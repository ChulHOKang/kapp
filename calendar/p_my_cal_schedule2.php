<?php
	include_once('../tkher_start_necessary.php');
	include "lunar_lib.php"; 
	/*
	*   p_my_cal_schedule2.php : index - p_my_cal_frame , p_my_cal_schedule , p_my_cal_schedule2 사용.
	*/
?>
<html>
<head>
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

	if( $click_day ) $day = $click_day;

	if( isset($_POST['xcnt']) ) $xcnt= $_POST['xcnt'];
	else if( isset($_REQUEST['xcnt']) ) $xcnt= $_REQUEST['xcnt'];
	else $xcnt='';

	if( isset($_POST['comment']) ) $comment= $_POST['comment'];
	else if( isset($_REQUEST['comment']) ) $comment= $_REQUEST['comment'];
	else $comment='';

	if( isset($_POST['no']) ) $no= $_POST['no'];
	else if( isset($_REQUEST['no']) ) $no= $_REQUEST['no'];
	else $no='';

	if( isset($_POST['uptime']) ) $uptime= $_POST['uptime'];
	else if( isset($_REQUEST['uptime']) ) $uptime= $_REQUEST['uptime'];
	else $uptime='';
	
	if (!$H_ID) {
		m_("Please Login! ");$run=KAPP_URL_T_;
		echo "<script>window.open( '$run' , '_top', ''); </script>";
	}
     $all_day = array(            //  1:쉬는날, 0:안쉬는 기념일 -24절기-일연번호
         '0101:1:신정-',
         '0105:0:소한-24-1',    // 
         '0120:0:대한-24-2',
         '0204:0:입춘-24-3',
         '0214:0:발렌타인데이-',
         '0219:0:우수-24-4',
         '0301:1:삼일절-',
         '0306:0:경칩-24-5',
         '0314:0:화이트데이-',
         '0321:0:춘분-24-6',
         '0405:1:식목일-청명-24-7',
         '0414:0:블랙데이-',
         '0420:0:곡우-24-8',
         '0501:0:근로자의날-',
         '0505:1:어린이날-',
         '0506:0:입하-24-9',
         '0508:0:어버이날-',
         '0514:0:로즈데이-',
         '0515:0:스승의날-',
         '0516:0:성년의날-',
         '0521:0:소만-24-10',
         '0605:0:망종-24-11',
         '0606:1:현충일-',
         '0614:0:키스데이-',
         '0621:0:하지-24-12',
         '0625:0:한국전쟁-',
         '0707:0:소서-24-13',
         '0714:0:실버데이-',
         '0717:1:제헌절-',
         '0723:0:대서-24-14',
         '0808:0:입추-24-15',
         '0814:0:그린데이-',
         '0815:1:광복절-',
         '0823:0:처서-24-16',
         '0908:0:백로-24-17',
         '0914:0:포토데이-',
         '0923:0:추분-24-18',
         '1001:0:국군의날-',
         '1008:0:한로-24-19',
         '1009:1:한글날-',
         '1014:0:와인데이-',
         '1023:0:상강-24-20',
         '1107:0:입동-24-21',
         '1111:0:빼빼로데이-',
         '1114:0:무비데이-',
         '1122:0:소설-24-22',
         '1207:0:대설-24-23',
         '1214:0:허그데이-',
         '1222:0:동지-24-24',
         '1225:1:성탄절-',
     );
     $um_all_day = array(        // 음력으로 기념일 쉬는날
        '1230:1:설날-1',
        '0101:1:설날-0',
        '0102:1:설날+1',
        '0115:0:대보름',
        '0408:1:석가탄신일',
        '0505:0:단오',
        '0707:0:칠석',
        '0814:1:추석-1',
        '0815:1:추석-0',
        '0816:1:추석+1',
     );

	$aR = array(        // 쉬는 기념일
         '0101:1:신정',
         '0301:1:삼일절',
         '0405:1:식목일',
         '0505:1:어린이날',
         '0515:1:석가탄신일',
         '0606:1:현충일',
         '0717:1:제헌절',
         '0815:1:광복절',
         '1003:1:개천절',
         '1009:1:한글날',
         '1225:1:성탄절',
     );
     $bR = array(        // 안쉬는 기념일
         '0114:0:다이어리데이',
         '0214:0:발렌타인데이',
         '0314:0:화이트데이',
         '0414:0:블랙데이',
         '0514:0:로즈데이',
         '0614:0:키스데이',
         '0714:0:실버데이',
         '0814:0:그린데이',
         '0914:0:포토데이',
         '1014:0:와인데이',
         '1114:0:무비데이',
         '1111:0:빼빼로데이',
         '1214:0:허그데이',
         '0501:0:근로자의 날',
         '0508:0:어버이날',
         '0515:0:스승의날',
         '0516:0:성년의날',
         '0625:0:6.25사변일',
         '1001:0:국군의날',
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
         '0405:청명',
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
	if($mode=='insert') {
		$uptime=time();
		sql_query("insert into kapp_my_schedule set id='$H_ID', year='0000', month='$month', day='$day', comment='$comment', uptime='$uptime'" );
		my_jump("p_my_cal_schedule_year.php?year=$year&month=$month&day=$day");
		exit;
	}

	if($mode=='delete') {
		//mysql_query("delete from kapp_my_schedule where id='$H_ID' and uptime='$uptime'",$mc);
		sql_query("delete from kapp_my_schedule where id='$H_ID' and no=$no " );
		my_jump("p_my_cal_schedule_year.php?year=$year&month=$month&day=$day");
		exit;
	}
	if( !$month ) {
		$this_time = time();
		$year = date("Y",$this_time);
		$month = date("m",$this_time);
//		$day = date("d",$this_time);
	}

	$my_date = mktime(0,0,0,$month+1,$day,$year);
	$date = date("Y-m",$my_date);
	//$date = date("Y년 m월",$my_date);
?>
<table border=0 cellpadding=4 cellspacing=1 bgcolor='#d0d0d0' width='870'>
	<tr><td bgcolor='#efefef' title='schedule2 - To edit a schedule, click on the calendar date.'>&nbsp;<?=$date?>&nbsp;<b>: Monthly Full Schedule</b></td></tr><!--  [월간 전체 일정 내역] -->
	<tr><td bgcolor='#ffffff' height=133 valign=top>
	<table border=0 cellpadding=4 cellspacing=0>
		<tr>
			<td width='60' bgcolor='cyan'>date</td><td width=80 bgcolor=cyan align=center>lunar<br>[음력:陰曆]</td> <td width=900 bgcolor='cyan'>Schedule</td> 
		</tr>
<?php
	$day = $day+1-1;
	$result = sql_query("select * from kapp_my_schedule where id='$H_ID' and year='$year' and month='$month' order by seqno desc" );

	$cnt = 0;
	while ($rs = sql_fetch_array($result)) {
		$cnt++;
		//$str = my_cutstr($rs['comment'],100);
		$str = $rs['comment'];
?>
		<td width='60'><?=$rs['month']?>-<?=$rs['day']?></td> 
		<td width='60'>
		<?php
		if ($rs['uselunar']) {
			echo "(".$rs['lmonth']."-".$rs['lday'].")"; 
		}
		?>
		</td>
		<td width='900' title='To edit a schedule, click on the calendar date.'><?=$str?></td>
		</tr>
<?php
	}
	if(!$cnt) {
		echo "<tr><td colspan=3 width=460 align=center>There are no registered events.</td></tr>";// (등록된 일정이 없습니다.)
		echo "<tr><td height=1 colspan=3 bgcolor='#e0e0e0'></td></tr>";
	}
	$cnt++;
?>
	</table>
	</td></tr>
</table>
 <?php
 	for($i=0; isset($all_day[$i]) && $all_day[$i]!='';$i++){
		$ga=$all_day[$i];
		$gi = explode("-",$ga);
		$gi1 = explode(":",$gi[0]);
		$m = substr($gi1[0],0,2);
		$d = substr($gi1[0],2,2);
		if($i==0) echo "<tr>--------------------------------------------------------------------</tr><br> ";
		if ( isset($gi[2]) && $gi[2] ) $gg = "24 seasons" . "-" . $gi[2];// (24절기)
		else $gg="";
		if($month == $m ) {
			$msg = "$m-$d : ". $gi1[2];
			if( isset($gi[1]) && $gi1[1] == '1')	echo "<tr> <td style='color:blue;'>".$msg." : holiday : " . $gg. "</td></tr><br> ";
			else echo "<tr> <td style='color:blue;'>".$msg. " : " . $gg."</td></tr><br> ";
		} else {
		}
	}
	echo "<tr>--------------------------------------------------------------------</tr><br> ";
	$my_date = mktime(0,0,0,$month,31,$year);
	$day = date("d",$my_date);
	if($day=='31') $temp = "31";
	if($day=='01') $temp = "30";
	if($day=='02') $temp = "29";
	if($day=='03') $temp = "28";
		echo "<tr>------------lunar ----------------------------------------------</tr><br> ";//- [ 음력 : 陰曆 ]
		for ($i=1;$i<=$temp;$i++) {
			$my_date = mktime(0,0,0,$month,$i,$year);
			$day = date("d",$my_date);
			$week = date("w",$my_date);
			$day = sprintf('%02d',$i);
			list($_ymd,$_info,$s,$f,$n) = $lunar= xtolunar($year,$month,$i); 
			list($_y,$_m,$_d,$_l,$_t,$_a,$_e) = $_info; // 음력 날짜 

			if($_l) $llnm = '윤달';
			else $llnm = '평달';

			$monthx = sprintf('%02d',$month);
			$dayx = sprintf('%02d',$day);
			$_dx = sprintf('%02d',$_d);
			$_mx = sprintf('%02d',$_m);
			$_dm = $_mx . $_dx;
		for($k=0; isset($um_all_day[$k]) && $um_all_day[$k]!='';$k++){
				$ga=$um_all_day[$k];
				$gi1 = explode(":",$ga);
				$m = substr($gi1[0],0,2);
				$d = substr($gi1[0],2,2);
				$dm = substr($gi1[0],0,4);
				if($_dm == $dm ) {
					$msg = "$monthx-$dayx (음력:陰曆:$_mx-$_dx) : ". $gi1[2]; //$ga
					if( isset($g1[2]) ) $g1_2 = $g1[2];
					else $g1_2 = '';
					if( isset($gi1[1]) && $gi1[1] == '1')	echo "<tr> <td style='color:blue;'>".$msg." : holiday: " . $g1_2. "</td></tr><br> ";//(휴일:休日) 
					else echo "<tr> <td style='color:blue;'>".$msg. " : " . $g1_2."</td></tr><br> ";
				} else {
				}
		}
	}
	echo "<tr>--------------------------------------------------------------------</tr><br> ";
?>

</body>
</html>