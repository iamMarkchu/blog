export const UPLOAD_URL = '/admin/materials/upload'
export const ASSETS_URL = '/storage/'

let url = (process.env.NODE_ENV == 'development') ? 'http://blog.test/': 'https://www.mcgoldfish.com/'
let url_without_slash = (process.env.NODE_ENV == 'development') ?  'http://blog.test': 'https://www.mcgoldfish.com'
export const FRONT_FULL_URL = url
export const FRONT_FULL_URL_WITHOUT_SLASH = url_without_slash


let token = document.head.querySelector('meta[name="csrf-token"]');
export const HEADERS = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': token.content
}