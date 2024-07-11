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

// Function to validate phone number using NFA
function validatePhone($phone) {
    $states = [
        'START' => 'START',
        'DIGIT' => 'DIGIT',
        'VALID' => 'VALID',
        'INVALID' => 'INVALID'
    ];
    
    $currentStates = [$states['START']];
    
    for ($i = 0; $i < strlen($phone); $i++) {
        $char = $phone[$i];
        $nextStates = [];
        
        foreach ($currentStates as $state) {
            switch ($state) {
                case $states['START']:
                    if (ctype_digit($char)) {
                        $nextStates[] = $states['DIGIT'];
                    }
                    break;
                case $states['DIGIT']:
                    if (ctype_digit($char)) {
                        $nextStates[] = $states['DIGIT'];
                    }
                    break;
            }
        }
        
        if (empty($nextStates)) {
            return false;
        }
        
        $currentStates = $nextStates;
    }
    
    return strlen($phone) >= 10 && strlen($phone) <= 13;
}

// Function to validate name to ensure it does not contain symbols
function validateName($name) {
    return preg_match('/^[a-zA-Z\s]+$/', $name);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $name = sanitize($_POST["name"]);
    $address = sanitize($_POST["address"]);
    $phone = sanitize($_POST["phone"]);
    $order_summary = "";
    $total_price = 0;

    // Validate name
    if (!validateName($name)) {
        echo "Invalid name format. Name should only contain letters and spaces.";
        exit;
    }

    // Validate phone number
    if (!validatePhone($phone)) {
        echo "Invalid phone number format.";
        exit;
    }

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
        $stmt->bind_param("ssssi", $name, $address, $phone, $order_summary, $total_price);

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