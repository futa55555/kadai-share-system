/**
 * File: public/js/pages/kadai_detail.js
 * Description: kadai_detail.phpの表示、処理をまとめて行う
 */

import { getSession } from "../clients/auth/getSession.js";
import { getKadaiDetail } from "../clients/kadai/getKadaiDetail.js";
import { getCommentList } from "../clients/comment/getCommentList.js";
import { layout } from "../components/common/layout.js";
import { kadaiDetail } from "../components/kadai/kadaiDetail.js";
import { commentList } from "../components/comment/commentList.js";
import { commentForm } from "../components/comment/commentForm.js";


async function renderInitial(username) {
    const params = new URLSearchParams(window.location.search);
    const kadaiId = params.get("kadai_id");

    layout(username);

    const kadaiDetailContainer = document.createElement("div");
    kadaiDetailContainer.id = "kadai-detail-container";
    document.body.append(kadaiDetailContainer);

    await renderKadaiDetail(username, kadaiId)

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
    const commentListData = await getCommentList(kadaiId);
    const commentListContainer = document.getElementById("comment-list-container");

    commentListContainer.innerHTML = "";

    if (commentListData !== null) {
        commentListContainer.append(commentList(commentListData.comment_list));
    } else {
        commentListContainer.textContent = "コメント一覧の取得に失敗しました";
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
