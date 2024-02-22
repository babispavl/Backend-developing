 <?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $welcomeMessage = "<p class='welcome-message'>Welcome, <span class='username'>$username</span>!</p>";

    
    $logoutForm = '<form action="logout.php" method="post">
                      <input type="submit" value="Logout">
                   </form>';
} else {
    $welcomeMessage = "<p>Δεν έχετε συνδεθεί ακόμα.</p>";
    $logoutForm = ''; 
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Main</title>
    <link rel="stylesheet" href="style.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' />
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <div class="container">
                <a style="color:white;" href="index.html">MoviePlanet</a>
            </div>
        </div>

        <div class="navbar">
            <img src="images/logo.PNG" class="logo" />
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#">Purpose</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Extra</a></li>
            </ul>
            <!-- Place the welcome message next to "Extra" in the navbar -->
            <?php echo $welcomeMessage; ?>
        </div>

        <!-- Search Container -->
        <div class="search-container">
            <div class="search-element">
                <h3>Search Movie:</h3>
                <input type="text" class="form-control" placeholder="Search Movie Title ..." id="movie-search-box" onkeyup="findMovies()" onclick="findMovies()" />
                <div class="search-list" id="search-list"></div>
            </div>
        </div>
        <!-- End of Search Container -->

        <!-- Favorite Movies Form -->
        <div class="favorite-container">
            <h3 style="color:white;">Add to Favorites</h3>
            <form action="favorite.php" method="post">
                

                <div class="form-group">
                    <label style="color:white;" for="movietitle">Movie Title:</label>
                    <input type="text" id="movietitle" name="movietitle" required class="form-control-small" />
                </div>

                <div class="form-group">
                    <label style="color:white;" for="movielink">Movie Link:</label>
                    <input type="text" id="movielink" name="movielink" required class="form-control-small" />
                </div>

                <div class="form-group">
                    <label style="color:white;" for="comment">Comment:</label>
                    <textarea id="comment" name="comment" class="form-control-small"></textarea>
                </div>

                <div class="form-group">
                    <input type="submit" value="Add to Favorites" class="btn-add-favorite" />
                </div>
            </form>
        </div>
        <!-- End of Favorite Movies Form -->   
                <?php
               

                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];

                    
                    $servername = "servername";
                    $db_username = "username";
                    $db_password = "password";
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



               
        

        <!-- Result Container -->
        <div class="container">
            <div class="result-container">
                <div class="result-grid" id="result-grid"></div>
            </div>
        </div>
        <!-- End of Result Container -->
        <div class="change-password-container">
    <h3 style="color:white;">Change Password:</h3>
    <form action="changepass.php" method="post">

        <label style="color:white;" for="newpassword">New Password:</label>
        <input type="password" id="newpassword" name="newpassword" required /><br /><br />

        <label style="color:white;" for="confirmpassword">Confirm New Password:</label>
        <input type="password" id="confirmpassword" name="confirmpassword" required /><br /><br />

        <input type="submit" value="Change Password" class="btn-changepass" />
    </form>
</div>
       

    </div>
    <div class="delete-account-container">
        <h3>Delete Account:</h3>
        <form action="deleteaccount.php" method="post">
            <input type="submit" value="Delete Account" />
        </form>
    </div>
    </div>
    <div class="Logout-container">
        <h3>Logout:</h3>
        <form action="logout.php" method="post">
            <input type="submit" value="Logout" />
        </form>
    </div>
    <!-- Include JavaScript -->
    <script src="script.js"></script>
</body>

</html>
