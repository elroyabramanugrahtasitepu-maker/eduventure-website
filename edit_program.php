<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin'])) { header("location: login.php"); exit(); }

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM program WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    if ($_FILES['gambar']['name'] != "") {
        $nama_file = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../Gambar edu/".$nama_file);
        mysqli_query($conn, "UPDATE program SET judul='$judul', deskripsi='$deskripsi', gambar='$nama_file' WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE program SET judul='$judul', deskripsi='$deskripsi' WHERE id='$id'");
    }
    header("location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Program - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-primary { background: #ffcc00; border: none; color: black; font-weight: 600; }
        .img-current { width: 100%; max-height: 200px; object-fit: cover; border-radius: 10px; border: 2px solid #ddd; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="dashboard.php" class="btn btn-outline-dark me-3"><i class="fas fa-arrow-left"></i></a>
                        <h2 class="mb-0 fw-bold">Edit Program</h2>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Program</label>
                            <input type="text" name="judul" class="form-control" value="<?= $row['judul'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="6" required><?= $row['deskripsi'] ?></textarea>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <label class="form-label fw-bold">Gambar Saat Ini</label>
                                <img src="../Gambar edu/<?= $row['gambar'] ?>" class="img-current">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                                <input type="file" name="gambar" class="form-control">
                                <p class="small text-muted mt-2 mt-md-4">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="update" class="btn btn-primary btn-lg"><i class="fas fa-sync me-2"></i>Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>