<?php
session_start(); 

$servername = "servername";
$dbusername = "username";
$dbpassword = "password";
$dbname = "database";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $raw_password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($raw_password, $hashed_password)) {
            
            $_SESSION['username'] = $username; 
            header("Location: http://movieplanet.liveblog365.com/main3.php");
            exit;

        } else {
            
            echo json_encode(array('status' => 'ERROR', 'message' => 'Incorrect password'));
        }
    } else {
        
    }

    $stmt->close();
}

$conn->close();
?>
