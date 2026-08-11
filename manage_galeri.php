<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin'])) { 
    header("location: login.php"); 
    exit(); 
}

// JALUR REMOTE: Keluar dari Herr_Niko_Power, keluar dari ADMIN_EDUVENTURE, masuk ke WEBSITE_EDUVENTURE
// Cukup keluar satu tingkat dari folder Herr_Niko_Power untuk menemukan Gambar_edu
$path_website = "../Gambar_edu/";

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $ambil = mysqli_query($conn, "SELECT file_media FROM galeri WHERE id=$id");
    $data = mysqli_fetch_assoc($ambil);
    
    if ($data) {
        $file_path = $path_website . $data['file_media'];
        if(file_exists($file_path)) { unlink($file_path); }
        mysqli_query($conn, "DELETE FROM galeri WHERE id=$id");
    }
    header("location: manage_galeri.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visual Manager | Eduventure Abroad</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --gold: #f2b705;
            --dark: #0f172a;
            --soft-bg: #f8fafc;
            --danger-bg: #fff1f2;
            --danger-text: #e11d48;
        }

        body { 
            background-color: var(--soft-bg); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: var(--dark);
        }

        /* Glassmorphism Header */
        .premium-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            margin-bottom: 3rem;
        }

        /* Modern Gallery Card */
        .card-gallery { 
            border-radius: 28px; 
            border: none; 
            overflow: hidden; 
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03); 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
        }

        .card-gallery:hover { 
            transform: translateY(-12px); 
            box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        }

        /* Media Styling */
        .media-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: #f1f5f9;
        }

        .media-crop { 
            width: 100%; 
            height: 100%; 
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .card-gallery:hover .media-crop {
            transform: scale(1.1);
        }

        /* Dynamic Badges */
        .badge-type { 
            position: absolute; 
            top: 15px; 
            right: 15px; 
            background: rgba(255, 255, 255, 0.9); 
            color: var(--dark); 
            padding: 6px 14px; 
            border-radius: 50px; 
            font-size: 10px; 
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Buttons */
        .btn-premium-add { 
            background: var(--gold); 
            color: var(--dark); 
            font-weight: 800; 
            border-radius: 16px;
            padding: 12px 28px;
            border: none;
            transition: 0.3s;
        }
        .btn-premium-add:hover { 
            background: var(--dark); 
            color: var(--gold);
            transform: scale(1.05);
        }

        .btn-premium-delete {
            background: var(--danger-bg);
            color: var(--danger-text);
            border: none;
            border-radius: 14px;
            font-weight: 700;
            padding: 10px;
            transition: 0.3s;
        }
        .btn-premium-delete:hover {
            background: var(--danger-text);
            color: white;
        }

        .back-circle {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            text-decoration: none;
            transition: 0.3s;
        }
        .back-circle:hover { background: var(--gold); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="premium-header d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <a href="dashboard.php" class="back-circle me-3"><i class="fas fa-chevron-left"></i></a>
            <div>
                <h2 class="fw-800 mb-0" style="letter-spacing: -1px;">Gallery Management</h2>
                <p class="text-muted small mb-0">Total Moment: <?php echo mysqli_num_rows($query); ?> Item</p>
            </div>
        </div>
        <a href="tambah_galeri.php" class="btn btn-premium-add shadow-lg">
            <i class="fas fa-plus-circle me-2"></i> Tambah Koleksi
        </a>
    </div>

    <div class="row g-4">
        <?php if(mysqli_num_rows($query) > 0) : ?>
            <?php while($row = mysqli_fetch_assoc($query)) : 
                $file_src = $path_website . $row['file_media'];
            ?>
            <div class="col-sm-6 col-lg-3">
                <div class="card-gallery d-flex flex-column h-100">
                    <div class="media-wrapper">
                        <span class="badge-type">
                            <i class="fas <?php echo ($row['tipe'] == 'video') ? 'fa-play' : 'fa-camera'; ?> me-1"></i>
                            <?php echo $row['tipe']; ?>
                        </span>
                        
                        <?php if($row['tipe'] == 'video'): ?>
                            <video src="<?= $file_src ?>" class="media-crop" muted loop onmouseover="this.play()" onmouseout="this.pause()"></video>
                        <?php else: ?>
                            <img src="<?= $file_src ?>" class="media-crop" onerror="this.src='https://placehold.co/600x400?text=File+Tidak+Ditemukan'">
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-4 mt-auto">
                        <p class="fw-700 text-truncate mb-3" style="font-size: 0.95rem;">
                            <?= !empty($row['judul_moment']) ? $row['judul_moment'] : 'Untitled Moment' ?>
                        </p>
                        <a href="?hapus=<?= $row['id'] ?>" class="btn btn-premium-delete w-100" onclick="return confirm('Hapus moment ini selamanya?')">
                            <i class="fas fa-trash-alt me-2"></i> Hapus Moment
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="opacity-25 mb-3"><i class="fas fa-images fa-5x"></i></div>
                <h4 class="text-muted">Belum ada koleksi visual.</h4>
                <p class="text-muted small">Mulai tambahkan moment berhargamu sekarang!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>