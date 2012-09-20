<?php

/**
 * @author CUONG
 * @copyright 2012
 */

include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Lay_RSS.php");
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$link=$_POST['site'];
if($link=="")$link=$_GET['site'];
if(nv_check_url($link))
{
    $website=$link;
    $xtpl = new XTemplate( "rss.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
    $xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
    $xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
    $xtpl->assign( 'MODULE_NAME', $module_name );
    $xtpl->assign( 'OP', $op );
    $xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
    
    $xtpl->assign('linksite',$link);
    //lay source nguon cua link rss
    $count=0;
    $source=Get_Source::main($link,$module_name,$count);
    
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
    $xtpl->parse('main.receive');
    $xtpl->parse('main.Action.ListCat');
    $xtpl->parse('main.getinfomation');
    
    $xtpl->parse( 'main' );
    
    $page_title = $lang_module['config'];
    $contents=$xtpl->text('main');
}

else
{
    $contents.="jalsdkf";
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>