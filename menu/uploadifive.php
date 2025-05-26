<?php
	include_once('../tkher_start_necessary.php');
	/*
	/t/module/uploadifive.php : 업로드될 파일의 경로를 지정한다.
	/t/menu/pages/trex/image.php 에서 콜: 

	UploadiFive
	Copyright (c) 2012 Reactive Apps, Ronnie Garcia
	*/

	$infor   = $_SESSION['infor'];
	include "./infor.php";

	if( isset($infor) ){
				$f_path1			= KAPP_PATH_T_ . "/file/" . $mf_infor[53];	    // 53:maker id
				$f_path2			= KAPP_PATH_T_ . "/file/" . $mf_infor[53] . "/aboard_".$mf_infor[2]; // 2: board name
	} else {
				$f_path2			= KAPP_PATH_T_ . "/file/uploads"; // 2: board name
	}
	$uploadDir = $f_path2 . "/";     // '/contents/uploads/'; //m_("uploadifive uploadDir : " . $targetFolder);
	$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions
	$verifyToken = md5('unique_salt' . $_POST['timestamp']);
	if( !empty($_FILES) && $_POST['token'] == $verifyToken) {
		$tempFile   = $_FILES['Filedata']['tmp_name'];
		$targetFile = $uploadDir . $_FILES['Filedata']['name'];
		$fileParts = pathinfo($_FILES['Filedata']['name']);
		if( in_array( strtolower( $fileParts['extension']), $fileTypes)) {
			move_uploaded_file( $tempFile, $targetFile ); // Save the file
			echo 1;
		} else {
			echo "allowed file type. : jpg, jpeg, gif, png";
		}
	}
?>