<?php
	include_once "../wechat01/wechat_03_sqlAccess.php";
	
	$access_token=getAccessTokenBySql();
	var_dump($access_token);
	$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
	
	 $obj='{
	     "button":[
		    {
		    		"name":"click",
           		"sub_button":[
           			{	
			          "type":"click",
			          "name":"发文字",
			          "key":" sendtext"
			      	},
			      	{	
			          "type":"click",
			          "name":"发音乐",
			          "key":" sendmusic"
			      	},
			      	{	
			          "type":"click",
			          "name":"发视频",
			          "key":" sendvideo"
			      	}
           		]
		    },
		    {
		    		"name":"图片",
           		"sub_button":[
           			{
	                    "type": "scancode_waitmsg", 
	                    "name": "扫码带提示", 
	                    "key": "rselfmenu_0_0" 
	                }, 
	                {
	                    "type": "scancode_push", 
	                    "name": "扫码推事件", 
	                    "key": "rselfmenu_0_1"
	                },
					{
	                    "type": "pic_sysphoto", 
	                    "name": "系统拍照发图", 
	                    "key": "rselfmenu_1_0"
	                }, 
	                	{
	                    "type": "pic_photo_or_album", 
	                    "name": "拍照或者相册发图", 
	                    "key": "rselfmenu_1_1"
	                }, 
	                {
	                    "type": "pic_weixin", 
	                    "name": "微信相册发图", 
	                    "key": "rselfmenu_1_2"
	                }
           		]
		    },
		    {
		    		"name":"其他",
           		"sub_button":[
           			{
			            "name": "发送位置", 
			            "type": "location_select", 
			            "key": "rselfmenu_2_0"
			        },
			        {	
		               "type":"view",
		               "name":"跳转",
		               "url":"http://www.soso.com/"
		            }
           		]
		    }
	       ]
	 }';
	
	
	$result=httpPost($obj, $url);
	var_dump($result); 

	                                                                                                                              
?>