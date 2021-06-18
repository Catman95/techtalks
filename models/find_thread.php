<?php

    require "../config/config.php";
    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = str_replace("_", "\_", $_POST['title']);
        $response = [];
        if($title != ''){
            try {
                $find_thread = retrieveData("SELECT th.id, th.title, tp.title as topic, u.username FROM threads th INNER JOIN topics tp ON th.topic_id = tp.id INNER JOIN users u ON th.created_by = u.id WHERE th.title LIKE '$title%'");
                if(count($find_thread) > 0){
                    foreach($find_thread as $row){
                        array_push($response, $row);
                    }
                }else {
                    $response['result'] = 'empty';
                }
                $status = 201;
            } catch (PDOException $e) {
                log_error($e);
                $response['result'] = "Error: " . $e->getMessage();
                $status = 500;
            }

        }else {
            $response['result'] = 'empty';
            $status = 201;
        }
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }

?>
