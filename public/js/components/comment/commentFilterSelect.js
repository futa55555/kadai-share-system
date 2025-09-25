/**
 * File: public/js/components/comment/commentFilterSelect.js
 * Description: コメント一覧のフィルター選択の作成関数
 */

export function commentFilterSelect() {
    const commentFilterSelect = document.createElement("select");
    commentFilterSelect.id = "comment-filter-select";
    commentFilterSelect.classList.add("comment-filter-select", "filter");

    const noneOption = document.createElement("option");
    noneOption.selected = true;
    noneOption.value = "";
    noneOption.textContent = "すべて";
    commentFilterSelect.append(noneOption);

    const empatyOption = document.createElement("option");
    empatyOption.value = "empathy";
    empatyOption.textContent = "共感";
    commentFilterSelect.append(empatyOption);

    const solutionOption = document.createElement("option");
    solutionOption.value = "solution";
    solutionOption.textContent = "解決策";
    commentFilterSelect.append(solutionOption);

    return commentFilterSelect;
}
