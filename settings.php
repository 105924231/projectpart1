<?php
$host = "localhost";
$username = "root";
$pwd = "";
$sql_db = "job_applications";

$conn = mysqli_connect($host, $username, $pwd, $sql_db);

if (!$conn) {
    die("Connection failed. " . mysqli_connect_error());
}

?>