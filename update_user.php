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
    if (isset($_POST['update'])) {
        // Updating the user
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $role = $_POST['role'];

        $sql = "UPDATE users SET name=?, role=? WHERE matric=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $role, $matric);

        if ($stmt->execute()) {
            header("Location: display_users.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Displaying the form for updating
        $matric = $_POST['matric'];
        $sql = "SELECT matric, name, role FROM users WHERE matric=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "No user found";
            exit();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
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
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"], input[type="name"] {
            width: 93%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        .radio-label {
            display: inline-block;
            margin-right: 20px;
        }
        input[type="submit"], .cancel-button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            margin-bottom: 20px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .cancel-button {
            background-color: #d9534f;
            color: white;
        }
        .cancel-button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update User</h2>
        <form action="update_user.php" method="post">
            <input type="hidden" name="matric" value="<?php echo $row['matric']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            
            <label for="role">Role:</label>
            <div class="radio-label">
                <input type="radio" id="lecturer" name="role" value="Lecturer" <?php if($row['role'] == 'Lecturer') echo 'checked'; ?> required>
                <label for="lecturer">Lecturer</label>
            </div>
            <div class="radio-label">
                <input type="radio" id="student" name="role" value="Student" <?php if($row['role'] == 'Student') echo 'checked'; ?> required>
                <label for="student">Student</label>
            </div>
            
            <input type="submit" name="update" value="Update">
            <a href="display_users.php" class="cancel-button">Cancel</a>
        </form>
    </div>
</body>
</html>
