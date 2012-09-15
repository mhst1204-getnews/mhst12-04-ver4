<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Loc_Noi_Dung.php");
$ketqua="";
$trangtin=$nv_Request->get_string('linktrangtin','post','');$kq="";
if(nv_is_url($trangtin))
{
    $noidung=$nv_Request->get_string('noidungtd','post','',1);
    $noidung=change_alias($noidung);
    $mota=$nv_Request->get_string('noidungmt','post','');
    if($noidung!='' && $mota!='')
    {
        $ketqua=GetContentArtice::main($trangtin,$noidung,$mota);
        if(count($ketqua)==3)
        {
            $temp=parse_url($trangtin);
            $host=$temp['host'];
            global $db;
            $sql="select id from article_path where host='".$host."'";
            $resu=$db->sql_query($sql);
            list($id1)=$db->sql_fetchrow($resu);$kq=$id1;
            if($id1>0)
            {
                $del="delete from article_path where id='".$id1."'";
                $db->sql_query($del);
                $sql="insert into article_path values(NULL,'".$host."','".$ketqua[0]."','".$ketqua[1]."','".$ketqua[2]."')";
                $id=$db->sql_query_insert_id($sql);
                if($id>0)
                {
                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=config";
                    $msg1 = $lang_module['content_saveok'];
                    $msg2 = $lang_module['quaylaitruoc'];
                    redriect($msg1, $msg2, $url);
                }
                else
                {
                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=config";
                    $msg1 = $lang_module['content_saveerror'];
                    $msg2 = $lang_module['quaylaitruoc'];
                    redriect($msg1, $msg2, $url);
                }
            }
            else
            {
                $sql="insert into article_path values(NULL,'".$host."','".$ketqua[0]."','".$ketqua[1]."','".$ketqua[2]."')";
                $id=$db->sql_query_insert_id($sql);
                if($id>0)
                {
                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=config";
                    $msg1 = $lang_module['content_saveok'];
                    $msg2 = $lang_module['quaylaitruoc'];
                    redriect($msg1, $msg2, $url);
                }
                else
                {
                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=config";
                    $msg1 = $lang_module['content_saveerror'];
                    $msg2 = $lang_module['quaylaitruoc'];
                    redriect($msg1, $msg2, $url);
                }
            }
        }
        else
        {
            $url = "javascript: history.go(-1)";
            $msg1 = implode("<br />", $error);
            $msg2 = $lang_module['content_back'];
            redriect($msg1, $msg2, $url);
        }
    }
}
$xtpl = new XTemplate( "article.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
$xtpl->assign('noidung',$kq);
$xtpl->parse( 'main' );
$page_title = $lang_module['config'];
$contents=$xtpl->text('main');
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $kq );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>