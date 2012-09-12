<?php

/**
 * @author CUONG
 * @copyright 2012
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Lay_RSS.php");
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Loc_Noi_Dung.php");
global $db;
$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);

$loaitin="";
$selectloaitin=$nv_Request->get_int('loaitin','post',-1);
for($i=0;$i<2;$i++)
{
    $z=$i==0?$lang_module['noidung']:$lang_module['rss'];
    $loaitin.="<option value='".$i."'".($i==$selectloaitin?"selected=selected":'').">".$z."</option>";
}

$trangtin="";
$selecttrangtin=$nv_Request->get_string('trangtin','post');
$rs=$db->sql_query("select distinct host from chuyenmuc where rss='".$selectloaitin."'");
while(list($trang)=$db->sql_fetchrow($rs))
{
    $trangtin.="<option value='".$trang."'".($trang==$selecttrangtin?"selected=selected":"").">".$trang."</option>";
}

$chuyenmuc="";
$selectchuyenmuc=$nv_Request->get_int('chuyenmuc','post',-1);
$kq=$db->sql_query("select idcm,tencm from chuyenmuc where host='".$selecttrangtin."'");
while(list($idcm,$tencm)=$db->sql_fetchrow($kq))
{
    $chuyenmuc.="<option value='".$idcm."'".($idcm==$selectchuyenmuc?"selected=selected":"").">".$tencm."</option>";
}

//lay theo trang tin
if($nv_Request->get_int('action','post')==1)
{
    if($selectchuyenmuc!=-1)
    {
        $kq=$db->sql_query("select link from chuyenmuc where idcm='".$selectchuyenmuc."'");
        list($link1)=$db->sql_fetchrow($kq);$xtpl->assign('linksite',$link1);
        $temp=parse_url($link1);
        $host=$temp['host'];
        $res=$db->sql_query("select path,titlepath,despath from article_path where host='".$host."'");
        list($path,$titlepath,$despath)=$db->sql_fetchrow($res);
        $arr=GetArticle::GetValue($link1,$path,$titlepath,$despath);$content="";$temp=0;$count=count($arr);
    
         
         $choncm="<p>".$lang_module['chuyenmuc']."</p>";
         $action=
         "<div style=\"text-align: center; padding-top: 10px;\">
             <input  type=\"button\" value=\"".$lang_module['laytin']."\" id=\"gettintuc\"/>
             <input  type=\"button\" value=\"".$lang_module['quaylai']."\" id=\"back\"/>
             <input  type=\"hidden\" value=\"\" id=\"getLink\" name=\"getLink\"/>
         </div>";
         $cats="<div style=\"padding:4px; height:130px;background:#FFFFFF; overflow:auto; border: 1px solid #CCCCCC; width:300px;\">";
         $sql = "SELECT catid, title, lev FROM `" . NV_PREFIXLANG . "_news_cat` ORDER BY `order` ASC";
         $result_cat = $db->sql_query( $sql );
         while ( list( $catid_i, $title_i, $lev_i ) = $db->sql_fetchrow( $result_cat ) )
         {
             $xtitle_i = "";
             if ( $lev_i > 0 )
             {
                 for ( $i = 1; $i <= $lev_i; $i ++ )
                 {
                     $xtitle_i .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                 }
             }
             $ch = "";
             $cats.= "<li>" . $xtitle_i . "<input class=\"news_checkbox\" type=\"checkbox\" name=\"catids[]\" value=\"" . $catid_i . "\"" . $ch . ">" . $title_i . "</li>";
         }
         $cats.="</ul></div>";
         $content.="<form name=\"block_list\" action=\"\">";
         $content.="<table summary=\"\" class=\"tab1\">";
         $content.="<thead><tr>";
         $content.="<td align=\"center\"><input name=\"check_all[]\" type=\"checkbox\" class=\"check_all[]\" value=\"yes\" onclick=\"nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);\" /></td>";
         $content.="<td align=\"center\">".$lang_module['noidungtd']."</td>";
         $content.="<td align=\"center\">".$lang_module['noidungmt']."</td>";
         $content.="</tr></thead>";
         foreach($arr as $a)
         {
            $linkImg="";
            if(!nv_is_url($a['link']))
            {
                $linkImg="http://www.".$host.$a['link'];
            }
            else $linkImg=$a['link'];
            $content.="<tbody><tr align=\"center\">";
			$content.="<td align=\"center\"><input type=\"checkbox\" onclick=\"nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);\" value=\"".$linkImg."\" name=\"idcheck[]\" /></td>";
			$content.="<td align=\"left\"><a href=\"".$linkImg."\">".$a['tieude']."</a></td>";	
			$content.="<td align=\"left\">".$a['mota']."</td>";	
			$content.="</tr></tbody>";
         }
         $content.="</table></form>";
         $xtpl->assign('listcats',$cats);
         $xtpl->assign('source',$content);
         $xtpl->assign('choncm',$choncm);
         $xtpl->assign('action',$action);
         $xtpl->parse('main.receive');
         $xtpl->parse('main.Action.ListCat');
    }
    
 
}

if($nv_Request->get_string('site','get')!=null)
{
    $link1=$nv_Request->get_string('site','get');
    $choncm="<p>".$lang_module['chuyenmuc']."</p>";
    $xtpl->assign('linksite',$link1);
    $action=
    "<div style=\"text-align: center; padding-top: 10px;\">
        <input  type=\"button\" value=\"".$lang_module['laytin']."\" id=\"getNews\"/>
        <input  type=\"button\" value=\"".$lang_module['quaylai']."\" id=\"back\"/>
        <input  type=\"hidden\" value=\"\" id=\"getLink\" name=\"getLink\"/>
    </div>";
    //lay source nguon cua link rss
    $count=0;
    $source=Get_Source::main($link1,$module_name,$count);
    
    //tao html cho chon chuyen muc
    $cats="<div style=\"padding:4px; height:130px;background:#FFFFFF; overflow:auto; border: 1px solid #CCCCCC; width:300px;\">";
    $sql = "SELECT catid, title, lev FROM `" . NV_PREFIXLANG . "_news_cat` ORDER BY `order` ASC";
    $result_cat = $db->sql_query( $sql );
    while ( list( $catid_i, $title_i, $lev_i ) = $db->sql_fetchrow( $result_cat ) )
    {
        $xtitle_i = "";
        if ( $lev_i > 0 )
        {
            for ( $i = 1; $i <= $lev_i; $i ++ )
            {
                $xtitle_i .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        }
        $ch = "";
        $cats.= "<li>" . $xtitle_i . "<input class=\"news_checkbox\" type=\"checkbox\" name=\"catids[]\" value=\"" . $catid_i . "\"" . $ch . ">" . $title_i . "</li>";
    }
    $cats.="</ul></div>";
    $xtpl->assign('listcats',$cats);
    $xtpl->assign('source',$source);
    $xtpl->assign('count',$count);
    $xtpl->assign('choncm',$choncm);
    $xtpl->assign('action',$action);
    $xtpl->parse('main.receive');
    $xtpl->parse('main.Action.ListCat');
}

//lay theo rss
if($nv_Request->get_int('action','post')==2)
{
    $kq=$db->sql_query("select link from chuyenmuc where idcm='".$selectchuyenmuc."'");
    list($link1)=$db->sql_fetchrow($kq);
    $choncm="<p>".$lang_module['chuyenmuc']."</p>";
    $xtpl->assign('linksite',$link1);
    $action=
    "<div style=\"text-align: center; padding-top: 10px;\">
        <input  type=\"button\" value=\"".$lang_module['laytin']."\" id=\"getNews\"/>
        <input  type=\"button\" value=\"".$lang_module['quaylai']."\" id=\"back\"/>
        <input  type=\"hidden\" value=\"\" id=\"getLink\" name=\"getLink\"/>
    </div>";
    //lay source nguon cua link rss
    $count=0;
    $source=Get_Source::main($link1,$module_name,$count);
    
    //tao html cho chon chuyen muc
    $cats="<div style=\"padding:4px; height:130px;background:#FFFFFF; overflow:auto; border: 1px solid #CCCCCC; width:300px;\">";
    $sql = "SELECT catid, title, lev FROM `" . NV_PREFIXLANG . "_news_cat` ORDER BY `order` ASC";
    $result_cat = $db->sql_query( $sql );
    while ( list( $catid_i, $title_i, $lev_i ) = $db->sql_fetchrow( $result_cat ) )
    {
        $xtitle_i = "";
        if ( $lev_i > 0 )
        {
            for ( $i = 1; $i <= $lev_i; $i ++ )
            {
                $xtitle_i .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        }
        $ch = "";
        $cats.= "<li>" . $xtitle_i . "<input class=\"news_checkbox\" type=\"checkbox\" name=\"catids[]\" value=\"" . $catid_i . "\"" . $ch . ">" . $title_i . "</li>";
    }
    $cats.="</ul></div>";
    $xtpl->assign('listcats',$cats);
    $xtpl->assign('source',$source);
    $xtpl->assign('count',$count);
    $xtpl->assign('choncm',$choncm);
    $xtpl->assign('action',$action);
    $xtpl->parse('main.receive');
    $xtpl->parse('main.Action.ListCat');
}
$xtpl->assign('chuyenmuc',$chuyenmuc);
$xtpl->assign('loaitin',$loaitin);
$xtpl->assign('trangtin',$trangtin);
$xtpl->parse('main.getinfomation');
$xtpl->parse( 'main' );

$page_title = $lang_module['config'];
$contents=$xtpl->text('main');


include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>