/**
 * File: public/js/components/comment/commentCard.js
 * Description: コメント一覧の各カード要素の作成関数
 */

export function commentCard(comment) {
    const card = document.createElement("div");
    card.classList.add("comment-card", `${comment.comment_type}`);


    const user = document.createElement("p");
    user.classList.add("comment-user");
    user.textContent = `${comment.username}`;
    card.append(user);


    const comment_type = document.createElement("p");
    comment_type.classList.add("comment-comment-type");
    comment_type.textContent = `${comment.comment_type}`;
    card.append(comment_type);


    const content = document.createElement("p");
    content.classList.add("comment-content");
    content.textContent = `${comment.content}`;
    card.append(content);


    if (comment.comment_filename !== null) {
        const commentFile = document.createElement("p");
        commentFile.classList.add("comment-comment-filename");

        const link = document.createElement("a");
        link.href = `./show_file.html?type=comment&filename=${encodeURIComponent(comment.comment_filename)}`;
        link.target = "_blank";
        link.textContent = `${comment.comment_filename}`;

        commentFile.append(link);
        card.append(commentFile);
    }


    const createdAt = document.createElement("p");
    createdAt.classList.add("comment-created-at");
    createdAt.textContent = `${comment.created_at}`;
    card.append(createdAt);


    return card;
}
