<?php
$db = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
mysql_select_db(SAE_MYSQL_DB, $db);

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