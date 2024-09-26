<?php
	include_once('./tkher_start_necessary.php');

	$ss_mb_id	= get_session("ss_mb_id");
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	/*
	 *  table_relationA.php Copy <- table_relationAM.php  : Multy Relationship Setup - 다중과계식 : 2022-02-15
	                         : Table Relation 정보만 저장한다.
							: A의 테이블에 데이터를 등록하면 X,Y,Z 의 3개의 테이블 까지 데이터를 'Insert' 또는 'Update' 한다.
							: Update 에는 반드시 Ket field를 설정해야한다.
							: {$tkher['table10_pg_table']} 테이블에 컬럼 'relation_type varchar(255)'이 추가 되었다.
	 *  table_relationA.php : Mobile용 프로그램. 2021-04-25
	    A테이블에 데이터를 등록하면 B테이블(Relation Table)에도 데이터를 등록한다.
		프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식
	 *  관계식에는 테이블이 처리될때마다 동일하게 처리되는 관계식과 프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식 두가지가 있다.
	 *  여기서는 후자에 속하는 프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식을 적용한다.
	    다중 관계식 처리 : table_relationAM.php : 2022-02-12 추가 생성.
	     call : kan_table_pg70.php
	 */
	if( !$H_ID || $H_LEV < 2 )
	{
		m_("Login please.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( $mode == 'Delete_Check' ){
		$item_array = $_POST['item_array'];
		$pg_codeS   = $_POST['pg_codeS'];
		$pg_code    = $_POST['pg_code'];
		$query="UPDATE {$tkher['table10_pg_table']} SET relation_data='', relation_type='' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) {
			my_msg("Complete the relationship. pg_code:".$pg_code);
		} else {
			my_msg("Program Delete error! ");
		}
		//echo "<script>delete_after_run( '$pg_codeS' , '$pg_code' );</script>"; 
		echo "<script>delete_after_run( '' , '$pg_code' );</script>"; 

	} else if( $mode == 'table_relation_save' ){

		$pg_code = $_POST['pg_code']; //dao_1644456532:거래처$fld_2:거래처|=|fld_1:거래처명$fld_6:외상매출액|=|fld_5:매출총액
		$relation_data_tab = $_POST['relation_data_tab'];
		$relation_type_key = $_POST['relation_type_key'];
		
		$query = "UPDATE {$tkher['table10_pg_table']} SET relation_type='$relation_type_key', relation_data='$relation_data_tab' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) {
			my_msg("Complete the relationship. pg_code:".$pg_code);
		} else {
			my_msg("Program UPDATE error! ");
		}
		//echo "<script>create_after_run( '$pg_codeS' , '$tab_hnmS' );</script>"; 
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>AppGeneratorSystem. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

<body leftmargin="0" topmargin="0">
<script language="JavaScript"> 
<!--
	function reset_confirm(){
		resp = confirm(' Would you like to reset relationship data removable?');
	
		if( !resp ) return false;
		else {
			makeform.mode.value='Reset_Check';
			makeform.relation_reset.value='on';
			makeform.relation_move_data.value='';
			makeform.relation_data.value='';
			makeform.relation_SQL_KeyD.value=''; // add 2022-02-14
			document.makeform.action="table_relationA.php";
			document.makeform.submit();
		}
		return;
	}
	function delete_confirm(){
		resp = confirm(' Would you like to Delete relationship data removable?');
	
		if( !resp ) return false;
		else {
			makeform.mode.value='Delete_Check';
			makeform.relation_reset.value='';
			makeform.relation_move_data.value='';
			makeform.relation_data.value='';
			document.makeform.action="table_relationA.php";
			document.makeform.submit();
		}
		return;
	}
	//---------------------------------------
	function init_relation( relation_data ) {
		alert('init_relation, relation_data: '+ relation_data);
		rel=relation_data.split('$');
		var hnmx2 = "";
		for( i=0; rel[i] !=""; i++ ){
			fld = rel[i];
			fff=fld.split('|');
			pg = fff[0];
			sik = fff[1];
			rt = fff[2];
			pg_fld=pg.split(':');
			fld_enm_pg = pg_fld[0];
			fld_hnm_pg = pg_fld[1];
			re_fld=rt.split(':');
			fld_enm_re = re_fld[0];
			fld_hnm_re = re_fld[1];			//상품=상품 , 수량=수량 , 수량+재고 , 일자=일자 , 
			hnmx2 = hnmx2 + fld_hnm_pg + sik + fld_hnm_re + " , "; 
		}
		makeform.relation_move_data.value = hnmx2;
		makeform.nmxh.value = hnmx2;
	}
	function relation_table_func(tab) {
		if( document.makeform.relation_reset.value=='on' ){
			makeform.relation_move_data.value='';
			makeform.relation_data.value='';
		}
		document.makeform.mode.value='SearchTAB';
		document.makeform.action="table_relationA.php";
		document.makeform.target='_self';
		document.makeform.submit();
	}
	//------------------------------------
	function change_relation_num_func(pg) {
		//alert('pg_ : '+pg + ', r data: ' + document.makeform.relation_data_tab.value ); //return;
		//pg_ : 1, r data: dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT@dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT@dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT

		R_type = document.makeform.relation_type_key.value.split('@');
		R_data = document.makeform.relation_data_tab.value.split('@');
		document.makeform.relation_SQL_KeyD.value = R_type[pg];	// + '-OK ' + pg;
		document.makeform.relation_data.value     = R_data[pg];	// + '-OK ' + pg;
		dd = eval( "document.makeform.relation_data_old_" + pg + ".value");
		//var fld2e = document.getElementById('sellist_tab2'+j).value;// pg_tab
		//alert( pg+', ' + dd);//2, dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT

		Rdata = dd.split('$');
		tab = Rdata[0]; // 0:table name
		document.makeform.tab_hnmS.value = Rdata[0];
		relation_table_func( tab );
		return;
	}
	//------------------------------------------------------ Program Select ---
	function change_program_func(pg) {
		pg_tag = pg.split('&'); // 0=pg_code:pg_name:tab_enm:tab_hnm, 1=relation_data, 2=item_array , 3=relation_type
		pg_tag[1] = pg_tag[1].replaceAll('undefined',''); //alert('relation_data_tab pg_tag 1]: '+pg_tag[1]);
		document.makeform.relation_data_tab.value= pg_tag[1]; //  1:relation data, 2:item_array, 3:relation_type
		pg_tag[3] = pg_tag[3].replaceAll('undefined',''); //alert('2 relation_type_key pg_tag 3]: '+pg_tag[3]);
		document.makeform.relation_type_key.value= pg_tag[3]; //  1:relation data, 2:item_array, 3:relation_type
		R_key = pg_tag[3].split('@');
		document.makeform.relation_SQL_KeyD.value= R_key[0]; //  1:relation data, 2:item_array, 3:relation_type

		//alert( ' r data: ' + document.makeform.relation_data_tab.value );
		//r data: dao_1644456532:거래처$fld_2:수금액|+|fld_6:수금총액:INT$fld_2:수금액|-|fld_7:미수총액:
		//alert( ' pg_tag[1]: ' + pg_tag[1] );
		//pg_tag[1]: dao_1644456532:거래처$fld_2:수금액|+|fld_6:수금총액:INT$fld_2:수금액|-|fld_7:미수총액:INT

		$rdata = pg_tag[1].split('@');		//alert('rdata length: '+ $rdata.length);
		document.makeform.relation_data_old_0.value = $rdata[0];
		document.makeform.relation_data_old_1.value = $rdata[1];
		document.makeform.relation_data_old_2.value = $rdata[2];

		//alert( ' pg_tag[3]: ' + pg_tag[3] ); // pg_tag[3]: Update:fld_1:fld_1:CHAR

		$rtype = pg_tag[3].split('@');
		document.makeform.relation_key_old_0.value = $rtype[0];
		document.makeform.relation_key_old_1.value = $rtype[1];
		document.makeform.relation_key_old_2.value = $rtype[2];
		document.makeform.item_array.value = pg_tag[2];// pg_tag[2] = item_array
		document.makeform.tab_hnmS.value ='';
		document.makeform.tab_enm.value  ='';
		document.makeform.relation_move_data.value ='';
		document.makeform.relation_data.value ='';
		document.makeform.sel_num.value = '0';
		document.makeform.mode.value ='SearchPG';
		document.makeform.target     ='_self';
		document.makeform.action     ="table_relationA.php";
		document.makeform.submit();
		return;
	}

	//================================
	function relation_save_confirm() {

		if( document.makeform.relation_move_data.value ==''){  // relation set 확인
			alert(" After setting the relational expression, click the 'save' button!"); // 관계식을 설정후 ' save' 버턴을 클릭 하세요!
			return false; 
		}
		var relation_type = makeform.relation_type[1].checked;
		if( relation_type == true && document.makeform.relation_SQL_KeyD.value ==''){ 
			// Insert or Update중에서 선택을 했다면. relation key fld 선택 여부 확인.
			alert(" The relation is Update. Please select a key field and click the 'SQL Save' button to save it! ");
			return false; // 관계식이 Update입니다. 키필드를 선택하고 'Key save' 버턴을 클릭하고 저장해 주세요!
		}

		makeform.relation_reset.value = '';
		makeform.mode.value="table_relation_save";
		makeform.action="table_relationA.php";
		makeform.submit();
	}

	function delete_after_run(pg_codeS, pg_code){
		alert('pg_codeS: '+pg_codeS+', pg_code: '+pg_code);
		document.makeform.pg_code.value =pg_code;
		document.makeform.pg_codeS.value=pg_codeS;
		document.makeform.mode.value='DeletePG';
		document.makeform.target		='_self';
		document.makeform.action		="table_relationA.php";
		document.makeform.submit();
	}
	function create_after_run(pg_codeS, tab_hnmS){
		document.makeform.mode.value='Save_OK';
		document.makeform.target		='_self';
		document.makeform.action		="table_relationA.php";
		document.makeform.submit();
	}
	//-----------------------------------------------------------------
		//key_ = eval( "document.makeform.relation_key_old_"+sel_num+".value");
		//var fld2e = document.getElementById('sellist_tab2'+j).value; 
		//eval("document.makeform.relation_key_old_" + sel_num + ".value=" + kd);
	function Key_confirm(){ // SQL Insert or Update 처리부분.
		// 중복을 허락한 Insert 이다. 그래서 Key field가 '' 다. 
		// 중복이 아닐때에 만 Insert가 필요 하다 나중에 'No Dup Insert' 버턴생성 보완 하던가, 프로그램을 별도생성?

		if ( makeform.relation_type[0].checked == true ) { // 중복허락한 Insert이다 key가 필요없다.
			document.makeform.relation_SQL_KeyD.value = 'Insert' + ':' + ':' + ':';
			var sel_num = document.makeform.sel_num.value;	//sel_num : 0,1,2
			document.getElementById('relation_key_old_'+sel_num).value = 'Insert' + ':' + ':' + ':';
			if( sel_num == '0' )      document.makeform.relation_key_old_0.value = 'Insert' + ':' + ':' + ':';
			else if( sel_num == '1' ) document.makeform.relation_key_old_1.value = 'Insert' + ':' + ':' + ':';
			else if( sel_num == '2' ) document.makeform.relation_key_old_2.value = 'Insert' + ':' + ':' + ':';
			alert('Set to record registration.'); //레코드 등록으로 설정 합니다.

		} else {  // Update 또는 중복을 허락하지 않는 Insert 일때 여기를 탄다. No중복은 'No Dup Insert'버턴을 추가 해야 한다.

			var pg_codeS = makeform.pg_codeS.value; // program select check
			var tab_hnmS = makeform.tab_hnmS.value; // relation table select check
			//alert('pg_codeS: ' + pg_codeS + ', tab_hnmS: ' + tab_hnmS);
			//pg_codeS: dao_1644457338:외상매출정보:dao_1644457338:외상매출정보:dao_1544062597:ETC&dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT@dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT@dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT&|fld_1|거래일자|DATETIME|15@|fld_2|거래처|CHAR|15@|fld_3|상품명|CHAR|15@|fld_4|수량|INT|12@|fld_5|판매가|INT|12@|fld_6|외상매출액|INT|12@|fld_7|메모|TEXT|255@&Update:fld_1:fld_2:CHAR@Update:fld_1:fld_2:CHAR@Update:fld_1:fld_2:CHAR, tab_hnmS: dao_1644457087:상품
			if(!pg_codeS){
				alert(' Select the program for which you want to set the relationship!');// \n 관계식을 설정할 프로그램을 선택하세요! 
				return false;
			}
			if(!tab_hnmS){
				alert(' Please select a table of relations!');// \n 관계식의 테이블을 선택하세요! 
				return false;
			}
			var fld1e = document.makeform.sellist_tab1.value;	//program table key data를 사용하기위해 가져온다.
																//alert("fld1e: " + fld1e); //return; // fld1e: fld_1:거래처
			if( !fld1e  ) {
				alert(' Select a column in the program table!');// \n 프로그램 테이블의 컬럼을 선택하세요!
				return false; 
			}
			fld1ex = fld1e.split(":");	 
			var Kfld1e = fld1ex[0]; 
			var Kfld1h = fld1ex[1]; 
			
			document.makeform.program_Key_fld.value = Kfld1e;
			document.makeform.program_Key_nm.value  = Kfld1h;

			var fld2e = document.makeform.sellist_tab2.value;	//relation table key fld 가져온다. //alert("fld2e: " + fld2e); // fld2e: fld_1:거래처명
			if( !fld2e  ) {
				alert(' Select a column in the relational table!');// \n 관계식테이블의 컬럼을 선택하세요!
				return false; 
			}
			fld2ex = fld2e.split(":");
			var Kfld2e = fld2ex[0]; 
			var Kfld2h = fld2ex[1]; //alert('' + Kfld2e + ', ' + Kfld2h);
			var Kfld2t = fld2ex[2]; //alert('' + Kfld2e + ', ' + Kfld2h);
			document.makeform.relation_Key_fld.value = Kfld2e;
			document.makeform.relation_Key_nm.value  = Kfld2h;

			if ( Kfld2t.indexOf("INT")>=0 || Kfld2t.indexOf("DECIMAL")>=0 || Kfld2t.indexOf("FLOAT")>=0 || Kfld2t.indexOf("DOUBLE")>=0) {
				document.makeform.relation_Key_fld_type.value  = "INT";
			} else document.makeform.relation_Key_fld_type.value  = "CHAR";
			
			Key_data = 'Update' +':'+Kfld1e+':'+Kfld2e+':'+document.makeform.relation_Key_fld_type.value;
			document.makeform.relation_SQL_KeyD.value = Key_data;

			sel_num = document.makeform.sel_num.value; // relation_key_old_0
			if(sel_num == '0' ) document.makeform.relation_key_old_0.value = Key_data;
			else if(sel_num == '1' ) document.makeform.relation_key_old_1.value = Key_data;
			else if(sel_num == '2' ) document.makeform.relation_key_old_2.value = Key_data;

			alert("Column "+Kfld2h+" is set as the key of the relational expression 'Update'"); //A 컬럼을 관계식 'Update'의 Key로 설정하였습니다
			//document.makeform.mode.value = 'Key_save';
			//document.makeform.action		="table_relationA.php";
			//document.makeform.submit();
		}
		document.makeform.relation_type_key.value = document.makeform.relation_key_old_0.value + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value;
	}

	function relation_move_set(){
		if( makeform.relation_reset.value !=='on' ) {
			alert(' Information is set. \n Click the Reset button and then click \n the Apply button after setting it!');
			// \n 설정된정보가 있습니다. \n 재설정 버턴을 클릭후 설정한 다음에 적용버턴을 클릭하세요!
			return false;
		}
		var pg_name = makeform.pg_name.value;
		var pg_codeS = makeform.pg_codeS.value;
		var tab_hnm = makeform.tab_hnm.value;
		var tab_hnmS = makeform.tab_hnmS.value; // relation table
		if(!pg_codeS){
			alert(' Select the program for which you want to set the relationship!'); // \n 관계식을 설정할 프로그램을 선택하세요! 
			return false;
		}
		if(!tab_hnmS){
			alert(' Please select a table of relations!');// \n 관계식의 테이블을 선택하세요! 
			return false;
		}
		var fld1e = document.makeform.sellist_tab1.value;
		if( !fld1e ) {
			alert(' Please select a column in the program table!');// \n 프로그램 테이블의 컬럼을 선택하세요!
			return false; 
		}
		var fld2e = document.makeform.sellist_tab2.value;
		if( !fld2e  ) {
			alert(' Please select a column in the relational table!');// \n 관계식테이블의 컬럼을 선택하세요!
			return false; 
		}
		var t3 = document.makeform.sellist_calc.value;
		if( !t3 ) {
			alert(' Please select a relationship!');// \n 관계식을 선택하세요!
			return false; 
		}
		fld1ex = fld1e.split(":"); 
		var fld1h = fld1ex[1];   //makeform.sellist_tab1.options[i].text;
		fld2ex = fld2e.split(":");	 
		var fld2h = fld2ex[1];   //makeform.sellist_tab2.options[j].text;
		r_tab = tab_hnmS.split(":");
		relation_data = document.makeform.relation_data.value;
		nmxh = document.makeform.nmxh.value;
		document.makeform.nmxh.value = nmxh + fld1h + calc_val + fld2h + " , ";
		nmx2 = document.makeform.relation_move_data.value;

		var calc_val = t3;   //makeform.sellist_calc.options[k].value;
		document.makeform.relation_move_data.value =  nmx2 + fld1h + calc_val + fld2h + " , ";	
		document.makeform.relation_data.value = relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e; // table_relation_save
		sel_num = document.makeform.sel_num.value; // relation_key_old_0
		Rdata = tab_hnmS + relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e;
		if(sel_num == '0' ) document.makeform.relation_data_old_0.value = Rdata;
		else if(sel_num == '1' ) document.makeform.relation_data_old_1.value = Rdata;
		else if(sel_num == '2' ) document.makeform.relation_data_old_2.value = Rdata;

		document.makeform.relation_data_tab.value = document.makeform.relation_data_old_0.value + '@' +document.makeform.relation_data_old_1.value + '@' + document.makeform.relation_data_old_2.value;
		return false;
	}
	function Relation_Num_Delete(sel_num){
		resp = confirm(' Do you want to delete relation '+sel_num +' ?'); // 1번 관계식을 삭제 할까요?
		if( !resp ) { 
			return false;
		} else {
			if(sel_num == '0' ) {
				document.makeform.relation_data_old_0.value = '';
				document.makeform.relation_key_old_0.value = '';
			} else if(sel_num == '1' ){
				document.makeform.relation_data_old_1.value = '';
				document.makeform.relation_key_old_1.value = '';
			} else if(sel_num == '2' ) {
				document.makeform.relation_data_old_2.value = '';
				document.makeform.relation_key_old_2.value = '';
			}

			document.makeform.relation_data_tab.value = document.makeform.relation_data_old_0.value + '@' +document.makeform.relation_data_old_1.value + '@' + document.makeform.relation_data_old_2.value;

			document.makeform.relation_type_key.value = document.makeform.relation_key_old_0.value + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value;
		}
	}
//-->
</script>

<?php
	$pg_rel = array(); // program relation set column
	$re_rel = array(); // relation table   set column
	$relation_move_data ='';      // 이동식 컬럼 이동식 데이터

	$mode =$_POST['mode'];
	$pg_codeS =$_POST['pg_codeS'];

	if( $pg_codeS ) {
		$pg_ = explode(":", $pg_codeS);
		$pg_code = $pg_[0];
		$pg_name = $pg_[1];
	}
	$tab_hnmS =$_POST['tab_hnmS'];

	if( $tab_hnmS ) {
		$tab_R = explode(":", $tab_hnmS);
		$tab_enmR = $tab_R[0];
		$tab_hnmR = $tab_R[1];
	}
	$group_code	=$_POST['group_code'];
	$group_name	=$_POST['group_name'];

	$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='".$pg_code."' ";
	$resultPG		= sql_query($sqlPG);	//$table10_pg	= sql_num_rows($resultPG);
	if( $resultPG > 0 ) {
		$rsPG = sql_fetch_array( $resultPG);
		$tab_enm	= $rsPG['tab_enm'];
		$tab_hnm	= $rsPG['tab_hnm'];

		if( $rsPG['relation_data'] ) {
			$rdataA = $rsPG['relation_data'];//m_("rdata: " . $rdata);
			//rdata: dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT@dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT@dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT

			//$relation_type_key = $rsPG['relation_type'];
			$type_R    = explode("@", $rsPG['relation_type'] );
			$data_R    = explode("@", $rsPG['relation_data'] );//m_("len: " . strlen( $data_R[0]) );
			//dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT
			//@dao_1644457087:상품$fld_3:상품명|=|fld_1:상품명:CHAR$fld_5:판매가|=|fld_5:판매가:INT
			//@dao_1644456532:거래처$fld_6:외상매출액|+|fld_5:매출총액:INT$fld_6:외상매출액|+|fld_7:미수총액:INT
			$sel_num = $_POST['sel_num'];
			$rel_ = explode("$", $data_R[$sel_num] ); //sel_num:0,1,2로하고 화면에는 1,2,3으로 표시만 중요.
			$key_ = explode(":", $type_R[$sel_num] );

			$tab_ = $rel_[0]; // 0:Relatio Table

			$tab_R    = explode(":", $rel_[0] );
			$tab_enmR = $tab_R[0];
			$tab_hnmR = $tab_R[1];

			$relation_data ="";
			if( $_POST['relation_reset'] =='on'){ // reset후 테이블을 선택했을 경우 여기로 탄다. 
				//if( $_POST['relation_reset']=='on' || $_POST['rel_job'] == 'add'){// reset후 테이블을 선택했을 경우 여기로 탄다. 
			} else { // reset이 아니면 여기를 탄다.

				for( $i=1; $i < count( $rel_); $i++ ) { //$rel_[0] i==0 -> relation table

					$re_data = $rel_[$i];
					$rrr = explode("|", $re_data);
					$pg_fld = explode(":", $rrr[0]); //$rrr[1] 연결 식 =, +, -, * 
					$re_fld = explode(":", $rrr[2]);
					
					$pg_rel[$i-1] = $pg_fld[1];
					$re_rel[$i-1] = $re_fld[1];
					$relation_move_data .= $pg_rel[$i-1]. $rrr[1] . $re_rel[$i-1]. ",";
					$relation_data = $relation_data . $rel_[$i] . '$';
				}
			}
			$init = 1;
		} //else $relation_reset='on'; 

		//------ Key add : 2022-02-11
		$relation_typeT = $rsPG['relation_type'];

		$rel_t   = explode('@' , $relation_typeT );
		$rel_cnt = count( $rel_t);
		
		$rel_tt = $rel_t[$sel_num];
		$rel_t   = explode(':' , $rel_tt );

		$relation_type = $rel_t[0]; // 'Insert' or 'Update'
		$relation_update_key = $rel_t[1];

		//m_("R cnt:". $rel_cnt. ", 0:" . $rel_t[0]. ", 1:". $rel_t[1] . ", relation_type: " . $relation_type );

			$rel_cA = 'white';
			$rel_cB = 'white';

		if( $relation_type == 'Insert') {
			$rel_cA = 'cyan';
			$rel_cB = 'white';
		} else if ( $relation_type == 'Update'){
			$rel_cA = 'white';
			$rel_cB = 'cyan';
		} else {
			$rel_cA = 'white';
			$rel_cB = 'white';
		}
		//echo "<label style='background-color:$rel_c;'><input type='radio' name='relation_type' value='".$relation_type."'>".$relation_type."</label><br>";
		//-------------------------------------------------------------------------------------------- Key add
	} else {
			//$relation_reset='on';
	}
	$w='100%';
	$w2='300';
?>
<center>

<!-- <div id='menu_normalA'> -->
   <table width='<?=$w2?>' cellspacing='0' cellpadding='4' border='1' class="c1">

		<FORM name='makeform' METHOD='POST' enctype="multipart/form-data">
			<input type="hidden" name="mode"			value="" >
			<input type="hidden" name="relation_reset"			value="<?=$_POST['relation_reset']?>" >
			<input type="hidden" name="tab_enm"		value="<?=$tab_enm?>">
			<input type="hidden" name="fld_hnmX"		value="<?=$fld_hnmX?>">
			<input type="hidden" name="fld_enmX"		value="<?=$fld_enmX?>"> 
			<input type="hidden" name="calcX"			value="<?=$idata1?>"> 
			<input type="hidden" name="sellist"			value="<?=$sellist?>"> 
			<input type="hidden" name="if_line"			value="<?=$if_line?>">
			<input type="hidden" name="pg_code"	value="<?=$pg_code?>">
			<input type="hidden" name="pg_name"	value="<?=$pg_name?>">
			<input type="hidden" name="group_code"	value="<?=$group_code?>">
			<input type="hidden" name="group_name"	value="<?=$group_name?>">
			<input type="hidden" name="item_array"	value="<?=$_POST['item_array']?>">
			<input type="hidden" name="relation_Key_fld" value="">
			<input type="hidden" name="relation_Key_nm"  value="">
			<input type="hidden" name="relation_Key_fld_type"  value="">
			
			<input type="hidden" name="program_Key_fld" value="">
			<input type="hidden" name="program_Key_nm" value="">
		  <tr>
			<!--  \n(작업순서)\n1:프로그램명 선택\n2:Relation table 선택\n3:relation column 선택\n4:관계식 선택\n5:Apply버턴\n6:save버턴 -->
			<!-- \n(work order)\n1:Select program name\n2:Select relation table\n3:Select relation column\n4:Select relational expression\n5:Apply button\n6:Save button -->
			<td align="center" <?php echo" title='\n(work order)\n1:Select program \n2:Select Relation Number \n3:Select relation table \n4:Select relation column \n5:Select relational expression \n6:Apply button \n7:Select SQL Type \n8:SQL Save button click \n9:Save button click' "; ?> style="border-style:;background-color:#666666;color:cyan;width:160px; height:33px;font-size:15;">
			Relational settings
			<br>Program:
			<SELECT name='pg_codeS' onchange="change_program_func(this.value);" style="border-style:;background-color:#666666;color:yellow; height:30px;font-size:15;" <?php echo " title='A list of programs to define the relational expression. ' "; ?> >
<?php 
			if($mode=='SearchPG' || $pg_codeS != "" || $_POST['mode']=="Reset_Check" || $_POST['mode']=="table_relation_save") {
?>
				<option value="<?=$pg_codeS?>"  selected <?php echo "title='pg_codeS:" . $pg_codeS."'"; ?> ><?php echo $pg_name ?> </option>
<?php
			} else {
?>
				<option value=''>Select program</option>
<?php
			}
			$result = sql_query( "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' order by seqno desc " ); // order by pg_name
			while( $rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['pg_code']?>:<?=$rs['pg_name']?>:<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>&<?=$rs['relation_data']?>&<?=$rs['item_array']?>&<?=$rs['relation_type']?>" <?php echo" title='Program code:$pg_codeS' "; if( $pg_name==$rs['pg_name']) echo " selected ";  ?> ><?=$rs['pg_name']?></option>
<?php
			}
?>
			</select>

			<br>
			Relation Number : <select name='sel_num' onchange="change_relation_num_func(this.value);" style="border-style:;background-color:#666666;color:yellow; height:27px;font-size:15;" >
				<option value=''>Select relation number</option>
				<option value="0" <?php if($_POST['sel_num']=='0') echo 'selected';?> >Relation 1</option>
				<option value="1" <?php if($_POST['sel_num']=='1') echo 'selected';?> >Relation 2</option>
				<option value="2" <?php if($_POST['sel_num']=='2') echo 'selected';?> >Relation 3</option>
			</select>

				</td>
			</tr>

			<tr>
               <td valign="top" align="center">
				  <!-- <div id='menu_normalA'> -->
                    <table width='' border="1" cellspacing="0" cellpadding="0">
                       <tr>
                              <td valign="top" align="right" >
                                <table cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td bgcolor="#666666" height="30" align="center">
									  <font color="#FFFFFF" >Program table column</font>
									</td>
                                  </tr>
                                  <tr>
									<td>
									<input maxlength='250' style="border-style:;background-color:#666666;color:yellow;height:33px;font-size:15;" type='text' name='tab_hnm' value='<?=$tab_hnm?>' title='table code:<?=$tab_enm?>' readonly>
									</td>
                                  </tr>

                                  <tr>
								  <td valign="top">
<?php
		$pg_col_chk=0;

		$ck = ''; // key fld 'checked' 표시
	if($_POST['mode']=="SearchPG" || $_POST['mode']=="SearchTAB" || $_POST['mode']=="Reset_Check" || $_POST['mode']=="table_relation_save"){
		$col_ = explode("@", $_POST['item_array']);
		for($i=0; $i < count($col_)-1; $i++) {
			$_col = explode("|", $col_[$i]);

			if( $key_[1] == $_col[1] ) $ck = ' checked'; // 1: program tab key fld 
			else $ck = '';

			for( $j=0; $j < count($pg_rel); $j++ ){
				if ( $pg_rel[$j]==$_col[2] ) $pg_col_chk=1;
			}
			if( $pg_col_chk==1 && $_POST['mode']!=="Reset_Check" ) { // 관계식에 설정한 컬럼의 색상을 cyan 으로 처리.
				echo "<label style='background-color:cyan;'><input type='radio' name='sellist_tab1' value='".$_col[1].":".$_col[2]."' ".$ck." >".$_col[2]."</label><br>";
			}else{
				echo "<label style='background-color:white;'><input type='radio' name='sellist_tab1' value='".$_col[1].":".$_col[2]."' ".$ck." >".$_col[2]."</label><br>";
			}
			$pg_col_chk=0;
		}//for
	}//if
?>
                                     </td>
                                   </tr>
                            </table>
                          </td>


                           <td align="center">
                              <table cellspacing="0" cellpadding="0" width="" align="center" border="1">
                                <tr>
                                  <td align="center" style="background-color:#666666;color:#ffffff;" >Relation<br>Select<br>
								  </td>
                                </tr>
                                
								<tr>
                                  <td height="15" align='center'><br>
										<p><label> <input type='radio' name='sellist_calc' value='='>=(Move)</label></p>
										<p><label> <input type='radio' name='sellist_calc' value='+'>+( Plus )</label></p>
										<p><label> <input type='radio' name='sellist_calc' value='-'>-(Minus)</label></p>
										<br>
										<input type='button' name='run' title='Apply the relational expression.' onClick="relation_move_set()" value='Apply' align='center' style="border-style:;background-color:#666666;color:yellow;width:90px;height:50px">
                                  </td>
								</tr>
                             </table>
                           </td>


                              <td valign="top" align="right" >
                                <table width='' cellspacing="0" cellpadding="0" border="0">
                                  <tr width='' >
                                    <td bgcolor="#666666" height="30" align="center" style="border-style:;background-color:#666666;color:white;height:33px;font-size:15;">Relation table	column</td></tr>
									
								<tr><td>
									
		<select name='tab_hnmS' onchange="relation_table_func(this.value);" style="border-style:;background-color:#666666;color:yellow;height:33px;font-size:15;" >
<?php 

		if($mode=='SearchTAB' || $tab_hnmS != "") {
			$tab_R = explode(":", $tab_hnmS);
			$tab_enmR = $tab_R[0];	// 
			$tab_hnmR = $tab_R[1];	// 
?>
			<option value='<?=$tab_hnmS?>' selected ><?=$tab_hnmR?></option>
<?php
		} else {
?>
			<option value=''>Select Table</option>
<?php
		}
//		$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and fld_enm='seqno' order by tab_hnm " );
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and fld_enm='seqno' order by upday desc " );//관계용테이블선택.
		while( $rs = sql_fetch_array($result)) {
?>
			<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>" <?php echo" title='Table code:".$rs['tab_enm']."' "; ?> <?php if($tab_enmR==$rs['tab_enm']) echo ' selected '; ?> ><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</select>
			<input type='hidden' name='tab_hnmR' value='<?=$tab_hnmR?>' >
			<br>
			</td>
		  </tr>

		  <tr width='' >
			 <td valign="top">
<?php
	//m_("mode: ".$mode);
	if( $mode !== "Delete_Check" ){  // Delete_Check, DeletePG
		$sql = "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enmR' order by disno asc";
		$result = sql_query($sql);
		$pg_col_chk = 0;
		$sel_color  = 'white';
		$rcnt = count( $re_rel); //m_("cnt: " . $rcnt );
		//$rel_cA = 'cyan'; $rel_cB = 'white';
		while( $rsP = sql_fetch_array($result)) {
			if( $rsP['fld_enm'] =='seqno' ) continue;

			if( $key_[2] == $rsP['fld_enm'] ) {
				$ck = ' checked'; // relation tab
				$rel_cA = 'white'; $rel_cB = 'cyan';
			} else { 
				$ck = ''; 
				//$rel_cA = 'cyan'; $rel_cB = 'white';
			}

			for( $j=0; $j < count( $re_rel); $j++ ){
				if ( $re_rel[$j] == $rsP['fld_hnm'] ) {
					$pg_col_chk=1; // 1:관계식 설정된 컬럼.
					$sel_color ='cyan';
				} 
			}
			echo "<label style='background-color:".$sel_color.";'><input type='radio' name='sellist_tab2' value='".$rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type']."' ".$ck.">".$rsP['fld_hnm']."</label><br>";
			$pg_col_chk=0;
			$sel_color='white';
		}//while
	}
?>
					 </td>
				   </tr>
			</table>
		  </td>
		 </tr>
	   </table>
	   <!-- </div> -->
                      </td>
                     </tr>
					  <tr><!-- SQL Type은 변경을 할것인지 또는 등록을 할것인지를 구분하는 것이다. -->
						<td width='' title='SQL Type distinguishes whether to change or register.'>SQL Type:
<?php
//m_("key_[0]: " . $key_[0]); // Insert or Update, key_[1]:relation table의 key fld, [2]:program key fld의 data
?>

<!-- 중요: 중복을 허락하지 않을때는 Key field가 필요하다. 중복인지를 먼저 확인하고 중복이 아닐때에만 등록한다. 그러나 지금은 이부분을 적용하지않았다.-->

 <?php echo "<label style='background-color:$rel_cA;' title='Insert does not require a key column.'>"; ?><input type='radio' name='relation_type'  value='Insert' <?php if( $key_[0] =='Insert') echo 'checked'; ?> >Insert</label>
  <!-- Insert는 key 컬럼이 필요 없습니다. -->
 <?php echo "<label style='background-color:$rel_cB;' title='Update must set the key column.' >"; ?><input type='radio' name='relation_type'  value='Update' <?php if( $key_[0] =='Update') echo 'checked'; ?> >Update</label>
 <!-- Update는 key 컬럼을 설정해야 합니다. -->
						
<?php
//Update에 대한 key를 저장한다.
	//m_("relation_type: " . $relation_type);
//if( $relation_type == 'Update') echo "<input type='button' value='Key Save' onClick='Key_confirm()' title='Save the key for update.'  >";

$sel_num = $_POST['sel_num'] +1; // 화면에 Relation Number를 0이면 1로 표시만 하려고 한것이다. 중요.
 echo "<input type='button' value='SQL Save' onClick='Key_confirm()' title='If the sql type is update, you need to set the key column. However, insert does not require a key column.'  >";
 //sql type이 update이면 key column을 설정해야합니다. 그러나, insert이면 key column이 필요하지않습니다
if( $sel_num > 1 )
 echo "&nbsp;&nbsp;&nbsp;<input type='button' value='Relation " .$sel_num. " Delete' onClick=\"Relation_Num_Delete('".$_POST['sel_num']."')\" title='delete relation number'  >";

?>
						<br>
						<input width='' id='relation_move_data' name='relation_move_data' maxlength='250' value='<?=$relation_move_data?>' style="border-style:;background-color:#666666;color:yellow;width:600px;height:33px;font-size:12;" readonly>
						<!-- display:none -->
						<!-- <br>D --><textarea id='relation_data_tab' name='relation_data_tab' rows='2' cols='84' style="display:none;"><?=$_POST['relation_data_tab']?></textarea><!-- relation 3개에 대한 data 모두 같고있다. -->

			<!-- <br>K --><input type="hidden" style="width:600px;display:none;" name="relation_type_key" value="<?=$_POST['relation_type_key']?>">

						<!-- <br>DD --><textarea id='relation_data' name='relation_data' rows='2' cols='60' style="display:none;"><?=$relation_data?></textarea><!-- relation 3개에 대한 data 모두 같고있다. -->
						
						<!-- <br>DK --><textarea id='relation_SQL_KeyD' name='relation_SQL_KeyD' rows='2' cols='70' style="display:none;"><?=$_POST['relation_SQL_KeyD']?></textarea><!-- relation 3개에 대한 key data 모두 같고있다. -->

						<!-- <br>1:data --><textarea id='relation_data_old_0' name='relation_data_old_0' rows='2' cols='60' style="display:none;"><?=$_POST['relation_data_old_0']?></textarea>
						<!-- <br>1:key --><textarea id='relation_key_old_0' name='relation_key_old_0' rows='2' cols='60' style="display:none;"><?=$_POST['relation_key_old_0']?></textarea>

						<!-- <br>2:data --><textarea id='relation_data_old_1' name='relation_data_old_1' rows='2' cols='60' style="display:none;"><?=$_POST['relation_data_old_1']?></textarea>
						<!-- <br>2:key --><textarea id='relation_key_old_1' name='relation_key_old_1' rows='2' cols='60' style="display:none;"><?=$_POST['relation_key_old_1']?></textarea>
						
						<!-- <br>3:data --><textarea id='relation_data_old_2' name='relation_data_old_2' rows='2' cols='60' style="display:none;"><?=$_POST['relation_data_old_2']?></textarea>
						<!-- <br>3:key --><textarea id='relation_key_old_2' name='relation_key_old_2' rows='2' cols='60' style="display:none;"><?=$_POST['relation_key_old_2']?></textarea>
						
<!-- 						<br>rel_data_old1<textarea id='relation_data_old1' name='relation_data_old1' rows='2' cols='60' style="display:;"><?=$_POST['relation_data_old1']?></textarea>
						<br>rel_key_old1<textarea id='relation_key_old1' name='relation_key_old1' rows='2' cols='60' style="display:;"><?=$_POST['relation_key_old1']?></textarea>

						<br>rel_data_old2<textarea id='relation_data_old2' name='relation_data_old2' rows='2' cols='60' style="display:;"><?=$_POST['relation_data_old2']?></textarea>
						<br>rel_key_old2<textarea id='relation_key_old2' name='relation_key_old2' rows='2' cols='60' style="display:;"><?=$_POST['relation_key_old2']?></textarea>
						
						<br>rel_data_old3<textarea id='relation_data_old3' name='relation_data_old3' rows='2' cols='60' style="display:;"><?=$_POST['relation_data_old3']?></textarea>
						<br>rel_key_old3<textarea id='relation_key_old3' name='relation_key_old3' rows='2' cols='60' style="display:;"><?=$_POST['relation_key_old3']?></textarea>
 -->
						<input type='hidden' id='nmxh' name='nmxh' maxlength='250' size='30'  value=''>
					  </tr>
					<tr>
                      <td align="center" >
						<input type='button' value='Save'  onClick="relation_save_confirm()" title='relation Save'>&nbsp;&nbsp;&nbsp;
						<input type='button' value='Reset' onClick="reset_confirm()"         title='Reset'  > &nbsp;&nbsp;&nbsp;
						<input type='button' value='Delete' onClick="delete_confirm()" title='Delete the entire relation.'  > 
						<!-- 관계식 전체를 삭제한다. -->
						</td>
                    </tr>
		</form>
	</table>
<!-- </div> -->
<?php
	if( $mode=='SearchPG' and $init==1 or $mode=='Save_OK' ){
			//echo "<script>init_relation('$relation_data');</script>";
			$init=0;
	}
?>
</body>
</html>
