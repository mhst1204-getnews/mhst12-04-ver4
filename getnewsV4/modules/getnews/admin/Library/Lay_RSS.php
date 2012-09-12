<?php

/**
 * @author CUONG
 * @copyright 2012
 */
 
 include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simplepie.inc");
class Get_Source
 {
    static function main($link,$module_name,&$count)
    {
        global $db,$global_config;
        $temp=parse_url($link);
        $host=$temp['host'];
        $sql="select link from nv_new_temp where site='".$host."'";
        $result=$db->sql_query($sql);
        $number=$db->sql_numrows( $result );
        
        $feed = new SimplePie();
        //feed sources
        $feed->set_feed_url($link);
        //start process
        $feed->init();
        $feed->handle_content_type();
        $content="";$temp=0;
        $count=$feed->get_item_quantity();
        if( $number > 0 )
        {
            $row=array();
            while($k=$db->sql_fetch_assoc( $result ))
            {
                $row[]=$k['link'];
            }
            $check=false;
            foreach($feed->get_items() as $item)
            {
                for($z=0;$z<count($row);$z++)
                {
                    if($item->get_permalink()==$row[$z])
                    {
                        $check=true;
                    }
                }
                if(!$check)
                {
                    $content.="<div class=\"content-box clearfix\" id=\"content".$temp."\">";
                    $title="";$description="";$link="";$img="";
                    $imgLink=Get_Source::GetImage($item->get_content());
                    foreach($imgLink as $i)
                    {
                        $img=$i;
                    }
                    $content.="<a href='".$item->get_permalink()."'>";
                    $content.="<img class=\"s-border fl left\" style=\"width:183px; height: 150px;\" src='".$img."'></a>";
                    $content.="<a href='".$item->get_permalink()."'>".$item->get_title()."</a>";
                    $description=preg_replace("/<img[^>]+\>/i", " ", $item->get_content());
                    $description=preg_replace("/<\\/?a(\\s+.*?>|>)/", "", $description);
                    $pos=strpos($description,'<BR');if($pos<0|| $pos==null)$pos=strpos($description,'<br');
                    $description=substr($description,0,$pos-1);
                    $content.="<p>".$description."</p>";
                    $content.="<input type=\"hidden\" value=\"".$item->get_permalink()."\" id=\"link".$temp."\">";
                    $content.="</div>";$temp++;
                }
                else {
                    $check=false;
                }
            }
        }
        else
        {
            foreach($feed->get_items() as $item)
            {
                $content.="<div class=\"content-box clearfix\" id=\"content".$temp."\">";
                $title="";$description="";$link="";$img="";
                $imgLink=Get_Source::GetImage($item->get_content());
                foreach($imgLink as $i)
                {
                    $img=$i;
                }
                $content.="<a href='".$item->get_permalink()."'>";
                $content.="<img class=\"s-border fl left\" style=\"width:183px; height: 150px;\" src='".$img."'></a>";
                $content.="<a href='".$item->get_permalink()."'>".$item->get_title()."</a>";
                $description=preg_replace("/<img[^>]+\>/i", " ", $item->get_content());
                $description=preg_replace("/<\\/?a(\\s+.*?>|>)/", "", $description);
                $pos=strpos($description,'<BR');if($pos<0|| $pos==null)$pos=strpos($description,'<br');
                $description=substr($description,0,$pos-1);
                $content.="<p>".$description."</p>";
                $content.="<input type=\"hidden\" value=\"".$item->get_permalink()."\" id=\"link".$temp."\">";
                $content.="</div>";$temp++;
            }
        }
        return $content;
    }
    //error_reporting(E_ALL & ~E_DEPRECATED);
    
    static function get_regex($regex)
	{
		$regex=str_replace("/","\/",$regex);
		return "/".$regex."/";
	}
    static function GetImage($content)	//Lay link anh
    {
    	$regex='src="(?<linkimage>.*?)"';
    	$regex=Get_Source::get_regex($regex);
    	$content=preg_replace('/\s+/'," ",$content);
    	preg_match_all($regex,$content,$result);
    	return $result['linkimage'];
    }
 }
?>