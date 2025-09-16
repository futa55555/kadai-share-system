/**
 * File: public/js/clients/kadai/getKadaiList.js
 * Description: 課題一覧の取得関数
 *
 * @param {none} なし
 *
 * @param {Promise<Object[]>} 課題一覧
 */

export async function getKadaiList() {
    try {
        const res = await fetch("../../api/kadai/get_kadai_list.php", {
            method: "GET"
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Got kadai list successfully");
            return json.data;
        } else {
            console.error(`Failed to get kadai list: ${json.message}`)
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
