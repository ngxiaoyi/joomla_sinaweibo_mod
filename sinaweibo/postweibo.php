<?php

session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);	//根据ID获取用户等基本信息

//发送图片微博
if (is_uploaded_file($_FILES["img"]["tmp_name"]))  
{
	//图片支持jgp/png/gif三种格式，且大小<5M
	if ( ( ($_FILES["img"]["type"] == "image/gif")||($_FILES["img"]["type"] == "image/jpeg")||($_FILES["img"]["type"] == "image/pjpeg")||($_FILES["img"]["type"] == "image/png") ) && ($_FILES["img"]["size"] < 5242880) )
	{
		if ($_FILES["img"]["error"] > 0)
		{
			echo '<script>alert("出错了，错误描述：' . $_FILES["img"]["error"] . '")</script><br />';
			exit();
		}
		else
		{
			//文件以时间戳 重命名     
			date_default_timezone_set('PRC');							//中国时区
			$dtime = date("YmdHis");									//时间戳，需精确到毫秒，待完善
			$ftype = substr(strrchr($_FILES['img']['name'], "."), 1);	//获取文件后缀名
			$nname = $dtime.".".$ftype; 								//新文件名

			if( !move_uploaded_file($_FILES["img"]["tmp_name"],"tmp/".$nname) )
			{
				echo '<script>alert("图片移动失败，请检查文件夹权限。")</script>';
				exit();
			}

			$imgurl = 'tmp/'.$nname;

			if ( isset($_REQUEST['weibotext']) ) 
				$ret = $c->upload( $_REQUEST['weibotext'], $imgurl );
			else
				$ret = $c->upload( $status='分享图片', $imgurl );

		}
	}
	//文件不合法
	else
	{
		echo '<script>alert("请上传jpg、png、gif这三种格式的图片文件。")</script>';
		exit();
	}

}
//纯文字微博
else if( isset($_REQUEST['weibotext']) ){

	$ret = $c->update( $_REQUEST['weibotext'] );

}else{

	echo '<script>alert("微博内容不能为空！")</script>';
	exit();

}

if( !empty($ret) ){
	if ( isset($ret['error_code']) && $ret['error_code'] > 0 ) {
		echo '<script>alert("发送失败，错误信息：'.$ret['error_code'].':'.$ret['error'].'")</script>';
	} else {
		echo '<script>alert("发送成功")</script>';
	}
}
?>