/**
 * File: public/js/clients/kadai/getKadaiDetail.js
 * Description: 課題詳細の取得関数
 *
 * @param {number} kadai_id 課題ID
 *
 * @return {Promise<Object>} 課題詳細
 */
export async function getKadaiDetail(kadaiId) {
    try {
        const res = await fetch(`../api/kadai/get_kadai_detail.php?kadai_id=${kadaiId}`, {
            method: "GET"
        });
        const json = await res.json();
        if (json.status === "success") {
            console.log("Got kadai detail successfully");
            return json.data;
        }
        else {
            console.error(`Failed to get kadai detail: ${json.message}`);
        }
    }
    catch (err) {
        console.error(`Error: ${err}`);
    }
}
//# sourceMappingURL=getKadaiDetail.js.map