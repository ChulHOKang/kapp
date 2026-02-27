<?php
	include_once('../tkher_start_necessary.php');
?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="../icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>

<?php
		/*
		*   main_img.php : table:tkher_main_img
		*   tkher_my_control : /data/main_scroll_image/
		    main_img_list.php
		*/
		$ss_mb_id = get_session("ss_mb_id");
		$H_ID = get_session("ss_mb_id");  
		$H_LEV = $member['mb_level'];
		if( isset($_POST['mode']) ) $mode = $_POST['mode'];
		else $mode = '';
		if( isset($_POST['no']) ) $no = $_POST['no'];
		else $no = '';
		if( isset($_POST['num']) ) $num = $_POST['num'];
		else $num = '';
if( $mode == "File_Change") {
	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");
			$url = "main_img.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	}
	if( isset($_POST['i']) ) $i = $_POST[i];
	else $i = 0;
	$fnm = "file_" . $i;
	$filenm = $_FILES[$fnm]['name'];
	$f_path = KAPP_PATH_T_ . "/data/main_scroll_image/";
	$in_date = time();
	if ( $_FILES["file[$i]"]["error"] > 0){ 
		echo "Return Code: " . $_FILES["$fnm"]["error"] . "<br>"; 
	} else { 
		if ( file_exists( $f_path . $filenm ) ) { 
			echo $_FILES["file"]["name"] . " I have the same file. Covered. ";
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
		if( ($result = sql_query( $SQL ) )==false ){
			m_(" Update error occurred.");
			exit();
		} else {
			m_(" The image file has been changed.");
		}
	}
}
if( $mode=="Time_Change" ){
	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");
		$url = "main_img.php";
		echo "<script>window.open('./', '_self', '');</script>";
	}
	$slide_time=$_POST['slide_time'];
	$SQL = "update {$tkher['tkher_my_control_table']} set slide_time= '$slide_time' where userid='tkher' ";
	if( ($result = sql_query( $SQL ) )==false ){
		echo "Invalid query: " . $SQL;
		m_("An error has occurred.");
		exit;
	} else {
		m_(" Time changed.");
	}
}
if($mode == "Update_func") {

	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");
			$url = "main_img.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	}
		$no = $_POST['no'];
		$jpg_name = $_POST['jpg_nameA'];
		$jpg_memo = $_POST['jpg_memoA'];
		$view_no  = $_POST['view_noA'];

		$SQL = "update {$tkher['tkher_main_img_table']} set jpg_name = '$jpg_name', jpg_memo = '$jpg_memo', view_no = '$view_no' where no = $no";
		if( ($result = sql_query( $SQL ) )==false ){
			m_("Update error occurred.");		//exit();
		} else {
			m_(" Title, Message, display order changed.");
		}
} else if( $mode == "Delete_Image") {
	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");
			$url = "main_img.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	}
	if( isset($_POST['no']) ){
		$no = $_POST['no'];
		if( isset($_POST['jpg_nameA']) ) $jpg_nameA = $_POST['jpg_nameA'];
		if( isset($_POST['jpg_fileA']) ) $jpg_fileA = $_POST['jpg_fileA'];
		$SQL = "delete from {$tkher['tkher_main_img_table']} where no = $no ";
		if( ($result = sql_query( $SQL ) )==false ){
			m_("A delete error occurred.");
			exit();
		} else {
			$del_file = KAPP_PATH_T_ . "/data/main_scroll_image/" . $jpg_fileA; 
			exec ("rm $del_file");
			m_("no:$no, jpg_name: $jpg_nameA, Deleted.");
		}
	} else m_("ERROR delete no null");
} else if( $mode == "Insert_func") {
	if( $H_LEV < 8 ) {
		m_(" You do not have permission.");
			$url = "main_img.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	} else {
        $jpg_name = $_POST['jpg_name'];
        $jpg_memo = $_POST['jpg_memo'];
		$cd = 'main';
		$nm = 'main';
        $f_path = KAPP_PATH_T_ . "/data/main_scroll_image/";
		$in_date = time();
		$file_ = $_FILES["file"]["name"];
		if( $_FILES["file"]["error"] > 0){ 
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>"; 
		} else { 
			if( file_exists( $f_path . $_FILES["file"]["name"])) { 
				echo $_FILES["file"]["name"] . " I have the same file.";
				move_uploaded_file($_FILES["file"]["tmp_name"], $f_path . $_FILES["file"]["name"] );
				$SQL = "INSERT INTO {$tkher['tkher_main_img_table']} SET jpg_name='$jpg_name', jpg_file='$file_', jpg_memo='$jpg_memo', group_code='$cd', group_name='$nm', view_no='99', userid='tkher'  ";
				if( ($result = sql_query( $SQL ) )==false ){
					printf("Invalid query: %s \n", $SQL);
					m_("Registration error occurred.");	//exit();
				} else {
					m_(" Registered.");
				}
			} else {
				move_uploaded_file($_FILES["file"]["tmp_name"], $f_path . $_FILES["file"]["name"] );
				$SQL = "INSERT INTO {$tkher['tkher_main_img_table']} SET jpg_name='$jpg_name', jpg_file='$file_', jpg_memo='$jpg_memo', group_code='$cd', group_name='$nm', view_no='99', userid='tkher'  ";
				if( ($result = sql_query( $SQL ) )==false ){
					m_("Registration error occurred.");
				} else {
					m_(" Registered.");
				}
			}
		}
	} //8
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
		if( x.jpg_name.value==''){
			alert('Please enter a title.');
			x.jpg_name.focus();
			return false;
		}else if(x.temp_name.value==''){
			alert('Please enter a file.');
			x.temp_name.focus();
			return false;
		}else{
			document.form1.submit();
			return true;
		}
	}
	function del_check( no, i, lev , img_file, img_name){
		if( lev < 7) {
			alert('not eligible ' + lev);
			return false;
		}
		document.form2.jpg_nameA.value	= img_name;
		document.form2.jpg_fileA.value	= img_file;
		yn = confirm('Are you sure you want to delete the image? delele file name:' + img_name + ", img_file: " + img_file);
		if( yn == true ) {
			document.form2.mode.value='Delete_Image';
			document.form2.no.value	= no;
			document.form2.submit();
		}else return false;
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
<?php
	$SQL = "SELECT * from {$tkher['tkher_my_control_table']} where userid='tkher' ";
	$result = sql_query( $SQL );
	$tot = sql_num_rows( $result );
	if( !$tot ){
		$slide_time=6000;
		$SQL = "INSERT {$tkher['tkher_my_control_table']} SET userid='tkher', slide_time='$slide_time' ";
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
<h style='font-size:25px;height:27px;'>[Main Slide Image Management]</h>
<FORM name='form1' action='main_img.php' method='post' enctype="multipart/form-data" >
	<div id="mypanel" class="ddpanel">
	<div id="mypanelcontent" class="ddpanelcontent">
		<table style="border-style:;background-color:#666666;color:black;color:white;height:30;width:100;width:100%;">
				<input type='hidden' name='mode'	 value=''>
					<tr>
					<td style="color:white;text-align:right;">Slide Time: </td>
					<td>
							<input type="text" name="slide_time" style='border:1 black solid;height:25;width:50' value='<?=$slide_time?>' title='1 second -1000'>
							&nbsp;<input type='button' value='Time_Change' onClick='javascript:time_func(this)' style="border-style:;background-color:blue;color:yellow;height:30;width:100;"> 
					</td>
					</tr>
					<tr>
						<td style="color:white;text-align:right;">Image: </td>
						<td style="color:white;text-align:left;"><input type="file" name="file" size="50" style='border:1 black solid;color:white;'></td>
					</tr>
					<tr>
						<td style="color:white;text-align:right;">Title: </td>
						<td><input type=text name='jpg_name' value='' style="border-style:;background-color:white;color:black;height:30;width:300;"></td>
					</tr>
					<tr>
						<td style="color:white;text-align:right;">Memo: </td>
						<td>
							<textarea id='jpg_memo' name='jpg_memo' style="border-style:;background-color:white;color:black;height:60;width:600;" ></textarea>
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">&nbsp;<input type='button'  onclick='insert_func()' value=' Insert ' style="border-style:;background-color:blue;color:yellow;height:30;width:100;text-align:center;"></td>
					</tr>
		</table>
	</div>
</FORM>
	<div id="mypaneltab" class="ddpaneltab" ><span style="background-color:;color:yellow;"><a href="#" style='height:25px;color:yellow;'>&nbsp; &#9776; Main Image Insert &nbsp;▼ &nbsp;</a></span></div>
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
					<input type='hidden' name='jpg_fileA'		value=''>
					<input type='hidden' name='jpg_memoA'		value=''>
					<input type='hidden' name='view_noA'		value=''>
					<input type='hidden' name='mode'			value=''>
					<input type='hidden' name='sel_g'			value=''>
<?php
	$SQL = "SELECT * from {$tkher['tkher_main_img_table']} where userid='tkher'  order by view_no, no";
	if( ($result = sql_query( $SQL ) )==false ){
	  printf("Invalid query: %s \n", $SQL);
	  m_("select error");
	  exit();
	} else {
		$i=0;
		$selx = "selected";
		while( $row = sql_fetch_array( $result )) {
				$no				= $row['no'];
				$jpg_name		= $row['jpg_name'];
				$jpg_file		= $row['jpg_file'];
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
					<input type='button' value='File_Change' onclick=\"javascript:upload_func('$no', '$i')\" title='Change the file.'>
				</td>
				";
		echo "	&nbsp;
				<td align='center'><input type='text' name='view_no[$i]' value='".$row['view_no']."' size=2 title='Output Order.'>&nbsp;
				</td>
				<td align='center'>
					<input type=button value='Update' onclick=\"javascript:update_func('$no', '$i');\" style='height:22px;background-color:blue;color:yellow;border:1 solid black' title=' Change the title.'><br><br>
					<input type=button value='Delete_Image' onclick=\"javascript:del_check( '$no', '$i', '$H_LEV', '".$jpg_file."', '".$jpg_name."' )\" style='height:22px;background-color:red;color:white;border:1 solid black' title='Delete the image.'>
				</td>
			</tr>
			";
			$i++;
		} //while
	}
?>
</form>
</table>
