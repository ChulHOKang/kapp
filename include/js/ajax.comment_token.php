<?php
//include_once('./_common.php');
//include_once(G5_LIB_PATH.'/json.lib.php');
include_once('../../tkher_start_necessary.php');
include_once('../../include/lib/tkher_json.lib.php');//TKHER_LIB_PATH:/var/www/html/t/include/lib, TKHER_LIB_DIR:include/lib
//include_once(TKHER_LIB_PATH.'/tkher_json.lib.php');//TKHER_LIB_PATH:/var/www/html/t/include/lib, TKHER_LIB_DIR:include/lib

$ss_name = 'ss_comment_token';

set_session($ss_name, '');

$token = _token();

set_session($ss_name, $token);

die(json_encode(array('token'=>$token)));
?>