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
            list.innerHTML = "<h2>課題一覧</h2>";

            json.data.forEach(kadai => {
                const card = document.createElement("div");
                card.classList.add("kadai-card");
                card.classList.add(`${kadai.resolve_state}`);

                const user = document.createElement("p");
                user.classList.add("kadai-user");
                user.textContent = `${kadai.username}`;
                card.appendChild(user);

                const mission = document.createElement("p");
                mission.classList.add("kadai-mission");
                mission.textContent = `${kadai.mission_genre}-${kadai.mission_detail}`;
                card.appendChild(mission);

                const goal = document.createElement("p");
                goal.classList.add("kadai-goal");

                const link = document.createElement("a");
                link.href = `kadai_detail.php?kadai_id=${kadai.kadai_id}`;
                link.textContent = `${kadai.goal}`;

                goal.appendChild(link);
                card.appendChild(goal);

                const problem = document.createElement("p");
                problem.classList.add("kadai-problem");
                problem.textContent = `${kadai.problem}`;
                card.appendChild(problem);

                const resolveState = document.createElement("p");
                resolveState.classList.add("kadai-resolveState");
                resolveState.textContent = `${kadai.resolve_state}`;
                card.appendChild(resolveState);

                const createdAt = document.createElement("p");
                createdAt.classList.add("kadai-createdAt");
                createdAt.textContent = `${kadai.created_at}`;
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

document.addEventListener("DOMContentLoaded", loadKadais);
