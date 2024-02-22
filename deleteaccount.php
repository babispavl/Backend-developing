<?php
session_start();

if (isset($_SESSION['username'])) {
    
   $servername = "servername";
   $dbusername = "username";
   $dbpassword = "password";
   $dbname = "database";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $username = $_SESSION['username'];

    
    $sql_delete_favorites = "DELETE FROM favorites WHERE username = '$username'";
    if ($conn->query($sql_delete_favorites) === TRUE) {
        
        $sql_delete_login = "DELETE FROM login WHERE username = '$username'";
        if ($conn->query($sql_delete_login) === TRUE) {
            
            $sql_delete_account = "DELETE FROM register WHERE username = '$username'";
            if ($conn->query($sql_delete_account) === TRUE) {
                
                unset($_SESSION['username']);
                header("Location: index.html");
                exit;
            } else {
                echo "Error deleting account: " . $conn->error;
            }
        } else {
            echo "Error deleting from login: " . $conn->error;
        }
    } else {
        echo "Error deleting favorites: " . $conn->error;
    }

    $conn->close();
} else {
    
    header("Location: http://movieplanet.liveblog365.com/Index.html");
    exit;
}
?>
