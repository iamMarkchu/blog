import request from '../utils/request'

const URL = '/github'

export function fetchList(query) {
    return request({
        url: URL,
        method: 'GET',
        params: query
    })
}