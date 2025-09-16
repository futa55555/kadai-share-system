/**
 * File: public/js/pages/layout.js
 * Description: すべてのページに共通の初期表示
 */

import { title } from "./title.js";
import { headerButton } from "../auth/headerButton.js";


export function layout(username) {
    document.body.append(title());

    document.body.append(headerButton(username));
}
