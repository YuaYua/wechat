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
		//数据个数为10个时根据分数大小倒序查找
    $query="select * from rank order by score desc";
    $result=mysql_query($query);
    if(mysql_num_rows($result)){
        while($row=mysql_fetch_assoc($result)){
            if($nickname!=$row["nickname"]){
                $flag=true;
            }else if($nickname==$row["nickname"]){
                if($score>=$row["score"]){
                    $query1="update rank set score=$score where nickname='$nickname'";
                    mysql_query($query1);
                }
                $flag=false;
                break;
            }
        }
        if($flag){
        	$query1="insert into rank (openid,nickname,img,score) values('$openid','$nickname','$headimgurl',$score)";
            mysql_query($query1);
        }
    }
}else{
	//没数据直接插入一条
	$query="insert into rank (openid,nickname,img,score) values ('$openid','$nickname','$headimgurl',$score)";
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