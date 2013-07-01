<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_sinaweibo
 *
 * @copyright   Copyright (C) 2012 - 2013 @ngxiaoyi, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$filename = __DIR__.'/sinaweibo/config.php';

// 生成网站接入config文件
if ( $params->get('AppKey') && $params->get('AppSecret') ) {

	if ( strlen( $params->get('AppKey') )===10 && strlen( $params->get('AppSecret') )===32 ) {

		if ( file_exists($filename) ) {

			include( $filename );

			//参数定义不对，需重新生成配置文件
			if ( (!defined('WB_AKEY') || !defined('WB_SKEY') || !defined('WB_CALLBACK_URL')) or ( WB_AKEY!=$params->get('AppKey') || WB_SKEY!=$params->get('AppSecret') ) ) {

				$wb_callback = JURI::base().'modules/mod_sinaweibo/sinaweibo/callback.php';
				$data = '<?php
	header("Content-Type: text/html; charset=UTF-8");
	define( "WB_AKEY" , "'.$params->get("AppKey").'" );
	define( "WB_SKEY" , "'.$params->get("AppSecret").'" );
	define( "WB_CALLBACK_URL" , "'.$wb_callback.'" );';
				file_put_contents( $filename,  utf8_encode($data) );

			}

		}else {

			$wb_callback = JURI::base().'modules/mod_sinaweibo/sinaweibo/callback.php';
			$data = '<?php
	header("Content-Type: text/html; charset=UTF-8");
	define( "WB_AKEY" , "'.$params->get("AppKey").'" );
	define( "WB_SKEY" , "'.$params->get("AppSecret").'" );
	define( "WB_CALLBACK_URL" , "'.$wb_callback.'" );';
			file_put_contents( $filename,  utf8_encode($data) );

		}

	}else{

		echo '<script>alert("AppKey/AppSecret字符长度不符合要求，请重新填写，程序将继续执行。")</script>';

	}

}else{

	echo '请在模块设置中填写好AppKey和AppSecret等配置参数。';
	exit();

}

require JModuleHelper::getLayoutPath('mod_sinaweibo', $params->get('layout', 'default'));
