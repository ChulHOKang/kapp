<?php
	include_once('../tkher_start_necessary.php');

	include "./paging.php";	  // 
	include "./string.php";   // function Shorten_String($String, $MaxLen, $ShortenStr)
	include "./infor.php";  
	include "./memo_cnt.php"; // function memo_count($board,$no)
/*
listD.php :
   call : insertD.php, detailD.php, board_list_admin.php
		: index.php?infor=<?=$rs['no']
		:/contents/memo_password.php?infor=159&mode=memo_deleteTT&board_name=aboard_tkherdao159&memo_no=3779&list_no=51&page=1&call_pg=detailD.php

	- Standard board skin -> movie:2:Standard , 1:General, 3:Memo, 4:Image
	- board_data_list.php : General board skin -> movie:1:General, 3:Memo, 4:Image
	- listD.php : Standard board skin -> movie:2:Standard
	- board_list_memo.php : Memo board skin -> movie:3:Memo
	- list1.php : Image board skin -> movie:4:Image
	- /contents/index.php and infor.php, listD.php 에 $_SESSION['infor'] add : 21-07-05
*/
	$H_ID   = get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( $H_ID ){
		$H_NICK	= $member['mb_nick'];
		$H_NAME = $member['mb_name'];
		$H_LEV	= $member['mb_level'];
	} else {
		$H_NICK	= '';
		$H_NAME = '';
		$H_LEV	= 0;
	}

	//$infor				= $_REQUEST[infor]; //include "./infor.php";
	if( isset($_REQUEST['mode'])) $mode = $_REQUEST['mode'];
	else if( isset($_POST['mode'])) $mode = $_POST['mode'];
	else $mode = '';

	if( isset($_REQUEST['search_text'])) $search_text = $_REQUEST['search_text'];
	else $search_text = '';

	if( isset($_REQUEST['page'])) $page = $_REQUEST['page'];
	else if( isset($_POST['page'])) $page = $_POST['page'];
	else $page = 1;
	
	if( isset($_REQUEST['target_'])) $target_ = $_REQUEST['target_'];
	else if( isset($_POST['target_'])) $target_ = $_POST['target_'];
	else $target_='url_link_bbstree_solpa_user_r';

	if( isset($_REQUEST['menu_mode'])) $menu_mode =$_REQUEST['menu_mode'];
	else $menu_mode = '';
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Board App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
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
	function Change_line_cnt( $line ){ //this.options[selectedIndex].value
		document.view_form.page.value = 1;
		document.view_form.line_cnt.value = $line;
		document.view_form.action='listD.php';
		document.view_form.submit();
	}
</script>
 <link rel="stylesheet" href="../include/css/Oboard.css" type="text/css" />
 <link rel="stylesheet" href="../include/css/common.css" type="text/css" />
 <!-- <link rel='stylesheet' href='/t/include/css/kancss.css' type='text/css'> --><!-- 중요! -->
</head>
<body>
		<?php
		$cur='A';
		if( $menu_mode != 'off') include_once "../menu_run.php";
		?>
<!-- <div class="wrapper">
	<div class="container">  -->
<?php
	$tit			= $mf_infor[1];
	$bbs_lev		= $mf_infor[47];	// grant_write

	if( isset($_REQUEST['line_cnt']) ) $line_cnt = $_REQUEST['line_cnt'];
	else if( isset($mf_infor[16]) ) $line_cnt = $mf_infor[16]; // $line_cnt; //  page line cnt
	else $line_cnt = 15;
	$page_cnt	= 10;					// $my_rs[page_num];		#[1] [2] [3] 갯수
?>
		<div id="write_page" class="mainProject">
			<div class="listTabs01">
				<a href="./listD.php?infor=<?=$infor?>&menu_mode=<?=$menu_mode?>" class="on" title="infor:<?=$infor?>, table:aboard_<?=$mf_infor[2]?>"><?=$tit?></a>
			</div>
<?php
		$tt			= time();
		$today		= $tt - 60*60*24*7;  // 최근게시물 : 7일전  // $reg_date	= date("Y-m-d H:i:s");  //
		$SQL			= "SELECT * from aboard_" . $mf_infor[2] . " where step=0 and re=0 order by target desc ";
		$result		= sql_query( $SQL );
		$total_count= sql_num_rows($result);	// new data select
		$SQL			= "SELECT * from aboard_" . $mf_infor[2] . " where in_date>$today and step=0 and re=0 order by target desc ";
		$result		= sql_query( $SQL );
		$total_new = sql_num_rows($result);	// new data select
?>
			<div class="boardView">
				<div class="boardNorBox">

					<form name='c_sel' action='listD.php#customer' method=post enctype="multipart/form-data" >
						<input type="hidden" name='page'	value='<?=$page?>' />
						<input type="hidden" name='board'	value='<?=$board?>' />

					<div class="fl">
						<tr>
							<td align=left>
								<script type="text/javascript" src="../include/js/dropdowncontent.js">
									/***********************************************
									* Drop Down/ Overlapping Content- (c) Dynamic Drive (www.dynamicdrive.com)
									* Please keep this notice intact.
									* Visit http://www.dynamicdrive.com/ for full source code
									***********************************************/
								</script>
								<p align="left" style="margin-top: 0px">
								<a href="#" id="contentlink" rel="subcontent2">
								<font color=#000ccc size=4> ▤ <font color=green size=2><b>Board List[▼]</b></font>
								</a><?php if($H_ID) echo "id:$H_ID, user_lev:$H_LEV"; ?>
								</p>

								<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">

									<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php

			$ttt = "---";
			if( $H_ID and $H_LEV > 1 ) {
				$sql = "SELECT * from {$tkher['aboard_infor_table']} where make_id='$H_ID' order by in_date desc";
				if( ($result = sql_query( $sql ) )==false ){
					printf("1 Invalid query: %s\n", $sql);
					m_(" 2 Select Error ");
				}
				$ttt = "Member[". $H_ID . "]:";
			} else {	// 비회원 no login guest에게 보여질 게시판 목록.
				$sql = "SELECT * from {$tkher['aboard_infor_table']} order by in_date desc limit 0,10";
				if( ($result = sql_query( $sql ) )==false ){
					printf("2 Invalid query: %s\n", $sql);
					m_("3 Select Error ");
				}
				$ttt = "Login-Please:";
			}
?>
<?php if( $H_ID && $H_LEV > 7) { ?>
					<tr>
					<td width='130' height='24' background='./images/admin_submenu.gif'>&nbsp;<img src='./images/left_icon.gif'>
					<a href="./board_list_admin.php" target='url_link_bbstree_solpa_user_r'>&nbsp;<font color='blue'>:management:<?=$ttt?></a>
					</td>
					</tr>
<?php }

			$j=0;
			if( $result ){
				while( $rs = sql_fetch_array( $result )  ) {
?>
					<tr>
					<td width='130' height='24' background='./images/admin_submenu.gif'>&nbsp;<img src='./images/left_icon.gif'>
					<a href="index_bbs.php?infor=<?=$rs['no']?>&menu_mode=<?=$menu_mode?>" target='url_link_bbstree_solpa_user_r'><?=$rs['name']?></a>
					</td>
					</tr>
<?php
				}
			}
?>

									</TABLE>
									<div align="right"><a href="javascript:dropdowncontent.hidediv('subcontent2')">Hide </a></div>
								</DIV><!-- subcontent2 -->

								<script type="text/javascript">
									dropdowncontent.init("searchlink", "left-bottom", 800, "mouseover")
									dropdowncontent.init("contentlink", "right-bottom", 800, "click")
								</script>
							</td>
						</tr>
					</div><!-- fi -->

					<div><!--  class="fl" fr -->
						<span>Total: <strong><?=$total_count?></strong> , Latest: <strong><?=$total_new?></strong>
							&nbsp;, line : <select id='line_cntS' name='line_cntS' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
								<option value='10'  <?php if($line_cnt=='10' )  echo " selected " ?> >10</option>
								<option value='30'  <?php if($line_cnt=='30' )  echo " selected " ?> >30</option>
								<option value='50'  <?php if($line_cnt=='50')   echo " selected" ?>  >50</option>
								<option value='100' <?php if($line_cnt=='100')  echo " selected" ?>  >100</option>
							</select>
						</span>
					</div>


					</form>
				</div><!-- boardNorBox -->
<?php

		$SQL1		= "SELECT * from aboard_" . $mf_infor[2];
		$SQL_w		= " where step=0 and re=0 ";
		$where_		= " and subject like '%$search_text%' "; // or context like '%$search_text%' 
		$orderby		= " order by target desc , step ";
		if( $mode=='SR' )	$SQL1 = $SQL1 . $SQL_w . $where_ . $orderby;
		else				$SQL1 = $SQL1 . $SQL_w . $orderby;
		if( ($result = sql_query( $SQL1 ) )==false ) {
			//printf("Invalid query: %s\n", $SQL1);	m_(" no found data Select Error ");
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
?>
				<form name='view_form' action='detailD.php' method=post enctype="multipart/form-data" >
					<input type="hidden" name='mode'			value='<?=$mode?>' />
					<input type="hidden" name='page'			value='<?=$page?>' />
					<input type="hidden" name='board'			value='<?=$infor?>' />
					<input type="hidden" name='board_name'	value='<?=$tit?>' />
					<input type="hidden" name='list_no'			value='' />
					<input type="hidden" name='old_no'			value='' />
					<input type="hidden" name='bbs_lev'		value='<?=$bbs_lev?>' />
					<input type="hidden" name='target_'		value='<?=$target_?>' />
					<input type="hidden" name='infor'			value='<?=$infor?>' />
					<input type="hidden" name='security'		value='' />
					<input type="hidden" name='search_text'		value='<?=$search_text?>' />
					<input type="hidden" name='line_cnt'		value='<?=$line_cnt?>' />
					<input type="hidden" name='menu_mode'	value='<?=$menu_mode?>' />

	<table class='listTableT' width='99%'>
		<thead>
					<tr>
						<th style='width:5%'>No</th>
						<th style='width:5%'><img src='../icon/subject.gif' title='Attached file'></th>
						<th style='width:50%'>Subject</th>
						<th style='width:15%'>Author</th>
						<th style='width:15%'>Date</th>
						<th style='width:10%'>View</th>
					</tr>
		</thead>
		<tbody width='100%'>

<?php
		$SQL			= "SELECT * from aboard_" . $mf_infor[2];
		$SQL_w			= " where step=0 and re=0 ";					// reply no print : 댓글을 제외한다. List에서는 제외 detail에만 Print.
		$SQL_orderby	= " order by target desc, step limit " . $start. ", " . $last;
//		if( $mode=='SR' )	$SQL = $SQL . $SQL_w . " and subject like '%$search_text%' or context like '%$search_text%' ";
		if( $mode=='SR' )	$SQL = $SQL . $SQL_w . " and subject like '%$search_text%' ";
		else $SQL = $SQL . $SQL_w;
		$SQL = $SQL . $SQL_orderby;
		if( ($result = sql_query( $SQL ) )==false ) {
			printf("Record 0 \n"); //printf("Record 0 : query: %s\n", $SQL);
		} else {
			$no_A=0;
			$today=0;
			while( $row = sql_fetch_array($result)  ) {
				$no_A++;
				$dt  = date("Y-m-d H:i", $row['in_date']);
				$now = time();
				$today = $now - $row['in_date'];		//m_("day :".$today); // 60 x 24 x 60 = 1200 x 24 = 28800 x 7 = 201600 = 7일.
				$new="";
				if( $today > 201600){  // //if($today > 86400){  //60*60*24*7;  // 최근게시물 : 7일전
					$ck = 'big';
				} else {
					//$new="<img src='".$mf_infor[38]."' border='0'>"; // 38:./icon/new.gif
					$new="<img src='../icon/new.gif' border='0'>"; // 38:./icon/new.gif
					$ck = 'low';
				}
				$infor38 = $mf_infor[38];
?>
				<tr>
					<td class="cell03" title='today:<?=$today?>:<?=$infor38?>:<?=$ck?>'><?=$row['no']?></td>
					<td class="cell03">
<?php
						//m_("5 : " . $mf_infor[5]);
						$dep=""; $memo_cnt=""; $file="";
						$memo_ = $mf_infor[5];
						for( $i=0; $i<$row['re']; $i++){
							$dep = $dep . "&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						if($dep){ $dep = $dep. "<img src='".$mf_infor[39]."' border='0'>"; }
						if( $mf_infor[5] ){
							$memo_cnt= memo_count( $mf_infor[2], $row['no']);

						}
						if( $row['file_name'] ){
							echo "<img src='../icon/subject.gif' title='Attached file'>";
						}
						if( $H_ID == $row['id']) $security_my = '1';	//본인의 글일때
						else $security_my = '';
						$msg_ = iconv_substr( $row['context'], 0, 80, 'utf-8') . "...";
						$t_   = $row['target'];
						$SQLB = " SELECT * from aboard_" . $mf_infor[2]. " where target='".$t_."' ";
						$ret  = sql_query( $SQLB );
						$step_= sql_num_rows( $ret);
						if( $step_==1 ) $step_=0;
						else if( $step_>1) $step_=$step_-1;
?>
					</td>
<?php
						if($dep){
							$msg_ = iconv_substr($row['subject'], 0, 50, 'utf-8') . "..."  . "[" . $step_ . "] - ";
							$con = strip_tags($row['context']);
							$msg_t = iconv_substr($con, 0, 200, 'utf-8') . "...";
						} else {
							$msg_ = iconv_substr($row['subject'], 0, 80, 'utf-8') . "..."  . "[" . $step_ . "] - ";
							$con = strip_tags($row['context']);
							$msg_t = iconv_substr($con, 0, 200, 'utf-8') . "...";
						}
?>
					<td class="cell03" title='<?=$msg_t?>' style="text-align:left;">
<?php
				$grant_view = $mf_array['grant_view']; // grant_view, security $mf_array, $row
				$rno = $row['no'];
				if($dep){ echo $dep; }
?>
					<a href="javascript:board_view('<?=$infor?>','<?=$grant_view?>','<?=$rno?>', '<?=$page?>', '<?=$security_my?>', '<?=$H_ID?>', '<?=$menu_mode?>' );" >

					<span><?=$msg_?><?=$memo_cnt?><?php echo $new; ?></span></a>
					</td>
					<td class="cell03"><?=$row['name']?></td>
					<td class="cell03" style='width:15%;'><?=$dt?></td>
					<td class="cell03"><?=$row['cnt']?></td>
				</tr>
<?php
			}	// while
		}
?>
					</tbody>
				</table>
				</form>
				<div class="boardNorBox mt10">
					<div class="fl">
						<form name='c_sel2' action='listD.php' method='post' enctype="multipart/form-data" >
							<input type="hidden" name='page'	value='<?=$page?>' />
							<input type="hidden" name='board'	value='<?=$infor?>' />
							<input type="hidden" name='target_'	value='<?=$target_?>' />
							<input type="hidden" name='mode'	value='SR' />
							<input type="hidden" name='infor'	value='<?=$infor?>' />
							<input type="hidden" name='menu_mode'	value='<?=$menu_mode?>' />
							<table>
								<tr>
								<td align='left'><input type="text" name='search_text' /></td>
								<!-- <td align=left><div class="sr"><a href="javascript:void(0)" class="btn_bo02">Search</a></div></td> -->
								<td align='left'><div class="sr"><a href="javascript:search_data('<?=$menu_mode?>')" class="btn_bo02">Search</a></div></td>
								<td align='right'><div class="fr">
								<a href="javascript:board_write('<?=$infor?>','<?=$H_LEV?>','<?=$page?>');" class="btn_bo02">Write</a></div></td>
								</tr>
							</table>
						</form>
					</div>

<?php
	paging("listD.php?infor=$infor&search_text=$search_text&menu_mode=$menu_mode",$total_count,$page,$line_cnt,$page_cnt);
?>
			</div><!-- boardNorBox mt10 -->
		</div><!-- boardNorBox -->
<!-- 	</div> --><!-- end : container -->
<!-- </div> --><!-- end : wrapper-->

<script type="text/javascript" >

	function board_view(infor, grant_view, no, page, security_my, id, menu_mode){
		//alert("id:" +id + ", len: " + id.length + ", grant_view:" + grant_view);
		//if( id.length > 2 ){ alert("------ id:" +id); }
		if( security_my == '1' ) { // my => security_my = 1
				document.view_form.list_no.value = no;
				document.view_form.security.value =grant_view;
				document.view_form.action ='detailD.php?infor='+infor+'&list_no='+no+'&menu_mode='+menu_mode;
				document.view_form.submit();
		} else if( security_my == '' ) { //  1: guest
			if( grant_view > 2 ){ // 2: member
				alert("my only! view"); return false;
			} else {
				document.view_form.list_no.value = no;
				document.view_form.security.value =grant_view;
				document.view_form.action ='detailD.php?infor='+infor+'&list_no='+no+'&menu_mode='+menu_mode;
				document.view_form.submit();
			}
		}
		/*else if( grant_view < 2 ) { //  1: guest
			document.view_form.list_no.value = no;
			document.view_form.security.value =grant_view;
			document.view_form.action ='detailD.php?infor='+infor+'&list_no='+no;
			document.view_form.submit();
		} else if( grant_view == '2' ) { // member
			if( id.length > 2 ) {
				document.view_form.list_no.value = no;
				document.view_form.security.value =grant_view;
				document.view_form.action ='detailD.php?infor='+infor+'&list_no='+no;
				document.view_form.submit();
			} else {
				alert("member only! view"); return false;
			}
		} else {
			document.view_form.security.value=security;
			infor = document.view_form.infor.value;
			old_no= document.view_form.list_no.value;
			document.view_form.old_no.value=old_no;
			url = "password_.php?infor="+infor + "&list_no=" +no+ "&page=" +page+ "&call_pg=detailD.php";
			window.open(url,"newP","width=600,height=300,scrollbars=no");
		}*/
	}

	function search_data(menu_mode){
		document.c_sel2.mode.value='SR';
		document.c_sel2.action='listD.php?menu_mode=' + menu_mode;
		document.c_sel2.submit();
	}
	function board_write( infor, user_lev, page ){
		if( user_lev < 2 ) {
			alert(' You Login check lev:' +user_lev );
			return false;
		}
		lev = document.view_form.bbs_lev.value;
		if( lev != 0 && lev > user_lev ) {
			alert(' You do not have permission to write. lev:'+lev+','+user_lev );
			return false;
		}
		document.view_form.mode.value='bbs_writeTT';
		document.view_form.board.value=infor;
		document.view_form.infor.value=infor;
		document.view_form.action='insertD.php';
		document.view_form.submit();
	}
	function page_move($page){
		document.view_form.page.value = $page;
		document.view_form.action='listD.php';
		document.view_form.submit();
	}

 </script>
</body>
</html>
