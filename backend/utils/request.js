import axios from 'axios'
import { Message } from 'element-ui'

let token = document.head.querySelector('meta[name="csrf-token"]');

if (!token) {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
const service = axios.create({
    baseURL: '/api',
    timeout: 5000,
    headers: {
        'Accept' : 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token.content
    }
});

service.interceptors.response.use(
    response => response,
    error => {
        console.log('err' + error)// for debug
        Message({
            message: error.message,
            type: 'error',
            duration: 10 * 1000
        });
        return Promise.reject(error)
    });

export default service