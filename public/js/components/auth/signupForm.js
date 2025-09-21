/**
 * File: public/js/components/auth/signupForm.js
 * Description: サインアップフォームの作成関数
 */
import { handleSignup } from "../../services/auth/handleSignup.js";
export function signupForm(username) {
    const signupForm = document.createElement("div");
    signupForm.classList.add("signup-form");
    const usernameGroup = document.createElement("div");
    usernameGroup.classList.add("signup-group");
    const usernameLabel = document.createElement("label");
    usernameLabel.for = "username";
    usernameLabel.classList.add("signup-label");
    usernameLabel.textContent = "ユーザー名：";
    usernameGroup.append(usernameLabel);
    const usernameInput = document.createElement("input");
    usernameInput.type = "text";
    usernameInput.id = "username";
    usernameInput.classList.add("signup-input");
    usernameInput.autocomplete = "username";
    usernameGroup.append(usernameInput);
    signupForm.append(usernameGroup);
    const passwordGroup = document.createElement("div");
    passwordGroup.classList.add("signup-group");
    const passwordLabel = document.createElement("label");
    passwordLabel.for = "password";
    passwordLabel.classList.add("signup-label");
    passwordLabel.textContent = "パスワード：";
    passwordGroup.append(passwordLabel);
    const passwordInput = document.createElement("input");
    passwordInput.type = "password";
    passwordInput.id = "password";
    passwordInput.classList.add("signup-input");
    passwordInput.autocomplete = "new-password";
    passwordGroup.append(passwordInput);
    signupForm.append(passwordGroup);
    const signupButton = document.createElement("button");
    signupButton.classList.add("btn", "signup-form-button");
    signupButton.textContent = "サインアップ";
    signupButton.onclick = () => {
        if (username === null) {
            handleSignup();
        }
    };
    signupForm.append(signupButton);
    return signupForm;
}
//# sourceMappingURL=signupForm.js.map