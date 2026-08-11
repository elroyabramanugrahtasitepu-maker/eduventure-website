<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("location: login.php");
    exit();
}

// Ambil Nama Admin
$admin_name = $_SESSION['admin'];

// Statistik Data - Dioptimalkan
function getCount($conn, $table) {
    $query = mysqli_query($conn, "SELECT id FROM $table");
    return mysqli_num_rows($query);
}

$counts = [
    'home' => getCount($conn, "home"),
    'profil' => getCount($conn, "profil"),
    'program' => getCount($conn, "program"),
    'galeri' => getCount($conn, "galeri"),
    'testimoni' => getCount($conn, "testimoni")
];

$page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Eduventure Abroad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #f2b705;
            --primary-dark: #d9a406;
            --sidebar-bg: #0f172a;
            --main-bg: #f8fafc;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--main-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
        }

        /* --- Sidebar --- */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            padding: 1.5rem;
            transition: var(--transition);
        }

        .brand-section {
            padding: 0.5rem 1rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1.5rem;
        }

        .nav-custom .nav-link {
            color: #94a3b8;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .nav-custom .nav-link i {
            width: 28px;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .nav-custom .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
            padding-left: 1.3rem;
        }

        .nav-custom .nav-link.active {
            background: var(--primary);
            color: var(--sidebar-bg) !important;
            font-weight: 700;
            box-shadow: 0 10px 15px -3px rgba(242, 183, 5, 0.3);
        }

        .nav-custom .nav-link.active i { color: var(--sidebar-bg); }

        .section-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            color: #475569;
            margin: 1.5rem 0 0.8rem 1rem;
            font-weight: 800;
        }

        /* --- Main Content --- */
        .main-content {
            margin-left: 280px;
            padding: 2.5rem;
            transition: var(--transition);
        }

        /* Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border-radius: 24px;
            padding: 3rem;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 2.5rem;
            box-shadow: var(--card-shadow);
        }

        .welcome-banner h1 { font-weight: 800; letter-spacing: -1px; }

        .banner-pattern {
            position: absolute;
            right: -50px;
            top: -50px;
            font-size: 15rem;
            opacity: 0.05;
            transform: rotate(-15deg);
        }

        /* Stats Card */
        .stat-card {
            background: #fff;
            border-radius: 20px;
            padding: 1.5rem;
            border: 1px solid #eef2f6;
            display: flex;
            align-items: center;
            transition: var(--transition);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow);
            border-color: var(--primary);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1.2rem;
        }

        /* Quick Action */
        .action-card {
            background: #fff;
            border: 2px dashed #e2e8f0;
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: #475569;
            transition: var(--transition);
            display: block;
        }

        .action-card:hover {
            border-style: solid;
            border-color: var(--primary);
            background: #fffdf5;
            color: var(--sidebar-bg);
            transform: scale(1.02);
        }

        .action-card i {
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 0.8rem;
            display: block;
        }

        .action-card span { font-weight: 700; font-size: 0.9rem; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 1.5rem; }
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="brand-section">
        <h3 class="text-white fw-bold mb-0">
            EDU<span class="text-warning">VENTURE</span>
        </h3>
        <p class="text-muted small mb-0 mt-1">International Education</p>
    </div>

    <nav class="nav-custom">
        <a href="dashboard.php" class="nav-link <?= $page=='dashboard.php'?'active':'' ?>">
            <i class="fa-solid fa-house-chimney-window"></i> Dashboard
        </a>

        <div class="section-header">Konten Web</div>
        <a href="tambah_home.php" class="nav-link <?= $page=='tambah_home.php'?'active':'' ?>">
            <i class="fa-solid fa-pager"></i> Banner Home
        </a>
        <a href="tambah_profil.php" class="nav-link <?= $page=='tambah_profil.php'?'active':'' ?>">
            <i class="fa-solid fa-circle-info"></i> Profil Agensi
        </a>
        <a href="tambah_program.php" class="nav-link <?= $page=='tambah_program.php'?'active':'' ?>">
            <i class="fa-solid fa-graduation-cap"></i> Program Studi
        </a>
        <a href="tambah_testimoni.php" class="nav-link <?= $page=='tambah_testimoni.php'?'active':'' ?>">
            <i class="fa-solid fa-star"></i> Testimoni
        </a>
        <a href="manage_galeri.php" class="nav-link <?= $page=='manage_galeri.php'?'active':'' ?>">
            <i class="fa-solid fa-images"></i> Media Galeri
        </a>

        <div class="section-header">Sistem</div>
        <a href="manage_identitas.php" class="nav-link <?= $page=='manage_identitas.php'?'active':'' ?>">
            <i class="fa-solid fa-gear"></i> Konfigurasi SEO
        </a>
        
        <a href="javascript:void(0)" class="nav-link text-danger mt-4" onclick="handleExitInfo()">
            <i class="fa-solid fa-right-from-bracket"></i> Keluar
        </a>
    </nav>
</div>

<div class="main-content">
    <div class="welcome-banner d-flex justify-content-between align-items-center">
        <i class="fa-solid fa-earth-americas banner-pattern"></i>
        <div style="position: relative; z-index: 1;">
            <h1 class="mb-2">Hello, <?= $admin_name ?>! 👋</h1>
            <p class="opacity-75 mb-0">Navigasi dashboard aktif. Gunakan tombol (X) browser untuk keluar sepenuhnya.</p>
        </div>
        <div class="text-end d-none d-lg-block border-start border-white border-opacity-25 ps-4" style="position: relative; z-index: 1;">
            <h2 class="fw-bold text-warning mb-0" id="clock">00:00:00</h2>
            <span class="small opacity-75"><?= date('l, d F Y') ?></span>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <?php
        $stats = [
            ['title' => 'Banner Active', 'count' => $counts['home'], 'icon' => 'fa-pager', 'bg' => 'bg-warning'],
            ['title' => 'Program Studi', 'count' => $counts['program'], 'icon' => 'fa-graduation-cap', 'bg' => 'bg-primary'],
            ['title' => 'Media Galeri', 'count' => $counts['galeri'], 'icon' => 'fa-images', 'bg' => 'bg-success'],
            ['title' => 'Ulasan Alumni', 'count' => $counts['testimoni'], 'icon' => 'fa-star', 'bg' => 'bg-danger']
        ];

        foreach ($stats as $s): ?>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="icon-box <?= $s['bg'] ?> bg-opacity-10 <?= str_replace('bg-', 'text-', $s['bg']) ?>">
                    <i class="fa-solid <?= $s['icon'] ?>"></i>
                </div>
                <div>
                    <h3 class="fw-800 mb-0"><?= $s['count'] ?></h3>
                    <p class="text-muted small fw-600 mb-0"><?= $s['title'] ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <h5 class="fw-800 mb-4 text-uppercase small letter-spacing-1">Akses Cepat</h5>
    <div class="row g-3">
        <div class="col-md-3">
            <a href="tambah_program.php" class="action-card">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Tambah Program</span>
            </a>
        </div>
        <div class="col-md-3">
            <a href="manage_galeri.php" class="action-card">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Upload Galeri</span>
            </a>
        </div>
        <div class="col-md-3">
            <a href="manage_identitas.php" class="action-card">
                <i class="fa-solid fa-sliders"></i>
                <span>SEO & Kontak</span>
            </a>
        </div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', { hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('clock').innerText = timeStr;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // --- PROTEKSI NAVIGASI ---
    (function () {
        // Flag untuk mengecek apakah user mengklik menu internal
        let isInternalNavigation = false;

        // Pasang listener pada semua link <a> di dalam page
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                isInternalNavigation = true;
            });
        });

        // 1. Kunci riwayat (Tombol Back/Forward mati)
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        // 2. Tampilkan peringatan HANYA jika bukan navigasi menu internal (misal refresh manual/panah browser)
        window.onbeforeunload = function (e) {
            if (!isInternalNavigation) {
                return "Sistem terkunci. Gunakan tombol (X) untuk keluar.";
            }
        };
    })();

    function handleExitInfo() {
        alert("Sistem Keamanan: Silakan klik tanda (X) pada TAB atau BROWSER Anda untuk keluar.");
    }
</script>

</body>
</html>