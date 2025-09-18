/**
 * File: public/js/components/comment/commentForm.js
 * Description: コメント投稿フォームの作成関数
 */

import { handleComment } from "../../services/comment/handleComment.js";


export function commentForm(username, kadaiId) {
    const commentForm = document.createElement("div");
    commentForm.classList.add("comment-form");


    const commentTypeGroup = document.createElement("div");
    commentTypeGroup.classList.add("comment-group");

    const commentTypeLabel = document.createElement("label");
    commentTypeLabel.htmlFor = "comment-type";
    commentTypeLabel.classList.add("comment-label");
    commentTypeLabel.textContent = "コメント種類：";
    commentTypeGroup.append(commentTypeLabel);

    const commentTypeSelect = document.createElement("select");
    commentTypeSelect.id = "comment-type";
    commentTypeSelect.classList.add("comment-input", "comment-select");
    commentTypeGroup.append(commentTypeSelect);

    const placeholder = document.createElement("option");
    placeholder.value = "";
    placeholder.textContent = "選択してください";
    placeholder.disabled = true;
    placeholder.selected = true;
    commentTypeSelect.append(placeholder);

    const empathyOption = document.createElement("option");
    empathyOption.value = "empathy";
    empathyOption.textContent = "共感";
    commentTypeSelect.append(empathyOption);

    const solutionOption = document.createElement("option");
    solutionOption.value = "solution";
    solutionOption.textContent = "解決策";
    commentTypeSelect.append(solutionOption);

    commentForm.append(commentTypeGroup);


    const contentGroup = document.createElement("div");
    contentGroup.classList.add("comment-group");

    const contentLabel = document.createElement("label");
    contentLabel.htmlFor = "content";
    contentLabel.classList.add("comment-label");
    contentLabel.textContent = "コメント内容：";
    contentGroup.append(contentLabel);

    const contentInput = document.createElement("textarea");
    contentInput.id = "content";
    contentInput.classList.add("comment-input");
    contentGroup.append(contentInput);

    commentForm.append(contentGroup);


    const commentCodeGroup = document.createElement("div");
    commentCodeGroup.classList.add("comment-group");

    const commentCodeLabel = document.createElement("label");
    commentCodeLabel.htmlFor = "comment-code";
    commentCodeLabel.classList.add("comment-label");
    commentCodeLabel.textContent = "コメントファイル：";
    commentCodeGroup.append(commentCodeLabel);

    const commentCodeInput = document.createElement("textarea");
    commentCodeInput.id = "comment-code";
    commentCodeInput.classList.add("comment-input");
    commentCodeInput.placeholder = "リンクではなく、ファイルの中身をコピペしてください。\n（空欄可）";
    commentCodeGroup.append(commentCodeInput);

    commentForm.append(commentCodeGroup);


    const commentButton = document.createElement("button");
    commentButton.classList.add("btn", "comment-form-button");
    if (username !== null) {
        commentButton.classList.add("out-form");
    } else {
        commentButton.classList.add("in-form");
    }
    commentButton.textContent = "コメント投稿";

    commentButton.onclick = () => {
        if (username !== null) {
            handleComment(username, kadaiId);
        } else {
            alert("コメント投稿にはログインが必要です");
        }
    }

    commentForm.append(commentButton);


    return commentForm;
}
