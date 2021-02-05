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
if (!isset($_SESSION['username']))
    Header("Location: login.php");
else{
?>
<div class="container-fluid">
    <div class="row h-100">
        <div class="col-12 text-center mt-5 pt-5">
            <?php
            include ("db_config.php");
            global $connection;
            if (isset($_GET['order']))
            {
                if (isset($_GET['order']) == 1)
                {
                    $city = $_POST['city'];
                    $address= $_POST['address'];
                    $foodsarray = [];
                    $foodsarrayid =[];
                    $foodsarrayname =[];
                    $restaurants =[];
                    $totalprice = 0;
                    foreach ($_SESSION['shopping_cart'] as $item)
                    {
                        $helper="";
                        $helper = $item['product_name']." x ".$item['product_quantity'];
                        array_push($foodsarray,$helper);
                        array_push($foodsarrayid,$item['product_id']);
                        array_push($foodsarrayname,$item['product_name']);
                        $totalprice += ($item['product_price'] * $item['product_quantity']);
                    }
                    $totalprice += 200;
                    $foods = implode(", ",$foodsarray);
                    $ids = implode(",",$foodsarrayid);
                    $foodsname = implode(", ",$foodsarrayname);
                    $stmt = $connection->prepare("INSERT INTO orders (username,food_id, food_name, food_name_quantity, price, time_arrived,city, address) 
                        VALUES (?,?,?,?,?,DATE_ADD(NOW(), INTERVAL 1 HOUR),?,?)");
                    $stmt ->bind_param("sssssss",$_SESSION['username'],$ids,$foodsname,$foods,$totalprice,$city,$address);
                    $stmt ->execute();
                    $stmt ->close();

                    ?>
                    <script>
                        // Set the date we're counting down to
                        var onehour = new Date();
                        onehour.setHours( onehour.getHours() + 1 );

                       var countDownDate = new Date(onehour).getTime();

                        // Update the count down every 1 second
                        var x = setInterval(function() {

                            // Get today's date and time
                            var now = new Date().getTime();

                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

                            // Time calculations for days, hours, minutes and seconds
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Output the result in an element with id="demo"
                            document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";

                            // If the count down is over, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("demo").innerHTML = "Megérkezett!";
                            }
                        }, 1000);
                    </script>

                    <?php
                    unset($_SESSION['shopping_cart']);
                    echo "<h1><i class='fas fa-check'></i> Ön sikeresen megrendelte ételét! Jóétvágyat!</h1><br><h1><i class='fas fa-stopwatch'></i></h1>";
                    echo "<h2>Már csak ennyit kell várnia:<p id='demo'></p></h2>";

                }

            }
            if (isset($_GET['exit'])){
            if (isset($_GET['exit']) == "1")
            {
                unset($_SESSION['shopping_cart']);
                echo "<h1><i class='fas fa-frown-open'></i> Kosara kiürítve!</h1>";
            }}
            ?>
        </div>

    </div>
</div>
<?php
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
