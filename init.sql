-- ==========================
-- ユーザーテーブル
-- ==========================
DROP TABLE IF EXISTS user;
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50),
    pass VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================
-- 課題テーブル
-- ==========================
DROP TABLE IF EXISTS kadai;
CREATE TABLE kadai (
    kadai_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50),
    mission_genre INT NOT NULL,
    mission_detail INT NOT NULL,
    goal VARCHAR(200),
    problem TEXT,
    error_file TEXT,
    solve_state VARCHAR(200),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================
-- コメントテーブル
-- ==========================
DROP TABLE IF EXISTS comment;
CREATE TABLE comment (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50),
    kadai_id INT NOT NULL,
    content TEXT,
    resolve_file TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
