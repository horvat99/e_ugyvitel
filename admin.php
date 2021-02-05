<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elhozom.hu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" href="pictures/logo.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php include("nav.php");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center bg-info">
            <?php
            if (isset($_GET['success']))
            {
                if ($_GET['success'] == 1)
                {
                    echo "Sikeresen hozzaadta!";
                }
                if ($_GET['success'] ==2)
                {
                    echo "Sikeresen torolt!";
                }
                if ($_GET['success'] ==3)
                {
                    echo "Sikeresen modositotta!";
                }
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            include ("db_config.php");
            global $connection;
            $stmt = $connection->prepare("SELECT priviligies from users where username = ?");
            $stmt -> bind_param("s",$_SESSION['username']);
            $stmt -> execute();
            $stmt -> bind_result($priv);
            $stmt -> fetch();
            $stmt -> close();
            if (!$priv)
            {
                echo "<h2>Onnek nincs joga modositani!</h2>";
            }
            ?>
        </div>
    </div>
    <div class="row mb-3 mt-3">
        <div class="col-6 col-md-4 col-lg-2 text-center">Add new food
            <hr class="border-top border-warning">
            <form method="POST" action="admin.php" enctype="multipart/form-data">
                <div>
                    <input type="file" name="image" class="form-control">
                </div>
                <input type="text" class="form-control" name="nameFood" placeholder="Food Name">
                <input type="text" class="form-control" name="descriptionFood" placeholder="Food description">
                <input type="text" class="form-control" name="priceFood" placeholder="Food price">
                <input type="text" class="form-control" name="typeFood" placeholder="Food type">
                <select name="restaurantFood" class="form-control">
                <?php
                $sql = "SELECT * from restaurants";
                $result = $connection->query($sql);
                $row = $result->fetch_all(MYSQLI_ASSOC);
                {
                    foreach ($row as $value)
                    {
                        echo '<option value="'.$value['name'].'">'.$value['name'].'</option>';
                    }
                }
                ?>
                </select>
                <div>
                    <button type="submit" class="btn btn-warning mt-2" name="uploadFood">Upload food</button>
                </div>
            </form>
        </div>

            <?php
            if (isset($_POST['update']))
            {
                echo '<div class="col-6 col-md-4 col-lg-2 text-center">
                    Update food
                <hr class="border-top border-warning">';
                $id = $_POST['update'];
                $result = $connection->query("SELECT * from foods WHERE food_id = '$id'");
                $row = $result->fetch_assoc();
                echo '<form method="post" action="admin.php">
                <input type="text" class="form-control" name="nameFood" value="'.$row['food_name'].'">
                <input type="text" class="form-control" name="descriptionFood" value="'.$row['description'].'">
                <input type="text" class="form-control" name="priceFood" value="'.$row['price'].'">
                <input type="text" class="form-control" name="typeFood" value="'.$row['type'].'">
                <button type="submit" class="btn btn-warning mt-2" name="updateFood" value="'.$row['food_id'].'">Update</button>
                </form>';
            echo '</div>';
            }
            if (isset($_POST['updateFood']))
            {
                $id = $_POST['updateFood'];
                $name = $_POST['nameFood'];
                $description = $_POST['descriptionFood'];
                $price = $_POST['priceFood'];
                $type = $_POST['typeFood'];
                $sql = "UPDATE foods SET food_name='$name',
                                         description = '$description',
                                         price = '$price',
                                         type = '$type' 
                        WHERE food_id = '$id'";
                if ($connection->query($sql) === TRUE) {
                    echo "<script>window.location.href='admin.php?success=3';</script>";
                }
                else
                    echo "Hiba";

            }

            ?>
        <div class="col-6 col-md-4 col-lg-2 text-center">Add city
            <hr class="border-top border-warning">
            <form method="POST" action="admin.php" enctype="multipart/form-data">
                <div>
                    <input class="form-control" type="file" name="image">
                </div>
                <input type="text" class="form-control" name="nameCity" placeholder="City name">
                <input type="text" class="form-control" name="postcode" placeholder="Postcode">
                <button type="submit" name="addcity" class="btn btn-warning mt-2">Add city</button>
            </form>
        </div>
        <div class="col-6 col-md-4 col-lg-2 text-center">Delete city
        <hr class="border-top border-warning">
            <form method="post">
                <select name="cityid" class="form-control">
            <?php
            $sql = "SELECT * from city";
            $result = $connection->query($sql);
            $row = $result->fetch_all(MYSQLI_ASSOC);
            {
                foreach ($row as $value)
                {
                    echo '<option value="'.$value['city_id'].'">'.$value['city'].'</option>';
                }
            }
            ?>
                </select>
                <button type="submit" name="deletecity" class="btn btn-warning mt-2">Delete city</button>
            </form>
        </div>
        <div class="col-6 col-md-4 col-lg-2 text-center">Add restaurant
        <hr class="border-top border-warning">
            <form method="post" action="admin.php">
                <input type="text" name="restaurantname" class="form-control" placeholder="Restaurant name">
                <select name="restaurantcity" class="form-control">
                    <?php
                    $sql = "SELECT * from city";
                    $result = $connection->query($sql);
                    $row = $result->fetch_all(MYSQLI_ASSOC);
                    {
                        foreach ($row as $value)
                        {
                            echo '<option value="'.$value['postcode'].'">'.$value['city'].'</option>';
                        }
                    }
                    ?>
                </select>
                <input type="text" name="addressrestaurant" class="form-control" placeholder="Address">
                <button type="submit" name="addrestaurant" class="btn btn-warning mt-2">Add restaurant</button>
            </form>
        </div>
        <div class="col-6 col-md-4 col-lg-2 text-center">Delete restaurant
        <hr class="border-top border-warning">
            <form method="post">
                <select name="restaurantId" class="form-control">
                    <?php
                    $sql = "SELECT * from restaurants";
                    $result = $connection->query($sql);
                    $row = $result->fetch_all(MYSQLI_ASSOC);
                    {
                        foreach ($row as $value)
                        {
                            echo '<option value="'.$value['restaurant_id'].'">'.$value['name'].'</option>';
                        }
                    }
                    ?>
                </select>
                <button type="submit" name="DeleteRestaurant" class="btn btn-warning mt-2">Delete restaurant</button>
            </form>
        </div>
        <div class="col-6 col-md-4 col-lg-2 text-center">Delete users
        <hr class="border-top border-warning">
            <form method="post">
                <select name="userID" class="form-control">
                    <?php
                    $sql = "SELECT * from users WHERE priviligies = 0";
                    $result = $connection->query($sql);
                    $row = $result->fetch_all(MYSQLI_ASSOC);
                    {
                        foreach ($row as $value)
                        {
                            echo '<option value="'.$value['id_user'].'">'.$value['username'].'</option>';
                        }
                    }
                    ?>
                </select>
                <button type="submit" name="DeleteUser" class="btn btn-warning mt-2">Delete user</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Kép</th>
                    <th scope="col">Név</th>
                    <th scope="col">Leírás</th>
                    <th scope="col">Étterem</th>
                    <th scope="col">Irányítószám</th>
                    <th scope="col">Ár</th>
                    <th colspan="2" scope="col" class="text-center">Gombok</th>

                </tr>
                </thead>
                <tbody>

                <?php
                $result = $connection->query("SELECT * from foods order by food_id DESC");
                $row = $result -> fetch_all(MYSQLI_ASSOC);
                foreach ($row as $food)
                {
                    echo '<tr><td><img width="100px" height="100px" src="pictures/'.$food['image'].'" alt="'.$food['food_name'].'"</td>
                        <td>'.$food['food_name'].'</td><td>'.$food['description'].'</td><td>'.$food['restaurant'].'</td>
                        <td>'.$food['postcode'].'</td><td>'.$food['price'].'</td>
                        <td><form method="post"> <button type="submit" name="delete" class="btn btn-warning" value="'.$food['food_id'].'">Delete</button></form></td>
                        <td><form method="post"> <button type="submit" class="btn btn-warning" name="update" value="'.$food['food_id'].'">Update</button></form></td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php

if (isset($_POST['uploadFood'])) {


    $foodname=$description=$price=$type=$restaurant="";
    $image = $_FILES['image']['name'];
    $foodname = $_POST['nameFood'];
    $description = $_POST['descriptionFood'];
    $price = $_POST['priceFood'];
    $type = $_POST['typeFood'];
    $restaurant = $_POST['restaurantFood'];
    $result = $connection->query("SELECT * from restaurants WHERE name = '$restaurant'");
    $row = $result->fetch_assoc();
    $postcode = $row['postcode'];

    // image file directory
    $target = "pictures/".basename($image);

    $sql = "INSERT INTO foods (food_name, description,postcode, price, restaurant, type, image) VALUES ('$foodname','$description','$postcode','$price','$restaurant','$type','$image')";
    // execute query
    $connection->query($sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "<script>window.location.href='admin.php?success=1';</script>";
    }else{
        echo "Nem sikerült feltölteni";
    }

    $connection->close();
}
if (isset($_POST['delete']))
{
    $id = $_POST['delete'];
    $sql = "DELETE from foods WHERE food_id = '$id'";
    if ($connection->query($sql) === TRUE)
    {
        echo "<script>window.location.href='admin.php?success=2';</script>";
    }
    $connection->close();
}
if (isset($_POST['addcity']))
{
    $cityname=$postcode="";
    $image = $_FILES['image']['name'];
    $cityname = $_POST['nameCity'];
    $postcode = $_POST['postcode'];
    // image file directory
    $target = "pictures/".basename($image);

    $sql = "INSERT INTO city (city, postcode, image) VALUES ('$cityname','$postcode','$image')";
    // execute query
    $connection->query($sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "<script>window.location.href='admin.php?success=1';</script>";
    }
}
if (isset($_POST['deletecity']))
{
    $id = $_POST['cityid'];
    $sql = "DELETE FROM city WHERE city_id = '$id'";
    if ($connection->query($sql) === TRUE) {
        echo "<script>window.location.href='admin.php?success=2';</script>";
    }
}
if (isset($_POST['addrestaurant']))
{
    $name = $_POST['restaurantname'];
    $city = $_POST['restaurantcity'];
    $address = $_POST['addressrestaurant'];
    $sql = "INSERT INTO restaurants (name, postcode, address)
                VALUES ('$name', '$city', '$address')";

    if ($connection->query($sql) === TRUE) {
        echo "<script>window.location.href='admin.php?success=1';</script>";
    }

}
if (isset($_POST['DeleteRestaurant']))
{
    $id = $_POST['restaurantId'];
    $sql = "DELETE FROM restaurants WHERE restaurant_id = '$id'";
    if ($connection->query($sql) === TRUE) {
        echo "<script>window.location.href='admin.php?success=2';</script>";
    }
}
if (isset($_POST['DeleteUser']))
{
    $id = $_POST['userID'];
    $sql = "DELETE FROM users WHERE id_user = '$id'";
    if ($connection->query($sql) === TRUE) {
        echo "<script>window.location.href='admin.php?success=2';</script>";
    }
}
?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

</body>
</html>
