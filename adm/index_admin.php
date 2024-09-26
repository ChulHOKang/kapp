<?php
$sub_menu = "100100";
include_once('../tkher_start_necessary.php');

include_once('./_common.php');
include_once('./admin.lib.php');

auth_check( $auth[$sub_menu], 'r'); // admin.lib.php
//alert : 로그인 하십시오.
//

//m_("config_form -------- ");
if( $is_admin != 'super'){
    alert('--- 최고관리자만 접근 가능합니다. ---- ');
	exit;
}

//if( !isset( $config['kapp_add_script'])) {
//    sql_query(" ALTER TABLE `{$tkher['config_table']}`
//                    ADD `kapp_add_script` TEXT NOT NULL AFTER `kapp_admin_email_name` ", true);
//}

if( !isset( $config['kapp_mobile_new_skin'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_mobile_new_skin` VARCHAR(255) NOT NULL AFTER `kapp_memo_send_point`,
                    ADD `kapp_mobile_search_skin` VARCHAR(255) NOT NULL AFTER `kapp_mobile_new_skin`,
                    ADD `kapp_mobile_connect_skin` VARCHAR(255) NOT NULL AFTER `kapp_mobile_search_skin`,
                    ADD `kapp_mobile_member_skin` VARCHAR(255) NOT NULL AFTER `kapp_mobile_connect_skin` ", true);
}

if( isset($config['kapp_gcaptcha_mp3'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    CHANGE `kapp_gcaptcha_mp3` `kapp_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' ", true);
} else if( !isset($config['kapp_captcha_mp3'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' AFTER `kapp_mobile_member_skin` ", true);
}

if( !isset( $config['kapp_editor'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_editor` VARCHAR(255) NOT NULL DEFAULT '' AFTER `kapp_captcha_mp3` ", true);
}

if( !isset( $config['kapp_googl_shorturl_apikey'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_googl_shorturl_apikey` VARCHAR(255) NOT NULL DEFAULT '' AFTER `kapp_captcha_mp3` ", true);
}

if( !isset( $config['kapp_mobile_pages'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_mobile_pages` INT(11) NOT NULL DEFAULT '0' AFTER `kapp_write_pages` ", true);
    sql_query(" UPDATE `{$tkher['config_table']}` SET cf_mobile_pages = '5' ", true);
}

if(!isset( $config['kapp_facebook_appid'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_facebook_appid` VARCHAR(255) NOT NULL AFTER `kapp_googl_shorturl_apikey`,
                    ADD `kapp_facebook_secret` VARCHAR(255) NOT NULL AFTER `kapp_facebook_appid`,
                    ADD `kapp_twitter_key` VARCHAR(255) NOT NULL AFTER `kapp_facebook_secret`,
                    ADD `kapp_twitter_secret` VARCHAR(255) NOT NULL AFTER `kapp_twitter_key` ", true);
}

// uniqid 테이블이 없을 경우 생성
if(!sql_query(" DESC {$tkher['uniqid_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$tkher['uniqid_table']}` (
                  `uq_id` bigint(20) unsigned NOT NULL,
                  `uq_ip` varchar(255) NOT NULL,
                  PRIMARY KEY (`uq_id`)
                ) ", false);
}

if(!sql_query(" SELECT uq_ip from {$tkher['uniqid_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE {$tkher['uniqid_table']} ADD `uq_ip` VARCHAR(255) NOT NULL ");
}

// 임시저장 테이블이 없을 경우 생성
if(!sql_query(" DESC {$tkher['autosave_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$tkher['autosave_table']}` (
                  `as_id` int(11) NOT NULL AUTO_INCREMENT,
                  `mb_id` varchar(20) NOT NULL,
                  `as_uid` bigint(20) unsigned NOT NULL,
                  `as_subject` varchar(255) NOT NULL,
                  `as_content` text NOT NULL,
                  `as_datetime` datetime NOT NULL,
                  PRIMARY KEY (`as_id`),
                  UNIQUE KEY `as_uid` (`as_uid`),
                  KEY `mb_id` (`mb_id`)
                ) ", false);
}

if( !isset( $config['kapp_admin_email'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_admin_email` VARCHAR(255) NOT NULL AFTER `kapp_admin` ", true);
}

if( !isset( $config['kapp_admin_email_name'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_admin_email_name` VARCHAR(255) NOT NULL AFTER `kapp_admin_email` ", true);
}
//m_("kapp_admin_email_name: " . $config['kapp_admin_email_name']); // kapp_admin_email_name: K-App
if( !isset( $config['kapp_cert_use'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_cert_use` TINYINT(4) NOT NULL DEFAULT '0' AFTER `kapp_editor`,
                    ADD `kapp_cert_ipin` VARCHAR(255) NOT NULL DEFAULT '' AFTER `kapp_cert_use`,
                    ADD `kapp_cert_hp` VARCHAR(255) NOT NULL DEFAULT '' AFTER `kapp_cert_ipin`,
                    ADD `kapp_cert_kcb_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `kapp_cert_hp`,
                    ADD `kapp_cert_kcp_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `kapp_cert_kcb_cd`,
                    ADD `kapp_cert_limit` INT(11) NOT NULL DEFAULT '0' AFTER `kapp_cert_kcp_cd` ", true);
    sql_query(" ALTER TABLE `{$tkher['tkher_member_table']}`
                    CHANGE `mb_hp_certify` `mb_certify` VARCHAR(20) NOT NULL DEFAULT '' ", true);
    sql_query(" update {$tkher['tkher_member_table']} set mb_certify = 'hp' where mb_certify = '1' ");
    sql_query(" update {$tkher['tkher_member_table']} set mb_certify = '' where mb_certify = '0' ");
    sql_query(" CREATE TABLE IF NOT EXISTS `{$tkher['cert_history_table']}` (
                  `cr_id` int(11) NOT NULL auto_increment,
                  `mb_id` varchar(255) NOT NULL DEFAULT '',
                  `cr_company` varchar(255) NOT NULL DEFAULT '',
                  `cr_method` varchar(255) NOT NULL DEFAULT '',
                  `cr_ip` varchar(255) NOT NULL DEFAULT '',
                  `cr_date` date NOT NULL DEFAULT '0000-00-00',
                  `cr_time` time NOT NULL DEFAULT '00:00:00',
                  PRIMARY KEY (`cr_id`),
                  KEY `mb_id` (`mb_id`)
                )", true);
}

if( !isset( $config['kapp_analytics'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_analytics` TEXT NOT NULL AFTER `kapp_intercept_ip` ", true);
}

if( !isset( $config['kapp_add_meta'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_add_meta` TEXT NOT NULL AFTER `kapp_analytics` ", true);
}

if ( !isset( $config['kapp_syndi_token'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_syndi_token` VARCHAR(255) NOT NULL AFTER `kapp_add_meta` ", true);
}

if ( !isset( $config['kapp_syndi_except'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_syndi_except` TEXT NOT NULL AFTER `kapp_syndi_token` ", true);
}

if( !isset( $config['kapp_sms_use'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_sms_use` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_cert_limit`,
                    ADD `kapp_icode_id` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_sms_use`,
                    ADD `kapp_icode_pw` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_icode_id`,
                    ADD `kapp_icode_server_ip` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_icode_pw`,
                    ADD `kapp_icode_server_port` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_icode_server_ip` ", true);
}

if( !isset( $config['kapp_mobile_page_rows'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_mobile_page_rows` int(11) NOT NULL DEFAULT '0' AFTER `kapp_page_rows` ", true);
}

if( !isset( $config['kapp_cert_req'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_cert_req` tinyint(4) NOT NULL DEFAULT '0' AFTER `kapp_cert_limit` ", true);
}

if( !isset( $config['kapp_faq_skin'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_connect_skin`,
                    ADD `kapp_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_mobile_connect_skin` ", true);
}

// LG유플러스 본인확인 필드 추가
if( !isset( $config['kapp_lg_mid'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_lg_mid` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_cert_kcp_cd`,
                    ADD `kapp_lg_mert_key` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_lg_mid` ", true);
}

if( !isset( $config['kapp_optimize_date'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_optimize_date` date NOT NULL default '0000-00-00' AFTER `kapp_popular_del` ", true);
}

// 카카오톡링크 api 키
if( !isset( $config['kapp_kakao_js_apikey'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_kakao_js_apikey` varchar(255) NOT NULL DEFAULT '' AFTER `kapp_googl_shorturl_apikey` ", true);
}

// SMS 전송유형 필드 추가
if( !isset( $config['kapp_sms_type'])) {
    sql_query(" ALTER TABLE `{$tkher['config_table']}`
                    ADD `kapp_sms_type` varchar(10) NOT NULL DEFAULT '' AFTER `kapp_sms_use` ", true);
}

// 접속자 정보 필드 추가
if( !sql_query(" select vi_browser from {$tkher['visit_table']} limit 1 ")) {
    sql_query(" ALTER TABLE `{$tkher['visit_table']}`
                    ADD `vi_browser` varchar(255) NOT NULL DEFAULT '' AFTER `vi_agent`,
                    ADD `vi_os` varchar(255) NOT NULL DEFAULT '' AFTER `vi_browser`,
                    ADD `vi_device` varchar(255) NOT NULL DEFAULT '' AFTER `vi_os` ", true);
}

if(!$config['kapp_faq_skin']) $config['kapp_faq_skin'] = "basic";
if(!$config['kapp_mobile_faq_skin']) $config['kapp_mobile_faq_skin'] = "basic";

//$tkher['title'] = '관리자메인 index_admin';
$tkher['title'] = '환경설정';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_cf_basic">기본환경</a></li>
    <li><a href="#anc_cf_board">게시판기본</a></li>
    <li><a href="#anc_cf_join">회원가입</a></li>
    <li><a href="#anc_cf_cert">본인확인</a></li>
    <li><a href="#anc_cf_mail">기본메일환경</a></li>
    <li><a href="#anc_cf_article_mail">글작성메일</a></li>
    <li><a href="#anc_cf_join_mail">가입메일</a></li>
    <li><a href="#anc_cf_vote_mail">투표메일</a></li>
    <li><a href="#anc_cf_sns">SNS</a></li>
    <li><a href="#anc_cf_lay">레이아웃 추가설정</a></li>
    <li><a href="#anc_cf_sms">SMS</a></li>
    <li><a href="#anc_cf_extra">여분필드</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="'.KAPP_URL.'/">메인으로</a>
</div>';

//if (!$config['kapp_icode_server_ip'])   $config['kapp_icode_server_ip'] = '211.172.232.124';
if (!$config['kapp_icode_server_ip'])   $config['kapp_icode_server_ip'] = '125.184.157.214';
if (!$config['kapp_icode_server_port']) $config['kapp_icode_server_port'] = '7295';

if ($config['kapp_sms_use'] && $config['kapp_icode_id'] && $config['kapp_icode_pw']) {
    $userinfo = get_icode_userinfo($config['kapp_icode_id'], $config['kapp_icode_pw']);
}
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">

<section id="anc_cf_basic">
    <h2 class="h2_frm">홈페이지 기본환경 설정</h2>
    <?php //echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>홈페이지 기본환경 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_title">홈페이지 제목<strong class="sound_only">필수</strong></label></th>
            <td colspan="3"><input type="text" name="kapp_title" value="<?php echo $config['kapp_title'] ?>" id="kapp_title" required class="required frm_input" size="40"></td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin">최고관리자<strong class="sound_only">필수</strong></label></th>
            <td colspan="3"><?php echo get_member_id_select('kapp_admin', 7, $config['kapp_admin'], 'required') ?></td><!-- 10->7 -->
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin_email">관리자 메일 주소<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
                <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일 주소를 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                <input type="text" name="kapp_admin_email" value="<?php echo $config['kapp_admin_email'] ?>" id="kapp_admin_email" required class="required email frm_input" size="40">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin_email_name">관리자 메일 발송이름<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
                <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일의 발송이름을 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                <input type="text" name="kapp_admin_email_name" value="<?php echo $config['kapp_admin_email_name'] ?>" id="kapp_admin_email_name" required class="required frm_input" size="40">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_use_point">포인트 사용</label></th>
            <td colspan="3"><input type="checkbox" name="kapp_use_point" value="1" id="kapp_use_point" <?php echo $config['kapp_use_point']?'checked':''; ?>> 사용</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_login_point">로그인시 포인트<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('회원이 로그인시 하루에 한번만 적립') ?>
                <input type="text" name="kapp_login_point" value="<?php echo $config['kapp_login_point'] ?>" id="kapp_login_point" required class="required frm_input" size="5"> 점
            </td>
            <!-- <th scope="row"><label for="cf_memo_send_point">쪽지보낼시 차감 포인트<strong class="sound_only">필수</strong></label></th>
            <td>
                 <?php echo help('양수로 입력하십시오. 0점은 쪽지 보낼시 포인트를 차감하지 않습니다.') ?>
                <input type="text" name="kapp_memo_send_point" value="<?php echo $config['kapp_memo_send_point'] ?>" id="kapp_memo_send_point" required class="required frm_input" size="5"> 점
            </td> -->
        </tr>
        <!-- <tr>
            <th scope="row"><label for="cf_cut_name">이름(닉네임) 표시</label></th>
            <td colspan="3">
                <input type="text" name="kapp_cut_name" value="<?php echo $config['kapp_cut_name'] ?>" id="kapp_cut_name" class="frm_input" size="5"> 자리만 표시
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_nick_modify">닉네임 수정</label></th>
            <td>수정하면 <input type="text" name="kapp_nick_modify" value="<?php echo $config['kapp_nick_modify'] ?>" id="kapp_nick_modify" class="frm_input" size="3"> 일 동안 바꿀 수 없음</td>
            <th scope="row"><label for="cf_open_modify">정보공개 수정</label></th>
            <td>수정하면 <input type="text" name="kapp_open_modify" value="<?php echo $config['kapp_open_modify'] ?>" id="kapp_open_modify" class="frm_input" size="3"> 일 동안 바꿀 수 없음</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_new_del">최근게시물 삭제</label></th>
            <td>
                <?php echo help('설정일이 지난 최근게시물 자동 삭제') ?>
                <input type="text" name="kapp_new_del" value="<?php echo $config['kapp_new_del'] ?>" id="kapp_new_del" class="frm_input" size="5"> 일
            </td>
            <th scope="row"><label for="cf_memo_del">쪽지 삭제</label></th>
            <td>
                <?php echo help('설정일이 지난 쪽지 자동 삭제') ?>
                <input type="text" name="kapp_memo_del" value="<?php echo $config['kapp_memo_del'] ?>" id="kapp_memo_del" class="frm_input" size="5"> 일
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_visit_del">접속자로그 삭제</label></th>
            <td>
                <?php echo help('설정일이 지난 접속자 로그 자동 삭제') ?>
                <input type="text" name="kapp_visit_del" value="<?php echo $config['kapp_visit_del'] ?>" id="kapp_visit_del" class="frm_input" size="5"> 일
            </td>
            <th scope="row"><label for="cf_popular_del">인기검색어 삭제</label></th>
            <td>
                <?php echo help('설정일이 지난 인기검색어 자동 삭제') ?>
                <input type="text" name="kapp_popular_del" value="<?php echo $config['kapp_popular_del'] ?>" id="kapp_popular_del" class="frm_input" size="5"> 일
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_login_minutes">현재 접속자</label></th>
            <td>
                <?php echo help('설정값 이내의 접속자를 현재 접속자로 인정') ?>
                <input type="text" name="kapp_login_minutes" value="<?php echo $config['kapp_login_minutes'] ?>" id="kapp_login_minutes" class="frm_input" size="3"> 분
            </td>
            <th scope="row"><label for="cf_new_rows">최근게시물 라인수</label></th>
            <td>
                <?php echo help('목록 한페이지당 라인수') ?>
                <input type="text" name="kapp_new_rows" value="<?php echo $config['kapp_new_rows'] ?>" id="kapp_new_rows" class="frm_input" size="3"> 라인
            </td>
        </tr> -->
        <tr>
            <th scope="row"><label for="cf_page_rows">한페이지당 라인수</label></th>
            <td>
                <?php echo help('목록(리스트) 한페이지당 라인수') ?>
                <input type="text" name="kapp_page_rows" value="<?php echo $config['kapp_page_rows'] ?>" id="kapp_page_rows" class="frm_input" size="3"> 라인
            </td>
            <th scope="row"><label for="cf_mobile_page_rows">모바일 한페이지당 라인수</label></th>
            <td>
                <?php echo help('모바일 목록 한페이지당 라인수') ?>
                <input type="text" name="kapp_mobile_page_rows" value="<?php echo $config['kapp_mobile_page_rows'] ?>" id="kapp_mobile_page_rows" class="frm_input" size="3"> 라인
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_write_pages">페이지 표시 수<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="kapp_write_pages" value="<?php echo $config['kapp_write_pages'] ?>" id="kapp_write_pages" required class="required numeric frm_input" size="3"> 페이지씩 표시</td>
            <th scope="row"><label for="cf_mobile_pages">모바일 페이지 표시 수<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="kapp_mobile_pages" value="<?php echo $config['kapp_mobile_pages'] ?>" id="kapp_mobile_pages" required class="required numeric frm_input" size="3"> 페이지씩 표시</td>
        </tr>

        <!-- <tr>
            <th scope="row"><label for="cf_new_skin">최근게시물 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('new', 'cf_new_skin', 'cf_new_skin', $config['kapp_new_skin'], 'required'); ?>
            </td>
            <th scope="row"><label for="cf_mobile_new_skin">모바일<br>최근게시물 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('new', 'cf_mobile_new_skin', 'cf_mobile_new_skin', $config['kapp_mobile_new_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_search_skin">검색 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('search', 'cf_search_skin', 'cf_search_skin', $config['kapp_search_skin'], 'required'); ?>
            </td>
            <th scope="row"><label for="cf_mobile_search_skin">모바일 검색 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('search', 'cf_mobile_search_skin', 'cf_mobile_search_skin', $config['kapp_mobile_search_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_connect_skin">접속자 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('connect', 'cf_connect_skin', 'cf_connect_skin', $config['kapp_connect_skin'], 'required'); ?>
            </td>
            <th scope="row"><label for="cf_mobile_connect_skin">모바일 접속자 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('connect', 'cf_mobile_connect_skin', 'cf_mobile_connect_skin', $config['kapp_mobile_connect_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_faq_skin">FAQ 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('faq', 'cf_faq_skin', 'cf_faq_skin', $config['kapp_faq_skin'], 'required'); ?>
            </td>
            <th scope="row"><label for="cf_mobile_faq_skin">모바일 FAQ 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('faq', 'cf_mobile_faq_skin', 'cf_mobile_faq_skin', $config['kapp_mobile_faq_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_editor">에디터 선택</label></th>
            <td colspan="3">
                <?php echo help(KAPP_EDITOR_URL.' 밑의 DHTML 에디터 폴더를 선택합니다.') ?>
                <select name="kapp_editor" id="kapp_editor">
                <?php
                $arr = get_skin_dir('', KAPP_EDITOR_PATH);
                for ($i=0; $i<count($arr); $i++) {
                    if ($i == 0) echo "<option value=\"\">사용안함</option>";
                    echo "<option value=\"".$arr[$i]."\"".get_selected($config['kapp_editor'], $arr[$i]).">".$arr[$i]."</option>\n";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_captcha_mp3">음성캡챠 선택<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
                <?php echo help(KAPP_CAPTCHA_URL.'/mp3 밑의 음성 폴더를 선택합니다.') ?>
                <select name="kapp_captcha_mp3" id="kapp_captcha_mp3" required class="required">
                <?php
                $arr = get_skin_dir('mp3', KAPP_CAPTCHA_PATH);
                for ($i=0; $i<count($arr); $i++) {
                    if ($i == 0) echo "<option value=\"\">선택</option>";
                    echo "<option value=\"".$arr[$i]."\"".get_selected($config['kapp_captcha_mp3'], $arr[$i]).">".$arr[$i]."</option>\n";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_use_copy_log">복사, 이동시 로그</label></th>
            <td colspan="3">
                <?php echo help('게시물 아래에 누구로 부터 복사, 이동됨 표시') ?>
                <input type="checkbox" name="kapp_use_copy_log" value="1" id="kapp_use_copy_log" <?php echo $config['kapp_use_copy_log']?'checked':''; ?>> 남김
            </td>
        </tr> -->
        <tr>
            <th scope="row"><label for="kapp_point_term">포인트 유효기간</label></th>
            <td colspan="3">
                <?php echo help('기간을 0으로 설정시 포인트 유효기간이 적용되지 않습니다.') ?>
                <input type="text" name="kapp_point_term" value="<?php echo $config['kapp_point_term']; ?>" id="kapp_point_term" required class="required frm_input" size="5"> 일
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_possible_ip">접근가능 IP</label></th>
            <td>
                <?php echo help('입력된 IP의 컴퓨터만 접근할 수 있습니다.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                <textarea name="kapp_possible_ip" id="kapp_possible_ip"><?php echo $config['kapp_possible_ip'] ?></textarea>
            </td>
            <th scope="row"><label for="cf_intercept_ip">접근차단 IP</label></th>
            <td>
                <?php echo help('입력된 IP의 컴퓨터는 접근할 수 없음.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                <textarea name="kapp_intercept_ip" id="kapp_intercept_ip"><?php echo $config['kapp_intercept_ip'] ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_analytics">방문자분석 스크립트</label></th>
            <td colspan="3">
                <?php echo help('방문자분석 스크립트 코드를 입력합니다. 예) 구글 애널리틱스'); ?>
                <textarea name="kapp_analytics" id="kapp_analytics"><?php echo $config['kapp_analytics']; ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_add_meta">추가 메타태그</label></th>
            <td colspan="3">
                <?php echo help('추가로 사용하실 meta 태그를 입력합니다.'); ?>
                <textarea name="kapp_add_meta" id="kapp_add_meta"><?php echo $config['kapp_add_meta']; ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_syndi_token">네이버 신디케이션 연동키</label></th>
            <td colspan="3">
                <?php if (!function_exists('curl_init')) echo help('<b>경고) curl이 지원되지 않아 네이버 신디케이션을 사용할수 없습니다.</b>'); ?>
                <?php echo help('네이버 신디케이션 연동키(token)을 입력하면 네이버 신디케이션을 사용할 수 있습니다.<br>연동키는 <a href="http://webmastertool.naver.com/" target="_blank"><u>네이버 웹마스터도구</u></a> -> 네이버 신디케이션에서 발급할 수 있습니다.') ?>
                <input type="text" name="kapp_syndi_token" value="<?php echo $config['kapp_syndi_token'] ?>" id="kapp_syndi_token" class="frm_input" size="70">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_syndi_except">네이버 신디케이션 제외게시판</label></th>
            <td colspan="3">
                <?php echo help('네이버 신디케이션 수집에서 제외할 게시판 아이디를 | 로 구분하여 입력하십시오. 예) notice|adult<br>참고로 그룹접근사용 게시판, 글읽기 권한 2 이상 게시판, 비밀글은 신디케이션 수집에서 제외됩니다.') ?>
                <input type="text" name="kapp_syndi_except" value="<?php echo $config['kapp_syndi_except'] ?>" id="kapp_syndi_except" class="frm_input" size="70">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo preg_replace('#</div>$#i', '<button type="button" class="get_theme_confc" data-type="conf_skin">테마 스킨설정 가져오기</button></div>', $frm_submit); ?>

<section id="anc_cf_board">
    <h2 class="h2_frm">K-APP Basic </h2><!-- 게시판 기본 설정 -->
    <?php //echo $pg_anchor ?>

    <div class="local_desc02 local_desc">
        <p>각 게시판 관리에서 개별적으로 설정 가능합니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>--- 게시판 기본 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_delay_sec">글쓰기 간격<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="kapp_delay_sec" value="<?php echo $config['kapp_delay_sec'] ?>" id="kapp_delay_sec" required class="required numeric frm_input" size="3"> 초 지난후 가능</td>
            <th scope="row"><label for="cf_link_target">새창 링크</label></th>
            <td>
                <?php echo help('글내용중 자동 링크되는 타켓을 지정합니다.') ?>
                <select name="kapp_link_target" id="kapp_link_target">
                    <option value="_blank"<?php echo get_selected($config['kapp_link_target'], '_blank') ?>>_blank</option>
                    <option value="_self"<?php echo get_selected($config['kapp_link_target'], '_self') ?>>_self</option>
                    <option value="_top"<?php echo get_selected($config['kapp_link_target'], '_top') ?>>_top</option>
                    <option value="_new"<?php echo get_selected($config['kapp_link_target'], '_new') ?>>_new</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_read_point">글읽기 포인트<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="kapp_read_point" value="<?php echo $config['kapp_read_point'] ?>" id="kapp_read_point" required class="required frm_input" size="3"> 점</td>
            <th scope="row"><label for="cf_write_point">글쓰기 포인트</label></th>
            <td><input type="text" name="kapp_write_point" value="<?php echo $config['kapp_write_point'] ?>" id="kapp_write_point" required class="required frm_input" size="3"> 점</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_comment_point">댓글쓰기 포인트</label></th>
            <td><input type="text" name="kapp_comment_point" value="<?php echo $config['kapp_comment_point'] ?>" id="kapp_comment_point" required class="required frm_input" size="3"> 점</td>
            <th scope="row"><label for="cf_download_point">다운로드 포인트</label></th>
            <td><input type="text" name="kapp_download_point" value="<?php echo $config['kapp_download_point'] ?>" id="kapp_download_point" required class="required frm_input" size="3"> 점</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_search_part">검색 단위</label></th>
            <td colspan="3"><input type="text" name="kapp_search_part" value="<?php echo $config['kapp_search_part'] ?>" id="kapp_search_part" class="frm_input" size="4"> 건 단위로 검색</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_image_extension">이미지 업로드 확장자</label></th>
            <td colspan="3">
                <?php echo help('게시판 글작성시 이미지 파일 업로드 가능 확장자. | 로 구분') ?>
                <input type="text" name="kapp_image_extension" value="<?php echo $config['kapp_image_extension'] ?>" id="kapp_image_extension" class="frm_input" size="70">
            </td>
        </tr>
        <!-- <tr>
            <th scope="row"><label for="cf_flash_extension">플래쉬 업로드 확장자</label></th>
            <td colspan="3">
                <?php echo help('게시판 글작성시 플래쉬 파일 업로드 가능 확장자. | 로 구분') ?>
                <input type="text" name="kapp_flash_extension" value="<?php echo $config['kapp_flash_extension'] ?>" id="kapp_flash_extension" class="frm_input" size="70">
            </td>
        </tr> -->
        <tr>
            <th scope="row"><label for="cf_movie_extension">동영상 업로드 확장자</label></th>
            <td colspan="3">
                <?php echo help('게시판 글작성시 동영상 파일 업로드 가능 확장자. | 로 구분') ?>
                <input type="text" name="kapp_movie_extension" value="<?php echo $config['kapp_movie_extension'] ?>" id="kapp_movie_extension" class="frm_input" size="70">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_filter">단어 필터링</label></th>
            <td colspan="3">
                <?php echo help('입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.') ?>
                <textarea name="kapp_filter" id="kapp_filter" rows="7"><?php echo $config['kapp_filter'] ?></textarea>
             </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_cf_join">
    <h2 class="h2_frm">회원가입 설정</h2>
    <?php //echo $pg_anchor ?>

    <div class="local_desc02 local_desc">
        <p>회원가입 시 사용할 스킨과 입력 받을 정보 등을 설정할 수 있습니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!-- <tr>
            <th scope="row"><label for="cf_member_skin">회원 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('member', 'kapp_member_skin', 'kapp_member_skin', $config['kapp_member_skin'], 'required'); ?>
            </td>
            <th scope="row"><label for="kapp_mobile_member_skin">모바일<br>회원 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('member', 'kapp_mobile_member_skin', 'kapp_mobile_member_skin', $config['kapp_mobile_member_skin'], 'required'); ?>
            </td>
        </tr> -->
        <!-- <tr>
            <th scope="row">홈페이지 입력</th>
            <td>
                <input type="checkbox" name="kapp_use_homepage" value="1" id="kapp_use_homepage" <?php echo $config['kapp_use_homepage']?'checked':''; ?>> <label for="cf_use_homepage">보이기</label>
                <input type="checkbox" name="kapp_req_homepage" value="1" id="kapp_req_homepage" <?php echo $config['kapp_req_homepage']?'checked':''; ?>> <label for="cf_req_homepage">필수입력</label>
            </td>
            <th scope="row">주소 입력</th>
            <td>
                <input type="checkbox" name="kapp_use_addr" value="1" id="kapp_use_addr" <?php echo $config['kapp_use_addr']?'checked':''; ?>> <label for="cf_use_addr">보이기</label>
                <input type="checkbox" name="kapp_req_addr" value="1" id="kapp_req_addr" <?php echo $config['kapp_req_addr']?'checked':''; ?>> <label for="cf_req_addr">필수입력</label>
            </td>
        </tr> -->
        <tr>
            <th scope="row">전화번호 입력</th>
            <td>
                <input type="checkbox" name="kapp_use_tel" value="1" id="kapp_use_tel" <?php echo $config['kapp_use_tel']?'checked':''; ?>> <label for="cf_use_tel">보이기</label>
                <input type="checkbox" name="kapp_req_tel" value="1" id="kapp_req_tel" <?php echo $config['kapp_req_tel']?'checked':''; ?>> <label for="cf_req_tel">필수입력</label>
            </td>
            <th scope="row">휴대폰번호 입력</th>
            <td>
                <input type="checkbox" name="kapp_use_hp" value="1" id="kapp_use_hp" <?php echo $config['kapp_use_hp']?'checked':''; ?>> <label for="cf_use_hp">보이기</label>
                <input type="checkbox" name="kapp_req_hp" value="1" id="kapp_req_hp" <?php echo $config['kapp_req_hp']?'checked':''; ?>> <label for="cf_req_hp">필수입력</label>
            </td>
        </tr>
        <tr>
            <th scope="row">서명 입력</th>
            <td>
                <input type="checkbox" name="kapp_use_signature" value="1" id="kapp_use_signature" <?php echo $config['kapp_use_signature']?'checked':''; ?>> <label for="cf_use_signature">보이기</label>
                <input type="checkbox" name="kapp_req_signature" value="1" id="kapp_req_signature" <?php echo $config['kapp_req_signature']?'checked':''; ?>> <label for="cf_req_signature">필수입력</label>
            </td>
            <th scope="row">자기소개 입력</th>
            <td>
                <input type="checkbox" name="kapp_use_profile" value="1" id="kapp_use_profile" <?php echo $config['kapp_use_profile']?'checked':''; ?>> <label for="cf_use_profile">보이기</label>
                <input type="checkbox" name="kapp_req_profile" value="1" id="kapp_req_profile" <?php echo $config['kapp_req_profile']?'checked':''; ?>> <label for="cf_req_profile">필수입력</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_register_level">회원가입시 권한</label></th>
            <td><?php echo get_member_level_select('kapp_register_level', 1, 9, $config['kapp_register_level']) ?></td>
            <th scope="row"><label for="cf_register_point">회원가입시 포인트</label></th>
            <td><input type="text" name="kapp_register_point" value="<?php echo $config['kapp_register_point'] ?>" id="kapp_register_point" class="frm_input" size="5"> 점</td>
        </tr>
        <tr>
            <th scope="row" id="th310"><label for="cf_leave_day">회원탈퇴후 삭제일</label></th>
            <td colspan="3"><input type="text" name="kapp_leave_day" value="<?php echo $config['kapp_leave_day'] ?>" id="kapp_leave_day" class="frm_input" size="2"> 일 후 자동 삭제</td>
        </tr>
        <!-- <tr>
            <th scope="row"><label for="cf_use_member_icon">회원아이콘 사용</label></th>
            <td>
                <?php echo help('게시물에 게시자 닉네임 대신 아이콘 사용') ?>
                <select name="kapp_use_member_icon" id="kapp_use_member_icon">
                    <option value="0"<?php echo get_selected($config['kapp_use_member_icon'], '0') ?>>미사용
                    <option value="1"<?php echo get_selected($config['kapp_use_member_icon'], '1') ?>>아이콘만 표시
                    <option value="2"<?php echo get_selected($config['kapp_use_member_icon'], '2') ?>>아이콘+이름 표시
                </select>
            </td>
            <th scope="row"><label for="cf_icon_level">아이콘 업로드 권한</label></th>
            <td><?php echo get_member_level_select('kapp_icon_level', 1, 9, $config['kapp_icon_level']) ?> 이상</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_member_icon_size">회원아이콘 용량</label></th>
            <td><input type="text" name="kapp_member_icon_size" value="<?php echo $config['kapp_member_icon_size'] ?>" id="kapp_member_icon_size" class="frm_input" size="10"> 바이트 이하</td>
            <th scope="row">회원아이콘 사이즈</th>
            <td>
                <label for="cf_member_icon_width">가로</label>
                <input type="text" name="kapp_member_icon_width" value="<?php echo $config['kapp_member_icon_width'] ?>" id="kapp_member_icon_width" class="frm_input" size="2">
                <label for="cf_member_icon_height">세로</label>
                <input type="text" name="kapp_member_icon_height" value="<?php echo $config['kapp_member_icon_height'] ?>" id="kapp_member_icon_height" class="frm_input" size="2">
                픽셀 이하
            </td>
        </tr> -->
        <tr>
            <th scope="row"><label for="cf_use_recommend">추천인제도 사용</label></th>
            <td><input type="checkbox" name="kapp_use_recommend" value="1" id="kapp_use_recommend" <?php echo $config['kapp_use_recommend']?'checked':''; ?>> 사용</td>
            <th scope="row"><label for="cf_recommend_point">추천인 포인트</label></th>
            <td><input type="text" name="kapp_recommend_point" value="<?php echo $config['kapp_recommend_point'] ?>" id="kapp_recommend_point" class="frm_input"> 점</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_prohibit_id">아이디,닉네임 금지단어</label></th>
            <td>
                <?php echo help('회원아이디, 닉네임으로 사용할 수 없는 단어를 정합니다. 쉼표 (,) 로 구분') ?>
                <textarea name="kapp_prohibit_id" id="kapp_prohibit_id" rows="5"><?php echo $config['kapp_prohibit_id'] ?></textarea>
            </td>
            <th scope="row"><label for="cf_prohibit_email">입력 금지 메일</label></th>
            <td>
                <?php echo help('입력 받지 않을 도메인을 지정합니다. 엔터로 구분 ex) hotmail.com') ?>
                <textarea name="kapp_prohibit_email" id="kapp_prohibit_email" rows="5"><?php echo $config['kapp_prohibit_email'] ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_stipulation">회원가입약관</label></th>
            <td colspan="3"><textarea name="kapp_stipulation" id="kapp_stipulation" rows="10"><?php echo $config['kapp_stipulation'] ?></textarea></td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_privacy">개인정보처리방침</label></th>
            <td colspan="3"><textarea id="kapp_privacy" name="kapp_privacy" rows="10"><?php echo $config['kapp_privacy'] ?></textarea></td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo preg_replace('#</div>$#i', '<button type="button" class="get_theme_confc" data-type="conf_member">테마 회원스킨설정 가져오기</button></div>', $frm_submit); ?>

<section id="anc_cf_cert">
    <h2 class="h2_frm">본인확인 설정</h2>
    <?php //echo $pg_anchor ?>

    <div class="local_desc02 local_desc">
        <p>
            회원가입 시 본인확인 수단을 설정합니다.<br>
            실명과 휴대폰 번호 그리고 본인확인 당시에 성인인지의 여부를 저장합니다.<br>
            게시판의 경우 본인확인 또는 성인여부를 따져 게시물 조회 및 쓰기 권한을 줄 수 있습니다.
        </p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>본인확인 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_cert_use">본인확인</label></th>
            <td>
                <select name="kapp_cert_use" id="kapp_cert_use">
                    <?php echo option_selected("0", $config['kapp_cert_use'], "사용안함"); ?>
                    <?php echo option_selected("1", $config['kapp_cert_use'], "테스트"); ?>
                    <?php echo option_selected("2", $config['kapp_cert_use'], "실서비스"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_ipin">아이핀 본인확인</label></th>
            <td class="cf_cert_service">
                <select name="kapp_cert_ipin" id="kapp_cert_ipin">
                    <?php echo option_selected("",    $config['kapp_cert_ipin'], "사용안함"); ?>
                    <?php echo option_selected("kcb", $config['kapp_cert_ipin'], "코리아크레딧뷰로(KCB) 아이핀"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_hp">휴대폰 본인확인</label></th>
            <td class="cf_cert_service">
                <select name="kapp_cert_hp" id="kapp_cert_hp">
                    <?php echo option_selected("",    $config['kapp_cert_hp'], "사용안함"); ?>
                    <?php echo option_selected("kcb", $config['kapp_cert_hp'], "코리아크레딧뷰로(KCB) 휴대폰 본인확인"); ?>
                    <?php echo option_selected("kcp", $config['kapp_cert_hp'], "NHN KCP 휴대폰 본인확인"); ?>
                    <?php echo option_selected("lg",  $config['kapp_cert_hp'], "LG유플러스 휴대폰 본인확인"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_kcb_cd">코리아크레딧뷰로<br>KCB 회원사ID</label></th>
            <td class="cf_cert_service">
                <?php echo help('KCB 회원사ID를 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, KCB와 계약체결 후 회원사ID를 발급 받으실 수 있습니다.<br>이용하시려는 서비스에 대한 계약을 아이핀, 휴대폰 본인확인 각각 체결해주셔야 합니다.<br>아이핀 본인확인 테스트의 경우에는 KCB 회원사ID가 필요 없으나,<br>휴대폰 본인확인 테스트의 경우 KCB 에서 따로 발급 받으셔야 합니다.') ?>
                <input type="text" name="kapp_cert_kcb_cd" value="<?php echo $config['kapp_cert_kcb_cd'] ?>" id="kapp_cert_kcb_cd" class="frm_input" size="20"> <a href="http://sir.kr/main/service/b_ipin.php" target="_blank" class="btn_frmline">KCB 아이핀 서비스 신청페이지</a>
                <a href="http://sir.kr/main/service/b_cert.php" target="_blank" class="btn_frmline">KCB 휴대폰 본인확인 서비스 신청페이지</a>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_kcp_cd">NHN KCP 사이트코드</label></th>
            <td class="cf_cert_service">
                <?php echo help('SM으로 시작하는 5자리 사이트 코드중 뒤의 3자리만 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, 본인확인 서비스 신청페이지에서 서비스 신청 후 사이트코드를 발급 받으실 수 있습니다.') ?>
                <span class="sitecode">SM</span>
                <input type="text" name="kapp_cert_kcp_cd" value="<?php echo $config['kapp_cert_kcp_cd'] ?>" id="kapp_cert_kcp_cd" class="frm_input" size="3"> <a href="http://sir.kr/main/service/p_cert.php" target="_blank" class="btn_frmline">NHN KCP 휴대폰 본인확인 서비스 신청페이지</a>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_lg_mid">LG유플러스 상점아이디</label></th>
            <td class="cf_cert_service">
                <?php echo help('LG유플러스 상점아이디 중 si_를 제외한 나머지 아이디만 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, 본인확인 서비스 신청페이지에서 서비스 신청 후 상점아이디를 발급 받으실 수 있습니다.<br><strong>LG유플러스 휴대폰본인확인은 ActiveX 설치가 필요하므로 Internet Explorer 에서만 사용할 수 있습니다.</strong>') ?>
                <span class="sitecode">si_</span>
                <input type="text" name="kapp_lg_mid" value="<?php echo $config['kapp_lg_mid'] ?>" id="kapp_lg_mid" class="frm_input" size="20"> <a href="http://sir.kr/main/service/lg_cert.php" target="_blank" class="btn_frmline">LG유플러스 본인확인 서비스 신청페이지</a>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_lg_mert_key">LG유플러스 MERT KEY</label></th>
            <td class="cf_cert_service">
                <?php echo help('LG유플러스 상점MertKey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실 수 있습니다.') ?>
                <input type="text" name="kapp_lg_mert_key" value="<?php echo $config['kapp_lg_mert_key'] ?>" id="kapp_lg_mert_key" class="frm_input" size="40">
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_limit">본인확인 이용제한</label></th>
            <td class="cf_cert_service">
                <?php echo help('하루동안 아이핀과 휴대폰 본인확인 인증 이용회수를 제한할 수 있습니다.<br>회수제한은 실서비스에서 아이핀과 휴대폰 본인확인 인증에 개별 적용됩니다.<br>0 으로 설정하시면 회수제한이 적용되지 않습니다.'); ?>
                <input type="text" name="kapp_cert_limit" value="<?php echo $config['kapp_cert_limit']; ?>" id="kapp_cert_limit" class="frm_input" size="3"> 회
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_req">본인확인 필수</label></th>
            <td class="cf_cert_service">
                <?php echo help('회원가입 때 본인확인을 필수로 할지 설정합니다. 필수로 설정하시면 본인확인을 하지 않은 경우 회원가입이 안됩니다.'); ?>
                <input type="checkbox" name="kapp_cert_req" value="1" id="kapp_cert_req"<?php echo get_checked($config['kapp_cert_req'], 1); ?>> 예
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

<!-- <section id="anc_cf_mail">
    <h2 class="h2_frm">기본 메일 환경 설정</h2>
    <?php //echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>기본 메일 환경 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_use">메일발송 사용</label></th>
            <td>
                <?php echo help('체크하지 않으면 메일발송을 아예 사용하지 않습니다. 메일 테스트도 불가합니다.') ?>
                <input type="checkbox" name="kapp_email_use" value="1" id="kapp_email_use" <?php echo $config['kapp_email_use']?'checked':''; ?>> 사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_use_email_certify">메일인증 사용</label></th>
            <td>
                <?php echo help('메일에 배달된 인증 주소를 클릭하여야 회원으로 인정합니다.'); ?>
                <input type="checkbox" name="kapp_use_email_certify" value="1" id="kapp_use_email_certify" <?php echo $config['kapp_use_email_certify']?'checked':''; ?>> 사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_formmail_is_member">폼메일 사용 여부</label></th>
            <td>
                <?php echo help('체크하지 않으면 비회원도 사용 할 수 있습니다.') ?>
                <input type="checkbox" name="kapp_formmail_is_member" value="1" id="kapp_formmail_is_member" <?php echo $config['kapp_formmail_is_member']?'checked':''; ?>> 회원만 사용
            </td>
        </tr>
        </table>
    </div>
</section> -->

<?php //echo $frm_submit; ?>

<!-- <section id="anc_cf_article_mail">
    <h2 class="h2_frm">게시판 글 작성 시 메일 설정</h2>
    <?php //echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 글 작성 시 메일 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_wr_super_admin">최고관리자</label></th>
            <td>
                <?php echo help('최고관리자에게 메일을 발송합니다.') ?>
                <input type="checkbox" name="kapp_email_wr_super_admin" value="1" id="kapp_email_wr_super_admin" <?php echo $config['kapp_email_wr_super_admin']?'checked':''; ?>> 사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_wr_group_admin">그룹관리자</label></th>
            <td>
                <?php echo help('그룹관리자에게 메일을 발송합니다.') ?>
                <input type="checkbox" name="kapp_email_wr_group_admin" value="1" id="kapp_email_wr_group_admin" <?php echo $config['kapp_email_wr_group_admin']?'checked':''; ?>> 사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_wr_board_admin">게시판관리자</label></th>
            <td>
                <?php echo help('게시판관리자에게 메일을 발송합니다.') ?>
                <input type="checkbox" name="kapp_email_wr_board_admin" value="1" id="kapp_email_wr_board_admin" <?php echo $config['kapp_email_wr_board_admin']?'checked':''; ?>> 사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_wr_write">원글작성자</label></th>
            <td>
                <?php echo help('게시자님께 메일을 발송합니다.') ?>
                <input type="checkbox" name="kapp_email_wr_write" value="1" id="kapp_email_wr_write" <?php echo $config['kapp_email_wr_write']?'checked':''; ?>> 사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_wr_comment_all">댓글작성자</label></th>
            <td>
                <?php echo help('원글에 댓글이 올라오는 경우 댓글 쓴 모든 분들께 메일을 발송합니다.') ?>
                <input type="checkbox" name="kapp_email_wr_comment_all" value="1" id="kapp_email_wr_comment_all" <?php echo $config['kapp_email_wr_comment_all']?'checked':''; ?>> 사용
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section> -->

<?php //echo $frm_submit; ?>

<!-- <section id="anc_cf_join_mail">
    <h2 class="h2_frm">회원가입 시 메일 설정</h2>
    <?php //echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입 시 메일 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_mb_super_admin">최고관리자 메일발송</label></th>
            <td>
                <?php echo help('최고관리자에게 메일을 발송합니다.') ?>
                <input type="checkbox" name="kapp_email_mb_super_admin" value="1" id="kapp_email_mb_super_admin" <?php echo $config['kapp_email_mb_super_admin']?'checked':''; ?>> 사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_mb_member">회원님께 메일발송</label></th>
            <td>
                <?php echo help('회원가입한 회원님께 메일을 발송합니다.') ?>
                <input type="checkbox" name="kapp_email_mb_member" value="1" id="kapp_email_mb_member" <?php echo $config['kapp_email_mb_member']?'checked':''; ?>> 사용
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section> -->

<?php //echo $frm_submit; ?>

<!-- <section id="anc_cf_vote_mail">
    <h2 class="h2_frm">투표 기타의견 작성 시 메일 설정</h2>
    <?php //echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>투표 기타의견 작성 시 메일 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_po_super_admin">최고관리자 메일발송</label></th>
            <td>
                <?php echo help('최고관리자에게 메일을 발송합니다.') ?>
                <input type="checkbox" name="kapp_email_po_super_admin" value="1" id="kapp_email_po_super_admin" <?php echo $config['kapp_email_po_super_admin']?'checked':''; ?>> 사용
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section> -->

<?php //echo $frm_submit; ?>

<section id="anc_cf_sns">
    <h2 class="h2_frm">소셜네트워크서비스(SNS : Social Network Service)</h2>
    <?php //echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>소셜네트워크서비스 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_facebook_appid">페이스북 앱 ID</label></th>
            <td>
                <input type="text" name="kapp_facebook_appid" value="<?php echo $config['kapp_facebook_appid'] ?>" id="kapp_facebook_appid" class="frm_input"> <a href="https://developers.facebook.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
            <th scope="row"><label for="cf_facebook_secret">페이스북 앱 Secret</label></th>
            <td>
                <input type="text" name="kapp_facebook_secret" value="<?php echo $config['kapp_facebook_secret'] ?>" id="kapp_facebook_secret" class="frm_input" size="35">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_twitter_key">트위터 컨슈머 Key</label></th>
            <td>
                <input type="text" name="kapp_twitter_key" value="<?php echo $config['kapp_twitter_key'] ?>" id="kapp_twitter_key" class="frm_input"> <a href="https://dev.twitter.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
            <th scope="row"><label for="cf_twitter_secret">트위터 컨슈머 Secret</label></th>
            <td>
                <input type="text" name="kapp_twitter_secret" value="<?php echo $config['kapp_twitter_secret'] ?>" id="kapp_twitter_secret" class="frm_input" size="35">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_googl_shorturl_apikey">구글 짧은주소 API Key</label></th>
            <td>
                <input type="text" name="kapp_googl_shorturl_apikey" value="<?php echo $config['kapp_googl_shorturl_apikey'] ?>" id="kapp_googl_shorturl_apikey" class="frm_input"> <a href="http://code.google.com/apis/console/" target="_blank" class="btn_frmline">API Key 등록하기</a>
            </td>
            <th scope="row"><label for="cf_kakao_js_apikey">카카오 Javascript API Key</label></th>
            <td>
                <input type="text" name="kapp_kakao_js_apikey" value="<?php echo $config['kapp_kakao_js_apikey'] ?>" id="kapp_kakao_js_apikey" class="frm_input"> <a href="http://developers.kakao.com/" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php //echo $frm_submit; ?>

<!-- <section id="anc_cf_lay">
    <h2 class="h2_frm">레이아웃 추가설정</h2>
    <?php //echo $pg_anchor; ?>

    <div class="local_desc02 local_desc">
        <p>기본 설정된 파일 경로 및 script, css 를 추가하거나 변경할 수 있습니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>레이아웃 추가설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_add_script">추가 script, css</label></th>
            <td>
                <?php echo help('HTML의 &lt;/HEAD&gt; 태그위로 추가될 JavaScript와 css 코드를 설정합니다.<br>관리자 페이지에서는 이 코드를 사용하지 않습니다.') ?>
                <textarea name="kapp_add_script" id="kapp_add_script"><?php echo get_text($config['kapp_add_script']); ?></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section> -->

<?php echo $frm_submit; ?>

<section id="anc_cf_sms">
    <h2 class="h2_frm">SMS</h2>
    <?php echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>SMS 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_sms_use">SMS 사용</label></th>
            <td>
                <select id="kapp_sms_use" name="kapp_sms_use">
                    <option value="" <?php echo get_selected($config['kapp_sms_use'], ''); ?>>사용안함</option>
                    <option value="icode" <?php echo get_selected($config['kapp_sms_use'], 'icode'); ?>>아이코드</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_sms_type">SMS 전송유형</label></th>
            <td>
                <?php echo help("전송유형을 SMS로 선택하시면 최대 80바이트까지 전송하실 수 있으며<br>LMS로 선택하시면 90바이트 이하는 SMS로, 그 이상은 1500바이트까지 LMS로 전송됩니다.<br>요금은 건당 SMS는 16원, LMS는 48원입니다."); ?>
                <select id="kapp_sms_type" name="kapp_sms_type">
                    <option value="" <?php echo get_selected($config['kapp_sms_type'], ''); ?>>SMS</option>
                    <option value="LMS" <?php echo get_selected($config['kapp_sms_type'], 'LMS'); ?>>LMS</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_icode_id">아이코드 회원아이디</label></th>
            <td>
                <?php echo help("아이코드에서 사용하시는 회원아이디를 입력합니다."); ?>
                <input type="text" name="kapp_icode_id" value="<?php echo $config['kapp_icode_id']; ?>" id="kapp_icode_id" class="frm_input" size="20">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_icode_pw">아이코드 비밀번호</label></th>
            <td>
                <?php echo help("아이코드에서 사용하시는 비밀번호를 입력합니다."); ?>
                <input type="password" name="kapp_icode_pw" value="<?php echo $config['kapp_icode_pw']; ?>" id="kapp_icode_pw" class="frm_input">
            </td>
        </tr>
        <tr>
            <th scope="row">요금제</th>
            <td>
                <input type="hidden" name="kapp_icode_server_ip" value="<?php echo $config['kapp_icode_server_ip']; ?>">
                <?php
                    if ($userinfo['payment'] == 'A') {
                       echo '충전제';
                        echo '<input type="hidden" name="kapp_icode_server_port" value="7295">';
                    } else if ($userinfo['payment'] == 'C') {
                        echo '정액제';
                        echo '<input type="hidden" name="kapp_icode_server_port" value="7296">';
                    } else {
                        echo '가입해주세요.';
                        echo '<input type="hidden" name="kapp_icode_server_port" value="7295">';
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row">아이코드 SMS 신청<br>회원가입</th>
            <td>
                <a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target="_blank" class="btn_frmline">아이코드 회원가입</a>
            </td>
        </tr>
         <?php if ($userinfo['payment'] == 'A') { ?>
        <tr>
            <th scope="row">충전 잔액</th>
            <td colspan="3">
                <?php echo number_format($userinfo['coin']); ?> 원.
                <a href="http://www.icodekorea.com/smsbiz/credit_card_amt.php?icode_id=<?php echo $config['kapp_icode_id']; ?>&amp;icode_passwd=<?php echo $config['kapp_icode_pw']; ?>" target="_blank" class="btn_frmline">충전하기</a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

<!-- <section id="anc_cf_extra">
    <h2 class="h2_frm">여분필드 기본 설정</h2>
    <?php echo $pg_anchor ?>
    <div class="local_desc02 local_desc">
        <p>각 게시판 관리에서 개별적으로 설정 가능합니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>여분필드 기본 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <?php for ($i=1; $i<=10; $i++) { ?>
        <tr>
            <th scope="row">여분필드<?php echo $i ?></th>
            <td class="td_extra">
                <label for="cf_<?php echo $i ?>_subj">여분필드<?php echo $i ?> 제목</label>
                <input type="text" name="kapp_<?php echo $i ?>_subj" value="<?php echo get_text($config['kapp_'.$i.'_subj']) ?>" id="kapp_<?php echo $i ?>_subj" class="frm_input" size="30">
                <label for="cf_<?php echo $i ?>">여분필드<?php echo $i ?> 값</label>
                <input type="text" name="kapp_<?php echo $i ?>" value="<?php echo $config['kapp_'.$i] ?>" id="kapp_<?php echo $i ?>" class="frm_input" size="30">
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section> -->

<?php //echo $frm_submit; ?>

</form>

<script>
$(function(){
    <?php
    if(!$config['kapp_cert_use'])
        echo '$(".cf_cert_service").addClass("cf_cert_hide");';
    ?>
    $("#cf_cert_use").change(function(){
        switch($(this).val()) {
            case "0":
                $(".cf_cert_service").addClass("cf_cert_hide");
                break;
            default:
                $(".cf_cert_service").removeClass("cf_cert_hide");
                break;
        }
    });

    $(".get_theme_confc").on("click", function() {
        var type = $(this).data("type");
        var msg = "기본환경 스킨 설정";
        if(type == "conf_member")
            msg = "기본환경 회원스킨 설정";

        if(!confirm("현재 테마의 "+msg+"을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('kapp_member_skin', 'kapp_mobile_member_skin', 'kapp_new_skin', 'kapp_mobile_new_skin', 'kapp_search_skin', 'kapp_mobile_search_skin', 'kapp_connect_skin', 'kapp_mobile_connect_skin', 'kapp_faq_skin', 'kapp_mobile_faq_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });
});

function fconfigform_submit(f)
{
    f.action = "./config_form_update.php";
    return true;
}
</script>

<?php
// 본인확인 모듈 실행권한 체크
if($config['kapp_cert_use']) {
    // kcb일 때
    if($config['kapp_cert_ipin'] == 'kcb' || $config['kapp_cert_hp'] == 'kcb') {
        // 실행모듈
        if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = KAPP_OKNAME_PATH.'/bin/okname';
            else
                $exe = KAPP_OKNAME_PATH.'/bin/okname_x64';
        } else {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = KAPP_OKNAME_PATH.'/bin/okname.exe';
            else
                $exe = KAPP_OKNAME_PATH.'/bin/oknamex64.exe';
        }

        echo module_exec_check($exe, 'okname');
    }

    // kcp일 때
    if($config['kapp_cert_hp'] == 'kcp') {
        if(PHP_INT_MAX == 2147483647) // 32-bit
            $exe = KAPP_KCPCERT_PATH . '/bin/ct_cli';
        else
            $exe = KAPP_KCPCERT_PATH . '/bin/ct_cli_x64';

        echo module_exec_check($exe, 'ct_cli');
    }

    // LG의 경우 log 디렉토리 체크
    if($config['kapp_cert_hp'] == 'lg') {
        $log_path = KAPP_LGXPAY_PATH.'/lgdacom/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(KAPP_PATH.'/', '', KAPP_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(KAPP_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }
}

include_once ('./admin.tail.php');
?>
