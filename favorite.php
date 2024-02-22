<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    if (!isset($_SESSION['username'])) {
        die("Δεν έχετε συνδεθεί.");
    }

    $username = $_SESSION['username'];  

    $movietitle = $_POST['movietitle'];
    $movielink = $_POST['movielink'];
    $comment = $_POST['comment'];

    
    $checkQuery = "SELECT * FROM favorites WHERE username = ? AND movietitle = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ss", $username, $movietitle);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
       
        $updateQuery = "UPDATE favorites SET movielink = ?, comment = ? WHERE username = ? AND movietitle = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ssss", $movielink, $comment, $username, $movietitle);

        if ($updateStmt->execute()) {
            echo "Τα αγαπημένα ενημερώθηκαν επιτυχώς!";
        } else {
            echo "Σφάλμα ενημέρωσης αγαπημένων: " . $updateStmt->error;
        }

        $updateStmt->close();
    } else {
        
        $insertQuery = "INSERT INTO favorites (username, movietitle, movielink, comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $username, $movietitle, $movielink, $comment);

        if ($stmt->execute()) {
            echo "Η ταινία προστέθηκε επιτυχώς στα αγαπημένα!";
        } else {
            echo "Σφάλμα: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
}
?>
