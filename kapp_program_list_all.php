<?php
include_once('./tkher_start_necessary.php');
/*
	kapp_program_list_all.php
*/

	$ss_mb_id	= get_session("ss_mb_id");
	$H_ID	= $ss_mb_id;	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$formula_		= "";
	$poptable_		= "";
	$column_all		= "";
	$pop_fld			= "";
	$pop_mvfld		= "";
	$relation_db	= "";
	$rel_mvfld		= "";
	$gita				= "";	// 1,3,5,7,9

	function item_array_func( $item , $iftype, $ifdata, $popdata, $relationdata) {
		global $formula_, $poptable_, $column_all, $pop_fld, $pop_mvfld, $rel_mvfld, $relation_db, $gita;
				$list	= explode("@", $item);
				$iftype = explode("|", $iftype);	
				$ifdata = explode("|", $ifdata);	
				$column_all		="";
				$formula_		="";
				$poptable_		="";
				$gita				="";
		for( $i=0,$j=1; isset($list[$i]) && $list[$i] !== ""; $i++, $j++ ){
				if( isset($iftype[$j]) ) {
					$typeX	= $iftype[$j];
				} else $typeX	= "";
				if( isset($ifdata[$j]) ) $dataX = $ifdata[$j];
				else $dataX = "";
				if( isset($list[$i]) && $list[$i] !=="" ) {
					$ddd		= $list[$i];
					$fld		= explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
					if( isset($fld[2]) && isset($fld[3]) ) $column_all = $column_all . $fld[2] . "(" . $fld[3] . ") , ";
				}

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
		// $fld_1:상품명|fld_3:제품명$fld_8:재고|fld_4:수량@fld_1:상품명@fld_2:규격@fld_3:원가@fld_4:판매가@fld_5:구분@fld_6:거래처@fld_8:재고@	
		// 3번 분류한다. 첫번째 @로, 두번째 $로, 세번째 |로
		$popdata = explode("@", $popdata); // pop_data, 첫번째 분류.
		$pop_fld ="";
		for ( $i=0,$j=1; isset($popdata[$i]) && $popdata[$i] !== ""; $i++, $j++ ){
			if( isset($popdata[$j]) ) {
				$popfld = $popdata[$j];
				$popfld = explode(":", $popfld);
				if( isset($popfld[1]) ) $pop_fld = $pop_fld . $popfld[1] . ",";
				else $pop_fld = $pop_fld . ",";
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
			else $relation_db = "";
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
table { border-collapse: collapse; }
th { background: #cdefff; height: 27px; }
th, td { border: 1px solid silver; padding:5px; }
</style>

<link rel='stylesheet' href='./include/css/kancss.css' type='text/css'><!-- 중요! -->
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
	function title_func(fld_code){       
		document.table_list.page.value = 1;                
		document.table_list.fld_code.value= fld_code;           
		document.table_list.mode.value='title_func';           
		document.table_list.action='kapp_program_list_all.php';
		document.table_list.submit();                         
	} 
	function group_code_change_func(cd){
		index=document.table_list.group_code.selectedIndex;
		nm = document.table_list.group_code.options[index].text;
		document.table_list.mode.value='Search_Project';
		document.table_list.group_nameX.value=nm;
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

<BODY> 
<center>
<?php
   $param	= '';   
   $sel	    = '';   
   $seqno	= '';   
   $pg_code	= '';   
   $pg_name = '';   

	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!=='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10; 

	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	if( isset($_POST["mode"]) ) $mode = $_POST["mode"];   
	else $mode= '';
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
			if($wsel!='') $ls = $ls . " where $param like '%$data%' " . $wsel;
			else $ls = $ls . " where $param like '%$data%' ";
			if( $mode=='title_func' ) $OrderBy = " order by $fld_code ";    
			else $OrderBy	= " ORDER BY upday desc, $param ";
			$ls = $ls . $OrderBy;
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if($wsel!='') $ls = $ls . " where $param $sel '$data' " . $wsel;
			else $ls = $ls . " where $param $sel '$data' ";
			if( $mode=='title_func' ) $OrderBy = " order by $fld_code ";    
			else $OrderBy	= " ORDER BY group_code, upday desc, $param ";
			$ls = $ls . $OrderBy;
		}
	} else if( $data !== "" ) { // program 검색.
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if($wsel!='') $ls = $ls . " where pg_name like '%$data%' ". $wsel;
			else $ls = $ls . " where pg_name like '%$data%' ";
			if( $mode=='title_func' ) $OrderBy = " order by $fld_code ";    
			else $OrderBy	= " ORDER BY upday desc, $param ";
			$ls = $ls . $OrderBy;
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			if($wsel!='') $ls = $ls . " where pg_name $sel '$data' " . $wsel;
			else $ls = $ls . " where pg_name $sel '$data' ";
			if( $mode=='title_func' ) $OrderBy = " order by $fld_code ";    
			else $OrderBy	= " ORDER BY upday desc, $param ";
			$ls = $ls . $OrderBy;
		}
	} else if( $mode == 'Search_Project' && $group_code!='') {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where group_code= '$group_code' ";
		if( $fld_code!='' ) $OrderBy = " order by $fld_code ";    
		else $OrderBy	= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;
	} else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $wsel ) $ls = $ls . " where group_code= '$group_code' ";
		if( $mode=='title_func' ) $OrderBy = " order by $fld_code ";    
		else $OrderBy	= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;
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
		<form name="tkher_search" target="_self" method="post" action="kapp_program_list_all.php"  >
			<input type='hidden' name='mode'    value='Program_Search'>
			<input type='hidden' name='modeS'   value='Program_Search'>
			<input type='hidden' name='page'    value="<?=$page?>">
			<input type="hidden" name="pg_hnmS" value="<?=$pg_code?>:<?=$pg_name?>"> 
			<input type="hidden" name='pg_name' value="<?=$pg_name?>"> 
			<input type="hidden" name="pg_code" value="<?=$pg_code?>" > 
			<input type="hidden" name="tab_hnmS" value="<?=$tab_enm?>:<?=$tab_hnm?>"> 
			<input type='hidden' name='tab_enm' value="<?=$tab_enm?>">
			<input type='hidden' name='tab_hnm' value="<?=$tab_hnm?>">
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

<FORM name="table_list" method='POST' enctype="multipart/form-data" >
		<input type="hidden" name="mode" > 
		<input type="hidden" name="page" > 
		<input type="hidden" name="data" > 
		<input type="hidden" name="seqno" > 
		<input type="hidden" name="pg_name" > 
		<input type="hidden" name="pg_code" > 
		<input type="hidden" name='fld_code' value='<?=$fld_code?>' />
<?php 
		//if( $mode=='Search' ) {
?>
			&nbsp;&nbsp;&nbsp;
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
<?php
		//}
?>
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
	<!-- <th>Project</th>
	<th>User</th>
	<th>Program</th>
	<th>Table</th> -->
<?php
 echo " <th title='project Sort click' onclick=title_func('group_name')>Project</th> ";
 echo " <th title='User Sort click' onclick=title_func('userid')>User</th> ";
 echo " <th title='Program Sort click' onclick=title_func('pg_name')>Program</th> ";
 echo " <th title='Table Sort click' onclick=title_func('tab_hnm')>Table</th> ";
?>
	<th>Date</th>
	</tr>
</thead>
<tbody width="100%">
 <?php
	$line=0;
	$i=1;
	//if( $mode == "" || $mode == "Program_Search")	
	$ls = $ls . " $limit "; // none table click 
	$resultT	= sql_query( $ls );
	while ( $rs = sql_fetch_array( $resultT ) ) { 
		$mid=$rs['userid'];
		$group_name = $rs['group_name'];
		$group_code = $rs['group_code'];
		
		if( $page>1 ) $line=$line_cnt*$page + $i - $line_cnt;
		else $line=$i;

		$bgcolor = "#eeeeee";
		if( $H_ID == $mid) $bcolor ="style='background-color:white;'";
		else $bcolor='';
		
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
		<td width='1%' <?=$bcolor?> ><?=$line?></td>
		<td width='5%' <?=$bcolor?> title=" project code:<?=$group_code?>"><?=$group_name?></td>
		<td width='3%' <?=$bcolor?> ><?=$rs['userid']?> </td>
		<td width='15%' <?=$bcolor?> ><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" title='program run' style='background-color:cyan;color:black;'><?=$rs['pg_name']?> (<?=$rs['pg_code']?>) - Run</a></td> 
		<td width='15%' <?=$bcolor?> ><a href="javascript:program_run_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>','<?=$rs['pg_code']?>' );" ><?=$rs['tab_hnm']?> (<?=$rs['tab_enm']?>)</a>
		</td> 
		<td width='5%' <?=$bcolor?> ><?=$rs['upday']?></td>
		</TR>
 <?php
		$i++;
		//$count = $count - 1;
    }
 ?>
</form>
</tbody>
</table>
<table width="100%"   bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
	/*if( $mode=='Search' ) { // table click
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_back('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Search List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of ".$tab_hnm."' >&nbsp;&nbsp; ";
		echo "<input type='button' value='DB & Table Source Down' onclick=\"DB_table_create_source('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Database and table creation source and data processing program source creation and download of ".$tab_hnm."' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Table Source Down' onclick=\"Table_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Create and download table creation source and data processing program source of ".$tab_hnm."' >&nbsp;&nbsp; ";
	} else if($mode == "Program_click") {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_backX('".$mode."', '".$data."', '".$page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' List of Program'>&nbsp;&nbsp;";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of ".$tab_hnm."' >&nbsp;&nbsp; ";
	} else {*/
		//if( $page>1) $first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
		//else $first_page = intval($page/$page_num+1) * 1;
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
	//}
?>
	</td>
  </tr>
</table>
</BODY>
</HTML>