<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "bakso_order";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$order_id = $_GET['order_id'] ?? '';

if ($order_id) {
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        $stmt = $pdo->prepare('SELECT * FROM order_items WHERE order_id = ?');
        $stmt->execute([$order_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Order not found.";
        exit;
    }
} else {
    echo "Invalid order ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Konfirmasi Pesanan</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <header class="header">
        <section class="main">
            <a class="logo" href="#"><img src="folder gambar/logo.jpg" alt="Logo"></a>
            <div class="fix">
                <a class="a1" href="index.html">HOME <i class="bx bx-home"></i></a>
            </div>
        </section>
    </header>

    <div>
        <section class="menu-template" id="id-menu">
            <center>
                <h3 class="menu-subtitle">JURAGAN &nbsp;&nbsp;BAKSO.ID</h3>
            </center>
        </section>

        <section class="order-summary">
            <h2>Detail Pesanan</h2>
            <p>Nama: <?= htmlspecialchars($order['name']) ?></p>
            <p>No Telepon: <?= htmlspecialchars($order['phone']) ?></p>
            <p>Alamat: <?= htmlspecialchars($order['address']) ?></p>
            <h3>Rincian Pesanan:</h3>
            <ul>
                <?php foreach ($items as $item): ?>
                    <li><?= htmlspecialchars($item['item_name']) ?>: <?= htmlspecialchars($item['quantity']) ?> x Rp<?= htmlspecialchars($item['price']) ?></li>
                <?php endforeach; ?>
            </ul>
            <h3>Total Harga: Rp<?= htmlspecialchars($order['total_price']) ?></h3>
        </section>
    </div>
</body>
</html>
