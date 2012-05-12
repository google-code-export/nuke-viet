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
    
    $result = $user->session_create( $user_id );
    if ( $result )
    {
        define( 'NV_IS_USER_LOGIN_FORUM_OK', true );
    }
    $db = $db_nkv;
    $op = $op_nkv;
}
else
{
    trigger_error( "Error no forum phpbb", 256 );
}

?>