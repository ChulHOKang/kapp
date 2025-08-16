<?php
	include_once('../tkher_start_necessary.php');
	/*
	*   index_year.php : Annual schedule management 
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
	$H_ID				= get_session("ss_mb_id");  
	$H_LEV			= $member['mb_level'];
	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else $mode='';
	if( !$H_ID) {
		m_("Please Login! ");$run=KAPP_URL_T_;
		echo "<script>window.open( '$run' , '_top', ''); </script>";
	}
    if( isset($_POST['my_month']) ) {
		$post_month=$_POST['my_month'];
		$month		= $_REQUEST['my_month'];
	} else if( isset($_REQUEST['my_month']) ) {
		$month		= $_REQUEST['my_month'];
		$post_month=$_REQUEST['my_month'];
	} else {
		$this_time	= time();
		$year		= date("Y",$this_time);
		$month	= date("m",$this_time);
	}
	$tkher_mode = get_session("tkher_mode");  
	if( $tkher_mode=='Insert' || $tkher_mode=='update_func' || $tkher_mode=='delete_func'){
		$year		= get_session("tkher_year");
		$month	= get_session("tkher_month");
		$day		= get_session("tkher_day");
		$click_day= get_session("tkher_click_day");
	}
?>
<link rel="stylesheet" href='<?=KAPP_URL_T_?>/include/css/style.css' type="text/css">
<script src="<?=KAPP_URL_T_?>/include/js/click.js"></script>
<script language="JavaScript">
<!--
function cal_click(val1,val2) {
	year = document.cal.my_year.value;
	month = document.cal.my_month.value;
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
			}
		}
		document.cal.my_month.value=month;
	}
		click_month(month);
		document.cal.mode.value='schedule_day';
		document.cal.action='p_my_cal_schedule_year.php';
		document.cal.target='schedule_view';
		document.cal.submit();
	return;
}
function click_month(m) {
		document.cal.mode.value='index_year';
		document.cal.month.value=m;
		document.cal.action='p_my_cal_frame_year.php';
		document.cal.target='cal_view';
		document.cal.submit();
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
		<input type='hidden' name='click_day'		value=''>
	</form>
<?php
		$cur='B';
		include_once "../menu_run.php"; 
?>
<br>
<p style='font-size:35px;font-weight: bold;wheight:40px;'>[ Annual schedule management ](<?=$H_ID?>)</p><br>
<p>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="ECDD79">
	<tr> <!--  (년중 일정 관리)  -->
		<td width='30%' bgcolor="#FEFDF1"><b>&nbsp;&nbsp;  &#9776; Schedule management throughout the year</b></td>
<!-- 		<td width='30%' style='font-weight: bold;'>&#9776; Schedule management throughout the year</td> -->
		<td width='70%' title='Click here for the daily schedule!' style='height:25px;'><a href="./index.php" style='font-weight: bold; font-size:20px;'>&#9776; Daily Plan Schedule Management</a></td>
		
		<!--  (일일일정관리) -->
	</tr>
</table>
<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<form name='cal' method='post' action=''>
		<input type='hidden' name='mode' value=''>
		<input type='hidden' name='year' value=''>
		<input type='hidden' name='month' value=''>
		<input type='hidden' name='day' value=''>
		<input type='hidden' name='click_day' value=''>
	<tr>
		<!-- <td width=0></td> -->
		<td>
			<table border=0 cellpadding=2 cellspacing=1 bgcolor='#d0d0d0'>
			<tr>
				<td bgcolor='#ffffff' align=center>
					<input type='hidden' name='my_year' value='<?=$year?>' >
					<input type='button' value='◀' class='form' onclick="cal_click('month','prev');" style="height:18">
					<input type='text' size=1 maxlength=2 name='my_month' value='<?=$month?>' class='form' onkeydown="enter_month();">
					<input type='button' value='▶' class='form' onclick="cal_click('month','next');" style="height:18">
				</td>
			</tr>
			<tr>
				<td valign='top' bgcolor='#ffffff'><!-- Calendar -->
					<iframe name='cal_view' src='p_my_cal_frame_year.php?year=<?=$year?>&month=<?=$month?>' frameborder='0' width='100%' height='210' scrolling='no'></iframe>
				</td>
			</tr>
			</table>
		</td>
		<td></td>
		<td valign='top' bgcolor='#d0d0d0' align='left' width='70%'>
			<iframe name='schedule_view' src='p_my_cal_schedule_year.php?year=<?=$year?>&month=<?=$month?>' frameborder='1'  width='100%' height='235' scrolling='auto' ></iframe>
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
<iframe name='schedule_view2' src='p_my_cal_schedule2_year.php?year=<?=$year?>&month=<?=$month?>' frameborder='0' width='100%' height='600' scrolling='auto'></iframe>
</tr>
</table>
</body>
</html>
