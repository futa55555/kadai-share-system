/**
 * File: public/js/components/kadai/kadaiDetail.js
 * Description: 課題詳細の作成関数
 */

import { kadaiResolveButton } from "./kadaiResolveButton.js";


export function kadaiDetail(username, kadaiDetail) {
    const heading = document.createElement("h2");
    heading.classList.add("kadai-detail-heading");
    heading.textContent = "課題詳細";


    const card = document.createElement("div");
    card.classList.add("kadai-detail-card");
    card.classList.add(`${kadaiDetail.resolve_state}`);


    const resolveState = document.createElement("p");
    resolveState.classList.add("kadai-detail-resolveState");

    if (kadaiDetail.resolve_state === "unresolved") {
        resolveState.textContent = "未解決";
    } else {
        resolveState.textContent = "解決済み";
    }

    card.append(resolveState);


    const goal = document.createElement("p");
    goal.classList.add("kadai-detail-goal");
    goal.textContent = `${kadaiDetail.goal}`;
    card.append(goal);


    const mission = document.createElement("p");
    mission.classList.add("kadai-detail-mission");
    mission.textContent = `${kadaiDetail.mission_genre}-${kadaiDetail.mission_detail}`;
    card.append(mission);


    const user = document.createElement("p");
    user.classList.add("kadai-detail-user");
    user.textContent = `${kadaiDetail.username}`;
    card.append(user);


    const problem = document.createElement("p");
    problem.classList.add("kadai-detail-problem");
    problem.textContent = `${kadaiDetail.problem}`;
    card.append(problem);


    if (kadaiDetail.error_filename !== null) {
        const errorFilename = document.createElement("p");
        errorFilename.classList.add("kadai-detail-errorFile")

        const link = document.createElement("a");
        link.href = `./show_file.html?type=kadai&filename=${kadaiDetail.error_filename}`;
        link.target = "_blank";
        link.textContent = `${kadaiDetail.error_filename}`;

        errorFilename.append(link);
        card.append(errorFilename);
    }


    const createdAt = document.createElement("p");
    createdAt.classList.add("kadai-detail-createdAt");
    createdAt.textContent = `投稿日時：${kadaiDetail.created_at}`;
    card.append(createdAt);


    if (kadaiDetail.resolve_state === "resolved") {
        const resolvedAt = document.createElement("p");
        resolvedAt.classList.add("kadai-detail-resolvedAt");
        resolvedAt.textContent = `解決日時：${kadaiDetail.resolved_at}`;
        card.append(resolvedAt);
    } else {
        if (username === kadaiDetail.username) {
            card.append(kadaiResolveButton(username, kadaiDetail.kadai_id));
        }
    }


    return card;
}
