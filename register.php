<?php
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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $matric, $name, $hashed_password, $role);

// Set parameters and execute
$matric = $_POST['matric'];
$name = $_POST['name'];
$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password for security
$role = $_POST['role'];

$registration_success = false;
$registration_error = "";

if ($stmt->execute()) {
    $registration_success = true;
} else {
    $registration_error = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            margin-bottom: 20px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Result</h2>
        <?php if ($registration_success): ?>
            <p class="success">New record created successfully</p>
        <?php else: ?>
            <p class="error"><?php echo $registration_error; ?></p>
        <?php endif; ?>
        <form action="login.html" method="get">
            <input type="submit" value="Back to Login">
        </form>
    </div>
</body>
</html>
