/**
 * File: public/js/clients/auth/logout.js
 * Description: ログアウトの処理関数
 *
 * @param {none} なし
 *
 * @return {none} 成功したらページ遷移
 */

export async function logout() {
    try {
        const res = await fetch("../../api/auth/logout.php", {
            method: "POST"
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Logout succeeded");
            window.location.href = "./index.html";
        } else {
            console.error(`Failed to logout: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
