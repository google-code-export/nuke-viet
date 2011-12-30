<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @createdate 12/31/2009 2:29
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$submenu['clearsystem'] = $lang_module['clearsystem'];
$submenu['siteDiagnostic'] = $lang_module['siteDiagnostic'];
$submenu['keywordRank'] = $lang_module['keywordRank'];
$submenu['sitemapPing'] = $lang_module['sitemapPing'];
$submenu['checkupdate'] = $lang_module['checkupdate'];
$submenu['revision'] = $lang_module['revision'];
$submenu['config'] = $lang_module['config'];

if ( $module_name == "webtools" )
{
	if ( $global_config['autocheckupdate'] )
    {
        $new_version = nv_geVersion( $global_config['autoupdatetime'] * 3600 );
    }
    elseif ( file_exists( NV_ROOTDIR . '/' . NV_CACHEDIR . '/nukeviet.version.' . NV_LANG_INTERFACE . '.xml' ) )
    {
        $new_version = simplexml_load_file( NV_ROOTDIR . '/' . NV_CACHEDIR . '/nukeviet.version.' . NV_LANG_INTERFACE . '.xml' );
    }
    else
    {
        $new_version = array();
    }
	if ( $op=="autoupdate" or (!empty($new_version) and nv_version_compare( $global_config['version'], $new_version->version ) < 0))
    {
        $submenu['autoupdate'] = $lang_module['autoupdate_system'];
    }
    
    $allow_func = array( 
        'main', 'clearsystem', 'sitemapPing', 'checkupdate', 'revision', 'siteDiagnostic', 'keywordRank', 'autoupdate', 'config' 
    );
    $menu_top = array( 
        "title" => $module_name, "module_file" => "", "custom_title" => $lang_global['mod_webtools'] 
    );
    define( 'NV_IS_FILE_WEBTOOLS', true );
}

?>