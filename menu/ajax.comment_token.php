<?php
include_once(KAPP_TATH_T_.'/include/lib/tkher_json.lib.php');

$ss_name = 'ss_comment_token';

set_session($ss_name, '');

$token = _token();

set_session($ss_name, $token);

die(json_encode(array('token'=>$token)));
?>