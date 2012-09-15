<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$maid=$nv_Request->get_int('xoacm','post',0);
if($maid>0)
{
    $db->sql_query("delete from chuyenmuc where id='".$maid."'");
    $db->sql_freeresult();
}
  
include (NV_ROOTDIR . "/includes/header.php");
echo $contents;
include (NV_ROOTDIR . "/includes/footer.php");

?>