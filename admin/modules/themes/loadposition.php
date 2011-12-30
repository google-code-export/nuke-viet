<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-2-2010 12:55
 */
if ( ! defined( 'NV_IS_FILE_THEMES' ) ) die( 'Stop!!!' );
$theme1 = filter_text_input( 'theme1', 'get' );
$theme2 = filter_text_input( 'theme2', 'get' );
$position1 = $position2 = array();
if ( $theme1 != $theme2 and file_exists( NV_ROOTDIR . '/themes/' . $theme1 . '/config.ini' ) and file_exists( NV_ROOTDIR . '/themes/' . $theme2 . '/config.ini' ) )
{
    // theme 1
    $xml = @simplexml_load_file( NV_ROOTDIR . '/themes/' . $theme1 . '/config.ini' ) or nv_info_die( $lang_global['error_404_title'], $lang_module['block_error_fileconfig_title'], $lang_module['block_error_fileconfig_content'] );
    $content = $xml->xpath( 'positions' ); //array
    $positions = $content[0]->position; //object
    for ( $i = 0; $i < count( $positions ); $i ++ )
    {
        $position1[] = $positions[$i]->tag;
    }
    
    // theme 2
    $xml = @simplexml_load_file( NV_ROOTDIR . '/themes/' . $theme2 . '/config.ini' ) or nv_info_die( $lang_global['error_404_title'], $lang_module['block_error_fileconfig_title'], $lang_module['block_error_fileconfig_content'] );
    $content = $xml->xpath( 'positions' ); //array
    $positions = $content[0]->position; //object
    for ( $i = 0; $i < count( $positions ); $i ++ )
    {
        $position2[] = $positions[$i]->tag;
    }
    
    $diffarray = array_diff( $position1, $position2 );
    $diffarray = array_diff( $position1, $diffarray );
    for ( $i = 0; $i < count( $diffarray ); $i ++ )
    {
        $position1[] = $positions[$i]->tag;
        $contents .= "<label><input type='checkbox' name='position[]' value=\"" . $positions[$i]->tag . "\"/> " . $positions[$i]->name . '</label>&nbsp;&nbsp;';
    }
    echo $contents;
}
?>