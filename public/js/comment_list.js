/**
 * File: public/js/comment_list.js
 * Description: コメント一覧の取得関数
 */

async function loadComments() {
    try {
        const detailEl = document.getElementById("kadai-id");
        const kadaiId = detailEl.dataset.kadaiId;

        const res = await fetch(`../../handlers/api/comment_list.php?kadai_id=${kadaiId}`);
        const json = await res.json();

        if (json.status === "success") {
            const list = document.getElementById("comment-list");
            list.innerHTML = "<h2>コメント一覧</h2>";

            json.data.forEach(comment => {
                const card = document.createElement("div");
                card.classList.add("comment-card");
                card.classList.add(`${comment.comment_type}`);

                const user = document.createElement("p");
                user.classList.add("comment-user");
                user.textContent = comment.username;
                card.appendChild(user);

                const content = document.createElement("p");
                content.classList.add("comment-content");
                content.textContent = comment.content;
                card.appendChild(content);

                const commentFile = document.createElement("p");
                commentFile.classList.add("comment-commentFile");

                if (comment.comment_file && comment.comment_file.trim() !== "") {
                    const link = document.createElement("a");
                    link.href = `../../show_file.php?type=comment&file=${encodeURIComponent(comment.comment_file)}`;
                    link.target = "_blank";
                    link.textContent = `${comment.comment_file.split('/').pop()}`;
                    commentFile.appendChild(link);
                } else {
                    commentFile.textContent = "添付なし"
                }

                card.appendChild(commentFile);

                const createdAt = document.createElement("p");
                createdAt.classList.add("comment-createdAt");
                createdAt.textContent = comment.created_at;
                card.appendChild(createdAt);

                list.appendChild(card);
            });
        } else {
            console.error("API error:", json.message);
        }
    } catch (err) {
        console.error("Fetch error:", err);
    }
}

document.addEventListener("DOMContentLoaded", loadComments);
