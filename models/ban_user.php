<?php

    require "../config/config.php";
    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $response = [];
        $check = getRow("SELECT * FROM users WHERE id = $id AND banned = 1");
        $is_banned = ($check == false? false : true);
        if(!$is_banned){
            try {
                $ban = $conn->prepare("UPDATE users SET banned = 1 WHERE id = ?");
                $ban->bindValue(1, $id);
                $ban->execute();
                $response['result'] = 'banned';
                $status = 201;
            } catch (PDOException $e) {
                $status = 500;
                $response['error'] = "Error: " . $e->getMessage();
                log_error($e);
            }
        }
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }

?>
