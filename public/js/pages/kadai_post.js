/**
 * File: public/js/pages/kadai_post.js
 * Description: kadai_post.phpの表示、処理をまとめて行う
 */
import { getSession } from "../clients/auth/getSession.js";
import { title } from "../components/common/title.js";
import { headerButton } from "../components/auth/headerButton.js";
import { headerMessage } from "../components/auth/headerMessage.js";
import { kadaiForm } from "../components/kadai/kadaiForm.js";
import { dynamicKadaiForm } from "../services/kadai/dynamicKadaiForm.js";
function renderInitial(username) {
    document.body.append(title());
    document.body.append(headerButton(username));
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
//# sourceMappingURL=kadai_post.js.map