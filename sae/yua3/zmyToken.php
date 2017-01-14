<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "zmy");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}
//$wechatObj->valid();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            	$RX_TYPE = trim($postObj->MsgType);

                switch ($RX_TYPE)
                {
                    case "event":
                        $resultStr = $this->receiveEvent($postObj);
                        break;
                    default:
                        $resultStr = "unknow msg type: ".$RX_TYPE;
                        break;
                }
            	echo $resultStr;
               

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
    
    private function receiveText($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是文本，内容为：".$object->Content;
        $str = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA[kjhdshabxjzc]]></Title> 
<Description><![CDATA[woshilckxiedejianjie]]></Description>
<PicUrl><![CDATA[http://lcks.applinzi.com/miao.jpg]]></PicUrl>
<Url><![CDATA[https://www.baidu.com/]]></Url>
</item>
</Articles>
</xml>";
        
        $resultStr = sprintf($str, $object->FromUserName, $object->ToUserName, time());;
        return $resultStr;
    }

    private function receiveImage($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是图片，地址为：".$object->PicUrl;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveLocation($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveVoice($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是语音，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveVideo($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是视频，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveLink($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveEvent($object)
    {
        $contentStr = "";
        $resultStr = "";
        $from = $object->ToUserName; // 开发者微信号
		$to = $object->FromUserName;
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "欢迎关注lck工作室";
            	$resultStr = "<xml>
<ToUserName><![CDATA[$to]]></ToUserName>
<FromUserName><![CDATA[$from]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[$contentStr]]></Content>
</xml>";
                break;
            case "unsubscribe":
                $contentStr = "";
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "sendimg":
						$resultStr = $this->sendText($object);
						break;
                    default:
                        $contentStr = "你点击了: ".$object->EventKey;
                    	$resultStr = $this->transmitText($object, $contentStr);
                        break;
                }
                break;
            default:
                $contentStr = "receive a new event: ".$object->Event;
                break;
        }
        
        return $resultStr;
    }
    private function sendText($object)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[idasda]]></Content>
</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $resultStr;
    }
   
    private function transmitText($object, $content, $flag = 0)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }
    
}

?>