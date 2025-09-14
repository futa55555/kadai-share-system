<?php

/**
 * File: public/pages/show_file.php
 * Description: アップロードファイルの表示
 */

require '../../handlers/show_file.php';

?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($filename) ?>-表示</title>
    <link rel="stylesheet" href="../css/show_file.css">
</head>

<body>
    <h2 class="file-title">
        <?= htmlspecialchars($filename) ?>
    </h2>


    <div class="code">
        <?php foreach ($lines as $i => $line): ?>
            <div class="line">
                <span class="num"><?= $i + 1 ?></span>
                <span class="text"><?= ($line === "") ? "<br />" : htmlspecialchars($line) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
