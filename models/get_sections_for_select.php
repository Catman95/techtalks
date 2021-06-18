<?php

    require "../config/config.php";
    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $response = [];
        try {
            $get_sections = retrieveData("SELECT * FROM forum_sections");
            foreach($get_sections as $section){
                array_push($response, $section);
            }
            $status = 201;
        } catch (PDOException $e) {
            $response['result'] = $e->getMessage();
            log_error($e);
            $status = 500;
        }
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }

?>
