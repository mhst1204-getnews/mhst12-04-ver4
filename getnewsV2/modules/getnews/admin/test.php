<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
require_once ( NV_ROOTDIR . "/includes/class/upload.class.php" );

$xtpl = new XTemplate( "test.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
$upload = new upload( 'images', $global_config['forbid_extensions'], $global_config['forbid_mimes'],NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT );
$upload ->save_urlfile( "http://vnexpress.net/Files/Subject/3b/bd/b7/58/Chua-nhat-tru.jpg", NV_ROOTDIR, $replace_if_exists = true );


$xtpl->assign('showContent',NV_ROOTDIR);
$xtpl->parse( 'main' );
$page_title = $lang_module['config'];
    $contents=$xtpl->text('main');
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>