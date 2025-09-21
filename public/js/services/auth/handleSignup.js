/**
 * File: public/js/services/auth/handleSignup.js
 * Description: サインアップボタンの処理関数
 */
import { signup } from "../../clients/auth/signup.js";
export async function handleSignup() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    signup(username, password);
}
//# sourceMappingURL=handleSignup.js.map