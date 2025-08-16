<?php
	include_once('../tkher_start_necessary.php');
	include "lunar_lib.php"; 
	/*
	*   p_my_cal_schedul.php : daily insert.
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
<link rel='StyleSheet' HREF='<?=KAPP_URL_T_?>/include/css/style.css' type='text/css' >
<script language='javascript'>
<!--
function reload_update() { 
		document.schedule_modify.target = 'schedule_view';
		document.schedule_modify.action='p_my_cal_schedule.php';
		document.schedule_modify.submit();
}
function reload_check(year,month,day, mode) { 
		document.schedule_modify.year.value	=year;
		document.schedule_modify.month.value	=month;
		document.schedule_modify.day.value	=day;
		document.schedule_modify.mode.value	=mode;
		document.schedule_modify.target='_top'; 
		document.schedule_modify.action='index.php';
		document.schedule_modify.submit();
}
function select_check() {
//	if (document.schedule_insert.uselunar.checked) {
	/*var ch = document.schedule_insert.uselunar.value;
		alert("'a:"+ a);
	if (ch=='checked') {
		alert("'체크박스 클릭함:"+ ch);
		document.schedule_insert.luse.value="1";
	} else{
		alert("'체크박스 클릭함 no:"+ ch);
		document.schedule_insert.luse.value="0";
	}*/
}
function insert_func() {
	if(!document.schedule_insert.comment.value) {
		alert("일정 등록을 하십시오");
		document.schedule_insert.comment.foucs();
		return;
	}
	document.schedule_insert.mode.value='insert_func'; 
	document.schedule_insert.action = 'p_my_cal_schedule.php'; 
	document.schedule_insert.submit();
}
	function update_func(cnt, no, uptime, yy, mm, dd) {
		document.schedule_modify.uptime.value=uptime;
		document.schedule_modify.no.value=no;
		document.schedule_modify.year.value=yy;
		document.schedule_modify.month.value=mm;
		document.schedule_modify.day.value=dd;
		var ii = cnt;
        var ss = eval("document.schedule_modify.sstr_" + ii + ".value");		
		document.schedule_modify.sms.value = ss; 
		document.schedule_modify.target='_self'; 
		document.schedule_modify.mode.value='update_func'; 
		document.schedule_modify.action = 'p_my_cal_schedule.php'; 
		document.schedule_modify.submit();
	}
	function delete_func( cnt, no, uptime) {
		form = document.schedule_modify;
		form.mode.value="delete_func"; 
		form.uptime.value=uptime; 
		form.no.value=no;
		document.schedule_modify.action = 'p_my_cal_schedule.php'; 
		document.schedule_modify.submit();
	}

//-->
</script>

<?php
	$H_ID				= get_session("ss_mb_id");  
	$H_LEV			= $member['mb_level'];
	
	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode='';
	$tkher_mode = get_session("tkher_mode");  

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

	if( $tkher_mode=='insert_func' || $tkher_mode=='update_func' || $tkher_mode=='delete_func'){
		$year		= get_session("tkher_year");
		$month	= get_session("tkher_month");
		$day		= get_session("tkher_day");
		$click_day= get_session("tkher_click_day");
	}
	if( $click_day ) $day = $click_day;

	if( isset($_POST['xcnt']) ) $xcnt= $_POST['xcnt'];
	else if( isset($_REQUEST['xcnt']) ) $xcnt= $_REQUEST['xcnt'];
	else $xcnt='';
	if( isset($_POST['_y']) ) $_y= $_POST['_y'];
	else if( isset($_REQUEST['_y']) ) $_y= $_REQUEST['_y'];
	else $_y='';
	if( isset($_POST['_m']) ) $_m= $_POST['_m'];
	else if( isset($_REQUEST['_m']) ) $_m= $_REQUEST['_m'];
	else $_m='';
	if( isset($_POST['_d']) ) $_d= $_POST['_d'];
	else if( isset($_REQUEST['_d']) ) $_d= $_REQUEST['_d'];
	else $_d='';
	if( isset($_POST['_l']) ) $_l= $_POST['_l']; //윤달 구분...
	else if( isset($_REQUEST['_l']) ) $_l= $_REQUEST['_l']; //윤달 구분...
	else $_l =date("d",time());

	if ( !$H_ID) {
		m_("Please Login! ");$run=KAPP_URL_T_;
		echo "<script>window.open( '$run' , '_top', ''); </script>";
	}
?>

</head>
<body bgcolor="#FFFFFF" text="#000000" onkeydown='' onLoad="" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php

		list($_ymd,$_info,$s,$f,$n) = $lunar = xtolunar($year,$month,$day ); 
		list($_y,$_m,$_d,$_l,$_t,$_a,$_e) = $_info; // 음력 날짜 
		if($_l) $llnm = 'intercalation(윤달)';
		else $llnm = 'Standard(평달)';
		$lunar_date = sprintf('Lunar[음력:陰曆] : %d-%02d-%02d (%s)',$_y,$_m,$_d,$llnm); 

	if($day){
		$my_date = mktime(0,0,0,$month,$day,$year);
		$date1 = date("Y-m-d: D",$my_date);
	} else {
		$date1 = sprintf('%d-%02d',$year,$month); 
	}
?>
<!--<table border=0 cellpadding=4 cellspacing=1 bgcolor='#d0d0d0' width=630>-->
<table border=0 cellpadding=4 cellspacing=1 bgcolor='#FFFFFF' >
	
	<tr <?php echo "title='Manage daily schedules. I try to use the lunar calendar. ";?> ><td bgcolor='#efefef'>
	<b><?php echo $date1;?> &nbsp; Daily schedule details</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lunar_date;?></td></tr>
	<tr>
	<form name='schedule_insert' method='post' action='<?=$PHP_SELF?>'>
	<input type='hidden' name='mode' value=''>
	<input type='hidden' name='year' value='<?=$year?>'>
	<input type='hidden' name='month' value='<?=$month?>'>
	<input type='hidden' name='day' value='<?=$day?>'>
	<input type='hidden' name='click_day' value='<?=$click_day?>'>
	<input type='hidden' name='cnt' value='<?=$cnt?>'>
	<input type='hidden' name='_y' value='<?=$_y?>'>
	<input type='hidden' name='_m' value='<?=$_m?>'>
	<input type='hidden' name='_d' value='<?=$_d?>'>
	<input type='hidden' name='_l' value='<?=$_l?>'>
	<input type='hidden' name='luse' value='0'>
	<td bgcolor='#ffffff' align=left <?php echo "title='Please check if you use lunar calendar!' "; ?>><!--  \n 음력을 사용할경우 체크를하세요! -->
	memo :<input type='text' name='comment' size=80 maxlength=200 class='form'> 
	*[陰曆]lunar use :<input type='checkbox' name='uselunar' onclick=select_check(this); >
<input type='button' value='insert' class='form' onclick="insert_func();" style="border-style:;background-color:blue;color:yellow;height:20;" <?php echo " title='Register your memo.' "; ?> ><!--  \n 메모를 등록 합니다. -->
	</td>
	</form>
	</tr>
	<tr><td bgcolor='#ffffff' height=133 valign=top>
	<table border=0 cellpadding=4 cellspacing=0>
	<form name='schedule_modify' method='post' >
	<input type='hidden' name='mode'		value=''>
	<input type='hidden' name='year'			value='<?=$year?>'>
	<input type='hidden' name='month'		value='<?=$month?>'>
	<input type='hidden' name='day'			value='<?=$day?>'>
	<input type='hidden' name='click_day'	value='<?=$click_day?>'>
	<input type='hidden' name='no' value=''>
	<input type='hidden' name='uptime' value=''>
	<input type='hidden' name='sms' value=''>
<?php
	$result = sql_query("select * from kapp_my_schedule where id='$H_ID' and year='$year' and month='$month' and day='$day' order by month, day" );
	$cnt=0;
	while ($rs = sql_fetch_array($result)) {
		$rsseqno=$rs['seqno']; 
		$rsuptime = $rs['uptime'];
		$rsmonth=$rs['month'];
		$rsday=$rs['day'];
		$rslmonth=$rs['lmonth'];
		$rslday=$rs['lday'];
		$rsuselunar=$rs['uselunar'];
?>
		<tr> 
		<td width=50 align=left><font style="font-size:11">
		<?php
		if( $rs['uselunar'] ){
			echo $rs['month']."-".$rs['day']."<br>(".$rs['lmonth']."-".$rs['lday'].")";
		} else {
			echo $rs['month']."-".$rs['day'];
		}
		?>
		</font></td>
		<td>
		<input type='text' name='sstr_<?=$cnt?>' width='400' size='80' maxlength='200' value="<?=$rs['comment']?>">
		</td>
		<td><!--  \n 메모를 변경합니다.  -->
		<input type='button' name='Change' <?php echo "title=' Change the note.' "; ?>  onClick="update_func('<?=$cnt?>','<?=$rsseqno?>','<?=$rsuptime?>','<?=$year?>','<?=$month?>','<?=$day?>')"  value='Change' style="border-style:;background-color:blue;color:white;height:20;"></td>
		
		<td><input type='button' value='Delete' width=50 class='form' onclick="delete_func('<?=$cnt?>','<?=$rsseqno?>','<?=$rsuptime?>');" style="border-style:;background-color:red;color:white;height:20;" <?php echo " title='Delete the note.' "; ?> ></td></tr><!--  \n 메모를 삭제합니다. -->
<?php
		$cnt++;
	}
	if(!$cnt) {
		echo "<tr><td colspan=3 width=460 align=center>There are no registered events.</td></tr>";// (등록된 일정이 없습니다.)
	}
?>
</form> 
	</table>
	</td></tr>
</table>
<?php
	if($mode=='insert_func') {
		$comment = $_REQUEST['comment'];
		$uptime=time();
		$DT = sprintf('%s-%02d-%02d',$year,$month,$day);
		list($_ymd,$_info,$s,$f,$n) = $lunar = xtolunar($year,$month,$day); 
		list($_y,$_m,$_d,$_l,$_t,$_a,$_e) = $_info; // 음력 날짜 
		if($_l) $llnm = '윤달';
		else $llnm = '평달';

		$monthx = sprintf('%02d',$month);
		$dayx = sprintf('%02d',$day);
		$_dx = sprintf('%02d',$_d);
		$_mx = sprintf('%02d',$_m);
		if( isset($_POST['uselunar']) ) $uselunar = $_POST['uselunar'];
		else $uselunar = '';
		if( $uselunar == 'on') $uselunarx='1';
		else $uselunarx ='0';
		sql_query("insert into kapp_my_schedule set id='$H_ID', year='$year', month='$monthx', day='$dayx', lyear='$_y', lmonth='$_mx', lday='$_dx', lnm='$llnm', uselunar='$uselunarx', comment='$comment', uptime='$uptime' " );
		sql_query("insert into kapp_my_everlasting_schedule set id='$H_ID',  month='$monthx', day='$dayx', um_month='$_mx', um_day='$_dx', yundal='$llnm', uselunar='$uselunarx', comment='$comment', uptime='$uptime' " );
		set_session('tkher_mode',		$mode);
		set_session("tkher_year", $year);  
		set_session("tkher_month", $month);  
		set_session("tkher_day", $day);  
		set_session("tkher_click_day", $click_day);  
		echo "<script>reload_check('$year','$month','$day','insert_func');</script>";
	}
	else if($mode=='delete_func') {
		$no = $_POST['no'];
		$uptime = $_POST['uptime'];
		sql_query("delete from kapp_my_schedule where id='$H_ID' and seqno=$no " );
		sql_query("delete from kapp_my_everlasting_schedule where id='$H_ID' and uptime=$uptime " );
		set_session('tkher_mode',		$mode);
		set_session("tkher_year", $year);  
		set_session("tkher_month", $month);  
		set_session("tkher_day", $day);  
		set_session("tkher_click_day", $click_day);  
		echo "<script>reload_check('$year','$month','$day','delete_func');</script>";
	}
	else if($mode=='update_func') {
		$no = $_POST['no'];
		$sms = $_POST['sms'];
		$uptime = $_POST['uptime'];
		$xxcnt=$xcnt-1;
		$day=$click_day;
		$year		= $_POST['year'];
		$month	= $_POST['month'];
		$day		= $_POST['day'];
		$click_day	= $_POST['click_day'];
		sql_query("update kapp_my_schedule set comment='$sms' where id='$H_ID' and seqno='$no'" );
		sql_query("update kapp_my_everlasting_schedule set comment='$sms' where id='$H_ID' and uptime='$uptime'" );
		set_session('tkher_mode',		$mode);
		set_session("tkher_year", $year);  
		set_session("tkher_month", $month);  
		set_session("tkher_day", $day);  
		set_session("tkher_click_day", $click_day);  
		echo "<script>reload_check('$year','$month','$day','update_func');</script>";
	}
?>
</body>
</html>