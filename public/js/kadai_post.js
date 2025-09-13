/**
 * File: public/js/kadai_post.js
 * Description: 課題投稿ページの小ジャンル表示、コメント入力を操作する関数
 */

function range(n) {
    return Array.from({
        length: n
    }, (_, i) => i + 1);
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

const prevGenre = genreSelect.dataset.prevGenre;
const prevDetail = detailSelect.dataset.prevDetail;

const placeholder = document.createElement("option");
placeholder.value = "";
placeholder.textContent = "選択してください";
placeholder.disabled = true;
if (!prevGenre) placeholder.selected = true;
genreSelect.appendChild(placeholder);

for (let i = 0; i <= 7; i++) {
    const opt = document.createElement("option");
    opt.value = i;
    opt.textContent = i;
    if (String(i) === prevGenre) opt.selected = true;
    genreSelect.appendChild(opt);
}

function updateDetailOptions(selected, prevDetail) {
    detailSelect.innerHTML = "";

    if (detailOptions[selected]) {
        detailOptions[selected].forEach(function (detail) {
            const option = document.createElement("option");
            option.value = detail;
            option.textContent = detail;
            if (detail == prevDetail) {
                option.selected = true;
            }
            detailSelect.appendChild(option);
        });
    } else {
        const option = document.createElement("option");
        option.value = "";
        option.textContent = "選択してください";
        detailSelect.appendChild(option);
    }
}
if (prevGenre) {
    updateDetailOptions(prevGenre, prevDetail);
}

genreSelect.addEventListener("change", function () {
    updateDetailOptions(this.value, null);
});

const resolveState = document.getElementById("resolve-state");

const commentBox = document.getElementById("comment-box");

toggleCommentBox(resolveState.value);

resolveState.addEventListener("change", function () {
    toggleCommentBox(this.value);
});

function toggleCommentBox(state) {
    if (!commentBox) return;
    commentBox.style.display = (state === "resolved") ? "block" : "none";
}
