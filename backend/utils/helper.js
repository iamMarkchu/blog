import { Message } from 'element-ui'
import { FRONT_FULL_URL_WITHOUT_SLASH } from "../api/upload";

export default {
    message: (text, type= 'success') => {
        Message({
            message: text,
            type,
            showClose: true,
        })
    },
    getFullRequestPath(requestPath) {
        return FRONT_FULL_URL_WITHOUT_SLASH + requestPath
    },
    displayTag (item, object, defaultItem='info') {
        return (object[item] !== undefined ) ? object[item]: defaultItem
    },
}