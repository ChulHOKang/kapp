<?php
	include_once('./tkher_start_necessary.php');
	/*
	 * table_sql.php : table30m_A.php copy:2025-12-09, table30m_Create.php copy 2023-08-25 - kan
	   2024-01-04   : TIME fld type add. $view_set=1 add
	   2024-01-03   : $item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 보완.
	   2023-10-12   : 컬럼명 또는 컬럼 타이들을 변경 했을 때 관련 프로그램(table10_pg의 item_array)도 변경한다 중요.
	                : 컬럼 위치 이동 과 이동후 컬럼 삭제 버턴 숨김 처리 추가 중요.
	 * TAB_curl_sendA( $tab_enm, $tab_hnm,0 , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ); // table_update_remake 2023-07-25 add
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
		$uid = explode('@', $H_ID);
		$tab_enm = $uid[0] . "_" . time();
	}

	if( isset($_POST['tab_hnm']) ) $tab_hnm	= $_POST["tab_hnm"];
	else $tab_hnm = '';
	if( isset($_POST['tab_hnmS']) ) $tab_hnmS	= $_POST["tab_hnmS"];
	else $tab_hnmS = '';
	if( isset($_POST['line_set']) ) $line_set = $_POST['line_set'];
	else $line_set = 50;
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['del_mode']) ) $del_mode = $_POST['del_mode'];
	else $del_mode = '';
	if( isset($_POST["group_code"])  && $_POST["group_code"] !== '') $group_code	= $_POST["group_code"];
	else  $group_code	= "";
	if( isset($_POST["group_name"])  && $_POST["group_name"] !== '') $group_name	= $_POST["group_name"];
	else  $group_name	= "";

	if( $mode == "table_name_change" && isset($tab_enm) ) {
			$aa = explode(':', $tab_hnmS);
			$tab_nmS0 = $aa[0];
			$tab_nmS1 = $aa[1];
			$mode ="Search";
			$query="update {$tkher['table10_table']} set group_code='".$group_code."', group_name='".$group_name."', tab_hnm='".$tab_hnm."' where tab_enm='$tab_nmS0' "; 
			$g = sql_query( $query );
			if( !$g ) m_("update error");
			else {
				$query="update {$tkher['table10_pg_table']} set group_code='".$group_code."', group_name='".$group_name."', tab_hnm='".$tab_hnm."', pg_name='".$tab_hnm."' where (pg_code='".$tab_nmS0."' and tab_enm='".$tab_nmS0."') "; //OK
				$g1 = sql_query( $query );
				if( $g1 ) m_("Changed name of the Table table code: " . $tab_nmS0 . ", name:" . $tab_hnm . " <- " . $tab_nmS1);
				else m_("Error! Changed name of Table : " . $tab_nmS0 . ", name:" . $tab_hnm . " <- " . $tab_nmS1);
			}
	}
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
	}
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
//CREATE TABLE IF NOT EXISTS `homepagegroup` ( `seqno` blob NOT NULL auto_increment,
//CREATE TABLE IF NOT EXISTS `homepagegroup` ( `seqno` int(11) NOT NULL auto_increment,
// fld0_typeF(fld0), fld0_lenF( fld0 )
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
//-- No Use ------------
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
function send_memo_chk() {
	document.insert.dup_confirm.checked =false;
	document.insert.sql_table.value = '';
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

		sqlA= document.insert.sql_memo.value;
		sqlm = sqlA.split(',');
		if( sqlm.length > document.insert.line_set.value ){
			alert("Please set the Column count higher! column count: "+ sqlm.length + ", " +document.insert.line_set.value);
			return false;
		}
/*
		sqlm_length_old = document.insert.sqlm_length_old.value; 
		if( sqlm_length_old !='' && sqlm_length_old > sqlm.length ) {
			document.insert.sqlm_length_old.value = sqlm.length; 
			for(k=1; k < sqlm_length_old; k++){
				document.insert["fld_enm[" + k + "]"].value  = '';
				document.insert["fld_hnm[" + k + "]"].value  = '';
				document.insert["fld_type[" + k + "]"].value  = '';
				document.insert["fld_len[" + k + "]"].value  = '';
				document.insert["memo[" + k + "]"].value  = '';
			}
		}
		*/
		//if( sqlm[0].indexOf("AUTO_INCREMENT") != -1 || sqlm[0].indexOf("auto_increment") != -1) { //auto_increment
		//	auto = 'AUTO_INCREMENT';
		//}
		//alert("sqlm0: " +sqlm[0]);//CREATE TABLE IF NOT EXISTS `aboard_` (  `no` int(11) NOT NULL auto_increment
		tab_enm = sql_tab( sqlm[0]);
		fld0_enm = fld0_enmF( sqlm[0]);
		fld0_type = fld0_typeF( sqlm[0]);//
		fld0_type = fld0_type.toUpperCase();//		alert("fld0_type: "+fld0_type);
		fld_len = fld0_lenF( sqlm[0]);
		fld_len_default = fld0_deF( sqlm[0]);

		msg = tab_enm + '\n' + '@' + '|' +fld0_enm + '|' +fld0_type+ '|' + fld_len + '|'+ fld_len_default + '\n'  +'@';
			if( fld0_enm == 'seqno') {
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
		//alert("sqlm.length: "+ sqlm.length);//sqlm.length: 53
		for( i=1; i < sqlm.length; i++, jj++){
			fld_enm = '';
			fld_t = '';
			fld_len = '';
			auto = '';
			//alert( "sqlm-" + i + " : " + sqlm[i]);
			mf = sqlm[i].split('`');
			if( last_check == 'on' ){
				key_msg = key_msg +sqlm[i];
				continue;
			}
			if( mf[2] == '' ){	//alert(" error : mf2: " + mf[2]);
				if( last_check == 'on' && i == sqlm.length-1 ) {
					alert( i+ " - msg: " +msg);
					//document.insert.sql_table.value = msg + key_msg;
					break;
				} else if( last_check == 'on' && i < sqlm.length-1 ) continue;
				alert(" 111 - msg: " +msg);
				document.insert.sql_table.value = msg + key_msg;
				break;
			}//`user_ip` varchar(255) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			if( i == sqlm.length-1 ){
				mf_last = sqlm[i].split(')');
				if( mf_last[0] !='' ) {
					mf = mf_last[0].split('`');
					fld_len_default = mf_last[1];
				}
			}
			fld_enm = mf[1];
			if( sqlm[i].indexOf("PRIMARY KEY") != -1 || sqlm[i].indexOf("primary key") != -1 ) {
				fld_enm = '';
				fld_t = '';
				key_msg = key_msg +sqlm[i];
				continue;
			} else if( sqlm[i].indexOf("UNIQUE KEY") != -1 ) {
				fld_enm = '';
				fld_t = '';
				key_msg = key_msg +sqlm[i];
				continue;
			} else if( sqlm[i].indexOf("KEY index") != -1 ) {
				fld_enm = '';
				fld_t = '';
				key_msg = key_msg +sqlm[i];
				continue;
			} else if( sqlm[i].indexOf("KEY ") != -1 || sqlm[i].indexOf("key ") != -1 ) {
				key_msg = key_msg +sqlm[i];
				last_check = 'on';
				continue;
			} else if( mf[2].indexOf("AUTO_INCREMENT") != -1 || mf[2].indexOf("auto_incrment") != -1 ) {
				auto = '        AUTO_INCREMENT';
			} else if( mf[2].indexOf("text") != -1 ) { //`up_day` datetime DEFAULT current_timestamp(),
				fld_t = 'text';//				fld_t = fld_t.toUpperCase();
				fld_len = '255';// length 관계없음 임시 설정.
				fld_len_default = mf[2];
				fld_len_default = fld_len_default.replace('text', '');
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+'|'+ fld_len_default + '\n' +'@';
			} else if( mf[2].indexOf("float") != -1 ) { //`up_day` datetime DEFAULT current_timestamp(),
				fld_t = 'float';//				fld_t = fld_t.toUpperCase();
				fld_len = '255';// length 관계없음 임시 설정.
				fld_len_default = mf[2];
				fld_len_default = fld_len_default.replace('float', '');
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+'|'+ fld_len_default + '\n' +'@';
			} else if( mf[2].indexOf("double") != -1 ) { //`up_day` datetime DEFAULT current_timestamp(),
				fld_t = 'double';//				fld_t = fld_t.toUpperCase();
				fld_len = '255';// length 관계없음 임시 설정.
				fld_len_default = mf[2];
				fld_len_default = fld_len_default.replace('double', '');
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+'|'+ fld_len_default + '\n' +'@';
			} else if( mf[2].indexOf("datetime") != -1 ) {
				fld_t = 'datetime';// length 관계없음 임시 설정.				fld_t = fld_t.toUpperCase();
				fld_len = '20';
				fld_len_default = mf[2];
				fld_len_default = fld_len_default.replace('datetime', '');
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+'|'+ fld_len_default + '\n' +'@';
			} else if( mf[2].indexOf("blob") != -1 ) {
				fld_t = 'longblob';//				fld_t = fld_t.toUpperCase();
				fld_len = '255'; // size 4GiB,  length 관계없음 임시 설정.
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+'|'+ fld_len + '\n' +'@';
			} else if( mf[2].indexOf("timestamp") != -1 ) {
				fld_t = 'timestamp';//				fld_t = fld_t.toUpperCase();
				fld_len = '20'; // length 관계없음 임시 설정.
				fld_len_default = mf[2];
				fld_len_default = fld_len_default.replace('timestamp', '');
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+'|'+ fld_len_default + '\n' +'@';
			} else if( mf[2].indexOf("date") != -1 ) {
				fld_t = 'date';//				fld_t = fld_t.toUpperCase();
				fld_len = '15';// length 관계없음 임시 설정.
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+'|'+ fld_len + '\n' +'@';
			} else if( mf[2].indexOf("time") != -1 ) {
				fld_t = 'time';//				fld_t = fld_t.toUpperCase();
				fld_len = '8';
				fld_len_default = mf[2];
				fld_len_default = fld_len_default.replace('time', '');
				msg = msg + '|' + fld_enm + '|' + fld_t +'|'+'|'+ fld_len_default + '\n' +'@';
			} else { //alert( i+ ",  mf2: " + mf[2]);
				if( mf[2].indexOf("(") != -1 ) {
					fld_t = fld_typeF( mf[2] );
					//alert("mf: "+ mf[2] + ", t:" +fld_t);
					fld_len_default = mf[2]; 
					field_len = fld_lenF( mf[2] );
					fld_len = field_len;
				} else {
					fld_t = mf[2];
					fld_t = mf[2].replace(' ', '');
					fld_len_default = mf[2]; //fld_lenF( mf[2] );
					field_len = fld_lenF( mf[2] );
					fld_len = field_len;
				}
				fld_t = fld_t.toUpperCase();
				msg = msg + '|' + fld_enm + '|' + fld_t.toUpperCase() +'|'+ fld_len_default + '\n' +'@';
				//alert( i+ ",  msg: " + msg);
			}
			fld_t = fld_t.toUpperCase();			//alert( i+ ",  fld_t: " + fld_t );
			document.insert["fld_enm[" + jj + "]"].value  = fld_enm;
			document.insert["fld_hnm[" + jj + "]"].value  = fld_enm;
			document.insert["fld_type[" + jj + "]"].value  = fld_t;
			document.insert["fld_len[" + jj + "]"].value  = fld_len;
			document.insert["memo[" + jj + "]"].value  = fld_len_default;

		} //for
		msg = msg + key_msg;
		document.insert.sql_table.value = msg;
	}
	//document.insert.submit();
	alert("SQL interpretation complete! Please check for table duplication");
	return;
}
</script>


<script language=javascript>
	function Project_change_func(cd){
		index=document.insert.group_code.selectedIndex;
		nm = document.insert.group_code.options[index].text;
		document.insert.group_name.value=nm;
		document.insert.old_group_code.value=document.insert.group_code.options[index].value;
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
			document.insert.action					="table_sql.php";
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
			document.insert.mode.value			="Search";
			document.insert.table_yn.value = table_yn;
			document.insert.add_column_hnm.value = document.insert["fld_hnm[" + no + "]"].value;
			document.insert.add_column_enm.value = document.insert["fld_enm[" + no + "]"].value;
			document.insert.add_column_type.value = document.insert["fld_type[" + no + "]"].value;
			document.insert.add_column_len.value = document.insert["fld_len[" + no + "]"].value;
			document.insert.add_column_memo.value = document.insert["memo[" + no + "]"].value;
			document.insert.action					="table_sql.php";
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
			document.insert.action				="table_sql.php";
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
			document.insert.action="table_sql.php";
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
			document.insert.action="table_sql.php";
			document.insert.submit();
	}

	function sendCon(form){
		f_nm = document.insert["fld_enm[0]"].value;
		if ( f_nm == "" ) {
			window.alert("An unentered field remains.");//입력 되지 않은 필드가 남아 있습니다.\n모두 입력하신 후에 계속등록하십시요.
		} else {
			document.insert.action="table_sql.php";
			document.insert.submit();
		}
	}

	function table_create_func(line){
		if( document.insert.dup_confirm.checked === false ) {
			alert("duplicate Confirm error, table - duplicate confirm please!");
			return false;
		}
		if( !document.insert.group_code.value) {
			alert(' Select Project! code:' + document.insert.group_code.value);
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
			if( !len) {
				if( fnm ) {
					alert('Check the column length input! ');// 컬럼 길이 입력을 확인 하세요!
					return false;
				}
			}
		}
		var ins = window.confirm("Register and create the table. ");//테이블을 등록및 생성합니다.
		if( ins ) {
			document.insert.mode.value='table_create';
			document.insert.action="table_sql.php";
			document.insert.submit();
		  }
	}

	function resetgo(){
		window.open( 'table_sql.php' , '_self', '');
		return;
	}

	function Newtable_save(cnt){
		new_table_name = document.insert.tab_hnm.value;
		tab = document.insert.tab_hnmS.value;
		da = tab.split(":");
		hnm=da[1];
		enm=da[0];
		document.insert.group_code.value=da[2];
		document.insert.group_name.value=da[3];
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
					document.insert.mode.value='table_new_copy';
					document.insert.action="table_sql.php";
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
			document.insert.action="table_sql.php";
			document.insert.submit();
		}
	}

/*
	function create_after_run(tab_enm, tab_hnm, mode){
		var selectIndex = document.insert.tab_hnmS.selectedIndex;
		tab_hnmS=tab_enm + ":" + tab_hnm;
		document.insert.tab_hnmS[selectIndex].value = tab_hnmS;
		document.insert.mode.value		= "Search";
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

		document.insert.action					="table_sql.php";
		document.insert.submit();
	}*/

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
	
	if( $mode == 'Search' ){
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
				$group_code		= $rs['group_code'];
				$group_name		= $rs['group_name'];
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

		if( $pg_mode=="on" ){
			$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$tab_enm' ";
			$resultPG = sql_query($sqlPG);
			$table10_pg = sql_num_rows($resultPG);
			if( $table10_pg ) {
				$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', item_cnt=$ARR, item_array='$item_array' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
				sql_query($query);
			} else {
				$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', relation_type='',relation_data='', item_cnt=$cnt, userid='$H_ID', tab_mid='$H_ID' ";
				sql_query($query);
				$link_ = KAPP_URL_T_ . "table_sql.php";
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
		<!-- <input type="hidden" name="tab_enm" value='<?=$tab_enm?>'> -->
		<input type="hidden" name="disno" value='<?=$disno?>'>
		<input type="hidden" name="add_column_no" value=''>
		<input type="hidden" name="add_column_enm" >
		<input type="hidden" name="add_column_hnm" >
		<input type="hidden" name="add_column_type" >
		<input type="hidden" name="add_column_len" >
		<input type="hidden" name="add_column_memo" >
		<input type="hidden" name="group_code_table" value="<?=$group_code_table?>">
		<input type="hidden" name="old_group_code" >
		<input type="hidden" name="old_group_name" >
		<input type="hidden" name="table_yn" value='<?=$table_yn?>'>
		<input type="hidden" name="sqlm_length_old" value=''>
		
		
		<h2><font fce="Arial">Table Design( SQL to Table ) <?php if( $mode=='Search' ) echo "( Change )"; ?></font></h2>

<div>
	<ul>
		<span bgcolor='#f4f4f4' <?php echo "title='You can change or add the group name of the table.' "; ?>><font color='black'>Project</span>
		<span bgcolor='#ffffff'><SELECT id='group_code' name='group_code' onchange="Project_change_func(this.value);" style='width:250px;height:30px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered. ' "; ?> >
				<option value=''>Select project</option>
				<!-- <option value='ETC' selected>ETC</option> -->
<?php
			$SQLG = "SELECT * from {$tkher['table10_group_table']} where userid='".$H_ID."' order by group_name ";
			$result = sql_query( $SQLG );
			while($rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['group_code']?>" <?php if($rs['group_code']==$group_code) echo "selected"; ?>><?=$rs['group_name']?></option>
<?php
			}
?>
			</select>
<?php
		if ( isset($H_ID) && $H_ID !== "" ) {
?>
		</span>
		<input type='hidden' name='group_name' value='<?=$group_name?>' style='height:25px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='You can change or add the group name of the table.' "; ?> >
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
		<span bgcolor='#ffffff'><input type='text' name='tab_enm'  value='' style='width:250px;height:30px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>></span>&nbsp;
	<span bgcolor='#f4f4f4' <?php echo "title='Select a table from the list of registered tables.' "; ?>>Table Name</span>
		<span bgcolor='#ffffff'><input type='text' name='tab_hnm'  value='<?=$tab_hnm?>' style='width:250px;height:30px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>></span>
		<span>
		&nbsp;<input type='checkbox' id='dup_confirm' name='dup_confirm' value='Confirm' onClick="return false">&nbsp;
		&nbsp;<input type='button' onclick="table_nm_dup_check();" value='Duplicate check' >
		</span>

</ul>
</div>

<div>
		<span bgcolor='#f4f4f4' title='Enter SQL here'><textarea title='Enter SQL here' id="sql_memo" name="sql_memo" rows="4" cols="100%"></textarea></span>
		<span bgcolor='#f4f4f4'><textarea id="sql_table" name="sql_table" rows="4" cols="100%" style='color:yellow;display:none;'></textarea></span>
		<p bgcolor='#f4f4f4'><input type='button' onclick="javascript:send_memo_chk();" value=' Sql to Table ' style='height:30px;width:150;background-color:black;color:white;border-radius:20px;border:1 solid black;' title='sql to table' ></p>

</div>

<div>
				  Column Count : <SELECT type='text' name="line_set" onchange="javascript:line_set_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Set the number of lines to be registered.' "; ?>><!--  \n등록할 라인수를 설정합니다. -->
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
			 <?php if( $mode=='Search' ) echo "<TH><b>CTL</b></TH>"; ?>
			</TR>
	</THEAD>
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
				  <option <?php echo "title='INT The range of 4-byte integer types is 2147483647 with -2,147,483,647 when there is a sign, and 4,294,967,295 when there is no sign.' "; ?> value="INT" <?php if($fld_type == 'INT') echo " selected ";  ?> >INT</option>
				  <option <?php echo "title='TINYINT The range of a 1-byte integer type is from -128 to 127 when it is signed, and from 0 to 255 when it is not signed.' "; ?> value="TINYINT" <?php if($fld_type == 'TINYINT') echo " selected ";  ?> >TINYINT</option>
				  <option <?php echo "title='SMALLINT The range of a 2-byte integer is -32,768 to 32,767 if signed and 0 to 65,355 if unsigned.' "; ?> value="SMALLINT" <?php if($fld_type == 'SMALLINT') echo " selected ";  ?> >SMALLINT</option>
				  <option <?php echo "title='MEDIUMINT The range of 3-byte integers is -8388608 to 8388607 if signed, and 0 to 16,777,215 if not signed.' "; ?> value="MEDIUMINT" <?php if($fld_type == 'MEDIUMINT') echo " selected ";  ?> >MEDIUMINT</option>
				  <option <?php echo "title='BIGINT An 8-byte integer type range is from -9,223,372,036,854,775,808 to +9,223,372,036,854,775,808 when there is a sign, and 18,446,744,073,709,551,615 when there is no sign.' "; ?> value="BIGINT" <?php if($fld_type == 'BIGINT') echo " selected ";  ?>>BIGINT</option>
				  <option <?php echo "title='DECIMAL Fixed-point number (M, D): The maximum number of digits (M) is 65 (default is 10) and the maximum number of decimal places (D is 30)' "; ?> value="DECIMAL" <?php if($fld_type == 'DECIMAL') echo " selected ";  ?>>DECIMAL</option>
				  <option <?php echo "title='FLOAT A small floating-point number, acceptable values are -3.402823466E + 38 to -1.175494351E-38, 0, and 1.175494351E-38 to 3.402823466E + 38.' "; ?> value="FLOAT" <?php if($fld_type == 'FLOAT') echo " selected ";  ?>>FLOAT</option>
				  <option <?php echo "title='DOUBLE precision floating point numbers, acceptable values are -1.7976931348623157E + 308 to -2.2250738585072014E-308, 0, And from 2.2250738585072014E-308 to 1.7976931348623157E + 308.' "; ?> value="DOUBLE" <?php if($fld_type == 'DOUBLE') echo " selected ";  ?>>DOUBLE</option>
				  <option <?php echo "title='DATE Date types 1000-01-01 through 9999-12-31 are available.' "; ?> value="DATE" <?php if($fld_type == 'DATE') echo " selected ";  ?>>DATE</option>
				  <option <?php echo "title='DATETIME Date and time combination, 1000-01-01 00:00:00 through 9999-12-31 23:59:59 Wanted.' "; ?> value="DATETIME" <?php if($fld_type == 'DATETIME') echo " selected ";  ?>>DATETIME</option><!-- 2023-07-18 kan -->
				  <option <?php echo "title='TIME Date and time combination, 00:00:00 through 23:59:59 Wanted.' "; ?> value="TIME" <?php if($fld_type == 'TIME') echo " selected ";  ?>>TIME</option>
				  <!-- <option <?php echo "title='TIMESTAMP timestamp format 1970-01-01 00:00:01 UTC to 2038-01-09 03:14:07 UTC Until EPOCH (1970-01-01 00:00:00 UTC), the elapsed time in seconds since the number.' "; ?> value="TIMESTAMP" <?php if($fld_type == 'TIMESTAMP') echo " selected ";  ?>>TIMESTAMP</option> -->
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
		if($mode=='Search') {
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
		if( $mode=="Search") {
?>
			<input <?php echo "title='Delete the created table and register the changes.' "; ?> type='button' name='upd' onclick="javascript:Save_Update('<?=$line_set?>');"
			value="Save Change" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
			<input <?php echo "title='Save as a new table.' "; ?> type='button' name='Newset' onclick="javascript:Newtable_save('<?=$line_set?>');"
			value="NewTable" style='height:25px;background-color:cyan;color:blue;border-radius:20px;border:1 solid white'>
			<input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else if( $mode=="line_set" || $mode=="" || $mode == "table_create") {
?>
			<!-- <input <?php echo "title='Re-create the table after deletion.'"; ?> type='button' name='upd' onclick="javascript:Save_Update_Insert('<?=$line_set?>');"
			value="Change additional registration" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'> -->
<?php
		//} else {
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

	//$tabData['data'][][] = array();
	function TAB_curl_sendA( $tab_enm, $tab_hnm, $cnt , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ){
		//m_("start --- TAB_curl_sendA ");
		global $H_ID, $H_EMAIL, $group_code, $group_name;
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
		$tabData['data'][$cnt]['group_code'] = $group_code;
		$tabData['data'][$cnt]['group_name'] = $group_name;
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
			//$_ms = "table30m curl 전송 실패 : " . curl_error($curl);
			echo 'curl 전송 실패 : ' . curl_error($curl);
		} else {
			//$_ms = 'table30m curl 응답 : ' . $response;
			//echo 'curl 응답 : ' . $response;
		}
		// ============ :table30m curl 응답 : --- count:10Error: Update failed{"message":"_api table data 전달 완료"}
		curl_close($curl);		//m_("curl end--------------- ms:"); //exit();
		return $response;
	}
	function PG_curl_sendA( $item_cnt , $item_array, $iftype_db, $ifdata_db, $popdata_db, $sys_link, $rel_data , $rel_type ){
		//m_("start --- PG_curl_sendA ");
		// use: kapp_tabel_create.php, app_pg50RC.php,  table_sql.php
		global $pg_code, $pg_name, $tab_enm, $tab_hnm, $H_ID, $H_EMAIL, $group_code, $group_name, $hostnameA, $config, $kapp_iv,$kapp_key;      
		global $H_ID, $H_EMAIL, $group_code, $group_name, $tab_hnm, $tab_enm; 
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
		$tabData['data'][$cnt]['group_code'] = $group_code;
		$tabData['data'][$cnt]['group_name'] = $group_name;
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
	function Table_Create_(){
		global $H_ID, $H_EMAIL, $table_yn, $mode, $line_set;
		global $config;
		global $tkher;
		global $group_code, $group_name, $tab_hnm, $tab_enm; 

		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " seqno int auto_increment not null, ";
		$item_list = $item_list . ' kapp_userid  VARCHAR(50),';
		$item_list = $item_list . ' kapp_pg_code VARCHAR(50),';

		//$tab_hnm	= $_POST["tab_hnm"];
		//$group_code	= $_POST["group_code"];
		//$group_name= $_POST["group_name"];
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
				if( $fld_type =='INT' )				$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )		$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )	$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )	$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )	$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )		$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' default 0.0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' default 0.0, ';
				else if( $fld_type =='CHAR' )		$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )	$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )		$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )		$item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )   $item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' , ';
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . '`'.$fld_enm . '` ' .  $fld_type . ' , ';
				$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$group_code', group_name='$group_name', memo='$memo' ";
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
		$item_list = $item_list . " primary key(`seqno`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$line_set  = $cnt - 1;
		$ret = sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', group_code='$group_code', group_name='$group_name', memo='$item_array', sqltable='$item_list' " );

		if( $ret ){
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$line_set, userid='$H_ID', tab_mid='$H_ID' ";
			
			$rets = sql_query($query);
			if( $rets ){ //m_("PG Create OK! table10_pg_table  insert ");//OK table10_pg_table - insert  -- 
				$Tret = TAB_curl_sendA( $tab_enm, $tab_hnm, 0, $item_list, 0, '', '', '', $item_array ); // table_create
				if( $Tret ) { //m_("TAB_curl_sendA -- OK, Tret:" . $Tret);
					$sys_link = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $tab_enm; 
					$Pret = PG_curl_sendA( $line_set , $item_array, $if_type, $if_data, '', $sys_link, '' , '' );
				} else  m_("TAB_curl_sendA -- Error");

				if( !kapp_table_check( $tab_enm ) ){
					$mq1 = sql_query( $item_list ); // Table Create SQL
					if( !$mq1 ) {
						echo "sql: " . $item_list; //컬럼명에 예약어를 사용했는지 확인하세요
						m_("Make sure you use reserved words in column names. Error - Create table - $tab_enm");
						exit;
					} else {
						$table_yn = 'y';
						$link_ = KAPP_URL_T_ . "table_sql.php";
						insert_point_app( $H_ID, $config['kapp_write_point'], $link_, 'table10@table_sql.php' );
						m_("c  Successful creation of the $tab_hnm table - $tab_enm.");
					}
				}
			} else {
				m_("Error INSERT table10_pg_table , $tab_enm , $tab_hnm ");
			}
		} else m_("ERROR INSERT table10_table create_func - tab seqno in ");

		//echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$mode' );</script>";
		exit;
	}

	if( $del_mode == 'column_modify_mode' ){ //
		$table_yn	=$_POST['table_yn'];
		$tab_enm	=$_POST['tab_enm'];
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
			$mq1=sql_query($query);
			if( $mq1 ) {
				sql_query( "UPDATE {$tkher['table10_table']} set  fld_hnm= '$fld_hnm', fld_type= '$fld_type', fld_len=$fld_len, memo='$fld_memo' where seqno=$seqno " );
				m_(" column update OK!! ");
			} else {
				printf(" sql:%s ", $query);
				m_(" column modify 실패------------!! ");
			}
		} else {
			$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len=$fld_len, userid='$H_ID', memo='$fld_memo', disno=$dis ";
			$ret = sql_query( $sql );
			if( $ret ) m_(" table10 column add OK!! ");
			else { m_("table10_table insert ERROR"); exit;}
		}
		//echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";

	} else if( $del_mode == 'column_add_mode' ){
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
		//echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";

	} else if( $del_mode == 'Delete_column_mode' ){
		$seqno	= $_POST["del_seqno"]; 
		$fld_enm	= $_POST["del_fld_enm"];
		$query = "ALTER TABLE $tab_enm drop $fld_enm ";
		$mq1	=sql_query($query);
		$query = "DELETE from {$tkher['table10_table']} where userid='" .$H_ID. "' and seqno = ". $_POST["del_seqno"];
		$mq2	=sql_query($query);
		//echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";
	}
	if( $mode == "table_create_reaction" ){
		create_reaction_func();
	} else if( $mode == "table_update_remake" ){
		$view_set=1; // update_pg_func()에서 참고 내용을 1번만 출력 하도록 한다.
		update_remake_func();
	}
	if( $mode == "table_create" ) {
		if( !Table_check_() ) Table_Create_();
		else m_("table exists : " . $tab_enm);
	} else if( $mode == "table_new_copy" ){	// copy and new.
		copy_func();
	}
	//==========================================================================================
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
		$item_list = $item_list . ' kapp_userid  VARCHAR(50),'; // add 20251118
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
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
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
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$cnt, userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);
			$link_ = KAPP_URL_T_ . "/table_sql.php";
			//insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'table10_pg@table30m' );//PG create point
		}
		//echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' ,  '$mode' );</script>";
	}
	//=============================================================
	function copy_func(){
		global $H_ID, $mode;
		global $config;
		global $tkher;
		$tab_enm		= $H_ID . "_" . time();
		$tab_hnm		= $_POST["tab_hnm"];
		if( isset($_POST["group_code"])  && $_POST["group_code"] !== '') $group_code	= $_POST["group_code"];
		else  $group_code	= "";
		if( isset($_POST["group_name"])  && $_POST["group_name"] !== '') $group_name	= $_POST["group_name"];
		else  $group_name	= "";

		$item_list  = " create table ". $tab_enm . " ( ";
		$item_list  = $item_list . " seqno int auto_increment not null, ";
		$item_list = $item_list . ' kapp_userid  VARCHAR(50),'; // add 20251118
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
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$group_code', group_name='$group_name', memo='$memo' " );
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=$cnt, userid='$H_ID', table_yn='y', group_code='$group_code', group_name='$group_name', memo='key column', sqltable='$item_list' " );
		$line_set = $cnt;
		$fld_enm  = "fld_" . $ARR;
		$mq1 = sql_query( $item_list );
		if( !$mq1 ) {
			m_( $tab_hnm . "x1 table creation failed.");
		} else {
			m_("  Successful creation of the ".$tab_hnm." table.");
			$link_ = KAPP_URL_T_ . "table_sql.php";
			insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'copy table10@table30m' );//re make copy
			TAB_curl_sendA( $tab_enm, $tab_hnm, 0, $item_list, 0, '', '', '', $item_array ); 
		}
		$enm		= $_POST['tab_enm'];
		$sqlPG		= "SELECT * from {$tkher['table10_pg_table']} where userid='".$H_ID."' and pg_code='".$enm."' ";
		$resultPG	= sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$rsPG = sql_fetch_array($resultPG);
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='".$rsPG['item_array']."', if_type='".$rsPG['if_type']."', if_data='".$rsPG['if_data']."', pop_data='".$rsPG['pop_data']."', relation_data='".$rsPG['relation_data']."', item_cnt=".$rsPG['item_cnt'].", userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);	// 중요.		//coin_add_func( $H_ID, 200 ); //OK !!!
			$link_ = KAPP_URL_T_ . "/table_sql.php";
			//insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'copy table10_pg@table30m' );// PG create point
		} else {
			m_(" Copy ERROR : mode:".$mode.", pg_code:".$enm );
		}
		//echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$mode' );</script>";
	}

	function update_remake_func(){
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
		$item_list = $item_list . ' kapp_userid  VARCHAR(50),'; // add 20251118
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
				else if( $fld_type =='DATE' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';	// no use
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';

				sql_query( "INSERT INTO {$tkher['table10_table']} set  group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', memo='$memo' " );

				// table_update_remake --- curl array ----- no use
				//TAB_curl_move( $tab_enm, $tab_hnm, $fld_enm, $fld_hnm, $fld_type, $fld_len, $ARR, $memo, $Asqltable, $if_lineA, $if_typeA, $if_dataA, $relation_dataA);
				$cnt++;
			}
		} // for

		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set  group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', memo='$item_array', sqltable='$item_list' " );

		$line_set = $cnt-1;
		TAB_curl_sendA( $tab_enm, $tab_hnm,0 , $item_list, $_POST["Aif_line"][0], $_POST["Aif_type"][0], $_POST["Aif_data"][0], $_POST["Arelation_data"][0], $item_array );

		$mq1 = sql_query( $item_list );
		if( !$mq1 ) {
			echo "sql:" . $item_list; exit;
		} else m_( $tab_enm . ", Successful creation of the " . $tab_hnm . " table.");

		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='".$H_ID."' and pg_code='".$tab_enm."' ";
		$resultPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name',  item_cnt=$line_set, item_array='$item_array', tab_mid='$H_ID' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
			sql_query($query);
		} else {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$line_set, userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);
				$link_ = KAPP_URL_T_ . "/table_sql.php";
				//insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'table10_pg@table30m' );//PG create point - update_remake_func()
		}
		//echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$mode' );</script>";
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
	// 사용 하지않음 --- // 컬럼명이 변경 되었을 때, 사용된 테이블 관련된 프로그램의 컬럼명을 변경한다.
	function update_pg_funcX($fld_enm, $fld_enmO, $fld_hnm, $fld_hnmO){
		global $H_ID, $tab_enm, $mode;
		global $config;
		global $tkher;
		$chg=0;
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where tab_enm='".$tab_enm."' ";
		$retPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($retPG);
		if( $table10_pg ) {
			while( $rs = sql_fetch_array( $retPG)) {
				$item_array = $rs['item_array'];

				$list		= explode("@", $item_array);
				for ( $i=0; $list[$i] !== ""; $i++ ){
					$ddd				= $list[$i];
					$item				= explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2 , $item[1]; //e, $item[2]; //h, $item[3]; //t	$item[4]; //l
					if( $item[1] == $fld_enmO ) {	//$item[1] = $fld_enm;
						$i_data = "|" . $fld_enm . "|" .$item[2] . "|" .$item[3] . "|" .$item[4];
						$retA = str_replace($ddd , $i_data, $item_array); //$result = str_replace('바나나' , '수박', $str);
						$query = "UPDATE {$tkher['table10_pg_table']} SET item_array='$retA' WHERE seqno=" . $rs['seqno'];
						sql_query($query);
						$chg=1;
					}
				}
			}
		}
		if( $chg == 1 && $view_set){
			m_( $table10_pg . ": Program - " . $rs['pg_code'] . ":" . $rs['pg_name'] . ", If you have settings for calculation formulas, pop-up windows, and relational expressions, you may need to check them. " . $item_array);
			$view_set = 0; //계산식, 팝업창, 관계식에 대한 설정 있다면 확인이 필요할 수 있습니다.
		}
	}
?>
