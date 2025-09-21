/**
 * File: public/js/services/kadai/dynamicKadaiForm.js
 * Description: 課題投稿フォームの動的な表示関数
 */
export function dynamicKadaiForm() {
    function range(n) {
        return Array.from({ length: n }, (_, i) => i + 1);
    }
    const detailOptions = {
        0: range(22),
        1: range(27),
        2: range(4),
        3: range(4),
        4: range(9),
        5: range(4),
        6: range(2),
        7: range(1)
    };
    const genreSelect = document.getElementById("mission-genre");
    const detailSelect = document.getElementById("mission-detail");
    const placeholder = document.createElement("option");
    placeholder.value = "";
    placeholder.textContent = "選択してください";
    placeholder.disabled = true;
    placeholder.selected = true;
    genreSelect.append(placeholder);
    for (let i = 0; i <= 7; i++) {
        const opt = document.createElement("option");
        opt.value = i;
        opt.textContent = i;
        genreSelect.append(opt);
    }
    function updateDetailOptions(selected) {
        detailSelect.innerHTML = "";
        if (detailOptions[selected]) {
            detailOptions[selected].forEach(function (detail) {
                const option = document.createElement("option");
                option.value = detail;
                option.textContent = detail;
                detailSelect.append(option);
            });
        }
        else {
            const option = document.createElement("option");
            option.value = "";
            option.textContent = "選択してください";
            detailSelect.append(option);
        }
    }
    genreSelect.addEventListener("change", function () {
        updateDetailOptions(this.value, null);
    });
    function toggleCommentBox(commentBox, state) {
        if (commentBox === null)
            return;
        commentBox.style.display = (state === "resolved") ? "block" : "none";
    }
    const resolveState = document.getElementById("resolve-state");
    const commentBox = document.getElementById("comment-box");
    toggleCommentBox(commentBox, resolveState.value);
    resolveState.addEventListener("change", function () {
        toggleCommentBox(commentBox, this.value);
    });
}
//# sourceMappingURL=dynamicKadaiForm.js.map