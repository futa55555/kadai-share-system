/**
 * File: public/js/clients/auth/login.js
 * Description: ログインの処理関数
 *
 * @param {string} username ユーザー名
 * @param {string} password パスワード
 *
 * @return {none} 成功したらページ遷移
 */

export async function login(username, password) {
    try {
        const res = await fetch("../api/auth/login.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                username: username,
                password: password
            })
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Logged in successfully");
            window.location.href = "./index.html";
        } else {
            console.error(`Failed to log in: ${json.message}`);
            alert(`Failed to log in: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
