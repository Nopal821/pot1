<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>JerseyStore</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Montserrat:wght@400;600&display=swap');
    *{box-sizing:border-box;scroll-behavior:smooth;margin:0;padding:0}
    body{font-family:'Montserrat',sans-serif;background:#0f1117;color:#e0e0e0;line-height:1.6;}
    header{position:fixed;top:0;width:100%;z-index:1000;
      background:rgba(16,20,28,0.9);backdrop-filter:blur(6px);
      display:flex;justify-content:space-between;align-items:center;
      padding:18px 40px;box-shadow:0 4px 12px rgba(0,0,0,0.6);}
    header h1{font-family:'Merriweather',serif;color:#fdd835;letter-spacing:2px;}
    header nav a{color:#cddff9;text-decoration:none;margin-left:24px;
      position:relative;font-weight:500;transition:color .3s}
    header nav a::after{content:"";position:absolute;left:0;bottom:-4px;
      width:0;height:2px;background:#fdd835;transition:width .3s}
    header nav a:hover{color:#fdd835}
    header nav a:hover::after{width:100%}

    main{padding-top:90px;}

    /* Hero fullscreen dengan parallax */
    .hero{height:100vh;background:url('https://images.unsplash.com/photo-1521412644187-c49fa049e84d?auto=format&fit=crop&w=1470&q=80') center/cover fixed;
      display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;
      color:#fff;position:relative;overflow:hidden;}
    .hero::before{content:"";position:absolute;inset:0;
      background:linear-gradient(to bottom,rgba(0,0,0,0.6),rgba(0,0,0,0.9));}
    .hero h2{position:relative;font-family:'Merriweather',serif;font-size:4rem;opacity:0;
      transform:translateY(20px);animation:fadeInUp 1s ease-out .5s forwards;}
    .hero p{position:relative;font-size:1.25rem;margin-top:12px;opacity:0;
      transform:translateY(20px);animation:fadeInUp 1s ease-out .8s forwards;}
    .hero .btn{position:relative;margin-top:24px;background:#fdd835;color:#212121;
      padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:700;
      opacity:0;transform:scale(.95);animation:popIn .6s ease-out 1.2s forwards;}

    /* Floating filter panel */
    .filter-panel{position:fixed;top:50%;right:24px;transform:translateY(-50%);
      background:rgba(16,20,28,0.8);backdrop-filter:blur(4px);
      padding:16px;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,0.6);
      opacity:0;pointer-events:none;transition:opacity .5s;}
    .filter-panel.visible{opacity:1;pointer-events:auto;}
    .filter-panel h4{margin-bottom:8px;color:#fdd835;}
    .filter-panel label{display:block;margin:8px 0;font-size:.9rem;}

    .container{max-width:1140px;margin:auto;padding:80px 24px;}

    .section-title{font-family:'Merriweather',serif;font-size:2.6rem;
      margin-bottom:32px;text-align:center;color:#fff;position:relative;}
    .section-title::after{content:"";position:absolute;bottom:-8px;left:50%;
      transform:translateX(-50%);width:80px;height:4px;background:#fdd835;border-radius:2px;}

    /* Asymmetric grid */
    .catalog-grid{display:grid;grid-template-columns:2fr 1fr 1fr;grid-auto-rows:200px;gap:16px;}
    .catalog-grid .large{grid-column:span 2;grid-row:span 2;}
    .catalog-grid img{width:100%;height:100%;object-fit:cover;border-radius:8px;
      transition:transform .3s;}
    .catalog-grid img:hover{transform:scale(1.05);}

    /* Rekomendasi – simple carousel row */
    .recommendations{display:flex;overflow-x:auto;gap:16px;padding-bottom:8px;}
    .recommendations .item{flex:0 0 280px;background:#202736;border-radius:8px;overflow:hidden;}
    .recommendations img{width:100%;height:160px;object-fit:cover;}
    .recommendations .info{padding:12px;text-align:center;}
    
    /* Testimoni & editorial dengan parallax */
    .parallax{background-attachment:fixed;background-size:cover;background-position:center;}
    .testi{background:#10141c;padding:80px 24px;text-align:center;}
    .testi blockquote{font-style:italic;color:#ddd;max-width:700px;margin:auto;
      opacity:0;transform:translateY(20px);animation:fadeInUp 1s ease-out .5s forwards;}
    .testi p{margin-top:16px;font-weight:600;color:#fdd835;}

    .editorial{background:url('https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&w=1470&q=80') center/cover fixed;
      padding:120px 24px;color:#fff;text-align:center;}
    .editorial h3{font-family:'Merriweather',serif;font-size:3rem;opacity:0;
      transform:translateY(20px);animation:fadeInUp 1s ease-out .6s forwards;}
    .editorial p{max-width:700px;margin:24px auto;opacity:0;
      transform:translateY(20px);animation:fadeInUp 1s ease-out .9s forwards;}

    /* Mega Footer */
    footer{background:#10141c;color:#aaa;padding:80px 24px;}
    .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:24px;max-width:1140px;margin:auto;}
    .social-feed{display:flex;gap:12px;overflow-x:auto;}
    .social-feed img{width:80px;height:80px;object-fit:cover;border-radius:4px;}
    .newsletter{background:rgba(255,255,255,0.05);backdrop-filter:blur(8px);
      padding:16px;border-radius:8px;}
    .newsletter input{width:100%;padding:8px;margin:8px 0;border:none;border-radius:4px;}
    .newsletter button{padding:8px 16px;border:none;background:#fdd835;color:#212121;
      border-radius:4px;cursor:pointer;}
    .brand-info p{font-size:.9rem;line-height:1.4;}

    /* Animations */
    @keyframes fadeInUp{to{opacity:1;transform:translateY(0)}}
    @keyframes popIn{to{opacity:1;transform:scale(1)}}
    
    @media(max-width:768px){
      .catalog-grid{grid-template-columns:1fr;grid-auto-rows:180px;}
      .footer-grid{grid-template-columns:1fr;rows: auto;}
      .filter-panel{display:none;}
    }
  </style>
</head>
<body>
  <header>
    <h1>JerseyStore</h1>
    <nav>
      <a href="#home">Home</a>
      <a href="#catalog">Katalog</a>
      <a href="#rekomendasi">Rekomendasi</a>
      <a href="#testi">Testi</a>
      <a href="#editorial">Story</a>
      <a href="#hubungi">Hubungi</a>
    </nav>
  </header>

  <div class="filter-panel" id="filter">
    <h4>Filter Kategori</h4>
    <label><input type="checkbox"> Bola</label>
    <label><input type="checkbox"> Basket</label>
    <label><input type="checkbox"> Futsal</label>
  </div>

  <main>
    <!-- Hero -->
    <section id="home" class="hero">
      <h2>Elite Performance Kit</h2>
      <p>• Precision Tailored • Dramatic Lighting •</p>
      <a href="#catalog" class="btn">Explore Katalog</a>
    </section>

    <!-- Katalog -->
    <section id="catalog" class="container">
      <h2 class="section-title">Katalog Produk</h2>
      <div class="catalog-grid">
        <img src="https://i.pinimg.com/736x/68/55/4c/68554cfe5024044a7845148143169ec9.jpg" class="large fade-in">
        <img src="https://i.pinimg.com/736x/04/e1/29/04e129e0db06c1663731d5d4d66ec231.jpg" class="fade-in">
        <img src="https://i.pinimg.com/736x/79/3a/62/793a6208ccfbae7057874c7530f16b34.jpg" class="fade-in">
        <img src="https://via.placeholder.com/600x400" class="large fade-in">
        <img src="https://via.placeholder.com/300x300" class="fade-in">
        <img src="https://via.placeholder.com/300x500" class="fade-in">
      </div>
    </section>

    <!-- Rekomendasi -->
    <section id="rekomendasi" class="container">
      <h2 class="section-title">Rekomendasi</h2>
      <div class="recommendations">
        <div class="item fade-in">
          <img src="https://i.pinimg.com/736x/68/55/4c.jpg" alt="">
          <div class="info"><strong>Jersey Barcelona</strong></div>
        </div>
        <div class="item fade-in">
          <img src="https://i.pinimg.com/736x/68/55/4c.jpg" alt="">
          <div class="info"><strong>Jersey Manutd</strong></div>
        </div>
        <div class="item fade-in">
          <img src="https://i.pinimg.com/736x/79/3a/62.jpg" alt="">
          <div class="info"><strong>Jersey RealMadrid</strong></div>
        </div>
      </div>
    </section>

    <!-- Desain -->
    <section id="desain" class="container">
      <h3 class="section-title">Desain</h3>
      <p style="max-width:600px;margin:auto;">
        Kami menyajikan desain kontemporer dan timeless—tiap garis, tiap warna, dipilih dengan presisi.
      </p>
    </section>

    <!-- Order -->
    <section id="order" class="container">
      <h3 class="section-title">Cara Order</h3>
      <ol style="max-width:600px;margin:auto;line-height:1.6;">
        <li>Kirim permintaan desain atau pilih dari koleksi kami.</li>
        <li>Sertakan ukuran & jumlah, lalu hubungi via WhatsApp.</li>
        <li>Produksi: 7–10 hari kerja dengan quality control ketat.</li>
        <li>Pengiriman ke seluruh Indonesia, packing eksklusif.</li>
      </ol>
    </section>

    <!-- Harga -->
    <section id="harga" class="container">
      <h3 class="section-title">Harga</h3>
      <ul style="max-width:600px;margin:auto;line-height:1.8;">
        <li><span class="price">Rp 120.000</span> – Jersey polos premium.</li>
        <li><span class="price">Rp 150.000</span> – Custom printing full color.</li>
        <li><span class="price">Rp 180.000</span> – Set jersey + celana.</li>
      </ul>
    </section>

    <!-- Spesifikasi -->
    <section id="spesifikasi" class="container">
      <h3 class="section-title">Spesifikasi Bahan</h3>
      <p style="max-width:600px;margin:auto;line-height:1.6;">
        Bahan Dry-Fit anti-bau, cepat kering, elastis, dan breathable—dirancang untuk performa puncak.
      </p>
    </section>

    <!-- Portofolio -->
    <section id="portofolio" class="container">
      <h3 class="section-title">Portofolio</h3>
      <div class="grid">
        <div class="card">
          <img src="https://i.pinimg.com/736x/68/55/4c/68554cfe5024044a7845148143169ec9.jpg" alt="Barcelona">
          <div class="card-body"><h4>Barcelona</h4></div>
        </div>
        <div class="card">
          <img src="https://i.pinimg.com/736x/04/e1/29/04e129e0db06c1663731d5d4d66ec231.jpg" alt="Man United">
          <div class="card-body"><h4>Man United</h4></div>
        </div>
        <div class="card">
          <img src="https://i.pinimg.com/736x/79/3a/62/793a6208ccfbae7057874c7530f16b34.jpg" alt="Real Madrid">
          <div class="card-body"><h4>Real Madrid</h4></div>
        </div>
      </div>
    </section>

    <!-- Testi -->
    <section id="testi" class="container">
      <h3 class="section-title">Testimoni</h3>
      <blockquote>
        “Setiap jahitan, setiap detail—sungguh menggambarkan dedikasi mereka. Layak untuk tim profesional.”
        <br><strong>– Budi, Jakarta</strong>
      </blockquote>
    </section>

    <!-- Editorial -->
    <section id="editorial" class="editorial">
      <h3>Behind The Craft</h3>
      <p>Eksplorasi proses kreatif di balik setiap jahitan—dari konsep hingga realisasi. Temukan cerita di balik label.</p>
    </section>

    <!-- Hubungi -->
    <section id="hubungi" class="container">
      <h3 class="section-title">Hubungi Kami</h3>
      <p style="text-align:center;line-height:1.6;max-width:500px;margin:auto;">
        📱 <a href="https://wa.me/62XXXXXXXXXX" target="_blank">+62 XXXXXXXXXX</a><br>
        ✉️ jerseysupport@store.id<br>
        📍 Bandung, Indonesia
      </p>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-grid">
      <div class="social-feed">
        <img src="https://via.placeholder.com/80" alt="">
        <img src="https://via.placeholder.com/80" alt="">
        <img src="https://via.placeholder.com/80" alt="">
        <img src="https://via.placeholder.com/80" alt="">
        <img src="https://via.placeholder.com/80" alt="">
      </div>
      <div class="newsletter">
        <h4>Langganan Newsletter</h4>
        <input type="email" placeholder="Email Anda">
        <button>Subscribe</button>
      </div>
      <div class="brand-info">
        <h4>JerseyStore</h4>
        <p>Butik jersey premium dengan komitmen pada presisi, inovasi, dan estetika. Setiap produk kami adalah karya seni olahraga.</p>
      </div>
    </div>
  </footer>

  <script>
    const fp=document.getElementById('filter'),
          cards=document.querySelectorAll('.fade-in');
    window.addEventListener('scroll',()=>{
      const y=window.scrollY;
      if(y>300) fp.classList.add('visible'); else fp.classList.remove('visible');
      cards.forEach(el=>{
        const rect=el.getBoundingClientRect();
        if(rect.top<window.innerHeight-100) el.classList.add('visible');
      });
    });
  </script>
</body>
</html>
