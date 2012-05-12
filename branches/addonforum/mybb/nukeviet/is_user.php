<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 31/05/2010, 00:36
 */
if ( !defined('NV_MAINFILE') )
    die('Stop!!!');

$sid = $nv_Request->get_string('sid', 'cookie', '', false);
$mybbuser = $nv_Request->get_string('mybbuser', 'cookie', '', false);
if ( preg_match("/^[a-zA-Z0-9]+$/", $sid) )
{
    $mybbuser_array = explode('_', $mybbuser);
    $uid = intval($mybbuser_array[0]);
    $loginkey = trim($mybbuser_array[1]);

    $user_info = array();
    if ( preg_match("/^[a-zA-Z0-9]+$/", $loginkey) AND file_exists(NV_ROOTDIR . '/' . DIR_FORUM . '/inc/config.php') )
    {
        include (NV_ROOTDIR . '/' . DIR_FORUM . '/inc/config.php');
        $user_info = $db->sql_fetch_assoc($db->sql_query("SELECT * FROM `" . $config['database']['table_prefix'] . "users` WHERE `uid`=" . $uid . ""));
        if ( isset($user_info['loginkey']) AND $user_info['loginkey'] == $loginkey )
        {
            $user_info['userid'] = $uid;
        }
        else
        {
            $user_info = array();
            $nv_Request->unset_request('mybbuser', 'cookie');
            $nv_Request->unset_request('sid', 'cookie');
        }
    }
}
?>