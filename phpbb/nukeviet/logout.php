<?php

/**
 * @Project NUKEVIET 3.1
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2011 VINADES.,JSC. All rights reserved
 * @Createdate 26/01/2011, 14:40
 */

if ( ! defined( 'NV_IS_MOD_USER' ) )
{
    die( 'Stop!!!' );
}

$session_id = $nv_Request->get_string( 'sid', 'cookie', '', false );
$user_id = $nv_Request->get_int( 'u', 'cookie', 0, false );
if ( $user_id > 1 and preg_match( "/^[a-z0-9]+$/", $session_id ) )
{
    $nv_Request->unset_request( 'u', 'cookie' );
    $nv_Request->unset_request( 'k', 'cookie' );
    $nv_Request->unset_request( 'sid', 'cookie' );
    $table_prefix = 'phpbb_';
    require_once ( NV_ROOTDIR . '/' . DIR_FORUM . '/config.php' );
    $sql = "DELETE FROM " . $table_prefix . "sessions WHERE session_id = " . $db->dbescape( $session_id ) . " AND session_user_id = " . $user_id;
    $db->sql_query( $sql );
}

?>