<!-- kadai_post.php -->

<?php
    session_start();

    require '../db.php';

    $sql_kadai_insert = <<<SQL
        INSERT INTO kadai (
            user_name,
            mission_genre,
            mission_detail,
            goal,
            problem,
            error_file,
            solve_state,
            created_at
        ) VALUES (
            :user_name,
            :mission_genre,
            :mission_detail,
            :goal,
            :problem,
            :error_file,
            :solve_state,
            :created_at
        );
    SQL;

    $sql_comment_insert = <<<SQL
        INSERT INTO comment (
            user_name,
            kadai_id,
            content,
            resolve_file,
            created_at
        ) VALUES (
            :user_name,
            :kadai_id,
            :content,
            :resolve_file,
            :created_at
        );
    SQL;

    $sql_count = <<<SQL
        SELECT
            COUNT(user_name) AS cnt
        FROM
            kadai
        ;
    SQL;
?>

<?php
    $user_name = $_SESSION["user_name"];
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>課題投稿ページ</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>
            <a href="index.php">
                課題共有システム
            </a>
        </h1>

        <?php if ($user_name): ?>
            <?= $user_name ?>としてログインしています。<br />
        <?php else: ?>
            ログインしていません。<br />
            <div class="log_in">
                <a href="log_in.php">ログイン</a>
            </div>
        <?php endif ?>

        <hr />

        <div class="kadai_post">
            <form method="post">
                ミッション<br />
                大分類：
                <select name="mission_genre" id="mission_genre" required>
                    <option value="" disabled selected>選択してください</option>
                    <option value=0 <?= (($_POST['mission_genre'] ?? '') == '0') ? 'selected' : '' ?>>0</option>
                    <option value=1 <?= (($_POST['mission_genre'] ?? '') == '1') ? 'selected' : '' ?>>1</option>
                    <option value=2 <?= (($_POST['mission_genre'] ?? '') == '2') ? 'selected' : '' ?>>2</option>
                    <option value=3 <?= (($_POST['mission_genre'] ?? '') == '3') ? 'selected' : '' ?>>3</option>
                    <option value=4 <?= (($_POST['mission_genre'] ?? '') == '4') ? 'selected' : '' ?>>4</option>
                    <option value=5 <?= (($_POST['mission_genre'] ?? '') == '5') ? 'selected' : '' ?>>5</option>
                    <option value=6 <?= (($_POST['mission_genre'] ?? '') == '6') ? 'selected' : '' ?>>6</option>
                    <option value=7 <?= (($_POST['mission_genre'] ?? '') == '7') ? 'selected' : '' ?>>7</option>
                </select>
                小分類：
                <select name="mission_detail" id="mission_detail" required>
                    <option value="" disabled selected>選択してください</option>
                </select>
                <br />
                やりたいこと：
                <input type="text" name="goal" value=<?php if (isset($_POST["goal"])) { echo $_POST["goal"]; } ?>>
                <br />
                問題点：
                <textarea name="problem"><?php if (isset($_POST["problem"])) { echo $_POST["problem"]; } ?></textarea>
                <br />
                問題ファイル：
                <textarea name="error_file"><?php if (isset($_POST["error_file"])) { echo $_POST["error_file"]; } ?></textarea>
                <br />
                解決状況：
                <select name="solve_state" id="solve_state">
                    <option value="unresolved" <?= (($_POST['solve_state'] ?? '') == 'unresolved') ? 'selected' : '' ?>>未解決</option>
                    <option value="resolved" <?= (($_POST['solve_state'] ?? '') == 'resolved') ? 'selected' : '' ?>>解決済み</option>
                </select>
                <br />

                <div id="comment_box" style="display:none;">
                    解決策：<textarea name="content"></textarea><br />
                    改善ファイル：<textarea name="resolve_file" placeholder="空欄可"></textarea>
                </div>

                <input type="submit" name="submit">
            </form>
        </div>

        <?php if (isset($_POST["submit"])): ?>
            <?php
                function is_input($value) {
                    return isset($value) && $value != "";
                }

                $mission_genre = $_POST["mission_genre"];
                $mission_detail = $_POST["mission_detail"];
                $goal = $_POST["goal"];
                $problem = $_POST["problem"];
                
                $error_code = $_POST["error_file"];

                $solve_state = $_POST["solve_state"];

                $input_list = array(
                    $user_name,
                    $mission_genre,
                    $mission_detail,
                    $goal,
                    $problem,
                    $error_code,
                    $solve_state,
                );

                $is_empty = false;

                foreach ($input_list as $input) {
                    if (!is_input($input)) {
                        $is_empty = true;
                        break;
                    }
                }
            ?>

            <?php if ($solve_state == "resolved"): ?>
                <?php
                    $content = $_POST["content"];

                    $resolve_code = $_POST["resolve_file"];

                    if (!is_input($content)) {
                        $is_empty = true;
                    }
                ?>
            <?php endif ?>

            <?php if ($is_empty): ?>
                すべての記入事項を入力してください。
            <?php else: ?>
                <?php
                    $error_file = "uploads/" . $user_name . "-kadai-" . date("dHis", $now) . ".txt";
                    file_put_contents($error_file, $error_code);

                    if ($resolve_code != "") {
                        $resolve_file = "uploads/" . $user_name . "-comment-" . time() . ".txt";
                        file_put_contents($resolve_file, $resolve_code);
                    }

                    $stmt = $pdo->query($sql_count);
                    $count_before = $stmt->fetch(PDO::FETCH_ASSOC)["cnt"];

                    date_default_timezone_set('Asia/Tokyo');
                    $date = date('Y-m-d H:i:s');

                    $stmt = $pdo->prepare($sql_kadai_insert);
                    $stmt->execute([
                        "user_name" => $user_name,
                        "mission_genre" => $mission_genre,
                        "mission_detail" => $mission_detail,
                        "goal" => $goal,
                        "problem" => $problem,
                        "error_file" => $error_file,
                        "solve_state" => $solve_state,
                        "created_at" => $date
                    ]);

                    if ($content != "") {
                        $stmt = $pdo->prepare("SELECT kadai_id FROM kadai WHERE user_name = :user_name AND created_at = :created_at");
                        $stmt->execute([
                            "user_name" => $user_name,
                            "created_at" => $date
                        ]);
                        $kadai_id = $stmt->fetch(PDO::FETCH_ASSOC)["kadai_id"];

                        $stmt = $pdo->prepare($sql_comment_insert);
                        $stmt->execute([
                            "user_name" => $user_name,
                            "kadai_id" => $kadai_id,
                            "content" => $content,
                            "resolve_file" => $resolve_file,
                            "created_at" => $date
                        ]);
                    }

                    $stmt = $pdo->query($sql_count);
                    $count_after = $stmt->fetch(PDO::FETCH_ASSOC)["cnt"];

                    header("Location: index.php?status=success");
                    exit;
                ?>
            <?php endif ?>
        <?php endif ?>
    </body>

    <script>
        function range(n) {
            return Array.from({ length: n}, (_, i) => i + 1);
        }

        const detailOptions = {
            0: [...range(22), '全般'],
            1: [...range(27), '全般'],
            2: [...range(4), '全般'],
            3: [...range(4), '全般'],
            4: [...range(9), '全般'],
            5: [...range(4), '全般'],
            6: [...range(2), '全般'],
            7: ['全般']
        };

        const genreSelect = document.getElementById("mission_genre");
        const detailSelect = document.getElementById("mission_detail");

        const prevGenre = "<?= $_POST['mission_genre'] ?? '' ?>";
        const prevDetail = "<?= $_POST['mission_detail'] ?? '' ?>";

        function updateDetailOptions(selected, prevDetail) {
            detailSelect.innerHTML = "";

            if (detailOptions[selected]) {
                detailOptions[selected].forEach(function(detail) {
                    const option = document.createElement("option");
                    option.value = detail;
                    option.textContent = detail;
                    if (detail == prevDetail) {
                        option.selected = true;
                    }
                    detailSelect.appendChild(option);
                });
            } else {
                const option = document.createElement("option");
                option.value = "";
                option.textContent = "選択してください";
                detailSelect.appendChild(option);
            }
        }
        if (prevGenre) {
            updateDetailOptions(prevGenre, prevDetail);
        }

        genreSelect.addEventListener("change", function() {
            updateDetailOptions(this.value, null);
        });

        const solveState = document.getElementById("solve_state");

        const commentBox = document.getElementById("comment_box");

        toggleCommentBox(solveState.value);

        solveState.addEventListener("change", function() {
            toggleCommentBox(this.value);
        });

        function toggleCommentBox(state) {
            if (state === "resolved") {
                commentBox.style.display = "block";
            } else {
                commentBox.style.display = "none";
            }
        }
    </script>
</html>
