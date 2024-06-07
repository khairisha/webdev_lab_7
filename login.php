<?php
session_start();

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "Lab_7";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$matric = $_POST['matric'];
$password = $_POST['password'];

// Query to select the user with the provided matric
$sql = "SELECT * FROM users WHERE matric = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verify the password
    if (password_verify($password, $row['password'])) {
        $_SESSION['matric'] = $row['matric'];
        $_SESSION['name'] = $row['name'];
        header("Location: display_users.php");
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "Invalid matric.";
}

$stmt->close();
$conn->close();
?>
