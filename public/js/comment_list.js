/**
 * File: public/js/comment_list.js
 * Description: コメント一覧の取得関数
 */

async function loadComments() {
    try {
        const detailEl = document.getElementById("kadai-id");
        const kadaiId = detailEl.dataset.kadaiId;

        const res = await fetch(`./../handlers/api/comment_list.php?kadai_id=${kadaiId}`);
        const json = await res.json();

        if (json.status === "success") {
            const list = document.getElementById("comment-list");
            list.innerHTML = "";

            json.data.forEach(comment => {
                const li = document.createElement("li");
                li.innerHTML = `
                    コメントID: ${comment.comment_id}<br>
                    ユーザー: ${comment.username}<br>
                    内容: ${comment.content}<br>
                    ${comment.resolve_file
                        ? `<a href="../../show_file.php?file=${encodeURIComponent(comment.resolve_file)}" target="_blank">
                               添付ファイル: ${comment.resolve_file.split('/').pop()}
                           </a>`
                        : "添付なし"}<br>
                    投稿日時: ${comment.created_at}
                `;
                list.appendChild(li);
            });
        } else {
            console.error("API error:", json.message);
        }
    } catch (err) {
        console.error("Fetch error:", err);
    }
}

document.addEventListener("DOMContentLoaded", loadComments);
