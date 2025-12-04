<?php
session_start();

include '../../../config/database.php';
$conn = databaseconfig::getConnection();

$error = '';
$title = "Masuk ke Sistem"; // Judul yang lebih menarik

// (LOGIKA PHP TIDAK BERUBAH)

// Jika sudah login → langsung lempar ke dashboard sesuai role
if (isset($_SESSION['user'])) {
    switch ($_SESSION['user']['role']) {
        case 'admin': header("Location: dashboard/pemilik/admin/admin.php"); exit;
        case 'pemilik': header("Location: dashboard/pemilik/pemilik.php"); exit;
        default: header("Location: dashboard/penyewa/penyewa.php"); exit;
    }
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");

    if ($query && mysqli_num_rows($query) === 1) {

        $user = mysqli_fetch_assoc($query);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {

            // 💥 FIX UTAMA → hapus session lama biar tidak tertukar
            session_unset();

            // Buat session baru secara aman
            $_SESSION['user'] = [
                'id_user' => $user['id_user'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            // Redirect sesuai role
            switch ($user['role']) {
                case 'admin':
                    // Jika admin memiliki id_pemilik → masuk ke dashboard admin pemilik
                    if (!empty($user['id_pemilik']) && $user['id_pemilik'] > 0) {
                        header("Location: dashboard/pemilik/admin/admin.php");
                        exit;
                    }
                case 'pemilik':
                    header("Location: dashboard/pemilik/pemilik.php");
                    exit;
                default:
                    header("Location: dashboard/penyewa/penyewa.php");
                    exit;
            }
        } else {
            $error = "Password salah! Silakan coba lagi.";
        }

    } else {
        $error = "Username tidak ditemukan! Cek kembali penulisan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Gaya latar belakang dan fokus utama */
        body { 
            background: linear-gradient(135deg, #6c5cE3F2FDe7 0%, #E3F2FD 100%); 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box { 
            max-width: 400px;
            width: 90%;
            padding: 40px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Header */
        .header-login { 
            display: flex; 
            align-items: center; 
            margin-bottom: 25px; 
            color: #333;
        }
        .back-icon { 
            font-size: 20px; 
            margin-right: 10px; 
            color: #6c5ce7; 
            text-decoration: none;
            transition: color 0.3s;
        }
        .back-icon:hover { color: #0984e3; }
        .title { 
            font-size: 24px;
            font-weight: 700;
        }
        /* Input dan Tombol */
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border-color: #ddd;
        }
        .form-control:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.25);
        }
        .btn-primary { 
            background-color: #6c5ce7;
            border-color: #6c5ce7;
            font-weight: 600;
            padding: 10px;
            transition: background-color 0.3s, transform 0.1s;
        }
        .btn-primary:hover {
            background-color: #5d4cd9;
            border-color: #5d4cd9;
        }
        .btn-primary:active {
            transform: scale(0.98);
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            transition: color 0.2s;
        }
        .password-toggle:hover {
            color: #6c5ce7;
        }
        .input-group-password {
            position: relative;
        }
        /* Link Daftar */
        .register-link a {
            color: #6c5ce7;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s;
        }
        .register-link a:hover {
            color: #0984e3;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="header-login">
        <a href="javascript:history.back()" class="back-icon"><i class="bi bi-arrow-left"></i></a>
        <span class="title"><?= $title ?></span>
    </div>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST" id="loginForm">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username Anda" required autocomplete="off">
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group input-group-password">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
                <span class="password-toggle" id="togglePassword">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3" id="loginButton" disabled>
            <span id="buttonText">LOGIN</span>
            <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>

        <div class="text-center mt-4 register-link">
            Belum punya akun? 
            <a href="register.php">Daftar Sekarang</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const loginButton = document.getElementById('loginButton');
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        // Fungsi untuk mengaktifkan/menonaktifkan tombol login
        function checkInputs() {
            if (usernameInput.value.trim() !== '' && passwordInput.value.trim() !== '') {
                loginButton.disabled = false;
            } else {
                loginButton.disabled = true;
            }
        }

        usernameInput.addEventListener('input', checkInputs);
        passwordInput.addEventListener('input', checkInputs);
        checkInputs(); // Panggil saat memuat untuk mengaktifkan jika sudah terisi (misal dari autocomplete)

        // Interaksi Tombol (Loading State)
        form.addEventListener('submit', function(e) {
            // Cek sekali lagi apakah input sudah terisi
            if (usernameInput.value.trim() === '' || passwordInput.value.trim() === '') {
                e.preventDefault(); // Mencegah submit jika input kosong (walaupun sudah ada 'required')
                return;
            }

            // Tampilkan loading
            loginButton.disabled = true;
            document.getElementById('buttonText').textContent = 'Memproses...';
            document.getElementById('spinner').classList.remove('d-none');
        });

        // Toggle Password
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Mengubah ikon
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>
</body>
</html>