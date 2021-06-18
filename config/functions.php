<?php

    function redirect($page){
        header("Location: index.php?page=$page");
    }

    function forceIndex(){
        if(!isset($_SESSION['username'])){
            redirect('home');
        }
    }

    function protectPageFromGetRequest(){
        if(!isset($_GET['page']) && $_SERVER['PHP_SELF'] != '/techtalks/index.php'){
            header("../../index.php");
        }
    }

    function adminOnly(){
        if($_SESSION['role'] != 1){
            redirect('home');
        }
    }

    function retrieveData($query){
        global $conn;
        $getData = $conn->query($query);
        return $getData->fetchAll();
    }

    function getUserData($id){
        global $conn;
        $getData = $conn->query("SELECT * FROM users WHERE id = $id");
        return $getData->fetch();
    }

    function getRow($query){
        global $conn;
        $getRow = $conn->query($query);
        if($getRow->rowCount() == 0){
            return false;
        }else {
            return $getRow->fetch(PDO::FETCH_ASSOC);
        }
    }

    function getUserRole($role_id){
        global $conn;
        $getRole = $conn->query("SELECT role FROM user_roles WHERE id = $role_id");
        return ucfirst($getRole->fetch()->role);
    }

    function getUsersPosts($user_id, $no_of_posts){
        global $conn;
        $posts = retrieveData("SELECT * FROM posts WHERE created_by = $user_id ORDER BY time_posted DESC LIMIT $no_of_posts");
        return $posts;
    }

    function page_access_log(){
        @ $log_file = fopen("data/log.txt", "ab");
        if(!$log_file){
            echo "Something went wrong";
        }else {
            @ $user = (null != $_SESSION['username']?$_SESSION['username']:'guest');
            $date = date("d-M-Y");
            $time = date("H:i:s");
            $page_code = $_GET['page'];
            if(!isset($_GET['page'])){
                $page_code = 'index';
            }
            $ip_address = $_SERVER['REMOTE_ADDR'];
            fwrite($log_file, "Page access: [$page_code, User: $user, IP: $ip_address, Timestamp: $date $time] [endline]\r\n");
            fclose($log_file);
        }
    }

    function log_error($e){
        @ $log_file = fopen("../data/log.txt", "a");
        if(!$log_file){
            echo "Something went wrong";
        }else {
            @ $user = (null != $_SESSION['username']?$_SESSION['username']:'guest');
            $date = date("d-M-Y");
            $time = date("H:i:s");
            $error_code = $e->getCode();
            $error_message = $e->getMessage();
            $ip_address = $_SERVER['REMOTE_ADDR'];
            fwrite($log_file, "Error: [Code = $error_code; Message = $error_message] [endline]\r\n");
            fclose($log_file);
        }
    }

    function prepare_image($tmp_name, $crop_dimensions, $file_path, $file_type) {

        list($src_width, $src_height) = getimagesize($tmp_name);
        $image_orientation = ($src_width == $src_height? 'square' : ($src_width > $src_height? 'landscape' : 'portrait'));

        if($image_orientation == 'portrait'){
            //Nova dužina
            $new_width = $crop_dimensions;
            //Proverava za koliko procenata se slika mora suziti da bi bila jednaka novoj dužini
            $resize_percentage = round(100 - $new_width / $src_width * 100);
            //Za toliko procenata ćemo smanjiti i visinu
            $new_height = round($src_height - $src_height * $resize_percentage / 100);

            switch($file_type){
                case "image/jpeg":
                    $img_handler = imagecreatefromjpeg($tmp_name);
                    break;
                case "image/png":
                    $img_handler = imagecreatefrompng($tmp_name);
                    break;
            }

            $empty_to_resize = imagecreatetruecolor($new_width, $new_height);
            imagecopyresized($empty_to_resize, $img_handler, 0, 0, 0, 0, $new_width, $new_height, $src_width, $src_height);
            $resized = $empty_to_resize;

            $empty_to_crop = imagecreatetruecolor($crop_dimensions, $crop_dimensions);
            imagecopyresampled($empty_to_crop, $resized, 0, 0, 0, ($new_height - $crop_dimensions) / 2, $crop_dimensions, $crop_dimensions, $crop_dimensions, $crop_dimensions);
            $cropped_image = $empty_to_crop;
            $compression = 100;
            switch($file_type){
                case "image/jpeg":
                    imagejpeg($cropped_image, $file_path, $compression);
                    break;
                case "image/png":
                    imagepng($cropped_image, $file_path);
                    break;
            }
        }else if($image_orientation == 'landscape'){
            //Nova dužina
            $new_height = $crop_dimensions;
            //Proverava za koliko procenata se slika mora suziti da bi bila jednaka novoj dužini
            $resize_percentage = round(100 - $new_height / $src_height * 100);
            //Za toliko procenata ćemo smanjiti i visinu
            $new_width = round($src_width - $src_width * $resize_percentage / 100);

            switch($file_type){
                case "image/jpeg":
                    $img_handler = imagecreatefromjpeg($tmp_name);
                    break;
                case "image/png":
                    $img_handler = imagecreatefrompng($tmp_name);
                    break;
            }

            $empty_to_resize = imagecreatetruecolor($new_width, $new_height);
            imagecopyresized($empty_to_resize, $img_handler, 0, 0, 0, 0, $new_width, $new_height, $src_width, $src_height);
            $resized = $empty_to_resize;

            $empty_to_crop = imagecreatetruecolor($crop_dimensions, $crop_dimensions);
            imagecopyresampled($empty_to_crop, $resized, 0, 0, ($new_width - $crop_dimensions) / 2, 0, $crop_dimensions, $crop_dimensions, $crop_dimensions, $crop_dimensions);
            $cropped_image = $empty_to_crop;

            $compression = 100;
            switch($file_type){
                case "image/jpeg":
                    imagejpeg($cropped_image, $file_path, $compression);
                    break;
                case "image/png":
                    imagepng($cropped_image, $file_path);
                    break;
            }
        }else {
            switch($file_type){
                case "image/jpeg":
                    $img_handler = imagecreatefromjpeg($tmp_name);
                    break;
                case "image/png":
                    $img_handler = imagecreatefrompng($tmp_name);
                    break;
            }
            $empty_to_resize = imagecreatetruecolor($crop_dimensions, $crop_dimensions);
            imagecopyresized($empty_to_resize, $img_handler, 0, 0, 0, 0, $crop_dimensions, $crop_dimensions, $src_width, $src_height);
            $resized = $empty_to_resize;

            $compression = 100;
            switch($file_type){
                case "image/jpeg":
                    imagejpeg($resized, $file_path, $compression);
                    break;
                case "image/png":
                    imagepng($resized, $file_path);
                    break;
            }
        }
    }

    function readLogFile(){
        $log_file = fopen("data/log.txt", 'r');
        $content = "";
        if($log_file){

            while(!feof($log_file)){
                $buffer = fread($log_file, 4096);
                $content = $content . $buffer;
            }

            fclose($log_file);

            $logs = explode("[endline]\r\n", $content);
            return $logs;
        }
    }

    function mark_visit($page, $time){
        global $totalVisits, $pages;
        $yesterday = time() - 84600;
        if($time > $yesterday){
            $pages[$page][0]++;
        }
        $pages[$page][1]++;
        $totalVisits++;
    }

    function show_page_visits($pages){
        global $totalVisits;
        echo "<table class=\"customTable\">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Last 24h</th>
                    <th>Total</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>";

        foreach($pages as $page){
            $page[2] = $page[1] / $totalVisits * 100;
            echo "<tr>
                <td>" . $page[3] . "</td>
                <td>" . $page[0] . "</td>
                <td>" . $page[1] . "</td>
                <td>" . number_format($page[2], 2, '.', '') . "%</td>
            </tr>";
        }

        echo "</tbody></table>";
    }
?>
