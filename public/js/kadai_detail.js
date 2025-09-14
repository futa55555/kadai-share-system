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
            detail.innerHTML = "<h2>課題詳細</h2>";


            const kd = json.data;


            const card = document.createElement("div");
            card.classList.add("kadai-detail-card");
            card.classList.add(`${kd.resolve_state}`);


            const user = document.createElement("p");
            user.classList.add("kadai-detail-user");
            user.textContent = `${kd.username}`;
            card.appendChild(user);


            const mission = document.createElement("p");
            mission.classList.add("kadai-detail-mission");
            mission.textContent = `${kd.mission_genre}-${kd.mission_detail}`;
            card.appendChild(mission);


            const goal = document.createElement("p");
            goal.classList.add("kadai-detail-goal");
            goal.textContent = `${kd.goal}`;
            card.appendChild(goal);


            const problem = document.createElement("p");
            problem.classList.add("kadai-detail-problem");
            problem.textContent = `${kd.problem}`;
            card.appendChild(problem);


            const errorFilename = document.createElement("p");
            errorFilename.classList.add("kadai-detail-errorFile")

            const link = document.createElement("a");
            link.href = `show_file.php?type=kadai&file=${kd.error_filename}`;
            link.target = "_blank";
            link.textContent = `${kd.error_filename}`;

            errorFilename.appendChild(link);
            card.appendChild(errorFilename);


            const resolveState = document.createElement("p");
            resolveState.classList.add("kadai-detail-resolveState");
            resolveState.textContent = `${kd.resolve_state}`;
            card.appendChild(resolveState);


            const createdAt = document.createElement("p");
            createdAt.classList.add("kadai-detail-createdAt");
            createdAt.textContent = `${kd.created_at}`;
            card.appendChild(createdAt);


            detail.appendChild(card);
        } else {
            console.error("API error:", json.message);
        }
    } catch (err) {
        console.error("Fetch error:", err);
    }
}

document.addEventListener("DOMContentLoaded", loadKadaiDetail);
