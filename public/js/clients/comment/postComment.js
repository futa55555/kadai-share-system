/**aaaaaa
 * File: public/js/clients/comment/postComment.js
 * Description: コメント投稿の処理関数
 *
 * @param {string} username ユーザー名
 * @param {number} kadai_id 課題ID
 * @param {string} comment_type コメントタイプ
 * @param {string} content コメント内容
 * @param {string} comment_code コメントファイル
 *
 * @return {none} なし
 */

export async function postComment(
    username,
    kadaiId,
    commentType,
    content,
    commentCode
) {
    try {
        const res = await fetch("../api/comment/post_comment.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                username: username,
                kadai_id: kadaiId,
                comment_type: commentType,
                content: content,
                comment_code: commentCode
            })
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Posted comment successfully");
            window.location.href = `./kadai_detail.html?kadai_id=${kadaiId}`;
        } else {
            console.error(`Failed to post comment: ${json.message}`);
            alert(`Failed to post comment: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
