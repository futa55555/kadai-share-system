/**
 * File: public/js/components/file/fileLine.js
 * Description: ファイルの中身の作成関数
 */
import { copyCode } from "../../services/file/copyCode.js";
export function fileLine(lines) {
    const list = document.createElement("div");
    list.classList.add("file-line");
    const copyButton = document.createElement("button");
    copyButton.classList.add("copy-button");
    copyButton.textContent = "コピー";
    copyButton.onclick = () => {
        copyCode(copyButton);
    };
    list.append(copyButton);
    lines.forEach((line, i) => {
        const el = document.createElement("div");
        el.classList.add("line");
        const num = document.createElement("span");
        num.classList.add("num");
        num.textContent = (i + 1);
        el.append(num);
        const text = document.createElement("span");
        text.classList.add("text");
        text.textContent = line;
        el.append(text);
        list.append(el);
    });
    return list;
}
//# sourceMappingURL=fileLine.js.map