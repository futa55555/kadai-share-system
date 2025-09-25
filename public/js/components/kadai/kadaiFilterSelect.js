/**
 * File: public/js/components/kadai/kadaiFilterSelect.js
 * Description: 課題一覧のフィルター選択の作成関数
 */

export function kadaiFilterSelect() {
    const kadaiFilterSelect = document.createElement("select");
    kadaiFilterSelect.id = "kadai-filter-select";
    kadaiFilterSelect.classList.add("kadai-filter-select", "filter");

    const noneOption = document.createElement("option");
    noneOption.selected = true;
    noneOption.value = "";
    noneOption.textContent = "すべて";
    kadaiFilterSelect.append(noneOption);

    const unresolvedOption = document.createElement("option");
    unresolvedOption.value = "unresolved";
    unresolvedOption.textContent = "未解決";
    kadaiFilterSelect.append(unresolvedOption);

    const resolvedOption = document.createElement("option");
    resolvedOption.value = "resolved";
    resolvedOption.textContent = "解決済み";
    kadaiFilterSelect.append(resolvedOption);

    return kadaiFilterSelect;
}
