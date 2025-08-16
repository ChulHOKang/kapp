<?php
	include_once('../tkher_start_necessary.php');
	include 'lunar_lib.php'; 
	/*
	*   p_my_cal_frame.php : Daily Calendar Disp
	*/
		$ss_mb_id		= get_session("ss_mb_id");	//"ss_mb_id";
		$H_ID				= get_session("ss_mb_id");  
		$H_LEV			= $member['mb_level'];			//get_session("ss_mb_level");   //"ss_mb_id";

		if( !$H_ID) {
			m_("Please Login! ");$run=KAPP_URL_T_;
			echo "<script>window.open( '$run' , '_top', ''); </script>";
		}
		if( isset($_POST['mode']) ) $mode= $_POST['mode'];
		else $mode='';

	$tkher_mode = get_session("tkher_mode");  

	if( isset($_POST['click_day']) ) $click_day= $_POST['click_day'];
	else if( isset($_REQUEST['click_day']) ) $click_day= $_REQUEST['click_day'];
	else $click_day = date("d",time());

	if( $mode == 'frame_day')	{
		if( isset($_POST['year']) ) $year= $_POST['year'];
		else $year='';
		if( isset($_POST['month']) ) $month= $_POST['month'];
		else $month='';
		if( isset($_POST['day']) ) $day= $_POST['day'];
		else $day=date("d",time());
	} else if( $tkher_mode=='insert_func' || $tkher_mode=='update_func' || $tkher_mode=='delete_func'){
		$year		= get_session("tkher_year");
		$month	= get_session("tkher_month");
		$day		= get_session("tkher_day");
		$click_day= get_session("tkher_click_day");
	}
	if( isset($year) && !$year || isset($month) && !$month) {
		$this_time = time();
		$year			= date("Y",$this_time);
		$month		= date("m",$this_time);
		$day			= date("d",$this_time);
	}

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
<link rel='StyleSheet' HREF='<?=KAPP_URL_T_?>/include/css/style.css' type='text/css'>
<script language='javascript'>
<!--
function scehdule_check1(year,month,day) {
		document.schedule_day.mode.value='frame_day';
		document.schedule_day.year.value=year;
		document.schedule_day.month.value=month;
		document.schedule_day.day.value=day;
		document.schedule_day.click_day.value=day;
		click_check(year,month,day);
		document.schedule_day.action='p_my_cal_schedule.php';
		document.schedule_day.target='schedule_view';
		document.schedule_day.submit();
}
function click_check(year,month,day) {
		document.schedule_day.click_day.value=day;
		document.schedule_day.action='p_my_cal_frame.php';
		document.schedule_day.target='_self';
		document.schedule_day.submit(); 
}
function scehdule_check(year,month,day) {
	parent.document.schedule_view.location.href="p_my_cal_schedule.php?year="+year+"&month="+month+"&day="+day;
}
//-->
</script>
</head> 
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0>
<center>
<?php
		$this_time = time();
	$y = date("Y",$this_time);
	$m = date("m",$this_time);
	$d = date("d",$this_time);
	$today = mktime(0,0,0,$m,$d,$y);

	//$my_date = mktime(0,0,0,$month,31,$year);
	if( isset($month) && isset($year)  ) $my_date = mktime(0,0,0,$month,31,$year);
	else $my_date = '1543590000';

	$day = date("d",$my_date);//m_("day:$day , my_date:$my_date");//day:01 , my_date:1543590000
	if($day=='31') $temp = "31";
	if($day=='01') $temp = "30";
	if($day=='02') $temp = "29";
	if($day=='03') $temp = "28";
?>
	<form name='schedule_day' method='post' action=''>
		<input type='hidden' name='mode' value='frame_day'>
		<input type='hidden' name='year'		value=''>
		<input type='hidden' name='month'	value=''>
		<input type='hidden' name='day'		value=''>
		<input type='hidden' name='click_day'		value='<?=$click_day?>'>
	</form>
<table border=0 cellpadding=3 cellspacing=1>
	<tr>
	<td><font color='red'>Sun</font><br>(日)</td><td>Mon<br>(月)</td><td>Tue<br>(火)</td><td>Wed<br>(水)</td><td>Thu<br>(木)</td><td>Fri<br>(金)</td><td>Sat<br>(土)</td>
	</tr>
<?php
	for ($i=1;$i<=$temp;$i++) {
		$my_date = mktime(0,0,0,$month,$i,$year);
		$day = date("d",$my_date);
		$week = date("w",$my_date);
		$result = sql_query("select * from kapp_my_schedule where year='$year' and month='$month' and day='$day' and id='$H_ID'" );
		$num = sql_num_rows($result );  //09.06.27 kan
		if($i=='1' && $week != '0') echo "<tr>";
		if($week == '0') echo "<tr>";
		if($i=='1') {
			for ($j=1;$j<=$week;$j++) {
				echo "<td>&nbsp;</td>";
			}
		}
			list($_ymd,$_info,$s,$f,$n) = $lunar = xtolunar($year,$month,$i); 
			list($_y,$_m,$_d,$_l,$_t,$_a,$_e) = $_info; // 음력 날짜 
?>
		<td align=right bgcolor='#efefff'><a href="javascript:scehdule_check1('<?=$year?>','<?=$month?>','<?=$i?>');">
		<?php
			if( $week==0) echo "<font color=red>";
			if( $click_day == $i && $today==$my_date) echo "<font color='blue' size=4>$day</font><br><font color='black' size=1>$_m.$_d</font>"; 
			else if ($click_day == $i) echo "<font color='maroon' size=4><u>$day</u></font><br><font color='black' size=1>$_m.$_d</font>"; 
			else if ($today==$my_date) echo "<font color='blue' size=4>$day</font><br><font color='black' size=1>$_m.$_d</font>"; 
			else if ($num) echo "<font color='orange' size=3>$day</font><br><font color='black' size=1>$_m.$_d</font>"; 
			else echo "<font size=3>$day</font><br><font color='green' size=1>$_m.$_d</font>"; 
		?>
		</a></td>
<?php
		if($week == '6') echo "</tr>";
	}
?>
</tr></table>
<?php
	if($mode=='reload') {
		echo "<script>scehdule_check('$year','$month','$click_day');</script>";
	}
?>
</body>
</html>
