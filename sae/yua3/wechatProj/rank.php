<?php
	include_once "../wechat03/saeSql.php";
	
	$nick=$_GET["nickname"];
	$openid=$_GET["openid"];
	$score=$_GET["score"];
	$img=$_GET["headimgurl"];
	
	$query="select * from rank where openid='$openid'";
	$result=mysql_query($query);
	if(mysql_num_rows($result)==1){
		$row=mysql_fetch_assoc($result);
		if($row["score"]<$score){
			  $query="update rank set score=$score where openid='$openid'";
              mysql_query($query);
		}
	}else{
		$query="insert into rank (openid,nickname,score,img) values('$openid','$nick',$score,'$img')";
		mysql_query($query);
	}
	$query="select * from rank order by score desc limit 0,10";
	$result=mysql_query($query);
	if(mysql_num_rows($result)){
		while($row=mysql_fetch_assoc($result)){
			$arr[]=$row;
//			$arr["errcode"]=1;
           // var_dump($row);
		}
	}else{
//		$arr["errcode"]=0;
	}
	$json=json_encode($arr);
	echo $json;

	
?>