<?php

class vk
{
    private $url = 'https://api.vk.com/method/';
    public $data = '';

    public function __construct() {
        $this->data = json_decode(file_get_contents('php://input'), true);
        if ($this->data['type'] == 'confirmation') exit($this->key);
        else {
            
        }
    }

    public function request($method,$params=array()){
        $url = 'https://api.vk.com/method/'.$method;
        $params['access_token']= "a674e7e28d9494db2368c299c10475659ce5f89b0275f65b3f7d5959bfe88b1458db4e78ebf79d7b99211";
        $params['v']= "5.81";
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type:multipart/form-data"
            ));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $result = json_decode(curl_exec($ch), True);
            curl_close($ch);
        } else {
            $result = json_decode(file_get_contents($url, true, stream_context_create(array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($params)
                )
            ))), true);
        }
        if (isset($result['response']))
            return $result['response'];
        else
            return $result;
    }
}