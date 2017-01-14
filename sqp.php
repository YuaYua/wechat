<?php 
    header("Content-type:text/html;charset=utf-8");//防止中文乱码
	date_default_timezone_set('PRC');//使用东八区时间
	
	mysql_connect("localhost","root","");
	mysql_select_db("php");
	
	mysql_query("set names utf8");  //防止插入中文乱码
?>