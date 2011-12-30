<?php

/**
 * @Project NUKEVIET 3.1
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2011 VINADES.,JSC. All rights reserved
 * @Createdate 21-04-2011 11:17
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! nv_function_exists( 'nv_menu_site' ) )
{
    function nv_block_config_menu ( $module, $data_block, $lang_block )
    {
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['menu'] . "</td>";
        $html .= "	<td><select name=\"menuid\">\n";
		
        $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module . "_menu` ORDER BY `id` DESC";
        $list = nv_db_cache( $sql, 'id', $module );
        foreach ( $list as $l )
        {
            $sel = ( $data_block['menuid'] == $l['id'] ) ? ' selected' : '';
            $html .= "<option value=\"" . $l['id'] . "\" " . $sel . ">" . $l['title'] . "</option>\n";
        }
		
        $html .= "	</select></td>\n";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['is_viewdes'] . "</td>";
        $checked = ( $data_block['is_viewdes'] == 1 ) ? " checked=\"checked\"" : "";
        $html .= "	<td><input value=\"1\" type=\"checkbox\" name=\"is_viewdes\"" . $checked . "/></td>";
        $html .= "<td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['type'] . "</td>";
        $html .= "	<td><select name=\"type\">\n";
        $sel = ( $data_block['type'] == 1 ) ? ' selected' : '';
        $html .= "<option value=\"1\" " . $sel . ">" . $lang_block['m_type1'] . "</option>\n";
        $sel = ( $data_block['type'] == 2 ) ? ' selected' : '';
        $html .= "<option value=\"2\" " . $sel . ">" . $lang_block['m_type2'] . "</option>\n";
        $sel = ( $data_block['type'] == 3 ) ? ' selected' : '';
        $html .= "<option value=\"3\" " . $sel . ">" . $lang_block['m_type3'] . "</option>\n";
        $sel = ( $data_block['type'] == 4 ) ? ' selected' : '';
        $html .= "<option value=\"4\" " . $sel . ">" . $lang_block['m_type4'] . "</option>\n";
        $sel = ( $data_block['type'] == 5 ) ? ' selected' : '';
        $html .= "<option value=\"5\" " . $sel . ">" . $lang_block['m_type5'] . "</option>\n";
        $sel = ( $data_block['type'] == 6 ) ? ' selected' : '';
        $html .= "<option value=\"6\" " . $sel . ">" . $lang_block['m_type6'] . "</option>\n";
        $sel = ( $data_block['type'] == 7 ) ? ' selected' : '';
        $html .= "<option value=\"7\" " . $sel . ">" . $lang_block['m_type7'] . "</option>\n";
        $sel = ( $data_block['type'] == 8 ) ? ' selected' : '';
        $html .= "<option value=\"8\" " . $sel . ">" . $lang_block['m_type8'] . "</option>\n";
        $html .= "	</select></td>\n";
        $html .= "</tr>";
        $html .= "<tr>";
        
        return $html;
    }

    function nv_block_config_menu_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['type'] = $nv_Request->get_int( 'type', 'post', 0 );
        $return['config']['is_viewdes'] = $nv_Request->get_int( 'is_viewdes', 'post', 0 );
        $return['config']['menuid'] = $nv_Request->get_int( 'menuid', 'post', 0 );
        return $return;
    }

    function nv_style_type ( $style, $list_cats, $block_config )
    {
        global $module_info;
		
        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/menu/" . $style . ".tpl" ) )
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }
		
        $xtpl = new XTemplate( $style . ".tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/menu" );
        $xtpl->assign( 'BLOCK_THEME', $block_theme );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        
        foreach ( $list_cats as $cat )
        {
            if ( empty( $cat['parentid'] ) )
            {
                $xtpl->assign( 'CAT1', $cat );
                if ( ! empty( $cat['subcats'] ) )
                {
                    $html_content = nv_sub_menu( $style, $list_cats, $cat['subcats'] );
                    $xtpl->assign( 'HTML_CONTENT', $html_content );
                    $xtpl->parse( 'main.loopcat1.cat2' );
                }
				
				if ( $block_config['is_viewdes'] and ! empty ( $cat['note'] ) )
				{
					$xtpl->parse( 'main.loopcat1.note' );
				}
				
                $xtpl->parse( 'main.loopcat1' );
            }
        }
        $xtpl->parse( 'main' );
        
        return $xtpl->text( 'main' );
    }

    function nv_style_type3 ( $list_cats, $block_config )
    {
        global $module_info;
		
        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/menu/pro_dropdown.tpl" ) )
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }
		
        $xtpl = new XTemplate( "pro_dropdown.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/menu" );
        $xtpl->assign( 'BLOCK_THEME', $block_theme );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		
        $arr = array();
        foreach ( $list_cats as $cat )
        {
            if ( empty( $cat['parentid'] ) )
            {
                $xtpl->assign( 'CAT1', $cat );
                if ( ! empty( $cat['subcats'] ) )
                {
                   $xtpl->assign( 'down', 'class="down"' );
                	foreach ( $list_cats as $subcat )
                    {
                        if ( $subcat['parentid'] == $cat['id'] )
                        {
                            $xtpl->assign( 'CAT2', $subcat );
                            if ( ! empty( $subcat['subcats'] ) )
                            {                                
                            	$xtpl->assign( 'cla', 'class="fly"' );
                                $html_content = nv_sub_menu( 'pro_dropdown', $list_cats, $subcat['subcats'] );
                                $xtpl->assign( 'HTML_CONTENT', $html_content );
                                $xtpl->parse( 'main.loopcat1.cat2.loopcat2.cat3' );
                            }
                            else
                            {
                                $xtpl->assign( 'cla', '' );
                            }
                            $xtpl->parse( 'main.loopcat1.cat2.loopcat2' );
                        }
                    }
                    $xtpl->parse( 'main.loopcat1.cat2' );
                }
           		 else 
                    {
                    	$xtpl->assign( 'down', 'class=""' );
                 }
				
				if ( $block_config['is_viewdes'] and ! empty ( $cat['note'] ) )
				{
					$xtpl->parse( 'main.loopcat1.note' );
				}
				

                $xtpl->parse( 'main.loopcat1' );
            }
        }
		
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }

    function nv_menu_site ( $block_config )
    {
        global $db, $module_name;
        		
        $list_cats = array();
        $sql = "SELECT `id`, `parentid`, `title`, `link`, `note`, `subitem`, `who_view`, `groups_view` FROM `" . NV_PREFIXLANG . "_menu_rows` WHERE `status`=1 AND `mid` = " . $block_config['menuid'] . " ORDER BY `weight` ASC";
        $result = $db->sql_query( $sql );
        while ( $row = $db->sql_fetchrow( $result ) )
        {
			$current_menu = "";
			$base_url_replace = str_replace( "/", "\/", NV_BASE_SITEURL );
				
			if ( ( preg_match( "/^" . $base_url_replace . "index\.php\?" . NV_LANG_VARIABLE . "\=" . NV_LANG_DATA . "\&" . NV_NAME_VARIABLE . "\=" . $module_name . "$/", $row['link'] ) or preg_match( "/^" . $base_url_replace . "index\.php\?" . NV_LANG_VARIABLE . "\=" . NV_LANG_DATA . "\&" . NV_NAME_VARIABLE . "\=" . $module_name . "\&/", $row['link'] ) ) and ( $row['parentid'] == 0 ) )
			{
				$current_menu = " class=\"current\"";
			}

            if ( nv_set_allow( $row['who_view'], $row['groups_view'] ) )
            {
                $list_cats[$row['id']] = array( 
                    'id' => $row['id'], 
					'parentid' => $row['parentid'],  //
					'subcats' => $row['subitem'],  //
					'title' => $row['title'],  // 
					'link' => $row['link'],  //
					'note' => $row['note'],  //
					'current' => $current_menu  //
                );
            }
        }
        		
        if ( $block_config['type'] == 1 )
        {
            $style = 'with_supersubs';
            return nv_style_type( $style, $list_cats, $block_config );
        }
        elseif ( $block_config['type'] == 2 )
        {
            $style = 'nav_bar';
            return nv_style_type( $style, $list_cats, $block_config );
        }
        elseif ( $block_config['type'] == 3 )
        {
            $style = 'vertical';
            return nv_style_type( $style, $list_cats, $block_config );
        }
        elseif ( $block_config['type'] == 4 )
        {
            $style = 'treeview';
            return nv_style_type( $style, $list_cats, $block_config );
        }
        elseif ( $block_config['type'] == 5 )
        {
            return nv_style_type2( $list_cats, $block_config );
        }
        elseif ( $block_config['type'] == 7 )
        {
            return nv_style_type3( $list_cats, $block_config );
        }
   		elseif ( $block_config['type'] == 8 )
        {
            return nv_style_type4( $list_cats, $block_config );
        }
        
        else
        {
            $style = 'side_menu_bar';
            return nv_style_type( $style, $list_cats, $block_config );
        }
    }
    
function nv_style_type4 ( $list_cats, $block_config )
    {
        global $module_info;
        
        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/menu/ver_2_level.tpl" ) )
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }
        
        $xtpl = new XTemplate( "ver_2_level.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/menu" );
        $xtpl->assign( 'BLOCK_THEME', $block_theme );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        
        $arr = array();
        foreach ( $list_cats as $cat )
        {
            if ( empty( $cat['parentid'] ) )
            {
                $xtpl->assign( 'CAT1', $cat );
                if ( ! empty( $cat['subcats'] ) )
                {
                    $xtpl->assign( 'menuheaders', 'class="menuheaders"' );
                    foreach ( $list_cats as $subcat )
                    {
                        if ( $subcat['parentid'] == $cat['id'] )
                        {
                            $xtpl->assign( 'CAT2', $subcat );
                                                       
                            $xtpl->parse( 'main.loopcat1.cat2.loop2' );
                        }
                    }
                    $xtpl->parse( 'main.loopcat1.cat2' );
                }
                else
                {
                    $xtpl->assign( 'menuheaders', '' );
                }
                             
                $xtpl->parse( 'main.loopcat1' );
            }
        }
        
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }

    function nv_style_type2 ( $list_cats, $block_config )
    {
        global $module_info;
		
        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/menu/top_menu_bar.tpl" ) )
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }
		
        $xtpl = new XTemplate( "top_menu_bar.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/menu" );
        $xtpl->assign( 'BLOCK_THEME', $block_theme );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        
        $i = 0;
        foreach ( $list_cats as $cat )
        {
            if ( empty( $cat['parentid'] ) )
            {
                $xtpl->assign( 'CAT1', $cat );
                
                if ( ! empty( $cat['subcats'] ) )
                {
                    $i = $i + 1;
                    $rel1 = "ddsubmenu" . $i;
                    $rel = "rel=\"" . $rel1 . "\"";
                    $xtpl->assign( 'rel', $rel );
                }
                else
                {
                    $xtpl->assign( 'rel', "" );
                }
				
				if ( $block_config['is_viewdes'] and ! empty ( $cat['note'] ) )
				{
					$xtpl->parse( 'main.loopcat1.note' );
				}
                
                $xtpl->parse( 'main.loopcat1' );
            }
        }
        
        $arr = array();
        $j = 0;
        
        foreach ( $list_cats as $cati )
        {
            if ( empty( $cati['parentid'] ) )
            {
                if ( ! empty( $cati['subcats'] ) )
                {
                    $j = $j + 1;
                    $xtpl->assign( 'nu', $j );
                    
                    foreach ( $list_cats as $subcat )
                    {
                        if ( $subcat['parentid'] == $cati['id'] )
                        {
                            $arr[] = $subcat;
                            $xtpl->assign( 'CAT2', $subcat );
                            
                            if ( ! empty( $subcat['subcats'] ) )
                            {
                                $html_content = nv_sub_menu( 'top_menu_bar', $list_cats, $subcat['subcats'] );
                                $xtpl->assign( 'HTML_CONTENT', $html_content );
                                $xtpl->parse( 'main.cat2.loopcat2.cat3' );
                            }
                            
                            $xtpl->parse( 'main.cat2.loopcat2' );
                        }
                    
                    }
                    $xtpl->parse( 'main.cat2' );
                }
            }
        }
        
        $xtpl->parse( 'main' );
        return ( $xtpl->text( 'main' ) );
    }

    function nv_sub_menu ( $style, $list_cats, $list_sub )
    {
        global $module_info;
        
        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/menu/" . $style . ".tpl" ) )
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }
		
        $xtpl = new XTemplate( $style . ".tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/menu" );
        
        if ( empty( $list_sub ) )
        {
            return "";
        }
        else
        {
            $list = explode( ",", $list_sub );
            
            foreach ( $list as $catid )
            {
                if ( $style == 'pro_dropdown' )
                {
                    if( $list_cats[$catid]['subcats'] != "" )
                    {
                		$xtpl->assign( 'cla', 'class="fly"' );
                    }
                    else 
                    {
                    	$xtpl->assign( 'cla', '' );
                    }
                }
                else
                {
                    $xtpl->assign( 'cla', '' );
                }
				
                $xtpl->assign( 'MENUTREE', $list_cats[$catid] );
				
                if ( ! empty( $list_cats[$catid]['subcats'] ) )
                {
                    $tree = nv_sub_menu( $style, $list_cats, $list_cats[$catid]['subcats'] );
                    $xtpl->assign( 'TREE_CONTENT', $tree );
                    $xtpl->parse( 'tree.tree_content' );
                }
				
                $xtpl->parse( 'tree' );
            }
            
            return $xtpl->text( 'tree' );
        }
    }
}

if ( defined( 'NV_SYSTEM' ) )
{
    $content = nv_menu_site( $block_config );
}

?>