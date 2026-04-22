<?php
	include_once('./tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id"); $ip = $_SERVER['REMOTE_ADDR'];
	if( !$H_ID ) {
		m_("login page.");
		echo "<script>top.location.reload();</script>";	exit;
	} else{
		if( isset($member['mb_level'])) $H_LEV = $member['mb_level'];
		else $H_LEV = 1;
	}
	/*
	kapp_program_list_ai.php
	*/
	$formula_		= "";
	$poptable_		= "";
	$column_all		= "";
	$pop_fld			= "";
	$pop_mvfld		= "";
	$relation_db	= "";
	$rel_mvfld		= "";
	$rel_t		= "";
	$gita				= "";
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;
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
<!-- 
textarea {
	  width: 200px;
	  height: 120px;
	  padding: 0px;
	  border: 2px solid #ccc;
	  border-radius: 0px;
	  background-color: #000000;
	  font-family: Arial, sans-serif;
	  font-size: 12px;
	  color: yellow;
	  /*resize: vertical;  Allows vertical resizing only */
	}
	textarea:focus {
	  border-color: #007bff; /* Changes border color on focus */
	  outline: none; /* Removes default outline on focus */
	}
	table { border-collapse: collapse; }
	th { background: #cdefff; height: 27px; }
	th, td { border: 1px solid silver; padding:0px; }

	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
		justify-content: space-between;		/* flex-start, flex-end, center, space-between, space-around */
		align-content: center;				/* flex-start, flex-end, center, space-between, space-around 줄넘김 처리시 사용. */
		align-items: center;							/* flex-start, flex-end, center, baseline, stretch */
		height:25px;

	}
	.item {
		background-color: gold;
		boarder: 1px solid gray;
	}
-->
</style>
<script src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/kapp_program.js"></script>
<script>
$(function () {
	let timer;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			switch(e.target.innerText){
				case 'Project' : title_func('group_name', 'kapp_program_list_ai.php'); break;
				case 'User'    : title_func('userid', 'kapp_program_list_ai.php'); break;
				case 'Program' : title_func('pg_name', 'kapp_program_list_ai.php'); break;
				case 'Table'   : title_func('tab_hnm', 'kapp_program_list_ai.php'); break;
				case 'Date'    : title_func('upday', 'kapp_program_list_ai.php'); break;
				default        : title_func('', 'kapp_program_list_ai.php'); break;
			}
		}, 250);
	});
	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer);
		switch(e.target.innerText){
				case 'Project' : title_wfunc('group_name', 'kapp_program_list_ai.php'); break;
				case 'User'    : title_wfunc('userid', 'kapp_program_list_ai.php'); break;
				case 'Program' : title_wfunc('pg_name', 'kapp_program_list_ai.php'); break;
				case 'Table'   : title_wfunc('tab_hnm', 'kapp_program_list_ai.php'); break;
				case 'Date'    : title_wfunc('upday', 'kapp_program_list_ai.php'); break;
				default        : title_wfunc('', 'kapp_program_list_ai.php'); break;
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
<script type="text/javascript" >
	/*function title_wfunc(fld_code){       
		document.kapp_program_list_Form.page.value = 1;
		document.kapp_program_list_Form.fld_code.value= fld_code;
		document.kapp_program_list_Form.fld_code_asc.value= 'desc';
		document.kapp_program_list_Form.mode.value='title_wfunc';
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.action='kapp_program_list_ai.php';
		document.kapp_program_list_Form.submit();                         
	} 
	function title_func(fld_code){       
		document.kapp_program_list_Form.page.value = 1;                
		document.kapp_program_list_Form.fld_code.value= fld_code;           
		document.kapp_program_list_Form.fld_code_asc.value= 'asc';
		document.kapp_program_list_Form.mode.value='title_func';           
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.action='kapp_program_list_ai.php';
		document.kapp_program_list_Form.submit();                         
	} 
	function group_code_change_func(cd){
		document.kapp_program_list_Form.page.value = 1;                
		index = document.kapp_program_list_Form.group_code.selectedIndex;
		nm = document.kapp_program_list_Form.group_code.options[index].text;
		document.kapp_program_list_Form.group_name.value=nm;
		vv = document.kapp_program_list_Form.group_code.options[index].value;
		document.kapp_program_list_Form.action ="kapp_program_list_ai.php";
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.submit();
		return;
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.kapp_program_list_Form.mode.value="program_list_ai";
		document.kapp_program_list_Form.seqno.value=seqno;
		document.kapp_program_list_Form.pg_name.value=pg_name;
		document.kapp_program_list_Form.pg_code.value=pg_code;
		document.kapp_program_list_Form.action= "./kapp_program_data_list.php";
		document.kapp_program_list_Form.target="_blank";
		document.kapp_program_list_Form.submit();
	}
	function kapp_line_cnt_submit(){
		document.kapp_program_list_Form.page.value = 1;
		document.kapp_program_list_Form.mode.value		='';
		document.kapp_program_list_Form.action='kapp_program_list_ai.php';
		document.kapp_program_list_Form.target="_self";
		document.kapp_program_list_Form.submit();
	}
	function Search_func(){
		document.kapp_program_list_Form.page.value= 1;
		document.kapp_program_list_Form.mode.value='Program_Search';
		document.kapp_program_list_Form.action='kapp_program_list_ai.php';
		document.kapp_program_list_Form.submit();
	}
	function page_move(thisform, $page, linkurl){
		thisform.page.value = $page;
		thisform.action= linkurl;
		thisform.submit();
	}*/
</script>

<body style='background-color:#fff;color:#000;' >
<center>
<?php
	include "./table_paging.php";
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10;
	if( isset( $_POST['fld_code']) && $_POST['fld_code']!='' ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	if( isset( $_POST['fld_code_asc']) ) $fld_code_asc= $_POST['fld_code_asc'];
	else $fld_code_asc = '';
	if( isset($_POST['page']) && $_POST['page'] !='' ) $page = $_POST['page'];
	else $page=1;
	if( isset($_POST['data']) ) $data = $_POST['data'];
	else $data = '';
	if( isset($_POST['param']) ) $param	= $_POST['param'];
	else $param = '';
	if( isset($_POST['sel']) )   $sel	= $_POST['sel'];
	else $sel = '';
	if( isset($_POST['seqno']) ) $seqno	= $_POST['seqno'];
	else $seqno = '';
	if( isset($_POST['pg_code']) ) $pg_code	= $_POST['pg_code'];
	else $pg_code = '';
	if( isset($_POST['pg_name']) ) $pg_name = $_POST['pg_name'];
	else $pg_name = '';

	if( isset($_POST['kproject']) && $_POST['kproject']!='' ) $kproject = $_POST['kproject'];
	else $kproject = "";
	if( isset($_POST['project_name']) ) $project_name = $_POST['project_name'];
	else $project_name = '';
	if( isset($_POST['project_code']) && $_POST['project_code']!='' ) {
		$project_code = $_POST['project_code'];   
		$wsel = " and group_code = '$project_code' ";
	} else {
		$project_code= '';
		$wsel = '';
	}
	if( $mode == 'Program_Search' ) {
		$page = 1;
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param like '%$data%' and userid='$H_ID' " . $wsel;
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param $sel '$data' and userid='$H_ID' " . $wsel;
		}
	} else if( $mode == "kapp_program_list_Form" ) {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid='$H_ID' " . $wsel;
	} else if( isset($data) && $data != '' ) {
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where pg_name like '%$data%' and userid='$H_ID' " . $wsel;
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where pg_name $sel '$data' and userid='$H_ID' " . $wsel;
		}
	} else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid='$H_ID' " . $wsel;
   }
	if( $fld_code!=='' ) $OrderBy = " order by $fld_code $fld_code_asc ";
	else $OrderBy	= " ORDER BY upday desc, pg_name asc ";
	$ls = $ls . $OrderBy;
	$resultT	= sql_query( $ls );
	$total_count = sql_num_rows( $resultT );
	$total_page = intval(($total_count-1) / $line_cnt)+1;
	if( $page == 1 ) {
		$first = 0;
		$no = $total_count;
	} else {
		$first = ($page-1)*$line_cnt;
		$no = $total_count - ($page - 1) * $line_cnt;
	}
	$last = $line_cnt;
	if( $total_count < $last) $last = $total_count;
	$limit = " limit $first, $last ";
	$cur='B';
	include_once "./menu_run.php";
	if( isset($_POST['tab_enm']) ) $tab_enm	= $_POST['tab_enm'];
	else $tab_enm = '';
	if( isset($_POST['tab_hnm']) ) $tab_hnm = $_POST['tab_hnm'];
	else $tab_hnm = '';
?>
<FORM name="kapp_program_list_Form" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="seqno" value='<?=$_POST['seqno']?>' >
	<input type="hidden" name="project_code" value="<?=$project_code?>" >
	<input type="hidden" name="project_name" value="<?=$project_name?>" >
	<input type='hidden' name='mode'    value='<?=$mode?>'>
	<input type='hidden' name='page'    value="<?=$page?>">
	<input type="hidden" name="pg_hnmS" value="<?=$pg_code?>:<?=$pg_name?>">
	<input type="hidden" name='pg_name' value="<?=$pg_name?>">
	<input type="hidden" name="pg_code" value="<?=$pg_code?>" >
	<input type="hidden" name="tab_hnmS" value="<?=$tab_enm?>:<?=$tab_hnm?>">
	<input type='hidden' name='tab_enm' value="<?=$tab_enm?>">
	<input type='hidden' name='tab_hnm' value="<?=$tab_hnm?>">
	<input type="hidden" name='fld_code' value='<?=$fld_code?>' />
	<input type="hidden" name='fld_code_asc' value='<?=$fld_code_asc?>' />

<h2 title='pg:program_list3A'>Program List (id:<?=$H_ID?>)</h2>
	<SELECT id='kproject' name='kproject' onchange="kproject_func(this.value, 'kapp_program_list_ai.php')" style='height:25px;background-color:#FFDF6E;border:1 solid black'>
	<option value=''>Select Project</option>
<?php
			if( $kproject !='') echo "<option value='$kproject' selected >$project_name</option>";
			$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " );
			while($rs = sql_fetch_array($result)) {
				//$chk='';
				//if( $rs['group_code'] == $group_code ) $chk = ' selected ';
?>
				<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' ><?=$rs['group_name']?></option>
<?php
			}
?>
	</select>
	<select name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
		<option value="pg_name">Program</option>
	</select>
	<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
		<option value="=" <?php if( $sel=='=') echo " selected ";?> >=</option>
		<option value="like" <?php if( $sel=='like') echo " selected ";?> >Like</option>
	</select>
	<input type="text" name="data" maxlength="30" size="15" value='<?=$data?>'>
	<input type="button" id="Search" name="Search" value='Search' onclick="PGsearch_func('kapp_program_list_ai.php')";>
View Line:<SELECT id='line_cnt' name='line_cnt' onChange="kapp_line_cnt_submit('kapp_program_list_ai.php')" style='height:20;'>
<?php echo "<option value='$line_cnt' selected >$line_cnt</option>"; ?>
								<option value='5'>5</option>
								<option value='10'>10</option>
								<option value='15'>15</option>
								<option value='30'>30</option>
								<option value='50'>50</option>
								<option value='100'>100</option>
</select>
 - total:<?=$total_count?> , page:<?=$page?>

<table class='floating-thead' style="width:1900px; table-layout:;">
<thead id='tit_et' width="100%">
	<tr>
	<th>NO</th>
<?php
 echo " <th title='User Sort click or doubleclick' >User</th> ";
 echo " <th title='project Sort click or doubleclick' >Project</th> ";
 echo " <th title='Program Sort click or doubleclick' >Program</th> ";
 echo " <th title='Table Sort click or doubleclick' >Table</th> ";
 echo " <th title='date Sort click or doubleclick' >Date</th> ";
?>
	<th>Column array</th>
	<th>column type</th>
	<th>Column Attributes</th>
	<th>formula</th>
	<th>Pop-up table</th>
	<th>Pop-up column</th>
	<th>Relation data</th>
	<th>Relation type</th>
	<th>Column</th>
	<th>Cnt</th>
	<th>Memo</th>
	</tr>
</thead>
<tbody width="100%">
 <?php
	$line=0;
	$i=1;
	$ls = $ls . " $limit ";
	$resultT	= sql_query( $ls );
	while ( $rs = sql_fetch_array( $resultT ) ) {
		$line=$line_cnt*$page + $i - $line_cnt;
		$bgcolor = "#eeeeee";
		$if_data = $rs['if_data'];
		$pop_data = $rs['pop_data'];
		$item_all= item_array_func( $rs['item_array'], $rs['if_type'], $rs['if_data'], $rs['pop_data'], $rs['relation_data'], $rs['relation_type'] );
		if( $pop_fld && $pop_mvfld )	$attr = $pop_fld . "<br>" .$pop_mvfld . "<br>" . $gita;
		else if( $pop_fld && !$pop_mvfld )	$attr = $pop_fld . "<br>" . $gita;
		else if( !$pop_fld && $pop_mvfld )	$attr = $pop_mvfld . "<br>" . $gita;
		else if( !$pop_fld && !$pop_mvfld )	$attr = $gita;
		else $attr="";
  ?>
	<input type="hidden" name="pg_codeX[<?=$i?>]" value="<?=$rs['pg_code']?>">
<TR bgcolor='<?=$bgcolor?>' >
	<td style='width:2%;'><?=$line?></td>
	<td style='width:2%;'><?=$rs['userid']?></td>
	<td style='width:2%;' title="<?=$rs['group_code']?>"><?=$rs['group_name']?></td>
	<td style='width:15%;'><img src="<?=KAPP_URL_T_?>/icon/default.gif"><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" title='program run'><?=$rs['pg_name']?></a></td>
	<td style='width:15%;'><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" ><?=$rs['tab_hnm']?></a></td>
	<td><?=$rs['upday']?></td>

	<td><textarea id='item_array' name='item_array' readonly><?=$rs['item_array']?></textarea></td>
	<td><textarea id='if_type' name='if_type' readonly><?=$rs['if_type']?></textarea></td>
	<td><textarea id='if_data' name='if_data' readonly><?=$if_data?></textarea></td>
	<td><textarea id='formula_d' name='formula_d' readonly><?=$formula_?></textarea></td>
	<td><textarea id='pop_data' name='pop_data' readonly><?=$poptable_?>:<?=$pop_data?></textarea></td>
	<td><textarea id='pop_mvfld' name='pop_mvfld' readonly><?php echo $pop_fld;?>:<?php echo $pop_mvfld;?></textarea></td>
	<td><textarea id='rel_mvfld' name='rel_mvfld' readonly><?=$relation_db?>:<?=$rel_mvfld?></textarea></td>
	<td><textarea id='rel_type' name='rel_type' readonly><?=$rel_t?></textarea></td>
	<td><textarea id='column_all' name='column_all' readonly><?=$column_all?></textarea></td>
	<td width='8px'><?=$rs['item_cnt']?></td>
	<td><textarea id='memo' name='memo' readonly><?=$rs['memo']?></textarea></td>
</TR>
<?php
		$i++;
    }
?>
</form>
</tbody>
</table>
<?php
	if( $mode=='Search' ) {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_back('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Search List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of ".$tab_hnm."' >&nbsp;&nbsp; ";
		echo "<input type='button' value='DB & Table Source Down' onclick=\"DB_table_create_source('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Database and table creation source and data processing program source creation and download of ".$tab_hnm."' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Table Source Down' onclick=\"Table_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Create and download table creation source and data processing program source of ".$tab_hnm."' >&nbsp;&nbsp; ";
	} else if( $mode == "Program_click") {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_backX('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of ".$tab_hnm."' >&nbsp;&nbsp; ";
	}
?>
<?php
	paging("kapp_program_list_ai.php",$total_count,$page,$line_cnt, "document.kapp_program_list_Form"); 
?> 
</FORM>
</BODY>
</HTML>
