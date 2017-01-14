<?php
	include_once "wechatCommon.php";
	$code=$_GET["code"];
	//echo $code;
	$api="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
	$result=httpGet($api);
	$arr=json_decode($result,true);
	$access_token=$arr["access_token"];
	$openid=$arr["openid"];
	//var_dump($access_token);
	$userUrl="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
	$json=httpGet($userUrl);
	$jsonArr=json_decode($json,true);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<style type="text/css">
			*{
				margin: 0;
				padding: 0;
			}
			ul{
				list-style-type: none;
			}
			#main{
				margin: 10px auto;
				width: 334px;
				text-align: center;
			}
			#wrap{
				height: 200px;
				width: 100%;
				line-height: 200px;
				border: 1px solid black;
			}
			.btn1{
				margin-top: 50px;
			}
			#playimg{
				width: 50px;
				height: 50px;
			}
			#rankList{
				margin-top: 50px;
			}
			.va{
				height: 50px;
				display: inline-block;
				vertical-align: middle;
				margin-left: 20px;
			}
		</style>
	</head>
	<body>
		<div id="main">
			<input type="hidden" name="openid" id="openid" value="<?php echo $jsonArr["openid"]?>" />
			<input type="hidden" name="nickname" id="nickname" value="<?php echo $jsonArr["nickname"]?>" />
			<input type="hidden" name="headimgurl" id="headimgurl" value="<?php echo $jsonArr["headimgurl"]?>" />
			<div id="wrap">
				<p id="num">1</p>
			</div>
			<button id="start" class="btn1">开始</button>
			<button id="stop" class="btn1">停止</button>
			<ul id="rankList">
				<li>
					<img id="playimg" src="../../ajax/ajax01/bookstore img/1.jpg" alt="" />
					<span id="playname" class="va">
						sdadf
					</span>
					<span id="playscore" class="va">
						456
					</span>
				</li>
			</ul>
		</div>
		<div id="test">
			
		</div>
	</body>
	<script src="JQuery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var num=document.getElementById("num");
		var start=document.getElementById("start");
		var stop=document.getElementById("stop");
		var test=document.getElementById("test");
		var openid=document.getElementById("openid");
		var nickname=document.getElementById("nickname");
		var headimgurl=document.getElementById("headimgurl");
		
		
		var timer=null;
		
		function createLi(data){
			var li=$('<li><img id="playimg" src="'
				+data.img+
				'" alt="" /><span id="playname" class="va">'
				+data.nickname+
				'</span><span id="playscore" class="va">'
				+data.score+
				'</span></li>');
			return li;
		}
		
		$.ajax({
			type:"get",
			url:"db.php",
			dataType:"json",
			success:function(data){
				console.log("成功");
				console.log(data);
				if(data["errcode"]==1){
					for (var keys in data) {
						if(keys!="errcode"){
							var liObj=createLi(data[keys]);
							$("#rankList").append(liObj);
						}
					}
				}	
			},
			error:function(errors){
				console.log("失败");
				console.log(errors);
			},
			async:true
		});
		
		
		//随机数1~100
		function rand(max,min){
			return parseInt(Math.random()*(max-min+1)+min);
		}
		start.onclick=function(){
			timer=setInterval(function(){
				n=rand(100,1);
				num.innerHTML=n;
			},30);
		}
		stop.onclick=function(){
			clearInterval(timer);
			var score=num.innerHTML;
			$.ajax({
				type:"get",
				url:"afterRank.php",
				data:{
					score:score,
					openid:openid.value,
					nickname:nickname.value,
					headimgurl:headimgurl.value,
				},
				success:function(data){
					console.log("成功");
					console.log(data);	
				},
				error:function(errors){
					console.log("失败");
					console.log(errors);
				},
				async:true
			});
		}
		
</script>
</html>
