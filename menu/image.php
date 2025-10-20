<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$ip = $_SERVER['REMOTE_ADDR'];
	$H_LEV	= $member['mb_level'];  
	$timestamp = time(); 
	/*
	/t/menu/pages/trex/image.php 에서 -> /t/menu/image.php 로 이동 : 2023-12-04 _menu에서 test
	/module/ 를 /menu/ 로 변경. 
	/t/module/uploadifive.php -> /t/menu/uploadifive.php
	/t/module/check-exists.php -> /t/menu/check-exists.php 로 변경.

	실행하는 위치 : /t/menu/js/editor.js 여기에 정의 되어 있다.
	*/
	//m_("root: " . $_SERVER['DOCUMENT_ROOT']); // root: /var/www/html
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Daum Image Upload</title> 
<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/menu/css/popup.css" charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/menu/css/uploadify.css">
<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/menu/css/uploadifive.css">
<script type="text/javascript" src="<?=KAPP_URL_T_?>/menu/js/jquery.min.js" ></script> 
<script type="text/javascript" src="<?=KAPP_URL_T_?>/menu/js/jquery.uploadifive.js" ></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/menu/js/popup.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/menu/js/jquery.uploadify.min.js" ></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script> -->
<style type="text/css">
body {
	font:13px Arial, Helvetica, Sans-serif;
}
#queue {
	border:1px solid #E5E5E5;
	overflow:auto;
	margin-bottom:10px;
	padding:0 3px 3px;
	float:left;
	width:370px;
	height:490px;
}
#uploadButton {
	float:left;
	margin-left:10px;
}
.uploadifive-button {
	float: left;
	margin-right: 10px;
}
</style>
<?php
	function mm_($message) {
		echo "<script language='javascript'>alert('$message');</script>";
	}
	//if( isset($_POST['infor'])) $infor = $_POST['infor'];
	//else if( isset($_REQUEST['infor'])) $infor = $_REQUEST['infor'];
	if( isset($_SESSION['infor'])) $infor = $_SESSION['infor']; //m_("image infor: ".$infor);
	else {
		 $infor = ''; 
	}

	if( $infor > 0 ){ // 게시판이면.

		include_once( './infor.php');
		$f_path1	= KAPP_PATH_T_ . "/file/" . $mf_infor[53]; // make_id
		$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];
		if( !is_dir($f_path1) ) {
			if( !@mkdir( $f_path1, 0755 ) ) {
				echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
				echo "<script>history.go(-1); </script>";exit;
			}
		}
		if( !is_dir($f_path2) ) {
			if( !@mkdir( $f_path2, 0755 ) ) {
				echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
				echo "<script>history.go(-1); </script>";exit;
			}
		}
		$mid = $mf_infor[53];
		$f_path1			= KAPP_URL_T_ ."/file/" . $mid; // 53:maker id. $mf_infor[53], $mf_infor[2]
		$f_path2			= $f_path1 . "/aboard_".$mf_infor[2] . "/"; // 2: board table_name
	} else { // 게시판이 아니면. note 이면.
			$f_path2			= KAPP_URL_T_ ."/file/uploads/";  // url을 사용해야한다 중요.
	}
	//m_("f_path1: " . $f_path1 . ", f_path2: " . $f_path2);
	//f_path1: https://biogplus.com/kapp/file/solpakan@naver.com, 
	//f_path2: https://biogplus.com/kapp/file/solpakan@naver.com/aboard_tkhersolpakan1716772819/
	
?>
<script type="text/javascript">
	function done() {
		if(typeof(execAttach) == "undefined") {
			return;
		}
		// 업로드한 파일의 수만큼 게시판에 나타내기 위해 each 문을 통해 반복시킨다.
		jQuery(".fileInfo").each(function(idx) {
			var fileName = jQuery("input[name='fileName']").eq(idx).val();
			var fileUpName = jQuery("input[name='fileUpName']").eq(idx).val();
			var fileSize = jQuery("input[name='fileSize']").eq(idx).val();
			var fileUrl = "<?php echo $f_path2;?>" + fileUpName;
			var _mockdata = {
				  "imageurl" : fileUrl
				, "filename" : fileName
				, "filesize" : fileSize
				, "imagealign": "C"
				, "originalurl" : fileUrl
				, "thumburl" : fileUrl
			};
			execAttach(_mockdata);
        });
		closeWindow();
	}
	function initUploader() {
		var _opener = PopupUtil.getOpener();
		if(!_opener) {
			alert("You have accessed the wrong path."); // 잘못된 경로로 접근하셨습니다.
			return;
		}
		var _attacher = getAttacher("image", _opener);
		registerAction(_attacher);
	}
</script>
</head>
<body onload="initUploader();">

	<form>

<div class="wrapper">
	<div class="header">
		<h1>Attach pictures</h1>
	</div>	
	<div class="body">
		<dl class="alertA">
		    <!-- <dt>Attach pictures confirm</dt> -->
			<div style="height:10px;"></div>
			<div>
				<div id="queue" style="float:left;"></div>
				<div id="uploadButton">
					<input id="file_upload" name="file_upload" type="file" multiple="true"><br><br><br>
			<input type='button' value='Upload Files' onclick="javascript:$('#file_upload').uploadifive('upload');" title='Upload to Server.' style="border-style:;background-color:#00000f;color:yellow;height:30px;border-radius:20px;">
				</div>


			</div>
		</dl>

	</div>
	<div class="footer" style="width:100%;position:absolute;right:0px;bottom:0px;">
		<p><a href="javascript:;" onClick="closeWindow();" title="Close" class="Aclose">Close</a></p>
		<ul>
			<li class="submit"><a href="javascript:;" onClick="done();" class="btnlink" title='image insert'>Insert</a></li>
			<li class="cancel"><a href="javascript:;" onClick="closeWindow();" title="Cancel" class="Abtnlink">Cancel</a></li>
		</ul>
	</div>
</div>
<div id="hiddenFile"></div>
	</form>

</body>
<script type="text/javascript">

jQuery(document).ready(function() {
	jQuery('#file_uploadA').uploadify({
		 'auto' : false, // 파일 선택 후 여부 자동 업로드 (기본값 : true)
		 'removeCompleted' : false, // 파일 업로드 성공 후 업로드 창의 자동 삭제 여부 (기본값 : true)
				'formData'         : {
									    'timestamp' : '<?php echo $timestamp;?>',
									    'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
										'nation' : 'kr'
				                     },
		 'queueID' : 'queue',										// 파일 업로드 상황을 나타내는 창의 위치를 강제적으로 지정한다.
		 'swf' : '<?=KAPP_URL_T_?>/menu/uploadify.swf',		// 파일 업로드 이벤트에 사용될 플래쉬 파일
		 'uploader' : '<?=KAPP_URL_T_?>/menu/uploadify.php',	// uploadify 파일 업로드를 수행할 php 파일 
		 'onUploadComplete' : function(file, data) {									// 파일 하나의 업로드 작업이 완료 후 실행되는 트리거
			var fileData = "<div class='fileInfo'>"
							+ "<input type='hidden' name='fileName' value='" + file.name + "'/>"
							+ "<input type='hidden' name='fileUpName' value='<?= $timestamp; ?>_" + file.name + "'/>"
							+ "<input type='hidden' name='fileSize' value='" + file.size +"'/>"
							+ "</div>";
			jQuery("#hiddenFile").append(fileData);
		}
	});
});

$(function() {
	$('#file_upload').uploadifive({
		'auto'             : false,
		'checkScript'      : '<?=KAPP_URL_T_?>/menu/check-exists.php',
		'fileType'         : '.jpg,.jpeg,.gif,.png,.JPG,.JPEG,.GIF,.PNG',
		'formData'         : {
							   'timestamp' : '<?php echo $timestamp;?>',
							   'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
							 },
		'queueID'          : 'queue',
		'uploadScript'     : '<?=KAPP_URL_T_?>/menu/uploadifive.php',
		'onUploadComplete' : function(file, data) { 
	var fileData = "<div class='fileInfo'>"
					+ "<input type='hidden' name='fileName' value='" + file.name + "'/>"
					+ "<input type='hidden' name='fileUpName' value='" + file.name + "'/>"
					+ "<input type='hidden' name='fileSize' value='" + file.size +"'/>"
					+ "</div>";
	jQuery("#hiddenFile").append(fileData);
							 }
	});
});
</script>
</html>