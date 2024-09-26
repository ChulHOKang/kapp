<?php
	include_once('./tkher_start_necessary.php');
?>
<html>
<head>
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<?php
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	/* ------------------------------------------------------------------
		link_list_all.php
			call : r1_my.php : index_a0_my.php , runf_my.php
			call : runf_my.php : tree_run_generator.php, link_list_all.php
	------------------------------------------------------------------ */
    $mode = $_POST["mode"];
	 $page = $_REQUEST['page'];
	 if( !$page ) $page=1;
?>
<link rel=StyleSheet HREF='./inlcude/css/default.css' type=text/css title=style>
 <script type="text/javascript" src="./include/js/ui.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
<?php
		$cur='B';
		include_once "./menu_run.php";
?>

<script>
$(function () {
  $('table.floating-thead').each(function() {
    if( $(this).css('border-collapse') == 'collapse') {
      $(this).css('border-collapse','separate').css('border-spacing',0);
    }
    $(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
  });

  $(window).scroll(function() {
    var scrollTop = $(window).scrollTop(),
      scrollLeft = $(window).scrollLeft();
    $('table.floating-thead').each(function(i) {
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
</head>
<script language="javascript">
<!--
	function delete_func ( tit, tkher_no, type, webnum ) {
		if( confirm('Are you sure you want to delete? title:'+tit) ) {
			tkher_form.mode.value='delete_func';
			tkher_form.tkher_no.value=tkher_no;
			tkher_form.tkher_type.value=type;
			tkher_form.webnum.value=webnum;
			tkher_form.action='link_list_all.php';
			tkher_form.submit();
		}
	}
	function call_pg_select( link_, id, group, title_, jong, num, aboard_no, seqno) {
		document.tkher_form.link_.value =link_;
		document.tkher_form.mid.value   =id;
		document.tkher_form.group.value =group;
		document.tkher_form.title_.value=title_;
		document.tkher_form.jong.value  =jong;
		document.tkher_form.num.value   =num;
		document.tkher_form.pg.value    =num;
		document.tkher_form.sys_pg.value=num;
		document.tkher_form.sys_subtit.value =group;
		document.tkher_form.aboard_no.value  =aboard_no;
		document.tkher_form.sys_board_num.value  =aboard_no;
		document.tkher_form.seqno.value      =seqno;
		document.tkher_form.action='./menu/cratree_coinadd_menu.php';
		document.tkher_form.target='_blank';
		document.tkher_form.submit();
	}
// -->
</script>
<body leftmargin='0' topmargin='0' bgproperties='fixed' bgcolor='black'> <font color='cyan'>
<?php
	$param = "sys_subtit";
	$sel = "like";
	$data = $_REQUEST['data'];
	if( $data ) {
		if( $sel == 'like' )   $xdata = "'%".$data."%'";
		else if( $sel == '=' ) $xdata = "'".$data."'";
		$W = " where " . $param . " " . $sel . " " . $xdata . " ";
	} else $W = " ";

	$OBY = " order by up_day desc ";
	$query = "SELECT * from {$tkher['sys_menu_bom_table']} " . $W . $OBY;
	$limite		= 15;								// 한페이지에 나타낼 글자 갯수
	$page_num	= 10;								// [1] [2] [3] 갯수
	$result = sql_query( $query);
	$total  = sql_num_rows( $result );
	if(!$page) $page=1;								// 페이지가 없으면 1로 정한다
	$total_page = intval(($total-1) / $limite)+1; // 총 페이지수를 구해온다
	$first = ($page-1)*$limite;						// 뽑아올 게시물 [처음]
	$lastX = $limite;								// 뽑아올 게시물 [끝]
	if( $total < $lastX ) $lastX = $total;
	$LLL = " limit " . $first . " , " . $lastX ;

	if ($page == "1")
		$no = $total;
	else {
		$no = $total - ($page - 1) * $limite;
	}
	$sql = "SELECT * from {$tkher['sys_menu_bom_table']} " . $W . $OBY . $LLL;
	$result = sql_query( $sql );
	$row = sql_num_rows( $result);

 if ( $row > 0) {
		$pagenum = $page;
		$recordcount = $row;
?>
<center>
<?php
		//echo "total count:" . $total;
?>
<form name="tkher_form" method='Post' enctype="multipart/form-data">
	<input type='hidden' name='mode' value=''>
	<input type='hidden' name='webnum' value=''>
	<input type='hidden' name='tkher_no' value=''>
	<input type='hidden' name='tkher_type' value=''>
	<input type='hidden' name='param' value='<?=$param?>'>
	<input type='hidden' name='sel' value='<?=$sel?>'>
	<input type='hidden' name='data' value='<?=$data?>'>

	<input type='hidden' name='link_' value=''>
	<input type='hidden' name='mid' value=''>
	<input type='hidden' name='group' value=''>
	<input type='hidden' name='title_' value=''>
	<input type='hidden' name='jong' value=''>
	<input type='hidden' name='pg' value=''>
	<input type='hidden' name='num' value=''>
	<input type='hidden' name='sys_pg' value=''>
	<input type='hidden' name='sys_subtit' value=''>
	<input type='hidden' name='aboard_no' value=''>

	<input type='hidden' name='sys_board_num' value=''><!-- add 2024-01-23 -->
	<input type='hidden' name='seqno' value=''>
</form>
<table class='floating-thead' border='0' cellspacing='5' >
<tbody width='100%'>
	<tr width='100%'>
	<DIV>Note List (total:<?=$total?>)</DIV>
	</tr>
 <thead>
	<tr>
	<TH><font color='cyan'>no</TH>
	<TH><font color='cyan'>Title</TH>
	<TH><font color='cyan'>Link-URL</TH>
	<TH><font color='cyan'>Type</TH>
	<TH><font color='cyan'>view</TH>
	<TH><font color='cyan'>date</TH>
	</tr>
 </thead>
 <?php
    $count = $disp_tot_cnt;
	$number = ($page - 1) * $limite;
	$j=0;
	while ( $rs = sql_fetch_array($result) )
	{
		$line = $nowrecord + $disp_tot_cnt+1 - $count ;
		$number = $number + 1;
  ?>
		 <tr valign='top' width='100%'>
		 <td><font color='cyan'><?=$number?></font></td>
 <?php
		$sys_pg    = $rs['sys_pg'];
		$link_type = $rs['tit_gubun'];
		if ( $rs['tit_gubun'] =='B' ) {
			$book_ = '<font color=yellow>트리북';
			$tree_color = '<font color=yellow>'; //$jong='B';				// Tree Doc  D -> N
			if( strpos( $rs['sys_link'], "contents_view_menu" ) !== false) $u_ = "./menu/" . $rs['sys_link'];
			else $u_ = KAPP_URL_T_  . $rs['sys_link'];
			$bb='yellow';
			//$run_mode = 'cratree_book_remake';
		} else if( $rs['tit_gubun'] =='A' ) {    // $rs['tit_gubun'] =='G'
			$book_ = '<font color=green>T-Board';
			$tree_color = '<font color=green>';  //$jong='G';				// Tree Board
			$u_ = $rs['sys_link'];
					$run_mode = 'cratree_bbs_remake';
					$bb='green';
		} else if( $rs['tit_gubun'] =='T' ) {
			$book_ = '<font color=grace>Link Tree';
			$tree_color = '<font color=grace>';  //$jong= 'T';
			$u_ = $rs['sys_link'];
					$bb='grace';
					$run_mode = 'cratree_remake';
		} else {	  // $jong= 'X';
			$book_ = '<font color=grace>Link Tree';
			$tree_color = '<font color=grace>';
			if( strpos( $rs['sys_link'], "index_bbs" ) !== false) $u_ = "./menu/" . $rs['sys_link']; // 2024-01-18
		}
		//$treeT = KAPP_URL_T_ . '/tree_menu_guest.php?sys_pg=' . $rs['sys_pg'] . '&sys_subtitS=' . $rs['sys_subtit'] .'&open_mode=off&mid='.$rs['sys_userid'].'&job_addr='.$rs['sys_link'];
		//$treeT = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $rs['sys_pg'] . '&sys_subtitS=' . $rs['sys_subtit'] .'&open_mode=off&mid='.$rs['sys_userid'].'&job_addr='.$rs['sys_link'];

		if( $rs['tit_gubun'] == 'B' || $rs['tit_gubun'] == 'M'|| $rs['tit_gubun'] == 'N'){
			$treeM = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $rs['sys_pg'] . '&sys_jong=note' . '&num='.$rs['book_num']. '&sys_subtitS='.$rs['sys_subtit'].'&open_mode=off&mid='.$rs['sys_userid'].'&job_addr='.$rs['sys_link'];
			$treeT = $treeM; //$rs['sys_link'];
		} else if( $link_type == 'A'){ // ABoard
			$treeM = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $rs['sys_pg'] . '&sys_jong=board' . '&num='.$rs['book_num']. '&sys_subtitS='.$rs['sys_subtit'].'&board_num='.$rs['sys_board_num'].'&open_mode=off&mid='.$rs['sys_userid'].'&job_addr='.$rs['sys_link'];
			$treeT = $treeM;
		} else if( $link_type == 'T'){ // link
			$treeM = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $rs['sys_pg'] . '&sys_jong=link' . '&num='.$rs['book_num']. '&sys_subtitS='.$rs['sys_subtit'].'&open_mode=off&mid='.$rs['sys_userid'].'&job_addr='.$rs['sys_link'];
			$treeT = $treeM;
		} else {
			$treeM = $rs['sys_link'];
			$treeT = $rs['sys_link'];
		}
		$treeM = urlencode($treeM);
		$treeT = urlencode($treeT);

		$rsuser_id   = $rs['sys_userid'];
		$rsuser_name = $rs['sys_subtit'];
		$rssys_pg    = $rs['sys_pg'];
		$rsaboard_no = $rs['book_num'];
		$view_cnt    = $rs['view_cnt'];
		$rsseqno     = $rs['seqno'];
?>
			<td><a href="javascript:call_pg_select( '<?=$treeM?>', '<?=$rsuser_id?>', '<?=$rssys_pg?>', '<?=$rsuser_name?>','<?=$link_type?>','<?=$rssys_pg?>','<?=$rsaboard_no?>', '<?=$rsseqno?>' )" style="border-style:;background-color:black;color:yellow;height:20;" title='maker - <?=$rsuser_id?>'><?=$rs['sys_subtit'] ?>
			<img src="<?=KAPP_URL_T_?>/icon/default.gif"></a></td>

			<td><a href="javascript:call_pg_select( '<?=$treeT?>', '<?=$rsuser_id?>', '<?=$rssys_pg?>', '<?=$rsuser_name?>','<?=$link_type?>','<?=$rssys_pg?>','<?=$rsaboard_no?>', '<?=$rsseqno?>' )" title='maker - <?=$rsuser_id?>, type:<?=$link_type?> '><?=$tree_color?><?=$rs['sys_link'] ?></font></a></td>

			<td title='T:Tree, B:Note, G:Board'><font color=<?=$bb?>><?=$link_type?></font></td>
			<td title='<?=$view_cnt?>' style='height:18px;background-color:black;color:cyan'><?=$view_cnt?>
			<td title='maker - <?=$rsuser_id?>' style='height:18px;background-color:black;color:cyan'><?=$rs['up_day']?>
<?php
		if( $H_ID != "" and $H_LEV > 1 ) {
			$rs_book_num = $rs['book_num'];
			$rs_sys_pg   = $rs['sys_pg'];
			$rs_sys_subtit = $rs['sys_subtit'];
		}
?>
			</td>
		</tr>
 <?php
		$count = $count - 1;
		$j++;
    }//loop while end
?>
 </tbody>
 </table>
<?php
  } else {
?>
	Record no found!
<?php
 }
	// 한 화면에 출력될 페이지 링크가 3개라고 가정 하면 현재 페이지가 4라면 4,5,6 이라는 링크만 출력되게 한다
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);// 4가 나오는식
	$last_page = $first_page+($page_num-1);// 6을 구하는식
	if( $last_page > $total_page) $last_page = $total_page;
	$prev = $first_page-1;// [이전] 버튼 링크
	$pp = 'page='.$prev.'&data='.$data;
	if($page > $page_num) echo"[<a href=$PHP_SELF?$pp><font color='yellow'>Prev</a>] ";
	//if($page > $page_num) echo"[<a href=$PHP_SELF?page=$prev&data=$data>이전</a>] ";
	for($i = $first_page; $i <= $last_page; $i++)// 페이지 링크 출력 : 4와 6을 구했으니 여기서는 4~6까지를 for문으로 출력// [4] [5] [6]
	{
		$pp = "<a href='".$PHP_SELF."?page=" . $i . "&data=" . $data . "' ><font color='white' size='5'>[".$i."]</font></a>";
		if($page == $i) echo"<font color='yellow' > $i </font>"; // 출력될 번호가 현재 페이지랑 같다면 진하게
		else echo "$pp";
	}
	$next = $last_page+1;// [다음] 버튼 출력
	$pp = 'page='.$next.'&data='.$data;
	if($next <= $total_page) echo"[<a href=$PHP_SELF?$pp><font color='yellow'>Next</a>]";
?>
</body>
</html>
