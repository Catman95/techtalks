<?php

require 'config/config.php';

include 'views/fixed/top.php';

if(isset($_GET['page'])){
    page_access_log();
    $logged_in = (isset($_SESSION['username'])? true : false);
    $admin = ($logged_in && $_SESSION['role'] == 1? true: false);
    switch($_GET['page']){
        case 'home':
            include "views/pages/home.php";
            break;
        case 'admin':
            redirect('home');
            adminOnly();
            include "views/pages/admin.php";
            break;
        case 'show_user':
            include "views/pages/show_user.php";
            break;
        case 'author':
            include "views/pages/author.php";
            break;
        case 'topic':
            include "views/pages/topic.php";
            break;
        case 'new_thread':
            forceIndex();
            include "views/pages/new_thread.php";
            break;
        case 'show_thread':
            include "views/pages/show_thread.php";
            break;
        case 'new_post':
            forceIndex();
            include "views/pages/new_post.php";
            break;
        case 'account_settings':
            forceIndex();
            include "views/pages/account_settings.php";
            break;
        case 'not_found':
            include "views/pages/404.php";
            break;
        case 'access_forbidden':
            include "views/pages/access_forbidden.php";
            break;
        }
}else {
    header("Location: index.php?page=home");
}

include 'views/fixed/bottom.php';

?>
