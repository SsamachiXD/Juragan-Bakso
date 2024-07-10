<?php

?>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div style="background-color:#ff852e;">
<section class="menu-template" id="id-menu">
  <h1 class="menu-title">This is</h1><br>
  <center><h3 class="menu-subtitle">O U R &nbsp;&nbsp;M E N U</h3></center>
</section><br><br>

<section class="menu" style="display: inline;">
    <div style="clear: both;"></div>
    <br>
  </section>
  <section class="menu" style="display: inline;">
    <!-- first column -->
    <!-- Menu Bakso Urat -->
<article class="menu-section">
  <div class="menu-flip-card">
    <div class="menu-flip-card-inner">
      <div class="menu-flip-card-front">
        <img src="folder gambar/bakso urat.jpg" alt="Avatar" class="menu-image">
      </div>
      <div class="menu-flip-card-back">
        <div class="menu-text">
          <h3 class="menu-text-title">Bakso Urat</h3>
          <p class="about-text">
            Bakso urat adalah variasi bakso yang terkenal di Indonesia, dikenal karena teksturnya yang khas.
          </p>
          <h3 class="menu-text-title">Rp25.000</h3>
          <!-- Form Pemesanan -->
          <form class="order-form">
            <label for="quantity-bakso-urat">Jumlah pesanan:</label>
            <input type="number" id="quantity-bakso-urat" name="quantity" min="1" max="100" value="1">
            <button type="submit" class="order-button">Pesan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</article>


    <!-- second column -->
    <article class="menu-section">
      <div class="menu-flip-card">
        <div class="menu-flip-card-inner">
          <div class="menu-flip-card-front">
            <img src="folder gambar/bakso telur.jpg" alt="Avatar" class="menu-image">
          </div>
          <div class="menu-flip-card-back">
            <div class="menu-text"><h3 class="menu-text-title">Bakso Telur</h3>
              <p class="about-text">
                Bakso telur adalah jenis bakso yang di dalamnya terdapat telur rebus.   
              </p>
              <h3 class="menu-text-title">Rp30.000</h3>
              <form class="order-form">
                <label for="quantity-bakso-urat">Jumlah Pesanan:</label>
                <input type="number" id="quantity-bakso-urat" name="quantity" min="1" max="100" value="1">
                <button type="submit" class="order-button">Pesan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </article>

    <!-- third column -->
    <article class="menu-section">
      <div class="menu-flip-card">
        <div class="menu-flip-card-inner">
          <div class="menu-flip-card-front">
            <img src="folder gambar/bakso lava.jpg" alt="Avatar" class="menu-image">
          </div>
          <div class="menu-flip-card-back">
            <div class="menu-text"><h3 class="menu-text-title">Bakso Lava</h3>
              <p class="about-text">
                Bakso lava adalah inovasi modern dalam dunia bakso dan banyak peminatnya. 
              </p>
              <h3 class="menu-text-title">Rp35.000</h3>
              <form class="order-form">
                <label for="quantity-bakso-urat">Jumlah Pesanan:</label>
                <input type="number" id="quantity-bakso-urat" name="quantity" min="1" max="100" value="1">
                <button type="submit" class="order-button">Pesan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </article>

    <!-- fourth column -->
    <article class="menu-section">
      <div class="menu-flip-card">
        <div class="menu-flip-card-inner">
          <div class="menu-flip-card-front">
            <img src="folder gambar/bakso iga.jpg" alt="Avatar" class="menu-image">
          </div>
          <div class="menu-flip-card-back">
            <div class="menu-text"><h3 class="menu-text-title">Bakso Iga Sapi</h3>
              <p class="about-text">
                Bakso iga sapi adalah bakso yang menggunakan iga sapi sebagai bahan utamanya, selain daging sapi giling.
              </p>
              <h3 class="menu-text-title">Rp40.000</h3>
              <form class="order-form">
                <label for="quantity-bakso-urat">Jumlah Pesanan:</label>
                <input type="number" id="quantity-bakso-urat" name="quantity" min="1" max="100" value="1">
                <button type="submit" class="order-button">Pesan</button>
              </form>
        </div>
      </div>
    </div>
  </div>
</article>

    <div style="clear: both;"></div>
    <br>
  </section>
  <br>

</div>
</body>
</html>