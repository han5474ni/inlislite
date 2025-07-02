<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .success-message {
            color: green;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Pengguna Baru</h2>

        <?php if (session()->getFlashdata('success')):
            ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')):
            ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors)):
            ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error):
                        ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('usermanagement/addUser') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
                <?php if (session('errors.nama_lengkap')):
                    ?>
                    <div class="error-message"><?= session('errors.nama_lengkap') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="nama_pengguna">Nama Pengguna:</label>
                <input type="text" id="nama_pengguna" name="nama_pengguna" value="<?= old('nama_pengguna') ?>" required>
                <?php if (session('errors.nama_pengguna')):
                    ?>
                    <div class="error-message"><?= session('errors.nama_pengguna') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
                <?php if (session('errors.email')):
                    ?>
                    <div class="error-message"><?= session('errors.email') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="kata_sandi">Kata Sandi:</label>
                <input type="password" id="kata_sandi" name="kata_sandi" required>
                <?php if (session('errors.kata_sandi')):
                    ?>
                    <div class="error-message"><?= session('errors.kata_sandi') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role">Peran (Role):</label>
                <select id="role" name="role" required>
                    <option value="">Pilih Peran</option>
                    <option value="Admin" <?= old('role') == 'Admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="Pustakawan" <?= old('role') == 'Pustakawan' ? 'selected' : '' ?>>Pustakawan</option>
                </select>
                <?php if (session('errors.role')):
                    ?>
                    <div class="error-message"><?= session('errors.role') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="Aktif" <?= old('status') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Non-Aktif" <?= old('status') == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
                <?php if (session('errors.status')):
                    ?>
                    <div class="error-message"><?= session('errors.status') ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">Tambah Pengguna</button>
        </form>
    </div>
</body>
</html>
