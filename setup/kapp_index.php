<?php
	include "kapp_start.php";

	/*
       kapp_index.php : 2021-03-05

       - kapp_dbcon_create.php <- tkher_dbcon_create.php을 복사 : 여기서 작업 내용은 out 1,2,3 중요!
			out 1 : 'tkher_dbcon.php'       를 생성한다.
			    2 : 'tkher_dbcon_Table.php' 를 생성한다.
			    3 : 'urllink_member' Table and 'DB의 id, pw record'를 생성한다 중요!

	   program을 사용하기 위한 DB table Setup용.
	   include "urllink_db_lib.php" 는 start control file. tkher_db_lib.php(db lib 함수를 포함)를 copy 하여 생성함.
	           kapp_dblib_common.php <- kapp_dblib_common.php를 사용. - DB lib만 있음.
			   /t/include/lib/tkher_db_lib_common.php와 같음.
	*/
?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<TITLE>K-App Generator is generator program. Made in Korea</TITLE>
<link rel='shortcut icon' href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
<meta name='keywords' content='App Generator, app maker, app, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '>
<meta name='description' content='App Generator, app maker, app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '>
<meta name='robots' content='ALL'>
</head>
<?php
	$menu1TWPer=30;  // 15 -> 30
	$menu1AWPer=100 - $menu1TWPer;
	$menu2TWPer=10;
	$menu2AWPer=50 - $menu2TWPer;
	$menu3TWPer=10;
	$menu3AWPer=33.3 - $menu3TWPer;
	$menu4TWPer=10;
	$menu4AWPer=25 - $menu4TWPer;
	$Xwidth='100%';
	$Xheight='100%';
?>

<!-- <link rel="stylesheet" href="setup_kapp.css"> -->

<style>
body, td, TEXTAREA { font-size: 12pt}
INPUT, select { font-size: 12pt; height:21pt}
a 		{text-decoration:none; color:#000000; }
a:hover 	{text-decoration:underline; color:7B90FA; }

.en tr 		td.na		{ font-size: 12pt}
.en tr 		td.img		{ font-size: 12pt;}
.en tr 		td.img img	{ border:#7B90FA 1px solid;}
.en tr 		td		{ font-size: 12pt}

* {  box-sizing: border-box;}
.header2A {width:100%;  height:50px;  float: left;  border: 0px solid red;  padding: 0px;}
.menu1Area{width:100%;  height:60px;  float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}
.menu2T{padding-top:3px; width:25%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FAFAFA;}
.menu2A {width:25%; height:30px; float:left; padding:0px; border:0px solid #DEDEDE; background-color:#FAFAFA;}
.data2A {width:25%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FFFFFF;}
.input1A { padding:0px;}
.mainA {width:100%;  float: left; padding:15px; border:1px solid red;}
.menu1T {padding-top:0px; width:<?=$menu1TWPer?>%; height:30px; float:left; padding:6px; border:1px solid #DEDEDE;background-color:#FAFAFA;}
.menu1A {width:<?=$menu1AWPer?>%;  height:30px;  float: left;  padding: 0px;}
.data1A {width:<?=$menu1AWPer?>%; height:30px; float:left;padding:6px;border:1px solid #DEDEDE; background-color:#FFFFFF;}
radio1A {width:<?=$menu1AWPer?>%;  height:30px;  float: left;  padding: 6px;  border: 1px solid #DEDEDE;background-color:#FFFFFF;}
.ListBox1A {width: <?=$menu1AWPer?>%;  height:30px;  float: left;  padding: 2px;  border: 1px solid #DEDEDE; background-color:#FFFFFF;}
.File1A {  width: <?=$menu1AWPer?>%;  height:30px;  float: left;  padding: 2px;  border: 1px solid #DEDEDE;background-color:#FFFFFF;}
.menu4T {padding-top:3px; width:10%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE;background-color:#FAFAFA;}
.input4A {width:15%;  height:30px;  float:left;  padding:0px; border:1px solid #DEDEDE;  background-color:#FFFFFF;}
.menu4B {width: 15%; height:30px; float:left; padding:0px; border:0px solid #DEDEDE;  background-color:#FAFAFA;}
.data4A {width:15%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FFFFFF;}
.main4A {width:100%;  float: left;  padding: 15px;  border: 1px solid #DEDEDE;}
.blankA {border-top:0px;	width: 100%;    float: left;	height: 1px;	padding: 0px;	border: 1px solid #FFFFFF;background-color:#FFFFFF;}
.blankB {width:100%;  height: 1px;  padding: 1px;  float: left;  border: 1px solid #FFFFFF;  background-color:#FFFFFF;}
.viewSubjX{margin-top:1px;	width:100%;height:35px;	line-height:32px;border-top:3px solid #d01c27;	text-align:center;background:#fafafa;border-bottom:1px solid #dedede;overflow:hidden;font-size:18px;color:#69604f;}
.viewSubjX span{font-size:22px;color:#171512; vertical-align:baseline; }
.HeadTitle02AX{display:inline-block;	margin:0 1px;	height:35px;	line-height:35px;	padding:0 20px;	font-size:25px;	background:#d01c27;	color:#ffffff;	border-radius:5px;}
.HeadTitle01AX{display:inline-block;margin:0 1px;height:40px;line-height:0px;padding:0 20px;font-size:22px;background:#d01c27;color:#fff;border-radius:5px;}
.HeadTitle01AX a.on{background:#d01c27;color:#fff;}
.HeadTitle01A{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}
.HeadTitle02A a{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}
.HeadTitle01A a{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;	font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}
.HeadTitle01A a.on{background:#d01c27;color:#fff;}
.Btn_List01A{width:64px;height:33px;display:inline-block;line-height:33px;	text-align:center;color:#fff;font-size:14px;background:#d01d27;	margin-right: 10px;	}
.Btn_List02A{width:64px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}
.Btn_List03A{width:104px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}
.Btn_List04A{width:114px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}
.viewHeader{width:100%;height:auto;overflow:hidden;position:relative;text-align:right;}
.viewHeader span{position:absolute;left:0;top:12px;font-size:14px;color:#686868;}
.boardView{width:1168px;height:auto;overflow:hidden;margin:0 auto 50px auto;}
.boardViewX{width:99%;height:auto;overflow:hidden;margin:0 auto 50px auto;}
</style>

<style>
body {margin:0;padding:0;background-color:cyan;font-size:0.75em;font-family:dotum,helvetica}
input, img, select, button {font-size:1em;vertical-align:middle}
label {vertical-align:middle}
/* background:#383838;color:#a1a4a7; */
#set_topbar {margin:0 0 50px;padding:20px 30px;background:black;color:yellow;font-family:tahoma,helvetica;font-size:1.800em;zoom:1}
#set_topbar:after {display:block;visibility:hidden;clear:both;content:""}
#set_topbar #set_topimg {float:left}
#set_topbar #set_bartxt {float:right}

h1 {margin:0 0 30px;text-align:center}
/* background:#fff */
.setup_inner {margin:0 30px 50px;padding:20px 30px;border-right:1px solid #dde4e9;border-bottom:1px solid #dde4e9;background:#fff}
.setup_inner ul {margin:20px 0;padding:0 0 0 13px}
.setup_inner ol {margin:20px 0;padding:0 0 0 18px}
.setup_inner ol li {margin:0 0 5px}
.setup_inner p strong {color:red}
.setup_inner .setup_btn {margin:30px 0 0;text-align:right}
.setup_inner .setup_btn a, .setup_inner .setup_btn input {display:inline-block;padding:10px 20px;background:#ff347d;color:#fff;text-decoration:none}
.setup_inner .setup_btn input {border:0;cursor:pointer}

.ins_frm {margin:0 0 30px;width:100%;border:0;border-collapse:collapse}
.ins_frm caption {padding:10px 0;font-weight:bold;text-align:left}
.ins_frm th, .ins_frm td {padding:5px 3px;border-top:1px solid #dde4e9;border-bottom:1px solid #dde4e9}
.ins_frm th {width:25%;background:#f2f5f9}
.ins_frm td span {display:block;margin:5px 0 0;font-size:0.917em;letter-spacing:-0.1em}

#ins_ft {color:#a1a4a7;font-family:tahoma,helvetica;text-align:center}
#ins_ft strong {font-size:1.500em;font-weight:normal}

</style>

<script language='JavaScript'>

	function kapp_dbcon_create_func( $setup_mode ){
		if( $setup_mode == "Kapp_Setup"){
			document.form_view.mode.value	= 'Kapp_Setup';
		} else if( $setup_mode == "Kapp_ReSet" ){
			document.form_view.mode.value	= 'Kapp_ReSet';
		} else {
			return false;
		}
		if( !document.form_view.db_name.value ) {
			alert('Please check the DB Name.');
			document.form_view.db_name.focus();
			return false;
		} else if( !document.form_view.db_user.value ) {
			alert('Please check the DB User Name.');
			document.form_view.db_user.focus();
			return false;
		} else if( !document.form_view.db_password.value ) {
			alert('Please check the DB User Password.');
			document.form_view.db_password.focus();
			return false;
		} else if( !document.form_view.db_passwordB.value ) {
			alert('Please check Confirm Password.');
			document.form_view.db_passwordB.focus();
			return false;
		} else if( !document.form_view.admin_email.value ) {
			alert('Please check the Admin E-Mail.');
			document.form_view.admin_email.focus();
			return false;
		} else if( !document.form_view.admin_password.value ) {
			alert('Please check the Admin E-Mail.');
			document.form_view.admin_password.focus();
			return false;
		} else if( !document.form_view.admin_passwordB.value ) {
			alert('Please check the Admin E-Mail.');
			document.form_view.admin_passwordB.focus();
			return false;
		}
		if( document.form_view.db_password.value !== document.form_view.db_passwordB.value ){
			alert('Passwords do not match.');
			document.form_view.db_password.focus();
			return false;
		} else if( document.form_view.admin_password.value !== document.form_view.admin_passwordB.value ){
			alert('Admin Passwords do not match.');
			document.form_view.admin_password.focus();
			return false;
		} else {
			if( confirm("Are you want to K-APP Setup? ") ) {
				//document.form_view.mode.value	= 'urllink_kapp_dbcon_create_func';
				document.form_view.action		= 'kapp_dbcon_create.php';   // create table 'urllink_member' 생성 - 중요!
				document.form_view.submit();
			}
		}
		return false;
	}
	function home_func($pg_code){
		document.form_view.mode='home_func';
		document.form_view.action='kapp_index.php' ;
		document.form_view.submit();
	}

	function urllink_admin_login($pg_code ){

		/* if( !document.form_admin.admin_id.value ){
			alert('Please enter a id.');
			document.form_admin.admin_id.focus();
			return false;
		} else */
		if( !document.form_admin.admin_email.value  ){
			alert('Please enter a admin_email.');
			document.form_admin.admin_email.focus();
			return false;
		} else if( !document.form_admin.admin_pwA.value  ){
			alert('Please enter a password.');
			document.form_admin.admin_pwA.focus();
			return false;
		} else {
			document.form_admin.mode.value	= 'admin_login';
			document.form_admin.action		= 'kapp_index.php';
			document.form_admin.submit();
		}
	}
	function admin_reset($pg_code ){
		document.form_view.mode.value	= 'admin_reset';
		document.form_view.action		= 'kapp_index.php';
		document.form_view.submit();
	}
	function table_list(){
		document.form_view.mode.value	= 'list';
		document.form_view.admin.value	= 'modumoa';
		document.form_view.target		= '_blank';
		document.form_view.action		= './DB_Table_CreateA.php?admin=modumoa';   //'../DB_Table_Create.php';
		document.form_view.submit();
	}
 </script>
  <body width=100%>

<div id="set_topbar">
    <span id="bar_img">K-APP <img src="<?=KAPP_URL_T_?>/logo/logo.png" title='K-App - home'></span>
    <span id="set_bartxt"><a href="<?=KAPP_URL_T_?>/setup/index.php"><font color='yellow'>SETUP</font></a></span>
</div>

    <center>

<div class="setup_inner">

<?php
	$mode		= $_POST['mode'];
	$connect_dbcheck = '';

	$kapp_dbcon_passfile = KAPP_PATH_T_ . "/data/kapp_dbcon.php"; // tkher_dbcon.php : kapp_dbcon_create.php에서 생성.
	if( file_exists( $kapp_dbcon_passfile ) ) {  
		include_once( $kapp_dbcon_passfile );
	}
	//include_once( $kapp_dbcon_passfile );

	if( isset($_POST['email']) ) $email = $_POST['email'];
	else $email = "";
	

if( $_POST['mode'] == "Kapp_Setup" ) {	//m_(" mode ------ admin_pwA "); 	//m_("kapp_index mode: " . $_POST['mode']);

	define('KAPP_MYSQL_HOST', 'localhost');
	define('KAPP_MYSQL_DB', '');
	define('KAPP_MYSQL_USER', '');
	define('KAPP_TABLE_PREFIX', 'kapp_');
	$_SESSION['table_prefix'] = KAPP_TABLE_PREFIX;

	db_create_screen('Kapp_Setup');

} else if( $_POST['mode'] =='Kapp_ReSet' ){

		db_create_screen('Kapp_ReSet');
/* 사용하지 않는다.
} else if( $_POST['mode'] == 'db_recreate' ) { // X

		if( !func_login_check( $_POST['admin_email'], $_POST['admin_pwA'] ) ) {
			echo "<script>alert('Admin Login Error mode:db_recreate : urllink_member '); </script>";
			$rungo = "kapp_index.php";
			echo "<script>window.open('$rungo','_top',''); </script>";
			exit;
		} else {
			echo "Login Error! password_reset_screen<br>";
			password_reset_screen();
		}
} else if( $_POST['mode'] =='admin_login' ) { // X
		if( !func_login_check( $_POST['admin_email'], $_POST['admin_pwA'] ) ) {
			echo "<script>alert('Admin Login Error mode:admin_login : urllink_member '); </script>";
			Admin_Login_for_Reset();

		} else {
			echo "Admin Login OK! DB reset_screen<br>";
			password_reset_screen();
		}
*/
} else { //
	m_("kapp_index - Error mode ");
	echo "<p>kapp_index Error mode:$mode</p>";
	$rungo = "./index.php";
	echo "<script>window.open('".$rungo."','_TOP',''); </script>";
}

//----------------------------------------------------------------------------
function db_create_screen( $setup_type ){ // 'kapp_dbcon.php' 없어서 이것을 생성해야 하는 처음 실행 루틴.
		global $Xwidth, $Xheight, $email;

		if( $setup_type == "Kapp_Setup" ){
			$setup_tit = "K-APP Setup";
		} else if( $setup_type == "Kapp_ReSet" ){
			$setup_tit = "K-APP ReSet";
			$_SESSION['table_prefix'] = KAPP_TABLE_PREFIX;
		} else {
			m_("setup mode error!");
			exit;
		}

	echo "
	<div class='HeadTitle01AX'>
		<P class='on' title=' kapp_dbcon.php - file Create Page'><b> $setup_tit Manager</b></P>
	</div>   <br><br>

		<form name='form_view' method='post' enctype='multipart/form-data' >
				<input type='hidden' name='mode' value='' />
				<input type='hidden' name='admin' value='' />
	<div>

		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
		<div class='viewSubjX'>
			<span title='(ailinkapp)'><b>DB Setup Information</b></span>
		</div>

		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>*Host Name</b></span></div>
		<div class='menu1A'><input type='text' name='db_host' value='".KAPP_MYSQL_HOST."' title='it is standard - db_host' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Host Name'></div>
		<div class='blankA'> </div>
		<div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>DB Name</b></span></div>
		<div class='menu1A'><input type='text' name='db_name' value='".KAPP_MYSQL_DB."' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB Name'></div>
		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>DB User ID</b></span></div>
		<div class='menu1A'><input type='text' name='db_user' value='".KAPP_MYSQL_USER."' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User ID'></div>
		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>DB User Password</b></span></div>
		<div class='menu1A'><input type=password name='db_password' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User Password'></div>

		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>Confirm DB Password</b></span></div>
		<div class='menu1A'><input type=password name='db_passwordB' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User Password'></div>

		<div class='blankA'> </div>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

		<div class='blankA'> </div>
		<div class='viewSubjX'>
			<span title='User Admin (urllink_member)'><b>Admin Information</b></span>
		</div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>Admin E-Mail</span></div>
		<div class='menu1A'><input type='text' name='admin_email' value='".$email."' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Admin Email'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>Admin Password</span></div>
		<div class='menu1A'><input type='password' name='admin_password' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Admin Password'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>Confirm Admin Password</span></div>
		<div class='menu1A'><input type='password' name='admin_passwordB' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Admin Password'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>File Prefix </span></div>
		<div class='menu1A'><input type='text' name='table_prefix' value='".KAPP_TABLE_PREFIX."' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a File Prefix' title='session:".$_SESSION['table_prefix'].", Changes are possible, but it is recommended to use it as is.'></div><!-- 변경이 가능 하지만 그대로 상용하기를 권장함. -->
		";

if( $setup_type == "Kapp_Setup"){
	echo "
		<div class='blankA'> </div>
		<input type='button' value='Setup Start' onclick=\"javascript:kapp_dbcon_create_func('Kapp_Setup');\" class='HeadTitle01AX' title='New kapp_dbcon_create_func'>
	";
} else if($setup_type == "Kapp_ReSet") {
	echo "
		<div class='blankA'> </div>
		<input type='button' value='K-APP Data Clear and Setup Start' onclick=\"javascript:kapp_dbcon_create_func('Kapp_ReSet');\" class='HeadTitle01AX' title='New kapp_dbcon_create_func'>
		<br><br>

		<input type='button' value='DB List' onclick=\"javascript:table_list();\" class='HeadTitle01AX' title=' Table Create List '>

		<!-- <p> Click Here -> <a onclick='table_list()' target='_blank' title='Table Create List session prefix:".$_SESSION['table_prefix']."' style='font-size:24px'><b>DB Create List View</b></a></p> -->
	";
} else {
	m_("ERROR - Approach miss");
}

echo "
		<!-- <p> DB Create List :<button onclick='table_list()' target='_blank' title='Table Create List'>DB Create List View</button></p> -->
		<p> Files that need to be uploaded only once.</p>
		<p> 1. kapp_index.php, kapp_start.php, kapp_config.php, kapp_dblib_common.php</p>
		<p> 2. kapp_dbcon_create.php : Table urllink_member and kapp_dbcon.php create</p>
		<!--
		<p> 3.tkher_config_link.php</p>
		<p> 4.tkher_db_lib.php</p>
		<p> 5.table_paging.php</p>
		<p> 6.default.gif</p>
		<p> 7.logo25a.jpg</p> -->
	</div>

	</form>
	";
}
function Admin_Login_for_Reset(){ // 2024-01-04 사용하지 않는다.
		global $Xwidth, $Xheight;
	echo "
	<div class='HeadTitle01AX'>
		<P class='on' title='DB Manager Again Setup Page'><b>Admin Manager Login for Reset</b></P>
	</div>   <br><br>
		<form name='form_admin' method='post' enctype='multipart/form-data' >
			<input type='hidden' name='mode' value='' />

			<p>Admin Email:<input type='text' name='admin_email' value='' title='Admin User Email.' /></p>
			<p>Admin ID:<input type='text' name='admin_id' value='' title='AppGenerator manager Admin User Id.' /></p>
			<p>Admin PW:<input type='password' name='admin_pwA' value='' title='Admin Password.' /></p>

			 <input type='button' value='Login' onclick=\"javascript:urllink_admin_login('urllink_DB_Re_save');\" class='HeadTitle01AX' title='Login - DB set : db-name, db-user, db-password , urllink_member table create, tkher_dbcon.php code generation'>

			 <input type='button' value='Reset and Data Clear' onclick=\"javascript:urllink_admin_login('urllink_DB_Re_save');\" class='HeadTitle01AX' title='Re Setup - K-App Data Clear : db-name, db-user, db-password , urllink_member table re create, tkher_dbcon.php code generation'>

			<!-- <div class='HeadTitle01AX'>
				<P class='on' title='Table Create Table name: urllink_member'><a href=\"javascript:urllink_admin_login('urllink');\" style='color:cyan'>Confirm</a></P>
			</div> -->
		</form>
	";
}
function password_reset_screen(){ // 2024-01-04 사용하지 않는다.
		global $Xwidth, $Xheight;
		$hostnm = KAPP_MYSQL_HOST;
		$dbnm   = KAPP_MYSQL_DB;
		$usernm = KAPP_MYSQL_USER;
		$passwordnm = KAPP_MYSQL_PASSWORD;

		global $kapp_dbcon_passfile; // kapp_dbcon_passfile = KAPP_PATH_T_ . "/data/kapp_dbcon.php"

	$day = date("Y-m-d H:i:s" );
	$ip  = $_SERVER['REMOTE_ADDR'];

	echo "
	<div class='HeadTitle01AX'>
		<P class='on' title='Table Create:urllink_member, source code:tkher_dbcon.php'><a href=\"javascript:home_func('urllink_db');\" style='color:cyan'>DB Setup Management</a></P>
	</div>
		<form name='form_viewX' action='' method='post' enctype='multipart/form-data' >
			<input type='hidden' name='mode' value='' />
	<div class='boardViewX'>

		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

		<div class='viewSubjX'>
			<span title='(urllink_member)'><b>DB Setup Information</b></span>
		</div>

		<div class='blankA'> </div>
		<p><b>DB password ReSet</b></p>
		<p><b>Table urllink_member Update</b><p>
		<p><b>ReCreate Source : tkher_dbcon.php </b></p>

		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>*Host Name</span></div>
		<div class='menu1A'><input type='text' name='host_name' value='localhost' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Host Name'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>*DB Name</span></div>
		<div class='menu1A'><input type='text' name='db_name' value='$dbnm' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB Name'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>DB User ID</span></div>
		<div class='menu1A'><input type='text' name='db_id' value='$usernm' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User ID'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>DB User Password</span></div>
		<div class='menu1A'><input type='password' name='db_password' value='$passwordnm' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User Password'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>confirm Password</span></div>
		<div class='menu1A'><input type='password' name='db_passwordB' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User Password'></div>

		<div class='blankA'> </div>

		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

		<div class='blankA'> </div>
		<div class='viewSubjX'>
			<span title='User Admin (urllink_member)'>Admin Information</span>
		</div>
		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>Admin User ID</span></div>
		<div class='menu1A'><input type='text' name='db_id' value='$usernm' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User ID'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>Admin E-Mail</span></div>
		<div class='menu1A'><input type='text' name='email' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Admin Email'></div>

		<div class='blankA'> </div>
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'><b>Admin Password</span></div>
		<div class='menu1A'><input type='password' name='admin_password' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Admin Password'></div>

		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

		<input type='button' value='DB Reset Save' onclick=\"javascript:kapp_dbcon_create_func('urllink_DB_Re_save');\" class='HeadTitle01AX' title='Save DB Reset : db-name, db-user, db-password , urllink_member table create, tkher_dbcon.php code generation'></p>



<!--
		<p>Files that need to be uploaded only once.</p>
		<p> 1. kapp_index.php : Setup start file</p>
		<p> 2. kapp_dbcon_create.php : Table urllink_member and 'tkher_dbcon.php' Create</p>
	---
		<p> 3.tkher_config_link.php</p>
		<p> 4.tkher_db_lib.php</p>
		<p> 5.table_paging.php</p>
		<p> 6.default.gif</p>
		<p> 7.logo25a.jpg</p>
	-->
		</div>
	</form>
	";
}

// ---------- No Use -----------------
function func_login_check($email, $pw){ // admin login check   // 2024-01-04 사용하지 않는다.
	global $kapp_dbcon_passfile; // kapp_dbcon_passfile -> KAPP_PATH_T_ . "/data/kapp_dbcon.php"
	global $tkher;
	//m_("func_login_check -------- ");
	if ( file_exists( $kapp_dbcon_passfile ) ) {  //KAPP_PATH_T_ . "/data/kapp_dbcon.php"

		include_once( $kapp_dbcon_passfile );
		$_fileLIB = KAPP_PATH_T_ . "/setup/kapp_dblib_common.php"; // KAPP_PATH_T_ . "/setup/kapp_dblib_common.php"

		if ( file_exists($_fileLIB) ) {
			include_once( $_fileLIB );    // 공통 라이브러리
			$connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
			$select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');
			$tkher['connect_db'] = $connect_db;
			sql_set_charset('utf8', $connect_db);
			if(defined('KAPP_MYSQL_SET_MODE') && KAPP_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = '' ");
			if (defined(KAPP_TIMEZONE)) sql_query(" set time_zone = '".KAPP_TIMEZONE."'");
		}

		//$sql = "SELECT * from urllink_member where urllink_id='$email'";
		//$sql = "SELECT * from urllink_member where admin_email='$email'";
		$sql = "SELECT * from {kapp_DB} where admin_email='$email'";
		$rec = sql_fetch($sql);// 1 record 가져온다.
		//if( $rec['urllink_pw'] == md5($pw) ) {
		if( $rec['admin_pw'] == md5($pw) ) {
			echo "<script language='javascript'>alert('OK confirm!');</script>";
			return true;
		} else {
			echo "<script language='javascript'>alert('DB password:$pw, id:$email, Please confirm!');</script>";
			return false;
		}

	} else {
		echo "<script language='javascript'>alert('file:$kapp_dbcon_passfile no found!');</script>";
		return false;
	}
}

?>
</div>

<div id="ins_ft">
    <strong>K-APP</strong>
    <p>OPEN SOURCE K-APP Generator</p>
    <p>solpakan@naver.com : <a href='https://ailinkapp.com' target='_BLANK'>ailinkapp.com</a> </p>
</div>

			</body>
			</html>
