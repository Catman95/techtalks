<?php

    header("Content-Type: application/json");
    require "../config/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $created_by = $_SESSION['user_id'];
        $title = $_POST['title'];
        $text = $_POST['text'];
        $topic_id = $_POST['topic_id'];
        $response = [];
        try {
            $conn->beginTransaction();
                $add_thread = $conn->prepare("INSERT INTO threads(title, created_by, topic_id) VALUES(?,?,?)");
                $add_thread->bindValue(1, $title);
                $add_thread->bindValue(2, $created_by);
                $add_thread->bindValue(3, $topic_id);
                $add_thread->execute();
                $thread_id = $conn->lastInsertId();
                $add_post = $conn->prepare("INSERT INTO posts(content, created_by, thread_id) VALUES(?,?,?)");
                $add_post->bindValue(1, $text);
                $add_post->bindValue(2, $created_by);
                $add_post->bindValue(3, $thread_id);
                $add_post->execute();
            $conn->commit();
            $response['redirect'] = "index.php?page=show_thread&id=$thread_id&part=1";
            $status = 201;
        }
        catch(PDOException $e){
            $status = 500;
            //$conn->rollBack();
            $response['result'] = $e->getMessage();
            log_error($e);
        }
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }
?>
