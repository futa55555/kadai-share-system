/**
 * File: public/js/pages/index.js
 * Description: index.htmlの表示、処理をまとめて行う
 */

import { getSession } from "../clients/auth/getSession.js";
import { getKadaiList } from "../clients/kadai/getKadaiList.js";
import { layout } from "../components/common/layout.js";
import { headerMessage } from "../components/auth/headerMessage.js";
import { kadaiPostButton } from "../components/kadai/kadaiPostButton.js";
import { kadaiList } from "../components/kadai/kadaiList.js";


async function renderInitial(username) {
    layout(username);
    document.body.append(headerMessage(username));

    document.body.append(kadaiPostButton());

    const kadaiListContainer = document.createElement("div");
    kadaiListContainer.id = "kadai-list-container";
    document.body.append(kadaiListContainer);

    await renderKadaiList();
}


async function renderKadaiList() {
    const data = await getKadaiList();
    const container = document.getElementById("kadai-list-container");

    container.innerHTML = "";

    if (data !== null) {
        container.append(kadaiList(data.kadai_list));
    } else {
        container.textContent = "課題一覧の取得に失敗しました";
    }
}


async function init() {
    const session = await getSession();
    const username = (session !== null) ? session.username : null;

    await renderInitial(username);

    setInterval(renderKadaiList, 100000);
}

init();
