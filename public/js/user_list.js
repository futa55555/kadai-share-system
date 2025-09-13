/**
 * File: public/js/user_list.js
 * Description: ユーザー一覧の取得関数
 */

async function loadUsers() {
    try {
        const res = await fetch("../../handlers/api/user_list.php");
        const json = await res.json();

        if (json.status === "success") {
            const list = document.getElementById("user-list");
            list.innerHTML = "";
            json.data.forEach(user => {
                const li = document.createElement("li");
                li.textContent = user.username;
                list.appendChild(li);
            });
        } else {
            console.error("API error:", json.message);
        }
    } catch (err) {
        console.error("Fetch error:", err);
    }
}

document.addEventListener("DOMContentLoaded", loadUsers);
