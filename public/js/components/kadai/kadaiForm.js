/**
 * File: public/js/components/kadai/kadaiForm.js
 * Description: 課題投稿フォームの作成関数
 */

import { handleKadai } from "../../services/kadai/handleKadai.js";


export function kadaiForm(username) {
    const kadaiForm = document.createElement("div");
    kadaiForm.classList.add("kadai-form");


    const missionGroup = document.createElement("div");
    missionGroup.classList.add("kadai-group", "mission-group");

    const missionLabel = document.createElement("label");
    missionLabel.htmlFor = "mission-genre";
    missionLabel.classList.add("kadak-label", "mission-label");
    missionLabel.textContent = "ミッション：";
    missionGroup.append(missionLabel);

    const missionGenreSelect = document.createElement("select");
    missionGenreSelect.id = "mission-genre";
    missionGenreSelect.classList.add("kadai-input", "kadai-select", "mission-genre");
    missionGroup.append(missionGenreSelect);

    const missionHyphen = document.createElement("p");
    missionHyphen.classList.add("kadai-input", "mission-hyphen");
    missionHyphen.textContent = "-";
    missionGroup.append(missionHyphen);

    const missionDetailSelect = document.createElement("select");
    missionDetailSelect.id = "mission-detail";
    missionDetailSelect.classList.add("kadai-input", "kadai-select", "mission-detail");
    missionGroup.append(missionDetailSelect);

    kadaiForm.append(missionGroup);


    const goalGroup = document.createElement("div");
    goalGroup.classList.add("kadai-group");

    const goalLabel = document.createElement("label");
    goalLabel.htmlFor = "goal";
    goalLabel.classList.add("kadai-label");
    goalLabel.textContent = "やりたいこと：";
    goalGroup.append(goalLabel);

    const goalInput = document.createElement("input");
    goalInput.type = "text";
    goalInput.id = "goal";
    goalInput.classList.add("kadai-input");
    goalGroup.append(goalInput);

    kadaiForm.append(goalGroup);


    const problemGroup = document.createElement("div");
    problemGroup.classList.add("kadai-group");

    const problemLabel = document.createElement("label");
    problemLabel.htmlFor = "problem";
    problemLabel.classList.add("kadai-label");
    problemLabel.textContent = "問題点：";
    problemGroup.append(problemLabel);

    const problemInput = document.createElement("textarea");
    problemInput.id = "problem";
    problemInput.classList.add("kadai-input", "kadai-textarea");
    problemGroup.append(problemInput);

    kadaiForm.append(problemGroup);


    const errorCodeGroup = document.createElement("div");
    errorCodeGroup.classList.add("kadai-group");

    const errorCodeLabel = document.createElement("label");
    errorCodeLabel.htmlFor = "error-code";
    errorCodeLabel.classList.add("kadai-label");
    errorCodeLabel.textContent = "エラーコード：";
    errorCodeGroup.append(errorCodeLabel);

    const errorCodeInput = document.createElement("textarea");
    errorCodeInput.id = "error-code";
    errorCodeInput.classList.add("kadai-input", "kadai-textarea");
    errorCodeInput.placeholder = "リンクではなく、ファイルの中身をコピペしてください。";
    errorCodeGroup.append(errorCodeInput);

    kadaiForm.append(errorCodeGroup);


    const resolveStateGroup = document.createElement("div");
    resolveStateGroup.classList.add("kadai-group");

    const resolveStateLabel = document.createElement("label");
    resolveStateLabel.htmlFor = "resolve-state";
    resolveStateLabel.classList.add("kadai-label");
    resolveStateLabel.textContent = "解決状況：";
    resolveStateGroup.append(resolveStateLabel);

    const resolveStateSelect = document.createElement("select");
    resolveStateSelect.id = "resolve-state";
    resolveStateSelect.classList.add("kadai-input", "kadai-select");
    resolveStateGroup.append(resolveStateSelect);

    const unresolvedOption = document.createElement("option");
    unresolvedOption.value = "unresolved";
    unresolvedOption.textContent = "未解決";
    resolveStateSelect.append(unresolvedOption);

    const resolvedOption = document.createElement("option");
    resolvedOption.value = "resolved";
    resolvedOption.textContent = "解決済み";
    resolveStateSelect.append(resolvedOption);

    kadaiForm.append(resolveStateGroup);


    const commentBox = document.createElement("div");
    commentBox.id = "comment-box";
    commentBox.classList.add("comment-box");


    const contentGroup = document.createElement("div");
    contentGroup.classList.add("comment-group");

    const contentLabel = document.createElement("label");
    contentLabel.htmlFor = "content";
    contentLabel.classList.add("comment-label");
    contentLabel.textContent = "解決策：";
    contentGroup.append(contentLabel);

    const contentInput = document.createElement("textarea");
    contentInput.id = "content";
    contentInput.classList.add("comment-input", "comment-textarea");
    contentGroup.append(contentInput);

    commentBox.append(contentGroup);


    const commentCodeGroup = document.createElement("div");
    commentCodeGroup.classList.add("comment-group");

    const commentCodeLabel = document.createElement("label");
    commentCodeLabel.htmlFor = "comment-code";
    commentCodeLabel.classList.add("comment-label");
    commentCodeLabel.textContent = "解決コード：";
    commentCodeGroup.append(commentCodeLabel);

    const commentCodeInput = document.createElement("textarea");
    commentCodeInput.id = "comment-code";
    commentCodeInput.classList.add("comment-input", "comment-textarea");
    commentCodeInput.placeholder = "リンクではなく、ファイルの中身をコピペしてください。";
    commentCodeGroup.append(commentCodeInput);

    commentBox.append(commentCodeGroup);


    kadaiForm.append(commentBox);


    const kadaiButton = document.createElement("button");
    kadaiButton.classList.add("btn", "kadai-form-button");
    if (username !== null) {
        kadaiButton.classList.add("out-form");
    } else {
        kadaiButton.classList.add("in-form");
    }
    kadaiButton.textContent = "課題投稿";

    kadaiButton.onclick = () => {
        if (username !== null) {
            handleKadai(username);
        } else {
            alert("課題投稿にはログインが必要です");
        }
    }

    kadaiForm.append(kadaiButton);


    return kadaiForm;
}
