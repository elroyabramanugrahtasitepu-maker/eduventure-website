<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ===============================
    KONFIGURASI & LOGIKA
================================ */
$upload_dir = 'upload/testimoni/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

if (isset($_POST['simpan'])) {
    // Sesuai struktur DB Anda: nama, pesan
    $nama = mysqli_real_escape_string($conn, $_POST['judul']); 
    $pesan = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if (!empty($_FILES['gambar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $nama_file = time() . '_testimoni.' . $ext;
        
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $nama_file)) {
            // Query menggunakan kolom: nama, pesan, foto
            $query = "INSERT INTO testimoni (nama, pesan, foto) VALUES ('$nama', '$pesan', '$nama_file')";
            if(mysqli_query($conn, $query)) {
                header("Location: tambah_testimoni.php?msg=success"); 
                exit;
            } else {
                echo "Error Database: " . mysqli_error($conn);
            }
        }
    }
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $q = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM testimoni WHERE id=$id"));
    if ($q && file_exists($upload_dir . $q['foto'])) unlink($upload_dir . $q['foto']);
    mysqli_query($conn, "DELETE FROM testimoni WHERE id=$id");
    header("Location: tambah_testimoni.php?msg=deleted"); exit;
}

$data = mysqli_query($conn, "SELECT * FROM testimoni ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Testimoni | Eduventure Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root { --success-color: #10b981; --bg-light: #f8fafc; --text-main: #1e293b; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-light); color: var(--text-main); }
        .navbar-admin { background: #fff; padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1000; }
        .card-form { background: white; border-radius: 20px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 30px; height: fit-content; }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #64748b; margin-bottom: 8px; }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; font-size: 0.95rem; }
        .btn-save { background: var(--success-color); color: white; border: none; border-radius: 12px; padding: 14px; font-weight: 700; width: 100%; transition: 0.3s; }
        .btn-save:hover { background: #059669; transform: translateY(-2px); }
        .testi-card { background: white; border-radius: 20px; padding: 25px; border: 1px solid #e2e8f0; transition: 0.3s; position: relative; height: 100%; }
        .testi-card:hover { border-color: var(--success-color); box-shadow: 0 15px 30px rgba(16, 185, 129, 0.1); }
        .quote-icon { position: absolute; top: 20px; right: 25px; font-size: 2rem; color: #f1f5f9; }
        .user-profile { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        .user-avatar { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .user-info h6 { margin: 0; font-weight: 700; font-size: 1rem; }
        .testi-text { font-size: 0.9rem; line-height: 1.6; color: #475569; font-style: italic; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; }
        .btn-delete-soft { color: #94a3b8; text-decoration: none; font-size: 0.8rem; font-weight: 600; transition: 0.3s; }
        .btn-delete-soft:hover { color: #ef4444; }
        .btn-back-home { text-decoration: none; color: #64748b; font-weight: 600; display: flex; align-items: center; gap: 8px; }
    </style>
</head>
<body>

<div class="navbar-admin">
    <div class="d-flex align-items-center gap-2">
        <i class="fas fa-comment-dots text-success fs-4"></i>
        <h4 class="mb-0 fw-bold">Testimoni Alumni</h4>
    </div>
    <a href="dashboard.php" class="btn-back-home">
        <i class="fas fa-chevron-left"></i> Kembali ke Panel
    </a>
</div>

<div class="container-fluid py-5 px-4 px-md-5">
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4" role="alert">
            Testimoni berhasil disimpan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card-form">
                <h5 class="fw-bold mb-4">Input Ulasan Baru</h5>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Andi Wijaya" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pesan Testimoni</label>
                        <textarea name="deskripsi" class="form-control" rows="5" placeholder="Tulis ulasan pengalaman mereka..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>

                    <button type="submit" name="simpan" class="btn btn-save">
                        <i class="fas fa-paper-plane me-2"></i> Simpan Testimoni
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row g-4">
                <?php if(mysqli_num_rows($data) > 0): ?>
                    <?php while($r = mysqli_fetch_assoc($data)): ?>
                        <div class="col-md-6">
                            <div class="testi-card">
                                <i class="fas fa-quote-right quote-icon"></i>
                                <div class="user-profile">
                                    <img src="<?= $upload_dir . $r['foto'] ?>" class="user-avatar" alt="Avatar">
                                    <div class="user-info">
                                        <h6><?= $r['nama'] ?></h6>
                                    </div>
                                </div>
                                <p class="testi-text">"<?= $r['pesan'] ?>"</p>
                                <div class="border-top pt-3 d-flex justify-content-end align-items-center">
                                    <a href="?hapus=<?= $r['id'] ?>" class="btn-delete-soft" onclick="return confirm('Hapus testimoni ini?')">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5 bg-white rounded-4 border">
                            <i class="fas fa-comment-slash fa-3x text-light mb-3"></i>
                            <p class="text-muted">Belum ada testimoni yang masuk.</p>
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