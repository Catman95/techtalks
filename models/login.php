<?php

    header("Content-Type: application/json");
    require "../config/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $password = $_POST['password'];
        $email = $_POST['email'];

        $response = [];

        try {
            $findUser = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $findUser->bindValue(1, $email);
            $findUser->execute();

            if($findUser->rowCount() > 0){
                $Row = $findUser->fetch(PDO::FETCH_ASSOC);
                $user = $Row['username'];
                $hash = $Row['password_hash'];
                $user_id = $Row['id'];
                $role = $Row['role'];
                $banned = $Row['banned'];

                if(password_verify($password, $hash)){
                    $_SESSION['role'] = $role;
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $user;
                    $_SESSION['email'] = $email;
                    $_SESSION['banned'] = $banned;
                    $onlineStatus = $conn->prepare("UPDATE users SET online_status = 1 WHERE username = ?");
                    $onlineStatus->bindValue(1, $_SESSION['username']);
                    $onlineStatus->execute();
                    $conn = NULL;
                    $response['redirect'] = "index.php?page=home";
                }else {
                    $response['error'] = 'Wrong password';
                    mail($email, "Tech Talks Log in", "There was an attempt of logging into your tech talks account with an incorrect password.");
                }
            }else {
                $response['error'] = 'No such account';
            }
            $status = 201;
        } catch (PDOException $e) {
            $status = 500;
            $response['error'] = $e->getMessage();
            log_error($e);
        }

        http_response_code($status);
        echo json_encode($response);
    }else {
        header("Location: ../index.php");
    }
?>
