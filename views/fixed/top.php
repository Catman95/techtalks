<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Aleksandar Stanković">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <title><?php echo 'Tech talks - ' . ucfirst($_GET['page']); ?></title>
        <link rel="stylesheet" href="assets/style/main.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Ropa+Sans&display=swap" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="assets/images/ico2.png"/>
    </head>
    <body>
        <div id="wrapper">
            <?php
                if(isset($_SESSION['username'])){
                    include "views/fixed/dashboard.php";
                }
            ?>
            <header id="header">
                <div id="logoHolder">
                    <a href="index.php?page=home"><img src="assets/images/logo.png" alt="Logo"></a>
                </div>
                <div id="burger">
                    <i class="fas fa-bars"></i>
                </div>
                <nav id="nav">
                    <ul>
                        <?php

                            $nav_links = retrieveData("SELECT * FROM menu_items WHERE menu = 'nav'");
                            foreach($nav_links as $row){
                                if($row->link == 'models/logout.php'){
                                    if(!isset($_SESSION['username'])){
                                        echo "<li><a href=\"#\" class=\"loginOpener\">Log in</a></li>";
                                    }else {
                                        echo "<li><a href=\"$row->link\">$row->text</a></li>";
                                    }
                                }else {
                                    echo "<li><a href=\"$row->link\">$row->text</a></li>";
                                }
                            }

                        ?>
                    </ul>
                </nav>
            </header>
            <div id="drawer">
                <nav id="drawerNav">
                    <ul>
                        <?php

                            $drawerLinks = retrieveData("SELECT * FROM menu_items WHERE menu = 'nav'");
                            foreach($drawerLinks as $row){
                                if($row->link == 'models/logout.php'){
                                    if(!isset($_SESSION['username'])){
                                        echo "<li><a href=\"#\" class=\"loginOpener\">Log in</a></li>";
                                    }else {
                                        echo "<li><a href=\"$row->link\">$row->text</a></li>";
                                    }
                                }else {
                                    echo "<li><a href=\"$row->link\">$row->text</a></li>";
                                }
                            }

                        ?>
                    </ul>
                </nav>
            </div>
            <?php include 'views/fixed/reglogforms.php'; ?>
            <main id="main">
