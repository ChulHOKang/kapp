<?php
	include_once('./tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");
	if( isset($member['mb_point'])) $H_POINT = $member['mb_point'];
	else $H_POINT = 0;
	$ip = $_SERVER['REMOTE_ADDR'];
	connect_count($host_script, $H_ID, 0 ,$referer);
	/*
		table10i.php : table-{$tkher['table10_table']}
		: Table list. 
		- Download : Download data from db table to excel
		- Upload : Upload excel data to table
		- Delete : table and app all delete
		- Update : table re design
		- Data list : app data list
	*/
	$day = date("Y-m-d H:i:s");
	$pg_ = 'table10i.php';
?>
<html>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
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
<link rel="stylesheet" href="./include/css/common.css" type="text/css" />
<script type="text/javascript" src="./include/js/ui.js"></script>
<script type="text/javascript" src="./include/js/common.js"></script>
<link rel="stylesheet" href="./include/css/kancss.css" type="text/css">
</head>
<?php
	$limite = 15;
	$page_num = 10;
	if( isset($_REQUEST["sdata"]) ) $sdata	= $_REQUEST["sdata"];
	else $sdata	= "";
	if( isset($_REQUEST['Table_page']) ) $Table_page = $_REQUEST['Table_page'];
	else if( isset($_POST['Table_page']) ) $Table_page = $_POST['Table_page'];
	else $Table_page = 1;

	if( isset($_POST["mode"]) ) $mode = $_POST["mode"];
	else $mode	= "";
	if( isset($_POST["data"]) ) $data = $_POST["data"];
	else $data	= "";

	if( isset($_REQUEST["pg_code"]) ) $pg_code		= $_REQUEST["pg_code"];
	else $pg_code		= "";
	if( isset($_REQUEST["tab_enm"]) ) $tab_enm	= $_REQUEST["tab_enm"];
	else $tab_enm		= "";
	if( isset($_REQUEST["tab_hnm"]) ) $tab_hnm	= $_REQUEST["tab_hnm"];
	else $tab_hnm		= "";

	if( isset($_POST['param']) ) $param =$_POST['param'];
	else $param = "tab_hnm";

   if( $H_ID !=='' && $mode == 'Delete_mode' ) {
		$query	="delete from {$tkher['table10_table']} where tab_enm='$tab_enm' and userid='$H_ID' ";
		$mq1	=sql_query($query);
		if( !$mq1 ) {
			printf("query:%s", $query );
			m_(" $tab_hnm table delete failed."); // \\n (  기존의 $tab_hnm 테이블 정보 삭제 실패)
				exit;
		} else {
			$query	="delete from {$tkher['table10_pg_table']} where tab_enm='$tab_enm' and userid='$H_ID' ";
			$mq3	=sql_query($query);
			if( !$mq3 ) {
				printf("query:%s", $query );
				m_(" $tab_hnm table delete failed.");	// \\n (  기존의 프로그램:$tab_hnm 정보 삭제 실패)
				exit;
			}
			$query	="drop table $tab_enm";
			$mq2	=sql_query($query);
			if( !$mq2 ) {
				m_(" DB $tab_hnm Failed to delete table. ");	// \\n ( DB $tab_hnm 테이블 삭제 실패)
				exit;
			}
			m_(" Table information and program deletion succeeded! ");// \\n ( $tab_enm, $tab_hnm 테이블 정보와 프로그램 삭제 성공!)
		}
		$url = "table10i.php";
		echo "<script>window.open( '$url' , '_self', '');</script>";
   } else if( $H_ID && $mode=='group_name_add'){
   } else if( $H_ID && $mode=='group_name_change'){
   } else if( $mode == 'Search' ) {
			$aa = explode(':', $tab_hnmS);
			$tab_enm = $aa[0];
			$tab_hnm = $aa[1];
		if( !$tab_enm ) {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " WHERE fld_enm='seqno' ";
			$ls = $ls . " ORDER BY upday desc"; //tab_hnm asc, seqno asc ";
		} else {
			$result = sql_query( "SELECT * from {$tkher['table10_table']} where tab_enm='$tab_enm' and fld_enm='seqno' " );
			$rs		= sql_fetch_array( $result );
			$group_code	= $rs['group_code'];
			$group_name	= $rs['group_name'];
			$sqltable   = $rs['sqltable'];
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where tab_enm='$tab_enm' ";
			//$ls = $ls . " ORDER BY seqno asc ";
			$ls = $ls . " ORDER BY disno "; //disno"; upday desc
		}
   } else if( $mode == 'Table_Search' && isset($data) ) {
		if( isset($_POST['sel']) ) $sel =$_POST['sel'];
		else $sel = "";
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			if( isset($data) && $data !==""  ){
				$ls = $ls . " where fld_enm='seqno' and $param like '%$data%' ";
				$ls = $ls . " ORDER BY $param ";
			} else  $ls = $ls . " where fld_enm='seqno' ORDER BY upday desc";
		} else {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			if( isset($data) && $data !=="" ) {
				$ls = $ls . " where fld_enm='seqno' and $param $sel '$data' ";
			} else {
				$ls = $ls . " where fld_enm='seqno' ";
			}
			$ls = $ls . " ORDER BY upday desc"; //$param ";
		}
   } else if( $mode == 'My_List' ) {
		$ls = " SELECT * from {$tkher['table10_table']} ";
		$ls = $ls . " where fld_enm='seqno' and userid='$H_ID' ";
		$ls = $ls . " ORDER BY upday desc"; //" ORDER BY upday desc, tab_hnm asc, seqno asc ";
   } else {
		$ls = " SELECT * from {$tkher['table10_table']} ";
		$ls = $ls . " where fld_enm='seqno' ";
		$ls = $ls . " ORDER BY upday desc"; //" ORDER BY upday desc, tab_hnm asc, seqno asc ";
   }
   //echo $param . ". " . $ls; exit;//tab_hnm. SELECT * from kapp_table10 where fld_enm='seqno' ORDER BY tab_hnm
   //m_(" - $mode");
   //echo "sql: "  . $ls; exit; //sql: SELECT * from kapp_table10 where fld_enm='seqno' and tab_hnm '' ORDER BY tab_hnm
	$resultT	= sql_query( $ls );
	$total = sql_num_rows( $resultT );
		if(!$Table_page) $Table_page=1;
		$total_page = intval(($total-1) / $limite)+1;
		$first = ($Table_page-1)*$limite;
		$last = $limite;
		if($total < $last) $last = $total;
		$limit = " limit $first, $last ";
		if ($Table_page == "1")
			$no = $total;
		else {
			$no = $total - ($Table_page - 1) * $limite;
		}
?>
<script type="text/javascript" >
<!--
	function check_enter() { if (event.keyCode == 13) { search_func(); } }
	function Cancle_run() {
		window.open('/','_top','');
	}
	function group_name_add_func(){
		nm = document.table_list.group_name.value;
		msg = " Do you want to register the group name of "+nm+"? "; // \n (" + nm + "의 그룹명을 등록할까요?)
		if ( window.confirm( msg ) )
		{
			document.table_list.mode.value ="group_name_add";
			document.table_list.action = "table10i.php";
			document.table_list.submit();
		} else return false;
	}
	function group_name_change_func(nm){
		group_name = document.table_list.group_name.value;
		msg = " Do you want to change the group name of table " + nm + " to " + group_name + "?  ";//\n ( 테이블 " + nm + "의 그룹명을 " + group_name +"으로 변경할까요?) \n
		if ( window.confirm( msg ) )
		{
			document.table_list.mode.value ="group_name_change";
			document.table_list.action ="table10i.php";
			document.table_list.submit();
		} else return false;
	}
	function excel_upload_func(tab_enm, tab_hnm){
		document.table_list.mode.value		="Upload_mode_table10i";
		document.table_list.tab_enm.value	=tab_enm;
		document.table_list.tab_hnm.value	=tab_hnm;
		document.table_list.action			="excel_load.php"; // user용: excel_upload_user.php
		document.table_list.submit();
	}
	function excel_down_func(tab_enm, tab_hnm){
		//Lid = document.table_list.tab_enm.value;
		Lid = document.table_list.login_id.value;
		//alert("Lid:"+Lid + ", tab_enm:" + tab_enm);
		if( !Lid ) {
			alert("member page "); return false;
		} else {
			document.table_list.mode.value		="Excel_mode_table10i";
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.action			="down_excel_file.php"; // user용: excel_download_user.php
			document.table_list.submit();
		}
	}
	//---------------------------------------------
	function table_update_func(tab_enm, tab_hnm, group_code , mid) {
		msg = "table are also update. \n Do you want to update the " + tab_hnm + " table? ";
		if ( window.confirm( msg ) )
		{
			document.table_list.mode.value ="Search";
			document.table_list.mid.value	=mid;
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.tab_hnmS.value	=tab_enm + ":"+tab_hnm;
			document.table_list.group_code.value	=group_code;
			document.table_list.action ="table_design_update.php";
			document.table_list.submit();
		} else {
			return false;
		}
	}
	function delete_table_func(tab_enm, tab_hnm ) {
		msg = "When you delete a table, all the programs that used the table are also deleted. \n Data can not be recovered.\n Do you want to delete the " + tab_hnm + " table? ";
		if ( window.confirm( msg ) )
		{
			document.table_list.mode.value ="Delete_mode";
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.action ="table10i.php";
			document.table_list.submit();
		} else {
			return false;
		}
	}
	function change_table_func() {
		tab = document.table_list.tab_hnmS.value;
		document.table_list.mode.value='Search';
		document.table_list.action="table10i.php";
		document.table_list.submit();
	}
	function table_sel_func(enm, hnm, data, Table_page) {
		document.table_list.data.value = data;
		document.table_list.Table_page.value = Table_page;
		document.table_list.tab_hnmS.value = enm + ":" + hnm;
		document.table_list.tab_enm.value=enm;
		document.table_list.tab_hnm.value=hnm;
		document.table_list.mode.value='Search';
		document.table_list.action="table10i.php";
		document.table_list.target='_self'; // .htm
		document.table_list.submit();
	}
	function program_run_funcList( pg_name, pg_code ) {
		document.table_list.mode.value		="tab_list_pg70";
		document.table_list.pg_name.value	=pg_name;
		document.table_list.pg_code.value	=pg_code;
		document.table_list.action				="tkher_program_run.php";
		document.table_list.target='_blank';
		document.table_list.submit();
	}
	function program_run_funcListT( pg_name, pg_code ) {
		document.table_list.mode.value		="tab_list_pg70";
		document.table_list.pg_name.value	=pg_name;
		document.table_list.pg_code.value	=pg_code;
		document.table_list.Table_page.value	=1;
		document.table_list.action ="tkher_program_data_list.php";
		document.table_list.target='_blank';
		document.table_list.submit();
	}
	function tkher_source_create(hnm, enm, $coin){
		if( $coin < 1000 ) {
			alert('Point is low. You must do activities to accumulate points. point:'+ $coin);//UrlLinCoin Point가 부족합니다. point를 축적해야합니다.
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.table_list.mode.value = "DN_sqltable";
				document.table_list.action = 'tkher_php_tableDN.php';// download source create.
				document.table_list.target = '_blank';
				document.table_list.submit();
			} else {
				alert('Cancel!');
			}
		}
	}
	function Table_source_create(hnm, enm, $coin){
		if( $coin < 1000 ) {
			alert('Point is low. You must do activities to accumulate points. point:'+ $coin);//UrlLinCoin Point가 부족합니다. point를 축적해야합니다.
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.table_list.mode.value	= "sqltable_only"; // table 생성 소스만 다운.
				document.table_list.action		= 'tkher_php_tableDN.php';// download source create.
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
		document.table_list.Table_page.value =1;
		document.table_list.mode.value='Table_Search';
		document.table_list.action="table10i.php";
		document.table_list.target='_self'; // .htm
		document.table_list.submit();
	}
	function run_back( mode, data, Table_page){
		document.table_list.mode.value		='';//Program_Search
		document.table_list.data.value		=data;
		document.table_list.Table_page.value		=Table_page;
		document.table_list.action		="table10i.php";
		document.table_list.target='_self'; // .htm
		document.table_list.submit();
	}
	function page_func( Table_page, data ){

		document.table_list.mode.value		=''; // Table_page click
		document.table_list.data.value		=data;
		document.table_list.Table_page.value		=Table_page;
		document.table_list.action		="table10i.php";
		document.table_list.target='_self'; // .htm
		document.table_list.submit();

	}
	function my_data(){
		//alert("-- my"); return;
		document.table_list.mode.value='My_List'; // Table_page click
		document.table_list.action		="table10i.php";
		document.table_list.target='_self'; // .htm
		document.table_list.submit();
	}
//-->
</script>
<body>
<?php
		$cur='B';
		//include_once "./menu_run.php";
?>
<FORM name="table_list" Method='post'  enctype="multipart/form-data" >
	<input type="hidden" name="login_id" value="<?=$H_ID?>">
	<input type="hidden" name="mode" >
	<input type="hidden" name="mid" >
	<input type='hidden' name='Table_page' value="<?=$Table_page?>">
	<input type="hidden" name="tab_hnmS" value=''> <!-- table10i_old.php  -->
	<input type="hidden" name="pg_name" value=''>
	<input type="hidden" name="pg_code" value='<?=$pg_code?>' >
	<input type='hidden' name='tab_enm' value='<?=$tab_enm?>'>
	<input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>'>
	<input type='hidden' name='group_code' >
	<input type='hidden' name='group_name' >
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
			<select name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
			<option value="tab_hnm">Table</option>
			<option value="userid">User</option>
			</select>
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
			<option value="like">Like</option>
			<option value="=">=</option>
			</select>
			<input type="text" name="data" value='<?=$data?>' maxlength="30" size="15">
			<input type='button' value='Search' onclick="javascript:table_search();" >
		</div>

<span title='my data print - table10i.php'><strong><a onclick="javascript:my_data();" style="border-style:;background-color:black;color:yellow;height:28;border-radius:20px;"><?=$T_msg?></a></strong></span>

<table class='floating-thead' width='100%'>
<thead  width='100%'>
	<tr align='center'>
		<TH>no</TH>
<?php
if( $mode != 'Search') {
?>
	<TH>user</TH>
	<TH>Project</TH>
	<TH>table title </TH>
	<TH>table of DB</TH>
	<TH>date</TH>
	<TH>Excel</TH><!-- Excel Down -->
	<TH>Manage</TH><!-- Excel Upload -->
<?php
} else if( $mode == 'Search'){ //table click
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
		$item_list = $item_list . " seqno int auto_increment not null, ";
    $line=0;
	$i=1;
	if( $mode !== "Search") {
		$ls = $ls . " $limit ";
	}
	$resultT	= sql_query( $ls );
	while( $rs = sql_fetch_array( $resultT ) ) {
		$group_code = $rs['group_code'];
		$mid = $rs['userid'];
		$line=$limite*$Table_page + $i - $limite;
		$bgcolor = "#eeeeee";
		if( $H_ID == $mid) $bcolor ="style='background-color:white;'";
		else $bcolor='';
?>
		<input type="hidden" name="tab_enmX[<?=$i?>]" value="<?=$rs['tab_enm']?>">
		<TR VALIGN='TOP' bgcolor='<?=$bgcolor?>'>
		<TD <?=$bcolor?> ><?=$line?></TD>
		<!-- <TD><?=$rs['disno']?></TD> -->
<?php
		if( $mode !== 'Search') {
?>
			<TD <?=$bcolor?> title='table_code:<?=$rs['tab_enm']?>,date:<?=$rs['upday']?>'><?=$rs['userid']?></TD>
			<TD <?=$bcolor?> title='project code:<?=$rs['group_code']?>'><?=$rs['group_name']?></TD>
			<TD <?=$bcolor?> <?php echo "title='Prints a list of columns.' "; ?> >
			<a href="javascript:table_sel_func('<?=$rs['tab_enm']?>', '<?=$rs['tab_hnm']?>', '<?=$data?>', '<?=$Table_page?>' );"><?=$rs['tab_hnm']?><img src="<?=KAPP_URL_T_?>/icon/default.gif"></a></TD>
			<TD <?=$bcolor?> <?php echo "title='Prints a list of columns.' "; ?> >
			<a href="javascript:table_sel_func('<?=$rs['tab_enm']?>', '<?=$rs['tab_hnm']?>', '<?=$data?>', '<?=$Table_page?>' );"><?=$rs['tab_enm']?></a></TD>
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
				if( $fld_enm !== 'seqno' ){
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
					else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';	// 사용하지않는다.
				}
		}
		if( $mode !== 'Search' && isset($H_ID) && $H_ID !=='' ){
				echo " <TD align='center' $bcolor><input type='button' name='excel' onclick=\"javascript:excel_down_func('".$rs['tab_enm']."', '".$rs['tab_hnm']."');\"  value=' Download ' style='height:22px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  title=' Download the data from the table to Excel-File. '>&nbsp;&nbsp;<input type='button' name='excel' onclick=\"javascript:excel_upload_func('".$rs['tab_enm']."', '".$rs['tab_hnm']."');\"  value=' Upload ' style='height:22px;background-color:red;border-radius:20px;color:yellow;border:1 solid black'  title=' Upload Excel data to table.  '> </TD>";

				if($rs['userid'] == $H_ID) echo " <TD align='center' $bcolor><input type='button' name='delete' onclick=\"javascript:delete_table_func('".$rs['tab_enm']."', '".$rs['tab_hnm']."', '".$rs['userid']."', '".$H_ID."');\"  value=' Table Delete ' style='height:24px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  title=' Table delete. ". $rs['tab_enm']. ":" . $rs['tab_hnm'] . "  '> ";
				else echo "<TD>---</TD>";
				if($rs['userid'] == $H_ID) echo "  <input type='button' name='table_update' onclick=\"javascript:table_update_func('".$rs['tab_enm']."', '".$rs['tab_hnm']."', '".$rs['group_code']."', '".$rs['userid']."');\"  value=' Table Update ' style='height:24px;background-color:blue;color:white;border-radius:20px;border:1 solid black'  title=' Table delete. ". $rs['tab_enm']. ":" . $rs['tab_hnm'] . "  '> </TD>";
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
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_back('".$mode."', '".$data."', '".$Table_page."');\" style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title='Search List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data Insert' onclick=\"program_run_funcList('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title=' Data Write of $tab_hnm' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title=' Data List of $tab_hnm' >&nbsp;&nbsp; ";
		echo "<input type='button' value='All DownLoad' onclick=\"tkher_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title='Database and table creation source and data processing program source creation and download of $tab_hnm.' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Create table only' onclick=\"Table_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  title=' Create and download table creation source and data processing program source of $tab_hnm.' >&nbsp;&nbsp; ";
	} else {
		//$data = $_POST["data"];
		$first_page = intval(($Table_page-1)/$page_num+1)*$page_num-($page_num-1); // $page_num =10
		$last_page = $first_page+($page_num-1);
		if($last_page > $total_page) $last_page = $total_page;
		$prev = $first_page-1;
		if($Table_page > $page_num)
			echo"<a href='#' onclick=\"page_func('".$prev."','".$data."')\" style='font-size:18px;'>[Prev]</a>";
		for($i = $first_page; $i <= $last_page; $i++)
		{
			if($Table_page == $i) echo" <b>$i</b> ";
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
