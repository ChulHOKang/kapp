<?php
	include_once('./tkher_start_necessary.php');
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<?php
	/*
	 *  table_popupRM.php : PopUp Window setup 프로그램. <- table_popupR.php
        call : app_pg50RU.php 에서 콜.
        call : app_pg50RC.php 에서 콜.
        X call : table_pg50R.php 에서 콜.
	    C call : kan_table_pg70.php,   - table_pg70.php에서 콜.
		
		독립적 실행방법: https://appgenerator.net/t/table_popupRM.php?pg_code=dao_1644457338&if_line=1

		'table_popupRM.php?pg_code='+pg_code+'&if_line='+selind;

		group_code: solpakanA_naver_1750725492, if_line: 1
	 */
	
	$H_ID  = get_session("ss_mb_id");	
	//You need to login. pg_codeS:dao_1540279192:생산정보-A:dao_1536028075:생산정보::, tab_hnmS:dao_1536028075:생산정보, sellist:
	if( !$H_ID || $H_ID =='' ){
		my_msg("You need to login. ");
		$url="/";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}

	$H_LEV = $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$if_type  = array();
	$if_data  = array();
	$col_ = array();
	$type_ = array();
	$ifT = array();
	$ColnmA = array();

	if( isset($_POST['mode']) && $_POST['mode'] !=='' ) $mode = $_POST['mode'];
	else $mode = "";
	if( isset($_POST['mode_call']) ) $mode_call = $_POST['mode_call'];
	else $mode_call = "";
	if( isset( $_POST["project_nmS"]) )  $project_nmS = $_POST["project_nmS"]; 
	else $project_nmS = "";
	if( isset( $_POST["project_code"]) )  $project_code = $_POST["project_code"]; 
	else $project_code = "";
	if( isset( $_POST["project_name"]) ) $project_name = $_POST["project_name"]; 
	else $project_name = "";
	if( isset($_POST["group_code"]) ) $group_code = $_POST["group_code"]; 
	else $group_code = "";
	if( isset($_POST["group_name"]) ) $group_name = $_POST["group_name"]; 
	else $group_name = "";
	if( isset($_POST["pg_codeS"]) ) $pg_codeS = $_POST["pg_codeS"]; 
	else $pg_codeS = "";
	if( isset($_POST['pop_tabS']) ) $pop_tabS = $_POST['pop_tabS']; 
	else $pop_tabS = "";
	if( isset($_POST["pg_code"]) ) $pg_code = $_POST["pg_code"]; 
	else $pg_code = "";
	if( isset($_POST["pg_name"]) ) $pg_name = $_POST["pg_name"]; 
	else $pg_name = "";
	if( isset($_POST['pop_tab']) ) $pop_table= $_POST['pop_tab'];
	else $pop_table = "";
	if( isset($_POST["if_line"]) ) {
		$if_line = $_POST["if_line"]; 
		$ln = $if_line+1;	  
	} else {
		$if_line = "";
		$ln = 0;
	}

	if( isset($_POST['if_column']) &&  $_POST['if_column'] !=='' ) $if_column = $_POST["if_column"]; 
	else $if_column = "";
	$tab_enm_pop = "";
	$tab_hnm_pop = "";
	$table_item_run30 = "";
	$table_item_run50 = "";
	$table_item_run50R = "";
	$table_item_run70 = "";
	$app_pg50RU = "";
	$app_pg50RC = "";
	if( $mode_call == 'table_item_run30' ) $table_item_run30 = 'on';
	else if( $mode_call == 'table_item_run50' ) $table_item_run50 = 'on';
	else if( $mode_call == 'table_item_run50R' ) $table_item_run50R = 'on';
	else if( $mode_call == 'table_item_run70' ) $table_item_run70 = 'on';
	else if( $mode_call == 'app_pg50RU' ) $app_pg50RU = 'on';
	else if( $mode_call == 'app_pg50RC' ) $app_pg50RC = 'on';

	if( $mode=='') {	
		if( isset($pop_table) ) $_SESSION['old_pop_tab']= $pop_table;
		else $_SESSION['old_pop_tab'] = "";
		$sqlPG = "select * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
		$resultPG = sql_query($sqlPG);
		if( $resultPG ) {
			$rsPG = sql_fetch_array($resultPG);
			$tab_enm	=$rsPG['tab_enm'];
			$tab_hnm	=$rsPG['tab_hnm'];
			$item_cnt	=$rsPG['item_cnt'];
			$item_array=$rsPG['item_array'];
			$tab_enm_pop=$rsPG['tab_enm'];
			$tab_hnm_pop=$rsPG['tab_hnm'];
			$group_code	=$rsPG['group_code'];
			$group_name	=$rsPG['group_name'];
			$pg_code	=$rsPG['pg_code'];
			$pg_name	=$rsPG['pg_name'];
			if( isset($rsPG["if_type"]) ) {
					$if_typeD = $rsPG["if_type"]; 
					$ff = explode("|", $if_typeD );
					$if_type  = $ff;
			} else {
					$if_typeD = "";
					$if_type  = "";
			}
			if( isset($rsPG["if_data"]) ) {
					$if_dataD = $rsPG["if_data"]; 
					$dd = explode("|", $if_dataD );
					$if_data  = $dd;
					$if_TabS = $dd[$ln];
					$pop_tabS = $dd[$ln];
			} else {
					$if_dataD = "";
					$if_TabS = "";
					$pop_tabS = "";
			}
			$pg_codeS = $rsPG['pg_code'] . ":" . $rsPG['pg_name'];
			$tab_hnmS = $rsPG['tab_enm'] . ":" . $rsPG['tab_hnm'];
			$tab_hnm  = $rsPG['tab_hnm'];
			if( isset( $rsPG['pop_data'] ) ){
				$popup_data	= $rsPG['pop_data'];
				$item_popA = explode( "^", $popup_data . ", ln:" . $ln);
				if( isset( $item_popA[$ln]) ) {
					$item_pop  = $item_popA[$ln];
					$pdata     = explode("@", $item_pop); //m_(" item_pop-".$ln. ": ". $item_pop[$ln]);
					$col_ = explode("@", $item_array);
					$move_col = explode( "$", $pdata[0] ); //m_("mv_col:$mv_col ");//mv_col:$fld_1:상품명|fld_3:제품명$fld_8:재고|fld_4:수량 
					$Column_movable = movable_func( $move_col );  //m_(" Column_movable: " . $Column_movable); // Column_movable: ->, ->, 
					$pdata_cnt = count( $pdata); //m_(" pdata_cnt: " . $pdata_cnt); 7
					$pop_move_data = $pdata[0];
					$pop='@'; 
					for( $i=1; $i< $pdata_cnt-1; $i++) $pop = $pop . $pdata[$i]."@";
					$pdata1         = $pop; //$pdata[1];
					$item_array_pop = $pop; // add
					if( isset( $pop_tabS) ) {
						$ifT = explode(":", $pop_tabS ); //$dd[$ln]
						$tab_enm_pop    = $ifT[0]; //m_("tab_enm_pop: " . $tab_enm_pop);
						$pop_table      = $ifT[0]; //m_("tab_enm_pop: " . $tab_enm_pop);
						$Colnm	= $col_[$if_line];
						$ColnmA = explode("|", $Colnm); //$dd[$ln]
						$Column_name	= $ColnmA[2];
					} else {
						$tab_enm_pop    = "";
						$pop_table      = "";
						$Colnm	= "";
						$Column_name	= "";
					}
				} else {
					m_("pop none ==============");
					$item_pop  = "";
					$pdata1      = "";
					$Column_name	= "";
				}
			} else {
				$col_ = explode("@", $item_array);
				$Colnm	= $col_[$if_line];
				$ColnmA = explode("|", $Colnm); //$dd[$ln]
				$Column_name	= $ColnmA[$ln];
				$Column_movable ='';
				$popup_data	= "";
			}
		}
	} else {  // mode == '' 아니다		
			if( isset($_POST['tab_enm_pop']) ) $tab_enm_pop = $_POST['tab_enm_pop'];
			else $tab_enm_pop = "";
			if( isset($_POST['tab_hnm_pop']) ) $tab_hnm_pop = $_POST['tab_hnm_pop'];
			else $tab_hnm_pop = "";
			if( isset($_POST['tab_hnmS']) ) $tab_hnmS = $_POST['tab_hnmS'];
			else $tab_hnmS = "";
			if( isset($_POST['tab_hnm']) ) $tab_hnm = $_POST['tab_hnm'];
			else $tab_hnm = "";
			if( isset($_POST['tab_enm']) ) $tab_enm = $_POST['tab_enm'];
			else $tab_enm = "";
			if( isset($_POST['item_cnt']) ) $item_cnt = $_POST['item_cnt'];
			else $item_cnt = 0;
			if( isset($_POST['item_array']) ) {
				$item_array = $_POST['item_array'];
				$col_ = explode("@", $item_array);
			} else $item_array = "";
			// 277|fld_1|상품k|CHAR|20@275|fld_2|작업공정K|CHAR|10@276|fld_3|작업자k|CHAR|10@278|fld_4|생산수량|TINYINT|3@279|fld_5|메모k|TEXT|200@
			if( isset($_POST['sellist']) ) $sellist  = $_POST['sellist'];		// 선택한 컬럼. 팝업에 적용할 컬럼.//sellist:277|fld_1|상품|CHAR|20
			else $sellist  = 0;
			if( isset($_POST['if_line']) ) $if_line  = $_POST['if_line'];		//m_("if_line: " . $if_line); //if_line: 2
			else $if_line  = 0;
			if( isset($_POST["move_pop_data"]) ) $move_pop_data = $_POST["move_pop_data"];
			else  $move_pop_data ="";
			if( isset($_POST['popup_data']) ) $popup_data	= $_POST['popup_data'];
			else  $popup_data ="";
			if( isset($_POST['if_TabS']) ) $if_TabS	= $_POST['if_TabS'];
			else  $if_TabS ="";
			if( isset($_POST['item_pop']) ) $item_pop   = $_POST['item_pop'];
			else  $item_pop ="";
			if( isset($_POST['pdata1']) ) $pdata1     = $_POST['pdata1'];
			else  $pdata1 ="";
			$item_array_pop = $pdata1; // add
	}
		/* --------- 중요. 분류 한다. ------------------------------
		// pop_data : $fld_1:상품명|fld_3:제품명$fld_8:재고|fld_4:수량@fld_1:상품명@fld_2:규격@fld_3:원가@fld_4:판매가@fld_5:구분@fld_6:거래처@fld_8:재고@
		// 배열[0]은:컬럼이동정보저장.-컬럼구분자는 '$'이고 영문컬럼구분자는 '|' 이다. 
		// 배열[1]...은: 팝업창에 사용되는 컬럼정보이다.
		// $dt[0] -> $fld_1:상품명|fld_1:상품$fld_4:판매가|fld_3:단가
		-------------------------------------------------------*/
		/*
		'@'로 분류한다. 0:다시 $로 분류한다 = 컬럼 이동식이다. 1:부터 컬럼 목록이다.
		pop_dataA:$fld_1:상품명|fld_3:제품명$fld_8:재고|fld_4:수량
		@fld_1:상품명@fld_2:규격@fld_3:원가@fld_4:판매가
		@fld_5:구분@fld_6:거래처@fld_8:재고@ 
		*/
	if( $mode =="ResetPOP") {	// $pop_tabS ){
		if( isset($pop_tabS) && $pop_tabS !=='' ) {
			$pop_ = explode(":", $pop_tabS);
			$tab_enm_pop = $pop_[0];
			$tab_hnm_pop = $pop_[1];
		} else {
			$tab_enm_pop = '';
			$tab_hnm_pop = '';
		}
		$pop_table   = ""; //$pop_[0];	//  reset 시에 처리한다. 중요
	} else if( $mode =="SearchTAB" ) {
		$pop_ = explode(":", $pop_tabS);
		$tab_enm_pop = $pop_[0];	
		$tab_hnm_pop = $pop_[1];
		$pop_table   = ""; //$pop_[0];	처음 팝업 테이블 선택시에 set 한다 중요.
	} else if( $mode =="Save_End" ) {
		m_('============= 사용 되지 않는다? Save_End 확인 테스트, mode: ' + $mode ); // 확인필요...
		if( isset($if_data[$if_line]) ) $pop_table	    = $if_data[$if_line];	
		else $pop_table	    = "";	
		$move_pop_data	= $_POST["move_pop_data"];
	} else { // 팝업이 설정되지않은 상테에서 처음 실행할때 탄다.
		if( $mode_call=="app_pg50RC" || $mode_call=="app_pg50RU" ){ // add 2023-09-12 : if 추가 else 이전 까지  - 테스트 미완성 중요.
			$ln	= $if_line + 1;
			$type_[$ln] = '13'; // 13:popup column으로 설정.
			$item_cnt = $_POST['item_cnt'];	
			$if_type = "";
			for( $i=0; $i< $item_cnt; $i++ ) {
				if( isset($type_[$i]) ) $if_type = $if_type . $type_[$i] . "|";
				else $if_type = $if_type . "|";
			}
			$if_typeD = $if_type;
		} else {
			$ln	= $if_line + 1;
			$type_ = explode("|", $if_typeD ); // $if_typeD=rsPG['if_type'] 
			if( $type_[$ln] !== '13') m_("Reset to column using popup window."); // 팝업창을 사용하는 컬럼으로 재설정합니다.
			$type_[$ln] = '13'; // 13:popup column으로 설정.
			$if_type = '';
			for( $i=0; $i< $item_cnt; $i++ ) {
				if( isset($type_[$i]) ) $if_type = $if_type . $type_[$i] . "|";
				else $if_type = $if_type . "|";
			}
			//m_("if_type: " . $if_type); // if_type: ||13|||||
			$if_typeD = $if_type;
		}
	}
		$pop_col = array();
		$pg_col  = array();
		$pop_fld = array();
		$pop_win_col = array();
	if( isset($pop_table) && $pop_table !=="" && $mode !== "SearchTAB" ) { 
		$pop_tabS = $if_TabS;
		$idata_ = explode(":", $if_TabS);
		$tab_enm_pop = $idata_[0];	// table hnm	//$pop_tab_enm;	 // SearchTAB
		$tab_hnm_pop = $idata_[1];	// table enm 
		$dt = $pdata;			//explode("@", $pop_data); //$pdata
		$tab_col = explode( "$", $dt[0] );  // m_("dt[0]:".$dt[0]); //dt[0]:$fld_1:product|fld_1:id$fld_4:price|fld_3:price
		$tab_col_cnt = count($tab_col);     // array 크기? count($tab_col); //m_("tab_col_cnt:".$tab_col_cnt); // tab_col_cnt:3
		for( $k=1; $k<$tab_col_cnt; $k++ ){ // m_(" tab_col k: ".$k. ", " . $tab_col[$k]); 
			$pt_col = explode("|", $tab_col[$k]); // m_(" pt_col 0: ". $pt_col[0]. ", 1:" . $pt_col[1]);
			$pp_col = explode(":", $pt_col[0]);   // m_("pt_col[0] pp_col 0:".$pp_col[0].", 1:".$pp_col[1]); 
			$pop_win_col[$k] = $pp_col[1];
		}
		$sellist_tab1 = ''; // popup column list 저장용.
		$item_array_pop = '@';
		for( $i=1, $j=0; isset($dt[$i]) && $dt[$i] != ""; $i++, $j++ ) {	
			$pcol = explode(":", $dt[$i]);
			array_push( $pop_fld, $pcol );
			$item_array_pop =  $item_array_pop . $pcol[0] . ":" . $pcol[1] . "@";
			$col_col='white';
			for( $k=1; $k<$tab_col_cnt; $k++ ){
				if( isset($pop_win_col[$k]) && isset($pcol[1]) && $pop_win_col[$k] == $pcol[1] ) $col_col = 'cyan';
			}
			$sellist_tab1 = $sellist_tab1 . "<label id='columnRX".$j."' style='background-color:".$col_col.";'  title='".$pcol[0].":".$pcol[1]."' onclick='sellist_pop_onclickTT(" .$j. " )'><input type='radio' id='sellist_tab1".$j."' name='sellist_tab1' value='".$pcol[0].":".$pcol[1]."'  onclick='sellist_pop_onclickT(this.value, ".$j.");' title='".$pcol[0].":".$pcol[1]."'><label id='columnR" .$j. "'>".$pcol[1]." </label></label><br>";
		}
		$mv_col = $dt[0];// [0]:컬럼이동정보-컬럼구분자는 '$'이고  팝업과 프로그램의 컬럼구분자는 '|' 이다.
		$pop_move_data = $dt[0];
		$move_col = explode( "$", $mv_col ); //m_("mv_col:$mv_col ");//mv_col:$fld_1:상품명|fld_3:제품명$fld_8:재고|fld_4:수량 
		$Column_movable = "";
		for( $i=1, $j=0; isset($move_col[$i]) && $move_col[$i] !== ""; $i++, $j++ ) {
			$pc = $col_[$j];						//m_("col_ : $j:" . $pc);
			$pg_col_ = explode("|", $col_[$j]);		//m_("col_ : $j:" . $pc . ", pg_col_:" . $pg_col_[1] );
			$col1 = $move_col[$i];					// m_("i:$i col1:$col1 ");// 1번컬럼이동 정보. 0번은 없다 배열1번부터 컬럼이 존재한다. $dta[1]->fld_1:상품명|fld_1:상품
			$mcol = explode("|", $col1);
			$pop_col1 = explode(":", $mcol[0]);
			array_push($pop_col, $pop_col1);
			$pg_col1 = explode(":", $mcol[1]);
			array_push($pg_col, $pg_col1);					// $ppp = $pop_col[$j][1];
			$p0  = $pg_col[$j][0];		$p1  = $pg_col[$j][1];
			$pp1 = $pg_col_[1];			$pp2 = $pg_col_[2]; //m_("pg_col_[1]:$pp1 ,pg_col_[2]:$pp2 , p0:$p0, p1:$p1");
			$Column_movable = $Column_movable . $pop_col[$j][1] . "->";
			$Column_movable = $Column_movable . $pg_col[$j][1] . ", ";	
		}
		$move_col_cnt = $i-1;
	} else { // 팝업테이블이 없고, 팝업 테이블을 선택하면 여기를 탄다. $pop_table none $mode =="SearchTAB" $_REQUEST['pop_tab'] = NULL
		$sql = "select * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enm_pop' order by tab_hnm";
		$result = sql_query($sql);
		$i=0;
		$pdata1 = '@';
		$sellist_tab1 = "";
		while($rsP = sql_fetch_array($result)) { // popup table column
			if( $rsP['fld_enm'] =='seqno' ) continue;
			else if( $rsP['fld_type'] =='TEXT' ) continue;// 숫자 와 문자 컬럼만 팝업창에 사용할 수 있게 한다.
			else if( $rsP['fld_type'] =='DATE' ) continue;
			else if( $rsP['fld_type'] =='DATATIME' ) continue;
			else if( $rsP['fld_type'] =='TIMESTAMP' ) continue;
			$sellist_tab1 = $sellist_tab1 . "<label id='columnRX".$i."' style='background-color:white;' title='".$rsP['fld_enm'].":".$rsP['fld_hnm']."' onclick='sellist_pop_onclickTT(" .$i. " )'><input type='radio'  id='sellist_tab1".$i."' name='sellist_tab1' value='".$rsP['fld_enm'].":".$rsP['fld_hnm']."' onclick='sellist_pop_onclickT(this.value, ".$i.");' title='".$rsP['fld_enm'].":".$rsP['fld_hnm']."'><label id='columnR" .$i. "'>".$rsP['fld_hnm']." </label></label><br>";
			$pdata1 = $pdata1 . $rsP['fld_enm']. ":" . $rsP['fld_hnm'] . "@"; 
			$i++;
		}//while
		$item_cnt_pop = $i;
		$item_array_pop = $pdata1; 
	}
	$pg_  = explode(":", $pg_codeS);
	$tab_ = explode(":", $tab_hnmS);
	$fld_ = explode("|", $sellist);
	if ( !$pg_name ) {
			$url="./";	//$PHP_SELF;
			echo("<meta http-equiv='refresh' content='0; URL=$url'>");
		exit;
	}
	$sqlPG = "select * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	$resultPG = sql_query($sqlPG);
	$table10_pg = sql_num_rows($resultPG);
	if( $table10_pg ) {
		$rsPG = sql_fetch_array($resultPG);
		$itype = explode("|", $rsPG['if_type']);
		$idata = explode("|", $rsPG['if_data']);
		$itp = $itype[$if_line+1];
		if( $itp == "11" ) {
			$idt = $idata[$if_line+1];
			$cl = explode(":", $idt);
		} else {
		}
	} else m_("no found - table_popupRM.php - table10_pg:" .$table10_pg. " - pg_name:" . $pg_name);
?>
<link href="./include/css/admin_style1.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0">
<SCRIPT language=JavaScript src="./include/js/board_func.js"></SCRIPT>
<script language="JavaScript"> 
<!--

	function sellist_pop_onclickTT( j ){
		document.makeform.pop_tab1_click.value = j;
		ss = document.getElementById('sellist_tab1'+j).value;
		document.getElementById('sellist_tab1'+j).checked=true;
	}
	function sellist_pop_onclickT(v, pop_click_col) { // pop_click_col:6, v:fld_8:stock
		document.makeform.pop_tab1_click.value = pop_click_col;
	}
	function sellist_tab2_onclick(click_col) { // pg table click
		if( click_col < 0 ) {// \n 프로그램의 컬럼을 선택하세요! 
			alert(' Please select the program column!');
			return false;
		}
		var i = click_col;
        document.makeform.pg_tab2_click.value = click_col;
		pop_tab_no = document.makeform.pop_tab1_click.value;
		if( pop_tab_no == ''){ // \n 팝업 테이블의 컬럼을 선택하세요! 
			alert(' Please select a column in the popup table!');
			return false;
		}
		var fld1e = document.getElementById('sellist_tab1'+pop_tab_no).value;
		fld1ex = fld1e.split(":");
		var fld1h = fld1ex[1];
		var k = click_col;
		var fld2e = document.getElementById('sellist_tab2'+click_col).value;//pg_tab
		fld2ex = fld2e.split(":");
		var fld2h = fld2ex[1]; 
	}
	function popup_confirm() { 
		makeform.mode.value="table_popup_save";
		makeform.action="table_popupRM.php";
		makeform.submit();
	}
	function Back_func( $mode_call ) {
		pg_codeS = makeform.pg_codeS.value;
		pcd = makeform.project_code.value;
		pnm = makeform.project_name.value;
		tcd = makeform.tab_enm.value;
		tnm = makeform.tab_hnm.value;
		tnmS= makeform.tab_hnmS.value;
		pcdnm = pcd + ":" + pnm;
		makeform.mode.value= "SearchPG"; 
		makeform.action= $mode_call + ".php";
		makeform.submit();
	}
	function create_after_run(pg_codeS, tab_hnmS){
		document.makeform.mode.value		= "SearchPG"; 
		document.makeform.target		='runf_main';
		document.makeform.action		="table_pg70.php";
		document.makeform.submit();
	}
	function save_end_run(mode, pop_tabS, if_line, move_pop_data){
		document.makeform.if_line.value = if_line; 
		pg_code = document.makeform.pg_code.value; 
		document.makeform.move_pop_data.value=move_pop_data;
		pcd = makeform.project_code.value;
		pnm = makeform.project_name.value;
		tcd = makeform.tab_enm.value;
		tnm = makeform.tab_hnm.value;
		tnmS= makeform.tab_hnmS.value;
		pcdnm = pcd + ":" + pnm;
		tabsel = pop_tabS.split(":");
		document.makeform.tab_enm_pop.value=tabsel[0];
		document.makeform.tab_hnm_pop.value=tabsel[1];
		old_pop_tab = document.makeform.old_pop_tab.value;
		document.makeform.mode.value = ''; //Save_End
		document.makeform.action="table_popupRM.php?pg_code=" + pg_code+'&if_line='+if_line+'&pop_tab='+old_pop_tab;
		document.makeform.submit();
	}
	function Reset_func(a){
		document.makeform.mode.value = "ResetPOP";
		if_line = document.makeform.if_line.value; 
		resp = confirm(' Would you like to reset pop-up data removable?');
		if( !resp ) return false;
		else {
			document.makeform.reset.value = 'on';
			pg_code = document.makeform.pg_code.value;
			if_line = document.makeform.if_line.value;
			poptab = document.makeform.pop_tabS.value;
			tabsel = poptab.split(":");
			document.makeform.Column_movable.value = "";
			document.makeform.pop_move_data.value = "";
			document.makeform.if_TabS.value = "";	//document.makeform["if_data[" + if_line + "]"].value = "";
			document.makeform.action="table_popupRM.php";
			document.makeform.submit();
		}
	}
	function popup_move(){ // apply
		var pop_tabS = makeform.pop_tabS.value;
		if( !pop_tabS){
			alert(' Select a table column in the popup window! pop_tabS=' + pop_tabS);
			return false;
		}
        var i = document.makeform.pop_tab1_click.value;
        var j = document.makeform.pg_tab2_click.value;
		if( i < 0 ) {
			alert(' Select a table column in the popup window! i:'+i);
			return false;
		}
		if( j < 0 ) {// \n 프로그램의 컬럼을 선택하세요! 
			alert(' Please select the program  column! j:'+j);
			return false; //makeform.sellist_tab2.focus();
		}
		var fld1e = document.getElementById('sellist_tab1'+i).value;//pop_tab
		fld1ex = fld1e.split(":");
		var fld1h = fld1ex[1];
		var fld2e = document.getElementById('sellist_tab2'+j).value;// pg_tab
		fld2ex = fld2e.split(":");
		var fld2h = fld2ex[1];
		pop_tab = pop_tabS.split(":");
		pop_move_data = document.makeform.pop_move_data.value;
		document.makeform.pop_move_data.value = pop_move_data + "$" + fld1e + "|" + fld2e;
		Column_movable = document.makeform.Column_movable.value;
		document.makeform.Column_movable.value = Column_movable + fld1h + "->" + fld2h + ' , ';
		return false; 
	}
	function pop_table_func(tab, if_line) {
		reset = document.makeform.reset.value;
		document.makeform.if_TabS.value = tab;
		const ln = if_line*1 + 1; // 중요. 계산은 *1 해야만 값이 계산된다. 안그러면 if_line이 1이면 11로 계산된다. 스크립트 버그?
		var if_DD = '';
		var DD = document.makeform.if_dataD.value; 
		var if_D = DD.split("|");
		var len = if_D.length - 1; // 컬럼수를 맞춰야한다. 중요. 8 , 7
		if_D[ln] = tab;
		for( i=0; i< len; i++) {
			if_DD = if_DD + if_D[i] + "|";
		}
		document.makeform.if_dataD.value = if_DD;
		document.makeform.mode.value='SearchTAB';
		tabsel = tab.split(":");
		document.makeform.tab_enm_pop.value=tabsel[0];
		document.makeform.tab_hnm_pop.value=tabsel[1];
		document.makeform.action="table_popupRM.php"; 
		document.makeform.target='_self';
		document.makeform.submit();
	}
	function downItemA() {
		var j = document.makeform.pop_tab1_click.value;
		if ( j < 0 ){	// column 선택 확인.
			alert(' Please select a column! ' );
			return false;
		}
		var colnm = document.getElementsByName('column_list');
		var colnm_value='';
		var len = colnm.length;

		var tmpValue, tmpText

		var top_line = 0;
		var end_line = len -1;
		if (j == end_line ) { // down		//if (j == top_line ) { // up
			alert('top_line j:' + j);
			return false; // down은 마지막 컬럼이면 return false
		}
		if (j < 0 ) {
			alert(' Please select a column! ' );
			return false;
		}
		tmpiftype = document.makeform.iftypeA.value; // 선택한 컬럼의 다음 컬럼 백업.
		tmpifdata = document.makeform.ifdataA.value; //alert( 'st --- D:' +tmpifdata + ' , T:'+tmpiftype );
		ifT = tmpiftype.split('|'); 
		ifD = tmpifdata.split('|');
		var stT = '';
		var stD = '';
		for (k = 0; k < colnm.length; k++) {
			if(k == j){
				bufT = ifT[k+1]; // 백업
				bufD = ifD[k+1];
				ifT[k+1] = ifT[j];       //val:|0|13|11|0
				ifD[k+1] = ifD[j]; 
				ifT[j] = bufT;
				ifD[j] = bufD;
			}
		}
		for (k = 0; k < colnm.length; k++) {
			stT = stT + ifT[k] + '|';
			stD = stD + ifD[k] + '|';
		}
		document.makeform.iftypeA.value = stT;
		document.makeform.ifdataA.value = stD;
			i = j*1 +1;
			tmpValueJ = colnm[j].value;
			tmpValueI = colnm[i].value;	
			document.getElementById('column_list'+j).value = tmpValueI;
			document.getElementById('column_list'+i).value = tmpValueJ;
			tmpValueJ = document.getElementById('column_list'+j).value;
			tmpValueI = document.getElementById('column_list'+i).value;
		var str_array = '';
		for( k = 0; k < colnm.length; k++) {
			colnm_value = colnm[k].value;
			st = colnm_value.split('|'); 
			str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
			document.getElementById('columnR'+k).innerHTML = st[2];
		}
		document.makeform.item_array.value = str_array;
		document.makeform.item_arrays.value = str_array; 
		document.getElementById('column_list'+i).checked=true;
		document.makeform.pop_tab1_click.value = i; // click point set
	}
	//----------------------------------------------
	function upItemA() {
		var j = document.makeform.pop_tab1_click.value;
		if ( j < 0 ){
			alert(' Please select a column! ' );
			return false;
		}
		var colnm = document.getElementsByName('column_list');
		var colnm_value='';
		var len = colnm.length;
		var tmpValue, tmpText
		var top_line = 0;
		var end_line = len -1;
		if ( j == top_line ) {
			alert('top_line j:' + j);
			return false;
		}
		if (j < 0 ) {
			alert(' Please select a column! ' );
			return false;
		}
			tmpiftype = document.makeform.iftypeA.value; 
			tmpifdata = document.makeform.ifdataA.value;
			ifT = tmpiftype.split('|'); 
			ifD = tmpifdata.split('|');  
		var stT = '';
		var stD = '';
		for( k = 0; k < colnm.length; k++) {
			if( k == j){
				bufT = ifT[k-1]; 
				bufD = ifD[k-1];
				ifT[k-1] = ifT[j]; 
				ifD[k-1] = ifD[j]; 
				ifT[k] = bufT; 
				ifD[k] = bufD;
			}
		}
		for (k = 0; k < colnm.length; k++) {
			stT = stT + ifT[k] + '|';
			stD = stD + ifD[k] + '|';
		}
		document.makeform.iftypeA.value = stT;
		document.makeform.ifdataA.value = stD;
			i = j*1 -1; // up
			tmpValueJ = colnm[j].value;
			tmpValueI = colnm[i].value;
			document.getElementById('column_list'+j).value = tmpValueI;
			document.getElementById('column_list'+i).value = tmpValueJ;
			tmpValueJ = document.getElementById('column_list'+j).value;
			tmpValueI = document.getElementById('column_list'+i).value;

		var str_array = '';
		for (k = 0; k < colnm.length; k++) {
			colnm_value = colnm[k].value;
			st = colnm_value.split('|'); 
			str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
			document.getElementById('columnR'+k).innerHTML = st[2];
		}
		document.makeform.item_array.value = str_array;
		document.makeform.item_arrays.value = str_array; // display:none
		document.getElementById('column_list'+i).checked=true;
		document.makeform.pop_tab1_click.value = i; // click point set
	} 
	function del_func() {
		var pg = document.makeform.pg_codeS.value;
		var tab = document.makeform.tab_hnmS.value;
		if( !tab || !pg) {
			alert(' Please select a table or program! ' );
			return false;
		}
		var j = document.makeform.pop_tab1_click.value;
		if( j == '' ) {
			alert(' Please select a column! ' );
			return false;
		}
		var colnm = document.getElementsByName('sellist_tab1');
		colnm_value = colnm[j].value;	
		st = colnm_value.split(':'); // st:fld_8:stock
		resp = confirm(' Are you sure you want to exclude columns? j:'+j+':'+st[1]); // \n 컬럼을 제외 하시겠습니까?
		if( !resp ) return false; 
		var item_cnt_pop = colnm.length;
		var end_line = colnm.length-1;
		var colnm_value='';
		var str_array="";
		var chk = 0;
		var pop = makeform.item_array_pop.value;	

		for(var i=0, j=1; i < colnm.length; i++, j++){
				colnm_value = colnm[i].value;
			if( colnm[i].checked ){
				if( i == end_line ){
					//document.makeform.column_name_change.value = '';
				} else {
					colnm[i].checked=false;
				}
				chk = 1;
			}
			if( chk == 1){
				if( i == end_line ){ // 마지막 라인이면 다음번째 가져올 컬럼이 없다.
				} else {
					colnm_value = colnm[j].value; // 선택한컬럼의 다음번째 컬럼을 가져온다.
					document.getElementById('sellist_tab1'+i).value = colnm_value; // pop_tab
					st = colnm_value.split(':');
					document.getElementById('columnR'+i).innerHTML = st[1];// 컬럼명출력.
				}
			}
		}
		var kk = item_cnt_pop -1;
		document.makeform.item_cnt_pop.value = kk;
		document.getElementById('sellist_tab1'+kk).value = '';
		document.getElementById('columnRX'+kk).innerHTML = ''; // 컬럼 label 출력화면에서 제거..
		document.makeform.pop_tab1_click.value = '';
		var str_array = '';
		for( k = 0; k < kk; k++) {
			colnm_value = colnm[k].value;
			st = colnm_value.split(':'); 
			str_array += st[0] + ':' + st[1] + '@';
		}
		makeform.item_array_pop.value = str_array; // display:none
		makeform.pdata1.value = str_array; // Add 2022-02-18     display:none
		return;
	}
	function rr_func( ss ){
		here.innerHTML = ss;
	}
//-->
</script>
<?php
	$w='100%';
	$w2='360';
	if( isset($_POST['reset']) ) $reset = $_POST['reset'];
	else $reset = "";
?>
<center>
PopUp Window Column Setup <font color='gray'>(user lev:<?=$H_LEV?>)</font>
<div id='menu_normal'>
   <table cellspacing='0' cellpadding='4' width='<?=$w2?>' border='1' class="c1">
		<FORM name="makeform" method="post" >
			<input type="hidden" name="mode"		value="" >
			<input type="hidden" name="reset"		value="<?=$reset?>" >
			<input type="hidden" name="mode_call"	value="<?=$mode_call?>" >
			<input type="hidden" name="pop_tab"	    value="<?=$pop_table?>">
			<input type="hidden" name="tab_enm_pop"	value="<?=$tab_enm_pop?>">
			<input type="hidden" name="tab_hnm_pop"	value="<?=$tab_hnm_pop?>">
			<input type="hidden" name="pg_codeS"	value="<?=$pg_codeS?>"> 
			<input type="hidden" name="tab_hnmS"	value="<?=$tab_hnmS?>">
			<input type="hidden" name="sellist"		value="<?=$sellist?>">
			<input type="hidden" name="if_line"		value="<?=$if_line?>">
			<input type='hidden' name='if_column'   value="<?=$if_column?>" >
			<input type="hidden" name="item_cnt"	value="<?=$item_cnt?>">
			<input type="hidden" name="item_array"	value="<?=$item_array?>">
			<input type="hidden" name="tab_enm"		 value="<?=$tab_enm?>">
			<input type="hidden" name="pg_code"         value="<?=$pg_code?>">
			<input type="hidden" name="project_code"  value="<?=$project_code?>">
			<input type="hidden" name="project_name"  value="<?=$project_name?>">
			<input type="hidden" name="group_code"	    value="<?=$group_code?>">
			<input type="hidden" name="group_name"	  value="<?=$group_name?>">
			<input type="hidden" name='move_pop_data' value="<?=$move_pop_data?>" > 
			<input type="hidden" name='pop_tab1_click' value='' > 
			<input type="hidden" name='pg_tab2_click'   value='' > 
			<input type="hidden" name='project_nmS'   value='<?=$project_nmS?>' > 
  <tr>
    <td height="30" align="center" style="border-style:;background-color:#666666;color:cyan;"  >
	Program Name:
	<input type='text' name='pg_name' value='<?=$pg_[1]?>' style="border-style:;background-color:#666666;color:yellow;" readonly>
	<br>&nbsp;&nbsp;&nbsp;&nbsp;Column Name:
	<input type='text' name='Column_name' value='<?=$Column_name?>' style="border-style:;background-color:#666666;color:yellow;" readonly>
	<input type='hidden' name='tab_hnm' value='<?=$tab_[1]?>' style="border-style:;background-color:#666666;color:yellow;" readonly>&nbsp;&nbsp;
  </tr>
			<tr>
               <td width="200" valign="top" align="center">
				  <div id='menu_normal'>
                    <table width="200" border="1" cellspacing="0" cellpadding="0">
					   <tr>      <!-- Table 1(작업순서) \n 1:팝업테이블의 컬럼을선택 \n 2:프로그램의 컬럼을 선택 \n 3:컬럼적용버턴을 클릭 -->
                              <td valign="top" align="right" width="100%">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
								  <tr>
                                    <td align="center" <?php echo" title=' Work Order \n 1: Select a column in the pop-up table \n 2: Select a column in the program \n 3: Click the Apply Column button'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:160px; height:20px;">
									Popup Window</b>
									<br>
			<select id='pop_tabS' name='pop_tabS' onchange="pop_table_func(this.value, '<?=$if_line?>');" style="border-style:;background-color:#666666;color:yellow;width:160px; height:24px;" <?php echo" title='".$_POST['pop_tabS']."' "; ?> >
<?php 
				if( $mode=='SearchTAB' || $mode=='ResetPOP' ) {
?>
						<option value="<?php echo $pop_tabS ?>"  selected ><?php echo $tab_hnm_pop ?> </option>
<?php
				} else {
?>
						<option value=''>Select Popup Table</option>
<?php
				}
				$result = sql_query( "select tab_enm, tab_hnm from {$tkher['table10_table']} where userid='$H_ID' and group_code='$group_code' and fld_enm='seqno' order by upday desc" );
				while( $rs = sql_fetch_array($result)) { // popup table list
?>
						<option value='<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>' <?php echo" title='Table code:".$rs['tab_enm']. ", " .$rs['tab_hnm']."' "; ?> 
						<?php if( $rs['tab_enm']==$tab_enm_pop ) echo " selected "; ?> ><?=$rs['tab_hnm']?></option>
<?php
				}
?>
			</select>
									<br>
									</td>
								  </tr>
                                  <tr>
                                     <td valign="top">
	<div id="here">
<?php
	echo "<script> rr_func(\"".$sellist_tab1."\");</script> "; // popup table column print
?>
	</div>
                                     </td>
                                   </tr>
                            </table>
                          </td>
						   <td align="center" width="60" style="border-style:;background-color:#661666;color:yellow;">
                              <table cellspacing="0" cellpadding="0" width="60" align="center" border="0" style="border-style:;background-color:#661666;color:yellow;">
								<tr>
								<td></td>
                                  <td align="middle">
									<input type='button' name='run' title='Column Apply' onClick="popup_move()" value='Apply' style="border-style:;background-color:#666666;color:yellow;width:50px;height:50px;">
                                  </td>
								  <td></td>
                                </tr>
                             </table>
                           </td>
                              <td valign="top" align="right" width="300">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tr>
                                    <td bgcolor="#666666" height="30" align="center"><font color="#FFFFFF">
									Program Window</font>
									<input type='text' name='tab_hnm' value='<?=$tab_[1]?>' style="border-style:;background-color:#666666;color:yellow;width:140px;height:24px" readonly>
									<br>
									</td>
                                  </tr>
                                  <tr>
                                     <td valign="top">
<?php
	$pg_col_chk=0;
	for( $i=0; isset($col_[$i]) && $col_[$i] != '';$i++) {
		$_col = explode("|", $col_[$i]);		//_col 1:".$_col[1].", 2:".$_col[2]. ", 3:".$_col[3] );
		for( $j=0; isset($pg_col[$j]) && $pg_col[$j][0]!=""; $j++ ){
			if ( $pg_col[$j][0]==$_col[1] ) $pg_col_chk=1;
			else $pg_col_chk=0;
		}
		if( $pg_col_chk==1) {
			echo "<label style='background-color:cyan;'><input type='radio' id='sellist_tab2".$i."' name='sellist_tab2' value='".$_col[1].":".$_col[2]."' onClick='sellist_tab2_onclick($i)' title='".$_col[1]."'> ".$_col[2]." </label><br>";
		}else{
			echo "<label style='background-color:white;'><input type='radio' id='sellist_tab2".$i."' name='sellist_tab2' value='".$_col[1].":".$_col[2]."' onClick='sellist_tab2_onclick($i)' title='".$_col[1]."'> ".$_col[2]." </label><br>";
		}
	}
	if( $mode == 'table_popup_save' ){
		$pdata1 = "";
		$if_typeD = $_POST['if_typeD'];
		$if_dataD = $_POST['if_dataD'];
		$item_array_pop = $_POST['item_array_pop'];	
		$pop_move_data = $_POST['pop_move_data'];
		$pdata1 = $_POST['pdata1'];
		$move_pop_data = $pop_move_data . $pdata1; 
		$pd1 = explode("^", $_POST['popup_data']);
		$pd1_cnt = count( $pd1 ); 
		$item_cnt = $_POST['item_cnt'];
		$ppd1 = "";
		for( $i=0; $i< $item_cnt; $i++){
			if( $i == $ln ) $ppd1 = $ppd1 . $move_pop_data . "^";  // new data change
			else {
				if( isset($pd1[$i]) && $pd1[$i] !=='' ) $ppd1 = $ppd1 . $pd1[$i] . "^";
				else $ppd1 = $ppd1 . "^";
			}
		}
		$popup_data = $ppd1;
		$pop_tabS = $_POST['pop_tabS'];
		if( isset($table10_pg) ) {
			$query= "UPDATE {$tkher['table10_pg_table']} SET if_type='$if_typeD', if_data='$if_dataD', pop_data='$popup_data' WHERE pg_code='$pg_code' ";
			$ret = sql_query($query);
		}
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
			<td height="24">
			Column movable:<br><input id='Column_movable' name='Column_movable' value='<?=$Column_movable?>' style='width:600px;background-color:cyan;' readonly>
			<br><input id='pop_move_data' name='pop_move_data' value='<?=$pop_move_data?>' style='width:600px;background-color:cyan;display:none;' readonly>
			<input id='if_typeD' name='if_typeD' value='<?=$if_typeD?>' style="width:600px;display:none;" readonly>
			<input id='if_dataD' name='if_dataD' value='<?=$if_dataD?>' style="width:600px;display:none" >
			<input id='if_TabS' name='if_TabS' value='<?=$if_TabS?>' style="width:600px;display:none;" >
			<textarea id='item_pop' name='item_pop' rows='3' style="width:600px;display:none;" ><?=$item_pop?></textarea>
			<textarea id='pdata0' name='pdata0' rows='3' style="width:600px;display:none;" ><?=$pdata[0]?></textarea>
			<textarea id='pdata1' name='pdata1' rows='3' style="width:600px;display:none;" ><?=$pdata1?></textarea>
			<textarea id='item_array_pop' name='item_array_pop' rows='3' style="width:600px;display:none;" readonly><?=$item_array_pop?></textarea>
			<textarea id='popup_data' name='popup_data' rows='3' style="width:600px;display:none;" ><?=$popup_data?></textarea>
						</td>
					  </tr>
					<tr>
						<td align="center" >
							<input type='button' value='Save' onClick="popup_confirm()" style="cursor:hand;" <?php echo "title=' Save the removable.' ";?> \>
							&nbsp;&nbsp;&nbsp;
							<input type='button' value='Reset' onClick="Reset_func('ResetPOP')" <?php echo "title=' Reset the removable.' ";?> \> 
							&nbsp;&nbsp;&nbsp;
							<input type='button' value='Back' onClick="Back_func('<?=$mode_call?>')" <?php echo "title=' Reset the removable.' ";?> \> 
						</td>
                    </tr>
	</table>
	<input type="hidden" name="item_cnt_pop"	value="<?=$item_cnt_pop?>">
	<input type="hidden" name="mode_session"	value="POPUP">
	<input type="hidden" name="iftype_db"	value="<?=$if_typeD?>">
</form>
<?php
if( $mode == 'table_popup_save' ){
	if( $table_item_run30 == 'on' ) {
		$url = "table_pg30.php";
	} else if( $table_item_run50R == 'on' ) {
		set_session('pg_codeS',  $pg_codeS);
		$url = "table_pg50R.php";
	} else if( $table_item_run70 == 'on' ) {
		set_session('pg_codeS',  $pg_codeS);
		$url = "table_pg70.php";
	} else if( $app_pg50RU == 'on' ) {
		set_session('pg_codeS',  $pg_codeS);
		$url = "app_pg50RU.php";
	} else if( $app_pg50RC == 'on' ) {
		set_session('pg_codeS',  $pg_codeS);
		$url = "app_pg50RC.php";
	}
	echo "<script>save_end_run('Save_End','$pop_tabS','$if_line','$move_pop_data');</script>";	
}
function movable_func( $move_col ){
		$Column_movable = "";
		for( $i=1; isset($move_col[$i]) && $move_col[$i] != ""; $i++) {
			$col1 = $move_col[$i];
			$mcol = explode("|", $col1);
			$pop_col1 = explode(":", $mcol[0]);
			$pg_col1 = explode(":", $mcol[1]); 
			$Column_movable = $Column_movable . $pop_col1[1] . "->";
			$Column_movable = $Column_movable . $pg_col1[1] . ", ";	
		}
		return $Column_movable;
}
?>
</body>
</html>
