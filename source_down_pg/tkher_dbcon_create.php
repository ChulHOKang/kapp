<?php
	include "urllink_db_lib.php";  
	/*
        tkher_dbcon_create.php
		call : setup.php에서 call한다. 
		out  : tkher_dbcon.php를 생성한다.
	*/
	$mode= $_POST['mode'];
	$tab_enm= $_POST['tab_enm'];
	$db_id= $_POST['db_id'];
	echo "<script>alert('mode:".$mode.", db_id:' + ".$db_id."); </script>";  
	if( $mode=='db_create' or $mode== 'urllink_db_recreate_action') { //, db_recreate_action
		$db_name 		= $_POST['db_name'];
		$db_id 			= $_POST['db_id'];
		$db_password 	= $_POST['db_password'];
	} else{
		//m_("write_r : Error, "); exit; 
		echo "<script>alert('mode:$mode - Error'); </script>";  
	}
	//--------- view start -----------------------------------------------------

	$upday  = date("Y-m-d H:i:s",time());

	$create_dbcon		= "./tkher_dbcon.php";

	$fsi			= fopen("$create_dbcon","w+");		// DB Setup용.

	fwrite($fsi,"<?php \r\n"); 
	//fwrite($fsi,"if (!defined('_KAPP_')) exit;     \r\n");
	fwrite($fsi,"define('KAPP_DB_SET_TIME',     '".$upday."');     \r\n");
	fwrite($fsi,"define('KAPP_MYSQL_HOST',     'localhost');     \r\n");
	fwrite($fsi,"define('KAPP_MYSQL_DB',       '".$db_name."');     \r\n");
	fwrite($fsi,"define('KAPP_MYSQL_USER',     '".$db_id."');     \r\n");
	fwrite($fsi,"define('KAPP_MYSQL_PASSWORD', '".$db_password."');     \r\n");
	fwrite($fsi,"define('KAPP_MYSQL_SET_MODE', true);     \r\n");

	fwrite($fsi,"include \"./tkher_pg_lib_common.php\";     \r\n"); // DB setup용. kapplink_index.php에서 사용.
	fwrite($fsi,"?>     \r\n");
	fclose($fsi);
	
	$create_dbcon_Table		= "./tkher_dbcon_Table.php";
	$fst			= fopen("$create_dbcon_Table","w+");		// Table Create 용.

	fwrite($fst,"<?php \r\n");
	//fwrite($fst,"if (!defined('_KAPP_')) exit;     \r\n");
	fwrite($fst,"define('KAPP_DB_SET_TIME',     '".$upday."');     \r\n");
	fwrite($fst,"define('KAPP_MYSQL_HOST',     'localhost');     \r\n");
	fwrite($fst,"define('KAPP_MYSQL_DB',       '".$db_name."');     \r\n");
	fwrite($fst,"define('KAPP_MYSQL_USER',     '".$db_id."');     \r\n");
	fwrite($fst,"define('KAPP_MYSQL_PASSWORD', '".$db_password."');     \r\n");
	fwrite($fst,"define('KAPP_MYSQL_SET_MODE', true);     \r\n");

	//=========== table create ====== $tab_enm + _table_index.php use .
	fwrite($fst,"$"."connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');  \r\n");
    fwrite($fst," if( $"."connect_db=='dberror' ) { $"."connect_dbcheck='dberror'; return; } \r\n"); 
    fwrite($fst,"$"."select_db  = sql_select_db(KAPP_MYSQL_DB, $"."connect_db) or die('MySQL DB Error!!!');  \r\n");
    fwrite($fst,"$"."tkher['connect_db'] = $"."connect_db; \r\n");
    fwrite($fst,"sql_set_charset('utf8', $"."connect_db); \r\n");
	fwrite($fst,"?>     \r\n");
	fclose($fst);

	$rungo = $_REQUEST['table_create_pg'];
	if( isset($rungo) ) {
		// tab_enm + _table_index.php 를 실행했을때 여기를 지나간다.
		echo "<script>alert('tkher_dbcon.php create and tkher_dbcon_Table.php created OK! table_create_pg: '+ ".$rungo."); </script>";  
		echo "<script>window.open('$rungo','_self',''); </script>"; exit;
	}
	$host	= $_SERVER['HTTP_HOST'];
	$up_day = date("Y-m-d H:i:s");
	if( file_exists( $create_dbcon ) ) {  
		include_once( $create_dbcon );
		$_fileLIB = "./tkher_pg_lib_common.php";
		if ( file_exists($_fileLIB) ) {  
			include_once( $_fileLIB ); 
			$connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');       
			$select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');       
			$tkher['connect_db'] = $connect_db;       
			sql_set_charset('utf8', $connect_db);       
			if( defined('KAPP_MYSQL_SET_MODE') && KAPP_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = '' ");       
			//if( defined(KAPP_TIMEZONE)) sql_query(" set time_zone = '".KAPP_TIMEZONE."'");       
			$sql = "SHOW TABLES LIKE 'kapp_urllink_member' ";		
			$ret = sql_query($sql);						        
			$row = sql_fetch_array($ret);		                
			if( $row ) {		
				$sqlB = "select urllink_id from kapp_urllink_member where urllink_id='$db_id' ";		
				$retB = sql_query($sqlB);						        
				$rowB = sql_fetch_array($retB);		                

				if( $rowB ){
					$sqlA   = " 
						UPDATE kapp_urllink_member set 
						urllink_id='$db_id', urllink_email='', urllink_pw='".md5($db_password)."', urllink_point=3000, urllink_level=9, urllink_ip='".$_SERVER['REMOTE_ADDR']."', urllink_memo='$host', upday='$up_day' 
						where urllink_id='$db_id'";

					if( ($result = sql_query( $sqlA ) ) !==false ) {   
						echo "<script>alert('Table kapp_urllink_member Update OK!'); </script>";  
						$rungo = "kapplink_index.php"; // urllink_index.php 2026-01-20
						echo "<script>window.open('$rungo','_self',''); </script>";
						exit;
					}
				} else {//$rowB

					$sqlA = "insert into kapp_urllink_member set 
					urllink_id='$db_id', urllink_email='', urllink_pw='".md5($db_password)."', urllink_point=3000, urllink_level=9, urllink_ip='".$_SERVER['REMOTE_ADDR']."', urllink_memo='$host', upday='$up_day' ";
					if( ($result = sql_query( $sqlA ) ) !==false ) {   
						echo "<script>alert('kapp_urllink_member Insert OK!'); </script>";  
						$rungo = "kapplink_index.php"; // urllink_index.php 2026-01-20
						echo "<script>window.open('$rungo','_self',''); </script>";
					}
				}//$rowB

			} else {//$row

				$SQL = " create table kapp_urllink_member( seqno int auto_increment not null, urllink_id CHAR(15), urllink_email CHAR(30), urllink_ip CHAR(30), urllink_pw CHAR(200), urllink_point INT ,urllink_level INT , upday CHAR(30),urllink_memo text, primary key(seqno) )";  
				
				if( ($result = sql_query( $SQL ) )==false ) {
					printf("kapp_urllink_member Table Create Invalid query: %s", $SQL);   
					exit();   
				} else {   
					$sqlA = "insert into kapp_urllink_member set 
					urllink_id='$db_id', urllink_email='', urllink_pw='".md5($db_password)."', urllink_point=3000, urllink_level=9, urllink_ip='".$_SERVER['REMOTE_ADDR']."', urllink_memo='$host', upday='$up_day' ";
					if( ($result = sql_query( $sqlA ) ) !==false ){
						echo "<script>alert('Table kapp_urllink_member was created and records were registered!'); </script>";  //테이블 kapp_urllink_member의 생성과 레코드 등록을 하였습니다.
						$rungo = "kapplink_index.php"; // urllink_index.php 2026-01-20
						echo "<script>window.open('$rungo','_self',''); </script>";
					}
				}   
			}//$row
		}//$_fileLIB
		else{
			//m_("tkher_pg_lib_common.php : '$_fileLIB' - no found");
			echo "<script>alert('tkher_pg_lib_common.php no found'); </script>";
		}
	}//$create_dbcon

	//echo "<script>alert('tkher_dbcon.php create OK! '); </script>";
	//$rungo = $tab_enm . "_table_index.php";
	//echo "<script>window.open('$rungo','_self',''); </script>";
	else {
		echo "<br>--- tkher_dbcon.php Create Error";
	}
?>
