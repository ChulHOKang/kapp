<?php
	include_once('../tkher_start_necessary.php');
	include "./infor.php";

	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($_POST['infor']) ) $infor = $_POST['infor'];
	else if( isset($_REQUEST['infor']) ) $infor = $_REQUEST['infor'];
	else {
		$infor = '';
		m_("Error infor: $infor - insert1.php "); exit;
	}
	$H_ID= get_session("ss_mb_id");
	if( $H_ID !=''){
		$H_LEV	= $member['mb_level'];
		$H_NAME	= $member['mb_name'];
	} else {
		$H_ID='Guest';
		$H_NAME	= 'Guest';
		$H_LEV	= 1;
	}
	//1Mb Only uploaded below. file size:1.1949167251586914, upfile:1
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/board_new.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<!-- <link rel="stylesheet" href="./css/Oboard.css" type="text/css"> -->
<link rel="stylesheet" href="../include/css/default.css" type="text/css" />
</head>
<SCRIPT src="<?=KAPP_URL_T_?>/include/js/contents_resize.js" type=text/javascript></SCRIPT>

<?php
	switch( $mf_infor[47] ){
		case '0': break;
		case '1': break;
		case '2':
			if( !$H_ID || $H_LEV < 2 ) { 
				m_("null You do not have permission to write."); 
				echo "<script>window.open('list1.php?infor=".$infor."','_top','')</script>";exit;
				//echo "<script>top.location.reload();</script>";	exit;
			}
			else break;
		case '3': 
			if( $H_ID != $mf_infor[53] ) { 
				m_("user You do not have permission to write."); 
				//echo "<script>history.back(-1);</script>"; exit;
				echo "<script>window.open('list1.php?infor=$infor','_self','')</script>";exit;
			}
			else break;
		case '8': 
			if( $H_LEV < 8 ) { 
				m_("manager You do not have permission to write."); 
				//echo "<script>history.back(-1);</script>"; exit;
				echo "<script>window.open('list1.php?infor=$infor','_self','')</script>";exit;
			}
			else break;
	}

	$amember_name	= $H_NAME;
	$amember_id		= $H_ID;
	$mf_47=$mf_infor[47];
?>

<script language="JavaScript"> 
<!--
	function check(x,y){
		//alert('y:'+y);
		if(x.name.value==''){
			alert('Please enter your name ');
			x.name.focus();
			return false;
		}
		if(x.subject.value==''){
			alert('Please enter a title! ');
			x.subject.focus();
			return false;
		}
		if(x.context.value==''){
			alert('Please enter your content! ');
			x.context.focus();
			return false;
		}
		if(y=="0"){
			if(x.password.value==''){
				alert('Please enter a password.');
				x.password.focus();
				return false;
			}
		}
		//else{return true;}
	}
	function textarea_size(value) {
		if (value == 0) {
		  document.insert_form.context.cols  = 60;
		  document.insert_form.context.rows  = 10;
		}
		if (value == 1) document.insert_form.context.cols += 5;
		if (value == 2) document.insert_form.context.rows += 5;
	}

	function list_func(infor) {
		document.insert_form.action="list1.php";
		document.insert_form.submit();
	}
	// security:비밀글, upfile: 첨부화일.
	function insert_funcK(security, upfile, id) {
	//	alert('insert_funcK ------------ security:'+security +' ,upfile:'+ upfile);
		if( !id ) {
			var p1 = document.insert_form.password.value;
			if( !p1 ){
				alert('Please enter password. ');
				document.insert_form.password.focus();
				return false;
			}
		}
		if(document.insert_form.name.value==''){
			alert('Please enter your name. ');
			document.insert_form.name.focus();
			return false;
		}
		if(document.insert_form.subject.value==''){
			alert('Please enter a title! ');
			document.insert_form.subject.focus();
			return false;
		}
		if(document.insert_form.context.value==''){
			alert('Please enter your content! ');
			document.insert_form.context.focus();
			return false;
		}
		if( security > 0){
			//alert('2 --- security:'+security);
			var se_ = document.insert_form.security1.value;
			if(se_=="use"){
				p = document.insert_form.security.value;
				if( !p ){
					alert('Please enter a password.');
					document.insert_form.security.focus();
					return false;
				}
			}
		} else {
			//alert('1 --- security:'+security);
		}

		if( upfile > 0 ){
			var form = document.insert_form;
			ff= form.file.value;
			if (form.file.value != ""){
				
					input = document.getElementById('file');
				var file_sz = input.files[0].size;
				//file_sz = document.querySelector('input[type=file]').files[0].size; //OK
				//alert('2 - file_sz:'+ file_sz);
					file_sz = file_sz / 1024 / 1024;
					if( file_sz > upfile ) {
						alert( upfile +"Mb Only uploaded below. file size:" + file_sz + ', upfile:' + upfile );//Mb Only uploaded below. file size:22.114242553710938
						return false;
					}

				idx_path = form.file.value.lastIndexOf("."); 
				if ( idx_path < 0 ) {
					idx_colon = form.file.value.lastIndexOf(".");
					if ( idx_colon >= 0 ) temp = form.file.value.substring(idx_colon);
				} else {
					temp = form.file.value.substring(idx_path);
				}
					temp = temp.toLowerCase();

				//alert(' temp:'+temp);	return false;	// temp:.html
				if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppk" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx" && temp != ".mp3" && temp != ".mp4" && temp != ".avi"){
					alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppk,alz,rar,pptx,xlsx,mp3,mp4,avi Please format!");
					return;
				}
				form.file_ext.value=temp;
			}
		} else {
		}

		document.insert_form.mode.value='insert_form_image'; 
		document.insert_form.action='query_ok_new.php';
		document.insert_form.submit();
		
	}

	function previewFile(upfile) { 

			input = document.getElementById('file');
			var file_sz = input.files[0].size;
			file_sz = file_sz / 1024 / 1024;
			if( file_sz > upfile ) {
				alert( upfile +"Mb Only uploaded below. file size:" + file_sz + ', upfile:' + upfile );//Mb Only uploaded below. file size:22.114242553710938
				//return false;
			}
			var form = document.insert_form;
			idx_path = form.file.value.lastIndexOf("."); //alert('idx_path:' + idx_path);//13
				 temp = form.file.value.substring(idx_path);
				 temp = temp.toLowerCase();

			if( temp == ".jpg" || temp == ".gif" || temp == ".png" || temp == ".bmp" ){
					var preview = document.querySelector('#imgID'); 
					var file = document.querySelector('input[type=file]').files[0]; 
					var filesz = document.querySelector('input[type=file]').files[0].size; 
					var reader  = new FileReader(); 
					reader.onloadend = function () { 
						  preview.src = reader.result; 
				   } 
				   if (file) { 
						 reader.readAsDataURL(file); 
					 } else { 
						 preview.src = ""; 
				  } 
			} else {
					var preview = document.querySelector('#imgID'); 
					preview.src = ""; 
					return false;
			}
	} 
-->
</script>
<SCRIPT src="../include/js/contents_resize.js" type='text/javascript'></SCRIPT>
<body>
<?php
		$cur='B';
		include_once "../menu_run.php"; 
?>
<?=$mf_infor[44]?>
<table style="border:1px solid cyan; width:auto; height:auto; margin:auto; text-align: center;">
  <tr>
    <td>
<table width="589" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
  <table width="565" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td bgcolor="#FFFFFF" >
        <br>
        <table width="565" border="1" cellspacing="1" cellpadding="1">
          <tr>
            <td valign="top" height="100%">
				 
				 <table border='0' cellspacing='0' cellpadding='5' width='100%' bgcolor='Silver'>
					<tr>
					  <td height='22' title='pg:insert1.php, tab:<?=$mf_infor[2]?>'><font color="#FFFFFF"><?=$mf_infor[1]?></font></td>
					</tr>
				 </table>

				<table><!-- <?=$mf_infor[10]?> -->
					<tr><td>
					<br>
				  <table width='100%' ><!-- <?=$mf_infor[24]?> bgcolor="WhiteSmoke" -->

<FORM name='insert_form' action='query_ok_new.php' method='post' enctype="multipart/form-data" >
		<input type='hidden' name='mode' value=''>
		<input type='hidden' name='insert' value='1'>
		<input type='hidden' name='security_' value='1'>
		<input type='hidden' name='infor' value='<?=$infor?>' > 
		<input type='hidden' name='file_ext' value=''>
		<input type='hidden' name='fileup_yn' value='<?=$mf_infor[3]?>'>

					<tr><td colspan=2 width="100%" height="1" bgcolor="#ffffff" background="../icon/dot.gif"></td></tr>
					<tr>
					  <td width="15%" bgcolor="<?=$mf_infor[25]?>">
					  <font color="<?=$mf_infor[26]?>">writer</td>
					  <td width="75%">
					  <input type="text" name="name" size="18" maxlength=30 style='border:1 black solid;' value="<?=$amember_name?>"></td>
					</tr>
<?php if($mf_infor[3]){ ?>
					<tr>
					  <td width="15%" height="9" bgcolor="<?=$mf_infor[25]?>">
						<font color="<?=$mf_infor[26]?>">Attached file</td>
					  <td width="75%" height="9" >
						<input type="file" name="file" id="file"  style="padding-top:12.5px;" onchange="previewFile( '<?=$mf_infor[3]?>' )">
						<br><img src="" id='imgID' > 
						</td>
					</tr>
<?php } ?>
					<tr>
					  <td width="15%" height="9" bgcolor="<?=$mf_infor[25]?>" title='Subject-Title'>
						<font color="<?=$mf_infor[26]?>">Subject</td>
					  <td width="75%" height="9" >
						<input type="text" name="subject" size="61" maxlength=50 style='border:1 black solid;'></td>
					</tr>

					<tr>
					  <td width="15%" height="9" bgcolor="<?=$mf_infor[25]?>" title='Context-Title'>
						<font color="<?=$mf_infor[26]?>">Context</td>
						<td width="75%" height="9" >
								<textarea rows="10" wrap="hard" name="context" cols="80" ></textarea>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
			  <td colspan='2' width="100%" height="1" bgcolor="#ffffff" background="../icon/dot.gif"></td>
			</tr>
			<tr align="left">
				<td colspan=2 width="100%" height="9">
				<input type='button' value='Previous' onclick="javascript:list_func('<?=$infor?>')" >&nbsp;
				<input type='button' value=' List ' onclick="javascript:list_func('<?=$infor?>')" >&nbsp;
				<input type='button' value=' Save ' onclick="javascript:insert_funcK('<?=$mf_infor[51]?>', '<?=$mf_infor[3]?>', '<?=$H_ID?>')" >
				</td>
			</tr>

      </table>
  </td></tr>
</table>
  
  </form>

    </td>
  </tr>
</table>
</td>
  </tr>
</table>
<?=$mf_infor[45]?>
</html>