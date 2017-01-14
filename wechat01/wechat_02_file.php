<?php
$appid="wxc7fac86788e3f528";
$appsecret="075f31740aa1c9ea5bd8d3c9e92a0a41";

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
//--------以上为公共部分可封装------------
function getAccess_token(){
	global $appid;
	global $appsecret;
	$json=file_get_contents("access_token.txt");
	$arr=json_decode($json,true);
	if($arr["expires_in"]<time()){
		//过期
		$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
		$result=httpGet($url);
		$resultArr=json_decode($result,true);
		$access_token=$resultArr["access_token"];
		$times=time()+$resultArr["expires_in"]/2;
		$setArr["access_token"]=$access_token;
		$setArr["expires_in"]=$times;
		$str=json_encode($setArr);
		file_put_contents("access_token.txt", $str);
	}else{
		//未过期
		$access_token=$arr["access_token"];
	}
	return $access_token;
}

$access_token=getAccess_token();
var_dump($access_token);

$api="https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$access_token";
$list=httpGet($api);
var_dump($list);
?>