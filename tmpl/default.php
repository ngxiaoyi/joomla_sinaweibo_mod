<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_sinaweibo
 *
 * @copyright   Copyright (C) 2012 - 2013 @ngxiaoyi, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


$wb_callback = JURI::base().'modules/mod_sinaweibo/sinaweibo/index.php';
$width = $params->get('width', 620);

?>
<script type="text/javascript">
	function iFrameHeight()
	{
		var h = 0;
		if (!document.all)
		{
			h = document.getElementById('blockrandom').contentDocument.height;
			document.getElementById('blockrandom').style.height = h + 60 + 'px';
		} else if (document.all)
		{
			h = document.frames('blockrandom').document.body.scrollHeight;
			document.all.blockrandom.style.height = h + 20 + 'px';
		}
	}
</script>

<iframe <?php echo $load; ?>
	id="blockrandom"
	name="sinaweibo"
	src="<?php echo $wb_callback;?>"
	width="<?php echo $width;?>px"
	height="600px">
</iframe>
