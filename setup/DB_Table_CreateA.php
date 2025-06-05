<?php
	include "kapp_start.php";  
	/*
		Run 1. Setup - 'DB List' Button click
		Run 2. Login - 'Kapp Table List' Button click 
       처음 셋업시에 -> kapp_dbcon_create.php 에서 테이블을 생성한다.  중요 2025-03-25
		
		DB_Table_CreateA.php : 테이블 생성 후 'Table List' 버턴을 클릭 하면 테이블 목록을 출력 한다. - SQL_Create_jsonA.php을 호출.
	*/

	$_SESSION['admin'] = "";
    if( isset($_POST['admin']) ) {
		$_SESSION['admin'] = $_POST['admin'];
	} else if( isset($_SESSION['ss_mb_level']) ){
		$_SESSION['mb_level'] = $_SESSION['ss_mb_level'];
		$_SESSION['admin'] = "modumoa";
	} else if( isset($_SESSION['mb_level']) ){
		if( $_SESSION['mb_level'] > 7 )	$_SESSION['admin'] = "modumoa";
	} else if( isset($_SESSION['ss_mb_level']) ) {
		if( $_SESSION['ss_mb_level'] > 7 ) $_SESSION['admin'] = "modumoa";
	}
	if( $_SESSION['admin'] !== "modumoa" ) {
		m_("aproche error!"); exit;
	}

	$url = 'DB_Table_CreateA.php?admin=modumoa'; // admin url $url = 'DB_Table_CreateA.php'; // default url
	
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode ='';
    if( isset($_POST['prefix']) ) {     //m_($_POST['prefix']);
        $prefix = $_POST['prefix'];
    } else if( isset($_SESSION['table_prefix']) ){
		$prefix = $_SESSION['table_prefix']; //'kapp_'; // default
	} else {
		$prefix = KAPP_TABLE_PREFIX; //"kapp_";
		$_SESSION['table_prefix'] = KAPP_TABLE_PREFIX;
		//m_( KAPP_TABLE_PREFIX. ", SS pre: " . $_SESSION['table_prefix'] .", mode: ". $mode . ", P admin: " .			$_POST['admin'] . ", R admin: " . $_REQUEST['admin'] );
	}
	//SS pre: kapp_, mode: list, P admin: modumoa, R admin: modumoa
	//SS pre: kapp_, mode: list, P admin: modumoa, R admin: modumoa
	//SS pre: kapp_, mode: , P admin: , R admin: 

	DB_Connect();

    if( $_SESSION['mb_level'] > 7 && $mode == 'create_all') {

        $uncreate_table_list = json_decode( getJsonText( $_POST['uncreate_table_list']), true); // 생성되지 않은 테이블 목록 //print_r($uncreate_table_list);
        Table_Create_All($prefix, $uncreate_table_list); // echo "<script>location.replace(location.href);</script>";
        Replace();
        exit;
    } else if( $_SESSION['mb_level'] > 7 && $mode == 're_create_all') {

        $create_table_list = json_decode(getJsonText($_POST['create_table_list']), true); // 생성된 테이블 목록      //print_r($create_table_list);
        Table_Re_Create_All($prefix, $create_table_list); // echo '<script>location.replace(location.href);</script>';
        Replace();
        exit;
    } else if( $_SESSION['mb_level'] > 7 && $mode == 'delete_all') {

		m_("Table Delet ALL --- ");
        //include_once('./SQL_Create_json.php'); // tkher_start_necessary와 같이 사용 불가능

        $create_table_list = json_decode(getJsonText($_POST['create_table_list']), true); // 생성된 테이블 목록   //print_r($create_table_list);
        foreach( $create_table_list as $table){   
			echo $_prefix.$table."<br/>";
            //if( $table !== "member" && $table !== "config" && $table !== "tkher_main_img" && $table !== "tkher_my_control")	
				Delete_table($prefix, $table); // 이미 생성된 테이블 삭제
        } //echo '<script>location.replace(location.href);</script>';
        Replace();
        exit;
    } else if( $_SESSION['mb_level'] > 7 ) {

        if( $_SESSION['mb_level'] < 7 && !isset($_POST['admin'])) { // index_reset
            m_("The wrong approach. - mb_level:".$_SESSION['mb_level']);
			exit;  //echo "<script>window.open( './index.php' , '_self');</script>";
        } else if( $_SESSION['mb_level'] < 7 && $_SESSION['admin'] == 'modumoa') {

            if( Check_admin_pass()) {
                $admin_pass = 'modumoa';
            } else {
                $prompt_msg = "Password : ";
                prompt($prompt_msg);

                $url = 'DB_Table_CreateA.php?admin=modumoa'; // admin url
                $admin_pass = 'modumoa';
            }

        }
    } else {
		m_("approche error KAPP DB Table List --- ");
		exit;
    }

	include "./SQL_Create_jsonA.php";

	//m_("table_nm: " . $_POST['table_nm']);
	if( $mode == "_delete_"){
		drop_kapp_( $_POST['prefix'] . $_POST['table_nm'] );
	}
	//--------------------------------------
	function drop_kapp_( $tab_ ){
		$query	="drop table " . $tab_;
		$mq2	=sql_query($query);
		if( $mq2 ) echo ", --- delete success : " . $tab_;
		else echo "<br> delete fail : " . $tab_;
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

    function prompt($prompt_msg){
        echo "<script type='text/javascript'> var answer = prompt('".$prompt_msg."'); 
        if( answer != 'modumoa') {
            alert('Invalid password.'); //잘못된 비밀번호입니다.
            window.open( './index.php' , '_self');
        }
        </script>";
    }

    function Check_admin_pass(){
        if( $_POST['admin_pass'] == 'modumoa') return true;
        else return false;
    }

    function Replace(){
        echo "<form name='replace_form' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='admin_pass' value='".$_POST['admin_pass']."'>
        </form>";
        echo '<script>
        document.replace_form.action = "DB_Table_CreateA.php";
        document.replace_form.submit();
        </script>';
    }

    function Table_Seatch($prefix, $_tab){
        $tab = $prefix.$_tab;
        $SQL = "show tables like '".$tab."' ";   
        $result = sql_query( $SQL );
        $row = sql_fetch_array($result);

        //print_r($row);
        if($row) {
            //m_("true");
            return true;
        } else {
            //echo "false : ".$SQL;
            return false;
        }
    }

    function getJsonText($jsontext) { // jsonText '\' 값 제거 
        return str_replace("\\\"", "\"", $jsontext);
    }

    function Table_Create_All($_prefix, $_table_list){
        foreach($_table_list as $table){
            //echo $_prefix.$table."<br/>";
            switch($table) {
                case 'aboard_admin':
                    Aboard_admin($_prefix, $table);
                    break;
                case 'aboard_infor':
                    Aboard_infor($_prefix, $table);
                    break;
                case 'aboard_memo':
                    Aboard_memo($_prefix, $table);
                    break;
                case 'admin_bbs':
                    Admin_bbs($_prefix, $table);
                    break;
                case 'bbs_history':
                    Bbs_history($_prefix, $table);
                    break;
                case 'coin_view':
                    Coin_view($_prefix, $table);
                    break;
                case 'ip_info':
                    Ip_info($_prefix, $table);
                    break;
                case 'visit_sum':
                    Visit_sum($_prefix, $table);
                    break;
                case 'menuskin':
                    Menuskin($_prefix, $table);
                    break;  
                case 'sajin_group':
                    Sajin_group($_prefix, $table);
                    break;
                case 'sajin_jpg':
                    Sajin_jpg($_prefix, $table);
                    break;
                
				case 'table10':
                    Table10($_prefix, $table);
                    break;
                case 'table10_pg':
                    Table10_pg($_prefix, $table);
                    break;
                case 'job_link_table':
                    Job_link_table($_prefix, $table);
                    break;
                case 'sys_menu_bom':
                    Sys_menu_bom($_prefix, $table);
                    break;

				case 'table10_group':
                    table10_group($_prefix, $table);
                    break;
                case 'tkher_main_img':
                    Tkher_main_img($_prefix, $table);
                    break;
                case 'tkher_my_control':
                    Tkher_my_control($_prefix, $table);
                    break;
                case 'url_group':
                    Url_group($_prefix, $table);
                    break;
                case 'webeditor':
                    Webeditor($_prefix, $table);
                    break;
                case 'webeditor_comment':
                    Webeditor_comment($_prefix, $table);
                    break; 
                case 'member':
                    Member($_prefix, $table);
                    break;     
                case 'log_info':
                    Log_info($_prefix, $table);
                    break;  
                case 'point':
                    Point($_prefix, $table);
                    break; 
                case 'config':
                    Config($_prefix, $table);
                    break; 
                case 'visit':
                    Visit($_prefix, $table);
                    break; 
                case 'ap_bbs':
                    Ap_bbs($_prefix, $table);
                    break; 
                case 'e_list':
                    E_list($_prefix, $table);
                    break; 
                case 'pri_contect':
                    Pri_contect($_prefix, $table);
                    break; 
                case 'project':
                    Project($_prefix, $table);
                    break; 
                case 'tkher_content':
                    Tkher_content($_prefix, $table);
                    break; 
                
                default:
                
                    break;
            }
        }
    }

    function Table_Re_Create_All($_prefix, $_table_list){
        foreach($_table_list as $table){
            //echo $_prefix.$table."<br/>";
            Delete_table($_prefix, $table); // 이미 생성된 테이블 삭제
        }
        All_Table_Create($_prefix);
    }

    function Delete_table($prefix, $tab) {
        $kapp_tab = $prefix.$tab;
        $SQL = " drop table ".$kapp_tab." ";
        $result = sql_query( $SQL );
        if( !$result ){
            echo json_encode("$tab Table Create Invalid query: " . $SQL);
            echo json_encode("Please check if the $tab table already exists.");
        } else {
            echo json_encode("Delete Success : $tab");
        }
    }

    function All_Table_Create($prefix){
        Aboard_admin($prefix, 'aboard_admin');
        Aboard_infor($prefix, 'aboard_infor');
        Aboard_memo($prefix, 'aboard_memo');
        Admin_bbs($prefix, 'admin_bbs');
        Ap_bbs($prefix, 'ap_bbs'); 
        Bbs_history($prefix, 'bbs_history');
        Coin_view($prefix, 'coin_view');
        Config($prefix, 'config');  
        E_list($prefix, 'e_list'); 
        Ip_info($prefix, 'ip_info');
        Log_info($prefix, 'log_info');   
        Member($prefix, 'member');  
        Menuskin($prefix, 'menuskin');  
        Point($prefix, 'point');      
        Pri_contect($prefix, 'pri_contect'); 
        Project($prefix, 'project'); 
        Sajin_group($prefix, 'sajin_group');
        Sajin_jpg($prefix, 'sajin_jpg');
        
		Table10($prefix, 'table10');
        Table10_pg($prefix, 'table10_pg');
        Job_link_table($prefix, 'job_link_table');
        Sys_menu_bom($prefix, 'sys_menu_bom');
//--------- add Curl Table 2025-03-25 --------
		Table10($prefix, 'table10_curl');
        Table10_pg($prefix, 'table10_pg_curl');
        Job_link_table($prefix, 'job_link_table_curl');
        Sys_menu_bom($prefix, 'sys_menu_bom_curl');
//------------------------ end
		table10_group($prefix, 'table10_group');
        Tkher_content($prefix, 'tkher_content'); 
        Tkher_main_img($prefix, 'tkher_main_img');
        Tkher_my_control($prefix, 'tkher_my_control');
        Url_group($prefix, 'url_group');
        Visit($prefix, 'visit'); 
        Visit_sum($prefix, 'visit_sum');
        Webeditor($prefix, 'webeditor');
        Webeditor_comment($prefix, 'webeditor_comment');  
    }

    /* function DelayTime($ms){ 
        $now = microtime();
        $finishtime = ($now + $ms);

        while($now < $finishtime){ 
            $now = time();
            if($now >= $finishtime){ break; }
        }
        return true;
    } */

    //Table_Seatch('aboard_admin');

    /* function Table_list_search(){ // DB 사용 시 실행되는 함수
        $SQL = "select k_table_name, k_table_link from ksd39673976_1711684888 order by k_table_name asc ";
        $result = sql_query( $SQL );

        while( $row = sql_fetch_array($result)  ) { 
            //print_r($row)."<br/>";
            $table_list_array[$row['k_table_name']] = array(
                "table_name" => $row['k_table_name'],
                "table_link" => $row['k_table_link']
            );
        }

        //print_r($table_list_array);
        return $table_list_array;
    } */

    function Table_list_create(){

        $table_list = array();
        
        $table_list['aboard_admin'] = array(
            "table_name" => "aboard_admin",
            "table_link" => "ksd39673976_1711519602_kapp_aboard_admin.php"
        );
        $table_list['aboard_infor'] = array(
            "table_name" => "aboard_infor",
            "table_link" => "../menu/board_list3.php"
        );
        $table_list['aboard_memo'] = array(
            "table_name" => "aboard_memo",
            "table_link" => ""
        );
        $table_list['admin_bbs'] = array(
            "table_name" => "admin_bbs",
            "table_link" => ""
        );
        $table_list['ap_bbs'] = array(
            "table_name" => "ap_bbs",
            "table_link" => ""
        );
        $table_list['bbs_history'] = array(
            "table_name" => "bbs_history",
            "table_link" => ""
        );
        $table_list['coin_view'] = array(
            "table_name" => "coin_view",
            "table_link" => ""
        );
        $table_list['config'] = array(
            "table_name" => "config",
            "table_link" => "ksd39673976_1711436495_kapp_config.php"
        );
        $table_list['e_list'] = array(
            "table_name" => "e_list",
            "table_link" => ""
        );
        $table_list['ip_info'] = array(
            "table_name" => "ip_info",
            "table_link" => ""
        );
        $table_list['log_info'] = array(
            "table_name" => "log_info",
            "table_link" => ""
        );
        $table_list['member'] = array(
            "table_name" => "member",
            "table_link" => "ksd39673976_1712020603_member_run.php"
        );
        $table_list['menuskin'] = array(
            "table_name" => "menuskin",
            "table_link" => ""
        );
        $table_list['point'] = array(
            "table_name" => "point",
            "table_link" => ""
        );
        $table_list['pri_contect'] = array(
            "table_name" => "pri_contect",
            "table_link" => "ksd39673976_1711673673_kapp_pri_contect.php"
        );
        $table_list['pri_maintenance'] = array(
            "table_name" => "pri_maintenance",
            "table_link" => ""
        );
        $table_list['project'] = array(
            "table_name" => "project",
            "table_link" => ""
        );
        $table_list['sajin_jpg'] = array(
            "table_name" => "sajin_jpg",
            "table_link" => ""
        );
        $table_list['sajin_group'] = array(
            "table_name" => "sajin_group",
            "table_link" => ""
        );

		$table_list['table10'] = array(
            "table_name" => "table10",
            "table_link" => ""
        );
        $table_list['table10_pg'] = array(
            "table_name" => "table10_pg",
            "table_link" => ""
        );
        $table_list['job_link_table'] = array(
            "table_name" => "job_link_table",
            "table_link" => ""
        );
        $table_list['sys_menu_bom'] = array(
            "table_name" => "sys_menu_bom",
            "table_link" => ""
        );
//------- add CURL Table 2025-03-25 ---------        
		$table_list['table10_curl'] = array(
            "table_name" => "table10_curl",
            "table_link" => "link_php_file_none"
        );
        $table_list['table10_pg_curl'] = array(
            "table_name" => "table10_pg_curl",
            "table_link" => "link_php_file_none"
        );
        $table_list['job_link_table_curl'] = array(
            "table_name" => "job_link_table_curl",
            "table_link" => "link_php_file_none"
        );
        $table_list['sys_menu_bom_curl'] = array(
            "table_name" => "sys_menu_bom_curl",
            "table_link" => "link_php_file_none"
        );
//---------------------------------------------
		$table_list['table10_group'] = array(
            "table_name" => "table10_group",
            "table_link" => ""
        );
        $table_list['tkher_content'] = array(
            "table_name" => "tkher_content",
            "table_link" => ""
        );
        $table_list['tkher_main_img'] = array(
            "table_name" => "tkher_main_img",
            "table_link" => ""
        );
        $table_list['tkher_my_control'] = array(
            "table_name" => "tkher_my_control",
            "table_link" => "ksd39673976_1711520865_kapp_tkher_my_control.php"
        );
        $table_list['url_group'] = array(
            "table_name" => "url_group",
            "table_link" => ""
        );
        $table_list['visit'] = array(
            "table_name" => "visit",
            "table_link" => ""
        );
        $table_list['visit_sum'] = array(
            "table_name" => "visit_sum",
            "table_link" => ""
        );
        $table_list['webeditor'] = array(
            "table_name" => "webeditor",
            "table_link" => ""
        );
        $table_list['webeditor_comment'] = array(
            "table_name" => "webeditor_comment",
            "table_link" => ""
        );

        return $table_list;
        
    }


?>

<html>

<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>DB Table Create</TITLE>
    <link rel="shortcut icon" href="../icon/logo25a.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="keywords"
        content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
    <meta name="description"
        content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
    <meta name="robots" content="ALL">
    <style>
    table {
        border-collapse: collapse;
    }

    th {
        background: #cdefff;
        height: 27px;
    }

    th,
    td {
        border: 1px solid silver;
        padding: 5px;
        height: 24px;
    }

    .div-left {
        float: left;
        width: 15%;
    }

    .div-right {
        float: right;
        width: 85%;
        margin-bottom: 20px;
    }

    span {
        font-size: 16px;
        font-weight: bold;
    }

    .a_link {
        /* font-size: 16px; */
        font-weight: bold;
    }

    .div_tab {
        float: left;
        width: 12%;
        height: 20px;
    }

    .div_tab2 {
        float: left;
        width: 280px;
        height: 20px;
    }
    </style>

    <link rel="stylesheet" href="../include/css/admin.css" type="text/css" />
    <script src="//code.jquery.com/jquery.min.js"></script>

</head>

<BODY>
    <br />
    <h2 title='pg:program_list3' style="text-align:center">K-APP System Table Create</h2>
    <br />
    <div class="div-left"></div>
    <div class="div-right">

        <br>
        <div>
            <form name='t_form' method='post' enctype='multipart/form-data'>
                <div class="div_tab"><span>table prefix</span></div><!-- 테이블 접두사 -->
                <div class="div_tab" style="width:200px"><input onclick="Edit_prefix('<?=$prefix?>')" id="prefix"
                        name="prefix" type="text" value="<?=$prefix?>" readonly title="수정가능 prefix:<?=	$_SESSION['table_prefix']?>"></div>
                <!-- <div class="div_tab" style="width:200px"><span>ex. <?=$prefix?>aboard_admin</span></div> -->
                <!-- <div class="div_tab" style="text-align:center;"><input type="button" onclick="Create_Table_All()"
                        value="Batch creation"></div> --><!-- 일괄 생성 -->
                <!-- <div class="div_tab" style="text-align:center;"><input type="button" onclick="Re_Create_Table_All()"
                        value="Batch regeneration"></div> --><!-- 일괄 재생성 -->
                <div class="div_tab" style="text-align:center;"><input type="button" style='background-color:red;color:yellow;' onclick="Delete_Table_All()"
                        value="Delete All Table" title='Data and Table Delete All - Requires a fresh install '></div><!-- 일괄 삭제 -->

                <input type="hidden" name="mode" value="">
                <input type="hidden" name="admin" value="<?=$_SESSION['admin']?>">
                <input type="hidden" name="create_table_list" value="">
                <input type="hidden" name="uncreate_table_list" value="">
                <input type="hidden" name="admin_pass" value="<?=$admin_pass?>">
                <!-- <div class="div_tab" style="text-align:center;"></div> -->
                <!-- <div class="div_tab" style="text-align:center;"><input type="button" onclick="Table_Add()"
                        value="테이블 추가"></div> -->
        </div>
        <br>
        <br>
        <br>

        <?php

        //$db = false;
        //if($db) $table_list = Table_list_search(); // 테이블 리스트 조회
        
		$table_list = Table_list_create(); // DB 사용하지 않음		//$table_list = Table_list_search(); // 테이블 리스트 조회
        
        $create_table_list_array = array();
        $uncreate_table_list_array = array();
        $cnt=1;

	foreach( $table_list as $table ) { 
        $state = 'not created'; // 미생성
        $t_check = '';
        $t_create_btn = '';
        $t_re_create_btn = 'disabled';
        $t_delete_btn = 'disabled';
        $href = '';

		$back_ground_color = 'style="background-color:#fff0;"';
		$back_ground_colorL = 'style="background-color:#fff0;"';
        if( $table['table_link'] != '') {
			$href = 'a href = ./'. $table['table_link']; //$href = 'a href = ../'. $table['table_link'];
			$back_ground_colorL = 'style="background-color:yellow;"';
		}

        
        $is_table = Table_Seatch( $prefix, $table['table_name']); // 테이블 유무 조회

        if( $is_table) {
            $state = 'Created - ' . $cnt++; //생성완료
            $t_check = 'checked';
            $t_create_btn = 'disabled';

            if( $table['table_name'] !== "member" && $table['table_name'] !== "config" && $table['table_name'] !== "tkher_main_img" && $table['table_name'] !== "tkher_my_control"  && $table['table_name'] !== "table10_curl" && $table['table_name'] !== "table10_pg_curl" && $table['table_name'] !== "job_link_table_curl" && $table['table_name'] !== "sys_menu_bom_curl" && $table['table_name'] !== "aboard_infor") {
				$t_re_create_btn = '';
				$t_delete_btn = '';
				$sys_file = ' - ';
			} else {
				$sys_file = ' system file ';
			}
            $back_ground_color = '';
            array_push( $create_table_list_array, $table['table_name']);
        } else {
            array_push( $uncreate_table_list_array, $table['table_name']);
			$back_ground_colorL = 'style="background-color:cyan;"';
        }
?>
        <div>
            <div class="div_tab" <?=$back_ground_color?>><span><?=$state?></span></div>
            <div class="div_tab2" <?=$back_ground_colorL?>><a class="a_link" style="font-size: 16px;"
                    <?=$href?> title="hr:<?=$href?>" target='_blank'><?=$prefix.$table['table_name']?></a></div>
            <div class="div_tab"><input type="checkbox" <?=$t_check?> disabled></div>
            <div class="div_tab"><button onclick="Create_Table('<?=$table['table_name']?>')"
                    <?=$t_create_btn?>>Create</button></div><!-- 생성 -->
            <div class="div_tab"><button onclick="Create_Table_RE('<?=$table['table_name']?>')"
                    <?=$t_re_create_btn?>>Regenerate</button></div><!-- 재생성 -->
            <div class="div_tab"><button title='<?=$sys_file?>:<?=$table['table_name']?>' onclick="Delete_Table('<?=$table['table_name']?>')"
                    <?=$t_delete_btn?>>Delete</button></div><!-- 삭제 -->
        </div>
        <br><br>
        <?php
    }

    $create_table_list_array = json_encode($create_table_list_array);
    $uncreate_table_list_array = json_encode($uncreate_table_list_array);
?>

    </div>

           <input type="hidden" name="table_list" value="<?=$table_list?>">
           <input type="hidden" name="table_nm"   value="">
           <input type="hidden" name="table_name" value="">
	</form>
</BODY>
<script>
function Create_Table(_table_name) {
	alert("_table_name: "+_table_name);
    $.ajax({
        type: "post",
        dataType: "json",
        data: {
            "mode": 't_create',
            "table_name": JSON.stringify(_table_name),
            "prefix": JSON.stringify($("#prefix").val())
        },
        url: "SQL_Create_r.php",
        success: function(data) {
            //console.log(data);
            alert(data);
            //location.replace(location.href);
            T_form_submit($("#prefix").val());
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //alert("The data type or URL is incorrect.-- SQL_Create_r.phpe"); //데이터 타입, 또는 URL이 올바르지 않습니다.
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
                T_form_submit($("#prefix").val());
            return;
        }
    });
}

function Create_Table_RE(_table_name) {
    if (confirm("기존 데이터가 전부 삭제됩니다. 테이블을 재생성하시겠습니까?")) {
        $.ajax({
            type: "post",
            dataType: "json",
            data: {
                "mode": 't_delete',
                "table_name": JSON.stringify(_table_name),
                "prefix": JSON.stringify($("#prefix").val())
            },
            url: "./SQL_Delete_r.php",
            success: function(data) {
                //console.log(data);
                /* alert(data);
                location.replace(location.href); */
                Create_Table(_table_name);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("The data type or URL is incorrect.-- SQL_Delete_r.phpe");
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                return;
            }
        });
    }
}

function Delete_Table(_table_name) {
	alert("Del _table_name: " + _table_name + ", pref: " +JSON.stringify($("#prefix").val())); // 기존 데이터가 전부 삭제됩니다. 테이블을 삭제하시겠습니까?
    if( confirm("All existing data will be deleted. Are you sure you want to delete the table? table: "+_table_name)) {
        $.ajax({
            type: "post",
            dataType: "json",
            data: {
                "mode": 't_delete',
                "table_name": JSON.stringify(_table_name),
                "prefix": JSON.stringify($("#prefix").val())
            },
            url: "SQL_Delete_r.php",
            success: function(data) {
                console.log(data);
                //alert(data);
                //location.replace(location.href);
                T_form_submit($("#prefix").val());
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //alert("The data type or URL is incorrect.-- SQL_Delete_r.phpe");
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                T_form_submit($("#prefix").val());
                return;
            }
        });
    }
}

function Edit_prefix(_prefix) {
    let prefix = prompt("Enter table name:", _prefix);
    //console.log("1");
    /* if (prefix != null && prefix != "") {
        document.t_form.prefix.value = prefix;
        document.t_form.action = 'DB_Table_CreateA.php';
        document.t_form.submit();
    } */

    T_form_submit(prefix);
}

function T_form_submit(_prefix) {
	//alert("--- mode: "+document.t_form.mode.value);
    document.t_form.prefix.value = _prefix;
    document.t_form.action = '<?=$url?>';
    document.t_form.submit();
}

function Delete_Table_func(_table_name) {
	alert("Del _table_name: " + _table_name + ", pref: " +JSON.stringify($("#prefix").val())); // 기존 데이터가 전부 삭제됩니다. 테이블을 삭제하시겠습니까?
    document.t_form.mode.value = "_delete_";
//    document.t_form.prefix.value = JSON.stringify($("#prefix").val()); //_prefix;
    document.t_form.table_nm.value = _table_name;
    document.t_form.action = '<?=$url?>';
    document.t_form.submit();
}

function Create_Table_All() {
    let uncreate_table_list_array = '<?=$uncreate_table_list_array?>'; // 미생성 테이블 목록

    document.t_form.mode.value = 'create_all';
    document.t_form.uncreate_table_list.value = uncreate_table_list_array;
    T_form_submit($("#prefix").val());
}

function Re_Create_Table_All() {
    let create_table_list_array = '<?=$create_table_list_array?>'; // 생성 테이블 목록

    document.t_form.mode.value = 're_create_all';
    document.t_form.create_table_list.value = create_table_list_array;
    T_form_submit($("#prefix").val());
}

function Delete_Table_All() {
    if( confirm("All existing data will be deleted. Are you sure you want to delete All Table?" )) {
		let create_table_list_array = '<?=$create_table_list_array?>'; // 생성 테이블 목록
		document.t_form.mode.value = 'delete_all';
		document.t_form.create_table_list.value = create_table_list_array;
		T_form_submit($("#prefix").val());
	} else alert("cancle --- ");
}

function Table_Add() {
    document.t_form.action = 'ksd39673976_1711684888_table_add.php';
    document.t_form.submit();
}
</script>

</HTML>