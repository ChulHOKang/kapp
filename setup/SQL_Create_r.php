<?php
	include "kapp_start.php";  
	include "./SQL_Create_jsonA.php";

	DB_Connect();

	if($_POST['mode'] === 't_create'){
		$table_name = json_decode($_POST['table_name'], true);
		$prefix = json_decode($_POST['prefix']);
		//$t_head = json_decode($_POST['t_head'], true);

		switch($table_name) {
			case 'aboard_admin':
				Aboard_admin($prefix, $table_name);
				break;
			case 'aboard_infor':
				Aboard_infor($prefix, $table_name);
				break;
			case 'aboard_memo':
				Aboard_memo($prefix, $table_name);
				break;
			case 'admin_bbs':
				Admin_bbs($prefix, $table_name);
				break;
			case 'bbs_history':
				Bbs_history($prefix, $table_name);
				break;
			case 'coin_view':
				Coin_view($prefix, $table_name);
				break;
			case 'ip_info':
				Ip_info($prefix, $table_name);
				break;
			case 'job_link_table':
				Job_link_table($prefix, $table_name);
				break;
			case 'visit_sum':
				Visit_sum($prefix, $table_name);
				break;
			case 'menuskin':
				Menuskin($prefix, $table_name);
				break;  
			case 'sajin_group':
				Sajin_group($prefix, $table_name);
				break;
			case 'sajin_jpg':
				Sajin_jpg($prefix, $table_name);
				break;
			case 'sys_menu_bom':
				Sys_menu_bom($prefix, $table_name);
				break;
			case 'table10':
				Table10($prefix, $table_name);
				break;
			case 'table10_group':
				Table10_group($prefix, $table_name);
				break;
			case 'table10_pg':
				Table10_pg($prefix, $table_name);
				break;
			case 'tkher_main_img':
				Tkher_main_img($prefix, $table_name);
				break;
			case 'tkher_my_control':
				Tkher_my_control($prefix, $table_name);
				break;
			case 'url_group':
				Url_group($prefix, $table_name);
				break;
			case 'webeditor':
				Webeditor($prefix, $table_name);
				break;
			case 'webeditor_comment':
				Webeditor_comment($prefix, $table_name);
				break; 
			case 'member':
				Member($prefix, $table_name);
				break;   
			case 'log_info':
				Log_info($prefix, $table_name);
				break;   
			case 'point':
				Point($prefix, $table_name);
				break;   
			case 'config':
				Config($prefix, $table_name);
				break;     
			case 'visit':
				Visit($prefix, $table_name);
				break; 
			case 'ap_bbs':
				Ap_bbs($prefix, $table_name);
				break; 
			case 'e_list':
				E_list($prefix, $table_name);
				break; 
			case 'pri_contect':
				Pri_contect($prefix, $table_name);
				break; 
			case 'project':
				Project($prefix, $table_name);
				break; 
			case 'tkher_content':
				Tkher_content($prefix, $table_name);
				break; 
			case 'pri_maintenance':
				Pri_maintenance($prefix, $table_name);
				break; 
			default:
				break;
		}

		/* if($table_name != '') { // switch 정상 실행
			print_r(json_encode("'".$table_name."' Table Create"));
			exit;
		} else {
			print_r(json_encode("table_no ERROR"));
			exit;
		} */
		
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