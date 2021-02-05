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
    <link rel="stylesheet" href="css/index.css">
    <script>
       function show()
       {
           $('#restaurant').toggle();
       }
    </script>
</head>
<body>
<?php include("nav.php");
?>
<div class="container-fluid">
    <div class="row mb-5 pb-5">
        <div class="col-lg-6 col-md-12 col-sm-12 text-white" id="search">

            <form method="post">
                <input id="CityAndPost" type="text" name="cityorpostcode" placeholder="Település vagy irányítószám">
                <button type="submit" name="search" class='btn btn-warning mb-2 ml-3'>Keresés</button>
            </form>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 text-left mt-3 text-white">
            <img class="img-fluid" src="pictures/ff.png" alt="food">
        </div>
    </div>
    <hr>
    <div class="row mt-5">
        <div class="col-lg-12 col-md-12 col-sm-12 mt-5 mb-5 text-center">
            <h1>Települések</h1>
        </div>
    </div>
    <div class="row">
        <?php
        include("db_config.php");
        global $connection;
        if (isset($_POST['search'])) {
            $param = "%{$_POST['cityorpostcode']}%";
            $stmt = $connection->prepare("SELECT * FROM city WHERE city LIKE ? or postcode LIKE ? LIMIT 1");
            $stmt->bind_param("ss", $param, $param);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            foreach ($result as $key => $value) {
                echo "<div class='offset-4 col-4 w-75' id='card'>
            <div class='card mt-3 mb-2'>
                <div class='card-block' id='cards'>
                    <div id='image'>
                        <img src='pictures/" . $value['image'] . "' alt='" . $value['city'] . "' id='images' class='img-fluid'>
                    </div>
                    <div class='card-title text-center pt-1'>
                        <h4>" . $value['city'] . "</h4>
                    </div>
                  
                    <button class='btn btn-warning btn-block' id='show' onclick='show()'>Éttermek mutatása</button>
                   
                </div>
                <div id='restaurant'>";
                $city = $value['city'];
                $result = $connection->query("SELECT name, address 
                        FROM city 
                        JOIN restaurants 
                        ON city.postcode = restaurants.postcode WHERE city = '$city'");
                $row = $result->fetch_all(MYSQLI_ASSOC);
                echo '<table class="text-left w-100"><tr><th>Név</th><th>Cím</th></tr>';
                foreach ($row as $value) {
                    echo '<tr>';
                    foreach ($value as $asd) {
                        echo '<td>' . $asd . '</td>';
                    }
                    echo '</tr>';
                }


                echo '</table></div>';
                echo " </div>
       </div>";
            }
        } else {
            $result = $connection->query("SELECT * from city");

            foreach ($result as $key => $value) {
                echo "<div class='col-lg-3 col-md-6 col-sm-12' id='card'>
            <div class='card mt-3 mb-2'>
                <div class='card-block' id='cards'>
                    <div id='image'>
                        <img src='pictures/" . $value['image'] . "' alt='" . $value['city'] . "' id='images' width='100%' class='img-fluid'>
                    </div>
                    <div class='card-title text-center pt-1'>
                        <h4>" . $value['city'] . "</h4>
                    </div>
                   
                </div>
            </div>
        </div>";
            }
        }
        ?>


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
<?php
include("footer.php");
?>
</body>
</html>