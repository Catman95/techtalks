<?php

    /**************************************************************************/
    require "dbconn.php";
    require "functions.php";

    if(!isset($_SESSION)){
        //session_set_cookie_params(1800,"/");
        /*$newVisit = $conn->prepare("INSERT INTO visits (ip) VALUES (?)");
        $newVisit->bindValue(1, $_SERVER['REMOTE_ADDR']);
        $newVisit->execute();*/
        session_start();
        $status;
    }

?>
