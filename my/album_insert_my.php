<?php
	include_once('../tkher_start_necessary.php');
		/*
		*   album_insert_my.php : 이미지 슬라이드.
		*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<?php

		$H_ID			= get_session("ss_mb_id");
		if( isset($member['mb_level']) ) $H_LEV	= $member['mb_level'];
		else $H_LEV =''; 
		if( isset($_POST['mode']) ) $mode = $_POST['mode']; //m_("mode: " . $mode);
		else $mode ='';
		if( isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode']; //m_("mode: " . $mode);
		else $mode ='';

		if( isset($_POST['g_name']) ) $g_name = $_POST['g_name']; //m_("mode: " . $mode);
		else $g_name ='';
		if( isset($_POST['no']) ) $no = $_POST['no'];
		else $no = 0;

		$g_code = time(); //$H_ID . time(); m_(" my mode: " . $mode);

	if( $mode == 'insert_group1') {
		$ls = "SELECT * from {$tkher['sajin_group_table']} where g_name='$g_name' and userid='$H_ID' ";
		$result = sql_query( $ls);
		$rs = sql_num_rows($result);
		if( $rs > 0 ) {
			echo "<script>alert('\'$g_name\' Already exists.');history.back();</script>";// 이미 존재합니다
		} else {
			$ls = "insert into {$tkher['sajin_group_table']} set g_name='$g_name', g_code='$g_code', userid='$H_ID' ";
			$result = sql_query( $ls );
			if( $result ) m_("Insert OK!");
			else m_("group insert error --- ");
			$url = "album_insert_my.php";
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	} else if( $mode == 'update_group1') {
			$g_name_update = $_POST['g_name_update'];
			$sql = "update {$tkher['sajin_group_table']} set g_name='$g_name_update' where g_name='$g_name' and userid='$H_ID' ";
			$rs = sql_query(  $sql );

			$sql = "update {$tkher['tkher_main_img_table']} set group_name='$g_name_update' where group_name='$g_name' and userid='$H_ID' ";
			$rs = sql_query(  $sql );
			$url = "album_insert_my.php";
			echo "<script>window.open('$url', '_self', '');</script>";
	}
	else if( $mode == "File_Change") {
			$i = $_POST[i];
			$fnm = "file_" . $i;
			$filenm = $_FILES[$fnm]['name'];

			$f_path = KAPP_PATH_T_ . "/file/" . $H_ID . "/";
			$in_date = time();
		if ( $_FILES[$fnm]["error"] > 0){
			echo "Return Code: " . $_FILES[$fnm]["error"] . "<br>";
		} else {
			if ( file_exists( $f_path . $filenm ) ) {
				echo $_FILES[$fnm]["name"] . " I have the same file. Covered.";// 동일한 파일이 있습니다. 덮었습니다.
				move_uploaded_file($_FILES[$fnm]["tmp_name"], $f_path . $filenm );
			} else {
				move_uploaded_file($_FILES[$fnm]["tmp_name"], $f_path . $filenm );
			}
		}
		if( $filenm ) {
			$file_ext  = explode(".", $filenm );
			$file_nm   = strtolower( $file_ext[0]);
			$file_type = strtolower( $file_ext[1]);
			$SQL = "update {$tkher['tkher_main_img_table']} set jpg_file='$filenm', jpg_name='$filenm', jpg_memo='$filenm' where userid='$H_ID' and no = $no";
			if( ($result = sql_query( $SQL ) )==false ){
				printf("Invalid query: Whole query: %s\n", $SQL);
				m_(" Update error occurred.");
				exit();
			} else {
				m_(" The image file has been changed. ");
			}
		}
	}
	else if( $mode=="Time_Change" ){
		$tb = $tkher['tkher_my_control_table'];
			$slide_time = $_POST['slide_time'];
				//m_("tkher_my_control_table: " . $tb . ", time:" . $slide_time );// tkher_my_control_table: kapp_tkher_my_control, time:5000

			$SQL = "SELECT * from {$tkher['tkher_my_control_table']} where userid='$H_ID' ";
			$result = sql_query($SQL);
			$row = sql_num_rows($result);
			if( $row > 0 ){
				$SQL = "update {$tkher['tkher_my_control_table']} set slide_time=".$slide_time." where userid='$H_ID' ";
				$result = sql_query( $SQL );
				if( $result ){
					m_("Update my_control_table OK");
				} else	{
					m_(" Time record Update error. "); //	printf("Invalid query: %s \n", $SQL);	m_("An error has occurred. ");	exit;
				}
			} else {
				$SQL = "insert into {$tkher['tkher_my_control_table']} set userid= '$H_ID', slide_time=".$slide_time;
				if( ($result = sql_query( $SQL ) )==false ){
					m_("my_control_table, insert error");
					echo "sql:" . $SQL; exit;
					//sql:insert into kapp_tkher_my_control set userid= 'solpakan@naver.com', slide_time=5000
				} else	{
					m_(" Time record insert OK. "); //	printf("Invalid query: %s \n", $SQL);	m_("An error has occurred. ");	exit;
				}
			}
	}
	else if( $mode == "group_change") {
			//if( isset($_REQUEST['jpg_group']) ) $g_name = $_REQUEST['jpg_group'];
			if( !$g_name) return;
			$aa = explode(":", $g_name);
			$cd = $aa[0];
			$nm = $aa[1];
			$SQL = "update {$tkher['tkher_main_img_table']} set group_code= '$cd', g_name= '$nm' where no = $no";
			if ( ($result = sql_query( $SQL ) )==false )
			{
			  printf("Invalid query: %s \n", $SQL);
				m_("An error has occurred. ");
				exit();
			} else {
				m_(" Classification changed. ");
			}
	}
	else if( $mode == "Update_func") {

			$jpg_name= $_POST['jpg_nameA'];
			$jpg_memo= $_POST['jpg_memoA'];
			$view_no = $_POST['view_noA'];
			$jpg_    = $_POST['sel_g'];
			$jpg     = explode(':', $jpg_);
			$cd = $jpg[0];
			$nm = $jpg[1];
			$SQL="update {$tkher['tkher_main_img_table']} set jpg_name='$jpg_name', jpg_memo='$jpg_memo', view_no='$view_no', group_code='$cd', group_name='$nm' where no=$no";
			if ( ($result = sql_query( $SQL ) )==false )
			{
			  printf("Invalid query: %s \n", $SQL);
				m_("Update error occurred. ");
			} else {
				m_(" Title, Message, display order changed. ");
			}
	} else if( $mode == "Delete_Image") {
			$jpg_nameA = $_POST['jpg_nameA'];
			$SQL = "delete from {$tkher['tkher_main_img_table']} where no = $no ";
			if ( ($result = sql_query( $SQL ) )==false )
			{
			  printf("Invalid query: %s \n", $SQL);
				m_("A delete error occurred.");	// \\n delete 오류가 발생하였습니다.
				exit();
			} else {
				//$del_file = KAPP_PATH_ . "/cratree/" . $H_ID . "/" . $jpg_nameA;;
				$del_file = KAPP_PATH_T_ . "/file/" . $H_ID . "/" . $jpg_nameA;;
				exec ("rm $del_file");
				m_(" Deleted. , file:$del_file");	// \\n 삭제 하였습니다.
			}
	} else if( $mode == "Insert_func") {
			$jpg_name = $_POST['jpg_name'];
			$jpg_memo = $_POST['jpg_memo'];
			$jpg_ = $_POST['sel_g_name'];
			$jpg = explode(':', $jpg_);
			$cd = $jpg[0];
			$nm = $jpg[1]; //m_("jpg_:". $jpg_);
			$f_path1 = KAPP_PATH_T_ . "/file/" . $H_ID;
			$f_path  = $f_path1 . "/";
			$in_date = time();
			$file_ = preg_replace("/\s+/","", $_FILES["file"]["name"] );	//m_("file_: " . $file_);
			if( $_FILES["file"]["error"] > 0){
				echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			} else {

				if( !is_dir($f_path1) ) { // userid Dir 
					if( !@mkdir( $f_path1, 0755 ) ) {
						echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
						m_(" Error: f_path1 : " . $f_path1 . " Failed to create directory. ");
						exit;
					}
				}
				if( file_exists( $f_path . $file_)){
						echo $file_ . " I have the same file. "; // 동일한 파일을 덭었습니다.
						move_uploaded_file($_FILES["file"]["tmp_name"], $f_path . $file_ );
						$SQL = "INSERT INTO {$tkher['tkher_main_img_table']} SET jpg_name='$jpg_name', jpg_file='$file_', jpg_memo='$jpg_memo', group_code='$cd', group_name='$nm', view_no=1, delay_time=3000, userid='$H_ID'  ";
						if( ($result = sql_query( $SQL ) )==false ){
						  printf("Invalid query: %s \n", $SQL);
							m_("Registration error occurred.");// \\n 등록 오류가 발생하였습니다.
						} else {
							m_(" Registered. ");// \\n 등록 하였습니다.
						}
				} else {
						move_uploaded_file($_FILES["file"]["tmp_name"], $f_path . $file_ );
						$SQL = "INSERT INTO {$tkher['tkher_main_img_table']} SET jpg_name='$jpg_name', jpg_file='$file_', jpg_memo='$jpg_memo', group_code='$cd', group_name='$nm', view_no=1, userid='$H_ID'  ";
						if( ($result = sql_query( $SQL ) )==false ){
						  printf("Invalid query: %s \n", $SQL);
						  //query: INSERT INTO {$tkher['tkher_main_img_table']} SET jpg_name='표지1', jpg_file='1표지 배경.jpg', jpg_memo='표지', group_code='solpakan@naver.com1712117189', group_name='배경사진', view_no=1, userid='solpakan@naver.com'
							m_("Registration error occurred.");// \\n 등록 오류가 발생하였습니다.
						} else {
							m_(" Registered.");// \\n 등록 하였습니다.
						}
				}
			}
	}
?>
<script language="JavaScript">
<!--
	function ValidateSize(file, i) {
		var files = document.getElementById('files[' + i + ']').files;
		if (!files.length) {
		  alert('Please select a file! len:'+files.length);
		  return;
		} else{
		  nm=files[0].name;
		  document.form2.fnm.value = nm;
		  document.form2["jpg_name[" + i + "]"].value = nm;
		  document.form2["jpg_memo[" + i + "]"].value = nm;
		  sz=files[0].size;
		  //alert(' len:'+files.length + ' , nm:' + nm+ ' , sz:' + sz);
		  return;
		}
    }
  function upload_func(no, i){
		if (window.File && window.FileReader && window.FileList && window.Blob) {
		} else {
		  alert('The File APIs are not fully supported in this browser.');
		  return false;
		}
		fnm = document.form2.fnm.value;
		if( !fnm ) {
			alert('Pease! select file '); return false;
		} else {
			document.form2.no.value		= no;
			document.form2.i.value			= i;
			document.form2.mode.value	= 'File_Change';
			document.form2.submit();
		}
	}
	function check(x){
		if(x.jpg_name.value==''){
			alert('Title Check');
			x.jpg_name.focus();
			return false;
		}
		else if(x.temp_name.value==''){
			alert('No File Select!');
			x.temp_name.focus();
			return false;
		}
		else{
			document.form1.submit();
			return true;
		}
	}
	function del_check(no, i, file_nm){
		yn = confirm('Are you sure you want to delete the image? no:'+ no+', '+file_nm);// \n 이미지을 삭제 하시겠습니까?
		if ( yn == true ) {
			document.form2.mode.value='Delete_Image';
			document.form2.no.value	= no;
			document.form2.jpg_nameA.value=file_nm;
			document.form2.submit();
		}
		else return false;
	}
	function update_func(no, i){
		jpg_name	= document.form2["jpg_name[" + i + "]"].value;
		jpg_memo	= document.form2["jpg_memo[" + i + "]"].value;
		view_no		= document.form2["view_no[" + i + "]"].value;
		var selectIndex = form1.sel_g_name.selectedIndex;
		t2v=document.form1.sel_g_name[selectIndex].value;
		document.form2.sel_g.value		= t2v;
		document.form2.jpg_nameA.value	= jpg_name;
		document.form2.jpg_memoA.value	= jpg_memo;
		document.form2.view_noA.value	= view_no;
		document.form2.mode.value		= 'Update_func';
		document.form2.no.value			= no;
		form2.submit();
	}
	function time_func(x){
		if( document.form1.slide_time.value == ''){
			alert(' Enter time in 1000s! \n 시간을 1000단위로 입력하세요!');
			document.form1.slide_time.focus();
			return false;
		} else {
			document.form1.mode.value="Time_Change";
			document.form1.submit();
		}
	}
	function change_g_name_func(g_nm) {
		var gg = g_nm.split(":");
		g_code  = gg[0];
		g_name = gg[1];
		g_id = gg[2];
		g_no = gg[3];
		form1.g_name.value = g_name;
		form2.sel_g.value = g_nm;
		form1.g_name_update.value = g_name;
	}
	function update_group2_func() {
		form = document.form1;
		if(!form1.g_name_update.value) {
			alert('Please enter the group name to be changed.');
			form1.g_name_update.focus();
			return false;
		}
		g_name_update = form1.g_name_update.value;
		if( confirm( 'Do you want to change it? ' + g_name_update ) ) {
			form1.mode.value	= 'update_group1';
			document.form1.submit();
		}
		else return false;;
	}
	function insert_group1_func() {
		if(!document.form1.g_name.value) {
			alert('Please enter group name to add.');
			document.form1.g_name.focus();
			return;
		}
		document.form1.mode.value = 'insert_group1';
		document.form1.submit();
	}
	function insert_func() {
		var selectIndex = form1.sel_g_name.selectedIndex;
		t2v=document.form1.sel_g_name[selectIndex].value;
		t2t=document.form1.sel_g_name[selectIndex].text;
		if( t2v == '' ) {
			alert (' Please select a group! ');
			return false;
		}
		if(!document.form1.jpg_name.value) {
			alert('Please enter a title! ');
			document.form1.jpg_name.focus();
			return;
		}
		if(!document.form1.jpg_memo.value) {
			alert('Please enter a Message! ');
			document.form1.jpg_memo.focus();
			return;
		}
		document.form1.mode.value = 'Insert_func';
		document.form1.submit();
	}
	function img_ext(){
		fnm = document.form1.file.value;
		ff1 = fnm.split('\\');
		cnt = ff1.length;	//alert( "1 cnt: " + cnt );//cnt: 3
		cnt = cnt *1 - 1;
		fm = ff1[cnt];	//alert( "fm 0: " + fm ); //fm 0: 내지10 편리함을 즐기다.jpg
		ff = fm.split('.'); // 2, fnm: C:\fakepath\내지10 편리함을 즐기다.jpg, alert(cnt+ ", fnm: " + fnm + ", ff: " + ff[0]);
		document.form1.jpg_name.value = ff[0]; //2, fnm: C:\fakepath\내지20 요리 고려인삼의 다양한변신.jpg, ff: undefined
		document.form1.jpg_memo.value = ff[0]; //2, fnm: C:\fakepath\내지20 요리 고려인삼의 다양한변신.jpg, ff: undefined
	}
 -->
 </script>
<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/include/css/dddropdownpanel.css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/dddropdownpanel.js"></script>
</head>
<?php
	if( isset($_REQUEST['num']) ) $num = $_REQUEST['num'];
	else $num = 0;

	$SQL = "SELECT * from {$tkher['tkher_my_control_table']} where userid='$H_ID' ";
	$result = sql_query( $SQL );
	if( $result ){	//m_("my control query ok");
		$tot = sql_num_rows( $result );
		if( !$tot ){
			$slide_time=3000;
			$SQL = "INSERT {$tkher['tkher_my_control_table']} SET userid='$H_ID', slide_time='$slide_time' ";
			sql_query( $SQL );
		} else {
			$row = sql_fetch_array( $result );
			$slide_time = $row['slide_time'];
		}
	} else {
		m_("my control query first record no found error");
		$slide_time=3000;
	}
	//m_("slide_time: " . $slide_time);
?>
<body bgcolor="#FFFFFF" text="#000000" topmargin="0" leftmargin="0">
<center>
<div id="mypanel" class="ddpanel">
<div id="mypanelcontent" class="ddpanelcontent">
<table border=0 bgcolor='#666666' width=100%>

	<FORM name='form1' action='album_insert_my.php' method='post' enctype="multipart/form-data" >
		<input type='hidden' name='mode'	 value=''>
			<tr>
				<td bgcolor='#f4f4f4' height=30 width=120 align=right><font color=black>&nbsp; Group </td>
				<td bgcolor='#ffffff'>
					<select name='sel_g_name' onchange="change_g_name_func(this.value);" style="border-style:;background-color:white;color:black;height:25;width:120;">
						<option value=''>Image Group</option>
		<?php
							$temp_g_name = '';
							$result = sql_query( "SELECT * from {$tkher['sajin_group_table']} where userid='$H_ID' order by g_name asc" );
							if( $result ){
								while( $rs = sql_fetch_array($result)) {
									if( $temp_g_name != $rs['g_name']) {
										$temp_g_name = $rs['g_name'];
		?>
										<option value="<?=$rs['g_code']?>:<?=$rs['g_name']?>:<?=$rs['userid']?>:<?=$rs['no']?>"
										<?php if( $rs['g_name']==$g_name) echo "selected"; ?>><?=$rs['g_name']?></option>
		<?php
									}
								}//while
							}//if
		?>
					</select>
		<?php
				if ( $H_ID ) {
		?>
						&nbsp; &nbsp;
						<input type='text' name='g_name' value='<?=$g_name?>' style="border-style:;background-color:white;color:black;height:25;width:120;">
						<input type=button onclick="javascript:insert_group1_func();" value=' Group-Insert ' style="border-style:;background-color:blue;color:yellow;height:30;width:120;">
						&nbsp; &nbsp;
		<?php
						if( $H_LEV > 7 or $H_ID == $userid) {
		?>
							<input type='text' name='g_name_update' value='<?=$g_name?>' style="border-style:;background-color:white;color:black;height:25;width:120;" >
							<input type='button' value='Group-Change' onclick="javascript:update_group2_func();" style="border-style:;background-color:blue;color:yellow;height:25;width:130;" <?php echo "title='Change the category name. ' "; ?> >
		<?php
						}
				} else {
		?>
						You can register after login
		<?php
				}
		?>
				</td>
			</tr>
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
				<td><input type=text name='jpg_name'  onclick='img_ext()' value='' style="border-style:;background-color:white;color:black;height:30;width:300;"></td>
			</tr>
			<tr style="border-style:;background-color:cyan;color:black;height:60;width:600;">
				<td bgcolor='#f4f4f4' height=30 width=120 align=right><font color=black>&nbsp; Memo</td>
				<td>
					<textarea id='jpg_memo' name='jpg_memo' style="border-style:;background-color:white;color:black;height:60;width:600;" ></textarea>

				</td>
			</tr>
			<tr style="border-style:;background-color:cyan;color:black;height:30;width:300;" >
				<td colspan=2 align=center>&nbsp;<input type='button'  onclick='insert_func()' value=' Insert ' style="border-style:;background-color:blue;color:yellow;height:30;width:100;"></td>
			</tr>
</form>
</table>
</div>
<div id="mypaneltab" class="ddpaneltab">
<a href="#"><span><font color=grace>▤ My Imag Insert ▤</span> </a>
</div>
</div>
		<?php
		$cur='C';
		//include "../menu_run.php";
		?>
<table border="1" width='100%' cellspacing="0" bordercolor="#C0C0C0" bordercolordark="#FFFFFF" bordercolorlight="#FFFFFF" align='center'>
	<tr>
		<td bgcolor="#C0C0C0" align=center><font color="#FFFFFF">Image</font></td>
		<td bgcolor="#C0C0C0" align=center><font color="#FFFFFF">Title / Message</font></td>
		<td bgcolor="#C0C0C0" align=center title='Output Order '><font color="#FFFFFF">no</td>
		<td bgcolor="#C0C0C0" align=center><font color="#FFFFFF">CTL</td>
	</tr>

	<form name='form2' action='album_insert_my.php' method='post' enctype='multipart/form-data'>
					<input type='hidden' name='i'				value=''>
					<input type='hidden' name='no'			value=''>
					<input type='hidden' name='jpg_nameA'		value=''>
					<input type='hidden' name='jpg_memoA'		value=''>
					<input type='hidden' name='view_noA'		value=''>
					<input type='hidden' name='mode'			value=''>
					<input type='hidden' name='sel_g'			value=''>
					<input type='hidden' name='fnm'			value=''>
<?php
	$SQL = "SELECT * from {$tkher['tkher_main_img_table']} where userid='$H_ID'  order by view_no, no";
	if( ($result = sql_query( $SQL ) )==false ){
	  printf("Invalid query: %s \n", $SQL);
	  exit();
	} else {
		$i=0;
		$selx = "selected";
		while( $row = sql_fetch_array( $result )) {
				$noA		= $row['no'];
				$jpg_name	= $row['jpg_name'];
				$jpg_file	= $row['jpg_file'];
				$f_path 	= KAPP_URL_T_ . "/file/" . $H_ID . "/" . $row['jpg_file'];
				$jpg_memo	= $row['jpg_memo'];
				$group_code	= $row['group_code'];
				$g_name		= $row['group_name'];
		echo "<tr>
				<td align='center'><img src='$f_path' width='300' height='200' title='$jpg_file'></td>
				<td align='left'>Group:".$row['group_name']."<br>Title:<br>
					<input type='text' name='jpg_name[$i]' value='".$row['jpg_name']."' size='20' readonly><br>memo:<br>
					<textarea id='jpg_memo' name='jpg_memo[$i]' style='border-style:;background-color:cyan;color:black;height:60;width:350;' >".$row['jpg_memo']."</textarea><br><label for='file'>Filename:</label>
					<input type=\"file\"  onchange=\"ValidateSize(this, $i )\" name='file_$i' id='files[$i]'><br>
					<input type=button value='File_Change' onclick=\"javascript:upload_func('$noA', $i )\" title='Change the file. '>
				</td>";

		echo "<td align='center'><input type=text name='view_no[$i]' value='".$row['view_no']."' size=2 title='Output Order.'></td>
				<td align='center'>
					<input type=button value='Update' onclick=\"javascript:update_func('$noA', '$i');\" style='height:22px;background-color:blue;color:yellow;border:1 solid black' title=' Change the title.'><br><br>
					<input type=button value='Delete_Image' onclick=\"javascript:del_check('$noA', '$i', '".$row['jpg_file']."' )\" style='height:22px;background-color:red;color:white;border:1 solid black' title=' Delete the image.'></td>
			</tr>";
			$i++;
		} //while

	}
?>
</form>
</table>
