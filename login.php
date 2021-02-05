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
<?php include("nav.php");
include("db_config.php");
include("LoginSystem.php");
global $connection;
if (isset($_GET['logout']))
{
    if ($_GET['logout'] == 1){
        $username = $_SESSION['username'];
        $result = $connection-> query("SELECT lastTime_loggedin_new FROM users where username = '$username'");
        $row = $result->fetch_assoc();
        $dateTime = $row['lastTime_loggedin_new'];
        $sql = "UPDATE users SET lastTime_loggedin='$dateTime' WHERE username =  '$username'";
        $connection->query($sql);
        session_unset();
        session_destroy();
    }
}
if (isset($_POST['login'])) {
    if (isset($_POST['SaveUsername']))
    {
        if ($_POST['SaveUsername'] == "save")
        {
            setcookie("username", $_POST['username'], time() + (86400 * 7));
        }

    }

    $login = new LoginSystem($_POST);
    if ($login->checkPassandUser() == true) {
        $sql = "UPDATE users SET lastTime_loggedin_new=now()";
        $connection->query($sql);
        $_SESSION['username'] = $_POST['username'];
        Header('location: LogedIn.php');

    }
    else
        Header("location: login.php?error=1");
}?>
<div class="container-fluid">
    <div class="container border-left border-warning mb-0 mt-4" id="login">
        <form method="post">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 p-0 text-dark text-center">
                <img src="pictures/food2.jpg" alt="food" id="regpic">
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12
         col-md-12 col-sm-12 text-dark text-center">
                <h2 class="mb-5">Bejelentkezés</h2>
            </div>
        </div>
        <div class="row ml-3 mr-3 mb-3">
            <div class="offset-3 col-6">
                <input type="text" class="form-control " placeholder="Felhasználónév" name="username" <?php
                if (isset($_COOKIE["username"]))
                    echo 'value = "' .$_COOKIE["username"] . '"';
                ?> >
            </div>
        </div>
        <div class="row ml-3 mr-3 mb-3">
            <div class="offset-3 col-6">
                <input type="password" class="form-control " placeholder="Jelszó" name="password">
            </div>
        </div>
            <div class="row ml-3 mr-3">
                <div class="offset-4 col-4">
                    <input type="checkbox" name="SaveUsername" checked value="save" class="ml-5 mr-3 mb-3">Felhasználónév megjegyzése
                </div>
            </div>
        <div class="row ml-3 mr-3">
            <div class="offset-4 col-4">
                <input type="submit" class="btn btn-warning btn-block mt-1 mb-3" value="Bejelentkezés" name="login">
            </div>
        </div>
        <div class="row ml-3 mr-3">
            <div class="offset-4 col-4 text-center">
                Nincs fiókja? Itt tud <a href="register.php">Regisztrálni!</a>
            </div>
        </div>
        <div class="row ml-3 mr-3 mb-1">
            <div class="offset-4 col-4 text-center">
                <a href="password_recovery.php">Jelszó emlékeztető</a>
            </div>
        </div>
        <div class="row ml-3 mr-3">
            <div class="offset-4 col-4 text-center">
                <?php
                if (isset($_GET['active']))
                    if ($_GET['active'] == 1)
                    {
                        echo "Sikeresen aktiválta fiókját, mostmár be tud jelentkezni!";
                    }
                if (isset($_GET['succes']))
                    if ($_GET['succes'] == 1)
                    {
                        echo "Jelszavát sikeresen megváltoztatta!";
                    }
                if (isset($_GET['error']))
                    if ($_GET['error'] == 1)
                    {
                        echo "Hibás felhasználónév vagy jelszó!";
                    }
                if (isset($_GET['logout']))
                {
                    if ($_GET['logout'] == 1) {
                    echo "Sikeresen kijelentkezett!";
                }}



                ?>
            </div>
        </div>

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
//include("footer.php");
?>
</body>
</html>

