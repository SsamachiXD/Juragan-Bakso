<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "juragan_bakso";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $pesanan = $_POST['pesanan'];

    $sql = "UPDATE orders SET nama='$nama', alamat='$alamat', telepon='$telepon', pesanan='$pesanan' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Pesanan berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel'])) {
    $id = $_POST['id'];

    $sql = "UPDATE orders SET status='cancelled' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Pesanan berhasil dibatalkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM orders WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Pesanan tidak ditemukan.";
        exit();
    }
} else {
    echo "ID pesanan tidak diberikan.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>View Order</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="order-confirmation">
    <header class="header">
      <section class="main">
        <a class="logo" href="#"><img src="folder gambar/logo.jpg" height="25px" alt="Logo"></a>
        <nav class="fix">
          <a class="a1" href="menu.html">ORDER</a>
          <a class="a1" href="#id-contact">CONTACT US</a>
          <a class="a1" href="#feedback">FEEDBACK</a>
          <a class="a1" href="#id-about">ABOUT US</a>
          <a class="a1" href="#id-menu">MENU</a>
          <a class="a1" href="#">HOME</a>
        </nav>
      </section>
      <div class="banner">
        <h1 class="banner-title">Edit Pesanan Anda</h1>
      </div>
    </header>

    <div class="content-divider"></div>

    <section class="order-details">
      <h2>Rincian Pesanan</h2>
      <form action="view_order.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
        
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required />

        <label for="alamat">Alamat Pengiriman</label>
        <input type="text" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required />

        <label for="telepon">Nomor Telepon</label>
        <input type="tel" id="telepon" name="telepon" value="<?php echo $row['telepon']; ?>" required />

        <label for="pesanan">Pesanan Anda</label>
        <textarea id="pesanan" name="pesanan" style="height:200px" required><?php echo $row['pesanan']; ?></textarea>

        <input type="submit" name="update" value="Perbarui Pesanan" />
        <input type="submit" name="cancel" value="Batalkan Pesanan" />
      </form>
    </section>

    <footer class="footer">
      <p>&copy; 2023 Juragan Bakso.id. All rights reserved.</p>
    </footer>
  </div>
</body>

</html>
