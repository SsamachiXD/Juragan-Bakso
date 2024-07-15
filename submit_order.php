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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $pesanan = $_POST['pesanan'];

    $sql = "INSERT INTO orders (nama, alamat, telepon, pesanan) VALUES ('$nama', '$alamat', '$telepon', '$pesanan')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        header("Location: view_order.php?id=$last_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
