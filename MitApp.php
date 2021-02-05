<?php
include("db_config.php");
include("config.php");
global $connection;
$username = "";

if (isset($_POST['username'])) {
    $username = strip_tags(trim($_POST['username']));

    $stmt = $connection->prepare("SELECT * from orders WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $FoodID = [];
    foreach ($result as $item)
    {
        if (strlen($item['food_id'])>2)
        {
            $array2 = explode(",",$item['food_id']);
            foreach($array2 as $s)
            {
                if (!in_array($s,$FoodID))
                {
                    array_push($FoodID,$s);
                }
            }

        }
        else
        {
            array_push($FoodID,$item['food_id']);
        }
    }
    $foods = [];
    foreach ($FoodID as $id)
    {
        $stmt = $connection->prepare("SELECT food_id,food_name, restaurant from foods WHERE food_id = ?");
        $stmt -> bind_param("s",$id);
        $stmt ->execute();
        $stmt -> bind_result($food_id,$nameoffood,$restaurant);
        $stmt -> fetch();
        $stmt -> close();
        $sql = "SELECT * FROM comments WHERE food_id = '$id' AND user = '$username'";
        $result = $connection->query($sql);
        if ($result->num_rows<1){
            $asd = $food_id . "-" .$nameoffood.'-'.$restaurant;
            array_push($foods,$asd);

        }
    }
    echo $foods[0];
//$username = "asd";
/*
$sql = "SELECT id_user FROM users WHERE username = '$username'";
$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
$row = mysqli_fetch_assoc($result);
$idUser = $row['id_user'];

$sql = "SELECT * FROM orders WHERE id_user = '$idUser' and status = '0' LIMIT 1";
$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
$row = mysqli_fetch_assoc($result);
if ($row){
$message = "Dátum: ".$row['date'] . "<br>Rendelési idő: ". $row['time'].
"<br>Érkezési idő: " . $row['timearrive']
. "<br>Étterem: " . $row['restaurant'] . "<br>Étel: " . $row['food']."<hr>";
echo $message;
}*/
/*else
    echo "Önnek nincs olyan rendelt étele amiről nem írt véleményt!";*/
}




