<?php 
// Menghubungkan ke database agar update dari admin bisa masuk ke sini
include 'config.php'; 

// Mengambil data identitas dari database
$ambil_identitas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM identitas WHERE id=1"));

// --- TAMBAHAN: Mengambil data dari tabel HOME agar tidak kosong ---
$ambil_home = mysqli_query($conn, "SELECT * FROM home ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
  <head>  
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDUVENTURE ABROAD</title>
    <link rel="icon" type="image/jpeg" href="logo web/logo.png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap");

      :root {
        --primary-gold: #D4AF37;
        --islamic-green: #065f46;
        --soft-bg: #fdfcf7;
      }
      body {
        font-family: "Plus Jakarta Sans", sans-serif;
        background-color: var(--soft-bg);
        background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');
        overflow-x: hidden;
      }

      .text-gold { color: var(--primary-gold); }
      .bg-gold { background-color: var(--primary-gold); }
      .text-green { color: var(--islamic-green); }
      .bg-green { background-color: var(--islamic-green); }

      .hero-bg-custom {
        background-image: linear-gradient(rgba(253, 252, 247, 0.7), rgba(253, 252, 247, 0.7)), url("backgroud_home/gambar.jpg?t=<?php echo time(); ?>");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
      }
      
      .nav-blur {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-bottom: 3px solid var(--primary-gold);
      }

      /* Animasi Gantung & Ayun */
      @keyframes swing {
        0% { transform: rotate(5deg); }
        50% { transform: rotate(-5deg); }
        100% { transform: rotate(5deg); }
      }
      .ornament-swing { animation: swing 4s ease-in-out infinite; transform-origin: top center; }

      /* Glow effect untuk lampion */
      @keyframes glow {
        0%, 100% { filter: drop-shadow(0 0 5px var(--primary-gold)); opacity: 0.8; }
        50% { filter: drop-shadow(0 0 20px var(--primary-gold)); opacity: 1; }
      }
      .lampion-glow { animation: glow 3s infinite; }

      /* Bintang Jatuh Animasi */
      @keyframes star-fall {
        0% { transform: translateY(-20px) scale(0); opacity: 0; }
        50% { opacity: 1; }
        100% { transform: translateY(100vh) scale(1); opacity: 0; }
      }
      .star { position: fixed; color: var(--primary-gold); z-index: 0; pointer-events: none; animation: star-fall 10s linear infinite; }

      /* Floating Bedug */
      .bedug-bounce { animation: bounce 2s infinite; }

      .glass-text-box {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(8px);
        padding: 20px;
        border-radius: 20px;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-left: 5px solid var(--primary-gold);
      }

      /* Container Ornamen Gantung */
      .ramadhan-header-ornaments {
        position: fixed; top: 0; left: 0; width: 100%; height: 0; z-index: 160; pointer-events: none;
      }

      .ramadhan-card {
        background: white;
        border-bottom: 5px solid var(--islamic-green);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      }
      .ramadhan-card:hover { 
        border-bottom-color: var(--primary-gold); 
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(6, 95, 70, 0.2);
      }

      .bg-islamic-gradient {
        background: linear-gradient(135deg, var(--islamic-green) 0%, #0a4d3a 100%);
      }
    </style>
  </head>
  <body class="antialiased relative">

    <i class="fa-solid fa-star star" style="left: 5%; animation-duration: 8s;"></i>
    <i class="fa-solid fa-moon star" style="left: 25%; animation-duration: 12s; animation-delay: 2s;"></i>
    <i class="fa-solid fa-star star" style="left: 55%; animation-duration: 10s; animation-delay: 5s;"></i>
    <i class="fa-solid fa-star star" style="left: 85%; animation-duration: 15s;"></i>

    <div class="ramadhan-header-ornaments hidden md:block">
        <div class="absolute left-[8%] ornament-swing lampion-glow">
            <svg width="50" height="160" viewBox="0 0 50 160">
                <line x1="25" y1="0" x2="25" y2="70" stroke="#D4AF37" stroke-width="2"/>
                <rect x="10" y="70" width="30" height="40" rx="5" fill="#065f46" stroke="#D4AF37" stroke-width="2"/>
                <circle cx="25" cy="90" r="8" fill="#D4AF37" opacity="0.6"/>
                <line x1="15" y1="110" x2="15" y2="135" stroke="#D4AF37" stroke-width="1.5"/>
                <line x1="25" y1="110" x2="25" y2="145" stroke="#D4AF37" stroke-width="1.5"/>
                <line x1="35" y1="110" x2="35" y2="135" stroke="#D4AF37" stroke-width="1.5"/>
            </svg>
        </div>
        <div class="absolute right-[12%] flex gap-6">
            <div class="ornament-swing" style="animation-delay: -0.5s;">
                <svg width="35" height="130" viewBox="0 0 40 150"><rect x="19" y="0" width="2" height="85" fill="#D4AF37"/><path d="M20 75L36 91L20 107L4 91L20 75Z" fill="#D4AF37" stroke="#065f46" stroke-width="2"/></svg>
            </div>
            <div class="ornament-swing" style="animation-delay: -1.2s;">
                <svg width="45" height="180" viewBox="0 0 45 180"><rect x="21" y="0" width="3" height="110" fill="#D4AF37"/><path d="M22.5 100L42 120L22.5 140L3 120L22.5 100Z" fill="#D4AF37" stroke="#065f46" stroke-width="2.5"/></svg>
            </div>
            <div class="ornament-swing" style="animation-delay: -2s;">
                <svg width="35" height="150" viewBox="0 0 40 150"><rect x="19" y="0" width="2" height="95" fill="#D4AF37"/><path d="M20 85L36 101L20 117L4 101L20 85Z" fill="#D4AF37" stroke="#065f46" stroke-width="2"/></svg>
            </div>
        </div>
    </div>

    <div class="fixed bottom-6 left-6 z-[100] hidden lg:block bedug-bounce">
       <div class="bg-white p-4 rounded-3xl shadow-2xl border-2 border-gold flex flex-col items-center">
          <i class="fa-solid fa-drum text-green text-5xl"></i>
          <span class="text-[10px] font-black text-green mt-2 tracking-tighter">RAMADHAN KAREEM</span>
       </div>
    </div>

    <nav class="fixed w-full z-[100] nav-blur transition-all duration-300">
      <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex-1">
          <a href="index.php" class="inline-block group logo-floating">
            <div class="flex items-center gap-2">
              <div class="bg-green text-gold font-black px-2 py-1 rounded-lg text-sm shadow-lg flex items-center gap-1"><i class="fa-solid fa-moon text-[10px]"></i> EV</div>
              <h1 class="text-xl md:text-2xl font-extrabold text-green italic tracking-tighter leading-none">Eduventure Abroad</h1>
            </div>
          </a>
        </div>
        <div class="hidden md:flex flex-[2] justify-center items-center">
          <div class="bg-white/50 px-8 py-2 rounded-full border border-green/10 flex space-x-8 text-sm font-bold text-slate-600">
            <a href="index.php" class="text-green border-b-2 border-gold transition-all">Home</a>
            <a href="profil.php" class="hover:text-green transition-all">Profil</a>
            <a href="program.php" class="hover:text-green transition-all">Program</a>
            <a href="galeri.php" class="hover:text-green transition-all">Galeri</a>
            <a href="testimoni.php" class="hover:text-green transition-all">Testimoni</a>
          </div>
        </div>
        <div class="flex-1 flex justify-end items-center gap-3">
          <a href="javascript:void(0)" onclick="openWaModal()" class="wa-bounce bg-green text-gold px-5 py-2.5 rounded-full flex items-center gap-2 shadow-lg hover:scale-105 transition-all"><i class="fa-brands fa-whatsapp text-xl"></i><span class="text-xs font-extrabold uppercase hidden lg:block">Hubungi Kami</span></a>
          <button id="openMenu" class="md:hidden w-11 h-11 flex items-center justify-center bg-green/10 text-green rounded-2xl"><i class="fa-solid fa-bars-staggered text-xl"></i></button>
        </div>
      </div>
    </nav>

    <section class="min-h-screen flex items-center px-6 pt-20 relative overflow-hidden hero-bg-custom">
      <div class="absolute bottom-0 right-0 opacity-10 pointer-events-none translate-y-10">
         <i class="fa-solid fa-mosque text-[25rem] text-green"></i>
      </div>

      <div class="container mx-auto grid md:grid-cols-2 items-center gap-12 relative z-10">
        <div data-aos="fade-right" data-aos-duration="1000">
          <div class="inline-flex items-center gap-2 px-4 py-2 bg-green/10 rounded-full mb-6 border border-green/20">
            <i class="fa-solid fa-star-and-crescent text-green text-xs"></i>
            <span class="text-[10px] font-black uppercase text-green tracking-widest font-bold">Marhaban Ya Ramadhan</span>
          </div>
          <h2 class="text-5xl md:text-7xl font-extrabold text-green leading-[1.1] tracking-tighter mb-2">Eduventure Abroad</h2>
          <h3 class="text-3xl md:text-4xl font-black text-gold italic mb-8 tracking-tight min-h-[40px]" id="typing-slogan"></h3>
          <div class="glass-text-box max-w-xl mb-10 shadow-xl">
            <p class="text-slate-800 text-lg leading-relaxed font-bold"><?php echo $ambil_identitas['deskripsi_home']; ?></p>
          </div>
          <div class="flex flex-wrap gap-4">
            <a href="program.php" class="px-8 py-4 bg-green text-gold rounded-2xl font-bold border border-gold/50 shadow-2xl hover:scale-110 transition-all">Lihat Program</a>
            <div class="flex items-center gap-2 text-green font-bold px-4">
               <i class="fa-solid fa-hands-praying animate-bounce text-xl"></i>
               <span>Selamat Menunaikan Ibadah Puasa</span>
            </div>
          </div>
        </div>
        <div class="relative flex justify-center" data-aos="zoom-in" data-aos-duration="1200">
          <div class="hero-img-animate relative z-10">
            <img src="gambar depan/gambar1.png" class="rounded-[3.5rem] shadow-2xl border-[15px] border-white w-full max-w-[450px] aspect-[4/5] object-cover" alt="Eduventure Abroad" />
            <div class="absolute -top-6 -right-6 w-20 h-20 bg-gold rounded-full flex items-center justify-center text-white shadow-xl rotate-12">
               <i class="fa-solid fa-kaaba text-3xl"></i>
            </div>
          </div>
          <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-gold rounded-3xl -rotate-12 -z-0 opacity-20"></div>
        </div>
      </div>
    </section>

    <section class="py-24 bg-white/50 relative overflow-hidden">
      <div class="container mx-auto px-6 text-center mb-16">
         <h2 class="text-4xl font-black text-green italic uppercase">Program <span class="text-gold">Unggulan</span></h2>
         <div class="w-24 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
      </div>
      <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php while($h = mysqli_fetch_assoc($ambil_home)) : ?>
            <div class="p-8 ramadhan-card rounded-[3rem] flex flex-col items-center text-center shadow-lg group" data-aos="fade-up">
                <div class="w-full h-56 overflow-hidden rounded-[2.5rem] mb-6 shadow-md border-4 border-white transition-all group-hover:border-gold">
                    <?php 
                    $ext = strtolower(pathinfo($h['gambar'], PATHINFO_EXTENSION)); 
                    $path = 'admin/Herr_Niko_Power/upload/home/' . $h['gambar']; 
                    if (in_array($ext, ['mp4','webm'])): ?>
                      <video class="w-full h-full object-cover" controls><source src="<?= $path ?>"></video>
                    <?php else: ?>
                      <img src="<?= $path ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="">
                    <?php endif; ?>
                </div>
                <h4 class="text-2xl font-black text-green mb-1 italic uppercase tracking-tighter"><?php echo $h['judul']; ?></h4>
                <h5 class="text-sm font-bold text-gold uppercase mb-4 tracking-widest"><?php echo $h['judul_program']; ?></h5>
                <p class="text-slate-600 font-bold text-sm leading-relaxed"><?php echo $h['deskripsi']; ?></p>
            </div>
            <?php endwhile; ?>
        </div>
      </div>
    </section>

    <section id="internship-coming-soon" class="py-24 bg-islamic-gradient relative overflow-hidden">
      <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/islamic-art.png');"></div>
      <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col items-center text-center max-w-4xl mx-auto" data-aos="fade-up">
          <div class="mb-8 p-6 bg-gold/20 rounded-full inline-block shadow-inner"><i class="fa-solid fa-briefcase text-5xl text-gold animate-bounce"></i></div>
          <h2 class="text-4xl md:text-6xl font-black text-white mb-4 italic tracking-tighter">GLOBAL <span class="text-gold">INTERNSHIP</span></h2>
          <p class="text-xs font-black text-gold tracking-[0.5em] uppercase mb-8">Peluang Magang Profesional di Jerman</p>
          <div class="glass-text-box w-full max-w-2xl mb-12 border-white/20"><p class="text-white text-lg font-bold leading-relaxed">Persiapkan dirimu untuk pengalaman kerja nyata di perusahaan ternama Jerman selepas hari kemenangan.</p></div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full mb-12">
            <div class="p-8 bg-white/10 rounded-[2rem] border-2 border-dashed border-gold/30 hover:bg-gold/20 transition-all group">
               <div class="w-12 h-12 bg-gold rounded-2xl flex items-center justify-center shadow-sm mb-6 mx-auto"><i class="fa-solid fa-euro-sign text-xl text-green"></i></div>
               <h4 class="font-black text-white mb-2">Uang Saku</h4><p class="text-sm text-white/70 font-bold">Tunjangan bulanan standar Eropa.</p>
            </div>
            <div class="p-8 bg-white/10 rounded-[2rem] border-2 border-dashed border-gold/30 hover:bg-gold/20 transition-all group">
               <div class="w-12 h-12 bg-gold rounded-2xl flex items-center justify-center shadow-sm mb-6 mx-auto"><i class="fa-solid fa-certificate text-xl text-green"></i></div>
               <h4 class="font-black text-white mb-2">Sertifikat Resmi</h4><p class="text-sm text-white/70 font-bold">Pengakuan internasional untuk CV.</p>
            </div>
            <div class="p-8 bg-white/10 rounded-[2rem] border-2 border-dashed border-gold/30 hover:bg-gold/20 transition-all group">
               <div class="w-12 h-12 bg-gold rounded-2xl flex items-center justify-center shadow-sm mb-6 mx-auto"><i class="fa-solid fa-earth-europe text-xl text-green"></i></div>
               <h4 class="font-black text-white mb-2">Akomodasi</h4><p class="text-sm text-white/70 font-bold">Bantuan tempat tinggal di Jerman.</p>
            </div>
          </div>
          <div class="inline-flex items-center gap-4 px-10 py-5 bg-gold text-green rounded-full font-black text-sm tracking-widest uppercase shadow-2xl hover:scale-105 transition-all"><i class="fa-solid fa-bullhorn animate-pulse"></i> Coming Soon: Pembukaan Cabang Baru!!!</div>
        </div>
      </div>
    </section>

    <footer class="bg-white border-t-8 border-gold pt-24 pb-12">
      <div class="container mx-auto px-6 text-center md:text-left">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-20 items-start">
          <div class="flex flex-col items-center md:items-start">
            <h3 class="text-3xl font-black text-green italic mb-6 uppercase tracking-tighter">EDUVENTURE ABROAD</h3>
            <div class="flex gap-4">
              <a href="#" class="w-12 h-12 rounded-2xl bg-green/5 flex items-center justify-center text-green hover:bg-green hover:text-gold transition-all shadow-md"><i class="fa-brands fa-tiktok text-xl"></i></a>
              <a href="#" class="w-12 h-12 rounded-2xl bg-green/5 flex items-center justify-center text-green hover:bg-[#1877F2] hover:text-white transition-all shadow-md"><i class="fa-brands fa-facebook-f text-xl"></i></a>
              <a href="#" class="w-12 h-12 rounded-2xl bg-green/5 flex items-center justify-center text-green hover:bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] hover:text-white transition-all shadow-md"><i class="fa-brands fa-instagram text-xl"></i></a>
            </div>
          </div>
          <div class="flex flex-col items-center justify-center">
            <h4 class="font-bold text-green mb-6 uppercase text-xs tracking-[0.2em]">Lokasi Kami</h4>
            <a href="#" class="flex flex-col items-center gap-3 text-gold hover:scale-110 transition-all group">
              <div class="w-24 h-24 bg-green/10 rounded-[2rem] flex items-center justify-center shadow-lg group-hover:bg-green group-hover:text-gold transition-all"><i class="fa-solid fa-map-location-dot text-4xl"></i></div>
              <span class="font-black italic text-sm text-green uppercase">Buka Google Maps</span>
            </a>
          </div>
          <div class="text-center md:text-left">
            <h4 class="font-bold text-green mb-6 uppercase text-xs tracking-[0.2em]">Email Kami</h4>
            <p class="text-slate-600 text-lg leading-relaxed font-black">abroadeduventure@gmail.com</p>
          </div>
        </div>
        <div class="pt-10 border-t border-slate-100 text-center">
          <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.4em]">© 2026 Eduventure Abroad - Ramadhan Kareem Edition</p>
        </div>
      </div>
    </footer>

    <div id="waModal" class="fixed inset-0 z-[300] hidden items-center justify-center px-4">
      <div class="absolute inset-0 bg-green/80 backdrop-blur-sm" onclick="closeWaModal()"></div>
      <div id="waModalContent" class="bg-white rounded-[3rem] p-10 w-full max-w-sm relative z-10 shadow-2xl transition-all border-t-8 border-gold">
         <h3 class="text-2xl font-black text-green mb-6 italic text-center">Konsultasi Ramadhan</h3>
         <div class="flex flex-col gap-4">
            <a href="https://wa.me/628886836298" target="_blank" class="p-5 bg-slate-50 rounded-2xl flex items-center gap-4 hover:bg-green/10 transition-all group">
                <div class="w-12 h-12 bg-green rounded-xl flex items-center justify-center text-gold shadow-md"><i class="fa-brands fa-whatsapp text-2xl"></i></div>
                <div><p class="font-black text-slate-900 leading-none">Admin 1</p><p class="text-[10px] text-slate-500 font-bold mt-1">Fast Response</p></div>
            </a>
            <a href="https://wa.me/6285786364389" target="_blank" class="p-5 bg-slate-50 rounded-2xl flex items-center gap-4 hover:bg-green/10 transition-all group">
                <div class="w-12 h-12 bg-green rounded-xl flex items-center justify-center text-gold shadow-md"><i class="fa-brands fa-whatsapp text-2xl"></i></div>
                <div><p class="font-black text-slate-900 leading-none">Admin 2</p><p class="text-[10px] text-slate-500 font-bold mt-1">Konsultasi Program</p></div>
            </a>
         </div>
         <button onclick="closeWaModal()" class="w-full mt-8 text-slate-400 font-bold text-sm uppercase tracking-widest hover:text-green transition-all">Nanti Saja</button>
      </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({ once: true });
      const text = "<?php echo $ambil_identitas['slogan_home']; ?>";
      const typingElement = document.getElementById("typing-slogan");
      let index = 0;
      function typeEffect() {
        if (index < text.length) { typingElement.innerHTML += text.charAt(index); index++; setTimeout(typeEffect, 100); } 
        else { setTimeout(() => { typingElement.innerHTML = ""; index = 0; typeEffect(); }, 3000); }
      }
      window.onload = typeEffect;
      function openWaModal() { document.getElementById("waModal").classList.remove("hidden"); document.getElementById("waModal").classList.add("flex"); setTimeout(() => { document.getElementById("waModalContent").classList.remove("scale-95", "opacity-0"); document.getElementById("waModalContent").classList.add("scale-100", "opacity-100"); }, 10); }
      function closeWaModal() { document.getElementById("waModalContent").classList.add("scale-95", "opacity-0"); setTimeout(() => { document.getElementById("waModal").classList.add("hidden"); }, 300); }
    </script>
  </body>
</html>