<?php
	include_once('./tkher_start_necessary.php');
	/*
	  program_list3.php  : program list A
	  program_pglist.php : program list B
	*/
	$ss_mb_id	= get_session("ss_mb_id");
	$H_ID	= $ss_mb_id;	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	if( !$ss_mb_id ) {
		m_("You need to login. ");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	connect_count($host_script, $H_ID, 0, $referer);	// log count
	/*if( $member['mb_level'] < 2) {
		m_("member page");
		//echo("<meta http-equiv='refresh' content='0; URL=indexTT.php'>");
		exit;
	}*/
	$formula_		= "";
	$poptable_		= "";
	$column_all		= "";
	$pop_fld			= "";
	$pop_mvfld		= "";
	$relation_db	= "";
	$rel_mvfld		= "";
	$gita				= "";

	//$page = $_POST['page'];
	if( strlen($_POST['pj_code']) > 0  && strlen($_POST['pj_code_check']) > 0 ) {
		//$page = 1;
		$page = $_POST["page"];
		$_POST['pj_code_check'] = $_POST['pj_code'];
	} else if( $_POST['pj_code'] !=  $_POST['pj_code_check']) {
		$_POST['pj_code_check'] = $_POST['pj_code'];
		$page = 1;
	} else if( strlen($_POST['pj_code']) > 0 ) {
		$_POST['pj_code_check'] = $_POST['pj_code'];
		$page = 1;
        //m_("--- page: " . $page . ", pj_code: " . $_POST['pj_code'] . ", pj_code_check: " . $_POST['pj_code_check'] );
		//--- page: 1, pj_code: gggg, pj_code_check:
	} else if( strlen($_POST['pj_code']) == 0 ) {
		//$page = 1; //$_POST["page"];
		$page = $_POST["page"]; // 1
	} else {
		$page = 1;
	}
    //m_("page: " . $page . ", pj_code: " . $_POST['pj_code'] . ", pj_code_check: " . $_POST['pj_code_check'] );

	function item_array_func( $item , $iftype, $ifdata, $popdata, $relationdata) {
		global $formula_, $poptable_, $column_all, $pop_fld, $pop_mvfld, $rel_mvfld, $relation_db, $gita;
				$list	= explode("@", $item);
				$iftype = explode("|", $iftype);
				$ifdata = explode("|", $ifdata);
				$column_all		="";
				$formula_		="";
				$poptable_		="";
				$gita				="";
		for ( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
				$typeX	= $iftype[$j];
				$dataX	= $ifdata[$j];
				$ddd		= $list[$i];
				$fld		= explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
				$column_all = $column_all . $fld[2] . "(" . $fld[3] . ") , ";
						if( !$typeX ) { // 0 or ''
						} else if( $typeX == "11" ) { // calc
							$formula = explode(":", $dataX);
							$formula_ = $formula[1];
						} else if( $typeX == "13" ) { // 팝업창
							$poptable = explode(":", $dataX);
							$poptable_ = $poptable[1];
						} else {
							$gita = $gita . $fld[2] . "-" . $dataX . "<br>";
						}
		}
		$popdata = explode("@", $popdata); // pop_data, 첫번째 분류.
		$pop_fld ="";
		for ( $i=0,$j=1; $popdata[$i] != ""; $i++, $j++ ){
			$popfld = $popdata[$j];
			$popfld = explode(":", $popfld);
			$pop_fld = $pop_fld . $popfld[1] . ",";
		}
		$mpop = $popdata[0];
		$mpop = explode("$", $mpop); // pop_data, 두번째 분류.
		$pop_mvfld = "";
		for ( $i=0,$j=1; $mpop[$j] != ""; $i++, $j++ ){
			$mv = explode("|", $mpop[$j]); // pop_data, 세번째 분류.
			$fld1 = $mv[0];
			$fld2 = $mv[1];
			$mvfld1 = explode(":", $fld1);
			$mvfld2 = explode(":", $fld2);

			$pop_mvfld = $pop_mvfld . $mvfld1[1] . "=" . $mvfld2[1] . ", ";
		}
			$relationdata = explode("$", $relationdata);
			$rel_db = $relationdata[0];
			$reldb = explode(":", $rel_db);
			$relation_db = $reldb[1];
			$rel_mvfld = "";
		for ( $i=0,$j=1; $relationdata[$j] != ""; $i++, $j++ ){
			$reldata = $relationdata[$j];
			$rel = explode("|", $reldata );
			$fld1 = $rel[0];
			$sik = $rel[1];
			$fld2 = $rel[2];
			$rmvfld1 = explode(":", $fld1);
			$rmvfld2 = explode(":", $fld2);

			$rel_mvfld = $rel_mvfld . $rmvfld1[1] . $sik . $rmvfld2[1] . " , ";
		}
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<style>
table { border-collapse: collapse; }
th { background: #cdefff; height: 27px; }
th, td { border: 1px solid silver; padding:5px; }
</style>
<link rel="stylesheet" href="./admin.css" type="text/css" />
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
<script type="text/javascript" >
<!--
	function program_del_funcList2( seqno, pg_name, pg_code, hid, mid ) {
		//alert("pg_name:" + pg_name+ ", pg_code:" + pg_code+ ", seqno: " + seqno);
		msg = "Are you sure you want to delete the program " + pg_name +"?";//  \n( 프로그램 " + pg_name + "을 삭제할까요?) \n
		if ( window.confirm( msg ) )
		{
			document.table_list.mode.value			="Delete_mode";
			document.table_list.seqno.value		=seqno;
			document.table_list.pg_code.value	=pg_code;
			document.table_list.pg_name.value	=pg_name;
			document.table_list.action				="program_list3.php";
			document.table_list.submit();
		} else {
			return false;
		}
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.table_list.mode.value		="tab_list_pg70";
		document.table_list.seqno.value		=seqno;
		document.table_list.pg_name.value	=pg_name;
		document.table_list.pg_code.value	=pg_code;
		//alert("pg_code:" + pg_code);
		document.table_list.action				="./tkher_program_data_list.php";  // data list
		document.table_list.target				="_blank";
		document.table_list.submit();
	}
	function page_func( page, data ){
		document.tkher_search.mode.value		=''; // page click
		document.tkher_search.data.value		=data;
		document.tkher_search.page.value		=page;
		document.tkher_search.action		="program_list3.php";
		document.tkher_search.target='_self'; // .htm
		document.tkher_search.submit();
	}
	/*
	function kmember(mid) {
		document.tkher_search.mode.value='';
		document.tkher_search.mid.value=mid;
		var num = document.getElementById("kapp_user").selectedIndex;
		var arr = document.getElementById("kapp_user").options;
		document.tkher_search.mid_nm.value= arr[num].text;
		document.tkher_search.pj_code.value='';
		document.tkher_search.action="program_list3.php";
		document.tkher_search.submit();
	}*/
	function kproject_func(pj) {
		document.tkher_search.mode.value='';
		document.tkher_search.pj_code.value=pj;
		var num = document.getElementById("kproject").selectedIndex;
		var arr = document.getElementById("kproject").options;
		document.tkher_search.pj_name.value= arr[num].text;
		document.tkher_search.action="program_list3.php";
		document.tkher_search.submit();
	}
//-->
</script>
</head>
 <BODY>
 <center>
 <?php
	$mode		= $_POST["mode"];
	//$page		= $_POST["page"];

	if( isset($_POST['data']) ) $data = $_POST['data'];
	else $data = '';
	$param	= $_POST["param"];
	$sel		= $_POST["sel"];
	$seqno	= $_POST["seqno"];
	$pg_code	= $_POST["pg_code"];
	$pg_name= $_POST["pg_name"];
    //m_("pj_code: " . $_POST['pj_code'] . ", mode:" . $_POST['mode'] );

	if( $mode == 'Delete_mode' ) { //2023-09-19 add
		$lsD = " DELETE from {$tkher['table10_pg_table']} ";
		$lsD = $lsD . " where userid='".$H_ID."' and seqno=" . $seqno; //중요 Table 첫컬럼.
		echo "sql: " . $lsD;
		$reT = sql_query( $lsD );
		if( $reT ) {
			m_( "delete ok pg_name:" . $pg_name . ", pg_code:" . $pg_code); // delete ok pg_name:order_pg10, pg_code:dao_1632720522 , seqno: 184
		} else {
			m_( "delete error pg_name:" . $pg_name . ", pg_code:" . $pg_code);
		}
		$mode='';
	}
	$limite = 15;
	$page_num = 10;

	if( strlen($_POST['pj_code']) > 0 ) {
		$lsPJ = " where group_code ='".$_POST['pj_code']."' ";
		$lsPJand = " and group_code ='".$_POST['pj_code']."' ";
	} else {
		$lsPJ = " ";
		$lsPJand = " ";
	}

	if( $mode == 'Search' ) {
			$aa = explode(':', $tab_hnmS);
			$tab_enm = $aa[0];
			$tab_hnm = $aa[1];
		if( !$tab_enm ) {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where fld_enm='seqno' "; //중요 Table 첫컬럼.
			$ls = $ls . " ORDER BY tab_hnm asc, seqno asc ";
		} else {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where tab_enm='$tab_enm' and fld_enm='seqno' ";
			$result = sql_query( $ls );
			$rs		= sql_fetch_array( $result );
			$group_code	= $rs['group_code'];
			$group_name	= $rs['group_name'];
			$sqltable   = $rs['sqltable'];
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where tab_enm='$tab_enm' ";
		}
   } else if( $mode == 'Program_Search' ) {
		$page = 1;
		if( !$data ){
			$sel   = 'like';
			$param = 'pg_name';
		} else {
			$sel   = $_POST['sel'];
			$param = $_POST['param'];
		}
		if($sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param like '%$data%' " . $lsPJand;
			if( strlen($_POST['mid']) > 0 ) $ls = $ls;
			$ls = $ls . " ORDER BY upday desc, $param ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param $sel '$data' " . $lsPJand;
			if( strlen($_POST['mid']) > 0 ) $ls = $ls;
			$ls = $ls . " ORDER BY upday desc, $param ";
			//$ls = $ls . " ORDER BY group_code, upday desc, $param ";
		}
	} else if( strlen($_POST['pj_code']) > 0 ) {
		//m_(" len pj_code: " . $_POST['pj_code'] . ", mode:" . $_POST['mode'] );

		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where group_code= '".$_POST['pj_code']."'";
		$ls = $ls . " ORDER BY upday desc ";

		//echo $_POST['pj_code'] . ", ls: " . $ls; exit;
		//dao_1543912777, ls: SELECT * from {$tkher['table10_pg_table']} where group_code= 'dao_1543912777' ORDER BY upday desc

	} else if( strlen($data) > 0 ) {
		$sel   = $_POST['sel'];
		$param = $_POST['param'];
		if( !$param ) $param = 'pg_name';
		if( !$sel )   $sel   = 'like';
		if($sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where pg_name like '%$data%' " ;
			if( strlen($_POST['pj_code']) > 0 ) $ls = $ls . " and group_code= '".$_POST['pj_code']."'";
			$ls = $ls . " ORDER BY upday desc, $param ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where pg_name $sel '$data' ";
			if( strlen($_POST['mid']) > 0 ) {
				$ls = $ls . " and userid= '".$_POST['mid']."'";
				if( strlen($_POST['pj_code']) > 0 ) $ls = $ls . " and group_code= '".$_POST['pj_code']."'";
			} else if( strlen($_POST['pj_code']) > 0 ) $ls = $ls . " and group_code= '".$_POST['pj_code']."'";
			$ls = $ls . " ORDER BY upday desc, $param ";
		}
   } else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( strlen($_POST['pj_code']) > 0 ) $ls = $ls . " where group_code= '".$_POST['pj_code']."'";
		$ls = $ls . " ORDER BY upday desc "; //ORDER BY upday desc
		//$ls = $ls . " ORDER BY group_code "; //ORDER BY upday desc
   }
	$resultT = sql_query( $ls );
	if( $resultT ) {
		$total = sql_num_rows( $resultT );
		if( $total == 0 ) {
			//echo "total 0 sql: " . $ls; exit;
		}
		if( !$page) $page=1;
		$total_page = intval(($total-1) / $limite)+1;
		$first = ($page-1)*$limite;
		$last = $limite;
		if( $total < $last) $last = $total;
		$limit = " limit $first, $last ";
		//if ($page == "1"){
		if ($page == 1){
			$no = $total;
		} else {
			$no = $total - ($page - 1) * $limite;
		}
		//m_("page: " . $page . ", total: " . $total);
		//if( $limite > $total ) $page=1;

	} else {
		$total = 0;
		//echo "sql: " . $ls; exit;
	}
		$cur='B';
		include_once "./menu_run.php";
?>
<h2 title='pg:program_list3'>Program List (admin:<?=$H_ID?>) - total:<?=$total?></h2>
		<form name="tkher_search" target="_self" method="post" action="program_list3.php"  >
			<input type='hidden' name='mode'    value='Program_Search'>
			<input type='hidden' name='modeS'   value='Program_Search'>
			<input type='hidden' name='page'    value="<?=$page?>">
			<input type="hidden" name="pg_hnmS" value="<?=$pg_code?>:<?=$pg_name?>">
			<input type="hidden" name='pg_name' value="<?=$_POST['pg_name']?>">
			<input type="hidden" name="pg_code" value="<?=$_POST['pg_code']?>" >
			<input type="hidden" name="tab_hnmS" value="<?=$_POST['tab_enm']?>:<?=$_POST['tab_hnm']?>">
			<input type='hidden' name='tab_enm' value="<?=$_POST['tab_enm']?>">
			<input type='hidden' name='tab_hnm' value="<?=$_POST['tab_hnm']?>">
			<input type='hidden' name='mid'     value="<?=$_POST['mid']?>">
			<input type='hidden' name='mid_nm' value="<?=$_POST['mid_nm']?>">
			<input type="hidden" name='pj_name' value="<?=$_POST['pj_name']?>">
			<input type="hidden" name="pj_code" value="<?=$_POST['pj_code']?>" >
			<input type="hidden" name="pj_code_check" value="<?=$_POST['pj_code_check']?>" >
		<input type="hidden" name="data" >
		<input type="hidden" name="seqno" >
			<!-- <select name="kapp_user" id="kapp_user" onChange="kmember(this.value)" style="background-color:cyan;color:#000;height:24;">
			<option value="">Select member</option>
<?php
			if( strlen($_POST['mid']) > 0 ) echo "<option value='".$_POST['mid']."' selected >".$_POST['mid_nm']."</option>";
$sql ="SELECT * from {$tkher['tkher_member_table']} ";
$ret = sql_query($sql);
    for ($i=0; $rs=sql_fetch_array($ret); $i++) {
?>
			<option value="<?=$rs['mb_id']?>"><?=$rs['mb_name']?></option>
<?php } ?>
			</select>  -->
			<select name="kproject" id="kproject" onChange="kproject_func(this.value)" style="background-color:cyan;color:#000;height:24;">
			<option value="">Select Project</option>
<?php
	if( strlen($_POST['pj_code']) > 0 ) echo "<option value='".$_POST['pj_code']."' selected >".$_POST['pj_name']."</option>";

		if( strlen($_POST['mid'])>0 ) $sql ="SELECT * from {$tkher['table10_group_table']} where userid ='".$_POST['mid']."'";
		else $sql ="SELECT * from {$tkher['table10_group_table']} ";
	/*if( strlen($_POST['pj_code']) > 0 ){
		if( strlen($_POST['mid'])>0 ) $sql ="SELECT * from {$tkher['table10_group_table']} where userid ='".$_POST['mid']."' and group_code='" .$_POST['pj_code'] ."' ";
		else $sql ="SELECT * from {$tkher['table10_group_table']} where group_code ='". $_POST['pj_code']. "' ";
	} else {
		if( strlen($_POST['mid'])>0 ) $sql ="SELECT * from {$tkher['table10_group_table']} where userid ='".$_POST['mid']."'";
		else $sql ="SELECT * from {$tkher['table10_group_table']} ";
	}*/

	$ret = sql_query($sql);
    for( $i=0; $rs=sql_fetch_array($ret); $i++) {
?>
			<option value="<?=$rs['group_code']?>"><?=$rs['group_name']?>:<?=$rs['userid']?></option>
<?php } ?>
			</select>
			<select name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
			<option value="pg_name">Program</option>
			</select>
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
			<option value="like">Like</option>
			<option value="=">=</option>
			</select>
			<input type="text" name="data" maxlength="30" size="15" value='<?=$data?>'>
			<input type="submit" value="Search" title="- Search -">
		</form>
<FORM name="table_list" method='POST' enctype="multipart/form-data" >
	<input type="hidden" name="mode" >
	<input type="hidden" name="page" >
	<input type="hidden" name="data" >
	<input type="hidden" name="seqno" >
	<input type="hidden" name="pg_name" >
	<input type="hidden" name="pg_code" >
	<input type='hidden' name='tab_enm' value='<?=$tab_enm?>'>
	<input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>'>
	<input type='hidden' name='group_nameX' >
	<input type='hidden' name='param' value='<?=$param?>'>
	<input type='hidden' name='sel' value='<?=$sel?>'>
	<input type='hidden' name='data' value='<?=$data?>'>
	<input type='hidden' name='sel1' value='<?=$sel1?>'>
	<input type='hidden' name='param2' value='<?=$param2?>'>
	<input type='hidden' name='sel2' value='<?=$sel2?>'>
	<input type='hidden' name='data2' value='<?=$data2?>'>

<table class='floating-thead' width="100%">
<thead  width="100%">
	<tr>
	<th>NO</th>
	<th>manager</th>
	<th>Project</th>
	<th>Program</th>
	<th>Table</th>
	<th>Date</th>
	</tr>
</thead>
<tbody width="100%">
 <?php
	$line=0;
	$i=1;
	if($mode == "" || $mode == "Program_Search")	$ls = $ls . " $limit ";

	$resultT	= sql_query( $ls );

	while ( $rs = sql_fetch_array( $resultT ) ) {
		$line=$limite*$page + $i - $limite;
			$bgcolor = "#eeeeee";
		$if_data = $rs['if_data'];
		$pop_data = $rs['pop_data']; // item_array_func()에서 pop_data는 1.@로 분류, 2.$분류,3:로 분류를 3번 한다
		$item_all= item_array_func( $rs['item_array'], $rs['if_type'], $rs['if_data'], $rs['pop_data'], $rs['relation_data'] );
		if( $pop_fld && $pop_mvfld )	$attr = $pop_fld . "<br>" .$pop_mvfld . "<br>" . $gita;
		else if( $pop_fld && !$pop_mvfld )	$attr = $pop_fld . "<br>" . $gita;
		else if( !$pop_fld && $pop_mvfld )	$attr = $pop_mvfld . "<br>" . $gita;
		else if( !$pop_fld && !$pop_mvfld )	$attr = $gita;
		else $attr="";
  ?>
	<input type="hidden" name="pg_codeX[<?=$i?>]" value="<?=$rs['pg_code']?>">
	<TR bgcolor='<?=$bgcolor?>' width='900' >
	<td width='1%'><?=$line?><!-- <input type='button' onclick="program_run_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>')"  value='DataList' style='height:22px;width:60px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  <?php echo "title=' Data List of ".$rs['pg_name']."' ";?>> --></td>
	<td  width='3%'><?=$rs['userid']?> </td>
	<td width='2%'><?=$rs['group_name']?><br><?=$rs['group_code']?></td>
	<td  width='5%'><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" title='program run'><?=$rs['pg_name']?></a></td>
	<td width='5%' title='Data List program run'>
		<a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" ><?=$rs['tab_hnm']?></a>
	</td>
	<td width='5%'><?=substr($rs['upday'], 0,10)?><br>

	<input type='button' onclick="program_run_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>')"  value='DataList' style='height:22px;width:60px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  <?php echo "title=' Data List of ".$rs['pg_name']."' ";?>>
	<?php if( $H_ID == $rs['userid'] ) {	?>
	&nbsp;&nbsp;<input type='button' onclick="program_del_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>', '<?=$H_ID?>', '<?=$rs['userid']?>')" value='Delete' style='height:22px;width:60px;background-color:red;color:white;border-radius:20px;border:1 solid black'  <?php echo "title=' Delete of ".$rs['pg_name']."' ";?>>
	<?php }	?>

	</td>
	</TR>
 <?php
		$i++;
		$count = $count - 1;
    }
 ?>
</form>
</tbody>
</table>
<table width="100%"   bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
	if( $mode=='Search' ) {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_back('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Search List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of ".$tab_hnm."' >&nbsp;&nbsp; ";
		echo "<input type='button' value='DB & Table Source Down' onclick=\"DB_table_create_source('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Database and table creation source and data processing program source creation and download of ".$tab_hnm."' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Table Source Down' onclick=\"Table_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Create and download table creation source and data processing program source of ".$tab_hnm."' >&nbsp;&nbsp; ";
	} else if($mode == "Program_click") {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_backX('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of ".$tab_hnm."' >&nbsp;&nbsp; ";
	} else {
		$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
		$last_page = $first_page+($page_num-1);
		if($last_page > $total_page) $last_page = $total_page;
		$prev = $first_page-1;
		if($page > $page_num)
			echo"<a href='#' title='page:$page, prev:$prev, data:$data' onclick=\"page_func('".$prev."','".$data."')\" style='font-size:18px;'>[Prev]</a>";
		for($i = $first_page; $i <= $last_page; $i++)
		{
			if($page == $i) echo" <b>".$i."</b> ";
			else
				echo"<a href='#' title='page:$page, i:$i, data:$data' onclick=\"page_func('".$i."','".$data."')\" style='font-size:18px;'>[".$i."]</a>";
		}
		$next = $last_page+1;
		if($next <= $total_page)
			echo"<a href='#' title='page:$page, next:$next, data:$data' onclick=\"page_func('".$next."','".$data."')\" style='font-size:18px;'>[Next]</a>";
	}
?>
	</td>
  </tr>
</table>
</BODY>
</HTML>
