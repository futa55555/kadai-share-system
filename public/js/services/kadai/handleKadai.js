/**
 * File: public/js/services/kadai/handleKadai.js
 * Description: 課題投稿ボタンの処理関数
 */
import { postKadai } from "../../clients/kadai/postKadai.js";
export async function handleKadai(username) {
    const missionGenre = document.getElementById("mission-genre").value;
    const missionDetail = document.getElementById("mission-detail").value;
    const goal = document.getElementById("goal").value;
    const problem = document.getElementById("problem").value;
    const errorCode = document.getElementById("error-code").value;
    const resolveState = document.getElementById("resolve-state").value;
    const content = document.getElementById("content").value;
    const commentCode = document.getElementById("comment-code").value;
    postKadai(username, missionGenre, missionDetail, goal, problem, errorCode, resolveState, content, commentCode);
}
//# sourceMappingURL=handleKadai.js.map