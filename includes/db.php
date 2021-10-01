<?php ob_start();
    $db['db_host'] = "data.azurednt.com";
    $db['db_user'] = "tphat";
    $db['db_pass'] = "p0937994252";
    $db['db_name'] = "SportShop";

    foreach($db as $key => $value) {
        define(strtoupper($key), $value);
    }

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$connection) {
        die('Connect Failed' .mysqli_error());
    }
    

?>