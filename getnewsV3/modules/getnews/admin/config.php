<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Mon, 23 Jul 2012 02:56:18 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
if(defined('NV_EDITOR')){require_once(NV_ROOTDIR.'/'.NV_EDITORSDIR.'/'.NV_EDITOR.'/nv.php');}

$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);

$xoacm="<select name='delcm' id='delcm'>";
global $db;
$re=$db->sql_query("select id,tencm from chuyenmuc");
while(list($id,$ten)=$db->sql_fetchrow($re))
{
    $xoacm.="<option value='".$id."'>".$ten."</option>";
}
$xoacm.="</select>";
$xtpl->assign("xoachuyenmuc",$xoacm);
$xtpl->parse('main.sendLink');
$xtpl->parse( 'main' );

$page_title = $lang_module['config'];
$contents=$xtpl->text('main');
//$contents.=NV_BASE_SITEURL.$module_name."/admin/getcontent.php";
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );



?>