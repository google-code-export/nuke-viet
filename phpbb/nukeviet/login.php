<?php

/**
 * @Project NUKEVIET 3.1
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2011 VINADES.,JSC. All rights reserved
 * @Createdate 26/01/2011, 14:40
 */

if ( ! defined( 'NV_IS_MOD_USER' ) ) die( 'Stop!!!' );

define( 'IN_PHPBB', true );

if ( file_exists( NV_ROOTDIR . '/' . DIR_FORUM . '/common.php' ) )
{
    $db_nkv = $db;
    $op_nkv = $op;
    global $user, $auth, $template, $cache, $db, $config, $phpEx, $phpbb_root_path;
    
    $phpEx = 'php';
    $phpbb_root_path = NV_ROOTDIR . '/' . DIR_FORUM . '/';
    
    include ( $phpbb_root_path . 'common.' . $phpEx );
    $user->session_begin();
    $auth->acl( $user->data );
    $user->setup();
    
    if ( empty( $nv_username ) )
    {
        $nv_username = filter_text_input( 'nv_login', 'post', '' );
    }
    if ( empty( $nv_password ) )
    {
        $nv_password = filter_text_input( 'nv_password', 'post', '' );
    }
    if ( empty( $nv_redirect ) )
    {
        $nv_redirect = filter_text_input( 'nv_redirect', 'post,get', '' );
    }
    
    $result = $auth->login( $nv_username, $nv_password, $remember );
    
    $status = $result['status'];
    
    $error = "";
    
    /*Login error codes
	define( 'LOGIN_CONTINUE', 1 );
	define( 'LOGIN_BREAK', 2 );
	define( 'LOGIN_SUCCESS', 3 );
	define( 'LOGIN_SUCCESS_CREATE_PROFILE', 20 );
	define( 'LOGIN_ERROR_USERNAME', 10 );
	define( 'LOGIN_ERROR_PASSWORD', 11 );
	define( 'LOGIN_ERROR_ACTIVE', 12 );
	define( 'LOGIN_ERROR_ATTEMPTS', 13 );
	define( 'LOGIN_ERROR_EXTERNAL_AUTH', 14 );
	define( 'LOGIN_ERROR_PASSWORD_CONVERT', 15 );
	*/
    
    define( 'USER_NORMAL', 0 );
    define( 'USER_FOUNDER', 3 );
    
    $db = $db_nkv;
    $op = $op_nkv;
    if ( $status == 3 )
    {
        $user_info = $result['user_row'];
        $password_crypt = $crypt->hash( $nv_password );
        $result = $db->sql_query( "SELECT * FROM " . $table_prefix . "users WHERE user_id='" . intval( $user_info['user_id'] ) . "'" );
        $row = $db->sql_fetchrow( $result );
        $user_info['active'] = 0;
        if ( $row['user_type'] == USER_NORMAL || $row['user_type'] == USER_FOUNDER )
        {
            $user_info['active'] = 1;
        }
        
        $user_info['userid'] = intval( $row['user_id'] );
        $user_info['username'] = $row['username_clean'];
        $user_info['email'] = $row['user_email'];
        $user_info['full_name'] = $row['username'];
        $user_info['birthday'] = intval( strtotime( $row['user_birthday'] ) );
        $user_info['regdate'] = intval( $row['user_regdate'] );
        $user_info['website'] = $row['user_website'];
        $user_info['location'] = $row['user_from'];
        $user_info['sig'] = $row['user_sig'];
        $user_info['yim'] = $row['user_yim'];
        $user_info['view_mail'] = intval( $row['user_allow_viewemail'] );
        
        $sql = "SELECT * FROM `" . NV_USERS_GLOBALTABLE . "` WHERE `userid`=" . intval( $user_info['userid'] );
        $result = $db->sql_query( $sql );
        $numrows = $db->sql_numrows( $result );
        
        if ( $db->sql_numrows( $result ) > 0 )
        {
            $sql = "UPDATE `" . NV_USERS_GLOBALTABLE . "` SET 
                `username` = " . $db->dbescape( $user_info['username'] ) . ", 
                `md5username` = " . $db->dbescape( md5( $user_info['username'] ) ) . ", 
                `password` = " . $db->dbescape( $password_crypt ) . ", 
                `email` = " . $db->dbescape( $user_info['email'] ) . ", 
                `full_name` = " . $db->dbescape( $user_info['full_name'] ) . ", 
                `birthday`=" . $user_info['birthday'] . ", 
				`sig`=" . $db->dbescape( $user_info['sig'] ) . ", 
                `regdate`=" . $user_info['regdate'] . ", 
                `website`=" . $db->dbescape( $user_info['website'] ) . ", 
                `location`=" . $db->dbescape( $user_info['location'] ) . ", 
                `yim`=" . $db->dbescape( $user_info['yim'] ) . ", 
                `view_mail`=" . $user_info['view_mail'] . ",
                `active`=" . $user_info['active'] . ",
                `last_login`=" . NV_CURRENTTIME . ", 
                `last_ip`=" . $db->dbescape( $client_info['ip'] ) . ", 
                `last_agent`=" . $db->dbescape( $client_info['agent'] ) . "
                 WHERE `userid`=" . $user_info['userid'];
        }
        else
        {
            $sql = "REPLACE INTO `" . NV_USERS_GLOBALTABLE . "` 
                (`userid`, `username`, `md5username`, `password`, `email`, `full_name`, `gender`, `photo`, `birthday`, `sig`, 
                `regdate`, `website`, `location`, `yim`, `telephone`, `fax`, `mobile`, `question`, `answer`, `passlostkey`, 
                `view_mail`, `remember`, `in_groups`, `active`, `checknum`, `last_login`, `last_ip`, `last_agent`, `last_openid`) VALUES 
                (
                " . intval( $user_info['userid'] ) . ", 
                " . $db->dbescape( $user_info['username'] ) . ", 
                " . $db->dbescape( md5( $user_info['username'] ) ) . ", 
                " . $db->dbescape( $password_crypt ) . ", 
                " . $db->dbescape( $user_info['email'] ) . ", 
                " . $db->dbescape( $user_info['full_name'] ) . ", 
                '', 
                '', 
                " . $user_info['birthday'] . ", 
				" . $db->dbescape( $user_info['sig'] ) . ", 
                " . $user_info['regdate'] . ", 
                " . $db->dbescape( $user_info['website'] ) . ", 
                " . $db->dbescape( $user_info['location'] ) . ", 
                " . $db->dbescape( $user_info['yim'] ) . ", 
                '', '', '', '', '', '', 
                " . $user_info['view_mail'] . ", 0, '', 
                " . $user_info['active'] . ", '', 
                " . NV_CURRENTTIME . ", 
                " . $db->dbescape( $client_info['ip'] ) . ", 
                " . $db->dbescape( $client_info['agent'] ) . ", 
                '' 
                )";
        }
        if ( $db->sql_query( $sql ) )
        {
            $error = "";
        }
        else
        {
            $error = $lang_module['error_update_users_info'];
        }
    }
    elseif ( $status == 12 )
    {
        $error = $lang_module['login_no_active'];
    }
    else
    {
        $error = $lang_global['loginincorrect'];
    }
}
else
{
    trigger_error( "Error no forum phpbb", 256 );
}

?>