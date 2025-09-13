/**
 * File: public/js/comment_list.js
 * Description: コメント一覧の取得関数
 */

async function loadComments() {
    try {
        const res = await fetch("../../handlers/api/comment_list.php");
        const json = await res.json();

        if (json.status === "success") {
            const list = document.getElementById("comment-list");
            list.innerHTML = "";
            json.data.forEach(comment => {
                const li = document.createElement("li");
                li.textContent = comment.comment_id;
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
