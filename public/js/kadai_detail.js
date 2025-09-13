/**
 * File: public/js/kadai_list.js
 * Description: 課題詳細の取得関数
 */

async function loadKadaiDetail() {
    try {
        const detailEl = document.getElementById("kadai-id");
        const kadaiId = detailEl.dataset.kadaiId;

        const res = await fetch(`../../handlers/api/kadai_detail.php?kadai_id=${kadaiId}`);
        const json = await res.json();

        if (json.status === "success") {
            const detail = document.getElementById("kadai-detail");
            detail.innerHTML = "";

            const kd = json.data;

            const normalFields = ["kadai_id", "username", "mission_genre", "mission_detail", "goal", "problem", "resolve_state", "created_at"];
            normalFields.forEach(field => {
                if (kd[field] !== undefined) {
                    const li = document.createElement("li");
                    li.textContent = `${field}: ${kd[field]}`;
                    detail.appendChild(li);
                }
            });

            if (kd.error_file) {
                const li = document.createElement("li");
                const a = document.createElement("a");
                a.href = `../../show_file.php?file=${encodeURIComponent(kd.error_file)}`;
                a.target = "_blank";
                a.textContent = `エラーファイル: ${kd.error_file.split('/').pop()}`; // ファイル名のみ表示
                li.appendChild(a);
                detail.appendChild(li);
            }
        } else {
            console.error("API error:", json.message);
        }
    } catch (err) {
        console.error("Fetch error:", err);
    }
}

document.addEventListener("DOMContentLoaded", loadKadaiDetail);
