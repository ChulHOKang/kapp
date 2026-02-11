<?php 
	include "urllink_db_lib.php";  
	/*
       kapplink_index.php : 2026-01-20 <- urllink_index.php 2021-03-05 
	   - tkher_dbcon_create.php : tkher_dbcon.php source create
                                 : kapp_urllink_member Table create
	   program을 사용하기 위한 DB table Setup용.
	   include "urllink_db_lib.php" 는 함수 lib를 제거함. tkher_db_lib.php를 copy 새로 생성함. 함수 lib를 제거함.;  
	           tkher_pg_lib_common.php를 사용. - DB lib만 있음.
			   /include/lib/tkher_db_lib_common.php와 같음.
	*/
?> 
<html> 
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="./icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>
<?php                                 
	$menu1TWPer=15;  
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
<link rel="stylesheet" href="kapp_basic.css" type="text/css" />

<!-- <style>  
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
</style>   -->
 <script language='JavaScript'>   
	function db_recreate_action($pg_code ){   
		if( !document.form_view.db_name.value ) {
			alert('Please check the DB Name.');
			document.form_view.db_name.focus();
			return false;
		} else if( !document.form_view.db_id.value ) {
			alert('Please check the DB User Name.');
			document.form_view.db_id.focus();
			return false;
		} else if( !document.form_view.db_password.value ) {
			alert('Please check the DB User Password.');
			document.form_view.db_password.focus();
			return false;
		} else if( !document.form_view.db_passwordB.value ) {
			alert('Please check Confirm Password.');
			document.form_view.db_passwordB.focus();
			return false;
		}
		if(document.form_view.db_password.value !== document.form_view.db_passwordB.value ){
			alert('Passwords do not match.');
			document.form_view.db_password.focus();
			return false;
		} else {
			if( confirm("Are you want to DB Setup? ") ) {   
				document.form_view.mode.value	= 'urllink_db_recreate_action';   
				document.form_view.action		= 'tkher_dbcon_create.php';   
				document.form_view.submit();   
			}
		}
		return false;
	}   
	function home_func($pg_code){   
		form_view.mode='home_func';   
		form_view.action='kapplink_index.php' ;   
		form_view.submit();   
	}   

	function urllink_admin_login($pg_code ){   

		if( !document.form_admin.admin_id.value ){
			alert('Please enter a id.');
			document.form_admin.admin_id.focus();
			return false;
		} else if( !document.form_admin.admin_pwA.value  ){
			alert('Please enter a password.');
			document.form_admin.admin_pwA.focus();
			return false;
		} else {
			document.form_admin.mode.value	= 'admin_login';   
			document.form_admin.action		= 'kapplink_index.php';   
			document.form_admin.submit();   
		}
	}  
	function admin_reset($pg_code ){   
		document.form_view.mode.value	= 'admin_reset';   
		document.form_view.action		= 'kapplink_index.php';   
		document.form_view.submit();   
	}  
 </script>                                
  <body width=100%>
  
  <center>
  
<?php
	$mode		= $_POST['mode'];     
	$connect_dbcheck = '';            
	$dbconfig_file = "./tkher_dbcon.php"; //tkher_dbcon_create.php에서 생성.
	$hostB	= $_SERVER['HTTP_HOST'];

	if( !$mode && !$_POST['admin_pwA'] ) {
		if( file_exists( $dbconfig_file) ) {  
			include_once( $dbconfig_file );    
			$_fileLIB = "./tkher_pg_lib_common.php";
			if( file_exists($_fileLIB) ) {  
				include_once( $_fileLIB );
				$connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');       
				if( $select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) ){
					echo " db connect OK --- ";
				} else {
					echo "error db connect --- Reset Please!<br>";
					password_reset_screen();
				}
				$tkher['connect_db'] = $connect_db;       
				sql_set_charset('utf8', $connect_db);       
				if( defined('KAPP_MYSQL_SET_MODE') && KAPP_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = '' ");       
				$sql = "SHOW TABLES LIKE 'kapp_urllink_member' ";		
				$ret = sql_query($sql);						        
				$row = sql_fetch_array($ret);		                
				if( $row == true) {		
					echo "db_login_screen<br>";
					db_login_screen();
				} else {
					echo "db_create_screen<br>";
					db_create_screen();
				}
			} else {
					db_create_screen();
			}
		} else {
			echo "db_create_screen<br>";
			db_create_screen();
		}

	} else if( $_POST['mode'] =='admin_login' or $_POST['mode'] == 'db_recreate' ) {
		if( $_POST['mode'] =='admin_login'){
			if( !func_login_check( $_POST['admin_id'], $_POST['admin_pwA'] ) ) {
				$_SESSION['kapp_userid'] = '';
				echo "<script>alert('Login Error Table kapp_urllink_member '); </script>";  
				$rungo = "kapplink_index.php";
				echo "<script>window.open('$rungo','_top',''); </script>";
				exit;
			} else {
				$_SESSION['kapp_userid'] = $_POST['admin_id'];
				echo "password_reset_screen<br>";
				password_reset_screen();
			}
		}
	} else {
		echo "<p> Login Error mode:$mode</p>";
		$rungo = "kapplink_index.php";
		echo "<script>window.open('$rungo','_self',''); </script>";
	}

function db_create_screen(){
		global $Xwidth, $Xheight;
	echo "
	<div class='HeadTitle01AX'>   
		<P class='on' title=' 1 display - DB Manager Login Page'>AppGenerator DB Manager Login</P>   
	</div>   <br><br>

		<form name='form_view' method='post' enctype='multipart/form-data' >						
				<input type='hidden' name='mode' value='' />						
	<div>      
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>*Host Name</span></div>  
		<div class='menu1A'><input type='text' name='host_name' value='localhost' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Host Name'></div>  
		<div class='blankA'> </div>  
		<div>      
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>DB Name</span></div>  
		<div class='menu1A'><input type='text' name='db_name' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB Name'></div>  
		<div class='blankA'> </div>  
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>DB User ID</span></div>  
		<div class='menu1A'><input type='text' name='db_id' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User ID'></div>  
		<div class='blankA'> </div>  
		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>DB User Password</span></div>  
		<div class='menu1A'><input type=password name='db_password' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User Password'></div>  

		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>confirm Password</span></div>  
		<div class='menu1A'><input type=password name='db_passwordB' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User Password'></div>  

		<div class='blankA'> </div>  
		<input type='button' value='DB Set Save' onclick=\"javascript:db_recreate_action('urllink_DB_Re_save');\" class='HeadTitle01AX' title='New db_recreate_action'>      

		<p>Files that need to be uploaded only once.</p>      
		<p> 1.kapplink_index.php</p>      
		<p> 2.tkher_dbcon_create.php : Table kapp_urllink_member and tkher_dbcon.php create</p>      
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
function db_login_screen(){
		global $Xwidth, $Xheight;
	echo "
	<div class='HeadTitle01AX'>   
		<P class='on' title=' 1 display - DB Manager Login Page'>AppGenerator DB Manager Login</P>   
	</div>   <br><br>
		<form name='form_admin' method='post' enctype='multipart/form-data' >						
			<input type='hidden' name='mode' value='' />						
			<p>ID:<input type='text' name='admin_id' value='' title='AppGenerator manager DB User Id.' /></p>
			
			<p>PW:<input type='password' name='admin_pwA' value='' title='DB Password.' /></p>

			 <input type='button' value='Login' onclick=\"javascript:urllink_admin_login('urllink_DB_Re_save');\" class='HeadTitle01AX' title='Login - DB set : db-name, db-user, db-password , kapp_urllink_member table create, tkher_dbcon.php code generation'>      

			<!-- <div class='HeadTitle01AX'>   
				<P class='on' title='Table Create Table name: kapp_urllink_member'><a href=\"javascript:urllink_admin_login('urllink');\" style='color:cyan'>Confirm</a></P> 
			</div> -->
			

		</form>	
	";
}
function password_reset_screen(){
	global $Xwidth, $Xheight;
	$hostnm = KAPP_MYSQL_HOST;
	$dbnm   = KAPP_MYSQL_DB;
	$usernm = KAPP_MYSQL_USER;
	$passwordnm = KAPP_MYSQL_PASSWORD;
	global $dbconfig_file;

	$day = date("Y-m-d H:s:i" );
	$ip  = $_SERVER['REMOTE_ADDR'];
	echo "
	<div class='HeadTitle01AX'>   
		<P class='on' title='Table Create:kapp_urllink_member, source code:tkher_dbcon.php'><a href=\"javascript:home_func('urllink_db');\" style='color:cyan'>DB Setup Management</a></P>   
	</div>   
		<form name='form_view' action='' method='post' enctype='multipart/form-data' >						
			<input type='hidden' name='mode' value='' />															
	<div class='boardViewX'>   

		<div class='viewSubjX'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span title='(kapp_urllink_member)'>DB Setup</span> </div>   

		<div class='blankA'> </div>   
		<p>DB password ReSet</p>

		<br> Table kapp_urllink_member Update<br>
		 <div>      
			<p>ReCreate Source : tkher_dbcon.php </p>   
		 <div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>*Host Name</span></div>  
		 <div class='menu1A'><input type='text' name='host_name' value='localhost' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a Host Name'></div>  
		 <div class='blankA'> </div>  

		 <div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>*DB Name</span></div>  
		 <div class='menu1A'><input type='text' name='db_name' value='$dbnm' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB Name'></div>  
		 <div class='blankA'> </div>  
		 <div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>DB User ID</span></div>  
		 <div class='menu1A'><input type='text' name='db_id' value='$usernm' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User ID'></div>  
		 <div class='blankA'> </div>  
		 <div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>DB User Password</span></div>  

		 <div class='menu1A'><input type='password' name='db_password' value='$passwordnm' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User Password'></div>  
		 <div class='blankA'> </div>  

		<div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>confirm Password</span></div>  
		<div class='menu1A'><input type=password name='db_passwordB' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a DB User Password'></div>  


		 <input type='button' value='DB_ReSet Save' onclick=\"javascript:db_recreate_action('urllink_DB_Re_save');\" class='HeadTitle01AX' title='DB Reset : db-name, db-user, db-password , kapp_urllink_member table create, tkher_dbcon.php code generation'>      

		<p>Files that need to be uploaded only once.</p>      
		<p> 1.kapplink_index.php</p>      
		<p> 2.tkher_dbcon_create.php : Table kapp_urllink_member and tkher_dbcon.php create</p>      
		<!-- <p> 3.tkher_config_link.php</p>      
		<p> 4.tkher_db_lib.php</p>      
		<p> 5.table_paging.php</p>      
		<p> 6.default.gif</p>      
		<p> 7.logo25a.jpg</p>  -->     
		</div>      
	</form>    
	";
}

function func_login_check($id, $pw){
	global $dbconfig_file;
	global $tkher;
	if( file_exists( $dbconfig_file ) ) {  
		include_once( $dbconfig_file );  
		$_fileLIB = "./tkher_pg_lib_common.php";
		if ( file_exists($_fileLIB) ) {  
			include_once( $_fileLIB ); 
			$connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');       
			$select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');       
			$tkher['connect_db'] = $connect_db;       
			sql_set_charset('utf8', $connect_db);       
			if( defined('KAPP_MYSQL_SET_MODE') && KAPP_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = '' ");       
			//if( defined(KAPP_TIMEZONE)) sql_query(" set time_zone = '".KAPP_TIMEZONE."'");       
		}
		$sql = "select * from kapp_urllink_member where urllink_id='$id'";
		$rec = sql_fetch($sql);
		if( $rec['urllink_pw'] == md5($pw) ) {
			echo "<script language='javascript'>alert('OK confirm!');</script>";
			return true;
		} else {
			echo "<script language='javascript'>alert('DB password:$pw, id:$id, Please confirm!');</script>";
			return false;
		}

	} else {
		echo "<script language='javascript'>alert('file:$dbconfig_file no found!');</script>";
		return false;
	}
}

?>
			</body>    
			</html>