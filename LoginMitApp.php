<?php
include("db_config.php");
include("config.php");
global $connection;
$username = $password = "";

if (isset($_POST['username'])) {
    $username = strip_tags(trim($_POST['username']));
}
if (isset($_POST['password'])) {
    $password = strip_tags(trim($_POST['password']));
    $pw1 = SALT1 . $password . SALT2;

    $passwordCoded = MD5($pw1);
}


if (!empty($username) && !empty($password)) {

    $sql = "SELECT * FROM users
            WHERE username = '$username' AND password = '$passwordCoded'";
    $result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
    $row = mysqli_fetch_all($result);
    if ($row) {
        echo "Helyes";
    }
    else
        echo "Hibás felhasználónév vagy jelszó!";
}
?>