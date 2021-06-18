<?php

    header("Content-Type: application/json");
    require "../config/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $usernameRegex = "/^[a-zA-Z0-9\_]{3,20}$/";
        $emailRegex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/";

        $usernameOk = (preg_match($usernameRegex, $username)? true : false);
        $emailOk = (preg_match($emailRegex, $email)? true : false);
        $passwordOk = (strlen($password) > 8? true: false);

        $response = [];

        if($usernameOk && $emailOk && $passwordOk){

            try {
                $register = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
                $register->bindValue(1, $username);
                $register->bindValue(2, $email);
                $register->bindValue(3, password_hash($password, PASSWORD_DEFAULT));
                $register->execute();
                $response['result'] = "success";
                $status = 501;
            } catch (PDOException $e) {
                $status = 500;
                $response['error'] = $e->getMessage();
                log_error($e);
            }

        }else {
            $response['validationError'] = true;
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }

?>
