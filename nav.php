<?php
require_once("Mobile-Detect-2.8.34/Mobile_Detect.php");
?>
<nav class="navbar navbar-expand-lg navbar-light bg-warning">
    <a class="navbar-brand" href="#"><i class="fas fa-utensils"></i> Elhozom.hu </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Kezdőlap</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="restaurants.php">Éttermek</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="foods.php">Ételek</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="LogedIn.php">Fiók</a>
            </li>
            <li class="nav-item">
                <?php
                session_start();
                if (!isset($_SESSION['username']))
                    echo '<a class="nav-link" href="login.php">Bejelentkezés</a>';
                else{
                    echo '<a class="nav-link" href="login.php?logout=1">Kijelentkezés</a>';
                }

                ?>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Regisztráció</a>
            </li>
        </ul>
        <form method="post" action="index.php" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" name="cityorpostcode" placeholder="Település" aria-label="Search">
            <button class="btn btn-outline-dark my-2 my-sm-0" name="search" type="submit">Keresés</button>
        </form>
    </div>
</nav>