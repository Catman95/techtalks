<?php

    require "../config/config.php";
    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = str_replace("_", "\_", $_POST['title']);
        $response = [];
        if($title != ''){
            try {
                $find_section = retrieveData("SELECT s.*, u.username FROM forum_sections s INNER JOIN users u ON s.created_by = u.id WHERE title LIKE '$title%'");
                if(count($find_section) > 0){
                    foreach($find_section as $row){
                        array_push($response, $row);
                    }
                }else {
                    $response['result'] = 'empty';
                }
                $status = 201;
            } catch (PDOException $e) {
                $status = 500;
                $response['result'] = "Error: " . $e->getMessage();
                log_error($e);
            }

        }else {
            $status = 201;
            $response['result'] = 'empty';
        }
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }

?>
