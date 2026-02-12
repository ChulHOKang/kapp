<?php
	include_once('../tkher_start_necessary.php');
	/*
		kapp_table_list_adm.php : kapp_table_list.php copy
		call : table_design_update_adm.php
		- Download : Download data from db table to excel
		- Upload : Upload excel data to table
		- Delete : table and app all delete
		- Update : table re design
		- Data list : app data list
	*/
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_ID	= get_session("ss_mb_id");
	if( $H_ID == '' ) {
		m_("login please");
		echo("<meta http-equiv='refresh' content='0; URL=../'>"); exit;
	}
	$H_LEV=$member['mb_level'];
	if( $H_LEV < 8) {
		m_("admin page");
		echo("<meta http-equiv='refresh' content='0; URL=../'>"); exit;
	}

	if( isset($member['mb_point'])) $H_POINT = $member['mb_point'];
	else $H_POINT = 0;
	$ip = $_SERVER['REMOTE_ADDR'];
	connect_count($host_script, $H_ID, 0 ,$referer);
	$day = date("Y-m-d H:i:s");
	$pg_ = 'kapp_table_list_adm.php';
?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="../icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>
<style>
table { border-collapse: collapse; }
/*th { background: #cdefff; height: 32px; } */
th { background: #666fff; color: white; height: 32px; }
th, td { border: 1px solid silver; padding:5px; }
	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
		/*flex-direction: row;*/							/* row, row-reverse, column, column-reverse */
		/*flex-wrap: nowrap;*/							/* nowrap, wrap, wrap-reverse */
		justify-content: space-between;		/* flex-start, flex-end, center, space-between, space-around */
		align-content: center;				/* flex-start, flex-end, center, space-between, space-around 줄넘김 처리시 사용. */
		align-items: center;							/* flex-start, flex-end, center, baseline, stretch */
		height:25px;

	}
	.item {
		background-color: gold;
		boarder: 1px solid gray;
	}
</style>
<script src="//code.jquery.com/jquery.min.js"></script>

<script>
$(function () {
	let timer;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			switch(e.target.innerText){
				case 'Project'    : title_func('group_name'); break;
				case 'User'       : title_func('userid'); break;
				case 'Table name' : title_func('tab_hnm'); break;
				case 'Table code' : title_func('tab_enm'); break;
				case 'Date'       : title_func('upday'); break;
				default           : title_func(''); break;
			}
		}, 250); // 약 300ms 대기 후 실행
	  
	});

	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer); // 마지막 클릭 타이머를 제거
		//alert('더블 클릭되었습니다!');
		switch(e.target.innerText){
				case 'Project'    : title_wfunc('group_name'); break;
				case 'User'       : title_wfunc('userid'); break;
				case 'Table name' : title_wfunc('tab_hnm'); break;
				case 'Table code' : title_wfunc('tab_enm'); break;
				case 'Date'       : title_wfunc('upday'); break;
				default           : title_wfunc(''); break;
		}
	});

	  $('table.floating-thead').each(function() {
		if( $(this).css('border-collapse') == 'collapse') {
		  $(this).css('border-collapse','separate').css('border-spacing',0);
		}
		$(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
	  });
	  $(window).scroll(function() {
		var scrollTop = $(window).scrollTop(),
		  scrollLeft = $(window).scrollLeft();
		$('table.floating-thead').each(function(i) {
		  var thead = $(this).find('thead:last'),
			clone = $(this).find('thead:first'),
			top = $(this).offset().top,
			bottom = top + $(this).height() - thead.height();
		  if( scrollTop < top || scrollTop > bottom ) {
			clone.hide();
			return true;
		  }
		  if( clone.is('visible') ) return true;
		  clone.find('th').each(function(i) {
			$(this).width( thead.find('th').eq(i).width() );
		  });
		  clone.css("margin-left", -scrollLeft ).width( thead.width() ).show();
		});
	  });
});
</script>
<!-- <link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>
<link rel="stylesheet" href="../include/css/kancss.css" type="text/css"> -->

<?php
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10;
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode	= '';

	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	if( isset( $_POST['fld_code_asc']) ) $fld_code_asc= $_POST['fld_code_asc'];
	else $fld_code_asc = '';

	if( isset($_POST['group_code']) && $_POST['group_code']!='' ) {
		$group_code = $_POST['group_code'];   
		$wsel = " and group_code = '$group_code' ";
	} else {
		$group_code= '';
		$wsel = '';
	}

	if( isset($_POST["pg_code"]) ) $pg_code		= $_POST["pg_code"];
	else $pg_code		= "";
	if( isset($_POST["tab_enm"]) ) $tab_enm	= $_POST["tab_enm"];
	else $tab_enm		= "";
	if( isset($_POST["tab_hnm"]) ) $tab_hnm	= $_POST["tab_hnm"];
	else $tab_hnm		= "";

	if( isset($_POST['param']) && $_POST['param']!='' ) $param =$_POST['param'];
	else $param = "tab_hnm";
	if( isset($_POST['sel']) && $_POST['sel']!='' ) $sel =$_POST['sel'];
	else $sel = "";
	if( isset($_POST['data']) && $_POST['data']!='' ) $data = $_POST['data'];
	else $data	= "";

   if( $H_LEV > 7 && $mode == 'Delete_mode' ) {
		$query	="delete from {$tkher['table10_table']} where tab_enm='$tab_enm' ";
		$mq1	=sql_query($query);
		if( !$mq1 ) {
			printf("query:%s", $query );
			m_(" $tab_hnm table delete failed.");
				exit;
		} else {
			$query	="delete from {$tkher['table10_pg_table']} where tab_enm='$tab_enm' ";
			$mq3	=sql_query($query);
			if( !$mq3 ) {
				printf("query:%s", $query );
				m_(" $tab_hnm table delete failed.");
				exit;
			}
			if( kapp_table_check( $tab_enm ) ){
				$query	="drop table $tab_enm";
				$mq2	=sql_query($query);
				if( !$mq2 ) {
					m_(" DB $tab_hnm Failed to delete table. ");
					exit;
				}
				m_(" Table information and program deletion succeeded! ");
			}
		}
		$url = "kapp_table_list_adm.php";
		echo "<script>window.open( '$url' , '_self', '');</script>";
   } else if( $mode == 'Search' && $H_LEV > 7 ) {
	   m_("$mode, tab_hnmS: $tab_hnmS"); //Search, tab_hnmS: crakan59_gmail_1762740284:성품테이블
			$aa = explode(':', $tab_hnmS);
			$tab_enm = $aa[0];
			$tab_hnm = $aa[1];
		if( !$tab_enm ) {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " WHERE fld_enm='seqno' ";
		} else {
			$result = sql_query( "SELECT * from {$tkher['table10_table']} where tab_enm='$tab_enm' and fld_enm='seqno'" );
			$rs		= sql_fetch_array( $result );
			$group_code	= $rs['group_code'];
			$group_name	= $rs['group_name'];
			$sqltable   = $rs['sqltable'];
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where tab_enm='$tab_enm' ";
		}
   } else if( $mode == 'Table_Search' ) {
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			if( isset($data) && $data !=''  ){
				$ls = $ls . " where fld_enm='seqno' and $param like '%$data%' ";
				if( $wsel!='') $ls = $ls . $wsel;
			} else {
				$ls = $ls . " where fld_enm='seqno' ";
				if( $wsel!='') $ls = $ls . $wsel;
			}
		} else {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			if( isset($data) && $data !='' ) {
				$ls = $ls . " where fld_enm='seqno' and $param $sel '$data' ";
			} else {
				$ls = $ls . " where fld_enm='seqno' and userid='$H_ID'";
			}
			if( $wsel!='') $ls = $ls . $wsel;
		}
	} else if( $mode == 'Search_Project' ) {
		$ls = " SELECT * from {$tkher['table10_table']} ";
		if( $wsel!='') $ls = $ls . " where fld_enm='seqno' " . $wsel;
		else $ls = $ls . " where fld_enm='seqno' ";
   } else {
		$ls = " SELECT * from {$tkher['table10_table']} ";
		$ls = $ls . " where fld_enm='seqno' ";
		if( $wsel!='') $ls = $ls . $wsel;
   }

	$resultT	= sql_query( $ls );
	$total = sql_num_rows( $resultT );

	$total_page = intval(($total-1) / $line_cnt)+1;
	if( $page>1) $first = ($page-1) * (INT)$line_cnt; 
	else $first =0;

	$last = $line_cnt;
	if( $total < $last) $last = $total;
	$limit = " limit $first, $last ";
	if( $page == 1){
		$no = $total;
	} else {
		if( $page>1) $no = $total - ($page - 1) * $line_cnt;
		else $no = $total;
	}

	function kapp_table_check( $tab ){
		global $table_prefix;
		$sql = "SELECT COUNT(*) as cnt FROM Information_schema.tables
		WHERE table_schema = '".KAPP_MYSQL_DB."'
		AND table_name = '".$tab."' ";
		$ret = sql_fetch($sql);
		if( $ret['cnt'] > 0 ) { 
			m_("Rec count:".$ret['cnt'] .", " . $tab . ", already exists. ");
			echo "<br>rec count:".$ret['cnt'] .", " . $tab . ", already exists. ";
			return true;
		} else { 
			echo "<br>" . $tab . ", --- ";
			return false;
		}
	}

?>
<script type="text/javascript" >
<!--
	function title_wfunc(fld_code){       
		document.table_list.page.value = 1;
		document.table_list.fld_code.value= fld_code;
		document.table_list.fld_code_asc.value= 'desc';
		document.table_list.mode.value='title_wfunc';
		document.table_list.target='_self';
		document.table_list.action='kapp_table_list_adm.php';
		document.table_list.submit();                         
	} 
	function title_func(fld_code){       
		document.table_list.page.value = 1;                
		document.table_list.fld_code.value= fld_code;           
		document.table_list.fld_code_asc.value= 'asc';
		document.table_list.mode.value='title_func';           
		document.table_list.target='_self';
		document.table_list.action='./kapp_table_list_adm.php';
		document.table_list.submit();                         
	} 
	function check_enter() { if (event.keyCode == 13) { search_func(); } }
	function Cancle_run() {
		window.open('./','_top','');
	}
	function excel_upload_func(tab_enm, tab_hnm){
		document.table_list.mode.value		="Upload_mode_table10i";
		document.table_list.tab_enm.value	=tab_enm;
		document.table_list.tab_hnm.value	=tab_hnm;
		document.table_list.action			="../excel_load.php";
		document.table_list.submit();
	}
	function excel_down_func(tab_enm, tab_hnm){
		Lid = document.table_list.login_id.value;
		if( !Lid ) {
			alert("member page "); return false;
		} else {
			document.table_list.mode.value		="Excel_mode_table10i";
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.action			="../down_excel_file.php";
			document.table_list.submit();
		}
	}
	function table_update_func(tab_enm, tab_hnm, group_code , mid) {
		msg = "table are also update. \n Do you want to update the " + tab_hnm + " table? ";
		if ( window.confirm( msg ) ){
			document.table_list.mode.value ="Search";
			document.table_list.mid.value	=mid;
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.tab_hnmS.value	=tab_enm + ":"+tab_hnm;
			document.table_list.group_code.value	=group_code;
			document.table_list.target='_self';
			document.table_list.action ="./table_design_update_adm.php";
			document.table_list.submit();
		} else {
			return false;
		}
	}
	function delete_table_func(tab_enm, tab_hnm ) {
		msg = "When you delete a table, all the programs that used the table are also deleted. \n Data can not be recovered.\n Do you want to delete the " + tab_hnm + " table? ";
		if ( window.confirm( msg ) ){
			document.table_list.mode.value ="Delete_mode";
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.target='_self';
			document.table_list.action ="kapp_table_list_adm.php";
			document.table_list.submit();
		} else {
			return false;
		}
	}
	function table_sel_func(enm, hnm, data, page) {
		document.table_list.data.value = data;
		document.table_list.page.value = page;
		document.table_list.tab_hnmS.value = enm + ":" + hnm;
		document.table_list.tab_enm.value=enm;
		document.table_list.tab_hnm.value=hnm;
		document.table_list.mode.value='Search';
		document.table_list.action="kapp_table_list_adm.php";
		document.table_list.target='_self'; // .htm
		document.table_list.submit();
	}
	function program_run_funcList( pg_name, pg_code ) {
		document.table_list.mode.value		="kapp_table_list_adm";
		document.table_list.pg_name.value	=pg_name;
		document.table_list.pg_code.value	=pg_code;
		document.table_list.action				="../tkher_program_run.php";
		document.table_list.target='_blank';
		document.table_list.submit();
	}
	function program_run_funcListT( pg_name, pg_code, group_code ) {
		document.table_list.mode.value		="tab_list_pg70";
		document.table_list.pg_name.value	=pg_name;
		document.table_list.pg_code.value	=pg_code;
		document.table_list.group_code.value=group_code;
		document.table_list.page.value	=1;
		document.table_list.action ="../tkher_program_data_list.php";
		document.table_list.target='_blank';
		document.table_list.submit();
	}
	function tkher_source_create(hnm, enm, $coin){
		if( $coin < 1000 ) {
			alert('Point is low. You must do activities to accumulate points. point:'+ $coin);
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.table_list.mode.value = "DN_sqltable";
				document.table_list.action = '../tkher_php_tableDN.php';
				document.table_list.target = '_blank';
				document.table_list.submit();
			} else {
				alert('Cancel!');
			}
		}
	}
	function Table_source_create(hnm, enm, $coin){
		if( $coin < 1000 ) {
			alert('Point is low. You must do activities to accumulate points. point:'+ $coin);
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.table_list.mode.value	= "sqltable_only";
				document.table_list.action		= '../tkher_php_tableDN.php';
				document.table_list.target		= '_blank';
				document.table_list.submit();
			} else {
				alert('Cancel!');
			}
		}
	}
	function table_search(){
		var tab_hnm = document.table_list.data.value;
		var tab = document.table_list.tab_hnmS.value;
		document.table_list.page.value =1;
		document.table_list.mode.value='Table_Search';
		document.table_list.action="kapp_table_list_adm.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	function run_back( mode, data, page){
		document.table_list.group_code.value='';
		document.table_list.mode.value		='';
		document.table_list.data.value		=data;
		document.table_list.page.value		=page;
		document.table_list.action		="kapp_table_list_adm.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	function page_func( page, data ){

		document.table_list.mode.value		='';
		document.table_list.data.value		=data;
		document.table_list.page.value		=page;
		document.table_list.action		="kapp_table_list_adm.php";
		document.table_list.target='_self';
		document.table_list.submit();

	}
	function my_data(){
		//alert("-- my"); return;
		document.table_list.mode.value='My_List';
		document.table_list.action		="kapp_table_list_adm.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	function Change_line_cnt( $line){
		document.table_list.page.value = 1;
		document.table_list.line_cnt.value = $line;
		document.table_list.target='_self';
		document.table_list.action='kapp_table_list_adm.php';
		document.table_list.submit();
	}
	function group_code_change_func(cd){
		index=document.table_list.group_code.selectedIndex;
		nm = document.table_list.group_code.options[index].text;
		document.table_list.mode.value='Search_Project';
		document.table_list.group_name.value=nm;
		document.table_list.action		="kapp_table_list_adm.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
//-->
</script>
<body>
<center>
<h2 title='pg:kapp_program_list_all'>KAPP Table List (total:<?=$total?>)</h2>

<FORM name="table_list" Method='post'  enctype="multipart/form-data" >
	<input type="hidden" name="login_id" value="<?=$H_ID?>">
	<input type="hidden" name="mode" value="<?=$mode?>">
	<input type="hidden" name="mid" >
	<input type='hidden' name='page' value="<?=$page?>">
	<input type="hidden" name="tab_hnmS" value=''>
	<input type="hidden" name="pg_name" value=''>
	<input type="hidden" name="pg_code" value='<?=$pg_code?>' >
	<input type='hidden' name='tab_enm' value='<?=$tab_enm?>'>
	<input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>'>
	<input type='hidden' name='group_name' >
	<input type="hidden" name='fld_code' value='<?=$fld_code?>' />
	<input type="hidden" name='fld_code_asc' value='<?=$fld_code_asc?>' />
<?php
		if( $mode == "Search" ) $T_msg = "[ Table10i, Table : <b>". $tab_hnm . "</b> ] - code: <b>" .$tab_enm . "</b>";
		else $T_msg = "[ ".$member['mb_id']." ]";
		if( !isset($H_ID) || $H_ID == '' || !$H_ID ) {
			$T_msg = $T_msg . " , " . $ip;
		} else {
			$T_msg = $T_msg . ", Point:" . number_format($H_POINT). ", Lev:" . $member['mb_level'];
		}
?>
		<div><center>
			<select name="param" style="border-style:;background-color:gray;color:white;height:24;">
				<option value="tab_hnm" style="background-color:gray;color:white;" >Table</option>
				<option value="userid" style="background-color:gray;color:white;">User</option>
				<option value="group_name" style="background-color:gray;color:white;">Project Name</option>
			</select>
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="like" <?php if( $sel=='like') echo " selected ";?> >Like</option>
				<option value="=" <?php if( $sel=='=') echo " selected ";?> >=</option>
			</select>
			<input type="text" name="data" value='<?=$data?>' maxlength="30" size="15">
			<input type='button' value='Search' onclick="javascript:table_search();" >
		</div>

<span title='my data print - kapp_table_list_adm.php'><strong><a onclick="javascript:my_data();" style="background-color:black;color:yellow;height:36px;border-radius:20px;">&nbsp;&nbsp;&nbsp;<?=$T_msg?></a></strong></span>
<br>
<span>
		<SELECT id='group_code' name='group_code' onchange="group_code_change_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered.' "; ?> >
			<option value=''>Project</option>
<?php
			$result = sql_query( "SELECT * from {$tkher['table10_group_table']} order by group_name " );
			while($rs = sql_fetch_array($result)) {
				$chk = '';
				if( $rs['group_code']==$group_code) $chk =' selected ';
?>
				<option value='<?=$rs['group_code']?>' <?php echo $chk; ?>><?=$rs['group_name']?></option>
<?php
			}
?>
		</select>
</span>
<span>
View Line: 
	<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
		<option value='10'  <?php if( $line_cnt=='10')  echo " selected" ?> >10</option>
		<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
		<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
		<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
	</select>&nbsp;&nbsp;&nbsp;&nbsp; 
</span>

<table class='floating-thead' width='100%'>
<thead id='tit_et' width='100%'>
	<tr align='center'>
		<TH>no</TH>
<?php
if( $mode != 'Search') {
	echo " <th title='User Sort click or doubleclick' >User</th> ";
	echo " <th title='project Sort click or doubleclick' >Project</th> ";
	echo " <th title='Program Sort click or doubleclick' >Table name</th> ";
	echo " <th title='Table Sort click or doubleclick' >Table code</th> ";
	echo " <th title='Date Sort click or doubleclick' >Date</th> ";
?>
	<TH>Excel</TH>
	<TH>Manage</TH>
<?php
} else if( $mode == 'Search'){
?>
	<TH>column</TH>
	<TH>column title</TH>
	<TH>type</TH>
	<TH>length</TH>
	<TH>memo</TH>
<?php } ?>
</TR>
</thead>
<tbody width='100%'>
<?php
		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),';
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';

    $line=0;
	$i=1;
	if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
	else $OrderBy	= " ORDER BY upday desc ";
	$ls = $ls . $OrderBy;
	//$ls = $ls . $limit;
	if( $mode != "Search") { // table 상세 조회가 아님.
		$ls = $ls . " $limit ";
	}
	$resultT	= sql_query( $ls );
	while( $rs = sql_fetch_array( $resultT ) ) {
		$group_code = $rs['group_code'];
		$mid = $rs['userid'];
		$line=$line_cnt*$page + $i - $line_cnt;
		$bgcolor = "#eeeeee";
		if( $H_ID == $mid) $bcolor ="style='background-color:white;'";
		else $bcolor='';
?>
		<input type="hidden" name="tab_enmX[<?=$i?>]" value="<?=$rs['tab_enm']?>">
		<TR VALIGN='TOP' bgcolor='<?=$bgcolor?>'>
		<TD <?=$bcolor?> ><?=$line?></TD>
<?php
		if( $mode != 'Search') {
?>
			<TD <?=$bcolor?> title='table_code:<?=$rs['tab_enm']?>,date:<?=$rs['upday']?>' ><?=$rs['userid']?></TD>
			<TD <?=$bcolor?> title='project code:<?=$rs['group_code']?>' ><?=$rs['group_name']?></TD>
			<TD <?=$bcolor?> <?php echo "title='Prints a list of columns.' "; ?> >
			<a href="javascript:table_sel_func('<?=$rs['tab_enm']?>', '<?=$rs['tab_hnm']?>', '<?=$data?>', '<?=$page?>' );"><?=$rs['tab_hnm']?><img src="<?=KAPP_URL_T_?>/icon/default.gif"></a></TD>
			<TD <?=$bcolor?> <?php echo "title='Prints a list of columns.' "; ?> >
			<a href="javascript:table_sel_func('<?=$rs['tab_enm']?>', '<?=$rs['tab_hnm']?>', '<?=$data?>', '<?=$page?>' );"><?=$rs['tab_enm']?></a></TD>
			<TD <?=$bcolor?> ><?=$rs['upday']?></TD>
<?php
		} else if( $mode == 'Search' ){
?>
			<TD><?=$rs['fld_enm']?></TD>
			<TD><?=$rs['fld_hnm']?></TD>
			<TD><?=$rs['fld_type']?></TD>
			<TD><?=$rs['fld_len']?></TD>
			<TD title='<?=$rs['memo']?>'><?=$rs['memo']?></TD>
<?php
				$fld_enm = $rs['fld_enm'];
				if( $fld_enm != 'seqno' ){
					$fld_type = $rs['fld_type'];
					$fld_len		= $rs['fld_len'];
					if( $fld_type =='INT' )					$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
					else if( $fld_type =='BIGINT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0 , ';
					else if( $fld_type =='TINYINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0 , ';
					else if( $fld_type =='SMALLINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0 , ';
					else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0 , ';
					else if( $fld_type =='DECIMAL' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0 , ';
					else if( $fld_type =='FLOAT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0 , ';
					else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0 , ';
					else if( $fld_type =='CHAR' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
					else if( $fld_type =='VARCHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
					else if( $fld_type =='TEXT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
					else if( $fld_type =='DATE' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
					else if( $fld_type =='DATETIME' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
					else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				}
		}
//		if( $mode != 'Search' && isset($H_ID) && $H_ID !='' ){
		if( $mode != 'Search' && isset($H_LEV) && $H_LEV > 7 ){
				echo " <TD align='center' $bcolor><input type='button' name='excel' onclick=\"javascript:excel_down_func('".$rs['tab_enm']."', '".$rs['tab_hnm']."');\"  value=' Download ' style='height:22px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  title=' Download the data from the table to Excel-File. '>&nbsp;&nbsp;<input type='button' name='excel' onclick=\"javascript:excel_upload_func('".$rs['tab_enm']."', '".$rs['tab_hnm']."');\"  value=' Upload ' style='height:22px;background-color:red;border-radius:20px;color:yellow;border:1 solid black'  title=' Upload Excel data to table.  '> </TD>";

				if( $H_LEV > 7 || $rs['userid'] == $H_ID) echo " <TD align='center' $bcolor><input type='button' name='delete' onclick=\"javascript:delete_table_func('".$rs['tab_enm']."', '".$rs['tab_hnm']."', '".$rs['userid']."', '".$H_ID."');\"  value=' Table Delete ' style='height:24px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  title=' Table delete. ". $rs['tab_enm']. ":" . $rs['tab_hnm'] . "  '> ";
				else echo "<TD>---</TD>";
				if( $H_LEV > 7 || $rs['userid'] == $H_ID) echo "  <input type='button' name='table_update' onclick=\"javascript:table_update_func('".$rs['tab_enm']."', '".$rs['tab_hnm']."', '".$rs['group_code']."', '".$rs['userid']."');\"  value=' Table Update ' style='height:24px;background-color:blue;color:white;border-radius:20px;border:1 solid black'  title=' Table delete. ". $rs['tab_enm']. ":" . $rs['tab_hnm'] . "  '> </TD>";
		}
?>
	</TR>
 <?php
		$i++;
    }
		$item_list = $item_list . " primary key(seqno) ) ";
 ?>
		<tr align="center"></tr>
</tbody>
</table>
<table width="100%"   bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
	if( $mode =='Search' ) {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_back('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title='Search List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data Insert' onclick=\"program_run_funcList('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title=' Data Write of $tab_hnm' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."', '".$group_code."')\"  style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title=' Data List of $tab_hnm' >&nbsp;&nbsp; ";
		echo "<input type='button' value='All DownLoad' onclick=\"tkher_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title='Database and table creation source and data processing program source creation and download of $tab_hnm.' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Create table only' onclick=\"Table_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title=' Create and download table creation source and data processing program source of $tab_hnm.' >&nbsp;&nbsp; ";
	} else {
		$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
		$last_page = $first_page+($page_num-1);
		if( $last_page > $total_page) $last_page = $total_page;
		$prev = $first_page-1;
		if($page > $page_num)
			echo"<a href='#' onclick=\"page_func('".$prev."','".$data."')\" style='font-size:18px;'>[Prev]</a>";
		for($i = $first_page; $i <= $last_page; $i++)
		{
			if($page == $i) echo" <b>$i</b> ";
			else
				echo"<a href='#' onclick=\"page_func('".$i."','".$data."')\" style='font-size:18px;'>[$i]</a>";
		}
		$next = $last_page+1;
		if($next <= $total_page)
			echo"<a href='#' onclick=\"page_func('".$next."','".$data."')\" style='font-size:18px;'>[Next]</a>";
	}
?>
	</td>
  </tr>
</table>
		<input type="hidden" name="sqltable"  value='<?=$sqltable?>' >
		<input type="hidden" name="sql_list"  value='<?=$item_list?>' >
</form>
<?php
if( $mode != 'Search') echo "If you click Table Name, Table Code, a list of columns is displayed.";
?>
</body>
</html>
