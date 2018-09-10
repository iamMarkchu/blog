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