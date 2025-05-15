<?php
require_once("settings.php");

if (isset($_POST['refnum'])) {
    $refnum = mysqli_real_escape_string($conn, $_POST['refnum'])
    $sql = "SELECT * FROM eoi WHERE refnum LIKE '%$refnum%'";
    $result = mysqli_query($conn, $sql);
}
?>
