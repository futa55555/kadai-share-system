/**
 * File: public/js/components/kadai/kadaiList.js
 * Description: 課題一覧の作成関数
 */
import { kadaiCard } from "./kadaiCard.js";
export function kadaiList(kadaiList) {
    const list = document.createElement("div");
    list.classList.add("kadai-list");
    const heading = document.createElement("h2");
    heading.classList.add("kadai-list-heading");
    heading.textContent = "課題一覧";
    list.append(heading);
    kadaiList.forEach(kadai => {
        const card = kadaiCard(kadai);
        list.append(card);
    });
    return list;
}
//# sourceMappingURL=kadaiList.js.map