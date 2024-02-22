<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        
        $servername = "servername";
        $db_username = "username";
        $db_password = "password";
        $dbname = "movieplanet";

        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $newPassword = $_POST["newpassword"];
        $confirmPassword = $_POST["confirmpassword"];

        if ($newPassword == $confirmPassword) {
            
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            
            $updateLoginSql = "UPDATE login SET password = '$hashedPassword' WHERE username = '$username'";
            if ($conn->query($updateLoginSql) === TRUE) {
                
                echo "Password updated successfully.";

                
                header("Location: http://movieplanet.liveblog365.com/main3.php");
                exit();
            } else {
                echo "Error updating password in login table: " . $conn->error;
            }
        } else {
            echo "New password and confirm password do not match.";
        }

        $conn->close();
    } else {
        echo "User not logged in.";
    }
}
?>
