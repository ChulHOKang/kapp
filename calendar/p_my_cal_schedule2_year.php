<?php
	include_once('../tkher_start_necessary.php');
	/*
	*   p_my_cal_schedule2_year.php :  Annual schedule Data
	*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP, Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<?php
		$ss_mb_id		= get_session("ss_mb_id");
		$H_ID				= get_session("ss_mb_id");  
		$H_LEV			= $member['mb_level'];
	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode='';

		set_session('year',	'');
		set_session('month', '');
		set_session('day',		'');


	if( isset($_POST['year']) ) $year= $_POST['year'];
	else if( isset($_REQUEST['year']) ) $year= $_REQUEST['year'];
	else $year=date("Y", time());
	if( isset($_POST['month']) ) $month= $_POST['month'];
	else if( isset($_REQUEST['month']) ) $month= $_REQUEST['month'];
	else $month=date("m", time());
	if( isset($_POST['click_day']) ) $click_day= $_POST['click_day'];
	else if( isset($_REQUEST['click_day']) ) $click_day= $_REQUEST['click_day'];
	else $click_day=date("d", time());
	
	$day = date("d", time());
	if( isset($_POST['day']) ) $day= $_POST['day'];
	else if( isset($_REQUEST['day']) ) $day= $_REQUEST['day'];
	else $day=date("d", time());

	

	if( isset($_REQUEST['xcnt']) ) $xcnt= $_REQUEST['xcnt'];
	else $xcnt='';
	if( isset($_REQUEST['comment']) ) $comment= $_REQUEST['comment'];
	else $comment='';
	if( isset($_REQUEST['no']) ) $no= $_REQUEST['no'];
	else $no='';
	if( isset($_REQUEST['uptime']) ) $uptime= $_REQUEST['uptime'];
	else $uptime='';

	if (!$H_ID) {
		m_("Please Login! ");$run=KAPP_URL_T_;
		echo "<script>window.open( '$run' , '_top', ''); </script>";
	}
	$aR = array(        // 쉬는 기념일
         '0101:신정',
         '0301:삼일절',
         '0405:식목일',
         '0505:어린이날',
         '0515:석가탄신일',
         '0606:현충일',
         '0717:제헌절',
         '0815:광복절',
         '1003:개천절',
         '1225:성탄절',
     );
     $bR = array(        // 안쉬는 기념일
         '0114:다이어리데이',
         '0214:발렌타인데이',
         '0314:화이트데이',
         '0414:블랙데이',
         '0514:로즈데이',
         '0614:키스데이',
         '0714:실버데이',
         '0814:그린데이',
         '0914:포토데이',
         '1014:와인데이',
         '1114:무비데이',
         '1111:빼빼로데이',
         '1214:허그데이',
         '0501:근로자의 날',
         '0508:어버이날',
         '0515:스승의날',
         '0516:성년의날',
         '0625:6.25사변일',
         '1009:한글날',
         '1001:국군의날',
     );
     $cR = array(        // 음력으로 기념일 쉬는날
        '1230: ',
        '0101:구정',
        '0102: ',
        '0814: ',
        '0815:추석',
        '0816: ',
     );
     $dR = array(        // 음력으로 기념일 절기
        '0115:대보름',
        '0505:단오',
        '0707:칠석',
     );

     $x24 = array(            // 24절기

         '0105:소한',    // 
         '0120:대한',
         '0204:입춘',
         '0219:우수',
         '0306:경칩',
         '0321:춘분',
         '0420:곡우',
         '0506:입하',
         '0521:소만',
         '0605:망종',
         '0621:하지',
         '0707:소서',
         '0723:대서',
         '0808:입추',
         '0823:처서',
         '0908:백로',
         '0923:추분',
         '1008:한로',
         '1023:상강',
         '1107:입동',
         '1122:소설',
         '1207:대설',
         '1222:동지',
     );
?>

<link rel=StyleSheet HREF='<?=KAPP_URL_T_?>/include/css/style.css' type=text/css >
<script language='javascript'>
<!--
function submit_check() {
	if(!document.schedule_insert.comment.value) {
		alert("일정 등록을 하십시오");
		document.schedule_insert.comment.foucs();
		return;
	}
	if(document.schedule_insert.cnt.value > 5) {
		alert("날짜당 5개까지 등록 가능합니다");
		document.schedule_insert.comment.value="";
		return;
	}
	document.schedule_insert.submit();
}
//-->
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" onkeydown='' onLoad="" onResize="" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
	if( $mode=='insert') {
		$uptime=time();
		sql_query("insert into kapp_my_schedule set id='$H_ID', year='0000', month='$month', day='$day', comment='$comment', uptime='$uptime'" );
		my_jump("p_my_cal_schedule_year.php?year=$year&month=$month&day=$day");
		exit;
	}

	if( $mode=='delete') {
		//mysql_query("delete from kapp_my_schedule where id='$H_ID' and uptime='$uptime'",$mc);
		sql_query("delete from kapp_my_schedule where id='$H_ID' and no=$no " );
		my_jump("p_my_cal_schedule_year.php?year=$year&month=$month&day=$day");
		exit;
	}
?>
<?php
	if( !$month ) {
		$this_time = time();
		$year = date("Y",$this_time);
		$month = date("m",$this_time);
	}

	$my_date = mktime(0,0,0,$month+1,$day,$year);
	$date = date("Y",$my_date);
?>
<table border=0 cellpadding=4 cellspacing=1 bgcolor='#d0d0d0' width=870>
	<tr><td bgcolor='#efefef'><b>&nbsp;<?=$date?> Full schedule for the year</b></td></tr><!--  [년간 전체 일정 내역] -->
	<tr><td bgcolor='#ffffff' height=133 valign=top>
	<table border=0 cellpadding=4 cellspacing=0>
		<tr>
			<td width=60 bgcolor=cyan>date</td> <td width=80 bgcolor=cyan align=center>lunar<br>[陰曆]</td> <td width=900 bgcolor=cyan>Schedule</td> 
		</tr>
<?php
	$cnt=0;
	$day = $day+1-1;
	$result = sql_query("select * from kapp_my_schedule where id='$H_ID' and year='0000' order by month, day" );
	while ($rs = sql_fetch_array($result)) {
		$cnt++;
		$str = my_cutstr($rs['comment'],100);
?>
		<td width=60><?=$rs['month']?>-<?=$rs['day']?></td> 
		<td width=60>
		<?php
		if ($rs['uselunar']) {
		echo "($rs[lmonth]-$rs[lday])"; 
		}
		?>
		</td>
		<td width=900><?=$str?></td>
		</tr>
<?php
	}
	if(!$cnt) {
		echo "<tr><td colspan=3 width=460 align=center>There are no registered events.</td></tr>";// (등록된 일정이 없습니다.)
		echo "<tr><td height=1 colspan=3 bgcolor='#e0e0e0'></td></tr>";
	}
	$cnt++;
	$nMonthDay='0621';
	$ss=$x24[1];
?>
	</table>
	</td></tr>
</table>
<?php
$ipcode='';
$ipcd=connect_count('Schedule_Year', $H_ID, 0, 'Calendar');		// 1: country code return 요청. 1이면 ip와 관계없이 로그생성한다.
if( $ipcd=='KR') {
?>
	<tr>
	--------------------------------------------------------------------
	</tr>
<tr>
		'0101:신정',<br>
		'0301:삼일절',<br>
		'0405:식목일',<br>
		'0501:근로자의 날',<br>
		'0505:어린이날',<br>
		'0508:어버이날',<br>
		'0515:스승의날',<br>
		'0516:성년의날',<br>
		'0606:현충일',<br>
		'0625:6.25사변일',<br>
		'0717:제헌절',<br>
		'0815:광복절',<br>
		'1001:국군의날',<br>
		'1003:개천절',<br>
		'1009:한글날',<br>
		'1225:성탄절',<br>
         ---(음력)---<br>
		'1230: ',<br>
		'0101:구정',<br>
		'0102: ',<br>
		'0408(음력):석가탄신일',<br>
		'0814: ',<br>
		'0815:추석',<br>
		'0816: ',<br>

		'0115:대보름',<br>
		'0505:단오',<br>
		'0707:칠석',<br>=======<br>

		'0105:소한',<br>
		'0120:대한',<br>
		'0204:입춘',<br>
		'0219:우수',<br>
		'0306:경칩',<br>
		'0321:춘분',<br>
		'0420:곡우',<br>
		'0506:입하',<br>
		'0521:소만',<br>
		'0605:망종',<br>
		'0621:하지',<br>
		'0707:소서',<br>
		'0723:대서',<br>
		'0808:입추',<br>
		'0823:처서',<br>
		'0908:백로',<br>
		'0923:추분',<br>
		'1008:한로',<br>
		'1023:상강',<br>
		'1107:입동',<br>
		'1122:소설',<br>
		'1207:대설',<br>
		'1222:동지',<br>=======<br>
		'0114:다이어리데이',<br>
		'0214:발렌타인데이',<br>
		'0314:화이트데이',<br>
		'0414:블랙데이',<br>
		'0514:로즈데이',<br>
		'0614:키스데이',<br>
		'0714:실버데이',<br>
		'0814:그린데이',<br>
		'0914:포토데이',<br>
		'1014:와인데이',<br>
		'1114:무비데이',<br>
		'1111:빼빼로데이',<br>
		'1214:허그데이',<br>
</tr>
	<tr>
	--------------------------------------------------------------------
	</tr> 
<?php
}
?>
</body>
</html>