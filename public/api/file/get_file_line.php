<?php

/**
 * File: public/api/file/get_file_line.php
 * Description: ファイルの中身の取得API
 */

require '../../../includes/response.php';


try {
    $type = $_GET["type"] ?? null;
    $filename = $_GET["filename"] ?? null;

    if ($type === null) {
        jsonError("Type is not specified");
    } elseif ($filename === null) {
        jsonError("Filename is not specified");
    } else {
        $baseDir = '../../../uploads';

        if ($type === "kadai" or $type === "comment") {
            $subdir = $type . "s";
        } else {
            jsonError("Type is invalid");
        }

        $filePath = $baseDir . '/' . $subdir . '/' . basename($filename);

        error_log("DEBUG: Looking for file at " . realpath($filePath));

        if (strpos($filePath, $baseDir) !== 0 || !is_file($filePath)) {
            jsonError("File does not exist. Checked path: " . $filePath . __DIR__);
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES);

        jsonResponse([
            "lines" => $lines
        ]);
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
