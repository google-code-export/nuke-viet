<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-9-2010 14:43
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$page_title = $lang_module['topics'];

$error = "";
$savecat = 0;

$array = array();
$array['topicid'] = 0;
$array['title'] = "";
$array['alias'] = "";
$array['description'] = "";
$array['keywords'] = "";

$savecat = $nv_Request->get_int( 'savecat', 'post', 0 );
if ( ! empty( $savecat ) )
{
    $array['topicid'] = $nv_Request->get_int( 'topicid', 'post', 0 );
    $array['title'] = filter_text_input( 'title', 'post', '', 1 );
    $array['keywords'] = filter_text_input( 'keywords', 'post', '', 1 );
    $array['alias'] = filter_text_input( 'alias', 'post', '' );
    $array['description'] = $nv_Request->get_string( 'description', 'post', '' );

    $array['description'] = strip_tags( $array['description'] );
    $array['description'] = nv_nl2br( nv_htmlspecialchars( $array['description'] ), '<br />' );
	
    $array['alias'] = ( $array['alias'] == "" ) ? change_alias( $array['title'] ) : change_alias( $array['alias'] );
	
	if ( empty ( $array['title'] ) )
	{
		$error = $lang_module['topics_error_title'];
	}
    elseif ( $array['topicid'] == 0 )
    {
        list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT max(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_topics`" ) );
        $weight = intval( $weight ) + 1;
		
        $query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_topics` (`topicid`, `title`, `alias`, `description`, `image`, `thumbnail`, `weight`, `keywords`, `add_time`, `edit_time`) VALUES (NULL, " . $db->dbescape( $array['title'] ) . ", " . $db->dbescape( $array['alias'] ) . ", " . $db->dbescape( $array['description'] ) . ", '', '', " . $db->dbescape( $weight ) . ", " . $db->dbescape( $array['keywords'] ) . ", UNIX_TIMESTAMP( ), UNIX_TIMESTAMP( ))";
		
        if ( $db->sql_query_insert_id( $query ) )
        {
            nv_insert_logs( NV_LANG_DATA, $module_name, 'log_add_topic', " ", $admin_info['userid'] );
            $db->sql_freeresult();
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "" );
            die();
        }
        else
        {
            $error = $lang_module['errorsave'];
        }
    }
    else
    {
        $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_topics` SET `title`=" . $db->dbescape( $array['title'] ) . ", `alias` =  " . $db->dbescape( $array['alias'] ) . ", `description`=" . $db->dbescape( $array['description'] ) . ", `keywords`= " . $db->dbescape( $array['keywords'] ) . ", `edit_time`=UNIX_TIMESTAMP( ) WHERE `topicid` =" . $array['topicid'] . "";
        $db->sql_query( $query );
        if ( $db->sql_affectedrows() > 0 )
        {
            nv_insert_logs( NV_LANG_DATA, $module_name, 'log_edit_topic', "topicid " . $array['topicid'], $admin_info['userid'] );
            $db->sql_freeresult();
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "" );
            die();
        }
        else
        {
            $error = $lang_module['errorsave'];
        }
        $db->sql_freeresult();
    }
}

$array['topicid'] = $nv_Request->get_int( 'topicid', 'get', 0 );
if ( $array['topicid'] > 0 )
{
    list( $array['topicid'], $array['title'], $array['alias'], $array['description'], $array['keywords'] ) = $db->sql_fetchrow( $db->sql_query( "SELECT `topicid`, `title`, `alias`, `description`, `keywords`  FROM `" . NV_PREFIXLANG . "_" . $module_data . "_topics` where `topicid`=" . $array['topicid'] . "" ) );
    $lang_module['add_topic'] = $lang_module['edit_topic'];
}

$xtpl = new XTemplate( "topics.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

$xtpl->assign( 'DATA', $array );
$xtpl->assign( 'TOPIC_LIST', nv_show_topics_list() );

if ( ! empty( $error ) )
{
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'main.error' );
}

if ( empty( $array['alias'] ) )
{
    $xtpl->parse( 'main.getalias' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>