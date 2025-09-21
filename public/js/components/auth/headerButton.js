/**
 * File: public/js/components/auth/headerButton.js
 * Description: ヘッダーボタンの作成関数
 */
import { logout } from "../../clients/auth/logout.js";
export function headerButton(username) {
    const headerButton = document.createElement("button");
    headerButton.classList.add("btn", "header-button");
    if (username !== null) {
        headerButton.textContent = "ログアウト";
        headerButton.onclick = () => {
            logout();
        };
    }
    else {
        headerButton.textContent = "ログイン";
        headerButton.onclick = () => {
            window.location.href = "./login.html";
        };
    }
    return headerButton;
}
//# sourceMappingURL=headerButton.js.map