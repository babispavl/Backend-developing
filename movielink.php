
<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    
   $servername = "servername";
   $dbusername = "username";
   $dbpassword = "password";
   $dbname = "database";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "SELECT movielink FROM favorites WHERE username = '$username'";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        echo "<div class='movie-links'>";
        while ($row = $result->fetch_assoc()) {
            echo "<a href='" . $row["movielink"] . "' target='_blank'>" . $row["movielink"] . "</a><br>";
        }
        echo "</div>";
    } else {
        echo "<p>Δεν υπάρχουν διαθέσιμοι σύνδεσμοι ταινιών για τον συνδεδεμένο χρήστη.</p>";
    }

    $conn->close();
} else {
    echo "<p>Δεν έχετε συνδεθεί ακόμα.</p>";
}
?>
