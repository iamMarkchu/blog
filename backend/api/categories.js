import request from '../utils/request'

const URL = '/categories'

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

export function fetchAll() {
    return request({
        url: URL+'/all',
        method: 'GET'
    })
}

export function fetch(id) {
    return request({
        url: URL + '/'+ id,
        method: 'get'
    })
}

export function tree() {
    return request({
        url: URL+ '/tree',
        method: 'get'
    })
}

export function del(id) {
    return request({
        url: URL + '/'+ id,
        method: 'DELETE'
    })
}

export function revoke(id) {
    return request({
        url: URL + '/'+ id + '/revoke',
        method: 'PUT'
    })
}