<?php

$appid="wxc7fac86788e3f528";
$appsecret="075f31740aa1c9ea5bd8d3c9e92a0a41";

$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxc7fac86788e3f528&secret=075f31740aa1c9ea5bd8d3c9e92a0a41";

//$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);//给 HTTPS 用的
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }

$result=httpGet($url);//json字符串
var_dump($result);
$what=json_decode($result,true);
//var_dump($what);
$access_token=$what["access_token"];
$api="https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$access_token";
$list=httpGet($api);
var_dump($list);



?>