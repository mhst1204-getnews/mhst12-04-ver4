<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Mon, 23 Jul 2012 02:56:18 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
if(defined('NV_EDITOR')){require_once(NV_ROOTDIR.'/'.NV_EDITORSDIR.'/'.NV_EDITOR.'/nv.php');}
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Loc_Noi_Dung.php");
//include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/ThaoTac_DB.php");
$data=array();
$linksite="";
$content="";
$action="";
if($nv_Request->isset_request('lay','post'))
{
    $link=$_POST["link_article"];
    if($link!="" && $link!=null && nv_is_url ( $link ))
    {
        $XpathFull=GetContent::main($link);
        if(!is_null($XpathFull))
        {
            $linksite=$link;
            $data=$XpathFull;
            $content=$XpathFull['noidung'];
        }
        else
        {
            $contents="Fail";
        }
        $action.='<input name="saveConfig" id="saveConfig" type="button" value="'.$lang_module["saveconfig"].'" />';
        $action.='<input name="redirect" type="submit" value="'.$lang_module["redirect"].'" />';
        $action.='<input name="exit" type="button" value="'.$lang_module["exitconfig"].'" onclick="javascript:history.go(-1)" />';
    }
}


$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('site',$linksite);
$xtpl->assign('DATA',$data);
$xtpl->assign('action',$action);
if(defined('NV_EDITOR')and nv_function_exists('nv_aleditor'))
{
    $edits = nv_aleditor( 'bodytext', '100%', '300px',$content);
}
else
{
    $edits="<textarea style=\"width: 100%\" name=\"bodytext\" id=\"bodyhtml\" cols=\"20\" rows=\"15\"></textarea>";
}
$xtpl->parse('main.site');
$xtpl->assign('edit_bodytext',$edits);
$xtpl->parse( 'main' );
$page_title = $lang_module['config'];
$contents=$xtpl->text('main');

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>