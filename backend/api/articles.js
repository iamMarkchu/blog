import request from '../utils/request'

const URL = '/articles'

// 添加文章接口
export function add(data) {
    return request({
        url: URL,
        method: 'POST',
        data
    })
}

// 更新文章接口
export function update(data, id) {
    return request({
        url: URL + '/'+ id,
        method: 'PUT',
        data
    })
}

// 获取文章列表接口
export function fetchList(query) {
    return request({
        url: URL,
        method: 'GET',
        params: query
    })
}

// 用id获取指定文章接口
export function fetch(id) {
    return request({
        url: URL + '/'+ id,
        method: 'get'
    })
}

export function edit(id) {
    return request({
        url: URL + '/'+ id,
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