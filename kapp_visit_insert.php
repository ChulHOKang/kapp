<?php
if (!defined('_KAPP_')) exit; // 개별 페이지 접근 불가
	/*
	   kapp_visit_insert.php
	   - call : tkher_start_necessary.php
	   pc: id + ip 
	*/

$kapp_host = isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
//$H_ID_IPADDR = $kapp_host . "_" . $member['mb_id'] . "_" . $_SERVER['REMOTE_ADDR'];
$H_ID_IPADDR = KAPP_TIME_YMD . "_" . $member['mb_id'] . "_" . $_SERVER['REMOTE_ADDR'];

$referer = $kapp_host . " : " . $H_ID_IPADDR;
if( get_cookie('kapp_ck_visit_ip') != $H_ID_IPADDR ) {
    set_cookie('kapp_ck_visit_ip', $H_ID_IPADDR, 86400); // 24
    $remote_addr = escape_trim($_SERVER['REMOTE_ADDR']); // $_SERVER 배열변수 값의 변조를 이용한 SQL Injection 공격을 막는 코드.
	$sql = " select * from {$tkher['visit_table']} where vi_device='{$H_ID_IPADDR}' and vi_date='".KAPP_TIME_YMD."' ";
	$tmp_row = sql_fetch( $sql );

    if( isset($_SERVER['HTTP_REFERER']))
        $referer = escape_trim(clean_xss_tags($_SERVER['HTTP_REFERER'])). " : " . $referer; 
    $user_agent  = escape_trim(clean_xss_tags($_SERVER['HTTP_USER_AGENT']));
    $vi_browser = '';
    $vi_os = '';
    $vi_device = $H_ID_IPADDR;
    
	if( !isset($tmp_row['vi_device']) ){ // vi_ip
		$sql = " insert {$tkher['visit_table']} ( vi_ip, vi_date, vi_time, vi_referer, vi_agent, vi_browser, vi_os, vi_device ) values (  '{$remote_addr}', '".KAPP_TIME_YMD."', '".KAPP_TIME_HIS."', '{$referer}', '{$user_agent}', '{$vi_browser}', '{$vi_os}', '{$vi_device}' ) ";
		$result = sql_query( $sql ); //sql_query($sql, FALSE);
		if( !$result) {
			$sql = " insert {$tkher['visit_sum_table']} ( vs_count, visit_all,  vs_date) values ( 1, 1, '".KAPP_TIME_YMD."' ) ";
			$rt = sql_query( $sql ); //sql_query($sql, FALSE);
			if( !$rt) { // DUPLICATE
				$sql = " update {$tkher['visit_sum_table']} set vs_count = vs_count + 1, visit_all = visit_all + 1 where vs_date = '".KAPP_TIME_YMD."' ";
				$result = sql_query($sql);
			}
			// today
			$sql = " select vs_count as cnt from {$tkher['visit_sum_table']} where vs_date = '".KAPP_TIME_YMD."' ";
			$row = sql_fetch($sql);
			$vi_today = $row['cnt'];
			// yesterday
			$sql = " select vs_count as cnt from {$tkher['visit_sum_table']} where vs_date = DATE_SUB('".KAPP_TIME_YMD."', INTERVAL 1 DAY) ";
			$row = sql_fetch($sql);
			if( isset($row['cnt']) ) $vi_yesterday = $row['cnt'];
			else $vi_yesterday = 0;
			// max
			$sql = " select max(visit_all) as cnt from {$tkher['visit_sum_table']} ";
			$row = sql_fetch($sql);
			$vi_max = $row['cnt'];
			// total
			$sql = " select sum(vs_count) as total from {$tkher['visit_sum_table']} ";
			$row = sql_fetch($sql);
			$vi_sum = $row['total'];
			$visit = 'today:'.$vi_today.', yestday:'.$vi_yesterday.', max:'.number_format($vi_max).', Total:'.number_format($vi_sum);
			sql_query(" update {$tkher['config_table']} set kapp_visit = '{$visit}' ");
			
		} else { // id + ip + date dup
		}
	}

}
?>
