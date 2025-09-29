<?php
if( !defined('_KAPP_')) exit; // 개별 페이지 접근 불가

if( !$title) $title = KAPP_VERSION_." Setup";
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>

<link rel="stylesheet" href="setup.css">

</head>
<body>

<div id="set_topbar">
    <span id="bar_img"><a href='<?=KAPP_URL_T_?>' >K-APP <img src="<?=KAPP_URL_T_?>/logo/logo.png" title='K-APP - home'></a></span>
    <span id="set_bartxt">SETUP</span>
</div>

<?php
$data_path = KAPP_PATH_ . '/' . KAPP_DATA_DIR;
$dbcon_file = $data_path.'/' . KAPP_DBCON;
$dbcon = '/' . KAPP_DATA_DIR . '/' . KAPP_DBCON;
if( !$reset && file_exists( $dbcon_file)) {
	m_("File exists : dbcon_file: " . $dbcon_file);
?>
	<h1><?php echo KAPP_VERSION_; ?> The program is already installed.</h1>
<form action="./index_reset.php" method="post" onsubmit="return reset_submit(this);">
	<input type='hidden' name='mode' value='reset'>
	<input type='hidden' name='admin' value='modumoa'>

	<div class="setup_inner">
		<p>The program is already installed.</p>
		<br />
		How to do a fresh install<br><br>
		Method-1. "<?=$dbcon?>" Delete this file and run it again!<br><br>
		Method-2. Enter administrator information when installing and run!<br><br>
		   E-Mail : &nbsp;&nbsp;<input type='text' name='email'><br>
		   Password: <input type='password' name='passwd'><br>
		   <input type="submit" value="Reset Enter"><br>
		</p>
		<ul>
			<li><?php echo $dbcon ?> has been installed. You can install it after deleting it. </li>
		</ul>
	</div>
</form>

<?php
    exit;
}
?>

<?php
$exists_data_dir = true;
if( !is_dir($data_path)) {
?>
	<h1><?php echo KAPP_VERSION_; ?> 설치를 위해 아래 내용을 확인해 주십시오.</h1>
	<div class="setup_inner">
		<p>
			Please create the <?php echo KAPP_DATA_DIR ?> directory in the root directory.<br />
			$> mkdir <?php echo KAPP_DATA_DIR ?><br /><br />
			Please create a data folder in the folder where you uploaded the kapp file.<br /><br />
			After executing the above command, refresh your browser.
		</p>
	</div>
<?php
    $exists_data_dir = false;
}
?>

<?php
$write_data_dir = true;
if( strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
    $sapi_type = php_sapi_name();
    if( substr($sapi_type, 0, 3) == 'cgi') {
        if( !(is_readable($data_path) && is_executable($data_path))) {
?>
			<div class="setup_inner">
				<p>
					<?php echo KAPP_DATA_DIR ?> Please change the directory permission to 705.<br /><br />
					$> chmod 705 <?php echo KAPP_DATA_DIR ?> or chmod uo+rx <?php echo KAPP_DATA_DIR ?><br /><br />
					After executing the above command, refresh your browser.
				</p>
			</div>
<?php
            $write_data_dir = false;
        }
    } else {
        if( !(is_readable($data_path) && is_writeable($data_path) && is_executable($data_path))) {
?>
			<div class="setup_inner">
				<p>
					<?php echo KAPP_DATA_DIR ?> Please change the directory permission to 705.<br /><br />
					$> chmod 705 <?php echo KAPP_DATA_DIR ?> or chmod uo+rx <?php echo KAPP_DATA_DIR ?><br /><br />
					After executing the above command, refresh your browser.
				</p>
			</div>
<?php
            $write_data_dir = false;
        }
    }
}
?>

	<script>
	function reset_submit(f)
	{
		if (!f.agree.checked) {
			alert("You must agree to the license terms to install.");
			return false;
		}
		return true;
	}
	</script>
