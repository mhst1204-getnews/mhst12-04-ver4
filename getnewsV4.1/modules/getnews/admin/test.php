<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simple_html_dom.php");
//include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/ThaoTac_DB.php");
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simplepie.inc");
require_once(NV_ROOTDIR . "/includes/class/upload.class.php" );
require_once(NV_ROOTDIR."/includes/class/image.class.php");
$xtpl = new XTemplate( "test.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
$kq="k";
$str="Kẻ lạ mang vật nhọn đột nhập nhà Miley";
$str1="Nữ ca sỹ lúc đó không có ở nhà.";
$titleClass="";$desClass="";
//$alias=change_alias($str);postcontent
$html=file_get_html("http://kenh14.vn/star.chn");
$a=$html->find('div');$arr=array();
foreach($a as $b)
{
    if($b->plaintext==$str)
    {
        $titleClass=$b->getAttribute("class")!=null?(".".$b->getAttribute("class")):("#".$b->getAttribute("id"));$arr[]=$titleClass;
    }
    if($b->plaintext==$str1)
    {
        $desClass=$b->getAttribute("class")!=null?(".".$b->getAttribute("class")):("#".$b->getAttribute("id"));
        $arr[]=$desClass;
    }
    if(count($arr)==2) break;
}
$class1="";
$xet=$html->find($arr[0],0);echo $xet->plaintext;
$sibling=$xet->nextSibling();
do{
    $attr=$sibling->getAttribute("class")!=null?(".".$sibling->getAttribute("class")):("#".$sibling->getAttribute("id"));
    if($attr==$arr[1])
    {
        $parent=$xet->parent();$check=false;
        while(!$check)
        {
            $attrP=$xet->getAttribute("class")!=null?(".".$xet->getAttribute("class")):("#".$xet->getAttribute("id"));
            if($attrP!=null)
            {
                $class=$attrP;break;
            }
            else $parent=$parent->parent();
        }
        
    }
    $sibling=$sibling->previousSibling();
}while($sibling);

$xtpl->assign('showContent',$class1);
$xtpl->parse( 'main' );
$page_title = $lang_module['config'];
    $contents=$xtpl->text('main');
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>