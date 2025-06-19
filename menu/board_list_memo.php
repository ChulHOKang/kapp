<?php
	include_once('../tkher_start_necessary.php');
	/*
		board_list_memo.php : memo type board
		run : query_ok_new.php
	*/
	$ss_mb_id = get_session("ss_mb_id");
	if( isset($ss_mb_id) && $ss_mb_id !=='' ) {
		$H_ID	= $ss_mb_id;
		$H_LEV	= $member['mb_level'];
		$H_NAME = $member['mb_name'];
	} else {
		$H_NAME='GUEST';
		$H_ID	= '';
		$H_LEV	= 1;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php
	if( isset($_REQUEST['infor']) ) $infor=$_REQUEST['infor'];	//m_("infor: $infor ------- ");
	else if( isset($_POST['infor']) ) $infor=$_POST['infor'];
	else $infor ='';

	include "./paging.php";
	include "./string.php";
	include "./infor.php";
	include "./memo_cnt.php";
	include "./file_size.php";

	$mid = $mf_infor[53];

	$content = '';
	if( isset($_REQUEST['search_choice']) ) $search_choice=$_REQUEST['search_choice'];
	else $search_choice='';
	if( isset($_REQUEST['search_text']) ) $search_text=$_REQUEST['search_text'];
	else $search_text='';
	if( isset($_REQUEST['del_admin']) ) $del_admin=$_REQUEST['del_admin'];
	else $del_admin='';
?>

  
<!-- <link href="<?=KAPP_URL_T_?>/include/css/style1.css" rel="stylesheet" type="text/css"> -->
<!-- <link href="<?=KAPP_URL_T_?>/menu/css/editor.css" rel="stylesheet" type="text/css"> -->

<script language="JavaScript"> 
<!--
function del_funcA(tarno, infor)
{
	resp = confirm( ' Are you sure you want to delete? : ' + tarno);
	if( !resp ) { 
		alert('Cancle ');
		return false;
	} else {
		document.makeform.mode.value='del_funcA';
		document.makeform.target_no.value=tarno;
		document.makeform.infor.value=infor;
		document.makeform.action='query_ok_new.php';
		document.makeform.submit();
	}
}
function del_func(no, infor)
{
	resp = confirm( ' Are you sure you want to delete? ');
	if( !resp ) { 
		alert('Cancle ');
		return false;
	} else {
		document.makeform.mode.value='del_func_';
		document.makeform.xmf_no.value=no;
		document.makeform.infor.value=infor;
		document.makeform.action='query_ok_new.php';
		document.makeform.submit();
	}
}

function save_memo_(lev, infor)
{
	if( lev > 1){}
	else {
		alert("login please");
		return false;
	}
	if(!makeform.subject.value) {
		alert('Register your subject! '); 
		return false;
	}
	if( infor > 0 ){
		var form = document.makeform;
		ff= form.file.value;
		alert("infor:" + infor + ", ff: " + ff); //infor:112, ff: C:\fakepath\새해인사.jpg
		//infor:13, ff: C:\fakepath\guggi.png
		if( form.file.value != ""){
			idx_path = form.file.value.lastIndexOf("."); 
			if( idx_path < 0 ) {
				idx_colon = form.file.value.lastIndexOf(".");
				if ( idx_colon >= 0 ) temp = form.file.value.substring(idx_colon);
			} else {
				temp = form.file.value.substring(idx_path);
		alert("temp:" + temp );
			}
				temp = temp.toLowerCase();

			if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppk" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"){
				alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppk,alz,rar,pptx,xlsx Format Please! ");
				return;
			}
			form.file_ext.value=temp;
		}
	} else {
	}
	
	document.makeform.mode.value='memo_insert_form_';
	document.makeform.submit();
}

function edit_reply_func(lev, t, s, r, num, subject)
{
	if( lev > 1){
		document.insert_form_re.mode.value = 'memo_reply_func'; //'memo_reply_func';
		document.insert_form_re.target_.value = t;
		document.insert_form_re.step.value = s;
		document.insert_form_re.re.value = r;
		document.insert_form_re.subject.value = "re:" + subject;
		document.insert_form_re.context.value = eval(" document.insert_form_re.xcontext_" + num + ".value ");
		ic = document.insert_form_re.context.value;
		document.insert_form_re.submit(); 
	} else {
		alert("login please"); 
		return false;
	}
}
//-->
</script>

<?php
	function GetFileSize_func($size) {
			if($size<1024) return ($size . "B");
			if($size >1024 && $size< 1024 *1024) return sprintf("%0.1fKB",$size / 1024);
			if($size >= 1024*1024) return sprintf("%0.2fMB",$size / (1024*1024));
	}

	function get_size($tmp_file, $board_name) {
		global $width, $height, $H_ID, $mid;
			$size_factor = 500;
			$img_file = KAPP_URL_T_ . "/file/".$mid."/aboard_".$board_name."/".$tmp_file;
		$size0 = @GetImageSize( $img_file ); 
		$width = $size0[0];
		$height = $size0[1];
		
		//echo"<script>alert('$temp_file:image size : x=$width, y=$height');</script>";
		
		if(!$width) $width = 0;
		if(!$height) $height = 0;

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

	$orderby = " order by no desc, target desc , step ";
	$where_  = " where step ='0' and re ='0' ";
	$query   = " SELECT * from $tab " . $where_ . $orderby;
	$mq  = sql_query( $query );
	$tot = sql_num_rows($mq);
	$now = time();
?>
	<!-- <SCRIPT src="<?=KAPP_URL_T_?>/include/js/contents_resize_bbs.js" type=text/javascript></SCRIPT> -->
	<!-- <script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script> -->
	<!-- <script src="//cdn.ckeditor.com/4.25.1/full/ckeditor.js"></script> -->
</head>

<body bgcolor='black' bgProperties='fixed' leftmargin="0" topmargin="0" "> 

<?php
		$cur='B';
		include_once "../menu_run.php"; 
?>

	<!-- <td width="100%" valign="top">
     <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#000000">
      <tr>
        <td align="center"> -->
<!------------------------- table --------------------------------->    
        <table width="800" cellspacing="0" cellpadding="0">
			<form name="makeform" action='query_ok_new.php' method='post' enctype="multipart/form-data">
			<input type='hidden' name='mode'   value=''>
			<input type='hidden' name='insert' value=''>
			<input type='hidden' name='infor'  value='<?=$infor?>'>
			<input type='hidden' name='xmf_no' value=''>
			<input type='hidden' name='target_no' value=''>
			<input type='hidden' name='file_ext'  value=''>

          <tr>
           <td height="30" style='color:yellow;'>
		   <strong>[<?=$infor_1?>]</strong> - tot:<?=$tot?> &nbsp;&nbsp;&nbsp;<strong>[<?=$H_NAME?>]</strong></td>
          </tr>
          <tr>
            <td><table width="100%" cellspacing="1" cellpadding="10" bgcolor="#c6c6c6">              
              <tr>
                <td bgcolor="#FFFFFF">
				<table>
					<div>subject:<input type="text" name="subject" style="background-color:#f2f2f2;border:1px solid #62a9e4;width:90%;" class="input01"> </div>
					<div><input type='file' name='file' ></div>
                </table>
					<DIV id='EditCtrl' >
					<textarea name="content" style='background-color:yellow;ime-mode:active; background-image:; width:100%; height:100%; '><?=$content?></textarea>
					</DIV>
					<!-- <script>
						CKEDITOR.replace(
							'EditCtrl',
							{
							toolbar : 'standard',
							width : '100%',
							height : '250'
							}
						);
					</script> -->
					
				<input type='button' value='Submit' onClick="save_memo_('<?=$H_LEV?>', '<?=$infor?>')" align="absmiddle">
				</td>
              </tr>
			</form>
            </table>
			</td>
          </tr>
          <tr>
            <td height="20"></td>
          </tr>
<?php
	//$line_size = 10;	//$infor_16;	//$mf_infor[16]; - list line 
	/* Page ---------------------------------------------------------------------------- */
	$line_size = $mf_infor[16];	//	10;	// total_view_line $infor_16;	//$mf_infor[16]; 한페이지에 나타낼 글자 갯수
	$page_num = 10;	// [1] [2] [3] 갯수
	$total = $tot;
	if( !$page) $page=1;										// 페이지가 없으면 1로 정한다
	$total_page = intval( ( $total - 1 ) / $line_size ) + 1;		// 총 페이지수를 구해온다
	if( $page==1 ) $first =  0;
	else $first = ( $page - 1) * $line_size;								// 뽑아올 게시물 [처음]
	$last = $line_size;												// 뽑아올 게시물 [끝]
	if ( $total < $last ) $last = $total;
	$limit = " limit $first,$last ";	// 뽑아올 게시물 [처음]~뽑아올 게시물 [끝] 구한값으로 한페이지에 글을 뽑아 온다
	//m_("tot:$total, $first, $last, $page, $line_size");// tot:71, 0, 10, 1, 10
	if ( $page==1 ) $no = $total;
	else $no = $total - ($page - 1) * $line_size;
	$query = "SELECT * from $tab " . $where_ . $orderby . $limit;
	$mq = sql_query($query); 
?>

<form name='insert_form_re' action='query_ok_new.php' method='post' enctype="multipart/form-data">

	<input type='hidden' name='mode'		value=''>
	<input type='hidden' name='subject'	value=''>
	<input type='hidden' name='context'	value=''>
	<input type='hidden' name='target_'	value=''>
	<input type='hidden' name='step'		value=''>
	<input type='hidden' name='re'		value=''>
	<input type='hidden' name='page'		value='<?=$page?>'>
	<input type='hidden' name='reply'		value=1>
	<input type='hidden' name='infor'		value='<?=$infor?>'>
	
	<input type='hidden' name='xname' value='<?=$H_NAME?>'> 

<?php
$aaa = 0;
$cnt = 0;
$j = 0;
//m_("mf2:$mf_infor[2]");//tkher112
while( $mf = sql_fetch_array( $mq ) ) {
	if( !$cnt ){ $cnt = 1; }
	$j++;
	$date=strftime("%m/%d",$mf['in_date']);	// 4
	//글자르기
	//$mf['subject']=Shorten_String($mf['subject'],"45","...");		// 3
	//$mf[1]=Shorten_String($mf[1],"4","...");
	//답변들여쓰기
	for($i=0; $i< $mf['re'];$i++){ $dep=$dep . "&nbsp;&nbsp;";}		// 6

	//메모글 카운트
	if( $infor_5 ) { $memo_cnt = memo_count( $mf_infor[2], $mf['no'] ); }	// memo_cnt.php 0 $infor_2
	//파일이미지 삽입
	//include "./file_image.php";
	//new 이미지삽입
	$today=$now - $mf['in_date'];	// 4
	if( $today <= 86400 ) { $new = "<img src='". $infor_38."' border=0>"; }
	//검색어 표시
	//	if( $search_text ){ $mf['subject'] = eregi_replace("($search_text)","<font color=blue>\\1</font>",$mf['subject']);}	//3
	//	if( $search_text ){ $mf['subject'] = preg_replace("($search_text)","<font color=blue>\\1</font>",$mf['subject']);}	//3
	// 일반 게시판일경우
	//if( $mf_infor[48] == "0" ) {

	$aaa = $aaa +1;
	//$mf['subject'] =Shorten_StringX( $mf['subject'],"80","...");		// my_func 3

	?>
          <tr>
            <td>
            <table width="800" cellspacing="1" cellpadding="10" bgcolor="#c6c6c6"> 
<?php
	$w_day = date("Y-m-d H:i", $mf['in_date']); // ("Y-m-d-H:i:s",time()); = $mf['in_date'];
	$tg = $mf['target'];
?>
              <tr>
                <td bgcolor="#FFFFFF">
                 <table cellspacing="0" cellpadding="8" width="100%">
                  <tr>
                   <td bgcolor="#f0f0f0" width="50%" ><?=$mf['no']?>:<b><?=$mf['subject']?></b></td>
                   <td bgcolor="#f0f0f0"><strong><?=$mf['name']?></strong></td>
				   <td bgcolor="#f0f0f0">
					<?php if( $mf['id'] == $H_ID ){ ?>
						<!-- <a href="#" class="gray_s">[Update]</a>  -->
						<font color="#bcbbba">|</font> <a href="javascript:del_funcA('<?=$tg?>','<?=$infor?>')" class="gray_s" title='memo all delete'><font color=red><b>[Del]</b></font></a>
					<?php } ?>
					</td>
					<td bgcolor="#f0f0f0"><?=$w_day?></td>
                  </tr>
				  
<?php
	$down_img=""; $img_v=""; $click_data="";
	if( $mf['file_name'] != "" ){	// file_name
		$sz = $mf['file_size'];
		$fsize = GetFileSize_func( $sz );	// file_size.php 파일싸이즈
		$width  = 1000;
		$height = 800;
		if( $mf['file_type']=='.bmp' || $mf['file_type']=='.gif' || $mf['file_type']=='.jpg' || $mf['file_type']=='.png' ){	// 2024-01-10
			$tmp = get_size( $mf['file_name'], $mf_infor[2]); 
			$size = explode("X", $tmp); 
			$x = $size[0]+15;
			$y = $size[1]+30;
			if( $H_LEV > 1) $file = "<a href='down.php?infor=$infor&no=".$mf['no']."&wonbon=".$mf['file_wonbon']."' ><img src=".KAPP_URL_T_."/icon/default.gif border=0> <font color=$mf_infor[21]>".$mf['file_name']."($fsize)</a>";
			else $file = "<img src=".KAPP_URL_T_."/icon/default.gif border=0> <font color=$mf_infor[21]>".$mf['file_name']."($fsize)";
			$down_img = "<img src=".KAPP_URL_T_."/file/".$mf_infor[53]."/aboard_".$mf_infor[2]."/".$mf['file_name']." border=0 width=$size[0] height=$size[1] >";
		} else {
			if( $H_LEV > 1) $file = "<a href='down.php?infor=$infor&no=".$mf['no']."&wonbon=".$mf['file_wonbon']."' ><img src=".KAPP_URL_T_."/icon/default.gif border=0> <font color=$mf_infor[21]>".$mf['file_name']."($fsize)</a>";
			else $file = "<img src=".KAPP_URL_T_."/icon/default.gif border=0> <font color=$mf_infor[21]>".$mf['file_name']."($fsize)";
			$down_img = "<img src=".KAPP_URL_T_."/file/".$mf_infor[53]."/aboard_".$mf_infor[2]."/".$mf['file_name']." border=0 width=$size[0] height=$size[1] >";
			$down_img  = "";
		}
		if( $down_img) { 
			$bnm = "aboard_" . $mf_infor[2]; // $mf_infor[2] : board name
			$click_data = "window.open('pic2.php?infor=".$infor."&mid=".$mid."&bnm=".$bnm."&fnm=".$mf['file_name']."', '', 'width=$width, height=$height, top=0, left=0, scrollbars=yes')";
		}
?>
          <tr>
            <td align='right' width="100%" height="12" colspan='4'>File:<?=$file?></td>
         </tr>
		 
<?php 
	} // if($mf['file_name'])
?>
			<tr>
				<td colspan="4">
				<?php if( $mf['file_name'] != "" && $down_img != "" ) { ?>
							<a href='#' onClick="<?=$click_data?>" title='mid:<?=$mid?>'><?=$down_img?></a><br>
				<?php } else if( $mf['file_name'] != "" ) { ?>
							<a href='#' onClick="<?=$click_data?>" title="mid:<?=$mid?> : click:<?=$click_data?>"><?=$down_img?></a><br>
				<?php }	?>
				<?=$mf['context']?></td>
			</tr>
			 </table>
			 </td>
		  </tr>
          <tr>
             <td bgcolor="#FFFFFF"> 
				<table cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="15%">[Comment]</td>
                    <td width="70%">
						<textarea name="xcontext_<?=$aaa?>" style="border:1px solid #62a9e4;width:100%" class="input01" rows="1"></textarea></td>
                    <td width="15%">
						<input type='button' value='Submit' title='memo answer t:<?=$mf['target']?>, step:<?=$mf['step']?>, re:<?=$mf['re']?>, aaa:<?=$aaa?>, subject:<?=$mf['subject']?>' onClick="edit_reply_func('<?=$H_LEV?>','<?=$mf['target']?>','<?=$mf['step']?>','<?=$mf['re']?>','<?=$aaa?>','<?=$mf['subject']?>')" style="cursor:hand;"></td>
                  </tr>
				 </table>
                  <!-- <tr>
                    <td colspan="3" height="1"></td>
                  </tr> -->
				<table cellspacing="0" cellpadding="0">
                  <tr>
                    <!-- <td colspan="3" align="right"><table cellspacing="0" cellpadding="5"> -->
<?php
	$xquery="SELECT * from aboard_" . $mf_infor[2] . " where target = '".$mf['target']."' and step > '0' and re > '0' order by target desc , step";
	$xmq = sql_query($xquery);
	if ( $xmq ) { $xtotal = sql_num_rows($xmq); }
	$cntx = 0;

	while( $xmf = sql_fetch_array( $xmq ) ){
		if( $xtotal > $cntx ){
?>
						<tr>
							<td width="85%" align='left'><?=$xmf['context']?>
							
<?php
			if( $H_ID == $xmf['id'] ){	
				$xno = $xmf['no'];
				$day = date("Y-m-d H:i", $xmf['in_date']);
?>
					<a href="javascript:del_func('<?=$xno?>', '<?=$infor?>')" style='color:red' title='Answer delete'><b>[Del]</b></a></td>
<?php
			}
			$nm = $xmf['name'];
?>
						
						<td width="15%" align='right'><font color="#0170aa"><?=$day?><br><?=$nm?></font></td>
						</tr>
<?php
		}
		$cntx = $cntx + 1;
	} //while
?>

                    </tr></table>
                  </td></tr>

                </table>
				</td>
              </tr>
            </table>
            </td>
          </tr>
          
		  <tr>
            <td height="1"></td>
          </tr>

<?php			
	$no--;
	//if($cnt==$size){break;}
	$cnt++; $dep=""; $file=""; $new=""; $memo_cnt="";
}	// while
?>
</form>
          <tr>
				<td width="100%" align='center'>
<?php  
	paging("board_list_memo.php?infor=$infor&search_choice=$search_choice&search_text=$search_text&del_admin=$del_admin",$tot,$page,$line_size,10); 
?>            
				</td>
          </tr>
        </table>
<!------------------공지사항 테이블 끝--------------------------------->        
        <!-- </td>
      </tr>
	  </table>
	</td>  -->
	
 <?=$mf_infor[45]?> <!--  bottom_html -->
