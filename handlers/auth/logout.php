<?php

/**
 * File: handlers/auth/logout.php
 * Description: ログアウトの処理ファイル
 */

// セッション情報
session_start();
session_destroy();


// ページ遷移
header("Location: ../../public/pages/logout.php");
exit;
