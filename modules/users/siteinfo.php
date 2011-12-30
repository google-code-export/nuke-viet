<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES. All rights reserved
 * @Createdate Apr 20, 2010 10:47:41 AM
 */

if ( ! defined( 'NV_IS_FILE_SITEINFO' ) ) die( 'Stop!!!' );

$lang_siteinfo = nv_get_lang_module( $mod );

// So thanh vien
list( $number ) = $db->sql_fetchrow( $db->sql_query( "SELECT COUNT(*) as number FROM `" . NV_USERS_GLOBALTABLE . "`" ) );
if ( $number > 0 )
{
    $siteinfo[] = array( 
        'key' => $lang_siteinfo['siteinfo_user'], 'value' => $number 
    );
}

// So thanh vien doi kich hoat
list( $number ) = $db->sql_fetchrow( $db->sql_query( "SELECT COUNT(*) as number FROM `" . NV_USERS_GLOBALTABLE . "_reg`" ) );
if ( $number > 0 )
{
    $siteinfo[] = array( 
        'key' => $lang_siteinfo['siteinfo_waiting'], 'value' => $number 
    );
}

?>