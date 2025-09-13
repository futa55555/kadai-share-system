/**
 * File: public/js/kadai_list.js
 * Description: 課題一覧の取得関数
 */

async function loadKadais() {
    try {
        const res = await fetch("../../handlers/api/kadai_list.php");
        const json = await res.json();

        if (json.status === "success") {
            const list = document.getElementById("kadai-list");
            list.innerHTML = "";

            json.data.forEach(kadai => {
                const card = document.createElement("div");
                card.className = "kadai-card";

                card.innerHTML = `
                    <h3>課題 #${kadai.kadai_id}</h3>
                    <p><strong>ユーザー：</strong>${kadai.username}</p>
                    <p><strong>ミッション：</strong>${kadai.mission_genre}-${kadai.mission_detail}</p>
                    <p><strong>状態：</strong>${kadai.resolve_state}</p>
                    <p><strong>投稿日：</strong>${kadai.created_at}</p>
                    <a href="kadai_detail.php?kadai_id=${kadai.kadai_id}">詳細を見る</a>
                `;

                list.appendChild(card);
            });
        } else {
            console.error("API error:", json.message);
        }
    } catch (err) {
        console.error("Fetch error:", err);
    }
}

document.addEventListener("DOMContentLoaded", loadKadais);
