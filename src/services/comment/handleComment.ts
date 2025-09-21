/**
 * File: public/js/services/comment/handleComment.js
 * Description: コメント投稿ボタンの処理関数
 */

import { postComment } from "../../clients/comment/postComment.js";


export async function handleComment(username, kadaiId) {
    const commentType = document.getElementById("comment-type").value;
    const content = document.getElementById("content").value;
    const commentCode = document.getElementById("comment-code").value;

    postComment(
        username,
        kadaiId,
        commentType,
        content,
        commentCode
    )
}
