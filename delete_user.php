<?php
session_start();

if (!isset($_SESSION['matric'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "Lab_7"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matric'])) {
    $matric = $_POST['matric'];

    $sql = "DELETE FROM users WHERE matric=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);

    if ($stmt->execute()) {
        header("Location: display_users.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
