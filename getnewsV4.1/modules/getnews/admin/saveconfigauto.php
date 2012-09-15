<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$laytin=$nv_Request ->get_int('laytintheo','post',1);
$auto=$nv_Request->get_int('tudctg','post',1);
global $db;$error=array();
$sql="insert into `config` values('laytintheo',".$laytin.")";
$result=$db->sql_query($sql);
if ($db->sql_affectedrows() <= 0){$error[]="Không luu du?c ch?c nang l?y tin theo";}

$sql="insert into `config` values('tudonglay',".$auto.")";
$result=$db->sql_query($sql);
if ($db->sql_affectedrows() <= 0){$error[]="Không luu du?c ch?c nang t? d?ng l?y tin";}



$xtpl = new XTemplate( "config.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);


$xtpl->parse('main.sendLink');
$xtpl->parse( 'main' );

$page_title = $lang_module['config'];
$contents=$xtpl->text('main');

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents.$laytin.$auto );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>