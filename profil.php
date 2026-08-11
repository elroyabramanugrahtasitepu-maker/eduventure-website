<?php 
// 1. Menyambungkan ke database agar menu dan sistem navigasi tetap sinkron
include 'config.php'; 

// Ambil data profil terbaru dari database
$query_profil = mysqli_query($conn, "SELECT * FROM profil ORDER BY id DESC LIMIT 1");
$data_profil = mysqli_fetch_assoc($query_profil);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Perusahaan | EDUVENTURE ABROAD</title>
    <link rel="icon" type="image/jpeg" href="logo web/logo.png" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap");

      :root {
        /* GANTI KE TEMA GOLD SESUAI INDEX */
        --primary-gold: #f2b705; 
        --soft-bg: #fdfcf7;      
      }
      body {
        font-family: "Plus Jakarta Sans", sans-serif;
        background-color: var(--soft-bg);
      }

      .text-gold { color: var(--primary-gold); }
      .bg-gold { background-color: var(--primary-gold); }

      /* Smooth Glass Navbar */
      .nav-blur {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-b: 2px solid var(--primary-gold);
      }

      /* WA Pulse Gold */
      @keyframes wa-pulse {
        0% { box-shadow: 0 0 0 0 rgba(242, 183, 5, 0.5); }
        70% { box-shadow: 0 0 0 15px rgba(242, 183, 5, 0); }
        100% { box-shadow: 0 0 0 0 rgba(242, 183, 5, 0); }
      }
      .wa-bounce {
        animation: wa-pulse 2s infinite;
        background-color: var(--primary-gold) !important;
      }

      /* GANTI LAMPION KE BENDERA JERMAN */
      .flag-container {
        position: absolute;
        bottom: -15px;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: space-around;
        pointer-events: none;
        z-index: -1;
      }
      .flag {
        width: 20px;
        height: 30px;
        clip-path: polygon(0% 0%, 100% 0%, 50% 100%);
        background: linear-gradient(to bottom, #000 33.3%, #FF0000 33.3%, #FF0000 66.6%, #FFCC00 66.6%);
        transform-origin: top center;
        animation: flagSwing 3s ease-in-out infinite;
      }
      .flag:nth-child(even) { animation-delay: 0.5s; }
      @keyframes flagSwing {
        0%, 100% { transform: rotate(-5deg); }
        50% { transform: rotate(5deg); }
      }

      .logo-floating {
        animation: float-logo 3s ease-in-out infinite;
        display: inline-block;
      }
      @keyframes float-logo { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-5px); } }

      .text-glow { text-shadow: 0 4px 6px rgba(242, 183, 5, 0.2); }
    </style>
  </head>
  <body class="antialiased overflow-x-hidden">
    
    <div class="flag-container">
        <div class="flag"></div><div class="flag"></div><div class="flag"></div><div class="flag"></div>
        <div class="flag"></div><div class="flag"></div><div class="flag"></div><div class="flag"></div>
    </div>

    <nav class="fixed w-full z-[100] nav-blur border-b border-white/50 transition-all duration-300">
      <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex-1">
          <a href="index.php" class="inline-block group logo-floating">
            <div class="flex items-center gap-2">
              <div class="bg-gold text-white font-black px-2 py-1 rounded-lg text-sm shadow-lg">EV</div>
              <div><h1 class="text-xl md:text-2xl font-extrabold text-gold italic tracking-tighter leading-none text-glow">Eduventure Abroad</h1></div>
            </div>
          </a>
        </div>

        <div class="hidden md:flex flex-[2] justify-center items-center">
          <div class="bg-white/50 px-8 py-2 rounded-full border border-white/80 shadow-sm flex space-x-8 text-sm font-bold text-slate-600">
            <a href="index.php" class="hover:text-gold transition-all">Home</a>
            <a href="profil.php" class="text-gold transition-all">Profil</a>
            <a href="program.php" class="hover:text-gold transition-all">Program</a>
            <a href="galeri.php" class="hover:text-gold transition-all">Galeri</a>
            <a href="testimoni.php" class="hover:text-gold transition-all">Testimoni</a>
          </div>
        </div>

        <div class="flex-1 flex justify-end items-center gap-3">
          <a href="javascript:void(0)" onclick="openWaModal()" class="wa-bounce text-white p-2.5 md:px-5 md:py-2.5 rounded-full flex items-center gap-2 hover:scale-105 transition-all shadow-lg">
            <i class="fa-brands fa-whatsapp text-xl"></i>
            <span class="text-xs font-extrabold uppercase hidden lg:block font-bold">Halo Kak!</span>
          </a>
          <button id="openMenu" class="md:hidden w-11 h-11 flex items-center justify-center bg-red-50 text-gold rounded-2xl active:scale-90 transition-all">
            <i class="fa-solid fa-bars-staggered text-xl"></i>
          </button>
        </div>
      </div>
    </nav>

    <header class="relative pt-48 pb-24 min-h-[70vh] flex items-center justify-center overflow-hidden bg-slate-900 text-white">
      <video autoplay muted loop playsinline preload="auto" poster="gambar_profil/profil1.jpeg" class="absolute top-0 left-0 w-full h-full object-cover">
        <source src="vidio_profil/profil.mp4" type="video/mp4" />
      </video>
      <div class="overlay-video absolute top-0 left-0 w-full h-full bg-slate-900/60 backdrop-blur-[2px]"></div>
      <div class="container mx-auto px-6 text-center relative">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 uppercase tracking-tighter italic drop-shadow-2xl" data-aos="fade-down">Kenali Kami</h1>
        <div class="w-24 h-2 bg-gold mx-auto rounded-full mb-8 shadow-lg"></div>
        <p class="text-white max-w-2xl mx-auto italic text-lg leading-relaxed drop-shadow-md" data-aos="fade-up">"Yuk, mulai perjalananmu ke Jerman bersama Eduventure"</p>
      </div>
    </header>

    <section class="py-28 bg-white overflow-hidden">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap items-center">
          <div class="w-full md:w-1/2 relative p-4 md:pr-12" data-aos="fade-right">
            <div class="img-accent relative">
              <img src="gambar_profil/profil1.jpeg" class="rounded-[3.5rem] shadow-2xl border-4 border-white w-full h-[500px] object-cover" alt="Eduventure" />
            </div>
            <div class="absolute -bottom-8 -right-4 bg-gold p-8 rounded-[2.5rem] shadow-2xl text-white text-center" data-aos="zoom-in">
              <span class="block text-5xl font-black tracking-tighter">04+</span>
              <span class="text-[10px] uppercase font-extrabold tracking-widest opacity-80">Tahun Eduventure</span>
            </div>
          </div>

          <div class="w-full md:w-1/2 md:pl-16 mt-24 md:mt-0" data-aos="fade-left">
            <?php 
              $teks = explode("||", $data_profil['deskripsi'] ?? '');
              $sub  = explode("||", $data_profil['judul_program'] ?? '');
              $judul_utama = !empty($data_profil['judul']) ? $data_profil['judul'] : 'Inovasi Eduventure Sejak 2023.';
              $desc_umum   = !empty($teks[0]) ? $teks[0] : 'Eduventure adalah lembaga kursus bahasa Jerman yang menghadirkan pembelajaran terstruktur dan humanis untuk membantu peserta menguasai bahasa Jerman secara komunikatif and aplikatif di era global.';
              $visi_judul  = !empty($sub[0]) ? $sub[0] : 'Visi Kami';
              $visi_isi    = !empty($teks[1]) ? $teks[1] : 'Menjadi program kursus bahasa Jerman yang unggul dan inklusif dalam membekali peserta dengan kemampuan bahasa Jerman yang komunikatif, aplikatif, dan berdaya saing global.';
              $misi_judul  = !empty($sub[1]) ? $sub[1] : 'Misi Kami';
              $misi_isi    = !empty($teks[2]) ? $teks[2] : 'Memberikan pengalaman belajar bahasa Jerman yang relevan dan aplikatif melalui metode adaptif dan pendampingan pengajar berkompeten.';
            ?>
            <span class="text-gold font-black uppercase text-xs tracking-widest mb-4 block">Our Journey</span>
            <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tighter leading-tight"><?= $judul_utama ?></h3>
            <p class="text-slate-500 mb-8 text-lg leading-relaxed"><?= nl2br($desc_umum) ?></p>

            <div class="grid grid-cols-1 gap-6">
              <div class="p-8 bg-red-50/30 rounded-[2rem] border-l-8 border-gold shadow-sm">
                <h4 class="font-bold text-xl text-slate-900 mb-2 italic"><?= $visi_judul ?></h4>
                <p class="text-slate-500"><?= nl2br($visi_isi) ?></p>
              </div>
              <div class="p-8 bg-red-50/30 rounded-[2rem] border-l-8 border-gold shadow-sm">
                <h4 class="font-bold text-xl text-slate-900 mb-2 italic"><?= $misi_judul ?></h4>
                <p class="text-slate-500"><?= nl2br($misi_isi) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-24 bg-red-50/20 overflow-hidden text-center">
      <div class="container mx-auto px-6">
        <span class="text-gold font-black uppercase text-xs tracking-widest mb-4 block">Roadmap</span>
        <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 italic tracking-tighter mb-20">PETA PERJALANAN KAMI</h2>
        <div class="relative max-w-4xl mx-auto">
          <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-red-600/20 rounded-full"></div>

          <div class="relative mb-24 flex items-center justify-center md:justify-start" data-aos="fade-up">
            <div class="hidden md:block md:w-1/2"></div>
            <div class="z-20 w-12 h-12 bg-gold rounded-2xl rotate-45 flex items-center justify-center shadow-lg absolute left-1/2 transform -translate-x-1/2"><i class="fa-solid fa-star text-white -rotate-45 text-sm"></i></div>
            <div class="md:w-1/2 md:pl-12">
              <div class="bg-white p-8 rounded-3xl shadow-xl border-t-4 border-gold text-left">
                <span class="text-gold font-black text-2xl">2025 - 2026</span>
                <h4 class="font-bold text-lg text-slate-900 mt-2 italic uppercase">Digital Ecosystem</h4>
                <p class="text-slate-500 text-sm mt-2">Eduventure mengembangkan sistem pembelajaran terintegrasi untuk mendukung kesiapan kerja dan magang ke Jerman.</p>
              </div>
            </div>
          </div>

          <div class="relative mb-24 flex items-center justify-center md:justify-end" data-aos="fade-up">
            <div class="md:w-1/2 md:pr-12">
              <div class="bg-white p-8 rounded-3xl shadow-xl border-t-4 border-gold text-left">
                <span class="text-gold font-black text-2xl">2024</span>
                <h4 class="font-bold text-lg text-slate-900 mt-2 italic uppercase">Collaboration Era</h4>
                <p class="text-slate-500 text-sm mt-2">Eduventure memperkuat pendampingan peserta melalui kolaborasi mentor dan mitra profesional.</p>
              </div>
            </div>
            <div class="z-20 w-12 h-12 bg-slate-900 rounded-2xl rotate-45 flex items-center justify-center shadow-lg absolute left-1/2 transform -translate-x-1/2"><i class="fa-solid fa-users text-gold -rotate-45 text-sm"></i></div>
            <div class="hidden md:block md:w-1/2"></div>
          </div>

          <div class="relative mb-24 flex items-center justify-center md:justify-start" data-aos="fade-up">
            <div class="hidden md:block md:w-1/2"></div>
            <div class="z-20 w-12 h-12 bg-gold rounded-2xl rotate-45 flex items-center justify-center shadow-lg absolute left-1/2 transform -translate-x-1/2"><i class="fa-solid fa-earth-europe text-white -rotate-45 text-sm"></i></div>
            <div class="md:w-1/2 md:pl-12">
              <div class="bg-white p-8 rounded-3xl shadow-xl border-t-4 border-gold text-left">
                <span class="text-gold font-black text-2xl">2023</span>
                <h4 class="font-bold text-lg text-slate-900 mt-2 italic uppercase">The Inception</h4>
                <p class="text-slate-500 text-sm mt-2">Eduventure didirikan sebagai lembaga kursus Bahasa Jerman dan persiapan kerja serta magang ke Jerman.</p>
              </div>
            </div>
          </div>
        </div>
    </section>

    <footer class="bg-white border-t border-red-50 pt-24 pb-12">
      <div class="container mx-auto px-6 text-center md:text-left">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-20 items-start">
          <div>
            <h3 class="text-3xl font-black text-gold italic mb-6 uppercase">EDUVENTURE ABROAD</h3>
            <div class="flex justify-center md:justify-start gap-4">
              <a href="https://www.tiktok.com/@eduventure.abroad" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 transition-all"><i class="fa-brands fa-tiktok text-xl"></i></a>
              <a href="https://www.facebook.com/profile.php?id=61572385726736" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 transition-all"><i class="fa-brands fa-facebook-f text-xl"></i></a>
              <a href="https://www.instagram.com/eduventureabroad" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 transition-all"><i class="fa-brands fa-instagram text-xl"></i></a>
            </div>
          </div>
          <div class="flex flex-col items-center justify-center"><h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Lokasi Kami</h4><a href="https://maps.app.goo.gl/GVthAecFrcdNkA237?g_st=aw" target="_blank" class="flex flex-col items-center gap-3 text-gold hover:scale-110 transition-all group"><div class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center shadow-lg group-hover:bg-gold group-hover:text-white transition-all"><i class="fa-solid fa-map-location-dot text-4xl"></i></div><span class="font-black italic text-sm uppercase">BUKA GOOGLE MAPS</span></a></div>
          <div class="text-center md:text-right"><h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Email Kami</h4><p class="text-slate-500 text-sm font-bold">abroadeduventure@gmail.com</p></div>
        </div>
        <div class="pt-10 border-t border-red-50 text-center"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">© 2023 Eduventure Abroad</p></div>
      </div>
    </footer>

    <div id="waModal" class="fixed inset-0 z-[300] hidden items-center justify-center px-4">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeWaModal()"></div>
      <div id="waModalContent" class="bg-white rounded-[2rem] p-8 w-full max-w-sm relative z-10 shadow-2xl transform transition-all scale-95 opacity-0">
        <h3 class="text-2xl font-black text-slate-900 mb-6 text-center italic">Hubungi Admin Kami</h3>
        <div class="flex flex-col gap-4 text-left">
          <a href="https://wa.me/628886836298" target="_blank" class="flex items-center gap-4 p-4 rounded-2xl bg-red-50 hover:bg-red-100 transition-all group">
            <div class="w-12 h-12 bg-[#25D366] rounded-xl flex items-center justify-center text-white"><i class="fa-brands fa-whatsapp text-2xl"></i></div>
            <div><p class="font-bold">Admin 1</p><p class="text-xs">+62 888-6836-298</p></div>
          </a>
          <a href="https://wa.me/6285786364389" target="_blank" class="flex items-center gap-4 p-4 rounded-2xl bg-red-50 hover:bg-red-100 transition-all group">
            <div class="w-12 h-12 bg-[#25D366] rounded-xl flex items-center justify-center text-white"><i class="fa-brands fa-whatsapp text-2xl"></i></div>
            <div><p class="font-bold">Admin 2</p><p class="text-xs">+62 857-8636-4389</p></div>
          </a>
        </div>
        <button onclick="closeWaModal()" class="mt-8 w-full py-3 text-slate-400 font-bold uppercase text-sm">Batal</button>
      </div>
    </div>

    <div id="mobileMenu" class="fixed inset-0 z-[200] invisible opacity-0 transition-all duration-500">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xl"></div>
      <div id="menuContent" class="absolute right-0 top-0 w-full h-full bg-white shadow-2xl translate-x-full transition-transform duration-500 p-10 flex flex-col">
        <div class="flex justify-between items-center mb-16">
          <div class="italic font-black text-2xl text-gold">Eduventure</div>
          <button id="closeMenu" class="w-12 h-12 flex items-center justify-center bg-slate-100 rounded-2xl text-slate-500 active:rotate-90 transition-all"><i class="fa-solid fa-xmark text-2xl"></i></button>
        </div>
        <div class="flex flex-col gap-8 text-left">
          <a href="index.php" class="text-4xl font-black text-slate-900 group">Home</a>
          <a href="profil.php" class="text-4xl font-black text-gold italic group">Profil</a>
          <a href="program.php" class="text-4xl font-black text-slate-900 group">Program</a>
          <a href="galeri.php" class="text-4xl font-black text-slate-900 group">Galeri</a>
          <a href="testimoni.php" class="text-4xl font-black text-slate-900 group">Testimoni</a>
          <a href="https://maps.app.goo.gl/GVthAecFrcdNkA237?g_st=aw" target="_blank" class="text-4xl font-black text-gold bg-red-50 p-4 rounded-2xl border-2 border-red-200 flex justify-between items-center">Lokasi Maps <i class="fa-solid fa-location-dot animate-bounce"></i></a>
        </div>
        <div class="mt-auto pt-10 border-t border-slate-100 flex flex-col gap-6">
          <div class="flex gap-4">
            <a href="https://www.tiktok.com/@eduventure.abroad" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600"><i class="fa-brands fa-tiktok text-xl"></i></a>
            <a href="https://www.facebook.com/profile.php?id=61572385726736" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600"><i class="fa-brands fa-facebook-f text-xl"></i></a>
            <a href="https://www.instagram.com/eduventureabroad" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600"><i class="fa-brands fa-instagram text-xl"></i></a>
            <a href="javascript:void(0)" onclick="openWaModal()" class="w-12 h-12 rounded-2xl bg-[#25D366] text-white flex items-center justify-center"><i class="fa-brands fa-whatsapp text-xl"></i></a>
          </div>
          <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">© 2023 Eduventure Abroad</p>
        </div>
      </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({ once: true });

      window.addEventListener("scroll", () => {
        const nav = document.querySelector("nav");
        if (window.scrollY > 50) nav.classList.add("py-2", "shadow-xl");
        else nav.classList.remove("py-2", "shadow-xl");
      });

      const openBtn = document.getElementById("openMenu");
      const closeBtn = document.getElementById("closeMenu");
      const mobileMenu = document.getElementById("mobileMenu");
      const menuContent = document.getElementById("menuContent");

      /* LOGIKANYA TETAP SAMA DENGAN KODE ASLI */
      openBtn.onclick = () => { 
        mobileMenu.classList.remove("invisible", "opacity-0"); 
        mobileMenu.classList.add("visible", "opacity-100"); 
        menuContent.classList.remove("translate-x-full"); 
      };
      
      closeBtn.onclick = () => { 
        menuContent.classList.add("translate-x-full"); 
        mobileMenu.classList.replace("opacity-100", "opacity-0"); 
        setTimeout(() => mobileMenu.classList.add("invisible"), 500); 
      };
      
      function openWaModal() { 
        document.getElementById("waModal").classList.replace("hidden", "flex"); 
        setTimeout(() => { 
            document.getElementById("waModalContent").classList.replace("opacity-0", "opacity-100"); 
            document.getElementById("waModalContent").classList.replace("scale-95", "scale-100"); 
        }, 10); 
      } 
      
      function closeWaModal() { 
        document.getElementById("waModalContent").classList.replace("scale-100", "scale-95"); 
        document.getElementById("waModalContent").classList.replace("opacity-100", "opacity-0"); 
        setTimeout(() => document.getElementById("waModal").classList.add("hidden"), 300); 
      }
    </script>
  </body>
</html>