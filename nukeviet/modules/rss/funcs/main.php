<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES. All rights reserved
 * @Createdate Apr 20, 2010 10:47:41 AM
 */

if ( ! defined( 'NV_IS_MOD_RSS' ) ) die( 'Stop!!!' );

function nv_get_rss_link ( )
{
    global $db, $module_data, $global_config, $imgmid, $imgmid2, $iconrss, $site_mods;
    $contentrss = "";
    
    foreach ( $site_mods as $mod_name => $row )
    {
        if ( $row['rss'] == 1 and isset( $row['funcs']['rss'] ) and file_exists( NV_ROOTDIR . "/modules/" . $row['module_file'] . "/rssdata.php" ) )
        {
            $mod_data = $row['module_data'];
            $mod_file = $row['module_file'];
            
            $contentrss .= $imgmid2 . "<a href=\"" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $mod_name . "&amp;" . NV_OP_VARIABLE . "=rss\">" . $iconrss . " <strong> " . $row['custom_title'] . "</strong></a><br />";
            
            $rssarray = array();
            include ( NV_ROOTDIR . "/modules/" . $mod_file . "/rssdata.php" );
            foreach ( $rssarray as $key => $value )
            {
                $parentid = ( isset( $value['parentid'] ) ) ? $value['parentid'] : 0;
                if ( $parentid == 0 )
                {
                    $contentrss .= $imgmid . $imgmid2 . "<a href=\"" . $value['link'] . "\">" . $iconrss . " " . $value['title'] . "</a><br />";
                    $catid = ( isset( $value['catid'] ) ) ? $value['catid'] : 0;
                    if ( $catid > 0 )
                    {
                        $contentrss .= nv_get_sub_rss_link( $rssarray, $catid, $imgmid . $imgmid );
                    }
                }
            }
        }
    
    }
    return $contentrss;
}

function nv_get_sub_rss_link ( $rssarray, $id, $image )
{
    global $imgmid, $imgmid2, $iconrss;
    $content = '';
    foreach ( $rssarray as $value )
    {
        if ( isset( $value['parentid'] ) and $value['parentid'] == $id )
        {
            $content .= $image . $imgmid2 . "<a href=\"" . $value['link'] . "\">" . $iconrss . " " . $value['title'] . "</a><br />";
            $catid = ( isset( $value['catid'] ) ) ? $value['catid'] : 0;
            if ( $catid > 0 )
            {
                $content .= nv_get_sub_rss_link( $rssarray, $catid, $image . $imgmid );
            }
        }
    }
    return $content;
}

$contents = "";
$content_file = NV_ROOTDIR . "/" . NV_DATADIR . "/" . NV_LANG_DATA . "_" . $module_data . "Content.txt";
if ( file_exists( $content_file ) )
{
    $contents .= file_get_contents( $content_file );
}
$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name;
$contents .= "<img  alt=\"\" style=\"border-width: 0px; vertical-align: middle;\" src=\"" . NV_BASE_SITEURL . "themes/" . $img_dir . "/images/" . $module_name . "/home.gif\" /><b>" . $module_info['custom_title'] . "</b><br />";

$contents .= nv_get_rss_link();

$page_title = $module_info['custom_title'];

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>