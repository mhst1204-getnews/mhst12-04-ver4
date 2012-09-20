<?php

/**
 * @author CUONG
 * @copyright 2012
 */
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simple_html_dom.php");
//require_once ( NV_ROOTDIR . "/includes/class/upload.class.php" );
class InsertNews
{
    static function GetValue($link,$titleLink,$descripLink,$contentLink)
    {
        $arr=array();
        $html=file_get_html($link);
        $body=$html->find('body',0);
        $title=InsertNews::ReturnNode($titleLink,$body);
        $arr[]=$title->plaintext;
        $des=InsertNews::ReturnNode($descripLink,$body);
        $arr[]=$des->plaintext;
        $vt=substr($contentLink,strlen($contentLink)-1,1);
        $con=InsertNews::ReturnNode($contentLink,$body);
        $source=InsertNews::GetContent($con,$vt,null);
        $arr[]=$source;
        return $arr;
    }
    //static function GetXpath($link,$catid)
//    {
//        global $db,$global_config;
//        $subLink=split(',',$link);$kq="";
//        $local=array("/uploads/news/","/files/news/thumb","/files/news/block");
//        for($i=0;$i<count($subLink);$i++)
//        {
//            $duongdan=$subLink[$i];
//            $temp=parse_url($duongdan);
//            $host=$temp['host'];
//            $sql="select * from nv_xpath_new where site='".$host."'";
//            $result=$db->sql_query($sql);
//            list($site,$titleLink,$descripLink,$contentLink)=$db->sql_fetchrow($result);
//            $html=file_get_html($duongdan);
//            $body=$html->find('body',0);
//            $title=InsertNews::ReturnNode($titleLink,$body);
//            $des=InsertNews::ReturnNode($descripLink,$body);
//            $vt=substr($contentLink,strlen($contentLink)-1,1);
//            $con=InsertNews::ReturnNode($contentLink,$body);
//            $source=InsertNews::GetContent($con,$vt,null);
//            $linkImg="";
//            $arrImg=InsertNews::GetImage($source);
//            for($j=0;$j<count($arrImg);$j++)
//            {
//                if(!nv_is_url($arrImg[$j]))
//                {
//                    $linkImg="http://www.".$host.$arrImg[$j];
//                }
//                else $linkImg=$arrImg[$j];
//                for($z=0;$z<3;$z++)
//                {
//                    $upload = new upload( 'images', $global_config['forbid_extensions'], $global_config['forbid_mimes'],NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT );
//                    $upload ->save_urlfile( $linkImg, NV_ROOTDIR.$local[$z], $replace_if_exists = true );
//                    $kq.= NV_ROOTDIR.$local[$z]."<br>";
//                }
//                $source=str_replace($arrImg[$j],NV_BASE_SITEURL.$local[0].basename($linkImg),$source);
//            }
//            $filename=basename($arrImg[0]);
//            InsertNews::Insert($catid,$title->plaintext,$des->plaintext,$source,$filename ,$duongdan);
//        }
//        return $kq;
//    }
//    
//    static function Insert($catid,$title,$des,$content,$linkImg,$link)
//    {
//        global $db;
//        //$local=array("/uploads/news/","/files/news/thumb","/files/news/block");
//        $id="";
//        $insert_catid=implode(",",$catid);
//        $alias=change_alias($title);
//        $query = "INSERT INTO `" . NV_PREFIXLANG . "_news_rows` (`id`,`catid` ,`listcatid` ,`topicid` ,`admin_id` ,`author` ,`sourceid` ,`addtime` ,`edittime` ,`status` ,`publtime` ,`exptime` ,`archive` ,`title` ,`alias` ,`hometext` ,`homeimgfile` ,`homeimgalt` ,`homeimgthumb` ,`inhome` ,`allowed_comm` ,`allowed_rating` ,`hitstotal` ,`hitscm` ,`total_rating` ,`click_rating` ,`keywords`) VALUES (NULL ,'".$catid[0]."','".$insert_catid."', 0, 0, 'admin', 1, '".NV_CURRENTTIME."', 0, 1, '".NV_CURRENTTIME."', 0, 2, '".$title."', '".$alias."', '".$des."', '".$linkImg."', '', 'thumb/".$linkImg."|block/".$linkImg."', 1, 0, 0, 0, 0, 0, 0,'')";
//        $db->sql_query($query);
//        $id = mysql_insert_id();
//        if ($id > 0)
//        {
//            $ct_query = array();
//            $tbhtml = NV_PREFIXLANG . "_news_bodyhtml_" . ceil($id /2000);
//            $db->sql_query("CREATE TABLE IF NOT EXISTS `" . $tbhtml .
//                "` (`id` int(11) unsigned NOT NULL, `bodyhtml` longtext NOT NULL, `sourcetext` varchar(255) NOT NULL default '', `imgposition` tinyint(1) NOT NULL default '1', `copyright` tinyint(1) NOT NULL default '0', `allowed_send` tinyint(1) NOT NULL default '0', `allowed_print` tinyint(1) NOT NULL default '0', `allowed_save` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=MyISAM");
//            $ct_query[] = (int)$db->sql_query("INSERT INTO `" . $tbhtml . "` VALUES \n\t\t\t\t\t(" .
//                $id . ", \n\t\t\t\t\t" . $db->dbescape_string($content) .
//                ", \n\t                " . $db->dbescape_string('') . ",\n\t\t\t\t\t" .
//                intval(1) . ",\n\t                " . intval(0) .
//                ",  \n\t                " . intval(0) . ",  \n\t                " .
//                intval(0) . ",  \n\t                " . intval(0) .
//                "\t\t\t\t\t\n\t\t\t\t\t)");
//            foreach($catid as $cat)
//            {
//                $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news_" . $cat . "` SELECT * FROM `" . NV_PREFIXLANG . "_news_rows` WHERE `id`=" .$id. "");
//            } 
//            $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news_bodytext` VALUES (" . $id . ", " . $db->dbescape_string($content) .")"); 
//            $db->sql_freeresult();
//        }
//        //nv_set_status_module();
//        
//        
//        
//        //$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news_rows` (`id`,`catid` ,`listcatid` ,`topicid` ,`admin_id` ,`author` ,`sourceid` ,`addtime` ,`edittime` ,`status` ,`publtime` ,`exptime` ,`archive` ,`title` ,`alias` ,`hometext` ,`homeimgfile` ,`homeimgalt` ,`homeimgthumb` ,`inhome` ,`allowed_comm` ,`allowed_rating` ,`hitstotal` ,`hitscm` ,`total_rating` ,`click_rating` ,`keywords`)
//        //VALUES (NULL ,'".$catid[0]."','".$insert_catid."', '0', '0', 'admin', '1', '".NV_CURRENTTIME."', '0', '1', '".NV_CURRENTTIME."', '0', '2', '".$title."', '".$alias."', '".$des."', '".$linkImg."', '', 'thumb/".$linkImg."|block/".$linkImg."', '1', '0', '0', '0', '0', '0', '0','')");
////        $id=mysql_insert_id();
////        if($id>0)
////        {
////            $ct_query = array();
////            $tbhtml = NV_PREFIXLANG . "_news_bodyhtml_" . ceil($id /2000);
////            $db->sql_query("CREATE TABLE IF NOT EXISTS `" . $tbhtml .
////                "` (`id` int(11) unsigned NOT NULL, `bodyhtml` longtext NOT NULL, `sourcetext` varchar(255) NOT NULL default '', `imgposition` tinyint(1) NOT NULL default '1', `copyright` tinyint(1) NOT NULL default '0', `allowed_send` tinyint(1) NOT NULL default '0', `allowed_print` tinyint(1) NOT NULL default '0', `allowed_save` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=MyISAM");
////            $ct_query[] = (int)$db->sql_query("INSERT INTO `" . $tbhtml . "` VALUES \n\t\t\t\t\t(" .
////                $id . ", \n\t\t\t\t\t" . $db->dbescape_string($content) .
////                ", \n\t                " . $db->dbescape_string('') . ",\n\t\t\t\t\t" .
////                intval(1) . ",\n\t                " . intval(0) .
////                ",  \n\t                " . intval(0) . ",  \n\t                " .
////                intval(0) . ",  \n\t                " . intval(0) .
////                "\t\t\t\t\t\n\t\t\t\t\t)");
////            foreach($catid as $cat)
////            {
////                $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news".
////                "_" . $cat . "` SELECT * FROM `" . NV_PREFIXLANG . "_news".
////                "_rows` WHERE `id`=" .$id. "");
////            } 
////            $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news".
////            "_bodytext` VALUES (" . $id . ", " . $db->dbescape_string($content) .
////            ")"); 
////            $db->sql_freeresult();  
////        }
//        //nv_set_status_module();
//        //return $z;
//    }
    
    static function GetContent($node,$vt,$vt1)
    {
        $parent=$node->parent();
        $child=$parent->childNodes();
        $kq="";
        for($i=$vt;$i<count($child);$i++)
        {
            $kq.=$parent->children($i)->outertext();
        }
        return $kq;
    }
    
    static function ReturnNode($xpath,$node)
    {
        $child=split(',',$xpath);
        foreach($child as $chi)
        {
            $node=$node->children($chi);
            
        }
        return $node;
    }
    
    
    static function get_regex($regex)
	{
		$regex=str_replace("/","\/",$regex);
		return "/".$regex."/";
	}
        
    static function GetImage($content)	
	{
		$regex='src="(?<linkimage>.*?)"';
		$regex=InsertNews::get_regex($regex);
		$content=preg_replace('/\s+/'," ",$content);
		preg_match_all($regex,$content,$result);
		return $result['linkimage'];
	}
}

?>