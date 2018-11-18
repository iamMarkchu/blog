<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/9/5
 * Time: 22:51
 */

use App\Utils\Baidu\Translate;

if (!function_exists('generate_url')) {
    /**
     * @param $title
     * @return string
     */
    function generate_url($title)
    {
        $tl = new Translate();
        $from = 'zh';
        $to = 'en';
        $result = $tl->handle($title, $from, $to);
        $words = $result['trans_result'][0]['dst'] ?? "";

        return str_slug($words);
    }
}

if (!function_exists('cascader_item')) {
    function cascader_item($data, $pid = 0)
    {
        $subItems = [];
        foreach ($data as $k => $d) {
            if ($d['parent_id'] == $pid) {
                unset($data[$k]);
                $d['children'] = cascader_item($data, $d['id']);
                $tmpData = [
                    "value" => $d['id'],
                    "label" => $d['name']
                ];
                if (!empty($d['children'])) {
                    $tmpData["children"] = $d['children'];
                }
                $subItems[] = $tmpData;
            }
        }

        return $subItems;
    }
}

if (!function_exists("youdao_oauth2_url")) {
    function youdao_oauth2_url()
    {
        $params = [
            "client_id" => "10be02800f1d363ecf85c029d2cdd035",
            "response_type" => "code",
            "redirect_uri" => "https://www.mcgoldfish.com/callback",
            "state" => "state",
        ];
        return "https://note.youdao.com/oauth/authorize2?".http_build_query($params);
    }
}

if (!function_exists("youdao_access2_url")) {
    function youdao_access2_url()
    {
        $params = [
            "client_id" => "10be02800f1d363ecf85c029d2cdd035",
            "client_secret" => "04f2ef85efc53f291f63ee38aef68071",
            "grant_type" => "authorization_code",
            "redirect_uri" => "https://www.mcgoldfish.com/callback",
            "code" => "code",
        ];
        return "https://note.youdao.com/oauth/authorize2?".http_build_query($params);
    }
}

if (!function_exists("clear_page_cache")) {
    function clear_page_cache($key) {
        return Redis::del($key);
    }
}

if (!function_exists('get_page_cache')) {
    function get_page_cache(string $type, string $url='') {
        if (config('app.debug'))
            return false;
        $cacheKey = get_page_cache_key($type);
        return Redis::get($cacheKey);
    }
}

if (!function_exists('set_page_cache')) {
    /**
     * @param string $type
     * @param string $url
     * @param string $content
     * @return bool|string
     */
    function set_page_cache(string $type, string $url, string $content='') {
        if (config('app.debug'))
            return false;
        $cacheKey = get_page_cache_key($type, $url);
        return Redis::setex($cacheKey, 1800, $content);
    }
}

if (!function_exists('get_page_cache_key')) {
    /**
     * @param string $type
     * @param string $url
     * @return bool|\Illuminate\Config\Repository|mixed|string
     */
    function get_page_cache_key(string $type, string $url='') {
        switch ($type) {
            case 'home':
                $cacheKey = config('cachekey.cache_home_page');
                break;
            case 'article':
                $cacheKey = config('cachekey.cache_articles_page').md5($url);
                break;
            case 'tag':
                $cacheKey = config('cachekey.cache_tags_page').md5($url);
                break;
            case 'category':
                $cacheKey = config("cachekey.cache_categories_page").md5($url);
                break;
            default:
                return false;
        }

        return $cacheKey;
    }
}