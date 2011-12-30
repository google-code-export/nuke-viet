<?php

/**
 * @Project NUKEVIET 3
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2011 VINADES.,JSC. All rights reserved
 * @Createdate 7-20-2011 9:25
 */

if (!defined('NV_MAINFILE'))
	die('Stop!!!');

if (!defined('NV_IS_CRON'))
	die('Stop!!!');

function cron_auto_del_cache()
{
	$result = true;
	$dir = NV_ROOTDIR . "/" . NV_CACHEDIR;
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if (preg_match("/(.*)\.cache/", $file) and (filemtime($dir . '/' . $file) + 3600) < NV_CURRENTTIME)
			{
				if (!@unlink($dir . '/' . $file))
				{
					$result = false;
				}
			}
		}
		closedir($dh);
		clearstatcache();
	}
	return $result;
}
?>