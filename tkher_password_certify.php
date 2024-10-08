<?php
include_once('./_common.php');

// 오류시 공히 Error 라고 처리하는 것은 회원정보가 있는지? 비밀번호가 틀린지? 를 알아보려는 해킹에 대비한것

$mb_no = trim($_GET['mb_no']);
$mb_nonce = trim($_GET['mb_nonce']);

// 회원아이디가 아닌 회원고유번호로 회원정보를 구한다.
$sql = " select mb_id, mb_lost_certify from {$tkher['tkher_member_table']} where mb_no = '$mb_no' ";
$mb  = sql_fetch($sql);
if (strlen($mb['mb_lost_certify']) < 33)
    die("Error");

// 인증 링크는 한번만 처리가 되게 한다.
sql_query(" update {$tkher['tkher_member_table']} set mb_lost_certify = '' where mb_no = '$mb_no' ");

// 인증을 위한 난수가 제대로 넘어온 경우 임시비밀번호를 실제 비밀번호로 바꿔준다.
if ($mb_nonce === substr($mb['mb_lost_certify'], 0, 32)) {
    $new_password_hash = substr($mb['mb_lost_certify'], 33);
    sql_query(" update {$tkher['tkher_member_table']} set mb_password = '$new_password_hash' where mb_no = '$mb_no' ");
    alert('Password changed. \\n 비밀번호가 변경됐습니다. \\n Please login with the member ID and the changed password. \\n 회원아이디와 변경된 비밀번호로 로그인 하시기 바랍니다.', './login.php');
}
else {
    die("Error");
}
?>
