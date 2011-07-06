<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Style CSS script (style.php)                #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

define('DPORTAL',true);
require_once('config/config.php');

header('content-type: text/css');

$smarty->caching = true;
if(!$smarty->is_cached('style_css.tpl')){
	require_once('config/style_cfg.php');
	$smarty->assign('STYLE_CONF',$style_list);
}

$smarty->display('style_css.tpl');

require_once(INCLUDES_PATH . 'footer.php');

?>
