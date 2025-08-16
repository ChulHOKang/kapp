<?php
	include_once('../tkher_start_necessary.php');
	include "lunar_lib.php"; 
	/*
	*   p_my_cal_schedul_year.php : Annual schedule - Data Insert
	*/
	$H_ID	= get_session("ss_mb_id");  
	$H_LEV	= $member['mb_level'];
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
<link rel=StyleSheet HREF='<?=KAPP_URL_T_?>/include/css/style.css' type=text/css title=style>
<script language='javascript'>
<!--
function reload_check(year,month,day) { 
		document.schedule_insert.year.value		=year;
		document.schedule_insert.month.value	=month;
		document.schedule_insert.day.value		=day;
		document.schedule_insert.target='_top'; 
		document.schedule_insert.action='index_year.php';
		document.schedule_insert.submit(); 
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
function submit_check(mm,dd) {
	_m=document.schedule_insert._m.value;
	_d=document.schedule_insert._d.value;
	document.schedule_insert.click_month.value=mm;
	document.schedule_insert.click_day.value=dd;
	if(!document.schedule_insert.comment.value) {
		alert("Please register your schedule"); // \\n 일정 등록을 하십시오
		document.schedule_insert.comment.foucs();
		return;
	}
	document.schedule_insert.mode.value='Insert'; 
	document.schedule_insert.submit();
}
	function update_func(cnt, no, uptime, yy, mm, dd, lmm, ldd, luse) {
		document.schedule_modify.uptime.value=uptime;	//kapp_my_everlasting_schedule update.
		document.schedule_modify.no.value=no;
		document.schedule_modify.year.value=yy;
		document.schedule_modify.month.value=mm;
		document.schedule_modify.day.value=dd;
		document.schedule_modify.click_month.value =mm;
		document.schedule_modify.click_day.value =dd;
		document.schedule_modify._m.value =lmm;
		document.schedule_modify._d.value =ldd;
		document.schedule_modify.luse.value =luse;
		var ii = cnt;
        var ss = eval("document.schedule_modify.sstr_" + ii + ".value");		
		document.schedule_modify.sms.value = ss; // comment
		document.schedule_modify.target='_self';
		document.schedule_modify.mode.value='update_func'; 
		document.schedule_modify.action = 'p_my_cal_schedule_year.php'; 
		document.schedule_modify.submit();
	}
	function delete_func(cnt, no, uptime) {
		resp = confirm('Are you sure you want to delete?');//  \n 삭제하시겠습니까?
		if(resp) {
			form = document.schedule_modify;
			form.mode.value="delete_func"; 
			form.uptime.value=uptime; 
			form.no.value=no;
			document.schedule_modify.action = 'p_my_cal_schedule_year.php'; 
			document.schedule_modify.submit();
		} else {
				return false;         
		}
	}
//-->
</script>
<?php
	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode='';
	$day='';
	$click_day= '';
	$tkher_mode = get_session("tkher_mode");  
	if( $mode == 'frame_day') {
		if( isset($_POST['year']) ) $year= $_POST['year'];
		else if( isset($_REQUEST['year']) ) $year= $_REQUEST['year'];
		else $year='';
		if( isset($_POST['month']) ) $month= $_POST['month'];
		else if( isset($_REQUEST['month']) ) $month= $_REQUEST['month'];
		else $month='';
		if( isset($_POST['day']) ) $day= $_POST['day'];
		else if( isset($_REQUEST['day']) ) $day= $_REQUEST['day'];
		else $day='';
		if( isset($_POST['click_day']) ) $click_day= $_POST['click_day'];
		else if( isset($_REQUEST['click_day']) ) $click_day= $_REQUEST['click_day'];
		else $click_day='';
	} else if( $mode=='schedule_day'){
		if( isset($_POST['my_year']) ) $year= $_POST['my_year'];
		else if( isset($_REQUEST['my_year']) ) $year= $_REQUEST['my_year'];
		else $year='';
		if( isset($_POST['my_month']) ) $month= $_POST['my_month'];
		else if( isset($_REQUEST['my_month']) ) $month= $_REQUEST['my_month'];
		else $month='';
		$day			= date("d",time()); 
		$click_day= $day;
		set_session('tkher_mode', "");
	} else if( $mode=='update_func' || $mode=='delete_func'){
		$year	= $_POST['year'];
		$month	= $_POST['month'];
		$day		= $_POST['day'];
		$click_day= $_POST['click_day'];
	} else if( $tkher_mode=='Insert' ){
		$year		= get_session("tkher_year");
		$month	= get_session("tkher_month");
		$day		= get_session("tkher_day");
		$click_day= get_session("tkher_click_day");
	}
	if( !$month) {
		$year			= date("Y",time());
		$month		= date("m",time());
		$day			= date("d",time());
		$click_day	= $day;
	}
	if( !$day) {
		$day			= date("d",time());
		$click_day	= $day;
	}
	//$year		= date("Y",time());

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


	if (!$H_ID) {
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
		$lunar_date = sprintf('Lunar[陰曆] : %d-%02d-%02d (%s)',$_y,$_m,$_d,$llnm); 
	if($day){
		$my_date = mktime(0,0,0,$month,$day,$year);
		$date1 = sprintf('%02d-%02d',$month,$click_day); 
		$imm = sprintf('%02d',$month ); 
		$idd = sprintf('%02d', $click_day); 
		$yymm = date("Y-m",$my_date);
	} else {
		$date1 = sprintf('%02d-%02d',$month,$click_day); 
		$imm = sprintf('%02d',$month ); 
		$idd = sprintf('%02d', $click_day); 
		$yymm = sprintf('%d-%02d',$year,$month); 
	}
?>
<table border=0 cellpadding=4 cellspacing=1 bgcolor='#FFFFFF' >
	<tr title='p_my_cal_schedule_year'><td bgcolor='#efefef'>
	&nbsp;<?php echo $yymm;?>:<b>Schedule (일정 내역)</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lunar_date;?></td></tr>
	<tr>
	<form name='schedule_insert' method='post' >
	<td bgcolor='#ffffff' align=left>
	<input type='hidden' name='mode' value=''>
	<input type='hidden' name='year' value='<?=$year?>'>
	<input type='hidden' name='month' value='<?=$month?>'>
	<input type='hidden' name='day' value='<?=$day?>'>
	<input type='hidden' name='click_month' value=''>
	<input type='hidden' name='click_day' value='<?=$click_day?>'>
	<input type='hidden' name='cnt' value='<?=$cnt?>'>
	<input type='hidden' name='_y' value='<?=$_y?>'>
	<input type='hidden' name='_m' value='<?=$_m?>'>
	<input type='hidden' name='_d' value='<?=$_d?>'>
	<input type='hidden' name='_l' value='<?=$_l?>'>
	<input type='hidden' name='luse' value='0'>
	memo(<?=$date1?>) :<input type='text' name='comment' size=80 maxlength=200 class='form'> 
	*[陰曆]lunar use :<input type='checkbox' name='uselunar' onclick=select_check(this); <?php echo "title='Please check if you use lunar calendar!' "; ?> ><!--  \n 음력을 사용할경우 체크를하세요! -->
<input type='button' value='insert' class='form' onclick="submit_check('<?=$imm?>','<?=$idd?>');" style="height:18" <?php echo " title='Register your memo.' "; ?>><!--  \n 메모를 등록 합니다. -->
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
		<input type='hidden' name='click_month' value=''>
		<input type='hidden' name='click_day'	value='<?=$click_day?>'>
		<input type='hidden' name='_m' value=''>
		<input type='hidden' name='_d' value=''>
		<input type='hidden' name='luse' value=''>
		<input type='hidden' name='no' value=''>
		<input type='hidden' name='uptime' value=''>
		<input type='hidden' name='sms' value=''>
<?php
	$result = sql_query("select * from kapp_my_schedule where year='0000' and month='$month' and id='$H_ID' order by month, day" );
	$tot = sql_num_rows($result);
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
		<td width='50' align='left'><font style="font-size:11">
		<?php
		if( $rs['uselunar']){
			echo"$rs[month]-$rs[day]<br>($rs[lmonth]-$rs[lday])";
		} else {
			echo $rs['month'] . "-". $rs['day'];
		}
		?>
		</font></td>
		<td>
		<input type='text' name='sstr_<?=$cnt?>' width='400' size='80' maxlength='200' value='<?=$rs['comment']?>'>
		</td>
		<td><!--  \n 메모를 변경합니다.  -->
		<input type='button' name='Change' <?php echo "title=' Change the note.' "; ?>  onClick="update_func('<?=$cnt?>','<?=$rsseqno?>','<?=$rsuptime?>','<?=$year?>','<?=$rsmonth?>','<?=$rsday?>','<?=$rslmonth?>','<?=$rslday?>','<?=$rsuselunar?>')"  value='Change' style="border-style:;background-color:blue;color:white;height:25;">
		</td>
		<td><input type='button' value='Delete' width='50' class='form' onclick="delete_func('<?=$cnt?>','<?=$rseqno?>','<?=$rsuptime?>');" style="height:18;" <?php echo " title='Delete the note.' "; ?> ></td></tr><!--  \n 메모를 삭제합니다. -->
<?php
			$cnt++;
	}
	if(!$cnt) {
		echo "<tr><td colspan='3' width='460' align='center'>There are no registered events.</td></tr>";// (등록된 일정이 없습니다.)
	}
?>
</form> 
	</table>
	</td></tr>
</table>
<?php
	if($mode=='Insert') {
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
		$uselunar = $_POST['uselunar'];
		if( $uselunar == 'on') $uselunarx='1';
		else $uselunarx ='0';
		$comment = $_POST['comment'];
		$_y = $_POST['_y'];
		$_mx = $_POST['_m'];
		$_dx = $_POST['_d'];
		$click_month = $_POST['click_month'];
		$click_day = $_POST['click_day'];
		sql_query("insert into kapp_my_schedule set id='$H_ID', year='0000', month='$click_month', day='$click_day', lyear='$_y', lmonth='$_mx', lday='$_dx', lnm='$llnm', uselunar='$uselunarx', comment='$comment', uptime='$uptime' " );
		sql_query("insert into kapp_my_everlasting_schedule set id='$H_ID',  month='$click_month', day='$click_day', um_month='$_mx', um_day='$_dx', yundal='$llnm', uselunar='$uselunarx', comment='$comment', uptime='$uptime' " );
		$year	= $_POST['year'];
		$month	= $_POST['month'];
		$day	= $_POST['day'];
		set_session('tkher_mode', $mode);
		set_session("tkher_year", $year);  
		set_session("tkher_month", $click_month);  
		set_session("tkher_day", $click_day);  
		set_session("tkher_click_day", $click_day);  
		echo "<script>reload_check('$year','$click_month','$click_day');</script>";
	} else if( $mode=='delete_func') {
		$no = $_POST['no'];
		$uptime = $_POST['uptime'];
		sql_query("delete from kapp_my_schedule where id='$H_ID' and seqno=$no " );
		sql_query("delete from kapp_my_everlasting_schedule where id='$H_ID' and uptime=$uptime " );
		set_session('tkher_mode',		$mode);
		set_session("tkher_year", $year);  
		set_session("tkher_month", $month);  
		set_session("tkher_day", $day);  
		set_session("tkher_click_day", $click_day);  
		echo "<script>reload_check('$year','$month','$day');</script>";
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
		$click_month	= $_POST['click_month'];
		$click_day	= $_POST['click_day'];
		sql_query("update kapp_my_schedule set comment='$sms' where id='$H_ID' and seqno='$no'" );
		sql_query("update kapp_my_everlasting_schedule set comment='$sms' where id='$H_ID' and uptime='$uptime'" );
		set_session('tkher_mode',		$mode);
		set_session("tkher_year", $year);  
		set_session("tkher_month", $click_month);  
		set_session("tkher_day", $click_day);  
		set_session("tkher_click_day", $click_day);  
		echo "<script>reload_check('$year','$click_month','$click_day','update_func');</script>";
	}
?>
</body>
</html>