/**
 * File: public/js/components/kadai/kadaiResolveButton.js
 * Description: 解決ボタンの作成関数
 */
import { resolveKadai } from "../../clients/kadai/resolveKadai.js";
export function kadaiResolveButton(username, kadaiId) {
    const kadaiResolveButton = document.createElement("button");
    kadaiResolveButton.classList.add("btn", "kadai-resolve-button");
    kadaiResolveButton.textContent = "解決した！";
    kadaiResolveButton.onclick = () => {
        alert("Congratulations!");
        resolveKadai(username, kadaiId);
    };
    return kadaiResolveButton;
}
//# sourceMappingURL=kadaiResolveButton.js.map