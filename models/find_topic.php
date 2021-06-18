<?php

    require "../config/config.php";
    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = str_replace("_", "\_", $_POST['title']);
        $response = [];
        if($title != ''){
            try {
                $find_topic = retrieveData("SELECT t.id, t.title, t.created_by, s.title as section, u.username FROM topics t INNER JOIN forum_sections s ON t.section_id = s.id INNER JOIN users u ON t.created_by = u.id WHERE t.title LIKE '$title%'");
                if(count($find_topic) > 0){
                    foreach($find_topic as $row){
                        array_push($response, $row);
                    }
                    $status = 201;
                }else {
                    $status = 201;
                    $response['result'] = 'empty';
                }
            } catch (PDOException $e) {
                $response['result'] = "Error: " . $e->getMessage();
                log_error($e);
                $status = 500;
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
