<?php

/**
 * @Project NUKEVIET 3.1
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2011 VINADES.,JSC. All rights reserved
 * @Createdate 26/01/2011, 14:40
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );
$session_id = $nv_Request->get_string( 'sid', 'cookie', '', false );
$user_id = $nv_Request->get_int( 'u', 'cookie', 0, false );
if ( $user_id > 1 and preg_match( "/^[a-z0-9]+$/", $session_id ) )
{
    $table_prefix = 'phpbb_';
    require_once ( NV_ROOTDIR . '/' . DIR_FORUM . '/config.php' );
    list( $session_browser ) = $db->sql_fetchrow( $db->sql_query( "SELECT session_browser FROM " . $table_prefix . "sessions WHERE session_id=" . $db->dbescape( $session_id ) . " AND session_user_id=" . $user_id . " ORDER BY `session_time` DESC LIMIT 0 , 1" ) );
    if ( $session_browser == trim( substr( $client_info['agent'], 0, 149 ) ) )
    {
        $user_info['userid'] = $user_id;
    }
    else
    {
        $nv_Request->unset_request( 'sid', 'cookie' );
        $nv_Request->unset_request( 'u', 'cookie' );
        $user_id = 0;
        unset( $user_info );
    }
    unset( $session_browser, $session_id );
}

unset( $session_id, $user_id );

?>