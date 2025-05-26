<?php
include_once(KAPP_PATH_T_.'/include/lib/tkhsr_json.lib.php');

if(!$bo_table)
   die(json_encode(array('error'=>'게시판 정보가 올바르지 않습니다.', 'url'=>KAPP_URL_T_)));

set_session('ss_write_'.$bo_table.'_token', '');

$token = get_write_token($bo_table);

die(json_encode(array('error'=>'', 'token'=>$token, 'url'=>'')));
?>