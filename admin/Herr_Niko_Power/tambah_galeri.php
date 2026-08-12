<?php
include 'config.php';
session_start();

// Gembok Keamanan Admin
if (!isset($_SESSION['admin'])) { 
    header("location: login.php"); 
    exit(); 
}

if (isset($_POST['simpan'])) {
    // Mengambil Judul dari Form
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $nama_file = time() . '_' . basename($_FILES['media']['name']);
$source = $_FILES['media']['tmp_name'];
$ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));   
    
    // Jalur folder fisik Gambar_edu (pakai underscore)
        $folder = "../Gambar_edu/";

    // Daftar format bebas: Foto, Screenshot, Video
    $format_gambar = ['jpg', 'jpeg', 'png', 'webp'];
    $format_video = ['mp4', 'mov', 'mpeg'];     

    // Deteksi Tipe Otomatis berdasarkan ekstensi
    if (in_array($ekstensi, $format_gambar)) {
        $tipe = "foto";
    } elseif (in_array($ekstensi, $format_video)) {
        $tipe = "video";
    } else {
        echo "<script>alert('Format file tidak didukung!'); window.history.back();</script>";
        exit();
    }

    // Pastikan folder tujuan tersedia
    if (!is_dir($folder)) { mkdir($folder, 0777, true); }

    // Proses Pindah File ke folder tujuan
    if(move_uploaded_file($source, $folder . $nama_file)) {
        // Simpan Judul dan Media ke Database
        $query = "INSERT INTO galeri (judul_moment, file_media, tipe) VALUES ('$judul', '$nama_file', '$tipe')";
        mysqli_query($conn, $query);
        echo "<script>alert('Berhasil diunggah dengan judul!'); window.location='manage_galeri.php';</script>";
    } else {
        echo "<script>alert('Gagal! Periksa folder Gambar_edu di laptop kamu.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload dengan Judul | Eduventure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #fdfcf7; font-family: 'Plus Jakarta Sans', sans-serif; }
        .upload-card { border-radius: 30px; border: none; box-shadow: 0 20px 50px rgba(0,0,0,0.06); background: #fff; margin-top: 50px; }
        .btn-gold { background: #f2b705; color: #121212; font-weight: 800; border-radius: 15px; padding: 15px; transition: 0.3s; border: none; }
        .btn-gold:hover { background: #121212; color: #f2b705; transform: translateY(-3px); }
        .form-label { font-weight: 700; color: #333; }
        .form-control { border-radius: 12px; padding: 12px; border: 2px solid #f0f0f0; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="upload-card p-5">
                    <div class="text-center mb-5">
                        <h2 class="fw-800">Upload Media</h2>
                        <p class="text-muted small">Tambahkan judul agar galeri lebih informatif.</p>
                    </div>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="form-label small text-uppercase">Judul / Keterangan Moment</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Suasana Kelas di Jerman" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-uppercase">Pilih File (Foto/Video)</label>
                            <input type="file" name="media" class="form-control" required>
                            <div class="form-text mt-2" style="font-size: 0.7rem;">*Sistem otomatis mendeteksi tipe media.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="simpan" class="btn btn-gold">
                                <i class="fas fa-check-circle me-2"></i>UNGGAH SEKARANG
                            </button>
                            <a href="manage_galeri.php" class="btn btn-light py-2 text-muted border-0">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>