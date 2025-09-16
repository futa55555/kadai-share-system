/**
 * File: public/js/clients/comment/getCommentList.js
 * Description: コメント一覧の取得関数
 *
 * @param {number} kadai_id 課題ID
 *
 * @return {Promise<Object[]>} コメント一覧
 */

export async function getCommentList(kadaiId) {
    try {
        const res = await fetch(`../../api/comment/get_comment_list.php?kadai_id=${kadaiId}`, {
            method: "GET"
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Got comment list successfully");
            return json.data;
        } else {
            console.error(`Failed to get comment list: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
