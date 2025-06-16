<?php
	include_once('../tkher_start_necessary.php');

	$H_ID= get_session("ss_mb_id");	$H_LEV= $member['mb_level']; 
	$ip = $_SERVER['REMOTE_ADDR'];
	if( $H_ID ){
		$H_NICK = $member['mb_nick'];$H_NAME= $member['mb_name']; 
	} else {
		$H_NICK = 'Guest';
		$H_NAME = 'Guest';
	}
	/*
	  list1_detail.php : image type board - list1.php 에서 call
					   : list1_detail_update.php - admin_detail_func() , admin : board_list3_update.php - 속성 설정 old type
					   : inc_list1.php - include : image list,           admin : board_list3_update.php - 속성 설정 old type - admin_detail_func()
					   : memoD.php      - include : memo write call : detailD_memoD_write.php - memo write
					   : password_.php?infor="+infor + "&no=" +no+ "&page=" +page+ "&call_pg=list1_detail.php";
					: infor.php
					: file_size.php
					: string.php :  // Shorten_String($String, $MaxLen, $ShortenStr)
					: query_ok_new.php
					https://biogplus.iwinv.net/kapp/menu/list1_detail.php#
	*/
	if( isset($_POST['page']) ) $page= $_POST['page'];
	else if( isset($_REQUEST['page']) ) $page= $_REQUEST['page'];
	else $page= 1;

	if( isset($_POST['list_no']) ) $list_no= $_POST['list_no'];
	else if( isset($_REQUEST['list_no']) ) $list_no= $_REQUEST['list_no'];
	else $list_no= '';

	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode= '';
	if( isset($_POST['search_text']) ) $search_text= $_POST['search_text'];
	else if( isset($_REQUEST['search_text']) ) $search_text= $_REQUEST['search_text'];
	else $search_text= '';
	if( isset($_POST['search_choice']) ) $search_choice= $_POST['search_choice'];
	else if( isset($_REQUEST['search_choice']) ) $search_choice= $_REQUEST['search_choice'];
	else $search_choice= '';

	$run_mode ='list1_detail';

	include "./infor.php";
	include "./file_size.php";
	include "./string.php";    // Shorten_String($String, $MaxLen, $ShortenStr)
	$view_lev = $mf_array['grant_view'];
	switch( $mf_infor[46] ){
		case '0': break;
		case '1': 	
			if( !$H_ID || $H_LEV < 2 ) { 
				//m_("You do not have permission to read."); 
				//echo "<script>history.back(-1);</script>"; exit;
			}
			//break;
		case '2': 
			if( $H_ID != $mf_infor[53] && $view_lev > 1) { 
				m_("You do not have permission to read."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
		case '3': 
			if( $H_ID != $mf_infor[53] || $H_LEV < 8 ) { 
				m_("You do not have permission to read."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
	}
?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
	<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/board_new.png">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
	<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
	<meta name="robots" content="ALL">
	<!-- <link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/board.css" type="text/css"> -->
	<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/default.css" type="text/css">
</head>
<SCRIPT src="<?=KAPP_URL_T_?>/include/js/contents_resize.js" type=text/javascript></SCRIPT>

<script>
	function openpage(){
		infor=document.view_form.infor.value;//	alert('infor:'+infor);
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
		document.view_form.infor.value	=infor;
		document.view_form.list_no.value	=no;
		document.view_form.no.value		=no;
		document.view_form.target="_blank";
		document.view_form.action='board_list3_update.php';
		document.view_form.submit();
	}
	function update_open( infor, list_no, page , search_choice , search_text ){
		document.view_form.infor.value	 =infor;
		document.view_form.list_no.value =list_no;
		document.view_form.page.value    =page;
		document.view_form.search_choice.value =search_choice;
		document.view_form.search_text.value   =search_text;
		document.view_form.action='list1_detail_update.php';
		document.view_form.submit();
	}
	function open_list1(){
		document.view_form.action='list1.php';
		document.view_form.submit();
	}
</script>

<?php
	//조회수 증가
	if( $list_no > 0 ){
		$query="update aboard_".$mf_infor[2]." set cnt=cnt+1 where no='$list_no'";
		$mq=sql_query($query);
	}
	$mf_46 = $mf_infor[46];

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

	$line_cnt	= $mf_infor[16];
	//$size   = $mf_infor[16];
	$limite = $mf_infor[16];
	$page_num = 10; 
	
	if( $list_no ) $query = "SELECT * from aboard_" . $mf_infor[2] . " where no=$list_no ";
	else {
			$SQL1		= " SELECT * from aboard_" . $mf_infor[2];
			$where_		= " where subject like '%$search_text%' or context like '%$search_text%' ";
			$orderby	= " order by target desc , step ";
			if( $mode =='SR' )	$SQL1 = $SQL1 . $where_ . $orderby;
			else				$SQL1 = $SQL1 . $orderby;
			if( ( $result = sql_query( $SQL1 ) )==false ){
				printf("Invalid query: %s\n", $SQL1);
				my_msg(" no found data Select Error ");
				$total_count = 0;
			} else {
				$total = sql_num_rows($result);
				if( !$page ) $page =1; 
				$total_page = intval(($total-1) / $limite)+1; 
				$first = ($page-1)*$limite; 
				$last = $limite; 
				if( $total < $last) $last = $total;
				$limit = " limit $first,$last";
			}
			$query = "SELECT * from aboard_" . $mf_infor[2] . " where subject like '%$search_text%' order by target desc , step";
			$query = $query . " $limit ";

	}
	$mq		= sql_query($query);
	$mf		= sql_fetch_row($mq);
	$mid	= $mf_infor[53]; // 53['makeid'] = 8['imember'] 
	$fsize	= GetFileSize_func($mf[14]);	//파일싸이즈 get_size
	/*if( strpos( $mf[16], "../" ) !== false) {
		$fpath	= $mf[16];       // new data format
	} else if( strpos( $mf[16], "./" ) !== false) { // old data
		$fpath	= "." . $mf[16]; // old data format
	} else {
		$fpath	= $mf[16]; // old data format
	}*/
	$fpath	= $mf[16];
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
	if( isset($_SESSION['security']) ) $security= $_SESSION['security'];
	else $security='';
	if( !$security ){
		//m_(" no security ");
	} else {
		if( $mf[21] != "" and $mf[21] != $security) {
			$page =$_POST['page'];
				//auth(); //m_(" password please enter! --------:$security , page:$page");
				echo "<script>board_view($infor, $list_no, $page );</script>";
				exit;
		} else $_SESSION['security']='';
	}

?>


<body>
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

	$call_pg = 'list1_detail';
	if( isset($_POST['view_line'])) $view_line =$_POST['view_line']; 
	else $view_line =2;
	if( isset($_POST['view_count'])) $view_count =$_POST['view_count']; 
	else $view_count =10;
	if( isset($_POST['tot_cnt'])) $tot_cnt =$_POST['tot_cnt']; 
	else $tot_cnt = 20;
	//m_("detail - tot_cnt:$tot_cnt, view_line:$view_line, view_count:$view_count, ");
?>
<?=$mf_infor[46]?><!-- top_html -->

<FORM name='view_form' action='list1.php' method='post' enctype="multipart/form-data">
	<input type='hidden' name='no' value='' >
	<input type='hidden' name='target' value='<?=$mf[18]?>'>
	<input type='hidden' name='step'   value='<?=$mf[19]?>'>
	<input type='hidden' name='re'     value='<?=$mf[20]?>'>
	<input type='hidden' name='mode'   value='<?=$mode?>' >
	
	<input type='hidden' name='infor'  value='<?=$infor?>' >
	<input type='hidden' name='list_no' value='<?=$list_no?>' >
	<input type='hidden' name='page'   value='<?=$page?>' >
	<input type='hidden' name='search_choice'	value='<?=$search_choice?>' >
	<input type='hidden' name='search_text'		value='<?=$search_text?>' >
	<input type='hidden' name='update_pass' value='list1' >

	<input type='hidden' name='view_count' value="<?=$view_count?>" >
	<input type='hidden' name='view_line'  value="<?=$view_line?>" >
	<input type='hidden' name='tot_cnt'    value="<?=$tot_cnt?>" >

</form>
<table  style="border: 1px solid cyan; width:auto; height:auto; margin:auto; text-align: center;">

  <!-- 상단 귀퉁이. <tr><td><img src="../icon/cbox_top_000.gif"></td></tr> -->
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td>
		  <table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
			<tr>
			  <td bgcolor="#FFFFFF" >

				<table width="100%" border="0" cellspacing="1" cellpadding="1">
				  <tr>
					<td valign="top" height="100%">

		 <table border='0' cellspacing='0' cellpadding='5' width='100%' bgcolor='<?=$mf_infor[49]?>'>
		<tr>
		  <td height='22' align='left'><font color='<?=$mf_infor[50]?>'><?=$mf_infor[1]?></font>&nbsp;&nbsp;&nbsp;page:<?=$page?></td>
		</tr>
	 </table>

  <table width='100%' <?=$mf_infor[17]?>>
	<tr><td  width="100%" height="1" bgcolor="#ffffff"></td></tr>
			  <tr>
				<td width="100%" height="1" bgcolor="<?=$mf_infor[18]?>"><font color=<?=$mf_infor[19]?>>
				 &nbsp;▣ (<?=$mf[0]?>)&nbsp;<b><?=$mf[8]?></b></font></td>
				</tr>
				<tr><td  width="100%" height="1" bgcolor="#c0c0c0"></td></tr>
				<tr><td>
		<table border='0' width='100%'>

<?php

if( $mf[12]){	// file_name
	$width  = 0;
	$height = 0;

	if( $mf[15]=='.bmp' || $mf[15]=='.gif' || $mf[15]=='.jpg' || $mf[15]=='.png'){
		$file="<a href='#' \"><img src='" . KAPP_URL_T_ . "/icon/subject.gif' border='0'><font color='".$mf_infor[21]."'>".$mf[13]."(".$fsize.")</a>";
			$tmp = get_size($mf[12], $mf_infor[2]); 
			$size = explode("X", $tmp); 
			$imgA = "../file/".$mf_infor[53]."/aboard_".$mf_infor[2]."/".$mf[12]; // 53['makeid'] = 8['imember']
			$imgs= "<img src='".$imgA."' border='0' width='".$size[0]."' height='".$size[1]."' >";

	}elseif($mf[15]=='.zip'||$mf[15]=='.rar'||$mf[15]=='.mp3'||$mf[15]=='.txt'){
		$file="<a href='#' ><img src='". KAPP_URL_T_ ."/icon/file/default.gif' border=0> <font color=$mf_infor[21]>$mf[13]($fsize)</a>";
	}else{
		$file="<a href='#' ><img src='".KAPP_URL_T_."/icon/file/default.gif' border=0> <font color=$mf_infor[21]>$mf[13]($fsize)</a>";
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
	
<?php
		$file1 = $mf[16] . "/" . $mf[12] ;
		if($mf[15]=='.avi' || $mf[15]=='.mp4') {
			$file1 = $mf[16] . "/" . $mf[12] ;
		}
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
            <td width="100%" ><?php if($mf_infor[5]){ include "./memoD.php";}?></td>
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
				$day = date("y/m/d H:i", $data[8]);
				if( $data[7] > 0 ) { $per = 100 - $data[7]*2; $wper=$data[7]+8;}
				else  { $per= 100; $wper=10;}
?>
<?php 
				if( $data[7] > 0 ) { 
?>
					<table width="<?=$per?>%" bgcolor=<?=$mf_infor[20]?> border="0" cellpadding="0" cellspacing="0" align='right'>
						<tr>
							<td width="<?=$wper?>" height="1">
									<img src='<?=KAPP_URL_T_?>/icon/list_reply.gif' border='0' title='memo save'>
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
					</table>
<?php
				} else {
?>
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
					</table>
<?php 
				}
				$temp1="";$temp2="";
				$dep="";
			}//while
		}//($mn>1)
	}//$mf_infor[43]
?>

    <tr>
      <td align='right' width="100%" height="20" >
<?php
	$e_ad = KAPP_URL_T_ . "/icon/e_admin.gif"; //https://fation.net/t/menu/.e_admin.gif
	if($H_LEV > 7 or $mf_infor[53] == $H_ID ){
?>
        <a href="javascript:admin_detail_func( '<?=$infor?>', '<?=$list_no?>');">
        <img src="<?php echo $e_ad; ?>" width='30' border='0' target='_blank' title="infor:<?=$infor?> : <?=$list_no?>"></a> 
<?php
	}
?>

<?php if( $search_choice){ ?>
         <input type='button' value='Search' onclick="javascript:window.open('list1_detail.php?no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>&del_admin=<?=$del_admin?>','_self','')">
<?php } ?>
        
<?php
	if ( ($mf_infor[53] == $H_ID ) or ($H_LEV > 7) ){	// manager
?>
        <input type='button' value='Update' onclick="javascript:update_open('<?=$infor?>','<?=$mf[0]?>','<?=$page?>','<?=$search_choice?>','<?=$search_text?>' )" title='update record data'>
<?php 
	} else if ( $mf[2] == $H_ID ){		// my data
?>
        <input type='button' value='Update' onclick="javascript:window.open('list1_detail_update.php?update_pass=list1&no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>','_self','')"  title='My data'>
<?php 
	} else if ( $mf[2] == $H_ID ){ //$mf_array['grant_view']
?>
        <input type='button' value='Update' onclick="javascript:window.open('list1_detail_update.php?update_pass=list1&no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>','_self','')" title='Guest data'>
<?php
	}
	// ($mf[2] == $H_ID)작성자, 게시판생성자, 시스템관리자 아이디랑 동일할 경우 & 관리자로 로그인 되었을경우에 바로 수정 삭제되도록.  8->53
	if ( ($mf[2] == $H_ID ) || ($mf_infor[53] == $H_ID ) || ($H_LEV > 7 ) ){ // ($mf_infor[53] == $H_ID ) - 게시판 주인
		//if ( $mf[19]==0 and $mf[20]==0 ){	// 메인글일때만 삭제가능. 댓글은 삭제불가.??
?>
        <input type='button' value='Delete' onclick="javascript:del_func( '<?=$infor?>', '<?=$mf[0]?>', '<?=$mf[18]?>', '<?=$mf[19]?>', '<?=$mf[20]?>')" >
        <input type='button' value='Write' onclick="javascript:window.open('insert1.php?no=<?=$mf[0]?>&infor=<?=$infor?>','_self','')" >
<?php } ?>
<?php if( !$search_choice){ $link="&page=$page";} ?>
		<!-- <input type='button' value='List' style="width:25px;" onclick="javascript:window.open('list1.php?infor=<?=$infor?>&page=<?=$page?>','_self','')" > -->
		<input type='button' value='List' style="width:25px;" onclick="javascript:open_list1()" title="open_list" >

				 </td>
			</tr>
			<tr>
				  <td width="100%" height="1" bgcolor="#ffffff" ></td>
			</tr>
			<tr>
				  <td width="100%" height="1" >
<?php 
		$mf_42 = $mf_infor[42];
		if( $mf_infor[42]){	//list_gubun : 관련글 출력 구분.
			$file="";
			include "./inc_list1.php";
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
	<!-- 하단 귀퉁이. <tr><td><img src="../icon/cbox_bot_000.gif"></td></tr> -->  
</table>
<?=$mf_infor[45]?><!-- aboard_infor : bottom_html -->


