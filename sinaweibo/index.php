<?php
/*
	新浪微博php sdk入口文件
	@author 		@ngxiaoyi -> http://www.ruanjian081.com
	@date 			2013-05
*/

session_start();

if ( $_SESSION['token']['access_token'] ){
	header('Location: weibolist.php');		//access_token过期自动抓取新的token，功能待完善。
	exit();
}

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>joomla后台新浪微博发布模块 - Powered by @ngxiaoyi http://www.ruanjian081.com</title>
</head>

<body>

	<p><strong>联系模块开发者：</strong>
	</p>
	<p>本Joomla后台发微博模块由&nbsp;<a href="http://weibo.com/jsports" target="_blank">@ngxiaoyi</a> 开发，联系作者或者获取更多joomla本地化扩展信息，戳：<a title="软件081班博" href="http://www.ruanjian081.com/" target="_blank">Joomla后台发微博模块</a>
	</p>
	<p>&nbsp;</p>
	<p><strong>产品使用帮助</strong>
	</p>
	<p>本Joomla扩展模块是后台模块，目前适用于3.5以下的3.X版本。</p>
	<p>1.要使用本扩展，你首先需要将你的网站接入新浪微博，网站接入地址：<a href="http://open.weibo.com/connect" target="_blank">新浪微博网站接入</a>
	</p>
	<p>2.下载安装本扩展。</p>
	<p>3.后台配置，设置你在新浪微博接入时获得的WB_AKEY、WB_SKEY、WB_CALLBACK_URL等参数以及模块位置、宽高等参数</p>
	<p>4.点击底下的微博登陆按钮即可立即发微博</p>
	<p>&nbsp;</p>
	<p><strong>产品特性介绍</strong>
	</p>
	<p>通过SNS分享来提升网站流量是个行之有效的方法，然后很多站长并没有这样的意识，或者是有想法但不懂技术不知如何自行开发。由此，这款后台发微博扩展模块应运而生。通过这个扩展，你可在你的joomla站后台管理中，读取你关注的人发的微博，并能自己发微博，所发微博均将在微博来源处显示你在微博网站接入操作步骤中设置的你的网站名，微博用户点击该来源链接后就将跳转到你设置的网址上来，从而给网站添加流量。更多joomla SNS 扩展正在开发中，详情访问 <a href="http://www.ruanjian081.com" target="_blank">软件081</a>
	</p>
	<!-- 授权按钮 -->
    <p style="text-align:center;">
    	<a href="<?=$code_url?>">
    		<img src="images/weibo_login.png" title="授权之后发微博" alt="点击授权" border="0" />
    	</a>
    </p>
</body>
</html>
