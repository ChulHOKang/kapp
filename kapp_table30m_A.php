<?php
	include_once('./tkher_start_necessary.php');
	/*
	 * kapp_table30m_A.php : table30m_Create.php copy 2023-08-25 - kan
	   2024-01-04   : TIME fld type add. $view_set=1 add
	   2024-01-03   : $item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 보완.
	   2023-10-12   : 컬럼명 또는 컬럼 타이들을 변경 했을 때 관련 프로그램(table10_pg의 item_array)도 변경한다 중요.
	                : 컬럼 위치 이동 과 이동후 컬럼 삭제 버턴 숨김 처리 추가 중요.
	 * TAB_curl_sendA( $tab_enm, $tab_hnm,0 , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ); // table_update_remake 2023-07-25 add
	 */
	$H_ID= get_session("ss_mb_id");
	$ip = $_SERVER['REMOTE_ADDR'];

	if( !isset($H_ID) ){
		m_("You need to login.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';

	if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode='';
	if( isset($_SESSION['project_nmS']) ) $project_nmS = $_SESSION['project_nmS'];
	if( isset($project_nmS) && $project_nmS !=='' ){
		$pcd_nm = explode(":", $project_nmS );
		if( isset($pcd_nm[0]) && $pcd_nm[0] !=='' ) $project_code	= $pcd_nm[0];
		else $project_code = '';	
		if( isset($pcd_nm[1]) && $pcd_nm[1] !=='' ) $project_name	= $pcd_nm[1]; 
		else $project_name= "";
	} else {
		$project_nmS = '';
		$project_name= "";
		$project_code= "";
	}

	if( $mode == 'SearchTAB' && isset($_SESSION['tab_hnmS']) ) {
		$tab_hnmS =$_SESSION['tab_hnmS'];
		$tab_R = explode(":", $tab_hnmS);
		$tab_enm = $tab_R[0];
		$tab_hnm = $tab_R[1];
		$new_tab_hnm = $tab_R[1];
		$project_code = $tab_R[2];
		$project_name = $tab_R[3];
	} else {
		$tab_hnmS = '';
		$tab_enm = '';
		$tab_hnm = '';
		$new_tab_hnm = '';
	}
		$uid = explode('@', $H_ID);
		$new_tab_enm = $uid[0] . "_" . time();

	if( isset($_POST['line_set']) ) $line_set = $_POST['line_set'];
	else $line_set = 10;
	if( isset($_POST['del_mode']) ) $del_mode = $_POST['del_mode'];
	else $del_mode = '';
	if( isset($_POST['pg_mode']) ) $pg_mode = $_POST['pg_mode'];
	else $pg_mode = '';
?>

<html>
<head>
<TITLE>K-APP. Made in Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
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
	/*function table_name_change(){ // add 2023-09-08 kan
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
				document.insert.action="kapp_table30m_A.php";
				document.insert.submit();
			}
		}
	}*/

	function column_modify_mode_func( no,  table_yn, colunm_cnt ) {
		fld_hnm = document.insert["fld_hnm[" + no + "]"].value;
		if( fld_hnm == "seqno"){
			alert(' Can not use column name seqno.');// \n 컬럼명 seqno를 사용할수 없습니다.
			return false;
		}
		for( var k=1; k < colunm_cnt; k++ ){
				knm = document.insert["fld_hnm[" + k + "]"].value;
				if( fld_hnm == knm) {
					if( k != no ) {
						alert(' Column name '+ fld_hnm +' can not be used as a duplicate.');//중복으로 사용할수 없습니다.
						return false;
					}
				}
		}
		msg = " Modify " + fld_hnm + " entry? "; //컬럼을 변경할까요?
		if ( window.confirm( msg ) )
		{
			document.insert.del_mode.value		="column_modify_mode";
			document.insert.mode.value			="SearchTAB";
			document.insert.table_yn.value = table_yn;
			document.insert.add_column_hnm.value = document.insert["fld_hnm[" + no + "]"].value;
			document.insert.add_column_enm.value = document.insert["fld_enm[" + no + "]"].value;
			document.insert.add_column_type.value = document.insert["fld_type[" + no + "]"].value;
			document.insert.add_column_len.value = document.insert["fld_len[" + no + "]"].value;
			document.insert.add_column_memo.value = document.insert["memo[" + no + "]"].value;
			document.insert.del_seqno.value = document.insert["seqno[" + no + "]"].value;
			document.insert.action					="kapp_table30m_A.php";
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
			document.insert.del_mode.value		="column_add_mode";
			document.insert.mode.value			="SearchTAB";
			document.insert.table_yn.value = table_yn;
			document.insert.add_column_hnm.value = document.insert["fld_hnm[" + no + "]"].value;
			document.insert.add_column_enm.value = document.insert["fld_enm[" + no + "]"].value;
			document.insert.add_column_type.value = document.insert["fld_type[" + no + "]"].value;
			document.insert.add_column_len.value = document.insert["fld_len[" + no + "]"].value;
			document.insert.add_column_memo.value = document.insert["memo[" + no + "]"].value;
			document.insert.action					="kapp_table30m_A.php";
			document.insert.submit();
		}
	}

	function delete_column_func(seqnoA, fld_hnmA, fld_enmA, i) {
		msg = " Delete " + fld_hnmA + " entry? ";//컬럼을 삭제할까요?
		if ( window.confirm( msg ) )
		{
			document.insert.del_mode.value		="Delete_column_mode";
			document.insert.mode.value			="SearchTAB";
			document.insert.pg_mode.value		="on";
			document.insert.del_seqno.value		=seqnoA;
			document.insert.del_fld_enm.value	=fld_enmA;
			document.insert.del_fld_hnm.value	=fld_hnmA;
			document.insert.action				="kapp_table30m_A.php";
			document.insert.submit();
		}
	}
	function Save_Update(cnt){ // Modification Registration - 수정등록
		tab_hnm = document.insert.tab_hnm.value;
		msg = " The data in the table is deleted. Want to regenerate? table is " + tab_hnm + " "; //테이블의 데이터가 삭제됩니다. 재생성 할까요?
		if ( window.confirm( msg ) )
		{
			tab = document.insert.tab_hnmS.value;
			document.insert.mode.value='table_update_remake';
			document.insert.del_mode.value		="";
			document.insert.action="kapp_table30m_A.php";
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
		else if( document.insert["fld_type["+i+"]"].value == "LONGBLOB")  document.insert["fld_len["+i+"]"].value = '255';
		else if( document.insert["fld_type["+i+"]"].value == "DATE")      document.insert["fld_len["+i+"]"].value = '15';
		else if( document.insert["fld_type["+i+"]"].value == "DATETIME")  document.insert["fld_len["+i+"]"].value = '20';
		else if( document.insert["fld_type["+i+"]"].value == "TIMESTAMP")  document.insert["fld_len["+i+"]"].value = '20';
		else if( document.insert["fld_type["+i+"]"].value == "TIME")      document.insert["fld_len["+i+"]"].value = '8';
	}
	function line_set_func(cnt) {
			document.insert.mode.value='line_set';
			document.insert.line_set.value=cnt;
			document.insert.action="kapp_table30m_A.php";
			document.insert.submit();
	}

	function sendCon(form){
		f_nm = document.insert["fld_enm[0]"].value;
		if ( f_nm == "" ) {
			window.alert("An unentered field remains.");//입력 되지 않은 필드가 남아 있습니다.\n모두 입력하신 후에 계속등록하십시요.
		} else {
			document.insert.action="kapp_table30m_A.php";
			document.insert.submit();
		}
	}

	function table_create_func(line){
		if( !document.insert.userid.value) {
			alert(' Please login! ');
			return false;
		}
		else if( !document.insert.new_tab_hnm.value) {
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
			document.insert.action="kapp_table30m_A.php";
			document.insert.submit();
		  }
	}
	
	function sql_func(){
		window.open( 'table_sql.php' , '_self', '');
		return;
	}
	function resetgo(){
		window.open( 'kapp_table30m_A.php?mode=Reset' , '_self', '');
		return;
	}

	function Newtable_save(cnt){
		new_table_name = document.insert.new_tab_hnm.value;
		tab = document.insert.tab_hnmS.value;
		da = tab.split(":");
		hnm=da[1];
		enm=da[0];
		document.insert.project_code.value=da[2];
		document.insert.project_name.value=da[3];
		if( new_table_name == hnm ) {
			alert('Change the table name! ');//테이블명을 변경하세요!
			document.insert.tab_hnm.focus();
			return false;
		} else {
			var item_cnt = insert.tab_hnmS.options.length;
			for(i=0;i < item_cnt; i++){
				tabA = insert.tab_hnmS[i].value;
				tt = tabA.split(":");
				t = tt[1];
				if( new_table_name == t ) {
					alert('Table name is duplicate.' );//Table명이 중복입니다.
					insert.tab_hnm.focus();
					return false;
				}
			}
			msg = " Do you want to save the new table name as " + new_table_name + "? ";//새로운 테이블명 " +new_table_name + "으로 생성할까요?
			if ( window.confirm( msg ) )
			{
					document.insert.old_tab_enm.value=enm;
					document.insert.mode.value='table_new_copy';
					document.insert.action="kapp_table30m_A.php";
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
			document.insert.action="kapp_table30m_A.php";
			document.insert.submit();
		}
	}

	function create_after_run(tab_enm, tab_hnm, mode){ // Add column alert(" ----- kapp_pg_curl_ajax");
		var selectIndex = document.insert.tab_hnmS.selectedIndex;
		tab_hnmS=tab_enm + ":" + tab_hnm;
		document.insert.tab_hnmS[selectIndex].value = tab_hnmS;
		document.insert.mode.value		= "SearchTAB";
		document.insert.pg_mode.value		="on";
		document.insert.tab_enm.value	=tab_enm;
		document.insert.tab_hnm.value	=tab_hnm;
jQuery(document).ready(function ($) {
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'kapp_pg_curl_ajax.php',
				data: {
					"mode_insert": 'pg_curl',
					"project_nm": project_nm,
					"memo": memo,
					"seq_no": seq_no
				},
			success: function(data) {
				//console.log(data);
				alert("OK --- " + seq_no);
				location.replace(location.href);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(" 올바르지 않습니다.-- kapp_project_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
});

		document.insert.action="kapp_table30m_A.php";
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

	function Project_change_funcX(cd){
		index=document.insert.project_code.selectedIndex;
		nm = document.insert.project_code.options[index].text;
		document.insert.project_name.value=nm;
		return;
	}
	function sendDataToPHP( projectnmS, pnmS) {
		fetch('kapp_save_session.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ projectnmS: projectnmS, pnmS: pnmS }),
		})
		.then(response => response.json())
		.then(data => {
			console.log('Success:', data);
			//location.href="kapp_table30m_A.php?mode=Project_Search";
			//location.replace(location.href);
		})
		.catch((error) => {
			console.error('Error:', error);
		});
	}
	function change_project_func(pnmS){
		sendDataToPHP('project_nmS', pnmS);
		location.href="kapp_table30m_A.php?mode=Project_Search";
	}
	function change_table_func(pnmS){ // Relation_Table_func
		/*
		alert("t: " + pnmS);//t: dao_1757214499:ABC:dao_1755421034:Project59
		da = pnmS.split(":");
		document.insert.project_nmS.value=pnmS;
		document.insert.project_code.value=da[2];
		document.insert.project_name.value=da[3];
		if( pnmS == '') {
			alert('Select Relation Table!');
			return false;
		}
		document.getElementById('mode').value = 'SearchTAB';
		document.getElementById('new_tab_hnm').value = da[1];
		alert("mode: " + document.getElementById('mode').value + ", " + document.getElementById('new_tab_hnm').value);
		*/
		sendDataToPHP('tab_hnmS', pnmS);
		location.href="kapp_table30m_A.php?mode=SearchTAB";
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
	
	if( $mode == 'SearchTAB' || $tab_hnmS !==''){
		$aa = explode(':', $tab_hnmS);
		$tab_enm = $aa[0];
		$tab_hnm = $aa[1];
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enm' order by disno" );
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
				$project_code		= $rs['group_code'];
				$project_name		= $rs['group_name'];
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
				$Aseqno[$ARR]		= $rs['seqno'];
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

		if( $pg_mode=="on" ){
			$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$tab_enm' ";
			$resultPG = sql_query($sqlPG);
			$table10_pg = sql_num_rows($resultPG);
			if( $table10_pg ) {
				$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', item_cnt=$ARR, item_array='$item_array' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
				sql_query($query);
			} else {
				$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', relation_type='',relation_data='', item_cnt=$cnt, userid='$H_ID', tab_mid='$H_ID' ";
				sql_query($query);
				$link_ = KAPP_URL_T_ . "kapp_table30m_A.php";
				//insert_point_app( $H_ID, $config['kapp_write_point'], $link_, 'table10_pg@table30m' ); //PG create point
			}
			$pg_mode="";
		}
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
				$Aseqno[$ARR]		= $rs['seqno'];
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
?>
	<Form METHOD='POST' name='insert' enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" >
		<input type="hidden" name="old_tab_enm" id="old_tab_enm" value=''>
		<input type="hidden" name="new_tab_enm" id="new_tab_enm" value='<?=$new_tab_enm?>'>
		<input type="hidden" name="project_code" id="project_code" value='<?=$project_code?>'>
		<input type="hidden" name="project_name" id="project_name" value='<?=$project_name?>'>
		<input type="hidden" name="line_index" >
		<input type="hidden" name="no" >
		<input type="hidden" name="pg_mode" >
		<input type="hidden" name="del_mode" >
		<input type="hidden" name="del_seqno" >
		<input type="hidden" name="del_fld_hnm" >
		<input type="hidden" name="del_fld_enm" >
		<input type="hidden" name="userid" value='<?=$userid?>'> <!--  H_ID -->
		<input type="hidden" name="disno" value='<?=$disno?>'>
		<input type="hidden" name="add_column_no" value=''>
		<input type="hidden" name="add_column_enm" >
		<input type="hidden" name="add_column_hnm" >
		<input type="hidden" name="add_column_type" >
		<input type="hidden" name="add_column_len" >
		<input type="hidden" name="add_column_memo" >
		<input type="hidden" name="table_yn" value='<?=$table_yn?>'>

		<h2><font fce="Arial">Table Design High Level<?php if( $mode=='SearchTAB' ) echo "( Change )"; ?></font></h2>

<div>
	<ul>
		<span bgcolor='#f4f4f4' <?php echo "title='You can change or add the group name of the table.' "; ?>><font color='black'>Project</span>
		<span bgcolor='#ffffff'>
			<SELECT id='project_nmS' name='project_nmS' onchange="change_project_func(this.value);" style="width:250px;height:30px;background-color:#FFDF6E;border:1 solid black" <?php echo "title='Select the classification of the table to be registered.' "; ?>>
<?php 
		if( isset( $_SESSION['project_nmS']) ) echo "<option value='$project_nmS' selected >$project_name</option>";
		else echo "<option value=''>1.Select Project</option>";

		$result= sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " ); 
		while( $rs = sql_fetch_array($result)) {
?>
			<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' <?php if( $project_code==$rs['group_code']) echo ' selected '; ?> ><?=$rs['group_name']?></option>
<?php	} ?>
		</SELECT>
		</span>




</ul>
<ul>
	<span bgcolor='#f4f4f4' <?php echo "title='Select a table from the list of registered tables.' "; ?>>Table Name</span>
	<span bgcolor='#ffffff'><input type='text' id='new_tab_hnm' name='new_tab_hnm'  value='<?=$new_tab_hnm?>' style='width:250px;height:30px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>></span>
		<span bgcolor='#ffffff'>
		
		<SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_func(this.value);" style='width:250px;height:30px;background-color:#FFDF6E;border:1 solid black' >
<?php
		if( $mode =='SearchTAB') echo "<option value='$tab_hnmS' selected >$tab_hnm</option>";
		else echo "<option value=''>2.Select Table</option>";
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where group_code='$project_code' and userid='".$H_ID."' and fld_enm='seqno'  order by upday desc");	//group by tab_enm " );
		while( $rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php if($rs['tab_hnm']==$tab_hnm) echo " selected "; ?> title='table code:<?=$rs['tab_enm']?>'><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</SELECT>
		
		</span>

		<!-- <span bgcolor='#f4f4f4'><input type='button' onclick="javascript:table_name_change();" value='Name Change' style='height:25px;background-color:cyan;border-radius:20px;border:1 solid black' <?php echo "title='name change of table' "; ?> ></span> -->
</ul>
</div>

<!-- <div>
<input type='button' value='SQL to Table' onclick="sql_func()" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white' title='You can SQL to Table.'>
</div> -->

<div>
	  New Table Code:<?=$tab_enm?>, Column Count : <SELECT type='text' name="line_set" onchange="javascript:line_set_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Set the number of lines to be registered.' "; ?>><!--  \n등록할 라인수를 설정합니다. -->
		<option value="<?php echo $line_set ?>" selected ><?php if($mode=='SearchTAB') echo $record_cnt; else echo $line_set; ?> </option>
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
</div>
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
		 <?php if( $mode=='SearchTAB' ) echo "<TH><b>CTL</b></TH>"; ?>
		</TR>
	</THEAD>
<?php
	if( $mode=='SearchTAB' ) { $dis_cnt=$record_cnt +1;  }
	else if( $mode=='line_set' ) { $line_cnt=$_POST['line_set']; $dis_cnt=$_POST['line_set']; }
	else  $dis_cnt=$line_set;
	$if_lineA       = $i;
	$if_typeA       = '';
	$if_dataA       = '';
	$relation_dataA = '';
	For ($i = 0; $i < $dis_cnt  ; $i++) {
		if( $i < $record_cnt ) $m_line = 0;
		else $m_line = 1;
		if( $mode == 'SearchTAB' and $i < $dis_cnt) {
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
		} else if( $mode == 'SearchTAB' and $i == $line_set) {
			$fld_enm	=	'fld_' . $dis_cnt;
			$fld_hnm	=	"";
			$fld_type	=	"";
			$fld_len	=	"";
			$memo		=	"";
			$bcolor		= 'black';
			$fcolor		= 'yellow';
		} else if( $mode == 'SearchTAB' ) {
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
<TBODY width='100%'>
	<TR valign='middle' bgcolor='#FFFFFF' bordercolor='#999999'>
		<td><B><?=$i?></B></font></TD><!-- No -->
			<input type="hidden" name="seq[<?=$i?>]" >
			<input type="hidden" name="seqno[<?=$i?>]" value='<?=$seqno?>'>
			<input type="hidden" name="fld_enm_old[<?=$i?>]" value='<?=$fld_enm?>'>
<?php if($mode=="SearchTAB"){	?>
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
				  <option <?php echo "title='TINYINT The range of a 1-byte integer type is from -128 to 127 when it is signed, and from 0 to 255 when it is not signed.' "; ?> value="TINYINT" <?php if($fld_type == 'TINYINT') echo " selected ";  ?> >TINYINT</option>
				  <option <?php echo "title='SMALLINT The range of a 2-byte integer is -32,768 to 32,767 if signed and 0 to 65,355 if unsigned.' "; ?> value="SMALLINT" <?php if($fld_type == 'SMALLINT') echo " selected ";  ?> >SMALLINT</option>
				  <option <?php echo "title='MEDIUMINT The range of 3-byte integers is -8388608 to 8388607 if signed, and 0 to 16,777,215 if not signed.' "; ?> value="MEDIUMINT" <?php if($fld_type == 'MEDIUMINT') echo " selected ";  ?> >MEDIUMINT</option>
				  <option <?php echo "title='BIGINT An 8-byte integer type range is from -9,223,372,036,854,775,808 to +9,223,372,036,854,775,808 when there is a sign, and 18,446,744,073,709,551,615 when there is no sign.' "; ?> value="BIGINT" <?php if($fld_type == 'BIGINT') echo " selected ";  ?>>BIGINT</option>
				  <option <?php echo "title='DECIMAL Fixed-point number (M, D): The maximum number of digits (M) is 65 (default is 10) and the maximum number of decimal places (D is 30)' "; ?> value="DECIMAL" <?php if($fld_type == 'DECIMAL') echo " selected ";  ?>>DECIMAL</option>
				  <option <?php echo "title='FLOAT A small floating-point number, acceptable values are -3.402823466E + 38 to -1.175494351E-38, 0, and 1.175494351E-38 to 3.402823466E + 38.' "; ?> value="FLOAT" <?php if($fld_type == 'FLOAT') echo " selected ";  ?>>FLOAT</option>
				  <option <?php echo "title='DOUBLE precision floating point numbers, acceptable values are -1.7976931348623157E + 308 to -2.2250738585072014E-308, 0, And from 2.2250738585072014E-308 to 1.7976931348623157E + 308.' "; ?> value="DOUBLE" <?php if($fld_type == 'DOUBLE') echo " selected ";  ?>>DOUBLE</option>
				  <option <?php echo "title='DATE Date types 1000-01-01 through 9999-12-31 are available.' "; ?> value="DATE" <?php if($fld_type == 'DATE') echo " selected ";  ?>>DATE</option>
				  <option <?php echo "title='DATETIME Date and time combination, 1000-01-01 00:00:00 through 9999-12-31 23:59:59 Wanted.' "; ?> value="DATETIME" <?php if($fld_type == 'DATETIME') echo " selected ";  ?>>DATETIME</option><!-- 2023-07-18 kan -->
				  <option <?php echo "title='TIME Date and time combination, 00:00:00 through 23:59:59 Wanted.' "; ?> value="TIME" <?php if($fld_type == 'TIME') echo " selected ";  ?>>TIME</option><!-- 2024-01-04 kan -->
				  
				  <option <?php echo "title='TIMESTAMP timestamp format 1970-01-01 00:00:01 UTC to 2038-01-09 03:14:07 UTC Until EPOCH (1970-01-01 00:00:00 UTC), the elapsed time in seconds since the number.' "; ?> value="TIMESTAMP" <?php if($fld_type == 'TIMESTAMP') echo " selected ";?> >TIMESTAMP</option>

				  <option <?php echo "title='LONGBLOB Length Maximum data size: 4GiB' "; ?> value="LONGBLOB" <?php if( $fld_type=='LONGBLOB') echo " selected ";?> >LONGBLOB</option>
				  <!-- 데이터 최대크기 4GiB -->
			  </select>
		</td>
		<td align='left'>  <input type='text' name="fld_len[<?=$i?>]" size='3' maxlength='3' style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'
<?php
				if ( $fld_enm=='seqno' or $i==0) { echo "value='13' readonly"; } else { echo " value='$fld_len' ";}
?>  >
		</td>
		<td align='left'>
			<input type='text' name="memo[<?=$i?>]"  style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'
			<?php
				if ($fld_enm=='seqno' or $i==0) {
					echo " value='AUTO_INCREMENT , Key : Can not change' title='Can not change' readonly";
				} else {
					echo " value='$memo' ";
				}
			?> >
	   </td>
	<?php
		if($mode=='SearchTAB') {
	?>
			<td align='left'>
	<?php
			if ( $i > 0 ) {
				if ($m_line) {
					echo " <input type='button' name='add' onclick=\"javascript:column_add_mode_func('$i', '$table_yn', '$dis_cnt');\"  value='column add' style='height:22px;background-color:blue;color:yellow;border-radius:20px;border:1 solid black' title=' Add a column.'>";
				}else {
					echo " <div id='manager_".$i.">' class='manager_".$i."' style='display: ;' > ";

					echo " <input type='button' name='del' onclick=\"javascript:delete_column_func('$seqno', '$fld_hnm', '$fld_enm', '$i');\"  value='delete' style='height:22px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  title=' Delete a column.'>";
					// 변경버턴 막아둔다 20230920 - echo " <input type='button' name='modify' onclick=\"javascript:column_modify_mode_func('$i', '$table_yn', '$dis_cnt');\"  value='modify' style='height:22px;background-color:blue;color:yellow;border:1 solid black' title=' Modify a column.'>";

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
		if( $mode=="SearchTAB") {
?>
			<input title='Delete the created table and register the changes.' type='button' id='upd' onclick="javascript:Save_Update('<?=$line_set?>');"
			value="Save Change" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'>&nbsp;&nbsp;&nbsp;
			<input title='Save as a new table. table code:<?=$new_tab_enm?>' type='button' id='Newset' onclick="javascript:Newtable_save('<?=$line_set?>');"
			value="Copy New Table" style='height:30px;background-color:cyan;color:blue;border-radius:20px;border:1 solid white'>&nbsp;&nbsp;&nbsp;
			<input title='Change to the table registration screen.' type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else if( $mode=="line_set") {
?>
			<input <?php echo "title='Re-create the table after deletion.'"; ?> type='button' name='upd' onclick="javascript:Save_Update_Insert('<?=$line_set?>');"
			value="Change additional registration" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else {
?>
			<input <?php echo "title='Register and create the created table.' "; ?> type='button' name='ins' onclick="javascript:table_create_func('<?=$line_set?>');"
			value="Create Table" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
			<input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
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
	if( $del_mode == 'column_modify_mode' ){ // column update - no use
		$table_yn	=$_POST['table_yn'];
		//$tab_enm	=$_POST['tab_enm'];
		$fld_enm	=$_POST['add_column_enm'];
		$fld_hnm	=$_POST['add_column_hnm'];
		$fld_type	=$_POST['add_column_type'];
		$fld_len	=$_POST['add_column_len'];
		$fld_memo	=$_POST['add_column_memo'];
		$seqno		=$_POST['del_seqno'];
		if( $table_yn =='y' ) {
			if( $fld_type== 'CHAR' || $fld_type== 'VARCHAR' ) {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type . "(". $fld_len .") DEFAULT NULL";
			} else if( $fld_type== 'INT' || $fld_type =='BIGINT' || $fld_type =='TINYINT' || $fld_type =='SMALLINT' || 'MEDIUMINT' || $fld_type =='DECIMAL' || $fld_type =='FLOAT' || $fld_type =='DOUBLE' ) {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type . " DEFAULT 0 ";
			} else {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type ;
			}
			$mq1	=sql_query($query);
			if( $mq1 ) {
				sql_query( "UPDATE {$tkher['table10_table']} set  fld_hnm= '$fld_hnm', fld_type= '$fld_type', fld_len=$fld_len, memo='$fld_memo' where seqno=$seqno " );
				m_(" column update OK!! ");
			}
			else {
				printf(" sql:%s ", $query);
				m_(" column modify 실패------------!! ");
			}
		} else {
			$sql = "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len=$fld_len, userid='$H_ID', memo='$fld_memo', disno=$dis ";
			$ret = sql_query( $sql );
			if( $ret ) m_(" table10 column add OK!! ");
			else {
					echo "sql: " . $sql; exit;
			}
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";

	} else if( $del_mode == 'column_add_mode' ){
		$table_yn	=$_POST['table_yn'];
		//$tab_enm	=$_POST['tab_enm'];
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
				sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len=$fld_len, userid='$H_ID', memo='$fld_memo', disno=$dis " );
				m_(" column add OK!! ");
			}
			else {
				echo " sql:" . $query; m_(" column add 실패------------!! ");	
			}
		} else {
				sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', userid='$H_ID', memo='$fld_memo', disno=$dis " );
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
		create_reaction_func();
	} else if( $mode == "table_update_remake" ){
		$view_set=1; // update_pg_func()에서 참고 내용을 1번만 출력 하도록 한다.
		update_remake_func();
	}
	if( $mode == "table_create" ) {
		create_func();
	} else if( $mode == "table_new_copy" ){	// copy and new.
		copy_func();
	}
	//==========================================================================================

	//$tabData['data'][][] = array();
	function TAB_curl_sendA( $tab_enm, $tab_hnm, $cnt , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ){
		//m_("start --- TAB_curl_sendA ");
		global $H_ID, $H_EMAIL, $project_code, $project_name;
		global $kapp_mainnet;
		$tabData['data'][][] = array();
		$tabData['data'][$cnt]['tab_enm']  = $tab_enm;
		$tabData['data'][$cnt]['tab_hnm']  = $tab_hnm;
		$tabData['data'][$cnt]['fld_enm']  = 'seqno';
		$tabData['data'][$cnt]['fld_hnm']  = 'seqno';
		$tabData['data'][$cnt]['fld_type'] = 'INT';
		$tabData['data'][$cnt]['fld_len']  = '10';
		$tabData['data'][$cnt]['disno']    = $cnt;
		$tabData['data'][$cnt]['userid']     = $H_ID;
		$tabData['data'][$cnt]['group_code'] = $project_code;
		$tabData['data'][$cnt]['group_name'] = $project_name;
		$tabData['data'][$cnt]['memo']       = $memo;
		$hostname = KAPP_URL_T_; // getenv('HTTP_HOST');
		$tabData['data'][$cnt]['host']       = $hostname;
		$tabData['data'][$cnt]['email']      = $H_EMAIL;
		$tabData['data'][$cnt]['sqltable']   = $item_list;
		$tabData['data'][$cnt]['if_line']    = $if_line;
		$tabData['data'][$cnt]['if_type']    = $if_type;
		$tabData['data'][$cnt]['if_data']    = $if_data;
		$tabData['data'][$cnt]['relation_data']    = $relation_data;
		$key = 'appgenerator';
		$iv = "~`!@#$%^&*()-_=+";
		$tabData = encryptA( $tabData , $key, $iv);
		$url_ = $kapp_mainnet . '/_Curl/table_curl_get_ailinkapp.php'; 
		$curl = curl_init(); //$curl = curl_init( $url_ );
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $tabData , JSON_UNESCAPED_UNICODE),
			'iv' => $iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);

		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		echo "curl --- response: " . $response;

		if( $response == false) {
			echo 'curl Error : ' . curl_error($curl);
		} else {
			//echo 'curl OK : ' . $response;
		}
		curl_close($curl);
		return $response;
	}
	function PG_curl_sendA( $item_cnt , $item_array, $iftype_db, $ifdata_db, $popdata_db, $sys_link, $rel_data , $rel_type ){
		global $pg_code, $pg_name, $new_tab_enm, $H_ID, $H_EMAIL, $project_code, $project_name, $hostnameA, $config, $kapp_iv,$kapp_key;      
		global $H_ID, $H_EMAIL; 
		global $kapp_mainnet;

		$new_tab_hnm	= $_POST["new_tab_hnm"];
		$pg_code = $new_tab_enm;
		$pg_name = $new_tab_hnm;
		$tabData['data'][][] = array();
		$cnt = 0;
		$tabData['data'][$cnt]['pg_code']  = $pg_code;
		$tabData['data'][$cnt]['pg_name']  = $pg_name;
		$tabData['data'][$cnt]['tab_enm']  = $new_tab_enm;
		$tabData['data'][$cnt]['tab_hnm']  = $new_tab_hnm;
		$tabData['data'][$cnt]['userid']     = $H_ID;
		$tabData['data'][$cnt]['group_code'] = $project_code;
		$tabData['data'][$cnt]['group_name'] = $project_name;
		$tabData['data'][$cnt]['host']       = KAPP_URL_T_;
		$tabData['data'][$cnt]['email']      = $H_EMAIL;
		$tabData['data'][$cnt]['item_cnt']   = $item_cnt;
		$tabData['data'][$cnt]['if_type']    = $iftype_db;
		$tabData['data'][$cnt]['if_data']    = $ifdata_db;
		$tabData['data'][$cnt]['popdata_db'] = $popdata_db;
		$tabData['data'][$cnt]['sys_link']   = $sys_link;
		$tabData['data'][$cnt]['relation_data']   = $rel_data;
		$tabData['data'][$cnt]['relation_type']   = $rel_type;
		$tabData['data'][$cnt]['item_array'] = $item_array;
		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);

		$url_ = $kapp_mainnet . '/_Curl/pg_curl_get_ailinkapp.php'; // 전송할 대상 URL fation
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			//$_ms = "new program curl error : " . curl_error($curl);
			echo 'curl error PG_curl_send : ' . curl_error($curl);
		} else {
			//$_ms = 'new program app_pg50RC curl response : ' . $response;
		}
		curl_close($curl);
		return $response;
	} // function
	//==========================================
	function create_func(){
		global $H_ID, $H_EMAIL, $table_yn, $mode, $line_set;
		global $config;
		global $tkher;
		global $project_code, $project_name, $new_tab_enm; 

		$new_tab_hnm	= $_POST["new_tab_hnm"];
		$item_list = " create table ". $new_tab_enm . " ( ";
		$item_list = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),';
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';
		$cnt = 1;
		$item_array = "";
		$if_type = "";
		$if_data = "";
		$item_cnt   = 0;
		For( $ARR=1; $ARR < $line_set ; $ARR++ ) {
			if( isset($_POST["fld_hnm"][$ARR]) && $_POST["fld_hnm"][$ARR] !=='' ) $fld_hnm	=	$_POST["fld_hnm"][$ARR];
			else $fld_hnm =	'';
			if( $fld_hnm !== '' ) {
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
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$memo' ";
				$ret = sql_query( $sql );
				if( !$ret ) {
					m_("error --- insert table10_table - $tab_enm");
					//echo "sql: " . $sql; exit;
				}
				$Asqltable=''; $if_lineA=0; $if_typeA=''; $if_dataA=''; $relation_dataA='';
				// table_create --- curl array -------------- no use
				//TAB_curl_move( $tab_enm, $tab_hnm, $fld_enm, $fld_hnm, $fld_type, $fld_len, $ARR, $memo, $Asqltable, $if_lineA, $if_typeA, $if_dataA, $relation_dataA);
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$line_set  = $cnt - 1;
		$ret = sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$item_array', sqltable='$item_list' " );

		if( $ret ){
			$mq1 = sql_query( $item_list );
			if( !$mq1 ) {
				m_("error --- insert table10_table - $new_tab_enm");
				exit;
			} else {
				m_("c  Successful creation of the $new_tab_hnm table - $new_tab_enm.");
				$table_yn = 'y';
				$link_ = KAPP_URL_T_ . "kapp_table30m_A.php";
				insert_point_app( $H_ID, $config['kapp_write_point'], $link_, 'table10@table30m' );
			}
		} else m_("INSERT table10_table ERROR create_func - tab seqno in ");

		$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$new_tab_enm',tab_hnm='$new_tab_hnm', pg_code='$new_tab_enm', pg_name='$new_tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$line_set, userid='$H_ID', tab_mid='$H_ID' ";
		
		$rets = sql_query($query);
		if( $rets ){
			//m_("PG Create OK! table10_pg_table  insert ");//OK table10_pg_table - insert  -- 
			$Tret = TAB_curl_sendA( $new_tab_enm, $new_tab_hnm, 0, $item_list, 0, '', '', '', $item_array ); // table_create
			if( $Tret ) {
				//m_("TAB_curl_sendA -- OK, Tret:" . $Tret);
				$sys_link = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $tab_enm; 
				$Pret = PG_curl_sendA( $line_set , $item_array, $if_type, $if_data, '', $sys_link, '' , '' );
			} else  m_("TAB_curl_sendA -- Error");
		} else {
			m_("Error INSERT table10_pg_table , $new_tab_enm , $new_tab_hnm ");
		}
		echo "<script>create_after_run( '$new_tab_enm' , '$new_tab_hnm' , '$mode' );</script>";
		exit;
	}

	function create_reaction_func(){
		global $H_ID, $tab_enm, $mode, $project_code, $project_name;
		global $config;
		global $tkher;
		$new_tab_hnm		= $_POST["new_tab_hnm"];
		$query	= " DELETE from {$tkher['table10_table']} where tab_enm='".$tab_enm."' and userid='".$H_ID."' ";
		$mq1	= sql_query($query);
		$query	= "drop table " . $tab_enm;
		$mq2	= sql_query($query);
		$cnt=0;
		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),'; // add 20251118
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';
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
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$new_tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', memo='$memo' " );
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set  group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$new_tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=$cnt, userid='$H_ID', table_yn='y', memo='key column', sqltable='$item_list' " );
		$line_set = $cnt;
		$mq3 = sql_query( $item_list );
		if( !$mq3 ) {
			m_("k1 $tab_enm table creation failed.");
			printf("sql:%s", $item_list);
			exit;
		} else m_("  Successful creation of the $new_tab_hnm table.");
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$tab_enm' ";
		$resultPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$query="UPDATE {$tkher['table10_pg_table']} SET item_cnt=$cnt, item_array='$item_array' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
			sql_query($query);
		} else {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$new_tab_hnm', pg_code='$tab_enm', pg_name='$new_tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$cnt, userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);
			$link_ = KAPP_URL_T_ . "/kapp_table30m_A.php";
			//insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'table10_pg@table30m' );//PG create point
		}
		echo "<script>create_after_run( '$tab_enm' , '$new_tab_hnm' ,  '$mode' );</script>";
	}
	//=============================================================
	function copy_func(){
		global $H_ID, $mode, $project_code, $project_name, $tab_enm;
		global $config;
		global $tkher;
		$new_tab_enm= $H_ID . "_" . time();
		$new_tab_hnm= $_POST["new_tab_hnm"];

		$item_list  = " create table ". $new_tab_enm . " ( ";
		$item_list  = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),'; // add 20251118
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';
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
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				sql_query( "INSERT INTO {$tkher['table10_table']} set tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$memo' " );
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=$cnt, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='key column', sqltable='$item_list' " );
		$line_set = $cnt;
		$fld_enm  = "fld_" . $ARR;
		$mq1 = sql_query( $item_list );
		if( !$mq1 ) {
			m_( $new_tab_hnm . ", table creation failed.");
		} else {
			m_("  Successful creation of the ".$new_tab_hnm." table.");
			$link_ = KAPP_URL_T_ . "kapp_table30m_A.php";
			insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'copy table10@kapp_table30m_A' );//re make copy
			TAB_curl_sendA( $new_tab_enm, $new_tab_hnm, 0, $item_list, 0, '', '', '', $item_array ); 
		}
		$old_tab_enm= $_POST['old_tab_enm'];
		//new_table_name: ABC_CCC_New, tab: dao_1757214499:ABC:dao_1755421034:Project59
		//new_table_name: ABC_DDD_New, tab: dao_1757214499:ABC:dao_1755421034:Project59
		$sqlPG		= "SELECT * from {$tkher['table10_pg_table']} where userid='".$H_ID."' and pg_code='".$old_tab_enm."' ";// old table copy pg
		$resultPG	= sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$rsPG = sql_fetch_array($resultPG);
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', pg_code='$new_tab_enm', pg_name='$new_tab_hnm', item_array='".$rsPG['item_array']."', if_type='".$rsPG['if_type']."', if_data='".$rsPG['if_data']."', pop_data='".$rsPG['pop_data']."', relation_data='".$rsPG['relation_data']."', item_cnt=".$rsPG['item_cnt'].", userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);
		} else {
			m_(" Copy ERROR : mode:".$mode.", old pg tab_enm: $tab_enm pg_code:".$new_tab_enm );
			//Copy ERROR : mode:table_new_copy, old pg tab_enm:  pg_code:dao_1766811819
			//Copy ERROR : mode:table_new_copy, pg_code:dao_1766811625
			//Copy ERROR : mode:table_new_copy, pg_code:dao_1766810942
			//new_table_name: ABCYY_New, tab: dao_1766735120:ABCYY:dao_1755421034:Project59
		}
		echo "<script>create_after_run( '$new_tab_enm' , '$new_tab_hnm' , '$mode' );</script>";
	}

	function update_remake_func(){
		global $H_ID, $tab_enm, $mode, $project_code, $project_name;
		global $config;
		global $tkher;
		$query	="delete from {$tkher['table10_table']} where tab_enm='$tab_enm' and userid='$H_ID' ";
		$mq1	=sql_query($query);
		$query	="drop table $tab_enm";
		$mq2	=sql_query($query);
		$new_tab_hnm	= $_POST["new_tab_hnm"];	
		$cnt = 1;
		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),'; // add 20251118
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';

		$item_array = '';
		$if_type = '';
		$if_data = '';
		For( $ARR=1; $_POST["fld_hnm"][$ARR] ; $ARR++ ) {
			$fld_enmO	=	$_POST["Afld_enm"][$ARR];
			$fld_hnmO	=	$_POST["Afld_hnm"][$ARR];
			$fld_typeO	=	$_POST["Afld_type"][$ARR];
			$fld_lenO	=	$_POST["Afld_len"][$ARR];
			$fld_O      = "|". $fld_enmO ."|". $fld_hnmO  ."|". $fld_typeO ."|". $fld_lenO . "@";
			//$memoO		=	$_POST["Amemo"][$ARR]; //Afld_memo
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
				if( $fld_enm !== $fld_enmO ) update_pg_func($fld_enm, $fld_enmO, $i_data, $fld_O); // 컬럼명이 변경 되었을 때, 사용된 테이블 관련된 프로그램의 컬럼명을 변경한다.
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
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';

				sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$new_tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', memo='$memo' " );

				// table_update_remake --- curl array ----- no use
				//TAB_curl_move( $tab_enm, $new_tab_hnm, $fld_enm, $fld_hnm, $fld_type, $fld_len, $ARR, $memo, $Asqltable, $if_lineA, $if_typeA, $if_dataA, $relation_dataA);
				$cnt++;
			}
		} // for

		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$new_tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', memo='$item_array', sqltable='$item_list' " );

		$line_set = $cnt-1;
		TAB_curl_sendA( $tab_enm, $new_tab_hnm,0 , $item_list, $_POST["Aif_line"][0], $_POST["Aif_type"][0], $_POST["Aif_data"][0], $_POST["Arelation_data"][0], $item_array );

		$mq1 = sql_query( $item_list );
		if( !$mq1 ) {
			echo "sql:" . $item_list; exit;
		} else m_( $tab_enm . ", Successful creation of the " . $new_tab_hnm . " table.");

		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='".$H_ID."' and pg_code='".$tab_enm."' ";
		$resultPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', item_cnt=$line_set, item_array='$item_array', tab_mid='$H_ID' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
			sql_query($query);
		} else {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$new_tab_hnm', pg_code='$tab_enm', pg_name='$new_tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$line_set, userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);
				$link_ = KAPP_URL_T_ . "/kapp_table30m_A.php";
				//insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'table10_pg@table30m' );//PG create point - update_remake_func()
		}
		echo "<script>create_after_run( '$tab_enm' , '$new_tab_hnm' , '$mode' );</script>";
	}
	//----------------------------------------------------------------------
	//컬럼명 또는 컬럼 타이들을 변경 했을 때 관련 프로그램(table10_pg의 item_array)도 변경한다 중요
	function update_pg_func($fld_enm, $fld_enmO, $i_data, $fld_O){
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
