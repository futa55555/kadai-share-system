/**
 * File: public/js/components/comment/commentList.js
 * Description: コメント一覧の作成関数
 */

import { commentCard } from "./commentCard.js";


export function commentList(commentList) {
    const list = document.createElement("div");
    list.classList.add("comment-list");

    const heading = document.createElement("h2");
    heading.classList.add("comment-list-heading");
    heading.textContent = "コメント一覧";

    list.append(heading);

    commentList.forEach(comment => {
        const card = commentCard(comment);
        list.append(card);
    })

    return list;
}
