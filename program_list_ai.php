<?php
	include_once('./tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id"); $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level'])) $H_LEV = $member['mb_level'];
	else $H_LEV = 0;
	if( !$H_ID || $H_LEV < 8 ) {
			m_("admin page.  lev= $H_LEV");// echo("<meta http-equiv='refresh' content='0; URL=index.php'>");
			exit;
	}
	$formula_		= "";
	$poptable_		= "";
	$column_all		= "";
	$pop_fld			= "";
	$pop_mvfld		= "";
	$relation_db	= "";
	$rel_mvfld		= "";
	$gita				= "";

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;

	function item_array_func( $item , $iftype, $ifdata, $popdata, $relationdata) {
		global $formula_, $poptable_, $column_all, $pop_fld, $pop_mvfld, $rel_mvfld, $relation_db, $gita;
				$list	= explode("@", $item);
				$iftype = explode("|", $iftype);
				$ifdata = explode("|", $ifdata);
				$column_all		="";
				$formula_		="";
				$poptable_		="";
				$gita				="";
		for ( $i=0,$j=1; isset($list[$i]) && $list[$i] !== ""; $i++, $j++ ){
				if(isset($iftype[$j]) ) $typeX	= $iftype[$j];
				else $typeX = "";
				if(isset($ifdata[$j]) ) $dataX	= $ifdata[$j];
				else $dataX = "";
				$ddd		= $list[$i];
				$fld		= explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
				$column_all = $column_all . $fld[2] . "(" . $fld[3] . ") , ";
						if( !$typeX ) { // 0 or ''
						} else if( $typeX == "11" ) { // calc
							$formula = explode(":", $dataX);
							if( isset($formula[1]) ) $formula_ = $formula[1];
						} else if( $typeX == "13" ) { // 팝업창
							$poptable = explode(":", $dataX);
							if( isset($poptable[1]) ) $poptable_ = $poptable[1];
						} else {
							$gita = $gita . $fld[2] . "-" . $dataX . "<br>";
						}
		}
		$popdata = explode("@", $popdata); // pop_data, 첫번째 분류.
		$pop_fld ="";
		for ( $i=0,$j=1; isset($popdata[$i]) && $popdata[$i] !== ""; $i++, $j++ ){
			if( isset($popdata[$j]) ){
				$popfld = $popdata[$j];
				$popfld = explode(":", $popfld);
				if( isset($popfld[1]) ) $pop_fld = $pop_fld . $popfld[1] . ",";
				else  $pop_fld = $pop_fld . ",";
			} else {
				$pop_fld = $pop_fld . ",";
			}
		}
		$mpop = $popdata[0];
		$mpop = explode("$", $mpop); // pop_data, 두번째 분류.
		$pop_mvfld = "";
		for ( $i=0,$j=1; isset($mpop[$j]) && $mpop[$j] !== ""; $i++, $j++ ){
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
			if( isset($reldb[1]) ) $relation_db = $reldb[1];
			else  $relation_db = "";
			$rel_mvfld = "";
		for ( $i=0,$j=1; isset($relationdata[$j]) && $relationdata[$j] !== ""; $i++, $j++ ){
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
	  height: 150px;
	  padding: 0px;
	  border: 2px solid #ccc;
	  border-radius: 0px;
	  background-color: #000000;
	  font-family: Arial, sans-serif;
	  font-size: 12px;
	  color: #fff;
	  /*resize: vertical;  Allows vertical resizing only */
	}
	textarea:focus {
	  border-color: #007bff; /* Changes border color on focus */
	  outline: none; /* Removes default outline on focus */
	}
table { border-collapse: collapse; }
th { background: #cdefff; height: 27px; }
th, td { border: 1px solid silver; padding:0px; }
 -->
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
<script type="text/javascript" >
	function project_name_change_func(){
		seqno = document.project_search.seqno.value;
		group_code = document.project_search.group_codeX.value;
		group_name = document.project_search.group_name.value;
		project_name = document.project_search.project_name.value;
		project_code = document.project_search.project_codeX.value;
		msg = " Do you want to change the project name of program " + group_name + " to " + project_name + "?";
		if ( window.confirm( msg ) )
		{
			document.project_search.mode.value ="project_name_change";
			document.project_search.action ="program_list_ai.php";
			document.project_search.group_name.value = project_name;
			document.project_search.submit();
		} else return false;
	}
	function project_code_change_funcA(cd ){
		index = document.getElementById("project_code").selectedIndex;
		var arr = document.getElementById("project_code").options;
		document.project_search.project_codeX.value = arr[index].value;
		document.project_search.project_name.value = arr[index].text;
		Gindex = document.getElementById("group_code").selectedIndex;
		var Garr = document.getElementById("group_code").options;
		document.project_search.group_codeX.value = Garr[Gindex].value;
		document.project_search.group_name.value = Garr[Gindex].text;
		return;
	}
	function group_code_change_func(cd){
		index = document.project_search.group_code.selectedIndex;
		nm = document.project_search.group_code.options[index].text;
		document.project_search.group_name.value=nm;
		vv = document.project_search.group_code.options[index].value;
		document.project_search.group_codeX.value=vv;
		document.project_search.action ="program_list_ai.php";
		document.project_search.submit();
		return;
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.project_search.mode.value		="tab_list_pg70";
		document.project_search.seqno.value		=seqno;
		document.project_search.pg_name.value	=pg_name;
		document.project_search.pg_code.value	=pg_code;
		document.project_search.action				= "<?=KAPP_URL_T_?>/tkher_program_data_list.php";
		document.project_search.target				="_blank";
		document.project_search.submit();
	}
	function page_func( page, data ){
		document.project_search.mode.value		='';
		document.project_search.data.value		=data;
		document.project_search.page.value		=page;
		document.project_search.action		="program_list_ai.php";
		document.project_search.target='_self';
		document.project_search.submit();
	}
</script>

 <BODY>
 <center>
<?php
	$limite = 15;
	$page_num = 10;

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
   
   if( $mode=='project_name_change'){
		$project_code	= $_POST["project_codeX"];
		$project_name	= $_POST["project_name"];
		$query="update {$tkher['table10_pg_table']} set group_code='$project_code', group_name='$project_name' where seqno='$seqno' ";
		$g = sql_query( $query );
		if( !$g ) my_msg("Change Project Error");
		else  my_msg("Project name changed! ");
		$group_code = $project_code;
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where group_code='" . $project_code . "' and userid='$H_ID'";
		$ls = $ls . " ORDER BY upday desc, pg_name asc ";
   } else if( $mode == 'Search' ) {
			$aa = explode(':', $tab_hnmS);
			$tab_enm = $aa[0];
			$tab_hnm = $aa[1];
		if( !$tab_enm ) {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where fld_enm='seqno' and userid='$H_ID'";
			$ls = $ls . " ORDER BY tab_hnm asc, seqno asc ";
		} else {
			$ls = "SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where tab_enm='$tab_enm' and fld_enm='seqno' and userid='$H_ID'";
			$result = sql_query( $ls );
			$rs		= sql_fetch_array( $result );
			$group_code	= $rs['group_code'];
			$group_name	= $rs['group_name'];
			$sqltable   = $rs['sqltable'];
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where tab_enm='$tab_enm' and userid='$H_ID'";
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
			$ls = $ls . " where $param like '%$data%' and userid='$H_ID'";
			$ls = $ls . " ORDER BY upday desc, $param ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param $sel '$data' ";
			$ls = $ls . " ORDER BY upday desc, $param ";
		}
	} else if( $mode == "Project_Search" ) { // Project_Search
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where group_code='".$_POST['group_code']."' and userid='$H_ID'";
		$ls = $ls . " ORDER BY upday desc, pg_name asc ";
	} else if( isset($data) && $data !== "" ) {
		$sel   = $_POST['sel'];
		$param = $_POST['param'];
		if( !$param ) $param = 'pg_name';
		if( !$sel )   $sel   = 'like';
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where pg_name like '%$data%' and userid='$H_ID'";
		$ls = $ls . " ORDER BY upday desc, $param ";
		if($sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where pg_name like '%$data%' and userid='$H_ID'";
			$ls = $ls . " ORDER BY upday desc, $param ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where pg_name $sel '$data' and userid='$H_ID'";
			$ls = $ls . " ORDER BY upday desc, $param ";
		}
	} else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid='$H_ID' ";
		$ls = $ls . " ORDER BY upday desc, pg_name asc ";
   }
	$resultT	= sql_query( $ls );
	$total = sql_num_rows( $resultT );
	if(!$page) $page=1;
	$total_page = intval(($total-1) / $limite)+1;
	$first = ($page-1)*$limite;
	$last = $limite;
	if($total < $last) $last = $total;
	$limit = " limit $first, $last ";
	if ($page == "1"){
		$no = $total;
	} else {
		$no = $total - ($page - 1) * $limite;
	}
	$cur='B';
	include_once "./menu_run.php";

	if( isset($_POST['tab_enm']) ) $tab_enm	= $_POST['tab_enm'];
	else $tab_enm = '';
	if( isset($_POST['tab_hnm']) ) $tab_hnm = $_POST['tab_hnm'];
	else $tab_hnm = '';
	if( isset($_POST['group_name']) ) $group_name = $_POST['group_name'];
	else $group_name = '';
?>
<h2 title='pg:program_list3A'>Program List (id:<?=$H_ID?>) - total:<?=$total?></h2>
		<form name="project_search" method="post" action="program_list_ai.php" enctype="multipart/form-data" >
			<input type="hidden" name="seqno" value='<?=$_POST['seqno']?>' >
			<input type="hidden" name="group_name" >
			<input type='hidden' name='project_name' >
			<input type="hidden" name="group_codeX" >
			<input type='hidden' name='project_codeX' >
			<input type='hidden' name='mode'    value='Project_Search'>
			<input type='hidden' name='modeS'   value='Program_Search'>
			<input type='hidden' name='page'    value="<?=$page?>">
			<input type="hidden" name="pg_hnmS" value="<?=$pg_code?>:<?=$pg_name?>">
			<input type="hidden" name='pg_name' value="<?=$pg_name?>">
			<input type="hidden" name="pg_code" value="<?=$pg_code?>" >
			<input type="hidden" name="tab_hnmS" value="<?=$tab_enm?>:<?=$tab_hnm?>">
			<input type='hidden' name='tab_enm' value="<?=$tab_enm?>">
			<input type='hidden' name='tab_hnm' value="<?=$tab_hnm?>">
		<SELECT id='group_code' name='group_code' onchange="group_code_change_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black'>
<?php
 if( isset($group_name) && $group_name !== "" ){
?>
							<option value='<?=$group_code?>' selected ><?=$group_name?></option>
<?php
} else {
?>
							<option value=''>Select Project</option>
<?php
}

			$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " );
			while($rs = sql_fetch_array($result)) {
?>
							<option value='<?=$rs['group_code']?>'><?=$rs['group_name']?></option>
<?php
			}
?>
			</select>
			<select name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
				<option value="pg_name">Program</option>
			</select>
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="like">Like</option>
				<option value="=">=</option>
			</select>
			<input type="text" name="data" maxlength="30" size="15" value='<?=$data?>'>
			<input type="submit" value="Search">
		</form>
<?php
		if( $mode=='Project_Change' ) {
?>
			<SELECT id='project_code' name='project_code' onchange="project_code_change_funcA(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' title='Select the project' >
				<option value=''>select project</option>
<?php
			$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " );
			while($rs = sql_fetch_array($result)) {
?>
				<option value='<?=$rs['group_code']?>' <?php if($rs['group_name']==$group_name) echo " selected "; ?> title='<?php echo $rs['group_name'].":".$rs['group_code']; ?>'><?=$rs['group_name']?></option>
<?php
			}
?>
			</select>
<?php
			echo "<input type='button' value='Change Project' onclick=\"javascript:project_name_change_func();\" style='height:25px;background-color:red;color:yellow;border:1 solid black' 
			title='Change the project of the $pg_name' >( $pg_name:$pg_code, Change the project of the program )";
		}
?>
	<input type='hidden' name='group_nameX' >
	<input type='hidden' name='param' value='<?=$param?>'>
	<input type='hidden' name='sel' value='<?=$sel?>'>
	<input type='hidden' name='data' value='<?=$data?>'>
	<input type='hidden' name='sel1' value='<?=$sel1?>'>
	<input type='hidden' name='param2' value='<?=$param2?>'>
	<input type='hidden' name='sel2' value='<?=$sel2?>'>
	<input type='hidden' name='data2' value='<?=$data2?>'>
<table class='floating-thead' style="width:3000px; table-layout:;">
<thead>
	<tr>
	<th>NO</th>
	<th>userid</th>
	<th>Project</th>
	<th>Program</th>
	<th>Table</th>
	<th>Column array</th>
	<th>column type</th>
	<th>Column Attributes</th>
	<th>formula</th>
	<th>Pop-up table</th>
	<th>Pop-up column</th>
	<th>Relationship</th>
	<th>Column</th>
	<th>Cnt</th>
	<th>Memo</th>
	<th>Date</th>
	</tr>
</thead>
<tbody width="100%">
 <?php
	$line=0;
	$i=1;
	if($mode == "" || $mode == "Program_Search" || $mode=="Project_Search")	$ls = $ls . " $limit ";
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
	<TR bgcolor='<?=$bgcolor?>' >
	<td style='width:2%;'><?=$line?><br><input type='button' onclick="program_run_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>')"  value='DataList' style='height:22px;width:60px;background-color:cyan;color:black;border:1 solid black'  <?php echo "title=' Data List of ".$rs['pg_name']."' ";?>></td>
	<td style='width:2%;'><?=$rs['userid']?> </td>
	<td title="<?=$rs['group_code']?>"><?=$rs['group_name']?></td>
	<td style='width:2%;'><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" title='program run'><?=$rs['pg_name']?></a></td>
	<td style='width:2%;'><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" ><?=$rs['tab_hnm']?></a></td>
	<td><textarea id='item_array' name='item_array' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$rs['item_array']?></textarea></td>
	<td><textarea id='if_type' name='if_type' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$rs['if_type']?></textarea></td>
	<td><textarea id='if_data' name='if_data' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$if_data?></textarea></td>
	<td><textarea id='formula_d' name='formula_d' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$formula_?></textarea></td>
	<td><textarea id='pop_data' name='pop_data' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$poptable_?>:<?=$pop_data?></textarea></td>
	<td><textarea id='pop_mvfld' name='pop_mvfld' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?php echo $pop_fld;?>:<?php echo $pop_mvfld;?></textarea></td>
	<td><textarea id='rel_mvfld' name='rel_mvfld' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$relation_db?>:<?=$rel_mvfld?></textarea></td>
	<td><textarea id='column_all' name='column_all' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$column_all?></textarea></td>
	<td width='8px'><?=$rs['item_cnt']?></td>
	<td><textarea id='column_all' name='column_all' style="border-style:;background-color:black;color:yellow;height:60px;width:300px;" readonly><?=$rs['memo']?></textarea></td>
	<td><?=$rs['upday']?></td>
	</TR>
<?php
		$i++;
    }
?>
</form>
</tbody>
</table>
<table width="1500"   bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
	if( $mode=='Search' ) { // table click
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
