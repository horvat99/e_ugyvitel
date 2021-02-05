<?php
$host = "localhost";
$user = "root";
$password = "6060";
$dbname = "Elhozom";

$connection = new \mysqli($host, $user, $password,$dbname);
if ($connection->connect_errno)
{
    echo $connection->connect_error;
}
?>
