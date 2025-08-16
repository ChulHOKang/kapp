<?php
	include_once('../tkher_start_necessary.php');
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
<link rel="stylesheet" href="../include/css/style.css" type="text/css">
<?php
	$H_ID= get_session("ss_mb_id");  
	if ( !$H_ID) {
		m_("Please Login! ");
		$run = KAPP_URL_T_;
		echo "<script>window.open( '$run' , '_top', ''); </script>";
	}
	$H_LEV			= $member['mb_level'];
	$ipcd = connect_count('accountbook', $H_ID, 0, 'accountbook');	// 1: country code return 요청.

	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode'];
	else $mode= '';
	if( isset($_POST['page_mode']) ) $page_mode = $_POST['page_mode'];
	else if( isset($_REQUEST['page_mode']) ) $page_mode = $_REQUEST['page_mode'];
	else $page_mode= '';

	if( isset($_POST['month']) ) $month= $_POST['month'];
	else if( isset($_REQUEST['month']) ) $month = $_REQUEST['month'];
	else $month= '';
	if( isset($_POST['year']) ) $year= $_POST['year'];
	else if( isset($_REQUEST['year']) ) $year = $_REQUEST['year'];
	else $year= '';
?>
</head>
<BODY bgcolor='white' alink='#000000' vlink='#000000' link='#000000' topmargin=0 leftmargin=0>
<CENTER>
<?php
		$cur='B';
		include_once "../menu_run.php"; 
		// 오늘 날짜..
		$time = time(); 
		$today_year = date("Y", $time);
		$today_month = date("n", $time);
		$today_day = date("j", $time); //m_("$today_month, $today_day");//8, 15
		//초기화..

		if( !$month )	$month = (int)$today_month;
		if( !$year ) $year = $today_year;

	echo "
		<script>
			function inputwindow(popmode,paydate) {
				if( popmode =='pay') {
					window.open('./pop_pay.php?paydate='+paydate,'popup','width=604,height=400,left=100,top=100');
					return false;
				}
				if( popmode =='income') {
					window.open('./pop_income.php?incomedate='+paydate,'popup','width=604,height=400,left=100,top=100');
					return false;
				}
			}
			function Change_Year(year){
				location.href = '$PHP_SELF?month=$month&page_mode=$page_mode&year='+year;
			}
			function Change_Month(month){
				location.href = '$PHP_SELF?year=$year&page_mode=$page_mode&month='+month;
			}
			function income_button( imode ){
				pay.page_mode.value=imode;
				pay.action='index.php'
				pay.submit();
			}
		</script>
	";

    $today_color = "green";
	$sun_color = "#ff88b8";
	$sat_color = "#3894ff";
   // 한달의 총 날짜 계산 함수
	function Month_Day( $i_month,$i_year) {
        $day=1;
        while( checkdate( $i_month,$day,$i_year) ) {
			$day++;
		}
		$day--;
		return $day;
	}
	$total_day = Month_Day($month,$year);					    	//선택한 월의 총 일수..
	$first_day = date('w',mktime(0,0,0,$month,1,$year));			//선택한 월의 1일의 요일..
	//지난달과 다음달..
    $year_p=$year-1;
    $year_n=$year+1;
    if( $month==1){
    	$year_prev = $year_p;
    	$year_next = $year;
    	$month_prev = 12;
    	$month_next = $month+1;
    }
    if( $month==12){
    	$year_prev = $year;
    	$year_next = $year_n;
    	$month_prev = $month-1;
    	$month_next = 1;
    }
    if( $month!=1 && $month!=12){
    	$year_prev = $year;
    	$year_next = $year;
    	$month_prev = $month-1;
    	$month_next = $month+1;
    }
	if( !$page_mode){
	   $page_mode ="pay";
	   $title_ = 'Payment Status';	//'Pay Insert';
	   $bgcolor_= '#666666';
	} else if( $page_mode =='income'){
		$title_ = 'Import Status';
	   $bgcolor_= '#666fff';
	} else if( $page_mode =='pay'){
		$title_ = 'Payment Status';
	   $bgcolor_= '#666666';
	}
	/*------ 화면 시작 ----------*/
    echo "
		<form name='pay' method='post' > 
			  <input type='hidden' name='page_mode' value=''>
		</form>
	   <TABLE border=0 cellpadding=0 cellspacing=0 width=100% height='100%'>
		<tr>
		<td align='center'><img src=".KAPP_URL_T_."/include/img/title_01.gif></td>
		</tr>
	   <TR>
		<TD align='center' valign=top>
		<TABLE border=0 width='100%' height='100%'  cellspacing=0 cellpadding=0>
		 <TR>
		  <TD align='center'  height=30 bgcolor='#ffffff'>
			<button style='font-size:15px;font-weight: bold;color:yellow; background-color:$bgcolor_;width:160px; height:30px;valign:center;' title='Click on the date if you want to register!'>$title_</button><!--  \n 등록을 원하면 날짜를 클릭하세요! -->
		  </TD>
		 </TR>
		 <TR>
		  <TD align='center' valign='top'>
		   <table width='100%' border=0>
			<tr>
			<td align='center'>
			  <a href='$PHP_SELF?month=$month_prev&year=$year_prev&page_mode=$page_mode'>
			  <font title='$year_prev-$month_prev'>◀</font></a>&nbsp;
			  <font style='font-family:굴림;font-size:10pt;'><b>
			  <select name='ch_year' onChange='Change_Year(this.options[this.selectedIndex].value)'>
	      ";
			$y_0 = $year;
			$y_1 = $year + 10;
			$y_2 = $year - 1;
			for($y =$y_2 ; $y <= $y_1; $y++){	        
				$year_sel = "";
				if( $y == $year){
					$year_sel = "selected";
				}
				echo("<option value='$y' $year_sel>$y");
			}
			echo("</select> - 
	            <select name='ch_month' onChange='Change_Month(this.options[this.selectedIndex].value)'>
			");
			for($m =1 ; $m <=12; $m++){	        
				$month_sel = "";
				if($m == $month){
					$month_sel = "selected";
				}
				echo("<option value='$m' $month_sel>$m");
			}
			echo("</select> </b></font>&nbsp;
				<a href='$PHP_SELF?month=$month_next&year=$year_next&page_mode=$page_mode'><font title='$year_next-$month_next'>▶</font></a>
		  </td></tr>
		</table><br>
		<table cellspacing=0 cellpadding=1 bordercolorlight='#cccccc' bordercolordark='#ffffff' width='100%' border=1>
		 <tr bgcolor='#f0f0f0'>
	      <td align='center' height='20' width='75'><font color='$sun_color'><b>Sun</b></font></td>
	      <td align='center' height='20' width='75'><font color='#908c90'><b>Mon</b></font></td>
	      <td align='center' height='20' width='75'><font color='#908c90'><b>Tue</b></font></td>
	      <td align='center' height='20' width='75'><font color='#908c90'><b>Wed</b></font></td>
	      <td align='center' height='20' width='75'><font color='#908c90'><b>Thu</b></font></td>
	      <td align='center' height='20' width='75'><font color='#908c90'><b>Fri</b></font></td>
	      <td align='center' height='20' width='75'><font color='$sat_color'><b>Sat<b></font></td>
		</tr>
		<tr>
	");
    $count=0;
	/*------ 첫번째 주에서 빈칸 시작-------*/
	for($i=0; $i<$first_day; $i++){
		echo "<td height='50' width='60'>&nbsp;</td>";
		$count++;
	}
	/*------ 날짜표시 시작 ---------------*/
	for($day=1;$day<=$total_day;$day++){
		$count++;
		if($day==$today_day && $month==$today_month && $year==$today_year){
	        $day_color=$today_color;
		} else {
			if ($count==1) { 
       	   		$day_color=$sun_color;
			} else if ($count==7) {
	       	   	$day_color=$sat_color;
			} else { 
	       	   	$day_color="#908c90";
			}
		}
		$paydate = sprintf('%04d-%02d-%02d',$today_year, $month, $day );
		if($page_mode =="pay"){       // 지출내역 뽑아오기..
			$sql = "select sum(money) as money from kapp_pay where userid='$H_ID' and paydate='$paydate' ";
   			$result = sql_query($sql);
	   		$row = sql_fetch_array($result);
			$moneytot = $row['money'];
			$sql = "select * from kapp_pay where userid='$H_ID' and paydate ='$paydate'";
  			$result = sql_query($sql);
	   		#$row = sql_fetch_array($result);
			$tit='';
			$itit='';
			$ptit='';
			while ($row = sql_fetch_array($result )) {
				$tit = $tit.':'.$row['payinfo'];
				$ptit = $ptit.':'.$row['payinfo'].':'.$row['memo'].':'. number_format( $row['money']);
			}

			if( $moneytot ) {
   				$day_paysum = "(<font color=red title='" . $ptit . "'>-)".number_format( $moneytot)."$tit</font>"; 
			} else { 
				$day_paysum = "";
			}
			$sql = "select sum(money) as money from kapp_income where userid='$H_ID' and incomedate ='$paydate'";
			$result = sql_query($sql);
	   		$row = sql_fetch_array($result); 
			$moneytot = $row['money'];
			$sql = "select * from kapp_income where userid='$H_ID' and incomedate ='$paydate'";
  			$result = sql_query($sql);
			$tit='';
			$itit='';
			$ptit='';
			while ($row = sql_fetch_array($result )) {
				$tit = $tit.':'.$row['incomeinfo'];
				$itit = $itit.':'.$row['incomeinfo'].':'.$row['memo'].':'. number_format( $row['money']);
			}
			if( $moneytot ) {
				$day_paysum2 = "(<font size=2 color=blue title='" . $itit . "'><b>+</b>)".number_format( $moneytot)."$tit</font>";
			} else {
				$day_paysum2 = "";
			}
		} else if( $page_mode=="income") { 	// 수입내역 뽑아오기..
			$sql = "select sum(money) as money from kapp_pay where userid='$H_ID' and paydate='$paydate' ";
   			$result = sql_query($sql);
	   		$row = sql_fetch_array($result);
			$moneytot = $row['money'];
			$sql = "select * from kapp_pay where userid='$H_ID' and paydate ='$paydate'";
  			$result = sql_query($sql);
	   		#$row = sql_fetch_array($result);
			$tit='';
			$itit='';
			$ptit='';
			while ($row = sql_fetch_array($result )) {
				$tit = $tit.':'.$row['payinfo'];
				$ptit = $ptit.':'.$row['payinfo'].':'.$row['memo'].':'. number_format( $row['money']);
			}
			if( $moneytot ) {
   				$day_paysum = "(<font color=red title='" . $ptit . "'>-)".number_format( $moneytot)."<br>$tit</font>"; 
			} else { 
				$day_paysum = "";
			}
			// 수입내역 뽑아오기..............................................................................
			$sql = "select sum(money) as money from kapp_income where userid='$H_ID' and incomedate ='$paydate'";
			$result = sql_query($sql);
	   		$row = sql_fetch_array($result); 
			$moneytot = $row['money'];
			$sql = "select * from kapp_income where userid='$H_ID' and incomedate ='$paydate'";
  			$result = sql_query($sql);
			$tit='';
			$itit='';
			$ptit='';
			while ($row = sql_fetch_array($result )) {
				$tit = $tit.':'.$row['incomeinfo'];
				$itit = $itit.':'.$row['incomeinfo'].':'.$row['memo'].':'. number_format( $row['money']);
			}
			if( $moneytot ) {
				$day_paysum2 = "(<font size=2 color=blue title='" . $itit . "'><b>+</b>)".number_format( $moneytot )." <br>$tit</font>";
			} else {
				$day_paysum2 = "";
			}
		}
	    echo("
		 <td valign=top height='50' width='75' onClick=\"inputwindow('$page_mode','$paydate')\" onMouseOut=this.style.backgroundColor='' onMouseOver=\"this.style.backgroundColor='#ffe5cc'
		"); 
		// \n 클릭하면 등록화면이 출력됩니다. 
		echo " \" class='hand' title='Click to display the registration screen.'>
			<font color='$day_color' ><b>$day</b>
			<br>$day_paysum 
			<br>$day_paysum2 
			</font></td>
		";
		if($count==7) { 
			echo "</tr>";
			if($day != $total_day) {
				echo "<tr>";
	            $count=0;
           }
		}
	} 
/*------ 날짜표시 끝 -----------------*/
/*------ 마지막주 빈칸 시작-----------*/   
	for($day++; $total_day < $day && $count<7; ) {
		$count++;
        echo "<td height='50' width='75'>&nbsp;</td>";
        if($count==7) {
			echo "</tr>";
		}	
	}
/*------ 마지막주 빈칸 끝 ------------*/   
$last_day = $day - 2;
$pay_date = sprintf('%04d-%02d-01',$today_year, $month );
$last_date = sprintf('%04d-%02d-%02d',$today_year, $month, $last_day );
$query = "select sum(money) as money from kapp_pay where userid='$H_ID' and paydate>='$pay_date' and paydate<='$last_date' ";
$result = sql_query($query);
$row = sql_fetch_array($result);
$out = $row['money'];
$pay_total = number_format($row['money']);
$query = "select sum(money) as money from kapp_income where userid='$H_ID' and incomedate>='$pay_date' and incomedate<='$last_date' ";
$result = sql_query($query);
$row = sql_fetch_array($result);
$in = $row['money'];
$income_total = number_format($row['money']);

$pay_date = sprintf('%04d-01-01',$year );
$last_date = sprintf('%04d-12-31',$year );
$query = "select sum(money) as money from kapp_pay where userid='$H_ID' and paydate>='$pay_date' and paydate<='$last_date' ";
$result = sql_query($query);
$row = sql_fetch_array($result);
$yout = $row['money'];
$pay_total_year = number_format($row['money']);
$query = "select sum(money) as money from kapp_income where userid='$H_ID' and incomedate>='$pay_date' and incomedate<='$last_date' ";
$result = sql_query($query);
$row = sql_fetch_array($result);
$yin = $row['money'];
$income_total_year = number_format($row['money']);
  $jan=number_format($in - $out);
  $yjan=number_format($yin - $yout);
  echo "<tr height='25' align='center' bgcolor=cyan>
			<td colspan=3>Total income[monthly] : <font color=blue><b>$income_total</font> </td>
			<td colspan=1>Balance: <b> $jan </td>
			<td colspan=3>Total Expenditure[monthly] : <font color=red><b>$pay_total</font> </td>
		</tr>  
		<tr height='25' align='center' bgcolor=cyan>
			<td colspan=3>Total income[$year] : <font color=blue><b>$income_total_year</font> </td>
			<td colspan=1>Balance: <b>$yjan</td>
			<td colspan=3>Total Expenditure[$year] : <font color=red><b>$pay_total_year</font> </td>
		</tr>  
	   </TABLE>
	</td>
	</tr>
	<tr>
	<td align='center'>";
	if( $page_mode =='income'){
		$title_ = 'Income Insert';
		echo "<input type='button' value='Import Status' onclick='return false' title='It will change to import registration screen.' style='border-style:;background-color:#666fff;color:yellow;width:160px; height:25px;' >&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='button' value='Payment Status' onclick=income_button('pay') title='The expenditure registration screen changes.' style='border-style:;background-color:#666666;color:yellow;width:160px; height:25px;' >&nbsp;&nbsp;
		";
	} else if( $page_mode =='pay'){
		echo "<input type='button' value='Import Status' onclick=income_button('income') title='It will change to import registration screen.' style='border-style:;background-color:#666fff;color:yellow;width:160px; height:25px;' >&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='button' value='Payment Status' onclick='retutn false' title='The expenditure registration screen changes.' style='border-style:;background-color:#666666;color:yellow;width:160px; height:25px;' >&nbsp;&nbsp;
		";
	} else {
		echo "<input type='button' value='Import Status' onclick=income_button('income') title='It will change to import registration screen.' style='border-style:;background-color:#666fff;color:yellow;width:160px; height:25px;' >&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='button' value='Payment Status' onclick='retutn false' title='The expenditure registration screen changes.' style='border-style:;background-color:#666666;color:yellow;width:160px; height:25px;' >&nbsp;&nbsp;
		";
	}
?>
   </TD>
   </TR>
   </TABLE>
   </TD>
   </TR>
   </TABLE>
