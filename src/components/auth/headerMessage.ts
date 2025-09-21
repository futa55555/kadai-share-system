/**
 * File: public/js/components/auth/headerMessage.js
 * Description: ヘッダーメッセージの作成関数
 */

export function headerMessage(username) {
    const headerMessage = document.createElement("p");
    headerMessage.classList.add("header-message");

    if (username !== null) {
        headerMessage.textContent = `${username}としてログインしています`;
    } else {
        headerMessage.textContent = "ログインしていません";
    }

    return headerMessage;
}
