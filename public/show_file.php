<?php

/**
 * File: public/show_file.php
 * Description: アップロードファイルの表示
 */

$type = $_GET["type"] ?? "";
$filename = $_GET["file"] ?? "";


// セッション情報
session_start(); // ログインチェックを入れるなら必要

$username = $_SESSION["username"];


// エラー処理
if ($filename === "") {
    http_response_code(400);
    exit("ファイル名が指定されていません");
}

if ($type === "") {
    http_response_code(400);
    exit("ファイルの種類が指定されていません");
}

if ($username === "") {
    http_response_code(401);
    exit("ログインしてください。");
}


// public/ の外の uploads ディレクトリを指定
$baseDir = realpath(__DIR__ . '/../uploads');
$subdir = ($type === 'kadai') ? 'kadais' : 'comments';
$filePath = realpath($baseDir . '/' . $subdir . '/' . basename($filename));


// ディレクトリトラバーサル防止
if (strpos($filePath, $baseDir) !== 0 || !is_file($filePath)) {
    http_response_code(404);
    exit("ファイルが存在しません");
}


// MIMEタイプを判定
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $filePath);
finfo_close($finfo);

header("Content-Type: {$mimeType}");
readfile($filePath);
