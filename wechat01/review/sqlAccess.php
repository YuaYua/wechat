<?php
include_once "../wechatCommon.php";
include_once "../../sqp.php";

function getAccessTokenBySql(){
	global $url;
	$query="select * from access_token";
	$result=mysql_query($query);
	if(mysql_num_rows($result)==1){
		$row=mysql_fetch_assoc($result);
		if($row["times"]<time()){
			$result=json_decode(httpGet($url),true);
			$access_token=$result["access_token"];
			$times=time()+$result["expires_in"];
			$query="update access_token set access_token='$access_token',times='$times'";
			mysql_query($query);
		}else{
			$access_token=$row["access_token"];
		}
	}else{
		$result=json_decode(httpGet($url),true);
		$access_token=$result["access_token"];
		$times=time()+$result["expires_in"];
		$query="insert into access_token (access_token,times) values ('$access_token','$times')";
		mysql_query($query);
	}
	return $access_token;
}
$access_token=getAccessTokenBySql();
var_dump($access_token);
?>