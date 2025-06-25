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

	if( isset($_POST['pop_tab']) ) $pop_table= $_POST['pop_tab']; // 팝업에 사용할 테이블 정보. dao_1644457087:상품
	else $pop_table = "";

	if( isset($_POST["if_line"]) ) {
		$if_line = $_POST["if_line"]; 
		$ln = $if_line+1;	  
	} else {
		$if_line = "";
		$ln = 0;
	}

	if( isset($_POST["if_column"]) ) $if_column = $_POST["if_column"]; 
	else $if_column = "";

	m_("86-- pop_table: $pop_table");

	//m_("pg_codeS: " . $pg_codeS . ", mode: " . $mode . ", pg_code:" . $pg_code );
	//pg_codeS: solpakanA_naver_1750725555:pg_T1, mode: , pg_code:solpakanA_naver_1750725555
	//pg_codeS: solpakanA_naver_1750757298:tab_tpC, mode: , pg_code:solpakanA_naver_1750757298
	//m_("group_code: ".$group_code . ", if_line: " . $if_line); 
	//group_code: solpakanA_naver_1750725492, if_line: 1

	$tab_enm_pop = "";
	$tab_hnm_pop = "";

	//m_("table_popupR, mode: $mode, mode_call: ".$mode_call); // table_popupR, mode: SearchTAB, mode_call: app_pg50RU

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
		m_("113 - mode: " . $mode . ", pop_table: $pop_table");//113 - mode: , pop_table: 

		//110 - mode: , pg_code: solpakanA_naver_1750757298
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
m_("-- $pop_tabS, line: $if_line, ln: $ln"); //-- , line: 1, ln: 2
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
					//m_( "item_popA: ", $item_popA . ", ln:" . $ln);
			} else {
				m_("rsPG none , item_array: $item_array");
				//rsPG none , item_array: |fld_1|fld1|VARCHAR|15@|fld_2|fld2|VARCHAR|15@|fld_3|fld3|VARCHAR|15@|fld_4|fld4|INT|12@|fld_5|fld5|INT|12@|fld_6|fld6|INT|12@
				$col_ = explode("@", $item_array);
				$Colnm	= $col_[$if_line];
				$ColnmA = explode("|", $Colnm); //$dd[$ln]
				$Column_name	= $ColnmA[$ln];
				$Column_movable ='';
				m_("Column_name: $Column_name");

				$popup_data	= "";
			}

			//m_($if_dataD . ", " . $popup_data . ", " . $if_typeD);
			//|||현금:어음:수표:||, ^$fld_1:거래처명|fld_1:거래처@fld_1:거래처명@fld_2:대표자@fld_3:전화@fld_4:이메일@fld_5:매출총액@fld_6:수금총액@fld_7:미수총액@^^^^, |13|0|1|0|
												//pop_tabS: dao_1644457087:상품, pop_data: ^^^$fld_1:상품명|fld_3:상품명$fld_5:판매가|fld_5:판매가@fld_1:상품명@fld_2:규격@fld_3:재고수량@fld_4:단가@fld_5:판매가@^^^^
													//item_pop-3: $fld_1:상품명|fld_3:상품명$fld_5:판매가|fld_5:판매가@fld_1:상품명@fld_2:규격@fld_3:재고수량@fld_4:단가@fld_5:판매가@
		}

	} else {  // mode == '' 아니다		
		//m_( "mode: ". $mode . ", pg_code: " . $pg_code); // pg_code = dao_1644457338
		//mode: table_popup_save, pg_code: solpakanA_naver_1750725555
		m_("211 - mode: " . $mode . ", pop_table: $pop_table");//110 - mode: , pg_code: solpakanA_naver_1750757298

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

	//m_("if_line:$if_line, move_pop_data:$move_pop_data"); //if_line:0, move_pop_data: 데이터가 널 이다.

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
	m_("272 - mode: " . $mode . ", pop_table: $pop_table, pop_tabS: $pop_tabS");
	//265 - mode: ResetPOP, pop_table: , pop_tabS: 
	//265 - mode: , pop_table: solpakanA_naver_1750755894, pop_tabS: solpakanA_naver_1750755894:tab_tpB
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
		//m_( $mode . ", pop_tabS:" . $pop_tabS . ", pop_table:" . $pop_table . ", ln: " . $ln); //SearchTAB, pop_tabS:dao_1744229654:testCCC, pop_table:dao_1744229654, ln: 3

	} else if( $mode =="Save_End" ) {
		m_('============= 사용 되지 않는다? Save_End 확인 테스트, mode: ' + $mode ); // 확인필요...
		if( isset($if_data[$if_line]) ) $pop_table	    = $if_data[$if_line];	
		else $pop_table	    = "";	
		$move_pop_data	= $_POST["move_pop_data"];
		//$pop_data	    = $move_pop_data;
	} else { // 팝업이 설정되지않은 상테에서 처음 실행할때 탄다.
		//$pop_table		= $if_data[$if_line];	// 팝업에 사용할 테이블 정보. dao_1538180041:상품정보
		//$pop_table		= $_REQUEST['pop_tab'];	// $_REQUEST['pop_tab']은 NULL 이다. 팝업에 사용할 테이블 정보. dao_1538180041:상품정보
		//$tab_enm_pop = "";
		//$tab_hnm_pop = "";
		//m_( "mode:" .$mode. ", mode_call: " . $mode_call); // mode:, mode_call: app_pg50RU
		// mode:, mode_call: app_pg50RU
		
		if( $mode_call=="app_pg50RC" || $mode_call=="app_pg50RU" ){ // add 2023-09-12 : if 추가 else 이전 까지  - 테스트 미완성 중요.
			$ln	= $if_line + 1;
			$type_[$ln] = '13'; // 13:popup column으로 설정.
			$item_cnt = $_POST['item_cnt'];	
			$if_type = "";
			for( $i=0; $i< $item_cnt; $i++ ) {
				if( isset($type_[$i]) ) $if_type = $if_type . $type_[$i] . "|";
				else $if_type = $if_type . "|";
			}
			//m_( "item_cnt: " . $item_cnt . ", if_type: " . $if_type); // item_cnt: 5, if_type: |||13|| 
			//item_cnt: 6, if_type: ||13||||
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
	m_("320 - mode: " . $mode . ", pop_table: $pop_table, pop_tabS: $pop_tabS, if_TabS: $if_TabS");
	//320 - mode: , pop_table: solpakanA_naver_1750755894, pop_tabS: solpakanA_naver_1750755894:tab_tpB

	//m_( " pg_name: ". $pg_name . ", pg_codeS: " . $pg_codeS . ", tab_hnmS: " . $tab_hnmS . ", sellist: ". $sellist. ", if_line: ". $if_line);
	//pg_name: 외상매출정보, pg_codeS: dao_1644457338:외상매출정보:dao_1644457338:외상매출정보:dao_1544062597:ETC, tab_hnmS: dao_1644457338:외상매출정보, sellist: |fld_3|상품명|CHAR|15, if_line: 2

	//mv_col:$fld_1:상품명|fld_3:제품명$fld_8:재고|fld_4:수량 

	//m_( "mode: " . $mode . " - pop_table: " . $pop_table); // mode:  - pop_table: dao_1644457087

		$pop_col = array();
		$pg_col  = array();
		$pop_fld = array();
		$pop_win_col = array();

	if( isset($pop_table) && $pop_table !=="" && $mode !== "SearchTAB" ) { 
		
		// $pop_table is not null, popup table이 설정 된경우다. popup table 선택할때는 타지 않는다.
		
		m_("A--- pop_table: " . $pop_table); //A--- pop_table: solpakanA_naver_1750755894
		//1, iftype: 13, if_data: solpakanA_naver_1750755894:tab_tpB

		$pop_tabS = $if_TabS;
		$idata_ = explode(":", $if_TabS);
		$tab_enm_pop = $idata_[0];	// table hnm	//$pop_tab_enm;	 // SearchTAB
		$tab_hnm_pop = $idata_[1];	// table enm 

		//product, 		//$fld_1:product|fld_1:id		//$fld_4:price|fld_3:price		//@fld_1:product@fld_2:standard@fld_3:cost@fld_4:price@
		//$pdata = explode("@", $item_pop[$ln]); //m_(" item_pop-".$ln. ": ". $item_pop[$ln]);

		//--------------------- add 2021-09-24 --- 팝업창에 사용된 컬럼을 축출 생성한다. 사용된컬럼에 배경색 cyan을 설정하기위해.
		$dt = $pdata;			//explode("@", $pop_data); //$pdata
		$tab_col = explode( "$", $dt[0] );  // m_("dt[0]:".$dt[0]); //dt[0]:$fld_1:product|fld_1:id$fld_4:price|fld_3:price
		$tab_col_cnt = count($tab_col);     // array 크기? count($tab_col); //m_("tab_col_cnt:".$tab_col_cnt); // tab_col_cnt:3
		for( $k=1; $k<$tab_col_cnt; $k++ ){ // m_(" tab_col k: ".$k. ", " . $tab_col[$k]); 
			$pt_col = explode("|", $tab_col[$k]); // m_(" pt_col 0: ". $pt_col[0]. ", 1:" . $pt_col[1]);
			$pp_col = explode(":", $pt_col[0]);   // m_("pt_col[0] pp_col 0:".$pp_col[0].", 1:".$pp_col[1]); 
			$pop_win_col[$k] = $pp_col[1];
		}
        //--------------------- $item_array_pop 생성부분 ----
		$sellist_tab1 = ''; // popup column list 저장용.

		$item_array_pop = '@';

		for( $i=1, $j=0; $dt[$i] != ""; $i++, $j++ ) {	

			$pcol = explode(":", $dt[$i]);
			array_push( $pop_fld, $pcol );
			$item_array_pop =  $item_array_pop . $pcol[0] . ":" . $pcol[1] . "@";
			
			$col_col='white';

			for( $k=1; $k<$tab_col_cnt; $k++ ){
				if( $pop_win_col[$k] == $pcol[1] ) $col_col = 'cyan';
			}
			//m_(" pop_win_col $i:" . $pop_win_col[$i]. ", pcol-1:" . $pcol[1] . "" . $col_col );

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

			//// 화면에 보여질 팝업데이터 이동 내용
				$Column_movable = $Column_movable . $pop_col[$j][1] . "->";
				$Column_movable = $Column_movable . $pg_col[$j][1] . ", ";	
		}
		//m_("Column_movable:$Column_movable");//nmxh:상품명-제품명, 재고-수량, 
		$move_col_cnt = $i-1;
	} else { // 팝업테이블이 없고, 팝업 테이블을 선택하면 여기를 탄다. $pop_table none $mode =="SearchTAB" $_REQUEST['pop_tab'] = NULL

		//m_("pop_table: " . $pop_table . ", pop_tab: " . $_REQUEST['pop_tab']);
		// popup table 선택시에 탄다. table_select
		$sql = "select * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enm_pop' order by tab_hnm";
		$result = sql_query($sql);

		$i=0;
		$pdata1 = '@';
		$sellist_tab1 = "";
		while($rsP = sql_fetch_array($result)) { // popup table column

			if( $rsP['fld_enm'] =='seqno' ) continue;
			//else if( $rsP['fld_type'] =='CHAR' ) continue;
			//else if( $rsP['fld_type'] =='VARCHAR' ) continue;
			else if( $rsP['fld_type'] =='TEXT' ) continue;// 숫자 와 문자 컬럼만 팝업창에 사용할 수 있게 한다.
			else if( $rsP['fld_type'] =='DATE' ) continue;
			else if( $rsP['fld_type'] =='DATATIME' ) continue;
			else if( $rsP['fld_type'] =='TIMESTAMP' ) continue;

			$sellist_tab1 = $sellist_tab1 . "<label id='columnRX".$i."' style='background-color:white;' title='".$rsP['fld_enm'].":".$rsP['fld_hnm']."' onclick='sellist_pop_onclickTT(" .$i. " )'><input type='radio'  id='sellist_tab1".$i."' name='sellist_tab1' value='".$rsP['fld_enm'].":".$rsP['fld_hnm']."' onclick='sellist_pop_onclickT(this.value, ".$i.");' title='".$rsP['fld_enm'].":".$rsP['fld_hnm']."'><label id='columnR" .$i. "'>".$rsP['fld_hnm']." </label></label><br>";

			//alert('str_array:' +str_array);//str_array:277|fld_1|상품|CHAR@275|fld_2|작업공정K|CHAR@276|fld_3|작업자k|CHAR@279|fld_5|메모|TEXT@
			$pdata1 = $pdata1 . $rsP['fld_enm']. ":" . $rsP['fld_hnm'] . "@"; // 2022-02-18 add
			$i++;
		}//while
		$item_cnt_pop = $i;
		$item_array_pop = $pdata1; // 2021-09-26 add
	}
	$pg_  = explode(":", $pg_codeS);
	$tab_ = explode(":", $tab_hnmS);
	$fld_ = explode("|", $sellist);
	if ( !$pg_name ) {
			$url="./";	//$PHP_SELF;
			echo("<meta http-equiv='refresh' content='0; URL=$url'>");
		exit;
	}

//	$sqlPG = "select * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_name='$pg_name' ";
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
			//m_("222--- $itp, $idt, $cl[0], $cl[1]");//222--- 11, fld_4 = fld_2 * fld_2:금액 = 수량 * 단가, fld_4 = fld_2 * fld_2, 금액 = 수량 * 단가
		} else {
			//my_msg("222 --- $itp: else --- $if_line, $idt ");//222 --- : else --- 3,  
		}
	} else m_("no found - table_popupRM.php - table10_pg:" .$table10_pg. " - pg_name:" . $pg_name);
?>
<link href="./include/css/admin_style1.css" rel="stylesheet" type="text/css">

<body leftmargin="0" topmargin="0">

<SCRIPT language=JavaScript src="./include/js/board_func.js"></SCRIPT>
<script language="JavaScript"> 
<!--
	
	/*
	function run_pg_list(pg)
	{
		pg_name = document.makeform.pg_name.value;
		if( !pg_name ) {
			alert("Choose a program!"); // 프로그램을 선택하세요!
			document.makeform.pg_name.focus();
			return false;
		}

		var str_array = makeform.pop_data.value + '@';	//팝업 테이블.
		var item_cnt = makeform.sellist_tab1.options.length;	 // table item 수.

		for (i = 0; i < item_cnt; i++) {
			var str_val = makeform.sellist_tab1.options[i].value;
			var str_txt = makeform.sellist_tab1.options[i].text;
			st = str_val.split(":");
			//str_array += st[0] + '|' + st[1] + '|' + st[2] +  '|' + st[3]+  '|' + st[4] + '@';	// seqno+enm + hnm + type + len
			//컬럼 순서변경, 컬럼명칭 변경, 컬럼 조건및 조건데이터 처리 에따른 item_array 재생성. 2018-09-11
			//str_array = str_array + st[0] + '|' + st[1] + '|' + str_txt + '|' + st[3]+ '|' + st[4] + '@';	// seqno+enm + hnm + type + len
			str_array = str_array + st[0] + ':' + st[1] + '@';	// seqno+enm + hnm + type + len
		} 
		//alert( ' str_array:' + str_array );
		//item_cnt:14, 658|fld_1|성명|CHAR|10@659|fld_2|전화|CHAR|15@660|fld_3|메일|CHAR|20@661|fld_4|아이디|CHAR|10@662|fld_5|주소|CHAR|200@664|fld_7|직업|CHAR|100@665|fld_8|취미|CHAR|20@666|fld_9|첨부화일|CHAR|200@667|fld_10|학력|CHAR|20@668|fld_11|종교|CHAR|20@669|fld_12|생일일시|DATE|20@670|fld_13|결혼|CHAR|20@671|fld_14|메모|CHAR|200@|undefined||undefined|undefined@

		document.makeform.item_array.value = str_array;
		document.makeform.action='tab_list_pg70.php';
		document.makeform.target='tab_pg_list';
		document.makeform.submit();
	}*/

	//---- sellist_pop_onclickT(ss,j)와 동일함. 타이틀 라벨을 클릭시에 사용. 중요.
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
		var fld2h = fld2ex[1]; //alert(pop_click + ': pop fld1e:'+fld1e+ ' , pg fld2e:' + fld2e);
	}

	function popup_confirm() { // save
		makeform.mode.value="table_popup_save";
		makeform.action="table_popupRM.php";
		makeform.submit();
	}
	// add : 2021-09-26
	function Back_func( $mode_call ) {
		pg_codeS = makeform.pg_codeS.value;
		pcd = makeform.project_code.value;
		pnm = makeform.project_name.value;

		tcd = makeform.tab_enm.value;
		tnm = makeform.tab_hnm.value;
		tnmS= makeform.tab_hnmS.value;
		
		pcdnm = pcd + ":" + pnm;
		makeform.mode.value= "SearchPG"; //"POPSearchPG"; //"SearchPG";
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
		//// ?pg_code=dao_1644457338&pop_tab=dao_1644457087&if_line=2 상품:dao_1644457087, 거래처:dao_1644456532

		//document.makeform.mode.value = mode; //Save_End
		document.makeform.if_line.value = if_line; 
		pg_code = document.makeform.pg_code.value; 
		document.makeform.move_pop_data.value=move_pop_data;

		pcd = makeform.project_code.value;
		pnm = makeform.project_name.value;

		tcd = makeform.tab_enm.value;
		tnm = makeform.tab_hnm.value;
		tnmS= makeform.tab_hnmS.value;
		
		pcdnm = pcd + ":" + pnm;
		
		//alert( 'pg:' +pg_code + ', tnmS: '+tnmS +', pcd:' + pcd + ', pnm:' + pnm); // pg:dao_1633396679, tnmS: , pcd:9999, pnm:출고
		//pg:dao_1633396679, tnmS: , pcd:9999, pnm:출고

//			document.makeform.target		='_self';
		tabsel = pop_tabS.split(":");
		document.makeform.tab_enm_pop.value=tabsel[0];
		document.makeform.tab_hnm_pop.value=tabsel[1];
		old_pop_tab = document.makeform.old_pop_tab.value;
		//var ln = if_line + 1;
		document.makeform.mode.value = ''; //Save_End
		document.makeform.action="table_popupRM.php?pg_code=" + pg_code+'&if_line='+if_line+'&pop_tab='+old_pop_tab;

		document.makeform.submit();
	}

	function Reset_func(a){
		document.makeform.mode.value = "ResetPOP";
		if_line = document.makeform.if_line.value; //alert('if_line:'+if_line);  // \n 팝업데이터 이동식을 다시 설정 하시겠습니까?
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
//			document.makeform.action="table_popupRM.php?pg_code="+pg_code+'&if_line='+if_line;
			document.makeform.action="table_popupRM.php";
//			document.makeform.target='_self';
			document.makeform.submit();
		}
	}
	//-----------------------------
	function popup_move(){ // apply
		var pop_tabS = makeform.pop_tabS.value;
		if(!pop_tabS){// \n 팝업창의 테이블 컬럼을 선택하세요! 
			alert(' Select a table column in the popup window! pop_tabS=' + pop_tabS);
			return false;
		}
        var i = document.makeform.pop_tab1_click.value;
        var j = document.makeform.pg_tab2_click.value;

		if( i < 0 ) {// \n 팝업창의 컬럼을 선택하세요! 
			alert(' Select a table column in the popup window! i:'+i);
			return false; //makeform.sellist_tab1.focus();
		}
		if( j < 0 ) {// \n 프로그램의 컬럼을 선택하세요! 
			alert(' Please select the program  column! j:'+j);
			return false; //makeform.sellist_tab2.focus();
		}

		var fld1e = document.getElementById('sellist_tab1'+i).value;//pop_tab
		fld1ex = fld1e.split(":");
		var fld1h = fld1ex[1];	//alert(': pop tab fld1e:'+fld1e);

		var fld2e = document.getElementById('sellist_tab2'+j).value;// pg_tab
		fld2ex = fld2e.split(":");
		var fld2h = fld2ex[1];	//alert(': pg tab fld2e:'+fld2e);

		pop_tab = pop_tabS.split(":");
		//alert('팝업창의 Table:' + pop_tab[1] + '의 컬럼 ' + fld1ex[1] + '을 프로그램 컬럼 ' + fld2ex[1] +'으로 적용합니다.' );
		// \n 팝업창의 Table:' + pop_tab[1] + '의 컬럼 ' + fld1ex[1] + '을 프로그램 컬럼 ' + fld2ex[1] +'로 적용합니다.
		//alert('Connect the column name ' + fld1ex[1] + ' of Table ' + pop_tab[1] + ' of the popup window to the column name ' + fld2ex[1] +' of the program.');

		pop_move_data = document.makeform.pop_move_data.value;
		document.makeform.pop_move_data.value = pop_move_data + "$" + fld1e + "|" + fld2e;

		Column_movable = document.makeform.Column_movable.value;
		document.makeform.Column_movable.value = Column_movable + fld1h + "->" + fld2h + ' , ';
		//document.makeform.nmxh.value = nmxh + fld1h + '(' + fld1ex[0] + ")->" + fld2h + '(' + fld2ex[0] + ') , ';
		return false; 
	}

	function pop_table_func(tab, if_line) { // ?pg_code=dao_1644457338&pop_tab=dao_1644457087&if_line=2 상품:dao_1644457087, 거래처:dao_1644456532
		reset = document.makeform.reset.value;
		if( reset !== 'on') {
			//alert('Reset Please!'); //2023-09-22 막음. 필요 원인 미확인...
			//return false;
		}
		document.makeform.if_TabS.value = tab;

		const ln = if_line*1 + 1; // 중요. 계산은 *1 해야만 값이 계산된다. 안그러면 if_line이 1이면 11로 계산된다. 스크립트 버그?
		var if_DD = '';
		var DD = document.makeform.if_dataD.value; //alert('if_dataD: '+if_dataD);
		var if_D = DD.split("|");
		var len = if_D.length - 1; //alert('' + if_D.length + ', len: '+len); // 컬럼수를 맞춰야한다. 중요. 8 , 7

		if_D[ln] = tab; // 바로 대입하니 문제가 생긴다. const ln = if_line*1 + 1; 이렇게 계산하지않아서 문제생김.
		for( i=0; i< len; i++) {
			if_DD = if_DD + if_D[i] + "|";
		}
		document.makeform.if_dataD.value = if_DD;
		document.makeform.mode.value='SearchTAB';
		tabsel = tab.split(":");
		document.makeform.tab_enm_pop.value=tabsel[0];
		document.makeform.tab_hnm_pop.value=tabsel[1];

		document.makeform.action="table_popupRM.php"; //action="table_popupRM.php?pg_code="+pg_code+'&if_line='+if_line+'&pop_tab='+tabsel[0];
		document.makeform.target='_self';
		document.makeform.submit();
	}

	//----------------------------------------------
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

		ifT = tmpiftype.split('|');       //val:275|fld_2|작업공정|CHAR|10
		ifD = tmpifdata.split('|');       //val:275|fld_2|작업공정|CHAR|10
			
		var stT = '';
		var stD = '';
		for (k = 0; k < colnm.length; k++) {

			if(k == j){
				bufT = ifT[k+1]; // 백업
				bufD = ifD[k+1];

				ifT[k+1] = ifT[j];       //val:|0|13|11|0
				ifD[k+1] = ifD[j]; 
				
				ifT[j] = bufT; // 복구
				ifD[j] = bufD;
			}
		}
		for (k = 0; k < colnm.length; k++) {
			stT = stT + ifT[k] + '|';
			stD = stD + ifD[k] + '|';
		}
		document.makeform.iftypeA.value = stT;	//display:none
		document.makeform.ifdataA.value = stD;	//	alert( 'ed --- T:' +stT + ' , D:'+stD );

			i = j*1 +1; // down			//i = j*1 -1; // up			//alert( 'j:' +j +' : len:'+len + ', i:' + i);
			tmpValueJ = colnm[j].value;
			tmpValueI = colnm[i].value;	//alert( 'tmpValueJ:' +tmpValueJ + ' , tmpValueI:' +tmpValueI );

			document.getElementById('column_list'+j).value = tmpValueI;
			document.getElementById('column_list'+i).value = tmpValueJ;

			tmpValueJ = document.getElementById('column_list'+j).value;//colnm[j].value;
			tmpValueI = document.getElementById('column_list'+i).value;//colnm[i].value;

		var str_array = '';
		for (k = 0; k < colnm.length; k++) {
			colnm_value = colnm[k].value;	//alert( 'colnm_value:' +colnm_value);
			st = colnm_value.split('|');    //val:275|fld_2|작업공정|CHAR|10
			str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
			document.getElementById('columnR'+k).innerHTML = st[2];//컬럼 내용 화면출력.
		}
		document.makeform.item_array.value = str_array;
		document.makeform.item_arrays.value = str_array; // display:none
		document.getElementById('column_list'+i).checked=true;
		document.makeform.pop_tab1_click.value = i; // click point set
	}
	//----------------------------------------------
	function upItemA() {
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
		//if (j == end_line ) {
		if (j == top_line ) {
			alert('top_line j:' + j);
			return false; // down은 마지막 컬럼이면 return false
		}
		if (j < 0 ) {
			alert(' Please select a column! ' );
			return false;
		}

			tmpiftype = document.makeform.iftypeA.value; // 선택한 컬럼의 다음 컬럼 백업.
			tmpifdata = document.makeform.ifdataA.value; //alert( 'st --- D:' +tmpifdata + ' , T:'+tmpiftype );

			ifT = tmpiftype.split('|');       //val:275|fld_2|작업공정|CHAR|10
			ifD = tmpifdata.split('|');       //val:275|fld_2|작업공정|CHAR|10
		var stT = '';
		var stD = '';
		for (k = 0; k < colnm.length; k++) {

			if(k == j){
				bufT = ifT[k-1]; // 백업
				bufD = ifD[k-1];

				ifT[k-1] = ifT[j];       //val:|0|13|11|0
				ifD[k-1] = ifD[j]; 
				
				ifT[k] = bufT; // 복구
				ifD[k] = bufD;
			}
		}
		for (k = 0; k < colnm.length; k++) {
			stT = stT + ifT[k] + '|';
			stD = stD + ifD[k] + '|';
		}
		document.makeform.iftypeA.value = stT;
		document.makeform.ifdataA.value = stD;	//	alert( 'ed --- T:' +stT + ' , D:'+stD );		//i = j*1 +1; // down
			i = j*1 -1; // up	//	alert( 'j:' +j +' : len:'+len + ', i:' + i);
			tmpValueJ = colnm[j].value;
			tmpValueI = colnm[i].value;	//alert( 'tmpValueJ:' +tmpValueJ + ' , tmpValueI:' +tmpValueI );

			document.getElementById('column_list'+j).value = tmpValueI;
			document.getElementById('column_list'+i).value = tmpValueJ;

			tmpValueJ = document.getElementById('column_list'+j).value;//colnm[j].value;
			tmpValueI = document.getElementById('column_list'+i).value;//colnm[i].value;

		var str_array = '';
		for (k = 0; k < colnm.length; k++) {
			colnm_value = colnm[k].value;		//alert( 'colnm_value:' +colnm_value);
			st = colnm_value.split('|');       //val:275|fld_2|작업공정|CHAR|10
			str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
			document.getElementById('columnR'+k).innerHTML = st[2];//컬럼 내용 화면출력.
		}
		document.makeform.item_array.value = str_array;
		document.makeform.item_arrays.value = str_array; // display:none
		document.getElementById('column_list'+i).checked=true;
		document.makeform.pop_tab1_click.value = i; // click point set
	} 
	//-------------------------------------------------------------------
	function del_func() {
		var pg = document.makeform.pg_codeS.value;
		var tab = document.makeform.tab_hnmS.value;
		if( !tab || !pg) {
			alert(' Please select a table or program! ' );
			return false;
		}
		//alert('tab:'+tab +', pg:'+pg);//tab:dao_1537753861:구매정보, pg:dao_1540779796:구매-C:dao_1537753861:구매정보:dddd:구매

		var j = document.makeform.pop_tab1_click.value;
		if( j == '' ) {
			alert(' Please select a column! ' );
			return false;
		}
		//var colnm = document.getElementsByName('column_list'); 
		var colnm = document.getElementsByName('sellist_tab1'); // pop_tab item_array_pop
		colnm_value = colnm[j].value;		//alert('colnm_value:'+colnm_value +', j:'+j); return; //colnm_value:fld_8:stock, j:6

		st = colnm_value.split(':'); // st:fld_8:stock

		resp = confirm(' Are you sure you want to exclude columns? j:'+j+':'+st[1]); // \n 컬럼을 제외 하시겠습니까?
		if( !resp ) return false; 

		//var item_cnt = makeform.column_list.options.length;	 // table item 수.

		var item_cnt_pop = colnm.length;
		var end_line = colnm.length-1;
		var colnm_value='';
		var str_array="";
		var chk = 0;
		var pop = makeform.item_array_pop.value;		//alert('pop:'+pop);

		for(var i=0, j=1; i < colnm.length; i++, j++){
				colnm_value = colnm[i].value;		//alert(i+':colnm_value:'+colnm_value);
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
				//alert(i+':st2:'+st[2]);
			}
			//alert('---item_cnt:'+item_cnt + ', i:' +i +':colnm_value:'+colnm_value);
		}
		
		var kk = item_cnt_pop -1;
		document.makeform.item_cnt_pop.value = kk;
		//fld_msg = document.getElementById('column_list'+kk).value
		//alert('kk:'+kk + ', item_cnt:' + item_cnt + ', end line fld msg:' + fld_msg);

		document.getElementById('sellist_tab1'+kk).value = '';
		document.getElementById('columnRX'+kk).innerHTML = ''; // 컬럼 label 출력화면에서 제거..
		document.makeform.pop_tab1_click.value = '';
		//------------------	

		var str_array = '';

		for (k = 0; k < kk; k++) {
			colnm_value = colnm[k].value;
			st = colnm_value.split(':');       //val:275|fld_2|작업공정|CHAR|10
			str_array += st[0] + ':' + st[1] + '@'; 	//str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
		}
		//alert('str_array:' +str_array);//str_array:277|fld_1|상품|CHAR@275|fld_2|작업공정K|CHAR@276|fld_3|작업자k|CHAR@279|fld_5|메모|TEXT@
		makeform.item_array_pop.value = str_array; // display:none
		makeform.pdata1.value = str_array; // Add 2022-02-18     display:none
		return;
	}
	//-------------------------
	//function rr_func( ss, qna ){
	function rr_func( ss ){
		//alert('rr:'+ ss );
		//if(!ss) r_func('A', qna);
		//else here.innerHTML = ss;
		here.innerHTML = ss;
	}

//-->
</script>


<?php
$w='100%';
$w2='360';
//alert : 올바른 방법으로 이용해 주십시오.
//m_("tab_hnmS:" . $tab_hnmS . ", pg_codeS:" . $_POST['pg_codeS'] ); //tab_hnmS:dao_1633396679:출고, pg_codeS:dao_1633396679:출고:dao_1633396679:출고:9999:출고
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
			<input type="hidden" name="pop_tab"	    value="<?=$pop_table?>"><!-- 2023-10-05 add -->
			<input type="hidden" name="tab_enm_pop"	value="<?=$tab_enm_pop?>">
			<input type="hidden" name="tab_hnm_pop"	value="<?=$tab_hnm_pop?>">
			<input type="hidden" name="pg_codeS"	value="<?=$pg_codeS?>">    <!-- pg_codeS 프로그램명. -->
			<input type="hidden" name="tab_hnmS"	value="<?=$tab_hnmS?>">    <!-- tab_hnmS -->

			<input type="hidden" name="sellist"		value="<?=$sellist?>"><!-- 컬럼. -->
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
	<!-- <font color=gray>(<?=$pg_[0]?>)</font> -->
	<br>&nbsp;&nbsp;&nbsp;&nbsp;Column Name:
	<input type='text' name='Column_name' value='<?=$Column_name?>' style="border-style:;background-color:#666666;color:yellow;" readonly>
	<input type='hidden' name='tab_hnm' value='<?=$tab_[1]?>' style="border-style:;background-color:#666666;color:yellow;" readonly>&nbsp;&nbsp;
	<!-- <font color=gray>(<?=$tab_[0]?>)</font> -->
	<!-- <br><font color='gray'>(user lev:<?=$H_LEV?>)</font> --></td>
  </tr>

			<tr>
               <td width="200" valign="top" align="center">
				  <div id='menu_normal'>
                    <table width="200" border="1" cellspacing="0" cellpadding="0">
					   <tr>            <!-- Table 1(작업순서) \n 1:팝업테이블의 컬럼을선택 \n 2:프로그램의 컬럼을 선택 \n 3:컬럼적용버턴을 클릭 -->
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
//					$result = sql_query( "select tab_enm, tab_hnm from table10 where userid='$H_ID' and fld_enm='seqno' order by tab_hnm" );
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
	echo "<script> rr_func(\"".$sellist_tab1."\");</script> "; // popup table 의 컬럼 리스트 출력.
?>
	</div>
                                     </td>
                                   </tr>

									<!-- (항목순서를 이동 및 삭제 합니다.) 막음... (항목순서를 위로 이동 합니다.) -->
                                    <!-- <tr>
                                     <td bgcolor="#666666" height="30">&nbsp;&nbsp; 
										<a href="javascript:downItem()" onFocus="this.blur()">
										<img style="CURSOR: hand" title="Move item order down." src="./bt_down_s01.gif" align="absMiddle" border="0"></a>
                                        <a href="javascript:upItem()" onFocus="this.blur()">
										<img style="CURSOR: hand" title="Move the order of items up." src="./bt_up_s01.gif" align="absMiddle" border="0"></a>
										<font color="#FFFFFF">Change
									</td>
                                  </tr>
								   <tr>
									 <td bgcolor="#666666" height="30">&nbsp;
										<a href="javascript:downItemA()">
										<img height="21" style="CURSOR: hand" title="Move column order down." src="./icon/bt_down_s01.gif"  border="0"></a>&nbsp;&nbsp;&nbsp;
										<a href="javascript:upItemA()" >
										<img height="21" style="CURSOR: hand" title="Move the order of column up." src="./icon/bt_up_s01.gif" border="0"></a>&nbsp;&nbsp;
										<a href="javascript:del_func()" >
										<img height="21" style="CURSOR: hand" src="./icon/e_delete.gif" border="0" <?php echo "title='Delete column\n No columns are used in the program.' ";?>></a>&nbsp;&nbsp;
									</td>
								  </tr> -->

                            </table>
                          </td>
						   <td align="center" width="60" style="border-style:;background-color:#661666;color:yellow;">
                              <table cellspacing="0" cellpadding="0" width="60" align="center" border="0" style="border-style:;background-color:#661666;color:yellow;">
								<tr>
								<td></td>
                                  <td align="middle"><!-- (컬럼을 적용합니다.) -->
									<input type='button' name='run' title='Column Apply' onClick="popup_move()" value='Apply' style="border-style:;background-color:#666666;color:yellow;width:50px;height:50px;">
                                  </td>
								  <td></td>
                                </tr>
                             </table>
                           </td>

                              <!-- 프로그램에서 사용할 Table -->
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
	for( $i=0; $col_[$i] != '';$i++) {
		$_col = explode("|", $col_[$i]); //m_($i . ":_col 1:".$_col[1].", 2:".$_col[2]. ", 3:".$_col[3] );//0:_col 1:fld_1, 2:상품k, 3:CHAR	//1:_col 1:fld_2, 2:작업공정K, 3:CHAR	//2:_col 1:fld_3, 2:작업자k, 3:CHAR	//3:_col 1:fld_4, 2:생산수량, 3:TINYINT 	//4:_col 1:fld_5, 2:메모k, 3:TEXT

		
//		for( $j=0; $pg_col[$j][0]!=""; $j++ ){
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
		$item_array_pop = $_POST['item_array_pop'];	//m_("item_array_pop:$item_array_pop");//$fld_1:상품명|fld_1:상품$fld_4:판매가|fld_3:단가@fld_1:상품명@fld_2:규격@fld_3:원가@fld_4:판매가@
		$pop_move_data = $_POST['pop_move_data'];	//m_(" pop_move_data: ". $pop_move_data ); //pop_move_data: $fld_1:상품명|fld_3:상품명$fld_5:판매가|fld_5:판매가
		$pdata1 = $_POST['pdata1'];		//m_(" pdata1: ". $pdata1 ); // pdata1: @fld_1:상품명@fld_2:규격@fld_3:재고수량@fld_4:단가@fld_5:판매가@
		$move_pop_data = $pop_move_data . $pdata1; // move_pop_data: $fld_1:상품명|fld_3:상품명$fld_5:판매가|fld_5:판매가@fld_1:상품명@fld_2:규격@fld_3:재고수량@fld_4:단가@fld_5:판매가@

		$pd1 = explode("^", $_POST['popup_data']); // POST popup_data: ^^^$fld_1:거래처명|fld_2:거래처@fld_1:거래처명@fld_2:대표자@fld_3:전화@fld_4:이메일@fld_5:매출총액@fld_6:수금총액@fld_7:미수총액@^^^^
		$pd1_cnt = count( $pd1 ); //m_("pd1_cnt: " .$pd1_cnt . ", ln: ".$ln); // pd1_cnt: 8, ln: 3
		$item_cnt = $_POST['item_cnt'];
		$ppd1 = "";
		for( $i=0; $i< $item_cnt; $i++){
			if( $i == $ln ) $ppd1 = $ppd1 . $move_pop_data . "^";  // new data change
			else {
				if( isset($pd1[$i]) && $pd1[$i] !=='' ) $ppd1 = $ppd1 . $pd1[$i] . "^";
				else $ppd1 = $ppd1 . "^"; // add 2025-06-25
			}
		}
		$popup_data = $ppd1; //m_("popup_data: " . $popup_data); //popup_data: ^^^$fld_1:상품명|fld_3:상품명$fld_5:판매가|fld_5:판매가@fld_1:상품명@fld_2:규격@fld_3:재고수량@fld_4:단가@fld_5:판매가@^^^^
		$pop_tabS = $_POST['pop_tabS'];	// 팝업 컬럼 매칭.

		if( isset($table10_pg) ) {
			$query= "UPDATE {$tkher['table10_pg_table']} SET if_type='$if_typeD', if_data='$if_dataD', pop_data='$popup_data' WHERE pg_code='$pg_code' ";
			$ret = sql_query($query);	//m_("Update OK ret: " . $ret);
		}
		/*else {
			$pg_code = $H_ID . '_' . time();
			$query= "INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$pg_code', pg_name='$pg_name', item_cnt=$item_cnt, item_array='$item_array', if_type='$iftype_db', if_data='$ifdata_db', userid='$H_ID', pop_data='$move_pop_data' ";
			$ret = sql_query($query);
			//m_("????????????? Insert OK ret: " . $ret);
		}*/

		// documet 전달 이 안된다... form 아래에 두니 된다
		//echo "<script>create_after_run( '$pg_codeS' , '$tab_hnmS' );</script>";	// documet 전달 이 안된다... form 아래에 두니 된다
		//$url = "table_popupRM.php?mode=SearchTAB";
		//echo("<meta http-equiv='refresh' content='0; URL=$url'>");
		//exit;
	} else {		//if( $mode == 'table_popup_save' )
	} //if $mode == 'table_popup'
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
			<td height="24"><!-- 컬럼이동식 -->
			Column movable:<br><input id='Column_movable' name='Column_movable' value='<?=$Column_movable?>' style='width:600px;background-color:cyan;' readonly>
			<!-- pop_move_data: --><br><input id='pop_move_data' name='pop_move_data' value='<?=$pop_move_data?>' style='width:600px;background-color:cyan;display:none;' readonly>
							
			<!-- if_typeD: --><input id='if_typeD' name='if_typeD' value='<?=$if_typeD?>' style="width:600px;display:none;" readonly><!-- 중요 -->
			<!-- if_dataD: --><input id='if_dataD' name='if_dataD' value='<?=$if_dataD?>' style="width:600px;display:none" ><!-- 중요-->
			<!-- if_TabS:<?=$ln?>: --><input id='if_TabS' name='if_TabS' value='<?=$if_TabS?>' style="width:600px;display:none;" >
			
			<!-- pop_data 원본:<textarea id='pop_data' name='pop_data' rows='3' style="width:600px;display:;" readonly><?=$pop_data?></textarea> -->
			
			<!-- item_pop <?=$ln?> ^: --><textarea id='item_pop' name='item_pop' rows='3' style="width:600px;display:none;" ><?=$item_pop?></textarea>

			<!-- pdata0 @: --><textarea id='pdata0' name='pdata0' rows='3' style="width:600px;display:none;" ><?=$pdata[0]?></textarea>

		<!-- pdata1 @ pop column list: --><textarea id='pdata1' name='pdata1' rows='3' style="width:600px;display:none;" ><?=$pdata1?></textarea>

			<!-- item_array_pop: --><textarea id='item_array_pop' name='item_array_pop' rows='3' style="width:600px;display:none;" readonly><?=$item_array_pop?></textarea>
			<!-- popup_data: --><textarea id='popup_data' name='popup_data' rows='3' style="width:600px;display:none;" ><?=$popup_data?></textarea><!-- 중요. -->
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
	<input type="hidden" name="iftype_db"	value="<?=$if_typeD?>"><!-- if_typeD , iftype_db:app_pg50RU 에서 사용 중요 2023-10-06 확인 -->

</form>

<?php
//m_("1169-- pg_codeS: $pg_codeS");//-- solpakanA_naver_1750757298:tab_tpC
//1169-- solpakanA_naver_1750725555:pg_T1
if( $mode == 'table_popup_save' ){

	if( $table_item_run30 == 'on' ) {
		$url = "table_pg30.php";		//echo "<script>window.open('$url', 'runf_main', '');</script>";
	} else if( $table_item_run50R == 'on' ) {
		set_session('pg_codeS',  $pg_codeS);
		$url = "table_pg50R.php";		//echo "<script>window.open('$url', '_top', '');</script>";
	} else if( $table_item_run70 == 'on' ) {
		set_session('pg_codeS',  $pg_codeS);
		$url = "table_pg70.php";		//echo "<script>window.open('$url', 'runf_main', '');</script>";
	} else if( $app_pg50RU == 'on' ) {
		set_session('pg_codeS',  $pg_codeS);
		$url = "app_pg50RU.php";		//echo "<script>window.open('$url', '_self', '');</script>";
	} else if( $app_pg50RC == 'on' ) {
		set_session('pg_codeS',  $pg_codeS);
		$url = "app_pg50RC.php";		//echo "<script>window.open('$url', '_self', '');</script>";
	}

	echo "<script>save_end_run('Save_End','$pop_tabS','$if_line','$move_pop_data');</script>";	
}
//my_msg("mode:$mode, iftype_db:$iftype_db, ifdata_db:$ifdata_db ");
//mode:table_popup, iftype_db:|13||||||, ifdata_db:|dao_1538180041:상품정보|||||| 
//mode:table_popup, iftype_db:||||11|||, ifdata_db:||||fld_4 = fld_2:수량 * fld_3:단가:금액 = 수량 * 단가||| 

//---------------------------------
function movable_func( $move_col ){	//m_("movable_func ---");
		$Column_movable = "";
		
		for( $i=1; isset($move_col[$i]) && $move_col[$i] != ""; $i++) { //for( $i=1, $j=0; $move_col[$i] != ""; $i++, $j++ ) {
			$col1 = $move_col[$i];				// 1번컬럼이동 정보. 0번은 없다 배열1번부터 컬럼이 존재한다. $dta[1]->fld_1:상품명|fld_1:상품
			//m_( $i . ", col1: " . $col1); 
			//0, col_: |fld_1|거래일자|DATETIME|15, col1: fld_1:상품명|fld_3:상품명
			//1, col_: |fld_2|거래처|CHAR|15, col1: fld_5:판매가|fld_5:판매가
			
			$mcol = explode("|", $col1);
			$pop_col1 = explode(":", $mcol[0]);	//array_push($pop_col, $pop_col1);
			$pg_col1 = explode(":", $mcol[1]);  //array_push($pg_col, $pg_col1); // $ppp = $pop_col[$j][1];
			$Column_movable = $Column_movable . $pop_col1[1] . "->";
			$Column_movable = $Column_movable . $pg_col1[1] . ", ";	
		}
		return $Column_movable;
}
//---------------------------------------------------------------------------------------
?>

</body>
</html>
