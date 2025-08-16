<?php
	include_once('../tkher_start_necessary.php');
	/*
	*   index.php : Daily schedule management
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
	$ipcd = connect_count('calendar', $H_ID, 0, 'Calendar'); // 1: country code return 요청.
	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode='';
	if( $mode == 'update_func' || $mode == 'update_func' || $mode == 'delete')	{
		set_session("tkher_mode", $mode);  
	} else {
		set_session("tkher_click_day", '');  
		set_session("tkher_mode", '');  
		set_session("tkher_year", '');  
		set_session("tkher_month", '');  
		set_session("tkher_day", '');  
	}
	if ( !$H_ID) {
		m_("Please Login! ");$run=KAPP_URL_T_;
		echo "<script>window.open( '$run' , '_top', ''); </script>";
	}
	if( isset($_POST['my_year']) )  $my_year = $_POST['my_year'];
	else if( isset($_REQUEST['my_year']) )  $my_year = $_REQUEST['my_year'];
	else $my_year = '';
    if( $my_year =='') {
		$this_time	= time();
		$year		= date("Y",$this_time);
		$month		= date("m",$this_time);
		$day		= date("d",$this_time);
	} else {
		if( isset($_POST['my_year']) ) $year	= $_POST['my_year'];
		else if( isset($_REQUEST['my_year']) ) $year	= $_REQUEST['my_year'];
		if( isset($_POST['my_month']) ) $month	= $_REQU_POSTEST['my_month'];
		else if( isset($_REQUEST['my_month']) ) $month	= $_REQUEST['my_month'];

		if( isset($_POST['click_day']) ) $day	= $_REQU_POSTEST['click_day'];
		else if( isset($_REQUEST['click_day']) ) $day	= $_REQUEST['click_day'];
	}
	//m_("$year, $month"); //2025, 08
?>
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/style.css" type="text/css">
<script src="<?=KAPP_URL_T_?>/include/js/click.js"></script>
<script language="JavaScript">
<!--
function cal_click(val1,val2) {
	year = document.cal.my_year.value;
	month = document.cal.my_month.value;
	if(val1 == 'year') {
		if(val2 == 'next') year++;
		if(val2 == 'prev') year--;
		document.cal.my_year.value=year;
	}

	if(val1 == 'month') {
		if(val2 == 'next') {
			month++;
			if(month < 10) month="0"+month;
			if(month >= 13) {
				month="01";
				year++;
				document.cal.my_year.value=year;
			}
		}
		if(val2 == 'prev') {
			month--;
			if(month < 10) month="0"+month;
			if(month==00) {
				month=12;
				year--;
				document.cal.my_year.value=year;
			}
		}
		document.cal.my_month.value=month;
		document.cal.my_year.value=year;
	}
	document.cal_view.location.href="p_my_cal_frame.php?mode=reload&year="+year+"&month="+month;
	document.schedule_view2.location.href="p_my_cal_schedule2.php?year="+year+"&month="+month;
		document.schedule_day.month.value=month;
		document.schedule_day.year.value=year;
		document.schedule_day.mode.value='schedule_day';
		document.schedule_day.action='p_my_cal_schedule.php';
		document.schedule_day.target='schedule_view';
		document.schedule_day.submit();
	
	return;
}
function enter_year() {
	if (event.keyCode == 13) cal_year();
}
function cal_year() {
	year = document.cal.my_year.value;
	month = document.cal.my_month.value;

	document.cal.my_year.value=year;
	document.cal_view.location.href="p_my_cal_frame_year.php?mode=reload&year="+year+"&month="+month;
	return;
}
function enter_month() {
	if (event.keyCode == 13) cal_month();
}
function cal_month() {
	year = document.cal.my_year.value;
	month = document.cal.my_month.value;

	if(month <= 0 || month > 12) {
		alert("1에서 12사이의 숫자를 입력하세요");
		return;
	}
	if(month < 10) month="0"+month;
	document.cal.my_month.value=month;
	document.cal_view.location.href="p_my_cal_frame_year.php?mode=reload&year="+year+"&month="+month;
	return;
}
// -->
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" onkeydown='' onLoad="" onResize="" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>

	<form name='schedule_day' method='post' action=''>
		<input type='hidden' name='mode' value='schedule_day'>
		<input type='hidden' name='year'		value=''>
		<input type='hidden' name='month'	value=''>
		<input type='hidden' name='day'		value=''>
	</form>
<?php
		$cur='B';
		include_once "../menu_run.php"; 
?>
<br>
<p style='font-size:35px;font-weight: bold;wheight:40px;'>[ Daily schedule management ](<?=$H_ID?>)</p><br>
<p>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="ECDD79">
	<tr> 
		  <td bgcolor="#FEFDF1" width='30%'><b>&nbsp;&nbsp; &#9776; Daily Plan Schedule Management</b></td>
		  <td width='70%'  title='Click here for the annual schedule!' style='height:25px;'><a href="./index_year.php" style='font-weight: bold; font-size:20px;'>&#9776; Annual schedule management (Year)</a></td>
	</tr>
</table>
<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<form name='cal'>
	<tr>
		<!-- <td width=0></td> -->
		<td>
			<table border=0 cellpadding=2 cellspacing=1 bgcolor='#d0d0d0'>
			<tr>
				<td bgcolor='#ffffff' align=center>
					<input type='button' value='◀' class='form' onclick="cal_click('year','prev');" style="height:18">
					<input type='text' size=3 maxlength=4 name='my_year' value='<?=$year?>' class='form' onkeydown="enter_year();">
					<input type='button' value='▶' class='form' onclick="cal_click('year','next');" style="height:18"> &nbsp;
					<input type='button' value='◀' class='form' onclick="cal_click('month','prev');" style="height:18">
					<input type='text' size=1 maxlength=2 name='my_month' value='<?=$month?>' class='form' onkeydown="enter_month();">
					<input type='button' value='▶' class='form' onclick="cal_click('month','next');" style="height:18">
				</td>
			</tr>
			<tr>
				<td valign=top bgcolor='#ffffff'><!-- Calendar -->
					<iframe name='cal_view' src='p_my_cal_frame.php?year=<?=$year?>&month=<?=$month?>&day=<?=$day?>' frameborder='0' width='100%' height='210' scrolling=no></iframe>
				</td>
			</tr>
			</table>
		</td>
		<td width=0></td>
		<td valign=top bgcolor='#d0d0d0' align=left width=70%>
			<iframe name='schedule_view' src='p_my_cal_schedule.php?year=<?=$year?>&month=<?=$month?>&day=<?=$day?>' frameborder='1'  width='100%' height='235' scrolling=auto ></iframe>
		</td>
	</tr>
	</form>
</table>
</p>
<p style='text-align:left; color:blue;' >&nbsp; &nbsp; &nbsp;■:today</p>
<p style='text-align:left; color:orange;' >&nbsp; &nbsp; &nbsp;■:Day on schedule</p><!-- [일정이 있는 날] -->
<!-- &nbsp; &nbsp; &nbsp;<font color='maroon'>※ You can enter up to 5 per date(날짜당 5개까지 입력 가능합니다)</font><p> -->

<p>
	<table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="ECDD79">
		<tr> 
<iframe name='schedule_view2' src='p_my_cal_schedule2.php?year=<?=$year?>&month=<?=$month?>&day=<?=$day?>' frameborder='0' width='100%' height='600' scrolling='auto'></iframe>
</tr>
</table></p>
</body>
</html>
