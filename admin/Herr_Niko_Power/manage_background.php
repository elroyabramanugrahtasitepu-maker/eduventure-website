<?php
include 'config.php';
session_start();

// Gembok Keamanan Admin
if (!isset($_SESSION['admin'])) { 
    header("location: login.php"); 
    exit(); 
}

// Logika Upload Otomatis (Menimpa file fisik)
if (isset($_POST['update_bg'])) {
    $menu = $_POST['menu_target'];
    $source = $_FILES['gambar_baru']['tmp_name'];
    
    // Pemetaan folder tujuan sesuai struktur VS Code Putri
    switch($menu) {
        case 'home': $target = "../../backgroud_home/gambar.jpg"; break;
        case 'profil': $target = "../../gambar_profil/profil1.jpeg"; break;
        case 'program': $target = "../../banner/Banner.PNG"; break;
        case 'galeri': $target = "../../Gambar edu/gambar1.jpeg"; break;
        case 'testimoni': $target = "../../backgroud_testimoni/testimoni1.jpeg"; break;
    }
    
    if(move_uploaded_file($source, $target)) {
        echo "<script>alert('Visual Background Berhasil Diperbarui!'); window.location='manage_background.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visual Editor | Eduventure Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root { --primary: #f2b705; --dark: #1a1a1a; --soft-gray: #f8f9fa; }
        
        body { 
            background-color: #fdfcf7; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: var(--dark);
        }

        /* Glassmorphism Title Area */
        .glass-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 2rem;
            margin-bottom: 3rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }

        /* Modern Card Styling */
        .card-visual {
            background: #fff;
            border: none;
            border-radius: 30px;
            padding: 20px;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        .card-visual:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(242, 183, 5, 0.1);
        }

        /* Image Preview with Overlay */
        .preview-container {
            position: relative;
            width: 100%;
            height: 180px;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 20px;
            border: 1px solid #f0f0f0;
        }

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .card-visual:hover .preview-img {
            transform: scale(1.1);
        }

        .badge-menu {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--dark);
            color: var(--primary);
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 2;
        }

        /* Custom Input & Button */
        .form-control-custom {
            border-radius: 12px;
            border: 2px dashed #e0e0e0;
            padding: 10px;
            font-size: 0.8rem;
            transition: 0.3s;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: none;
            background: var(--soft-gray);
        }

        .btn-upload {
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 15px;
            padding: 12px;
            font-weight: 700;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-upload:hover {
            background: #000;
            color: var(--primary);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .btn-back {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-back:hover {
            background: var(--primary);
            color: var(--dark);
            transform: rotate(-10deg);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="glass-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="dashboard.php" class="btn-back me-4">
                <i class="fas fa-chevron-left fa-lg"></i>
            </a>
            <div>
                <h1 class="fw-800 mb-1" style="font-size: 1.8rem; letter-spacing: -1px;">Editor Visual</h1>
                <p class="text-muted small mb-0"><i class="fas fa-magic me-1"></i> Sesuaikan atmosfir background 5 menu utama kamu.</p>
            </div>
        </div>
        <div class="d-none d-md-block text-end">
            <span class="badge bg-warning text-dark rounded-pill px-3">Live Editor Mode</span>
        </div>
    </div>

    <div class="row g-4">
        <?php
        // Array Konfigurasi 5 Menu Utama Putri
        $menus = [
            ['id' => 'home', 'label' => 'Homepage Utama', 'path' => '../../backgroud_home/gambar.jpg', 'icon' => 'fa-home'],
            ['id' => 'profil', 'label' => 'Halaman Profil', 'path' => '../../gambar_profil/profil1.jpeg', 'icon' => 'fa-user-tie'],
            ['id' => 'program', 'label' => 'Banner Program', 'path' => '../../banner/Banner.PNG', 'icon' => 'fa-graduation-cap'],
            ['id' => 'galeri', 'label' => 'Visual Galeri', 'path' => '../../Gambar edu/gambar1.jpeg', 'icon' => 'fa-camera-retro'],
            ['id' => 'testimoni', 'label' => 'Halaman Testimoni', 'path' => '../../backgroud_testimoni/testimoni1.jpeg', 'icon' => 'fa-comment-alt']
        ];

        foreach ($menus as $m) :
        ?>
        <div class="col-xl-4 col-md-6">
            <div class="card-visual">
                <span class="badge-menu"><i class="fas <?php echo $m['icon']; ?> me-1"></i> <?php echo $m['id']; ?></span>
                
                <div class="preview-container">
                    <img src="<?php echo $m['path']; ?>?t=<?php echo time(); ?>" class="preview-img" alt="Preview">
                </div>

                <div class="content-box">
                    <h5 class="fw-700 mb-1"><?php echo $m['label']; ?></h5>
                    <p class="text-muted mb-4" style="font-size: 0.75rem;">Lokasi: <code class="text-primary"><?php echo $m['path']; ?></code></p>

                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="menu_target" value="<?php echo $m['id']; ?>">
                        
                        <div class="mb-3">
                            <input type="file" name="gambar_baru" class="form-control form-control-custom" accept="image/*" required>
                            <div class="form-text mt-1" style="font-size: 0.65rem;">Format disarankan: JPG/PNG (Max 2MB)</div>
                        </div>

                        <button type="submit" name="update_bg" class="btn btn-upload">
                            <i class="fas fa-sync-alt"></i> GANTI BACKGROUND
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-5">
        <p class="text-muted small">© 2026 Eduventure Dashboard • Managed by Putri Amanda Khaira</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>