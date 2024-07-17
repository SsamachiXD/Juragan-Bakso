<!DOCTYPE html>
<html>
<head>
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
    .main {
    position: fixed;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    margin-top: 10px 0;
    top: 10px;
}
.main a{
    display: inline;
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.5));

}
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #fff; /* White text */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); /* Text shadow for contrast */
        font-size: 36px; /* Larger font size */
    }

    form {
        text-align: center;
        margin-bottom: 20px;
    }

    .content {
        background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background for content */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Soft shadow */
        margin-top: 20px;
        max-width: 800px; /* Limit content width */
        width: 100%;
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
        background-color: #f2f2f2; /* Light gray */
        font-size: 18px; /* Larger font size */
        text-transform: uppercase; /* Uppercase text */
    }

    table td {
        font-size: 16px; /* Medium font size */
    }

    table td a {
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
        color: #777; /* Gray text color */
        font-size: 18px; /* Larger font size */
    }

    /* CSS for home link */
    .a1 {
        position: absolute;
        top: 20px;
        left: 20px;
        text-decoration: none;
        color: #fff; /* White text color */
        font-size: 24px; /* Larger font size */
        transition: color 0.3s ease; /* Smooth color transition */
    }

    .a1:hover {
        color: #ccc; /* Light gray on hover */
    }
    </style>
</head>
<body>
<section class="main">
      <div class="fix">
        <a class="a1" href="index.html">HOME</a>
      </div>
    </section>
    <div class="content">
        <h2>View Orders</h2>
        <form method="post" action="view_orders.php">
            <label for="phone">Enter your phone number:</label>
            <input type="text" id="phone" name="phone" required>
            <input type="submit" value="View Orders">
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
                                <a href='delete_order.php?phone={$row['phone']}' onclick='return confirm(\"Are you sure you want to delete this order?\")'>Delete</a>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='no-orders'>No orders found for this phone number.</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>
