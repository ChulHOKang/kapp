<?php
	include_once('./tkher_start_necessary.php');
	/*
	 *  kapp_table_relationA.php : table_relationA.php Copy <- table_relationAM.php  : Multy Relationship Setup - 다중과계식
			: Table Relation 정보저장.
			: A의 테이블에 데이터를 등록하면 X,Y,Z 3개의 테이블에도 데이터를 'Insert' 또는 'Update' 한다.
			: Update 에는 반드시 Key field를 설정해야 한다.
			: {$tkher['table10_pg_table']}
	 *  kapp_save_session.php
	    A테이블에 데이터를 등록하면 B테이블(Relation Table)에도 데이터를 등록한다.
		프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식
	 *  관계식에는 테이블이 처리될때마다 동일하게 처리되는 관계식과 프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식 두가지가 있다.
	 *  여기서는 후자에 속하는 프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식을 적용한다.
		relation_data 구성 샘플: dao_1766735120:ABCYY$
		fld_1:fld1|=|fld_5:product:VARCHAR$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT$fld_7:날짜|=|fld_1:날짜:TIMESTAMP@
		dao_1766812390:ABCYY_FFF_New$
		fld_1:fld1|=|fld_5:product:VARCHAR$fld_7:날짜|=|fld_1:날짜:TIMESTAMP$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT@
		dao_1766822184:ABC_AAA$
		fld_1:fld1|=|fld_1:fld1:VARCHAR$fld_7:날짜|=|fld_7:날짜:TIMESTAMP$fld_5:fld5|+|fld_5:fld5:INT$fld_6:fld6|+|fld_6:fld6:INT
		relation_type 구성 샘플: Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR
	 */
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_ID = get_session("ss_mb_id");
	if( !$H_ID || $H_ID == ''){
		m_("Login please.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	} else {
		$H_LEV = $member['mb_level']; 
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-App System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
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
			makeform.relation_key.value='';
			document.makeform.action="kapp_table_relationA.php";
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
			document.makeform.action="kapp_table_relationA.php";
			document.makeform.submit();
		}
		return;
	}
	// no use
	function init_relation( relation_data ) {
		/*
		dao_1766735120:ABCYY$
		fld_1:fld1|=|fld_5:product:VARCHAR$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT$fld_7:날짜|=|fld_1:날짜:TIMESTAMP@
		dao_1766812390:ABCYY_FFF_New$
		fld_1:fld1|=|fld_5:product:VARCHAR$fld_7:날짜|=|fld_1:날짜:TIMESTAMP$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT@
		dao_1766822184:ABC_AAA$
		fld_1:fld1|=|fld_1:fld1:VARCHAR$fld_7:날짜|=|fld_7:날짜:TIMESTAMP$fld_5:fld5|+|fld_5:fld5:INT$fld_6:fld6|+|fld_6:fld6:INT
		*/
		rel=relation_data.split('$');
		var hnmx2 = "";
		//for( i=0; rel[i] !=""; i++ ){
		for( i=1; rel[i] !=""; i++ ){
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
		document.makeform.relation_move_data.value = hnmx2;
		document.makeform.nmxh.value = hnmx2;
	}
	//================================
	function relation_save_ALL_func() {

		if( document.makeform.relation_move_data.value ==''){  // relation set 확인
			alert(" After setting the relational expression, click the 'save' button!"); // 관계식을 설정후 ' save' 버턴을 클릭 하세요!
			return false; 
		}
		alrt("relation_type_SQL: "+makeform.relation_type_SQL.value);
		if( makeform.relation_type_SQL.value == '' ){
			alert(" The relation is Update. Please select a key field and click the 'SQL Save' button to save it! ");
			return false; // 관계식이 Update입니다. 키필드를 선택하고 'Key save' 버턴을 클릭하고 저장해 주세요!
		}
		/*
		var relation_type_SQL = makeform.relation_type_SQL[1].checked;
		if( relation_type_SQL == true && document.makeform.relation_key.value ==''){ 
			// Insert or Update중에서 선택을 했다면. relation key fld 선택 여부 확인.
			alert(" The relation is Update. Please select a key field and click the 'SQL Save' button to save it! ");
			return false; // 관계식이 Update입니다. 키필드를 선택하고 'Key save' 버턴을 클릭하고 저장해 주세요!
		}*/

		makeform.relation_reset.value = '';
		makeform.mode.value="table_relation_save";
		makeform.action="kapp_table_relationA.php";
		makeform.submit();
	}

	function delete_after_run(pg_codeS, pg_code){
		alert('pg_codeS: '+pg_codeS+', pg_code: '+pg_code);
		document.makeform.pg_code.value =pg_code;
		document.makeform.pg_codeS.value=pg_codeS;
		document.makeform.mode.value='DeletePG';
		document.makeform.target		='_self';
		document.makeform.action		="kapp_table_relationA.php";
		document.makeform.submit();
	}
	function create_after_run(pg_codeS, Rtab_hnmS){
		document.makeform.mode.value='Save_OK';
		document.makeform.target		='_self';
		document.makeform.action		="kapp_table_relationA.php";
		document.makeform.submit();
	}
	 // SQL Insert or Update 중복을 허락한 Insert 이다. 그래서 Key field가 '' 다. 중복이 아닐때에 만 Insert가 필요 하다 나중에 'No Dup Insert' 버턴생성 보완 하던가, 프로그램을 별도생성?
	function Relation_SQL_Key_Set_func(){
		R_item_array = document.getElementById('R_item_array').value;
		alert("" + R_item_array);

		var relation_num = document.getElementById('relation_num').value;
		if ( makeform.relation_type_SQL[0].checked == true ) { // 중복허락한 Insert이다 key가 필요없다.
			document.makeform.relation_key.value = 'Insert' + ':' + ':' + ':';
			key_type = document.getElementById('relation_key_old_'+relation_num).value;
			if( key_type=='') document.getElementById('relation_key_old_'+relation_num).value = 'Insert' + ':' + ':' + ':';
			//alert('Set to record registration.'); //레코드 등록으로 설정 합니다.

		} else {  // Update 또는 중복을 허락하지 않는 Insert 일때 여기를 탄다. No중복은 'No Dup Insert'버턴을 추가 해야 한다.

			var pg_codeS = makeform.pg_codeS.value; //document.getElementById('pg_codeS').value; // program select check
			var Rtab_hnmS = makeform.Rtab_hnmS.value; //document.getElementById('Rtab_hnmS').value; // relation table select check
			if(!pg_codeS){
				alert(' Select the program for which you want to set the relationship!');// \n 관계식을 설정할 프로그램을 선택하세요! 
				return false;
			}
			if(!Rtab_hnmS){
				alert(' Please select a table of relations!');// \n 관계식의 테이블을 선택하세요! 
				return false;
			}
			var fld1e = document.makeform.pg_tab_column.value; //document.getElementById('pg_tab_column').value; //program table key data를 사용하기위해 가져온다.
			var fld2e = document.makeform.re_tab_column.value; //document.getElementById('re_tab_column').value; //relation table key fld 가져온다.
			if( !fld1e ) {
				alert(' Select a column in the program table!');// \n 프로그램 테이블의 컬럼을 선택하세요!
				return false; 
			}
			if( !fld2e ) {
				alert(' Select a column in the relational table!');// \n 관계식테이블의 컬럼을 선택하세요!
				return false; 
			}
			fld1ex = fld1e.split(":");	 
			var Kfld1e = fld1ex[0]; 
			var Kfld1h = fld1ex[1]; 
			document.getElementById('program_Key_fld').value = Kfld1e;//document.makeform.program_Key_fld.value = Kfld1e;
			document.getElementById('program_Key_nm').value = Kfld1h; //document.makeform.program_Key_nm.value  = Kfld1h;
			fld2ex = fld2e.split(":");
			var Kfld2e = fld2ex[0]; 
			var Kfld2h = fld2ex[1];
			var Kfld2t = fld2ex[2];
			document.getElementById('relation_Key_fld').value = Kfld2e;//document.makeform.program_Key_fld.value = Kfld2e;
			document.getElementById('relation_Key_nm').value = Kfld2h; //document.makeform.program_Key_nm.value  = Kfld2h;
			if( Kfld2t.indexOf("INT")>=0 || Kfld2t.indexOf("DECIMAL")>=0 || Kfld2t.indexOf("FLOAT")>=0 || Kfld2t.indexOf("DOUBLE")>=0) {
				document.makeform.relation_Key_fld_type.value  = "INT";
			} else document.makeform.relation_Key_fld_type.value  = "CHAR";
			
			Key_data = 'Update' +':'+Kfld1e+':'+Kfld2e+':' + document.getElementById('relation_Key_fld_type').value;
			document.getElementById('relation_key').value= Key_data;
			relation_num = document.getElementById('relation_num').value;
			document.getElementById('relation_key_old_'+relation_num).value = Key_data;
		}
		r_t_k = document.makeform.relation_type_key.value;
		if( r_t_k == '' ){
			document.makeform.relation_type_key.value = Key_data + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value + "^" + R_item_array + "^" + "^";
		} else {
			rtk[0]=''; rtk[1]=''; rtk[2]='';
			rtk = r_t_k.split("^");
			if( rtk[1] =='') {
				RK = Key_data + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value;
				document.makeform.relation_type_key.value = RK + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value + "^" + R_item_array + "^" + "^";
			} else {
				if(relation_num==0){
					RK = Key_data + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value;
					document.makeform.relation_type_key.value = RK + "^" + R_item_array + "^" + rtk[1] + "^" + rtk[2];
				} if(relation_num==1) {
					RK = document.makeform.relation_key_old_0.value + '@' +Key_data + '@' + document.makeform.relation_key_old_2.value;
					document.makeform.relation_type_key.value = RK + "^" + rtk[0]+ "^" + R_item_array + "^" + rtk[2];
				} if(relation_num==2) {
					RK = document.makeform.relation_key_old_0.value + '@' + document.makeform.relation_key_old_1.value +Key_data;
					document.makeform.relation_type_key.value = RK + "^" + rtk[0]+ "^" + rtk[1]+ "^" + R_item_array;
				}
			}
		}
	}

	function relation_move_set(){
		if( makeform.relation_reset.value !=='on' ) {
			alert('--- Information is set. \n Click the Reset button and then click \n the Apply button after setting it!');
			// \n 설정된정보가 있습니다. \n 재설정 버턴을 클릭후 설정한 다음에 적용버턴을 클릭하세요!		//return false;
		}
		var pg_codeS = document.getElementById('pg_codeS').value; //makeform.pg_codeS.value;
		var Rtab_hnmS = document.getElementById('Rtab_hnmS').value; //makeform.Rtab_hnmS.value; // relation table
		var pg_name = document.getElementById('pg_name').value; //makeform.pg_name.value;
		var tab_hnm = document.getElementById('tab_hnm').value; //makeform.tab_hnm.value;
		alert( "tab_hnm: "+tab_hnm+ ", pg_name: " +pg_name);

		if(!pg_codeS){
			alert(' Select the program for which you want to set the relationship!'); // \n 관계식을 설정할 프로그램을 선택하세요! 
			return false;
		}
		if(!Rtab_hnmS){
			alert(' Please select a table of relations!');// \n 관계식의 테이블을 선택하세요! 
			return false;
		}
		var fld1e = document.makeform.pg_tab_column.value; //document.getElementById('pg_tab_column').value; //document.makeform.pg_tab_column.value;
		if( !fld1e ) {
			alert(' Please select a column in the program table!');// \n 프로그램 테이블의 컬럼을 선택하세요!
			return false; 
		}
		var fld2e = document.makeform.re_tab_column.value; //document.getElementById('re_tab_column').value; //document.makeform.re_tab_column.value;
		if( !fld2e  ) {
			alert(' Please select a column in the relational table!');// \n 관계식테이블의 컬럼을 선택하세요!
			return false; 
		}
		var t3 = document.makeform.sellist_calc.value; //document.getElementById('sellist_calc').value; //document.makeform.sellist_calc.value;
		if( !t3 ) {
			alert(' Please select a relationship!');// \n 관계식을 선택하세요!
			return false; 
		}
		alert( "fld1e: " + fld1e + ", fld2e:" +fld2e+ ", t3: "+ t3 ); //fld1e: fld_1:fld1, fld2e:fld_5:product:VARCHAR, t3: =
		fld1ex = fld1e.split(":"); 
		var fld1h = fld1ex[1];   //makeform.pg_tab_column.options[i].text;
		fld2ex = fld2e.split(":");	 
		var fld2h = fld2ex[1];   //makeform.re_tab_column.options[j].text;
		r_tab = Rtab_hnmS.split(":");
		relation_data = document.makeform.relation_data.value;
		nmxh = document.makeform.nmxh.value;
		document.makeform.nmxh.value = nmxh + fld1h + calc_val + fld2h + " , ";
		nmx2 = document.makeform.relation_move_data.value;

		var calc_val = t3;   //makeform.sellist_calc.options[k].value;
		document.makeform.relation_move_data.value =  nmx2 + fld1h + calc_val + fld2h + " , ";	
		document.makeform.relation_data.value = relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e; // table_relation_save
		relation_num = document.getElementById('relation_num').value; //document.makeform.relation_num.value; // relation_key_old_0
		Rdata = Rtab_hnmS + relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e;
		document.getElementById('relation_data_old_'+relation_num).value = Rdata; 
		document.getElementById('relation_data_tab').value = document.getElementById('relation_data_old_0').value + '@' +document.getElementById('relation_data_old_1').value + '@' + document.getElementById('relation_data_old_2').value;
		return;
	}
	function Relation_Num_Delete(){
		var relation_num = document.getElementById('relation_num').value;

		resp = confirm(' Do you want to delete relation '+relation_num +' ?'); // 1번 관계식을 삭제 할까요?
		if( !resp ) { 
			return false;
		} else {
			document.getElementById('relation_data_old_'+relation_num).value = '';
			document.getElementById('relation_key_old_'+relation_num).value = '';

			document.getElementById('relation_data_tab').value = document.getElementById('relation_data_old_0').value + '@' +document.getElementById('relation_data_old_1').value + '@' + document.getElementById('relation_data_old_2').value;

			r_type_key = document.getElementById('relation_type_key').value;
			Rkey = r_type_key.split("^");

			relation_type_keyA = document.getElementById('relation_key_old_0').value + '@' +document.getElementById('relation_key_old_1').value + '@' + document.getElementById('relation_key_old_2').value;
			
			//Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR^0array^1array^2array
			relation_type_key = document.getElementById('relation_type_key').value;
			Rkey = relation_type_key.split("^");

			if( relation_num == 0) relation_type_key = relation_type_keyA + "^" + "" + "^"+ Rkey[2] + "^"+ Rkey[3];
			else if( relation_num == 1) relation_type_key = relation_type_keyA + "^" + Rkey[1] + "^"+ "" + "^"+ Rkey[3];
			else if( relation_num == 2) relation_type_key = relation_type_keyA + "^" + Rkey[1] + "^"+ Rkey[2] + "^" + "";

			document.getElementById('relation_type_key').value = relation_type_key;

			//document.getElementById('relation_type_key').value = document.getElementById('relation_key_old_0').value + '@' +document.getElementById('relation_key_old_1').value + '@' + document.getElementById('relation_key_old_2').value + "^";
		}
	}
	// --- relation_num change
	function change_relation_num_func(pg) {
		R_typeA = document.getElementById('relation_type_key').value; // Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR^0array^1array^2array
		R_dataA = document.getElementById('relation_data_tab').value;
		if( R_dataA!==''){
			R_data = R_dataA.split('@');
			document.getElementById('relation_data').value= R_data[pg]; // relation_data = relation_num 현재 설정된 값 출력용.
		}
		if( R_typeA !==''){
			R_t = R_typeA.split('^'); // R_typeA = Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR^0array^1array^2array
			R_type = R_t[0].split('@'); // R_t[0] = Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR
			document.getElementById('relation_key').value= R_type[pg]; // relation_key = relation_num 현재 설정된 값 출력용.
		}
		//Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR^0array^1array^2array
		dt = document.getElementById('relation_key_old_'+pg).value;  //dao_1766735120:ABCYY$fld_1:fld1|=|fld_5:product:VARCHAR$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT$fld_7:날짜|=|fld_1:날짜:TIMESTAMP
		//dd=dao_1766822184:ABC_AAA$fld_1:fld1|=|fld_1:fld1:VARCHAR$fld_7:날짜|=|fld_7:날짜:TIMESTAMP$fld_5:fld5|+|fld_5:fld5:INT$fld_6:fld6|+|fld_6:fld6:INT
		dd = document.getElementById('relation_data_old_'+pg).value; //dd = eval( "document.makeform.relation_data_old_" + pg + ".value");
		var selectIndex = document.makeform.Rtab_hnmS.selectedIndex;
		if( dd !==''){
			Rdata = dd.split('$');
			dataT = Rdata[0].split(':');
			tabenm = dataT[0]; // 0:table cd name
			tabhnm = dataT[1];
			document.makeform.Rtab_hnmS[selectIndex].value = Rdata[0]; //Rdata0: dao_1766812390:ABCYY_FFF_New, dd Rtab_hnmS: dao_1766812390:ABCYY_FFF_New
			document.makeform.Rtab_hnmS[selectIndex].text = dataT[1];  //dataT[0]: dao_1766812390
			
		} else {
			document.getElementById('Rtab_hnmS').value = '';
			document.getElementById('re_tab_column').value = '';
		}
		r_func( dd, dt );
		return;
	}
	/*
	dao_1766735120:ABCYY$
	fld_1:fld1|=|fld_5:product:VARCHAR$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT$fld_7:날짜|=|fld_1:날짜:TIMESTAMP@
	dao_1766812390:ABCYY_FFF_New$
	fld_1:fld1|=|fld_5:product:VARCHAR$fld_7:날짜|=|fld_1:날짜:TIMESTAMP$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT@
	dao_1766822184:ABC_AAA$
	fld_1:fld1|=|fld_1:fld1:VARCHAR$
	fld_7:날짜|=|fld_7:날짜:TIMESTAMP$
	fld_5:fld5|+|fld_5:fld5:INT$
	fld_6:fld6|+|fld_6:fld6:INT
	Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR
	Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR^0array^1array^2array
	*/
	function r_func(relation_column, keyf){ // only relation column in table
		rt = keyf.split(':');
		rdata = relation_column.split('$');
		len = rdata.length;
		ss="";
		for( i=1; i<len; i++){
			rr = rdata[i].split('|');
			pg = rr[0]; // program field
			sk = rr[1]; // sik
			re = rr[2]; // relation table field
			fn = re.split(':');
			re_enm = fn[0];
			re_hnm = fn[1];
			st = " style='background-color:white;' ";
			ck = "";
			tt = rdata[i];
			if( rt[2] == re_enm) { // rt = Update:fld_1:fld_5:
				st = " style='background-color:cyan;' ";
				ck = " checked ";
				tt = " key " + tt;
			}
			ss+="<label " +st+ " title='"+ tt +"'><input type='radio' "+ck+" id='re_tab_column' name='re_tab_column' onclick='re_col_func(this.value)' title='"+ re+"' value='"+ re+"'>"+re_hnm+"</label><br>";
		}
		here_relation.innerHTML=ss;
	} 
	function sendDataToPHP( projectnmS, pnmdataS ) {
		fetch('<?=KAPP_URL_T_?>/kapp_save_session.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ projectnmS: projectnmS, pnmdataS: pnmdataS }),
		})
		.then(response => response.json())
		.then(data => {
			console.log('Success:', data);
		})
		.catch((error) => {
			console.error('Error:', error);
		});
	}
	function change_project_func(pnmS){
		if( pnmS == '') {
			alert('Select Project!');
			return false;
		}
		sendDataToPHP('project_nmS', pnmS); //my_func
		document.getElementById('mode').value = 'Project_Search';
		document.makeform.action="kapp_table_relationA.php";
		document.makeform.submit();
	}
	function change_program_func(pcdS){
		if( pcdS == '') {
			alert('Select Program!');
			return false;
		}
		sendDataToPHP('pg_codeS', pcdS);
		document.getElementById('mode').value = 'pg_codeS_Search';
		document.makeform.action="kapp_table_relationA.php";
		document.makeform.submit();
	}
	function Change_Relation_Table_func(ptbS){ // Relation_Table_func
		if( ptbS == '') {
			alert('Select Relation Table!');
			return false;
		}
		sendDataToPHP('Rtab_hnmS', ptbS);
		document.getElementById('mode').value = 'Relation_SearchTAB';
		document.getElementById('R_item_array').value = ptbS;
		document.makeform.action="kapp_table_relationA.php";
		document.makeform.submit();
	}
	function radio_box_func(rnum,val){
		//no = document.getElementById('relation_num').value; //document.makeform.relation_num.value;
		//alert( rnum + ' , '+ val);
		sql_v = val+':::@@'; //':::@@^^^'; // Update:fld_1:fld_5:CHAR@@
		document.getElementById('relation_key_old_'+rnum).value = sql_v; 
	}
	function re_col_func(val){
		//alert('val: '+ val); //val: fld_5:product:VARCHAR
	}
//-->
</script>

<?php

	$data_R = array();
	$type_R = array();
	$pg_rel = array(); // program relation set column
	$re_rel = array(); // relation table   set column
	$rel_ = array();
	$key_ = array();

	$rel_cA = 'white';
	$rel_cB = 'white';
	$relation_data ='';
	$relation_move_data ='';      // 이동식 컬럼 이동식 데이터
	$mode ='';
	$relation_reset ='';
	$item_array='';
	$project_nmS = '';
	$project_name= '';
	$project_code= '';
	$pg_codeS = '';
	$pg_code = '';
	$pg_name = '';
	$tab_enm = '';
	$tab_hnm = '';
	$Rtab_hnmS = '';
	$tab_enmR = '';
	$tab_hnmR = '';
	$relation_type_key = '';
	$relation_key = '';
	$relation_data_tab = '';
	$relation_data_old_0 = '';
	$relation_key_old_0 = '';
	$item_array_0 ='';
	$relation_data_old_1 = '';
	$relation_key_old_1 = '';
	$item_array_1='';
	$relation_data_old_2 = '';
	$relation_key_old_2 = '';
	$item_array_2='';
	$relation_num = 0;
	$R_item_array = '';

	if( isset($_POST['mode']) ) $mode =$_POST['mode'];
	if( isset($_POST['relation_type_key']) ) $relation_type_key = $_POST['relation_type_key'];
	if( isset($_POST['relation_data_tab']) ) $relation_data_tab = $_POST['relation_data_tab'];
	if( isset($_POST['relation_data_old_0']) ) $relation_data_old_0 = $_POST['relation_data_old_0'];
	if( isset($_POST['relation_key_old_0']) ) $relation_key_old_0 = $_POST['relation_key_old_0'];
	if( isset($_POST['relation_data_old_1']) ) $relation_data_old_1 = $_POST['relation_data_old_1'];
	if( isset($_POST['relation_key_old_1']) ) $relation_key_old_1 = $_POST['relation_key_old_1'];
	if( isset($_POST['relation_data_old_2']) ) $relation_data_old_2 = $_POST['relation_data_old_2'];
	if( isset($_POST['relation_key_old_2']) ) $relation_key_old_2 = $_POST['relation_key_old_2'];
	if( isset($_POST['item_array_0']) ) $item_array_0 = $_POST['item_array_0'];
	if( isset($_POST['item_array_1']) ) $item_array_1 = $_POST['item_array_1'];
	if( isset($_POST['item_array_2']) ) $item_array_2 = $_POST['item_array_2'];

	if( isset($_POST['relation_key']) ) $relation_key = $_POST['relation_key'];
	if( isset($_POST['relation_reset']) ) $relation_reset = $_POST['relation_reset'];
	if( isset($_POST['item_array']) ) $item_array = $_POST['item_array'];
	if( isset($_POST['relation_num']) ) $relation_num = $_POST['relation_num'];
	//if( isset($_POST['project_code']) ) $project_code = $_POST['project_code'];
	//if( isset($_POST['project_name']) ) $project_name = $_POST['project_name'];
	if( isset($_POST['R_item_array']) ) $R_item_array = $_POST['R_item_array'];

	if( $mode=='Project_Search' ) { //|| isset( $_SESSION['project_nmS'])
		$project_nmS = $_SESSION['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	}
	if( isset($_SESSION['project_nmS']) ){
		$project_nmS = $_SESSION['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	}
	/*	pg_codeS = pg_code:pg_name:tab_enm:tab_hnm:group_code:group_name^relation_data^relation_type^item_array
	relation_data=
	dao_1766735120:ABCYY$fld_1:fld1|=|fld_5:product:VARCHAR$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT$fld_7:날짜|=|fld_1:날짜:TIMESTAMP@@
	relation_type=Update:fld_1:fld_5:CHAR@@
	*/
	if( $mode=='pg_codeS_Search' ) { //|| isset($_SESSION['pg_codeS'])
		$pg_codeS =$_SESSION['pg_codeS'];
		$pg_A = explode("^", $pg_codeS);
		$pg_ = explode(":", $pg_A[0]);
		$pg_code = $pg_[0];
		$pg_name = $pg_[1];
		$tab_enm = $pg_[2];
		$tab_hnm = $pg_[3];

	}
	/*else if( isset($_POST['pg_codeS']) && $_POST['pg_codeS']!=='' ){
		$pg_codeS =$_POST['pg_codeS'];
		$pg_A = explode("^", $pg_codeS);
		$pg_ = explode(":", $pg_A[0]);
		$pg_code = $pg_[0];
		$pg_name = $pg_[1];
		$tab_enm = $pg_[2];
		$tab_hnm = $pg_[3];

		$relation_dataA = explode("@", $pg_A[1]); // $pg_A[1] = relation_data, $pg_A[2] = relation_type
		$relation_dataT = explode("$", $relation_dataA[$relation_num]);
		
		if($relation_dataT[0] !==''){
			$Rtab_hnmS = $relation_dataT[0];
			$relation_TAB = explode(":", $Rtab_hnmS); //dao_1766735120:ABCYY
			$tab_enmR = $relation_TAB[0];
			$tab_hnmR = $relation_TAB[1];
			$relation_typeA = explode("@", $pg_A[2]); //$pg_A[2] = relation_type
			$relation_type_key = $relation_typeA[$relation_num];
		}
	}*/
	if( isset($_SESSION['pg_codeS']) ){
		$pg_codeS =$_SESSION['pg_codeS'];
		$pg_A = explode("^", $pg_codeS);
		$pg_ = explode(":", $pg_A[0]);
		$pg_code = $pg_[0];
		$pg_name = $pg_[1];
		$tab_enm = $pg_[2];
		$tab_hnm = $pg_[3];
		//$project_code = $pg_[4];
		//$project_name = $pg_[5];
		if( isset($pg_A[1]) ){
			$relation_dataA = explode("@", $pg_A[1]); //relation_data=$pg_A[1]
			$relation_dataT = explode("$", $relation_dataA[0]); //$relation_dataA[0]=relation num:0
			$Rtab_hnmS = $relation_dataT[0];
			
			if( $relation_dataT[0] !==''){
				$relation_TAB = explode(":", $relation_dataT[0]);
				$tab_enmR = $relation_TAB[0]; //relation num:0 - tab
				$tab_hnmR = $relation_TAB[1];
				//$relation_typeA = explode("@", $pg_A[2]);
				//$relation_type_key = $relation_typeA[0];
				$relation_type_key = $pg_A[2];
			}
		}
		
		Fetch_pg_code($pg_code, $pg_name);
	}
	if( $mode=='Relation_SearchTAB' ) { // && isset($_POST['pg_codeS']
		$pg_codeS =$_SESSION['pg_codeS']; //$pg_codeS =$_POST['pg_codeS'];
		$pg_A = explode("^", $pg_codeS); //pg_codeS = pg_code:pg_name:tab_enm:tab_hnm:group_code:group_name^relation_data^relation_type^item_array
		$pg_ = explode(":", $pg_A[0]);   //$pg_A[0] = pg_code:pg_name:tab_enm:tab_hnm:group_code:group_name
		$pg_code = $pg_[0];
		$pg_name = $pg_[1];
		$tab_enm = $pg_[2];
		$tab_hnm = $pg_[3];

		$Rtab_hnmS =$_SESSION['Rtab_hnmS'];	m_("mode:$mode, Rtab_hnmS" . $Rtab_hnmS);
		$relation_TAB = explode(":", $Rtab_hnmS); //dao_1766735120:ABCYY
		$tab_enmR = $relation_TAB[0];
		$tab_hnmR = $relation_TAB[1];

		//$relation_typeA = explode("@", $pg_A[2]); //$pg_A[2] = relation_type
		//if($pg_A[2] == '') $relation_type_key = ""; //":::@@^^^";
		//else $relation_type_key = $pg_A[2]; //$relation_type_key = $relation_typeA[$relation_num];
		//m_("$mode, R_item_array: $R_item_array");
	}
	if( $mode == 'Delete_Check' ) {
		relation_all_delete( $pg_code );
		$relation_data_tab = '';
		$relation_type_key = '';
	}
	if( $mode == 'table_relation_save' ) relation_save( $pg_code );
	//relation_type=Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR^^^
	$data_R  = explode("@", $relation_data_tab); //$relation_data_tab = $rsPG['relation_data'];
	if( isset($data_R[$relation_num]) && $data_R[$relation_num]!=='') $rel_ = explode("$", $data_R[$relation_num] ); //relation_num:0,1,2로하고 화면에는 1,2,3으로 표시만 중요.

/*	$type_R  = explode("@", $relation_type_key); //$relation_type_key = $rsPG['relation_type'];
	if( isset($type_R[$relation_num]) && $type_R[$relation_num]!=='') $key_ = explode(":", $type_R[$relation_num] );
	if( isset($type_R[$relation_num]) && $type_R[$relation_num] !=='' && $key_[0]=='Insert' ) $rel_cA = 'cyan'; //item_color( $relation_num );
	if( isset($type_R[$relation_num]) && $type_R[$relation_num] !=='' && $key_[0]=='Update' ) $rel_cB = 'cyan'; //str_contains( $key_[0], 'Insert')
*/
	if( $relation_type_key !==''){
		$typeR  = explode("^", $relation_type_key); //relation_type=Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR^^^
		$type_R  = explode("@", $typeR[1]); //$relation_type_key = $rsPG['relation_type'];
		if( isset($type_R[$relation_num]) && $type_R[$relation_num]!=='') $key_ = explode(":", $type_R[$relation_num] );
		if( isset($type_R[$relation_num]) && $type_R[$relation_num]!=='' && $key_[0]=='Insert' ) $rel_cA = 'cyan'; //item_color( $relation_num );
		if( isset($type_R[$relation_num]) && $type_R[$relation_num]!=='' && $key_[0]=='Update' ) $rel_cB = 'cyan'; //str_contains( $key_[0], 'Insert')
	}
?>
<center>

<!-- <div id='menu_normalA'> -->
   <table width='300' cellspacing='0' cellpadding='4' border='1' class="c1">

		<FORM name='makeform' METHOD='POST' enctype="multipart/form-data">
			<input type="hidden" name="mode" id="mode" value="" >
			<input type="hidden" name="relation_reset" id="relation_reset" value="<?=$relation_reset?>" >
			<input type="hidden" name="tab_enm" id="tab_enm" value="<?=$tab_enm?>">
			<input type="hidden" name="pg_code"	id="pg_code" value="<?=$pg_code?>">
			<input type="hidden" name="pg_name"	id="pg_name" value="<?=$pg_name?>">
			<input type="hidden" name="project_code" id="project_code" value="<?=$project_code?>">
			<input type="hidden" name="project_name" id="project_name" value="<?=$project_name?>">
			<input type="hidden" name="item_array" id="item_array" value="<?=$item_array?>">
			<input type="hidden" name="relation_Key_fld" id="relation_Key_fld" value="">
			<input type="hidden" name="relation_Key_nm" id="relation_Key_nm"  value="">
			<input type="hidden" name="relation_Key_fld_type" id="relation_Key_fld_type"  value="">
			<input type="hidden" name="program_Key_fld" id="program_Key_fld" value="">
			<input type="hidden" name="program_Key_nm" id="program_Key_nm" value="">

		  <tr><!--  \n(작업순서)\n1:프로그램명 선택\n2:Relation table 선택\n3:relation column 선택\n4:관계식 선택\n5:Apply버턴\n6:save버턴 -->
			<!-- \n(work order)\n1:Select program name\n2:Select relation table\n3:Select relation column\n4:Select relational expression\n5:Apply button\n6:Save button -->
			<td align="center" <?php echo" title='\n(work order)\n1:Select program \n2:Select Relation Number \n3:Select relation table \n4:Select relation column \n5:Select relational expression \n6:Apply button \n7:Select SQL Type \n8:SQL Save button click \n9:Save button click' "; ?> style="border-style:;background-color:#666666;color:cyan;width:160px; height:33px;font-size:15;">
			Relational settings(<?=$H_ID?>)<br>
			Project:<SELECT id='project_nmS' name='project_nmS' onchange="change_project_func(this.value);" style="background-color:#666666;color:yellow;width:50%;height:30px;">
<?php 
		echo "<option value=''>1.Select Project</option>";
		if( isset( $_SESSION['project_nmS']) ) echo "<option value='$project_nmS' selected title='".$_SESSION['project_nmS']."'>$project_name</option>";

		$result= sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by upday desc " ); 
		while( $rs = sql_fetch_array($result)) {
?>
			<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' <?php if( $project_code==$rs['group_code']) echo ' selected '; ?> title="<?=$rs['group_code']?>:<?=$rs['group_name']?>"><?=$rs['group_name']?></option>
<?php	} ?>
		</SELECT>

		<br>Program:<SELECT id='pg_codeS' name='pg_codeS' onchange="change_program_func(this.value);" style="background-color:#666666;color:yellow;width:45%; height:30px;" >
<?php
		if( isset( $_SESSION['pg_codeS']) ) echo "<option value='$pg_codeS' selected >$pg_name</option>";
		else echo "<option value=''>2.Select program</option>";

		$result= sql_query( "SELECT * from {$tkher['table10_pg_table']} where group_code='$project_code' and userid='$H_ID' order by seqno desc " );
		while( $rs = sql_fetch_array($result)) {
?>
			<option value="<?=$rs['pg_code']?>:<?=$rs['pg_name']?>:<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>^<?=$rs['relation_data']?>^<?=$rs['relation_type']?>^<?=$rs['item_array']?>" <?php if( $pg_code==$rs['pg_code']) echo " selected ";?> ><?=$rs['pg_name']?></option>
<?php   } ?>
		</SELECT>

		<br>Relation Number:<SELECT id='relation_num' name='relation_num' onchange="change_relation_num_func(this.value);" style="border-style:;background-color:#666666;color:yellow; height:30px;font-size:15;" >
				<option value=''>Select relation number</option>
				<option value="0" <?php if($relation_num=='0') echo 'selected';?> >Relation 1</option>
				<option value="1" <?php if($relation_num=='1') echo 'selected';?> >Relation 2</option>
				<option value="2" <?php if($relation_num=='2') echo 'selected';?> >Relation 3</option>
		</SELECT>
		<input type='button' value=' Relation Save ' onclick='' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;'>

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
									<input id='tab_hnm' name='tab_hnm' maxlength='250' style="border-style:;background-color:#666666;color:yellow;height:33px;font-size:15;" type='text'  value='<?=$tab_hnm?>' title='table code:<?=$tab_enm?>' readonly>
									</td>
                                  </tr>

                                  <tr>
								  <td valign="top">
<?php
	$sel_color  = 'white';
	pg_tab_disp( $item_array );
?>
                                     </td>
                                   </tr>
                            </table>
                          </td>


                           <td valign="top">
                              <table border="1" style='text-align:center;table-layout:fixed;'>
                                <tr>
                                  <td align="center" style="background-color:#666666;color:#ffffff;" >Relationship <br> Select<br>
								  </td>
                                </tr>
                                
								<tr>
                                  <td height="15" align='center'><br>
										<p><label> <input type='radio' id='sellist_calc' name='sellist_calc' value='='>=(Move)</label></p>
										<p><label> <input type='radio' id='sellist_calc' name='sellist_calc' value='+'>+( Plus )</label></p>
										<p><label> <input type='radio' id='sellist_calc' name='sellist_calc' value='-'>-(Minus)</label></p>
										<br>
										<input type='button' id='Applyrun' name='Applyrun' title='Apply the relational expression.' onClick="relation_move_set()" value='Apply'  style="background-color:#666666;color:yellow;width:90px;height:50px;text-align:center;">
                                  </td>
								</tr>
                             </table>
                           </td>


                              <td valign="top" >
                                <table width='' cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td style="border-style:;background-color:#666666;color:white;height:33px;font-size:15;text-align:center;">Relation table	column</td></tr>
								<tr><td>
									
		<SELECT id='Rtab_hnmS' name='Rtab_hnmS' onchange="Change_Relation_Table_func(this.value);" style="background-color:#666666;color:yellow;height:33px;font-size:15;" >
<?php 
		if( $mode=='Relation_SearchTAB' || isset($_SESSION['Rtab_hnmS']) ) { //isset($_SESSION['Rtab_hnmS']) , $Rtab_hnmS != ""
			$tab_R = explode(":", $Rtab_hnmS);
			$tab_enmR = $tab_R[0];
			$tab_hnmR = $tab_R[1];
		}

		if( $mode=='pg_codeS_Search' || $mode=='Relation_SearchTAB' || isset($_SESSION['Rtab_hnmS']) ) echo "<option value='$Rtab_hnmS' selected >$tab_hnmR</option>";
		else echo "<option value=''>Select Table</option>";
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where group_code='$project_code' and userid='$H_ID' and fld_enm='seqno' " );//관계용테이블선택.
		while( $rs = sql_fetch_array($result)) {
			if( $tab_enmR == $rs['tab_enm']) $R_item_array = $rs['tab_enm'].":".$rs['tab_hnm'] .":" .$rs['memo'];
?>
			<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['memo']?>" title='Table code:<?=$rs['tab_hnm']?>:<?=$rs['memo']?>' <?php if( $tab_enmR==$rs['tab_enm']) echo ' selected '; ?> ><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</SELECT>
			<input type='hidden' id='tab_hnmR' name='tab_hnmR' value='<?=$tab_hnmR?>' >
			<br>
			</td>
		  </tr>
		  <tr>
			 <td valign="top">
	<div id="here_relation" style="font-size:18px;">
<?php
	if( $tab_enmR !== '' ) $R_item_array = relation_table_disp( $tab_enmR ); //if( $mode !== "Delete_Check" ) relation_table_disp( $tab_enmR );
	m_("mode:$mode, R_item_array: " . $R_item_array); 
	//R_item_array: dao_1766735120:ABCYY:|fld_1|날짜|TIMESTAMP|20@|fld_2|yyyy|CHAR|4@|fld_3|mm|CHAR|2@|fld_4|dd|CHAR|2@|fld_5|product|VARCHAR|15@|fld_6|total_count|INT|12@|fld_7|tottal_price|BIGINT|15@
?>
	</div>
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
						<td title='SQL Type distinguishes whether to change or register.'>SQL Key Type:

<!-- 중요: 중복을 허락하지 않을때는 Key field가 필요하다. 중복인지를 먼저 확인하고 중복이 아닐때에만 등록한다. 그러나 지금은 이부분을 적용하지않았다.-->

 <?php echo "<label style='background-color:$rel_cA;' title='Insert does not require a key column.'>"; ?>
 <input type='radio' onclick='radio_box_func(<?=$relation_num?>,this.value)' id='relation_type_SQL' name='relation_type_SQL' value='Insert' <?php if( isset($key_[0]) && $key_[0] =='Insert') echo 'checked'; ?> >Insert</label>  <!-- Insert는 key 컬럼이 필요 없습니다. -->
 <?php echo "<label style='background-color:$rel_cB;' title='Update must set the key column.' >"; ?>
 <input type='radio' onclick='radio_box_func(<?=$relation_num?>,this.value)' id='relation_type_SQL' name='relation_type_SQL' value='Update' <?php if( isset($key_[0]) && $key_[0] =='Update') echo 'checked'; ?> >Update</label> <!-- Update는 key 컬럼을 설정해야 합니다. -->
						
<?php
	m_("R_item_array: $R_item_array");
 echo "<input id='sqlsave_button' type='button' value=' SQL Key Set ' onClick='Relation_SQL_Key_Set_func();' style='height:30px;font-size:15; border-radius:20px;border:1 solid white;' title='R_item_array:$R_item_array, If the sql type is update, you need to set the key column. However, insert does not require a key column.'  >";
 //sql type이 update이면 key column을 설정해야합니다. 그러나, insert이면 key column이 none

 echo "&nbsp;<input id='delnum_button' type='button' value='Relation Delete' onClick='Relation_Num_Delete()' style='height:30px;font-size:15; border-radius:20px;border:1 solid white;' >";
?>
			<br>
			<input width='' id='relation_move_data' name='relation_move_data' maxlength='250' value='<?=$relation_move_data?>' style="border-style:;background-color:#666666;color:yellow;width:600px;height:33px;font-size:12;" readonly title='relation_move_data:<?=$relation_move_data?>'>
			<!-- display:none --><!-- relation 3개에 대한 data 모두 같고있다. -->
			relation_data_tab<textarea id='relation_data_tab' name='relation_data_tab' rows='3' cols='84' style="display:;"><?=$relation_data_tab?></textarea>
			relation_type_key<textarea id='relation_type_key' name='relation_type_key' rows='3' cols='84' style="display:;"><?=$relation_data_tab?></textarea>
			R_item_array<textarea id='R_item_array' name='R_item_array' rows='3' cols='84' style="display:;"><?=$R_item_array?></textarea>

			relation_data<textarea id='relation_data' name='relation_data' rows='3' cols='60' style="display:;"><?=$relation_data?></textarea>
			relation_key<textarea id='relation_key' name='relation_key' rows='1' cols='60' style="display:;"><?=$relation_key?></textarea>

			relation_data_old_0<textarea id='relation_data_old_0' name='relation_data_old_0' rows='3' cols='60' style="display:;"><?=$relation_data_old_0?></textarea>
			relation_key_old_0<textarea id='relation_key_old_0' name='relation_key_old_0' rows='1' cols='60' style="display:;"><?=$relation_key_old_0?></textarea>
			item_array_0<textarea id='item_array_0' name='item_array_0' rows='1' cols='60' style="display:;"><?=$item_array_0?></textarea>

			relation_data_old_1<textarea id='relation_data_old_1' name='relation_data_old_1' rows='3' cols='60' style="display:;"><?=$relation_data_old_1?></textarea>
			relation_key_old_1<textarea id='relation_key_old_1' name='relation_key_old_1' rows='1' cols='60' style="display:;"><?=$relation_key_old_1?></textarea>
			item_array_1<textarea id='item_array_1' name='item_array_1' rows='1' cols='60' style="display:;"><?=$item_array_1?></textarea>
			
			relation_data_old_2<textarea id='relation_data_old_2' name='relation_data_old_2' rows='3' cols='60' style="display:;"><?=$relation_data_old_2?></textarea>
			relation_key_old_2<textarea id='relation_key_old_2' name='relation_key_old_2' rows='1' cols='60' style="display:;"><?=$relation_key_old_2?></textarea>
			item_array_2<textarea id='item_array_2' name='item_array_2' rows='1' cols='60' style="display:;"><?=$item_array_2?></textarea>
			
			<input type='hidden' id='nmxh' name='nmxh' maxlength='250' size='30'  value=''>
		  </tr>
		<tr>
		  <td align="center" >
			<input id='all_save_button' type='button' value=' Save Submit '  onClick="relation_save_ALL_func()" title='relation Save'>&nbsp;&nbsp;&nbsp;
			<input id='all_reset_button' type='button' value=' Reset ' onClick="reset_confirm()"         title='Reset'  > &nbsp;&nbsp;&nbsp;
			<input id='all_delete_button' type='button' value=' Delete All ' onClick="delete_confirm()" title='Delete the entire relation.'  > 
			<!-- 관계식 전체를 삭제한다. -->
			</td>
		</tr>
		</FORM>
	</table>
<!-- </div> -->
<?php
	/*
	if( $mode=='pg_codeS_Search' || $relation_data !='' || $mode=='Save_OK' ){
			//echo "<script>init_relation('$relation_data');</script>";
			//$init=0;
	}*/

	function pg_tab_disp( $item_array ){
		global $key_, $pg_rel;
		global $mode;
		$pg_col_chk=0;
		$ck = ''; // key fld 'checked' 표시
		if( isset( $item_array ) && $item_array !=='' ){
			$col_ = explode( "@", $item_array );
			for( $i=0; $i < count($col_)-1; $i++) {
				$_col = explode("|", $col_[$i]);
				if( isset( $key_[1]) && isset($_col[1]) && $key_[1] == $_col[1] ) $ck = ' checked'; // 1: program table key field 
				else $ck = '';
				$pg_col_chk=0;
				$sel_color='white';
				for( $j=0; $j < count($pg_rel); $j++ )	if( $pg_rel[$j]==$_col[2] ) $pg_col_chk=1;
				if( $pg_col_chk==1 ) $sel_color ='cyan'; //if( $pg_col_chk==1 && $mode!=="Reset_Check" ) $sel_color ='cyan';
				echo "<label style='background-color:$sel_color;'><input type='radio' id='pg_tab_column' name='pg_tab_column' value='".$_col[1].":".$_col[2]."' ".$ck." >".$_col[2]."</label><br>";
			}//for
		}//if
	}
	function relation_table_disp( $tab_enmR ){
		global $tkher, $H_ID;
		global $key_, $re_rel;
		global $rel_cA,$rel_cB;
		$sql = "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enmR' order by disno asc";
		$result = sql_query($sql);
		if( isset($re_rel) ) $rcnt = count( $re_rel); //m_("cnt: " . $rcnt );
		else $rcnt = 0;
		while( $rsP = sql_fetch_array($result)) {
			if( $rsP['fld_enm'] =='seqno' )	{
				$R_item_array=$rsP['memo'];
				continue;
			}
			if( isset($key_[2]) && $key_[2] == $rsP['fld_enm'] ) {
				$ck = ' checked'; // relation tab
				$rel_cA = 'white'; $rel_cB = 'cyan';
			} else { 
				$ck = ''; 
				$rel_cA = 'white'; $rel_cB = 'white';
			}
			$pg_col_chk=0;
			$sel_color='white';
			for( $j=0; $j < count( $re_rel); $j++ ){
				if( isset($re_rel[$j]) && $re_rel[$j] == $rsP['fld_hnm'] ) {
					$pg_col_chk=1; // 1:관계식 설정된 컬럼.
					$sel_color ='cyan';
				} 
			}
			echo "<label style='background-color:".$sel_color.";' ><input type='radio' onclick='re_col_func(this.value)' id='re_tab_column' name='re_tab_column' value='".$rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type']."' ".$ck.">".$rsP['fld_hnm']."</label><br>";
		}//while
		return $R_item_array;
	}
	function relation_array( $relation_num ){
		global $data_R, $type_R, $tab_enmR, $tab_hnmR;
		global $relation_move_data, $relation_data;
		global $pg_rel, $re_rel;

		if( isset($data_R[$relation_num]) && $data_R[$relation_num] !='' && isset($type_R[$relation_num]) && $type_R[$relation_num] !='' ){
			$rel_ = explode("$", $data_R[$relation_num] ); //relation_num:0,1,2로하고 화면에는 1,2,3으로 표시만 중요.
			$key_ = explode(":", $type_R[$relation_num] );
			$tab_ = $rel_[0]; // 0:Relatio Table
			$tab_R    = explode(":", $rel_[0] );
			$tab_enmR = $tab_R[0];
			$tab_hnmR = $tab_R[1];
		} else {
			$tab_ = ''; // 0:Relatio Table
			$tab_enmR = '';
			$tab_hnmR = '';
		}
		if( $relation_reset =='on'){ // reset후 테이블을 선택했을 경우 여기로 탄다. 
				$relation_move_data = '';
				$relation_data = '';

		} else { // reset이 아니면 여기를 탄다.
			for( $i=1; isset($rel_) && $i < count( $rel_); $i++ ) { //$rel_[0] i==0 -> relation table
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
	}
	function relation_save( $pg_code ){
		global $tkher, $H_ID;
		global $relation_data_tab, $relation_type_key;
		$query = "UPDATE {$tkher['table10_pg_table']} SET relation_type='$relation_type_key', relation_data='$relation_data_tab' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) m_("Save, Complete the relationship. pg_code:".$pg_code);
		else my_msg("Program UPDATE error! ");
		//echo "<script>create_after_run( '$pg_codeS' , '$Rtab_hnmS' );</script>"; 
	}
	function relation_all_delete( $pg_code ){ //dao_1644456532:거래처$fld_2:거래처|=|fld_1:거래처명$fld_6:외상매출액|=|fld_5:매출총액
		global $tkher, $H_ID;
		$query="UPDATE {$tkher['table10_pg_table']} SET relation_data='', relation_type='' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) m_(" Delete, Complete the relationship. pg_code:".$pg_code);
		else m_("Program Delete error! ");
		echo "<script>delete_after_run( '' , '$pg_code' );</script>"; 
	}
	function item_color( $relation_num ){
		global $type_R,	$rel_cA, $rel_cB;
		if( $type_R[$relation_num] !== '' ){
			$rel_Qt   = explode(':' , $type_R[$relation_num] );
			$relation_Qtype = $rel_Qt[0]; // 'Insert' or 'Update'
			$relation_update_key = $rel_Qt[1];
		} else {
			$relation_Qtype = ''; // 'Insert' or 'Update'
			$relation_update_key = '';
		}
		if( $relation_Qtype == 'Insert') {
			$rel_cA = 'cyan';
			$rel_cB = 'white';
		} else if ( $relation_Qtype == 'Update'){
			$rel_cA = 'white';
			$rel_cB = 'cyan';
		}
	}
	function Fetch_pg_code($pg_code, $pg_name){
		global $relation_reset, $relation_num, $item_array, $tab_enm, $tab_hnm;
		global $relation_data_tab, $relation_type_key, $relation_key, $relation_data;
		global $relation_move_data;
		global $relation_data_old_0, $relation_key_old_0, $relation_data_old_1, $relation_key_old_1, $relation_data_old_2, $relation_key_old_2;
		global $data_R, $type_R;
		global $tab_enmR, $tab_hnmR;
		global $rel_cA, $rel_cB;
		global $key_, $rel_, $pg_rel, $re_rel;
		global $tkher;

		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='".$pg_code."' ";
		$resultPG= sql_query($sqlPG);	//$table10_pg	= sql_num_rows($resultPG);
		if( sql_num_rows($resultPG) > 0 ) {
			$rsPG = sql_fetch_array( $resultPG);
			$item_array	= $rsPG['item_array'];
			$tab_enm	= $rsPG['tab_enm'];
			$tab_hnm	= $rsPG['tab_hnm'];

			if( $rsPG['relation_data'] !=='' ) {
				$relation_data_tab = $rsPG['relation_data'];
				$relation_type_key = $rsPG['relation_type'];
				$relation_key = $rsPG['relation_type'];

				$data_R    = explode("@", $rsPG['relation_data'] );
				$type_R    = explode("@", $rsPG['relation_type'] );

				if(isset($data_R[0]) && $data_R[0]!==''){
					$relation_data_old_0 = $data_R[0];
					$relation_key_old_0 = $type_R[0];
					$relation_data_old_1 = $data_R[1];
					$relation_key_old_1 = $type_R[1];
					$relation_data_old_2 = $data_R[2];
					$relation_key_old_2 = $type_R[2];
				}

				if( isset($data_R[$relation_num]) && $data_R[$relation_num] !='' && isset($type_R[$relation_num]) && $type_R[$relation_num] !='' ){
					$rel_ = explode("$", $data_R[$relation_num] ); //relation_num:0,1,2로하고 화면에는 1,2,3으로 표시만 중요.
					$key_ = explode(":", $type_R[$relation_num] );
					$tab_ = $rel_[0]; // 0:Relatio Table
					$tab_R    = explode(":", $rel_[0] );
					$tab_enmR = $tab_R[0];
					$tab_hnmR = $tab_R[1];
				} else {
					$tab_ = ''; // 0:Relatio Table
					$tab_enmR = '';
					$tab_hnmR = '';
				}
				if( $relation_reset =='on'){ //if( $_POST['relation_reset']=='on' || $_POST['rel_job'] == 'add'){// reset후 테이블을 선택했을 경우 여기로 탄다. 
						$relation_move_data = '';
						$relation_data = '';
				} else { // reset이 아니면 여기를 탄다.

					for( $i=1; isset($rel_) && $i < count( $rel_); $i++ ) { //$rel_[0] i==0 -> relation table
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
			}
		}
	}
?>
</body>
</html>
