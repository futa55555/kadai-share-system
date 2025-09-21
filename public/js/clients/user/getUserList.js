/**
 * File: public/js/clients/user/getUserList.js
 * Description: ユーザー一覧の取得関数
 *
 * @param {none} なし
 *
 * @return {Promise<Object[]>} ユーザー一覧
 */
export async function getUserList() {
    try {
        const res = await fetch("../api/user/get_user_list.php", {
            method: "GET"
        });
        const json = await res.json();
        if (json.status === "success") {
            console.log("Got user list successfully");
            return json.data;
        }
        else {
            console.error(`Failed to get user list: ${json.message}`);
        }
    }
    catch (err) {
        console.error(`Error: ${err}`);
    }
}
//# sourceMappingURL=getUserList.js.map