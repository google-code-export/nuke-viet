<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-9-2010 14:43
 */
 
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'checkss', 'get' ) and $nv_Request->get_string( 'checkss', 'get' ) == md5( $global_config['sitekey'] . session_id() ) )
{
    $listid = $nv_Request->get_string( 'listid', 'get' );
    $id_array = array_map( "intval", explode( ",", $listid ) );
    
    $exp_array = array();
    $sql = "SELECT `id`, `listcatid`, `publtime`, `exptime`, `status`  FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` in (" . implode( ",", $id_array ) . ")";
    $result = $db->sql_query( $sql );
    while ( list( $id, $listcatid, $publtime, $exptime, $status ) = $db->sql_fetchrow( $result ) )
    {
        if ( $exptime == 0 or $exptime > NV_CURRENTTIME )
        {
            $arr_catid = explode( ",", $listcatid );
            
            $check_permission = false;
            if ( defined( 'NV_IS_ADMIN_MODULE' ) )
            {
                $check_permission = true;
            }
            else
            {
                $check_edit = 0;
                
                if ( $status == 0 )
                {
                    $edit_status = 0;
                }
                elseif ( $publtime < NV_CURRENTTIME and ( $exptime == 0 or $exptime > NV_CURRENTTIME ) )
                {
                    $edit_status = 1;
                }
                elseif ( $publtime > NV_CURRENTTIME )
                {
                    $edit_status = 2;
                }
                else
                {
                    $edit_status = 3;
                }
                foreach ( $arr_catid as $catid_i )
                {
                    if ( isset( $array_cat_admin[$admin_id][$catid_i] ) )
                    {
                        if ( $array_cat_admin[$admin_id][$catid_i]['admin'] == 1 )
                        {
                            $check_edit ++;
                        }
                        else
                        {
                            if ( $array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1 )
                            {
                                $check_edit ++;
                            }
                            elseif ( $array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1 and ( $edit_status == 0 or $edit_status = 2 ) )
                            {
                                $check_edit ++;
                            }
                            elseif ( $edit_status == 0 and $post_id == $admin_id )
                            {
                                $check_edit ++;
                            }
                        }
                    }
                }
                if ( $check_edit == count( $arr_catid ) )
                {
                    $check_permission = true;
                }
            }
            if ( $check_permission > 0 )
            {
                $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET `exptime` = '" . NV_CURRENTTIME . "' WHERE `id` =" . $id . "" );
                foreach ( $arr_catid as $catid_i )
                {
                    $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_" . $catid_i . "` SET `exptime` = '" . NV_CURRENTTIME . "' WHERE `id` =" . $id . "" );
                }
                $exp_array[] = $id;
            }
        }
    }
    
    if ( ! empty( $exp_array ) )
    {
        nv_insert_logs( NV_LANG_DATA, $module_name, 'log_exp_content', "listid: " . implode( ", ", $exp_array ), $admin_info['userid'] );
    }
    nv_del_moduleCache( $module_name );
}

Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "" );
die();

?>