<?php
$servername = "servername";
$dbusername = "username";
$dbpassword = "password";
$dbname = "database";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $email = $_POST['email'];

        if ($password !== $confirmPassword) {
            die("Οι κωδικοί πρόσβασης δεν ταιριάζουν");
        }

        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt_register = $pdo->prepare("INSERT INTO register (username, password, `confirm password`, email) VALUES (:username, :password, :confirmpassword, :email)");
        $stmt_register->bindParam(':username', $username);
        $stmt_register->bindParam(':password', $hashedPassword);
        $stmt_register->bindParam(':confirmpassword', $hashedPassword);
        $stmt_register->bindParam(':email', $email);
        $stmt_register->execute();

        
        $stmt_favorites = $pdo->prepare("INSERT INTO favorites (username) VALUES (:username)");
        $stmt_favorites->bindParam(':username', $username);
        $stmt_favorites->execute();

        $stmt_login = $pdo->prepare("INSERT INTO login (username, password) VALUES (:username, :password)");
        $stmt_login->bindParam(':username', $username);
        $stmt_login->bindParam(':password', $hashedPassword);
        $stmt_login->execute();

        echo "Επιτυχής εισαγωγή δεδομένων!";

        
        header("Location: http://movieplanet.liveblog365.com/LogIn.html");
        exit;

    }

    $pdo = null;  
} catch (PDOException $e) {
    echo "Σφάλμα σύνδεσης: " . $e->getMessage();
} catch (Exception $e) {
    echo "Γενικό σφάλμα: " . $e->getMessage();
}
?>
