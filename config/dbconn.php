<?php

    /*$host = 'sql308.epizy.com';
    $dbname = "epiz_24006859_techtalks";
    $user = "epiz_24006859";
    $pass = "IggRNN5Ry2AID8y";*/

    // Ostala podesavanja
    define("ENV_FAJL", "http://" . $_SERVER['HTTP_HOST'] . "/config/.env");
    define("LOG_FAJL", "http://" . $_SERVER['HTTP_HOST'] . "/data/log.txt");
    // Podesavanja za bazu
    define("SERVER", env("SERVER"));
    define("DATABASE", env("DBNAME"));
    define("USERNAME", env("USERNAME"));
    define("PASSWORD", env("PASSWORD"));
    function env($name){
        $open = fopen(ENV_FAJL, "r");
        $data = file(ENV_FAJL);
        $value = "";
        foreach($data as $row){
            $divided = explode("=", $row);
            if($divided[0] == $name){
                return trim($divided[1]);
            }
        }
    }
    try {
        $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE, USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOexception $e){
        log_error($e);
        echo $e->getMessage();
        die("<h2 style='text-align:center'>Couldn't connect to the database. Rest assured we're working on it.</h2><img style='display:block;margin:auto' src='assets/images/error.jpg'>");
    }
?>
