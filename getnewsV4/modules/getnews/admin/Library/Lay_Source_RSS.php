<?php

/**
 * @author CUONG
 * @copyright 2012
 */

include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simple_html_dom.php");
class GetSource
{
    //Ham lay noi dung cua file RSS
    static function GetContent($link)
    {
        $tagName=GetSource::FindNode($link);
        $html=file_get_html($link);
        $node=$html->find($tagName);
        $content="";
        foreach($node as $no)
        {
            $child=$no->childNodes();
            foreach($child as $chi)
            {
                if($chi->tag=="title")
                {
                    $temp=$chi->xmltext();
                    $content.=$temp;
                }
                if($chi->tag=="description")
                {
                    $temp=$chi->xmltext();
                    $pos=strpos($temp,'<BR');
                    $kq=substr($temp,0,$pos-3);
                    $content.=$kq;
                }
                if($chi->tag=="link")
                {
                    $temp=$chi->xmltext();
                    $content.=$temp;
                }
                $content.="<br>";
            }
        }
        return $content;
    }
    
    
    //ham nay dung de tim node nao chua du lieu can lay
    //Cach tim node nay chinh la xac dinh tan suat node nao xuat hien nhieu nhat
    static function FindNode($link)
    {
        $html=file_get_html($link);
        $root=$html->childNodes(0)->childNodes(0);
        $tagName="";
        GetSource::CountTagRepeat($root,$tagName);
        return $tagName;
    }
    
    //ham nay dung de dem so the tag cung cap xuat hien bao nhieu lan
    static function CountTagRepeat($node,&$tagName)
    {
        $dem=0;
        //Dem so node cung cap
        $sibling=$node->parent()->childNodes();
        //Neu node dang xet co con <=1, tuc la node dang xet phu hop, chon node con cua node dang xet de xet tiep
        if(count($sibling)<=1)
        {
            GetSource::CountTagRepeat($node->childNodes(0),$tagName);
        }
        else
        {
            //Duyet lan luot tung node, tim xem so lan lap lai cua node do
            for($i=0;$i<count($sibling);$i++)
            {
                for($j=$i+1;$j<count($sibling);$j++)
                {
                    if($node->parent()->children($i)->tag==$node->parent()->children($j)->tag)
                    {
                        $dem=$dem+1;
                    }
                }
                //Khi so lan lap lai lon hon 10 tuc la node do chua vung thong tin can lay.
                if($dem>10) 
                {
                    $tagName=$node->parent()->children($i)->tag;
                    break;
                }
            }
        }
    }
}

?>