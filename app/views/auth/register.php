<?php
include '../../../config/database.php';
$conn = databaseconfig::getConnection();
$_SESSION['from_login'] = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_user = mysqli_real_escape_string($conn, $_POST['nama_user']);
    $username  = mysqli_real_escape_string($conn, $_POST['username']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon   = mysqli_real_escape_string($conn, $_POST['telepon']);
    $password  = mysqli_real_escape_string($conn, $_POST['password']);
    $password2 = mysqli_real_escape_string($conn, $_POST['password2']);
    $role      = mysqli_real_escape_string($conn, $_POST['role']);

    if ($role !== 'pemilik' && $role !== 'penyewa') {
        die("Role tidak valid!");
    }

    if ($password !== $password2) {
        // Mengubah dari echo showAlert menjadi set session untuk menampilkan alert setelah redirect
        // Ini adalah penyesuaian karena kode asli menggunakan JS yang mungkin tidak tereksekusi
        // dengan benar saat exit, namun kita pertahankan showAlert untuk konsistensi dengan kode JS di bawah.
        echo "<script>showAlert('Konfirmasi password tidak cocok!', 'danger');</script>";
        exit;
    }

    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT id_user FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>showAlert('Username atau Email sudah digunakan!', 'danger');</script>";
        exit;
    }

    $sql = "INSERT INTO users (username, nama_user, telepon, email, password, role)
             VALUES ('$username', '$nama_user', '$telepon', '$email', '$passHash', '$role')";

    if (mysqli_query($conn, $sql)) {
        // Tambahkan alert sukses sebelum redirect
        echo "<script>alert('Registrasi berhasil. Silakan Masuk.'); window.location.href='login.php';</script>";
        exit;
    } else {
        echo "<script>showAlert('Registrasi gagal!', 'danger');</script>";
        exit;
    }
}

$login_role = isset($_GET['role']) ? htmlspecialchars($_GET['role']) : 'penyewa';
$role_title = ($login_role == 'pemilik') ? 'Pemilik Kos' : 'Pencari Kos';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrasi - SiLaKos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
/* CSS agar mirip tampilan login di gambar */
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    /* Ganti background menjadi putih polos atau sedikit gradasi */
    background-color: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}
.card {
    width: 100%;
    max-width: 400px; /* Ukuran card disesuaikan dengan tampilan login */
    border-radius: 12px; /* Disesuaikan agar lebih halus */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 1rem; /* Padding lebih kecil */
}
.form-control {
    height: 44px; /* Tinggi input */
    border-radius: 8px; /* Sudut input */
}
.form-control:focus {
    border-color: #305FCA;
    box-shadow: 0 0 0 0.25rem rgba(48, 95, 202, 0.25);
}
.btn-register {
    background-color: #305FCA; /* Warna tombol sesuai tampilan login */
    border-color: #305FCA;
    color: white;
    font-weight: 600;
    height: 48px; /* Tinggi tombol */
    border-radius: 8px;
}
.btn-register:hover {
    background-color: #21469A;
    border-color: #21469A;
}
.input-group-text {
    /* Menghilangkan background biru di icon */
    background-color: #fff; 
    border-left: 0;
}
.input-group-text i {
    color: #6c757d;
}

/* Penyesuaian untuk tampilan Registrasi yang mirip Login */
.card-header-custom {
    display: flex;
    align-items: center;
    padding: 0.5rem 0 1rem 0;
    border-bottom: none;
}
.card-header-custom a {
    color: #000;
    margin-right: 10px;
}
.card-header-custom h3 {
    font-size: 1.5rem; /* Ukuran font lebih kecil agar mirip */
    margin: 0;
    font-weight: 500;
}
.fade-alert { animation: fadeOut 3s forwards; }
@keyframes fadeOut { 0%{opacity:1} 90%{opacity:1} 100%{opacity:0; display:none} }
</style>
</head>
<body>
<div class="card">
    <div id="alertBox"></div>
    <div class="card-header-custom">
        <a href="javascript:history.back()"><i class="bi bi-arrow-left"></i></a>
        <h3>Daftar Akun</h3>
    </div>

    <p class="text-center text-muted mb-3">Sebagai <?= $role_title ?></p>
    
    <form method="POST" id="regForm">
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" name="nama_user" placeholder="Nama Lengkap" required>
            </div>
        </div>
        
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                <input type="tel" class="form-control" name="telepon" placeholder="Nomor Handphone" required>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control password-input" name="password" placeholder="Password" required>
                <span class="input-group-text password-toggle"><i class="bi bi-eye-slash"></i></span>
            </div>
        </div>

        <div class="mb-4">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control password-input" name="password2" placeholder="Ulangi Password" required>
                <span class="input-group-text password-toggle"><i class="bi bi-eye-slash"></i></span>
            </div>
        </div>

        <input type="hidden" name="role" value="<?= $login_role ?>">

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="checkTerms" required>
            <label class="form-check-label" for="checkTerms" style="font-size: 0.9rem;">
                Saya setuju dengan <a href="syarat.php" style="color:#305FCA;font-weight:600; text-decoration: none;">Syarat & Ketentuan</a>
            </label>
        </div>

        <button type="submit" class="btn btn-register w-100 mb-3">DAFTAR</button>

        <p class="text-center mt-3" style="font-size: 0.9rem;">
            Sudah punya akun? 
            <a href="login.php?role=<?= $login_role ?>" style="color:#305FCA;font-weight:600; text-decoration: none;">Masuk ke Sistem</a>
        </p>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Fungsi showAlert dipertahankan untuk pesan error dari PHP
function showAlert(msg, type="danger"){
    const box = document.getElementById('alertBox');
    box.innerHTML = `<div class='alert alert-${type} fade-alert text-center fw-semibold py-2' role='alert'>${msg}</div>`;
    
    // Hapus alert setelah 3 detik
    setTimeout(() => {
        if (box.firstChild) {
            box.removeChild(box.firstChild);
        }
    }, 3000);
}

// Skrip toggle password
document.querySelectorAll('.password-toggle').forEach(el => {
    el.addEventListener('click', (e)=>{
        // Mencegah klik menyebar jika ada di dalam input group
        e.preventDefault(); 
        let input = el.parentElement.querySelector('.password-input');
        let icon  = el.querySelector('i');
        if(input.type === 'password'){ 
            input.type='text'; 
            icon.className='bi bi-eye'; 
        } else { 
            input.type='password'; 
            icon.className='bi bi-eye-slash'; 
        }
    });
});
</script>

</body>
</html>