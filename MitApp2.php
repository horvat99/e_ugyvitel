<?php
include("db_config.php");
include("config.php");
global $connection;
$username = $comment = $food = "";

if (isset($_POST['username'])) {
   // $username = strip_tags(trim($_POST['username']));
    $username = urldecode(strip_tags(trim($_POST['username'])));
}
if (isset($_POST['food'])) {
 //   $food = strip_tags(trim($_POST['food']));
    $food = urldecode(strip_tags(trim($_POST['food'])));
}
if (isset($_POST['grades'])) {
    //   $food = strip_tags(trim($_POST['food']));
    $grade = urldecode(strip_tags(trim($_POST['grades'])));
}
if (isset($_POST['comment'])) {
    $comment = urldecode(strip_tags(trim($_POST['comment'])));
   // $comment = strip_tags(trim($_POST['comment']));

$FoodDetails = explode("-",$food);
$foodId = $FoodDetails[0];
$foodName = $FoodDetails[1];
$restaurant = $FoodDetails[2];


$sql = "INSERT INTO comments (food_name,restaurant,food_id,comment,mark,user) VALUES
                    ('$foodName','$restaurant','$foodId','$comment','$grade','$username')";
    if ($connection->query($sql) === TRUE) {
        echo "Rögzítettük hozzászólását! Köszönjük!";
    }
   /* else
        echo $foodName ."<br>". $restaurant ."<br>". $foodId ."<br>". $comment ."<br>". $username;*/
}