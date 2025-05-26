<?php
session_start();
require_once("settings.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle login
if (isset($_POST['login'])) {
    if (!isset($_SESSION['attempt'])) {
        $_SESSION['attempt'] = 0;
    }

    // Check if user is locked out
    if ($_SESSION['attempt'] >= 3) {
        if (isset($_SESSION['attempt_again'])) {
            $now = time();
            if ($now < $_SESSION['attempt_again']) {
                $_SESSION['error'] = 'Attempt limit reached. Try again in ' . ceil(($_SESSION['attempt_again'] - $now) / 60) . ' minutes.';
                header("Location: login_form.php");
                exit();
            } else {
                // Reset lockout
                unset($_SESSION['attempt']);
                unset($_SESSION['attempt_again']);
            }
        }
    }

    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    // Fetch user from DB
    $stmt = $conn->prepare("SELECT * FROM managers WHERE username = ?");
    $stmt->bind_param("s", $username_input);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check result
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stored_password = $user['password'];

        $is_valid = password_verify($password_input, $stored_password) || $password_input === $stored_password;

        if ($is_valid) {
            $_SESSION['success'] = "Login successful";
            unset($_SESSION['attempt']);
            unset($_SESSION['attempt_again']);

            // Update plain-text password to hashed
            if (!password_verify($password_input, $stored_password)) {
                $new_hash = password_hash($password_input, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE managers SET password = ? WHERE username = ?");
                $update_stmt->bind_param("ss", $new_hash, $username_input);
                $update_stmt->execute();
                $update_stmt->close();
            }

            header("Location: manage.php");
            exit();
        } else {
            $_SESSION['attempt'] += 1;
            $_SESSION['error'] = "Password incorrect.";

            if ($_SESSION['attempt'] >= 3) {
                $_SESSION['attempt_again'] = time() + (5 * 60); // lock for 5 min
            }
        }
    } else {
        $_SESSION['error'] = "No account with that username.";
        $_SESSION['attempt'] += 1;

        if ($_SESSION['attempt'] >= 3) {
            $_SESSION['attempt_again'] = time() + (5 * 60); // lock for 5 min
        }
    }
} else {
    $_SESSION['error'] = "Please submit the login form.";
}

header("Location: login_form.php");
exit();

