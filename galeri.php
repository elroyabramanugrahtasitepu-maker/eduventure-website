<?php 
// 1. Koneksi ke database agar navigasi menu tetap sinkron
include 'config.php'; 

// AMBIL DATA GALERI DARI DATABASE
$query_galeri = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />  
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Visual Stories | EDUVENTURE ABROAD</title>
    <link rel="icon" type="image/jpeg" href="logo web/logo.png" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap");

      :root {
        /* Tema Imlek: Merah & Emas */
        --primary-red: #d6001c; 
        --accent-gold: #ffb800; 
        --soft-bg: #fff5f5;      
      }
      body {
        font-family: "Plus Jakarta Sans", sans-serif;
        background-color: var(--soft-bg);
      }

      .text-gold { color: var(--primary-red); }
      .bg-gold { background-color: var(--primary-red); }

      .nav-blur {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-b: 2px solid var(--accent-gold);
      }

      @keyframes wa-pulse {
        0% { box-shadow: 0 0 0 0 rgba(214, 0, 28, 0.5); }
        70% { box-shadow: 0 0 0 15px rgba(214, 0, 28, 0); }
        100% { box-shadow: 0 0 0 0 rgba(214, 0, 28, 0); }
      }
      .wa-bounce {
        animation: wa-pulse 2s infinite;
        background-color: var(--primary-red) !important;
      }

      .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 2.5rem;
        cursor: pointer;
        background-color: #f3f3f3;
        border: 2px solid transparent;
        transition: all 0.5s ease;
      }
      .gallery-item:hover {
        border-color: var(--accent-gold);
        transform: scale(1.02);
      }

      .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
          to top,
          rgba(214, 0, 28, 0.9),
          transparent
        );
        display: flex;
        align-items: flex-end;
        padding: 2.5rem;
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(30px);
      }
      .gallery-item:hover .gallery-overlay {
        opacity: 1;
        transform: translateY(0);
      }

      .logo-floating {
        animation: float-logo 3s ease-in-out infinite;
        display: inline-block;
      }
      @keyframes float-logo { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-5px); } }

      /* --- LAMPION NAVBAR --- */
      .lantern-navbar-container {
        position: fixed;
        top: 0;
        width: 100%;
        display: flex;
        justify-content: space-around;
        pointer-events: none;
        z-index: 1002;
      }
      .lantern-item {
        position: relative;
        width: 40px; height: 35px;
        background: var(--primary-red);
        border-radius: 40% / 100%;
        border: 2px solid var(--accent-gold);
        box-shadow: 0 0 15px rgba(214, 0, 28, 0.6), inset 0 0 10px #8b0000;
        animation: swing-lantern 3s ease-in-out infinite;
        transform-origin: top center;
        margin-top: 65px;
      }
      .lantern-item::before { content: ''; position: absolute; top: -65px; left: 50%; width: 2px; height: 65px; background: #444; }
      .lantern-item::after { content: ''; position: absolute; bottom: -15px; left: 50%; width: 3px; height: 15px; background: var(--accent-gold); transform: translateX(-50%); }
      @keyframes swing-lantern { 0%, 100% { transform: rotate(-5deg); } 50% { transform: rotate(5deg); } }

      /* --- EFEK BUNGA MEIHUA --- */
      .flower-container { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
      .flower { position: absolute; background: #ff4d6d; border-radius: 50% 10% 50% 10%; opacity: 0.8; animation: fall linear forwards; }
      @keyframes fall { 0% { transform: translateY(-10vh) rotate(0deg); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0; } }
    </style>
  </head>
  <body class="antialiased overflow-x-hidden">

    <div class="lantern-navbar-container">
        <div class="lantern-item hidden lg:block"></div>
        <div class="lantern-item"></div>
        <div class="lantern-item hidden md:block"></div>
        <div class="lantern-item"></div>
        <div class="lantern-item hidden lg:block"></div>
    </div>
    <div class="flower-container" id="flowerContainer"></div>

    <nav class="fixed w-full z-[100] nav-blur border-b border-white/50 transition-all duration-300">
      <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex-1">
          <a href="index.php" class="inline-block group logo-floating">
            <div class="flex items-center gap-2">
              <div class="bg-gold text-white font-black px-2 py-1 rounded-lg text-sm shadow-lg">EV</div>
              <div>
                <h1 class="text-xl md:text-2xl font-extrabold text-gold italic tracking-tighter leading-none">
                  Eduventure Abroad
                </h1>
              </div>
            </div>
          </a>
        </div>
        <div class="hidden md:flex flex-[2] justify-center items-center">
          <div class="bg-white/50 px-8 py-2 rounded-full border border-white/80 shadow-sm flex space-x-8 text-sm font-bold text-slate-600">
            <a href="index.php" class="hover:text-gold transition-all">Home</a>
            <a href="profil.php" class="hover:text-gold transition-all">Profil</a>
            <a href="program.php" class="hover:text-gold transition-all">Program</a>
            <a href="galeri.php" class="text-gold transition-all">Galeri</a>
            <a href="testimoni.php" class="hover:text-gold transition-all">Testimoni</a>
          </div>
        </div>
        <div class="flex-1 flex justify-end items-center gap-3">
          <a href="javascript:void(0)" onclick="openWaModal()" class="wa-bounce text-white p-2.5 md:px-5 md:py-2.5 rounded-full flex items-center gap-2 hover:scale-105 transition-all shadow-lg">
            <i class="fa-brands fa-whatsapp text-xl"></i>
            <span class="text-xs font-extrabold uppercase tracking-wider hidden lg:block font-bold">Halo Kak!</span>
          </a>
          <button id="openMenu" class="md:hidden w-11 h-11 flex items-center justify-center bg-red-50 text-gold rounded-2xl active:scale-90 transition-all">
            <i class="fa-solid fa-bars-staggered text-xl"></i>
          </button>
        </div>
      </div>
    </nav>

    <header class="pt-48 pb-16">
      <div class="container mx-auto px-6 text-center">
        <span class="inline-block px-4 py-1.5 bg-red-100 text-red-600 rounded-full text-[10px] font-black uppercase tracking-[0.4em] mb-6">Moments</span>
        <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tighter italic" data-aos="fade-up">
          Eduventure <span class="text-gold">Stories</span>
        </h1>
      </div>
    </header>

    <section class="py-12 pb-32">
      <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 auto-rows-[350px]">
          
        <?php 
        $i = 1;
        while($row = mysqli_fetch_assoc($query_galeri)) : 
          $is_large = ($i == 1) ? 'md:col-span-2 md:row-span-2' : '';
          $path_file = "admin/Gambar_edu/" . $row['file_media'];
        ?>

        <div
          class="<?= $is_large ?> gallery-item shadow-xl"
          data-aos="zoom-in"
          data-fancybox="gallery"
          data-src="<?= $path_file ?>"
        >
          <?php if($row['tipe'] == 'video'): ?>   
            <video
              src="<?= $path_file ?>"
              class="w-full h-full object-cover"
              muted
            ></video>
            <div class="gallery-overlay">   
              <i class="fa-solid fa-play text-white text-3xl"></i>
            </div>
          <?php else: ?>
            <img
              src="<?= $path_file ?>"
              class="w-full h-full object-cover transition duration-1000 hover:scale-110"
              alt="Moment"
            />
            <div class="gallery-overlay">
              <div>
                <h4 class="text-white text-3xl font-black italic">
                  <?= htmlspecialchars($row['judul_moment']) ?>
                </h4>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <?php 
          $i++;
        endwhile; 
        ?>

        </div>
      </div>
    </section>

    <div id="mobileMenu" class="fixed inset-0 z-[200] invisible opacity-0 transition-all duration-500">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xl"></div>
      <div id="menuContent" class="absolute right-0 top-0 w-full h-full bg-white shadow-2xl translate-x-full transition-transform duration-500 p-10 flex flex-col">
        <div class="flex justify-between items-center mb-16">
          <div class="italic font-black text-2xl text-gold">Eduventure</div>
          <button id="closeMenu" class="w-12 h-12 flex items-center justify-center bg-slate-100 rounded-2xl text-slate-500 active:rotate-90 transition-all"><i class="fa-solid fa-xmark text-2xl"></i></button>
        </div>
        <div class="flex flex-col gap-8">
          <a href="index.php" class="text-4xl font-black text-slate-900 group">Home</a>
          <a href="profil.php" class="text-4xl font-black text-slate-900 group">Profil</a>
          <a href="program.php" class="text-4xl font-black text-slate-900 group">Program</a>
          <a href="galeri.php" class="text-4xl font-black text-gold italic group">Galeri</a>
          <a href="testimoni.php" class="text-4xl font-black text-slate-900 group">Testimoni</a>
          <a href="https://maps.app.goo.gl/GVthAecFrcdNkA237?g_st=aw" target="_blank" class="text-4xl font-black text-gold bg-red-50 p-4 rounded-2xl border-2 border-red-200 flex justify-between items-center">Lokasi Maps <i class="fa-solid fa-location-dot animate-bounce"></i></a>
        </div>
        <div class="mt-auto pt-10 border-t border-slate-100 flex flex-col gap-6">
          <div class="flex gap-4">
            <a href="https://www.tiktok.com/@eduventure.abroad" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 transition-all"><i class="fa-brands fa-tiktok text-xl"></i></a>
            <a href="https://www.facebook.com/profile.php?id=61572385726736" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 transition-all"><i class="fa-brands fa-facebook-f text-xl"></i></a>
            <a href="https://www.instagram.com/eduventureabroad" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 transition-all"><i class="fa-brands fa-instagram text-xl"></i></a>
            <a href="javascript:void(0)" onclick="openWaModal()" class="w-12 h-12 rounded-2xl bg-[#25D366] text-white flex items-center justify-center shadow-lg"><i class="fa-brands fa-whatsapp text-xl"></i></a>
          </div>
          <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">© 2023 Eduventure Abroad</p>
        </div>
      </div>
    </div>

    <footer class="bg-white border-t border-red-50 pt-24 pb-12">
      <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
          <div>
            <h3 class="text-3xl font-black text-gold italic mb-6 uppercase">EDUVENTURE ABROAD</h3>
            <div class="flex gap-4">
              <a href="https://www.tiktok.com/@eduventure.abroad" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-all"><i class="fa-brands fa-tiktok text-xl"></i></a>
              <a href="https://www.facebook.com/profile.php?id=61572385726736" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-all"><i class="fa-brands fa-facebook-f text-xl"></i></a>
              <a href="https://www.instagram.com/eduventureabroad" target="_blank" class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-all"><i class="fa-brands fa-instagram text-xl"></i></a>
            </div>
          </div>
          <div class="flex flex-col items-center">
            <h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Lokasi Kami</h4>
            <a href="https://maps.app.goo.gl/GVthAecFrcdNkA237?g_st=aw" target="_blank" class="flex flex-col items-center gap-3 text-gold hover:scale-110 transition-all group"><div class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center shadow-lg group-hover:bg-gold group-hover:text-white transition-all"><i class="fa-solid fa-map-location-dot text-4xl"></i></div><span class="font-black italic text-sm">BUKA GOOGLE MAPS</span></a>
          </div>
          <div class="text-center md:text-left"><h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Email Kami</h4><p class="text-slate-500 text-sm font-bold">abroadeduventure@gmail.com</p></div>
      </div>
      <div class="pt-10 border-t border-red-50 text-center mt-10"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">© 2023 Eduventure Abroad - Gong Xi Fa Cai</p></div>
    </footer>

    <div id="waModal" class="fixed inset-0 z-[300] hidden items-center justify-center px-4">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeWaModal()"></div>
      <div id="waModalContent" class="bg-white rounded-[2rem] p-8 w-full max-w-sm relative z-10 shadow-2xl transform transition-all scale-95 opacity-0">
        <h3 class="text-2xl font-black text-slate-900 mb-6 text-center italic">Hubungi Admin Kami</h3>
        <div class="flex flex-col gap-4 text-left">
          <a href="https://wa.me/628886836298" target="_blank" class="flex items-center gap-4 p-4 rounded-2xl bg-red-50 hover:bg-red-100 transition-all group">
            <div class="w-12 h-12 bg-[#25D366] rounded-xl flex items-center justify-center text-white shadow-lg"><i class="fa-brands fa-whatsapp text-2xl"></i></div>
            <div><p class="font-bold">Admin 1</p><p class="text-xs">+62 888-6836-298</p></div>
          </a>
          <a href="https://wa.me/6285786364389" target="_blank" class="flex items-center gap-4 p-4 rounded-2xl bg-red-50 hover:bg-red-100 transition-all group">
            <div class="w-12 h-12 bg-[#25D366] rounded-xl flex items-center justify-center text-white shadow-lg"><i class="fa-brands fa-whatsapp text-2xl"></i></div>
            <div><p class="font-bold">Admin 2</p><p class="text-xs">+62 857-8636-4389</p></div>
          </a>
        </div>
        <button onclick="closeWaModal()" class="mt-8 w-full py-3 text-slate-400 font-bold uppercase text-sm">Batal</button>
      </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({ once: true });
      Fancybox.bind("[data-fancybox]", { loop: true });

      const flowerContainer = document.getElementById('flowerContainer');
      function createFlower() {
        const flower = document.createElement('div'); flower.classList.add('flower');
        flower.style.left = Math.random() * 100 + 'vw';
        flower.style.width = flower.style.height = (Math.random() * 8 + 8) + 'px';
        flower.style.animationDuration = (Math.random() * 5 + 5) + 's';
        flowerContainer.appendChild(flower);
        setTimeout(() => flower.remove(), 6000);
      }
      setInterval(createFlower, 350);

      window.addEventListener("scroll", () => {
        const nav = document.querySelector("nav");
        if (window.scrollY > 50) nav.classList.add("py-2", "shadow-xl");
        else nav.classList.remove("py-2", "shadow-xl");
      });

      const openBtn = document.getElementById("openMenu");
      const closeBtn = document.getElementById("closeMenu");
      const mobileMenu = document.getElementById("mobileMenu");
      const menuContent = document.getElementById("menuContent");
      openBtn.onclick = () => { mobileMenu.classList.remove("invisible", "opacity-0"); mobileMenu.classList.add("visible", "opacity-100"); menuContent.classList.remove("translate-x-full"); };
      closeBtn.onclick = () => { menuContent.classList.add("translate-x-full"); mobileMenu.classList.replace("opacity-100", "opacity-0"); setTimeout(() => mobileMenu.classList.add("invisible"), 500); };
      
      function openWaModal() { document.getElementById("waModal").classList.replace("hidden", "flex"); setTimeout(() => { document.getElementById("waModalContent").classList.replace("opacity-0", "opacity-100"); document.getElementById("waModalContent").classList.replace("scale-95", "scale-100"); }, 10); } 
      function closeWaModal() { document.getElementById("waModalContent").classList.replace("scale-100", "scale-95"); document.getElementById("waModalContent").classList.replace("opacity-100", "opacity-0"); setTimeout(() => document.getElementById("waModal").classList.add("hidden"), 300); }
    </script>
  </body>
</html>