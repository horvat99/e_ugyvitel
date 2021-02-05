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
        function show(x)
        {
            $(x).toggle();
        }
    </script>
</head>
<body>
<?php include("nav.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include ("functions.php");
include ("db_config.php");
global $connection;
if (!isset($_SESSION['username']))
    Header("Location: login.php");
?>
<div class="container-fluid">
    <div class="row h-100">
        <div class="col-lg-2 col-md-12 pt-0 mt-3 h-100">
            <div class="row">
                <div class="col-12 text-center pt-3">
                    <?php
                    echo "Aktív felhasználó: " . $_SESSION['username'];
                    ?>
                </div>
                <div class="col-12 mt-1">
                    <button class="class='btn btn-warning w-100" onclick="show('#firstsection')">Elhozom.hu</button>
                </div>
                <div class="col-12 mt-1">
                    <button onclick="myFunction()" class="class='btn btn-warning w-100">Kezdőlap</button>
                </div>
                <script>
                    function myFunction()
                    {
                        location.replace("http://localhost/Ehesvagyok/index.php")
                    }
                </script>
                <div class="col-12 mt-1">
                    <a href="restaurants.php"><button class="class='btn btn-warning w-100">Éttermek</button></a>
                </div>
                <div class="col-12 mt-1">
                    <a href="foods.php"><button class="class='btn btn-warning w-100">Ételek</button></a>
                </div>
                <div class="col-12 mt-1">
                    <button class="class='btn btn-warning w-100" onclick="show('#secondsection')">Kosár</button>
                </div>
                <div class="col-12 mt-1">
                    <button class="class='btn btn-warning w-100" onclick="show('#thirdsection')">Rendeléseim</button>
                </div>
                <div class="col-12 mt-1">
                    <button class="class='btn btn-warning w-100" onclick="show('#fourthsection')">Osztályzás</button>
                </div>
                <?php
                $stmt = $connection->prepare("SELECT priviligies from users where username = ?");
                $stmt -> bind_param("s",$_SESSION['username']);
                $stmt -> execute();
                $stmt -> bind_result($priv);
                $stmt -> fetch();
                $stmt -> close();
                if ($priv==1)
                {
                    echo '<div class="col-12 mt-1">
                    <a href="admin.php"><button class="class=btn btn-warning w-100">Szerkesztés</button></a>
                </div>';
                }
                ?>

                <div class="col-12 mt-1">
                    <a href="login.php?logout=1"><button class="class='btn btn-warning w-100">Kijelentkezés</button></a>
                </div>
                <div class="col-12 mt-1 text-center">
                    <b>Készítette:</b>
                    <img src="qr.php" alt="qr code" width="100px" height="100px">
                </div>

            </div>
        </div>
        <div class="col-lg-10 col-md-12 mt-5 p-5 text-center">
            <div id="firstsection">
            <h3>
            <?php
            if (isset($_GET['success']))
            {
                echo "<p class='pb-5'>Véleményét rögzítettük, köszönjük!</p>";
            }
            $username = $_SESSION['username'];
            $ip = getIpAdress();
            $country = getCountryByIp();
            $result = $connection-> query("SELECT lastTime_loggedin FROM users where username = '$username'");
            $row = $result->fetch_assoc();
            $result -> free_result();


            echo "<p class='bg-warning p-5 text-left'><i class='fas fa-sign-in-alt'></i>&nbsp;&nbsp;&nbsp;
            Az ön utolsó bejelentkezése ".$row['lastTime_loggedin'] ."-kor volt, " . $ip . " címről, 
            ebből az országból: ".$country."</p>";

            ?>
            </h3>
                <hr>
            </div>
            <div id="secondsection" style="display: none">
                <h3 class="mt-3 mb-3">Kosár</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" width="10%">Étel azonosító</th>
                        <th scope="col" width="30%">Étel</th>
                        <th scope="col" width="10%">Mennyiség</th>
                        <th scope="col" width="20%">Ár</th>
                        <th scope="col" width="30%">Összesen</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                if (isset($_SESSION['shopping_cart'])){
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
                }
                else
                {
                    echo '<tr><td colspan="5">Az ön kosara üres!</td></tr>';
                }

                if (isset($_SESSION['shopping_cart'])){
                    $total = $totalprice+$delivery;
                echo '
                    <tr>

                        <td colspan="3" align="left"><h4>Összeg + házhozszállítás: '. $total .' rsd</h4></td>
                        <td align="right" colspan="2"><a href="preorder.php"><button type="submit" name="pay" class="btn btn-warning">Rendel</button></a>
                        <a href="ordered.php?exit=1"><button type="submit" name="cancel" class="btn btn-warning">Töröl</button></td></a>

                    </tr>';}
                ?>

                    </tbody>
                </table>
                <hr>
            </div>
            <div id="thirdsection" style="display: none">
                <h3 class="mt-3 mb-3">Rendeléseim</h3>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" width="40%">Étel és mennyiség</th>
                        <th scope="col" width="30%">Fizetett összeg</th>
                        <th scope="col" width="30%">Érkezési idő</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                $stmt =$connection->prepare("SELECT * from orders WHERE username = ?");
                $stmt -> bind_param("s",$_SESSION['username']);
                $stmt -> execute();
                $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                foreach ($result as $value)
                {
                    echo '<tr>
                    <td>'.$value['food_name_quantity'].'</td>
                    <td>'.$value['price'].'</td>
                    <td>'.$value['time_arrived'].'</td>
                    </tr>';
                }
                ?>
                    </tbody>
                </table>

            </div>
            <div id="fourthsection" style="display: none">
                <h3 class="mt-3 mb-3">Vélemény és osztályzás</h3>

                <?php
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
                echo '<form action="">
                <select name="foods" onchange="showFoods(this.value)">
                <option value="">Mit szeretnél osztályozni?</option>';
                $user = $_SESSION['username'];

                foreach ($FoodID as $id)
                {
                    $stmt = $connection->prepare("SELECT food_name, restaurant from foods WHERE food_id = ?");
                    $stmt -> bind_param("s",$id);
                    $stmt ->execute();
                    $stmt -> bind_result($nameoffood,$restaurant);
                    $stmt -> fetch();
                    $stmt -> close();
                    $sql = "SELECT * FROM comments WHERE food_id = '$id' AND user = '$user'";
                    $result = $connection->query($sql);
                    if ($result->num_rows<1){
                    echo '<option value="'.$id.'">'.$nameoffood.'-'.$restaurant.'</option>';
                    }
                }
                echo '</select></form>';
                ?>
                <br>
                <div id="txtHint"></div>
                <script>
                    function showFoods(str) {
                        var xhttp;
                        if (str == "") {
                            document.getElementById("txtHint").innerHTML = "";
                            return;
                        }
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("txtHint").innerHTML = this.responseText;
                            }
                        };
                        xhttp.open("GET", "getfood.php?q="+str, true);
                        xhttp.send();
                    }
                </script>
                <?php
                if (isset($_POST['add']))
                {

                    $id = $_POST['add'];
                    $mark = $_POST['mark'];
                    $comment = $_POST['comment'];
                    $fn = $_POST['name'];
                    $ret = $_POST['restaurant'];
                    if (!empty($id) && !empty($mark) && !empty($comment))
                    {
                        $stmt = $connection->prepare("INSERT INTO comments (food_name,restaurant,food_id,comment,mark,user)
            VALUES (?,?,?,?,?,?)");
                        $stmt -> bind_param("ssssss",$fn,$ret,$id,$comment,$mark,$_SESSION['username']);
                        $stmt -> execute();
                        if ($stmt->affected_rows)
                        {
                            echo "<script>window.location.href='LogedIn.php?success=1';</script>";
                            exit();
                            //echo "Véleményét rögzítettük, köszönjük!";
                        }

                    }

                }
                ?>
            </div>
        </div>

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
