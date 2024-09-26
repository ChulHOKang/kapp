<?php
	include_once('../tkher_start_necessary.php');
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
	//$from_session_id = $H_ID;
	/*if (!$H_ID || !$H_LEV) {
		$url = "url_list_all.php";
		echo "<script>alert('Member Login! Please!'); window.open('/', '_top', '');</script>";
		exit;
	}*/
	/* ------------------------------------------------------------------
		treelist2_my.php
			call : r1_my.php : index_a0_my.php , runf_my.php
			call : runf_my.php : tree_run_generator.php, treelist2_my.php
	------------------------------------------------------------------ */
    if( isset($_POST["mode"])) $mode = $_POST["mode"];
	else $mode = '';
	if( $mode == 'delete_func'){
		/*
		$tkher_type= $_POST["tkher_type"];
		$tkher_no	= $_POST["tkher_no"];
		$webnum	= $_POST["webnum"];
		if( $tkher_type == 'job_link_table') {
			if($H_LEV > 7 ) $chkpass = " ";
			else $chkpass = " and user='$H_ID' ";
			$query ="SELECT * from {$tkher['webeditor_table']} where num='$webnum' $chkpass ";
			$mq    =sql_query($query);
			$mn    =sql_num_rows($mq);
			if($mn){
				$rs  = sql_fetch_array($mq);
				$dir = substr($rs[date],0,7);
				if( $rs['up_file'] != ""){
					$del_file = "../contents/webeditor/". $dir . "/" . $rs['up_file'];
					exec ("rm $del_file");
				}
				$result = sql_query( "delete from {$tkher['job_link_table']} where seqno='$tkher_no'" );
				$result = sql_query( "delete from {$tkher['webeditor_table']} where num='$webnum'" );
				$result = sql_query( "delete from {$tkher['webeditor_table']}_comment where num='$webnum'" );
			} else {
				$result = sql_query( "delete from {$tkher['job_link_table']} where seqno='$tkher_no'" );
			}
		} else if( $tkher_type == 'sys_bom' ) {
			//$sql = "delete from sys_bom where sys_pg='$tkher_no' ";
			//sql_query( $sql );
		}
		$rungo = "r1_my.php";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";*/
	}
	 $page = $_POST['page'];
	 if( !$page ) $page=1; // m_("page: " . $page);
?>
<link rel=StyleSheet HREF='<?=KAPP_URL_T_?>/inlcude/css/default.css' type=text/css title=style>
 <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
<?php
		$cur='B';
		include_once KAPP_PATH_T_ ."/menu/menu_run.php"; 
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
			tkher_form.action='treelist2_my.php';
			tkher_form.submit();
		}
	}
	function call_pg_select( link_, id, group, title_, jong, num, aboard_no, seqno){
		//alert("link:" + link_ + ", id:" + id + ", tit:" + title_ + ", jong:" + jong + ", num:" + num + ", aboard_no:" + aboard_no + ", seqno:" + seqno);
		//link:contents_view_menuD.php?num=dao1704844396, id:dao, tit:호스팅비용-스마일서버, jong:B, num:dao1703742132, aboard_no:dao1704844396, seqno:42
		document.tkher_form.link_.value=link_;
		document.tkher_form.mid.value=id;
		document.tkher_form.group.value=group;
		document.tkher_form.title_.value=title_;
		document.tkher_form.jong.value=jong;
		document.tkher_form.num.value=num;
		document.tkher_form.sys_pg.value=num;
		document.tkher_form.sys_subtit.value=group;
		document.tkher_form.aboard_no.value=aboard_no;
		document.tkher_form.sys_board_num.value=aboard_no;

		document.tkher_form.seqno.value=seqno;
		document.tkher_form.action='<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';		
		document.tkher_form.target='_blank';
		document.tkher_form.submit();
	}
	function page_move($page){
		document.tkher_form.page.value = $page;
		document.tkher_form.action='treelist2_my.php';
		document.tkher_form.submit();
	}
	function Change_line_cnt( $line ){
		document.tkher_form.page.value = 1;
		document.tkher_form.line_cnt.value = $line;
		document.tkher_form.action='treelist2_my.php';
		document.tkher_form.submit();
	}
// -->
</script>
<body leftmargin='0' topmargin='0' bgproperties='fixed' bgcolor='black'> <font color='cyan'>
<?php
	if( isset($_POST['line_cnt']) ) $line_cn = $_POST['line_cnt'];
	else $line_cnt	= 10;
	$page_num	= 10;								// [1] [2] [3] 갯수

	//if ( $mode == 'delete' ) {
		//$sql = " delete  from sys_bom where sys_pg ='$sys_pg' and sys_userid='$H_ID' ";
		//sql_query( $sql );
	//}
	$param = "sys_subtit";	//$_REQUEST[param];
	$sel = "like";			//$_REQUEST[sel];
	if( isset($_POST['data']) ){
		$data = $_POST['data'];
		if( $sel == 'like' )   $xdata = "'%".$data."%'";
		else if( $sel == '=' ) $xdata = "'".$data."'";
		$W = " where sys_userid='" . $H_ID . "' and " . $param . " " . $sel . " " . $xdata . " "; 
	} else $W =" where sys_userid='" . $H_ID ."' " ;
	//else $W =" where sys_level='mroot' and sys_userid='" . $H_ID ."' " ;
	$OBY = " order by up_day desc ";
	$query = "SELECT * from {$tkher['sys_menu_bom_table']} " . $W . $OBY;
	$result = sql_query( $query);

	/*
	$total_count  = sql_num_rows( $result );
	if( !$page) $page=1;								// 페이지가 없으면 1로 정한다
	$total_page = intval(($total_count-1) / $line_cnt)+1; // 총 페이지수를 구해온다
	$first = ($page-1)*$line_cnt;						// 뽑아올 게시물 [처음]
	$lastX = $line_cnt;								// 뽑아올 게시물 [끝]
	if($total_count < $lastX) $lastX = $total_count;
	*/

	$total_count = sql_num_rows($result);
	if( $total_count ) $total_page  = ceil($total_count / $line_cnt);			// 전체 페이지 계산
	else $total_page  =1;
	if( $page < 2) {
		$page = 1;										// 페이지가 없으면 첫 페이지 (1 페이지)
		$start = 0;
	} else {
		$start = ($page - 1) * $line_cnt;					// 시작 열을 구함
	}
	$last = $line_cnt;										// 뽑아올 게시물 [끝]
	if( $total_count < $last) $last = $total_count;
	$SQL_limit	= "  limit " . $start . ", " . $last;
	$sql = "SELECT * from {$tkher['sys_menu_bom_table']} " . $W . $OBY . $SQL_limit;
	$result = sql_query( $sql );
	$row = sql_num_rows( $result);
	
if ( $row > 0) { 
?>
	<center>
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
		<input type='hidden' name='num' value=''>
		<input type='hidden' name='sys_pg' value=''>
		<input type='hidden' name='sys_subtit' value=''>
		<input type='hidden' name='aboard_no' value=''>
		<input type='hidden' name='sys_board_num' value=''><!-- aboard_no -->
		<input type='hidden' name='seqno' value=''>
		<input type='hidden' name='page' value='<?=$page?>' >
		<input type="hidden" name='line_cnt' value='<?=$line_cnt?>' />
	</form>
	<table class='floating-thead' border='0' cellspacing='5' >

	<tbody width='100%'>
		<tr width='100%'> 
		<DIV>Note List (total:<?=$total_count?>)
			&nbsp;&nbsp;&nbsp; Page line:<select id='line_cntS' name='line_cntS' onChange="Change_line_cnt(this.options[this.selectedIndex].value);" style='height:20;'>
				<option value='10'  <?php if( $line_cnt=='10' )  echo " selected " ?> >10</option>
				<option value='30'  <?php if( $line_cnt=='30' )  echo " selected " ?> >30</option>
				<option value='50'  <?php if( $line_cnt=='50')   echo " selected" ?>  >50</option>
				<option value='100' <?php if( $line_cnt=='100')  echo " selected" ?>  >100</option>
			</select>
		
		</DIV>
		</tr>
	 <thead>
		<tr>
		<TH><font color='cyan'>no</TH>
		<TH><font color='cyan'>Title</TH>
		<TH><font color='cyan'>Link-URL</TH>
		<TH><font color='cyan'>Type</TH>
		<TH><font color='cyan'>date</TH>
		</tr>  
	 </thead>
 <?php
	$number = ($page - 1) * $line_cnt;
	while ( $rs = sql_fetch_array($result) ) 
	{
		$number = $number + 1;
  ?>
		 <tr valign='top' width='100%'>
		 <td><font color='cyan'><?=$number?></font></td>
 <?php
		$sys_pg=$rs['sys_pg'];

		//if( strpos( $rs['sys_link'], "contents_view_menu" ) !== false || $rs['tit_gubun'] == 'M' ) {
		if( $rs['tit_gubun'] == 'M' ) {
			$jong='B';				// Tree Doc  D -> N
			$u_ = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $rs['sys_pg'] . '&num=' . $rs['sys_pg']. '&sys_jong=note' . '&sys_subtitS=' . $rs['sys_subtit'] .'&open_mode=off&mid='.$rs['sys_userid'].'&job_addr='.$rs['sys_link'];
			//$u_       = urlencode($u_);
			$tree_color = '<font color=yellow>';
			$bb='yellow';
			$run_mode = 'cratree_book_remake'; 
		} else if( $rs['tit_gubun'] =='B' ){ // sys_menu_bom 에서 note 로 생성한것.
			$u_ = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $rs['sys_pg'] . '&num=' . $rs['sys_pg']. '&sys_jong=noteB' . '&sys_subtitS=' . $rs['sys_subtit'] .'&open_mode=off&mid='.$rs['sys_userid'].'&job_addr='.$rs['sys_link'];
			$tree_color = '<font color=white>';
			$bb='white';
			$run_mode = 'cratree_book_remake'; 
		} else if( $rs['tit_gubun'] =='A' || $rs['tit_gubun'] =='G' ){
			$u_ = KAPP_URL_T_ . "/menu/index_bbs.php?infor=" . $rs['book_num']. '&sys_jong=board' ;
			//$u_       = urlencode($u_);
			$tree_color = '<font color=green>';
			$jong='A';				// Tree Board
			$run_mode = 'cratree_bbs_remake';
			$bb='green';
		} else if( strpos( $rs['sys_link'], "index_bbs" ) !== false ) {
			$u_ = KAPP_URL_T_ . "/menu/index_bbs.php?infor=" . $rs['book_num']. '&sys_jong=board' ;
			$tree_color = '<font color=green>';
			$jong='A';				// Tree Board
			$run_mode = 'cratree_bbs_remake';
			$bb='green';
			//$run = './' . $rs['sys_userid'] . '/' . $sys_pg . '_r1.htm';	//../contents/webeditor/contents_view.php?num=$rs['seqno']
			
		/*} else if ( $rs['tit_gubun'] =='G' ) {
			$book_ = '<font color=green>T-Board';
			$tree_color = '<font color=green>';
			$jong='G';				// Tree Board
			$u_ = $rs['sys_link'];
					$run_mode = 'cratree_bbs_remake';
					$bb='green';
					//$run = './' . $rs['sys_userid'] . '/' . $sys_pg . '_r1.htm';	//../contents/webeditor/contents_view.php?num=$rs['seqno']
					*/
		} else if ( $rs['tit_gubun'] =='T' ) {
			$tree_color = '<font color=grace>';
			$jong= 'T';
			$u_ = $rs['sys_link'];
			$bb='grace';
			$run_mode = 'cratree_remake'; //$run = './' . $rs['sys_userid'] . '/' . $sys_pg . '_r1.htm';	//../contents/webeditor/contents_view.php?num=$rs['seqno']
		} else {	  
			$jong= 'X';
			$tree_color = '<font color=grace>';
			$u_ = $rs['sys_link'];
		}	  
		//$treeT = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $rs['sys_pg'] . '&num=' . $rs['sys_pg']. '&sys_subtitS=' . $rs['sys_subtit'] .'&open_mode=off&mid='.$rs['sys_userid'].'&job_addr='.$rs['sys_link'];
		//$treeT       = urlencode($treeT);
		$treeT       = $rs['sys_link'];
		$rsuser_id   = $rs['sys_userid'];
		$rsuser_name = $rs['sys_subtit'];
		$rsjob_name  = $rs['sys_pg'];
		$rsnum       = $rs['sys_pg'];
		$rsaboard_no =$rs['book_num'];
		$rsjong      =$rs['tit_gubun']; //$jong;
		$rsseqno     =$rs['seqno'];
		if( $rs['tit_gubun'] == 'M' || $rs['tit_gubun'] == 'B' ) {
?>
			<td><a href="<?=$u_?>" target="_blank" title="u_: <?=$u_?>"><?=$tree_color?><?=$rs['sys_subtit'] ?></font></a></td>
<?php
		} else if( $rs['tit_gubun'] == 'T' ) {
?>
			<td><a href="javascript:call_pg_select( '<?=$treeT?>', '<?=$rsuser_id?>', '<?=$rsjob_name?>', '<?=$rsuser_name?>','<?=$rsjong?>','<?=$rsnum?>','<?=$rsaboard_no?>', '<?=$rsseqno?>' )" style="border-style:;background-color:black;color:yellow;height:20;"><?=$rs['sys_subtit'] ?>
			<img src="<?=KAPP_URL_T_?>/icon/default.gif"></a></td>
<?php
		} else {
?>
			<td><a href="<?=$u_?>" target="_blank" title="else u_: <?=$u_?>"><?=$tree_color?><?=$rs['sys_subtit'] ?></font></a></td>
<?php   } ?>

			<td><a href="<?=$u_?>" target="_blank"><?=$tree_color?><?=$rs['sys_link'] ?></font></a></td>
			<td title='T:Tree, M,B:Note, G:Board'><font color=<?=$bb?>><?=$rs['tit_gubun']?></font></td>
			<td title='<?=$rs['up_day']?>' style='height:18px;background-color:black;color:cyan'><?=$rs['up_day']?>
<?php
		if($H_ID != "" and $H_LEV > 1 ) {
			$rs_book_num = $rs['book_num'];
			$rs_sys_pg = $rs['sys_pg'];
			$rs_sys_subtit = $rs['sys_subtit'];
?>			
				<!-- <input type='button' value='Del' onclick="delete_func('<?=$rs_sys_subtit?>','<?=$rs_sys_pg?>', 'sys_bom', '<?=$rs_book_num?>')" style='height:18px;background-color:red;color:yellow'> -->
<?php	} ?>			
			</td>
		</tr>
 
 <?php
    }//loop while end
?>
 </tbody>
 </table>

<?php
} else { // $row
	?>  
	Record no found! 
	<?php
} 

	paging("treelist2_my.php?id=$H_ID",$total_count,$page,$line_cnt); 

function paging($link, $total, $page, $line_cnt){
	$page_num = 10;
	if( !$total ) { return; }
	$total_page	= ceil($total/$line_cnt);
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page  = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;

	echo "<div class=paging>";
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>[First]</a><span>&nbsp;</span>");
	} else {
		echo("<span>[Start]&nbsp;</span>");	//echo("<img src=./include/img/btn/b_first_silver.gif border=0 height=30 title='First'>");
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;	//echo("<a href='javascript:page_move($back_page)' ><img src=./include/img/btn/btn_prev.png width=30 title='previous'></a>");
		echo("<a href='javascript:page_move($back_page)' >[Prev]</a><span>&nbsp;</span>");
	} else {
		//echo("<img src=./include/img/btn/btn_prev.png width=30 title='Previous'>");
		//echo("<span>[Prev].</span>");
	}
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("<a href='javascript:void(0)' class=on>$i</a><span>&nbsp;</span>"); }
		else         { echo("<a href='javascript:page_move($i)'>[$i]</a><span>&nbsp;</span>"); }
	}
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'>[Next]</a><span>&nbsp;</span>");
	}else { 
		//echo("<img src=./include/img/btn/btn_next.png width=30 title='Btn Next Page'>");
		//echo("<span>[Next].</span>");
	}
	if( $last_page < $total_page){
		echo("<a href='javascript:page_move($total_page)'>[Last]</a>");
	}else{
		echo("<span>[End]</span>");
	}
	echo "</div>";
}
?>
</body>
</html>
