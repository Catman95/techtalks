<?php

    header("Content-Type: application/json");
    require "../config/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $title = $_POST['title'];
        $response = [];
        try {
            $add_section = $conn->prepare("INSERT INTO forum_sections(title, created_by) VALUES(?,?)");
            $add_section->bindValue(1, $title);
            $add_section->bindValue(2, $_SESSION['user_id']);
            $add_section->execute();
            $response['result'] = 'Success';
            $status = 201;
        }
        catch(PDOException $e){
            $status = 500;
            if($e->getCode() == '23000'){
                $response['result'] = 'Error: Section with such a name already exists';
            }
            log_error($e);
        }
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }
?>
