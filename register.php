<?php
session_start();
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
    <link rel="stylesheet" href="css/register.css">
    <script>
        function reload() {
            window.location.href = "register.php";
        }
    </script>
</head>
<body>
<?php
include("nav.php");
include("db_config.php");
include("LoginSystem.php");
$register = new LoginSystem($_POST);
if (isset($_POST['delete'])) {
    session_unset();
    session_destroy();
    Header("Location: register.php");
}
if (isset($_POST['register'])) {
    if ($register->validate() == true) {
        if (!$register->existsUser()) {
            if (!$register->checkEmail())
            {
                $register->registerUser();
            }
            else
            {
                Header("Location: register.php?succes=5");
            }

        } else {
            Header("Location: register.php?succes=0");
        }
    }
}
?>
<div class="container-fluid">
    <div class="container border-left border-warning pb-5 mb-0" id="login">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 p-0 text-dark text-center">
                <img src="pictures/food2.jpg" alt="food" id="regpic">
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12
         col-md-12 col-sm-12 text-dark text-center">
            <h2 class="mb-5">Regisztráció</h2>
        </div>
        </div>
    <div class="row">

        <div class="col-lg-12
         col-md-12 col-sm-12 text-dark text-center pl-0">

                <form method="post" id="register">
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                            <input type="text" class="form-control " placeholder="Vezetéknév" name="lastname"
                                   value="<?php echo isset($_SESSION['InputLastname']) ? $_SESSION['InputLastname'] : ''; ?>">
                            <?php

                            if (isset($_GET['lastname_error'])) {
                                if ($_GET['lastname_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Keresztnév" name="firstname"
                                   value="<?php echo isset($_SESSION['InputFirstName']) ? $_SESSION['InputFirstName'] : ''; ?>">
                            <?php

                            if (isset($_GET['firstname_error'])) {
                                if ($_GET['firstname_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Város" name="city"
                                   value="<?php echo isset($_SESSION['InputCity']) ? $_SESSION['InputCity'] : ''; ?>">
                            <?php

                            if (isset($_GET['city_error'])) {
                                if ($_GET['city_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Cím" name="adress"
                                   value="<?php echo isset($_SESSION['InputAdress']) ? $_SESSION['InputAdress'] : ''; ?>">
                            <?php

                            if (isset($_GET['adress_error'])) {
                                if ($_GET['adress_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Telefonszám" name="phone"
                                   value="<?php echo isset($_SESSION['InputPhone']) ? $_SESSION['InputPhone'] : ''; ?>">
                            <?php

                            if (isset($_GET['phone_error'])) {
                                if ($_GET['phone_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="E-mail" name="email"
                                   value="<?php echo isset($_SESSION['InputEmail']) ? $_SESSION['InputEmail'] : ''; ?>">
                            <?php

                            if (isset($_GET['email_error'])) {
                                if ($_GET['email_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Felhasználónév" name="username"
                                   value="<?php echo isset($_SESSION['InputUsername']) ? $_SESSION['InputUsername'] : ''; ?>">
                            <?php

                            if (isset($_GET['username_error'])) {
                                if ($_GET['username_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                            <input type="password" class="form-control" placeholder="Jelszó" name="password">
                            <?php

                            if (isset($_GET['password_error'])) {
                                if ($_GET['password_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                        <div class="col">
                            <input type="password" class="form-control" placeholder="Jelszó megerősítés" name="password_ver">
                            <?php

                            if (isset($_GET['password_ver_error'])) {
                                if ($_GET['password_ver_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                            <div class="row">
                            <div class="col-3">
                            <img src="captcha.php" border="0" alt="code">
                            </div>
                            <div class="col-9">
                            <input type="text" class="form-control" placeholder="Biztonsági kód" name="captcha">
                            </div>
                            </div>
                            <?php

                            if (isset($_GET['captcha_error'])) {
                                if ($_GET['captcha_error'] == 1)
                                    echo "<span style=color:red>Kötelező kitölteni</span>";
                            }
                            ?>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <input type="submit" class="btn btn-warning btn-block mt-1 mb-3" name="register"
                                           value="Regisztráció">
                                </div>
                                <div class="col-6">
                                    <input type="submit" class="btn btn-warning btn-block mt-1 mb-3" name="delete"
                                           value="Töröl">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                        Van már fiókja? <a style="color: #999900" class="reg" href="login.php">Lépjen
                            be!</a>
                        </div>
                    </div>
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                            <?php
                            if (isset($_GET['succes'])) {
                                if ($_GET['succes'] == 1)
                                    echo "Sikeresen regisztrált!";
                            }
                            if (isset($_GET['succes'])) {
                                if ($_GET['succes'] == 0)
                                    echo "<span style=color:red>Felhasználónév foglalt</span>";
                            }
                            if (isset($_GET['succes'])) {
                                if ($_GET['succes'] == 5)
                                    echo "<span style=color:red>Email cim foglalt</span>";
                            }
                            if (isset($_GET['captcha_error'])) {
                                if ($_GET['captcha_error'] == 2)
                                    echo "<span style=color:red>Helytelen biztonsági kód</span>";
                            }
                            if (isset($_GET['password_match'])) {
                                if ($_GET['password_match'] == 1)
                                    echo "<span style=color:red>A két jelszó nem egyezik meg!</span>";
                            }
                            ?>

                        </div>
                    </div>
                </form>
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
<?php
//include("footer.php");
?>
</body>
</html>


