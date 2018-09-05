<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/9/5
 * Time: 22:51
 */

use App\Utils\Baidu\Translate;

if(!function_exists('generate_url'))
{
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
        $words = $result['trans_result'][0]['dst']??"";
        return str_slug($words);
    }
}