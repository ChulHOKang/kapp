<?php
	include_once('./tkher_start_necessary.php');
	/*
	 * tableK_sql.php : table_sql.php : table30m_A.php copy:2025-12-09, table30m_Create.php copy 2023-08-25 - kan
		kapp_table_dup_ajax.php : table name Duplicate check
	 * TAB_curl_sendA( $tab_enm, $tab_hnm,0 , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ); 
	 */
	$H_ID		= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';

	if( !isset($H_ID) || $H_LEV < 2 ){
		m_("You need to login.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( isset($_POST["tab_enm"]) ) $tab_enm	= $_POST["tab_enm"];
	else {
		//$uid = explode('@', $H_ID);
		//$tab_enm = $uid[0] . "_" . time();
		$tab_enm = '';
	}

	if( isset($_POST['tab_hnm']) ) $tab_hnm	= $_POST["tab_hnm"];
	else $tab_hnm = '';
	if( isset($_POST['tab_hnmS']) ) $tab_hnmS	= $_POST["tab_hnmS"];
	else $tab_hnmS = '';
	if( isset($_POST['line_set']) ) $line_set = $_POST['line_set'];
	else $line_set = 50;
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode'];
	else $mode = '';
	if( isset($_POST['del_mode']) ) $del_mode = $_POST['del_mode'];
	else $del_mode = '';
	if( isset($_POST["project_code"])  && $_POST["project_code"] !== '') $project_code	= $_POST["project_code"];
	else  $project_code	= "";
	if( isset($_POST["project_name"])  && $_POST["project_name"] !== '') $project_name	= $_POST["project_name"];
	else  $project_name	= "";

	if( isset($_POST["sql_memo"]) && $_POST["sql_memo"] !== '') $sql_memo= $_POST["sql_memo"];
	else  $sql_memo	= "";

	if( isset($_POST["sql_table"]) && $_POST["sql_table"] !== '') $sql_table= $_POST["sql_table"];
	else  $sql_table = "";
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
<style type="text/css">
<!--
	textarea {
	  width: 50%;
	  height: 250px;
	  padding: 12px;
	  border: 2px solid #ccc;
	  border-radius: 4px;
	  background-color: #000000;
	  font-family: Arial, sans-serif;
	  font-size: 14px;
	  color: #fff;
	  /*resize: vertical;  Allows vertical resizing only */
	}
	textarea:focus {
	  border-color: #007bff; /* Changes border color on focus */
	  outline: none; /* Removes default outline on focus */
	}
	.style3 {
		width: 420px;
		height: 30px;
		font-size: 14px;
		color: blue;
		font-weight: bold;
	}
	.style2 {
		color: #4F2044;
		font-weight: bold;
	}
	.style4 {
		width: 150px;
		height: 35px;
		font-size: 16px;
		color: #4F2044;
		font-weight: bold;
	}
	.style5 {
		height: 25px;
		font-size: 16px;
		font-weight: bold;
		color: #000;
	}
-->
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

<script language='javascript'>
field_len = '';
function sql_tab(tab) {
	table_enm = tab.split('`');
	document.insert.tab_enm.value = 'SQLKapp_' + table_enm[1];
	document.insert.tab_hnm.value = table_enm[1];
	return table_enm[1];
}
function fld0_enmF(fld0) {
	fld0_enm = fld0.split('`');
	return fld0_enm[3];
}

function fld0_typeF(fld0) {

	fld0_type_ok = '';
	fld0_ = fld0.split('`');
	if( fld0_[4].indexOf("(") == -1 ){ // none
		fld0_t = fld0_[4].split(' ');
		if( fld0_t[1] !='') fld0_type_ok = fld0_t[1];
	} else {
		fld0_tt = fld0_[4].split('('); // '('가 없을 수도 있다 보완 필요.... 중요.
		fld0_type_ok = fld0_tt[0]; //fld0_type[0];
	}
	fld0_type_ok = fld0_type_ok.replace(' ', '');
	return fld0_type_ok;
}
function fld0_lenF( fld0 ) { // CREATE TABLE IF NOT EXISTS `job_offer` ( `jo_id` text,
	fld0_ = fld0.split('`');
	if( fld0_[4].indexOf("(") == -1 ){ // none
		f_len = '';
	} else {
		fld0_t = fld0_[4].split('(');
		fld0_len = fld0_t[1].split(')');
		f_len = fld0_len[0];
	}
	return f_len;
}

//CREATE TABLE IF NOT EXISTS `homepagegroup` (  `seqno` blob NOT NULL auto_increment,
function fld0_deF( fld0 ) {
	fld0_type_ok ='';
	fld0_ = fld0.split('`');
	if( fld0_[4].indexOf("(") == -1 ){ // on
		fld0_t = fld0_[4].split(' ');	//alert("0 len: "+fld0_t.length);//0 len: 5
		for( i=0; i < fld0_t.length; i++){
			if( i> 1 && fld0_t[i] !='') fld0_type_ok = fld0_type_ok + ' ' + fld0_t[i];
		}
	} else {
		fld0_t = fld0_[4].split('(');
		fld0_len = fld0_t[1].split(')');
		fld0_type_ok = fld0_len[1];
	}
	return fld0_type_ok;
}

function fld_typeF( mf2 ) { //mb_nick_date` date,
	fld_ = mf2.split('(');
	fld_t = fld_[0].replace(' ', '');
	return fld_t;
}
function fld_lenF( mf2) { // varchar(15) DEFAULT NULL
	fld_ = mf2.split('(');
	fld_len = fld_[1].split(')');
	field_len = fld_len[0];
	default_data = fld_len[0] + '|' +fld_len[1];
	return field_len; //default_data;
}
function send_memo_chk() {
	document.insert.dup_confirm.checked =false;
	document.insert.sql_table.value = ''; // display: none
	if(!document.insert.sql_memo.value) {
		alert('sql 입력하세요');
		document.insert.sql_memo.focus();
		return;
	} else {
		let sqlm = [];
		msg = '';
		auto = '';
		key_msg = '';
		key_cnt = 0;
		item_array ='';

		sqlA= document.insert.sql_memo.value;
		sqlm = sqlA.split(',');
		if( sqlm.length > document.insert.line_set.value ){
			alert("Please set the Column count higher! column count: "+ sqlm.length + ", " +document.insert.line_set.value);
			return false;
		}

		tab_enm = sql_tab( sqlm[0]);
		sqlm0 = sqlm[0].split('`');
		if( sqlm0[3] =='' && sqlm0[4] =='' ) {
			alert("The format of the first line of SQL should be \n 'CREATE TABLE IF NOT EXISTS `table_name` ( `colunm_name` data_type' ");
			return;
		}
		tab_enm = sqlm0[1];
		fld0_enm = sqlm0[3]; //alert( tab_enm + ", " +fld0_enm);

		if( sqlm0[4].indexOf("(") != -1 ) {
			fnm = sqlm0[4].split('('); //  sqlm0[4] =" `no` int(11)"
			fld0_type = fnm[0].replace( ' ', ''); // " int"
			f_len = fnm[1].split(')');
			fld_len = f_len[0];
			fld_len_default = sqlm0[4];

		} else { //`book_num` double default NULL,
			fnm = sqlm0[4].split(' ');
			fld0_type = fnm[1];
			fld_len = '';
			fld_len_default = sqlm0[4].replace( fnm[1], '');
		}
		fld0_type = fld0_type.toUpperCase();
		msg = tab_enm + '\n' + '@' + '|' +fld0_enm + '|' + fld0_type +'|'+ fld_len + '|' + fld_len_default + '\n' +'@';
		item_array = '|' +fld0_enm + '|' +fld0_enm + '|' + fld0_type +'|'+ fld_len + '|' + fld_len_default +'@';
		if( fld0_enm == 'seqno') { //if( fld0_enm == 'seqno') {
			jj =1;
		} else {
			jj = 2;
			document.insert["fld_enm[1]"].value  = fld0_enm;
			document.insert["fld_hnm[1]"].value  = fld0_enm;
			document.insert["fld_type[1]"].value  = fld0_type;
			document.insert["fld_len[1]"].value  = fld_len;
			document.insert["memo[1]"].value  = fld_len_default;
		}

		last_check = ''; 
		for( i=1; i < sqlm.length; i++, jj++){
			fld_enm = '';
			fld_t = '';
			fld_len = '';
			auto = '';
			sqlm_i = sqlm[i];
			mf = sqlm[i].split('`');
			fld_enm = mf[1];

			if( last_check == 'on' ){
				if( i == sqlm.length-1 ) {	//alert("on ---  " + i+ ", sqlm_i: " + sqlm_i );
					key_msg = key_msg + sqlm_i; //KEY `jh_key` (`jh_key`,`jh_id`))  AUTO_INCREMENT=7 ;
				} else key_msg = key_msg + sqlm_i + ', ';
				continue;
			}

			if( mf[2] == '' ){	
				alert(" SQL error : mf2: " + mf[2]);
				if( last_check == 'on' && i == sqlm.length-1 ) {
					alert( i+ " - msg: " +msg);
					break;
				} else if( last_check == 'on' && i < sqlm.length-1 ) continue;
				break;
			}

			if( sqlm[i].indexOf("PRIMARY KEY") != -1 || sqlm[i].indexOf("primary key") != -1 ) {
				fld_enm = '';
				fld_t = '';
				//key_msg = key_msg +sqlm[i] + ', '; // primary key 바이패스...
				last_check = 'on';
				continue;
			} else if( sqlm[i].indexOf("UNIQUE KEY") != -1 ) {
				fld_enm = '';
				fld_t = '';
				key_msg = key_msg +sqlm[i] + ',';
				continue;
			} else if( sqlm[i].indexOf("KEY index") != -1 ) {
				fld_enm = '';
				fld_t = '';
				key_msg = key_msg +sqlm[i] + ',';
				continue;
			} else if( sqlm[i].indexOf("KEY ") != -1 || sqlm[i].indexOf("key ") != -1 ) {
				key_msg = key_msg +sqlm[i] + ',';
				last_check = 'on';
				continue;
			} else { // `book_num` varchar(15) default NULL
			  
				if( mf[2].indexOf("(") != -1 ) {
					fnm = mf[2].split('(');
					fld_t = fnm[0].replace( ' ', ''); // fnm[0]: ' varchar'
					f_len = fnm[1].split(')');
					fld_len = f_len[0];
					fld_len_default = mf[2]; //f_len[1];
					if( i== sqlm.length-1 ){
						def = fld_len_default.split(')');
						fld_len_default = def[0] + ') '+ def[1];
					}
				} else { //`book_num` text default NULL,
					if( i== sqlm.length-1 ) alert("222 mf2: " + mf[2]);
					fnm = mf[2].split(' ');
					fld_t = fnm[1];
					fld_len_default = mf[2]; //mf[2].replace( fnm[1], '');
					fld_len ='';
					if( i== sqlm.length-1 ){
						def = fld_len_default.split(')');
						fld_len_default = def[0] + ' ' + def[1];
					}
				}
				fld_t = fld_t.toUpperCase();
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+ fld_len + '|' + fld_len_default + '\n' +'@';
				item_array = item_array + '|' +fld_enm + '|' +fld_enm + '|' + fld_t +'|'+ fld_len + '|' + fld_len_default +'@';
			}
			fld_t = fld_t.toUpperCase();			//alert( i+ ",  fld_t: " + fld_t );
			document.insert["fld_enm[" + jj + "]"].value  = fld_enm;
			document.insert["fld_hnm[" + jj + "]"].value  = fld_enm;
			document.insert["fld_type[" + jj + "]"].value  = fld_t;
			document.insert["fld_len[" + jj + "]"].value  = fld_len;
			fld_len_default = fld_len_default.replace('auto_increment', '');
			document.insert["memo[" + jj + "]"].value  = fld_len_default;
		} //for
		document.insert.key_msg.value = key_msg;
		msg = msg + key_msg;
		document.insert.sql_table.value = msg;
		document.insert.item_array.value = item_array;
		document.insert.item_cnt.value = i;
	}
	//alert( i + ", SQL interpretation complete! Please check for table duplication");
	document.insert.mode.value='SQL_Search';
	document.insert.action="tableK_sql.php";
	document.insert.submit();
}

//-- No Use 미완 ------------
function Save_Table(){
	if( document.insert.project_code.value == '') {
		alert("## confirm project! ##"); 
		document.insert.project_code.focus();
		return false;
	} else {
		project_code = document.insert.project_code.value;
		alert("project_code: " + project_code);
	}
	if( document.insert.sql_memo.value == '' || document.insert.sql_table.value == '' ) {
		alert("## confirm SQL! ###"); 
		document.insert.sql_memo.focus();
		return false;
	} else {
		if( document.insert.tab_enm.value == '' || document.insert.tab_hnm.value == '' ) {
			alert("## Confirm Table Name! ###"); 
			return false;
		}
		if( window.confirm( " Table을 생성하시겠습니까? " ) ){
			project_code = document.insert.project_code.value;
			tab_enm = document.insert.tab_enm.value;
			tab_hnm = document.insert.tab_hnm.value;
			sql_memo = document.insert.sql_memo.value;
			sql_table = document.insert.sql_table.value;
			

jQuery(document).ready(function ($) {
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'kapp_sql_to_table_ajax.php',
				data: {
					"mode_insert": 'Save_SQL_to_Table',
					"project_cd": project_cd,
					"tab_enm": tab_enm,
					"tab_hnm": tab_hnm,
					"sql_memo": sql_memo,
					"sql_table": sql_table
				},
			success: function(data) {
				//console.log(data);
				alert("table create OK --- " + tab_hnm);
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

		} else return false;
	}
}

</script>


<script language=javascript>
	function Project_change_func(cd){
		index=document.insert.project_code.selectedIndex;
		nm = document.insert.project_code.options[index].text;
		document.insert.project_name.value=nm;
		document.insert.old_group_code.value=document.insert.project_code.options[index].value;
		return;
	}

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
			document.insert.mode.value			="Search";
			document.insert.table_yn.value = table_yn;
			document.insert.add_column_hnm.value = document.insert["fld_hnm[" + no + "]"].value;
			document.insert.add_column_enm.value = document.insert["fld_enm[" + no + "]"].value;
			document.insert.add_column_type.value = document.insert["fld_type[" + no + "]"].value;
			document.insert.add_column_len.value = document.insert["fld_len[" + no + "]"].value;
			document.insert.add_column_memo.value = document.insert["memo[" + no + "]"].value;
			document.insert.del_seqno.value = document.insert["seqno[" + no + "]"].value;
			document.insert.action					="tableK_sql.php";
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
		if( window.confirm( msg ) ) {
			document.insert.del_mode.value		="column_add_mode";
			document.insert.mode.value			="Search";
			document.insert.table_yn.value = table_yn;
			document.insert.add_column_hnm.value = document.insert["fld_hnm[" + no + "]"].value;
			document.insert.add_column_enm.value = document.insert["fld_enm[" + no + "]"].value;
			document.insert.add_column_type.value = document.insert["fld_type[" + no + "]"].value;
			document.insert.add_column_len.value = document.insert["fld_len[" + no + "]"].value;
			document.insert.add_column_memo.value = document.insert["memo[" + no + "]"].value;
			document.insert.action					="tableK_sql.php";
			document.insert.submit();
		}
	}

	function delete_column_func(seqnoA, fld_hnmA, fld_enmA, i) {
		msg = " Delete " + fld_hnmA + " entry? ";//컬럼을 삭제할까요?
		if ( window.confirm( msg ) )
		{
			document.insert.del_mode.value		="Delete_column_mode";
			document.insert.mode.value			="Search";
			//document.insert.pg_mode.value		="on"; // sql to table - no use 
			document.insert.del_seqno.value		=seqnoA;
			document.insert.del_fld_enm.value	=fld_enmA;
			document.insert.del_fld_hnm.value	=fld_hnmA;
			document.insert.action				="tableK_sql.php";
			document.insert.submit();
		}
	}
	function Save_Update( cnt){ // Modification Registration - 수정등록
		tab_hnm = document.insert.tab_hnm.value;
		msg = " The data in the table is deleted. Want to regenerate? table is " + tab_hnm + " "; //테이블의 데이터가 삭제됩니다. 재생성 할까요?
		if ( window.confirm( msg ) )
		{
			tab = document.insert.tab_hnmS.value;
			document.insert.mode.value='table_update_remake';
			document.insert.del_mode.value		="";
			document.insert.action="tableK_sql.php";
			document.insert.submit();
			return true;
		} else {
			return false;
		}
	}

	function type_set_func( i, v) {
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
		else if( document.insert["fld_type["+i+"]"].value == "TIME")      document.insert["fld_len["+i+"]"].value = '8'; // 2024-01-04 add
	}
	function line_set_func(cnt) {
		//alert("line set: " +cnt);
			document.insert.mode.value='line_set';
			document.insert.line_set.value=cnt;
			document.insert.action="tableK_sql.php";
			document.insert.submit();
	}

	function sendCon(form){
		f_nm = document.insert["fld_enm[0]"].value;
		if ( f_nm == "" ) {
			window.alert("An unentered field remains.");//입력 되지 않은 필드가 남아 있습니다.\n모두 입력하신 후에 계속등록하십시요.
		} else {
			document.insert.action="tableK_sql.php";
			document.insert.submit();
		}
	}

	function table_create_func(line){
		if( document.insert.dup_confirm.checked === false ) {
			alert("duplicate Confirm error, table - duplicate confirm please!");
			return false;
		}
		if( !document.insert.project_code.value) {
			alert(' Select Project! code:' + document.insert.project_code.value);
			return false;
		}

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
			/*if( !len) {
				if( fnm ) {
					alert('Check the column length input! ');// 컬럼 길이 입력을 확인 하세요!
					return false;
				}
			}*/
		}
		var ins = window.confirm("Register and create the table. ");//테이블을 등록및 생성합니다.
		if( ins ) {
			document.insert.mode.value='sql_table_create';
			document.insert.action="tableK_sql.php";
			document.insert.submit();
		  }
	}

	function resetgo(){
		window.open( 'tableK_sql.php' , '_self', '');
		return;
	}

	function Newtable_save(cnt){
		// sql to table no use
		return;
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
			document.insert.action="tableK_sql.php";
			document.insert.submit();
		}
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
	}
    function up_move(i, j){
		document.insert["fld_enm[" + j + "]"].value  = document.insert["fld_enm[" + i + "]"].value;
		document.insert["fld_hnm[" + j + "]"].value  = document.insert["fld_hnm[" + i + "]"].value;
		document.insert["fld_type[" + j + "]"].value  = document.insert["fld_type[" + i + "]"].value;
		document.insert["fld_len[" + j + "]"].value  = document.insert["fld_len[" + i + "]"].value;
		document.insert["memo[" + j + "]"].value  = document.insert["memo[" + i + "]"].value;
		document.insert["seqno[" + j + "]"].value  = document.insert["seqno[" + i + "]"].value;
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
			alert('last line.');
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

	function change_table_func() { // no use
		tab = document.insert.tab_hnmS.value;
		da = tab.split(":");
		document.insert.group_code_table.value=da[2];
		document.insert.group_code.value=da[2];
		document.insert.group_name.value=da[3];
		document.insert.mode.value='Search';
		document.insert.action="tableK_sql.php";
		document.insert.submit();
	}

function table_nm_dup_check(){
	var $tab_enm= document.insert.tab_enm.value;
	var $tab_hnm= document.insert.tab_hnm.value;
	if( $tab_enm =='' || $tab_hnm =='') {
		alert("table code and table name confirm;");
		return false;
	}
	jQuery(document).ready(function ($) {
			$.ajax({
				header:{"Content-Type":"application/json"},
				method: "post",
					url: 'kapp_table_dup_ajax.php',
					data: {
						"mode_insert": 'table_dup_check',
						"tab_hnm": $tab_hnm,
						"tab_enm": $tab_enm
					},
				success: function(data) {
					//console.log(data);
					if( data.indexOf('Already exists') == -1 ) {
						document.insert.dup_confirm.checked =true;
						alert( data + ",  tab_enm " + $tab_enm);
					} else {
						document.insert.dup_confirm.checked =false;
						alert("Error - Table name is duplicated "+ data + ",  tab_enm " + $tab_enm);
					}
					//location.replace(location.href);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("Error Dup! data: "+ data + ", tab_enm: " + $tab_enm);
					document.insert.dup_confirm.checked =false;
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
					return;
				}
			});
	});
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
	if( $mode == 'SQL_Search' ){
		//$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len ."|". $fld_len_def . "@";
		if( isset($_POST['item_array']) ) $item_array = $_POST['item_array'];
		//m_("item_array: $item_array");
		//item_array: |tran_pr|tran_pr|INT|11| int(11) NOT NULL auto_increment@|tran_refkey|tran_refkey|VARCHAR|40| varchar(40) binary default NULL@|tran_id|tran_id|VARCHAR|20| varchar(20) binary default NULL@|tran_phone|tran_phone|VARCHAR|15| varchar(15) binary NOT NULL default ''@|tran_callback|tran_callback|VARCHAR|15| varchar(15) binary default NULL@|tran_status|tran_status|CHAR|1| char(1) binary default NULL@|tran_date|tran_date|DATETIME|| datetime NOT NULL default@|tran_rsltdate|tran_rsltdate|DATETIME|| datetime default NULL@|tran_reportdate|tran_reportdate|DATETIME|| datetime default NULL@|tran_rslt|tran_rslt|CHAR|1| char(1) binary default NULL@|tran_net|tran_net|CHAR|3| char(3) binary default NULL@|tran_msg|tran_msg|VARCHAR|255| varchar(255) binary default NULL@|tran_etc1|tran_etc1|VARCHAR|64| varchar(64) binary default NULL@|tran_etc2|tran_etc2|VARCHAR|16| varchar(16) binary default NULL@|tran_etc3|tran_etc3|VARCHAR|16| varchar(16) binary default NULL@|tran_etc4|tran_etc4|INT|10| int(10) default NULL@|tran_type|tran_type|INT|5| int(5) NOT NULL default '0'@
		$record_cnt = $_POST['item_cnt'];
		$list= explode("@", $item_array);
		for ( $i=0; $list[$i] !== ""; $i++ ){
			$ddd= $list[$i];// 36|fld_2|전화폰|2
			$item= explode("|", $ddd);
				$Aseqno[$i]	= $i;
				$Afld_enm[$i]	=$item[1];
				$Afld_hnm[$i]	=$item[2];
				$Afld_type[$i]	=$item[3];
				$Afld_len[$i]	=$item[4];
				$Amemo[$i]		=$item[5]; // replace
		}
		$record_cnt = $i;
	} else if( $mode == 'Search' ){
	} else if( $mode == "line_set" ) {
	}
	if( isset($_POST['group_code_table']) ) $group_code_table = $_POST['group_code_table'];
	$group_code_table ='';
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
		<input type="hidden" name="userid" value='<?=$H_ID?>'> <!--  H_ID , userid-->
		<input type="hidden" name="disno" value='<?=$disno?>'>
		<input type="hidden" name="add_column_no" value=''>
		<input type="hidden" name="add_column_enm" >
		<input type="hidden" name="add_column_hnm" >
		<input type="hidden" name="add_column_type" >
		<input type="hidden" name="add_column_len" >
		<input type="hidden" name="add_column_memo" >
		<input type="hidden" name="group_code_table" value="<?=$group_code_table?>">
		<input type="hidden" name="old_group_code" >
		<input type="hidden" name="item_array" ><!-- add -->
		<input type="hidden" name="item_cnt" ><!-- add -->
		<input type="hidden" name="table_yn" value='<?=$table_yn?>'>
		<input type="hidden" name="sqlm_length_old" value=''>
		<input type="hidden" name="key_msg" value=''>
		
		<h2><font fce="Arial">Table Design( SQL to Table )</font></h2>

<div>
	<ul>
		<span bgcolor='#f4f4f4' <?php echo "title='You can change or add the group name of the table.' "; ?>><font color='black'>Project</span>
		<span bgcolor='#ffffff'><SELECT id='project_code' name='project_code' onchange="Project_change_func(this.value);" style='width:250px;height:30px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered. ' "; ?> >
				<option value=''>Select project</option>
				<!-- <option value='ETC' selected>ETC</option> -->
<?php
			$SQLG = "SELECT * from {$tkher['table10_group_table']} where userid='".$H_ID."' order by group_name ";
			$result = sql_query( $SQLG );
			while($rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['group_code']?>" <?php if($rs['group_code']==$project_code) echo "selected"; ?>><?=$rs['group_name']?></option>
<?php
			}
?>
			</select>
<?php
		if ( isset($H_ID) && $H_ID !== "" ) {
?>
		</span>
		<input type='hidden' name='project_name' value='<?=$project_name?>' style='height:25px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='You can change or add the group name of the table.' "; ?> >
<?php
		} else {
?>
				You can register after login.
<?php
		}
?>
</ul>
<ul>
	<span bgcolor='#f4f4f4' <?php echo "title='Select a table from the list of registered tables.' "; ?>>Table Code</span>
		<span bgcolor='#ffffff'><input type='text' name='tab_enm'  value='<?=$tab_enm?>' style='width:250px;height:30px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>></span>&nbsp;
	<span bgcolor='#f4f4f4' <?php echo "title='Select a table from the list of registered tables.' "; ?>>Table Name</span>
		<span bgcolor='#ffffff'><input type='text' name='tab_hnm'  value='<?=$tab_hnm?>' style='width:250px;height:30px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>></span>
		<span>
		&nbsp;<input type='checkbox' id='dup_confirm' name='dup_confirm' value='Confirm' onClick="return false">&nbsp;
		&nbsp;<input type='button' onclick="table_nm_dup_check();" value='Duplicate check' >
		</span>

</ul>
</div>
<?php
$sql_memo = str_replace('\\', '', $sql_memo);
$sql_table = str_replace('\\', '', $sql_table);
?>
<div>
	<span bgcolor='#f4f4f4' title='Enter SQL here'><textarea title='Enter SQL here' id="sql_memo" name="sql_memo" cols="100%" ><?=$sql_memo?></textarea></span>
	<span bgcolor='#f4f4f4'><textarea id="sql_table" name="sql_table" cols="100%" style='color:yellow;display:none;' ><?=$sql_table?></textarea></span>
	<p bgcolor='#f4f4f4'><input type='button' onclick="javascript:send_memo_chk();" value=' Sql to Table ' style='height:30px;width:150;background-color:black;color:white;border-radius:20px;border:1 solid black;' title='sql to table' ></p>

</div>
<?php if( $mode=='SQL_Search') $line_set = $record_cnt; else $line_set=$line_set; ?>
<div>
				  Column Count : <SELECT type='text' name="line_set" onchange="javascript:line_set_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Set the number of lines to be registered.' "; ?>><!--  \n등록할 라인수를 설정합니다. -->
					<option value="<?php echo $line_set ?>" selected ><?php if($mode=='SQL_Search') echo $record_cnt; else echo $line_set; ?> </option>
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
			 <?php //if( $mode=='SQL_Search' ) echo "<TH><b>CTL</b></TH>"; ?>
			</TR>
	</THEAD>
<?php
			if( $mode=='SQL_Search' ) { $dis_cnt = $record_cnt +1;  }
			else if( $mode=='line_set' ) { $line_cnt =$_POST['line_set']; $dis_cnt =$_POST['line_set']; }
			else  $dis_cnt =$line_set;
			$if_lineA =0; $if_typeA =''; $if_dataA ='';	$relation_dataA ='';
			For( $i = 0; $i < $dis_cnt  ; $i++) {
				if( $i < $record_cnt ) $m_line = 0;
				else $m_line = 1;
				if( $mode == 'SQL_Search' ) {
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
<?php if( $mode=="SQL_Search"){	?>
			<input type="hidden" name="Afld_enm[<?=$i?>]" value='<?=$fld_enm?>'>
			<input type="hidden" name="Afld_hnm[<?=$i?>]" value='<?=$fld_hnm?>'>
			<input type="hidden" name="Afld_type[<?=$i?>]" value='<?=$fld_type?>'>
			<input type="hidden" name="Afld_len[<?=$i?>]" value='<?=$fld_len?>'>
			<input type="hidden" name="Afld_memo[<?=$i?>]" value='<?=$memo?>'>
<?php }	?>

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
							<option <?php echo "title='CHAR A fixed-length (0-255, default 1) string that fills the right with blanks to the specified length at all times when saved.' "; ?> value="CHAR" 
				  <?php if( $fld_type == 'CHAR') echo " selected ";  ?> >CHAR</option>
							<option <?php echo "title='VARCHAR Variable-length (0-65,535) string.' "; ?> value="VARCHAR" 
				  <?php if($fld_type == 'VARCHAR') echo " selected ";  ?> >VARCHAR</option>
							<option <?php echo "title='TEXT Text column with a maximum length of 65535 (2 ^ 16-1) characters.' "; ?> value="TEXT" 
				  <?php if($fld_type == 'TEXT') echo " selected ";  ?>>TEXT</option>
							<option <?php echo "title='INT The range of 4-byte integer types is 2147483647 with -2,147,483,647 when there is a sign, and 4,294,967,295 when there is no sign.' "; ?> value="INT" <?php if( $i==0 || $fld_type == 'INT') echo " selected ";  ?> >INT</option>
							<option <?php echo "title='TINYINT The range of a 1-byte integer type is from -128 to 127 when it is signed, and from 0 to 255 when it is not signed.' "; ?> value="TINYINT" 
				  <?php if( $fld_type == 'TINYINT') echo " selected ";  ?> >TINYINT</option>
							<option <?php echo "title='SMALLINT The range of a 2-byte integer is -32,768 to 32,767 if signed and 0 to 65,355 if unsigned.' "; ?> value="SMALLINT" 
				  <?php if($fld_type == 'SMALLINT') echo " selected ";  ?> >SMALLINT</option>
							<option <?php echo "title='MEDIUMINT The range of 3-byte integers is -8388608 to 8388607 if signed, and 0 to 16,777,215 if not signed.' "; ?> value="MEDIUMINT" 
				  <?php if($fld_type == 'MEDIUMINT') echo " selected ";  ?> >MEDIUMINT</option>
							<option <?php echo "title='BIGINT An 8-byte integer type range is from -9,223,372,036,854,775,808 to +9,223,372,036,854,775,808 when there is a sign, and 18,446,744,073,709,551,615 when there is no sign.' "; ?> value="BIGINT" 
				  <?php if($fld_type == 'BIGINT') echo " selected ";  ?>>BIGINT</option>
							<option <?php echo "title='DECIMAL Fixed-point number (M, D): The maximum number of digits (M) is 65 (default is 10) and the maximum number of decimal places (D is 30)' "; ?> value="DECIMAL" 
				  <?php if($fld_type == 'DECIMAL') echo " selected ";  ?>>DECIMAL</option>
							<option <?php echo "title='FLOAT A small floating-point number, acceptable values are -3.402823466E + 38 to -1.175494351E-38, 0, and 1.175494351E-38 to 3.402823466E + 38.' "; ?> value="FLOAT" 
				  <?php if($fld_type == 'FLOAT') echo " selected ";  ?>>FLOAT</option>
							<option <?php echo "title='DOUBLE precision floating point numbers, acceptable values are -1.7976931348623157E + 308 to -2.2250738585072014E-308, 0, And from 2.2250738585072014E-308 to 1.7976931348623157E + 308.' "; ?> value="DOUBLE" 
				  <?php if($fld_type == 'DOUBLE') echo " selected ";  ?>>DOUBLE</option>
							<option <?php echo "title='DATE Date types 1000-01-01 through 9999-12-31 are available.' "; ?> value="DATE" 
				  <?php if($fld_type == 'DATE') echo " selected ";  ?>>DATE</option>
							<option <?php echo "title='DATETIME Date and time combination, 1000-01-01 00:00:00 through 9999-12-31 23:59:59 Wanted.' "; ?> value="DATETIME" 
				  <?php if($fld_type == 'DATETIME') echo " selected ";  ?>>DATETIME</option><!-- 2023-07-18 kan -->
							<option <?php echo "title='TIME Date and time combination, 00:00:00 through 23:59:59 Wanted.' "; ?> value="TIME" 
				  <?php if($fld_type == 'TIME') echo " selected ";  ?>>TIME</option>
							<option <?php echo "title='TIMESTAMP timestamp format 1970-01-01 00:00:01 UTC to 2038-01-09 03:14:07 UTC Until EPOCH (1970-01-01 00:00:00 UTC), the elapsed time in seconds since the number.' "; ?> value="TIMESTAMP" 
				  <?php if($fld_type == 'TIMESTAMP') echo " selected ";  ?>>TIMESTAMP</option>
							<option <?php echo "title='LONGBLOB Length Maximum data size: 4GiB' "; ?> value="LONGBLOB" 
				  <?php if( $fld_type=='LONGBLOB') echo " selected ";?> >LONGBLOB</option> <!-- LONGBLOB data size 4GiB -->
			  </select>
		</td>
		<td align='left'>  <input type='text' name="fld_len[<?=$i?>]" size='3' maxlength='3' style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'
<?php
				if ( $fld_enm=='seqno' or $i==0) { echo "value='11' readonly >"; } else { echo " value='$fld_len' >";}
				$memo = str_replace('\\', '', $memo);
?> 
		</td>
		<td align='left'>
			<input type='text' name="memo[<?=$i?>]" value="<?=$memo?>" style='width:300px;height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' >
	   </td>
	<?php
		if( $mode=='SQL_Search') {
	?>
			<td align='left'>
	<?php
			if( $i > 0 ) {
				if( $m_line) {
					//echo " <input type='button' name='add' onclick=\"javascript:column_add_mode_func('$i', '$table_yn', '$dis_cnt');\"  value='column add' style='height:22px;background-color:blue;color:yellow;border-radius:20px;border:1 solid black' title=' Add a column.'>";
				} else {
					//echo " <div id='manager_".$i.">' class='manager_".$i."' style='display: ;' > ";
					//echo " <input type='button' name='del' onclick=\"javascript:delete_column_func('$seqno', '$fld_hnm', '$fld_enm', '$i');\"  value='delete' style='height:22px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  title=' Delete a column.'>";
					//echo "</div>";
				}
			} else {
				echo "";
			}

	?>
			</td>
<?php  } // if SQL_Search ?>
		</tr>
<?php } // for ?>
	<tr>
      <td colspan='8' align='center'>
	   <img src="./icon/bt_down_s02.gif" title="column down" border="0" onclick="down_func();" />&nbsp;&nbsp;
	   <img src="./icon/bt_up_s02.gif" title="column up" border="0" onclick="up_func();" />&nbsp;&nbsp;
<?php
		if( $mode=="SQL_Search") {
?>
			<span><input <?php echo "title='Register and create the created table.' "; ?> type='button' name='ins' onclick="javascript:table_create_func('<?=$line_set?>');"
			value="Create Table" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'></span>

			<!-- <input <?php echo "title='Delete the created table and register the changes.' "; ?> type='button' name='upd' onclick="javascript:Save_Update('<?=$line_set?>');"
			value="Save Change" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'> -->

			<!-- <input <?php echo "title='Save as a new table.' "; ?> type='button' name='Newset' onclick="javascript:Newtable_save('<?=$line_set?>');"
			value="NewTable" style='height:25px;background-color:cyan;color:blue;border-radius:20px;border:1 solid white'> -->
			
			<input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else if( $mode=="line_set" || $mode=="" || $mode == "table_create") {
?>
			<span><input <?php echo "title='Register and create the created table.' "; ?> type='button' name='ins' onclick="javascript:table_create_func('<?=$line_set?>');"
			value="Create Table" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'></span>
			<span><input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value=" Reset " style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'></span>
<?php
		}
?>
        &nbsp
		<br><b>#There should be no spaces in the name of the column.
      </td>
    </tr>
	</TBODY>

  </TABLE>
</Form>
</body>
</html>
<?php

	if( $del_mode == 'column_modify_mode' ){ //
		// sql to table - no use
	} else if( $del_mode == 'column_add_mode' ){
		// sql to table - no use
	} else if( $del_mode == 'Delete_column_mode' ){
		//sql to table - no use
	}
	if( $mode == "table_create_reaction" ){
		// sql to table - no use
		//create_reaction_func();
	} else if( $mode == "table_update_remake" ){
		// sql to table - no use
	}
	if( $mode == "sql_table_create" ) {
		if( !Table_check_() ) Table_Create_Submit();
		else m_("table exists : " . $tab_enm);
	} else if( $mode == "table_new_copy" ){	// copy and new.
		// sql to table - no use
		//copy_func();
	}
	//==========================================
	function Table_Create_Submit(){
		global $H_ID, $H_EMAIL, $table_yn, $mode, $line_set;
		global $config;
		global $tkher;
		global $project_code, $project_name, $tab_hnm, $tab_enm; 

		$item_list = " create table `". $tab_enm . "` ( ";
		$item_list = $item_list . " `seqno` INT(11) auto_increment not null, ";
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
				$memo = str_replace('auto_increment', '', $memo);
				$item_list = $item_list . '`'.$fld_enm . '`' . $memo . ', ';
				
				$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$memo' ";
				$ret = sql_query( $sql );
				if( !$ret ) {
					m_("error --- insert table10_table - $tab_enm");
					echo "Make sure you use reserved words in column names.<br>sql: " . $sql;
					exit;
				}
				$Asqltable=''; $if_lineA=0; $if_typeA=''; $if_dataA=''; $relation_dataA='';
				$cnt++;
			}
		}

		$key_msg= $_POST["key_msg"];
		if( $key_msg == '' ) $item_list = $item_list . " PRIMARY KEY (`seqno`) ); ";
		else $item_list = $item_list . " PRIMARY KEY (`seqno`), ";
		
		$SQLA = str_replace('\\', '', $item_list);//Rec count:1, SQLKapp_em_tran, already exists. 
		$SQLA = $SQLA . $key_msg;	//echo "sql:" . $SQLA; 

		$item_cnt  = $cnt - 1;
		$ret = sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='11', disno=0, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$item_array', sqltable='$item_list' " );

		if( $ret ){
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$item_cnt, userid='$H_ID', tab_mid='$H_ID', memo='$item_list' ";
			
			$rets = sql_query( $query);
			if( $rets ){ //m_("PG Create OK! table10_pg_table  insert ");//OK table10_pg_table - insert  -- 
				if( !kapp_table_check( $tab_enm ) ){

					$mq1 = sql_query( $SQLA ); // Table Create SQL ------------------------------------
					sleep(1);
					
					if( !$mq1 ) {
						echo "sql: " . $item_list; //컬럼명에 예약어를 사용했는지 확인하세요
						m_("ERROR - Make sure you use reserved words in column names. - Create table - $tab_enm");
						exit;
					} else {
						m_("$tab_enm : table create ok!");
						$table_yn = 'y';
						$link_ = KAPP_URL_T_ . "/tableK_sql.php?tab_enm=". $tab_enm;
						$p_msg = 'table10@tableK_sql.php : ' . $tab_enm;
						insert_point_app( $H_ID, $config['kapp_write_point'], $link_, $p_msg );

						$Tret = TAB_curl_sendA( $tab_enm, $tab_hnm, 0, $item_list, 0, '', '', '', $item_array ); // table_create
						sleep(1);
						if( $Tret ) { //m_("TAB_curl_sendA -- OK, Tret:" . $Tret);
							$sys_link = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $tab_enm; 
							$Pret = PG_curl_sendA( $line_set , $item_array, $if_type, $if_data, '', $sys_link, '' , '' );
							sleep(1);

						} else  m_("TAB_curl_sendA -- Error");
						if( $Pret ) m_("c  Successful creation of the $tab_hnm table - $tab_enm.");
					}
				}

			} else {
				m_("Error INSERT table10_pg_table , $tab_enm , $tab_hnm ");
			}
		} else m_("ERROR INSERT table10_table create_func - tab seqno in ");

		//echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$mode' );</script>";
		exit;
	}
	function Table_check_(){
		global $table_prefix, $tab_enm, $tkher;
		$sql = "SELECT * from {$tkher['table10_table']} where tab_enm='$tab_enm' ";
		$rec = sql_fetch($sql);
		if( isset($rec['tab_enm']) && $rec['tab_enm'] !='' ) return true;
		else false;
	}
	function kapp_table_check( $tab ){
		global $table_prefix;
		$sql = "SELECT COUNT(*) as cnt FROM Information_schema.tables
		WHERE table_schema = '".KAPP_MYSQL_DB."'
		AND table_name = '".$tab."' ";
		$ret = sql_fetch($sql);
		if( $ret['cnt'] > 0 ) { 
			m_("Rec count:".$ret['cnt'] .", " . $tab . ", already exists. ");
			echo "<br>rec count:".$ret['cnt'] .", " . $tab . ", already exists. ";
			return true;
		} else { 
			echo "<br>" . $tab . ", --- ";
			return false;
		}
	}
	function create_reaction_func(){
		// no use - sql to table
	}
	function copy_func(){
		// sql to table - no use
	}
	function update_remake_func(){
		// sql to table - no use
	}
	//==========================================================================================
	function TAB_curl_sendA( $tab_enm, $tab_hnm, $cnt , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ){
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
		if( $response == false) {
			echo 'curl 전송 실패 : ' . curl_error($curl);
		}
		curl_close($curl);
		return $response;
	}
	function PG_curl_sendA( $item_cnt , $item_array, $iftype_db, $ifdata_db, $popdata_db, $sys_link, $rel_data , $rel_type ){
		global $pg_code, $pg_name, $tab_enm, $tab_hnm, $H_ID, $H_EMAIL, $hostnameA, $config, $kapp_iv,$kapp_key;      
		global $H_ID, $H_EMAIL, $project_code, $project_name; 
		global $kapp_mainnet;
		$pg_code = $tab_enm;
		$pg_name = $tab_hnm;
		$tabData['data'][][] = array();
		$cnt = 0;
		$tabData['data'][$cnt]['pg_code']  = $pg_code;
		$tabData['data'][$cnt]['pg_name']  = $pg_name;
		$tabData['data'][$cnt]['tab_enm']  = $tab_enm;
		$tabData['data'][$cnt]['tab_hnm']  = $tab_hnm;
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
		//echo curl_error($curl);
		if( $response == false) {
			//$_ms = "new program curl error : " . curl_error($curl);
			echo 'curl error PG_curl_send : ' . curl_error($curl);
		} else {
			//$_ms = 'new program app_pg50RC curl response : ' . $response;
		}
		curl_close($curl);
		return $response;
	} // function
?>
