import request from '../utils/request'

const URL = '/images'

export function add(data) {
    return request({
        url: URL,
        method: 'POST',
        data
    })
}

export function update(data, id) {
    return request({
        url: URL + '/'+ id,
        method: 'PUT',
        data
    })
}

export function fetchList(query) {
    return request({
        url: URL,
        method: 'GET',
        params: query
    })
}

export function fetch(id) {
    return request({
        url: URL + '/'+ id,
        method: 'get'
    })
}