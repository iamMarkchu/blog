import request from '../utils/request'

const URL = '/articles'

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

export function edit(id) {
    return request({
        url: URL + '/'+ id + '/edit',
        method: 'get'
    })
}

export function changeStatus(data) {
    return request({
        url: URL+ '/' + data.id + '/change',
        method: 'put',
        data
    })
}

export function del(id) {
    return request({
        url: URL+ '/' + id,
        method: 'delete'
    })
}
export function publish(id) {
    return request({
        url: URL+ '/' + id + '/publish',
        method: 'put'
    })
}
export function revoke(id) {
    return request({
        url: URL+ '/' + id + '/revoke',
        method: 'put'
    })
}