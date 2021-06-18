<?php
    include "../config/config.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];
        $response = [];

        try {
            $update = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
            $update->bindValue(1, $role_id);
            $update->bindValue(2, $user_id);
            $update->execute();
            $status = 201;
            $response['result'] = 'Success';
        } catch (PDOException $e) {
            $status = 500;
            $response['result'] = "Error: " . $e->getMessage();
            log_error($e);
        }

        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);

    }else {
        header("Location: ../index.php");
    }

?>
