<?php

	include "kapp_start.php";  
	//include "./SQL_Create_jsonA.php";
	//include_once('../tkher_start_necessary.php');
	if($_SESSION['mb_level'] < 8) {
		m_("잘못된 접근입니다.---mb_level:".$member['mb_level']);
		echo "<script>window.open( './index.php' , '_self');</script>";
	}

	DB_Connect();

	//include "./SQL_Create_json.php";
	/* include '../modu_shop/coupon/tkher_db_lib.php';		
	include '../modu_shop/coupon/tkher_dbcon_Table.php';  */

	if( $_POST['mode'] === 't_delete'){
		$table_name = json_decode($_POST['table_name'], true);
		$prefix = json_decode($_POST['prefix'], true);

		Delete_table($prefix, $table_name);
	}

	function Delete_table($_prefix, $tab) {
		$kapp_tab = $_prefix.$tab;
		$SQL = " drop table ".$kapp_tab." ";
		$result = sql_query( $SQL );
		if( !$result ){
			echo json_encode("$tab Table Create Invalid query: " . $SQL);
			echo json_encode("Please check if the $tab table already exists.");
		} else {
			echo json_encode("Delete Success : $tab");
		}
	}
	//--------------------------------------
	function DB_Connect(){
		global $tkher;
		$kapp_dbcon_connect		= KAPP_PATH_T_ . "/data/kapp_dbcon.php";
		if( file_exists( $kapp_dbcon_connect ) ) {  
			include_once( $kapp_dbcon_connect );
		} else {
			m_("KAPP Setup please! No found file: " . $kapp_dbcon_connect); // No found file: /var/www/html/kapp/data/kapp_dbcon.php
			echo "<a href='./index.php' > K-APP Setup Go </a>";
			exit;
		}
		$kapp_dblib_common = "./kapp_dblib_common.php";
		if( file_exists($kapp_dblib_common) ) {  
			include_once( $kapp_dblib_common );    // db 라이브러리       
		} else {
			m_( $kapp_dblib_common . " - file no found! Error!"); // kapp_dblib_common.php
			//echo "<script>window.open( './index.php', '_TOP', ''); </script>";
			exit;
		}
		$connect_db = sql_connect( KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD, KAPP_MYSQL_DB) or die('MySQL Connect Error!!! <br>- Confirm DB password! and DB-NAME , pw:' . KAPP_MYSQL_PASSWORD . ', db:' . KAPP_MYSQL_DB . ', user:' . KAPP_MYSQL_USER);   
		$select_db  = sql_select_db( KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error! <br>- Confirm DB password! and DB-NAME, pw:' . KAPP_MYSQL_PASSWORD . ', db:' . KAPP_MYSQL_DB . ', user:' . KAPP_MYSQL_USER);

		$tkher['connect_db'] = $connect_db;       
		sql_set_charset('utf8', $connect_db);       
	}
?>