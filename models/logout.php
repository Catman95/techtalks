<?php

    require "../config/config.php";

    try {
        $onlineStatus = $conn->prepare("UPDATE users SET online_status = 0 WHERE username = ?");
        $onlineStatus->bindValue(1, $_SESSION['username']);
        $onlineStatus->execute();
    } catch (PDOException $e) {
        log_error($e);
        die("Error: " . $e->getMessage());
    }

    session_start();
    session_destroy();
    header("Location: ../index.php");
?>
