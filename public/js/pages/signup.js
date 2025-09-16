/**
 * File: public/js/pages/signup.js
 * Description: signup.phpの表示、処理をまとめて行う
 */

import { getSession } from "../clients/auth/getSession.js";
import { getUserList } from "../clients/user/getUserList.js";
import { layout } from "../components/common/layout.js";
import { createAccount } from "../components/auth/createAccount.js";
import { userList } from "../components/user/userList.js";
import { signupForm } from "../components/auth/signupForm.js";


async function renderInitial(username) {
    layout(username);
    document.body.append(createAccount("login"));

    document.body.append(signupForm(username));

    const userListContainer = document.createElement("div");
    userListContainer.id = "user-list-container";
    document.body.append(userListContainer);

    await renderUserList();
}


async function renderUserList() {
    const userListData = await getUserList();
    const userListContainer = document.getElementById("user-list-container");

    userListContainer.innerHTML = "";

    if (userListData !== null) {
        userListContainer.append(userList(userListData.user_list));
    } else {
        userListContainer.textContent = "ユーザー一覧の取得に失敗しました";
    }
}


async function init() {
    const session = await getSession();
    const username = (session !== null) ? session.username : null;

    await renderInitial(username)

    if (username !== null) {
        alert("既にログインしています");
        window.location.href = "./index.html";
    }
}

init();
