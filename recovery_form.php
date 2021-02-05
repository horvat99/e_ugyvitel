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
    <script src="js/checkInputs.js"></script>
</head>
<body>
<?php include("nav.php"); ?>
<div class="container-fluid">
    <div class="container border-left border-warning" id="login">
        <form method="post">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 p-0 text-dark text-center">
                <img src="pictures/food2.jpg" alt="food" id="regpic">
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12
         col-md-12 col-sm-12 text-dark text-center">
                <h2 class="mb-5">Jelszó csere!</h2>
            </div>
        </div>
        <div class="row ml-3 mr-3 mb-3">
            <div class="offset-3 col-6">
                <input type="password" class="form-control " placeholder="Jelszó" name="password">
            </div>
        </div>
        <div class="row ml-3 mr-3 mb-3">
            <div class="offset-3 col-6">
                <input type="password" class="form-control " placeholder="Jelszó újra" name="password_ver">
            </div>
        </div>
        <div class="row ml-3 mr-3">
            <div class="offset-4 col-4">
                <input type="submit" class="btn btn-warning btn-block mt-1 mb-3" value="Küldés" name="login">
            </div>
        </div>
            <?php
            include ("db_config.php");
            include ("config.php");
            global $connection;
            $stmt = $connection -> prepare("SELECT * FROM users  WHERE binary code_password = ?
                                          AND new_password_expires>now()");
            $stmt -> bind_param('s',$_GET['code']);
            $stmt -> execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            if ($result) {


            if (isset($_POST['login'])){
                $pass = $_POST['password'];
                $pass_ver = $_POST['password_ver'];

            if ($pass == $pass_ver)
            {
                $password_new = SALT1 . $pass . SALT2;
                $passMD5 = MD5($password_new);//new_password volt... 65.sor
                $stmt = $connection->prepare("UPDATE users SET password = ?, code_password = '' WHERE binary code_password = ?
                                          AND new_password_expires>now()");
                $stmt -> bind_param("ss",$passMD5,$_GET['code']);
                $stmt -> execute();
                if ($stmt->affected_rows>0) {
                    Header("Location: login.php?succes=1");
                    //include ("recovery_form.php");

                }
                else
                {
                    echo "vmi nemjo";
                }
                $stmt -> close();
            }
            else
                {
                    echo '<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 p-0 text-dark text-center">
                A két jelszó nem egyezik meg!
            </div>
        </div>';
                }
            }}
            $stmt -> close();
            ?>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 p-0 text-dark text-center">
                <img src="pictures/food3.jpg" alt="food" id="regpic">
            </div>
        </div>
        </form>
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