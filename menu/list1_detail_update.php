<?php
	include_once('../tkher_start_necessary.php');
	/*
	  list1_detail_update.php : board_data_update.php를 copy
	  image type board - list1.php - list1_detail.php - data update를 위해 사용.
	*/
	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	$cranim_id  = $H_ID;
	$cranim_lev = $H_LEV;

	$infor   = $_POST['infor'];
	$list_no = $_POST['list_no'];
	$page         =$_POST['page']; 
	$search_text  =$_POST['search_text']; 
	$search_choice=$_POST['search_choice']; 
	$update_pass  =$_POST['update_pass'];// =list1

	include "./infor.php";

	$query="SELECT * from aboard_" . $mf_infor[2] . " where no=$list_no";
	$mq = sql_query($query );
	$mf = sql_fetch_row($mq);

	$mid	= $mf_infor[53]; // 53['makeid'] = 8['imember'] 
	$fsize	= GetFileSize_func($mf[14]);	//파일싸이즈 get_size
	$fpath	= $mf[16];
	$mf[7]	= strftime("%Y/%m/%d &nbsp;%X", $mf[7]);
	//$mf[8]	= iconv_substr($mf[8], 0, 50, 'utf-8');// . "...";

?>
<?=$mf_infor[44]?><!-- top -->

<link rel="stylesheet" href="./include/css/board.css" type="text/css">

<style type="text/css">
<!--
BODY{scrollbar-face-color: #ffffff;scrollbar-highlight-color: #bbbbbb;scrollbar-shadow-color: #bbbbbb;scrollbar-3dlight-color: #ffffff;scrollbar-arrow-color: #bbbbbb;scrollbar-track-color: #ffffff;scrollbar-darkshadow-color: #ffffff ; font-family:굴림;}
-->
</style>

<script>
	function check(x,y){

		if(x.name.value==''){
		alert('Please enter your name');//이름을 입력하세요
		x.name.focus();
		return false;
		}
		if(x.subject.value==''){
		alert('Please enter a title');//제목을 입력하세요
		x.subject.focus();
		return false;
		}
		if(x.context.value==''){
		alert('Please enter your content');//내용을 입력하세요
		x.context.focus();
		return false;
		}
		if(y=="0"){
		if(x.password.value==''){
		alert('Please enter a password');//비밀번호를 입력하세요
		x.password.focus();
		return false;
		}
		}
		else{return true;}
		
	}
	function textarea_size(value) {
		if (value == 0) {
		  document.form.context.cols  = 60;
		  document.form.context.rows  = 10;
		}
		if (value == 1) document.form.context.cols += 5;
		if (value == 2) document.form.context.rows += 5;
	}

	function update_func(id){
		if( !id ){
			var p1 = document.update_form.password.value;
			if( !p1 ) { alert('Enter Password! ' ); return false; }
			var p2 = document.update_form.passwordG.value;
			if( p1 == p2 )	document.update_form.submit();
			else {
				alert('Password is incorrect! p:' + p1);
				return false;
			}
		} else document.update_form.submit();
	}
	function back_func(infor){
		update_form.action='list1.php?infor='+infor;
		document.update_form.submit();
	}
	function goBack() {
		update_form.action='list1_detail.php';
		document.update_form.submit();
	}

	function previewFile(upfile) { 
			input = document.getElementById('fileA');
			var file_sz = input.files[0].size;
			file_sz = file_sz / 1024 / 1024;
			if( file_sz > upfile ) {
				alert( upfile +"Mb Only , file size:" + file_sz + ', upfile:' + upfile );	//3Mb file size:0.23010730743408203, upfile:3
				return false;
			}
			//alert( upfile +"Mb file size:" + file_sz + ', upfile:' + upfile );	//3Mb file size:0.16010475158691406, upfile:3
			var form = document.update_form;
			document.update_form.up_fileA.value = document.update_form.fileA.value;
			idx_path = document.update_form.fileA.value.lastIndexOf(".");  //alert('idx_path:' + idx_path);//idx_path:22
				 temp = document.update_form.fileA.value.substring(idx_path);
				 temp = temp.toLowerCase();

			if( temp == ".jpg" || temp == ".gif" || temp == ".png" || temp == ".bmp" ){
					var preview = document.querySelector('#imgID'); 
					var file = document.querySelector('input[type=file]').files[0]; 
					var filesz = document.querySelector('input[type=file]').files[0].size; 	//	alert( file + ", filesz: " + filesz);			//[object File], filesz: 78278
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
				alert( "file: " + file + ", filesz: " + filesz);
					var preview = document.querySelector('#imgID'); 
					preview.src = ""; 
					return false;
			}
	} 

</script>

<SCRIPT src="./include/js/contents_resize.js" type=text/javascript></SCRIPT>

<!-- <body bgProperties=fixed leftmargin="0" topmargin="0" onLoad="frame_init()"> 
<body bgProperties=fixed leftmargin="0" topmargin="0" align=center>-->
<body>
<center>
<?php
		$cur='B';
		include_once "../menu_run.php"; 



	function GetFileSize_func($size) {
			if($size<1024) return ($size . "B");
			if($size >1024 && $size< 1024 *1024) return sprintf("%0.1fKB",$size / 1024);
			if($size >= 1024*1024) return sprintf("%0.2fMB",$size / (1024*1024));
	}
	function get_size($tmp_file, $board_name) {
		global $width, $height, $mid, $fpath;
		$size_factor = 500; 
		$size0 = @GetImageSize("$fpath/$tmp_file"); 
		$x= $size0[0];
		$y= $size0[1];
		$width = $size0[0];
		$height = $size0[1];
		if($size0[0] == 0 ) $size0[0]=1; 
		if($size0[1] == 0 ) $size0[1]=1; 

		if($size0[0]>$size0[1]) { $per=$size_factor / $size0[0]; } 
		else { $per=$size_factor / $size0[1]; } 
		if( $size0[0] > $size_factor ) {
			$x_size=$size0[0]*$per; 
			$y_size=$size0[1]*$per; 
		} else {
			$x_size=$size0[0];//200; 
			$y_size=$size0[1];//120; 
		}
		$win_width  = $size0[0] + 15; 
		$win_height = $size0[1] + 30; 
		return $x_size."X".$y_size;
	} // func end


?>
<FORM name='update_form' action='list1_update_check.php' method='post' enctype="multipart/form-data" accept-charset="utf-8">
	<input type='hidden' name='infor'	value='<?=$infor?>' >
	<input type='hidden' name='list_no'	value='<?=$list_no?>' >
	<input type='hidden' name='page'	value='<?=$page?>' >
	<input type='hidden' name='search_choice'	value='<?=$search_choice?>' >
	<input type='hidden' name='search_text'		value='<?=$search_text?>' >
	<input type='hidden' name='update_pass'		value='<?=$update_pass?>' >
	<input type='hidden' name='fileup_yn' 		value='<?=$mf_infor[3]?>'><!-- upload file size -->
	<input type='hidden' name='mode'			value='List1_Update_Check'> <!-- update_func -->
	<input type='hidden' name='up_fileA' value='' >

<table width="<?=$mf_infor[10]?>" border="1" cellspacing="1" cellpadding="1" align="center">
  <!--<tr>
     <td><img src="./images/cbox_top_000.gif"></td>
  </tr>-->
  <tr>
    <td>
<table width="<?=$mf_infor[10]?>" border="0" cellspacing="1" cellpadding="1" align=center>
    <tr>
      <td align="center"> 


  <table width="565" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
    <tr>
      <td align="center" bgcolor="#FFFFFF" align=center> 
        <br>
        <table width="565" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td valign="top" align="left" height="400">
 
 <table border=0 cellspacing=0 cellpadding=5 width=565 bgcolor=Silver>
    <tr> 
      <td height=22><font color="#FFFFFF"><?=$mf_infor[1]?></font></td>
    </tr>
 </table>
<table width=<?=$mf_infor[10]?> align=center>
    <tr><td>
   <br>
  <table width=560 <?=$mf_infor[24]?>  bgcolor="WhiteSmoke">

<tr><td colspan=2 width="100%" height="1" bgcolor="#ffffff" background="./img/dot.gif"></td></tr>
    <tr>
      <td width="15%" height="14" bgcolor="<?=$mf_infor[25]?>" align="center">
      <font color="<?=$mf_infor[26]?>">Author</td>
      <td width="75%" height="14">
      <input type="text" name="name" size="18" maxlength=30 value='<?=$mf[3]?>' style='border:1 black solid;'></td>
    </tr>
    <tr>
      <td width="15%" height="18" bgcolor="<?=$mf_infor[25]?>" align="center">
        <font color="<?=$mf_infor[26]?>">Subject</td>
      <td width="75%" height="18" >
        <input type="text" name="subject" size="61" maxlength=50 value='<?=$mf[8]?>' style='border:1 black solid;'></td>
    </tr>
</tr>
<!-- 
<?php if( !$H_ID) { ?>
    <tr>
      <td width="236" height="7" bgcolor="<?=$mf_infor[25]?>">
       <p align="center"><font color="<?=$mf_infor[26]?>">Password</td>
      <td width="235" height="7">
      <input type="password" name="password" size="18" maxlength=10 value="" style='border:1 black solid;'></td>
    </tr>
<?php } ?>
 -->




<?php
$tmp=''; $size='';$imgA='';$imgs='';
if( $mf[12]){	// file_name
	$width  = 0;
	$height = 0;
	
	if( $mf[15]=='.bmp' || $mf[15]=='.gif' || $mf[15]=='.jpg' || $mf[15]=='.png'){
		$file="<a href='down.php?infor=$infor&no=$mf[0]&wonbon=$mf[13]' <img src='../icon/subject.gif' border='0'> <font color='$mf_infor[21]'>$mf[13]($fsize)</a>";
			$tmp = get_size($mf[12], $mf_infor[2]); 
			$size = explode("X", $tmp); 
			$imgA = "../file/".$mf_infor[53]."/aboard_".$mf_infor[2]."/".$mf[12]; // 53['makeid'] = 8['imember']
			$imgs= "<img id='imgID' src='".$imgA."' border='0' width='".$size[0]."' height='".$size[1]."' >";

	}else{
		$file="<a href='#' ><img src='".KAPP_URL_T_."/icon/file/default.gif' border=0> <font color=$mf_infor[21]>$mf[13]($fsize)</a>";
	}
?>
          <tr>
            <td colspan='2' align='right' width="100%" height="12" ><font color=<?=$mf_infor[21]?>><?=$file?></font></td>
          </tr>

          <tr>
     	  <td colspan='2' >
								<input type="text" name="fileAW" style="padding-top:1px;width:450px;" value='<?=$mf[12]?>' readonly>
								<input type="hidden" name="fileW" value='<?=$mf[13]?>' ><!-- 13:wonbon -->
<?php
	if( $imgA ) { 

		if( strpos( $mf[16], "../" ) !== false) { // new data
			$file_p = $mf[16] . "/" . $mf[12] ;
		} else if( strpos( $mf[16], "./" ) !== false) { // old data
			$file_p = "." . $mf[16] . "/" . $mf[12] ;
		} else {
			$file_p = $mf[16] . "/" . $mf[12] ;
		}

		$bnm = "aboard_" . $mf_infor[2]; // $mf_infor[2] : board name
		 $click_data = "window.open('pic2.php?infor=".$infor."&mid=".$mid."&bnm=".$bnm."&fnm=".$mf[12]."', '', 'width=$width, height=$height, top=0, left=0, scrollbars=yes')";
	?>
		<!-- <div align=center >-->
		<a href='#' onClick="<?=$click_data?>" title="width:<?=$size[0]?>, height:<?=$size[1]?>, file_path:<?=$mf[16]?> , file_name:<?=$mf[12]?>, file_original:<?=$mf[13]?>"><?=$imgs?></a>
		<!--</div>-->
<?php } ?>

</td>
         </tr>




<?php 
} //if($mf[12]) END  -----------------------------------------------------------------------------------
?>


    <tr>
      <td width="15%" height="18" bgcolor="<?=$mf_infor[25]?>" align="center">
        <font color="<?=$mf_infor[26]?>">Attachments</td>
      <td width="75%" height="18" >
				<!-- <input type="file" name="fileA" style="padding-top:12.5px;"> -->
				<input type="file" name="fileA" id="fileA"  style="padding-top:12.5px;" onchange="previewFile( '<?=$mf_infor[3]?>' )">
						<!-- <br><img src="" id='imgID' >  -->

	  </td>

    </tr>
</tr>

	<tr>
		<td width="15%" height="18" bgcolor="<?=$mf_infor[25]?>" align="center"><font color="<?=$mf_infor[26]?>">Context</td>
		<td width="75%" height="9" ><textarea rows="10" wrap="hard" name="context" cols="60" ><?=$mf[9]?></textarea></td>
    </tr>

	<tr><td colspan=2 width="100%" height="1" bgcolor="#ffffff" background="./img/dot.gif"></td></tr>
     <tr>
		<td width="15%" height="12" align="center"></td>
		<td width="75%" height="9" >

				<!--<a href="javascript:history.back()"><img src="<?=$mf_infor[28]?>" border=0></a>
				 <input type=image src="<?=$mf_infor[37]?>"> -->
				<!-- <input type='button' value='Back' onclick='javascript:history.back(-1)'> -->

				<!-- <input type='button' value='Back' onclick="javascript:history.back(-1)"> -->
				<!-- <a href="#" onclick="history.go(-1);return false;" style="text-decoration:underline;">Back</a> -->

				<input type='button' value='Back' onclick="goBack()">&nbsp;&nbsp;&nbsp;
				<input type='button' value='Submit' onclick="update_func('<?=$H_ID?>')">
		</td>
    </tr>
  </table>

  </td></tr>
</table>

	  <input type="hidden" name="passwordG" value="<?=$mf[11]?>" >

  </form>
            <!-- End of Paging Table --> 
    </td>
  </tr>  
</table>
</td>
  </tr>
<!--<tr>
    <td><img src="./images/cbox_bot_000.gif"></td>
  </tr>-->
</table>
<?=$mf_infor[45]?><!-- bottom -->
