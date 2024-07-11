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

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $name = sanitize($_POST["name"]);
    $address = sanitize($_POST["address"]);
    $phone = sanitize($_POST["phone"]);
    $order_summary = "";
    $total_price = 0;

    $menu_items = ["bakso_urat" => 25000, "bakso_telur" => 30000, "bakso_lava" => 35000, "bakso_iga" => 40000];
    
    foreach ($menu_items as $item => $price) {
        if (isset($_POST[$item]) && is_numeric($_POST[$item]) && $_POST[$item] > 0) {
            $quantity = intval($_POST[$item]);
            $order_summary .= ucfirst(str_replace("_", " ", $item)) . ": " . $quantity . " x Rp" . $price . "<br>";
            $total_price += $quantity * $price;
        }
    }

    // Ensure all required fields are filled
    if (!empty($name) && !empty($address) && !empty($phone) && !empty($order_summary) && $total_price > 0) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO orders (name, address, phone, order_summary, total_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $name, $address, $phone, $order_summary, $total_price);

        // Execute the query
        if ($stmt->execute()) {
            echo "New order has been placed successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please fill in all required fields and ensure you have ordered at least one item.";
    }
}

// Close the connection
$conn->close();
?>
