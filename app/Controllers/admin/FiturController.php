<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FiturModel;
use CodeIgniter\HTTP\ResponseInterface;

class FiturController extends BaseController
{
    protected FiturModel $model;

    public function __construct()
    {
        $this->model = new FiturModel();
    }

    /**
     * Halaman manajemen fitur & modul (menampilkan view admin/fitur)
     */
    public function index()
    {
        $data = [
            'title' => 'Fitur & Modul - INLISLite v3',
            'page_title' => 'Fitur dan Modul Program',
            'page_css' => ['assets/css/admin/fitur.css'],
        ];

        return view('admin/fitur', $data);
    }

    /**
     * Ambil data fitur atau modul dalam format JSON.
     * Query string: type=feature|module (default: feature)
     */
    public function getData()
    {
        $type = strtolower($this->request->getGet('type') ?? 'feature');
        $status = strtolower($this->request->getGet('status') ?? 'active');

        try {
            if ($type === 'module') {
                $items = $this->model->where('type', 'module')
                                     ->where('status', $status)
                                     ->orderBy('sort_order', 'ASC')
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll();
            } else {
                $items = $this->model->where('type', 'feature')
                                     ->where('status', $status)
                                     ->orderBy('sort_order', 'ASC')
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll();
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $items,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'FiturController::getData - ' . $e->getMessage());
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['success' => false, 'message' => 'Gagal memuat data']);
        }
    }

    /**
     * Statistik ringkas data fitur/modul.
     */
    public function getStatistics()
    {
        try {
            $stats = $this->model->getStatistics();
            return $this->response->setJSON(['success' => true, 'data' => $stats]);
        } catch (\Throwable $e) {
            log_message('error', 'FiturController::getStatistics - ' . $e->getMessage());
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['success' => false, 'message' => 'Gagal memuat statistik']);
        }
    }

    /**
     * Tambah fitur atau modul.
     * Body: title, description, icon, color, type(feature|module), module_type(optional)
     */
    public function store()
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon' => $this->request->getPost('icon'),
            'color' => $this->request->getPost('color'),
            'type' => $this->request->getPost('type'),
            'module_type' => $this->request->getPost('module_type'),
            'status' => $this->request->getPost('status') ?? 'active',
        ];

        try {
            if (!$this->model->insert($data)) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $this->model->errors(),
                    ]);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Berhasil menyimpan']);
        } catch (\Throwable $e) {
            log_message('error', 'FiturController::store - ' . $e->getMessage());
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['success' => false, 'message' => 'Gagal menyimpan']);
        }
    }

    /**
     * Update fitur/modul by id.
     */
    public function update($id)
    {
        $payload = $this->request->getPost();

        try {
            if (!$this->model->update($id, $payload)) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $this->model->errors(),
                    ]);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Berhasil memperbarui']);
        } catch (\Throwable $e) {
            log_message('error', 'FiturController::update - ' . $e->getMessage());
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['success' => false, 'message' => 'Gagal memperbarui']);
        }
    }

    /**
     * Hapus fitur/modul by id.
     */
    public function delete($id)
    {
        try {
            $deleted = $this->model->delete($id);
            return $this->response->setJSON(['success' => (bool)$deleted, 'message' => $deleted ? 'Berhasil dihapus' : 'Gagal menghapus']);
        } catch (\Throwable $e) {
            log_message('error', 'FiturController::delete - ' . $e->getMessage());
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['success' => false, 'message' => 'Gagal menghapus']);
        }
    }

    /**
     * Update urutan sort untuk banyak item.
     * Body: items = [{id:1, sort_order:1}, ...] atau order=[id1,id2,...]
     */
    public function updateSortOrder()
    {
        $items = $this->request->getPost('items');
        $order = $this->request->getPost('order');

        try {
            if (is_array($items)) {
                foreach ($items as $it) {
                    if (isset($it['id'], $it['sort_order'])) {
                        $this->model->update($it['id'], [
                            'sort_order' => (int)$it['sort_order'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            } elseif (is_array($order)) {
                foreach ($order as $idx => $id) {
                    $this->model->update((int)$id, [
                        'sort_order' => $idx + 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            } else {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON(['success' => false, 'message' => 'Payload tidak valid']);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Urutan berhasil diperbarui']);
        } catch (\Throwable $e) {
            log_message('error', 'FiturController::updateSortOrder - ' . $e->getMessage());
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['success' => false, 'message' => 'Gagal memperbarui urutan']);
        }
    }
}