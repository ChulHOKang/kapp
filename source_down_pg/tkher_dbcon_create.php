<?php
	include "urllink_db_lib.php";  
	/*
        tkher_dbcon_create.php
		call : setup.php에서 call한다. 
		out  : tkher_dbcon.php를 생성한다.
		이것을 고쳐야 될것같다.................................................... 2021-09-28
	*/
	$mode 		= $_POST['mode'];
	$tab_enm	= $_POST['tab_enm'];
	$db_id 			= $_POST['db_id'];
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
	//fwrite($fsi,"if (!defined('_TKHER_')) exit;     \r\n");
	fwrite($fsi,"define('URLLINK_SET_TIME',     '".$upday."');     \r\n");
	fwrite($fsi,"define('TKHER_MYSQL_HOST',     'localhost');     \r\n");
	fwrite($fsi,"define('TKHER_MYSQL_DB',       '".$db_name."');     \r\n");
	fwrite($fsi,"define('TKHER_MYSQL_USER',     '".$db_id."');     \r\n");
	fwrite($fsi,"define('TKHER_MYSQL_PASSWORD', '".$db_password."');     \r\n");
	fwrite($fsi,"define('TKHER_MYSQL_SET_MODE', true);     \r\n");

	fwrite($fsi,"include \"./tkher_pg_lib_common.php\";     \r\n"); // DB setup용. urllink_index.php에서 사용.
	// 위 38 라인을 막고 아래 부분을 풀어서 사용하니 정상작동한다. OK - 2021-09-29 수요일.
	//==================== 이부분을 풀어야 될것같다. 2021-09-28 ==== 왜 막았는지 모르겠다 ================ 
	//fwrite($fsi,"$"."connect_db = sql_connect(TKHER_MYSQL_HOST, TKHER_MYSQL_USER, TKHER_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');  \r\n");
    //fwrite($fsi," if( $"."connect_db=='dberror' ) { $"."connect_dbcheck='dberror'; return; } \r\n"); 
    //fwrite($fsi,"$"."select_db  = sql_select_db(TKHER_MYSQL_DB, $"."connect_db) or die('MySQL DB Error!!!');  \r\n");
    //fwrite($fsi,"$"."tkher['connect_db'] = $"."connect_db; \r\n");
    //fwrite($fsi,"sql_set_charset('utf8', $"."connect_db); \r\n");
	//===============================================================================================end 
	
	fwrite($fsi,"?>     \r\n");
	
	fclose($fsi);


	
	
	$create_dbcon_Table		= "./tkher_dbcon_Table.php";
	
	$fst			= fopen("$create_dbcon_Table","w+");		// Table Create 용.

	fwrite($fst,"<?php \r\n");
	//fwrite($fst,"if (!defined('_TKHER_')) exit;     \r\n");
	fwrite($fst,"define('URLLINK_SET_TIME',     '".$upday."');     \r\n");
	fwrite($fst,"define('TKHER_MYSQL_HOST',     'localhost');     \r\n");
	fwrite($fst,"define('TKHER_MYSQL_DB',       '".$db_name."');     \r\n");
	fwrite($fst,"define('TKHER_MYSQL_USER',     '".$db_id."');     \r\n");
	fwrite($fst,"define('TKHER_MYSQL_PASSWORD', '".$db_password."');     \r\n");
	fwrite($fst,"define('TKHER_MYSQL_SET_MODE', true);     \r\n");

	//fwrite($fst,"include \"./tkher_pg_lib_common.php\";     \r\n"); // DB setup용. urllink_index.php에서 사용.
	//==================== table create 용. ====== $tab_enm + _table_index.php에서 사용 .
	fwrite($fst,"$"."connect_db = sql_connect(TKHER_MYSQL_HOST, TKHER_MYSQL_USER, TKHER_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');  \r\n");
    fwrite($fst," if( $"."connect_db=='dberror' ) { $"."connect_dbcheck='dberror'; return; } \r\n"); 
    fwrite($fst,"$"."select_db  = sql_select_db(TKHER_MYSQL_DB, $"."connect_db) or die('MySQL DB Error!!!');  \r\n");
    fwrite($fst,"$"."tkher['connect_db'] = $"."connect_db; \r\n");
    fwrite($fst,"sql_set_charset('utf8', $"."connect_db); \r\n");
	//===============================================================================================end 
	
	fwrite($fst,"?>     \r\n");
	
	fclose($fst);
	//==================================	
	//---------------------------------------- add -----------------
	$rungo = $_REQUEST['table_create_pg'];
	if( isset($rungo) ) {
		// tab_enm + _table_index.php 를 실행했을때 여기를 지나간다.
		echo "<script>alert('tkher_dbcon.php create and tkher_dbcon_Table.php created OK! table_create_pg: '+ ".$rungo."); </script>";  
		echo "<script>window.open('$rungo','_self',''); </script>"; exit;
	} else {
		// urllink_index.php를 실행 했을때 여기로 지나간다.
		//m_("rungo table_create_pg: " . $rungo);
	}
	//----------------------------------------- end ----------------

    //--------------------- 2021 -03-03 add
	$host	= $_SERVER['HTTP_HOST'];
	$up_day = date("Y-m-d H:i:s");

	if ( file_exists( $create_dbcon ) ) {  

		include_once( $create_dbcon );    // "/data/tkher_dbconfig.php"

		//$_fileLIB = TKHER_LIB_PATH . "/tkher_db_lib_common.php";
		$_fileLIB = "./tkher_pg_lib_common.php";
		if ( file_exists($_fileLIB) ) {  
			include_once( $_fileLIB );    // 공통 라이브러리       
			$connect_db = sql_connect(TKHER_MYSQL_HOST, TKHER_MYSQL_USER, TKHER_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');       
			$select_db  = sql_select_db(TKHER_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');       
			$tkher['connect_db'] = $connect_db;       
			sql_set_charset('utf8', $connect_db);       
			if(defined('TKHER_MYSQL_SET_MODE') && TKHER_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = '' ");       
			if (defined(TKHER_TIMEZONE)) sql_query(" set time_zone = '".TKHER_TIMEZONE."'");       

			//-----------------------------------------
			$sql = "SHOW TABLES LIKE 'urllink_member' ";		
			$ret = sql_query($sql);						        
			$row = sql_fetch_array($ret);		                
			if( $row ) {		
				$sqlB = "select urllink_id from urllink_member where urllink_id='$db_id' ";		
				$retB = sql_query($sqlB);						        
				$rowB = sql_fetch_array($retB);		                

				if( $rowB ){
					$sqlA   = " 
						UPDATE urllink_member set 
						urllink_id='$db_id', urllink_email='', urllink_pw='".md5($db_password)."', urllink_point=3000, urllink_level=9, urllink_ip='".$_SERVER['REMOTE_ADDR']."', urllink_memo='$host', upday='$up_day' 
						where urllink_id='$db_id'";

					if ( ($result = sql_query( $sqlA ) ) !==false )   
					{   
						echo "<script>alert('Table urllink_member Update OK!'); </script>";  
						$rungo = "urllink_index.php";
						echo "<script>window.open('$rungo','_self',''); </script>";
						exit;
					}
				} else {//$rowB

					$sqlA = "insert into urllink_member set 
					urllink_id='$db_id', urllink_email='', urllink_pw='".md5($db_password)."', urllink_point=3000, urllink_level=9, urllink_ip='".$_SERVER['REMOTE_ADDR']."', urllink_memo='$host', upday='$up_day' ";
					if ( ($result = sql_query( $sqlA ) ) !==false )   
					{   
						echo "<script>alert('urllink_member Insert OK!'); </script>";  
						$rungo = "urllink_index.php";
						echo "<script>window.open('$rungo','_self',''); </script>";
					}
				}//$rowB

			} else {//$row

				$SQL = " create table urllink_member( seqno int auto_increment not null, urllink_id CHAR(15), urllink_email CHAR(30), urllink_ip CHAR(30), urllink_pw CHAR(200), urllink_point INT ,urllink_level INT , upday CHAR(30),urllink_memo text, primary key(seqno) )";  
				
				if ( ($result = sql_query( $SQL ) )==false )   
				{   
					printf("urllink_member Table Create Invalid query: %s", $SQL);   
					exit();   
				} else {   
					$sqlA = "insert into urllink_member set 
					urllink_id='$db_id', urllink_email='', urllink_pw='".md5($db_password)."', urllink_point=3000, urllink_level=9, urllink_ip='".$_SERVER['REMOTE_ADDR']."', urllink_memo='$host', upday='$up_day' ";

					if ( ($result = sql_query( $sqlA ) ) !==false )   
					{   
						echo "<script>alert('Table urllink_member was created and records were registered!'); </script>";  //테이블 urllink_member의 생성과 레코드 등록을 하였습니다.
						$rungo = "urllink_index.php";
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
