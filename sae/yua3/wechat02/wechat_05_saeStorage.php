<?php
	include_once "wechatCommon.php";
	use sinacloud\sae\Storage as Storage;//这句必须写上才能连接到 storage
	function storageToken(){
        global $url; 
    	$s=new Storage();
        //echo $s->getUrl("kaige","0E1F3836-CDAA-454F-8DE7-62DE4498296F.png");

        //putObject向文件中写入
        //$s->putObject('{"access_token":"6Fe0OzbEhg9wL7GWLBhC8UbpxAdd9EpSP0h-onZVQrst6hCmxzLynHEmS-M6W_vtLLDFSplmfCi5nqj4L5gWpGfczOpOyGJwFYt-gRLvGNjXQk23qrYK0C29C0m-yOGIHICbAEACDX","times":1483516}',"kaige","access_token.txt",array(), array('Content-Type' => 'text/plain;charset=utf-8'));

        //getObject查看文件
        $obj=$s->getObject("kaige","access_token.txt");
        $content=$obj->body;
        var_dump($content);
        //这里文件必须是一个 json字符串
        //因为下面用的 json_decode
        $arr=json_decode($content,true);
        if($arr){
            if($arr["expires_in"]<time()){
                $result=json_decode(httpGet($url),true);
                $access_token=$result["access_token"];
                $times=time()+$result["expires_in"]/2;
                $setArr["access_token"]=$access_token;
                $setArr["times"]=$times;
                $json=json_encode($setArr);
                $s->putObject($json,"kaige","access_token.txt",array(), array('Content-Type' => 'text/plain;charset=utf-8'));
            }else{
                $access_token=$arr["access_token"];
            }
        }else{
            $arr=json_decode(httpGet($url),true);
            $access_token=$arr["access_token"];
            $times=time()+$arr["expires_in"]/2;
            $setArr["access_token"]=$access_token;
            $setArr["times"]=$times;
            $json=json_encode($setArr);
            $s->putObject($json,"kaige","access_token.txt",array(), array('Content-Type' => 'text/plain;charset=utf-8'));
        }
        return $access_token;
    }
	

	

?>