<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Mon, 23 Jul 2012 02:56:18 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
if(defined('NV_EDITOR')){require_once(NV_ROOTDIR.'/'.NV_EDITORSDIR.'/'.NV_EDITOR.'/nv.php');}
global $db;
$ma=$nv_Request->get_int('id', 'get', 0);
$tenchuyenmuc="";
$linkchuyenmuc="";
$tudonglay="";
$tang="";
$giam="";
$button="";
if($ma!=0)
{
    $kq=$db->sql_query("select tencm,auto,chnho,chlon from chuyenmuc where idcm='".$ma."'");
    list($tencm,$auto,$chnho,$chlon)=$db->sql_fetchrow($kq);
    $tenchuyenmuc='<input style="width: 200px" name="tencm" id="tencm" type="text" value="'.$tencm.'" maxlength="100" />';
    for($i=0;$i<2;$i++)
    {
        $z=$i==1?$lang_module['co']:$lang_module['khong'];
        $tudonglay.="<option value=\"" . $i . "\"" . (($i == $auto) ? " selected=\"selected\"" : "") . ">" . $z . "</option>\n";
    }
    for($i=1;$i<=2;$i++)
    {
        $giam.="<option value='".($i*5)."' ".(($i*5)==$chnho? "selected='selected'":"").">".($i*5).$lang_module['phut']."</option>";
    }
    for($i=1;$i<=2;$i++)
    {
        $tang.="<option value='".($i*5)."' ".(($i*5)==$chlon? "selected='selected'":"").">".($i*5).$lang_module['phut']."</option>";
    }
    
    $kq=$db->sql_query("select link from tinchuyenmuc where idcm='".$ma."'");
    while(list($link)=$db->sql_fetchrow($kq))
    {
        $linkchuyenmuc.=$link.",";
    }
    $tenchuyenmuc.='<input  style="width:500px;" name="linkcm" id="linkcm" type="text" value="'.$linkchuyenmuc.'"/>';
    $button='<td colspan="3" align="center"><input name="sua" type="submit" id="taocm" value="'.$lang_module['suacm'].'" />
    <input type="hidden" name="id" value="'.$ma.'">
    </td>';
}

else
{
    $tenchuyenmuc='<input style="width: 200px" name="tencm" id="tencm" type="text" value="'.$lang_module["chuyenmuc"].'" onclick="if(this.value=="'.$lang_module["chuyenmuc"].'"){this.value="";}" maxlength="100" />';
    $tenchuyenmuc.='<input  style="width:500px;" name="linkcm" id="linkcm" type="text" value="'.$lang_module["linkchuyenmuc"].'" onclick="if(this.value=="'.$lang_module["linkchuyenmuc"].'"){this.value="";}"/>';
    for($i=0;$i<2;$i++)
    {
        $z=$i==1?$lang_module['co']:$lang_module['khong'];
        $tudonglay.="<option value=\"" . $i . "\"" . (($i == 1) ? " selected=\"selected\"" : "") . ">" . $z . "</option>\n";
    }
    for($i=1;$i<=2;$i++)
    {
        $giam.="<option value='".($i*5)."'".(($i*5)==5? "selected='selected'":"").">".($i*5).$lang_module['phut']."</option>";
    }
    for($i=1;$i<=2;$i++)
    {
        $tang.="<option value='".($i*5)."'".(($i*5)==5? "selected='selected'":"").">".($i*5).$lang_module['phut']."</option>";
    }
    $button='<td colspan="3" align="center"><input name="tao" type="submit" id="taocm" value="'.$lang_module['themcm'].'" /></td>';
}

$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);

$xtpl->assign('tencm',$tenchuyenmuc);
$xtpl->assign('tudong',$tudonglay);
$xtpl->assign('giam',$giam);
$xtpl->assign('tang',$tang);
$xtpl->assign('nut',$button);
$xtpl->parse('main.sendLink');
$xtpl->parse( 'main' );

$page_title = $lang_module['config'];
$contents=$xtpl->text('main');
//$contents.=NV_BASE_SITEURL.$module_name."/admin/getcontent.php";
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );



?>