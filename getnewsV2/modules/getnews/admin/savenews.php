<?php

/**
 * @author CUONG
 * @copyright 2012
 */
 
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/ThaoTac_DB.php");
//include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simple_html_dom.php");
require_once(NV_ROOTDIR . "/includes/class/upload.class.php" );
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$link=$_POST['getLink'];
$catid=$_POST['catids'];
if($link!=null || $link!="")
{
    //Luu tin
    global $db,$global_config;
    $subLink=split(',',$link);$kq="";$filename="";
    $local=array("uploads/news/","files/news/thumb","files/news/block");
    $error=0;
    $temp=parse_url($subLink[0]);
    $host=$temp['host'];
    $sql="select * from nv_xpath_new where site='".$host."'";
    $result=$db->sql_query($sql);
    list($site,$titleLink,$descripLink,$contentLink)=$db->sql_fetchrow($result);
    if($site!="" || $site!=null)
    {
        for($i=0;$i<count($subLink);$i++)
        {
            $duongdan=$subLink[$i];
            $arr=InsertNews::GetValue($duongdan,$titleLink,$descripLink,$contentLink);
            $title=$arr[0];
            $des=$arr[1];$des=str_replace('\'','',$des);
            $source=$arr[2];
            $linkImg="";
            $arrImg=InsertNews::GetImage($source);$kq.=count($arrImg);
            if(count($arrImg)>0)
            {
                for($j=0;$j<count($arrImg);$j++)
                {
                    if(!nv_is_url($arrImg[$j]))
                    {
                        $linkImg="http://www.".$host.$arrImg[$j];
                    }
                    else $linkImg=$arrImg[$j];
                    for($z=0;$z<3;$z++)
                    {
                        $upload = new upload( 'images', $global_config['forbid_extensions'], $global_config['forbid_mimes'],NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT );
                        $upload ->save_urlfile( $linkImg, NV_ROOTDIR."/".$local[$z], $replace_if_exists = true );
                    }
                    $source=str_replace($arrImg[$j],NV_BASE_SITEURL.$local[0].basename($linkImg),$source);
                }
                $filename=basename($arrImg[0]);
            }
            $id="";
            $insert_catid=implode(",",$catid);
            $alias=change_alias($title);
            $db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news_rows` (`id`,`catid` ,`listcatid` ,`topicid` ,`admin_id` ,`author` ,`sourceid` ,`addtime` ,`edittime` ,`status` ,`publtime` ,`exptime` ,`archive` ,`title` ,`alias` ,`hometext` ,`homeimgfile` ,`homeimgalt` ,`homeimgthumb` ,`inhome` ,`allowed_comm` ,`allowed_rating` ,`hitstotal` ,`hitscm` ,`total_rating` ,`click_rating` ,`keywords`)VALUES (NULL ,'".$catid[0]."','".$insert_catid."', '0', '0', 'admin', '1', '".NV_CURRENTTIME."', '0', '1', '".NV_CURRENTTIME."', '0', '2', '".$title."', '".$alias."', '".$des."', '".$filename."', '', 'thumb/".$filename."|block/".$filename."', '1', '0', '0', '0', '0', '0', '0','')");
            $id=mysql_insert_id();
            
            if($id>0)
            {
                $ct_query = array();
                $tbhtml = NV_PREFIXLANG . "_news_bodyhtml_" . ceil($id /2000);
                $db->sql_query("CREATE TABLE IF NOT EXISTS `" . $tbhtml .
                    "` (`id` int(11) unsigned NOT NULL, `bodyhtml` longtext NOT NULL, `sourcetext` varchar(255) NOT NULL default '', `imgposition` tinyint(1) NOT NULL default '1', `copyright` tinyint(1) NOT NULL default '0', `allowed_send` tinyint(1) NOT NULL default '0', `allowed_print` tinyint(1) NOT NULL default '0', `allowed_save` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=MyISAM");
                $ct_query[] = (int)$db->sql_query("INSERT INTO `" . $tbhtml . "` VALUES \n\t\t\t\t\t(" .
                    $id . ", \n\t\t\t\t\t" . $db->dbescape_string($source) .
                    ", \n\t                " . $db->dbescape_string('') . ",\n\t\t\t\t\t" .
                    intval(1) . ",\n\t                " . intval(0) .
                    ",  \n\t                " . intval(0) . ",  \n\t                " .
                    intval(0) . ",  \n\t                " . intval(0) .
                    "\t\t\t\t\t\n\t\t\t\t\t)");
                foreach($catid as $cat)
                {
                    $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news".
                    "_" . $cat . "` SELECT * FROM `" . NV_PREFIXLANG . "_news".
                    "_rows` WHERE `id`=" .$id. "");
                } 
                $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news".
                "_bodytext` VALUES (" . $id . ", " . $db->dbescape_string($source) .
                ")"); 
                
                $db->sql_query("INSERT INTO `nv_new_temp`(site,link) VALUES ('".$host."', '" . $duongdan ."')");
                $db->sql_freeresult();
                
            }
            else $error=1;
        }
        if($error==0)
        {
            $website=$_GET['site'];
            $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=".$module_name."&".NV_OP_VARIABLE."=getxml&site=".$website;
            $msg1 = $lang_module['content_saveok'];
            $msg2 = $lang_module['content_main'] . " " . $module_info['custom_title'];
            redriect($msg1, $msg2, $url);  
        }
        else
        {
            $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=".$module_name."&".NV_OP_VARIABLE."=rss";
            $msg1 = $lang_module['content_saveerror'];
            $msg2 = $lang_module['content_mainerror'] . " " . $module_info['custom_title'];
            redriect($msg1, $msg2, $url);  
        }
    }
    else
    {
        $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=".$module_name."&".NV_OP_VARIABLE."=config";
        $msg1 = $lang_module['content_addconfig'];
        $msg2 = $lang_module['content_config'] . " " . $module_info['custom_title'];
        redriect($msg1, $msg2, $url);
    }
    
//$xtpl = new XTemplate( "saveSuccess.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
//$xtpl->assign( 'LANG', $lang_module );
//$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
//$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
//$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
//$xtpl->assign( 'MODULE_NAME', $module_name );
//$xtpl->assign( 'OP', $op );
//$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
//$xtpl->assign('linksite',$kq);
//$xtpl->parse( 'main' );
//$page_title = $lang_module['config'];
//$contents=$xtpl->text('main');
}



include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>