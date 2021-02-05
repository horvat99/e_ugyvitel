<!-- Footer -->
<footer class="page-footer font-small unique-color-dark mt-5 bg-warning pt-3">

    <!-- Footer Links -->
    <div class="container text-center text-md-left mt-5">

        <!-- Grid row -->
        <div class="row mt-3">

            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

                <!-- Content -->
                <h6 class="text-uppercase font-weight-bold">Elhozom.hu</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>Legyen szó reggeli kávéról, hétköznapi ebédről a kollégáiddal, egy gyors bevásárlásról,
                    egy romantikus vacsoráról, vagy akár titkos éjjeli snackről: az Elhozom.hu-ról minden alkalomra rendelhetsz.</p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

                <!-- Links -->
                <h6 class="text-uppercase font-weight-bold">Főbb települések</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>
                    <a href="#!">Óbecse</a>
                </p>
                <p>
                    <a href="#!">Szabadka</a>
                </p>
                <p>
                    <a href="#!">Temerin</a>
                </p>
                <p>
                    <a href="#!">Újvidék</a>
                </p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

                <!-- Links -->
                <h6 class="text-uppercase font-weight-bold">Főbb linkek</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>
                    <a href="#!">Kezdőlap</a>
                </p>
                <p>
                    <a href="#!">Rólunk</a>
                </p>
                <p>
                    <a href="#!">Bejelentkezés</a>
                </p>
                <p>
                    <a href="#!">Regisztráció</a>
                </p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

                <!-- Links -->
                <h6 class="text-uppercase font-weight-bold">Kontakt</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 80px;">
                <p>
                    <i class="fas fa-home mr-3"></i> Óbecse, Zöldfás utca 12</p>
                <p>
                    <i class="fas fa-envelope mr-3"></i> info@elhozom.hu</p>
                <p>
                    <i class="fas fa-phone mr-3"></i> + 381 64 12 59 045</p>
                <p>
                    <i class="fas fa-print mr-3"></i> + 381 21 6919 199</p>

            </div>
            <!-- Grid column -->

        </div>
        <!-- Grid row -->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3" style="background-color: #DAA520">
        <?php

        $header_ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        $keywords = array("nokia", "touch", "samsung", "sonyericsson", "alcatel", "panasonic", "tosh", "benq", "sagem", "android", "iphone", "berry", "palm", "mobi", "lg", "symb", "kindle", "phone");
        $keywordsComputer = array("windows", "linux");
        $mobile = false;
        $computer = false;
        $match = "";
        $deviceType = "";
        foreach ($keywords as $keyword) {
            if (strpos($header_ua, $keyword) !== false) // http://php.net/manual/en/function.strpos.php
            {
                $mobile = true;

                $match = $keyword;
                break;
            }
        }
        foreach ($keywordsComputer as $keyword) {
            if (strpos($header_ua, $keyword) !== false) // http://php.net/manual/en/function.strpos.php
            {
                $computer = true;

                $match = $keyword;
                break;
            }
        }

        if ($mobile) {
            echo "<p>Ön mobileszközt használ. ($match)</p>";
        } elseif ($computer) {
            echo "<p>Ön számítógépet használ. ($match)</p>";
        } else {
            echo "<p>Ön tabletet használ.</p>";
        }

        ?>
        © 2020 Copyright:
        <a href="index.php"> Elhozom.hu</a>
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->