<?php

    header("Content-Type: application/json");
    require "../config/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST" && $_SESSION['banned'] == 0){
        $user_id = $_SESSION['user_id'];
        $thread_id = $_POST['thread_id'];
        $text = $_POST['text'];
        $response = [];
        try {
            $add_thread = $conn->prepare("INSERT INTO posts(content, created_by, thread_id) VALUES(?,?,?)");
            $add_thread->bindValue(1, $text);
            $add_thread->bindValue(2, $user_id);
            $add_thread->bindValue(3, $thread_id);
            $add_thread->execute();
            $response['result'] = 'Success';
            $status = 201;
        }
        catch(PDOException $e){
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
