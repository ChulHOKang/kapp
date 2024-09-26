<?php
//include_once('./_common.php');
//include_once(G5_LIB_PATH.'/register.lib.php');

include_once('../../tkher_start_necessary.php');
include_once(TKHER_PATH_T_.'/include/lib/tkher_register.lib.php');

$mb_nick = trim($_POST['reg_mb_nick']);
$mb_id   = trim($_POST['reg_mb_id']);
//m_("bbs-ajax.mb_nick.php  mb_nick:$mb_nick");
set_session('ss_check_mb_nick', '');
$msg ='';
if ($msg = empty_mb_nick($mb_nick)) die($msg);
if ($msg = valid_mb_nick($mb_nick)) die($msg);
if ($msg = count_mb_nick($mb_nick)) die($msg);
if ($msg = exist_mb_nick($mb_nick, $mb_id)) die($msg);
if ($msg = reserve_mb_nick($mb_nick)) die($msg);

//m_("2222 bbs-ajax.mb_nick.php msg:$msg: mb_nick:$mb_nick");
set_session('ss_check_mb_nick', $mb_nick);
?>