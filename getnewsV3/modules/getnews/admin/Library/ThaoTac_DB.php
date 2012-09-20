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
        $vt1=0;$xpath="";$vt=0;
        $arrSplit=split("@",$contentLink);
        if(count($arrSplit)>0)
        {
           $vt1=$arrSplit[1];
           $xpath=$arrSplit[0];
           $vt=substr($xpath,strlen($xpath)-2,1);
        }
        else 
        {
            $xpath=$contentLink;
            $vt=substr($xpath,strlen($xpath)-1,1);
        }
        
        $con=InsertNews::ReturnNode($xpath,$body);
        $source=InsertNews::GetContent($con,$vt,$vt1);
        $arr[]=$source;
        return $arr;
    }
    
    static function GetContent($node,$vt,$vt1)
    {
        $parent=$node->parent();
        $child=$parent->childNodes();
        $kq="";
        for($i=$vt;$i<count($child)-$vt1;$i++)
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
            if($chi!="")
            {
                $node=$node->children($chi);
            }
            
            
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