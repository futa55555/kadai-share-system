/**
 * File: public/js/services/auth/handleLogin.js
 * Description: ログインボタンの処理関数
 */

import { login } from "../../clients/auth/login.js";


export async function handleLogin() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    login(username, password);
}
