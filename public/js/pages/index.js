/**
 * File: public/js/pages/index.js
 * Description: index.htmlの表示、処理をまとめて行う
 */

import { getSession } from "../clients/auth/getSession.js";
import { getKadaiList } from "../clients/kadai/getKadaiList.js";
import { title } from "../components/common/title.js";
import { headerButton } from "../components/auth/headerButton.js";
import { headerMessage } from "../components/auth/headerMessage.js";
import { kadaiPostButton } from "../components/kadai/kadaiPostButton.js";
import { kadaiFilterSelect } from "../components/kadai/kadaiFilterSelect.js";
import { kadaiList } from "../components/kadai/kadaiList.js";


async function renderInitial(username) {
    document.body.append(title());
    document.body.append(headerButton(username));
    document.body.append(headerMessage(username));

    document.body.append(kadaiPostButton());

    const kadaiFilter = kadaiFilterSelect();
    kadaiFilter.addEventListener("change", renderKadaiList);
    document.body.append(kadaiFilter);

    const kadaiListContainer = document.createElement("div");
    kadaiListContainer.id = "kadai-list-container";
    document.body.append(kadaiListContainer);

    await renderKadaiList();
}


async function renderKadaiList() {
    const kadaiFilterSelect = document.getElementById("kadai-filter-select");

    const data = await getKadaiList(kadaiFilterSelect.value);
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
