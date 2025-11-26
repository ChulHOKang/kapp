<?php
	include_once('../tkher_start_necessary.php');
	/*
	  detailD.php : 
	          call : replyTT.php, updateD.php, query_ok_new.php
			       : down.php?infor=$infor&no=$mf[0]&wonbon=$mf[13]
				   : include "./memoD.php";
				   : $click_data = "window.open('pic2.php?infor=$infor&file_path=$file_p', '', 'width=$width, height=$height, top=0, left=0, scrollbars=yes')";
				   : <FORM name='view_form' action='index.php' method='post' enctype="multipart/form-data">
				   : include "./inc_listTT.php";
	*/
	include "./infor.php";
	include "./file_size.php";
	include "./string.php";
	$call_pg = 'detailD.php'; // use - memoD.php
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_ID = get_session("ss_mb_id");
	if( $H_ID && $H_ID !=='') {
		$H_LEV	= $member['mb_level'];  
		$H_NAME	= $member['mb_name'];  
		$H_NICK	= $member['mb_nick'];  
		$H_EMAIL = get_session("ss_mb_email"); 
	} else {
		if( $mf_infor[47] == 1 ){
			$H_ID	= 'Guest';  
			$H_NICK	= 'Guest';
			$H_NAME = 'Guest';
			$H_EMAIL= ''; 
			$H_LEV	= 1;
		} else {
			$H_NICK	= '';
			$H_NAME = '';
			$H_LEV	= 0;
			$H_ID	= '';  
			$H_EMAIL= ''; 
		}
	}

	if( isset($_REQUEST['search_choice']) ) $search_choice = $_REQUEST['search_choice'];
	else if( isset($_POST['search_choice']) ) $search_choice = $_POST['search_choice'];
	else $search_choice = '';
	if( isset($_REQUEST['search_text']) ) $search_text = $_REQUEST['search_text'];
	else if( isset($_POST['search_text']) ) $search_text = $_POST['search_text'];
	else $search_text = '';
	if( isset($_REQUEST['list_no']) ) $list_no = $_REQUEST['list_no'];
	else if( isset($_POST['list_no']) ) $list_no = $_POST['list_no'];
	else $list_no = '';
	if( isset($_REQUEST['infor']) ) $infor = $_REQUEST['infor'];
	else if( isset($_POST['infor']) ) $infor = $_POST['infor'];
	else $infor = '';
	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page =1;
	if( isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode'];
	else if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_REQUEST['menu_mode']) ) $menu_mode	= $_REQUEST['menu_mode'];
	else if( isset($_POST['menu_mode']) ) $menu_mode	= $_POST['menu_mode'];
	else $menu_mode	= '';

	if( $H_LEV < $mf_infor[46] && $H_ID !== $mf_infor[53]){
		m_("member permission to read. $H_ID, $mf_infor[47], $mf_infor[46] - $mf_infor[53]"); //47:grant read, 47:grant write
		echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";
		exit;
	}
?>

<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<script src="//code.jquery.com/jquery.min.js"></script>
<script>
	$(function () {
	  $('table.listTableT').each(function() {
		if( $(this).css('border-collapse') == 'collapse') {
		  $(this).css('border-collapse','separate').css('border-spacing',0);
		}
		$(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
	  });
	  $(window).scroll(function() {
		var scrollTop = $(window).scrollTop(),
		  scrollLeft = $(window).scrollLeft();
		$('table.listTableT').each(function(i) {
		  var thead = $(this).find('thead:last'),
			clone = $(this).find('thead:first'),
			top = $(this).offset().top,
			bottom = top + $(this).height() - thead.height();

		  if( scrollTop < top || scrollTop > bottom ) {
			clone.hide();
			return true;
		  }
		  if( clone.is('visible') ) return true;
		  clone.find('th').each(function(i) {
			$(this).width( thead.find('th').eq(i).width() );
		  });
		  clone.css("margin-left", -scrollLeft ).width( thead.width() ).show();
		});
	  });
	});
</script>

<script>
	function board_view(infor, no, page, menu_mode){
		url = "password_.php?infor="+infor + "&menu_mode=" +menu_mode+ "&list_no=" +list_no+ "&page=" +page+ "&call_pg=detailD.php";
		window.open(url,"new","width=600,height=300,scrollbars=no");
	}
	function reply_func( infor, list_no, page, menu_mode){
		document.view_form.mode.value='replyTT';
		document.view_form.action='replyD.php?infor='+infor+'&list_no='+list_no+'&page='+page+'&menu_mode='+menu_mode;
		document.view_form.submit();
	}
	function update_func( infor, list_no, menu_mode, h_lev){
		call_pg = 'detailD.php';
		grant_write =document.view_form.grant_write.value;
		if( grant_write > h_lev ){
			alert('no permission lev: ' + h_lev); return false;
		}
		/*else if( grant_write == h_lev ){
			document.view_form.mode.value='detail_deleteTT';
			url = "detail_update_password.php?infor=" + infor + "&mode=detail_deleteTT" + "&list_no=" + list_no + "&page=" +page+ "&call_pg=" + call_pg+ "&menu_mode=" + menu_mode;
			window.open(url,"newB","width=600,height=300,scrollbars=no");
			return true;
		} else {
			document.view_form.mode.value='updateTT';
			document.view_form.action='updateD.php?menu_mode='+menu_mode;
			document.view_form.submit();
		}*/
			document.view_form.mode.value='updateTT';
			document.view_form.action='updateD.php?menu_mode='+menu_mode;
			document.view_form.submit();

	}
	function detail_func(infor, list_no, page, menu_mode){
		document.view_form.mode.value='detailTT';
		document.view_form.action='detailD.php?infor='+infor+'&list_no='+list_no+'&page='+page+'&menu_mode='+menu_mode;
		document.view_form.submit();
	}

	function del_func( infor, list_no, page, menu_mode  ) {

			document.view_form.mode.value='detail_deleteTT';
			document.view_form.list_no.value=list_no;
			document.view_form.page.value = page;
			//search_choice= document.view_form.search_choice.value;
			//search_text	= document.view_form.search_text.value;
			call_pg = 'detailD.php';
			url = "detail_delete_password.php?infor=" + infor + "&mode=detail_deleteTT" + "&list_no=" + list_no + "&page=" +page+ "&call_pg=" + call_pg+ "&menu_mode=" + menu_mode;
			window.open(url,"newB","width=600,height=300,scrollbars=no");
			return true;

		/*if( confirm("Are you sure you want to delete? ")==true){
			document.view_form.mode.value='detail_deleteTT';
			document.view_form.list_no.value=list_no;
			document.view_form.action='detailD_delete.php';	// 'query_ok_new.php';
			document.view_form.submit();	//window.location.href=url;
		}*/
	}
	 function back_go( infor,list_no, page, menu_mode) {
		x = document.view_form;
		x.action='listD.php?infor='+infor+'&list_no='+list_no+'&page='+page+'&menu_mode='+menu_mode;
		x.submit();
	}
	function board_listTT( infor,list_no, page, menu_mode) {
		x = document.view_form;
		x.action='listD.php?infor='+infor+'&list_no='+list_no+'&page='+page+'&menu_mode='+menu_mode;
		x.submit();

	}
</script>
<link rel="stylesheet" href="../include/css/Oboard.css" type="text/css" />
<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>
</head>
<?php
	if( $list_no > 0 ){ // view count
		$query = "update aboard_".$mf_infor[2]." set cnt=cnt+1 where no=".$list_no;
		$mq = sql_query($query);
	}
	$mf_46 = $mf_infor[46];
	$line_cnt	= $mf_infor[16];
	$orderby		= " order by target desc , step ";
	$where_		= " where subject like '%$search_text%' or context like '%$search_text%' ";
	$whereA		= " where no >= $list_no ";
	$SQL1		= " SELECT * from aboard_" . $mf_infor[2];
	if( $list_no > 0 ) 	$SQL1 = $SQL1 . $whereA . $orderby;
	else if( $mode=='SR' )	$SQL1 = $SQL1 . $where_ . $orderby;
	else				$SQL1 = $SQL1 . $orderby;
	if( ($result = sql_query( $SQL1 ) )==false ){
		printf("Invalid query: %s\n", $SQL1);
		my_msg(" no found data Select Error ");
		$total_count = 0;
	} else {
		$total_count = sql_num_rows($result);
		if( $total_count) $total_page  = ceil($total_count / $line_cnt);			// 전체 페이지 계산
		else $total_page  =1;
		
		if( $page < 2) {
			$page  = 1;										// 페이지가 없으면 첫 페이지 (1 페이지)
			$start = 0;
		} else {
			$start = ($page - 1) * $line_cnt;					// 시작 열을 구함
		}
		$last = $line_cnt;										// 뽑아올 게시물 [끝]
		if( $total_count < $last) $last = $total_count;
	}
	$query="SELECT * from aboard_" . $mf_infor[2] . " where no=".$list_no;
	//m_( $mf_infor[2] . ", list_no: ".$list_no . ", infor: " . $infor);
	$mq		= sql_query($query);
	$mf		= sql_fetch_row($mq);
	$mid	= $mf_infor[53]; // 53:make_id , $mf[2];
	$fsize	= $mf[14];
	$grant_read	= $mf_infor[46];
	$grant_write= $mf_infor[47];

	if( $mf_infor[2] == 'kapp_Notice' || $mf_infor[2] == 'kapp_news' || $mf_infor[2] == 'kapp_qna' || $mf_infor[2] == 'kapp_free') $f_path1	= KAPP_PATH_T_ . "/file/";
	else $f_path1	= KAPP_PATH_T_ . "/file/" . $mf_infor[53];
	$fpath	= $f_path1 . "/aboard_".$mf_infor[2]; // 2: board name
	$mf[7]	= date("y/m/d H:i", $mf[7]);
	$mf[8]	= iconv_substr($mf[8], 0, 50, 'utf-8');// . "...";
	if( $search_text){ $mf[9] = preg_replace("($search_text)","<font color=blue>\\1</font>",$mf[9]);}
	$p = $mf[21];
	if( isset($_SESSION['security'])) {
		$security = $_SESSION['security'];
		if( $mf[21] !== "" and $mf[21] !== $security) {
			echo "<script>board_view($infor, $list_no, $page, $menu_mode );</script>";
			exit;
		}
	} else {
		$security = '';
	}
?>
<body bgProperties="" leftmargin="0" topmargin="0" height='100%'>
<center>
<?php
	$cur='B';
	if( $menu_mode != 'off') include_once "../menu_run.php";
	function get_size( $tmp_file, $infor2) {
		global $width, $height, $mid, $fpath;
		$size_factor	= 500;
		$size0			= @GetImageSize("$fpath/$tmp_file"); 
		$x					= $size0[0];
		$y					= $size0[1];
		$width			= $size0[0];
		$height			= $size0[1];
		if( $size0[0] == 0 ) $size0[0]=1; 
		if( $size0[1] == 0 ) $size0[1]=1; 
		if( $size0[0]>$size0[1]) { $per=$size_factor / $size0[0]; } 
		else { $per=$size_factor / $size0[1]; } 
		if( $size0[0] > $size_factor ) {
			$x_size=$size0[0]*$per; 
			$y_size=$size0[1]*$per; 
		} else {
			$x_size=$size0[0];
			$y_size=$size0[1];
		}
		$win_width  = $size0[0] + 15; 
		$win_height = $size0[1] + 30; 
		return $x_size."X".$y_size;
	} // func end
?>
<?=$mf_infor[44]?>

<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC"  align='center'>
	<FORM name='view_form' action='listD.php' method='post' enctype="multipart/form-data">
		<input type='hidden' name='search_choice' 		value='<?=$search_choice?>' >
		<input type='hidden' name='search_text' 		value='<?=$search_text?>' >
		<input type='hidden' name='infor' 				value='<?=$infor?>' >
		<input type='hidden' name='list_no' 			value='<?=$list_no?>' >
		<input type='hidden' name='page' 				value='<?=$page?>' >
		<input type='hidden' name='del_admin' >
		<input type='hidden' name='mode' 				value='<?=$mode?>' >
		<input type='hidden' name='del' 					value=''>
		<input type='hidden' name='previous' 			value='detailD.php' >
		<input type='hidden' name='target'				value='<?=$mf[18]?>'>
		<input type='hidden' name='step'					value='<?=$mf[19]?>'>
		<input type='hidden' name='re'					value='<?=$mf[20]?>'>
		<input type='hidden' name='grant_read' value='<?=$mf_infor[46]?>'>
		<input type='hidden' name='grant_write' value='<?=$mf_infor[47]?>'>
		<input type="hidden" name='menu_mode'	value='<?=$menu_mode?>' />
	</form>
<?php
	$file="";
if( $mf[12]){	// file_name, 
	$width  = 0; 
	$height = 0; 
	$file="";
	if( $mf[15]=='.gif' || $mf[15]=='.jpg' || $mf[15]=='.png'){	// 14->15, 13->14 $mf[15]=='.bmp' 
		$file="<a href='down.php?infor=$infor&no=$mf[0]&wonbon=$mf[13]' <img src=../icon/subject.gif border='0'> <font color='$mf_infor[21]'>$mf[13]($fsize)</a>";
			$tmp = get_size( $mf[12], $mf_infor[2]); 
			$size = explode("X", $tmp); 
			$img = "<img src='$fpath/$mf[12]' border='0' width='$size[0]' height='$size[1]' >";
	} else if( $mf[15]=='.zip'||$mf[15]=='.rar'||$mf[15]=='.mp3'||$mf[15]=='.mp4'||$mf[15]=='.avi'||$mf[15]=='.txt'){
		$fp_path= KAPP_URL_T_ . "/file/".$mf_infor[53] ."/aboard_". $mf_infor[2]. "/". $mf[12]; // $mf[16]/$mf[12]
		$file="<a href='down.php?infor=$infor&no=$mf[0]&wonbon=$mf[13]' target='_blank' title='TXT $mf[12] - $fp_path'><img src='../icon/file/default.gif' border='0'> <font color='$mf_infor[21]'>$mf[13]($fsize)</a>";
	} else {
		$fp_path= KAPP_URL_T_ . "/file/".$mf_infor[53] ."/aboard_". $mf_infor[2]. "/". $mf[12]; // $mf[16]/$mf[12]
		$file="<a href='down.php?infor=$infor&no=$mf[0]&wonbon=$mf[13]' target='_blank' title='XLSX $mf[12] - $fp_path'><img src='../icon/file/default.gif' border='0'> <font color='$mf_infor[21]'>$mf[13]($fsize)</a>";
	}
}
    $in_day = date("y/m/d H:i", time());
?>
		<div class="viewHeader">
			<span><?=$in_day?></span>
			<a href="javascript:back_go('<?=$infor?>','<?=$list_no?>','<?=$page?>')" class="btn_bo02">Previous</a>
			<a href="javascript:board_listTT('<?=$infor?>','<?=$list_no?>','<?=$page?>','<?=$menu_mode?>');" class="btn_bo02">List</a>
		</div>
		<div class="viewSubj" ><span title='infor:<?=$mf_infor[0]?>'><?=$mf_infor[1]?></span> </div>
					<div class="blankA"> </div>
					<div>
						<div class="menu2T"><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Subject</span></div>
						<div class="data2A"><!-- <span title='list no:<?=$mf[0]?>'> [<?=$mf[0]?>]</span> --><span title='list no:<?=$mf[0]?>'><?=$mf[8]?> </span></div>
						<div class="menu2T"><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>FILE</span></div>
						<div class="data2A"><span><?=$file?></span></div>
					</div>
					<div class="blankA"> </div>
<?php if($mf_infor[6]){ ?>
					<div>
						<div class="menu2T"><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Writer</span></div>
						<div class="data2A"><span> <?=$mf[3]?> </span></div>
						<div class="data4A"><span> <?=$mf[17]?> </span></div> -->
						<div class="menu2T"><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Date</span></div>
						<div class="data2A"><span> <?=$mf[7]?> </span></div>
					</div>
<?php } else { ?>
					<div>
						<div class="menu2T"><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Writer</span></div>
						<div class="data2A"><span> <?=$mf[3]?> </span></div>
						<div class="menu2T"><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Date</span></div>
						<div class="data2A"><span> <?=$mf[7]?> </span></div>
					</div>

<?php } ?>
<?php 
	$content = $mf[9];
?>
</table>
		<table width="100%" border="0" borderColorDark="#fdfdfa" borderColorLight="#bec9d4" cellSpacing="0" cellpadding="0">
			<tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
			 <td><?=$content?></td>
			</tr>
		  <tr><td width="98%" height="1" bgcolor="#ffffff" background="../icon/dot.gif"></td></tr>
          <tr>
            <td width="100%" ><?php if($mf_infor[5]){ include "./memoD.php"; } ?></td>	<!-- MEMO. -->
          </tr>
		  <tr><td width="98%" height="1" bgcolor="#ffffff" background="../icon/dot.gif"></td></tr><!-- ..... -->
		</table>
    <table width="99%" bgcolor=<?=$mf_infor[20]?> border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td align='center' width="100%" height="20" >
<?php
	if( $H_LEV > 7 ){
?>
         <a href='updateD.php?mode=updateTT&infor=<?=$infor?>' target='_blank'><img src='../icon/e_admin.gif' width='30' border='0' target='_blank' title='Bulletin Board Management '></a>
<?php
	 }
?>
    <?php
        for( $i=$mf[0]+1;$i<$mf[0]+5;$i++){
        	   $query="select no from aboard_".$mf_infor[2]." where no=".$i;
			   $prev	= sql_fetch( $query);
                if( $prev > 0){
					echo "<input type='button' value=' Previous ' 
					onclick=\"javascript:window.open('detailD.php?list_no=$i&infor=$infor&page=$page&search_choice=$search_choice&search_text=$search_text','_self',''); \" >";
					break;
				}
         }
         for( $i=$mf[0]-1;$i>0;$i--){
			$query="select no from aboard_".$mf_infor[2]." where no=".$i;
			$mq=sql_query($query);
			$next=sql_num_rows($mq);
			if($next){
				echo(" 
				&nbsp;&nbsp;&nbsp;<input type='button' title='next no=".$i."' value=' Next ' onclick=\"javascript:window.open('detailD.php?list_no=$i&infor=$infor&page=$page&search_choice=$search_choice&search_text=$search_text','_self','')\">
				");
				break;
			}
         }
	?>
    <?php if( $search_choice){ ?>
         &nbsp;&nbsp;&nbsp;<input type='button' value=' Search ' onclick="javascript:window.open('listD.php?list_no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>&del_admin=<?=$del_admin?>','_self','')">
	<?php } ?>
        
<?php
	if ( $mf_infor[47]== 1 || $mf_infor[53]==$H_ID || $H_LEV > 7 || $mf[2]==$H_ID ){
?>
        &nbsp;&nbsp;&nbsp;<input type='button' value=' Answer ' onclick="reply_func('<?=$infor?>','<?=$list_no?>','<?=$page?>','<?=$menu_mode?>')" title='Write your answer.'>
        &nbsp;&nbsp;&nbsp;<input type='button' value=' Write ' onclick="javascript:window.open('insertD.php?list_no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&menu_mode=<?=$menu_mode?>&previous=detailD.php','_self','')" >        
        &nbsp;&nbsp;&nbsp;<input type='button' value=' Update ' onclick="javascript:update_func('<?=$infor?>', '<?=$list_no?>','<?=$menu_mode?>', '<?=$H_LEV?>')" title='Guest, <?=$mf_infor[47]?>, <?=$mf[2]?>, id:<?=$H_ID?>'>
		&nbsp;&nbsp;&nbsp;<input type='button' value=' Delete ' onclick="del_func('<?=$infor?>', '<?=$list_no?>', '<?=$page?>','<?=$menu_mode?>')" title='Delete the post.'>
        &nbsp;&nbsp;&nbsp;<input type='button' value=' List ' onclick="javascript:window.open('listD.php?infor=<?=$infor?>&page=<?=$page?>&menu_mode=<?=$menu_mode?>','_self','')" >
<?php } else if ( $H_ID && $H_LEV > 1 ){ ?>
        &nbsp;&nbsp;&nbsp;<input type='button' value=' Answer ' onclick="reply_func( '<?=$infor?>','<?=$list_no?>','<?=$page?>','<?=$menu_mode?>')" title='Write your answer.'>
        &nbsp;&nbsp;&nbsp;<input type='button' value=' List ' onclick="javascript:window.open('listD.php?infor=<?=$infor?>&page=<?=$page?>&menu_mode=<?=$menu_mode?>','_self','')" >
<?php } else if ( $mf_infor[47] == 1 ){ ?>
		&nbsp;&nbsp;&nbsp;<input type='button' value=' Delete ' onclick="del_func('<?=$infor?>', '<?=$list_no?>', '<?=$page?>','<?=$menu_mode?>')" title='Delete the post.'>
        &nbsp;&nbsp;&nbsp;<input type='button' value=' List ' onclick="javascript:window.open('listD.php?infor=<?=$infor?>&page=<?=$page?>&menu_mode=<?=$menu_mode?>','_self','')" >
<?php } else { ?>
        &nbsp;&nbsp;&nbsp;<input type='button' value=' List ' onclick="javascript:window.open('listD.php?infor=<?=$infor?>&page=<?=$page?>&menu_mode=<?=$menu_mode?>','_self','')" >
<?php } ?>

        <?php if( !$search_choice ) { $link="&page=$page";} ?>

         </td>
    </tr>
	</table>
<br>
    <table width="100%" bgcolor='<?=$mf_infor[20]?>' border="0" cellpadding="0" cellspacing="0">
<?php 
	// re
	if($mf_infor[43]){
		$query = "select no, name, subject, context, id, target,step,re, in_date from aboard_".$mf_infor[2]." where target=".$mf[18]." order by step";
		$mq = sql_query($query);
		$mn = sql_num_rows($mq);
		if( $mn > 1 ){
			$mn= $mn-1;
?>
			<tr>
			  <td colspan='2' width="100%" height="1" >
				&nbsp; <font color='<?=$mf_infor[21]?>'>Answer(<?=$mn?>)</font></td>
			</tr>
			<tr><td colspan='2' width="98%" height="1" bgcolor="#ffffff" background="../icon/dot.gif"></td></tr><!-- ...... -->
<?php 
			$dep="";
			while( $data = sql_fetch_row($mq)){
				for($i=0; $i< $data[7]; $i++){$dep=$dep . "&nbsp;";} // 7:re
				$day = date("m/d/Y H:i", $data[8]);
				if( $data[7] > 0 ) { $per = 100 - $data[7]*1; $wper=$data[7]+8;}
				else { $per= 100; $wper=10;}
				if( $data[7] > 0 ) { // 7: re
					$no = $data[0];
?>
					<table width="<?=$per?>%" bgcolor='<?=$mf_infor[20]?>' border="0" cellpadding="0" cellspacing="20" align='right'>
						<tr>
							<td width="<?=$wper?>" height="1">
									<img src='../icon/list_reply.gif' border='0'>
							</td>
							<td width="73%" height="15" align='left'>
									<a href="javascript:detail_func('<?=$infor?>', '<?=$no?>', '<?=$page?>', '<?=$menu_mode?>')" >
									<font color='<?=$mf_infor[21]?>'>[<?=$data[6]?>]&nbsp;&nbsp;<?=$temp1?><?=$data[2]?><?=$temp2?></a>
							</td>
							<td width="25%" align='right'>
								<font size='2' color='<?=$mf_infor[19]?>'> [<?=$data[1]?>]-[<?=$day?>]</font>
							</td>
						</tr>
						<tr>
							<td width="<?=$wper?>" height="1"></td>
							<td colspan='2' align='left' style='background-color:#FAFAFA' ><?=$data[3]?></td>
						</tr>
						<tr><td colspan='3' width="100%" height="1" bgcolor="#ffffff" background="../icon/dot.gif"></td></tr>
					</table>
	<?php 
			}
				$temp1="";$temp2="";
				$dep="";

 		  } // while
		} //if
	} //if
?>
	</table>
	<table width='100%' class="listTableT" align='center' bgcolor='<?=$mf_infor[20]?>' border="0" cellpadding="0" cellspacing="0">
	</table>
    <!-- End of Paging Table -->
	<?=$mf_infor[45]?><!-- aboard_infor : bottom_html -->
