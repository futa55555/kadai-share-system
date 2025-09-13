/**
 * File: public/js/kadai_list.js
 * Description: 課題詳細の取得関数
 */

async function loadKadaiDetail() {
    try {
        const detailEl = document.getElementById("kadai-detail");
        const kadaiId = detailEl.dataset.kadaiId;

        const res = await fetch("../../handlers/api/kadai_detail.php?kadai_id=${kadaiId}");
        const json = await res.json();

        if (json.status === "success") {
            const detail = document.getElementById("kadai-detail");
            detail.innerHTML = "";

            const kd = json.data;

            for (const [key, value] of Object.entries(kd)) {
                const li = document.createElement("li");
                li.textContent = "${key*: ${value}";
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
