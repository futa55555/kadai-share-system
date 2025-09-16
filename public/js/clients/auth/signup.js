/**
 * File: public/js/clients/auth/signup.js
 * Description: サインアップの処理関数
 *
 * @param {string} username ユーザー名
 * @param {string} password パスワード
 *
 * @return {none} 成功したらページ遷移
 */

import { login } from "./login.js";


export async function signup(username, password) {
    try {
        const res = await fetch("../../api/auth/signup.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                username: username,
                password: password
            })
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Signed up successfully");
            login(username, password);
        } else {
            console.error(`Failed to sign up: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
