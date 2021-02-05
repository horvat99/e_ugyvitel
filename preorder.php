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
    <link rel="stylesheet" href="css/loggedIn.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    </script>
</head>
<body>
<?php
include ("nav.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="container-fluid">
<div class="offset-4 col-4 text-center mt-5 pt-5">
    <?php
        if (!isset($_SESSION['username']))
        {
            Header("Location: login.php");
        }
        if (empty($_SESSION['shopping_cart']))
        {
            Header("Location: foods.php?carterror=1");
        }
        include ("db_config.php");
        global $connection;
        $stmt = $connection->prepare("SELECT city, adress FROM users WHERE username = ?");
        $stmt -> bind_param("s",$_SESSION['username']);
        $stmt -> execute();
        $stmt -> bind_result($city,$address);
        $stmt -> fetch();
        $stmt -> close();
        echo '<table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" width="10%">Étel azonosító</th>
                        <th scope="col" width="30%">Étel</th>
                        <th scope="col" width="10%">Mennyiség</th>
                        <th scope="col" width="20%">Ár</th>
                        <th scope="col" width="30%">Összesen</th>
                    </tr>
                    </thead>
                    <tbody>';
         $totalprice =0;
                $delivery = 200;
                    foreach ($_SESSION['shopping_cart'] as $item)
                    {
                        echo '<tr>';
                        echo '<td>'.$item['product_id'].'</td>';
                        echo '<td>'.$item['product_name'].'</td>';
                        echo '<td>'.$item['product_quantity'].'</td>';
                        echo '<td>'.$item['product_price'].'</td>';
                        echo '<td>'.$item['product_price'] * $item['product_quantity'].'</td>';
                        echo '</tr>';
                        $totalprice += ($item['product_price'] * $item['product_quantity']);
                    }
            $total = $totalprice+$delivery;
                echo '
                    <tr>

                        <td colspan="5" align="left"><h4>Összeg + házhozszállítás: '. $total .' rsd</h4></td>
                     

                    </tr>';
                echo '</tbody></table>';
        echo '<form method="post" action="ordered.php?order=1">
        <div class="form-group">
        <label for="address">Cím:</label><input id="address" class="form-control" type="text" name="address" value="'.$address.'"><br>
        <label for="city">Város:</label><input id="city" class="form-control mb-4" type="text" name="city" value="'.$city.'">
        <button type="submit" name="pay" class="btn btn-warning">Rendel</button>
        </div>
    </form>';

    ?>
    <a href="foods.php"><button type="submit" name="cancel" class="btn btn-warning">Vissza</button></td></a>


</div>
</div>
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
