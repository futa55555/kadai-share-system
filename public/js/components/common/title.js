/**
 * File: public/js/components/common/title.js
 * Description: タイトルの作成関数
 */

export function title() {
    const title = document.createElement("h1");
    title.classList.add("title");

    const link = document.createElement("a");
    link.href = "index.html";
    link.textContent = "課題共有システム";

    title.append(link);


    return title;
}
