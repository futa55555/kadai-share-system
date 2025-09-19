/**
 * File: public/js/clients/kadai/postKadai.js
 * Description: 課題投稿の処理関数
 *
 * @param {string} username ユーザー名
 * @param {number} mission_genre ミッション大分類
 * @param {number} mission_detail ミッション小分類
 * @param {string} goal やりたいこと
 * @param {string} problem 問題点
 * @param {string} error_code エラーファイル
 * @param {string} resolve_state 解決状況
 *
 * @return {none} 成功したらページ遷移
 */

import { getLatestKadaiId } from "./getLatestKadaiId.js";
import { postComment } from "../comment/postComment.js";


export async function postKadai(
    username,
    missionGenre,
    missionDetail,
    goal,
    problem,
    errorCode,
    resolveState,
    content,
    commentCode
) {
    try {
        const res = await fetch("../api/kadai/post_kadai.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                username: username,
                mission_genre: missionGenre,
                mission_detail: missionDetail,
                goal: goal,
                problem: problem,
                error_code: errorCode,
                resolve_state: resolveState
            })
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Posted kadai successfully");
            const kadaiId = await getLatestKadaiId(username);

            if (resolveState === "unresolved") {
                window.location.href = "./index.html";
            } else {
                postComment(
                    username,
                    kadaiId,
                    "solution",
                    content,
                    commentCode
                );
            }
        } else {
            console.error(`Failed to post kadai: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
