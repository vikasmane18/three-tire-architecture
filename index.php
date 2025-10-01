<?php
// ===== DATABASE CONNECTION =====
$DB_HOST = "127.0.0.1";
$DB_NAME = "facebook";
$DB_USER = "fb_user";
$DB_PASS = "**********";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// ===== FORM SUBMISSION HANDLER =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $phone === '' || $message === '') {
        echo "<p style='color:red'>All required fields must be filled!</p>";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO form_data (name,email,phone,address,message,created_at) 
             VALUES (?,?,?,?,?,NOW())"
        );
        $stmt->bind_param("sssss", $name, $email, $phone, $address, $message);

        if ($stmt->execute()) {
            echo "<p style='color:green'>Form submitted successfully!</p>";
        } else {
            echo "<p style='color:red'>Error: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
    }
}
?>
