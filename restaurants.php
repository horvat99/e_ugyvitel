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
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<?php include("nav.php");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center mt-5">
            <h2 class="pb-5">Elérhető éttermeink listája</h2>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Név</th>
                    <th scope="col">Város</th>
                    <th scope="col">Cím</th>
                </tr>
                </thead>
                <tbody>
                <?php
                include ("db_config.php");
                global $connection;
                $result = $connection->query("SELECT restaurants.restaurant_id, restaurants.name, restaurants.address, city.city 
                from restaurants JOIN city on restaurants.postcode = city.postcode order by restaurants.restaurant_id ASC");
                foreach ($result as $key => $value)
                {
                    echo '<tr>
                <th scope="row">'.$value['restaurant_id'].'</th>
                <td>'.$value['name'].'</td>
                <td>'.$value['city'].'</td>
                <td>'.$value['address'].'</td>
            </tr>';
                }
                ?>
                </tbody>
            </table>
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
<?php
include("footer.php");
?>
</body>
</html>
