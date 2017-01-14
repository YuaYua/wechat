<?php
	include_once "wechatCommon.php";
	$code=$_GET["code"];
	$api="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
	$result=httpGet($api);
	$arr=json_decode($result,true);
	$access_token=$arr["access_token"];
	$openid=$arr["openid"];
//	var_dump($result);
	$userUrl="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
	$json=httpGet($userUrl);
	var_dump($json);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title></title>
	</head>
	<body>
        <img src="<?php
			$jsonArr=json_decode($json,true);
			 
			//var_dump($jsonArr);
                 echo $jsonArr["headimgurl"]; 
		?>"/>
	</body>
</html>
