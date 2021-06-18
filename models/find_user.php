<?php

    require "../config/config.php";
    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        try {
            $username = str_replace("_", "\_", $_POST['username']);
            $result = $conn->query("SELECT u.*, r.role as userRole
                                    FROM users u INNER JOIN user_roles r
                                    ON u.role = r.id
                                    WHERE u.username LIKE '$username%'");
            $response = [];
            foreach($result as $row){
                $posts = getRow("SELECT COUNT(id) as count FROM posts WHERE created_by = $row->id");
                $no_of_posts = $posts['count'];
                $row->posts = $no_of_posts;
                array_push($response, $row);
            }
            if($username == '' || $result->rowCount() == 0){
                $response['empty'] = true;
            }
            $status = 201;
        } catch (PDOException $e) {
            $response['error'] = $e->getMessage();
            log_error($e);
            $status = 500;
        }

        $conn = NULL;
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }

?>
