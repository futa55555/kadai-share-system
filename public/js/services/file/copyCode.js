/**
 * File: public/js/services/file/copyCode.js
 * Description: コピーボタンの処理関数
 */
export function copyCode(button) {
    const codeBlock = button.parentElement;
    let text = "";
    codeBlock.querySelectorAll(".text").forEach(line => {
        text += line.textContent + "\n";
    });
    navigator.clipboard.writeText(text.trim()).then(() => {
        button.textContent = "コピー済み";
        setTimeout(() => (button.textContent = "コピー"), 1500);
    });
}
//# sourceMappingURL=copyCode.js.map