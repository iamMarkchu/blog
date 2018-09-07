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
    function cascader_item($data, $pid=0)
    {
        $subItems = [];
        foreach ($data as $k => $d)
        {
            if ($d['parent_id'] == $pid)
            {
                unset($data[$k]);
                $d['children'] = cascader_item($data, $d['id']);
                $tmpData = [
                    "value" => $d['id'],
                    "label" => $d['name']
                ];
                if (!empty($d['children']))
                {
                    $tmpData["children"] = $d['children'];
                }
                $subItems[] = $tmpData;
            }
        }
        return $subItems;
    }
}