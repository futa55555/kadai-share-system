<?php
    session_start();
    session_destroy();

    header("Location: index.php"); // ログインページに戻す
    exit;