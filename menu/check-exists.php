<?php
	include_once('../tkher_start_necessary.php');
/*
	/t/module/check-exists.php
	/t/menu/pages/trex/image.php 에서 콜: 

	Uploadify
	Copyright (c) 2012 Reactive Apps, Ronnie Garcia
	Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

	// Define a destination
	//$targetFolder = '/uploads'; // Relative to the root and should match the upload folder in the uploader script

	$infor   = $_SESSION['infor'];
	include "./infor.php";

	$f_path1			= KAPP_PATH_T_ . "/file/" . $mf_infor[53];	// 53:maker id.
	$f_path2			= $f_path1 . "/aboard_".$mf_infor[2]; // 2: board name

	$targetFolder = $f_path2;	//m_("check-exists.php targetFolder: " . $targetFolder); exit;

	if( file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder . '/' . $_POST['filename'])) {
		echo 1;
	} else {
		echo 0;
	}
?>