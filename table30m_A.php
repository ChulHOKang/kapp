<?php
	include_once('./tkher_start_necessary.php');
	/*
	 * table30m_A.php : table30m_Create.php copy 2023-08-25 - kan
	 - New_Create_Func()
	 - Save_Change_Func()
	 - Table_Copy_Func()
	 - Re_Create_Func()
	 - $del_mode : 'Modify_column_mode', 'Add_column_mode' , 'Delete_column_mode'
	 - TAB_curl_send( $tab_enm, $tab_hnm,0 , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ); - my_func

	  : 컬럼명 또는 컬럼 타이들을 변경 했을 때 관련 프로그램(table10_pg의 item_array)도 변경한다.
	  : 컬럼 위치 이동 과 이동후 컬럼 삭제 버턴 숨김 처리 추가.
	 */
	$H_ID= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';
	//m_("HTTP_HOST: " . getenv('HTTP_HOST') ); //HTTP_HOST: fation.net
	if( !isset($H_ID) || $H_LEV < 2 ){
		m_("You need to login.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( isset($_POST["tab_enm"]) ) $tab_enm	= $_POST["tab_enm"];
	else {
		$uid = explode('@', $H_ID);
		$tab_enm = $uid[0] . "_" . time();
	}

	if( isset($_POST['tab_hnm']) ) $tab_hnm	= $_POST["tab_hnm"];
	else $tab_hnm = '';
	if( isset($_POST['tab_hnmS']) ) $tab_hnmS	= $_POST["tab_hnmS"];
	else $tab_hnmS = '';
	if( isset($_POST['line_set']) ) $line_set = $_POST['line_set'];
	else $line_set = 10;
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['del_mode']) ) $del_mode = $_POST['del_mode'];
	else $del_mode = '';
	if( isset($_POST["group_code"])  && $_POST["group_code"] !== '') $group_code	= $_POST["group_code"];
	else  $group_code	= "";
	if( isset($_POST["group_name"])  && $_POST["group_name"] !== '') $group_name	= $_POST["group_name"];
	else  $group_name	= "";
	/*
	if( $mode == "table_name_change" && isset($tab_enm) ) {
			$aa = explode(':', $tab_hnmS);
			$tab_nmS0 = $aa[0];
			$tab_nmS1 = $aa[1];
			$mode ="Search";
			$query="update {$tkher['table10_table']} set tab_hnm='".$tab_hnm."' where tab_enm='$tab_nmS0' "; 
			$g = sql_query( $query );
			if( !$g ) m_("update error");
			else {
				$query="update {$tkher['table10_pg_table']} set tab_hnm='".$tab_hnm."'  where tab_enm='".$tab_nmS0."' "; 
				$g1 = sql_query( $query );
				$g1 = sql_query( $query );
				if( $g1 ) m_("Changed name of the Table table code: " . $tab_nmS0 . ", name:" . $tab_hnm . " <- " . $tab_nmS1);
				else m_("Error! Changed name of Table : " . $tab_nmS0 . ", name:" . $tab_hnm . " <- " . $tab_nmS1);
			}
	}*/
	/*
	if( $mode=='group_name_add'){
		$uid = explode('@', $H_ID); // id is email
		$group_code	= $uid[0] . "_" . time();
		$group_name	= $_POST["group_name"];
		$query="insert into {$tkher['table10_group_table']} set group_code='$group_code', group_name='$group_name', userid='$H_ID' , memo='table30m' ";
		$g = sql_query( $query );
		if( !$g ){ m_("Project Add error");
			echo "group sql: " . $query;
		} else  m_("Project added! ");
		$resultT = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID'  and tab_enm='$tab_enm' " );
		$total		= sql_num_rows( $resultT );
	}*/
?>

<html>
<head>
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
	<style>
	body, td, tr { font-size:10pt}
	a:link, a:visited, a:active {text-decoration:none; font-size:10pt; color:black}
	a:hover {text-decoration:yes; font-size:10pt; color:eeeeee}
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

<script language=javascript>
	function table_name_change(){
		tab_hnmS = document.insert.tab_hnmS.value;
		da = tab_hnmS.split(":");
		hnm=da[1];
		enm=da[0];
		tabhnm = document.insert.tab_hnm.value;
		if( tab_hnmS == "Select table" || !tabhnm ){
			alert("table none name or table select please!");
			return;
		} else {
			var ins = window.confirm("Do you want to change it? name:" + tabhnm);
			if (ins)
			{
				document.insert.mode.value = 'table_name_change';
				document.insert.action="table30m_A.php";
				document.insert.submit();
			}
		}
	}

	function change_table_func( thisS ) {
		tab = document.insert.tab_hnmS.value;
		da = tab.split(":");
		//document.insert.group_code_table.value=da[2];
		//document.insert.group_code.value=da[2];
		//document.insert.group_name.value=da[3];
		document.insert.mode.value='Search';
		document.insert.action="table30m_A.php";
		document.insert.submit();
	}

	function Project_change_func( cd){
		index=document.insert.group_code.selectedIndex;
		nm = document.insert.group_code.options[index].text;
		document.insert.group_name.value=nm;
		document.insert.old_group_code.value=document.insert.group_code.options[index].value;
		return;
	}

	function column_modify_mode_func( no,  table_yn, colunm_cnt, len ) {
		Alen = document.insert["Afld_len[" + no + "]"].value;
		len = document.insert["fld_len[" + no + "]"].value;
		Ahnm = document.insert["Afld_hnm[" + no + "]"].value;
		hnm = document.insert["fld_hnm[" + no + "]"].value;
		Aenm = document.insert["Afld_enm[" + no + "]"].value;
		enm = document.insert["fld_enm[" + no + "]"].value;
		Aftype = document.insert["Afld_type[" + no + "]"].value;
		ftype = document.insert["fld_type[" + no + "]"].value;
		Amemo = document.insert["Afld_memo[" + 0 + "]"].value; // column list
		if( document.insert["Afld_len["+no+"]"].value == len && document.insert["fld_hnm["+no+"]"].value==hnm && document.insert["fld_enm["+no+"]"].value==enm){
			alert(" name and length is same, You can only change the column name and length. "); // 컬럼명과 길이만 변경가능
			return false;
		}
		/*
		  Program을 Upgrade 했다면 컬럼 변경은 하지 않는것이 좋다. 잘못하면 속성이 엉컬어 질 수 있다.
		  컬럼 속성을 선언 하였다면 컬럼 길이만 변경 가능
		  컬럼 타입을 변경하는 것은 프로그램 Upgrade 하기전에 하는것이 좋다
		  컬럼의 속성이 선언 되었다면 컬럼 타입을 변경 하지 않는 것이 좋다. VARCHAR 를 INT 로의 변경 즉 문자 타입을 숫자 타입으로 변경은 오류를 유발한다.

		*/
		fld_enm = document.insert["fld_enm[" + no + "]"].value;
		fld_hnm = document.insert["fld_hnm[" + no + "]"].value;
		if( fld_hnm == "seqno"){
			alert(' Can not use column name seqno.');// \n 컬럼명 seqno를 사용할수 없습니다.
			return false;
		}
		for( var k=1; k < colunm_cnt; k++ ){
				khnm = document.insert["fld_hnm[" + k + "]"].value;
				kenm = document.insert["fld_enm[" + k + "]"].value;  
				if( fld_hnm == khnm || fld_enm == kenm ) {
					if( k != no ) {
						alert(' Column name '+ fld_enm + ', ' + fld_hnm +' can not be used as a duplicate.');//중복으로 사용할수 없습니다.
						// Column name fld_1, fld1 can not be used as a duplicate.
						return false;
					}
				}
		}
		msg = " Modify " + fld_hnm + " entry? "; //컬럼을 변경할까요?
		if( window.confirm( msg ) ) {
			document.insert.del_mode.value="Modify_column_mode";
			document.insert.mode.value="Search";
			document.insert.table_yn.value = table_yn;

			document.insert.add_column_enm.value = document.insert["fld_enm[" + no + "]"].value;
			document.insert.add_column_hnm.value = document.insert["fld_hnm[" + no + "]"].value;
			document.insert.add_column_type.value = document.insert["fld_type[" + no + "]"].value;
			document.insert.add_column_len.value = document.insert["fld_len[" + no + "]"].value;

			document.insert.old_column_enm.value = Aenm;
			document.insert.old_column_hnm.value = Ahnm;
			document.insert.old_column_type.value = Aftype;
			document.insert.old_column_len.value = Alen;
			document.insert.old_memo.value = Amemo;

			document.insert.add_column_memo.value = document.insert["memo[" + no + "]"].value;
			document.insert.del_seqno.value = document.insert["seqno[" + no + "]"].value;
			document.insert.action="table30m_A.php";
			document.insert.submit();
		}
	}

	function column_add_mode_func( no,  table_yn, column_cnt) {
		if( document.insert["fld_enm[" + no + "]"].value == '' ) {
			alert(" Define columns! "); //column을 정의 하세요!
			document.insert["fld_enm[" + no + "]"].focus();
			return false;
		} else if ( document.insert["fld_hnm[" + no + "]"].value == ''){
			alert(" Define column name!"); //column name을 정의 하세요!
			document.insert["fld_hnm[" + no + "]"].focus();
			return false;
		} else if ( document.insert["fld_len[" + no + "]"].value == ''){
			alert(" Define the column length!"); //column 길이를 정의 하세요!
			document.insert["fld_len[" + no + "]"].focus();
			return false;
		}
		fld_hnm = document.insert["fld_hnm[" + no + "]"].value;
		if( fld_hnm == 'seqno'){
			alert(' Can not use column name seqno.');//컬럼명 seqno를 사용할수 없습니다.
			return false;
		}
		msg = " Add " + fld_hnm + " entry? ";//컬럼을 추가할까요?
		if ( window.confirm( msg ) )
		{
			document.insert.del_mode.value		="Add_column_mode";
			document.insert.mode.value			="Search";
			document.insert.table_yn.value = table_yn;
			document.insert.add_column_hnm.value = document.insert["fld_hnm[" + no + "]"].value;
			document.insert.add_column_enm.value = document.insert["fld_enm[" + no + "]"].value;
			document.insert.add_column_type.value = document.insert["fld_type[" + no + "]"].value;
			document.insert.add_column_len.value = document.insert["fld_len[" + no + "]"].value;
			document.insert.add_column_memo.value = document.insert["memo[" + no + "]"].value;
			document.insert.action					="table30m_A.php";
			document.insert.submit();
		}
	}

	function delete_column_func(seqnoA, fld_hnmA, fld_enmA, i) {
		msg = " Delete " + fld_hnmA + " entry? ";//컬럼을 삭제할까요?
		if ( window.confirm( msg ) )
		{
			document.insert.del_mode.value		="Delete_column_mode";
			document.insert.mode.value			="Search";
			document.insert.pg_mode.value		="on";
			document.insert.del_seqno.value		=seqnoA;
			document.insert.del_fld_enm.value	=fld_enmA;
			document.insert.del_fld_hnm.value	=fld_hnmA;
			document.insert.action				="table30m_A.php";
			document.insert.submit();
		}
	}
	function Save_Update( cnt){ // Modification Registration - 수정등록
		tab_hnm = document.insert.tab_hnm.value;
		msg = " The data in the table is deleted.\n Want to regenerate? table is " + tab_hnm + " "; //테이블의 데이터가 삭제됩니다. 재생성 할까요?
		if ( window.confirm( msg ) )
		{
			tab = document.insert.tab_hnmS.value;
			document.insert.mode.value='table_update_remake';
			document.insert.del_mode.value		="";
			document.insert.action="table30m_A.php";
			document.insert.submit();
			return true;
		} else {
			return false;
		}
	}

	function type_set_func(i, v) {
		if( i==0 ) {
			alert('Can not be changed because it is a key.' );
			document.insert["fld_type[0]"].value = 'INT';
			return false;
		}
		if( document.insert["fld_type["+i+"]"].value == "INT") document.insert["fld_len["+i+"]"].value = '12';
		else if( document.insert["fld_type["+i+"]"].value == "TINYINT")   document.insert["fld_len["+i+"]"].value = '3';
		else if( document.insert["fld_type["+i+"]"].value == "SMALLINT")  document.insert["fld_len["+i+"]"].value = '5';
		else if( document.insert["fld_type["+i+"]"].value == "MEDIUMINT") document.insert["fld_len["+i+"]"].value = '8';
		else if( document.insert["fld_type["+i+"]"].value == "BIGINT")    document.insert["fld_len["+i+"]"].value = '15';
		else if( document.insert["fld_type["+i+"]"].value == "DECIMAL")   document.insert["fld_len["+i+"]"].value = '6';
		else if( document.insert["fld_type["+i+"]"].value == "FLOAT")     document.insert["fld_len["+i+"]"].value = '8.3';
		else if( document.insert["fld_type["+i+"]"].value == "DOUBLE")    document.insert["fld_len["+i+"]"].value = '12.3';
		else if( document.insert["fld_type["+i+"]"].value == "CHAR")      document.insert["fld_len["+i+"]"].value = '5';
		else if( document.insert["fld_type["+i+"]"].value == "VARCHAR")   document.insert["fld_len["+i+"]"].value = '15';
		else if( document.insert["fld_type["+i+"]"].value == "TEXT")      document.insert["fld_len["+i+"]"].value = '255';
		else if( document.insert["fld_type["+i+"]"].value == "DATE")      document.insert["fld_len["+i+"]"].value = '15';
		else if( document.insert["fld_type["+i+"]"].value == "DATETIME")  document.insert["fld_len["+i+"]"].value = '20';
		else if( document.insert["fld_type["+i+"]"].value == "TIME")      document.insert["fld_len["+i+"]"].value = '8'; // 2024-01-04 add
	}
	function line_set_func(cnt) {
			document.insert.mode.value='line_set';
			document.insert.line_set.value=cnt;
			document.insert.action="table30m_A.php";
			document.insert.submit();
	}

	function sendCon(form){
		f_nm = document.insert["fld_enm[0]"].value;
		if ( f_nm == "" ) {
			window.alert("An unentered field remains.");//입력 되지 않은 필드가 남아 있습니다.\n모두 입력하신 후에 계속등록하십시요.
		} else {
			document.insert.action="table30m_A.php";
			document.insert.submit();
		}
	}

	function table_create_func( line){
		if( !document.insert.userid.value) {
			alert(' Please login! ');
			return false;
		}
		else if( !document.insert.tab_hnm.value) {
			alert(' Please enter a table name! ');
			return false;
		}
		for(var i=0;i<line; i++){
			len = document.insert["fld_len[" + i + "]"].value;
			fnm = document.insert["fld_hnm[" + i + "]"].value;
			if( !len) {
				if( fnm ) {
					alert('Check the column length input! ');// 컬럼 길이 입력을 확인 하세요!
					return false;
				}
			}
		}
		var ins = window.confirm("Register and create the table. ");//테이블을 등록및 생성합니다.
		if (ins)
		  {
			document.insert.mode.value='table_create';
			document.insert.action="table30m_A.php";
			document.insert.submit();
		  }
	}

	function resetgo(){
		window.open( 'table30m_A.php' , '_self', '');
		return;
	}

	function Copy_Newtable_save( cnt){
		group_code = document.insert.group_code.value;
		group_name = document.insert.group_name.value;
		if( group_code == '' || group_name == '' ){
			alert("select project ");
			return false;
		}
		new_table_name = document.insert.tab_hnm.value;
		tab = document.insert.tab_hnmS.value;
		da = tab.split(":");
		hnm=da[1];
		enm=da[0];
		//document.insert.group_code.value=da[2];
		//document.insert.group_name.value=da[3];
		if( new_table_name == hnm ) {
			alert('Change the table name! ');//테이블명을 변경하세요!
			document.insert.tab_hnm.focus();
			return false;
		} else {
			var item_cnt = insert.tab_hnmS.options.length;
			for( i=0;i < item_cnt; i++){
				tabA = insert.tab_hnmS[i].value;
				tt = tabA.split(":");
				t = tt[1];
				if( new_table_name == t ) {
					alert('Table name is duplicate.' ); //Table명이 중복입니다.
					insert.tab_hnm.focus();
					return false;
				}
			}
			msg = " Do you want to save the new table name as " + new_table_name + "? ";//새로운 테이블명 " +new_table_name + "으로 생성할까요?
			if ( window.confirm( msg ) )
			{
					document.insert.mode.value='table_new_copy';
					document.insert.action="table30m_A.php";
					document.insert.submit();
					return;
			} else return false;
		}
	}

	function Save_Update_Insert(line){
		if( !document.insert.userid.value) {
			alert(' Please login! ');
			return false;
		}
		else if( !document.insert.tab_hnm.value) {
			alert(' Please enter a table name! ');
			return false;
		}
		for(var i=0;i<line; i++){
			len = document.insert["fld_len[" + i + "]"].value;
			fnm = document.insert["fld_hnm[" + i + "]"].value;
			if( !len) {
				if( fnm ) {
					alert('Check the column length input!'); //컬럼 길이 입력을 확인 하세요!
					return false;
				}
			}
		}
		var ins = window.confirm("Register the table. ");
		if (ins)
		{
			document.insert.mode.value='table_create_reaction';
			document.insert.action="table30m_A.php";
			document.insert.submit();
		}
	}

	function create_after_run_pg(tab_enm){
		document.insert.action	="tkher_program_data_list.php?pg_code=" +tab_enm;
		document.insert.target='_blank';
		document.insert.submit();
	}
	function create_after_run(tab_enm, tab_hnm, mode){
		var selectIndex = document.insert.tab_hnmS.selectedIndex;
		tab_hnmS=tab_enm + ":" + tab_hnm;
		document.insert.tab_hnmS[selectIndex].value = tab_hnmS;
		document.insert.mode.value		= "Search";
		document.insert.pg_mode.value		="on";
		document.insert.tab_enm.value	=tab_enm;
		document.insert.tab_hnm.value	=tab_hnm;
		document.insert.action					="table30m_A.php";
		document.insert.submit();
	}
	function ref_func( no ) {
		document.insert.no.value=no;
		fld_hnm = document.insert["fld_hnm[" + no + "]"].value;
		if( fld_hnm == "seqno"){
			alert(' Can not use column name seqno.');// \n 컬럼명 seqno를 사용할수 없습니다.
			return false;
		}
		window.open('./fld_select.php?no='+no,'','width=700,height=700, toolbar=no,scrollbars=yes,resizable=no');//pg_list_select_menu.php
	}
	var	fld_enmV, fld_hnmV, fld_typeV, fld_lenV, memoV,	seqnoV, Aif_lineV, Aif_typeV, Aif_dataV, Arelation_dataV;

	function up_bakup(j){
		fld_enmV  = document.insert["fld_enm[" + j + "]"].value;
		fld_hnmV  = document.insert["fld_hnm[" + j + "]"].value;
		fld_typeV = document.insert["fld_type[" + j + "]"].value;
		fld_lenV  = document.insert["fld_len[" + j + "]"].value;
		memoV     = document.insert["memo[" + j + "]"].value;
		seqnoV    = document.insert["seqno[" + j + "]"].value;
		Aif_lineV = document.insert["Aif_line[" + j + "]"].value;
		Aif_typeV = document.insert["Aif_type[" + j + "]"].value;
		Aif_dataV = document.insert["Aif_data[" + j + "]"].value;
		Arelation_dataV  = document.insert["Arelation_data[" + j + "]"].value;
	}
    function up_move(i, j){
		document.insert["fld_enm[" + j + "]"].value  = document.insert["fld_enm[" + i + "]"].value;
		document.insert["fld_hnm[" + j + "]"].value  = document.insert["fld_hnm[" + i + "]"].value;
		document.insert["fld_type[" + j + "]"].value  = document.insert["fld_type[" + i + "]"].value;
		document.insert["fld_len[" + j + "]"].value  = document.insert["fld_len[" + i + "]"].value;
		document.insert["memo[" + j + "]"].value  = document.insert["memo[" + i + "]"].value;
		document.insert["seqno[" + j + "]"].value  = document.insert["seqno[" + i + "]"].value;
		document.insert["Aif_line[" + j + "]"].value  = document.insert["Aif_line[" + i + "]"].value;
		document.insert["Aif_type[" + j + "]"].value  = document.insert["Aif_type[" + i + "]"].value;
		document.insert["Aif_data[" + j + "]"].value  = document.insert["Aif_data[" + i + "]"].value;
		document.insert["Arelation_data[" + j + "]"].value  = document.insert["Arelation_data[" + i + "]"].value;
	}
    function up_recover(i){
		fld_enmI = document.insert["fld_enm[" + i + "]"].value;
		fld_hnmI = document.insert["fld_hnm[" + i + "]"].value;
		document.insert["fld_enm[" + i + "]"].value  = fld_enmV;
		document.insert["fld_hnm[" + i + "]"].value  = fld_hnmV;
		document.insert["fld_type[" + i + "]"].value = fld_typeV;
		document.insert["fld_len[" + i + "]"].value  = fld_lenV;
		document.insert["memo[" + i + "]"].value     = memoV;
		document.insert["seqno[" + i + "]"].value    = seqnoV;
		document.insert["Aif_line[" + i + "]"].value = Aif_lineV;
		document.insert["Aif_type[" + i + "]"].value = Aif_typeV;
		document.insert["Aif_data[" + i + "]"].value = Aif_dataV;
		document.insert["Arelation_data[" + i + "]"].value = Arelation_dataV;
	}
    function up_func(){
		var i = document.insert.line_index.value;
		var j = i*1 -1; // 윗 라인 //alert('up_func i:' + i);

		if ( i > 0) {
			up_bakup(j);   // 윗라인 데이터 보관
			up_move(i, j);    // 현재라인 데이터 윗 라인으로 이동
			up_recover(i); // 보관한 윗라인 데이터 현재라인으로 이동
		} else {
			return;
		}
		document.insert.line_index.value = j;
	    $(".manager_"+i).css('display', 'none');
	    $(".manager_"+j).css('display', 'none');
		document.insert["fld_hnm[" + j + "]"].focus();
		return;
	}
    function down_func(){
		var i = document.insert.line_index.value;
		var j = i*1 +1; // 아랫 라인 //alert('down_func i:' + i + ', j:' +j);

		fld_enmV  = document.insert["fld_enm[" + j + "]"].value;
		fld_hnmV  = document.insert["fld_hnm[" + j + "]"].value; //alert('fld_enmV i:' + fld_enmV + ', fld_hnmV:' +fld_hnmV);

		if( fld_enmV == '' || fld_hnmV == '' ){
			alert('이동할 위치에 대이터가 존재하지 않습니다.');
			return;
		}
		if ( i > 0) {
			up_bakup(j);   // 아랫 라인 데이터 보관
			up_move(i, j);    // 현재라인 데이터 아랫 라인으로 이동
			up_recover(i); // 보관한 윗라인 데이터 현재라인으로 이동
		} else {
			return;
		}
		document.insert.line_index.value = j;
	    $(".manager_"+i).css('display', 'none');
	    $(".manager_"+j).css('display', 'none');
		document.insert["fld_hnm[" + j + "]"].focus();
		return;
	}
    function line_getA(no){
		document.insert.line_index.value = no;
	}
    function memo_set(memo){
		alert("memo: " + memo);
		//document.insert.line_index.value = no;
	}
</script>

<body>
<center>
<?php
		$cur='B';
		include_once "./menu_run.php";
		$userid	= $H_ID;
		$record_cnt = 0;
		$Aseqno		= array();
		$Afld_enm	= array();
		$Afld_hnm	= array();
		$Afld_type	= array();
		$Afld_len	= array();
		$Amemo		= array();
	
	if( $mode == 'Search' ){
			$aa = explode(':', $tab_hnmS);
			$tab_enm = $aa[0];
			$tab_hnm = $aa[1];
//			$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enm' order by disno" );
			$result = sql_query( "SELECT * from {$tkher['table10_table']} where tab_enm='$tab_enm' order by disno" );
			$record_cnt = sql_num_rows($result);
			$ARR=0;
			$item_array = "";
			$if_type = "";
			$if_data = "";
			while( $rs = sql_fetch_array($result)) {
					$fld_enm		= $rs['fld_enm'];
					$fld_hnm		= $rs['fld_hnm'];
				if($rs['fld_enm'] == 'seqno' )	{
					$userid				= $rs['userid']; // 한번만 처리하기.
					//$group_code		= $rs['group_code'];
					//$group_name		= $rs['group_name'];
					$tab_enm			= $rs['tab_enm'];
					$tab_hnm			= $rs['tab_hnm'];
					$table_yn			= $rs['table_yn'];
					$disno				= $rs['disno'];//	m_("000 disno:" . $disno);
					$Aseqno[0]			= $rs['seqno'];
					$Afld_enm[0]		= $rs['fld_enm'];
					$Afld_hnm[0]		= $rs['fld_hnm'];
					$Afld_type[0]		= $rs['fld_type'];
					$Afld_len[0]		= $rs['fld_len'];
					$Amemo[0]			= $rs['memo'];
				}else {
					$table_yn			= $rs['table_yn']; // add 2023-08-18
					$ARR++;
					$Aseqno	[$ARR]		= $rs['seqno'];
					$Afld_enm[$ARR]		= $rs['fld_enm'];
					$Afld_hnm[$ARR]		= $rs['fld_hnm'];
					$Afld_type[$ARR]		= $rs['fld_type'];
					$Afld_len[$ARR]		= $rs['fld_len'];
					$Amemo[$ARR]		= $rs['memo'];
					$fld_type	= $rs['fld_type'];
					$fld_len		= $rs['fld_len'];
					$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
					$if_type = $if_type . "|" . "0";
					$if_data = $if_data . "|" . "";
				}
			}//while
			$disno = $ARR +1;

			/*if( $pg_mode=="on" ){
				$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$tab_enm' ";
				$resultPG = sql_query($sqlPG);
				$table10_pg = sql_num_rows($resultPG);
				if( $table10_pg ) {
					$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', item_cnt=$ARR, item_array='$item_array' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
					sql_query($query);
				} else {
					$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', relation_type='',relation_data='', item_cnt=$cnt,  userid='$H_ID' ";
					sql_query($query);
					$link_ = $link_ = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=". $tab_enm;
					//insert_point_app( $H_ID, $config['kapp_write_point'], $link_, 'table10_pg@table30m' ); //PG create point
				}
				$pg_mode="";
			}*/
	} else if( $mode == "line_set" ) {
			$aa = explode(':', $tab_hnmS);
			$tab_enm = $aa[0];
			$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enm' order by disno" );
			$record_cnt = sql_num_rows($result);
			$ARR=0;
			while( $rs = sql_fetch_array($result)) {
					$fld_enm		= $rs['fld_enm'];
					$fld_hnm		= $rs['fld_hnm'];
				if( $rs['fld_enm'] == 'seqno' )	{
					$userid				= $rs['userid']; // 한번만 처리하기.
					$tab_enm			= $rs['tab_enm'];
					$tab_hnm			= $rs['tab_hnm'];
					$table_yn			= $rs['table_yn'];
					$disno				= $rs['disno'];
					$Aseqno	[0]			= $rs['seqno'];
					$Afld_enm[0]		= $rs['fld_enm'];
					$Afld_hnm[0]		= $rs['fld_hnm'];
					$Afld_type[0]		= $rs['fld_type'];
					$Afld_len[0]		= $rs['fld_len'];
					$Amemo[0]			= $rs['memo'];
					$Aif_line[0]		= $rs['if_line']; 
					$Aif_type[0]		= $rs['if_type']; 
					$Aif_data[0]		= $rs['if_data']; 
					$Arelation_data[0]	= $rs['Arelation_data']; 
				} else {
					$table_yn			= $rs['table_yn'];
					$ARR++;
					//$disno				= $rs['disno'];
					$Aseqno	[$ARR]		= $rs['seqno'];
					$Afld_enm[$ARR]		= $rs['fld_enm'];
					$Afld_hnm[$ARR]		= $rs['fld_hnm'];
					$Afld_type[$ARR]	= $rs['fld_type'];
					$Afld_len[$ARR]		= $rs['fld_len'];
					$Amemo[$ARR]		= $rs['memo'];
					$Aif_line[$ARR]		= $rs['if_line']; 
					$Aif_type[$ARR]		= $rs['if_type']; 
					$Aif_data[$ARR]		= $rs['if_data']; 
					$Arelation_data[$ARR]= $rs['Arelation_data']; 
				}
			}//while
	}
//	if( isset($_POST['group_code_table']) ) $group_code_table = $_POST['group_code_table'];
//	$group_code_table ='';
?>
	<Form METHOD='POST' name='insert' enctype="multipart/form-data">
		<input type="hidden" name="line_index" >
		<input type="hidden" name="no" >
		<input type="hidden" name="mode" >
		<input type="hidden" name="pg_mode" >
		<input type="hidden" name="del_mode" >
		<input type="hidden" name="del_seqno" >
		<input type="hidden" name="del_fld_hnm" >
		<input type="hidden" name="del_fld_enm" >
		<input type="hidden" name="tab_create_ok" value='<?=$tab_create_ok?>'>
		<input type="hidden" name="userid" value='<?=$userid?>'> <!--  H_ID -->
		<input type="hidden" name="tab_enm" value='<?=$tab_enm?>'>
		<input type="hidden" name="disno" value='<?=$disno?>'>
		<input type="hidden" name="add_column_no" value=''>
		
		<input type="hidden" name="add_column_enm" >
		<input type="hidden" name="add_column_hnm" >
		<input type="hidden" name="add_column_type" >
		<input type="hidden" name="add_column_len" >

		<input type="hidden" name="old_column_enm" >
		<input type="hidden" name="old_column_hnm" >
		<input type="hidden" name="old_column_type" >
		<input type="hidden" name="old_column_len" >
		<input type="hidden" name="old_memo" >

		<input type="hidden" name="add_column_memo" >
		<!-- <input type="hidden" name="group_code_table" value="<?=$group_code_table?>"> -->
		<input type="hidden" name="old_group_code" >
		<input type="hidden" name="old_group_name" >
		<input type="hidden" name="table_yn" value='<?=$table_yn?>'>
		<h2><font fce="Arial">Table Design High Level<?php if( $mode=='Search' ) echo "( Change )"; ?></font></h2>
<table border=0 bgcolor='#cccccc' cellpadding="1" cellspacing="3">
	<tr>
		<td bgcolor='#f4f4f4' title='You can change or add the group name of the table.'><font color='black'>Project</td>
		<td bgcolor='#ffffff'>
		<SELECT id='group_code' name='group_code' onchange="Project_change_func( this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered. ' "; ?> >
				<option value=''>Select project</option>
<?php
			$SQLG = "SELECT * from {$tkher['table10_group_table']} where userid='".$H_ID."' order by group_name ";
//			$SQLG = "SELECT * from {$tkher['table10_group_table']}  order by group_name ";
			$result = sql_query( $SQLG );
			while( $rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['group_code']?>" <?php //if($rs['group_code']==$group_code) echo " selected ";?> ><?=$rs['group_name']?></option>
<?php
			}
?>
			</select>
		</td>
		<td bgcolor='#ffffff' >&nbsp;<input type='text' name='group_name' size='15' value='<?=$group_name?>' style='height:25px;background-color:#666666;color:yellow;border:1 solid black' title='project name' readonly></td>
</tr>
<tr>
	<td bgcolor='#f4f4f4' <?php echo "title='Select a table from the list of registered tables.' "; ?>>Table Name</td>
	<td bgcolor='#ffffff'><SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_func( this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select a table from the list of registered tables.' "; ?> >
				<option value=''>Select table</option>
<?php
		if( $mode =='Search') {
?>
				<option value="<?php echo $tab_hnmS ?>"  selected ><?php echo $tab_hnm ?> </option>
<?php
		}
//		$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='".$H_ID."' and fld_enm='seqno'  order by upday desc");	//group by tab_enm " );
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where fld_enm='seqno'  order by upday desc");	//group by tab_enm " );
		while( $rs = sql_fetch_array($result)) {
?>
				<option title="user:<?=$rs['userid']?>" value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php if($rs['tab_hnm']==$tab_hnm) echo " selected "; ?>><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</select>
		</td><td bgcolor='#ffffff'>&nbsp;<input type='text' name='tab_hnm' size='15' maxlength='50' value='<?=$tab_hnm?>' style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>>
		</td>
		<!-- <td bgcolor='#f4f4f4'><input type='button' onclick="javascript:table_name_change();" value='Name Change' style='height:25px;background-color:cyan;border-radius:20px;border:1 solid black' <?php echo "title='name change of table' "; ?> ></td> -->
</tr>
</table>
				  Table:<?=$tab_enm?>, Line Count : <SELECT type='text' name="line_set" onchange="javascript:line_set_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Set the number of lines to be registered.' "; ?>><!--  \n등록할 라인수를 설정합니다. -->
					<option value="<?php echo $line_set ?>" selected ><?php if($mode=='Search') echo $record_cnt; else echo $line_set; ?> </option>
					  <option value="10" >10</option>
					  <option value="15" >15 </option>
					  <option value="20" >20 </option>
					  <option value="25" >25 </option>
					  <option value="30" >30 </option>
					  <option value="40" >40 </option>
					  <option value="50" >50 </option>
					  <option value="60" >60 </option>
					  <option value="70" >70 </option>
					  <option value="100" >100 </option>
					  <option value="150" >150 </option>
				  </select>

		<TABLE class='floating-thead' border=0 cellpadding="1" cellspacing="3">
		<THEAD >
			<TR align='center' style='background-color:eeeeee;'>
			 <TH><b>NO</b></TH>
			 <TH><b>Ref</b></TH>
			 <TH><b>column</b></TH>
			 <TH><b>column title</b></TH>
			 <TH><b>data type</b></TH>
			 <TH><b>size</b></TH>
			 <TH><b>memo</b></TH>
			 <?php if( $mode=='Search' ) echo "<TH><b>CTL</b></TH>"; ?>

			</TR>
<?php
			if( $mode=='Search' ) { $dis_cnt=$record_cnt +1;  }
			else if( $mode=='line_set' ) { $line_cnt=$_POST['line_set']; $dis_cnt=$_POST['line_set']; }
			else  $dis_cnt=$line_set;
			$if_lineA       = $i;
			$if_typeA       = '';
			$if_dataA       = '';
			$relation_dataA = '';
			For ($i = 0; $i < $dis_cnt  ; $i++) {
				if( $i < $record_cnt ) $m_line = 0;
				else $m_line = 1;
				if( $mode == 'Search' and $i < $dis_cnt) {
					if( isset($Aseqno[$i]) ) $seqno		=	$Aseqno[$i];
					if( isset($Afld_enm[$i]) ) $fld_enm	=	$Afld_enm[$i];
					else $fld_enm	=	"";
					if( isset($Afld_hnm[$i]) ) $fld_hnm	=	$Afld_hnm[$i];
					else $fld_hnm	=	"";
					if( isset($Afld_type[$i]) ) $fld_type	=	$Afld_type[$i];
					else $fld_type	=	"";
					if( isset($Afld_len[$i]) ) $fld_len	=	$Afld_len[$i];
					else $fld_len	=	"";
					if( isset($Amemo[$i]) ) $memo		=	$Amemo[$i];
					else $memo	=	"";
					if( isset($Aif_line[$i]) ) $if_lineA       = $Aif_line[$i]; 
					if( isset($Aif_type[$i]) ) $if_typeA       = $Aif_type[$i];
					if( isset($Aif_data[$i]) ) $if_dataA       = $Aif_data[$i];
					if( isset($Arelation_data[$i]) ) $relation_dataA = $Arelation_data[$i];
					$bcolor		= '#FFDF6E';
					$fcolor		= '#666666';
				} else if( $mode == 'Search' and $i == $line_set) {
					$fld_enm	=	'fld_' . $dis_cnt;
					$fld_hnm	=	"";
					$fld_type	=	"";
					$fld_len	=	"";
					$memo		=	"";
					$bcolor		= 'black';
					$fcolor		= 'yellow';
				} else if( $mode == 'Search' ) {
					$seqno		=	$Aseqno[$i];
					$fld_enm	=	$Afld_enm[$i];
					$fld_hnm	=	$Afld_hnm[$i];
					$fld_type	=	$Afld_type[$i];
					$fld_len	=	$Afld_len[$i];
					$memo		=	$Amemo[$i];
					$if_lineA       = $Aif_line[$i]; 
					$if_typeA       = $Aif_type[$i]; 
					$if_dataA       = $Aif_data[$i]; 
					$relation_dataA = $Arelation_data[$i]; 
					$bcolor		= '#FFDF6E';
					$fcolor		= '#666666';
				} else if( $mode == 'line_set' and $i < $record_cnt) {
					$seqno		=	$Aseqno[$i];
					$fld_enm	=	$Afld_enm[$i];
					$fld_hnm	=	$Afld_hnm[$i];
					$fld_type	=	$Afld_type[$i];
					$fld_len	=	$Afld_len[$i];
					$memo		=	$Amemo[$i];
					$if_lineA       = $Aif_line[$i]; 
					$if_typeA       = $Aif_type[$i]; 
					$if_dataA       = $Aif_data[$i]; 
					$relation_dataA = $Arelation_data[$i]; 
					$bcolor		= '#FFDF6E';
					$fcolor		= '#666666';
				} else if( $mode == 'line_set' and $i >= $record_cnt) {
					$fld_enm	=	'fld_' . $i;
					$fld_hnm	=	"";
					$fld_type	=	"";
					$fld_len	=	"";
					$memo		=	"";
					$bcolor		= 'black';
					$fcolor		= 'white';
				} else if( !isset($mode) ) {
					if( $i==0)	$fld_enm	=	'seqno';
					else		$fld_enm	=	'fld_' . $i;
					$fld_hnm	=	"";
					$fld_type	=	"";
					$fld_len	=	"";
					$memo		=	"";
					$bcolor		= '#FFDF6E';
					$fcolor		= '#666666';
				} else {
					if( $i==0)	$fld_enm	=	'seqno';
					else		$fld_enm	=	'fld_' . $i;
					$fld_hnm	=	"";
					$fld_type	=	"";
					$fld_len	=	"";
					$memo		=	"";
					$bcolor		= '#FFDF6E';
					$fcolor		= '#666666';
				}
?>
</THEAD>
<TBODY width='100%'>
	<TR valign='middle' bgcolor='#FFFFFF' bordercolor='#999999'>
		<td><B><?=$i?></B></font></TD><!-- No -->
			<input type="hidden" name="seq[<?=$i?>]" >
			<input type="hidden" name="seqno[<?=$i?>]" value='<?=$seqno?>'>
			<input type="hidden" name="fld_enm_old[<?=$i?>]" value='<?=$fld_enm?>'>
<?php if($mode=="Search"){	?>
			<input type="hidden" name="Afld_enm[<?=$i?>]" value='<?=$fld_enm?>'>
			<input type="hidden" name="Afld_hnm[<?=$i?>]" value='<?=$fld_hnm?>'>
			<input type="hidden" name="Afld_type[<?=$i?>]" value='<?=$fld_type?>'>
			<input type="hidden" name="Afld_len[<?=$i?>]" value='<?=$fld_len?>'>
			<input type="hidden" name="Afld_memo[<?=$i?>]" value='<?=$memo?>'>
<?php }	?>

			<input type="hidden" name="Aif_line[<?=$i?>]" value='<?=$if_lineA?>'>
			<input type="hidden" name="Aif_type[<?=$i?>]" value='<?=$if_typeA?>'>
			<input type="hidden" name="Aif_data[<?=$i?>]" value='<?=$if_dataA?>'>
			<input type="hidden" name="Arelation_data[<?=$i?>]" value='<?=$relation_dataA?>'>

		<td>
			<input type='button' name="fld_ref[<?=$i?>]" size='5' maxlength='10' value='Ref' onclick="ref_func('<?=$i?>')"
			style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' title='You can select an existing field by finding the material.'> </td><!-- 기존의 필드를 자료를 찾아서 선택 할 수 있습니다. -->
		<td align='left'>
			<input type='text' name="fld_enm[<?=$i?>]" size='10' maxlength='30' onclick="line_getA(<?=$i?>);"
			<?php if ( $fld_enm=='seqno' or $i==0) { echo "value='seqno' readonly ";  } else if ( $fld_enm ){ echo " value='$fld_enm' ";} ?>
			style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'> </td>
		<td align='left'>
			<input type='text' name="fld_hnm[<?=$i?>]" size='20' maxlength='30' onclick="line_getA(<?=$i?>);"
			<?php if ( $fld_enm=='seqno' or $i==0) { echo "value='seqno' readonly ";  } else if ( $fld_hnm ){ echo " value='$fld_hnm' ";} ?>
			style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' title="column:<?=$fld_enm?>"> </td>
		<td align='left'>
			  <select type='text' name="fld_type[<?=$i?>]" onchange="javascript:type_set_func('<?=$i?>', this.value);" style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' title='MYSQL basic '>
				  <option <?php echo "title='CHAR A fixed-length (0-255, default 1) string that fills the right with blanks to the specified length at all times when saved.' "; ?> value="CHAR" <?php if($fld_type == 'CHAR') echo " selected ";  ?> >CHAR</option>
				  <option <?php echo "title='VARCHAR Variable-length (0-65,535) string.' "; ?> value="VARCHAR" <?php if($fld_type == 'VARCHAR') echo " selected ";  ?> >VARCHAR</option>
				  <option <?php echo "title='TEXT Text column with a maximum length of 65535 (2 ^ 16-1) characters.' "; ?> value="TEXT" <?php if($fld_type == 'TEXT') echo " selected ";  ?>>TEXT</option>
				  <option <?php echo "title='INT The range of 4-byte integer types is 2147483647 with -2,147,483,647 when there is a sign, and 4,294,967,295 when there is no sign.' "; ?> value="INT" <?php if ( $i==0 ) { echo "selected"; } ?> <?php if($fld_type == 'INT') echo " selected ";  ?> >INT</option>
				  <option <?php echo "title='FLOAT A small floating-point number, acceptable values are -3.402823466E + 38 to -1.175494351E-38, 0, and 1.175494351E-38 to 3.402823466E + 38.' "; ?> value="FLOAT" <?php if($fld_type == 'FLOAT') echo " selected ";  ?>>FLOAT</option>
				  <option <?php echo "title='DOUBLE precision floating point numbers, acceptable values are -1.7976931348623157E + 308 to -2.2250738585072014E-308, 0, And from 2.2250738585072014E-308 to 1.7976931348623157E + 308.' "; ?> value="DOUBLE" <?php if($fld_type == 'DOUBLE') echo " selected ";  ?>>DOUBLE</option>
				  <option <?php echo "title='TINYINT The range of a 1-byte integer type is from -128 to 127 when it is signed, and from 0 to 255 when it is not signed.' "; ?> value="TINYINT" <?php if($fld_type == 'TINYINT') echo " selected ";  ?> >TINYINT</option>
				  <option <?php echo "title='SMALLINT The range of a 2-byte integer is -32,768 to 32,767 if signed and 0 to 65,355 if unsigned.' "; ?> value="SMALLINT" <?php if($fld_type == 'SMALLINT') echo " selected ";  ?> >SMALLINT</option>
				  <option <?php echo "title='MEDIUMINT The range of 3-byte integers is -8388608 to 8388607 if signed, and 0 to 16,777,215 if not signed.' "; ?> value="MEDIUMINT" <?php if($fld_type == 'MEDIUMINT') echo " selected ";  ?> >MEDIUMINT</option>
				  <option <?php echo "title='BIGINT An 8-byte integer type range is from -9,223,372,036,854,775,808 to +9,223,372,036,854,775,808 when there is a sign, and 18,446,744,073,709,551,615 when there is no sign.' "; ?> value="BIGINT" <?php if($fld_type == 'BIGINT') echo " selected ";  ?>>BIGINT</option>
				  <option <?php echo "title='DECIMAL Fixed-point number (M, D): The maximum number of digits (M) is 65 (default is 10) and the maximum number of decimal places (D is 30)' "; ?> value="DECIMAL" <?php if($fld_type == 'DECIMAL') echo " selected ";  ?>>DECIMAL</option>
				  <option <?php echo "title='DATE Date types 1000-01-01 through 9999-12-31 are available.' "; ?> value="DATE" <?php if($fld_type == 'DATE') echo " selected ";  ?>>DATE</option>
				  <option <?php echo "title='DATETIME Date and time combination, 1000-01-01 00:00:00 through 9999-12-31 23:59:59 Wanted.' "; ?> value="DATETIME" <?php if($fld_type == 'DATETIME') echo " selected ";  ?>>DATETIME</option><!-- 2023-07-18 kan -->
				  <option <?php echo "title='TIME Date and time combination, 00:00:00 through 23:59:59 Wanted.' "; ?> value="TIME" <?php if($fld_type == 'TIME') echo " selected ";  ?>>TIME</option><!-- 2024-01-04 kan -->
				  <!-- <option <?php echo "title='TIMESTAMP timestamp format 1970-01-01 00:00:01 UTC to 2038-01-09 03:14:07 UTC Until EPOCH (1970-01-01 00:00:00 UTC), the elapsed time in seconds since the number.' "; ?> value="TIMESTAMP" <?php if($fld_type == 'TIMESTAMP') echo " selected ";  ?>>TIMESTAMP</option>
				  <option <?php echo "title='Number auto increment type.' "; ?> value="INT" <?php if ( $i==0 ) { echo "selected"; } ?> >INT</option>-->
			  </select>
		</td>
<?php
				if ( $fld_enm=='seqno' or $i==0) {
				  $fld_len = 13; 
				  $fld_only=' readonly ';	//  echo "value='13' readonly"; 
				  $memo_v = "AUTO_INCREMENT , Key : Can not change readonly";
				}  else {
					  //echo " value='$fld_len' ";
					  $fld_len = $fld_len; 
					  $fld_only=' ';
					  $memo_v = $memo;
				}
?>
		<td align='left'>  <input type='text' name="fld_len[<?=$i?>]" size='3' maxlength='3' style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'  value='<?=$fld_len?>' <?=$fld_only?> >
		</td>
		<td align='left'>
			<input type='text' name="memo[<?=$i?>]"  style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'
			value='<?=$memo_v?>'
			<?php
				/*if ($fld_enm=='seqno' or $i==0) {
					echo " value='AUTO_INCREMENT , Key : Can not change' title='Can not change' readonly";
				} else {
					echo " value='$memo' ";
				}*/
			?> >
	   </td>
	<?php
		if( $mode=='Search') {
	?>
			<td align='left'>
	<?php
			if( $i > 0 ) {
				if( $m_line) {
					echo " <input type='button' name='add' onclick=\"javascript:column_add_mode_func('$i', '$table_yn', '$dis_cnt');\"  value='column add' style='height:22px;background-color:blue;color:yellow;border-radius:20px;border:1 solid black' title=' Add a column.'>";
				} else {
					echo " <div id='manager_".$i.">' class='manager_".$i."' style='display: ;' > ";
					echo " <input type='button' name='del' onclick=\"javascript:delete_column_func('$seqno', '$fld_hnm', '$fld_enm', '$i');\"  value='delete' style='height:22px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  title=' Delete a column.'>";
					echo " <input type='button' name='modify' onclick=\"javascript:column_modify_mode_func( '$i', '$table_yn', '$dis_cnt', '$fld_len');\"  value='modify' style='height:22px;background-color:blue;color:yellow;border:1 solid black' title=' Modify a column.\nOnly column name and length can be changed.\nAlso change the associated programs.'>"; //컬럼명과 길이만 변경가능

					echo "</div>";
				}
			} else {
				echo "";
			}

	?>
			</td>
<?php  } // if Search ?>
		</tr>
<?php } // for ?>
	<tr>
      <td colspan='8' align='center'>
	   <img src="./icon/bt_down_s02.gif" title="column down" border="0" onclick="down_func();" />&nbsp;&nbsp;
	   <img src="./icon/bt_up_s02.gif" title="column up" border="0" onclick="up_func();" />&nbsp;&nbsp;
<?php
		if( $mode=="Search") {
?>
			<input <?php echo "title='Delete the created table and register the changes.\nIf you only changed the column name and length,you don't need to run it.' "; ?> type='button' name='upd' onclick="javascript:Save_Update( '<?=$line_set?>');"
			value="Save Change" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
			<input <?php echo "title='Copy and Save as a new table.' "; ?> type='button' name='Newset' onclick="javascript:Copy_Newtable_save( '<?=$line_set?>');"
			value="Copy NewTable" style='height:25px;background-color:cyan;color:blue;border-radius:20px;border:1 solid white'>
			<input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else if( $mode=="line_set") {
?>
			<input <?php echo "title='Re-create the table after deletion.'"; ?> type='button' name='upd' onclick="javascript:Save_Update_Insert('<?=$line_set?>');"
			value="Change additional registration" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else {
?>
			<input <?php echo "title='Register and create the created table.' "; ?> type='button' name='ins' onclick="javascript:table_create_func( '<?=$line_set?>');"
			value="Create Table" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
			<input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		}
?>
        &nbsp
		<br><br><b>#There should be no spaces in the name of the column.
      </td>
    </tr>
	</TBODY>
  </TABLE>
</Form>
</body>
</html>

<?php
	$tabData['data'][][] = array();
	if( $del_mode == 'Modify_column_mode' ){ 
		$table_yn	=$_POST['table_yn'];
		$tab_enm	=$_POST['tab_enm'];
		$fld_enm	=$_POST['add_column_enm'];
		$fld_hnm	=$_POST['add_column_hnm'];
		$fld_type	=$_POST['add_column_type'];
		$fld_len	=$_POST['add_column_len'];
		$it_new = "|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len;
		$ofld_enm	=$_POST['old_column_enm'];
		$ofld_hnm	=$_POST['old_column_hnm'];
		$ofld_type	=$_POST['old_column_type'];
		$ofld_len	=$_POST['old_column_len'];
		$it_old = "|". $ofld_enm ."|". $ofld_hnm  ."|". $ofld_type ."|". $ofld_len;
		$fld_memo	=$_POST['add_column_memo'];
		$seqno		=$_POST['del_seqno'];
		if( isset($_POST['old_memo']) ) $Amemo	=$_POST['old_memo'];
		else $Amemo='';
		$item_arrayA = str_replace( $it_old, $it_new, $Amemo);
		if( $table_yn =='y' ) {
			if( $fld_type== 'CHAR' || $fld_type== 'VARCHAR' ) {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type . "(". $fld_len .") DEFAULT NULL";
			} else if( $fld_type== 'INT' || $fld_type =='FLOAT' || $fld_type =='DOUBLE' || $fld_type =='BIGINT' || $fld_type =='TINYINT' || $fld_type =='SMALLINT' || 'MEDIUMINT' || $fld_type =='DECIMAL' ) {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type . " DEFAULT 0 ";
			} else {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type ;
			}
			$mq1=sql_query($query);
			if( $mq1 ) {
				sql_query( "UPDATE {$tkher['table10_table']} set  memo='$item_arrayA' where tab_enm='$tab_enm' and fld_enm='seqno' " );
				sql_query( "UPDATE {$tkher['table10_table']} set  fld_hnm= '$fld_hnm', fld_type= '$fld_type', fld_len=$fld_len, memo='$fld_memo' where seqno=$seqno " );
				sql_query( "UPDATE {$tkher['table10_pg_table']} set  item_array='$item_arrayA' where tab_enm='$tab_enm' " );
				m_(" column update OK!! ");
				echo "<script>create_after_run_pg( '$tab_enm');</script>"; 
				exit;
			}
			else {
				printf(" sql:%s ", $query);
				m_(" column modify 실패------------!! ");
			}
		} else {
			$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len=$fld_len, userid='$H_ID', memo='$fld_memo', disno=$dis ";
			$ret = sql_query( $sql );
			if( $ret ) m_(" table10 column add OK!! ");
			else {
					echo "sql: " . $sql; exit;
			}
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";

	} else if( $del_mode == 'Add_column_mode' ){
		$table_yn	=$_POST['table_yn'];
		$tab_enm	=$_POST['tab_enm'];
		$dis		=$_POST['disno'];
		$fld_enm =$_POST['add_column_enm'];
		$fld_hnm =$_POST['add_column_hnm'];
		$fld_type=$_POST['add_column_type'];
		$fld_len =$_POST['add_column_len'];
		$fld_memo=$_POST['add_column_memo'];
		if( $table_yn =='y' ) {
			if( $fld_type== 'CHAR' || $fld_type== 'VARCHAR' ) {
				$query = "ALTER TABLE ". $tab_enm . " ADD COLUMN " . $fld_enm . " " . $fld_type . "(". $fld_len .") DEFAULT NULL ";
			} else if( $fld_type== 'INT' || $fld_type =='BIGINT' || $fld_type =='TINYINT' || $fld_type =='SMALLINT' || 'MEDIUMINT' || $fld_type =='DECIMAL' || $fld_type =='FLOAT' || $fld_type =='DOUBLE' ) {
				$query = "ALTER TABLE ". $tab_enm . " ADD COLUMN " . $fld_enm . " " . $fld_type . " DEFAULT 0 ";
			} else {
				$query = "ALTER TABLE $tab_enm ADD COLUMN $fld_enm $fld_type ";
			}
			$mq1 =sql_query($query);
			if( $mq1 ) {
				sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len=$fld_len, userid='$H_ID', memo='$fld_memo', disno=$dis " );
				m_(" column add OK!! ");
			}
			else {
				echo " sql:" . $query; m_(" column add 실패------------!! ");	
			}
		} else {
				sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', userid='$H_ID', memo='$fld_memo', disno=$dis " );
				m_(" table10 column add OK!! ");
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";

	} else if( $del_mode == 'Delete_column_mode' ){
		$seqno	= $_POST["del_seqno"]; 
		$fld_enm	= $_POST["del_fld_enm"];
		$query = "ALTER TABLE $tab_enm drop $fld_enm ";
		$mq1	=sql_query($query);
		$query = "DELETE from {$tkher['table10_table']} where userid='" .$H_ID. "' and seqno = ". $_POST["del_seqno"];
		$mq2	=sql_query($query);
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";
	}
	if( $mode == "table_create_reaction" ){
		Re_Create_Func();
	} else if( $mode == "table_update_remake" ){ // Save Change
		$view_set=1; // update_pg_func()에서 참고 내용을 1번만 출력 하도록 한다.
		Save_Change_Func();
	}
	if( $mode == "table_create" ) {
		New_Create_Func();
	} else if( $mode == "table_new_copy" ){	// copy and new.
		Table_Copy_Func();
	}
	//==========================================================================================
	function Re_Create_Func(){
		global $H_ID, $tab_enm, $mode, $tab_hnm;
		global $config;
		global $tkher;
		$query	= " DELETE from {$tkher['table10_table']} where tab_enm='".$tab_enm."' and userid='".$H_ID."' ";
		$mq1	= sql_query($query);
		$query	= "drop table " . $tab_enm;
		$mq2	= sql_query($query);
		$cnt=0;
		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " seqno int auto_increment not null, ";

		$item_list = $item_list . ' kapp_userid  VARCHAR(50),';
		$item_list = $item_list . ' kapp_pg_code VARCHAR(50),';

		$group_code = $_POST['group_code'];
		$group_name = $_POST['group_name'];
		$item_array = "";
		$if_type = "";
		$if_data = "";
		For( $ARR=1; $_POST["fld_hnm"][$ARR] ; $ARR++ ) {
			$fld_hnm	=	$_POST["fld_hnm"][$ARR];
			if( $fld_hnm ) {
				$seqno		=	$_POST["seqno"][$ARR];
				$fld_enm		=	$_POST["fld_enm"][$ARR];
				$fld_hnm		=	$_POST["fld_hnm"][$ARR];
				$fld_type	=	$_POST["fld_type"][$ARR];
				$fld_len		=	$_POST["fld_len"][$ARR];
				$memo		=	$_POST["memo"][$ARR];
				$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				if( $fld_type =='INT' )				$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='CHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				//		else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				sql_query( "INSERT INTO {$tkher['table10_table']} set  group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', memo='$memo' " );
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set  group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=$cnt, userid='$H_ID', table_yn='y', memo='key column', sqltable='$item_list' " );
		$line_set = $cnt;
		$mq3 = sql_query( $item_list );
		if( !$mq3 ) {
			m_("k1 $tab_enm table creation failed.");
			printf("sql:%s", $item_list);
			exit;
		} else m_("  Successful creation of the $tab_hnm table.");
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$tab_enm' ";
		$resultPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name',  item_cnt=$cnt, item_array='$item_array' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
			sql_query($query);
		} else {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$cnt,  userid='$H_ID',  tab_mid='$H_ID' ";
			sql_query($query);
			$link_ = KAPP_URL_T_ . "/table30m_A.php";
			//insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'table10_pg@table30m' );//PG create point
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' ,  '$mode' );</script>";
	}
	//==========================================
	function New_Create_Func(){
		global $H_ID, $tab_enm, $table_yn, $mode, $line_set, $ip;
		global $config;
		global $tkher;

		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " seqno int auto_increment not null, ";
		$item_list = $item_list . ' kapp_userid  VARCHAR(50),';
		$item_list = $item_list . ' kapp_pg_code VARCHAR(50),';

		$tab_hnm	= $_POST["tab_hnm"];
		$group_code	= $_POST["group_code"];
		$group_name	= $_POST["group_name"];
		$cnt = 1;
		$item_array = "";
			$if_type = "";
			$if_data = "";
		$item_cnt   = 0;
		For( $ARR=1; $ARR < $line_set ; $ARR++ ) {
			$fld_hnm	=	$_POST["fld_hnm"][$ARR];
			if( $fld_hnm ) {
				$seqno		=	$_POST["seqno"][$ARR];
				$fld_enm	=	$_POST["fld_enm"][$ARR];
				$fld_hnm	=	$_POST["fld_hnm"][$ARR];
				$fld_type	=	$_POST["fld_type"][$ARR];
				$fld_len	=	$_POST["fld_len"][$ARR];
				$memo		=	$_POST["memo"][$ARR];
				$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				if( $fld_type =='INT' )				$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='CHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$group_code', group_name='$group_name', memo='$memo' ";
				$ret = sql_query( $sql );
				if( !$ret ) {
					echo "sql: " . $sql; exit;
				}
				$Asqltable=''; $if_lineA=0; $if_typeA=''; $if_dataA=''; $relation_dataA='';
				//TAB_curl_move( $tab_enm, $tab_hnm, $fld_enm, $fld_hnm, $fld_type, $fld_len, $ARR, $memo, $Asqltable, $if_lineA, $if_typeA, $if_dataA, $relation_dataA); //my_func
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$line_set  = $cnt - 1;
		sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', group_code='$group_code', group_name='$group_name', memo='$item_array', sqltable='$item_list' " );

		TAB_curl_send( $tab_enm, $tab_hnm, 0, $item_list, 0, '', '', '', $item_array ); // table_create

		$fld_enm = "fld_" . $ARR;
		if( $table_yn == 'y') {
			$query	="drop table $tab_enm";
			$mq2	=sql_query($query);
			if( !$mq2 ) {
				m_("c1 $tab_hnm table creation failed.");
			}
			$mq1 = sql_query( $item_list );
			if( !$mq1 ) {
				m_("c2 $tab_enm table creation failed.");
			} else m_("  Successful creation of the $tab_hnm table.");
		} else {
			$mq1 = sql_query( $item_list );
			if( !$mq1 ) {
				echo "sql: " . $item_list;
				m_("c3 $tab_hnm table creation failed.");
				exit;
			} else {
				//m_("c  Successful creation of the $tab_hnm table.");
				$table_yn = 'y';
				//$link_ = KAPP_URL_T_ . "table30m_A.php";
				$link_ = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=". $tab_enm;
				insert_point_app( $H_ID, $config['kapp_write_point'], $link_, 'table10@table30m' );
			}
		}
		$sqlPG		= "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$tab_enm' ";
		$resultPG	= sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name',  item_cnt=$line_set, item_array='$item_array' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
			sql_query($query);
		} else {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$line_set,  userid='$H_ID',  tab_mid='$H_ID' ";
			$ret = sql_query($query);
			if( $ret ){
				$pg_url = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=". $tab_enm;
				$job_name = $tab_hnm;
				$aboard_no = $tab_enm;
				$job_group = "KAPP-Program";
				job_link_table_add( $tab_hnm, $tab_hnm, $pg_url, $aboard_no, $job_group, $job_name, 'P' );//curl 함께처리.
				m_(" $tab_hnm - pg create OK!");
				//$kapp_server = KAPP_URL_T_;
				//$up_day = date("Y-m-d H:i:s");
				//$memo = 'Table create and PG create';
				//Link_Table_curl_send( $tab_hnm, $pg_url, 'P', $kapp_server, $ip, $memo, $up_day );
			}
			//$link_ = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=". $tab_enm;
			//insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'table10_pg@table30m' );// PG create point
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$mode' );</script>";
	}
	//=============================================================
	function Table_Copy_Func(){
		global $H_ID, $mode, $group_code, $group_name;
		global $config;
		global $tkher;
		global $pg_code, $pg_name, $tab_enm, $tab_hnm, $tabData, $H_EMAIL, $hostnameA, $item_array;      

		$tab_enm		= $H_ID . "_" . time();
		$tab_hnm		= $_POST["tab_hnm"];
		$item_list  = " create table ". $tab_enm . " ( ";
		$item_list  = $item_list . " seqno int auto_increment not null, ";
		$item_list = $item_list . ' kapp_userid  VARCHAR(50),';
		$item_list = $item_list . ' kapp_pg_code VARCHAR(50),';
		$cnt = 1;
		$item_array = "";
		$if_type = "";
		$if_data = "";
		$item_cnt   = 0;
		For( $ARR=1; isset($_POST["fld_hnm"][$ARR]); $ARR++ ) {
			$fld_hnm	=	$_POST["fld_hnm"][$ARR];
			if( $fld_hnm ) {
				$seqno		=$_POST["seqno"][$ARR];
				$fld_enm	=$_POST["fld_enm"][$ARR];
				$fld_hnm	=$_POST["fld_hnm"][$ARR];
				$fld_type	=$_POST["fld_type"][$ARR];
				$fld_len	=$_POST["fld_len"][$ARR];
				$memo		=$_POST["memo"][$ARR];
				$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				if( $fld_type =='INT' )					$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='CHAR' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$group_code', group_name='$group_name', memo='$memo' " );
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', group_code='$group_code', group_name='$group_name', memo='$item_array', sqltable='$item_list' " );
		$line_set = $cnt;
		$fld_enm  = "fld_" . $ARR;
		$mq1 = sql_query( $item_list );
		if( !$mq1 ) {
			m_( $tab_hnm . "x1 table creation failed.");
		} else {
			m_("  Successful creation of the ".$tab_hnm." table.");
			$link_ = $link_ = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=". $tab_enm;
			insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'copy table10@table30m' );//re make copy
			TAB_curl_send( $tab_enm, $tab_hnm, 0, $item_list, 0, '', '', '', $item_array ); 
		}
		$tab_enm_copy	= $_POST['tab_enm'];
		$sqlPG		= "SELECT * from {$tkher['table10_pg_table']} where pg_code='".$tab_enm_copy."' ";
		$rsPG	= sql_fetch($sqlPG);
		if( $rsPG ) {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='".$rsPG['item_array']."', if_type='".$rsPG['if_type']."', if_data='".$rsPG['if_data']."', pop_data='".$rsPG['pop_data']."', relation_data='".$rsPG['relation_data']."', item_cnt=".$rsPG['item_cnt'].",  userid='$H_ID',  tab_mid='$H_ID' ";
			sql_query($query);

			$pg_code = $tab_enm;
			$pg_name = $tab_hnm;
			$pg_sys_link	= KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $pg_code;
			//insert_point_app( $H_ID, $config['kapp_comment_point'], $pg_sys_link, 'copy table10_pg@table30m' );// PG create point
			
			$tabData['data'][][] = ''; //array(); // use: PG_curl_send() - my_func
			PG_curl_send( $rsPG['item_cnt'] , $rsPG['item_array'], $rsPG['if_type'], $rsPG['if_data'], $rsPG['pop_data'], $pg_sys_link, $rsPG['relation_data'], $rsPG['relation_type'] );
			echo "<script>window.open( '".$pg_sys_link."' , '_blank', ''); </script>";
		} else {
			m_("table30m_A - Copy ERROR : mode:".$mode.", tab_enm_copy:".$tab_enm_copy );//table30m_A - Copy ERROR : mode:table_new_copy, tab_enm_copy:dao_1744229654
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$mode' );</script>";
	}
	function Save_Change_Func(){ // update_remake_func(){
		global $H_ID, $tab_enm, $mode;
		global $config;
		global $tkher;
		$query	="delete from {$tkher['table10_table']} where tab_enm='$tab_enm' and userid='$H_ID' ";
		$mq1	=sql_query($query);
		$query	="drop table $tab_enm";
		$mq2	=sql_query($query);
		$tab_hnm	= $_POST["tab_hnm"];	
		$cnt = 1;
		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " seqno int auto_increment not null, ";
		$item_list = $item_list . ' kapp_userid  VARCHAR(50),';
		$item_list = $item_list . ' kapp_pg_code VARCHAR(50),';

		$group_code = $_POST['group_code'];
		$group_name = $_POST['group_name'];
		$item_array = '';
		$if_type = '';
		$if_data = '';
		For( $ARR=1; $_POST["fld_hnm"][$ARR] ; $ARR++ ) {
			$fld_enmO	=	$_POST["Afld_enm"][$ARR];
			$fld_hnmO	=	$_POST["Afld_hnm"][$ARR];
			$fld_typeO	=	$_POST["Afld_type"][$ARR];
			$fld_lenO	=	$_POST["Afld_len"][$ARR];
			$fld_O      = "|". $fld_enmO ."|". $fld_hnmO  ."|". $fld_typeO ."|". $fld_lenO . "@";
			if( isset($_POST["Amemo"][$ARR]) ) $memoO=$_POST["Amemo"][$ARR];
			else $memoO ='';
			$fld_hnm	=	$_POST["fld_hnm"][$ARR];
			if( $fld_hnm ) {
				$seqno		=	$_POST["seqno"][$ARR];
				$fld_hnm	=	$_POST["fld_hnm"][$ARR];
				$fld_enm	=	$_POST["fld_enm"][$ARR];
				$fld_type	=	$_POST["fld_type"][$ARR];
				$fld_len	=	$_POST["fld_len"][$ARR];
				$memo		=	$_POST["memo"][$ARR];
				$if_lineA	=	$_POST["Aif_line"][$ARR];
				$if_typeA	=	$_POST["Aif_type"][$ARR];
				$if_dataA	=	$_POST["Aif_data"][$ARR];
				$relation_dataA	=	$_POST["Arelation_data"][$ARR];
				$Asqltable = '';
				$i_data = "|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$item_array = $item_array . "|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				if( $fld_enm !== $fld_enmO ) update_pg_func( $fld_enm, $fld_enmO, $i_data, $fld_O); // 컬럼명이 변경 되었을 때, 사용된 테이블 관련된 프로그램의 컬럼명을 변경한다.
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				if( $fld_type =='INT' )					$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='CHAR' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';	// no use
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';

				sql_query( "INSERT INTO {$tkher['table10_table']} set  group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', memo='$memo' " );
				//TAB_curl_move( $tab_enm, $tab_hnm, $fld_enm, $fld_hnm, $fld_type, $fld_len, $ARR, $memo, $Asqltable, $if_lineA, $if_typeA, $if_dataA, $relation_dataA);
				$cnt++;
			}
		} // for
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set  group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', memo='$item_array', sqltable='$item_list' " );
		$line_set = $cnt-1;
		TAB_curl_send( $tab_enm, $tab_hnm,0 , $item_list, $_POST["Aif_line"][0], $_POST["Aif_type"][0], $_POST["Aif_data"][0], $_POST["Arelation_data"][0], $item_array );

		$mq1 = sql_query( $item_list );
		if( !$mq1 ) {
			echo "sql:" . $item_list; exit;
		} else m_( $tab_enm . ", Successful creation of the " . $tab_hnm . " table.");

		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='".$tab_enm."' ";
		$resultPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			m_(" ok pg - update 1");
			$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name',  item_cnt=$line_set, item_array='$item_array' WHERE pg_code='$tab_enm' ";
			sql_query($query);
		} else {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$line_set,  userid='$H_ID',  tab_mid='$H_ID' ";
			sql_query($query);
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$mode' );</script>";
	}
	//컬럼명 또는 컬럼 타이들을 변경 했을 때 관련 프로그램도 변경(table10_pg의 item_array)
	//When you change a column name or column title, the related program also changes.
	function update_pg_func( $fld_enm, $fld_enmO, $i_data, $fld_O){ // Save_Change_Func()
		global $H_ID, $tab_enm, $mode, $view_set;
		global $config;
		global $tkher;
		$chg=0;
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where tab_enm='".$tab_enm."' ";
		$retPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($retPG);
		if( $table10_pg ) {
			while( $rs = sql_fetch_array( $retPG)) {
				$item_array = $rs['item_array'];
				$retA = str_replace($fld_O , $i_data, $item_array); 
				$query = "UPDATE {$tkher['table10_pg_table']} SET item_array='$retA' WHERE seqno=" . $rs['seqno'];
				sql_query($query);
				$chg=1;
			}
		}
		if( $chg == 1 && $view_set){
			m_( $table10_pg . ": Program - " . $rs['pg_code'] . ":" . $rs['pg_name'] . ", If you have settings for calculation formulas, pop-up windows, and relational expressions, you may need to check them. " . $item_array);
			$view_set = 0; //계산식, 팝업창, 관계식에 대한 설정 있다면 확인이 필요할 수 있습니다.
		}
	}
?>
