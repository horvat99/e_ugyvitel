<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('database_connection.php');
global $connect;

?>

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
    <script src="js/foods.js"></script>
    <link rel="stylesheet" href="css/foods.css">
</head>

<body>
<?php
include ("nav.php");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-5 text-left mt-3">
            <a id="cart-popover" data-placement="bottom" title="Kosár"><button class="btn btn-warning border border-dark" id="showcart"><i class="fas fa-shopping-cart"></i>
                </button></a>&nbsp;<?php
            if (isset($_GET['carterror']))
            {
                if ($_GET['carterror'] == 1)
                {
                    echo "Üres a kosara.";
                }
            }
            ?>
            <div id="popover_content_wrapper" class="border border-dark" style="display: none">
                <span id="cart_details"></span>
                <div class="text-left pt-0 pl-1 pb-1">
                    <a href="preorder.php" class="btn btn-warning" id="check_out_cart">Fizet
                    </a>
                    <a href="#" class="btn btn-warning" id="clear_cart">Töröl
                    </a>
                </div>
            </div>
            <script>

            </script>
            <div id="display_item">


            </div>
        </div>
        <div class="col-7 text-left mt-3">
            <h1><i class="fas fa-search"></i>&nbsp;&nbsp;Keresés</h1>
        </div>

    </div>
    <div class="row">


        <div class="col-2 mt-5">
            <div class="list-group">
                <h5 class="text-left ml-1">Város:</h5>
                <?php
                if(isset($_SESSION['username'])){
                $username = $_SESSION['username'];
                $stmt = $connect -> prepare("SELECT city from users WHERE username = '$username'");
                $stmt -> execute();
                $city = $stmt -> fetch();
                }
                $query = "
                    SELECT DISTINCT postcode,city FROM city
                    ";
                $statement = $connect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                foreach($result as $row)
                {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" <?php if(isset($_SESSION['username']))
                        {
                            if ($city['city']==$row['city']){
                            echo 'Checked';
                            }
                        }
                        ?> class="common_selector postcode" value="<?php echo $row['postcode']; ?>" > <?php echo $row['city']; ?></label>
                    </div>
                    <?php
                }

                ?>
            </div>
            <div class="list-group mt-3">
                <h5 class="text-left ml-1">Éttermek:</h5>
                <?php
                $query = "
                    SELECT DISTINCT(restaurant) FROM foods WHERE product_status = '1'
                    ";
                $statement = $connect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                foreach($result as $row)
                {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector restaurant" value="<?php echo $row['restaurant']; ?>"  > <?php echo $row['restaurant']; ?></label>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="list-group mt-3">
                <h5 class="text-left ml-1">Étel fajta:</h5>
                <?php
                $query = "
                    SELECT DISTINCT(type) FROM foods WHERE product_status = '1'
                    ";
                $statement = $connect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                foreach($result as $row)
                {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector type" value="<?php echo $row['type']; ?>"  > <?php echo $row['type']; ?></label>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

            <div class="col-10 filter_data mt-5">
            </div>
        </div>
    </div>

<?php
include ("footer.php");
?>
</body>
</html>
