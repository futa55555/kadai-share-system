/**
 * File: public/js/clients/kadai/getLatestKadaiId.js
 * Description: 最新の課題IDの取得関数
 *
 * @param {none} なし
 *
 * @param {Promise<Object[]>} 課題一覧
 */

export async function getLatestKadaiId(username) {
    try {
        const res = await fetch("../../api/kadai/get_latest_kadai_id.php", {
            method: "GET",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                username: username
            })
        });
        const json = await res.json();

        if (json.status === "success") {
            alert("Got latest kadai id successfully");
            return json.data;
        } else {
            console.error(`Failed to get latest kadai id: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
