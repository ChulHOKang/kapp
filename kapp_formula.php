<?php
	include_once('./tkher_start_necessary.php');
	/*
		kapp_formula.php : table_formulaM.php : 계산식 설정 
		call: kapp_pg_Upgrade.php, old:app_pg50RU.php
	*/
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

<?php

	/* 
	 *  kapp_formula.php : 테이블 계산식 적용 프로그램.  
	    - table_pg70.php - table_pg50.php - table_pg30.php
	     call : kapp_pg_Upgrade.php, app_PG50RU.php, kan_table_pg70.php
	 */
	$H_ID = get_session("ss_mb_id");	
	if( !$H_ID || $H_ID =='' ){
		$url=KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$H_LEV =$member['mb_level'];
	if( $H_LEV < 2 ){
		$url=KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";
	if( isset($_POST['mode_call']) ) $mode_call = $_POST['mode_call'];
	else $mode_call = "";
	
	if( isset($_POST['project_nmS']) ) $project_nmS = $_POST['project_nmS'];
	else $project_nmS = "";
	if( isset($_POST['project_code']) ) $project_code = $_POST['project_code'];
	else $project_code = '';
	if( isset($_POST['project_name']) ) $project_name = $_POST['project_name'];
	else $project_name = '';
	$_SESSION['project_name'] = $project_name;
	$_SESSION['project_code'] = $project_code;
	if( isset($_POST["pg_codeS"]) ) $pg_codeS = $_POST["pg_codeS"];
	else $pg_codeS = "";
	if( isset($_POST["tab_hnmS"]) ) $tab_hnmS = $_POST["tab_hnmS"];
	else $tab_hnmS = "";
	if( isset($_POST["pg_code"]) ) $pg_code = $_POST["pg_code"]; 
	else $pg_code = "";
	if( isset($_POST["pg_name"]) ) $pg_name = $_POST["pg_name"]; 
	else $pg_name = "";
	$_SESSION['pg_name'] = $pg_name;
	$_SESSION['pg_code'] = $pg_code;

	$table_item_run30 = "";
	$table_item_run70 = "";
	$table_item_run50R = "";
	$app_pg50RC = "";
	$app_pg50RU = "";
	$app_pg50RU_New = "";

 	$if_type  = array();
	$if_data = array();
	$idata_ = array();
	$col_ = array();
	$idata = '';

	if( isset($_POST['item_cnt']) ) $item_cnt = $_POST['item_cnt'];
	else $item_cnt = 0;
	if( isset($_POST['tab_hnm']) ) $tab_hnm = $_POST['tab_hnm'];
	else $tab_hnm = "";
	if( isset($_POST['tab_enm']) ) $tab_enm = $_POST['tab_enm'];
	else $tab_enm = "";

	if( isset($_POST['if_data']) ) $if_data = $_POST['if_data'];
	if( isset($_POST['if_type']) ) $if_type = $_POST['if_type'];

	if( isset($_POST['if_line']) ) $if_line  = $_POST['if_line'];		
	else $if_line  = 0;
	
	if( isset($_POST['sellist']) ) $sellist  = $_POST['sellist'];
	else $sellist  = 0;
	$_SESSION['sellist'] = $sellist;	//formula sellist: |fld_7|금액|INT|255, if_line: 6
	
	if( isset( $if_data[$if_line]) ) {
		//m_("if_data , $if_line : " . $if_data[$if_line] );
		$idata = $if_data[$if_line];
	}

	$idata1_enm = ""; 
	$idata2_hnm = ""; 
	$fd1 = ""; 
	$fd2 = ""; 
	$fd3 = ""; 
	$fd4 = ""; 
	$ifdata = '';
	$iftype = '';

	$ifline = $if_line +1;

	for( $i=0; $i<$item_cnt; $i++){
			if( isset($if_data[$i]) ) $ifdata = $ifdata . '|' . $if_data[$i]; 
			if( isset($if_type[$i]) ) $iftype = $iftype . '|' . $if_type[$i]; 
	}

	if( isset($idata) && $idata !='') { // fld_10 = fld_8 + fld_9:합계 = 금액 + 세액
		$idata_ = explode(":", $idata);
		if( isset($idata_[0]) ) $idata1_enm = $idata_[0]; 
		if( isset($idata_[1]) ) $idata2_hnm = $idata_[1]; 
		$dt_enm = explode(" ", $idata1_enm);           // a = f1 + f2;
		if( isset($dt_enm[0]) ) $fd1 = $dt_enm[0]; // 0= 'a' , 1= '='
		if( isset($dt_enm[2]) ) $fd2 = $dt_enm[2]; // 2= 'f1'
		if( isset($dt_enm[3]) ) $fd3 = $dt_enm[3]; // 3= '+'
		if( isset($dt_enm[4]) ) $fd4 = $dt_enm[4]; // 4= 'f2'
	}
	$pg_  = explode(":", $pg_codeS);
	$tab_ = explode(":", $tab_hnmS);
	$fld_ = explode("|", $sellist);
	$fld_enm_sel_column = $fld_[1];
	$fld_hnm_sel_column = $fld_[2];
	if( !$pg_codeS || !$tab_hnmS || !$sellist ) {
		$url="kapp_pg_Upgrade.php";
		echo("<meta http-equiv='refresh' content='0; URL=$url'>");
		exit;
	}
?>
<script language="JavaScript"> 
<!--
	function calc_( calc){ //alert('cale:'+calc);
		var calc_val = document.getElementById('sellist_calc'+calc).value;
		document.getElementById('calc_fd3').value = calc_val;

		makeform.sellist_calc_index.value = calc;
		var i = makeform.sellist_tab1_index.value;
		var j = calc;
		var k = makeform.sellist_tab2_index.value;
		if( i == '' ){
			alert('Choose column A! i:'+i);
			return;
		}
		if( k == '' ){
			return;
		} else {
			var fldenm = makeform.fld_enm_sel_column.value;
			var fldhnm = makeform.fld_hnm_sel_column.value;
			var fld1e = document.getElementById('sellist_tab2'+i).value;
			fld1ex = fld1e.split(":");
			var fld1h = fld1ex[1];
			var fld2e = document.getElementById('sellist_tab2'+k).value;
			fld2ex = fld2e.split(":");
			var fld2h = fld2ex[1];
			var calc_val = document.getElementById('sellist_calc'+j).value;
			document.makeform.calc_HNM.value = fldhnm + " = " + fld1h + " " + calc_val + " " + fld2h;
			document.makeform.calc_ENM.value = fldenm + " = " + fld1ex[0] + " " + calc_val + " " + fld2ex[0];
		}
		return;
	}
	function sellist_tab1_onclick( i) {
		var fld1e = document.getElementById('sellist_tab1'+i).value;
		document.getElementById('calc_fd2').value = fld1e;

		makeform.sellist_tab1_index.value = i;
		var j = makeform.sellist_calc_index.value;
		var k = makeform.sellist_tab2_index.value;

		if( k == '' ){
			return;
		}
		if( j == '' ){
			return;
		}
		var fldenm = makeform.fld_enm_sel_column.value;
		var fldhnm = makeform.fld_hnm_sel_column.value;
		fld1ex = fld1e.split(":");
		var fld1h = fld1ex[1];
		var fld2e = document.getElementById('sellist_tab2'+k).value;
		fld2ex = fld2e.split(":");
		var fld2h = fld2ex[1];
		var calc_val = document.getElementById('sellist_calc'+j).value;
		document.makeform.calc_HNM.value = fldhnm + " = " + fld1h + " " + calc_val + " " + fld2h;
		document.makeform.calc_ENM.value = fldenm + " = " + fld1ex[0] + " " + calc_val + " " + fld2ex[0];
		return;
	}
	function sellist_tab2_onclick(k) {
		var fld2e = document.getElementById('sellist_tab2'+k).value;
		document.getElementById('calc_fd4').value = fld2e;

		makeform.sellist_tab2_index.value = k;
		var j = makeform.sellist_calc_index.value;
		var i = makeform.sellist_tab1_index.value;

		if( i == '' ){
			alert('Choose column A! i:'+i);
			return;
		}
		if( j == '' ){
			alert('Choose a calculation formula! j:'+j);
			return;
		}
		var fldenm = makeform.fld_enm_sel_column.value;
		var fldhnm = makeform.fld_hnm_sel_column.value;
		var fld1e = document.getElementById('sellist_tab1'+i).value;
		fld1ex = fld1e.split(":");
		var fld1h = fld1ex[1];
		var fld2e = document.getElementById('sellist_tab2'+k).value;
		fld2ex = fld2e.split(":");
		var fld2h = fld2ex[1];
		var calc_val = document.getElementById('sellist_calc'+j).value;
		document.makeform.calc_HNM.value = fldhnm + " = " + fld1h + " " + calc_val + " " + fld2h;
		document.makeform.calc_ENM.value = fldenm + " = " + fld1ex[0] + " " + calc_val + " " + fld2ex[0];

		document.makeform.calc_button.hidden='true';
		return;
	}
	function calc_confirm() {
		makeform.mode.value="table_formula";
		makeform.action="kapp_formula.php";
		makeform.submit();
	}
	function calc_buttonA() { //calc_fd4
		if( makeform.calc_fd4.value == '') {
			alert(" data null - confirm");
			makeform.calc_fd4.focus();
			return false;
		}
		var j = document.makeform.sellist_calc_index.value;
		var calc_val = document.getElementById('sellist_calc'+j).value;
		var i = document.makeform.sellist_tab1_index.value;
		var fld1e = document.getElementById('sellist_tab1'+i).value;
		fld1ex = fld1e.split(":");
		var fld1e = fld1ex[0];
		var fld1h = fld1ex[1];
		var calc_fd4 = document.makeform.calc_fd4.value;
		var fldenm = makeform.fld_enm_sel_column.value;
		var fldhnm = makeform.fld_hnm_sel_column.value;
		document.makeform.calc_ENM.value = fldenm + ' = ' + fld1e + ' ' + calc_val + ' ' + calc_fd4;
		document.makeform.calc_HNM.value = fldhnm + ' = ' + fld1h + ' ' + calc_val + ' ' + calc_fd4;

		//document.makeform.calc_HNM.value = fldhnm + '(' + fldenm +')' + ' = ' + fld1e + ' ' +calc_val + ' ' + calc_fd4;
		//alert(fld1e + ",  sellist_tab1_index: " + i + ", sellist_calc_index: " +j + ", calc_fd4: " + calc_fd4); 
		//fld_8:금액,  sellist_tab1_index: 0, sellist_calc_index: 2, calc_fd4: 0.1
		//alert("fld1e: " + fld1e + ", calc_val: " +calc_val + ", calc_fd4: " + calc_fd4); 
		//fld1e: fld_8:금액, calc_val: *, calc_fd4: 0.1
	}
	/*function save_end_run( mode ){
		mode_call = document.makeform.mode_call.value;
		document.makeform.mode.value = "table_formula"; 
		document.makeform.action		= mode_call + ".php";
		document.makeform.submit();
	}*/
	function Back_func( $mode_call ) {
		pcd = makeform.project_code.value;
		pnm = makeform.project_name.value;
		pcdnm = pcd + ":" + pnm;
		makeform.mode.value="pg_codeS_Search";
		makeform.action= $mode_call + ".php";
		makeform.submit();
	}
	function Reset_func(mode){
		document.makeform.mode.value = mode;
		if_line = document.makeform.if_line.value;	
		resp = confirm(' Would you like to reset pop-up data removable?');
		if( !resp ) return false;
		else {
			var i = makeform.sellist_tab1_index.value;
			var j = makeform.sellist_calc_index.value;
			var k = makeform.sellist_tab2_index.value;
			document.getElementById('sellist_tab1'+i).checked=false;
			document.getElementById('sellist_calc'+j).checked=false;
			document.getElementById('sellist_tab2'+k).checked=false;
			makeform.sellist_tab1_index.value = '';
			makeform.sellist_calc_index.value = '';
			makeform.sellist_tab2_index.value = '';
			document.makeform.calc_HNM.value = "";
			document.makeform.calc_ENM.value = "";
			document.makeform["if_data[" + if_line + "]"].value = "";
		}
	}
//-->
</script>
<body leftmargin="0" topmargin="0">
<center>
<div id='menu_normal'>
   <table cellspacing='0' cellpadding='4' width='600' border='1' class='c1'>
		<FORM name="makeform" method="post" >

<?php
	if( $mode == 'table_formula' ){
		$iftype_db="";
		$ifdata_db="";
		$calc_ENM = "";
		$calc_HNM = ""; 
		$ifT	= "";
		$ifD= "";

		$ifdata = $_POST['ifdata'];
			$ifdata_ = explode("|", $ifdata);
		$iftype = $_POST['iftype'];
			$iftype_ = explode("|", $iftype);

		if( isset($_POST['calc_ENM']) ) $calc_ENM = $_POST['calc_ENM']; 
		if( isset($_POST['calc_HNM']) ) $calc_HNM = $_POST['calc_HNM']; 
		$idata11_EHNM = $calc_ENM . ":" . $calc_HNM;
		$iftype = ''; //|0|13|5|13|0|0|0|0|0|11
		$ifdata = ''; //||dao_1768440220:매출처|매입:매출|dao_1768177474:계정코드||||||fld_10 = fld_8 + fld_9:합계 = 금액 + 세액
		for( $i=0; $i<$item_cnt+1; $i++){
				$ifD= "";
				$ifT= "0";
			if( $i == $ifline){
				$idata11_EHNM = $calc_ENM . ":" . $calc_HNM;
				$iftype_db = $iftype_db . "|" . "11";
				if( isset($ifdata_[$i]) ) $ifdata = $ifdata. $idata11_EHNM . '|'; 
				if( isset($iftype_[$i]) ) $iftype = $iftype. '11' . '|' ; 
				$iftype_db = $iftype_db . "|" . "11";
				$ifdata_db = $ifdata_db . "|" . $calc_ENM . ":" . $calc_HNM;
?>
				<input type='hidden' name='if_type[<?=$i?>]'	 value='11' >
				<input type='hidden' name='if_data[<?=$i?>]' value='<?=$idata11_EHNM?>' > 
<?php
			} else {
				if( isset($ifdata_[$i]) ) $ifdata = $ifdata . $ifdata_[$i] . '|'; 
				if( isset($iftype_[$i]) ) $iftype = $iftype . $iftype_[$i] . '|'; 

				if( isset($ifdata_[$i]) ) $ifD= $ifdata_[$i];
				if( isset($iftype_[$i]) ) $ifT= $iftype_[$i];
?>
				<input type='hidden' name='if_type[<?=$i?>]' value='<?=$ifT?>' >
				<input type='hidden' name='if_data[<?=$i?>]' value='<?=$ifD?>' > 
<?php
				$iftype_db = $iftype_db . "|" . $ifT;
				$ifdata_db = $ifdata_db . "|" . $ifD;
			}
		}
		if( isset( $ifdata) && $ifdata !='' ) {
			$ifdata_db = $ifdata;
			$iftype_db = $iftype;
			$query="UPDATE {$tkher['table10_pg_table']} SET if_type='$iftype_db',if_data='$ifdata_db' WHERE userid='$H_ID' and pg_code='$pg_code' ";
			$ret = sql_query($query);
			if( $ret ){
				m_("--- formula - Save OK! ");
			} else {
				m_("--- formula - Save ERROR!");
				echo "sql: " .$query;
				exit;
			}
		}
		$_SESSION["mode_session"]='Formula'; // use - kapp_pg_Upgrade.php
		set_session('iftype_db',  $iftype_db);
		set_session('if_line',  $if_line);
		set_session('formula_data',  $idata11_EHNM);
		set_session('tab_hnmS',  $tab_hnmS);
		set_session('item_array',  $item_array);
		$mode = '';
	}//if $mode == 'table_formula'

	$sqlPG = "select * from {$tkher['table10_pg_table']} where userid='".$H_ID."' and pg_code='".$pg_code."' ";
	$rsPG = sql_fetch($sqlPG);
	if( isset($rsPG['item_array']) ) {
		$item_array = $rsPG['item_array'];
		$col_ = explode("@", $item_array);
		$itype = explode("|", $rsPG['if_type']);
		$idata_ = explode("|", $rsPG['if_data']);
		$idata11_EHNM = $idata_[$if_line+1];
		$itp = $itype[$if_line+1];
		if( $itp == "11" ) {
			$idt = $idata_[$if_line+1]; // idt = clac_ENM:calc_HNM
			$cl = explode(":", $idt);   // clac_ENM:calc_HNM
			$clac_ENM=$cl[0];
			$calc_HNM=$cl[1];
		}
	}
	if( $mode=="ResetCALC") { 
		$idata2_hnm = ""; 
		$idata1_enm = ""; 
		$fd1 = ""; 
		$fd2 = ""; 
		$fd3 = ""; 
		$fd4 = ""; 
		$ifdata = $_POST['ifdata'];
			$ifdata_ = explode("|", $ifdata);
		$iftype = $_POST['iftype'];
			$iftype_ = explode("|", $iftype);

		$ifdata = '';
		$iftype = '';
		for( $i=0; $i<$item_cnt; $i++){
				if( isset($ifdata_[$i]) ) $ifdata = $ifdata . $ifdata_[$i] . '|'; 
				if( isset($iftype_[$i]) ) $iftype = $iftype . $iftype_[$i] . '|' ; 
		}
	} else { // fld_10 = fld_8 + fld_9:합계 = 금액 + 세액
		$idata = $idata_[$if_line+1];
		if( isset($idata) && $idata !='') {
			$idata_ = explode(":", $idata);
			if( isset($idata_[0]) ) $idata1_enm = $idata_[0]; 
			if( isset($idata_[1]) ) $idata2_hnm = $idata_[1]; 
			$dt_enm = explode(" ", $idata1_enm);           // a = f1 + f2;
			if( isset($dt_enm[0]) ) $fd1 = $dt_enm[0]; // 0= 'a' , 1= '='
			if( isset($dt_enm[2]) ) $fd2 = $dt_enm[2]; // 2= 'f1'
			if( isset($dt_enm[3]) ) $fd3 = $dt_enm[3]; // 3= '+'
			if( isset($dt_enm[4]) ) $fd4 = $dt_enm[4]; // 4= 'f2'
		}
	}

?>


			<input type="hidden" name="mode"			value="<?=$mode?>" >
			<input type="hidden" name="mode_call"	value="<?=$mode_call?>" >
			<input type="hidden" name="tab_enm"		value="<?=$tab_enm?>">
			<input type="hidden" name="tab_hnm"		value="<?=$tab_hnm?>">
			<input type="hidden" name="fld_hnm_sel_column" value="<?=$fld_hnm_sel_column?>">
			<input type="hidden" name="fld_enm_sel_column" value="<?=$fld_enm_sel_column?>"> 
			<!-- <input type="hidden" name="calc_ENM"			value="<?=$idata1_enm?>">  -->
			<input type="hidden" name="sellist"			value="<?=$sellist?>"> 
			<input type="hidden" name="if_line"			value="<?=$if_line?>">
			<input type="hidden" name="item_cnt"		value="<?=$item_cnt?>">
			<input type="hidden" name="item_array"	value="<?=$item_array?>">
			<input type="hidden" name="iftype"	value="<?=$iftype?>">
			<input type="hidden" name="ifdata"	value="<?=$ifdata?>">
			<input type="hidden" name="pg_code"	    value="<?=$pg_code?>">
			<input type="hidden" name="pg_name"	    value="<?=$pg_name?>">
			<!-- <input type="hidden" name="group_code"	value="<?=$group_code?>">
			<input type="hidden" name="group_name"	value="<?=$group_name?>"> -->
			<input type="hidden" name="project_code"	value="<?=$project_code?>">
			<input type="hidden" name="project_name"	value="<?=$project_name?>">
			<input type="hidden" name="project_nmS"	value="<?=$project_nmS?>">
			<input type="hidden" name="pg_codeS"	value="<?=$pg_codeS?>"> 
			<input type="hidden" name="tab_hnmS"	value="<?=$tab_hnmS?>">
  <tr>
    <td height="30" align="center" style="border-style:;background-color:#666666;color:cyan;" <?php echo " title='(PG:/kapp/kapp_formula.php)\n For example, If the quantity and unit price are input, the amount is calculated and output. \n That is, the amount is automatically calculated without inputting.' "; ?>>
	<!-- \n 예를들면, 수량 과 단가를 입력하면 금액을 계산하여 출력한다. \n 즉,금액은 입력하지않고 자동으로 계산된다. -->
	<b><font color='white'>Set calculation formula</b><br>
	<b><font color='white'>Project Name: <font color='yellow'><?=$project_name?>(<?=$project_code?>)</b><br>
	<font color='white'>Program Name: <font color='yellow'><?=$pg_name?>(<?=$pg_code?>)<br>
	<font color='white'>Table Name: <font color='yellow'><?=$tab_hnm?>(<?=$tab_enm?>)<br>
	<b><font color='white'>Formula Column Name: <font color='yellow'><?=$fld_hnm_sel_column?>(<?=$fld_enm_sel_column?>) =</b><br>
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
	// Only numeric columns can be used in calculations.
	$j = 0;
	$chk = '';
	$tab1_index = '';
	for( $i=0; isset($col_[$i]) && $col_[$i] !== '';$i++) {
		$_col = explode("|", $col_[$i]);
			if( $_col[1] =='seqno') continue; // Only numeric columns can be used in calculations.
			else if( $_col[3] =='CHAR' || $_col[3] =='VARCHAR' || $_col[3] =='TEXT' || $_col[3] =='DATE' || $_col[3] =='TIME') continue;
			else if( $_col[3] =='BLOB' || $_col[3] =='LONGBLOB' || $_col[3] =='DATATIME'|| $_col[3] =='TIMESTAMP') continue;
		if( $fd2 == $_col[1]) { $chk =' checked '; $tab1_index = $j; }
		/*if( $fd2 == $_col[1]) {
			$tab1_index = $j;
			echo "<label style='background-color:cyan;'><input type='radio' id='sellist_tab1".$j."' name='sellist_tab1' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab1_onclick('".$j."')\" title='".$_col[1]."' checked> ".$_col[2]." </label><br>";
		}else{
			echo "<label style='background-color:white;'><input type='radio' id='sellist_tab1".$j."' name='sellist_tab1' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab1_onclick('".$j."')\" title='".$_col[1]."'> ".$_col[2]." </label><br>";
		}
		*/
		echo "<label style='background-color:white;'><input type='radio' id='sellist_tab1".$j."' name='sellist_tab1' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab1_onclick('".$j."')\" title='".$_col[1]."' $chk >".$_col[2]." </label><br>";
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
			if( $fd3=='+') $calc_index = 0;
			else if( $fd3=='-') $calc_index = 1;
			else if( $fd3=='*') $calc_index = 2;
			else if( $fd3=='/') $calc_index = 3;
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
	$tab2_index = '';
	$chk ='';
	for($i=0; $col_[$i] != ''; $i++) {
			$_col = explode("|", $col_[$i]);
			if($_col[1] =='seqno') continue; //Only numeric columns can be used in calculations.
			else if( $_col[3] =='CHAR' || $_col[3] =='VARCHAR' || $_col[3] =='TEXT' || $_col[3] =='DATE' || $_col[3] =='TIME') continue;
			else if( $_col[3] =='BLOB' || $_col[3] =='LONGBLOB' || $_col[3] =='DATATIME'|| $_col[3] =='TIMESTAMP') continue;
		if( $fd4==$_col[1]) { $chk =' checked '; $tab2_index = $j; }
		/*if( $fd4==$_col[1]) {
			$tab2_index = $j;
			echo "<label style='background-color:cyan;'><input type='radio' id='sellist_tab2".$j."' name='sellist_tab2' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab2_onclick('".$j."')\" title='".$_col[1]."' checked> ".$_col[2]." </label><br>";
		}else{
			echo "<label style='background-color:white;'><input type='radio' id='sellist_tab2".$j."' name='sellist_tab2' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab2_onclick('".$j."')\" title='".$_col[1]."'> ".$_col[2]." </label><br>";
		}*/
		echo "<label style='background-color:white;'><input type='radio' id='sellist_tab2".$j."' name='sellist_tab2' value='".$_col[1].":".$_col[2]."' onClick=\"sellist_tab2_onclick('".$j."')\" title='".$_col[1]."' $chk > ".$_col[2]." </label><br>";
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
						<td height="24" style='background-color:cyan;'>
						Formula: <?=$fld_hnm_sel_column?>(<?=$fld_enm_sel_column?>)=<br>
						column A:<input id='calc_fd2' name='calc_fd2' value='<?=$fd2?>'><br>
						calc type : <input id='calc_fd3' name='calc_fd3' value='<?=$fd3?>'><br>
						column B:<input id='calc_fd4' name='calc_fd4' value='<?=$fd4?>'>&nbsp;
						<input type='button' id='calc_button' name='calc_button' onClick="javascript:calc_buttonA();" value='Confirm'><br>
						Formula:<br><input id='calc_HNM' name='calc_HNM' value='<?=$idata2_hnm?>' style='height:33;WIDTH:100%' readonly>
						<br><input id='calc_ENM' name='calc_ENM' value='<?=$idata1_enm?>' style='height:33;WIDTH:100%' readonly><br>
						</td>
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

			<input type="hidden" name="sellist_tab1_index"	value="<?=$tab1_index?>">
			<input type="hidden" name="sellist_calc_index"	value="<?=$calc_index?>">
			<input type="hidden" name="sellist_tab2_index"	value="<?=$tab2_index?>">
			<input type="hidden" name="mode_session" value="Formula">
			<input type="hidden" name="iftype_db"    value="<?=$iftype_db?>">
			<input type="hidden" name="formula_data" value="<?=$idata11_EHNM?>">
	</form>

</body>
</html>
