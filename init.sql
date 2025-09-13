-- ==========================
-- ユーザーテーブル
-- ==========================
DROP TABLE IF EXISTS user;
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password_hash VARCHAR(50)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- ==========================
-- 課題テーブル
-- ==========================
DROP TABLE IF EXISTS kadai;
CREATE TABLE kadai (
    kadai_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    mission_genre INT NOT NULL,
    mission_detail INT NOT NULL,
    goal VARCHAR(200) NOT NULL,
    problem TEXT NOT NULL,
    error_file TEXT,
    resolve_state VARCHAR(200),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- ==========================
-- コメントテーブル
-- ==========================
DROP TABLE IF EXISTS comment;
CREATE TABLE comment (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    kadai_id INT NOT NULL,
    solution TEXT NOT NULL,
    solution_file TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
