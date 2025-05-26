<?php
	include "kapp_start.php";
	/*
	   이프로그램을 사용유무 확인 필요 - SQL+Create_jsonA.php를 사용하는것 같다

        kapp_dbcon_create.php : _curl table 생성 부분 추가 - 2025-03-17 컬럼확인 부분 미완성 - 
		                      : create table 'kapp_member' and 'DB의 id, pw record'를 생성한다 중요!

		'tkher_dbconfig.php(/t/data/tkher_dbconfig.php 사용중인 원본 화일이다 중요!)' 을 생성 

		out 1 : 'tkher_dbcon.php'       를 생성한다.
		    2 : 'tkher_dbcon_Table.php' 를 생성한다.
		out 3 : 'kapp_member' Table and 'DB의 id, pw record'를 생성한다 중요!
		call : setup.php에서 call한다. 
		이것을 고쳐야 될것같다.................................................... 2021-09-28 ---------------------
	*/

	$tabData['data'][][] = array();
		$db_host 		= "";
		$db_name 		= "";
		$db_user		= "";
		$db_password 	= "";
		$admin_email 	= "";
		$admin_password = "";

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else  $mode = "";
	$table_prefix = $_POST['table_prefix'];
	$_SESSION['table_prefix'] = $table_prefix;

	//m_("create mode: " . $mode . ", table_prefix: " . $table_prefix); // create mode: Kapp_Setup, table_prefix: kapp_
	if( $mode !== 'Kapp_Setup' and $mode !== 'Kapp_ReSet' ) {
		m_("kapp_dbcon_create : Error - mode: " . $mode);
		echo "<script>window.open( './index.php', '_TOP', ''); </script>";
		exit;
	} else {

		$db_host 		= $_POST['db_host'];
		$db_name 		= $_POST['db_name'];
		$db_user		= $_POST['db_user'];
		$db_password 	= $_POST['db_password'];
		$admin_email 	= $_POST['admin_email'];
		$admin_password = $_POST['admin_password'];
	}
	if( $mode == 'Kapp_Setup' ) {
		// $kapp_dbcon = KAPP_PATH_T_ . "/data/kapp_dbcon.php"; 만 생성 티스트를 한다.
		//m_("set create mode: " . $mode );
		
		create_kapp_dbcon();

		Create_Kapp_Table('Kapp_Setup'); // DB table, DB record=kapp_DB_record_create(), table All

	} else if( $mode == 'Kapp_ReSet' ) {
		//m_("1 reset create mode: " . $mode ); // 1 reset create mode: Kapp_ReSet

		create_kapp_dbcon();
		
		Create_Kapp_Table('Kapp_ReSet');		//m_("Re Set OK===============");

		//echo "<script>window.open('./index.php','_self',''); </script>";

	} else if( $mode == 'db_create' ) {

	} else{
		m_("kapp_dbcon_create : mode Error. mode: " . $mode );
		echo "<script>window.open( './index.php', '_TOP', ''); </script>";
		exit;
	}

	//$upday= date("Y-m-d H:i:s");
	//$memo = $_SERVER['SERVER_NAME']. ", " . $_SERVER['SCRIPT_NAME'];
	//DB_curl_send( $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_HOST'], $upday, $memo );

	//--------------------------------------
	function Create_Kapp_Table( $set_type ){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      
		$upday  = date("Y-m-d H:i:s",time());

		$kapp_dbcon_connect		= KAPP_PATH_T_ . "/data/kapp_dbcon.php";
		if( file_exists( $kapp_dbcon_connect ) ) {  
			include_once( $kapp_dbcon_connect );
		} else {
			m_("No found file: " . $kapp_dbcon_connect); // /data/kapp_dbcon.php
			exit;
		}

		$kapp_dblib_common = KAPP_PATH_T_ . "/setup/kapp_dblib_common.php";
		if( file_exists( $kapp_dblib_common) ) {  
			include_once( $kapp_dblib_common );    // db 라이브러리       
		} else {
			m_( $kapp_dblib_common . " - file no found! Error!"); 
			exit;
		}
		$connect_db = sql_connect( $db_host, $db_user, $db_password, $db_name) or die('MySQL Connect Error!!! Confirm DB password!!!');   
		$select_db  = sql_select_db( $db_name, $connect_db) or die('MySQL DB Error! Confirm DB password!!!');
		$tkher['connect_db'] = $connect_db;       
		sql_set_charset('utf8', $connect_db);       

		Drop_ALL_Table();	// m_("Drop_ALL_Table --- OK");

		$chk = kapp_DB_table_check( $table_prefix . "DB" );
		if( !$chk ) { // no found
			$ret = kapp_DB_table_create();
			if( $ret ) kapp_DB_record_create();

			if( !kapp_DB_table_check( $table_prefix . "member" ) ) {
				$member_chk = Kapp_Member_Table_Create( $table_prefix . "member" ); //kapp_member 없으면 생성.
				if($member_chk) kapp_member_record_create();
				else exit;
			} else { //m_(" 1 Create_ALL_Table Member_Record Update ------- "); // 
				//Kapp_Member_Record_Update(); // m_(" 2 Create_ALL_Table Member_Record Update ------- "); // 
				drop_kapp_( $table_prefix . "member" );
				$member_chk = Kapp_Member_Table_Create( $table_prefix . "member" ); //kapp_member 무조건 새로 생성.
				if($member_chk) kapp_member_record_create();
				else exit;
			}
			$_SESSION['mb_level'] = 8;
			$_SESSION['admin'] = 'modumoa';
			Create_ALL_Table();	// m_("Create_ALL_Table --- OK");
		} else { // m_( $table_prefix ."DB Table 존재 합니다.");
			drop_kapp_( $table_prefix ."DB" ); // kapp_DB
			$ret = kapp_DB_table_create();
			if( $ret ) kapp_DB_record_create();

			if( !kapp_DB_table_check( $table_prefix . "member" ) ) { //kapp_member 없으면 생성.
				$member_chk = Kapp_Member_Table_Create( $table_prefix . "member" ); 
				if($member_chk) kapp_member_record_create();
				else exit;
			} else { //m_(" 1 Create_ALL_Table Member_Record Update ------- "); // kapp_member 무조건 새로 생성.
				//Kapp_Member_Record_Update(); // m_(" 2 Create_ALL_Table Member_Record Update ------- "); // 
				drop_kapp_( $table_prefix . "member" );
				$member_chk = Kapp_Member_Table_Create( $table_prefix . "member" ); //kapp_member 없으면 생성.
				if($member_chk) kapp_member_record_create();
				else exit;
			}
			$_SESSION['mb_level'] = 8;
			$_SESSION['admin'] = 'modumoa';
			Create_ALL_Table();	// m_("Create_ALL_Table --- OK");
		} //m_("kapp_DB Table ---------- OK");
	}
	//---------------------------
	function Drop_ALL_Table(){
		global $table_prefix;	//m_("Drop_ALL_Table ------- "); //

		echo "<br><br><b>--- Reset table list :  ---</b><br>";

		//drop_kapp_( $table_prefix ."menuskin" );
		if( kapp_DB_table_check( $table_prefix . "config" ) )			drop_kapp_( $table_prefix . "config" ); 
		if( kapp_DB_table_check( $table_prefix . "tkher_main_img" ) )	drop_kapp_( $table_prefix . "tkher_main_img" ); 
		if( kapp_DB_table_check( $table_prefix . "tkher_my_control" ))	drop_kapp_( $table_prefix . "tkher_my_control" ); 
		if( kapp_DB_table_check( $table_prefix . "sajin_group" ) )		drop_kapp_( $table_prefix . "sajin_group" ); 
		if( kapp_DB_table_check( $table_prefix . "sajin_jpg" ) )		drop_kapp_( $table_prefix . "sajin_jpg" ); 
		if( kapp_DB_table_check( $table_prefix . "log_info" ) )		drop_kapp_( $table_prefix . "log_info" ); 
		if( kapp_DB_table_check( $table_prefix . "visit" ) )			drop_kapp_( $table_prefix . "visit" ); 
		if( kapp_DB_table_check( $table_prefix . "visit_sum" ) )		drop_kapp_( $table_prefix . "visit_sum" ); 
		if( kapp_DB_table_check( $table_prefix . "point" ) )			drop_kapp_( $table_prefix . "point" ); 
		if( kapp_DB_table_check( $table_prefix . "aboard_admin" ) )	drop_kapp_( $table_prefix . "aboard_admin" ); 
		if( kapp_DB_table_check( $table_prefix . "aboard_infor" ) )	drop_kapp_( $table_prefix . "aboard_infor" ); 
		if( kapp_DB_table_check( $table_prefix . "aboard_memo" ) )		drop_kapp_( $table_prefix . "aboard_memo" ); 
		if( kapp_DB_table_check( $table_prefix . "admin_bbs" ) )		drop_kapp_( $table_prefix . "admin_bbs" ); 
		if( kapp_DB_table_check( $table_prefix . "ap_bbs" ) )			drop_kapp_( $table_prefix . "ap_bbs" ); 
		if( kapp_DB_table_check( $table_prefix . "menuskin" ) )		drop_kapp_( $table_prefix . "menuskin" ); 
		if( kapp_DB_table_check( $table_prefix . "webeditor" ) )		drop_kapp_( $table_prefix . "webeditor" ); 
		if( kapp_DB_table_check( $table_prefix . "webeditor_comment"))	drop_kapp_( $table_prefix . "webeditor_comment" ); 
		
		if( kapp_DB_table_check( $table_prefix . "table10" ) )			drop_kapp_( $table_prefix . "table10" ); 
		if( kapp_DB_table_check( $table_prefix . "table10_pg" ) )		drop_kapp_( $table_prefix . "table10_pg" ); 
		if( kapp_DB_table_check( $table_prefix . "job_link_table" ) )	drop_kapp_( $table_prefix . "job_link_table" ); 
		if( kapp_DB_table_check( $table_prefix . "sys_menu_bom" ) )	drop_kapp_( $table_prefix . "sys_menu_bom" ); 
		//-------------- add - 2025-03-17 
		if( kapp_DB_table_check( $table_prefix . "table10_curl" ) )			drop_kapp_( $table_prefix . "table10_curl" ); 
		if( kapp_DB_table_check( $table_prefix . "table10_pg_curl" ) )		drop_kapp_( $table_prefix . "table10_pg_curl" ); 
		if( kapp_DB_table_check( $table_prefix . "job_link_table_curl" ) )	drop_kapp_( $table_prefix . "job_link_table_curl" ); 
		if( kapp_DB_table_check( $table_prefix . "sys_menu_bom_curl" ) )	drop_kapp_( $table_prefix . "sys_menu_bom_curl" ); 
		//-------------- add - 2025-03-17 end
		
		if( kapp_DB_table_check( $table_prefix . "table10_group" ) )	drop_kapp_( $table_prefix . "table10_group" ); 
		if( kapp_DB_table_check( $table_prefix . "coin_view" ) )		drop_kapp_( $table_prefix . "coin_view" ); 
		if( kapp_DB_table_check( $table_prefix . "url_group" ) )		drop_kapp_( $table_prefix . "url_group" ); 
		if( kapp_DB_table_check( $table_prefix . "bbs_history" ) )		drop_kapp_( $table_prefix . "bbs_history" ); 
		if( kapp_DB_table_check( $table_prefix . "e_list" ) )			drop_kapp_( $table_prefix . "e_list" ); 
		if( kapp_DB_table_check( $table_prefix . "pri_contect" ) )		drop_kapp_( $table_prefix . "pri_contect" ); 
		if( kapp_DB_table_check( $table_prefix . "project" ) )			drop_kapp_( $table_prefix . "project" ); 
		if( kapp_DB_table_check( $table_prefix . "pri_maintenance" ) )	drop_kapp_( $table_prefix . "pri_maintenance" ); 
		if( kapp_DB_table_check( $table_prefix . "tkher_content" ) )	drop_kapp_( $table_prefix . "tkher_content" ); 
		if( kapp_DB_table_check( $table_prefix . "ip_info" ) )			drop_kapp_( $table_prefix . "ip_info" ); 
		if( kapp_DB_table_check( $table_prefix . "login" ) )			drop_kapp_( $table_prefix . "login" ); 

		echo "<br><br><b>--- Table : End ---</b><br>";
		//echo "Click Here <a href='./DB_Table_CreateA.php?admin=modumoa' target='_blank'> Table List </a>";
	}
	//--------------------------------------
	function drop_kapp_( $tab_){
		global $table_prefix;
		$query	="drop table " . $tab_;
		$mq2	=sql_query($query);
		if( $mq2 ) echo ", --- delete success : " . $tab_;
		else echo "<br> delete fail : " . $tab_;
	}
	//---------------------------
	function Create_ALL_Table(){
		global $table_prefix;	//m_("Create_ALL_Table ------- "); //

		echo "<br><br><b>--- Setup Create table list :  ---</b><br>";

		if( !kapp_DB_table_check( $table_prefix . "config" ) )			Config( $table_prefix , "config" ); 
		if( !kapp_DB_table_check( $table_prefix . "tkher_main_img" ) )	Tkher_main_img( $table_prefix , "tkher_main_img" ); 
		if( !kapp_DB_table_check( $table_prefix . "tkher_my_control" ))	Tkher_my_control( $table_prefix , "tkher_my_control" ); 
		if( !kapp_DB_table_check( $table_prefix . "sajin_group" ) )		Sajin_group( $table_prefix , "sajin_group" ); 
		if( !kapp_DB_table_check( $table_prefix . "sajin_jpg" ) )		Sajin_jpg( $table_prefix , "sajin_jpg" ); 
		if( !kapp_DB_table_check( $table_prefix . "log_info" ) )		Log_info( $table_prefix , "log_info" ); 
		if( !kapp_DB_table_check( $table_prefix . "visit" ) )			Visit( $table_prefix , "visit" ); 
		if( !kapp_DB_table_check( $table_prefix . "visit_sum" ) )		Visit_sum( $table_prefix , "visit_sum" ); 
		if( !kapp_DB_table_check( $table_prefix . "point" ) )			Point( $table_prefix , "point" ); 
		if( !kapp_DB_table_check( $table_prefix . "aboard_admin" ) )	Aboard_admin( $table_prefix , "aboard_admin" ); 
		if( !kapp_DB_table_check( $table_prefix . "aboard_infor" ) )	Aboard_infor( $table_prefix , "aboard_infor" ); 
		if( !kapp_DB_table_check( $table_prefix . "aboard_memo" ) )		Aboard_memo( $table_prefix , "aboard_memo" ); 
		if( !kapp_DB_table_check( $table_prefix . "admin_bbs" ) )		Admin_bbs( $table_prefix , "admin_bbs" ); 
		if( !kapp_DB_table_check( $table_prefix . "ap_bbs" ) )			Ap_bbs( $table_prefix , "ap_bbs" ); 
		if( !kapp_DB_table_check( $table_prefix . "menuskin" ) )		Menuskin( $table_prefix , "menuskin" ); 
		if( !kapp_DB_table_check( $table_prefix . "webeditor" ) )		Webeditor( $table_prefix , "webeditor" ); 
		if( !kapp_DB_table_check( $table_prefix . "webeditor_comment"))	Webeditor_comment( $table_prefix , "webeditor_comment" ); 

		if( !kapp_DB_table_check( $table_prefix . "table10" ) )			Table10( $table_prefix , "table10" ); 
		if( !kapp_DB_table_check( $table_prefix . "table10_pg" ) )		Table10_pg( $table_prefix , "table10_pg" ); 
		if( !kapp_DB_table_check( $table_prefix . "job_link_table" ) )	Job_link_table( $table_prefix , "job_link_table" ); 
		if( !kapp_DB_table_check( $table_prefix . "sys_menu_bom" ) )	Sys_menu_bom( $table_prefix , "sys_menu_bom" ); 
		//-------------- add - 2025-03-17 
		if( !kapp_DB_table_check( $table_prefix . "table10_curl" ) )		         Table10_curl( $table_prefix , "table10_curl" ); 
		if( !kapp_DB_table_check( $table_prefix . "table10_pg_curl" ) )		 Table10_pg_curl( $table_prefix , "table10_pg_curl" ); 
		if( !kapp_DB_table_check( $table_prefix . "job_link_table_curl" ) )	 Job_link_table_curl( $table_prefix , "job_link_table_curl" ); 
		if( !kapp_DB_table_check( $table_prefix . "sys_menu_bom_curl" ) ) Sys_menu_bom_curl( $table_prefix , "sys_menu_bom_curl" ); 
		//-------------- add - 2025-03-17 - end
		
		if( !kapp_DB_table_check( $table_prefix . "table10_group" ) )	table10_group( $table_prefix , "table10_group" ); 
		if( !kapp_DB_table_check( $table_prefix . "coin_view" ) )		Coin_view( $table_prefix , "coin_view" ); 
		if( !kapp_DB_table_check( $table_prefix . "url_group" ) )		Url_group( $table_prefix , "url_group" ); 
		if( !kapp_DB_table_check( $table_prefix . "bbs_history" ) )		Bbs_history( $table_prefix , "bbs_history" ); 
		if( !kapp_DB_table_check( $table_prefix . "e_list" ) )			E_list( $table_prefix , "e_list" ); 
		if( !kapp_DB_table_check( $table_prefix . "pri_contect" ) )		Pri_contect( $table_prefix , "pri_contect" ); 
		if( !kapp_DB_table_check( $table_prefix . "project" ) )			Project( $table_prefix , "project" ); 
		if( !kapp_DB_table_check( $table_prefix . "pri_maintenance" ) )	Pri_maintenance( $table_prefix , "pri_maintenance" ); 
		if( !kapp_DB_table_check( $table_prefix . "tkher_content" ) )	Tkher_content( $table_prefix , "tkher_content" ); 
		if( !kapp_DB_table_check( $table_prefix . "ip_info" ) )			Ip_info( $table_prefix , "ip_info" ); 
		if( !kapp_DB_table_check( $table_prefix . "login" ) )			Login( $table_prefix , "login" ); 

		echo "<br><br><b>--- Table Create : End ---</b><br>";
		echo "Click Here <a href='./DB_Table_CreateA.php?admin=modumoa' target='_blank'> Table List </a>";
	}
	//----------------------------------
	function kapp_DB_table_check( $tab ){
		global $table_prefix;
		$sql = "SELECT COUNT(*) as cnt FROM Information_schema.tables
		WHERE table_schema = '".KAPP_MYSQL_DB."'
		AND table_name = '".$tab."' ";

		$ret = sql_fetch($sql);	//m_( "cnt: " . $ret['cnt']);
		if( $ret['cnt'] > 0 ) {  //m_( $tab . ", 존재합니다."); // , 존재합니다.
			echo "<br>" . $tab . ", already exists. "; // 이미 존재합니다
			return true;
		} else {  //m_( $tab . ", 존재하지 않습니다.");
			echo "<br>" . $tab . ", --- ";
			return false;
		}
	}
	// ----- kapp_member insert ----------
	function Kapp_Member_Table_Create( $tab ){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      
		$SQL = " 
			CREATE TABLE ".$table_prefix."member (
			  mb_no int(11) auto_increment NOT NULL,
			  mb_id varchar(50) NOT NULL,
			  mb_sn varchar(255) ,
			  mb_password varchar(255) NOT NULL,
			  mb_name varchar(255) NOT NULL,
			  mb_nick varchar(255) ,
			  mb_nick_date date,
			  mb_email varchar(255) NOT NULL,
			  mb_photo varchar(255) ,
			  mb_homepage varchar(255) ,
			  mb_level tinyint(4),
			  mb_sex char(1) ,
			  mb_birth varchar(255) ,
			  mb_tel varchar(255) ,
			  mb_hp varchar(255) ,
			  mb_certify varchar(20) ,
			  mb_adult tinyint(4) ,
			  mb_dupinfo varchar(255) ,
			  mb_zip1 char(4) ,
			  mb_zip2 char(4) ,
			  mb_addr1 varchar(255) ,
			  mb_addr2 varchar(255) ,
			  mb_addr3 varchar(255) ,
			  mb_addr_jibeon varchar(255) ,
			  mb_signature text,
			  mb_recommend varchar(255) ,
			  mb_point int(11) DEFAULT 0,
			  mb_today_login datetime,
			  mb_login_ip varchar(255) ,
			  mb_datetime datetime ,
			  mb_ip varchar(255) ,
			  mb_leave_date varchar(8) ,
			  mb_intercept_date varchar(8) ,
			  mb_email_certify datetime,
			  mb_email_certify2 varchar(255) ,
			  mb_memo text NOT NULL,
			  mb_lost_certify varchar(255),
			  mb_mailling tinyint(4),
			  mb_sms tinyint(4),
			  mb_open tinyint(4),
			  mb_open_date date,
			  mb_profile text,
			  mb_memo_call varchar(255),
			  mb_penalty int(11) DEFAULT 0,
			  mb_gpt_key varchar(255),
			  mb_gpt_model varchar(255)
			  , PRIMARY KEY (mb_no)
			  , UNIQUE KEY mb_id (mb_id)
			  , KEY mb_today_login (mb_today_login)
			  , KEY mb_datetime (mb_datetime)
			  , KEY mb_email (mb_email)
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$result = sql_query( $SQL );
		if( !$result ){   
			echo "$tab Table Create Invalid query: " . $SQL;
			echo "<br>Please check if the $tab table already exists.";//table이 이미 존재하는지 확인 바랍니다
			return false;
		} else { 
			echo "<br>Create Success : $tab <br>";
			return true;
		}
	}
	function kapp_member_record_create(){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      
		$upday  = date("Y-m-d H:i:s",time());
		$nickday  = date("Y-m-d",time());
		$row = sql_fetch(" select password('$admin_password') as pass ");
		$pw = $row['pass'];

		//$str = str_replace("Hello", "Goodbye", $str);
		$emailA = explode(".", $admin_email);
		$email0 = $emailA[0];
		$admin_id = str_replace( "@", "_", $email0); // 2025-05-18 add

		$sqlA = "insert into " . $table_prefix. "member set 
		mb_id='".$admin_id."', mb_email='".$admin_email."', mb_certify='".$upday."', mb_email_certify='".$upday."', mb_email_certify2='DB Setup', mb_nick_date='".$nickday."', mb_name='DBadmin', mb_nick='DBadmin', mb_level=9, mb_sn='db', mb_password='".$pw."', mb_point=100000, mb_ip='".$_SERVER['REMOTE_ADDR']."', mb_memo='".$_SERVER['SERVER_NAME'].":".$_SERVER['HTTP_HOST']. ":" . $_SERVER['SCRIPT_NAME']."' ";
		$result = sql_query( $sqlA );
		if( $result !== false ){   
			echo "<script>alert('". $table_prefix."member Insert Success'); </script>";  
			//echo "<script>window.open('./index.php','_self',''); </script>";
		} else {
			m_("member insert error! ");	echo "sql:" . $sqlA; exit;
			//#1364 - Field 'mb_signature' doesn't have a default value
		}
	}
	function Kapp_Member_Record_Update(){ // 
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      
		$upday  = date("Y-m-d H:i:s",time());
		$nickday  = date("Y-m-d",time());
		$admin_id = str_replace( "@", "_", $admin_email); // 2025-05-18 add
		$row = sql_fetch(" select password('$admin_password') as pass ");
		$pw = $row['pass']; //m_(" pw: " . $pw); // pw: *2FAA1FB2012C385C7CFE7FE38E4F4FC018237420
		$sqlA = "update " . $table_prefix. "member set 
		mb_id='".$admin_id."', mb_email='".$admin_email."', mb_email_certify='".$upday."', mb_email_certify2='DB Setup', mb_nick_date='".$nickday."', mb_name='DBadmin', mb_nick='DBadmin', mb_level=9, mb_sn='db', mb_password='".$pw."', mb_point=100000, mb_ip='".$_SERVER['REMOTE_ADDR']."', mb_memo='".$_SERVER['SERVER_NAME'].":".$_SERVER['HTTP_HOST']. ":" . $_SERVER['SCRIPT_NAME']."' where mb_id='".$admin_id."' ";
		
		if( ( $result = sql_query( $sqlA ) ) !==false ){   
			echo "<script>alert('". $table_prefix."member Update Success'); </script>";  //echo "<script>window.open('./index.php','_self',''); </script>";
		} else {
			m_("member update error! "); echo "sql:" . $sqlA; exit;
		}
	}
	//--------------------------------------
	function drop_DB_table( $DB_Table ){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      
		$kapp_dbcon_connect		= KAPP_PATH_T_ . "/data/kapp_dbcon.php";
		if( file_exists( $kapp_dbcon_connect ) ) {  
			include_once( $kapp_dbcon_connect );
		} else {
			m_("No found file: " . $kapp_dbcon_connect); // /var/www/html/t/data/kapp_dbcon.php
			exit;
		}
		$kapp_dblib_common = KAPP_PATH_T_ . "/setup/kapp_dblib_common.php";
		if( file_exists($kapp_dblib_common) ) {  
			include_once( $kapp_dblib_common );    // db 라이브러리       
		} else {
			m_( $kapp_dblib_common . " - file no found! Error!"); 
			//echo "<script>window.open( './index.php', '_TOP', ''); </script>";
			exit;
		}
		$connect_db = sql_connect( KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD, KAPP_MYSQL_DB) or die('MySQL Connect Error!!! <br>- Confirm DB password! and DB-NAME , pw:' . KAPP_MYSQL_PASSWORD . ', db:' . KAPP_MYSQL_DB . ', user:' . KAPP_MYSQL_USER);   
		$select_db  = sql_select_db( KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error! <br>- Confirm DB password! and DB-NAME, pw:' . KAPP_MYSQL_PASSWORD . ', db:' . KAPP_MYSQL_DB . ', user:' . KAPP_MYSQL_USER);

		$tkher['connect_db'] = $connect_db;       
		sql_set_charset('utf8', $connect_db);       

		$query	="drop table $DB_Table";
		$mq2	=sql_query($query);
		if( $mq2 ) m_(" delete success kapp DB table: " . $DB_Table);
	}
	//--------------------------------------
	function create_DB_table( $set_type ){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      
		$upday  = date("Y-m-d H:i:s",time());

		$kapp_dbcon_connect		= KAPP_PATH_T_ . "/data/kapp_dbcon.php";
		if( file_exists( $kapp_dbcon_connect ) ) {  
			include_once( $kapp_dbcon_connect );
		} else {
			m_("No found file: " . $kapp_dbcon_connect); // /data/kapp_dbcon.php
			exit;
		}

		$kapp_dblib_common = KAPP_PATH_T_ . "/setup/kapp_dblib_common.php";
		if ( file_exists($kapp_dblib_common) ) {  
			include_once( $kapp_dblib_common );    // db 라이브러리       
		} else {
			m_( $kapp_dblib_common . " - file no found! Error!");  
			//echo "<script>window.open( './index.php', '_TOP', ''); </script>";
			exit;
		}
		$connect_db = sql_connect( $db_host, $db_user, $db_password, $db_name) or die('MySQL Connect Error!!! Confirm DB password!!!');   
		$select_db  = sql_select_db( $db_name, $connect_db) or die('MySQL DB Error! Confirm DB password!!!');
		$tkher['connect_db'] = $connect_db;       
		sql_set_charset('utf8', $connect_db);       

		$SQL = " create table " . $table_prefix. "DB( seqno int auto_increment not null, kapp_dbhost CHAR(15), kapp_dbname CHAR(15), kapp_dbuser CHAR(50), kapp_dbpw CHAR(255), admin_email CHAR(100), admin_pw CHAR(255), kapp_ip CHAR(30), kapp_point INT ,kapp_level INT , upday CHAR(30), server_name CHAR(50), kapp_memo text, primary key(seqno) )";  
		
		$result = sql_query( $SQL );
		if( !$result ){   
			echo $table_prefix. "DB Table Create Invalid query: " . $SQL;
			echo "<br>Please check if the " . $table_prefix. "DB table already exists.";//table이 이미 존재하는지 확인 바랍니다
			return false; //exit;   
		} else return true;
	}
	//---------------------------
	function create_kapp_DB(){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      

		$upday = date("Y-m-d H:i:s");
		$host = $_SERVER['HTTP_HOST']; // $_SERVER['SERVER_NAME']
		$ip   = $_SERVER['REMOTE_ADDR'];

		$kapp_dbcon_connect		= KAPP_PATH_T_ . "/data/kapp_dbcon.php";
		if( file_exists( $kapp_dbcon_connect ) ) {  
			include_once( $kapp_dbcon_connect );
		} else { // if ( file_exists( $kapp_dbcon_connect ) ) : $kapp_dbcon_connect = KAPP_PATH_T_ . "./data/kapp_dbcon.php";
				m_( $kapp_dbcon_connect . " - file no found! Create Error!"); // kapp_dbcon.php
				echo "<script>window.open( './index.php', '_TOP', ''); </script>";
				exit;
		}
			
		$_fileLIB = KAPP_PATH_T_ . "/setup/kapp_dblib_common.php";
		if( file_exists($_fileLIB) ) {  
			include_once( $_fileLIB );    // db 라이브러리       
		} else {
			m_( $_fileLIB . " - file no found! Error!"); 
			//echo "<script>window.open( './index.php', '_TOP', ''); </script>";
			exit;
		}
		$connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD, KAPP_MYSQL_DB) or die('MySQL Connect Error!!!');   
		$select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!');
		$tkher['connect_db'] = $connect_db;       
		sql_set_charset('utf8', $connect_db);       

		//-----------------------------------------
		$sql = "SHOW TABLES LIKE 'kapp_DB' ";		// table_prefix
		$ret = sql_query($sql);						        
		if( $ret ){ // kapp_DB 있다.
			$row = sql_fetch_array($ret);		                
			if( $row ) {		
				$sqlB = "select server_name from kapp_DB where server_name='".$_SERVER['HTTP_HOST']."' ";		
				//$retB = sql_query($sqlB);						        
				$rowB = sql_fetch( $retB );		                
				if( $rowB ){ // record data 가 존재하면 변경하여 저장한다.
					$sqlA   = " 
						UPDATE " . $table_prefix. "DB set 
						kapp_dbhost='$db_host', kapp_dbname='$db_name', kapp_dbuser='$db_user', kapp_dbpw='".md5($db_password)."', admin_pw='".md5($admin_password)."', admin_email='$admin_email', kapp_point=10000, kapp_level=9, kapp_ip='".$ip."', kapp_memo='".$_SERVER['SERVER_NAME']."', upday='$upday', server_name='".$_SERVER['HTTP_HOST']."' 
						where server_name='".$_SERVER['HTTP_HOST']."'
					";
					if( ($result = sql_query( $sqlA ) ) !==false ){   
						//m_("Table " . $table_prefix. "DB record Update Success");
						//$memo = "update, " . $_SERVER['SERVER_NAME']. ", " . $_SERVER['SCRIPT_NAME'];
						$memo = $upday ." update - " . $_SERVER['SERVER_SOFTWARE']. ", " . $_SERVER['SERVER_NAME']. ", " . $_SERVER['SCRIPT_NAME'];
						DB_curl_send( $ip, KAPP_URL_T_, $upday, $memo, md5($db_password) );
						//exit;
					}
				} else { // $rowB - kapp_member table이 존재하고 record가 없으면 record만 생성한다.
					kapp_DB_record_create();
				}//$rowB
			} else {// $row
				kapp_DB_record_create();
			} //$row

		} else{ // kapp_DB table이 없으면 table을 생성하고 record를 생성한다 - ret=sql_query - $sql = "SHOW TABLES LIKE 'kapp_DB' ";

			kapp_DB_table_create(); 
			m_( $_fileLIB . " - file no found! Error!"); 
			//echo "<script>window.open( './index.php', '_TOP', ''); </script>";
			exit;
		}
		
	}
	//----------------------------------
	function kapp_DB_table_create(){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      

			$SQL = " create table kapp_DB( seqno int auto_increment not null, kapp_dbhost CHAR(15), kapp_dbname CHAR(15), kapp_dbuser CHAR(50), kapp_dbpw CHAR(255), admin_email CHAR(100), admin_pw CHAR(255), kapp_ip CHAR(30), kapp_point INT ,kapp_level INT , upday CHAR(30), server_name CHAR(50), kapp_memo text, primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";  
			
			if( ( $result = sql_query( $SQL ) )==false ) {   
				echo $table_prefix . " Table Create Invalid query: " . $SQL;
				return false; //exit;   
			} else {   
				echo ", --- ".$table_prefix. "DB table create <br>" ;
				return true;
			}
	}
	// ----- kapp_DB insert ----------
	function kapp_DB_record_create(){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tkher;      
		$upday = date("Y-m-d H:i:s");

		$memo = $upday ." setup - " . $_SERVER['SERVER_SOFTWARE']. ", " . $_SERVER['SERVER_NAME']. ", " . $_SERVER['SCRIPT_NAME']. ", " . $_SERVER['HTTP_USER_AGENT'];
		$sqlA = "insert into kapp_DB set 
		kapp_dbhost='".$db_host."', kapp_dbname='$db_name', kapp_dbuser='$db_user', kapp_dbpw='".md5($db_password)."', admin_email='".$admin_email."', admin_pw='".md5($admin_password)."', kapp_point=10000, kapp_level=9, kapp_ip='".$_SERVER['REMOTE_ADDR']."', server_name='".$_SERVER['HTTP_HOST']."', upday='$upday', kapp_memo='".$memo."' ";
		if( ($result = sql_query( $sqlA ) ) !== false ) {   
			DB_curl_send( $_SERVER['REMOTE_ADDR'], KAPP_URL_T_, $upday, $memo, md5($admin_password) );
			echo " - Create Success and Record Create  Success : kapp_DB <br>";
		} else {
			echo "ERROR - insert kapp_DB";// "sql:" . $sqlA;
		}
	}

	function DB_curl_send( $ip, $server_name_set, $upday, $memo, $pw_md5 ){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password, $table_prefix;
		global $tabData;
		$cnt = 0;
		
		m_("DB_curl_send - db_host : " . $db_host);

		$tabData['data'][$cnt]['kapp_dbhost']  = $db_host;
		$tabData['data'][$cnt]['kapp_dbname']  = $db_name;
		$tabData['data'][$cnt]['kapp_dbuser']  = $db_user;
		$tabData['data'][$cnt]['admin_email']  = $admin_email;
		$tabData['data'][$cnt]['kapp_ip']      = $ip;   //$remote_addr;
		$tabData['data'][$cnt]['server_name']  = $server_name_set;
		$tabData['data'][$cnt]['upday']        = $upday;
		$tabData['data'][$cnt]['memo']         = $memo;
		$tabData['data'][$cnt]['pw_md5']       = $pw_md5;

		$key = 'appgenerator';
		$iv = "~`!@#$%^&*()-_=+";

		$sendData = encryptA( $tabData , $key, $iv);

		//$url_ = 'https://ailinkapp.com/onlyshop/coupon/pg_curl_get_ailinkapp.php';
		$url_ = 'https://www.fation.net/kapp/_Curl/DB_curl_get_ailinkapp.php'; //$url_ = 'https://ailinkapp.com/kapp/DB_curl_get_ailinkapp.php';
		//$url_ =  KAPP_URL_T_ . "/_Curl/DB_curl_get_ailinkapp.php" //$url_ = 'https://ailinkapp.com/kapp/DB_curl_get_ailinkapp.php';
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);

		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);

		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		
		//echo curl_error($curl);

		echo "curl --- response: " . $response . "<br>";

		if( $response == false) {
			$_ms = "new kapp_DB curl Fail : " . curl_error($curl);
			echo $_ms . ", response: " . $response . "<br>"; // 'curl 전송 실패 : ' . curl_error($curl);
			//m_(" ------------ : " . $_ms);
		} else {
			$_ms = 'new kapp_DB curl OK : ' . $response;
			echo 'curl OK : ' . $response . "<br>";
			//m_(" ============ :" . $_ms);
		}
		curl_close($curl);
	}
	//--------- kapp_dbcon----------------------------- Table DEFINE 추가 필요함 ==========================================
	function create_kapp_dbcon(){
		global $db_host, $db_name, $db_user, $db_password, $admin_email, $admin_password;
		global $tkher, $table_prefix;      

		$upday  = date("Y-m-d H:i:s",time());
		$kapp_dbcon		= KAPP_PATH_T_ . "/data/kapp_dbcon.php";

		//m_(" create_kapp_dbcon - kapp_dbcon: " . $kapp_dbcon); // /data/kapp_dbcon.php
		//create_kapp_dbcon - kapp_dbcon: /var/www/html/kapp/data/kapp_dbcon.php

		$fsi = fopen("$kapp_dbcon","w");

		fwrite($fsi,"<?php                                              \r\n");
		fwrite($fsi,"if (!defined('_KAPP_')) exit;                      \r\n");
		fwrite($fsi,"define('KAPP_SET_TIME',       '".$upday."');       \r\n");
		fwrite($fsi,"define('KAPP_MYSQL_HOST',     '".$db_host."');     \r\n"); // localhost
		fwrite($fsi,"define('KAPP_MYSQL_DB',       '".$db_name."');     \r\n");
		fwrite($fsi,"define('KAPP_MYSQL_USER',     '".$db_user."');     \r\n");
		fwrite($fsi,"define('KAPP_MYSQL_PASSWORD', '".$db_password."'); \r\n");
		fwrite($fsi,"define('KAPP_MYSQL_SET_MODE', true);               \r\n");


		//define('URLLINK_TABLE_PREFIX', 'urllink_'); // urllinkcoin.com add-2021-04-04
		//$tkher['urllink_member_table']	= URLLINK_TABLE_PREFIX.'member'; // add 2021-04-04 회원 테이블
		
		//fwrite($fsi," $" . "prefix = '". $table_prefix ."';                   \r\n");
		fwrite($fsi," define('KAPP_TABLE_PREFIX', '" . $table_prefix . "' );                // table prefix   \r\n\r\n");

		fwrite($fsi," $" . "tkher['config_table']		= KAPP_TABLE_PREFIX.'config';       // 기본환경 설정 테이블   \r\n");
		fwrite($fsi," $" . "tkher['login_table']		= KAPP_TABLE_PREFIX.'login';        // 로그인 테이블 (접속자수)   \r\n");
		fwrite($fsi," $" . "tkher['point_table']		= KAPP_TABLE_PREFIX.'point';        // 포인트 테이블   \r\n");
		fwrite($fsi," $" . "tkher['visit_table']		= KAPP_TABLE_PREFIX.'visit';        // 방문자 테이블   \r\n");
		fwrite($fsi," $" . "tkher['visit_sum_table']	= KAPP_TABLE_PREFIX.'visit_sum';    // 방문자 합계 테이블   \r\n");
		fwrite($fsi," $" . "tkher['tkher_member_table']	= KAPP_TABLE_PREFIX.'member';       // 회원 테이블   \r\n");
		fwrite($fsi," $" . "tkher['pri_contect_table']		= KAPP_TABLE_PREFIX.'pri_contect';       // 회사 테이블   \r\n");
		fwrite($fsi," $" . "tkher['tkher_content_table']		= KAPP_TABLE_PREFIX.'tkher_content';       // 약관, 개인정보 처리방안 테이블   \r\n");

		fwrite($fsi," $" . "tkher['group_table']		= KAPP_TABLE_PREFIX.'coin_group';   // 게시판 그룹 테이블   \r\n");
		fwrite($fsi," $" . "tkher['group_member_table']	= KAPP_TABLE_PREFIX.'group_member'; // 게시판 그룹+회원 테이블   \r\n");
		fwrite($fsi," $" . "tkher['board_table']		= KAPP_TABLE_PREFIX.'board';        // 게시판 설정 테이블   \r\n");
		fwrite($fsi," $" . "tkher['board_file_table']	= KAPP_TABLE_PREFIX.'board_file';   // 게시판 첨부파일 테이블   \r\n");
		fwrite($fsi," $" . "tkher['board_good_table']	= KAPP_TABLE_PREFIX.'board_good';   // 게시물 추천,비추천 테이블   \r\n");
		fwrite($fsi," $" . "tkher['board_new_table']	= KAPP_TABLE_PREFIX.'board_new';    // 게시판 새글 테이블   \r\n");

		//fwrite($fsi," $" . "tkher['memo_table']			= KAPP_TABLE_PREFIX.'memo';         // 메모 테이블   \r\n");
/*
		fwrite($fsi," $" . "tkher['auth_table']			= KAPP_TABLE_PREFIX.'auth';         // 관리권한 설정 테이블   \r\n");
		fwrite($fsi," $" . "tkher['uniqid_table']		= KAPP_TABLE_PREFIX.'uniqid';       // 유니크한 값을 만드는 테이블   \r\n");
		fwrite($fsi," $" . "tkher['autosave_table']		= KAPP_TABLE_PREFIX.'autosave';     // 게시글 작성시 일정시간마다 글을 임시 저장하는 테이블   \r\n");
		fwrite($fsi," $" . "tkher['cert_history_table']	= KAPP_TABLE_PREFIX.'cert_history'; // 인증내역 테이블   \r\n");
		fwrite($fsi," $" . "tkher['qa_config_table']	= KAPP_TABLE_PREFIX.'qa_config';    // 1:1문의 설정테이블   \r\n");
		fwrite($fsi," $" . "tkher['qa_content_table']	= KAPP_TABLE_PREFIX.'qa_content';   // 1:1문의 테이블   \r\n");
		fwrite($fsi," $" . "tkher['content_table']		= KAPP_TABLE_PREFIX.'content';      // 내용(컨텐츠)정보 테이블   \r\n");
		fwrite($fsi," $" . "tkher['faq_table']			= KAPP_TABLE_PREFIX.'faq';          // 자주하시는 질문 테이블   \r\n");
		fwrite($fsi," $" . "tkher['faq_master_table']	= KAPP_TABLE_PREFIX.'faq_master';   // 자주하시는 질문 마스터 테이블   \r\n");
		fwrite($fsi," $" . "tkher['new_win_table']		= KAPP_TABLE_PREFIX.'new_win';      // 새창 테이블   \r\n");
		fwrite($fsi," $" . "tkher['menu_table']			= KAPP_TABLE_PREFIX.'menu';         // 메뉴관리 테이블   \r\n");
		fwrite($fsi," $" . "tkher['poll_table']			= KAPP_TABLE_PREFIX.'poll';         // 투표 테이블   \r\n");
		fwrite($fsi," $" . "tkher['poll_etc_table']		= KAPP_TABLE_PREFIX.'poll_etc';     // 투표 기타의견 테이블   \r\n");
		fwrite($fsi," $" . "tkher['popular_table']		= KAPP_TABLE_PREFIX.'popular';      // 인기검색어 테이블   \r\n");
		fwrite($fsi," $" . "tkher['scrap_table']		= KAPP_TABLE_PREFIX.'scrap';        // 게시글 스크랩 테이블   \r\n");
*/

		fwrite($fsi," $" . "tkher['table10_table']		= KAPP_TABLE_PREFIX.'table10';                               // kapp_table10_table   \r\n");
		fwrite($fsi," $" . "tkher['table10_pg_table']	= KAPP_TABLE_PREFIX.'table10_pg';                     // kapp_table10_pg_table   \r\n");
		fwrite($fsi," $" . "tkher['job_link_table']		= KAPP_TABLE_PREFIX.'job_link_table';                    // kapp_job_link_table   \r\n");
		fwrite($fsi," $" . "tkher['sys_menu_bom_table']		= KAPP_TABLE_PREFIX.'sys_menu_bom';     // kapp_sys_menu_bom   \r\n");
// ----------------------------- add 2025-03-25 curl 부분 추가 . ---------------------------------------------
		fwrite($fsi," $" . "tkher['table10_curl_table']		= KAPP_TABLE_PREFIX.'table10_curl';                               // kapp_table10_table_curl   \r\n");
		fwrite($fsi," $" . "tkher['table10_pg_curl_table']	= KAPP_TABLE_PREFIX.'table10_pg_curl';                     // kapp_table10_pg_table_curl   \r\n");
		fwrite($fsi," $" . "tkher['job_link_table_curl']		= KAPP_TABLE_PREFIX.'job_link_table_curl';                    // kapp_job_link_table_curl   \r\n");
		fwrite($fsi," $" . "tkher['sys_menu_bom_curl_table']		= KAPP_TABLE_PREFIX.'sys_menu_bom_curl';     // kapp_sys_menu_bom_curl  \r\n");
//---------------------- end

		fwrite($fsi," $" . "tkher['table10_group_table']		= KAPP_TABLE_PREFIX.'table10_group';    // table10_group   \r\n");
		fwrite($fsi," $" . "tkher['project_table']		= KAPP_TABLE_PREFIX.'project';      // project   \r\n");

		fwrite($fsi," $" . "tkher['aboard_infor_table']		= KAPP_TABLE_PREFIX.'aboard_infor'; // aboard_infor   \r\n");
		fwrite($fsi," $" . "tkher['aboard_admin_table']		= KAPP_TABLE_PREFIX.'aboard_admin'; // aboard_admin   \r\n");
		fwrite($fsi," $" . "tkher['aboard_memo_table']		= KAPP_TABLE_PREFIX.'aboard_memo';  // aboard_memo   \r\n");
		fwrite($fsi," $" . "tkher['webeditor_table']			= KAPP_TABLE_PREFIX.'webeditor';    // webeditor   \r\n");
		fwrite($fsi," $" . "tkher['webeditor_comment_table']	= KAPP_TABLE_PREFIX.'webeditor_comment';// webeditor_comment   \r\n");
		fwrite($fsi," $" . "tkher['menuskin_table']			= KAPP_TABLE_PREFIX.'menuskin';     // menuskin   \r\n");
		fwrite($fsi," $" . "tkher['ap_bbs_table']			= KAPP_TABLE_PREFIX.'ap_bbs';      // 게시판 등록 모든 데이터 수집 테이블   \r\n");

		fwrite($fsi," $" . "tkher['memo_table']			= KAPP_TABLE_PREFIX.'memo_table';   // X 관리자 및 사용자 간의 메모 전달 관리. 1 대 다 전달 기능   \r\n");

		fwrite($fsi," $" . "tkher['tkher_main_img_table']  = KAPP_TABLE_PREFIX.'tkher_main_img';  // slide main and my image   \r\n");
		fwrite($fsi," $" . "tkher['sajin_group_table']	   = KAPP_TABLE_PREFIX.'sajin_group';     //   \r\n");
		fwrite($fsi," $" . "tkher['tkher_my_control_table']= KAPP_TABLE_PREFIX.'tkher_my_control';//   \r\n");
		fwrite($fsi," $" . "tkher['pri_maintenance_table']= KAPP_TABLE_PREFIX.'pri_maintenance';//   \r\n");

		fwrite($fsi," $" . "tkher['coin_view_table']= KAPP_TABLE_PREFIX.'coin_view';//   \r\n");  // add 2024-05-03
		fwrite($fsi," $" . "tkher['url_group_table']= KAPP_TABLE_PREFIX.'url_group';//   \r\n");  // add 2024-05-03
		fwrite($fsi," $" . "tkher['log_info_table']= KAPP_TABLE_PREFIX.'log_info';//   \r\n");  // add 2024-05-21
		fwrite($fsi," $" . "tkher['bbs_history_table']= KAPP_TABLE_PREFIX.'bbs_history';//   \r\n");  // add 2024-05-21

		fwrite($fsi,"?>                                                 \r\n");

		/* 필요시 해제...
		fwrite($fst,"$"."connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD, KAPP_MYSQL_DB) or die('MySQL Connect Error!!!');  \r\n");
		fwrite($fst," if( $"."connect_db=='dberror' ) { $"."connect_dbcheck='dberror'; return; } \r\n"); 
		fwrite($fst,"$"."select_db  = sql_select_db(KAPP_MYSQL_DB, $"."connect_db) or die('MySQL DB Error!!!');  \r\n");
		fwrite($fst,"$"."kapp['connect_db'] = $"."connect_db; \r\n");
		fwrite($fst,"sql_set_charset('utf8', $"."connect_db); \r\n");
		*/

		fclose($fsi);
		m_("file : " . $kapp_dbcon . " 을 생성 하였습니다.");
		//echo "<br><a href='./DB_Table_CreateA.php?admin=modumoa' ><b>Table info list - Click here!!!</b></a>";
		//echo "<script> href='./DB_Table_CreateA.php'; </script>"; //DB_Table_CreateA.php , SQL_Create_Table.php
	}


//==========================================================
function Delete_table($_prefix, $tab) {
    $kapp_tab = $_prefix.$tab;
    $SQL = " drop table ".$kapp_tab." ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");
    } else {
        m_("Delete Success : $tab");
    }
}

//==========================================================
function Login($t_head, $tab){
	global $admin_email, $table_prefix;
    $tab = $t_head.$tab;
	$SQL = "
        CREATE TABLE ".$t_head."login (
		  lo_ip varchar(255) NOT NULL DEFAULT 'localip',
		  mb_id varchar(20) NOT NULL DEFAULT 'mid',
		  lo_datetime datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  lo_location text DEFAULT NULL,
		  lo_url text DEFAULT NULL,
		  PRIMARY KEY (lo_ip)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	";
}

function Config($t_head, $tab) {
		global $admin_email, $table_prefix;
    $tab = $t_head.$tab;
		$admin_id = str_replace( "@", "_", $admin_email); // 2025-05-18 add

    $SQL = "
        CREATE TABLE ".$t_head."config (
        kapp_title varchar(255) NOT NULL DEFAULT '',
        kapp_theme varchar(255) DEFAULT NULL,
        kapp_admin varchar(255) NOT NULL DEFAULT '',
        kapp_admin_email varchar(255) DEFAULT NULL,
        kapp_admin_email_name varchar(255) DEFAULT NULL,
        kapp_add_script text DEFAULT NULL,
        kapp_admin_level int(3) DEFAULT 8,
        kapp_use_point tinyint(4) DEFAULT 0,
        kapp_point_term int(11) DEFAULT 0,
        kapp_use_copy_log tinyint(4) DEFAULT 0,
        kapp_use_email_certify tinyint(4) DEFAULT 0,
        kapp_login_point int(11) DEFAULT 0,
        kapp_cut_name tinyint(4) DEFAULT 0,
        kapp_nick_modify int(11) DEFAULT 0,
        kapp_new_skin varchar(255) DEFAULT NULL,
        kapp_new_rows int(11) DEFAULT 0,
        kapp_search_skin varchar(255) DEFAULT NULL,
        kapp_connect_skin varchar(255) DEFAULT NULL,
        kapp_faq_skin varchar(255) DEFAULT NULL,
        kapp_read_point int(11) DEFAULT 0,
        kapp_write_point int(11) DEFAULT 0,
        kapp_comment_point int(11) DEFAULT 0,
        kapp_download_point int(11) DEFAULT 0,
        kapp_write_pages int(11) DEFAULT 0,
        kapp_mobile_pages int(11) DEFAULT 0,
        kapp_link_target varchar(255) DEFAULT NULL,
        kapp_delay_sec int(11) DEFAULT 0,
        kapp_filter text DEFAULT NULL,
        kapp_possible_ip text DEFAULT NULL,
        kapp_intercept_ip text DEFAULT NULL,
        kapp_analytics text DEFAULT NULL,
        kapp_add_meta text DEFAULT NULL,
        kapp_syndi_token varchar(255) DEFAULT NULL,
        kapp_syndi_except text DEFAULT NULL,
        kapp_member_skin varchar(255) DEFAULT NULL,
        kapp_use_homepage tinyint(4) DEFAULT 0,
        kapp_req_homepage tinyint(4) DEFAULT 0,
        kapp_use_tel tinyint(4) DEFAULT 0,
        kapp_req_tel tinyint(4) DEFAULT 0,
        kapp_use_hp tinyint(4) DEFAULT 0,
        kapp_req_hp tinyint(4) DEFAULT 0,
        kapp_use_addr tinyint(4) DEFAULT 0,
        kapp_req_addr tinyint(4) DEFAULT 0,
        kapp_use_signature tinyint(4) DEFAULT 0,
        kapp_req_signature tinyint(4) DEFAULT 0,
        kapp_use_profile tinyint(4) DEFAULT 0,
        kapp_req_profile tinyint(4) DEFAULT 0,
        kapp_register_level tinyint(4) DEFAULT 0,
        kapp_register_point int(11) DEFAULT 0,
        kapp_icon_level tinyint(4) DEFAULT 0,
        kapp_use_recommend tinyint(4) DEFAULT 0,
        kapp_recommend_point int(11) DEFAULT 0,
        kapp_leave_day int(11) DEFAULT 0,
        kapp_search_part int(11) DEFAULT 0,
        kapp_email_use tinyint(4) DEFAULT 0,
        kapp_email_wr_super_admin tinyint(4) DEFAULT 0,
        kapp_email_wr_group_admin tinyint(4) DEFAULT 0,
        kapp_email_wr_board_admin tinyint(4) DEFAULT 0,
        kapp_email_wr_write tinyint(4) DEFAULT 0,
        kapp_email_wr_comment_all tinyint(4) DEFAULT 0,
        kapp_email_mb_super_admin tinyint(4) DEFAULT 0,
        kapp_email_mb_member tinyint(4) DEFAULT 0,
        kapp_email_po_super_admin tinyint(4) DEFAULT 0,
        kapp_prohibit_id text DEFAULT NULL,
        kapp_prohibit_email text DEFAULT NULL,
        kapp_new_del int(11) DEFAULT 0,
        kapp_memo_del int(11) DEFAULT 0,
        kapp_visit_del int(11) DEFAULT 0,
        kapp_popular_del int(11) DEFAULT 0,
        kapp_optimize_date date DEFAULT '0000-00-00',
        kapp_use_member_icon tinyint(4) DEFAULT 0,
        kapp_member_icon_size int(11) DEFAULT 0,
        kapp_member_icon_width int(11) DEFAULT 0,
        kapp_member_icon_height int(11) DEFAULT 0,
        kapp_login_minutes int(11) DEFAULT 0,
        kapp_image_extension varchar(255) DEFAULT NULL,
        kapp_flash_extension varchar(255) DEFAULT NULL,
        kapp_movie_extension varchar(255) DEFAULT NULL,
        kapp_formmail_is_member tinyint(4) DEFAULT 0,
        kapp_page_rows int(11) DEFAULT 0,
        kapp_mobile_page_rows int(11) DEFAULT 0,
        kapp_visit varchar(255) DEFAULT NULL,
        kapp_max_po_id int(11) DEFAULT 0,
        kapp_stipulation text DEFAULT NULL,
        kapp_privacy text DEFAULT NULL,
        kapp_open_modify int(11) DEFAULT 0,
        kapp_memo_send_point int(11) DEFAULT 0,
        kapp_mobile_new_skin varchar(255) DEFAULT NULL,
        kapp_mobile_search_skin varchar(255) DEFAULT NULL,
        kapp_mobile_connect_skin varchar(255) DEFAULT NULL,
        kapp_mobile_faq_skin varchar(255) DEFAULT NULL,
        kapp_mobile_member_skin varchar(255) DEFAULT NULL,
        kapp_captcha_mp3 varchar(255) DEFAULT NULL,
        kapp_editor varchar(255) DEFAULT NULL,
        kapp_cert_use tinyint(4) DEFAULT 0,
        kapp_cert_ipin varchar(255) DEFAULT NULL,
        kapp_cert_hp varchar(255) DEFAULT NULL,
        kapp_cert_kcb_cd varchar(255) DEFAULT NULL,
        kapp_cert_kcp_cd varchar(255) DEFAULT NULL,
        kapp_lg_mid varchar(255) DEFAULT NULL,
        kapp_lg_mert_key varchar(255) DEFAULT NULL,
        kapp_cert_limit int(11) DEFAULT 0,
        kapp_cert_req tinyint(4) DEFAULT 0,
        kapp_sms_use varchar(255) DEFAULT NULL,
        kapp_sms_type varchar(10) DEFAULT NULL,
        kapp_icode_id varchar(255) DEFAULT NULL,
        kapp_icode_pw varchar(255) DEFAULT NULL,
        kapp_icode_server_ip varchar(255) DEFAULT NULL,
        kapp_icode_server_port varchar(255) DEFAULT NULL,
        kapp_googl_shorturl_apikey varchar(255) DEFAULT NULL,
        kapp_facebook_appid varchar(255) DEFAULT NULL,
        kapp_facebook_secret varchar(255) DEFAULT NULL,
        kapp_twitter_key varchar(255) DEFAULT NULL,
        kapp_twitter_secret varchar(255) DEFAULT NULL,
        kapp_kakao_js_apikey varchar(255) DEFAULT NULL,
        kapp_naver_client_id varchar(255) DEFAULT NULL,
        kapp_naver_client_secret varchar(255) DEFAULT NULL,

        kapp_shop_code varchar(20) DEFAULT NULL,
        kapp_shop_name varchar(5) DEFAULT NULL,
        kapp_shop_delivery_cost int(11) DEFAULT 3000,
        kapp_pay_point int(11) DEFAULT 1,
        kapp_slide_time int(11) DEFAULT 6000,

		PRIMARY KEY (kapp_title)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    "; // naver add 2024-04-24
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");

        $query = "
        INSERT INTO `".$t_head."config` (`kapp_title`, `kapp_theme`, `kapp_admin`, `kapp_admin_email`, `kapp_admin_email_name`, `kapp_add_script`, `kapp_admin_level`, `kapp_use_point`, `kapp_point_term`, `kapp_use_copy_log`, `kapp_use_email_certify`, `kapp_login_point`, `kapp_cut_name`, `kapp_nick_modify`, `kapp_new_skin`, `kapp_new_rows`, `kapp_search_skin`, `kapp_connect_skin`, `kapp_faq_skin`, `kapp_read_point`, `kapp_write_point`, `kapp_comment_point`, `kapp_download_point`, `kapp_write_pages`, `kapp_mobile_pages`, `kapp_link_target`, `kapp_delay_sec`, `kapp_filter`, `kapp_possible_ip`, `kapp_intercept_ip`, `kapp_analytics`, `kapp_add_meta`, `kapp_syndi_token`, `kapp_syndi_except`, `kapp_member_skin`, `kapp_use_homepage`, `kapp_req_homepage`, `kapp_use_tel`, `kapp_req_tel`, `kapp_use_hp`, `kapp_req_hp`, `kapp_use_addr`, `kapp_req_addr`, `kapp_use_signature`, `kapp_req_signature`, `kapp_use_profile`, `kapp_req_profile`, `kapp_register_level`, `kapp_register_point`, `kapp_icon_level`, `kapp_use_recommend`, `kapp_recommend_point`, `kapp_leave_day`, `kapp_search_part`, `kapp_email_use`, `kapp_email_wr_super_admin`, `kapp_email_wr_group_admin`, `kapp_email_wr_board_admin`, `kapp_email_wr_write`, `kapp_email_wr_comment_all`, `kapp_email_mb_super_admin`, `kapp_email_mb_member`, `kapp_email_po_super_admin`, `kapp_prohibit_id`, `kapp_prohibit_email`, `kapp_new_del`, `kapp_memo_del`, `kapp_visit_del`, `kapp_popular_del`, `kapp_optimize_date`, `kapp_use_member_icon`, `kapp_member_icon_size`, `kapp_member_icon_width`, `kapp_member_icon_height`, `kapp_login_minutes`, `kapp_image_extension`, `kapp_flash_extension`, `kapp_movie_extension`, `kapp_formmail_is_member`, `kapp_page_rows`, `kapp_mobile_page_rows`, `kapp_visit`, `kapp_max_po_id`, `kapp_stipulation`, `kapp_privacy`, `kapp_open_modify`, `kapp_memo_send_point`, `kapp_mobile_new_skin`, `kapp_mobile_search_skin`, `kapp_mobile_connect_skin`, `kapp_mobile_faq_skin`, `kapp_mobile_member_skin`, `kapp_captcha_mp3`, `kapp_editor`, `kapp_cert_use`, `kapp_cert_ipin`, `kapp_cert_hp`, `kapp_cert_kcb_cd`, `kapp_cert_kcp_cd`, `kapp_lg_mid`, `kapp_lg_mert_key`, `kapp_cert_limit`, `kapp_cert_req`, `kapp_sms_use`, `kapp_sms_type`, `kapp_icode_id`, `kapp_icode_pw`, `kapp_icode_server_ip`, `kapp_icode_server_port`, `kapp_googl_shorturl_apikey`, `kapp_facebook_appid`, `kapp_facebook_secret`, `kapp_twitter_key`, `kapp_twitter_secret`, `kapp_kakao_js_apikey`, `kapp_naver_client_id`, `kapp_naver_client_secret`, `kapp_shop_code`, `kapp_shop_name`, `kapp_shop_delivery_cost`, `kapp_pay_point`, `kapp_slide_time`) 
		VALUES
		('K-App', 'https://fation.net/kapp', '".$admin_id."', '".$admin_email."', 'K-App', '', 8, 1, 0, 1, 1, 100, 10, 60, 'basic', 15, 'basic', 'basic', 'basic', 100, 3000, 1000, -3000, 10, 5, '_blank', 30, '18아,18놈,18새끼,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ', '', '', '', '', '', '', 'basic', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 2, 30000, 2, 1, 1000, 30, 1000, 1, 0, 0, 0, 0, 0, 1, 1, 0, 'admin,administrator,webmaster,sysop,manager,root,su,guest', '', 30, 180, 365, 180, '2022-12-08', 2, 5000, 22, 22, 10, 'gif|jpg|jpeg|png', 'swf', 'asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3', 1, 15, 10, 'today:2, yestday:, max:2, Total:2', 0, 'A. K-App No Coding System website terms and conditions\r\nThe following terms apply to all use of the website \r\n\r\nPLEASE READ THIS AGREEMENT CAREFULLY BEFORE ACCESSING OR USING THE WEBSITE. By accessing or using any portion of the website, you agree to the terms of this Agreement. If you do not agree to all of the terms and conditions of this Agreement, you will not be able to access the Website or use the Services. If these Terms of Use are considered an offer of U-link System, you expressly agree to these Terms and Conditions. This website is only available to individuals who are at least 13 years old.\r\n\r\n1. Ownership\r\nOwnership, copyright and ownership of software developed by U-link System must always remain in U-link System. You may not acquire, directly, indirectly, or implicitly, ownership, copyright or ownership of the software or any part thereof. We do not claim ownership of any information you submit to the U-link System application itself, and your code is yours.\r\n\r\n2. Your account and website\r\nWhen you create an account on the website, you are responsible for maintaining the security of your account, and you are solely responsible for all activities related to your account and other actions related to your account. You must promptly notify U-link System of any unauthorized use of your account or any other security breach. U-link System is not liable for any act or negligence by you, including any damages of any kind arising out of such acts or omissions.\r\n\r\n3. Acceptable use of your account and website\r\nBy agreeing to this Agreement, you agree that you will not use, recommend, promote or facilitate the use of the Website or your account by others in a manner that is harmful to others (“Acceptable Use”). Examples of harmful uses include illegal or fraudulent activities, infringement of the intellectual property rights of others, defamation, obscene content, violent content, violent content, infringement of privacy, or distributing content that is harassing. The security or integrity of a network or communication system, a taxable resource for activities such as cryptocurrency mining. External scans of the U-link System infrastructure cannot be performed without the written permission of the U-link System.\r\n\r\n4.Payment and renewal for subscriptions purchased through the website\r\nBy choosing a subscription, you agree to pay the U-link System a designated annual subscription fee for that service. Subscription fees are non-refundable within the first 45 days of subscription. The subscription fee is stated on the invoice. Your subscription will automatically renew unless you notify the U-link System you wish to cancel your subscription before the end of the subscription period. U-link System reserves the right to adjust rates at the time of renewal. You have the right to collect the applicable annual subscription fee using the credit card or other payment method recorded by us. All subscriptions are subject to the terms and conditions of the U-link System Subscription Terms.\r\n\r\n5.U-link System newsletter\r\nBy creating an account on U-link System, you will be given the right to add your email address to the U-link System newsletter. You can unsubscribe at any time using the link at the bottom of the newsletter.\r\n\r\n6. Responsibilities of website visitors\r\nU-link System does not review \r\n\r\n7. Content posted on other websites\r\nWe have not reviewed \r\n\r\n8. Copyright Infringement and DMCA Policy\r\nU-link System respects the intellectual property rights of others because it asks others to respect their intellectual property rights. If you believe that any material on the U-link System infringes your copyright, please notify U-link System in accordance with DMCA policy.\r\n\r\n9.Data privacy\r\nYou must ensure that any inf\r\n\r\n(U-link System Contribut\r\n\r\n10. Intellectual property rights\r\nThis Agreement does not transfer the intellectual property rights of the U-link System or any third party to you by the U-link System, and all rights, titles and interests in such property remain (between the parties) with the U-link System. U-link System, the U-link System logo, and all other trademarks, service marks, graphics and logos or websites associated with the U-link System are trademarks or registered trademarks of U-link System BV or U-link System licensors. Use of the \"U-link System\" is under license. Other trademarks, service marks, graphics and logos used in connection with the website may be trademarks of other third parties. Use of the website does not give you any right or license to reproduce or otherwise use the U-link System or any third party trademarks.\r\n\r\n11. Changes\r\nWhile most changes may be min\r\n\r\n12. General Representative\r\nYou will (i) strictly comply with this Agreement \r\n\r\n13. End\r\nThe U-link System may terminate your access to all \r\n\r\n14. Limitation of Liability\r\nU-link System or its affiliates, suppliers or licensors shall not be liable for any contract, negligence, strict liability or any other liability in relation to the subject matter of this Agreement under any law or impartial theory. (i) U-link System, or consequential damages; (ii) Cost of procurement for a replacement product or service; (iii) Use or loss of data or discontinuation of data; Or (iv) we are not liable for any damages. U-link System cannot be held liable for failures or delays due to issues beyond its reasonable control.\r\n\r\n15. Warranty\r\nYou agree that U-link System, its affiliates, contract\r\n\r\n16. Disclaimer of Warranty\r\nThe website is provided \"as is\". U-link System \r\n\r\n17. Partial void\r\nIf a court of competent jurisdiction claims any provision of this document as invalid, invalid or unenforceable, the remaining provisions will remain in full effect without being damaged or invalidated in any way.\r\n\r\n18. Execution failure\r\n\r\n19. Dispute Resolution\r\nBoth parties will enter into good faith negotiations to resolve the dispute for 10 business days after written notice of the dispute or written matter has been provided to the other party. Within such 10 business days, the representatives of each party will participate in negotiations to resolve the dispute, and these individuals will meet in person via video conference or telephone to attempt to resolve the dispute or problem informally. If such parties are unable to resolve the dispute within 10 such business days, the parties may exercise their rights to use this Agreement or otherwise, unless the parties mutually agree to extend the negotiation period.\r\n\r\n20. Arbitration\r\nAny dispute, controversy, or allegation arising in connection with this Agreement, including the formation, interpretation, breach or termination of this Agreement, including whether any claims not resolved through the procedures set forth in Dispute Resolution may be asserted, shall be governed by the Arbitration Rules of the Republic of Korea Arbitration Service. Subject to arbitration and final decision. The arbitral tribunal consists of one arbitrator. The place of arbitration shall be the Republic of Korea. A ruling on an award made by an arbitrator may be filed with a court having jurisdiction.\r\n\r\n21. Governing Law\r\nThis Agreement is governed and construed in accordance with the laws of the Republic of Korea.\r\n', 'Purpose item retention period\r\nIdentification of the user, contact for contract execution, handling of complaints related to the use of the service Until the e-mail service is canceled.\r\nHowever, when it is necessary to retain the transaction-related rights and obligations for a certain period of time,\r\nFor the period set by the relevant laws or for the period set forth below\r\n1) Record of consumer complaints or disputes: 3 years\r\n2) Records on the collection, processing and use of credit information: 3 years  3) Record of payment and goods supply: 5 years\r\n4) Record of contract or withdrawal of subscription: 5 years\r\n5) Login record: 3 months\r\n', 0, 100, 'basic', 'basic', 'basic', 'basic', 'basic', 'basic', 'cheditor5', 0, '', '', '', '', '', '', 5, 1, 'icode', '', 'K-APP', '778855', '211.172.232.124', '7295', '', '', '', '', '', '', '', '', '', '', 3000, 1, 6000)
        "; // naver add 2024-04-24

		//`kapp_as_thema`, `kapp_as_color`, `kapp_as_mobile_thema`, `kapp_as_mobile_color`, `kapp_as_admin`, `kapp_as_intro`, `kapp_as_intro_skin`, `kapp_as_mobile_intro_skin`, `kapp_as_tag_skin`, `kapp_as_mobile_tag_skin`, `kapp_as_misc_skin`, `kapp_as_lang`, `kapp_as_gnu`, `kapp_as_xp`, `kapp_as_mp`) 
		//, 'Basic', 'Basic', 'Basic', 'Basic', '', '', '', '', 'basic', 'basic', 'basic', 'english', 0, 'XP', 'MP')

        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
        } else {
            echo " - Create Success and Record Create  Success : $tab, admin email:" . $admin_email;
        }
    }
}
function Aboard_admin($t_head, $tab) {
    /* m_("Create Success : $tab");
    exit; */
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."aboard_admin (
        no int(11) auto_increment NOT NULL,
        id varchar(50) DEFAULT NULL,
        password varchar(15) DEFAULT NULL,
        url varchar(70) DEFAULT NULL,
        db_host varchar(50) DEFAULT NULL,
        db_user varchar(50) DEFAULT NULL,
        db_password varchar(50) DEFAULT NULL,
        db_database varchar(50) DEFAULT NULL,
        bbsname varchar(50) DEFAULT '',
        lev smallint(2) DEFAULT 0,
        bbstitle varchar(50) DEFAULT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");

        $query = "
        INSERT INTO `".$t_head."aboard_admin` (`no`, `id`, `password`, `url`, `db_host`, `db_user`, `db_password`, `db_database`, `bbsname`, `lev`, `bbstitle`) VALUES (1, 'admin', '1004', 'menu', '', '', '', '', 'tkher', 0, '전체관리')
        ";

        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");//table이 이미 존재하는지 확인 바랍니다
        } else {
            echo "Create Success and Record Create  Success : $tab";
        }
    }
}

function Aboard_infor($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."aboard_infor (
        no int(11) auto_increment NOT NULL,
        name varchar(50) DEFAULT NULL,
        table_name varchar(50) DEFAULT NULL,
        fileup int(11) DEFAULT NULL,
        in_date int(11) DEFAULT NULL,
        memo_gubun int(11) DEFAULT NULL,
        ip_gubun int(11) DEFAULT NULL,
        html_gubun int(11) DEFAULT NULL,
        imember varchar(50) DEFAULT NULL,
        home_url varchar(150) DEFAULT NULL,
        table_width varchar(5) DEFAULT NULL,
        list_table_set varchar(150) DEFAULT NULL,
        list_title_bgcolor varchar(7) DEFAULT NULL,
        list_title_font varchar(7) DEFAULT NULL,
        list_text_bgcolor varchar(7) DEFAULT NULL,
        list_text_font varchar(7) DEFAULT NULL,
        list_size int(11) DEFAULT NULL,
        detail_table_set varchar(150) DEFAULT NULL,
        detail_title_bgcolor varchar(7) DEFAULT NULL,
        detail_title_font varchar(7) DEFAULT NULL,
        detail_text_bgcolor varchar(7) DEFAULT NULL,
        detail_text_font varchar(7) DEFAULT NULL,
        detail_memo_bgcolor varchar(7) DEFAULT NULL,
        detail_memo_font varchar(7) DEFAULT NULL,
        input_table_set varchar(150) DEFAULT NULL,
        input_title_bgcolor varchar(7) DEFAULT NULL,
        input_title_font varchar(7) DEFAULT NULL,
        icon_home varchar(100) DEFAULT NULL,
        icon_prev varchar(100) DEFAULT NULL,
        icon_next varchar(100) DEFAULT NULL,
        icon_insert varchar(100) DEFAULT NULL,
        icon_update varchar(100) DEFAULT NULL,
        icon_delete varchar(100) DEFAULT NULL,
        icon_reply varchar(100) DEFAULT NULL,
        icon_list varchar(100) DEFAULT NULL,
        icon_search_list varchar(100) DEFAULT NULL,
        icon_search varchar(100) DEFAULT NULL,
        icon_submit varchar(100) DEFAULT NULL,
        icon_new varchar(100) DEFAULT NULL,
        icon_list_reply varchar(100) DEFAULT NULL,
        icon_memo varchar(100) DEFAULT NULL,
        icon_admin varchar(100) DEFAULT NULL,
        list_gubun int(11) DEFAULT NULL,
        connection_gubun int(11) DEFAULT NULL,
        top_html text DEFAULT NULL,
        bottom_html text DEFAULT NULL,
        grant_view int(2) DEFAULT 0,
        grant_write int(2) DEFAULT 0,
        movie char(1) DEFAULT NULL,
        title_color varchar(20) DEFAULT NULL,
        title_text_color varchar(20) DEFAULT NULL,
        security char(1) DEFAULT NULL,
        lev char(1) DEFAULT NULL,
        make_id varchar(50) NOT NULL DEFAULT '',
        make_club varchar(255) DEFAULT NULL,
        sunbun int(4) DEFAULT 0,
        memo text DEFAULT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Aboard_memo($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."aboard_memo (
        no int(11) auto_increment NOT NULL,
        board_name varchar(30) NOT NULL DEFAULT '',
        list_no int(11) NOT NULL DEFAULT 0,
        name varchar(20) NOT NULL,
        memo text DEFAULT NULL,
        in_date varchar(20) DEFAULT NULL,
        password varchar(15) DEFAULT NULL,
        id varchar(50) DEFAULT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Admin_bbs($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."admin_bbs (
        no int(8) auto_increment NOT NULL,
        name varchar(20) DEFAULT NULL,
        comment varchar(100) DEFAULT NULL,
        skin varchar(30) NOT NULL DEFAULT 'modern',
        admin_icon char(1) NOT NULL DEFAULT 'N',
        guest_write char(1) NOT NULL DEFAULT 'N',
        is_notice char(1) NOT NULL DEFAULT 'N',
        is_secret char(1) NOT NULL DEFAULT 'N',
        bbs_level int(1) NOT NULL DEFAULT 9,
        upload_image char(1) NOT NULL DEFAULT 'N',
        up_image_size int(2) NOT NULL DEFAULT 1,
        upload_file char(1) NOT NULL DEFAULT 'N',
        up_file_size int(2) NOT NULL DEFAULT 2,
        width int(4) NOT NULL DEFAULT 600,
        cut int(3) DEFAULT 62,
        list_num int(2) DEFAULT 10,
        page_num int(2) DEFAULT 10,
        font_size int(2) NOT NULL DEFAULT 9,
        font_family varchar(10) NOT NULL DEFAULT '굴림',
        font_color varchar(10) NOT NULL DEFAULT '#000000',
        line_color varchar(10) NOT NULL DEFAULT '#eeeeee',
        top1 varchar(50) DEFAULT 'bbs_top.php',
        top2 text DEFAULT NULL,
        top3 text DEFAULT NULL,
        foot1 text DEFAULT NULL,
        foot2 text DEFAULT NULL,
        foot3 varchar(50) DEFAULT 'bbs_foot.php',
        memo text NOT NULL,
        uptime varchar(20) DEFAULT NULL,
        make_userid varchar(50) NOT NULL DEFAULT 'solpakan'
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Bbs_history($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."bbs_history (
        no int(11) auto_increment NOT NULL,
        id varchar(50) NOT NULL,
        pg_code char(50) NOT NULL,
        pg_name char(150) NOT NULL,
        build_time int(11) DEFAULT NULL,
        comment text DEFAULT NULL,
        cid varchar(50) DEFAULT NULL,
        ctime timestamp NULL DEFAULT current_timestamp()
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Coin_view($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."coin_view (
        seqno int(11) auto_increment NOT NULL,
        id varchar(50) NOT NULL,
        makeid varchar(50) NOT NULL,
        title varchar(255) NOT NULL,
        url varchar(255) NOT NULL DEFAULT '',
        up_day varchar(25) NOT NULL,
        ip varchar(15) NOT NULL,
        host varchar(100) NOT NULL,
        cd varchar(10) NOT NULL,
        cdname varchar(30) NOT NULL,
        view_cnt int(13) NOT NULL DEFAULT 0,
        type varchar(10) NOT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Ip_info($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."ip_info (
        no int(10) auto_increment NOT NULL,
        ip1 varchar(30) NOT NULL DEFAULT '',
        ip2 varchar(30) NOT NULL DEFAULT '',
        ipno1 bigint(11) NOT NULL DEFAULT 0,
        ipno2 bigint(11) NOT NULL DEFAULT 0,
        country_cd varchar(5) DEFAULT NULL,
        country_name varchar(20) DEFAULT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Visit_sum($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."visit_sum (
        seqno int(11) auto_increment NOT NULL,
        vs_date date NOT NULL DEFAULT '0000-00-00',
        vs_count int(11) NOT NULL DEFAULT 0,
        visit_all int(11) NOT NULL DEFAULT 0,
        PRIMARY KEY (seqno),
        UNIQUE KEY vs_date (vs_date) USING BTREE,
        KEY index1 (vs_count)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Menuskin($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."menuskin (
        seqno int(11) auto_increment NOT NULL,
        user_id varchar(50) DEFAULT NULL,
        sys_pg varchar(30) DEFAULT NULL,
        sys_subtit varchar(50) NOT NULL DEFAULT '',
        sys_link varchar(100) DEFAULT NULL,
        bgcolor varchar(10) DEFAULT NULL,
        fontcolor varchar(10) DEFAULT NULL,
        fontface varchar(10) DEFAULT NULL,
        fontsize varchar(10) DEFAULT NULL,
        imgtype1 varchar(100) DEFAULT NULL,
        imgtype2 varchar(100) DEFAULT NULL,
        imgtype3 varchar(100) DEFAULT NULL,
        Mmemo varchar(100) DEFAULT NULL,
        club_url varchar(15) DEFAULT NULL,
        up_day timestamp NULL DEFAULT current_timestamp()
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Sajin_group($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."sajin_group (
        no int(10) auto_increment NOT NULL,
        g_code varchar(50) DEFAULT NULL,
        g_name varchar(50) NOT NULL DEFAULT '',
        g_class_code varchar(50) DEFAULT NULL,
        g_class_name varchar(50) DEFAULT NULL,
        userid varchar(50) DEFAULT NULL,
        lev char(3) NOT NULL DEFAULT '0',
        up_day datetime DEFAULT current_timestamp()
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Sajin_jpg($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."sajin_jpg (
        no int(11) auto_increment NOT NULL,
        jpg_name varchar(50) NOT NULL,
        jpg_file varchar(100) NOT NULL,
        jpg_memo varchar(200) NOT NULL,
        group_code varchar(50) DEFAULT NULL,
        group_name varchar(50) DEFAULT NULL,
        view_no int(11) DEFAULT 99,
        g_file1 varchar(100) DEFAULT NULL,
        g_file2 varchar(100) DEFAULT NULL,
        g_file3 varchar(100) DEFAULT NULL,
        day datetime DEFAULT current_timestamp(),
        url varchar(200) DEFAULT NULL,
        userid varchar(50) NOT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Table10($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10 (
        seqno int(13) auto_increment NOT NULL,
        group_code varchar(50) NOT NULL DEFAULT 'xxxx',
        group_name varchar(50) NOT NULL DEFAULT 'ETC(기타)',
        disno int(5) NOT NULL,
        tab_enm varchar(50) NOT NULL,
        tab_hnm varchar(50) NOT NULL,
        fld_enm varchar(50) NOT NULL,
        fld_hnm varchar(50) NOT NULL,
        fld_type varchar(10) NOT NULL,
        fld_len int(10) NOT NULL,
        if_line tinyint(3) DEFAULT NULL,
        if_type text DEFAULT NULL,
        if_data text DEFAULT NULL,
        relation_data text DEFAULT NULL,
        memo text NOT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(50) NOT NULL,
        grant_write varchar(3) DEFAULT NULL,
        grant_view varchar(3) DEFAULT NULL,
        table_yn varchar(3) DEFAULT NULL,
        sqltable text DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Table10_pg($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10_pg (
        seqno int(13) auto_increment NOT NULL,
        pg_code char(50) NOT NULL,
        pg_name char(50) NOT NULL,
        tab_enm varchar(50) NOT NULL,
        tab_hnm varchar(50) NOT NULL,
        item_cnt tinyint(3) DEFAULT NULL,
        item_array text NOT NULL,
        if_type text DEFAULT NULL,
        if_data text DEFAULT NULL,
        pop_data text DEFAULT NULL,
        relation_data text DEFAULT NULL,
        relation_type varchar(255) DEFAULT NULL,
        memo text DEFAULT NULL,
        group_code varchar(50) DEFAULT NULL,
        group_name varchar(50) DEFAULT NULL,
        disno int(5) DEFAULT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(50) NOT NULL,
        del varchar(1) DEFAULT NULL,
        del_date datetime DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Job_link_table($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."job_link_table (
        seqno int(11) auto_increment NOT NULL,
        job_name varchar(200) DEFAULT NULL,
        user_name varchar(200) DEFAULT NULL,
        job_addr text DEFAULT NULL,
        num varchar(50) DEFAULT NULL,
        aboard_no varchar(50) DEFAULT NULL,
        jong char(1) DEFAULT NULL,
        job_level char(1) DEFAULT NULL,
        job_group varchar(200) DEFAULT NULL,
        job_group_code varchar(50) DEFAULT NULL,
        price int(11) DEFAULT 0,
        user_id varchar(50) DEFAULT NULL,
        email varchar(50) DEFAULT NULL,
        club_url varchar(50) DEFAULT NULL,
        up_day timestamp NULL DEFAULT current_timestamp(),
        memo text DEFAULT NULL,
        view_cnt int(13) DEFAULT 0,
        ip varchar(255) DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Sys_menu_bom($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."sys_menu_bom (
        seqno int(11) auto_increment NOT NULL,
        sys_userid varchar(50) DEFAULT NULL,
        sys_pg varchar(50) NOT NULL,
        sys_rcnt int(11) DEFAULT 0,
        sys_disno int(11) DEFAULT 0,
        sys_subtit varchar(50) NOT NULL,
        sys_link varchar(255) NOT NULL,
        sys_level varchar(50) DEFAULT NULL,
        sys_menu varchar(255) NOT NULL,
        sys_submenu varchar(255) NOT NULL,
        sys_cnt int(11) DEFAULT 0,
        sys_memo text DEFAULT NULL,
        sys_board_num int(12) DEFAULT NULL,
        sys_menutit varchar(100) DEFAULT NULL,
        view_lev char(1) DEFAULT NULL,
        view_cnt int(11) DEFAULT 0,
        tit_gubun char(1) DEFAULT NULL,
        book_num varchar(50) DEFAULT NULL,
        up_day timestamp NULL DEFAULT current_timestamp(),
        sys_comp varchar(200) DEFAULT NULL,
        ip varchar(20) DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

//------ add 2025-03-17 테이블 컬럼 확인 필요 . 중요 -  보완완료2025-03-20
function Table10_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10_curl (
        `seqno` int(13) auto_increment NOT NULL,
  `host` char(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `group_code` varchar(50) NOT NULL DEFAULT 'xxxx',
  `group_name` varchar(50) NOT NULL DEFAULT 'ETC',
  `disno` int(5) NOT NULL,
  `tab_enm` varchar(50) NOT NULL,
  `tab_hnm` varchar(50) NOT NULL,
  `fld_enm` varchar(50) NOT NULL,
  `fld_hnm` varchar(50) NOT NULL,
  `fld_type` varchar(10) NOT NULL,
  `fld_len` int(10) NOT NULL,
  `if_line` tinyint(3) DEFAULT NULL,
  `if_type` text DEFAULT NULL,
  `if_data` text DEFAULT NULL,
  `relation_data` text DEFAULT NULL,
  `memo` text DEFAULT NULL,
  `upday` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `userid` varchar(50) NOT NULL,
  `grant_write` varchar(3) DEFAULT NULL,
  `grant_view` varchar(3) DEFAULT NULL,
  `table_yn` varchar(3) DEFAULT NULL,
  `sqltable` text DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Table10_pg_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10_pg_curl (
        `seqno` int(13) auto_increment NOT NULL,
  `host` varchar(30) NOT NULL,
  `pg_code` varchar(50) NOT NULL,
  `pg_name` varchar(50) NOT NULL,
  `tab_enm` varchar(50) NOT NULL,
  `tab_hnm` varchar(50) NOT NULL,
  `item_cnt` tinyint(3) DEFAULT NULL,
  `item_array` text NOT NULL,
  `if_type` text DEFAULT NULL,
  `if_data` text DEFAULT NULL,
  `pop_data` text DEFAULT NULL,
  `relation_data` text DEFAULT NULL,
  `relation_type` varchar(255) DEFAULT NULL,
  `memo` text DEFAULT NULL,
  `group_code` varchar(50) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `disno` int(5) DEFAULT NULL,
  `upday` timestamp NOT NULL DEFAULT current_timestamp(),
  `userid` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `del` varchar(1) DEFAULT NULL,
  `del_date` datetime DEFAULT NULL,
  `sys_link` varchar(255) NOT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Job_link_table_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."job_link_table_curl (
        `seqno` int(11) auto_increment NOT NULL,
  `kapp_server` varchar(30) DEFAULT NULL,
  `link_title` varchar(200) DEFAULT NULL,
  `link_url` text DEFAULT NULL,
  `link_type` char(1) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `up_day` timestamp NULL DEFAULT current_timestamp(),
  `memo` text DEFAULT NULL,
  `user_ip` varchar(255) DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Sys_menu_bom_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."sys_menu_bom_curl (
        `seqno` int(11) auto_increment NOT NULL,
  `host` varchar(30) DEFAULT NULL,
  `sys_userid` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sys_pg` varchar(50) NOT NULL,
  `sys_rcnt` int(11) DEFAULT 0,
  `sys_disno` int(11) DEFAULT 0,
  `sys_subtit` varchar(50) DEFAULT NULL,
  `sys_link` varchar(250) NOT NULL,
  `sys_level` varchar(50) DEFAULT NULL,
  `sys_menu` varchar(100) NOT NULL,
  `sys_submenu` varchar(100) NOT NULL,
  `sys_cnt` int(11) DEFAULT 0,
  `sys_memo` text DEFAULT NULL,
  `sys_file` varchar(50) DEFAULT NULL,
  `sys_menutit` varchar(100) DEFAULT NULL,
  `view_lev` char(1) DEFAULT NULL,
  `view_cnt` int(11) DEFAULT 0,
  `tit_gubun` char(1) DEFAULT NULL,
  `book_num` varchar(50) DEFAULT NULL,
  `up_day` timestamp NULL DEFAULT current_timestamp(),
  `ip` varchar(20) DEFAULT NULL,
  `bgcolor` varchar(10) DEFAULT NULL,
  `fontcolor` varchar(10) DEFAULT NULL,
  `fontface` varchar(10) DEFAULT NULL,
  `fontsize` varchar(10) DEFAULT NULL,
  `imgtype1` varchar(100) DEFAULT NULL,
  `imgtype2` varchar(100) DEFAULT NULL,
  `imgtype3` varchar(100) DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

//------------------------------------------------------------------------------ add end

function table10_group($t_head, $tab) {
    $tab = $t_head.$tab; // solpakan_1713493572

    $SQL = "
        CREATE TABLE ".$t_head."table10_group (
        seqno int(13) auto_increment NOT NULL,
        group_code varchar(50) NOT NULL,
        group_name varchar(50) NOT NULL,
        memo text NOT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(50) NOT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Tkher_main_img($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."tkher_main_img (
        no int(11) auto_increment NOT NULL,
        jpg_name varchar(50) NOT NULL,
        jpg_file varchar(200) NOT NULL,
        jpg_memo varchar(200) NOT NULL,
        group_code varchar(50) DEFAULT NULL,
        group_name varchar(50) DEFAULT NULL,
        view_no int(4) DEFAULT 99,
        g_file1 varchar(100) DEFAULT NULL,
        g_file2 varchar(100) DEFAULT NULL,
        g_file3 varchar(100) DEFAULT NULL,
        day timestamp NULL DEFAULT current_timestamp(),
        url varchar(200) DEFAULT NULL,
        userid varchar(50) NOT NULL,
        delay_time int(11) NOT NULL DEFAULT 3000
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");

        $query = "
        INSERT INTO `".$t_head."tkher_main_img` (`no`, `jpg_name`, `jpg_file`, `jpg_memo`, `group_code`, `group_name`, `view_no`, `g_file1`, `g_file2`, `g_file3`, `day`, `url`, `userid`, `delay_time`) VALUES
        (81, 'Developer Level', 'ma1.jpg', 'Beginner<br>\r\nIntermediate<br>\r\nAdvanced<br>\r\nExp', 'main', 'main', 5, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (82, 'App Generator My Page', 'ma2.jpg', 'My Album<br>\r\nSchedule<br>\r\nAccount Book<br>\r\nMy Menu Design', 'main', 'main', 6, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (98, 'Menu Make', 'ma4.jpg', 'My Menu Design<br>\r\nTree Menu Create<br>\r\nProgram Make and Source Code DownLoad<br>\r\nProgram Link<br>\r\nPopUp Menu Create<br>\r\nSource Code DownLoad', 'main', 'main', 1, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (86, 'K-APP My Page', '20171022_175759m.jpg', '이것 알아야하는이유?<br>\r\n나의 미래를 설계한다면 이것은 필수다.<br>\r\n나의 상상력을 발휘할려면 최소한 이것은 기본으로 알아야한다.<br>\r\n이것은 미래의시스템이다.<br>\r\n이것을 모르면 반드시 경쟁에서 밀린다.<br>\r\n이것에 투자할 시간은 하루면 충분하다.<br>\r\n이것은 시작이다. 창의력를 발휘하기 위해.', 'main', 'main', 12, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (87, 'Program Generation', 'bg_proj01.jpg', 'Beginner<br>\r\nMiddle<br>\r\nMaster<br>\r\nSource Code DownLoad', 'main', 'main', 99, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (88, 'Relationship', 'bg_proj02.jpg', 'Table Design<br>\r\nRelationship<br>\r\nColumn Move<br>\r\nSource Code DownLoad', 'main', 'main', 99, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (89, 'Table Design', 'bg_proj03.jpg', 'Column Name<br>\r\nType<br>\r\nLength<br>\r\nColumn Attribute<br>\r\nSource Code DownLoad', 'main', 'main', 4, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (91, 'Column Attribute', 'bg_proj05.jpg', 'Column Attribute<br>\r\nradio button<br>\r\ncheck box<br>\r\nList box<br>\r\nPopup Window<br>\r\nFormula<br>\r\nTable Relationship<br>\r\nSource Code DownLoad', 'main', 'main', 5, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (92, 'Column Formula', 'bg_proj06.jpg', 'Column Formula<br>\r\nA-column=B-Column+C-column<br>\r\nA=B*C<br>\r\nPrice=unit price * count<br>\r\nSource Code DownLoad', 'main', 'main', 99, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (93, 'App Generator PopUp Window', 'bg_proj07.jpg', 'App Generator PopUp Window<br>\r\nColumn Attribute<br>\r\nColumn Move<br>\r\nSource Code DownLoad\r\n', 'main', 'main', 8, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (94, 'Table Permission', 'bg_proj04.jpg', 'Table Permission<br>\r\nRead<br>\r\nWrite<br>\r\nSource Code DownLoad\r\n', 'main', 'main', 3, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (95, 'App Generator Tree Menu Make', 'bg_proj09.jpg', 'App Generator Tree Menu Make<br>\r\nTree Menu<br>\r\nPopUp Menu <br>\r\nSource Code DownLoad', 'main', 'main', 3, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (96, 'App Generator Note', 'bg_proj10.jpg', 'App Generator Note Tree<br>\r\nNote create<br>\r\nEncryption,\r\nDecryption', 'main', 'main', 2, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (97, 'App Generator Board', 'bg_proj11.jpg', 'App Generator Board<br>\r\nTree Board Make<br>\r\nGeneral<br>\r\nStandard<br>\r\nOne line board', 'main', 'main', 99, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (100, 'App Generator', '2_78281.jpg', 'App Generator<br>\r\nProgram Generator<br>\r\nSource Code DownLoad\r\n', 'main', 'main', 0, NULL, NULL, NULL, '2018-11-19 02:20:24', NULL, 'tkher', 3000)
        ";

        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
        } else {
            echo " - Create Success and Record Create  Success : $tab";
        }
    }
}

function Tkher_my_control($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."tkher_my_control (
        seqno int(11) auto_increment NOT NULL,
        userid varchar(50) NOT NULL,
        slide_time int(11) NOT NULL DEFAULT 3000,
        fld1 varchar(50) NOT NULL,
        fld2 varchar(50) NOT NULL,
        fld3 varchar(50) NOT NULL,
        fld4 varchar(50) NOT NULL,
        fld5 decimal(5,0) NOT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");

        $query = "
        INSERT INTO `".$t_head."tkher_my_control` (`seqno`, `userid`, `slide_time`, `fld1`, `fld2`, `fld3`, `fld4`, `fld5`) VALUES
        (1, 'tkher', 6000, '', '', '', '', 0)
        ";
        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
        } else {
            echo " - Create Success and Record Create  Success : $tab";
        }
    }
}

function Url_group($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."url_group (
        no int(10) auto_increment NOT NULL,
        g_name varchar(200) NOT NULL DEFAULT '',
        g_num varchar(50) DEFAULT NULL,
        g_class varchar(20) DEFAULT NULL,
        g_class_num int(11) DEFAULT NULL,
        user_id varchar(50) DEFAULT NULL,
        lev char(3) NOT NULL DEFAULT '7'
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Webeditor($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."webeditor (
        seq int(11) auto_increment NOT NULL,
        num varchar(50) NOT NULL,
        user varchar(50) DEFAULT 'solpakan',
        h_lev char(1) DEFAULT NULL,
        id varchar(50) DEFAULT NULL,
        title varchar(255) NOT NULL DEFAULT '',
        align varchar(255) DEFAULT NULL,
        content text DEFAULT NULL,
        reply text DEFAULT NULL,
        date timestamp NULL DEFAULT current_timestamp(),
        backgroundcolor varchar(7) DEFAULT NULL,
        backgroundimage varchar(100) DEFAULT NULL,
        diff char(1) DEFAULT NULL,
        book_name varchar(50) DEFAULT NULL,
        view_cnt int(13) DEFAULT NULL,
        up_file varchar(255) DEFAULT NULL,
        del char(1) DEFAULT '0'
        , primary key(seq) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Webeditor_comment($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."webeditor_comment (
        seq int(11) auto_increment NOT NULL,
        num varchar(50) NOT NULL,
        user varchar(50) DEFAULT NULL,
        h_lev char(1) DEFAULT NULL,
        doc_userid varchar(50) DEFAULT NULL,
        title varchar(255) DEFAULT NULL,
        align varchar(10) DEFAULT NULL,
        content text DEFAULT NULL,
        reply text DEFAULT NULL,
        date datetime DEFAULT current_timestamp(),
        backgroundcolor varchar(7) DEFAULT NULL,
        backgroundimage varchar(100) DEFAULT NULL,
        diff char(1) DEFAULT NULL,
        book_name varchar(50) DEFAULT NULL,
        view_cnt int(13) DEFAULT NULL,
        del char(1) DEFAULT '0'
        , primary key(seq) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Member($t_head, $tab) {
    $tab = $t_head.$tab;
    // 2024-03-26 mb_zip1 char(3) => char(10) 변경
    $SQL = "
        CREATE TABLE ".$t_head."member (
        mb_no int(11) auto_increment NOT NULL,
        mb_id varchar(50) NOT NULL,
        mb_sn varchar(255) DEFAULT NULL,
        mb_password varchar(255) DEFAULT NULL,
        mb_name varchar(255) DEFAULT NULL,
        mb_nick varchar(255) DEFAULT NULL,
        mb_nick_date date DEFAULT '0000-00-00',
        mb_email varchar(255) NOT NULL,
        mb_photo varchar(255) DEFAULT NULL,
        mb_homepage varchar(255) DEFAULT NULL,
        mb_level tinyint(4) DEFAULT 0,
        mb_sex char(1) DEFAULT NULL,
        mb_birth varchar(255) DEFAULT NULL,
        mb_tel varchar(255) DEFAULT NULL,
        mb_hp varchar(255) DEFAULT NULL,
        mb_certify varchar(20) DEFAULT NULL,
        mb_adult tinyint(4) NOT NULL DEFAULT 0,
        mb_dupinfo varchar(255) DEFAULT NULL,
        mb_zip1 char(10) DEFAULT NULL,
        mb_zip2 char(3) DEFAULT NULL,
        mb_addr1 varchar(255) DEFAULT NULL,
        mb_addr2 varchar(255) DEFAULT NULL,
        mb_addr3 varchar(255) DEFAULT NULL,
        mb_addr_jibeon varchar(255) DEFAULT NULL,
        mb_signature text DEFAULT NULL,
        mb_recommend varchar(255) DEFAULT NULL,
        mb_point int(11) DEFAULT 0,
        mb_today_login datetime DEFAULT '0000-00-00 00:00:00',
        mb_login_ip varchar(255) DEFAULT NULL,
        mb_datetime datetime DEFAULT current_timestamp(),
        mb_ip varchar(255) DEFAULT NULL,
        mb_leave_date varchar(8) DEFAULT NULL,
        mb_intercept_date varchar(8) DEFAULT NULL,
        mb_email_certify datetime DEFAULT '0000-00-00 00:00:00',
        mb_email_certify2 varchar(255) DEFAULT NULL,
        mb_memo text DEFAULT NULL,
        mb_lost_certify varchar(255) DEFAULT NULL,
        mb_mailling tinyint(4) DEFAULT 0,
        mb_sms tinyint(4) DEFAULT 0,
        mb_open tinyint(4) DEFAULT 0,
        mb_open_date date DEFAULT '0000-00-00',
        mb_profile text DEFAULT NULL,
        mb_memo_call varchar(255) DEFAULT NULL,
        PRIMARY KEY (mb_no),
        UNIQUE KEY mb_id (mb_id),
        KEY mb_today_login (mb_today_login),
        KEY mb_datetime (mb_datetime),
        KEY mb_email (mb_email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Log_info($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."log_info (
        no int(10) auto_increment NOT NULL,
        url varchar(255) DEFAULT NULL,
        name varchar(100) NOT NULL,
        id varchar(50) NOT NULL,
        uptime datetime NOT NULL DEFAULT current_timestamp(),
        ip varchar(20) DEFAULT NULL,
        msg text DEFAULT NULL,
        country_cd char(5) DEFAULT NULL,
        country_name char(50) DEFAULT NULL,
        type char(10) DEFAULT NULL,
        start_pg char(255) DEFAULT NULL,
        email varchar(255) DEFAULT NULL,
        PRIMARY KEY (no),
        KEY no (no)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Point($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."point (
        po_id int(11) auto_increment NOT NULL,
        mb_id varchar(50) NOT NULL,
        po_datetime datetime DEFAULT current_timestamp(),
        po_title varchar(100) DEFAULT NULL,
        po_content varchar(255) DEFAULT '',
        po_point int(11) DEFAULT 0,
        po_use_point int(11) DEFAULT 0,
        po_expired varchar(255) DEFAULT 0,
        po_expire_date datetime DEFAULT current_timestamp(),
        po_mb_point int(11) DEFAULT 0,
        po_rel_table varchar(255) DEFAULT NULL,
        po_rel_id varchar(50) DEFAULT NULL,
        po_rel_action varchar(255) DEFAULT NULL ,
        PRIMARY KEY (po_id),
        KEY index2 (po_expire_date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}


function Visit($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."visit (
        vi_id int(11) auto_increment NOT NULL,
        vi_ip varchar(255) NOT NULL DEFAULT '',
        vi_date date NOT NULL DEFAULT '0000-00-00',
        vi_time time NOT NULL DEFAULT '00:00:00',
        vi_referer text DEFAULT NULL,
        vi_agent varchar(255) DEFAULT NULL,
        vi_browser varchar(255) DEFAULT NULL,
        vi_os varchar(255) DEFAULT NULL,
        vi_device varchar(255) DEFAULT NULL,
        PRIMARY KEY (vi_id),
        UNIQUE KEY index1 (vi_ip,vi_date),
        KEY index2 (vi_date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Ap_bbs($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE `".$t_head."ap_bbs` (
        `seqno` bigint(20) NOT NULL AUTO_INCREMENT,
        `infor` bigint(20) NOT NULL,
        `email` varchar(100) DEFAULT NULL,
        `subject` varchar(60) NOT NULL,
        `content` text NOT NULL,
        `up_day` datetime DEFAULT current_timestamp(),
        `reg_date` int(11) DEFAULT NULL,
		`host` varchar(100) DEFAULT NULL,
        PRIMARY KEY (`seqno`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function E_list($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE `".$t_head."e_list` (
        `no` int(11) auto_increment NOT NULL,
        `e_yy` varchar(100) NOT NULL,
        `yy` varchar(100) NOT NULL,
        `mm` varchar(100) NOT NULL,
        `e_memo` varchar(255) NOT NULL,
        `indate` varchar(20) NOT NULL,
        primary key(no) 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Pri_contect($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
    CREATE TABLE `".$t_head."pri_contect` (
    `seqno` int(11) auto_increment NOT NULL,
    `custom` varchar(50) NOT NULL,
    `compno` varchar(15) NOT NULL,
    `up_name` varchar(30) NOT NULL,
    `postno` varchar(5) NOT NULL,
    `address1` varchar(255) NOT NULL,
    `address2` varchar(255) NOT NULL,
    `address3` varchar(255) NOT NULL,
    `tel` varchar(15) NOT NULL,
    `tel1` varchar(5) NOT NULL,
    `tel2` varchar(5) NOT NULL,
    `tel3` varchar(5) NOT NULL,
    `email` varchar(50) NOT NULL,
    `homep` varchar(100) NOT NULL,
    `gubun` varchar(200) NOT NULL,
    `jobgubun1` varchar(30) NOT NULL,
    `jobgubun2` varchar(30) NOT NULL,
    `jobgubun3` varchar(30) NOT NULL,
    `jobgubun4` varchar(30) NOT NULL,
    `memo` text NOT NULL,
    `day` datetime NOT NULL,
    `pass_check` varchar(10) NOT NULL,
    `cnt` int(12) NOT NULL,
    primary key(seqno) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");
        $query = "
        INSERT INTO `".$t_head."pri_contect` (`seqno`, `custom`, `compno`, `up_name`, `postno`, `address1`, `address2`, `address3`, `tel`, `tel1`, `tel2`, `tel3`, `email`, `homep`, `gubun`, `jobgubun1`, `jobgubun2`, `jobgubun3`, `jobgubun4`, `memo`, `day`, `pass_check`, `cnt`) VALUES
        (1, '(주)K-APP', '736-81-01709', 'sw개발', '49224', '부산 서구 구덕로186번길 13', '2층', ' (토성동3가)', '010-7542-8567', '010', '7542', '8567', 'solpakan@naver.com', 'https://fation.net', '', '', '', '', '', 'K-APP', '2025-03-26 13:15:00', '1111', 0)
        ";

        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
        } else {
            echo " - Create Success and Record Create  Success : $tab";
        }
    }
}

function Project($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
    CREATE TABLE `".$t_head."project` (
    `no` int(11) auto_increment NOT NULL,
    `wr_subject` varchar(200) DEFAULT NULL,
    `reguest` varchar(50) DEFAULT NULL,
    `wr_yesan` varchar(255) DEFAULT NULL,
    `wr_iljung` varchar(50) DEFAULT NULL,
    `wr_content` text DEFAULT NULL,
    `bf_file` varchar(255) DEFAULT NULL,
    `wr_name` varchar(30) DEFAULT NULL,
    `wr_tel` varchar(15) DEFAULT NULL,
    `wr_comp` varchar(30) DEFAULT NULL,
    `wr_bu` varchar(20) DEFAULT NULL,
    `wr_email` varchar(20) DEFAULT NULL,
    `wr_homepage` varchar(255) DEFAULT NULL,
    `day` varchar(20) DEFAULT NULL,
    `pass_check` varchar(10) NOT NULL,
    `gubun` varchar(10) NOT NULL,
    primary key(no) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Tkher_content($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
    CREATE TABLE `".$t_head."tkher_content` (
    `co_id` varchar(50) NOT NULL DEFAULT '',
    `co_html` tinyint(4) NOT NULL DEFAULT 0,
    `co_subject` varchar(255) NOT NULL DEFAULT '',
    `co_content` longtext NOT NULL,
    `co_mobile_content` longtext NOT NULL,
    `co_skin` varchar(255) NOT NULL DEFAULT '',
    `co_mobile_skin` varchar(255) NOT NULL DEFAULT '',
    `co_tag_filter_use` tinyint(4) NOT NULL DEFAULT 0,
    `co_hit` int(11) NOT NULL DEFAULT 0,
    `co_include_head` varchar(255) NOT NULL,
    `co_include_tail` varchar(255) NOT NULL,
    primary key(co_id) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Pri_maintenance($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
    CREATE TABLE `".$t_head."pri_maintenance` (
    `no` int(11) auto_increment NOT NULL,
    `num` int(11) DEFAULT NULL,
    `reply` varchar(10) DEFAULT NULL,
    `parent` int(11) DEFAULT NULL,
    `gubun` varchar(10) DEFAULT NULL,
    `jemok` varchar(50) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    `tel` varchar(15) DEFAULT NULL,
    `email` varchar(200) DEFAULT NULL,
    `homep` varchar(200) DEFAULT NULL,
    `day` varchar(50) DEFAULT NULL,
    `cnt` varchar(255) DEFAULT NULL,
    `jobgubun` int(1) DEFAULT NULL,
    `memo` text DEFAULT NULL,
    `customer_file` varchar(200) DEFAULT NULL,
    `pass_check` varchar(10) DEFAULT NULL,
    primary key(no) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}
	//--------------------------------------------------------------------------------------------
	function encryptA($_data, $_salt, $_iv) {
		$key = openssl_digest($_salt, 'sha256', true);
		$encrypt_jsonData = json_encode($_data);
		$encryptedData = openssl_encrypt($encrypt_jsonData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $_iv);
		return base64_encode($encryptedData);
	}

	//복호화 ---
	function decryptA($_encryptedData, $_salt , $_iv) {
		$key = openssl_digest($_salt, 'sha256', true);
		$decryptedData = openssl_decrypt(base64_decode($_encryptedData), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $_iv);
		$encrypted_jsonData = json_decode($decryptedData);
		return $encrypted_jsonData;
	}

//=================================================
?>
