<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @createdate 10/03/2010 10:51
 */

if ( !defined('NV_IS_MOD_USER') )
{
    die('Stop!!!');
}

if ( file_exists(NV_ROOTDIR . '/' . DIR_FORUM . '/inc/config.php') )
{
    $error = $lang_global['loginincorrect'];
    include (NV_ROOTDIR . '/' . DIR_FORUM . '/inc/config.php');

    $user = $db->sql_fetch_assoc($db->sql_query("SELECT * FROM `" . $config['database']['table_prefix'] . "users` WHERE `uid`=" . $user_id));
    if ( isset($user['uid']) AND $user['uid'] > 0 )
    {
        global $client_info, $crypt;

        $loginkey = nv_genpass(50);
        $sid = md5($client_info['session_id'] . $loginkey);

        $birthday = 0;
        if ( $user['birthday'] != "" )
        {
            $arr_birthday = array_map("intval", explode("-", $user['birthday']));
            if ( count($arr_birthday) == 3 )
            {
                $birthday = mktime(0, 0, 0, $arr_birthday[1], $arr_birthday[0], $arr_birthday[2]);
            }
        }
        $password_crypt = $crypt->hash($nv_password);
        $useractive = ($user['coppauser']) ? 0 : 1;

        //set_user_login.php
        $db->sql_query("REPLACE INTO `" . $config['database']['table_prefix'] . "sessions` (`sid`, `uid`, `ip`, `time`, `location`, `useragent`, `anonymous`, `nopermission`, `location1`, `location2`) VALUES ('" . $sid . "', " . $user['uid'] . ", '" . $client_info['ip'] . "', " . NV_CURRENTTIME . ", " . $db->dbescape_string($nv_redirect) . ", " . $db->dbescape($client_info['agent']) . ", 0, 0, 0, 0)");
        $db->sql_query("UPDATE `" . $config['database']['table_prefix'] . "users` SET `loginkey`='" . $loginkey . "', `loginattempts`='1' WHERE uid='" . $user['uid'] . "'");

        $nv_Request->set_Cookie('mybbuser', $user['uid'] . "_" . $loginkey, NV_LIVE_COOKIE_TIME, false);
        $nv_Request->set_Cookie('sid', $sid, NV_LIVE_COOKIE_TIME, false);

        $sql = "SELECT * FROM `" . NV_USERS_GLOBALTABLE . "` WHERE `userid`=" . intval($user['uid']);
        $result = $db->sql_query($sql);
        $numrows = $db->sql_numrows($result);
        if ( $db->sql_numrows($result) > 0 )
        {
            $sql = "UPDATE `" . NV_USERS_GLOBALTABLE . "` SET
					`username` = " . $db->dbescape($user['username']) . ",
					`md5username` = " . $db->dbescape(md5($user['username'])) . ",
					`password` = " . $db->dbescape($password_crypt) . ",
					`email` = " . $db->dbescape($user['email']) . ",
					`full_name` = " . $db->dbescape($user['usertitle']) . ",
					`birthday`=" . $birthday . ",
					`sig`=" . $db->$user($user['signature']) . ",
					`regdate`=" . $user['regdate'] . ",
					`website`=" . $db->dbescape($user['website']) . ",
					`active`=" . $useractive . ",
					`last_login`=" . NV_CURRENTTIME . ",
					`last_ip`=" . $db->dbescape($client_info['ip']) . ",
					`last_agent`=" . $db->dbescape($client_info['agent']) . "
					WHERE `userid`=" . $user['uid'];
            if ( $db->sql_query($sql) )
            {
                $error = "";
                define('NV_IS_USER_LOGIN_FORUM_OK', true);
            }
            else
            {
                $error = $lang_module['error_update_users_info'];
            }
        }
    }

    unset($userid);
}
else
{
    trigger_error("Error no forum mybb", 256);
}
?>