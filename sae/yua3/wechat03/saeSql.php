<?php
	header("Content-type:text/html;charset=utf-8");//防止中文乱码
	date_default_timezone_set('PRC');//使用东八区时间
	
	$db = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
	mysql_select_db(SAE_MYSQL_DB, $db);
	
	mysql_query("set names utf8");  //防止插入中文乱码
?>