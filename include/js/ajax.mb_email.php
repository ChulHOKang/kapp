<?php
include_once('../../tkher_start_necessary.php');
include_once(TKHER_PATH_T_.'/include/lib/tkher_register.lib.php');
//include_once('./_common.php');
//include_once(G5_LIB_PATH.'/register.lib.php');

$mb_email = trim($_POST['reg_mb_email']);
$mb_id    = trim($_POST['reg_mb_id']);

set_session('ss_check_mb_email', '');
//m_("mb_email : ".$mb_email);

if ($msg = empty_mb_email($mb_email)) {
    m_("mb_email--die : ".$mb_email);
    die($msg);
}
if ($msg = valid_mb_email($mb_email)) die($msg);
if ($msg = prohibit_mb_email($mb_email)) die($msg);
if ($msg = exist_mb_email($mb_email, $mb_id)) die($msg);

set_session('ss_check_mb_email', $mb_email);
?>