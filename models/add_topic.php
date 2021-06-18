<?php

    header("Content-Type: application/json");
    require "../config/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $title = $_POST['title'];
        $section_id = $_POST['section_id'];
        $description = $_POST['description'];
        $response = [];
        try {
            $add_topic = $conn->prepare("INSERT INTO topics(title, created_by, section_id, description) VALUES(?,?,?,?)");
            $add_topic->bindValue(1, $title);
            $add_topic->bindValue(2, $_SESSION['user_id']);
            $add_topic->bindValue(3, $section_id);
            $add_topic->bindValue(4, $description);
            $add_topic->execute();
            $response['result'] = 'added';
            $status = 201;
        }
        catch(PDOException $e){
            $status = 500;
            log_error($e);
            $response['result'] = 'Error: ' . $e->getMessage();
        }
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);

    }else {
        header("Location: ../index.php");
    }
?>
