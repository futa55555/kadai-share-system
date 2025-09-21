/**
 * File: public/js/auth/getSession.js
 * Description: ログインセッションの取得関数
 *
 * @param {none} なし
 *
 * @return {Promise<Object[]>} username ユーザー名
 */
export async function getSession() {
    try {
        const res = await fetch("../api/auth/get_session.php", {
            method: "GET"
        });
        const json = await res.json();
        if (json.status === "success") {
            console.log("Got username successfully");
            return json.data;
        }
        else {
            alert(`Failed to get username: ${json.message}`);
        }
    }
    catch (err) {
        console.error(`Error: ${err}`);
    }
}
//# sourceMappingURL=getSession.js.map