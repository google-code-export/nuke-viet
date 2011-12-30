<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @createdate 12/31/2009 0:51
 */

if ( ! defined( 'NV_IS_MOD_DOWNLOAD' ) ) die( 'Stop!!!' );

function x_generate_page ( $base_url, $num_items, $per_page, $start_item, $add_prevnext_text = true, $onclick = false, $js_func_name = 'nv_urldecode_ajax', $containerid = 'generate_page' )
{
    global $lang_global;
    
    $total_pages = ceil( $num_items / $per_page );
    if ( $total_pages == 1 ) return '';
    @$on_page = floor( $start_item / $per_page ) + 1;
    $amp = preg_match( "/\?/", $base_url ) ? "&amp;" : "?";
    $page_string = "";
    if ( $total_pages > 10 )
    {
        $init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
        for ( $i = 1; $i <= $init_page_max; $i ++ )
        {
            $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
            $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
            if ( $i < $init_page_max ) $page_string .= "";
        }
        if ( $total_pages > 3 )
        {
            if ( $on_page > 1 && $on_page < $total_pages )
            {
                $page_string .= ( $on_page > 5 ) ? " ... " : ", ";
                $init_page_min = ( $on_page > 4 ) ? $on_page : 5;
                $init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
                for ( $i = $init_page_min - 1; $i < $init_page_max + 2; $i ++ )
                {
                    $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
                    $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
                    if ( $i < $init_page_max + 1 )
                    {
                        $page_string .= "";
                    }
                }
                $page_string .= ( $on_page < $total_pages - 4 ) ? " ... " : ", ";
            }
            else
            {
                $page_string .= " ... ";
            }
            
            for ( $i = $total_pages - 2; $i < $total_pages + 1; $i ++ )
            {
                $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
                $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
                if ( $i < $total_pages )
                {
                    $page_string .= "";
                }
            }
        }
    }
    else
    {
        for ( $i = 1; $i < $total_pages + 1; $i ++ )
        {
            $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
            $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
            if ( $i < $total_pages )
            {
                $page_string .= "";
            }
        }
    }
    if ( $add_prevnext_text )
    {
        if ( $on_page > 1 )
        {
            $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $on_page - 2 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $on_page - 2 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
            $page_string = "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pageprev'] . "</a></span>&nbsp;&nbsp;" . $page_string;
        }
        if ( $on_page < $total_pages )
        {
            $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( $on_page * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( $on_page * $per_page ) ) ) . "','" . $containerid . "')\"";
            $page_string .= "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pagenext'] . "</a></span>";
        }
    }
    return $page_string;
}

/**
 * theme_viewcat_download()
 * 
 * @param mixed $array
 * @param mixed $download_config
 * @param mixed $subs
 * @param mixed $generate_page
 * @return
 */
function theme_main_download ( $array_cats, $list_cats, $download_config )
{
    global $global_config, $lang_module, $lang_global, $module_info, $module_name, $module_file, $my_head;
    $xtpl = new XTemplate( "main_page.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file . "/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'GLANG', $lang_global );
    $xtpl->assign( 'IMG_FOLDER', NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/download/" );
    $xtpl->assign( 'MODULELINK', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" );
    foreach ( $array_cats as $cat )
    {
        if ( empty( $cat['parentid'] ) )
        {
            $xtpl->assign( 'catbox', $cat );
            if ( ! empty( $cat['subcats'] ) )
            {
                foreach ( $list_cats as $subcat )
                {
                    if ( $subcat['parentid'] == $cat['id'] )
                    {
                        $subcat['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $subcat['alias'];
                        $xtpl->assign( 'listsubcat', $subcat );
                        $xtpl->parse( 'main.catbox.subcatbox.listsubcat' );
                    }
                }
                $xtpl->parse( 'main.catbox.subcatbox' );
            }
            $items = $cat['items'];
            #parse the first items
            $thefirstcat = current( $items );
            $xtpl->assign( 'itemcat', $thefirstcat );
            if ( ! empty( $thefirstcat['fileimage']['orig_src'] ) )
            {
                $xtpl->parse( 'main.catbox.itemcat.image' );
            }
            $xtpl->parse( 'main.catbox.itemcat' );
            foreach ( $items as $item )
            {
                if ( $item['id'] != $thefirstcat['id'] )
                {
                    $xtpl->assign( 'loop', $item );
                    $xtpl->parse( 'main.catbox.related.loop' );
                }
            }
            $xtpl->parse( 'main.catbox.related' );
            $xtpl->parse( 'main.catbox' );
        }
    }
    
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function theme_viewcat_download ( $array, $download_config, $subs, $generate_page )
{
    global $global_config, $lang_module, $lang_global, $module_info, $module_name, $module_file;
    
    $xtpl = new XTemplate( "viewcat_page.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file . "/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'GLANG', $lang_global );
    $xtpl->assign( 'IMG_FOLDER', NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/download/" );
    $xtpl->assign( 'MODULELINK', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" );
    
    if ( $download_config['is_addfile_allow'] )
    {
        $xtpl->assign( 'UPLOAD', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=upload" );
        $xtpl->parse( 'main.is_addfile_allow' );
    }
    #view cat
    if ( ! empty( $subs ) )
    {
        $i = 1;
        foreach ( $subs as $cat )
        {
            $cat['current'] = 'current-cat';
            $xtpl->assign( 'listsubcat', $cat );
            if ( ! empty( $cat['posts'] ) )
            {
                //post in subcat
                $items = $cat['posts'];
                #parse the first items
                $thefirstcat = current( $items );
                $xtpl->assign( 'itemcat', $thefirstcat );
                if ( ! empty( $thefirstcat['fileimage']['orig_src'] ) )
                {
                    $xtpl->parse( 'main.listsubcat.itemcat.image' );
                }
                foreach ( $items as $item )
                {
                    if ( $item['id'] != $thefirstcat['id'] )
                    {
                        $xtpl->assign( 'loop', $item );
                        $xtpl->parse( 'main.listsubcat.itemcat.related.loop' );
                    }
                }
                $xtpl->parse( 'main.listsubcat.itemcat.related' );
                $xtpl->parse( 'main.listsubcat.itemcat' );
                //post in subcat
            }
            
            $xtpl->parse( 'main.listsubcat' );
            $i = 0;
        }
    }
    
    if ( ! empty( $array ) )
    {
        foreach ( $array as $row )
        {
            $xtpl->assign( 'listpostcat', $row );
            
            if ( ! empty( $row['author_name'] ) )
            {
                $xtpl->parse( 'main.row.author_name' );
            }
            
            if ( ! empty( $row['fileimage']['orig_src'] ) )
            {
                $xtpl->parse( 'main.listpostcat.image' );
            }
            
            if ( ! empty( $row['edit_link'] ) )
            {
                $xtpl->parse( 'main.listpostcat.is_admin' );
            }
            
            $xtpl->parse( 'main.listpostcat' );
        }
    }
    
    if ( ! empty( $generate_page ) )
    {
        $xtpl->assign( 'GENERATE_PAGE', $generate_page );
        $xtpl->parse( 'main.generate_page' );
    }
    
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * view_file()
 * 
 * @param mixed $row
 * @param mixed $download_config
 * @return
 */
function view_file ( $row, $download_config )
{
    global $global_config, $lang_global, $lang_module, $module_name, $module_file, $module_info, $my_head;
    
    if ( ! defined( 'SHADOWBOX' ) and isset( $row['fileimage']['src'] ) and ! empty( $row['fileimage']['src'] ) )
    {
        $my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.js\"></script>\n";
        $my_head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.css\" />\n";
        $my_head .= "<script type=\"text/javascript\">\n";
        $my_head .= "Shadowbox.init();\n";
        $my_head .= "</script>\n";
        
        define( 'SHADOWBOX', true );
    }
    
    $my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/star-rating/jquery.rating.pack.js\"></script>\n";
    $my_head .= "<script src=\"" . NV_BASE_SITEURL . "js/star-rating/jquery.MetaData.js\" type=\"text/javascript\"></script>\n";
    $my_head .= "<link href=\"" . NV_BASE_SITEURL . "js/star-rating/jquery.rating.css\" type=\"text/css\" rel=\"stylesheet\" />\n";
    $my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/jquery/jquery.validate.js\"></script>\n";
    $my_head .= "<script type=\"text/javascript\">\n";
    $my_head .= "$(document).ready(function(){
            $('#commentForm').validate({
                submitHandler: function() { nv_send_comment(); },
                rules: {
                    comment_uname: {
                    required: true,
                    rangelength: [3, 60]
                    },
                    
                    comment_uemail: {
                    required: true,
                    email: true
                    },
                    
                    comment_subject: {
                    required: true,
                    rangelength: [3, 200]
                    },
                    
                    comment_content: {
                    required: true,
                    rangelength: [3, 1000]
                    },
                    
                    comment_seccode: {
                    required: true,
                    minlength: " . NV_GFX_NUM . "
                    }
                }
			});
          });";
    $my_head .= "  </script>\n";
    
    $xtpl = new XTemplate( "viewfile.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file . "/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'GLANG', $lang_global );
    $xtpl->assign( 'ROW', $row );
    
    if ( $download_config['is_addfile_allow'] )
    {
        $xtpl->assign( 'UPLOAD', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=upload" );
        $xtpl->parse( 'main.is_addfile_allow' );
    }
    
    if ( isset( $row['fileimage']['src'] ) and ! empty( $row['fileimage']['src'] ) )
    {
        $xtpl->assign( 'FILEIMAGE', $row['fileimage'] );
        $xtpl->parse( 'main.is_image' );
    }
    
    if ( ! empty( $row['description'] ) )
    {
        $xtpl->parse( 'main.introtext' );
    }
    
    if ( ! empty( $row['comment_allow'] ) )
    {
        $xtpl->parse( 'main.comment_allow' );
    }
    
    if ( $row['is_download_allow'] )
    {
        $xtpl->parse( 'main.report' );
        
        if ( ! empty( $row['fileupload'] ) )
        {
            $xtpl->assign( 'SITE_NAME', $global_config['site_name'] );
            
            $a = 0;
            foreach ( $row['fileupload'] as $fileupload )
            {
                $fileupload['key'] = $a;
                $xtpl->assign( 'FILEUPLOAD', $fileupload );
                $xtpl->parse( 'main.download_allow.fileupload.row' );
                $a ++;
            }
            
            $xtpl->parse( 'main.download_allow.fileupload' );
        }
        
        if ( ! empty( $row['linkdirect'] ) )
        {
            foreach ( $row['linkdirect'] as $host => $linkdirect )
            {
                $xtpl->assign( 'HOST', $host );
                
                foreach ( $linkdirect as $link )
                {
                    $xtpl->assign( 'LINKDIRECT', $link );
                    $xtpl->parse( 'main.download_allow.linkdirect.row' );
                }
                
                $xtpl->parse( 'main.download_allow.linkdirect' );
            }
        }
        
        $xtpl->parse( 'main.download_allow' );
    }
    else
    {
        $xtpl->parse( 'main.download_not_allow' );
    }
    
    if ( $row['rating_disabled'] )
    {
        $xtpl->parse( 'main.disablerating' );
    }
    
    if ( defined( 'NV_IS_MODADMIN' ) )
    {
        $xtpl->parse( 'main.is_admin' );
    }
    
    if ( $row['comment_allow'] )
    {
        if ( $row['is_comment_allow'] )
        {
            $xtpl->assign( 'FORM_ACTION', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=getcomment" );
            $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
            $xtpl->assign( 'CAPTCHA_MAXLENGTH', NV_GFX_NUM );
            
            $xtpl->parse( 'main.comment_allow2.is_comment_allow' );
        }
        $xtpl->parse( 'main.comment_allow2' );
    }
    
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * show_comment()
 * 
 * @param mixed $array
 * @param mixed $generate_page
 * @return
 */
function show_comment ( $array, $generate_page )
{
    global $module_info, $module_name, $module_file, $lang_module, $lang_global, $global_config;
    if ( ! empty( $array ) )
    {
        $xtpl = new XTemplate( "comment.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file . "/" );
        $xtpl->assign( 'LANG', $lang_module );
        $xtpl->assign( 'GLANG', $lang_global );
        foreach ( $array as $row )
        {
			if ( ! empty ( $row['photo'] ) && file_exists ( NV_ROOTDIR . "/" . $row['photo'] ) )
			{
				$row['photo'] = NV_BASE_SITEURL . $row['photo'];
			}
			else
			{
				$row['photo'] = NV_BASE_SITEURL . "themes/" . $global_config['module_theme'] . "/images/users/no_avatar.jpg";
			}
			
            $xtpl->assign( 'ROW', $row );
            
            if ( defined( 'NV_IS_MODADMIN' ) )
            {
                $xtpl->parse( 'main.if_not_empty.detail.is_admin' );
            }
            $xtpl->parse( 'main.if_not_empty.detail' );
        }
        
        if ( ! empty( $generate_page ) )
        {
            $xtpl->assign( 'GENERATE_PAGE', $generate_page );
            $xtpl->parse( 'main.if_not_empty.generate_page' );
        }
        $xtpl->parse( 'main.if_not_empty' );
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
    else
    {
        return "&nbsp;";
    }

}

/**
 * theme_upload()
 * 
 * @param mixed $array
 * @param mixed $list_cats
 * @param mixed $download_config
 * @param mixed $error
 * @return
 */
function theme_upload ( $array, $list_cats, $download_config, $error )
{
    global $module_info, $module_name, $module_file, $lang_module, $lang_global, $my_head;
    
    $my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/jquery/jquery.validate.js\"></script>\n";
    $my_head .= "<script type=\"text/javascript\">\n";
    $my_head .= "$(document).ready(function(){
            $('#uploadForm').validate({
                rules: {
                    upload_title: {
                    required: true,
                    rangelength: [3, 255]
                    },
                    
                    upload_author_name: {
                    rangelength: [3, 100]
                    },
                    
                    upload_author_email: {
                    email: true
                    },
                    
                    upload_author_url: {
                    url: true
                    },
                    
                    upload_fileupload: {
                    accept: '" . implode( "|", $download_config['upload_filetype'] ) . "'
                    },
                    
                    upload_filesize: {
                    number: true
                    },
                    
                    upload_fileimage: {
                    accept: 'jpg|gif|png'
                    },
                    
                    upload_introtext: {
                    maxlength: 500
                    },
                    
                    upload_description: {
                    maxlength: 5000
                    },
                    
                    upload_user_name: {
                    required: true,
                    rangelength: [3, 60]
                    },
                    
                    upload_seccode: {
                    required: true,
                    minlength: 6
                    }
                }
			});
          });";
    $my_head .= "  </script>\n";
    
    $xtpl = new XTemplate( "upload.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file . "/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'GLANG', $lang_global );
    $xtpl->assign( 'DOWNLOAD', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name );
    $xtpl->assign( 'UPLOAD', $array );
    $xtpl->assign( 'FORM_ACTION', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=upload" );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'CAPTCHA_MAXLENGTH', NV_GFX_NUM );
    $xtpl->assign( 'EXT_ALLOWED', implode( ", ", $download_config['upload_filetype'] ) );
    
    if ( ! empty( $error ) )
    {
        $xtpl->assign( 'ERROR', $error );
        $xtpl->parse( 'main.is_error' );
    }
    
    foreach ( $list_cats as $cat )
    {
        $cat['selected'] = $array['catid'] == $cat['id'] ? " selected=\"selected\"" : "";
        $xtpl->assign( 'LISTCATS', $cat );
        $xtpl->parse( 'main.catid' );
    }
	if ($download_config['is_upload_allow'])
	{
		$xtpl->parse('main.is_upload_allow');
	}	
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

?>