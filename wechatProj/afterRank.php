<?php
include_once "wechatCommon.php";
$openid=$_GET["openid"];
$nickname=$_GET["nickname"];
$headimgurl=$_GET["headimgurl"];
$score=$_GET["score"];
$db = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
mysql_select_db(SAE_MYSQL_DB, $db);
//查询表中数据个数
$query="select count(*) from rank";
$result=mysql_query($query);

if(mysql_num_rows($result)==1){
	//有数据
	$row=mysql_fetch_row($result);
	$size=$row[0];
	if($size==2){
		//数据个数为10个时根据分数大小倒序查找
		$query="select * from rank order by score desc";
		$result=mysql_query($query);
		if(mysql_num_rows($result)){
			while($row=mysql_fetch_assoc($result)){
				if($score>=$row["score"]){
					$query="insert into rank (openid,nickname,img,score) values('$openid','$nickname','$headimgurl',$score)";
					mysql_query($query);
					return;
				}
			}
		}
	}else{
		//数据个数小于十个时插入一条
		$query="insert into rank (openid,nickname,img,score) values('$openid','$nickname','$headimgurl',$score)";
		mysql_query($query);
	}
}else{
	//没数据直接插入一条
	$query="insert into rank (openid,nickname,img,score) values('$openid','$nickname','$headimgurl',$score)";
	mysql_query($query);
}
$query="select * from rank order by score desc limit 0,10";
$result=mysql_query($query);
if(mysql_num_rows($result)){
	while($row=mysql_fetch_assoc($result)){
		$arr[]=$row;
		$arr["errcode"]=1;
	}
}else{
	$arr["errcode"]=0;
}
$json=json_encode($arr);
echo $json;


?>