<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin'])) { header("location: login.php"); exit(); }

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM identitas WHERE id=1"));

if (isset($_POST['update_teks'])) {
    $kolom = $_POST['kolom_target'];
    $isi = mysqli_real_escape_string($conn, $_POST['isi_baru']);
    $update = mysqli_query($conn, "UPDATE identitas SET $kolom = '$isi' WHERE id=1");
    if ($update) {
        echo "<script>alert('Konfigurasi Berhasil Diperbarui!'); window.location='manage_identitas.php';</script>";
    }
}

// Fungsi helper dengan UI yang diperbarui
function renderField($data, $kolom, $label, $sub, $icon) {
    $val = isset($data[$kolom]) ? $data[$kolom] : '';
    ?>
    <div class="card-input-wrapper mb-4">
        <div class="card-input">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle me-3">
                        <i class="fas <?php echo $icon; ?>"></i>
                    </div>
                    <div>
                        <span class="badge-cat">Database Field: <?php echo $kolom; ?></span>
                        <h5 class="input-label mb-0"><?php echo $label; ?></h5>
                        <p class="input-sub mb-0"><?php echo $sub; ?></p>
                    </div>
                </div>
            </div>
            
            <form method="POST" class="mt-2">
                <input type="hidden" name="kolom_target" value="<?php echo $kolom; ?>">
                <div class="textarea-wrapper">
                    <textarea name="isi_baru" class="form-control custom-textarea" 
                              placeholder="Tulis perubahan teks di sini..."><?php echo htmlspecialchars($val); ?></textarea>
                    <div class="focus-border"></div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="status-indicator">
                        <i class="fas fa-circle-check text-success me-1"></i> 
                        <span class="small text-muted">Tersimpan secara aman</span>
                    </div>
                    <button type="submit" name="update_teks" class="btn-save-new">
                        <span>Update Konten</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Editor | Eduventure Abroad</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --primary: #f2b705; 
            --dark-blue: #0f172a; 
            --slate: #64748b;
            --bg-soft: #f8fafc;
            --white: #ffffff;
            --glass: rgba(255, 255, 255, 0.7);
        }

        body { 
            background-color: var(--bg-soft); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: var(--dark-blue);
            letter-spacing: -0.2px;
        }

        /* Layout */
        .master-wrapper { padding: 40px; }
        
        /* Sidebar Styling */
        .sidebar-sticky {
            position: sticky;
            top: 40px;
            background: var(--white);
            padding: 30px;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
        }

        .sidebar-brand { font-weight: 800; font-size: 1.6rem; color: var(--dark-blue); }

        .nav-pills .nav-link { 
            color: var(--slate); 
            border-radius: 14px; 
            padding: 14px 20px; 
            font-weight: 600; 
            transition: all 0.3s ease;
            margin-bottom: 8px;
            border: 1px solid transparent;
            font-size: 0.95rem;
        }

        .nav-pills .nav-link i { width: 25px; font-size: 1.1rem; }

        .nav-pills .nav-link.active { 
            background-color: var(--dark-blue) !important; 
            color: var(--primary) !important; 
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.15);
        }

        /* Editor Content */
        .editor-main-card {
            background: var(--white);
            border-radius: 32px;
            border: 1px solid #e2e8f0;
            padding: 45px;
            min-height: 85vh;
        }

        .section-title { font-weight: 800; font-size: 2rem; margin-bottom: 8px; }
        .section-subtitle { color: var(--slate); margin-bottom: 40px; }

        /* Card Input Styling */
        .card-input {
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .card-input:hover {
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
            transform: translateY(-4px);
        }

        .icon-circle {
            width: 48px;
            height: 48px;
            background: #fff9e6;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.2rem;
        }

        .badge-cat {
            background: #f1f5f9;
            color: #64748b;
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            margin-bottom: 8px;
            display: inline-block;
        }

        .input-label { font-weight: 700; color: var(--dark-blue); }
        .input-sub { font-size: 0.85rem; color: var(--slate); }

        /* Textarea Styling */
        .textarea-wrapper { position: relative; }
        
        .custom-textarea {
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            background: #fcfcfc;
            padding: 16px;
            font-weight: 500;
            color: var(--dark-blue);
            transition: all 0.3s;
            min-height: 100px;
        }

        .custom-textarea:focus {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(242, 183, 5, 0.1);
        }

        /* Buttons */
        .btn-save-new {
            background: var(--dark-blue);
            color: var(--white);
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
        }

        .btn-save-new:hover {
            background: var(--primary);
            color: var(--dark-blue);
            transform: translateX(4px);
        }

        /* Animation */
        .tab-pane {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container-fluid master-wrapper">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="sidebar-sticky">
                <div class="mb-5">
                    <a href="dashboard.php" class="text-decoration-none d-inline-flex align-items-center mb-4 px-3 py-2 rounded-3 bg-light text-dark fw-600 small">
                        <i class="fas fa-chevron-left me-2"></i> Dashboard
                    </a>
                    <h1 class="sidebar-brand">Eduventure<span class="text-warning">.</span></h1>
                    <p class="text-muted small">Global Identity Manager</p>
                </div>

                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    <button class="nav-link active text-start" data-bs-toggle="pill" data-bs-target="#home" type="button"><i class="fas fa-home-alt me-2"></i> Beranda</button>
                    <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#profil" type="button"><i class="fas fa-info-circle me-2"></i> Profil Agensi</button>
                    <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#program" type="button"><i class="fas fa-layer-group me-2"></i> Layanan</button>
                    <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#galeri" type="button"><i class="fas fa-camera-retro me-2"></i> Dokumentasi</button>
                    <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#testi" type="button"><i class="fas fa-star me-2"></i> Review Alumni</button>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="editor-main-card">
                <div class="tab-content" id="v-pills-tabContent">
                    
                    <div class="tab-pane fade show active" id="home">
                        <h2 class="section-title">Beranda</h2>
                        <p class="section-subtitle">Atur teks pemicu (call to action) pada landing page utama.</p>
                        <?php renderField($data, 'slogan_home', 'Slogan Utama', 'Teks pembuka di banner utama website.', 'fa-keyboard'); ?>
                        <?php renderField($data, 'deskripsi_home', 'Deskripsi Singkat', 'Penjelasan singkat yang muncul di bawah slogan.', 'fa-align-left'); ?>
                    </div>

                    <div class="tab-pane fade" id="profil">
                        <h2 class="section-title">Profil & Visi</h2>
                        <p class="section-subtitle">Kelola pernyataan visi, misi, dan judul profil perusahaan.</p>
                        <?php renderField($data, 'judul_profil', 'Judul Profil', 'Header utama halaman tentang kami.', 'fa-id-card'); ?>
                        <?php renderField($data, 'visi', 'Visi Perusahaan', 'Pernyataan tujuan jangka panjang agensi.', 'fa-eye'); ?>
                        <?php renderField($data, 'misi', 'Misi Perusahaan', 'Daftar rencana aksi nyata perusahaan.', 'fa-bullseye'); ?>
                    </div>

                    <div class="tab-pane fade" id="program">
                        <h2 class="section-title">Layanan</h2>
                        <p class="section-subtitle">Atur teks promosi untuk daftar program studi atau layanan.</p>
                        <?php renderField($data, 'judul_program', 'Judul Section Program', 'Header di section pilihan program.', 'fa-list-check'); ?>
                        <?php renderField($data, 'sub_program', 'Deskripsi Katalog', 'Teks pengantar sebelum daftar program muncul.', 'fa-circle-info'); ?>
                    </div>

                    <div class="tab-pane fade" id="galeri">
                        <h2 class="section-title">Dokumentasi</h2>
                        <p class="section-subtitle">Judul dan pengantar untuk album kegiatan perusahaan.</p>
                        <?php renderField($data, 'judul_galeri', 'Header Galeri', 'Judul besar pada bagian foto kegiatan.', 'fa-camera'); ?>
                        <?php renderField($data, 'sub_galeri', 'Teks Pengantar Galeri', 'Penjelasan singkat mengenai dokumentasi.', 'fa-images'); ?>
                    </div>

                    <div class="tab-pane fade" id="testi">
                        <h2 class="section-title">Ulasan Alumni</h2>
                        <p class="section-subtitle">Atur judul untuk menampilkan kredibilitas agensi.</p>
                        <?php renderField($data, 'judul_testimoni', 'Judul Testimoni', 'Header bagian review alumni.', 'fa-star'); ?>
                        <?php renderField($data, 'sub_testimoni', 'Sub-Header Testimoni', 'Kalimat ajakan untuk membaca testimoni.', 'fa-comment'); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>