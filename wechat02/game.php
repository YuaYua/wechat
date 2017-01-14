<style type="text/css">
	*{
		margin: 0;
		padding: 0;
	}
	#main{
		margin: 10px auto;
		width: 50%;
		text-align: center;
	}
	#wrap{
		height: 200px;
		width: 100%;
		line-height: 200px;
		border: 1px solid black;
	}
	#btn{
		margin-top: 50px;
	}
</style>


<div id="main">
	<div id="wrap">
		<p id="num">1</p>
	</div>
	<button id="start" class="btn1">开始</button>
	<button id="stop" class="btn1">停止</button>
</div>
<script type="text/javascript">
	var num=document.getElementById("num");
	var start=document.getElementById("start");
	var stop=document.getElementById("stop");
	
	var timer=null;
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
	}
	
	
</script>

<?php

?>