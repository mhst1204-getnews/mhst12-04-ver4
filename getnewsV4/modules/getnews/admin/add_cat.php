<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
global $db;
$id=$nv_Request->get_int('id','get',0);$thongbao="";
$tenchuyenmuc="";$link="";$isrss="";



if($id>0)
{
    $kq=$db->sql_query("select tencm,link,rss from chuyenmuc where idcm='".$id."'");
    list($tencm,$linkcm,$rss)=$db->sql_fetchrow($kq);
    $tenchuyenmuc='<input style="width: 200px" name="tencm" id="tencm" type="text" value="'.$tencm.'" maxlength="100" />';
    $tenchuyenmuc.='<input  style="width:500px;" name="linkcm" id="linkcm" type="text" value="'.$linkcm.'"/>';
    for($i=0;$i<2;$i++)
    {
        $z=$i==1?$lang_module['co']:$lang_module['khong'];
        $isrss.="<option value=\"" . $i . "\"" . (($i == $rss) ? " selected=\"selected\"" : "") . ">" . $z . "</option>\n";
    }
    $isrss.="<option value=\"3\">" .$lang_module['isrss'] . "</option>\n";
}
else
{
    $tenchuyenmuc='<input style="width: 200px" name="tencm" id="tencm" type="text" value="'.$lang_module["chuyenmuc"].'" maxlength="100" />';
    $tenchuyenmuc.='<input  style="width:500px;" name="linkcm" id="linkcm" type="text" value="'.$lang_module["linkchuyenmuc"].'"/>';
    for($i=0;$i<2;$i++)
    {
        $z=$i==1?$lang_module['co']:$lang_module['khong'];
        $isrss.="<option value=\"" . $i . "\">" . $z . "</option>\n";
    }
    $isrss.="<option value=\"3\" selected=\"selected\">" .$lang_module['isrss'] . "</option>\n";
    
    
}



$xtpl = new XTemplate( "add_cat.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
$xtpl->assign('tencm',$tenchuyenmuc);

$query="select distinct host from chuyenmuc";
$ket=$db->sql_query($query);$web="";
$che=$nv_Request->get_string('web','post','vnexpress.net');
while(list($website)=$db->sql_fetchrow($ket))
{
    $web.="<option value='".$website."'".($che==$website?"selected='selected'":'').">".$website."</option>";
}
$row=array();

$k=$db->sql_query("select * from chuyenmuc where host='".$che."'");
while(list($idcm1,$tencm1,$link1,$host1,$rss1)=$db->sql_fetchrow($k))
{
    $rs=$rss1==1?$lang_module['co']:$lang_module['khong'];
    $admin_funcs = array();
    $admin_funcs[] = suacm($idcm1);
    $admin_funcs[] = xoacm($idcm1);
    $row[]=array("id"=>$idcm1,"chuyenmuc"=>$tencm1,"linkchuyenmuc"=>$link1,"linksite"=>$host1,"isrss"=>$rs,"feature"=>implode("&nbsp;-&nbsp;", $admin_funcs));
    
}
foreach($row as $r)
{
    $xtpl->assign('ROW',$r);
    $xtpl->parse('main.quantri.loop');
}
$array_list_action = array('delete' => $lang_global['delete']);
$action = array();
while (list($catid_i, $title_i) = each($array_list_action))
{
    $action[] = array("value" => $catid_i, "title" => $title_i);
}
foreach ($action as $action1)
{
    $xtpl->assign('ACTION', $action1);
    $xtpl->parse('main.quantri.action');
}
$xtpl->assign("website",$web);

if($nv_Request->isset_request('check','post'))
{
    $tencm=$nv_Request ->get_string('tencm','post','');
    $link=$nv_Request ->get_string('linkcm','post','');
    $rss=$nv_Request->get_int('isrss','post',3);
    $temp=parse_url($link);
    $host=$temp['host'];
    if($tencm!='' && nv_is_url($link))
    {
        $resu=$db->sql_query("SELECT idcm from `chuyenmuc` where tencm=N'".$tencm."' and host='".$host."'");
        list($ma)=$db->sql_fetchrow($resu);
        if($ma<1)
        {
            $ma1=$db->sql_query_insert_id("INSERT INTO `chuyenmuc` values(NULL,'".$tencm."','".$link."','".$host."','".$rss."')");
            if($ma1<=0)
            {
                $thongbao=$lang_module['content_saveerror'];
            }
            else
            {
                $thongbao=$lang_module['content_saveok'];
            }
        }
        else
        {
            $db->sql_query("update chuyenmuc set tencm='".$tencm."',link='".$link."',host='".$host."',rss='".$rss."' where idcm='".$id."'");
            if ($db->sql_affectedrows() > 0)
            {
                $thongbao=$lang_module['content_saveok'];
            }
            else
            {
                $thongbao=$lang_module['content_saveerror'];
            }
        }
    }
    else
    {
        $thongbao=$lang_module['duongdansai'];
    }
    $xtpl->assign('thongbao',$thongbao);
    $xtpl->parse('main.alert');
}

$xtpl->assign('isrss',$isrss);

$xtpl->parse('main.quantri');
$xtpl->parse( 'main' );
$page_title = $lang_module['config'];
$contents=$xtpl->text('main');


include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>