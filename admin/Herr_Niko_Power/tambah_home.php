<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ===============================
    KONFIGURASI
================================ */
$tabel = 'home';
$upload_dir = 'upload/home/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

/* ===============================
    SIMPAN DATA
================================ */
if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $subjudul = mysqli_real_escape_string($conn, $_POST['judul_program']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if (!empty($_FILES['gambar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $nama_file = time() . '_home.' . $ext;
        $tmp = $_FILES['gambar']['tmp_name'];

        if (move_uploaded_file($tmp, $upload_dir . $nama_file)) {
            mysqli_query(
                $conn, 
                "INSERT INTO home (judul, judul_program, deskripsi, gambar) 
                 VALUES ('$judul', '$subjudul', '$deskripsi', '$nama_file')"
            );
        }

        header("Location: tambah_home.php?status=success");
        exit;
    }
}

/* ===============================
    HAPUS DATA
================================ */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $q = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM home WHERE id=$id"));
    if ($q && file_exists($upload_dir . $q['gambar'])) {
        unlink($upload_dir . $q['gambar']);
    }

    mysqli_query($conn, "DELETE FROM home WHERE id=$id");
    header("Location: tambah_home.php?status=deleted");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM home ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Home | Eduventure Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #f2b705;
            --primary-hover: #d9a404;
            --dark: #0f172a;
            --bg: #f8fafc;
            --border: #e2e8f0;
            --white: #ffffff;
            --text-muted: #64748b;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg); 
            color: var(--dark);
        }

        /* Navbar & Header */
        .navbar { 
            background: var(--white); 
            padding: 1.2rem 2.5rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .brand { font-weight: 800; font-size: 1.4rem; color: var(--dark); letter-spacing: -0.5px; }
        .brand span { color: var(--primary); }
        
        .btn-back {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }
        .btn-back:hover { color: var(--primary); }

        .container { max-width: 1250px; margin: 30px auto; padding: 0 20px; }

        /* Alert Status */
        .alert { 
            border-radius: 12px; 
            font-weight: 600; 
            border: none; 
            display: flex; 
            align-items: center; 
            gap: 10px;
            animation: fadeIn 0.4s ease;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        /* Grid Layout */
        .admin-grid { display: grid; grid-template-columns: 400px 1fr; gap: 30px; align-items: start; }

        /* Form Card */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
            background: var(--white);
        }
        .card-header { 
            background: transparent; 
            padding: 25px 30px; 
            border-bottom: 1px solid var(--border); 
        }
        .card-header h5 { font-weight: 800; font-size: 1.1rem; margin: 0; }

        /* Form Controls */
        label {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: block;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            background: #fcfcfc;
            transition: 0.3s;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(242, 183, 5, 0.1);
            border-color: var(--primary);
            background: white;
        }

        .btn-save {
            background: var(--primary);
            color: var(--dark);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-save:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(242, 183, 5, 0.3);
        }

        /* Content List */
        .home-item {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 25px;
            border: 1px solid var(--border);
            transition: 0.3s;
            height: 100%;
        }
        .home-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.08);
            border-color: var(--primary);
        }

        .img-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary);
            color: var(--dark);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .content-pad { padding: 20px; }
        .content-pad h6 { font-weight: 700; font-size: 1.1rem; }

        .btn-delete {
            color: #ef4444;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }
        .btn-delete:hover { color: #b91c1c; transform: scale(1.05); }

        @media (max-width: 992px) { .admin-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="brand">EDU<span>VENTURE</span></div>
    <a href="dashboard.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Panel Dashboard
    </a>
</nav>

<div class="container">
    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle"></i> Slide banner berhasil diterbitkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="admin-grid">
        <div class="side-form">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-plus-circle text-warning me-2"></i> Tambah Banner</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Judul Utama</label>
                            <input type="text" name="judul" class="form-control" placeholder="Teks headline..." required>
                        </div>

                        <div class="mb-3">
                            <label>Label / Kategori</label>
                            <input type="text" name="judul_program" class="form-control" placeholder="Contoh: News / Promo">
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi Pendek</label>
                            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Sub-headline banner..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label>File Background</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <small class="text-muted mt-2 d-block small">Rekomendasi: 1920x1080px (Landscape)</small>
                        </div>

                        <button type="submit" name="simpan" class="btn btn-save">
                            <i class="fas fa-paper-plane"></i> Publikasikan Slide
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="side-data">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-800 mb-0 text-uppercase small letter-spacing-1" style="color:var(--text-muted)">Preview Konten Aktif</h5>
                <span class="badge bg-dark rounded-pill px-3 py-2"><?= mysqli_num_rows($data) ?> Banner</span>
            </div>

            <div class="row g-4">
                <?php if(mysqli_num_rows($data) > 0): ?>
                    <?php while($r = mysqli_fetch_assoc($data)): ?>
                        <div class="col-xl-6">
                            <div class="home-item">
                                <div class="img-container">
                                    <img src="<?= $upload_dir . $r['gambar'] ?>" alt="Slide">
                                    <?php if($r['judul_program']): ?>
                                        <div class="badge-category"><?= $r['judul_program'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="content-pad">
                                    <h6 class="mb-2 text-truncate"><?= $r['judul'] ?></h6>
                                    <p class="text-muted small mb-4" style="height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        <?= $r['deskripsi'] ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <div class="text-muted fw-600" style="font-size: 0.7rem;">
                                            <i class="fas fa-clock me-1"></i> Aktif
                                        </div>
                                        <a href="?hapus=<?= $r['id'] ?>" 
                                           class="btn-delete" 
                                           onclick="return confirm('Hapus slide ini secara permanen?')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="card p-5 text-center text-muted border-2 border-dashed bg-light">
                            <i class="fas fa-images fa-4x mb-3 opacity-25"></i>
                            <h5 class="fw-bold">Belum Ada Banner</h5>
                            <p class="mb-0 small">Gunakan form di sebelah kiri untuk menambah slide pertama Anda.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>