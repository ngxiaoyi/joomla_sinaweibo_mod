<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if ( $_SESSION['token']['access_token'] ){
	$token = $_SESSION['token']['access_token'];
}
elseif ( $o->getTokenFromJSSDK() && $tokenArr=$o->getTokenFromJSSDK() ) {
	$token = $tokenArr['access_token'];
}else{
	header('Location: index.php');
}

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token );
$ms  = $c->home_timeline();
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>joomla后台新浪微博发布模块-Powered by @ngxiaoyi  http://www.ruanjian081.com</title>

<link rel="stylesheet" type="text/css" href="css/base.css">

<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
<script>
	if (!window.jQuery) {
	var script = document.createElement('script');
	script.src = "js/jquery.min.js";
	document.body.appendChild(script);
	}
</script>
<script type="text/javascript" src="js/default.js"></script>

</head>
<body>

<div>

	<img style="float:left;" src="images/weibo_question.gif">
	<div style="float:right;">最多输入140个字！</div>
	<div style="clear:both;"></div>
	<form id="sendform" action="postweibo.php" method="post" enctype="multipart/form-data" style="display: block;" target="_postform">

		<textarea id="weibotext" name="weibotext" rows="4">#你可在joomla后台直接发布微博#</textarea>
		<input type="file" name="img" style=" margin-left: 5%; float: left; ">

	</form>
	<img id="postweibo" style="float:right; margin-right:5%; cursor:pointer;" src="images/btn_send.gif">
	<div style="clear:both;"></div>

	<iframe name="_postform" style="display:none;"></iframe>

</div>

<?php if( is_array( $ms['statuses'] ) ): ?>

<div class="feed-list">
<ul>
<?php foreach( $ms['statuses'] as $i=>$item ): ?>

  <li>
	<div class="user-pic">
		<a href="http://weibo.com/<?php echo $item['user']['profile_url'];?>" target="_blank">
			<img width="50" height="50" src="<?php echo $item['user']['profile_image_url'];?>" alt="<?php echo $item['user']['screen_name'];?>" title="<?php echo $item['user']['screen_name'];?>">
		</a>
	</div>
	<div class="feed-content">
		<p class="feed-main">
			<a href="http://weibo.com/<?php echo $item['user']['profile_url'];?>" title="" target="_blank">
				<?php echo $item['user']['screen_name'];?>
			</a>：<?php echo $item['text'];?>
		</p>
		<?php if ($item['thumbnail_pic']) { ?>
			<a class="fancybox" href="<?php echo $item['original_pic'];?>" target="_blank">
				<img src="<?php echo $item['thumbnail_pic'];?>">
			</a>
		<?php }elseif ($item['retweeted_status']) {	//转发微博和图片微博不可能重合 ?>
				<p class="feed-main">
					<a href="http://weibo.com/<?php echo $item['retweeted_status']['user']['profile_url'];?>" title="" target="_blank">
						<?php echo $item['retweeted_status']['user']['screen_name'];?>
					</a>：<?php echo $item['retweeted_status']['text'];?>
				</p>
				<?php if ($item['retweeted_status']['thumbnail_pic']) { ?>
					<a class="fancybox" href="<?php echo $item['retweeted_status']['original_pic'];?>" target="_blank">
						<img src="<?php echo $item['retweeted_status']['thumbnail_pic'];?>">
					</a>
				<?php } ?>
		<?php } ?>

	</div>
	<div style="clear:both;"></div>
</li>

<?php endforeach; ?>
<!-- 	转发、收藏、评论功能，待完善，收费版将提供
		<div class="feed-info">
			<p>
				<a class="fancybox" href="#repost" rel="e:fw" id="fw" mid="" target="_blank">转发</a>|
				<a class="addFavorites" mid="" href="#" rel="e:fr" target="_blank">收藏</a>|
				<a class="fancybox" href="#CreateComments" rel="e:cm" id="cm" mid="" target="_blank">评论</a>
			</p>
		</div>
 -->
</ul>
</div>
<?php endif; ?>

</body>
</html>
