<?php
if( !defined('_KAPP_')) exit; // 개별 페이지 접근 불가

if( !$title) $title = KAPP_VERSION_." Setup";
/*
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
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>

<link rel="stylesheet" href="setup.css"><!-- <link rel="stylesheet" href="setup_kapp.css"> -->

</head>
<body>

<div id="set_topbar">
    <span id="bar_img"><a href='<?=KAPP_URL_T_?>' >K-APP <img src="<?=KAPP_URL_T_?>/logo/logo.png" title='K-APP - home'></a></span>
    <span id="set_bartxt">SETUP</span>
</div>

<?php
// 파일이 존재한다면 설치할 수 없다.

$data_path = KAPP_PATH_ . '/' . KAPP_DATA_DIR; // 'data'
$dbcon_file = $data_path.'/' . KAPP_DBCON; // './data/kapp_dbcon.php'

$dbcon = '/' . KAPP_DATA_DIR . '/' . KAPP_DBCON;

//m_("ini kapp_dbcon: ".$dbcon_file); //ini kapp_dbcon: /var/www/html/t/my/data/kapp_dbcon.php

if( !$reset && file_exists( $dbcon_file)) { // './data/kapp_dbcon.php' 화일이 존재하고 , reset 이면 pass 
	m_("File exists : dbcon_file: " . $dbcon_file); // kapp_dbcon.php 화일이 존재함:File exists
?>
	<h1><?php echo KAPP_VERSION_; ?> The program is already installed.</h1><!-- 프로그램이 이미 설치되어 있습니다. -->
<form action="./index_reset.php" method="post" onsubmit="return reset_submit(this);">
	<input type='hidden' name='mode' value='reset'>
	<input type='hidden' name='admin' value='modumoa'>

	<div class="setup_inner">
		<p>The program is already installed.</p>
		<br /><!-- 프로그램이 이미 설치되어 있습니다.  새로 설치하는 방법 -->
		How to do a fresh install<br><br>
		Method-1. "<?=$dbcon?>" Delete this file and run it again!<br><br> <!-- 이 화일을 삭제후 다시 실행하세요! -->
		Method-2. Enter administrator information when installing and run!<br><br> <!-- 설치시 관리자 정보를 입력하고 실행하세요! -->
		   E-Mail : &nbsp;&nbsp;<input type='text' name='email'><br>
		   Password: <input type='password' name='passwd'><br>
		   <input type="submit" value="Reset Enter"><br>
		</p>

		<ul>
			<li><?php echo $dbcon ?> has been installed. You can install it after deleting it. </li><!-- 설치 되었습니다. 삭제 후 설치 할 수 있습니다. -->
		</ul>
	</div>
</form>

<?php
    exit;
}
?>

<?php

$exists_data_dir = true;
// data 디렉토리가 있는가?
//$data_path = './data'

//m_("ini data_path:" . $data_path); //ini data_path:/var/www/html/t/data
if( !is_dir($data_path)) { // './data'
?>
	<h1><?php echo KAPP_VERSION_; ?> 설치를 위해 아래 내용을 확인해 주십시오.</h1>

	<!-- <div class="setup_inner"> HeadTitle01AX-->
	<div class="setup_inner">
		<p>
			<!-- 루트 디렉토리에 아래로 <?php echo KAPP_DATA_DIR ?> 디렉토리를 생성하여 주십시오.<br />
			$> mkdir <?php echo KAPP_DATA_DIR ?><br /><br />
			kapp file을 업로드한 폴드에 data 폴더를 하나 생성해 주시기 바랍니다.<br /><br />
			위 명령 실행후 브라우저를 새로고침 하십시오. -->
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
$write_data_dir = true; // data 디렉토리에 파일 생성 가능한지 검사.
//m_("setup.ini - PHP_OS: " . PHP_OS ); //setup.ini - PHP_OS: Linux
if( strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
    $sapi_type = php_sapi_name(); //m_("setup.ini - sapi_type: " . $sapi_type ); // setup.ini - sapi_type: apache2handler
    if( substr($sapi_type, 0, 3) == 'cgi') {
        if( !(is_readable($data_path) && is_executable($data_path))) {
?>
			<div class="setup_inner">
				<p>
					<?php echo KAPP_DATA_DIR ?> Please change the directory permission to 705.<br /><br /><!-- 디렉토리의 퍼미션을 705로 변경하여 주십시오. -->
					$> chmod 705 <?php echo KAPP_DATA_DIR ?> or chmod uo+rx <?php echo KAPP_DATA_DIR ?><br /><br />
					After executing the above command, refresh your browser.
				</p>
			</div>
<?php
            $write_data_dir = false;
        }
    } else { //m_("setup.ini - is_readable: " . is_readable($data_path) ); // setup.ini - is_readable: 1
        if( !(is_readable($data_path) && is_writeable($data_path) && is_executable($data_path))) {
?>
			<div class="setup_inner">
				<p>
					<?php echo KAPP_DATA_DIR ?> Please change the directory permission to 705.<br /><br /><!-- 디렉토리의 퍼미션을 705로 변경하여 주십시오. -->
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
			alert("You must agree to the license terms to install."); // 라이센스 내용에 동의하셔야 설치가 가능합니다.
			return false;
		}
		return true;
	}
	</script>
