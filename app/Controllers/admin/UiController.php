<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class UiController extends BaseController
{
    // /admin/ui or /admin/ui/{page}
    public function index($page = null)
    {
        $data = [
            'page' => $page,
        ];
        return view('admin/ui', $data);
    }
}