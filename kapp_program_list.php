<?php
	include_once('./tkher_start_necessary.php');
	/*
	  kapp_program_list.php - program_list3.php copy  : program list A
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
	$formula_		= "";
	$poptable_		= "";
	$column_all		= ""; //my_func
	$pop_fld			= "";
	$pop_mvfld		= "";
	$relation_db	= "";
	$rel_mvfld		= "";
	$gita				= "";

	if( isset($_POST['mid']) ) $mid = $_POST['mid'];
	$mid = $H_ID;

	if( isset($_POST['page']) ) $page = $_POST['page'];
	else if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else $page=1;

	if( isset($_POST['pj_code']) && $_POST['pj_code']!='' ) $pj_code = $_POST['pj_code'];
	else $pj_code = "";
	if( isset($_POST['pj_name']) && $_POST['pj_name']!='' ) $pj_name = $_POST['pj_name'];
	else $pj_name = "";

//	if( isset($_POST['pj_code_check']) )	$pj_code_check = $_POST['pj_code_check'];
//	else $pj_code_check = "";

/*	if( isset($pj_code) && isset($pj_code_check) ) {
		if( $pj_code !=  $pj_code_check ) {
			$pj_code_check = $pj_code;
		}
	} else if( isset($pj_code)  ) {
		$pj_code_check = $pj_code;
	}*/

?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="./icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>
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
		msg = "Are you sure you want to delete the program " + pg_name +"?";
		if ( window.confirm( msg ) ){
			document.tkher_search.mode.value			="Delete_mode";
			document.tkher_search.seqno.value		=seqno;
			document.tkher_search.pg_code.value	=pg_code;
			document.tkher_search.pg_name.value	=pg_name;
			document.tkher_search.action				="kapp_program_list.php";
			document.tkher_search.submit();
		} else {
			return false;
		}
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.tkher_search.mode.value		="tab_list_pg70";
		document.tkher_search.seqno.value		=seqno;
		document.tkher_search.pg_name.value	=pg_name;
		document.tkher_search.pg_code.value	=pg_code;
		document.tkher_search.action				="./tkher_program_data_list.php";
		document.tkher_search.target				="_blank";
		document.tkher_search.submit();
	}
	function program_upgrade( seqno, pg_code, userid ) {
		document.tkher_search.mode.value		="program_upgrade";
		document.tkher_search.seqno.value		=seqno;
		document.tkher_search.userid.value	=userid;
		document.tkher_search.pg_code.value	=pg_code;
		document.tkher_search.action= "./kapp_pg_Upgrade.php";
		document.tkher_search.target ="_blank";
		document.tkher_search.submit();
	}

	function page_func( page, data ){
		document.tkher_search.mode.value		='';
		document.tkher_search.data.value		=data;
		document.tkher_search.page.value		=page;
		document.tkher_search.action		="kapp_program_list.php";
		document.tkher_search.target='_self';
		document.tkher_search.submit();
	}
	function kproject_func(pj) {
		document.tkher_search.page.value = 1;                
		document.tkher_search.mode.value='Project_search';
		document.tkher_search.pj_code.value=pj;
		Prj = pj.split(':');
		//var num = document.getElementById("kproject").selectedIndex;
		//var arr = document.getElementById("kproject").options;
		document.tkher_search.pj_code.value= Prj[0];
		document.tkher_search.pj_name.value= Prj[1];
		document.tkher_search.action="kapp_program_list.php";
		document.tkher_search.submit();
	}
	function title_func(fld_code){       
		document.tkher_search.page.value = 1;                
		document.tkher_search.fld_code.value= fld_code;           
		document.tkher_search.mode.value='title_func';           
		document.tkher_search.action='kapp_program_list.php';
		document.tkher_search.submit();                         
	} 
	function Change_line_cnt( $line){
		document.tkher_search.page.value = 1;
		document.tkher_search.line_cnt.value = $line;
		document.tkher_search.action='kapp_program_list.php';
		document.tkher_search.submit();
	}
	function search_func(){
		document.tkher_search.page.value = 1;
		document.tkher_search.mode.value = 'Program_Search';
		document.tkher_search.action='kapp_program_list.php';
		document.tkher_search.submit();
	}
//-->
</script>

 <BODY>
 <center>
 <?php
	if( isset($_POST["mode"]) ) $mode		= $_POST["mode"];
	else $mode	 = "";

	if( isset($_POST['param']) && $_POST['param'] !="" ) $param = $_POST['param'];
	else $param = '';
	if( isset($_POST['sel']) && $_POST['sel'] !="" ) $sel = $_POST['sel'];
	else $sel = '';
	if( isset($_POST['data']) && $_POST['data'] !="" ) $data = $_POST['data'];
	else $data = '';

	if( isset($_POST['seqno']) && $_POST['seqno'] !="" ) $seqno = $_POST['seqno'];
	else $seqno = '';

	if( isset($_POST['pg_code']) && $_POST['pg_code'] !="" ) $pg_code = $_POST['pg_code'];
	else $pg_code = '';
	if( isset($_POST['pg_name']) && $_POST['pg_name'] !="" ) $pg_name = $_POST['pg_name'];
	else $pg_name = '';

	//if( isset($_POST['mid_nm']) )  $mid_nm = $_POST['mid_nm'];
	//$mid_nm = "";

	if( isset($_POST['tab_hnm']) )  $tab_hnm = $_POST['tab_hnm'];
	$tab_hnm = "";
	if( isset($_POST['tab_enm']) )  $tab_enm = $_POST['tab_enm'];
	$tab_enm = "";
	
	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	
	//m_("pj_code: " . $pj_code . ", mode:" . $mode );

	if( $mode == 'Delete_mode' ) { 
		$lsD = " DELETE from {$tkher['table10_pg_table']} ";
		$lsD = $lsD . " where userid='".$H_ID."' and seqno=" . $seqno; //중요 Table 첫컬럼.
		echo "sql: " . $lsD;
		$reT = sql_query( $lsD );
		if( $reT ) {
			m_( "delete ok pg_name:" . $pg_name . ", pg_code:" . $pg_code);
			// delete ok pg_name:order_pg10, pg_code:dao_1632720522 , seqno: 184
		} else {
			m_( "delete error pg_name:" . $pg_name . ", pg_code:" . $pg_code);
		}
		$mode='';
	}
	//$limite = 15;
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10;

	if( isset($pj_code) &&  $pj_code != "") {
		$lsPJ = " where group_code ='".$pj_code."' ";
		$lsPJand = " and group_code ='".$pj_code."' ";
	} else {
		$lsPJ = " ";
		$lsPJand = " ";
	}

	/*if( $mode == 'Search' ) {
			$aa = explode(':', $tab_hnmS);
			$tab_enm = $aa[0];
			$tab_hnm = $aa[1];
		if( !$tab_enm ) {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where fld_enm='seqno' "; //중요 Table 첫컬럼.
//			$ls = $ls . " ORDER BY tab_hnm asc, seqno asc ";
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
   } else */
	if( $mode == 'Program_Search' ) {
		if($sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param like '%$data%' ";
			if( isset($pj_code) && $pj_code !='' ) $ls = $ls . " and group_code= '".$pj_code."'";
			$ls = $ls . " and userid= '".$H_ID."' ";
//			$ls = $ls . " ORDER BY upday desc, $param ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param $sel '$data' ";
			if( isset($pj_code) && $pj_code !='' ) $ls = $ls . " and group_code= '".$pj_code."'";
			$ls = $ls . " and userid= '".$H_ID."' ";
//			$ls = $ls . " ORDER BY upday desc, $param ";
		}
	} else if( $mode=='Project_search' ) {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid= '".$H_ID."'";
		if( $pj_code !='') $ls = $ls . " and group_code= '".$pj_code."' ";
//		$ls = $ls . " ORDER BY upday desc ";

	} else if( isset($data) && $data != "" ) {
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param like '%$data%' " ;
			$ls = $ls . " and userid= '".$H_ID."' ";
			if( isset($pj_code) && $pj_code !='' ) $ls = $ls . " and group_code= '".$pj_code."'";
//			$ls = $ls . " ORDER BY upday desc, $param ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param $sel '$data' ";
			$ls = $ls . " and userid= '".$H_ID."' ";
			if( isset($pj_code) && $pj_code !='' ) $ls = $ls . " and group_code= '".$pj_code."'";
//			$ls = $ls . " ORDER BY upday desc, $param ";
		}
   } else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid= '".$H_ID."'";
		if( isset($pj_code ) && $pj_code!='' ) $ls = $ls . " and group_code= '".$pj_code."'";
//		$ls = $ls . " ORDER BY upday desc ";
   }
	$resultT = sql_query( $ls );
	if( $resultT ) {
		$total = sql_num_rows( $resultT );
		$total_page = intval(($total-1) / $line_cnt)+1;
		if( $page > 1) $first = ($page-1)*$line_cnt;
		else $first = 0;
		$last = $line_cnt;
		if( $total < $last) $last = $total;
		$limit = " limit $first, $last ";
		if( $page == 1){
			$no = $total;
		} else {
			$no = $total - ($page - 1) * $line_cnt;
		}
		//m_("page: " . $page . ", total: " . $total);
		//if( $line_cnt > $total ) $page=1;

	} else {
		$total = 0;
		//echo "sql: " . $ls; exit;
	}
		$cur='B';
		include_once "./menu_run.php";


?>
<h2 title='pg:kapp_program_list'>Program List (admin:<?=$H_ID?>) - total:<?=$total?></h2>
		<form name="tkher_search" target="_self" method="post" action="kapp_program_list.php"  >
			<input type='hidden' name='mode'    value='<?=$mode?>'>
			<input type='hidden' name='page'    value="<?=$page?>">
			<input type="hidden" name="pg_hnmS" value="<?=$pg_code?>:<?=$pg_name?>">
			<input type="hidden" name='pg_name' value="<?=$pg_name?>">
			<input type="hidden" name="pg_code" value="<?=$pg_code?>" >
			<input type="hidden" name="tab_hnmS" value="<?=$tab_enm?>:<?=$tab_hnm?>">
			<input type='hidden' name='tab_enm' value="<?=$tab_enm?>">
			<input type='hidden' name='tab_hnm' value="<?=$tab_hnm?>">
			<input type='hidden' name='mid'     value="<?=$H_ID?>">
			<!-- <input type='hidden' name='mid_nm' value="<?=$mid_nm?>"> -->
			<input type="hidden" name='pj_name' value="<?=$pj_name?>">
			<input type="hidden" name="pj_code" value="<?=$pj_code?>" >
			<input type="hidden" name="pj_code_check" value="<?=$pj_code_check?>" >

		<input type="hidden" name="data" >
		<input type="hidden" name="seqno" >

	<input type="hidden" name="seqno" >
	<input type="hidden" name="userid" >
	<input type='hidden' name='group_name' >

			<!-- <select name="kapp_user" id="kapp_user" onChange="kmember(this.value)" style="background-color:cyan;color:#000;height:24;">
			<option value="">Select member</option>
<?php
			if( strlen($mid) > 0 ) echo "<option value='".$mid."' selected >".$_POST['mid_nm']."</option>";
$sql ="SELECT * from {$tkher['tkher_member_table']} ";
$ret = sql_query($sql);
    for ($i=0; $rs=sql_fetch_array($ret); $i++) {
?>
			<option value="<?=$rs['mb_id']?>"><?=$rs['mb_name']?></option>
<?php } ?>
			</select>  -->
			<SELECT name="kproject" id="kproject" onChange="kproject_func(this.value)" style="background-color:cyan;color:#000;height:24;">
			<option value="">Select Project</option>
			<!-- <option value="ETC:ETC" >ETC</option> --><!-- default : 2025-05-08 close -->
<?php
//	if( isset($pj_code) ) echo "<option value='".$pj_code."' selected >".$pj_name."</option>";

	//if( isset($H_ID) ) $sql ="SELECT * from {$tkher['table10_group_table']} where userid ='".$H_ID."'";
	//else $sql ="SELECT * from {$tkher['table10_group_table']} ";
	$sql ="SELECT * from {$tkher['table10_group_table']} where userid ='".$H_ID."'";
	$ret = sql_query($sql);
    //for( $i=0; $rs=sql_fetch_array($ret); $i++) {		//m_("g cd: " . $rs['group_code'] . ",  pj_code: ". $pj_code);
	while( $rs=sql_fetch_array($ret) ){
		$chk='';
		if( $pj_code == $rs['group_code'] ) $chk = ' selected ';
?>
			<option value="<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php echo $chk;?> ><?=$rs['group_name']?></option>
<?php } ?>
			</SELECT>
			<SELECT name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
				<option value="pg_name">Program</option>
			</select>
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="like" <?php if($sel =='like') echo ' selected ';?> >Like</option>
				<option value="=" <?php if($sel =='=') echo ' selected ';?> >=</option>
			</SELECT>
			<input type="text" name="data" maxlength="30" size="15" value='<?=$data?>'>
			<input type="button" value="Search" onclick='search_func()'>
			<!-- <input type="submit" value="Search" title="- Search -"> -->
		<!-- </form> -->
<!-- <FORM name="table_list" method='POST' enctype="multipart/form-data" > -->
<span>
View Line: 
	<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
		<option value='10'  <?php if( $line_cnt=='10')  echo " selected" ?> >10</option>
		<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
		<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
		<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
	</select>&nbsp;&nbsp;&nbsp;&nbsp; 
</span>

<table class='floating-thead' width="100%">
<thead  width="100%">
	<tr>
	<th>NO</th>
	<th>user</th>
	<th>Project</th>
	<th>Program</th>
	<th>Table</th>
	<th>Date</th>
	<th>Management</th>
	</tr>
</thead>
<tbody width="100%">
 <?php
	$line=0;
	$i=1;
	
//	$ls = $ls . " $limit ";
	$ls = $ls . $limit;
	$resultT	= sql_query( $ls );
	while( $rs = sql_fetch_array( $resultT ) ) {
		$line=$line_cnt*$page + $i - $line_cnt;
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
	<TR bgcolor='<?=$bgcolor?>' width='100%' >
	<td width='1%'><?=$line?></td>
	<td width='3%'><?=$rs['userid']?> </td>
	<td width='2%' title="project_code: <?=$rs['group_code']?>"><?=$rs['group_name']?></td>
	<td  width='5%'><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" title='program run'><?=$rs['pg_name']?></a></td>
	<td width='5%' title='Data List program run'>
		<a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" ><?=$rs['tab_hnm']?></a>
	</td>
	<td width='5%'><?=substr($rs['upday'], 0,10)?></td>
	<td width='15%' align='center'>
	<input type='button' onclick="program_run_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>')"  value='DataList' style='height:22px;width:66px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  <?php echo "title=' Data List of ".$rs['pg_name']."' ";?>>
<?php if( $H_ID == $rs['userid'] ) { ?>
	<input type='button' onclick="program_del_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>', '<?=$H_ID?>', '<?=$rs['userid']?>')" value='Delete' style='height:22px;width:60px;background-color:red;color:white;border-radius:20px;border:1 solid black'  <?php echo "title=' Delete of ".$rs['pg_name']."' ";?>>
	&nbsp;
	<input type='button' onclick="program_upgrade('<?=$rs['seqno']?>','<?=$rs['pg_code']?>','<?=$rs['userid']?>')" value=' Upgrade ' style='height:22px;width:69px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  <?php echo "title=' Upgrade of ".$rs['pg_name']."' ";?>>
<?php }	?>

	</td>
	</TR>
 <?php
		$i++;		//$count = $count - 1;
    }
 ?>
</form>
</tbody>
</table>
<table width="100%"   bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
	/*if( $mode=='Search' ) {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_back('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Search List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of ".$tab_hnm."' >&nbsp;&nbsp; ";
		echo "<input type='button' value='DB & Table Source Down' onclick=\"DB_table_create_source('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Database and table creation source and data processing program source creation and download of ".$tab_hnm."' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Table Source Down' onclick=\"Table_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Create and download table creation source and data processing program source of ".$tab_hnm."' >&nbsp;&nbsp; ";
	} else if( $mode == "Program_click") {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_backX('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of ".$tab_hnm."' >&nbsp;&nbsp; ";
	} else { */

		$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
		$last_page = $first_page+($page_num-1);
		if( $last_page > $total_page) $last_page = $total_page;
		$prev = $first_page-1;
		if( $page > $page_num)
			echo"<a href='#' title='page:$page, prev:$prev, data:$data' onclick=\"page_func('".$prev."','".$data."')\" style='font-size:18px;'>[Prev]</a>";
		for( $i = $first_page; $i <= $last_page; $i++){
			if($page == $i) echo" <b>".$i."</b> ";
			else
				echo"<a href='#' title='page:$page, i:$i, data:$data' onclick=\"page_func('".$i."','".$data."')\" style='font-size:18px;'>[".$i."]</a>";
		}
		$next = $last_page+1;
		if($next <= $total_page)
			echo"<a href='#' title='page:$page, next:$next, data:$data' onclick=\"page_func('".$next."','".$data."')\" style='font-size:18px;'>[Next]</a>";
	//}
?>
	</td>
  </tr>
</table>
</BODY>
</HTML>
