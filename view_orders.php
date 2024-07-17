<!DOCTYPE html>
<html>
<head>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)),
                        url("folder gambar/bakso.jpg") center/cover no-repeat; /* Gradient overlay and image background */
            padding: 20px;
            background-color: #f0f0f0; /* Fallback background color */
            margin: 0;
            height: 100vh; /* Full viewport height */
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
            justify-content: flex-end; /* Align to the right */
            align-items: center;
            width: 100%;
            padding: 10px 20px; /* Adjust padding */
            top: 0;
        }
        .main a {
            display: inline;
            background: transparent;
            color: #f8f9fa;
            text-decoration: none;
            font-size: 24px;
            transition: color 0.3s;
            padding: 10px 20px; /* Add padding for clickable area */
            border-radius: 4px; /* Add border radius for better styling */
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
            color: #ffa361; /* White text */
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.8); /* Text shadow for contrast */
            font-size: 36px; /* Larger font size */
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            background-color: rgb(210, 210, 210); /* Semi-transparent white background for content */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Soft shadow */
            margin-top: 20px;
            max-width: 80%; /* Limit content width */
            width: 100%;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff; /* White */
            border: 1px solid #dddddd; /* Light gray border */
        }
        table th, table td {
            border: 1px solid #dddddd; /* Light gray border */
            padding: 12px; /* Increased padding for better spacing */
            text-align: left;
            color: #333; /* Dark gray text color */
        }
        table th {
            background-color: white: /* Light gray */
            font-size: 15px; /* Larger font size */
            text-transform: uppercase; /* Uppercase text */
        }
        table td {
            font-size: 16px; /* Medium font size */
        }
        table td a {
            font-size: 15px;
            text-decoration: none;
            color: #007bff; /* Blue links */
            margin-right: 10px;
            transition: color 0.3s ease; /* Smooth color transition */
        }
        table td a:hover {
            text-decoration: underline;
            color: #0056b3; /* Darker blue on hover */
        }
        .no-orders {
            text-align: center;
            margin-top: 20px;
            color: red; /* Gray text color */
            font-size: 18px; /* Larger font size */
        }
        /* Custom table styles */
        table th, table td {
            width: auto; /* Auto width */
            max-width: 200px; /* Maximum width for cells */
            word-wrap: break-word; /* Wrap long words */
            height: 40px; /* Fixed height */
            vertical-align: middle; /* Center align vertically */
        }
        table th {
            height: 50px; /* Fixed height for header cells */
        }
    </style>

</head>
<body>
    <section class="main">
      <div class="fix">
      <a class="a1" href="menu.html"><i class='bx bx-arrow-back' >PESAN LAGI</i></a>
        <a class="a1" href="index.html"><i class="bx bx-home">HOME</i></a>
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
                                <a href='edit_order.php?phone={$row['phone']}'>Edit</a> |
                                <a href='delete_order.php?phone={$row['phone']}' onclick='return confirm(\"Anda yakin untuk menghapus orderan ini?\")'>Delete</a>
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