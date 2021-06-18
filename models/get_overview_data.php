<?php

    require "../config/config.php";
    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        try {
            //First part of the query
            $count_all = "SELECT COUNT(*) AS count FROM";

            //Queries the database to get total numbers of some attributes
            $conn->beginTransaction();
                $ttl_usr = getRow($count_all . " users");
                $ttl_ban = getRow($count_all . " users WHERE banned = 1");
                $ttl_pst = getRow($count_all . " posts");
                $ttl_thr = getRow($count_all . " threads");
                $ttl_onl = getRow($count_all . " users WHERE online_status = 1");

                //Getting the data about the latest users
                $latest_users = retrieveData("SELECT id, username, email, register_time FROM users ORDER BY register_time DESC LIMIT 10");

            $conn->commit();

            //Data for admin panel overview. Total numbers of certain stuff...
            $overview_data = ['totalUsers' => $ttl_usr['count'],
                              'totalPosts' => $ttl_pst['count'],
                              'totalThreads' => $ttl_thr['count'],
                              'currentlyOnline' => $ttl_onl['count'],
                              'totalBanned' => $ttl_ban['count']];

            //Preparing the data to be sent as an ajax response
            $response = ['latestUsers' => $latest_users, 'otherData' => $overview_data];
            $status = 201;
        } catch (PDOException $e) {
            $response['error'] = "Database error: " . $e->getMessage();
            log_error($e);
            $status = 500;
        }

        //Closes the connection
        $conn = NULL;

        //Echoing the data
        http_response_code($status);
        echo json_encode($response, JSON_PRETTY_PRINT);

    }else {
        header("Location: ../index.php");
    }

?>
