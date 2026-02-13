<?php
include_once('./tkher_start_necessary.php');
/*
	kapp_program_list_all.php
*/

	$H_ID	= get_session("ss_mb_id");
	$ip = $_SERVER['REMOTE_ADDR'];
	if( $H_ID!=''){
		$H_LEV=$member['mb_level'];
	} else {
		$H_LEV=1;
	}
	$formula_		= "";
	$poptable_		= "";
	$column_all		= ""; //my_func 
	$pop_fld= "";
	$pop_mvfld		= "";
	$relation_db	= "";
	$rel_mvfld		= "";
	$gita= "";	// 1,3,5,7,9
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
		}, 250); // 약 300ms 대기 후 실행
	  
	});

	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer); // 마지막 클릭 타이머를 제거
		//alert('더블 클릭되었습니다!');
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
		document.table_list.page.value = 1;
		document.table_list.fld_code.value= fld_code;
		document.table_list.fld_code_asc.value= 'desc';
		document.table_list.mode.value='title_wfunc';
		document.table_list.target='_self';
		document.table_list.action='kapp_program_list_all.php';
		document.table_list.submit();                         
	} 
	function title_func(fld_code){       
		document.table_list.page.value = 1;                
		document.table_list.fld_code.value= fld_code;           
		document.table_list.fld_code_asc.value= 'asc';
		document.table_list.mode.value='title_func';           
		document.table_list.target='_self';
		document.table_list.action='kapp_program_list_all.php';
		document.table_list.submit();                         
	} 
	function group_code_change_func(cd){
		index=document.table_list.group_code.selectedIndex;
		nm = document.table_list.group_code.options[index].text;
		document.table_list.mode.value='Search_Project';
		document.table_list.group_name.value=nm;
		document.table_list.action		="kapp_program_list_all.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.table_list.mode.value		="";
		document.table_list.seqno.value		=seqno;
		document.table_list.pg_name.value	=pg_name;
		document.table_list.pg_code.value	=pg_code;
		document.table_list.action				="tkher_program_data_list.php";
		document.table_list.target				="_blank";
		document.table_list.submit();
	}
	function page_func( page, data ){
		document.table_list.mode.value		='';
		document.table_list.data.value		=data;
		document.table_list.page.value		=page;
		document.table_list.action		="kapp_program_list_all.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	function Change_line_cnt( $line){
		document.table_list.page.value = 1;
		document.table_list.line_cnt.value = $line;
		document.table_list.action='kapp_program_list_all.php';
		document.table_list.submit();
	}
</script>

<body bgcolor="#000000" text="#FFFFFF" topmargin="0" leftmargin="0" >
<center>
<?php
   $param	= '';   
   $sel	    = '';   
   $seqno	= '';   
   $pg_code	= '';   
   $pg_name = '';   

	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10; 

	if( isset($_POST["mode"]) ) $mode = $_POST["mode"];   
	else $mode= '';
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

	if( isset($_POST['data']) ) $data = $_POST['data'];
	else $data = '';
	if( isset($_POST['page']) && $_POST['page'] !='' ) $page = $_POST['page'];
	else $page=1;

	if( isset($_POST['param']) ) $param	= $_POST["param"];   
	if( isset($_POST['sel']) )   $sel	= $_POST["sel"];   
	if( isset($_POST['seqno']) ) $seqno	= $_POST["seqno"];   
	if( isset($_POST['pg_code']) ) $pg_code	= $_POST["pg_code"];   
	if( isset($_POST['pg_name']) ) $pg_name= $_POST["pg_name"];   

	if( $mode == 'Program_Search' ) {
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if( $wsel!='') $ls = $ls . " where $param like '%$data%' " . $wsel;
			else $ls = $ls . " where $param like '%$data%' ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if( $wsel!='') $ls = $ls . " where $param $sel '$data' " . $wsel;
			else $ls = $ls . " where $param $sel '$data' ";
		}
	} else if( $data != '' ) { // program 검색.
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if( $wsel!='') $ls = $ls . " where pg_name like '%$data%' ". $wsel;
			else $ls = $ls . " where pg_name like '%$data%' ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if( $wsel!='') $ls = $ls . " where pg_name $sel '$data' " . $wsel;
			else $ls = $ls . " where pg_name $sel '$data' ";
		}
	} else if( $mode == 'Search_Project' && $group_code!='') {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $wsel!='' ) $ls = $ls . " where group_code= '$group_code' ";
	} else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $wsel!='' ) $ls = $ls . " where group_code= '$group_code' ";
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
	$cur='B';
	include_once "./menu_run.php"; 

	if( isset($_POST['tab_enm']) ) $tab_enm = $_POST['tab_enm'];
	if( isset($_POST['tab_hnm']) ) $tab_enm = $_POST['tab_hnm'];
?>
<h2 title='pg:kapp_program_list_all'>Program List (total:<?=$total?>)</h2>
<FORM name="tkher_search" target="_self" method="post" action="kapp_program_list_all.php"  >
			<input type='hidden' name='mode'    value='Program_Search'>
			<input type='hidden' name='modeS'   value='Program_Search'>
			<input type='hidden' name='page'    value="<?=$page?>">
			<input type="hidden" name="pg_hnmS" value="<?=$pg_code?>:<?=$pg_name?>"> 
			<input type="hidden" name='pg_name' value="<?=$pg_name?>"> 
			<input type="hidden" name="pg_code" value="<?=$pg_code?>" > 
			<input type="hidden" name="tab_hnmS" value="<?=$tab_enm?>:<?=$tab_hnm?>"> 
			<input type='hidden' name='tab_enm' value="<?=$tab_enm?>">
			<input type='hidden' name='tab_hnm' value="<?=$tab_hnm?>">
			<SELECT name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
				<option value="pg_name">Program</option>
			</SELECT> 
			<SELECT name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="=" <?php if($sel == '=') echo " selected ";?>>=</option>
				<option value="like" <?php if($sel == 'like') echo " selected ";?>>Like</option>
			</SELECT>
			<input type="text" name="data" maxlength="30" size="15" value='<?=$data?>'>
			<input type="submit" value="Search">
		</form>

<FORM name="table_list" method='POST' enctype="multipart/form-data" >
	<input type="hidden" name="mode" > 
	<input type="hidden" name="page" > 
	<input type="hidden" name="data" > 
	<input type="hidden" name="seqno" > 
	<input type="hidden" name="pg_name" > 
	<input type="hidden" name="pg_code" > 
	<input type="hidden" name='fld_code'     value='<?=$fld_code?>' />
	<input type="hidden" name='fld_code_asc' value='<?=$fld_code_asc?>' />
	<input type='hidden' name='tab_enm' value='<?=$tab_enm?>'>
	<input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>'>
	<input type='hidden' name='group_name' >

		<SELECT id='group_code' name='group_code' onchange="group_code_change_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered.' "; ?> >
							<option value=''>Project</option>
<?php
					$result = sql_query( "SELECT * from {$tkher['table10_group_table']} order by group_name " );
					while($rs = sql_fetch_array($result)) {
						$chk = '';
						if( $rs['group_code']==$group_code) $chk =' selected ';
?>
							<option title='user:<?=$rs['userid']?>' value='<?=$rs['group_code']?>' <?php echo $chk; ?>><?=$rs['group_name']?></option>
<?php
					}
?>
		</SELECT>
<span>
View Line: 
	<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
		<option value='10'  <?php if( $line_cnt=='10')  echo " selected" ?> >10</option>
		<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
		<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
		<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
	</select>&nbsp;&nbsp;&nbsp;&nbsp; 
</span>
<table class='floating-thead' width="100%" style='background-color:black;color:white;'>

<thead id='tit_et' width="100%">
	<tr>
	<th>NO</th>
<?php
	echo " <th title='project Sort click or doubleclick' >Project</th> ";
	echo " <th title='User Sort click or doubleclick' >User</th> ";
	echo " <th title='Program Sort click or doubleclick' >Program</th> ";
	echo " <th title='Table Sort click or doubleclick' >Table</th> ";
	echo " <th title='Date Sort click or doubleclick' >Date</th> ";
?>
	</tr>
</thead>

<tbody width="100%" style='background-color:black;color:white;'>
 <?php
	$line=0;
	$i=1;
	if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
	else $OrderBy	= " ORDER BY upday desc ";
	$ls = $ls . $OrderBy;
	$ls = $ls . " $limit ";
	$resultT	= sql_query( $ls );
	while ( $rs = sql_fetch_array( $resultT ) ) { 
		$mid=$rs['userid'];
		$group_name = $rs['group_name'];
		$group_code = $rs['group_code'];
		if( $page>1 ) $line=$line_cnt*$page + $i - $line_cnt;
		else $line=$i;
		$bgcolor = 'black'; //"#eeeeee";
		if( $H_ID == $mid) $bcolor ="style='background-color:black;color:yellow;'";//style='background-color:black;color:white;'
		else $bcolor ="style='background-color:black;color:gray;'";
		//$if_data = $rs['if_data'];
		//$pop_data = $rs['pop_data']; // item_array_func()에서 pop_data는 1.@로 분류, 2.$분류,3:로 분류를 3번 한다
		//$item_all= item_array_func( $rs['item_array'], $rs['if_type'], $rs['if_data'], $rs['pop_data'], $rs['relation_data'] );
		/*if( $pop_fld && $pop_mvfld )	$attr = $pop_fld . "<br>" .$pop_mvfld . "<br>" . $gita;
		else if( $pop_fld && !$pop_mvfld )	$attr = $pop_fld . "<br>" . $gita;
		else if( !$pop_fld && $pop_mvfld )	$attr = $pop_mvfld . "<br>" . $gita;
		else if( !$pop_fld && !$pop_mvfld )	$attr = $gita;
		else $attr="";*/
  ?> 
		<input type="hidden" name="pg_codeX[<?=$i?>]" value="<?=$rs['pg_code']?>">
	<TR bgcolor='<?=$bgcolor?>' width='900' >
		<td width='1%' <?=$bcolor?> ><?=$line?></td>
		<td width='5%' <?=$bcolor?> title=" project code:<?=$group_code?>"><?=$group_name?></td>
		<td width='3%' <?=$bcolor?> ><?=$rs['userid']?> </td>
		<td width='15%' style='background-color:000051;' ><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" title='program run' style='background-color:000051;color:#ffffff;'><?=$rs['pg_name']?> (<?=$rs['pg_code']?>) - Run</a></td> 

		<td width='15%' onclick="javascript:program_run_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>','<?=$rs['pg_code']?>' );" <?=$bcolor?> ><?=$rs['tab_hnm']?> (<?=$rs['tab_enm']?>)</td> 
		<td width='5%' <?=$bcolor?> ><?=$rs['upday']?></td>
	</TR>
 <?php
		$i++;
		//$count = $count - 1;
    }
 ?>
</tbody>
</table>

</form>
<table width="100%"   bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
		$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
		$last_page = $first_page+($page_num-1);
		if( $last_page > $total_page) $last_page = $total_page;
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
?>
	</td>
  </tr>
</table>
</BODY>
</HTML>