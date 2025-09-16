/**
 * File: public/js/components/auth/loginForm.js
 * Description: ログインフォームの作成関数
 */

import { handleLogin } from "../../services/auth/handleLogin.js";


export function loginForm(username) {
    const loginForm = document.createElement("div");
    loginForm.classList.add("login-form");


    const usernameGroup = document.createElement("div");
    usernameGroup.classList.add("login-group");

    const usernameLabel = document.createElement("label");
    usernameLabel.htmlFor = "username";
    usernameLabel.classList.add("login-label");
    usernameLabel.textContent = "ユーザー名：";
    usernameGroup.append(usernameLabel);

    const usernameInput = document.createElement("input");
    usernameInput.type = "text";
    usernameInput.id = "username";
    usernameInput.classList.add("login-input");
    usernameInput.autocomplete = "username";
    usernameGroup.append(usernameInput);

    loginForm.append(usernameGroup);


    const passwordGroup = document.createElement("div");
    passwordGroup.classList.add("login-group");

    const passwordLabel = document.createElement("label");
    passwordLabel.htmlFor = "password";
    passwordLabel.classList.add("login-label");
    passwordLabel.textContent = "パスワード：";
    passwordGroup.append(passwordLabel);

    const passwordInput = document.createElement("input");
    passwordInput.type = "password";
    passwordInput.id = "password";
    passwordInput.classList.add("login-input");
    passwordInput.autocomplete = "current-password";
    passwordGroup.append(passwordInput);

    loginForm.append(passwordGroup);


    const loginButton = document.createElement("button");
    loginButton.classList.add("btn", "login-form-button");
    loginButton.textContent = "ログイン";

    loginButton.onclick = () => {
        if (username === null) {
            handleLogin();
        }
    }

    loginForm.append(loginButton);


    return loginForm;
}
