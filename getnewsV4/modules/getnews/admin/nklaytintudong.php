<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

global $db;
$sql="select idcm,tencm,tgbd,tglap,sotinmoi,auto from chuyenmuc";
$result=$db->sql_query($sql);
$rowcontent=array();

while(list($idcm,$tencm,$tgbd,$tglap,$sotinmoi,$auto)=$db->sql_fetchrow($result))
{
    $hd=$auto==0?$lang_module['noauto']:$lang_module['auto'];
    $admin_funcs = array();
    $admin_funcs[] = nv_link_edit_page1($idcm);
    $admin_funcs[] = nv_link_delete_page1($idcm);
    $tg1=nv_date("l, d/m/Y H:i", $tgbd);
    $interval=$tglap*60;$next_time="";
    if ($auto==0)
    {
        $next_time = "n/a";
    } else
    {
        if($tgbd<=NV_CURRENTTIME)
        {
            $next_time = nv_date("l, d/m/Y H:i", $tgbd + ceil((NV_CURRENTTIME - $tgbd) / $interval) * $interval);
        }
        else
        {
            $next_time = nv_date("l, d/m/Y H:i", $tgbd+$interval);
        }
    }
    $rowcontent[]=array("idcm" => $idcm, "tencm" => $tencm, "tgbd" => $tg1,
             "tgtt" => $next_time, "tglap" => $tglap, "sotinmoi" => $sotinmoi,"auto" => $hd,"chucnang"=>implode("&nbsp;-&nbsp;", $admin_funcs));
}
$array_list_action = array('delete' => $lang_global['delete'], 'publtime' => $lang_module['auto'],
    'exptime' => $lang_module['noauto']);
$action = array();
while (list($catid_i, $title_i) = each($array_list_action))
{
    $action[] = array("value" => $catid_i, "title" => $title_i);
}

$xtpl = new XTemplate("nktintudong.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);

foreach ($rowcontent as $row)
{
    $xtpl->assign('rowcontent', $row);
    $xtpl->parse('main.loop');
}

foreach ($action as $action1)
{
    $xtpl->assign('ACTION', $action1);
    $xtpl->parse('main.action');
}
//$xtpl->assign('rowcontent',$rowcontent);
$xtpl->parse( 'main' );

$page_title = $lang_module['config'];
$contents=$xtpl->text('main');
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>