/**
 * File: public/js/components/kadai/kadaiCard.js
 * Description: 課題一覧の各カード要素の作成関数
 */

export function kadaiCard(kadai) {
    const card = document.createElement("div");
    card.classList.add("kadai-card", `${kadai.resolve_state}`);


    const goal = document.createElement("p");
    goal.classList.add("kadai-goal");

    const link = document.createElement("a");
    link.href = `kadai_detail.html?kadai_id=${kadai.kadai_id}`;
    link.textContent = `${kadai.goal}`;
    goal.append(link);

    card.append(goal);


    const mission = document.createElement("p");
    mission.classList.add("kadai-mission");
    mission.textContent = `${kadai.mission_genre}-${kadai.mission_detail}`;
    card.append(mission);


    const user = document.createElement("p");
    user.classList.add("kadai-user");
    user.textContent = `${kadai.username}`;
    card.append(user);


    const problem = document.createElement("p");
    problem.classList.add("kadai-problem");
    problem.textContent = `${kadai.problem}`;
    card.append(problem);


    const resolveState = document.createElement("p");
    resolveState.classList.add("kadai-resolve-state");
    resolveState.textContent = `${kadai.resolve_state}`;
    card.append(resolveState);


    const createdAt = document.createElement("p");
    createdAt.classList.add("kadai-created-at");
    createdAt.textContent = `投稿日：${kadai.created_at}`;
    card.append(createdAt);


    const resolvedAt = document.createElement("p");
    resolvedAt.classList.add("kadai-resolved-at");
    if (kadai.resolve_state === "resolved") {
        resolvedAt.textContent = `解決日：${kadai.resolved_at}`;
    } else {
        resolvedAt.textContent = `未解決`;
    }
    card.append(resolvedAt);


    return card;
}
