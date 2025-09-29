<?php
@header('Content-Type: text/html; charset=utf-8');
@header('X-Robots-Tag: noindex');

include './kapp_start.php';
$title = KAPP_VERSION_." - System Setup";
$reset = true;
include './setup.inc.php';

function admin_check(){
	global $tkher;      
	global $SQL;

	$kapp_dbcon_connect		= KAPP_PATH_T_ . "/data/kapp_dbcon.php";
	if( file_exists( $kapp_dbcon_connect ) ) {  
		include_once( $kapp_dbcon_connect );
	} else {
		m_("Reset Error - No found file: " . $kapp_dbcon_connect);
		exit;
	}
	$kapp_dblib_common = KAPP_PATH_T_ . "/setup/kapp_dblib_common.php";
	if( file_exists($kapp_dblib_common) ) { 
		include_once( $kapp_dblib_common );
	} else {
		m_( $kapp_dblib_common . " - file no found! Reset Error!"); 
		exit;
	}
	$connect_db = sql_connect( KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD, KAPP_MYSQL_DB) or die('MySQL Connect Error!!! <br>- Confirm DB password! and DB-NAME , pw:' . KAPP_MYSQL_PASSWORD . ', db:' . KAPP_MYSQL_DB . ', user:' . KAPP_MYSQL_USER .
    '<br> -> Delete the "/data/kapp_dbcon.php" file and run setup again! ');   
	$select_db  = sql_select_db( KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error! <br>- Confirm DB password! and DB-NAME, pw:' . KAPP_MYSQL_PASSWORD . ', db:' . KAPP_MYSQL_DB . ', user:' . KAPP_MYSQL_USER.
    '<br> -> Delete the "/data/kapp_dbcon.php" file and run setup again! ');
	$tkher['connect_db'] = $connect_db;       
	sql_set_charset('utf8', $connect_db);       

	$email = $_POST['email'];
	$admin_password = $_POST['passwd'];
	$row = sql_fetch(" select password('$admin_password') as pass ");
	$passwd = $row['pass'];

	$SQL = "SELECT * from {$tkher['tkher_member_table']} where mb_email='$email'";
	$result = sql_query( $SQL );
	$row = sql_fetch_array( $result );
	if( $row['mb_password'] == $passwd ){
		$_SESSION['mb_level'] = $row['mb_level'];
		return true;
	} else return false;
}
$SQL="";
if( !admin_check() ) {
	m_(" admin fail.");
	echo "<script>window.open( './index.php', '_TOP', ''); </script>";
	exit;
}

if( $reset && $exists_data_dir && $write_data_dir) {
?>
<form name='form_view' method="post" >
<input type='hidden' name='mode' value=''>
<input type='hidden' name='admin' value='modumoa'>
</form>

<form action="./kapp_index.php" method="post" onsubmit="return frm_submit(this);">
<input type='hidden' name='mode' value='Kapp_ReSet'>
<input type='hidden' name='email' value='<?=$_POST['email']?>'>

<div class="setup_inner">
    <p>
        <strong class="st_strong">Be sure to check the license details.</strong><br>
        Installation will only proceed if you agree to the license.
    </p>

    <div class="ins_ta ins_license">
        <textarea name="textarea" id="ins_license" readonly><?php echo implode('', file('./LICENSE.txt')); ?></textarea>
    </div>

    <div id="ins_agree">
        <label for="agree">I agree.</label>
        <input type="checkbox" name="agree" value="Agree" id="agree">
    </div>
<?php
	if( $_SESSION['mb_level'] > 7)	echo "<input type='button' value='DB List View' onclick='table_list();' title=' Table Create List '>";
?>
	<div class="setup_btn">
        <input type="submit" value="Next">
    </div>
</div>
</form>
<script>
	function frm_submit(f)
	{
		if (!f.agree.checked) {
			alert("You must agree to the license terms to install."); // 라이센스 내용에 동의하셔야 설치가 가능합니다.
			return false;
		}
		return true;
	}

	function table_list(){   
		document.form_view.mode.value	= 'setup';   
		document.form_view.target		= '_blank';   
		document.form_view.action		= './DB_Table_CreateA.php?admin=modumoa';   //'../DB_Table_Create.php';   
		document.form_view.submit();   
	}  

</script>
<?php
} // if
?>

<?php
include_once ( KAPP_PATH_T_ . '/setup/setup.buttom.php');
?>
