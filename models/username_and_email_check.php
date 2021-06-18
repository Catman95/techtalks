<?php

    header("Content-Type: application/json");
    require "../config/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $whatToCheck = $_POST['whatToCheck'];
        $value = $_POST['value'];
        $query = ($whatToCheck == 'username'? "SELECT * FROM users WHERE username = ?" : "SELECT * FROM users WHERE email = ?");

        $response = [];

        try {
            $check = $conn->prepare($query);
            $check->bindValue(1, $value);
            $check->execute();
            $response['exists'] = ($check->rowCount() > 0? true: false);
            $status = 201;
        }catch(PDOException $e){
            $repsonse['error'] = "Error: " . $e->getMessage();
            $status = 500;
            log_error($e);
        }
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }
?>
