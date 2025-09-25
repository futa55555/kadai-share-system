/**
 * File: public/js/pages/kadai_detail.js
 * Description: kadai_detail.phpの表示、処理をまとめて行う
 */

import { getSession } from "../clients/auth/getSession.js";
import { getKadaiDetail } from "../clients/kadai/getKadaiDetail.js";
import { getCommentList } from "../clients/comment/getCommentList.js";
import { title } from "../components/common/title.js";
import { headerButton } from "../components/auth/headerButton.js";
import { headerMessage } from "../components/auth/headerMessage.js";
import { kadaiDetail } from "../components/kadai/kadaiDetail.js";
import { commentFilterSelect } from "../components/comment/commentFilterSelect.js";
import { commentList } from "../components/comment/commentList.js";
import { commentForm } from "../components/comment/commentForm.js";


async function renderInitial(username) {
    const params = new URLSearchParams(window.location.search);
    const kadaiId = params.get("kadai_id");

    document.body.append(title());
    document.body.append(headerButton(username));
    document.body.append(headerMessage(username));

    const kadaiDetailContainer = document.createElement("div");
    kadaiDetailContainer.id = "kadai-detail-container";
    document.body.append(kadaiDetailContainer);

    await renderKadaiDetail(username, kadaiId)

    const commentFilter = commentFilterSelect();
    commentFilter.addEventListener("change", () => {
        renderCommentList(kadaiId);
    });
    document.body.append(commentFilter);

    const commentListContainer = document.createElement("div");
    commentListContainer.id = "comment-list-container";
    document.body.append(commentListContainer);

    await renderCommentList(kadaiId);

    document.body.append(commentForm(username, kadaiId));
}


export async function renderKadaiDetail(username, kadaiId) {
    const kadaiDetailData = await getKadaiDetail(kadaiId);
    const kadaiDetailContainer = document.getElementById("kadai-detail-container");

    kadaiDetailContainer.innerHTML = "";

    if (kadaiDetailData !== null) {
        kadaiDetailContainer.append(kadaiDetail(username, kadaiDetailData));
    } else {
        kadaiDetailContainer.textContent = "課題詳細の取得に失敗しました";
    }
}


async function renderCommentList(kadaiId) {
    const commentFilterSelect = document.getElementById("comment-filter-select");

    const data = await getCommentList(kadaiId, commentFilterSelect.value);
    const container = document.getElementById("comment-list-container");

    container.innerHTML = "";

    if (data !== null) {
        container.append(commentList(data.comment_list));
    } else {
        container.textContent = "コメント一覧の取得に失敗しました";
    }
}


async function init() {
    const session = await getSession();
    const username = (session !== null) ? session.username : null;

    await renderInitial(username);

    if (username === null) {
        alert("コメント投稿にはログインが必要です");
    }
}

init();
