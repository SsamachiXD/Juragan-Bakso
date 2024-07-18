<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST["phone"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $total_price = $_POST["total_price"];

    $sql = "UPDATE orders SET name=?, address=?, total_price=? WHERE phone=?";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssis", $name, $address, $total_price, $phone);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Order anda berhasil diperbarui."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating order: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
} else {
    $phone = $_GET['phone'];
    $sql = "SELECT * FROM orders WHERE phone='$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No order found with phone number $phone";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Order</title>
    <link rel="icon" href="folder gambar/logo.jpg" type="image/icon type">
    <link rel="stylesheet" href="styles.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
         body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)),
                        url("folder gambar/bakso.jpg") center/cover no-repeat; /* Gradient overlay and image background */
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
            .a1 {
            margin-right: 20px; /* Mengatur jarak antar ikon */
            margin-top: 20px;   /* Jarak atas 20px */
            margin-bottom: 30px; /* Jarak bawah 30px */
            }

            .a1 i {
                font-size: 20px; /* Mengatur ukuran ikon */
            }
        </style>

    <script>
        function calculateTotal() {
            const prices = {
                "Bakso Urat": 25000,
                "Bakso Telur": 30000,
                "Bakso Lava": 35000,
                "Bakso Iga Sapi": 40000
            };

            let total = 0;
            let orderSummary = '';
            const quantities = document.querySelectorAll('.quantity');
            quantities.forEach((quantity) => {
                const menu = quantity.dataset.menu;
                const count = parseInt(quantity.value) || 0;
                if (count > 0) {
                    total += count * prices[menu];
                    orderSummary += `${menu}: ${count} x Rp${prices[menu]}<br>`;
                }
            });

            document.getElementById('order_summary').innerHTML = orderSummary;
            document.getElementById('total_price').innerText = 'Total: Rp ' + total;
            document.getElementById('hidden_total_price').value = total;
        }

        function submitOrder(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('order_form'));

            fetch('edit_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    window.location.href = 'view_orders.php';
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
<section class="main">
      <div class="fix">
          <a class="a1" href="view_orders.php"><i class='bx bx-basket'>PESANAN</i></a>
      </div>
    </section>
    <section class="menu-template" id="id-menu">
        <center>
            <h3 class="menu-subtitle">JURAGAN &nbsp;&nbsp;BAKSO.ID</h3>
        </center>
    </section>

    <form id="order_form" onsubmit="submitOrder(event)">
        <section class="menu">
            <article class="menu-section"><br>
                <center><img src="folder gambar/bakso urat.jpg" alt="Bakso Urat" class="menu-image" height="45px"></center>
                <div class="menu-text">
                    <h3 class="menu-text-title">Bakso Urat</h3>
                    <h4 class="menu-text-title">Rp25.000</h4>
                    <label for="quantity-bakso-urat">Jumlah pesanan:</label>
                    <input type="number" id="quantity-bakso-urat" name="bakso_urat" class="quantity" data-menu="Bakso Urat"
                        min="0" max="100" value="0" oninput="calculateTotal()">
                </div>
            </article>

            <article class="menu-section">
                <center><img src="folder gambar/bakso telur.jpg" alt="Bakso Telur" class="menu-image" height="45px"></center>
                <div class="menu-text">
                    <h3 class="menu-text-title">Bakso Telur</h3>
                    <h4 class="menu-text-title">Rp30.000</h4>
                    <label for="quantity-bakso-telur">Jumlah pesanan:</label>
                    <input type="number" id="quantity-bakso-telur" name="bakso_telur" class="quantity" data-menu="Bakso Telur"
                        min="0" max="100" value="0" oninput="calculateTotal()">
                </div>
            </article>

            <article class="menu-section">
                <center><img src="folder gambar/bakso lava.jpg" alt="Bakso Lava" class="menu-image" height="100px"></center>
                <div class="menu-text">
                    <h3 class="menu-text-title">Bakso Lava</h3>
                    <h4 class="menu-text-title">Rp35.000</h4>
                    <label for="quantity-bakso-lava">Jumlah pesanan:</label>
                    <input type="number" id="quantity-bakso-lava" name="bakso_lava" class="quantity" data-menu="Bakso Lava"
                        min="0" max="100" value="0" oninput="calculateTotal()">
                </div>
            </article>

            <article class="menu-section">
                <center><img src="folder gambar/bakso iga.jpg" alt="Bakso Iga Sapi" class="menu-image" height="100px"></center>
                <div class="menu-text">
                    <h3 class="menu-text-title">Bakso Iga Sapi</h3>
                    <h4 class="menu-text-title">Rp40.000</h4>
                    <label for="quantity-bakso-iga">Jumlah pesanan:</label>
                    <input type="number" id="quantity-bakso-iga" name="bakso_iga" class="quantity" data-menu="Bakso Iga Sapi"
                        min="0" max="100" value="0" oninput="calculateTotal()">
                </div>
            </article>
        </section>

        <div id="order_summary_section">
            <h2>Pesanan Yang di Order</h2>
            <div id="order_summary"></div>
        </div>
        <h2 id="total_price">Total: Rp <?php echo $row['total_price']; ?></h2>

        <section id="customer_data" style="display:block;">
            <section class="about-section-center-clearfix" style="display: inline;">
                <h2>Data Pemesanan:</h2>
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>

                <label for="phone">No Telepon:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" pattern="\d+" title="Harap masukkan hanya angka!" required readonly><br>

                <label for="address">Alamat:</label>
                <textarea id="address" name="address" required><?php echo $row['address']; ?></textarea><br>

                <input type="hidden" id="hidden_total_price" name="total_price" value="<?php echo $row['total_price']; ?>">

                <p align="center"><button type="submit" value="Submit">Update Order</button>
            </section>
        </section>
    </form>
</body>
</html>
