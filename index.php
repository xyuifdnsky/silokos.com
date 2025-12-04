<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiLoKos | Pemesanan Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Gaya Dasar & Reset */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            padding-top: 80px;
        }
        
        /* HEADER - Diambil dari perbaikan kedua (yang paling bawah) */
        .header {
            position: fixed; /* Ubah kembali ke fixed agar tidak terdorong konten */
            top: 0;
            left: 0;
            width: 100%;
            padding: 12px 30px;
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 1000;
        }

        .logo { display: flex; align-items: center; gap: 10px; }
        .logo-img { height: 45px; }
        .logo-text { font-size: 22px; font-weight: bold; color: #2c3e50; }

        .nav-menu {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 25px;
            margin: 0;
            padding: 0;
        }

        .nav-menu a {
            text-decoration: none;
            font-weight: 500;
            color: #2c3e50;
            transition: 0.3s ease;
        }

        .nav-menu a:hover {
            color: #1e90ff;
        }

        .dropdown { position: relative; }
        .dropdown-btn { cursor: pointer; }

        .dropdown-content {
            position: absolute;
            top: 35px;
            left: 0;
            min-width: 170px;
            background: #ffffff;
            border-radius: 8px;
            padding: 8px 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            display: none;
        }

        .dropdown-content a {
            padding: 10px 15px;
            display: block;
            transition: 0.2s ease;
            color: #2c3e50;
        }

        .dropdown-content a:hover {
            background: #f0f6ff;
            color: #1e90ff;
        }

        .btn {
            background: #1a2a4b; /* Kembalikan ke warna default */
            padding: 10px 18px;
            color: #fff !important;
            border-radius: 8px;
            transition: 0.3s ease;
            text-decoration: none;
            font-weight: bold;
        }

        #openRoleUserBar {
            background-color: #1a2a4b;
        }
        #openRoleUserBar:hover {
            background-color: #0d1936;
        }
        
        /* SEKSI UTAMA / HERO SECTION */
        .hero-section {
            background-color: #E3F2FD;
            padding: 100px 5%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-height: 50vh;
        }
        .hero-section h1 {
            color: #1a2a4b;
            font-size: 2.8em;
            line-height: 1.2;
            margin-bottom: 20px;
            max-width: 900px;
        }
        .hero-section p {
            line-height: 1.8;
            margin-bottom: 40px;
            color: #555;
            font-size: 1.1em;
            max-width: 800px;
        }
        .hero-section .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 15px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s, color 0.3s;
        }
        .btn-login { background-color: #1a2a4b; color: white; }
        .btn-login:hover { background-color: #0d1936; transform: translateY(-2px); }
        .btn-registrasi {
            background-color: transparent;
            color: #1a2a4b;
            border: 2px solid #1a2a4b;
        }
        .btn-registrasi:hover {
            background-color: #1a2a4b;
            color: white;
            transform: translateY(-2px);
        }

        /* SEKSI UMUM (Kamar, Fasilitas) */
        .section {
            padding: 60px 5%;
            text-align: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-header {
            color: #1a2a4b;
            font-size: 2em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .section .divider {
            height: 3px;
            width: 80px;
            background-color: #10b981;
            margin: 10px auto 40px auto;
        }
        
        /* INFORMASI KAMAR */
        .room-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .room-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 350px;
            text-align: left;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 5px solid #3B82F6;
        }
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .room-card h3 {
            color: #1a2a4b;
            font-size: 1.5em;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .room-card p {
            color: #666;
            line-height: 1.6;
        }
        .btn-stylish {
            display: inline-block;
            padding: 12px 22px;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: 0.3s ease;
        }

        .btn-stylish:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(59,130,246,0.4);
            background: linear-gradient(135deg, #6366f1, #60a5fa);
        }
        
        /* FASILITAS KOST */
        .facility-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            padding: 20px 10px 40px;
            max-width: 1100px;
            margin: auto;
        }
        .facility-item {
            background: #ffffff;
            padding: 18px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: 0.3s ease;
            opacity: 1; /* Biarkan 1 agar terlihat jika JS dinonaktifkan */
            transform: translateY(0);
            min-height: 120px;
            text-align: center;
        }
        .facility-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.10);
            background-color: #E6FFFA;
        }
        .facility-item h4 {
            color: #1a2a4b;
            font-size: 1.2em;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .facility-item p {
            color: #777;
            font-size: 0.9em;
        }

        /* --- LOKASI KOST (Perbaikan Tampilan) --- */
        .section-white {
            padding: 60px 5%;
            text-align: center;
            background-color: #fff;
            border-top: 1px solid #eee;
        }
        .section-title {
            color: #1a2a4b;
            font-size: 2em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .underline {
            height: 3px;
            width: 80px;
            background-color: #10b981;
            margin: 10px auto 40px auto;
            display: block;
            border-radius: 8px;
        }

        /* Kontainer Flex untuk teks dan peta */
        .lokasi-content {
            display: flex;
            justify-content: space-between;
            align-items: stretch; /* Agar kedua kolom tingginya sama */
            gap: 35px;
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 15px;
            text-align: left; /* Teks di dalam harus rata kiri */
        }
        
        /* Kolom Teks Lokasi */
        .lokasi-text {
            width: 50%; /* Setengah-setengah */
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            line-height: 1.7;
            font-size: 16px;
            transition: 0.3s;
            display: flex; /* Untuk menyesuaikan konten di tengah vertikal */
            flex-direction: column;
            justify-content: center;
        }
        .lokasi-text:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 18px rgba(0,0,0,0.12);
        }
        .lokasi-text h3 {
            color: #1a2a4b;
            font-size: 1.8em;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .lokasi-text p {
            color: #666;
            margin: 0;
            padding: 0;
        }

        /* Kolom Peta Lokasi */
        .lokasi-map {
            width: 50%; /* Setengah-setengah */
            min-height: 400px; /* Atur tinggi minimum agar seimbang dengan teks */
        }
        .lokasi-map iframe {
            width: 100%;
            height: 100%;
            border: 2px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            display: block;
        }
        
        /* Animasi */
        .lokasi-anim {
            opacity: 0;
            transform: translateY(30px);
            transition: 0.7s ease;
        }
        /* --- Akhir Perbaikan Lokasi --- */

        /* FOOTER */
        .footer {
            background-color: #1a2a4b;
            color: white;
            padding: 40px 5%;
            font-size: 0.9em;
        }
        .footer-content {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto 30px auto;
            flex-wrap: wrap;
            gap: 20px;
        }
        .footer-col {
            width: 23%;
            min-width: 150px;
        }
        .footer-col h4 {
            font-size: 1.1em;
            margin-bottom: 15px;
            color: #10b981;
        }
        .footer-col a, .footer-col p {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: color 0.3s;
        }
        .footer-col a:hover {
            color: #fff;
        }
        .footer-bottom {
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 15px;
            margin-top: 20px;
        }


        /* POP-UP STYLES */
        .role-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(4px);
            display: none; 
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .role-popup {
            background: white;
            border-radius: 16px;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: fadeIn 0.3s ease;
            text-align: center;
        }
        @keyframes fadeIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .role-popup h3 { color: #1a2a4b; margin-bottom: 10px;}
        .role-popup p { color: #777; margin-bottom: 25px;}

        .role-btn {
            width: 100%;
            max-width: 350px; 
            padding: 15px;
            margin: 0 auto 15px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            transition: transform 0.2s ease;
        }
        .role-btn:hover {
            transform: translateY(-3px);
        }
        .role-text {
            text-align: left;
            flex-grow: 1;
        }
        .role-text small {
            display: block;
            margin-top: 2px;
            font-weight: normal;
            opacity: 0.9;
            font-size: 0.85em;
        }
        .btn-penyewa { background-color: #3B82F6; } 
        .btn-pemilik { background-color: #10B981; } 
        .role-icon { font-size: 1.5rem; width: 30px; text-align: center; }
        .role-popup .btn-secondary { background-color: #eee; color: #555; border: 1px solid #ddd; padding: 10px; width: 100%; max-width: 350px; margin-top: 15px; border-radius: 8px;}
        .role-popup .btn-secondary:hover { background-color: #ddd; }


        /* Responsif */
        @media (max-width: 900px) {
            .header { padding: 15px 20px;}
            .nav-menu { gap: 10px; }
            .nav-menu a { font-size: 12px; }
            .nav-menu #openRoleUserBar { padding: 6px 12px; }

            .hero-section { padding: 80px 5% 50px 5%; }
            .hero-section h1 { font-size: 2em; }
            .hero-section p { font-size: 1em; }
            
            /* Perbaikan Responsif Lokasi */
            .lokasi-content { 
                flex-direction: column; /* Ubah menjadi tumpukan */
                gap: 20px;
            }
            .lokasi-text, .lokasi-map { 
                width: 100%; /* Lebar penuh */
                min-height: 250px; /* Kurangi tinggi di mobile */
            }
            .lokasi-map { order: 1; margin-bottom: 0; } /* Peta di atas teks */
            .lokasi-text { order: 2; text-align: left; } /* Teks di bawah peta */
            .lokasi-text h3, .lokasi-text p { text-align: left; }
            
            .footer-content { flex-direction: column; gap: 30px; text-align: center; }
            .footer-col { width: 100%; min-width: unset; }
            .footer-col a { display: inline-block; margin: 0 5px; }
            
            .facility-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .facility-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
</head>
<body>

<header class="header">
    <div class="logo">
        <img src="gambar/logo-silokos.png" alt="Logo SiLoKos" class="logo-img">
        <span class="logo-text">SiLoKos</span>
    </div>

    <nav>
        <ul class="nav-menu">
            <li class="dropdown">
                <a href="#" class="dropdown-btn">Cari Apa?</a>
                <ul class="dropdown-content">
                    <li><a href="app/views/kamar/index.php">Booking</a></li>
                    <li><a href="#kamar">Informasi Kamar</a></li>
                    <li><a href="#fasilitas">Fasilitas Kost</a></li>
                </ul>
            </li>
            <li><a href="ketentuan/pusat_bantuan.php">Pusat Bantuan</a></li>
            <li><a href="ketentuan/syarat_ketentuan.php">Syarat dan Ketentuan</a></li>
            <li><a href="#" id="openRoleUserBar" class="btn">LOGIN</a></li>
        </ul>
    </nav>
</header>

<script>
// Dropdown interaktif
document.querySelectorAll(".dropdown").forEach(drop => {
    const btn = drop.querySelector(".dropdown-btn");
    const menu = drop.querySelector(".dropdown-content");

    btn.addEventListener("mouseover", () => menu.style.display = "block");
    drop.addEventListener("mouseleave", () => menu.style.display = "none");
});
</script>

    <div class="hero-section">
        <div class="text-area">
            <h1>Temukan Kos Idaman Anda dengan Mudah</h1>
            <p>SiLoKos merupakan Sistem informasi pengelolaan dan pemesanan kos yang menyediakan data kamar, fasilitas, dan harga secara lengkap untuk memudahkan pengguna dalam memilih dan melakukan booking secara online.</p>
            
            <a href="#" id="openRoleUser" class="btn btn-login">Login</a>
            <a href="#" id="openRole" class="btn btn-registrasi">Registrasi</a>
        </div>
    </div>

    <section id="kamar" class="section">
        <h2 class="section-header">Informasi Kamar</h2>
        <div class="divider"></div>
        
        <div class="room-cards">
            <div class="room-card">
                <h3>Kamar Tipe A</h3>
                <p>Ukuran 3x3m, Kamar Mandi Dalam. Harga mulai dari Rp 800.000/bulan.</p>
            </div>
            
            <div class="room-card" style="border-top: 5px solid #10B981;"> 
                <h3>Kamar Tipe B</h3>
                <p>Ukuran 3x4m, AC & Kamar Mandi Dalam. Harga mulai dari Rp 1.200.000/bulan.</p>
            </div>
            
        </div>
    
        <div style="margin-top: 40px;">
            <a href="app/views/kamar/index.php" class="btn-stylish">Cek Semua Kamar</a>
        </div>
    </section>

<section id="fasilitas" class="section" style="background-color: #fff; border-top: 1px solid #eee;">
    <h2 class="section-header">Fasilitas Kost</h2>
    <div class="divider"></div>
    
    <div class="facility-grid">
        <div class="facility-item facility-anim">
            <h4>WiFi Cepat</h4>
            <p>Jaringan internet stabil dan cepat untuk kebutuhan belajar atau hiburan.</p>
        </div>
        <div class="facility-item facility-anim">
            <h4>Dapur Umum</h4>
            <p>Area memasak bersama yang bersih dan dilengkapi peralatan dasar.</p>
        </div>
        <div class="facility-item facility-anim">
            <h4>Parkir Motor</h4>
            <p>Tempat parkir motor yang aman dan tersedia di dalam area kost.</p>
        </div>
        <div class="facility-item facility-anim">
            <h4>CCTV 24 Jam</h4>
            <p>Keamanan properti dipantau penuh selama 24 jam dengan CCTV.</p>
        </div>
        <div class="facility-item facility-anim">
            <h4>Ruang Tamu</h4>
            <p>Ruangan nyaman untuk menerima tamu atau bersantai bersama penghuni lain.</p>
        </div>
        <div class="facility-item facility-anim">
            <h4>Air Bersih</h4>
            <p>Pasokan air bersih terjamin untuk kebutuhan sehari-hari.</p>
        </div>
        <div class="facility-item facility-anim">
            <h4>Laundry Coin</h4>
            <p>Tersedia mesin cuci koin yang mudah diakses (opsional/biaya tambahan).</p>
        </div>
        <div class="facility-item facility-anim">
            <h4>Akses Kunci</h4>
            <p>Setiap penghuni mendapatkan akses kunci sendiri untuk privasi dan keamanan.</p>
        </div>
    </div>
</section>

<script>
// Fade-in interaksi saat discroll
const items = document.querySelectorAll(".facility-anim");

function revealFacilities() {
    const trigger = window.innerHeight - 80;
    items.forEach(item => {
        const boxTop = item.getBoundingClientRect().top;
        if (boxTop < trigger) {
            item.style.opacity = "1";
            item.style.transform = "translateY(0)";
            item.style.transition = "0.6s ease";
        } else {
             // Reset state saat keluar dari pandangan agar animasi bisa dipicu lagi saat scroll ke atas (opsional)
            item.style.opacity = "0";
            item.style.transform = "translateY(20px)";
        }
    });
}

window.addEventListener("scroll", revealFacilities);
window.addEventListener("load", revealFacilities);
</script>

<section class="section-white" id="lokasi">
    <h2 class="section-title">LOKASI KOST</h2>
    <span class="underline"></span>

    <div class="lokasi-content">
        <div class="lokasi-text lokasi-anim">
            <h3>Alamat</h3>
            <p><strong>Dsn. Cipaku RT/RW 1X/2X</strong></p>
            <p><strong>Ds. Cibogo Kec. Cibogo Kab. Subang</strong></p>
            <br>
            <p>Kost kami terletak di lokasi strategis dekat kampus, pusat perbelanjaan, dan akses transportasi umum. Kami menyediakan hunian yang nyaman, aman, dan mudah diakses. Cek langsung lokasi di peta untuk panduan lengkap dan rute perjalanan!</p>
        </div>

        <div class="lokasi-map lokasi-anim">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15848.47271810488!2d107.72895690000001!3d-6.84073385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e679b3971c221a9%3A0x6a2c2227d825c9b7!2sCibogo%2C%20Kec.%20Cibogo%2C%20Kabupaten%20Subang%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1701625983790!5m2!1sid!2sid" 
                width="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<script>
// Fade-in scroll animation untuk Lokasi
const lokasiItems = document.querySelectorAll(".lokasi-anim");

function revealLokasi() {
    const triggerBottom = window.innerHeight - 80;

    lokasiItems.forEach(item => {
        const itemTop = item.getBoundingClientRect().top;
        if (itemTop < triggerBottom) {
            item.style.opacity = "1";
            item.style.transform = "translateY(0)";
        } else {
            // Reset state saat keluar dari pandangan
            item.style.opacity = "0";
            item.style.transform = "translateY(30px)";
        }
    });
}

window.addEventListener("scroll", revealLokasi);
window.addEventListener("load", revealLokasi);
</script>


    <footer class="footer">
        <div class="footer-content">
            <div class="footer-col">
                <h4>SiLoKos</h4>
                <p>Sistem Informasi dan Pemesanan Kos.</p>
                <p>Memudahkan Anda mencari hunian terbaik.</p>
            </div>

            <div class="footer-col">
                <h4>Tentang Kami</h4>
                <a href="#">Pusat Bantuan</a>
                <a href="#">Blog Kos</a>
            </div>

            <div class="footer-col">
                <h4>Kebijakan</h4>
                <a href="ketentuan/syarat_ketentuan.php">Syarat dan Ketentuan</a>
                <a href="#">Kebijakan dan Privasi</a>
            </div>

            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <p>cs@kel7.com</p>
                <p>+62 812 xxxx xxxx</p>
            </div>
        </div>
        <div class="footer-bottom">
            © 2025 Kelompok 7. All rights reserved.
        </div>
    </footer>

    <div id="roleOverlay" class="role-overlay">
        <div class="role-popup">
            <h3 class="mb-4">Daftar Sebagai Apa?</h3>
            <p class="text-muted mb-4">Pilih jenis akun yang sesuai dengan kebutuhan Anda.</p>
            <a href="app/views/auth/register.php?role=penyewa" class="role-btn btn-penyewa">
                <span class="role-icon"><i class="fas fa-bed"></i></span>
                <span class="role-text">
                    Penyewa
                    <small>Mencari dan Menyewa Kos</small>
                </span>
            </a>
            <a href="app/views/auth/register.php?role=pemilik" class="role-btn btn-pemilik">
                <span class="role-icon"><i class="fas fa-house-user"></i></span>
                <span class="role-text">
                    Pemilik Kos
                    <small>Mengelola Properti & Penyewa</small>
                </span>
            </a>
            <button id="closeRole" class="btn btn-secondary mt-3">Tutup</button>
        </div>
    </div>

    <div id="roleUserOverlay" class="role-overlay">
        <div class="role-popup">
            <h3 class="mb-4">Login Sebagai Apa?</h3>
            <p class="text-muted mb-4">Pilih jenis akun yang sesuai dengan kebutuhan Anda.</p>
            <a href="app/views/auth/login.php?role=penyewa" class="role-btn btn-penyewa">
                <span class="role-icon"><i class="fas fa-bed"></i></span>
                <span class="role-text">
                    Penyewa
                    <small>Mencari dan Menyewa Kos</small>
                </span>
            </a>
            <a href="app/views/auth/login.php?role=pemilik" class="role-btn btn-pemilik">
                <span class="role-icon"><i class="fas fa-house-user"></i></span>
                <span class="role-text">
                    Pemilik Kos
                    <small>Mengelola Properti & Penyewa</small>
                </span>
            </a>
            <button id="closeRoleUser" class="btn btn-secondary mt-3">Tutup</button>
        </div>
    </div>

    <div id="roleUserOverlayBar" class="role-overlay">
        <div class="role-popup">
            <h3 class="mb-4">Login Sebagai Apa?</h3>
            <p class="text-muted mb-4">Pilih jenis akun yang sesuai dengan kebutuhan Anda.</p>
            <a href="app/views/auth/login.php?role=penyewa" class="role-btn btn-penyewa">
                <span class="role-icon"><i class="fas fa-bed"></i></span>
                <span class="role-text">
                    Penyewa
                    <small>Mencari dan Menyewa Kos</small>
                </span>
            </a>
            <a href="app/views/auth/login.php?role=pemilik" class="role-btn btn-pemilik">
                <span class="role-icon"><i class="fas fa-house-user"></i></span>
                <span class="role-text">
                    Pemilik Kos
                    <small>Mengelola Properti & Penyewa</small>
                </span>
            </a>
            <button id="closeUserBar" class="btn btn-secondary mt-3">Tutup</button>
        </div>
    </div>

    <script>
        // Register Popup (Tombol Registrasi Utama)
        document.getElementById('openRole').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('roleOverlay').style.display = 'flex';
        });

        document.getElementById('closeRole').addEventListener('click', function() {
            document.getElementById('roleOverlay').style.display = 'none';
        });

        // Login Popup (Tombol Login Utama)
        document.getElementById('openRoleUser').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('roleUserOverlay').style.display = 'flex';
        });

        document.getElementById('closeRoleUser').addEventListener('click', function() {
            document.getElementById('roleUserOverlay').style.display = 'none';
        });

        // Login Popup (Tombol Login Navigasi)
        document.getElementById('openRoleUserBar').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('roleUserOverlayBar').style.display = 'flex';
        });

        document.getElementById('closeUserBar').addEventListener('click', function() {
            document.getElementById('roleUserOverlayBar').style.display = 'none';
        });
    </script>
</body>
</html>