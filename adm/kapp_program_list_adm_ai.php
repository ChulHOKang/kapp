<?php
	include_once('../tkher_start_necessary.php');
	/*
	kapp_program_list_adm_ai.php
	*/
	$H_ID	= get_session("ss_mb_id");
	if( !$H_ID || $H_ID=='' ) {
			m_(" login please - admin page.");exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level'])) $H_LEV = $member['mb_level'];
	else $H_LEV = 0;
	if( !$H_ID || $H_LEV < 8 ) {
			m_("admin page.  lev= $H_LEV");	exit;
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
	let timer;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			switch(e.target.innerText){
				case 'Project' : title_func('group_name'); break;
				case 'User'    : title_func('userid'); break;
				case 'Program' : title_func('pg_name'); break;
				case 'Table'   : title_func('tab_hnm'); break;
				case 'Date'    : title_func('upday'); break;
				default        : title_func(''); break;
			}
		}, 250);
	  
	});
	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer);
		switch(e.target.innerText){
				case 'Project' : title_wfunc('group_name'); break;
				case 'User'    : title_wfunc('userid'); break;
				case 'Program' : title_wfunc('pg_name'); break;
				case 'Table'   : title_wfunc('tab_hnm'); break;
				case 'Date'    : title_wfunc('upday'); break;
				default        : title_wfunc(''); break;
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
	function title_wfunc(fld_code){       
		document.project_search.page.value = 1;
		document.project_search.fld_code.value= fld_code;
		document.project_search.fld_code_asc.value= 'desc';
		document.project_search.mode.value='title_wfunc';
		document.project_search.target='_self';
		document.project_search.action='kapp_program_list_adm_ai.php';
		document.project_search.submit();                         
	} 
	function title_func(fld_code){       
		document.project_search.page.value = 1;                
		document.project_search.fld_code.value= fld_code;           
		document.project_search.fld_code_asc.value= 'asc';
		document.project_search.mode.value='title_func';           
		document.project_search.target='_self';
		document.project_search.action='kapp_program_list_adm_ai.php';
		document.project_search.submit();                         
	} 
	function Project_change_func(cd){
		document.project_search.page.value = 1;                
		index = document.project_search.group_code.selectedIndex;
		nm = document.project_search.group_code.options[index].text;
		document.project_search.group_name.value=nm;
		document.project_search.mode.value		='Project_Search';
		document.project_search.action ="kapp_program_list_adm_ai.php";
		document.project_search.target='_self';
		document.project_search.submit();
		return;
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.project_search.mode.value		="program_list_ai";
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
		document.project_search.action		="kapp_program_list_adm_ai.php";
		document.project_search.target='_self';
		document.project_search.submit();
	}
	function Change_line_cnt( $line){
		document.project_search.page.value = 1;
		document.project_search.mode.value		='';
		document.project_search.line_cnt.value = $line;
		document.project_search.action='kapp_program_list_adm_ai.php';
		document.project_search.submit();
	}
	function Search_func(){
		document.project_search.page.value = 1;
		document.project_search.mode.value		='Program_Search';
		document.project_search.action='kapp_program_list_adm_ai.php';
		document.project_search.submit();
	}

</script>
<BODY>
<center>
<?php
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
	if( isset($_POST['group_code']) && $_POST['group_code']!='' ) {
		$group_code = $_POST['group_code'];   
		$wsel = " group_code = '$group_code' ";
	} else {
		$group_code= '';
		$wsel = '';
	}
	if( $mode == 'Program_Search' ) {
		$page = 1;
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if( $wsel !='') $ls = $ls . " where pg_name $sel '%$data%' and " . $wsel;
			else $ls = $ls . " where $param like '%$data%' ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if( $wsel!='') $ls = $ls . " where pg_name $sel '$data' and " . $wsel;
			else $ls = $ls . " where pg_name $sel '$data' ";
		}
	} else if( $mode == "Project_Search" ) {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $wsel !='' ) $ls = $ls . " where " . $wsel;
	} else if( isset($data) && $data != '' ) {
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if( $wsel!='') $ls = " where pg_name $sel '%$data%' and " . $wsel;
			else $ls = $ls . " where pg_name $sel '%$data%' ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if( $wsel!='') $ls = $ls . " where pg_name $sel '$data' and " . $wsel;
			else $ls = $ls . " where pg_name $sel '$data' ";
		}
	} else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $wsel !='' ) $ls = $ls . " where " . $wsel;
   }
	if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
	else $OrderBy	= " ORDER BY upday desc, pg_name asc ";
	$ls = $ls . $OrderBy;
	$resultT= sql_query( $ls ) or die ("kapp_program_list_adm_ai.php Error sql:" . $ls);
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
		$no = $total - ($page - 1) * $line_cnt;
	}
	$cur='B';
	include_once "../menu_run.php";
	if( isset($_POST['tab_enm']) ) $tab_enm	= $_POST['tab_enm'];
	else $tab_enm = '';
	if( isset($_POST['tab_hnm']) ) $tab_hnm = $_POST['tab_hnm'];
	else $tab_hnm = '';
	if( isset($_POST['group_name']) ) $group_name = $_POST['group_name'];
	else $group_name = '';
?>
<h2 title='pg:program_list3A'>Program List (id:<?=$H_ID?>) - total:<?=$total?></h2>
<FORM name="project_search" method="post" action="kapp_program_list_adm_ai.php" enctype="multipart/form-data" >
	<input type="hidden" name="seqno" value='<?=$_POST['seqno']?>' >
	<input type="hidden" name="group_name" >
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

<SELECT id='group_code' name='group_code' onchange="Project_change_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black'>
<?php
			echo "<option value=''>Select Project</option>";
			$result = sql_query( "SELECT * from {$tkher['table10_group_table']} order by group_name " );
			while($rs = sql_fetch_array($result)) {
				$chk='';
				if( $rs['group_code'] == $group_code ) $chk = ' selected ';
?>
				<option value='<?=$rs['group_code']?>' <?php echo $chk; ?> ><?=$rs['group_name']?></option>
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
	<input type="button" id="Search" name="Search" value='Search' onclick='Search_func()';>
<span>View Line: 
	<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
		<option value='10'  <?php if( $line_cnt=='10')  echo " selected" ?> >10</option>
		<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
		<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
		<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
	</select>&nbsp;&nbsp;&nbsp;&nbsp; 
</span>
</FORM>
<table class='floating-thead' style="width:1900px; table-layout:;">
<thead id='tit_et' width='100%'>
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
	<th>Relationship</th>
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
	<td style='width:9%;'><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" title='program run'><?=$rs['pg_name']?></a></td>
	<td style='width:9%;'><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" ><?=$rs['tab_hnm']?></a></td>
	<td><?=$rs['upday']?></td>
	<td><textarea id='item_array' name='item_array' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$rs['item_array']?></textarea></td>
	<td><textarea id='if_type' name='if_type' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$rs['if_type']?></textarea></td>
	<td><textarea id='if_data' name='if_data' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$if_data?></textarea></td>
	<td><textarea id='formula_d' name='formula_d' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$formula_?></textarea></td>
	<td><textarea id='pop_data' name='pop_data' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$poptable_?>:<?=$pop_data?></textarea></td>
	<td><textarea id='pop_mvfld' name='pop_mvfld' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?php echo $pop_fld;?>:<?php echo $pop_mvfld;?></textarea></td>
	<td><textarea id='rel_mvfld' name='rel_mvfld' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$relation_db?>:<?=$rel_mvfld?></textarea></td>
	<td><textarea id='column_all' name='column_all' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$column_all?></textarea></td>
	<td width='8px'><?=$rs['item_cnt']?></td>
	<td><textarea id='memo' name='memo' style="border-style:;background-color:black;color:yellow;height:60px;width:10%px;" readonly><?=$rs['memo']?></textarea></td>
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
			if($page == $i) echo" &nbsp;<b>".$i."</b> ";
			else
				echo"<a href='#' title='page:$page, i:$i, data:$data' onclick=\"page_func('".$i."','".$data."')\" style='font-size:21px;'>&nbsp;[".$i."]</a>";
		}
		$next = $last_page+1;
		if($next <= $total_page)
			echo"<a href='#' title='page:$page, next:$next, data:$data' onclick=\"page_func('".$next."','".$data."')\" style='font-size:18px;'>[Next]</a>";
	}
?>
</BODY>
</HTML>
