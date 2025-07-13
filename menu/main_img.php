<?php
	include_once('../tkher_start_necessary.php');
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php
		/*
		*   main_img.php : 이미지 슬라이드. table:tkher_main_img
		*   tkher_my_control : 슬라이드 시간 설정. /data/main_scroll_image/
		    main_img_list.php
		*/
		$ss_mb_id = get_session("ss_mb_id");	//"ss_mb_id";
		$H_ID = get_session("ss_mb_id");  
		$H_LEV = $member['mb_level'];			//get_session("ss_mb_level");   //"ss_mb_id";

		if( isset($_POST['mode']) ) $mode = $_POST['mode'];
		else $mode = '';
		if( isset($_POST['no']) ) $no = $_POST['no'];
		else $no = '';
		if( isset($_POST['num']) ) $num = $_POST['num'];
		else $num = '';

if( $mode == "File_Change") {
	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");	// \\n 권한이 없습니다. 
			$url = "main_img.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	}
		if( isset($_POST['i']) ) $i = $_POST[i];
		else $i = 0;
		$fnm = "file_" . $i;
		$filenm = $_FILES[$fnm]['name'];

        $f_path = KAPP_PATH_T_ . "/data/main_scroll_image/";	//---------------------------------- 보완 OK.
		$in_date = time();

		if ( $_FILES["file[$i]"]["error"] > 0){ 
			echo "Return Code: " . $_FILES["$fnm"]["error"] . "<br>"; 
		} else { 
			if ( file_exists( $f_path . $filenm ) ) 
			{ 
				echo $_FILES["file"]["name"] . " I have the same file. Covered. ";	//동일한 파일이 있습니다. 덮었습니다.
				move_uploaded_file($_FILES["$fnm"]["tmp_name"], $f_path . $filenm );
			} else { 
				move_uploaded_file($_FILES["$fnm"]["tmp_name"], $f_path . $filenm );
			}
		}

		if( $filenm ) {

			$file_ext  = explode(".", $filenm );
			$file_nm   = strtolower( $file_ext[0]);
			$file_type = strtolower( $file_ext[1]);
			$SQL = "update {$tkher['tkher_main_img_table']} set jpg_file='$filenm' where userid='tkher' and no = $no";
			if ( ($result = sql_query( $SQL ) )==false )
			{
			  printf("Invalid query: Whole query: %s\n", $SQL);
				m_(" Update error occurred.");	// \\n Update 오류가 발생하였습니다. 
				exit();
			} else {
				m_(" The image file has been changed.");	// \\n 이미지화일를 변경 하였습니다. 
			}
		}
}

if( $mode=="Time_Change" ){
	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");	// \\n 권한이 없습니다. 
			$url = "main_img.php";
			echo "<script>window.open('./', '_self', '');</script>";
	}
		
		$slide_time=$_POST['slide_time'];
		$SQL = "update {$tkher['tkher_my_control_table']} set slide_time= '$slide_time' where userid='tkher' ";
		if ( ($result = sql_query( $SQL ) )==false )
		{
		  printf("Invalid query: %s \n", $SQL);
			m_("An error has occurred.");	// \\n Update 오류가 발생하였습니다. 
			exit();
		} else {
			m_(" Time changed.");	// \\n Time 변경 하였습니다. 
		}
}
if($mode == "Update_func") {

	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");	// \\n 권한이 없습니다. 
			$url = "main_img.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	}
		$no = $_POST['no'];
		$jpg_name = $_POST['jpg_nameA'];
		$jpg_memo = $_POST['jpg_memoA'];
		$view_no  = $_POST['view_noA'];

		$SQL = "update {$tkher['tkher_main_img_table']} set jpg_name = '$jpg_name', jpg_memo = '$jpg_memo', view_no = '$view_no' where no = $no";
		if ( ($result = sql_query( $SQL ) )==false )
		{
		  printf("Invalid query: %s \n", $SQL);
			m_("Update error occurred.");	// \\n Update 오류가 발생하였습니다. 
			//exit();
		} else {
			m_(" Title, Message, display order changed.");	// \\n Title , Message, display 순서를 변경 하였습니다. 
		}
}
else if($mode == "Delete_Image") {

	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");	// \\n 권한이 없습니다. 
			$url = "main_img.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	}
		$no = $_POST['no'];
		$SQL = "delete from {$tkher['tkher_main_img_table']} where no = $no ";
		if ( ($result = sql_query( $SQL ) )==false ){
			printf("Invalid query: %s \n", $SQL); 
			//Invalid query: delete from tkher_main_img where no = 100 - 2_78281.jpg, App Generator<br>Program Generator<br>Source Code DownLoad
			m_("A delete error occurred.");	// \\n delete 오류가 발생하였습니다. 
			exit();
		} else {
			m_(" Deleted.");	// \\n 삭제 하였습니다. 
		}
}
else if($mode == "Insert_func") {

	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");	// \\n 권한이 없습니다. 
			$url = "main_img.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	}
        $jpg_name = $_POST['jpg_name'];
        $jpg_memo = $_POST['jpg_memo'];
		$cd = 'main';		//$jpg[0];	
		$nm = 'main';		//$jpg[1];
        $f_path = KAPP_PATH_T_ . "/data/main_scroll_image/";	//---------------------------------- 보완 OK.
		$in_date = time();

		$file_ = $_FILES["file"]["name"];
		if ( $_FILES["file"]["error"] > 0){ 
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>"; 
		} else { 
				if ( file_exists( $f_path . $_FILES["file"]["name"])) 
				{ 
						echo $_FILES["file"]["name"] . " I have the same file.";	// 동일한 파일을 덭었습니다. 
						move_uploaded_file($_FILES["file"]["tmp_name"], $f_path . $_FILES["file"]["name"] );
						$SQL = "INSERT INTO {$tkher['tkher_main_img_table']} SET jpg_name='$jpg_name', jpg_file='$file_', jpg_memo='$jpg_memo', group_code='$cd', group_name='$nm', view_no='99', userid='tkher'  ";
						if ( ($result = sql_query( $SQL ) )==false )
						{
							printf("Invalid query: %s \n", $SQL);
							m_("Registration error occurred.");	// \\n 등록 오류가 발생하였습니다. 
							//exit();
						} else {
							m_(" Registered.");	// \\n 등록 하였습니다. 
						}
				} else {														// 동일한 파일이 없다면
						move_uploaded_file($_FILES["file"]["tmp_name"], $f_path . $_FILES["file"]["name"] );
						$SQL = "INSERT INTO {$tkher['tkher_main_img_table']} SET jpg_name='$jpg_name', jpg_file='$file_', jpg_memo='$jpg_memo', group_code='$cd', group_name='$nm', view_no='99', userid='tkher'  ";
						if ( ($result = sql_query( $SQL ) )==false )
						{
						  printf("Invalid query: %s \n", $SQL);
							m_("Registration error occurred.");	// \\n 등록 오류가 발생하였습니다. 
							//exit();
						} else {
							m_(" Registered.");	// \\n 등록 하였습니다. 
						}
				}
		}

}

?>

<script language="JavaScript"> 
<!-- 
	function upload_func(no, i){

		document.form2.no.value		= no;
		document.form2.i.value			= i;
		document.form2.mode.value	= 'File_Change';
		document.form2.submit();
	}

	function check(x){
		if(x.jpg_name.value==''){
			alert('Please enter a title.');	//타이틀을 입력 하세요.
			x.jpg_name.focus();
			return false;
		}
		else if(x.temp_name.value==''){
			alert('Please enter a file.');	//화일을 입력 하세요.
			x.temp_name.focus();
			return false;
		}
		else{
			document.form1.submit();
			return true;
		}
	}

	function del_check(no, i, lev){
		if( lev < 7) {
			alert('not eligible ' + lev);
			return false;
		}
		yn = confirm('Are you sure you want to delete the image?');	// \n 이미지을 삭제 하시겠습니까?
		if ( yn == true ) {
			document.form2.mode.value='Delete_Image';
			document.form2.no.value	= no;
			document.form2.submit();
		}
		else return false;
	}


	function update_func(no, i){
		jpg_name	= document.form2["jpg_name[" + i + "]"].value;
		jpg_memo	= document.form2["jpg_memo[" + i + "]"].value;
		view_no		= document.form2["view_no[" + i + "]"].value;
		document.form2.jpg_nameA.value	= jpg_name;
		document.form2.jpg_memoA.value	= jpg_memo;
		document.form2.view_noA.value	= view_no;
		document.form2.mode.value		= 'Update_func';
		document.form2.no.value			= no;
		form2.submit();
	}

	function time_func(x){
		if( document.form1.slide_time.value == ''){
			alert(' Enter time in 1000s!');
			document.form1.slide_time.focus();
			return false;
		} else {
			document.form1.mode.value="Time_Change";
			document.form1.submit();
		}
	}
	function insert_func() {
		if(!document.form1.jpg_name.value) {
			alert('Please enter a title!');
			document.form1.jpg_name.focus();
			return;
		}
		if(!document.form1.jpg_memo.value) {
			alert('Please enter a Message!');
			document.form1.jpg_memo.focus();
			return;
		}

		document.form1.mode.value = 'Insert_func';

		document.form1.submit();
	}
 -->
</script>
<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/include/css/dddropdownpanel.css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/dddropdownpanel.js"></script>
</head>
<?php
	$SQL = "SELECT * from {$tkher['tkher_my_control_table']} where userid='tkher' ";
	$result = sql_query( $SQL );
	$tot = sql_num_rows( $result );
	if( !$tot ){
		$slide_time=6000;
		$SQL = "INSERT {$tkher['tkher_my_control_table']} SET userid='tkher', slide_time=$slide_time ";
		sql_query( $SQL );
	} else {
		$row = sql_fetch_array( $result );
		$slide_time=$row['slide_time'];
	}
?>
<body bgcolor="#FFFFFF" text="#000000" topmargin="0" leftmargin="0">
<center>
		<?php 
		$cur='C';
		include_once( KAPP_PATH_T_ . "/menu_run.php"); 
		?>
<h2>Main Slide Image Management</h2>
<!-- --------------------------------------------------------------------- -->
<div id="mypanel" class="ddpanel">
	<div id="mypanelcontent" class="ddpanelcontent">
		<table border=0 bgcolor='#666666' width=100%>
			<form name='form1' action='main_img.php' method='post' enctype="multipart/form-data" >
				<input type='hidden' name='mode'	 value=''>
					<tr style="border-style:;background-color:cyan;color:black;height:25;width:300;" >
					<td align=right><font color=black>&nbsp; Slide Time:</td>
					<td>
							<input type="text" name="slide_time" style='border:1 black solid;height:25;width:50' value='<?=$slide_time?>' title='1 second -1000'>
							&nbsp;<input type='button' value='Time_Change' onClick='javascript:time_func(this)' style="border-style:;background-color:blue;color:yellow;height:30;width:100;"> 
					</td>
					<tr style="border-style:;background-color:cyan;color:black;height:25;width:300;" >
						<td bgcolor='#f4f4f4' height=30 width=120 align=right><font color=black>&nbsp;Image</td>
						<td><input type="file" name="file" size="50" style='border:1 black solid;'></td>
					</tr>
					<tr style="border-style:;background-color:cyan;color:black; " >
						<td bgcolor='#f4f4f4' height=30 width=120 align=right><font color=black>&nbsp;Title</td>
						<td><input type=text name='jpg_name' value='' style="border-style:;background-color:white;color:black;height:30;width:300;"></td>
					</tr>
					<tr style="border-style:;background-color:cyan;color:black;height:60;width:600;">
						<td bgcolor='#f4f4f4' height=30 width=120 align=right><font color=black>&nbsp; Memo</td>
						<td>
							<textarea id='jpg_memo' name='jpg_memo' style="border-style:;background-color:white;color:black;height:60;width:600;" ></textarea>
							
						</td>
					</tr>
					<tr style="border-style:;background-color:cyan;color:black;height:30;width:300;" >
						<td colspan=2 align='center'>&nbsp;<input type='button'  onclick='insert_func()' value=' Insert ' style="border-style:;background-color:blue;color:yellow;height:30;width:100;"></td>
					</tr>
		</form>
		</table>
	</div>
	<div id="mypaneltab" class="ddpaneltab"><a href="#"><span style="border-style:;background-color:;color:yellow;"><b>&#9776; Main Image Insert</b></span></a></div>

</div>
<table border="1" width=100% cellspacing="0" bordercolor="#C0C0C0" bordercolordark="#FFFFFF" bordercolorlight="#FFFFFF" align='center'>
	<tr>
		<td bgcolor="#C0C0C0" align='center'><font color="#FFFFFF">Image </font></td>
		<td bgcolor="#C0C0C0" align='center'><font color="#FFFFFF">Title / Message </font></td>
		<td bgcolor="#C0C0C0" align='center' title='Output Order'><font color="#FFFFFF">no</td>
		<td bgcolor="#C0C0C0" align='center'><font color="#FFFFFF">CTL</td>
	</tr>
	<form name='form2' action='main_img.php' method='post' enctype='multipart/form-data'>
					<input type='hidden' name='i'				value=''>
					<input type='hidden' name='no'			value=''>
					<input type='hidden' name='jpg_nameA'		value=''>
					<input type='hidden' name='jpg_memoA'		value=''>
					<input type='hidden' name='view_noA'		value=''>
					<input type='hidden' name='mode'			value=''>
					<input type='hidden' name='sel_g'			value=''>
<?php
	$SQL = "SELECT * from {$tkher['tkher_main_img_table']} where userid='tkher'  order by view_no, no";
	if( ($result = sql_query( $SQL ) )==false ){
	  printf("Invalid query: %s \n", $SQL);
	  exit();
	} else {
		$i=0;
		$selx = "selected";
		while ($row = sql_fetch_array( $result )) {
				$no				= $row['no'];
				$jpg_name		= $row['jpg_name'];
				$jpg_file			= $row['jpg_file'];
				$jpg_memo		= $row['jpg_memo'];
				$group_code	= $row['group_code'];
				$g_name	= $row['group_name'];

		echo "	
			<tr>
				<td align='center'><img src='".KAPP_URL_T_."/data/main_scroll_image/".$row['jpg_file']."' width='300' height='200' title='$jpg_file'></td>
				<td align='left'>
						Group:".$row['group_name']."<br>
						Title:<br>
					<input type='text' name='jpg_name[$i]' value='".$row['jpg_name']."' size=20><br>
						Message:<br>
					<textarea id='jpg_memo' name='jpg_memo[$i]' style='border-style:;background-color:cyan;color:black;height:60;width:350;' >".$row['jpg_memo']."</textarea>
						<br><label for='file'>Filename:</label>
					<input type='file' name='file_$i' id='file'><br>
					<input type='button' value='File_Change' onclick=\"javascript:upload_func($no, '$i')\" title='Change the file.'>
				</td>
				";

		echo "	&nbsp;
				<td align='center'><input type='text' name='view_no[$i]' value='".$row['view_no']."' size=2 title='Output Order.'>&nbsp;
				</td>
				<td align='center'>
					<input type=button value='Update' onclick=\"javascript:update_func($no, '$i');\" style='height:22px;background-color:blue;color:yellow;border:1 solid black' title=' Change the title.'><br><br>
					<input type=button value='Delete_Image' onclick=\"javascript:del_check($no, '$i', '$H_LEV' )\" style='height:22px;background-color:red;color:white;border:1 solid black' title='Delete the image.'>
				</td>
			</tr>
			";

			$i++;
		} //while

	}
?>
</form>
</table>
