/**
 * File: public/js/clients/file/getFileLine.js
 * Description: ファイルの中身の取得関数
 */

export async function getFileLine(type, filename) {
    try {
        const res = await fetch(`../api/file/get_file_line.php?type=${type}&filename=${filename}`, {
            method: "GET"
        });
        const json = await res.json();

        if (json.status === "success") {
            console.log("Got file line successfully");
            return json.data;
        } else {
            console.error(`Failed to get file line: ${json.message}`);
        }
    } catch (err) {
        console.error(`Error: ${err}`);
    }
}
