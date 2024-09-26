<?php
if (!defined('_KAPP_')) exit; // 개별 페이지 접근 불가
/*
   kapp_visit_insert.php
   - call : tkher_start_necessary.php
   컴퓨터의 아이피와 쿠키에 저장된 아이피가 다르다면 테이블에 반영함
*/

$kapp_host = isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
$H_ID_IPADDR = $kapp_host . "_" . $member['mb_id'] . "_" . $_SERVER['REMOTE_ADDR'];
$referer = $kapp_host . " : " . $H_ID_IPADDR;

if( get_cookie('kapp_ck_visit_ip') != $H_ID_IPADDR ) { //if( get_cookie('kapp_ck_visit_ip') != $_SERVER['REMOTE_ADDR']) {

    set_cookie('kapp_ck_visit_ip', $H_ID_IPADDR, 86400); // 하루동안 저장

    $remote_addr = escape_trim($_SERVER['REMOTE_ADDR']);// $_SERVER 배열변수 값의 변조를 이용한 SQL Injection 공격을 막는 코드.

	//$sql = " select max(vi_id) as max_vi_id from {$tkher['visit_table']} ";
	$sql = " select * from {$tkher['visit_table']} where vi_ip='{$remote_addr}' and vi_date='".KAPP_TIME_YMD."' ";
	$tmp_row = sql_fetch( $sql );
    //$vi_id = $tmp_row['max_vi_id'] + 1;

    if( isset($_SERVER['HTTP_REFERER']))
        $referer = escape_trim(clean_xss_tags($_SERVER['HTTP_REFERER'])). " : " . $H_ID_IPADDR; 
    $user_agent  = escape_trim(clean_xss_tags($_SERVER['HTTP_USER_AGENT'])); // $_SERVER['HTTP_USER_AGENT'];
    $vi_browser = '';
    $vi_os = '';
    $vi_device = $H_ID_IPADDR;
    /*if( version_compare(phpversion(), '5.3.0', '>=') && defined('KAPP_BROWSCAP_USE') && KAPP_BROWSCAP_USE) {
        include_once('./visit_browscap.inc.php');
    }*/
    //$sql = " insert {$tkher['visit_table']} ( vi_id, vi_ip, vi_date, vi_time, vi_referer, vi_agent, vi_browser, vi_os, vi_device ) values ( {$vi_id}, '{$remote_addr}', '".KAPP_TIME_YMD."', '".KAPP_TIME_HIS."', '{$referer}', '{$user_agent}', '{$vi_browser}', '{$vi_os}', '{$vi_device}' ) ";
    
	if( !isset($tmp_row['vi_ip']) ){
		$sql = " insert {$tkher['visit_table']} ( vi_ip, vi_date, vi_time, vi_referer, vi_agent, vi_browser, vi_os, vi_device ) values (  '{$remote_addr}', '".KAPP_TIME_YMD."', '".KAPP_TIME_HIS."', '{$referer}', '{$user_agent}', '{$vi_browser}', '{$vi_os}', '{$vi_device}' ) ";
		$result = sql_query( $sql ); //sql_query($sql, FALSE);
		if( !$result) { // 등록 실패 즉 중복 발생시에도 카운트를 한다. ================= 보완 필요 =========
			//m_("--- visit insert");
			$sql = " insert {$tkher['visit_sum_table']} ( vs_count, visit_all,  vs_date) values ( 1, 1, '".KAPP_TIME_YMD."' ) ";
			$rt = sql_query( $sql ); //sql_query($sql, FALSE);
			if( !$rt) { // DUPLICATE 오류가 발생한다면 이미 날짜별 행이 생성되었으므로 UPDATE 실행
				$sql = " update {$tkher['visit_sum_table']} set vs_count = vs_count + 1, visit_all = visit_all + 1 where vs_date = '".KAPP_TIME_YMD."' ";
				$result = sql_query($sql);
			}
			// INSERT, UPDATE 된건이 있다면 기본환경설정 테이블에 저장// 방문객 접속시마다 따로 쿼리를 하지 않기 위함 (엄청난 쿼리를 줄임 ^^)

			// 오늘
			$sql = " select vs_count as cnt from {$tkher['visit_sum_table']} where vs_date = '".KAPP_TIME_YMD."' ";
			$row = sql_fetch($sql);
			$vi_today = $row['cnt'];
			// 어제
			$sql = " select vs_count as cnt from {$tkher['visit_sum_table']} where vs_date = DATE_SUB('".KAPP_TIME_YMD."', INTERVAL 1 DAY) ";
			$row = sql_fetch($sql);
			if( isset($row['cnt']) ) $vi_yesterday = $row['cnt'];
			else $vi_yesterday = 0;
			// 최대        $sql = " select max(vs_count) as cnt from {$tkher['visit_sum_table']} ";
			$sql = " select max(visit_all) as cnt from {$tkher['visit_sum_table']} ";
			$row = sql_fetch($sql);
			$vi_max = $row['cnt'];
			// 전체
			$sql = " select sum(vs_count) as total from {$tkher['visit_sum_table']} ";
			$row = sql_fetch($sql);
			$vi_sum = $row['total'];
			$visit = 'today:'.$vi_today.', yestday:'.$vi_yesterday.', max:'.number_format($vi_max).', Total:'.number_format($vi_sum);
			// 기본설정 테이블에 방문자수를 기록한 후	// 방문자수 테이블을 읽지 않고 출력한다.	// 쿼리의 수를 상당부분 줄임
			sql_query(" update {$tkher['config_table']} set kapp_visit = '{$visit}' ");
			
		} else { // ip + date 중복일때 여기를 탄다.
			//m_("eles visit insert"); // eles visit insert ip + date 중복일때 여기를 탄다.
			//echo "sql:" . $sql; exit;
			// insert kapp_visit ( vi_id, vi_ip, vi_date, vi_time, vi_referer, vi_agent, vi_browser, vi_os, vi_device ) values ( 4565, '172.31.5.156', '2024-02-20', '09:09:21', 'https://ailinkapp.com/t/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', '', '', '' )
		}
	}

	//m_("visit insert");		echo "sql:" . $sql; exit;

    // 정상으로 INSERT 되었다면 방문자 합계에 반영
} // ( get_cookie('kapp_ck_visit_ip') != $H_ID_IPADDR )
?>
