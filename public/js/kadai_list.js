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
                const li = document.createElement("li");
                li.textContent = kadai.kadai_id;
                list.appendChild(li);
            });
        } else {
            console.error("API error:", json.message);
        }
    } catch (err) {
        console.error("Fetch error:", err);
    }
}

document.addEventListener("DOMContentLoaded", loadKadais);
