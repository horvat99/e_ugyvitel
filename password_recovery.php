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
    <link rel="stylesheet" href="css/password_recovery.css">
    <script src="js/checkInputs.js"></script>
</head>
<body>
<?php include("nav.php");

include("db_config.php");
include("LoginSystem.php");
if (isset($_POST['forget'])) {
    $forget = new LoginSystem($_POST);
    if ($forget->checkEmail()==true){
    $forget->PasswordRecovery();
    }
    else
    {
        Header("location: password_recovery.php?error=1");
    }
}?>
<div class="container-fluid">
    <div class="container border-left border-warning mb-0" id="login">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 p-0 text-dark text-center">
                <img src="pictures/food2.jpg" alt="food" id="regpic">
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12
         col-md-12 col-sm-12 text-dark text-center">
                <h2 class="mb-5">Jelszó emlékezető</h2>
            </div>
        </div>
        <div class="row pb-1">

            <div class="col-lg-12
         col-md-12 col-sm-12 text-dark text-center pl-0">

                <form method="post" id="register">
                    <div class="row ml-3 mr-3 mb-3">
                        <div class="col">
                            <div class="row">
                                <div class="offset-3 col-6">
                            Kérjük, add meg az e-mail címed, amellyel oldalunkra regisztráltál.  A megadott címre
                            küldünk egy linket, amelyre kattintva jelszavad módosíthatod!
                                </div>

                            </div>
                            <hr class="offset-3 col-6 bg-warning">
                            <div class="row mt-4">
                            <div class="offset-3 col-4">
                            <input type="text" class="form-control " placeholder="E-mail cím" name="email">
                            </div>
                            <div class="col-2">
                                <input type="submit" class="btn btn-warning btn-block mb-3" name="forget" value="Küldés">
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    if (isset($_GET['succes']))
                                        if ($_GET['succes'] == 1)
                                        {
                                            echo "A megadott címre elküldtük a linket ahol újra állíthatja jelszavát!";
                                        }
                                    if (isset($_GET['error']))
                                        if ($_GET['error'] == 1)
                                        {
                                            echo "Nincs ilyen e-mail címmel regisztrált felhasználó!";
                                        }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 p-0 text-dark text-center">
            <img src="pictures/food3.jpg" alt="food" id="regpic">
        </div>
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

