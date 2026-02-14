<?php
	include_once('../tkher_start_necessary.php');

	include "./infor.php";  
	include "./paging.php";	  // 
	include "./string.php";   // function Shorten_String($String, $MaxLen, $ShortenStr)
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
	$grant_read	= $mf_infor[46];
	$grant_write= $mf_infor[47];

	$ip = $_SERVER['REMOTE_ADDR'];
	$H_ID = get_session("ss_mb_id");
	if( $H_ID && $H_ID !=='') {
		$H_LEV	= $member['mb_level'];  
		$H_NAME	= $member['mb_name'];  
		$H_NICK	= $member['mb_nick'];  
		$H_EMAIL = get_session("ss_mb_email"); 
	} else {
		$H_NICK	= 'Guest';
		$H_NAME = 'Guest';
		$H_LEV	= 1;
		$H_ID	= 'Guest';  
		$H_EMAIL= ''; 
	}

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
	else $target_='_top';
	if( isset($_REQUEST['menu_mode'])) $menu_mode =$_REQUEST['menu_mode'];
	else $menu_mode = '';
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
<script src="//code.jquery.com/jquery.min.js"></script>
<script>
	$(function () {
	  $('table.listTable').each(function() {
		if( $(this).css('border-collapse') == 'collapse') {
		  $(this).css('border-collapse','separate').css('border-spacing',0);
		}
		$(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
	  });

	  $(window).scroll(function() {
		var scrollTop = $(window).scrollTop(),
		  scrollLeft = $(window).scrollLeft();
		$('table.listTable').each(function(i) {
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
	function Change_line_cnt( $line ){
		document.view_form.page.value = 1;
		document.view_form.line_cnt.value = $line;
		document.view_form.action='listD.php';
		document.view_form.submit();
	}
</script>

</head>
<body>
<?php
		$cur='A';
		if( $menu_mode != 'off') include_once "../menu_run.php";
		else { 
?>
			<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<?php  } ?>
<?php
	$tit			= $mf_infor[1];
	$bbs_lev		= $mf_infor[47];	// 47:grant_write

	if( isset($_REQUEST['line_cnt']) ) $line_cnt = $_REQUEST['line_cnt'];
	else if( isset($_POST['line_cnt']) ) $line_cnt = $_POST['line_cnt'];
	else if( isset($mf_infor[16]) ) $line_cnt = $mf_infor[16];
	else $line_cnt = 15;
	$page_cnt	= 10;
?>
		
		<div id="write_page" class="mainProject">
			<div class="listTabs01">
				<a href="./listD.php?infor=<?=$infor?>&menu_mode=<?=$menu_mode?>" class="on" title="infor:<?=$infor?>, table:aboard_<?=$mf_infor[2]?>"><?=$tit?></a>
			</div>
<?php
		$today		= time() - 60*60*24*7;
		$SQL			= "SELECT * from aboard_" . $mf_infor[2] . " order by target desc ";
		$result		= sql_query( $SQL );
		$total_count= sql_num_rows($result);
		$SQL			= "SELECT * from aboard_" . $mf_infor[2] . " where in_date>$today order by target desc ";
		$result		= sql_query( $SQL );
		$total_new = sql_num_rows($result);
?>
			<div class="boardView">
				<div class="boardNorBox">

					<form name='c_sel' action='listD.php#customer' method=post enctype="multipart/form-data" >
						<input type="hidden" name='page'	value='<?=$page?>' />
						<input type="hidden" name='board'	value='<?=$board?>' />

					<div class="fl">
						<tr>
							<td align=left>

			<script type="text/javascript" src="../include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="#" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Board List [▼]</b></font>
				</a><?php if($H_ID) echo "id:$H_ID, user_lev:$H_LEV"; ?>
			</p>


						<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 200px; height: 100%px; padding: 4px;z-index:200">

							<TABLE border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='160'>
<?php

						if( $H_ID and $H_LEV > 1 ) {
							$sql = "SELECT * from {$tkher['aboard_infor_table']} where make_id='$H_ID' order by in_date desc";
							if( ($result = sql_query( $sql ) )==false ){
								m_("listD 2 Select Error ");
							}
						} else {
							$sql = "SELECT * from {$tkher['aboard_infor_table']} order by in_date desc limit 0,10";
							if( ($result = sql_query( $sql ) )==false ){
								m_("listD 3 Select Error ");
							}
						}
?>
<?php if( $H_ID && $H_LEV > 7) { ?>
					<tr>
					<td width='130' height='24' >
					<a href="./board_list_admin.php" target='_blank' title='board write level:<?=$bbs_lev?>'><img src='../icon/admin.gif' width='27' height='27' title='super manager mode'>User:<?=$mf_array['make_id']?>:<?=$mf_array['grant_write']?></a>
					</td>
					</tr>
<?php }

			$j=0;
			if( $result ){
				while( $rs = sql_fetch_array( $result )  ) {
?>
					<tr>
					<td width='130' height='24' background='./images/admin_submenu.gif'>&nbsp;<img src='./images/left_icon.gif'>
					<a href="index_bbs.php?infor=<?=$rs['no']?>&menu_mode=<?=$menu_mode?>" target='_top'><?=$rs['name']?></a>
					</td>
					</tr>
<?php
				}
			}
?>
							</TABLE>
									<div align="right"><a href="javascript:dropdowncontent.hidediv('subcontent2')">Hide </a></div>
						</DIV>

								<script type="text/javascript">
									dropdowncontent.init("searchlink", "left-bottom", 200, "mouseover")
									dropdowncontent.init("contentlink", "right-bottom", 200, "click")
								</script>
							</td>
						</tr>
					</div>
					<div>
						<span>Total: <strong><?=$total_count?></strong> , Latest: <strong><?=$total_new?></strong>
							&nbsp;, line : <select id='line_cntS' name='line_cntS' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
							<?php
if( $line_cnt == '10') echo "<option value='10' selected >$line_cnt</option>";
else if( $line_cnt == '30') echo "<option value='30' selected >$line_cnt</option>";
else if( $line_cnt == '50') echo "<option value='50' selected >$line_cnt</option>";
else if( $line_cnt == '100') echo "<option value='100' selected >$line_cnt</option>";
else echo "<option value='$line_cnt' selected >$line_cnt</option>";

							?>
								<option value='10'  <?php if($line_cnt=='10' )  echo " selected " ?> >10</option>
								<option value='30'  <?php if($line_cnt=='30' )  echo " selected " ?> >30</option>
								<option value='50'  <?php if($line_cnt=='50')   echo " selected " ?> >50</option>
								<option value='100' <?php if($line_cnt=='100')  echo " selected " ?> >100</option>
							</select>
						</span>
					</div>


					</form>
				</div><!-- boardNorBox -->
<?php

		$SQL1		= "SELECT * from aboard_" . $mf_infor[2];
		$SQL_w		= ' ';
		$where_= " where subject like '%$search_text%' ";
		$orderby		= " order by target desc , step ";
		if( $mode=='SR' )	$SQL1 = $SQL1 . $SQL_w . $where_ . $orderby;
		else				$SQL1 = $SQL1 . $SQL_w . $orderby;
		if( ($result = sql_query( $SQL1 ) )==false ) {
			$total_count = 0;
		} else {
			$total_count = sql_num_rows($result);
			if( $total_count) $total_page  = ceil($total_count / $line_cnt);
			else $total_page  =1;

			if( $page < 1) {
				$page  = 1;	
				$start = 0;
			} else {
				$start = ($page - 1) * $line_cnt;
			}
			$last = $line_cnt;
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

	<table class='listTable' width='99%'><!-- listTableT -->
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
		$SQL_w			= ' '; //" where step=0 and re=0 ";
		$where_= " where subject like '%$search_text%' ";
		$SQL_orderby	= " order by target desc, step limit " . $start. ", " . $last;
		if( $mode=='SR' )	$SQL = $SQL . $SQL_w . $where;
		else $SQL = $SQL . $SQL_w;
		$SQL = $SQL . $SQL_orderby;
		if( ($result = sql_query( $SQL ) )==false ) {
			printf("Record 0 \n");
		} else {
			$no_A=0;
			$today=0;
			while( $row = sql_fetch_array($result)  ) {
				$no_A++;
				$dt  = date("Y-m-d H:i", $row['in_date']);
				$now = time();
				$today = $now - $row['in_date'];
				$new="";
				if( $today > 201600){
					$ck = 'big';
				} else {
					$new="<img src='../icon/new.gif' border='0'>"; 
					$ck = 'low';
				}
				$infor38 = $mf_infor[38];
?>
				<tr>
					<td class="cell01" title='today:<?=$today?>:<?=$infor38?>:<?=$ck?>'><?=$row['no']?></td>
					<td class="cell02">
<?php
						$dep=""; $memo_cnt=""; $file="";
						$memo_ = $mf_infor[5];
						for( $i=0; $i<$row['re']; $i++){
							$dep = $dep . "&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						if($dep){ $dep = $dep. "<img src='../icon/".$mf_infor[39]."' border='0'>"; }
						if( $mf_infor[5] ){
							$memo_cnt= memo_count( $mf_infor[2], $row['no']);

						}
						if( $row['file_name'] ){
							echo "<img src='../icon/subject.gif' title='Attached file'>";
						}
						if( $H_ID == $row['id']) $security_my = '1';
						else $security_my = '';
						$msg_ = iconv_substr( $row['context'], 0, 80, 'utf-8') . "...";

						$SQLB = " SELECT * from aboard_" . $mf_infor[2]. " where target='" .$row['target']. "' ";
						$ret  = sql_query( $SQLB );
						$step_= sql_num_rows( $ret);
						if( $step_==1 ) $step_=0;
						else if( $step_>1) $step_ = $step_ - 1;
?>
					</td>
<?php
						if( $dep ){
							$msg_ = iconv_substr($row['subject'], 0, 50, 'utf-8') . "..."  . "[" . $step_ . "] - ";
							$con = strip_tags($row['context']);
							$msg_t = iconv_substr($con, 0, 200, 'utf-8') . "...";
						} else {
							$msg_ = iconv_substr($row['subject'], 0, 80, 'utf-8') . "..."  . "[" . $step_ . "] - ";
							$con = strip_tags($row['context']);
							$msg_t = iconv_substr($con, 0, 200, 'utf-8') . "...";
						}
?>
					<td class="cell03" title='no:<?=$row['no']?>:<?=$msg_t?>' style="text-align:left;">
<?php
				$rno = $row['no'];
				if($dep){ echo $dep; }
?>
					<a href="javascript:board_view('<?=$infor?>','<?=$grant_read?>','<?=$rno?>', '<?=$page?>', '<?=$security_my?>', '<?=$H_ID?>', '<?=$menu_mode?>' );" >

					<span><?=$msg_?><?=$memo_cnt?><?php echo $new; ?></span></a>
					</td>
					<td class="cell04"><?=$row['name']?></td>
					<td class="cell05" style='width:15%;'><?=$dt?></td>
					<td class="cell06"><?=$row['cnt']?></td>
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
								<td align='left'><div class="sr"><a href="javascript:search_data('<?=$menu_mode?>')" class="btn_bo02">Search</a></div></td>
								<td align='right'><div class="fr">
								<a href="javascript:board_write('<?=$infor?>','<?=$H_LEV?>','<?=$page?>','<?=$grant_write?>');" class="btn_bo02">Write</a></div></td>
								</tr>
							</table>
						</form>
					</div>
<?php
					paging("listD.php?infor=$infor&search_text=$search_text&menu_mode=$menu_mode",$total_count,$page,$line_cnt,$page_cnt);
?>
				</div><!-- boardNorBox mt10 -->
			</div><!-- boardView -->
		</DIV><!-- mainProject -->

<script type="text/javascript" >

	function board_view(infor, grant_view, no, page, security_my, id, menu_mode){
		if( security_my == '1' ) {
				document.view_form.list_no.value = no;
				document.view_form.security.value =grant_view;
				document.view_form.action ='detailD.php?infor='+infor+'&list_no='+no+'&menu_mode='+menu_mode;
				document.view_form.submit();
		} else if( security_my == '' ) { 
			if( grant_view > 2 ){ 
				alert("my only! view"); return false;
			} else {
				document.view_form.list_no.value = no;
				document.view_form.security.value =grant_view;
				document.view_form.action ='detailD.php?infor='+infor+'&list_no='+no+'&menu_mode='+menu_mode;
				document.view_form.submit();
			}
		}
	}

	function search_data(menu_mode){
		document.c_sel2.mode.value='SR';
		document.c_sel2.action='listD.php?menu_mode=' + menu_mode;
		document.c_sel2.submit();
	}
	function board_write( infor, user_lev, page, grant_write ){
		if( user_lev < grant_write ) {
			alert('Please! you login lev:' +user_lev );
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
