<?php
session_start();

if(isset($_SESSION['attempt_again'])){
    $now = time();
    if($now >= $_SESSION['attempt_again']){
        unset($_SESSION['attempt']);
        unset($_SESSION['attempt_again']);
    }
}

include 'header.inc';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <title>S.A Coder's Manager Portal</title>
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <h1>Manager Portal</h1>
            <form method="POST" action="login.php" class="login-form">

                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Enter username..." required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter password..." required>

                <button type="submit" name="login">Login</button>
            </form>

            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='login-error'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<p class='login-success'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            }
            ?>
        </div>
    </div>

    <?php include 'footer.inc'; ?>
</body>
</html>

