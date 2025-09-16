/**
 * File: public/js/components/kadai/kadaiPostButton.js
 * Description: 課題投稿ボタンの作成関数
 *
 * @param {string} username ユーザー名
 */

export function kadaiPostButton() {
    const kadaiPostButton = document.createElement("button");
    kadaiPostButton.classList.add("btn", "kadai-post-button");
    kadaiPostButton.textContent = "課題投稿";
    kadaiPostButton.onclick = () => {
        window.location.href = "./kadai_post.html";
    }

    return kadaiPostButton;
}
