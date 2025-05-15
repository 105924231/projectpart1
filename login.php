<?php
session_start();
require_once("settings.php");

if(isset($_POST['login'])) {
    $conn = mysqli_connect($host, $username, $password, $database);

    if(!isset($_SESSION['attempt'])){
        $_SESSION['attempt'] = 0;
    }

    if($_SESSION['attempt'] == 3){
        $_SESSION['error'] = 'Attempt limit reached.';
    } else {
        $sql = "SELECT * FROM managers WHERE username = '".$_POST['username']."'";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
            $row = $query->fetch_assoc();
        }

        if(password_verify($_POST['password'], $row['password'])) {
            $_SESSION['success']; = 'Login successful';
            header("Location: manage.php");
            unset($_SESSION['attempt']); 
        } else {
            $_SESSION['error'] = 'Password incorrect.';
            $_SESSION['attempt'] += 1;

            if($_SESSION['attempt'] == 3) {
                $_SESSION['attempt_again'] = time() + (5*60);
            }
        }
    } else {
    $_SESSION['error'] = 'No account with that username.';
    }
} else {
    $_SESSION['error'] = 'Fill in login form first';
}

header('Location: login_form.php')

?>