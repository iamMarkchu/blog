<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/9/5
 * Time: 22:45
 */

namespace App\Utils\Baidu;


class Translate
{
    protected $translateUrl;
    protected $translateAppId;
    protected $translateSecret;
    public function __construct()
    {
        $this->translateUrl = config('baidu.translate_url');
        $this->translateAppId = config('baidu.translate_appid');
        $this->translateSecret = config('baidu.translate_secret');
    }
    /**
     * @param String $query
     * @param String $from
     * @param String $to
     *
     * 查看 http://api.fanyi.baidu.com/api/trans/product/apidoc
     *
     * @return Array
     */
    public function handle($query, $from, $to)
    {
        $args = array(
            'q' => $query,
            'appid' => $this->translateAppId,
            'salt' => rand(10000,99999),
            'from' => $from,
            'to' => $to,
        );
        $args['sign'] = $this->buildSign($query, $this->translateAppId, $args['salt'], $this->translateSecret);
        $ret = $this->call($this->translateUrl, $args);
        $ret = json_decode($ret, true);
        return $ret;
    }
    /**
     * @param $query
     * @param $appID
     * @param $salt
     * @param $secKey
     * @return string
     */
    protected function buildSign($query, $appID, $salt, $secKey)
    {
        $str = $appID . $query . $salt . $secKey;
        $ret = md5($str);
        return $ret;
    }
    /**
     * @param $url
     * @param null $args
     * @param string $method
     * @param int $testflag
     * @param int $timeout
     * @param array $headers
     * @return bool|mixed
     */
    protected  function call($url, $args=null, $method="post", $testflag = 0, $timeout = 10, $headers=array())
    {
        $ret = false;
        $i = 0;
        while($ret === false)
        {
            if($i > 1)
                break;
            if($i > 0)
            {
                sleep(1);
            }
            $ret = $this->callOnce($url, $args, $method, false, $timeout, $headers);
            $i++;
        }
        return $ret;
    }
    /**
     * @param $url
     * @param null $args
     * @param string $method
     * @param bool $withCookie
     * @param int $timeout
     * @param array $headers
     * @return mixed
     */
    protected  function callOnce($url, $args=null, $method="post", $withCookie = false, $timeout = 10, $headers=array())
    {
        $ch = curl_init();
        if($method == "post")
        {
            $data = $this->convert($args);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        else
        {
            $data = $this->convert($args);
            if($data)
            {
                if(stripos($url, "?") > 0)
                {
                    $url .= "&$data";
                }
                else
                {
                    $url .= "?$data";
                }
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($headers))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if($withCookie)
        {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);
        }
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
    /**
     * @param $args
     * @return string
     */
    protected  function convert(&$args)
    {
        $data = '';
        if (is_array($args))
        {
            foreach ($args as $key=>$val)
            {
                if (is_array($val))
                {
                    foreach ($val as $k=>$v)
                    {
                        $data .= $key.'['.$k.']='.rawurlencode($v).'&';
                    }
                }
                else
                {
                    $data .="$key=".rawurlencode($val)."&";
                }
            }
            return trim($data, "&");
        }
        return $args;
    }
}