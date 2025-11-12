<?php
	include_once('./tkher_start_necessary.php');
	/*
		table_formulaM.php : 계산식 설정 : app_pg50RU.php 에서 call - 
	*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Made in Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

<?php

	/* 
	 *  table_formulaM.php : 테이블 계산식 적용 프로그램.  
	    - table_pg70.php에서 콜.
	    - table_pg50.php에서 콜.
		- table_pg30.php에서 콜.2018-10-22
	     call : app_PG50RU.php, kan_table_pg70.php - 2025-04-14
	 */
	$H_ID	= get_session("ss_mb_id");	
	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	if( !$H_ID || $H_LEV < 2 )
	{
		$url="/";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";
	if( isset($_POST['mode_call']) ) $mode_call = $_POST['mode_call'];
	else $mode_call = "";
	if( isset($_POST['project_nmS']) ) $project_nmS = $_POST['project_nmS'];
	else $project_nmS = "";
	if( isset($_POST['project_code']) ) $project_code = $_POST['project_code'];
	else $project_code = "ETC";
	if( isset($_POST['project_name']) ) $project_name = $_POST['project_name'];
	else $project_name = "ETC";
	if( isset($_POST["pg_codeS"]) ) $pg_codeS = $_POST["pg_codeS"]; //$_POST["pg_codeS"]
	else $pg_codeS = "";	 // pg_codeS:dao_1633396679:출고:dao_1633396679:출고:9999:출고
	if( isset($_POST["tab_hnmS"]) ) $tab_hnmS = $_POST["tab_hnmS"];
	else $tab_hnmS = "";
	if( isset($_POST["group_code"]) ) $group_code = $_POST["group_code"]; 
	else $group_code = "";
	if( isset($_POST["group_name"]) ) $group_name = $_POST["group_name"]; 
	else $group_name = "";
	if( isset($_POST["pg_code"]) ) $pg_code = $_POST["pg_code"]; 
	else $pg_code = "";
	if( isset($_POST["pg_name"]) ) $pg_name = $_POST["pg_name"]; 
	else $pg_name = "";

	$table_item_run30 = "";
	$table_item_run70 = "";
	$table_item_run50R = "";
	$app_pg50RC = "";
	$app_pg50RU = "";
	$app_pg50RU_New = "";
	if( $mode_call == 'table_item_run30' ) $table_item_run30 = 'on';
	else if( $mode_call == 'table_item_run70' ) $table_item_run70 = 'on';
	else if( $mode_call == 'table_item_run50R' ) $table_item_run50R = 'on';
	else if( $mode_call == 'app_pg50RC' ) $app_pg50RC = 'on';
	else if( $mode_call == 'app_pg50RU' ) $app_pg50RU = 'on';
	else if( $mode_call == 'app_pg50RU_New' ) $app_pg50RU_New = 'on';

 	$iftype  = array();
	$if_data = array();
	$idata = array();
	$col_ = array();

	if( isset($_POST['item_cnt']) ) $item_cnt = $_POST['item_cnt'];
	else $item_cnt = 0;
	if( isset($_POST['tab_hnm']) ) $tab_hnm = $_POST['tab_hnm'];
	else $tab_hnm = "";
	if( isset($_POST['tab_enm']) ) $tab_enm = $_POST['tab_enm'];
	else $tab_enm = "";
	if( isset($_POST['if_data']) ) $if_data = $_POST['if_data'];
	if( isset($_POST['iftype']) ) $iftype  = $_POST['iftype'];
	if( isset($_POST['if_line']) ) $if_line  = $_POST['if_line'];		
	else $if_line  = 0;
	$idata   = $if_data[$if_line];
	if( isset($_POST['sellist']) ) $sellist  = $_POST['sellist'];		// 선택한 컬럼. 팝업에 적용할 컬럼.//sellist:277|fld_1|상품|CHAR|20
	else $sellist  = 0;
	$idata1 = ""; 
	$idata2 = ""; 
	$fd1 = ""; 
	$fd2 = ""; 
	$fd3 = ""; 
	$fd4 = ""; 

	if( isset($idata) ) {
		$idata_ = explode(":", $idata);
		if( isset($idata_[1]) ) $idata2 = $idata_[1]; 
		if( isset($idata_[0]) ) $idata1 = $idata_[0]; 
		$dt = explode(" ", $idata1);
		if( isset($dt[0]) ) $fd1 = $dt[0]; // $dt[1]은 '='
		if( isset($dt[2]) ) $fd2 = $dt[2]; 
		if( isset($dt[3]) ) $fd3 = $dt[3]; 
		if( isset($dt[4]) ) $fd4 = $dt[4]; 	//m_("0:$fd1, 2:$fd2, 3:$fd3, 4:$fd4");//$dt[0]:fld_4,$dt[2]:fld_2,$dt[3]:*,$dt[4]:fld_3
	} else {
		$idata2 = ""; 
		$idata1 = ""; 
		$fd1 = ""; 
		$fd2 = ""; 
		$fd3 = ""; 
		$fd4 = ""; 
	}
	$pg_  = explode(":", $pg_codeS);
	$tab_ = explode(":", $tab_hnmS);
	$fld_ = explode("|", $sellist);
	$fld_enm_sel_column = $fld_[1];
	$fld_hnm_sel_column = $fld_[2];
	if ( !$pg_codeS || !$tab_hnmS || !$sellist ) {
			$url="./";	//$PHP_SELF;
			echo("<meta http-equiv='refresh' content='0; URL=$url'>");
		exit;
	}
?>
<script language="JavaScript"> 
<!--
	function calc_(calc){ //alert('cale:'+calc);
		makeform.sellist_calc_index.value = calc;
		var i = makeform.sellist_tab1_index.value;
		var j = calc;
		var k = makeform.sellist_tab2_index.value;
		if( i == '' ){
			alert('Choose column A! i:'+i);// 컬럼 A를 선택하세요!
			return;
		}
		if( k == '' ){
			//alert('Choose column B! k:'+k);// 컬럼 B를 선택하세요!
			return;
		} else {
			var fldenm = makeform.fld_enm_sel_column.value;
			var fldhnm = makeform.fld_hnm_sel_column.value; // 금액 - 계산식 선택한 컬럼 
			var fld1e = document.getElementById('sellist_tab2'+i).value;
			fld1ex = fld1e.split(":");
			var fld1h = fld1ex[1];
			var fld2e = document.getElementById('sellist_tab2'+k).value;
			fld2ex = fld2e.split(":");
			var fld2h = fld2ex[1];
			var calc_val = document.getElementById('sellist_calc'+j).value;
			document.makeform.nmx2.value = fldhnm + " = " + fld1h + " " + calc_val + " " + fld2h;
			document.makeform.calcX.value = fldenm + " = " + fld1ex[0] + " " + calc_val + " " + fld2ex[0];
		}
		return;
	}
	function sellist_tab1_onclick(i) {
		makeform.sellist_tab1_index.value = i;
		var j = makeform.sellist_calc_index.value;
		var k = makeform.sellist_tab2_index.value;
		if( k == '' ){
			//alert('Choose column B! i:'+i); // 컬럼 B를 선택하세요!
			return;
		}
		if( j == '' ){
			//alert('Choose a calculation formula! j:'+j); // 계산식을 선택하세요!
			return;
		}
		var fldenm = makeform.fld_enm_sel_column.value;
		var fldhnm = makeform.fld_hnm_sel_column.value; // 금액
		var fld1e = document.getElementById('sellist_tab1'+i).value;
		fld1ex = fld1e.split(":");
		var fld1h = fld1ex[1];
		var fld2e = document.getElementById('sellist_tab2'+k).value;
		fld2ex = fld2e.split(":");
		var fld2h = fld2ex[1];
		var calc_val = document.getElementById('sellist_calc'+j).value;
		document.makeform.nmx2.value = fldhnm + " = " + fld1h + " " + calc_val + " " + fld2h;
		document.makeform.calcX.value = fldenm + " = " + fld1ex[0] + " " + calc_val + " " + fld2ex[0];
		return;
	}
	function sellist_tab2_onclick(k) {
		makeform.sellist_tab2_index.value = k;
		var j = makeform.sellist_calc_index.value;
		var i = makeform.sellist_tab1_index.value;
		if( i == '' ){
			alert('Choose column A! i:'+i);// 컬럼 A를 선택하세요!
			return;
		}
		if( j == '' ){
			alert('Choose a calculation formula! j:'+j); // 계산식을 선택하세요!
			return;
		}
		var fldenm = makeform.fld_enm_sel_column.value;
		var fldhnm = makeform.fld_hnm_sel_column.value; // 금액
		var fld1e = document.getElementById('sellist_tab1'+i).value;
		fld1ex = fld1e.split(":");
		var fld1h = fld1ex[1];
		var fld2e = document.getElementById('sellist_tab2'+k).value;
		fld2ex = fld2e.split(":");
		var fld2h = fld2ex[1];
		var calc_val = document.getElementById('sellist_calc'+j).value;
		document.makeform.nmx2.value = fldhnm + " = " + fld1h + " " + calc_val + " " + fld2h;
		document.makeform.calcX.value = fldenm + " = " + fld1ex[0] + " " + calc_val + " " + fld2ex[0];
		return;
	}
	function calc_confirm() {
		makeform.mode.value="table_formula";
		makeform.action="table_formulaM.php";
		makeform.submit();
	}
	function save_end_run( mode ){
		mode_call = document.makeform.mode_call.value;
		document.makeform.mode.value = "POPSearchPG"; // 2023-09-13 set kan
		document.makeform.action		= mode_call + ".php"; // "app_pg50RU_New.php"; //"table_formulaM.php"; // 2023-09-13 set
		document.makeform.submit();
	}
	function Back_func( $mode_call ) {
		pcd = makeform.project_code.value;
		pnm = makeform.project_name.value;
		pcdnm = pcd + ":" + pnm;
		makeform.mode.value="POPSearchPG"; //"SearchPG";
		makeform.action= $mode_call + ".php";
		makeform.submit();
	}
	function Reset_func(mode){
		document.makeform.mode.value = mode; //ResetCALC
		if_line = document.makeform.if_line.value;	
		resp = confirm(' Would you like to reset pop-up data removable?'); // \n 팝업데이터 이동식을 다시 설정 하시겠습니까?
		if( !resp ) return false;
		else {
			var i = makeform.sellist_tab1_index.value;
			var j = makeform.sellist_calc_index.value;
			var k = makeform.sellist_tab2_index.value;			//alert('i:'+i +', j:'+j+', k:'+k +', if_line:'+if_line);
			document.getElementById('sellist_tab1'+i).checked=false;
			document.getElementById('sellist_calc'+j).checked=false;
			document.getElementById('sellist_tab2'+k).checked=false;
			makeform.sellist_tab1_index.value = '';
			makeform.sellist_calc_index.value = '';
			makeform.sellist_tab2_index.value = '';
			document.makeform.nmx2.value = "";
			document.makeform.calcX.value = "";
			document.makeform["if_data[" + if_line + "]"].value = "";
		}
	}
//-->
</script>

<?php
	$sqlPG = "select * from {$tkher['table10_pg_table']} where userid='".$H_ID."' and pg_code='".$pg_code."' ";
	$resultPG = sql_query($sqlPG);
	$table10_pg = sql_num_rows($resultPG);
	if( isset($table10_pg) ) {
		$rsPG = sql_fetch_array($resultPG);
		$item_array = $rsPG['item_array'];
		$col_ = explode("@", $item_array);		//m_( "111 :_col 1:".$col_[1].", 2:".$col_[2]. ", 3:".$col_[3] );
		$itype = explode("|", $rsPG['if_type']);
		$idata = explode("|", $rsPG['if_data']);
		$itp = $itype[$if_line+1];
		if( $itp == "11" ) {
			$idt = $idata[$if_line+1];
			$cl = explode(":", $idt);
		}
	}
	if( $mode=="ResetPOP") { 
		$idata2 = ""; 
		$idata1 = ""; 
		$fd1 = ""; 
		$fd2 = ""; 
		$fd3 = ""; 
		$fd4 = ""; 
	}
?>

<body leftmargin="0" topmargin="0">
<center>
<div id='menu_normal'>
   <table cellspacing='0' cellpadding='4' width='600' border='1' class='c1'>
		<FORM name="makeform" method="post" >
			<input type="hidden" name="mode"			value="" >
			<input type="hidden" name="mode_call"	value="<?=$mode_call?>" >
			<input type="hidden" name="tab_enm"		value="<?=$tab_enm?>">
			<input type="hidden" name="tab_hnm"		value="<?=$tab_hnm?>">
			<input type="hidden" name="fld_hnm_sel_column" value="<?=$fld_hnm_sel_column?>">
			<input type="hidden" name="fld_enm_sel_column" value="<?=$fld_enm_sel_column?>"> 
			<input type="hidden" name="calcX"			value="<?=$idata1?>"> 
			<input type="hidden" name="sellist"			value="<?=$sellist?>"> 
			<input type="hidden" name="if_line"			value="<?=$if_line?>">
			<input type="hidden" name="item_cnt"		value="<?=$item_cnt?>">
			<input type="hidden" name="item_array"	value="<?=$item_array?>">
			<input type="hidden" name="pg_code"	    value="<?=$pg_code?>">
			<input type="hidden" name="pg_name"	    value="<?=$pg_name?>">
			<input type="hidden" name="group_code"	value="<?=$group_code?>">
			<input type="hidden" name="group_name"	value="<?=$group_name?>">
			<input type="hidden" name="project_code"	value="<?=$project_code?>">
			<input type="hidden" name="project_name"	value="<?=$project_name?>">
			<input type="hidden" name="project_nmS"	value="<?=$project_nmS?>">
			<input type="hidden" name="pg_codeS"	value="<?=$pg_codeS?>"> 
			<input type="hidden" name="tab_hnmS"	value="<?=$tab_hnmS?>">
  <tr>
    <td height="30" align="center" style="border-style:;background-color:#666666;color:cyan;" <?php echo " title='For example, If the quantity and unit price are input, the amount is calculated and output. \n That is, the amount is automatically calculated without inputting.' "; ?>>
	<!-- \n 예를들면, 수량 과 단가를 입력하면 금액을 계산하여 출력한다. \n 즉,금액은 입력하지않고 자동으로 계산된다. -->
	<b><font color='white'>Program Name: <font color='yellow'><?=$pg_name?>(<?=$pg_code?>)<br>
	<b><font color='white'>Table Name: <font color='yellow'><?=$tab_hnm?>(<?=$tab_enm?>)<br>
	<b><font color='white'>Formula Column Name: <font color='yellow'><?=$fld_hnm_sel_column?>(<?=$fld_enm_sel_column?>) =</b>
	</td>
  </tr>
			<tr>
               <td width="92%" valign="top" align="center">
				  <div id='menu_normal'>
                    <table width="80%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                              <td valign="top" align="right" width="200">
                               <table cellspacing="0" cellpadding="0" width="200" border="1">
							  <tr>
                                    <td bgcolor="#666666" height="30" align="center"><font color="#FFFFFF" >
									<b>Select Column A</b></font>
									<br>
									<input type='text' id='tab_hnm' name='tab_hnm' value='<?=$tab_[1]?>' style="border-style:;background-color:#666666;color:yellow;width:140px; height:25px;">
									<br>
									</td>
                                  </tr>
                                  <tr>
                                     <td valign="top">
<?php
				// 숫자 column 만 계산식에 사용 가능하다. 
	$j = 0;
	for($i=0; isset($col_[$i]) && $col_[$i] !== '';$i++) {
		$_col = explode("|", $col_[$i]);
			if( $_col[1] =='seqno') continue;
			else if( $_col[3] =='CHAR' ) continue;
			else if( $_col[3] =='VARCHAR' ) continue;
			else if( $_col[3] =='TEXT' ) continue;// 숫자 와 문자 컬럼만 팝업창에 사용할 수 있게 한다.
			else if( $_col[3] =='DATE' ) continue;
			else if( $_col[3] =='DATATIME' ) continue;
			else if( $_col[3] =='TIMESTAMP' ) continue;
		if( $fd2==$_col[1]) {
			$tab1_index = $j;
			echo "<label style='background-color:cyan;'><input type='radio' id='sellist_tab1".$j."' name='sellist_tab1' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab1_onclick('".$j."')\" title='".$_col[1]."' checked> ".$_col[2]." </label><br>";
		}else{
			echo "<label style='background-color:white;'><input type='radio' id='sellist_tab1".$j."' name='sellist_tab1' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab1_onclick('".$j."')\" title='".$_col[1]."'> ".$_col[2]." </label><br>";
		}
		$j++;
	}

?>
                                     </td>
                                   </tr>
                            </table>
                          </td>
                           <td align="center">
                              <table cellspacing="0" cellpadding="0" width="150" align="center" border="1">
                                <tr>
                                  <td bgcolor="#666666" height="30" align="center" style="WIDTH: 100px" ><font color="#FFFFFF">
									<b>Select operator<br>Select formula</b></font>
								  </td>
                                </tr>
								<tr>
                                  <td height="10">

<?php
			if($fd3=='+') $calc_index = 0;
			else if($fd3=='-') $calc_index = 1;
			else if($fd3=='*') $calc_index = 2;
			else if($fd3=='/') $calc_index = 3;
			else $calc_index = 0;
?>

		<p><label <?php if($fd3=='+') echo " style='background-color:cyan;' ";?>> <input type='radio' onclick="calc_('0')" id='sellist_calc0' name='sellist_calc' value='+' <?php if($fd3=='+') echo " checked ";?> title='fd3:".$fd3."' \> +( Plus ) </label></p>
		<p><label <?php if($fd3=='-') echo " style='background-color:cyan;' ";?>> <input type='radio' onclick="calc_('1')" id='sellist_calc1' name='sellist_calc' value='-' <?php if($fd3=='-') echo " checked ";?> title='fd3:".$fd3."' \> -(Minus) </label></p>
		<p><label <?php if($fd3=='*') echo " style='background-color:cyan;' ";?>> <input type='radio' onclick="calc_('2')" id='sellist_calc2' name='sellist_calc' value='*' <?php if($fd3=='*') echo " checked ";?> title='fd3:".$fd3."' \> *(multiply) </label></p>
		<p><label <?php if($fd3=='/') echo " style='background-color:cyan;' ";?>> <input type='radio' onclick="calc_('3')" id='sellist_calc3' name='sellist_calc' value='/' <?php if($fd3=='/') echo " checked ";?> title='fd3:".$fd3."' \> /(division) </label></p>

								  </td>
                                </tr>
                             </table>
                           </td>
                              <td valign="top" align="right" width="200">
                                <table cellspacing="0" cellpadding="0" width="200" border="1">
                                  <tr>
                                    <td bgcolor="#666666" height="30" align="center"><font color="#FFFFFF" >
									<b>Select Column B</b></font>
									<br>
									<input type='text' name='tab_hnm' value='<?=$tab_[1]?>' style="border-style:;background-color:#666666;color:yellow;width:140px; height:25px;">
									<br>
									</td>
                                  </tr>
                                  <tr>
                                     <td valign="top">
		

<?php
	$j = 0;
	for($i=0; $col_[$i] != ''; $i++) {
			$_col = explode("|", $col_[$i]);
			if($_col[1] =='seqno') continue;
			else if( $_col[3] =='CHAR' ) continue;
			else if( $_col[3] =='VARCHAR' ) continue;
			else if( $_col[3] =='TEXT' ) continue;// 숫자 와 문자 컬럼만 팝업창에 사용할 수 있게 한다.
			else if( $_col[3] =='DATE' ) continue;
			else if( $_col[3] =='DATATIME' ) continue;
			else if( $_col[3] =='TIMESTAMP' ) continue;
		if( $fd4==$_col[1]) {
			$tab2_index = $j;
			echo "<label style='background-color:cyan;'><input type='radio' id='sellist_tab2".$j."' name='sellist_tab2' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab2_onclick('".$j."')\" title='".$_col[1]."' checked> ".$_col[2]." </label><br>";
		}else{
			echo "<label style='background-color:white;'><input type='radio' id='sellist_tab2".$j."' name='sellist_tab2' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab2_onclick('".$j."')\" title='".$_col[1]."'> ".$_col[2]." </label><br>";
		}
		$j++;
	}

?>
                                     </td>
                                   </tr>
                            </table>
                          </td>
                         </tr>
                       </table>
                       </div>
                      </td>
                     </tr>
					  <tr>
						<td height="24" style='background-color:cyan;'>Formula:<input id='nmx2' name='nmx2' maxlength='200' size='60' value='<?=$idata2?>' style='height:33;' readonly></td>
					  </tr>
					<tr>
                      <td align="center" >
						<button name='run' title='Save' border="0" onClick="calc_confirm()" style="cursor:hand;">Save</button>
							&nbsp;&nbsp;&nbsp;
						<button name='runb' <?php echo "title=' Reset the formula. ' ";?> onClick="javascript:Reset_func('ResetCALC')" style="cursor:hand;">Reset</button>
							&nbsp;&nbsp;&nbsp;
							<input type='button' value='Back' onClick="Back_func('<?=$mode_call?>')" <?php echo "title=' Reset the removable.' ";?> \> 
						</td>
                    </tr>
	</table>

<?php
if( $mode == 'table_formula' ){
	$iftype_db="";
	$ifdata_db="";
	$calcX = "";
	$nmx2 = ""; 
	$ifT	= "";
	$ifD= "";	//m_("cnt: " . $item_cnt . ", if_line:" . $if_line); //cnt: 6, if_line:3
	for( $i=0; $i<$item_cnt; $i++){
		if( $i == $if_line ) {
			if( isset($_POST['calcX']) ) $calcX = $_POST['calcX']; 
			if( isset($_POST['nmx2']) ) $nmx2 = $_POST['nmx2']; 
			$idata11 = $calcX . ":" . $nmx2;
?>
			<input type='hidden' name='iftype[<?=$i?>]'	 value='11' >
			<input type='hidden' name='if_data[<?=$i?>]' value='<?=$idata11?>' > 
<?php
			$iftype_db = $iftype_db . "|" . "11";
			$ifdata_db = $ifdata_db . "|" . $calcX . ":" . $nmx2;
		} else {
			if( isset($iftype[$i]) ) $ifT	= $iftype[$i];
			else  $ifT	= "";
			if( isset($if_data[$i]) ) $ifD= $if_data[$i];
			else $ifD= "";
?>
			<input type='hidden' name='iftype[<?=$i?>]'  value='<?=$ifT?>' >
			<input type='hidden' name='if_data[<?=$i?>]' value='<?=$ifD?>' > 
<?php
			$iftype_db = $iftype_db . "|" . $ifT;
			$ifdata_db = $ifdata_db . "|" . $ifD;
		}
	}	//m_("idata11: " . $idata11 . ", iftype_db: " . $iftype_db . ", ifdata_db: " .$ifdata_db); 
	//idata11: fld_4 = fld_5 * fld_5:fld4 = fld5 * fld5, iftype_db: |||13|11||, ifdata_db: |||dao_1744251268:testDDD|fld_4 = fld_5 * fld_5:fld4 = fld5 * fld5||
	if( isset($table10_pg) ) {
		$query="UPDATE {$tkher['table10_pg_table']} SET item_cnt=$item_cnt, item_array='$item_array',if_type='$iftype_db',if_data='$ifdata_db', pg_name='$pg_name' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) m_("OK!");
		else {
			echo "sql: " . $query;
			exit;
		}
	} else {
		$pg_code = $H_ID . '_' . time();
		$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$pg_code', pg_name='$pg_name', item_cnt=$item_cnt, item_array='$item_array', if_type='$iftype_db', if_data='$ifdata_db', userid='$H_ID' ";
		$ret = sql_query($query);
	}
	set_session('mode_session',  'Formula');
	set_session('iftype_db',  $iftype_db);
	set_session('if_line',  $if_line);
	set_session('formula_data',  $idata11);
	set_session('tab_hnmS',  $tab_hnmS);
	set_session('item_array',  $item_array);	m_(" Complete calculation. ");

} else {	//if $mode == 'table_formula'
		$iftype_db="";
		$ifdata_db="";
		for( $i=0; $i<$item_cnt; $i++){
?>
			<input type='hidden' name='iftype[<?=$i?>]'  value='<?=$iftype[$i]?>' >
			<input type='hidden' name='if_data[<?=$i?>]' value='<?=$if_data[$i]?>' > 
<?php
			$iftype_db = $iftype_db . "|" . $iftype[$i];
			$ifdata_db = $ifdata_db . "|" . $if_data[$i];
		}
}//if $mode == 'table_formula'
?>
			<input type="hidden" name="sellist_tab1_index"	value="<?=$tab1_index?>">
			<input type="hidden" name="sellist_calc_index"	value="<?=$calc_index?>">
			<input type="hidden" name="sellist_tab2_index"	value="<?=$tab2_index?>">
			<input type="hidden" name="mode_session" value="Formula">
			<input type="hidden" name="iftype_db"    value="<?=$iftype_db?>">
			<input type="hidden" name="formula_data" value="<?=$idata11?>">
	</form>

<?php
	if( $mode == 'table_formula' ){
		if( $table_item_run30 == 'on' ) {
			$url = "table_pg30.php";
		} else if( $table_item_run50R == 'on' ) {
			set_session('pg_codeS',  $pg_codeS);
			$url = "table_pg50R.php";
		} else if( $table_item_run70 == 'on' ) {
			set_session('pg_codeS',  $pg_codeS);
			$url = "table_pg70.php";	
		} else if( $app_pg50RC == 'on' ) {
			set_session('pg_codeS',  $pg_codeS);
			$url = "app_pg50RC.php";
		} else if( $app_pg50RU == 'on' ) {
			set_session('pg_codeS',  $pg_codeS);
			$url = "app_pg50RU.php";
		} else if( $app_pg50RU_New == 'on' ) { // 2021-09-27 add
			set_session('pg_codeS',  $pg_codeS);
			$url = "app_pg50RU_New.php";		//echo "<script>window.open('$url', '_self', '');</script>";
		}
		echo "<script>save_end_run( 'Save_End' );</script>";	
	}
?>
</body>
</html>
