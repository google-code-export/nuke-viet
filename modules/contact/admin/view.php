<?php

/**
 * @Project NUKEVIET CMS 3.0
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (@) 2010 VINADES. All rights reserved
 * @Createdate 2-9-2010 14:43
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$id = $nv_Request->get_int( 'id', 'get', 0 );

if ( ! $id )
{
    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );
    die();
}

$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_send` WHERE `id`=" . $id;
$result = $db->sql_query( $sql );
$numrows = $db->sql_numrows( $result );

if ( $numrows != 1 )
{
    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );
    die();
}

$row = $db->sql_fetchrow( $result );

$contact_allowed = nv_getAllowed();

if ( ! isset( $contact_allowed['view'][$row['cid']] ) )
{
    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );
    die();
}

$is_read = intval( $row['is_read'] );
if ( ! $is_read )
{
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_send` SET `is_read`=1 WHERE `id`=" . $id;
    $result = $db->sql_query( $sql );
    $is_read = 1;
}

$page_title = $module_info['custom_title'];

$contents = "";

$contents .= "<table summary=\"\" class=\"tab1\">\n";
$contents .= "<caption>" . $row['title'] . "<caption>\n";
$contents .= "<col width=\"150px\" />\n";

$contents .= "<tbody>\n";
$contents .= "<tr>\n";
$contents .= "<td style=\"vertical-align:top;\">" . $lang_module['infor_user_send_title'] . "</td>\n";

$sender_name = $row['sender_name'];
$sender_id = intval( $row['sender_id'] );
if ( $sender_id )
{
    $sender_name = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=users&amp;" . NV_OP_VARIABLE . "=edit&amp;userid=" . $sender_id . "\">" . $sender_name . "</a>";
}
$contents .= "<td>" . $sender_name . " &lt;" . $row['sender_email'] . "&gt;<br />\n";
if ( ! empty( $row['sender_phone'] ) )
{
    $contents .= $lang_global['phonenumber'] . ": " . $row['sender_phone'] . "<br />\n";
}
$contents .= "IP: " . $row['sender_ip'] . "<br />\n";
$contents .= nv_date( "H:i d/m/Y", $row['send_time'] ) . "</td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";

$contents .= "<tbody class=\"second\">\n";
$contents .= "<tr>\n";
$contents .= "<td>" . $lang_module['part_row_title'] . "</td>\n";

$part_row_title = $contact_allowed['view'][$row['cid']];
$part_row_title = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=row&amp;id=" . $row['cid'] . "\">" . $part_row_title . "</a>";

$contents .= "<td>" . $part_row_title . "</td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";

$contents .= "<tbody>\n";
$contents .= "<tr>\n";
$contents .= "<td colspan=\"2\">\n";
$contents .= "<div style=\"padding:5px; margin:5px;\">\n";
$contents .= $row['content'] . "</div></td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";
$contents .= "</table>\n";

$contents .= "<br />\n";
$contents .= "<div style=\"margin-top:8px;margin-bottom:8px;\">\n";
$contents .= "<div style=\"position:absolute;right:10px;\">\n";
if ( isset( $contact_allowed['reply'][$row['cid']] ) )
{
    $contents .= "<a class=\"button1\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=reply&amp;id=" . $row['id'] . "\">\n";
    $contents .= "<span><span>" . $lang_module['send_title'] . "</span></span></a>\n";
}
$contents .= "<a class=\"button1\" href=\"javascript:void(0);\" onclick=\"nv_del_mess(" . $row['id'] . ");\">\n";
$contents .= "<span><span>" . $lang_global['delete'] . "</span></span></a>\n";
$contents .= "<a class=\"button1\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "\">\n";
$contents .= "<span><span>" . $lang_module['back_title'] . "</span></span></a>\n";
$contents .= "</div>\n";
$contents .= "</div>\n";
$contents .= "<br />\n";

if ( $row['is_reply'] and ! empty( $row['reply_content'] ) )
{
    $sql = "SELECT t2.username as admin_login, t2.email as admin_email, t2.full_name as admin_fullname FROM 
`" . NV_AUTHORS_GLOBALTABLE . "` AS t1 INNER JOIN  `" . NV_USERS_GLOBALTABLE . "` AS t2 ON t1.admin_id  = t2.userid WHERE t1.admin_id=" . intval( $row['reply_aid'] );
    $result = $db->sql_query( $sql );
    $adm_row = $db->sql_fetchrow( $result );
    $contents .= "<table summary=\"\" class=\"tab1\">\n";
    $contents .= "<caption>Re: " . $row['title'] . "<caption>\n";
    $contents .= "<col width=\"150px\" />\n";
    $contents .= "<tbody>\n";
    $contents .= "<tr>\n";
    $contents .= "<td style=\"vertical-align:top;\">" . $lang_module['infor_user_send_title'] . "</td>\n";

    $reply_name = $adm_row['admin_fullname'];
    if ( empty( $reply_name ) )
    {
        $reply_name = $adm_row['admin_login'];
    }
    $reply_name = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=authors&amp;id=" . intval( $row['reply_aid'] ) . "\">" . $reply_name . "</a>";
    $contents .= "<td>" . $reply_name . " &lt;" . $adm_row['admin_email'] . "&gt;<br />\n";
    $contents .= nv_date( "H:i d/m/Y", $row['reply_time'] ) . "</td>\n";
    $contents .= "</tr>\n";
    $contents .= "</tbody>\n";

    $contents .= "<tbody class=\"second\">\n";
    $contents .= "<tr>\n";
    $contents .= "<td>" . $lang_module['reply_user_send_title'] . "</td>\n";
    $contents .= "<td>" . $sender_name . " &lt;" . $row['sender_email'] . "&gt;</td>\n";
    $contents .= "</tr>\n";
    $contents .= "</tbody>\n";

    $contents .= "<tbody>\n";
    $contents .= "<tr>\n";
    $contents .= "<td colspan=\"2\">\n";
    $contents .= "<div style=\"padding:5px; margin:5px;\">\n";
    $contents .= $row['reply_content'] . "</div></td>\n";
    $contents .= "</tr>\n";
    $contents .= "</tbody>\n";
    $contents .= "</table>\n";
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>