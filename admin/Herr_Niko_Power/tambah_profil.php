<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $judul_utama = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi_umum = mysqli_real_escape_string($conn, $_POST['deskripsi_umum']);
    $visi_judul = mysqli_real_escape_string($conn, $_POST['visi_judul']);
    $visi_teks = mysqli_real_escape_string($conn, $_POST['visi_teks']);
    $misi_judul = mysqli_real_escape_string($conn, $_POST['misi_judul']);
    $misi_teks = mysqli_real_escape_string($conn, $_POST['misi_teks']);

    $gabung_deskripsi = $deskripsi_umum . "||" . $visi_teks . "||" . $misi_teks;
    $gabung_subjudul = $visi_judul . "||" . $misi_judul;

    mysqli_query($conn, "INSERT INTO profil (judul, judul_program, deskripsi) VALUES ('$judul_utama', '$gabung_subjudul', '$gabung_deskripsi')");

    header("Location: tambah_profil.php?status=success");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM profil WHERE id=$id");
    header("Location: tambah_profil.php?status=deleted");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM profil ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Admin Profil | Eduventure Abroad</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #f2b705;
            --dark: #0f172a;
            --soft-bg: #f8fafc;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--soft-bg);
            color: var(--dark);
        }

        /* Navbar & Header */
        .admin-nav {
            background: white;
            padding: 20px 40px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 40px;
        }

        /* Card Styling */
        .card-custom {
            background: white;
            border-radius: 24px;
            border: none;
            box-shadow: var(--card-shadow);
            padding: 35px;
            transition: transform 0.3s ease;
        }

        /* Form Inputs */
        .form-label {
            font-weight: 700;
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 18px;
            border: 1px solid #e2e8f0;
            background: #fdfdfd;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(242, 183, 5, 0.1);
        }

        /* Buttons */
        .btn-update {
            background: var(--dark);
            color: white;
            border-radius: 14px;
            padding: 14px;
            font-weight: 800;
            width: 100%;
            border: none;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-update:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            color: white;
        }

        .btn-back {
            background: white;
            color: var(--dark);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-back:hover {
            background: #f1f5f9;
            color: var(--dark);
        }

        /* Table Styling */
        .table-container {
            border-radius: 20px;
            overflow: hidden;
            background: white;
        }

        .table thead {
            background: #f8fafc;
        }

        .table thead th {
            padding: 20px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            border: none;
        }

        .table tbody td {
            padding: 20px;
            vertical-align: middle;
            border-color: #f1f5f9;
        }

        .btn-delete {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #fff1f2;
            color: #e11d48;
            transition: all 0.2s;
            border: none;
        }

        .btn-delete:hover {
            background: #e11d48;
            color: white;
        }

        .badge-info {
            background: #fef9c3;
            color: #a16207;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.7rem;
        }

        hr.dashed {
            border-top: 2px dashed #e2e8f0;
            margin: 30px 0;
            opacity: 0.5;
        }
    </style>
</head>
<body>

<nav class="admin-nav d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-warning text-white p-2 rounded-3">
            <i class="fas fa-user-edit"></i>
        </div>
        <div>
            <h5 class="fw-800 m-0">Profil Editor</h5>
            <p class="text-muted small m-0">Eduventure Abroad Control Panel</p>
        </div>
    </div>
    <a href="dashboard.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</nav>

<div class="container-fluid px-md-5">
    <div class="row g-5">
        <div class="col-xl-5 col-lg-6">
            <div class="card-custom">
                <div class="mb-4">
                    <h4 class="fw-800 mb-1">Update Teks Konten</h4>
                    <p class="text-muted small">Kosongkan bagian yang tidak ingin ditampilkan di website.</p>
                </div>

                <form method="post">
                    <div class="mb-4">
                        <label class="form-label">Judul Utama Journey</label>
                        <input type="text" name="judul" class="form-control" placeholder="Misal: Inovasi Eduventure Sejak 2023">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Paragraf Deskripsi Umum</label>
                        <textarea name="deskripsi_umum" class="form-control" rows="4" placeholder="Tuliskan cerita singkat agensi..."></textarea>
                    </div>

                    <hr class="dashed">

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Label Box 1 (Visi)</label>
                            <input type="text" name="visi_judul" class="form-control" placeholder="Visi Kami">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Label Box 2 (Misi)</label>
                            <input type="text" name="misi_judul" class="form-control" placeholder="Misi Kami">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konten Visi</label>
                        <textarea name="visi_teks" class="form-control" rows="3" placeholder="Apa tujuan utama Eduventure?"></textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Konten Misi</label>
                        <textarea name="misi_teks" class="form-control" rows="3" placeholder="Langkah nyata yang dilakukan..."></textarea>
                    </div>

                    <button type="submit" name="simpan" class="btn-update">
                        <i class="fas fa-sync-alt me-2"></i> Update Tampilan Website
                    </button>
                </form>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6">
            <div class="table-container shadow-sm">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Preview Judul</th>
                            <th>Status Box</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($data) > 0): ?>
                            <?php while($r = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td>
                                    <div class="fw-700"><?= !empty($r['judul']) ? $r['judul'] : '<span class="text-muted italic">No Title</span>' ?></div>
                                    <div class="text-muted x-small" style="font-size: 0.7rem;">ID: #<?= $r['id'] ?></div>
                                </td>
                                <td>
                                    <?php 
                                        $sub = explode("||", $r['judul_program']);
                                        if(!empty($sub[0])) echo '<span class="badge-info me-1">Visi ON</span>';
                                        if(!empty($sub[1])) echo '<span class="badge-info">Misi ON</span>';
                                    ?>
                                </td>
                                <td class="d-flex justify-content-center">
                                    <a href="?hapus=<?= $r['id'] ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus perubahan ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="fas fa-history fa-2x mb-3 opacity-20"></i>
                                    <p class="small m-0">Belum ada riwayat perubahan data.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 p-3 bg-white border rounded-4 d-flex align-items-center gap-3">
                <div class="bg-success text-white p-2 rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-info-circle fa-sm"></i>
                </div>
                <p class="m-0 small text-muted">Data terbaru yang Anda simpan akan muncul secara otomatis sebagai konten utama di halaman profil.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>