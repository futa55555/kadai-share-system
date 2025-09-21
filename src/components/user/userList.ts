/**
 * File: public/js/components/user/userList.js
 * Description: ユーザー一覧の作成関数
 */

export function userList(userList) {
    const list = document.createElement("ul");
    list.classList.add("user-list");

    const heading = document.createElement("h3");
    heading.classList.add("user-list-heading");
    heading.textContent = "ユーザー一覧";

    list.append(heading);


    userList.forEach(user => {
        const li = document.createElement("li");
        li.classList.add("user");
        li.textContent = `${user.username}`;
        list.append(li);
    })

    return list;
}
