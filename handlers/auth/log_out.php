<?php

/**
 * File: handlers/auth/log_out.php
 * Description: ログアウトの処理ファイル
 */

session_start();
session_destroy();

header("Location: ../../public/pages/index.php");
exit;
