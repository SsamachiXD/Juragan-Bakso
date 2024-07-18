<!DOCTYPE html>
<html>
<head>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)),
                        url("folder gambar/bakso.jpg") center/cover no-repeat;
            padding: 20px;
            background-color: #f0f0f0;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .header {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.5)),
              url("folder gambar/bakso.jpg") center/cover no-repeat;
            position: relative;
            background-attachment: fixed;
            background-color: #222;
        }
        .main {
            position: fixed;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            width: 100%;
            padding: 10px 20px;
            top: 0;
        }
        .main a {
            display: inline;
            background: transparent;
            color: #f8f9fa;
            text-decoration: none;
            font-size: 24px;
            transition: color 0.3s;
            padding: 10px 20px;
            border-radius: 4px;
        }
            .main a:hover {
                color: #ff852e;
            }
            .a1 i {
                font-size: 20px; /* Mengatur ukuran ikon */
            }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffa361;
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.8);
            font-size: 36px;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            background-color: rgb(210, 210, 210);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            max-width: 80%;
            width: 100%;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
        }
        table th, table td {
            border: 1px solid #dddddd;
            padding: 12px;
            text-align: left;
            color: #333;
        }
        table th {
            background-color: #f0f0f0;
            font-size: 15px;
            text-transform: uppercase;
        }
        table td {
            font-size: 16px;
        }
        table td a {
            font-size: 15px;
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
            transition: color 0.3s ease;
        }
        table td a:hover {
            text-decoration: underline;
            color: #0056b3;
        }
        .no-orders {
            text-align: center;
            margin-top: 20px;
            color: red;
            font-size: 18px;
        }
        table th, table td {
            width: auto;
            max-width: 200px;
            word-wrap: break-word;
            height: 40px;
            vertical-align: middle;
        }
        table th {
            height: 50px;
        }
    </style>

    <script>
        function confirmEdit(phone) {
            if (confirm("Apakah Anda yakin ingin mengedit pesanan ini?")) {
                window.location.href = 'edit_order.php?phone=' + phone;
            }
        }

        function confirmDelete(phone) {
            if (confirm("Anda yakin untuk menghapus orderan ini?")) {
                window.location.href = 'delete_order.php?phone=' + phone;
            }
        }
    </script>
</head>
<body>
    <section class="main">
      <div class="fix">
      <a class="a1" href="index.html"><i class="bx bx-home">HOME</i></a>
      <a class="a1" href="menu.html"><i class='bx bx-arrow-back' >ORDER</i></a>
      </div>
    </section>

    <div class="content">
        <h2>Melihat Pesanan</h2>
        <form method="post" action="view_orders.php">
            <label for="phone">Masukkan Nomor Telepon Anda:</label>
            <input type="text" id="phone" name="phone" required>
            <input type="submit" value="Lihat Pesanan">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $phone = $_POST["phone"];
            
            // Database configuration
            $servername = "localhost:3307";
            $username = "root";
            $password = "";
            $dbname = "bakso_order";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM orders WHERE phone='$phone'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo "<table border='1'><tr><th>Nama</th><th>Alamat</th><th>Telepon</th><th>Total Harga</th><th>Tanggal Order</th><th>Aksi</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['address']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['total_price']}</td>
                            <td>{$row['order_date']}</td>
                            <td>
                                <a href='#' onclick='confirmEdit(\"{$row['phone']}\")'>Edit</a>|
                                <a href='#' onclick='confirmDelete(\"{$row['phone']}\")'>Delete</a>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='no-orders'>Tidak ada order yang ditemukan pada nomor telepon ini.</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>
