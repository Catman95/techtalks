<?php

    header("Content-Type: application/json");
    require "../config/config.php";

    if($_SERVER['REQUEST_METHOD']){
        $thread_id = $_POST['thread_id'];
        $page_number = $_POST['page_number'];
        $response = ['data' => [], 'pagination_links' => [], 'current_page' => $page_number];

        try {
            //Pagination
            $posts_per_page = 10;
            $post_count = getRow("SELECT COUNT(*) as count FROM posts WHERE thread_id = $thread_id")['count'];
            $needed_pages = ceil($post_count / $posts_per_page);
            $range_start = ($page_number - 1) * $posts_per_page;
            for($i = 1; $i <= $needed_pages; $i++){
                array_push($response['pagination_links'], "<button class='paginationButton btn' data-part=$i>$i</button>");
            }
            //Getting data
            $posts = retrieveData("SELECT * FROM posts WHERE thread_id = $thread_id LIMIT $range_start, $posts_per_page");
            $get_thread = getRow("SELECT * FROM threads WHERE id = $thread_id");
            $thread_title = $get_thread['title'];

            foreach($posts as $row){
                $user = getRow("SELECT * FROM users WHERE id = $row->created_by");
                $no_of_posts = getRow("SELECT COUNT(*) as count FROM posts WHERE created_by = $row->created_by")['count'];
                $post_data = [];
                $post_data['username'] = $user['username'];
                $post_data['online_status'] = $user['online_status'];
                $post_data['register_time'] = $user['register_time'];
                $post_data['no_of_posts'] = $no_of_posts;
                $post_data['avatar'] = $user['avatar'];
                $post_data['post_time'] = $row->time_posted;
                $post_data['content'] = $row->content;
                $post_data['post_id'] = $row->id;
                $post_data['user_id'] = $user['id'];
                $post_data['is_admin_or_mod'] = (isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)? true : false);
                $post_data['is_last_post'] = (getRow("SELECT COUNT(*) as count FROM posts WHERE thread_id = $thread_id")['count'] == 1? true : false);
                array_push($response['data'], $post_data);
            }
            $status = 201;
        } catch (PDOException $e) {
            $response['error'] = "Error: " . $e->getMessage();
            log_error($e);
            $status = 500;
        }

        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }else {
        header("Location: ../index.php");
    }
?>
