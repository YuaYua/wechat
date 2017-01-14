<?php
	include_once "wechatCommon.php";
	$code=$_GET["code"];
	session_start();
//var_dump($_SESSION);
	if(isset($_SESSION["code"])){
        
        $code=$_SESSION["code"];
    	$api="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $result=httpGet($api);
        $arr=json_decode($result,true);
        //var_dump($arr);
        session_destroy();
        $access_token=$arr["access_token"];
        $openid=$arr["openid"];
    //	var_dump($result);
        $userUrl="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $json=httpGet($userUrl);
        $jsonArr=json_decode($json,true);
    }else{
    	$_SESSION["code"]=$code;
        //var_dump($_SESSION);
        //header("Location:wechat_07_rank.php?code=$code");
    }
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
        <img src="<?php echo $jsonArr["headimgurl"]; ?>"/>
		<div id="main">
			<div id="wrap">
				<p id="num">1</p>
			</div>
			<button id="start" class="btn1">开始</button>
			<button id="stop" class="btn1">停止</button>
			<ul id="rankList"></ul>
		</div>
		<div id="test">
			
		</div>
	</body>
	<script src="JQuery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var num=document.getElementById("num");
		var start=document.getElementById("start");
		var stop1=document.getElementById("stop");
		var test=document.getElementById("test");
		var openid='<?php echo $jsonArr["openid"];?>';
		var nickname='<?php echo $jsonArr["nickname"];?>';
		var img='<?php echo $jsonArr["headimgurl"];?>';
		
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
			url:"all_db.php",
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
		stop1.onclick=function(){
			clearInterval(timer);
			var score=num.innerHTML;
			$.ajax({
				type:"get",
				url:"rank.php",
				data:{
					score:score,
					openid:openid,
					nickname:nickname,
					headimgurl:img,
				},
                dataType:"json",
				success:function(data){
					console.log("成功");
					console.log(data);
                    test.innerHTML=data[0].openid;
                       $("#rankList").html("");
                        for (var keys in data) {
                             var liObj=createLi(data[keys]);
                             $("#rankList").append(liObj);
                            
                        }
                   
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
