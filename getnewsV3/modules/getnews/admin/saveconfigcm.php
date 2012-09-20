<?php

/**
 * @author CUONG
 * @copyright 2012
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$tencm=$nv_Request ->get_string('tencm','post','');
$linkcm=$nv_Request ->get_string('linkcm','post','');
global $db;$kq="";
if($nv_Request->isset_request('tao','post'))
{
    if($tencm!='' && $linkcm!='')
    {
        $table=change_alias($tencm);$table=str_replace('-','',$table);
        $resu=$db->sql_query("SELECT id from `chuyenmuc` where tencm=N'".$tencm."'");
        list($ma)=$db->sql_fetchrow($resu);
        if($ma<1)
        {
            $db->sql_query("INSERT INTO `chuyenmuc` values(NULL,'".$tencm."')");
            $resu=$db->sql_query("SELECT id from `chuyenmuc` where tencm=N'".$tencm."'");
            list($ma)=$db->sql_fetchrow($resu);
        }
        $db->sql_query("CREATE TABLE IF NOT EXISTS `auto_".$table."` (`id` int(11) unsigned NOT NULL auto_increment,`macm` varchar(255) NOT NULL,`link` varchar(255) NOT NULL,`host` varchar(100) NOT NULL,PRIMARY KEY  (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $arrLink=split(",",$linkcm);
        $error=array();$check=false;
        for($i=0;$i<count($arrLink);$i++)
        {
            if($arrLink[$i]!="")
            {
                $temp=parse_url($arrLink[$i]);
                $host=$temp['host'];
                
                $host1=str_replace('.','',$host);
                if(!($db->sql_query("select * from auto_".$host1)))
                {
                    $db->sql_query('CREATE TABLE IF NOT EXISTS `auto_"'.$host1.'"` (`id` int(10) NOT NULL auto_increment,`idcm` int(10) NOT NULL,`link` varchar(100) NOT NULL,PRIMARY KEY  (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;');
                }
                
                $query="INSERT INTO `auto_".$table."` values(NULL,'".$ma."','".$arrLink[$i]."','".$host."')";
                $id=$db->sql_query_insert_id($query);
                if($id==0)
                {
                    $error[]=$lang_module['content_saveerror']."'".$arrLink[$i]."'";
                }
                else
                {
                    $db->sql_query('insert into `auto_"'.$host1.'"` values(NULL,$id')
                }
            }
        }
    }
    
    if(!empty($error))
    {
        for($z=0;$z<count($error);$z++)
        {
            $kq.=$error[$z]."\n";
        }
    }
    else
    {
        $kq=$lang_module['content_saveok'];
    }
}
if($nv_Request->isset_request('xoa','post'))
{
    $maid=$nv_Request->get_int('xoacm','post',0);
    $ten=$nv_Request->get_string('ten','post','');
    $ten=change_alias($ten);$ten=str_replace('-','',$ten);
    if($maid>0 && $ten!="")
    {
        $db->sql_query("delete from chuyenmuc where id='".$maid."'");
        $db->sql_query("DROP TABLE auto_".$ten);
        $db->sql_freeresult();
        $kq.=$ten;
    }
    else
        $kq.=$lang_module['error_del_content'];
}
include (NV_ROOTDIR . "/includes/header.php");
echo $kq;
include (NV_ROOTDIR . "/includes/footer.php");
?>