<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/9/16
 * Time: 16:44
 */

namespace App\Utils\Markdown;

use Parsedown;
class Markdown extends Parsedown
{

    protected function inlineImage($excerpt)
    {
        $image = parent::inlineImage($excerpt);
        // dd($image);
        $image['element']['attributes']['data-src'] = $image['element']['attributes']['src'];
        // $image['element']['attributes']['src'] = '/blank.gif';
        $image['element']['attributes']['class'] = 'img-fluid';
        return $image;
    }

    protected function inlineLink($excerpt)
    {
        $link = parent::inlineLink($excerpt);
        if(strpos($excerpt['context'], '!') !== 0 && isset($link['element']['attributes']['href']))
        {
            $link['element']['attributes']['target'] = '_blank';
            if((strpos($link['element']['attributes']['href'], config('app.url')) === false) and (strpos($link['element']['attributes']['href'], 'http') === 0))
            {
                $link['element']['attributes']['rel'] = 'nofollow';
                $link['element']['attributes']['href'] = config('app.url') .'/link?target='. urlencode($link['element']['attributes']['href']);
            }
        }
        return $link;
    }

    protected function blockHeader($line) {
        $line = parent::blockHeader($line);
        $line['element']['attributes']['id'] = $line['element']['text'];
        return $line;
    }
}