<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 14/7/2010, 2:55
 */

if ( !defined('NV_IS_MOD_USER') )
{
    die('Stop!!!');
}

$sid = $nv_Request->get_string('sid', 'cookie', '', false);
$mybbuser = $nv_Request->get_string('mybbuser', 'cookie', '', false);
if ( preg_match("/^[a-zA-Z0-9]+$/", $sid) )
{
    if ( file_exists(NV_ROOTDIR . '/' . DIR_FORUM . '/inc/config.php') )
    {
        $mybbuser_array = explode('_', $mybbuser);
        $uid = intval($mybbuser_array[0]);

        $lastactive = NV_CURRENTTIME - 900;
        $lastvisit = NV_CURRENTTIME;

        include (NV_ROOTDIR . '/' . DIR_FORUM . '/inc/config.php');
        $db->sql_query("UPDATE `" . $config['database']['table_prefix'] . "users` SET `lastactive`='" . $lastactive . "', `lastvisit`='" . $lastvisit . "' WHERE uid='" . $uid . "'");
        $db->sql_query("DELETE FROM `" . $config['database']['table_prefix'] . "sessions` WHERE sid='" . $sid . "'");
    }
}
$nv_Request->unset_request('mybbuser', 'cookie');
$nv_Request->unset_request('sid', 'cookie');
?>