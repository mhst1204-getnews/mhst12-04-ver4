<?php

/**
 * @author CUONG
 * @copyright 2012
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
global $db;$kq="";
if($nv_Request->isset_request('tao','post'))
{
    $tencm=$nv_Request ->get_string('tencm','post','');
    $link=$nv_Request ->get_string('linkcm','post','');
    $rss=$nv_Request->get_int('isrss','post',1);
    if($tencm!='' && $linkcm!='')
    {
        $table=change_alias($tencm);$table=str_replace('-','',$table);
        $resu=$db->sql_query("SELECT idcm from `chuyenmuc` where tencm=N'".$tencm."'");
        list($ma)=$db->sql_fetchrow($resu);
        if($ma<1)
        {
            $ma=$db->sql_query_insert_id("INSERT INTO `chuyenmuc` values(NULL,'".$tencm."','0','15','0','".$nho."','".$lon."','".$auto."')");
        }
        $arrLink=split(",",$linkcm);
        $error=array();
        for($i=0;$i<count($arrLink);$i++)
        {
            if($arrLink[$i]!="")
            {
                $a=$db->sql_query_insert_id("insert into tinchuyenmuc values(NULL,'".$ma."','".$arrLink[$i]."','')");
                if($a<1)
                {
                    $error[]=$lang_module['content_saveerror'];
                }
            }
        }
    }
    
    if(!empty($error))
    {
        $url = "javascript: history.go(-1)";
        $msg1 = implode("<br />", $error);
        $msg2 = $lang_module['content_back'];
        redriect($msg1, $msg2, $url);
    }
    else
    {
        $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=".$module_name."&".NV_OP_VARIABLE."=config";
        $msg1 = $lang_module['content_saveok'];
        $msg2 = $lang_module['content_main'] . " " . $module_info['custom_title'];
        redriect($msg1, $msg2, $url);
    }
}
if($nv_Request->isset_request('sua','post'))
{
    $ma=$nv_Request->get_int('id','post',0);
    if($ma>0)
    {
        $ten=$nv_Request->get_string('tencm','post','');
        $link=$nv_Request->get_string('linkcm','post','');
        $tudong=$nv_Request->get_int('tudctg','post');
        $lon=$nv_Request->get_int('lon','post');
        $nho=$nv_Request->get_int('nho','post');
        $sql="update chuyenmuc set tencm=N'".$ten."',chnho='".$nho."',chlon='".$lon."',auto='".$tudong."' where idcm='".$ma."'";
        $db->sql_query($sql);
        if($db->sql_affectedrows() < 0){$error[]=$lang_module['content_saveerror'];}
        $db->sql_query("delete from tinchuyenmuc where idcm='".$ma."'");
        $arrLink=split(",",$link);
        $error=array();
        for($i=0;$i<count($arrLink);$i++)
        {
            if($arrLink[$i]!="")
            {
                $a=$db->sql_query_insert_id("insert into tinchuyenmuc values(NULL,'".$ma."','".$arrLink[$i]."','')");
                if($a<1)
                {
                    $error[]=$lang_module['content_saveerror'];
                }
            }
        }
        if (empty($error))
        {
            $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=".$module_name."&".NV_OP_VARIABLE."=config";
            $msg1 = $lang_module['content_saveok'];
            $msg2 = $lang_module['content_main'] . " " . $module_info['custom_title'];
            redriect($msg1, $msg2, $url);
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
if($nv_Request->isset_request('xoa','post'))
{
    $maid=$nv_Request->get_int('xoacm','post',0);
    if($maid>0)
    {
        $db->sql_query("delete from chuyenmuc where id='".$maid."'");
        $db->sql_freeresult();
    }
}
include (NV_ROOTDIR . "/includes/header.php");
echo $contents;
include (NV_ROOTDIR . "/includes/footer.php");
?>