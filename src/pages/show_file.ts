/**
 * File: public/js/pages/show_file.js
 * Description: ファイルの表示関数
 */

import { getFileLine } from "../clients/file/getFileLine.js";
import { fileLine } from "../components/file/fileLine.js";


async function init() {
    const params = new URLSearchParams(window.location.search);

    const type = params.get("type");
    const filename = params.get("filename");

    const data = await getFileLine(type, filename);
    const lines = await data.lines;

    document.body.append(fileLine(lines));
}


init();
