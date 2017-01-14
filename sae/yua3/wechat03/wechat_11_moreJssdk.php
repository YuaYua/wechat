<?php
include_once 'wechatCommon.php';
require_once "jssdk.php";
$jssdk = new JSSDK("$appid", "$appsecret");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
  <title></title>
</head>
<body>
  <button id="btn">拍照</button>
   <button id="btn1">内置位置</button> 
     <button id="btn2">地理位置</button>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      //分享到朋友圈
      "onMenuShareTimeline",
      //分享给朋友
      "onMenuShareAppMessage",
      //拍照或从手机选择图片
      "chooseImage",
      //分享到 QQ
      "onMenuShareQQ",
      //分享到QQ 空间
      "onMenuShareQZone",
      //使用微信内置地图查看位置接口
      "openLocation",
      //获取地理位置接口
      "getLocation"
    ]
  });
  wx.ready(function () {
    // 在这里调用 API
    wx.onMenuShareTimeline({
	    title: 'hhh我是标题', // 分享标题
	    link: 'www.baidu.com', // 分享链接
	    imgUrl: 'http://lcks.applinzi.com/miao.jpg', // 分享图标
	    success: function () { 
	        // 用户确认分享后执行的回调函数
	        alert("success");
	    },
	    cancel: function () { 
	        // 用户取消分享后执行的回调函数
	    }
	});
      wx.onMenuShareAppMessage({
        title: '朋友', // 分享标题
        desc: '没啥', // 分享描述
        link: 'www.baidu.com', // 分享链接
        imgUrl: 'http://lcks.applinzi.com/miao.jpg', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });
      wx.onMenuShareQQ({
        title: '分享到 qq', // 分享标题
        desc: '测试分享 QQ', // 分享描述
        link: 'www.baidu.com', // 分享链接
        imgUrl: 'http://yua3.applinzi.com/0E1F3836-CDAA-454F-8DE7-62DE4498296F.jpg', // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
           // 用户取消分享后执行的回调函数
        }
    });
     
    wx.onMenuShareQZone({
        title: '分享到 QQ 空间', // 分享标题
        desc: '测试分享到 QQ 空间', // 分享描述
        link: ' www.baidu.com', // 分享链接
        imgUrl: 'http://yua3.applinzi.com/0E1F3836-CDAA-454F-8DE7-62DE4498296F.jpg', // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });

     

  });
    
    var btn=document.getElementById('btn');
    btn.addEventListener('click',function(){
    	 wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            }
        });
    },false);
    
    var btn1=document.getElementById('btn1');
    btn1.addEventListener('click',function(){
    	wx.openLocation({
            latitude: 0, // 纬度，浮点数，范围为90 ~ -90
            longitude: 0, // 经度，浮点数，范围为180 ~ -180。
            name: '', // 位置名
            address: '', // 地址详情说明
            scale: 1, // 地图缩放级别,整形值,范围从1~28。默认为最大
            infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
        });
    },false);
    var btn2=document.getElementById('btn2');
    btn2.addEventListener('click',function(){
        wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
            }
        });
    },false);
</script>
</html>
