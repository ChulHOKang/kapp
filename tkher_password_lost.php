<?php
include_once('./_common.php');
include_once('./kcaptcha/kcaptcha.lib.php');

if ($is_member) {
    alert("You are already signed in. \\n 이미 로그인중입니다.");
}

$g5['title'] = 'Find Member Information (회원정보 찾기)';
include_once('./tkher_head.sub.php');

$action_url = "./tkher_password_lost2.php";
include_once('./tkher_password_lost.skin.php');

include_once('./tkher_tail.sub.php');
?>