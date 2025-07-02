<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Tambahkan Pengguna Baru</h5>
                    <p class="modal-subtitle mb-0">Buat akun pengguna baru dan tetapkan hak akses</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan nama lengkap">
                            <div class="form-text">Opsional - akan menggunakan username jika kosong</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_pengguna" required minlength="3" maxlength="50" placeholder="Masukkan username">
                            <div class="form-text">Panjang 3-50 karakter, harus unik</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required placeholder="Masukkan alamat email">
                            <div class="form-text">Format email yang valid dan unik</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="kata_sandi" required minlength="6" placeholder="Masukkan kata sandi">
                            <div class="form-text">Minimal 6 karakter</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin">Admin</option>
                                <option value="Pustakawan">Pustakawan</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" form="addUserForm">
                    <i data-feather="plus" style="width: 16px; height: 16px;"></i>
                    Tambahkan User
                </button>
            </div>
        </div>
    </div>
</div>