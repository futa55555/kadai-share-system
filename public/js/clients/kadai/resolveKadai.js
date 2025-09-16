/**
 * File: public/js/clients/kadai/resolveKadai.js
 * Description: 解決状況の更新の処理関数
 *
 * @param {number} kadaiId 課題ID
 *
 * @return {none} なし
 */

import { renderKadaiDetail } from "../../pages/kadai_detail.js";


export async function resolveKadai(username, kadaiId) {
    try {
        const res = await fetch("../../api/kadai/resolve_kadai.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                username: username,
                kadai_id: kadaiId
            })
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Update resolve state successfully");
            renderKadaiDetail(json.data.username, json.data.kadai_id);
        } else {
            console.error(`Failed to update resolve state: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
