/**
 * File: public/js/components/auth/createAccount.js
 * Description: ヘッダーメッセージの作成関数
 */
export function createAccount(page) {
    const message = document.createElement("p");
    message.classList.add("create-account");
    const link = document.createElement("a");
    link.textContent = "こちら";
    if (page === "signup") {
        message.textContent = "アカウントをお持ちでない場合は";
        link.href = `./${page}.html`;
    }
    else if (page === "login") {
        message.textContent = "アカウントをお持ちの場合は";
        link.href = `./${page}.html`;
    }
    else {
        console.error(`Invalid value: ${page}`);
    }
    message.append(link);
    return message;
}
//# sourceMappingURL=createAccount.js.map