<?php
/**
 * Created by PhpStorm.
 * User: jince
 * Date: 2018/9/10
 * Time: 14:17
 */

namespace App\Utils\Github\Api;

use GuzzleHttp\Client;

class Api
{

    protected $apiRoot = "https://api.github.com/";
    protected $personalAccessToken;

    protected $http;

    public function __construct()
    {
        $this->personalAccessToken = config("github.personal_access_token");
        $this->http = new Client([
            "base_uri" => $this->apiRoot,
            "timeout" => 2.0,
            "headers" => [
                "Authorization" => "Bearer ".$this->personalAccessToken,
                "Accept" => "application/vnd.github.v3+json"
            ]
        ]);
    }

    public function httpGet($url)
    {
        $response = $this->http->get($url);
        if ($response->getStatusCode() == 200)
        {
            return $response->getBody()->getContents();
        } else {
            return false;
        }
    }

    public function httpPost()
    {

    }
}