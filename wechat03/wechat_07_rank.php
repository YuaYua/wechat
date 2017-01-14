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
	$jsonArr=json_decode($json,true);
//	var_dump($json);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title></title>
	</head>
	<body>
		<img src="<?php echo $jsonArr["headimgurl"]; ?>"/>
		<button id="play">颜值</button>
		<div id="test"></div>
	</body>
	<script src="zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var btn=document.getElementById("play");
		var openid='<?php echo $jsonArr["openid"];?>';
		var nickname='<?php echo $jsonArr["nickname"];?>';
		var img='<?php echo $jsonArr["headimgurl"];?>';
		btn.addEventListener("click",function(){
			var num=Math.random();
            console.log(num);
            num=String(num).substring(2,4);
            
			console.log(num);
            console.log(openid);
            $.ajax({
	            	type:"get",
	            	url:"wechat_08_server.php",
	            	data:{
	            		openid:openid,
	            		nick:nickname,
	            		img:img,
	            		score:num,
	            	},
	            	dataType:"json",
	            	success:function(data){
	            		console.log("成功");
	            		console.log(data);
	            	},
	            	error:function(errores){
	            		console.log("失败");
	            		console.log(errores);
	            	},                           
	            	
	            	async:true
            });
            
            
//			test.innerHTML=num;
		},false);
	</script>
</html>
