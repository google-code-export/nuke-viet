<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 31/05/2010, 00:36
 */

define('NV_SYSTEM', true);

require (str_replace(DIRECTORY_SEPARATOR, '/', dirname(__file__)) . '/mainfile.php');
require (NV_ROOTDIR . "/includes/core/user_functions.php");

//Google Sitemap
if ($nv_Request->isset_request(NV_NAME_VARIABLE, 'get') and $nv_Request->get_string(NV_NAME_VARIABLE, 'get') == "SitemapIndex")
{
    nv_xmlSitemapIndex_generate();
    die();
}

//Check user
if (defined('NV_IS_USER'))
    trigger_error('Hacking attempt', 256);
require (NV_ROOTDIR . "/includes/core/is_user.php");

//Cap nhat trang thai online
if ($global_config['online_upd'] and !defined('NV_IS_AJAX') and !defined('NV_IS_MY_USER_AGENT'))
{
    require (NV_ROOTDIR . "/includes/core/online.php");
}

//Thong ke
if ($global_config['statistic'] and !defined('NV_IS_AJAX') and !defined('NV_IS_MY_USER_AGENT'))
{
    if (!$nv_Request->isset_request('statistic_' . NV_LANG_DATA, 'session'))
    {
        require (NV_ROOTDIR . "/includes/core/stat.php");
    }
}

//Referer + Gqueries
if ($client_info['is_myreferer'] === 0 and !defined('NV_IS_MY_USER_AGENT'))
{
    require (NV_ROOTDIR . "/includes/core/referer.php");
}

if (!isset($global_config['site_home_module']) or empty($global_config['site_home_module']))
    $global_config['site_home_module'] = "news";

if ($nv_Request->isset_request(NV_NAME_VARIABLE, 'get') || $nv_Request->isset_request(NV_NAME_VARIABLE, 'post'))
{
    $home = 0;
    $module_name = $nv_Request->get_string(NV_NAME_VARIABLE, 'post,get');
}
else
{
    $home = 1;
    $module_name = $global_config['site_home_module'];
}

if (preg_match($global_config['check_module'], $module_name))
{
    $site_mods = nv_site_mods();
    //IMG thong ke truy cap + online
    if ($global_config['statistic'] and isset($site_mods['statistics']) and $nv_Request->get_string('second', 'get') == "statimg")
    {
        include_once (NV_ROOTDIR . "/includes/core/statimg.php");
    }
    if (isset($site_mods[$module_name]))
    {
        $module_info = $site_mods[$module_name];
        $module_file = $module_info['module_file'];
        $module_data = $module_info['module_data'];
        $include_file = NV_ROOTDIR . "/modules/" . $module_file . "/funcs/main.php";
        if (file_exists($include_file) and filesize($include_file) != 0)
        {
            $array_op = array();
            $op = $nv_Request->get_string( NV_OP_VARIABLE, 'post,get', 'main' );
            if ( empty( $op ) ) $op = "main";

            if ( ! preg_match( "/^[a-z0-9\-\_\/]+$/i", $op ) )
            {
                Header( "Location: " . nv_url_rewrite( NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name, true ) );
                die();
            }

            if ( $op != "main" and ! isset( $module_info['funcs'][$op] ) )
            {
                $array_op = explode( "/", $op );
                $op = ( isset( $module_info['funcs'][$array_op[0]] ) ) ? $array_op[0] : 'main';
            }

            //Xac dinh quyen dieu hanh module
            if ($module_info['is_modadmin'])
            {
                define('NV_IS_MODADMIN', true);
            }
            if (defined('NV_IS_SPADMIN'))
            {
                $drag_block = $nv_Request->get_int('drag_block', 'session', 0);
                if ($nv_Request->isset_request('drag_block', 'get'))
                {
                    $drag_block = $nv_Request->get_int('drag_block', 'get', 0);
                    $nv_Request->set_Session('drag_block', $drag_block);
                }
                if ($drag_block)
                {
                    define('NV_IS_DRAG_BLOCK', true);
                    $adm_data_lang = $nv_Request->get_string('data_lang', 'cookie');
                    if ($adm_data_lang != NV_LANG_DATA)
                    {
                        $nv_Request->set_Cookie('int_lang', NV_LANG_DATA, NV_LIVE_COOKIE_TIME);
                        $nv_Request->set_Cookie('data_lang', NV_LANG_DATA, NV_LIVE_COOKIE_TIME);
                    }
                }
            }

            //Ket noi ngon ngu cua module
            if (file_exists(NV_ROOTDIR . "/modules/" . $module_file . "/language/" . NV_LANG_INTERFACE . ".php"))
            {
                require (NV_ROOTDIR . "/modules/" . $module_file . "/language/" . NV_LANG_INTERFACE . ".php");
            }
            elseif (file_exists(NV_ROOTDIR . "/modules/" . $module_file . "/language/en.php"))
            {
                require (NV_ROOTDIR . "/modules/" . $module_file . "/language/en.php");
            }

            //Ket noi giao dien chung
            $is_mobile = false;
            if (!empty($client_info['is_mobile']) and !empty($module_info['mobile']) and file_exists(NV_ROOTDIR . "/themes/" . $module_info['mobile'] . "/theme.php"))
            {
                $global_config['module_theme'] = $module_info['mobile'];
                $is_mobile = true;
            }
            elseif (!empty($module_info['theme']) and file_exists(NV_ROOTDIR . "/themes/" . $module_info['theme'] . "/theme.php"))
            {
                $global_config['module_theme'] = $module_info['theme'];
            }
            elseif (!empty($global_config['site_theme']) and file_exists(NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/theme.php"))
            {
                $global_config['module_theme'] = $global_config['site_theme'];
            }
            elseif (file_exists(NV_ROOTDIR . "/themes/default/theme.php"))
            {
                $global_config['module_theme'] = "default";
            }
            else
            {
                trigger_error("Error!  Does not exist themes default", 256);
            }

            //Xac dinh layout funcs cua module
            $sql = "SELECT f.func_name, t.layout FROM `" . NV_MODFUNCS_TABLE . "` AS f INNER JOIN `" . NV_PREFIXLANG . "_modthemes` AS t ON f.func_id=t.func_id WHERE f.in_module = '" . $module_name . "' AND t.theme='" . $global_config['module_theme'] . "'";
            $cache_file = NV_LANG_DATA . "_modules_" . md5($sql) . "_" . NV_CACHE_PREFIX . ".cache";
            if (($cache = nv_get_cache($cache_file)) != false)
            {
                $module_info['layout_funcs'] = unserialize($cache);
            }
            else
            {
                $module_info['layout_funcs'] = array();
                $result = $db->sql_query($sql);
                while ($row = $db->sql_fetch_assoc($result))
                {
                    $module_info['layout_funcs'][$row['func_name']] = $row['layout'];
                }
                $db->sql_freeresult($result);
                $cache = serialize($module_info['layout_funcs']);
                nv_set_cache($cache_file, $cache);
            }
            require (NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/theme.php");

            //ket noi ngon ngu theo theme
            if (file_exists(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/language/" . NV_LANG_INTERFACE . ".php"))
            {
                require (NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/language/" . NV_LANG_INTERFACE . ".php");
            }
            elseif (file_exists(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/language/en.php"))
            {
                require (NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/language/en.php");
            }

            //Ket noi voi file functions.php, file chua cac function dung chung cho ca module
            if (file_exists(NV_ROOTDIR . "/modules/" . $module_file . "/functions.php"))
            {
                require (NV_ROOTDIR . "/modules/" . $module_file . "/functions.php");
            }

            //Xac dinh template module
            $module_info['template'] = $global_config['module_theme'];
            if (!file_exists(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file))
            {
                if (file_exists(NV_ROOTDIR . "/themes/default/modules/" . $module_file))
                {
                    $module_info['template'] = "default";
                }
            }

            if (file_exists(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file . "/theme.php"))
            {
                require (NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file . "/theme.php");
            }
            elseif (file_exists(NV_ROOTDIR . "/modules/" . $module_file . "/theme.php"))
            {
                require (NV_ROOTDIR . "/modules/" . $module_file . "/theme.php");
            }

            if (!defined('NV_IS_AJAX'))
            {
                if ($module_info['submenu'])
                    nv_create_submenu();
            }

            //Ket noi voi cac op cua module de thuc hien
            if ($is_mobile and file_exists(NV_ROOTDIR . "/modules/" . $module_file . "/mobile/" . $op . ".php"))
            {
                require (NV_ROOTDIR . "/modules/" . $module_file . "/mobile/" . $op . ".php");
            }
            else
            {
                require (NV_ROOTDIR . "/modules/" . $module_file . "/funcs/" . $op . ".php");
            }
            exit();
        }
        elseif (isset($module_info['funcs']['main']))
        {
            $db->sql_query("UPDATE `" . NV_MODULES_TABLE . "` SET `act`=2 WHERE `title`=" . $db->dbescape($module_name));
            nv_del_moduleCache('modules');
        }
    }
    else
    {
        $sql = "SELECT * FROM `" . NV_MODFUNCS_TABLE . "` AS f, `" . NV_MODULES_TABLE . "` AS m WHERE m.act = 1 AND f.in_module = m.title ORDER BY m.weight, f.subweight";
        $list = nv_db_cache($sql, '', 'modules');
        foreach ($list as $row)
        {
            if ($row['title'] == $module_name)
            {
                $groups_view = ( string )$row['groups_view'];
                if (!defined('NV_IS_USER') and $groups_view == 1)
                {
                    // login users
                    Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode($client_info['selfurl']));
                    die();
                }
                else
                if (!defined('NV_IS_ADMIN') and $groups_view == "2")
                {
                    // login admin
                    nv_info_die($lang_global['error_404_title'], $lang_global['site_info'], $lang_global['module_for_admin']);
                    //$nv_Request->set_Session( 'admin_login_redirect', $client_info['selfurl'] );
                    //Header( "Location: " . NV_BASE_SITEURL . NV_ADMINDIR );
                    die();
                }
                break;
            }
        }
    }
}

nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
?>