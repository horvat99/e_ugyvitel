<?php

require "db_config.php";

$active = "";

    $stmt = $connection -> prepare("UPDATE users SET active = '1', code = '' WHERE binary code = ?
                                          AND registration_expires>now()");
    $stmt -> bind_param('s',$_GET['code']);
    $stmt -> execute();
    if ($stmt->affected_rows>0)
    {
        $active = "?active=1";
    }

header("Location:login.php$active");
exit();
?>