<?php

    require "../config/config.php";
    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $response = [];

        $row_id = $_POST['row_id'];
        $table = $_POST['table'];

        switch ($table) {
            case 'users':
                $query = "DELETE FROM users WHERE id = ?";
                break;
            case 'forum_sections':
                $query = "DELETE FROM forum_sections WHERE id = ?";
                break;
            case 'topics':
                $query = "DELETE FROM topics WHERE id = ?";
                break;
            case 'threads':
                $query = "DELETE FROM threads WHERE id = ?";
                break;
            case 'posts':
                $query = "DELETE FROM posts WHERE id = ?";
                break;
        }
        try {
            $delete = $conn->prepare($query);
            $delete->bindValue(1, $row_id);
            $delete->execute();
            $response['result'] = 'Success';
            $status = 201;
        }catch(PDOException $e){
            $status = 500;
            log_error($e);
            $response['result'] = "Error: " . $e->getMessage();
        }
        http_response_code($status);
        echo json_encode($response);
    }else {
        header("Location: ../index.php");
    }

?>
