<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Mon, 23 Jul 2012 02:56:18 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$submenu['main'] = $lang_module['main'];
$submenu['rss'] = $lang_module['rss'];
$submenu['add_news'] = $lang_module['addnews'];
$submenu['config'] = $lang_module['config'];
$submenu['test'] = $lang_module['test'];
$array_cat_admin = nv_array_cat_admin();
$is_refresh = false;
if (!empty($module_info['admins']))
{
    $module_admin = explode(",", $module_info['admins']);
    foreach ($module_admin as $userid_i)
    {
        if (!isset($array_cat_admin[$userid_i]))
        {
            $db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news_admins` (`userid`, `catid`, `admin`, `add_content`, `pub_content`, `edit_content`, `del_content`, `comment`) VALUES ('" .
                $userid_i . "', '0', '1', '1', '1', '1', '1', '1')");
            $is_refresh = true;
        }
    }
}
if ($is_refresh)
{
    $array_cat_admin = nv_array_cat_admin();
}
$admin_id = $admin_info['admin_id'];
if (defined('NV_IS_SPADMIN'))
{
    define('NV_IS_ADMIN_MODULE', true);
    define('NV_IS_ADMIN_FULL_MODULE', true);
}
else
{
    if (isset($array_cat_admin[$admin_id][0]))
    {
        define('NV_IS_ADMIN_MODULE', true);
        if (intval($array_cat_admin[$admin_id][0]['admin']) == 2)
        {
            define('NV_IS_ADMIN_FULL_MODULE', true);
        }
    }
}
$allow_func = array( 'main', 'config','getcontent','saveconfig','getarea','add_news','rss','getxml','savenews','test');
define('NV_IS_FILE_ADMIN', true);
require_once (NV_ROOTDIR . "/modules/" . $module_file . "/global.functions.php");
$global_array_cat = array();
$sql = "SELECT catid, parentid, title, titlesite, alias, lev, viewcat,numsubcat, subcatid, numlinks, description, inhome, keywords, who_view, groups_view FROM `" .
    NV_PREFIXLANG . "_news_cat` ORDER BY `order` ASC";
$result = $db->sql_query($sql);
while (list($catid_i, $parentid_i, $title_i, $titlesite_i, $alias_i, $lev_i, $viewcat_i,
    $numsubcat_i, $subcatid_i, $numlinks_i, $description_i, $inhome_i, $keywords_i,
    $who_view_i, $groups_view_i) = $db->sql_fetchrow($result))
    {
        $global_array_cat[$catid_i] = array("catid" => $catid_i, "parentid" => $parentid_i,
            "title" => $title_i, "titlesite" => $titlesite_i, "alias" => $alias_i,
            "numsubcat" => $numsubcat_i, "lev" => $lev_i, "viewcat" => $viewcat_i,
            "subcatid" => $subcatid_i, "numlinks" => $numlinks_i, "description" => $description_i,
            "inhome" => $inhome_i, "keywords" => $keywords_i, "who_view" => $who_view_i,
            "groups_view" => $groups_view_i);
    }
    
function nv_array_cat_admin()
{
    global $db, $module_data;
    $array_cat_admin = array();
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_news_admins` ORDER BY `userid` ASC";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result))
    {
        $array_cat_admin[$row['userid']][$row['catid']] = $row;
    }
    return $array_cat_admin;
}

function redriect($msg1 = "", $msg2 = "", $nv_redirect)
{
    if (empty($nv_redirect))
    {
        $nv_redirect = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name;
    }
    $contents = "<table><tr><td>";
    $contents .= "<div align=\"center\">";
    $contents .= "<strong>" . $msg1 . "</strong><br /><br />\n";
    $contents .= "<img border=\"0\" src=\"" . NV_BASE_SITEURL . "images/load_bar.gif\" /><br /><br />\n";
    $contents .= "<strong><a href=\"" . $nv_redirect . "\">" . $msg2 .
        "</a></strong>";
    $contents .= "</div>";
    $contents .= "</td></tr></table>";
    $contents .= "<meta http-equiv=\"refresh\" content=\"2;url=" . $nv_redirect . "\" />";
    include (NV_ROOTDIR . "/includes/header.php");
    echo nv_admin_theme($contents);
    include (NV_ROOTDIR . "/includes/footer.php");
    exit();
}
define( 'NV_IS_FILE_ADMIN', true );

?>