<?php

/**
 * File: handlers/auth/log_out.php
 * Description: ログアウトの処理ファイル
 */

// セッション情報
session_start();
session_destroy();


// ページ遷移
header("Location: ../../public/pages/log_out.php");
exit;
