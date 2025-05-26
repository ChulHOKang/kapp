<?php
	include_once('../tkher_start_necessary.php');

	$H_ID= get_session("ss_mb_id");	$H_LEV= $member['mb_level']; 
	$H_NICK = $member['mb_nick'];$H_NAME= $member['mb_name']; $ip = $_SERVER['REMOTE_ADDR'];
/*
  list1_detail.php : image type board - list1.php 에서 call
				   : list1_detail_update.php - admin_detail_func() , admin : board_list3_update.php - 속성 설정 old type
                   : inc_list1.php - include : image list,           admin : board_list3_update.php - 속성 설정 old type - admin_detail_func()
				   : memo.php      - include : memo write
				   : password_.php?infor="+infor + "&no=" +no+ "&page=" +page+ "&call_pg=list1_detail.php";
				: infor.php
				: file_size.php
				: string.php :  // Shorten_String($String, $MaxLen, $ShortenStr)
				: query_ok_new.php
*/
	//if( isset($_REQUEST['list_no']) ) {
	if( isset($_POST['list_no']) ) {
		$list_no= $_POST['list_no'];
		$no		= $_POST['list_no'];
		$page	= $_POST['page'];
		$mode	= $_POST['mode'];
		$search_text	= $_POST['search_text'];
		$search_choice	= $_POST['search_choice'];
	} else {
		$list_no	= $_REQUEST['list_no'];
		$no			= $_REQUEST['list_no'];
		$page		= $_REQUEST['page'];
		$mode		= $_REQUEST['mode'];
		$search_text= $_REQUEST['search_text'];
		$search_choice	= $_REQUEST['search_choice'];
	}
    $run_mode ='list1_detail';

	include "./infor.php";
	include "./file_size.php";
	include "./string.php";    // Shorten_String($String, $MaxLen, $ShortenStr)

	switch( $mf_infor[46] ){
		case '0': break;
		case '1': 	
			if( !$H_ID || $H_LEV < 2 ) { 
				//m_("You do not have permission to read."); 
				//echo "<script>history.back(-1);</script>"; exit;
			}
			//break;
		case '2': 
			if( $H_ID != $mf_infor[53] ) { 
				m_("You do not have permission to read."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
		case '3': 
			if( $H_LEV < 8 ) { 
				m_("You do not have permission to read."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
	}

	//m_("list_no:" . $_REQUEST['list_no']);

?>

<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Board - App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/board.css" type="text/css">
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/default.css" type="text/css">
<SCRIPT src="<?=KAPP_URL_T_?>/js/contents_resize.js" type=text/javascript></SCRIPT>

<script>
	function openpage(){
		//alert('---------------- openpage');
				infor=document.view_form.infor.value;
				//	alert('infor:'+infor);
				url = "password_.php?infor="+infor + "&no=" +no+ "&page=" +page+ "&call_pg=list1_detail.php";
				window.open(url,"new","width=600,height=300,scrollbars=no");
	}
	function board_view(infor, no, page){
			url = "password_.php?infor="+infor + "&no=" +no+ "&page=" +page+ "&call_pg=list1_detail.php";
			window.open(url,"new","width=600,height=300,scrollbars=no");
	}
	function del_func( infor, no, target_no, step, re){
		if(confirm("Are you sure you want to delete? ")==true){
			document.view_form.mode.value	='del_func';
			document.view_form.infor.value	=infor;
			document.view_form.target.value	=target_no;
			document.view_form.step.value	=step;
			document.view_form.re.value		=re;
			document.view_form.list_no.value	=no;
			document.view_form.no.value		=no;
			document.view_form.action='query_ok_new.php';
			view_form.submit();
		}
	}
	function admin_detail_func( infor, no ){
		//alert('list_no:'+no);
		//document.view_form.mode.value	='del_func';
		//document.view_form.target.value	=target_no;
		//document.view_form.step.value	=step;
		//document.view_form.re.value		=re;
		document.view_form.infor.value	=infor;
		document.view_form.list_no.value	=no;
		document.view_form.no.value		=no;
		
		//document.view_form.action='list1_detail_update.php'; //document.view_form.action='update.php';
		document.view_form.target="_blank";
		document.view_form.action='board_list3_update.php'; //document.view_form.action='update.php';
		document.view_form.submit();
	}
	
	function update_open( infor, list_no, page , search_choice , search_text ){
		//alert('list_no:'+list_no+ ', infor:' + infor);

		//document.view_form.target.value	=target_no;
		//document.view_form.step.value	=step;
		//document.view_form.re.value		=re;
		document.view_form.infor.value	 =infor;
		document.view_form.list_no.value =list_no;
		document.view_form.page.value    =page;
		document.view_form.search_choice.value =search_choice;
		document.view_form.search_text.value   =search_text;
		document.view_form.action='list1_detail_update.php';
		document.view_form.submit();
	}
</script>

<!--
<body bgcolor="#000000" text="#000000"  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<body bgcolor="#FFFFFF" text="#000000" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" onkeydown='' onLoad="frame_init()" onResize="" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
-->
<?php
	//조회수 증가

	if( $list_no > 0 ){
		$query="update aboard_".$mf_infor[2]." set cnt=cnt+1 where no='$list_no'";
		$mq=sql_query($query);
	}
	$mf_46 = $mf_infor[46];
	if ( !$mf_infor[46] ) {	// $mf_infor[46] 는 0 
	} else if ( !$mf_infor[46] and ($mf_infor[46] > $H_LEV) or !$H_ID ) {
		echo "<script>alert('You do not have read permissions! :'+$mf_46+' , LEV:'+$H_LEV); </script>";// \\n 현재 읽기 권한이 없습니다!!
		//	echo "<script> history.go(-1);</script>";
		//	exit;
	} else if( !$H_LEV && !$H_ID ) {
		//echo "<script>alert('로그인 필요!!! 현재 읽기 권한이 없습니다!!!!!. '); history.go(-1);</script>";
		//exit;
	}

	function auth() {
		echo "<script>openpage();</script>";
		/*
		global $security;
		
		echo "
		<form action='$PHP_SELF' method=post>
			<input type=hidden name=security value='$security' size=10>
			This is a private article. Please enter your password.<br>비공개 글입니다. 패스워드를 입력하여주십시오. <br>
			password : <input type=password name=security size=10>
			<input type=submit value='Confirm'>
		</form>
		";
		*/
		
	}

	//m_("infor:".$infor . ", list_no:". $list_no . ", mf_infor[2]:" . $mf_infor[2]); 
	//infor:126, list_no:24, mf_infor[2]:tkher126

	if( $list_no ) $query="SELECT * from aboard_" . $mf_infor[2] . " where no=$list_no ";
	else {
			$line_cnt	= $mf_infor[16];
			$orderby		= " order by target desc , step ";
			$where_		= " where subject like '%$searchT%' or context like '%$searchT%' ";
			$SQL1		= "SELECT * from aboard_" . $mf_infor[2];
			if( $mode=='SR' )	$SQL1 = $SQL1 . $where_ . $orderby;
			else				$SQL1 = $SQL1 . $orderby;
			if ( ($result = sql_query( $SQL1 ) )==false )
			{
				printf("Invalid query: %s\n", $SQL1);
				my_msg(" no found data Select Error ");
				$total_count = 0;
			} else {
				$total_count = sql_num_rows($result);
				if($total_count) $total_page  = ceil($total_count / $line_cnt);			// 전체 페이지 계산
				else $total_page  =1;
				
				if ($page < 2) {
					$page  = 1; 
					$start = 0;
				} else {
					$start = ($page - 1) * $line_cnt; 
				}
				$last = $line_cnt; 
				if( $total_count < $last) $last = $total_count;
			}
			$query="SELECT * from aboard_" . $mf_infor[2] . " order by target desc, step desc limit $start, $last ";
	}

	$mq		= sql_query($query);
	$mf		= sql_fetch_row($mq);

	//m_("mf-12 img:". $mf[12] . ", 2:" . $mf_infor[2]); // mf-12 img:dao_1549589819.jpg, 2:tkher126

	$mid		= $mf[2];
	$fsize		= GetFileSize_func($mf[14]);	//파일싸이즈 get_size
	// ------------------------------------------------- 2024-01-22
	if( strpos( $mf[16], "../" ) !== false) {
		$fpath	= $mf[16];       // new data format
	} else if( strpos( $mf[16], "./" ) !== false) { // old data
		$fpath	= "." . $mf[16]; // old data format
	} else {
		$fpath	= $mf[16]; // old data format
	}
	//---------------------------------------------------
	$mf[7]	= strftime("%Y/%m/%d &nbsp;%X", $mf[7]);
	$mf[8]	= iconv_substr($mf[8], 0, 50, 'utf-8');// . "...";
	//글형식
	$mf[9]	= stripslashes($mf[9]);
	if($mf[10] ==2){
		$mf[9] = htmlspecialchars($mf[9]);
		$mf[9] = nl2br($mf[9]);
	} else if($mf[10] ==3 || !$mf[10]) {
		$mf[9] = strip_tags($mf[9]);	// html TAG 제거.
		$mf[9] = nl2br($mf[9]);
	}
	if( $search_text ){ $mf[9] = preg_replace("($search_text)","<font color=blue>\\1</font>",$mf[9]);}
	$p			= $mf[21];	// 20->21
	$security= $_SESSION['security'];
	if( !$security ){
		//m_(" no security ");
	} else {
		if( $mf[21] != "" and $mf[21] != $security) {
			$page=$_POST['page'];
				//auth(); //m_(" password please enter! --------:$security , page:$page");
				echo "<script>board_view($infor, $list_no, $page );</script>";
				exit;
		} else $_SESSION['security']='';
	}
	//else m_(" pass ok! -------- security:$security, p:$p");

?>

<style type="text/css">
<!--
BODY{scrollbar-face-color: #ffffff;scrollbar-highlight-color: #bbbbbb;scrollbar-shadow-color: #bbbbbb;scrollbar-3dlight-color: #ffffff;scrollbar-arrow-color: #bbbbbb;scrollbar-track-color: #ffffff;scrollbar-darkshadow-color: #ffffff ; font-family:굴림; }
-->
</style>

<!-- <body bgcolor="#ffffff" text="#000000"  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> -->
<BODY bgProperties=fixed leftmargin="0" topmargin="0" >
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
//m_("get_size - fpath:" . $fpath . ", tmp_file:" . $tmp_file);
		//$size0 = @GetImageSize("./file/$mid/aboard_$board_name/$tmp_file"); 
		$size0 = @GetImageSize("$fpath/$tmp_file"); 
		$x= $size0[0];
		$y= $size0[1];
		//m_("$mid, $x, $y");//dao, 170, 197
		$width = $size0[0];
		$height = $size0[1];
		
		//echo"<script>alert('$temp_file:image size : x=$width, y=$height');</script>";
		
		//if(!$width) $width = 0;
		//if(!$height) $height = 0;

		if($size0[0] == 0 ) $size0[0]=1; 
		if($size0[1] == 0 ) $size0[1]=1; 

		if($size0[0]>$size0[1]) { $per=$size_factor / $size0[0]; } 
		else { $per=$size_factor / $size0[1]; } 
		//echo"<script>alert('image size : x=$size0[0], y=$size0[1]');</script>";

		if( $size0[0] > $size_factor ) {
			$x_size=$size0[0]*$per; 
			$y_size=$size0[1]*$per; 
		} else {
			$x_size=$size0[0];//200; 
			$y_size=$size0[1];//120; 
		}
		//		$x_size=$size0[0]*$per; 
		//		$y_size=$size0[1]*$per; 


		$win_width  = $size0[0] + 15; 
		$win_height = $size0[1] + 30; 
		return $x_size."X".$y_size;

	} // func end
?>

<?=$mf_infor[44]?>
<!-- -->

<FORM name='view_form' action='list1.php' method='post' enctype="multipart/form-data">
	<input type='hidden' name='no'					value='' >
	<input type='hidden' name='target'				value='<?=$mf[18]?>'>
	<input type='hidden' name='step'					value='<?=$mf[19]?>'>
	<input type='hidden' name='re'					value='<?=$mf[20]?>'>
	<input type='hidden' name='old_no' 				value='<?=$_POST['old_no']?>' >
	<input type='hidden' name='mode'				value='<?=$_POST['mode']?>' >
	
	<input type='hidden' name='infor'					value='<?=$_POST['infor']?>' >
	<input type='hidden' name='list_no' 				value='<?=$_POST['list_no']?>' >
	<input type='hidden' name='page'				value='<?=$_POST['page']?>' >
	<input type='hidden' name='search_choice'	value='<?=$_POST['search_choice']?>' >
	<input type='hidden' name='search_text'		value='<?=$_POST['search_text']?>' >
	<input type='hidden' name='update_pass' value='list1' >
</form>
<table width="100%" cellspacing="0" cellpadding="0">
  <!-- 귀퉁이. -->
  <!-- <tr>
     <td><img src="./images/cbox_top_000.gif"></td> 
  </tr>-->
  <tr>
    <td>
<table width="589" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="center">
  <table width="565" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
    <tr>
      <td align="center" bgcolor="#FFFFFF" >

        <table width="565" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td valign="top" align="center" height="400">

 <table border=0 cellspacing=0 cellpadding=5 width=565 bgcolor='<?=$mf_infor[49]?>'>
    <tr>
      <td height=22 align='left'><font color='<?=$mf_infor[50]?>'><?=$mf_infor[1]?></font>&nbsp;&nbsp;&nbsp;page:<?=$page?></td>
    </tr>
 </table>

  <table width=565 <?=$mf_infor[17]?>>
<tr><td  width="100%" height="1" bgcolor="#ffffff"></td></tr>
          <tr>
            <td width="100%" height="1" bgcolor="<?=$mf_infor[18]?>"><font color=<?=$mf_infor[19]?>>
             <!--&nbsp;&nbsp;▣ <b><?=$mf[8]?></b></font></td>-->
             &nbsp;▣ (<?=$mf[0]?>)&nbsp;<b><?=$mf[8]?></b></font></td>
            </tr>
            <tr><td  width="100%" height="1" bgcolor="#c0c0c0"></td></tr>
            <tr><td>
<table border=0 width=100%>

<?php

if($mf[12]){	// file_name
	$width  = 0;//1000;
	$height = 0;//800;

	if( $mf[15]=='.bmp' || $mf[15]=='.gif' || $mf[15]=='.jpg' || $mf[15]=='.png'){	// 14->15, 13->14
		$file="<a href='down.php?infor=$infor&no=$mf[0]&wonbon=$mf[13]' \">
			<img src='" . KAPP_URL_T_ . "/icon/subject.gif' border='0'> <font color='".$mf_infor[21]."'>".$mf[13]."(".$fsize.")</a>";
			$tmp = get_size($mf[12], $mf_infor[2]); 
			//m_("get_size - tmp:" . $tmp);

			$size = explode("X", $tmp); 
			$img = "<img src=$fpath/$mf[12] border=0 width=$size[0] height=$size[1] >";
			//m_("369 --- img: " . $img);	//--- img: <img src=.../file/dao/aboard_dao1705561193/dao_1705885451.jpg border=0 width=1 height=1 >
	}elseif($mf[15]=='.zip'||$mf[15]=='.rar'||$mf[15]=='.mp3'||$mf[15]=='.txt'){
		$file="<a href='down.php?infor=$infor&no=$mf[0]&wonbon=$mf[13]' title='zip,rar,mp3,mp4,avi,txt'>
			<img src='". KAPP_URL_T_ ."/icon/file/default.gif' border=0> <font color=$mf_infor[21]>$mf[13]($fsize)</a>";
	}else{
		$file="<a href='down.php?infor=$infor&no=$mf[0]&wonbon=$mf[13]' title=' Other '>
			<img src='".KAPP_URL_T_."/icon/file/default.gif' border=0> <font color=$mf_infor[21]>$mf[13]($fsize)</a>";
	}
	

	?>

          <tr>
            <td align='right' width="100%" height="12" colspan='2'>
            <font color=<?=$mf_infor[21]?>><?=$file?></font>
            </td>
         </tr>
<?php 
} //if($mf[12]) END  -----------------------------------------------------------------------------------
?>
          <tr>
            <td width="50%" height="12"><font color=<?=$mf_infor[21]?>>
			<?php if($mf_infor[6]){echo("IP : $mf[6]");}?></font></td>
            <td width="50%" height="12">
            <p align="right"><font color=<?=$mf_infor[21]?>>view : <?=$mf[17]?></font></td>
          </tr>
          <tr>
            <td width="50%" height="12"><font color=<?=$mf_infor[21]?>>Author : </font>
				<a href="mailto:<?=$mf[4]?>"><font color=<?=$mf_infor[21]?>><?=$mf[3]?></font></a></td>
            <td width="50%" height="12">
            <p align="right"><font color=<?=$mf_infor[21]?>><?=$mf[7]?></font></td>
          </tr>
</table>
</td></tr>
    <tr>
		<td width="100%" height="1" bgcolor="#ffffff" background="<?=KAPP_URL_T_?>/include/img/dot.gif"></td> 
    </tr>
    <tr>
      <td width="100%" height=300 align=center>
<?php
	if ($img) { 

		if( strpos( $mf[16], "../" ) !== false) { // new data
			$file_p = $mf[16] . "/" . $mf[12] ;
		} else if( strpos( $mf[16], "./" ) !== false) { // old data
			$file_p = "." . $mf[16] . "/" . $mf[12] ;
		} else {
			$file_p = $mf[16] . "/" . $mf[12] ;
		}

		$bnm = "aboard_" . $mf_infor[2]; // $mf_infor[2] : board name
		//<img src=.../file/dao/aboard_dao1705561193/dao_1705885451.jpg border=0 width=1 height=1 >, file_p: .../file/dao/aboard_dao1705561193/dao_1705885451.jpg
		
//		$file_p="./file/$mid/aboard_$mf_infor[2]/$mf[12]";
//		 $click_data = "window.open('pic2.php?infor=".$infor."&file_path=".$file_p."', '', 'width=$width, height=$height, top=0, left=0, scrollbars=yes')";
		 $click_data = "window.open('pic2.php?infor=".$infor."&mid=".$mid."&bnm=".$bnm."&fnm=".$mf[12]."', '', 'width=$width, height=$height, top=0, left=0, scrollbars=yes')";
	?>
		<!-- <div align=center >-->
		<a href='#' onClick="<?=$click_data?>" title="width:<?=$size[0]?>, height:<?=$size[1]?>, file_path:<?=$mf[16]?> , file_name:<?=$mf[12]?>, file_original:<?=$mf[13]?>"><?=$img?></a>
		<!--</div>-->
<?php } ?>
	
<?php
	$file1 = $mf[16] . "/" . $mf[12] ;	//= "$f_path/file/".$file_path;			
//	$file1 = "./file/$mid/aboard_$mf_infor[2]/$mf[12]";
//	if ( $mf_infor[48] == "1" ) { // 48:movie = 0:general, 1:standard, 2:memo, 3:image, 4:movie-동영상.
//	if ( $mf_infor[48] == "4" ) { // 48:movie = 0:general, 1:standard, 2:memo, 3:image, 4:movie-동영상.
		if($mf[15]=='.avi' || $mf[15]=='.mp4') {	// file_type	$mf[15]=='.bmp'
			$file1 = $mf[16] . "/" . $mf[12] ;	//= "./file/$mf[15]";
//			$file1 = "./file/" . $mid . "/" . $mf[12];
//			$file1 = "./file/$mid/aboard_$mf_infor[2]/$mf[12]";
?>
			<OBJECT ID="MediaPlayer1" name="MediaPlayer1" WIDTH=320 HEIGHT=310 CLASSID="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,05,0809" Standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject" VIEWASTEXT>
			<PARAM NAME="transparentAtStart" VALUE="True">
			<PARAM NAME="transparentAtStop" VALUE="False">
			<PARAM NAME="AnimationAtStart" 	VALUE="False">
			<PARAM NAME="AutoStart" 		VALUE="True">
			<PARAM NAME="AutoRewind" 		VALUE="true">
			<PARAM NAME="SendMouseClickEvents" VALUE="True">
			<PARAM NAME="DisplaySize" 		VALUE="0">
			<PARAM NAME="AutoSize" 			VALUE="False">
			<PARAM NAME="ShowDisplay" 		VALUE="False">
			<PARAM NAME="ShowStatusBar" 	VALUE="True">
			<PARAM NAME="ShowControls" 		VALUE="True">
			<PARAM NAME="ShowTracker" 		VALUE="True">
			<PARAM NAME="FileName" 			VALUE="<?=$file1?>">
			<PARAM NAME="Enabled" 			VALUE="1">
			<PARAM NAME="EnableContextMenu" VALUE="0">
			<PARAM NAME="EnablePositionControls" VALUE="0">
			<PARAM NAME="EnableFullScreenControls" VALUE="1">
			<PARAM NAME="ShowPositionControls" VALUE="1">
			<PARAM NAME="Mute" 				VALUE="0">
			<PARAM NAME="Rate" 				VALUE="1">
			<PARAM NAME="SAMILang" 			VALUE="">
			<PARAM NAME="SAMIStyle" 		VALUE="">
			<PARAM NAME="SAMIFileName" 		VALUE="">
			<param NAME="ClickToPlay" 		VALUE="0">
			<param NAME="CursorType" 		value="1">
		</OBJECT>
<?php
		}
 //}	
 ?>

        <table align='center' bgcolor='<?=$mf_infor[20]?>' border="0" cellpadding="10" cellspacing="0" width="100%" height="49">
          <tr>
            <td width="100%" >
				<?php if($mf[5]){	// 5:homepage url
					echo("<a href='$mf[5]' target='_blank'><font color='$mf_infor[21]'>$mf[5]</font></a><a href='$mf[5]' target='_blank'><font color='$mf_infor[21]'> view </font></a><br><br>");
				} 
				?>
					<font color=<?=$mf_infor[21]?>><?=$mf[9]?></font></td>
          </tr>
          <tr>
            <td width="100%" ><?php if($mf_infor[5]){ include "./memo.php";}?></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td  width="100%" height="1" bgcolor="#ffffff" background="<?=KAPP_URL_T_?>/include/img/dot.gif"></td>
    </tr>

<?php 
	// 관련글 - 답글 - 출력
	if( $mf_infor[43]){
		$query = "select no, name, subject, context, id, target,step,re, in_date from aboard_".$mf_infor[2]." where target='$mf[18]' order by step";
		$mq = sql_query($query);
		$mn = sql_num_rows($mq);	//m_("---------- mn:$mn");//mf-17:17, 43:1
		if( $mn > 1 ){
			$mn= $mn-1;	// 댓글 수.
?>
			<tr>
			  <td colspan='2' width="100%" height="1" >
				&nbsp; <font color=<?=$mf_infor[21]?>>Answer(<?=$mn?>)</font></td>
			</tr>
			<tr><td colspan='2' width="98%" height="1" bgcolor="#ffffff" background="<?=KAPP_URL_T_?>/include/img/dot.gif"></td></tr> <!-- 점선...... -->
<?php 
$dep="";
			while( $data = sql_fetch_row($mq)){
				
				for( $i=0;$i<$data[7];$i++){$dep=$dep . "&nbsp;&nbsp;&nbsp;";}
				
				//$data[1]=Shorten_String( $data[1],"10","...");	// author
				//$data[2]=Shorten_String( $data[2],"65","...");	// 2:subject, 3:context
				$day = date("y/m/d H:i", $data[8]);
?>
	<?php 
				if( $data[7] > 0 ) { $per = 100 - $data[7]*2; $wper=$data[7]+8;}
				else  { $per= 100; $wper=10;}
				//m_("$wper, $per");//10, 100 //9, 99	//10, 98//11, 97
		
	?>
	<?php 
//				if( $data[7] > 1 ) { 
			if( $data[7] > 0 ) { 
	?>
			<table width="<?=$per?>%" bgcolor=<?=$mf_infor[20]?> border="0" cellpadding="0" cellspacing="0" align='right'>
				<tr>
				    <td width="<?=$wper?>" height="1">
							<!--<img src='./icon/list_reply.gif' border=0><?=$dep?>-->
							<img src='<?=KAPP_URL_T_?>/icon/list_reply.gif' border='0'>
					</td>
				    <td width="60%" height="15" align='left'>
							<a href="javascript:detail_func('<?=$data[0]?>')" >
							<font color=<?=$mf_infor[21]?>>[<?=$data[0]?>]<?=$temp1?><?=$data[2]?><?=$temp2?></a>
					</td>
					<td width="40%" align='right'>
						<font size='2' color='<?=$mf_infor[19]?>'> [<?=$data[1]?>]-[<?=$day?>]</font>
					</td>
				</tr>
				<tr>
				    <td width="<?=$wper?>" height="1"></td>
					<td colspan='2' align='left' style='background-color:#FAFAFA' ><?=$data[3]?></td>
				</tr>
				<!--<tr><td colspan=3 width="100%" height="1" bgcolor="#ffffff" background="./img/dot.gif"></td></tr>-->
			</table>
	<?php } else { ?>
			<table width="<?=$per?>%" bgcolor=<?=$mf_infor[20]?> border="0" cellpadding="0" cellspacing="0" align='right'>
				<tr>
				    <td width="60%" height="15" align='left'>
							<a href="javascript:detail_func('<?=$data[0]?>')" >
							<font color=<?=$mf_infor[21]?>>[<?=$data[0]?>]<?=$temp1?><?=$data[2]?><?=$temp2?></a>
					</td>
					<td width="40%" align='right'>
						<font size=2 color=<?=$mf_infor[19]?>> [<?=$data[1]?>]-[<?=$day?>]</font>
					</td>
				</tr>
				<tr>
					<td colspan='2' align='left' style='background-color:#99FFFF' ><?=$data[3]?></td>
				</tr>
				<!--<tr><td colspan='2' width="98%" height="1" bgcolor="#ffffff" background="./img/dot.gif"></td></tr>-->
			</table>
	<?php } ?>


<!--		</td>
	</tr>-->
<?php
				$temp1="";$temp2="";
				$dep="";

			} // while
?>
	<?php } } ?>

    <tr>
      <td align='right' width="100%" height="20" >
<?php
$e_ad = KAPP_URL_T_ . "/icon/e_admin.gif"; //https://fation.net/t/menu/.e_admin.gif
//m_("list_no:$list_no"); https://fation.net/t/menu/.e_admin.gif
//			if($H_LEV === "0" or $mf_infor[8] == $H_ID){
//			if( $mf_infor[53] == $H_ID ){
			if($H_LEV > 7 or $mf_infor[53] == $H_ID ){
				$list_no = $_POST['list_no'];
?>
		<!-- <a href='update.php?no=<?=$infor?>&list_no=<?=$list_no?>' target='_blank' title='41:<?=$mf_infor[41]?>'>
        <img src='./icon/e_admin.gif' width=30 border=0 target=_blank></a> --> 

         <a href="javascript:admin_detail_func( '<?=$infor?>', '<?=$list_no?>');">
        <img src="<?php echo $e_ad; ?>" width='30' border='0' target='_blank' title="infor:<?=$infor?> : <?=$list_no?>"></a> 
		
        <!-- <img src='./icon/e_admin.gif' height='30' onclick="javascript:admin_func( '<?=$infor?>', '<?=$list_no?>');" title='admin, list_no:'> -->
        <!--<img src='<?=$mf_infor[41]?>' width=30 border=0 target=_blank></a>-->
		
<?php
			 }
?>


    <?php
	/* https://fation.net/t/menu/.e_insert.gif
		// Previous, Next.
        for($i=$mf[0]+1;$i<$mf[0]+5;$i++){
        	   $query="select no from aboard_".$mf_infor[2]." where no='$i'";
                $mq=sql_query($query);
                $prev=sql_num_rows($mq);
                if($prev){
					echo("
					<input type=button value='Previous' onclick=\"javascript:window.open('list1_detail.php?no=$i&infor=$infor&page=$page&search_choice=$search_choice&search_text=$search_text','_self','')\">
					");
					break;
				}
         }

         for($i=$mf[0]-1;$i>0;$i--){
        	   $query="select no from aboard_".$mf_infor[2]." where no='$i'";
                $mq=sql_query($query);
                $next=sql_num_rows($mq);
                if($next){
					echo(" 
					<input type=button value='Next' onclick=\"javascript:window.open('list1_detail.php?no=$i&infor=$infor&page=$page&search_choice=$search_choice&search_text=$search_text','_self','')\">
					");
					break;
				}
         }
		 */
	?>
    <?php if( $search_choice){ ?>
         <!--<a href='index.php?no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>&del_admin=<?=$del_admin?>'
         onMouseOver="window.status=('검색리스트'); return true;" onMouseOut="window.status=(''); return true;">
        <img src='<?=$mf_infor[35]?>' border=0></a>-->
         <input type='button' value='Search' onclick="javascript:window.open('board_data_list.php?no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>&del_admin=<?=$del_admin?>','_self','')">
	<?php } ?>
        
<?php
			//m_("mf[2] : $mf[2]");
			// 관리자 아이디랑 동일할 경우 & 관리자로 로그인 되었을경우에 바로 수정 삭제되도록. 8-> 53
	if ( ($mf_infor[53] == $H_ID ) or ($H_LEV > 7) ){	// manager
?>
        <!-- <input type='button' value='Update' onclick="javascript:window.open('list1_detail_update.php?update_pass=list1&no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>','_self','')" title='Manager data'> -->
        <input type='button' value='Update' onclick="javascript:update_open('<?=$infor?>','<?=$mf[0]?>','<?=$page?>','<?=$search_choice?>','<?=$search_text?>' )" title='update record data'>
<?php 
	} else if ( $mf[2] == $H_ID ){		// my data
?>
        <input type='button' value='Update' onclick="javascript:window.open('list1_detail_update.php?update_pass=list1&no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>','_self','')"  title='My data'>
<?php 
//	} else if ( $mf[2] == 'Guest' and !$H_ID ){	// Guest data
	} else if ( $mf_infor[47] == '0' and $mf[2] == 'Guest' and !$H_ID ){	// Guest data
?>
        <input type='button' value='Update' onclick="javascript:window.open('list1_detail_update.php?update_pass=list1&no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>','_self','')" title='Guest data'>
<?php
	}
?>
		
        <!-- <input type=button value='Relpy' onclick="javascript:window.open('reply.php?no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>','_self','')" > -->
		
<?php
		// 작성자, 관리자, 시스템관리자 아이디랑 동일할 경우 & 관리자로 로그인 되었을경우에 바로 수정 삭제되도록.  8->53
	if ( ($mf[2] == $H_ID ) or ($mf_infor[53] == $H_ID ) or ($H_LEV > 7 ) ){
		//if ( $mf[19]==0 and $mf[20]==0 ){	// 메인글일때만 삭제가능. 댓글은 삭제불가.??
?>
        <input type='button' value='Delete' onclick="javascript:del_func( '<?=$infor?>', '<?=$mf[0]?>', '<?=$mf[18]?>', '<?=$mf[19]?>', '<?=$mf[20]?>')" >
<?php 
		//}
	} else { 
			//url = "password_.php?infor="+infor + "&no=" +no+ "&page=" +page+ "&call_pg=list1_detail.php";
	?>
        <!--<input type=button value='Delete' onclick="javascript:window.open('password_.php?file_path=<?=$mf[15]?>&del=1&no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>&call_pg=list1_detail.php','_self','')" >-->
<?php } ?>

        <?php if(!$search_choice){$link="&page=$page";}?>
		
        <input type='button' value='List' onclick="javascript:window.open('list1.php?infor=<?=$infor?>&page=<?=$page?>','_self','')" >
        <input type='button' value='Write' onclick="javascript:window.open('insert1.php?no=<?=$mf[0]?>&infor=<?=$infor?>','_self','')" >
         </td>
    </tr>
<tr>
      <td width="100%" height="1" bgcolor="#ffffff" ></td>
    </tr>
    <tr>
      <td width="100%" height="1" >
     <?php 
		$mf_42 = $mf_infor[42];		//m_("mf42: " . $mf_infor[42]); // mf42: 1
		if( $mf_infor[42]){	//list_gubun : 관련글 출력 구분.
			$file="";
			//include "./inc_list.php"; ////////////////////// list //////////
			include "./inc_list1.php"; ////////////////////// list //////////
		 }
	?>
     </td>
    </tr>
 </table>
         <!-- End of Paging Table -->
    </td>
  </tr>
</table>
</td>
  </tr>
  
<!-- 하단 귀퉁이.
  <tr>
    <td><img src="./images/cbox_bot_000.gif"></td>  
  </tr>
-->  
</table>
<!-- <?=$mf_infor[45]?> --><!-- aboard_infor : bottom_html -->


