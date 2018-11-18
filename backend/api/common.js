import request from "../utils/request";

export function generateUrl(q) {
    return request({
        url: '/generate-url',
        params: {q: q}
    })
}