<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @createdate 12/31/2009 2:29
 */

if( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$global_array_cat = array();
$global_array_cat[0] = array(
	"catid" => 0,
	"parentid" => 0,
	"title" => "Other",
	"alias" => "Other",
	"link" => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=Other",
	"viewcat" => "viewcat_page_new",
	"subcatid" => 0,
	"numlinks" => 3,
	"description" => "",
	"keywords" => ""
);

$sql = "SELECT `catid`, `parentid`, `lev`, `" . NV_LANG_DATA . "_title`, `" . NV_LANG_DATA . "_alias`, `viewcat`, `numsubcat`, `subcatid`, `numlinks`, `del_cache_time`, `" . NV_LANG_DATA . "_description`, `inhome`, `" . NV_LANG_DATA . "_keywords`, `who_view`, `groups_view` FROM `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` ORDER BY `order` ASC";
$result = $db->sql_query( $sql );

while( list( $catid_i, $parentid_i, $lev_i, $title_i, $alias_i, $viewcat_i, $numsubcat_i, $subcatid_i, $numlinks_i, $del_cache_time_i, $description_i, $inhome_i, $keywords_i, $who_view_i, $groups_view_i ) = $db->sql_fetchrow( $result ) )
{
	$xtitle_i = "";
	if( $lev_i > 0 )
	{
		$xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
		for( $i = 1; $i <= $lev_i; $i++ )
		{
			$xtitle_i .= "---";
		}
		$xtitle_i .= "&nbsp;";
	}
	$xtitle_i .= $title_i;
	
	$global_array_cat[$catid_i] = array(
		"catid" => $catid_i,
		"parentid" => $parentid_i,
		"title" => $title_i,
		"alias" => $alias_i,
		"link" => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $alias_i,
		"viewcat" => $viewcat_i,
		"numsubcat" => $numsubcat_i,
		"subcatid" => $subcatid_i,
		"numlinks" => $numlinks_i,
		"description" => $description_i,
		"inhome" => $inhome_i,
		"keywords" => $keywords_i,
		"who_view" => $who_view_i,
		"groups_view" => $groups_view_i,
		"lev" => $lev_i,
		"name" => $xtitle_i,
	);	
}

$submenu['items'] = $lang_module['content_add_items'];
$submenu['content'] = $lang_module['content_add'];
$submenu['cat'] = $lang_module['categories'];
$submenu['group'] = $lang_module['group'];
$submenu['blockcat'] = $lang_module['block'];
$submenu['sources'] = $lang_module['sources'];
$submenu['comment'] = $lang_module['comment'];
$submenu['prounit'] = $lang_module['prounit'];
$submenu['order'] = $lang_module['order_title'];
$submenu['money'] = $lang_module['money'];
$submenu['payport'] = $lang_module['setup_payment'];
$submenu['docpay'] = $lang_module['document_payment'];
$submenu['setting'] = $lang_module['setting'];

$allow_func = array( 'main', 'alias', 'items', 'exptime', 'publtime', 'setting', 'content', 'keywords', 'del_content', 'cat', 'change_cat', 'list_cat', 'del_cat', 'sources', 'change_source', 'list_source', 'del_source', 'sourceajax', 'block', 'blockcat', 'del_block_cat', 'list_block_cat', 'chang_block_cat', 'change_block', 'list_block', 'comment', 'del_comment', 'active_comment', 'prounit', 'delunit', 'order', 'or_del', 'or_view', 'money', 'delmoney', 'active_pay', 'payport', 'changepay', 'actpay', 'docpay', 'group', 'del_group', 'list_group', 'change_group', 'getcatalog', 'getgroup' );

$array_viewcat_full = array( 
	'view_home_cat' => $lang_module['view_home_cat'],
	'viewcat_page_list' => $lang_module['viewcat_page_list'],
	'viewcat_page_gird' => $lang_module['viewcat_page_gird']
);
$array_viewcat_nosub = array(
	'viewcat_page_list' => $lang_module['viewcat_page_list'],
	'viewcat_page_gird' => $lang_module['viewcat_page_gird']
);
$array_who_view = array( $lang_global['who_view0'], $lang_global['who_view1'], $lang_global['who_view2'], $lang_global['who_view3'] );
$array_allowed_comm = array( $lang_global['no'], $lang_global['who_view0'], $lang_global['who_view1'] );

define( 'NV_IS_FILE_ADMIN', true );

require_once ( NV_ROOTDIR . "/modules/" . $module_file . "/global.functions.php" );

/**
 * nv_fix_cat_order()
 * 
 * @param integer $parentid
 * @param integer $order
 * @param integer $lev
 * @return
 */
function nv_fix_cat_order( $parentid = 0, $order = 0, $lev = 0 )
{
	global $db, $db_config, $module_data;
	
	$sql = "SELECT `catid`, `parentid` FROM `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	$array_cat_order = array();
	while( $row = $db->sql_fetchrow( $result ) )
	{
		$array_cat_order[] = $row['catid'];
	}
	$db->sql_freeresult();
	$weight = 0;
	
	if( $parentid > 0 )
	{
		$lev++;
	}
	else
	{
		$lev = 0;
	}
	
	foreach( $array_cat_order as $catid_i )
	{
		$order ++;
		$weight ++;
		$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` SET `weight`=" . $weight . ", `order`=" . $order . ", `lev`='" . $lev . "' WHERE `catid`=" . intval( $catid_i );
		$db->sql_query( $sql );
		$order = nv_fix_cat_order( $catid_i, $order, $lev );
	}
	
	$numsubcat = $weight;
	if( $parentid > 0 )
	{
		$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` SET `numsubcat`=" . $numsubcat;
		if( $numsubcat == 0 )
		{
			$sql .= ", `subcatid`='', `viewcat`='viewcat_page_list'";
		}
		else
		{
			$sql .= ", `subcatid`='" . implode( ",", $array_cat_order ) . "'";
		}
		$sql .= " WHERE `catid`=" . intval( $parentid );
		$db->sql_query( $sql );
	}
	return $order;
}

/**
 * nv_fix_block_cat()
 * 
 * @return
 */
function nv_fix_block_cat()
{
	global $db, $db_config, $module_data;
	
	$sql = "SELECT `bid` FROM `" . $db_config['prefix'] . "_" . $module_data . "_block_cat` ORDER BY `weight` ASC";
	$weight = 0;
	$result = $db->sql_query( $sql );
	while( $row = $db->sql_fetchrow( $result ) )
	{
		$weight++;
		$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_block_cat` SET `weight`=" . $weight . " WHERE `bid`=" . intval( $row['bid'] );
		$db->sql_query( $sql );
	}
	$db->sql_freeresult();
}

/**
 * nv_fix_source()
 * 
 * @return
 */
function nv_fix_source()
{
	global $db, $db_config, $module_data;
	
	$sql = "SELECT `sourceid` FROM `" . $db_config['prefix'] . "_" . $module_data . "_sources` ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	$weight = 0;
	while( $row = $db->sql_fetchrow( $result ) )
	{
		$weight++;
		$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_sources` SET `weight`=" . $weight . " WHERE `sourceid`=" . intval( $row['sourceid'] );
		$db->sql_query( $sql );
	}
	$db->sql_freeresult();
}

/**
 * nv_news_fix_block()
 * 
 * @param mixed $bid
 * @param bool $repairtable
 * @return
 */
function nv_news_fix_block( $bid, $repairtable = true )
{
	global $db, $db_config, $module_data;
	
	$bid = intval( $bid );
	
	if( $bid > 0 )
	{
		$sql = "SELECT `id` FROM `" . $db_config['prefix'] . "_" . $module_data . "_block` WHERE `bid`='" . $bid . "' ORDER BY `weight` ASC";
		$result = $db->sql_query( $sql );
		$weight = 0;
		while( $row = $db->sql_fetchrow( $result ) )
		{
			$weight++;
			if( $weight <= 500 )
			{
				$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_block` SET `weight`=" . $weight . " WHERE `bid`='" . $bid . "' AND `id`=" . intval( $row['id'] );
			}
			else
			{
				$sql = "DELETE FROM `" . $db_config['prefix'] . "_" . $module_data . "_block` WHERE `bid`='" . $bid . "' AND `id`=" . intval( $row['id'] );
			}
			$db->sql_query( $sql );
		}
		$db->sql_freeresult();
		
		if( $repairtable )
		{
			$db->sql_query( "REPAIR TABLE `" . $db_config['prefix'] . "_" . $module_data . "_block`" );
			$db->sql_query( "OPTIMIZE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_block`" );
		}
	}
}

/**
 * nv_show_cat_list()
 * 
 * @param integer $parentid
 * @return
 */
function nv_show_cat_list( $parentid = 0 )
{
	global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op, $array_viewcat_full, $array_viewcat_nosub, $global_config, $module_file;

	$xtpl = new XTemplate( "cat_lists.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );
	
	if( $parentid > 0 )
	{
		$parentid_i = $parentid;
		$array_cat_title = array();
		$a = 0;
		
		while( $parentid_i > 0 )
		{
			list( $catid_i, $parentid_i, $title_i ) = $db->sql_fetchrow( $db->sql_query( "SELECT `catid`, `parentid`, `" . NV_LANG_DATA . "_title` FROM `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` WHERE `catid`=" . intval( $parentid_i ) ) );
			
			$array_cat_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $catid_i . "\"><strong>" . $title_i . "</strong></a>";
			
			$a ++;
		}
		
		for( $i = $a - 1; $i >= 0; $i-- )
		{
			$xtpl->assign( 'CAT_NAV', $array_cat_title[$i] . ( $i > 0 ? " &raquo; " : "" ) );
			$xtpl->parse( 'main.catnav.loop' );
		}
		
		$xtpl->parse( 'main.catnav' );
	}
	
	$sql = "SELECT `catid`, `parentid`, `" . NV_LANG_DATA . "_title`, `weight`, `viewcat`, `numsubcat`, `inhome`, `numlinks` FROM `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` WHERE `parentid`='" . $parentid . "' ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	$num = $db->sql_numrows( $result );
	
	if( $num > 0 )
	{
		$a = 0;
		$array_inhome = array( $lang_global['no'], $lang_global['yes'] );
		
		while( list( $catid, $parentid, $title, $weight, $viewcat, $numsubcat, $inhome, $numlinks ) = $db->sql_fetchrow( $result ) )
		{
			$array_viewcat = ( $numsubcat > 0 ) ? $array_viewcat_full : $array_viewcat_nosub;
			if( ! array_key_exists( $viewcat, $array_viewcat ) )
			{
				$viewcat = "viewcat_page_list";
				$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` SET `viewcat`=" . $db->dbescape( $viewcat ) . " WHERE `catid`=" . intval( $catid );
				$db->sql_query( $sql );
			}
			
			$xtpl->assign( 'ROW', array(
				"class" => ( $a % 2 ) ? " class=\"second\"" : "",
				"catid" => $catid,
				"cat_link" => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $catid,
				"title" => $title,
				"numsubcat" => $numsubcat > 0 ? "  <span style=\"color:#FF0101;\">(" . $numsubcat . ")</span>" : "",
				"parentid" => $parentid,
			) );
			
			for( $i = 1; $i <= $num; $i++ )
			{
				$xtpl->assign( 'WEIGHT', array( "key" => $i, "title" => $i, "selected" => $i == $weight ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.data.loop.weight' );
			}
			
			foreach( $array_inhome as $key => $val )
			{
				$xtpl->assign( 'INHOME', array( "key" => $key, "title" => $val, "selected" => $key == $inhome ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.data.loop.inhome' );
			}

			foreach( $array_viewcat as $key => $val )
			{
				$xtpl->assign( 'VIEWCAT', array( "key" => $key, "title" => $val, "selected" => $key == $viewcat ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.data.loop.viewcat' );
			}

			for( $i = 0; $i <= 10; $i++ )
			{
				$xtpl->assign( 'NUMLINKS', array( "key" => $i, "title" => $i, "selected" => $i == $numlinks ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.data.loop.numlinks' );
			}
			
			$xtpl->parse( 'main.data.loop' );
			$a ++;
		}
		
		$xtpl->parse( 'main.data' );
	}
	
	$db->sql_freeresult();
	unset( $sql, $result );
	
	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );

	return $contents;
}

/**
 * nv_fix_group_order()
 * 
 * @param integer $parentid
 * @param integer $order
 * @param integer $lev
 * @return
 */
function nv_fix_group_order( $parentid = 0, $order = 0, $lev = 0 )
{
	global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
	
	$sql = "SELECT `groupid`, `parentid` FROM `" . $db_config['prefix'] . "_" . $module_data . "_group` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	$array_group_order = array();
	while( $row = $db->sql_fetchrow( $result ) )
	{
		$array_group_order[] = $row['groupid'];
	}
	$db->sql_freeresult();
	$weight = 0;
	if( $parentid > 0 )
	{
		$lev++;
	}
	else
	{
		$lev = 0;
	}
	foreach( $array_group_order as $groupid_i )
	{
		$order ++;
		$weight ++;
		
		$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_group` SET `weight`=" . $weight . ", `order`=" . $order . ", `lev`='" . $lev . "' WHERE `groupid`=" . intval( $groupid_i );
		$db->sql_query( $sql );
		
		$order = nv_fix_group_order( $groupid_i, $order, $lev );
	}
	
	$numsubgroup = $weight;
	
	if( $parentid > 0 )
	{
		$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_group` SET `numsubgroup`=" . $numsubgroup;
		if( $numsubgroup == 0 )
		{
			$sql .= ",`subgroupid`='', `viewgroup`='viewcat_page_list'";
		}
		else
		{
			$sql .= ",`subgroupid`='" . implode( ",", $array_group_order ) . "'";
		}
		$sql .= " WHERE `groupid`=" . intval( $parentid );
		$db->sql_query( $sql );
	}
	return $order;
}

/**
 * nv_show_group_list()
 * 
 * @param integer $parentid
 * @return
 */
function nv_show_group_list( $parentid = 0 )
{
	global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op, $array_viewcat_full, $array_viewcat_nosub, $module_file, $global_config;
	
	$xtpl = new XTemplate( "group_lists.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );
	
	if( $parentid > 0 )
	{
		$parentid_i = $parentid;
		$array_group_title = array();
		$a = 0;
		while( $parentid_i > 0 )
		{
			list( $groupid_i, $parentid_i, $title_i ) = $db->sql_fetchrow( $db->sql_query( "SELECT `groupid`, `parentid`, `" . NV_LANG_DATA . "_title` FROM `" . $db_config['prefix'] . "_" . $module_data . "_group` WHERE `groupid`=" . intval( $parentid_i ) ) );
			
			$array_group_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group&amp;parentid=" . $groupid_i . "\"><strong>" . $title_i . "</strong></a>";
			$a ++;
		}
		
		for( $i = $a - 1; $i >= 0; $i-- )
		{
			$xtpl->assign( 'GROUP_NAV', $array_group_title[$i] . ( $i > 0 ? " &raquo; " : "" ) );
			$xtpl->parse( 'main.groupnav.loop' );
		}
		
		$xtpl->parse( 'main.catnav' );
	}
	
	$sql = "SELECT `groupid`, `parentid`, `" . NV_LANG_DATA . "_title`, `weight`, `viewgroup`, `numsubgroup`, `inhome`, `numlinks` FROM `" . $db_config['prefix'] . "_" . $module_data . "_group` WHERE `parentid` = '" . $parentid . "' ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	$num = $db->sql_numrows( $result );
	
	if( $num > 0 )
	{
		$a = 0;
		$array_inhome = array( $lang_global['no'], $lang_global['yes'] );
		
		while( list( $groupid, $parentid, $title, $weight, $viewgroup, $numsubgroup, $inhome, $numlinks ) = $db->sql_fetchrow( $result ) )
		{
			$array_viewgroup = $array_viewcat_nosub;
			if( ! array_key_exists( $viewgroup, $array_viewgroup ) )
			{
				$viewgroup = "viewcat_page_list";
				$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_group` SET `viewgroup`=" . $db->dbescape( $viewgroup ) . " WHERE `groupid`=" . intval( $groupid );
				$db->sql_query( $sql );
			}
			
			$xtpl->assign( 'ROW', array(
				"class" => ( $a % 2 ) ? " class=\"second\"" : "",
				"groupid" => $groupid,
				"group_link" => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=group&amp;parentid=" . $groupid,
				"title" => $title,
				"numsubgroup" => $numsubgroup > 0 ? "  <span style=\"color:#FF0101;\">(" . $numsubgroup . ")</span>" : "",
				"parentid" => $parentid,
			) );
			
			for( $i = 1; $i <= $num; $i++ )
			{
				$xtpl->assign( 'WEIGHT', array( "key" => $i, "title" => $i, "selected" => $i == $weight ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.data.loop.weight' );
			}
			
			foreach( $array_inhome as $key => $val )
			{
				$xtpl->assign( 'INHOME', array( "key" => $key, "title" => $val, "selected" => $key == $inhome ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.data.loop.inhome' );
			}

			foreach( $array_viewgroup as $key => $val )
			{
				$xtpl->assign( 'VIEWGROUP', array( "key" => $key, "title" => $val, "selected" => $key == $viewgroup ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.data.loop.viewgroup' );
			}

			$xtpl->parse( 'main.data.loop' );
			$a++;
		}
		
		$xtpl->parse( 'main.data' );
	}
	
	$db->sql_freeresult();
	unset( $sql, $result );
	
	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );

	return $contents;
}

/**
 * nv_show_block_cat_list()
 * 
 * @return
 */
function nv_show_block_cat_list()
{
	global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op, $global_config, $module_file;

	$xtpl = new XTemplate( "block_cat_list.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );

	$sql = "SELECT * FROM `" . $db_config['prefix'] . "_" . $module_data . "_block_cat` ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	
	$num = $db->sql_numrows( $result );
	
	if( $num > 0 )
	{
		$a = 0;
		$array_adddefault = array( $lang_global['no'], $lang_global['yes'] );
		
		while( $row = $db->sql_fetchrow( $result ) )
		{
			list( $numnews ) = $db->sql_fetchrow( $db->sql_query( "SELECT COUNT(*)  FROM `" . $db_config['prefix'] . "_" . $module_data . "_block` WHERE `bid`=" . $row['bid'] ) );

			$xtpl->assign( 'ROW', array(
				"class" => ( $a % 2 ) ? " class=\"second\"" : "",
				"bid" => $row['bid'],
				"numnews" => $numnews ? " (" . $numnews . " " . $lang_module['topic_num_news'] . ")" : "",
				"title" => $row[NV_LANG_DATA . '_title'],
			) );

			for( $i = 1; $i <= $num; $i++ )
			{
				$xtpl->assign( 'WEIGHT', array( "key" => $i, "title" => $i, "selected" => $i == $row['weight'] ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.loop.weight' );
			}

			foreach( $array_adddefault as $key => $val )
			{
				$xtpl->assign( 'ADDDEFAULT', array( "key" => $key, "title" => $val, "selected" => $key == $row['adddefault'] ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.loop.adddefault' );
			}

			$xtpl->parse( 'main.loop' );
			$a ++;
		}
	}
	$db->sql_freeresult();
	
	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );
	
	return $contents;
}

/**
 * nv_show_sources_list()
 * 
 * @return
 */
function nv_show_sources_list()
{
	global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op, $nv_Request, $global_config, $module_file;

	$xtpl = new XTemplate( "sources_list.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );

	$num = $db->sql_numrows( $db->sql_query( "SELECT * FROM `" . $db_config['prefix'] . "_" . $module_data . "_sources` ORDER BY `weight` ASC" ) );
	$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=sources";
	$all_page = ( $num > 1 ) ? $num : 1;
	$per_page = 15;
	$page = $nv_Request->get_int( 'page', 'get', 0 );
	
	if( $num > 0 )
	{
		$a = 0;
		$result = $db->sql_query( "SELECT * FROM `" . $db_config['prefix'] . "_" . $module_data . "_sources` ORDER BY `weight` LIMIT " . $page . ", " . $per_page );
		
		while( $row = $db->sql_fetchrow( $result ) )
		{
			$xtpl->assign( 'ROW', array(
				"class" => ( $a % 2 ) ? " class=\"second\"" : "",
				"sourceid" => $row['sourceid'],
				"title" => $row[NV_LANG_DATA . '_title'],
				"link" => $row['link'],
			) );
			
			for( $i = 1; $i <= $num; $i++ )
			{
				$xtpl->assign( 'WEIGHT', array( "key" => $i, "title" => $i, "selected" => $i == $row['weight'] ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.loop.weight' );
			}
			
			$xtpl->parse( 'main.loop' );
			$a++;
		}
		
		$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
		
		if( $generate_page )
		{
			$xtpl->assign( 'GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
	}
	$db->sql_freeresult();
	
	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );
	
	return $contents;
}

/**
 * nv_show_block_list()
 * 
 * @param mixed $bid
 * @return
 */
function nv_show_block_list( $bid )
{
	global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op, $global_array_cat, $global_config, $module_file;

	$xtpl = new XTemplate( "block_list.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'BID', $bid );
	
	$sql = "SELECT t1.id, t1.listcatid, t1." . NV_LANG_DATA . "_title, t1." . NV_LANG_DATA . "_alias, t2.weight FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` as t1 INNER JOIN `" . $db_config['prefix'] . "_" . $module_data . "_block` AS t2 ON t1.id = t2.id WHERE t2.bid= " . $bid . " AND t1.inhome='1' ORDER BY t2.weight ASC";
	
	$result = $db->sql_query( $sql );
	$num = $db->sql_numrows( $result );
	$a = 0;
	
	while( list( $id, $listcatid, $title, $alias, $weight ) = $db->sql_fetchrow( $result ) )
	{
		$xtpl->assign( 'ROW', array(
			"class" => ( $a % 2 ) ? " class=\"second\"" : "",
			"id" => $id,
			"title" => $title,
			"link" => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $global_array_cat[$listcatid]['alias'] . "/" . $alias . "-" . $id,
		) );

		for( $i = 1; $i <= $num; $i++ )
		{
			$xtpl->assign( 'WEIGHT', array( "key" => $i, "title" => $i, "selected" => $i == $weight ? " selected=\"selected\"" : "" ) );
			$xtpl->parse( 'main.loop.weight' );
		}

		$xtpl->parse( 'main.loop' );
		$a ++;
	}
	
	$db->sql_freeresult();
	
	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );
	
	return $contents;
}

/**
 * FormatNumber()
 * 
 * @param mixed $number
 * @param integer $decimals
 * @param string $thousand_separator
 * @param string $decimal_point
 * @return
 */
function FormatNumber( $number, $decimals = 0, $thousand_separator = '&nbsp;', $decimal_point = '.' )
{
	$str = number_format( $number, 0, ',', '.' );
	return $str;
}

/**
 * drawselect_number()
 * 
 * @param string $select_name
 * @param integer $number_start
 * @param integer $number_end
 * @param integer $number_curent
 * @param string $func_onchange
 * @return
 */
function drawselect_number( $select_name = "", $number_start = 0, $number_end = 1, $number_curent = 0, $func_onchange = "" )
{
	$html = "<select name=\"" . $select_name . "\" onchange=\"" . $func_onchange . "\">";
	for( $i = $number_start; $i < $number_end; $i++ )
	{
		$select = ( $i == $number_curent ) ? "selected=\"selected\"" : "";
		$html .= "<option value=\"" . $i . "\"" . $select . ">" . $i . "</option>";
	}
	$html .= "</select>";
	return $html;
}

/**
 * nv_fix_group_count()
 * 
 * @param mixed $listid
 * @return
 */
function nv_fix_group_count( $listid )
{
	global $db, $module_name, $module_data, $db_config;
	
	$array_id = explode( ',', $listid );
	
	foreach( $array_id as $id )
	{
		if( ! empty( $id ) )
		{
			$sql = "SELECT COUNT(*) FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` WHERE ( `group_id`='" . $id . "' OR `group_id` REGEXP '^" . $id . "\\\,' OR `group_id` REGEXP '\\\," . $id . "\\\,' OR `group_id` REGEXP '\\\," . $id . "$' ) AND `status`=1 AND `publtime` <= " . NV_CURRENTTIME . " AND (`exptime`=0 OR `exptime` >=" . NV_CURRENTTIME . ")";
			$result = $db->sql_query( $sql );
			
			list( $num ) = $db->sql_fetchrow( $result );
			$db->sql_freeresult();
			
			$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_group` SET `numpro`=" . $num . " WHERE `groupid`=" . intval( $id );
			$db->sql_query( $sql );
			$db->sql_freeresult();
			
			unset( $result );
		}
	}
}
/**
 * GetCatidInChild()
 * 
 * @param mixed $catid
 * @return
 */
function GetCatidInChild( $catid )
{
	global $global_array_cat, $array_cat;
	$array_cat[] = $catid;
	if( $global_array_cat[$catid]['parentid'] > 0 )
	{
		$array_cat[] = $global_array_cat[$catid]['parentid'];
		$array_cat_temp = GetCatidInChild( $global_array_cat[$catid]['parentid'] );
		foreach( $array_cat_temp as $catid_i )
		{
			$array_cat[] = $catid_i;
		}
	}
	return array_unique( $array_cat );
}

?>