/**
 * File: public/js/pages/kadai_post.js
 * Description: kadai_post.phpの表示、処理をまとめて行う
 */

import { getSession } from "../clients/auth/getSession.js";
import { layout } from "../components/common/layout.js";
import { headerMessage } from "../components/auth/headerMessage.js";
import { kadaiForm } from "../components/kadai/kadaiForm.js";
import { dynamicKadaiForm } from "../services/kadai/dynamicKadaiForm.js";


function renderInitial(username) {
    layout(username);
    document.body.append(headerMessage(username));

    document.body.append(kadaiForm(username));

    dynamicKadaiForm();
}


async function init() {
    const session = await getSession();
    const username = (session !== null) ? session.username : null;

    renderInitial(username);

    if (username === null) {
        alert("課題投稿にはログインが必要です");
    }
}

init();
