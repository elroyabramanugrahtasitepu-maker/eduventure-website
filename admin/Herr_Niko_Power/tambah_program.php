<?php
include 'config.php';
session_start();

// Proteksi halaman admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$edit_mode = false;
$id_edit = $v_judul = $v_subjudul = $v_deskripsi = "";

// Logika Simpan Perubahan
if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $subjudul = mysqli_real_escape_string($conn, $_POST['judul_program']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $id = $_POST['id_program'];

    $update = mysqli_query($conn, "UPDATE program SET judul='$judul', judul_program='$subjudul', deskripsi='$deskripsi' WHERE id=$id");
    
    if($update) {
        header("Location: tambah_program.php?status=success");
        exit;
    }
}

// Ambil Data untuk Edit jika ada parameter 'edit' di URL
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id_edit = (int)$_GET['edit'];
    $res_edit = mysqli_query($conn, "SELECT * FROM program WHERE id=$id_edit");
    if($row = mysqli_fetch_assoc($res_edit)) {
        $v_judul = $row['judul']; 
        $v_subjudul = $row['judul_program']; 
        $v_deskripsi = $row['deskripsi']; 
    }
}

// Ambil 3 Program Utama (ID 1, 2, 3) untuk ditampilkan di sidebar kiri
$data_utama = mysqli_query($conn, "SELECT * FROM program ORDER BY id ASC LIMIT 3");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Utama Admin | Eduventure</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdfcf7; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(226, 232, 240, 0.8); }
        .active-menu { border-color: #f2b705; background-color: #fffbeb; }
    </style>
</head>
<body class="antialiased text-slate-900">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-[#f2b705] text-white font-black px-2 py-1 rounded-lg text-sm">EV</div>
                <h1 class="text-xl font-extrabold italic text-[#f2b705] tracking-tighter">Eduventure Abroad <span class="text-slate-400 not-italic font-medium ml-2">| Admin</span></h1>
            </div>
            <a href="dashboard.php" class="text-slate-500 hover:text-slate-800 font-bold flex items-center gap-2 transition-all text-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-5">
                <div class="mb-8">
                    <h2 class="text-3xl font-black tracking-tight mb-2">Menu Utama</h2>
                    <p class="text-slate-500 font-medium">Klik salah satu program di bawah untuk mengubah kontennya.</p>
                </div>

                <div class="space-y-4">
                    <?php 
                    $no = 1;
                    while($r = mysqli_fetch_assoc($data_utama)): 
                        $is_active = ($id_edit == $r['id']) ? 'active-menu' : '';
                    ?>
                    <a href="?edit=<?= $r['id'] ?>" class="block group">
                        <div class="p-6 rounded-[2rem] glass-card shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 flex items-center justify-between <?= $is_active ?>">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-2xl text-[#f2b705] group-hover:scale-110 transition-transform">
                                    <?php 
                                        if($no == 1) echo '<i class="fa-solid fa-language"></i>';
                                        elseif($no == 2) echo '<i class="fa-solid fa-file-signature"></i>';
                                        else echo '<i class="fa-solid fa-house-user"></i>';
                                    ?>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#f2b705]">Program 0<?= $no ?></span>
                                    <h3 class="font-bold text-lg group-hover:text-[#f2b705] transition-colors"><?= $r['judul'] ?></h3>
                                </div>
                            </div>
                            <div class="text-slate-300 group-hover:text-[#f2b705] transition-colors">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                    <?php $no++; endwhile; ?>
                </div>
            </div>

            <div class="lg:col-span-7">
                <?php if($edit_mode): ?>
                    <div class="p-8 md:p-10 rounded-[2.5rem] bg-white border border-slate-200 shadow-xl shadow-slate-200/50">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-black italic">Edit Konten</h3>
                        </div>

                        <form method="post" class="space-y-6">
                            <input type="hidden" name="id_program" value="<?= $id_edit ?>">

                            <div>
                                <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Judul Utama</label>
                                <input type="text" name="judul" value="<?= $v_judul ?>" required
                                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-[#f2b705] focus:ring-4 focus:ring-[#f2b705]/10 outline-none transition-all font-bold">
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Label (Sub-Judul)</label>
                                <input type="text" name="judul_program" value="<?= $v_subjudul ?>"
                                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-[#f2b705] focus:ring-4 focus:ring-[#f2b705]/10 outline-none transition-all font-semibold">
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Detail Deskripsi (Pop-up)</label>
                                <textarea name="deskripsi" rows="8" required
                                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-[#f2b705] focus:ring-4 focus:ring-[#f2b705]/10 outline-none transition-all font-medium leading-relaxed"><?= $v_deskripsi ?></textarea>
                            </div>

                            <button type="submit" name="simpan" 
                                class="w-full bg-[#f2b705] text-white font-black py-4 rounded-2xl shadow-lg hover:bg-[#d9a404] transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-save"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="h-full flex flex-col items-center justify-center p-12 rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-white/50 text-center">
                        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center text-slate-300 text-4xl mb-6">
                            <i class="fa-solid fa-arrow-left"></i>
                        </div>
                        <h4 class="text-xl font-black text-slate-400 mb-2">Belum ada program dipilih</h4>
                        <p class="max-w-xs text-slate-400 font-medium">Silakan pilih salah satu menu di panel sebelah kiri untuk mulai mengedit konten.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>
</body>
</html>