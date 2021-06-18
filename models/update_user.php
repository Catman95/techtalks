<?php
    include "../config/config.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user_id = $_SESSION['user_id'];

        //Gets data about the image
        $file = $_FILES['avatar_input'];
        $file_name = $file['name'];
        $tmp_name = $file['tmp_name'];
        $file_size = $file['size'];
        $file_type = $file['type'];
        $file_error = $file['error'];
        //If the user has chosen a file
        if(!empty($file_name)){
            $file_name_exploded = explode(".", $file_name);
            $file_extension = end($file_name_exploded);
            $upload_dir = '../assets/images/avatars/';
            $new_file_name = $user_id . "." . $file_extension;
            $file_path = $upload_dir . $new_file_name;

            $crop_dimensions = 250;

            try {
                prepare_image($tmp_name, $crop_dimensions, $file_path, $file_type);
            } catch (Exception $e) {
                log_error($e);
                die ("Error: " . $e->getMessage());
            }

            try {
                $update_avatar = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
                $update_avatar->bindValue(1, $new_file_name);
                $update_avatar->bindValue(2, $user_id);
                $update_avatar->execute();
            } catch(PDOException $e) {
                log_error($e);
                die ("Error: " . $e->getMessage());
            }
        }

        try {
            $update_bio = $conn->prepare("UPDATE users SET short_bio = ? WHERE id = ?");
            $update_bio->bindValue(1, $_POST['shortBioInput']);
            $update_bio->bindValue(2, $user_id);
            $update_bio->execute();
        } catch (PDOException $e) {
            log_error($e);
            die ("Error: " . $e->getMessage());
        }

        header("Location: ../index.php?page=account_settings");

    }else {
        header("Location: ../index.php");
    }

?>
