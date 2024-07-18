<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "bakso_order";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to validate phone number using FSA
function validatePhone($phone) {
    $states = ['START', 'DIGIT', 'VALID'];
    $currentState = 'START';
    
    for ($i = 0; $i < strlen($phone); $i++) {
        $char = $phone[$i];
        
        switch ($currentState) {
            case 'START':
                if (ctype_digit($char)) {
                    $currentState = 'DIGIT';
                } else {
                    return false;
                }
                break;
                
            case 'DIGIT':
                if (ctype_digit($char)) {
                    $currentState = 'DIGIT';
                } else {
                    return false;
                }
                break;
        }
    }
    
    if ($currentState == 'DIGIT' && strlen($phone) >= 10 && strlen($phone) <= 13) {
        return true;
    } else {
        return false;
    }
}

// Function to validate name
function validateName($name) {
    return preg_match('/^[a-zA-Z\s]+$/', $name);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $name = sanitize($_POST["name"]);
    $address = sanitize($_POST["address"]);
    $phone = sanitize($_POST["number"]);
    $total_price = 0;

    // Validate name
    if (!validateName($name)) {
        echo json_encode(["status" => "error", "message" => "Masukan nama dengan format yang benar."]);
        exit;
    }

    // Validate phone number
    if (!validatePhone($phone)) {
        echo json_encode(["status" => "error", "message" => "Masukan no telepon dengan format yang benar."]);
        exit;
    }

    // Check if the phone number already exists
    $checkSql = "SELECT * FROM orders WHERE phone = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Nomor telepon ini sudah terdaftar!"]);
        exit();
    }

    $menu_items = [
        "bakso_urat" => 25000,
        "bakso_telur" => 30000,
        "bakso_lava" => 35000,
        "bakso_iga" => 40000
    ];
    
    foreach ($menu_items as $item => $price) {
        if (isset($_POST[$item]) && is_numeric($_POST[$item]) && $_POST[$item] > 0) {
            $quantity = intval($_POST[$item]);
            $total_price += $quantity * $price;
        }
    }

    // Ensure all required fields are filled
    if (!empty($name) && !empty($address) && !empty($phone) && $total_price > 0) {
        // Prepare and bind
        $order_date = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO orders (name, address, phone, total_price, order_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $address, $phone, $total_price, $order_date);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Orderan kamu berhasil dibuat, Silahkan cek di pesanan."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Anda belum memilih salah satu menu baksonya."]);
    }
}

// Close the connection
$conn->close();
?>
