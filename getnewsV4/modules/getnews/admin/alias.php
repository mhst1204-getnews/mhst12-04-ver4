<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Mon, 23 Jul 2012 02:56:18 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$title = filter_text_input( 'title', 'post', '' );
$alias = change_alias( $title );

include ( NV_ROOTDIR . "/includes/header.php" );
echo $alias;
include ( NV_ROOTDIR . "/includes/footer.php" );
//$title=$_POST['title'];
//$alias=change_alias($title);
//echo json_encode($alias);
//die;
?>

