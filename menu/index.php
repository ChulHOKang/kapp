<?php
	include_once('../tkher_start_necessary.php');
	/*
		index.php : Tree List
		- index_create.php - cratreebook_make_create_menu.php : tree menu Create
		DB: {$tkher['sys_menu_bom_table']}, webeditor, webeditor_comment,
		     job_link_table, aboard_info, aboard_memo, aboard_admin, menuskin
	*/
	$H_ID  = get_session("ss_mb_id");
	if( isset($H_ID) && $H_ID!='' ) {
		$H_LEV  = $member['mb_level'];
		$H_POINT= $member['mb_point'];
		$H_EMAIL= $member['mb_email'];
	} else {
		$H_LEV  = 0;
		$H_POINT= 0;
		$H_EMAIL= '';
	}
	$ip     = $_SERVER['REMOTE_ADDR'];
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

<style>  
.HeadTitle01AX{display:inline-block;margin:0 1px;height:40px;line-height:0px;padding:0 20px;font-size:22px;background:#d01c27;color:#fff;border-radius:5px;}  
.HeadTitle01AX a.on{background:#d01c27;color:#000;}  
</style>  

<script language="javascript">
	function big(x){
		x.style.color='#ffffff';
	}
	function small(x){
		x.style.color='#000000';
	}

	function new_create(Anum) {
		if( confirm('Are you sure you want to create? ') ) {
			location.href='index_create.php';
		}
	}
	function tree_func(mid, sys_pg, run_mode ){
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= "cratree_book_remake";
		document.sys_form.action='./treebom_remake_all_menu.php';
		document.sys_form.target  = "_blank";
		document.sys_form.submit();
	}
	function popup_func(mid, sys_pg, run_mode ){
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= run_mode;
		document.sys_form.action='./treebom_dropdown_menu_create.php';
		document.sys_form.submit();
	}
	function treeDN_func( mid, sys_pg, run_mode, point ){
		if( !document.sys_form.Hid.value ) {
			alert('Login please!'); return false;
		}
		if( point < 1000){
			alert("There are not enough points. point:" + point);
			return  false;
		}
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= 'tree_menu_createDN';
		document.sys_form.action='./treebom_tree_menu_createDN.php';
		document.sys_form.target  = "_blank";
		document.sys_form.submit();
	}
	function popupDN_func(mid, sys_pg, run_mode, point ){
		if( !document.sys_form.Hid.value ) {
			alert('Login please!'); return false;
		}
		if( point < 1000){
			alert("There are not enough points. point:" + point);
			return  false;
		}
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= 'dropdown_menu_createDN';
		document.sys_form.action='./treebom_dropdown_menu_createDN.php';
		document.sys_form.target  = "_blank";
		document.sys_form.submit();
	}
	function Change_line_cnt( $line){
		document.sys_form.page.value = 1;
		document.sys_form.action='index.php';
		document.sys_form.submit();
	}
	function page_func( $page){
		document.sys_form.page.value = $page;
		document.sys_form.target  = "_self";
		document.sys_form.action='index.php';
		document.sys_form.submit();
	}
	function title_wfunc(fld_code){       
		document.sys_form.page.value = 1;
		document.sys_form.fld_code.value= fld_code;
		document.sys_form.fld_code_asc.value= 'desc';
		document.sys_form.mode.value='title_wfunc';
		document.sys_form.action='index.php';
		document.sys_form.submit();                         
	} 
	function title_func(fld_code){
		document.sys_form.page.value = 1;
		document.sys_form.fld_code.value= fld_code;
		document.sys_form.fld_code_asc.value= 'asc';
		document.sys_form.mode.value='title_func';
		document.sys_form.action='index.php';
		document.sys_form.submit();
	} 
	function list_click_run_func( $sys_pg, $subtit, $open_mode, $mid, $sys_jong, $num, $job_addr ){
		document.sys_form.sys_pg.value  = $sys_pg;
		document.sys_form.subtit.value  = $subtit;
		document.sys_form.open_mode.value = $open_mode;
		document.sys_form.mid.value		= $mid;
		document.sys_form.sys_jong.value = $sys_jong;
		document.sys_form.num.value = $num;
		document.sys_form.job_addr.value = $job_addr;
		document.sys_form.start_click.value = 'on';

		document.sys_form.action='./tree_run.php';
		document.sys_form.target  = "_blank";
		document.sys_form.submit();
	}
</script>

<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<link rel='stylesheet' href='../include/css/kancss.css' type='text/css'>

<script>
$(function () {
	let timer;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			//alert(e.target.innerText + ' 순수하게 한 번만 클릭됨'); //Project 순수하게 한 번만 클릭됨
			switch(e.target.innerText){
				case 'User'    : title_func('sys_userid'); break;
				case 'Title'   : title_func('sys_subtit'); break;
				case 'type'    : title_func('tit_gubun'); break;
				case 'View'    : title_func('view_cnt'); break;
				case 'Date'    : title_func('up_day'); break;
				default        : title_func(''); break;
			}
		}, 250); // 약 300ms 대기 후 실행
	  
	});

	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer); // 마지막 클릭 타이머를 제거
		//alert('더블 클릭되었습니다!');
		switch(e.target.innerText){
				case 'User'    : title_wfunc('sys_userid'); break;
				case 'Title'   : title_wfunc('sys_subtit'); break;
				case 'type'    : title_wfunc('tit_gubun'); break;
				case 'View'    : title_wfunc('view_cnt'); break;
				case 'Date'    : title_wfunc('up_day'); break;
				default        : title_wfunc(''); break;
		}
	});

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

<script type="text/javascript">
var $grid;
$(function(){
	$(".visualSlide ").slick({
		dots: false, slidesToShow: 1,slidesToScroll: 1, autoplay:true ,autoplaySpeed:<?=$slide_time?>,pauseOnHover : false
	});
	if($(".grid").length){
		$grid = $('.grid').isotope({
			itemSelector: '.element-item',
			layoutMode: 'fitRows'
		});
	}
	$("body").on("click",".listTabs a",function(){
		var filterValue = $( this ).attr('data-filter');
	    $grid.isotope({ filter: filterValue });
		$(".listTabs a").removeClass("on");
		$(this).addClass("on");
	});
	$("body").on("click",".listTabs01 a",function(){
		$(".listTabs01 a").removeClass("on");
		$(this).addClass("on");
	});
	$(window).on("scroll", common.headerFixed);
	$("body").on("click",".btnService",function(){
		var ck = $(this).hasClass("on");
		if(ck){
			$(this).removeClass("on");
			$(".serviceLayer").hide();
		}else{
			$(this).addClass("on");
			$(".serviceLayer").show();
		}
	});
	$("body").on("click",".project_request .close",function(){
		$(".project_area").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad');
	});
	$("body").on("click",".lnbFooter a.lnbIcon03",function(){
		$(".project_area").stop().animate({"right":"-20px"}, 200, 'easeOutQuad');
		$(".loginBox").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad');
	});
	$("body").on("click",".lnbFooter a.lnbIcon01",function(){
		$(".loginBox").stop().animate({"right":"0"}, 200, 'easeOutQuad');
		$(".project_area").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad');
	});
});
function visualHeight(){
	var h = window.innerHeight;
	$(".visualSlide .item, #videoBg").css("height", h+"px");
}
common = {
	etcEvt:function(){
		$("body").on("click",".btnService",function(){
			var ck = $(this).hasClass("on");
			if(ck){
				$(this).removeClass("on");
				$(".serviceLayer").hide();
			}else{
				$(this).addClass("on");
				$(".serviceLayer").show();
			}
		});
	},
	headerFixed:function(){
		var h = window.innerHeight;
		var st = $(window).scrollTop();
		if (st < h){
			$(".header").removeClass("on");
		}else{
			$(".header").addClass("on");
		}
	},
}
</script>
<?php
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode='';
	if( isset($_REQUEST['mid']) ) $mid  = $_REQUEST['mid'];
	else $mid = $H_ID;
	if( isset($_POST['page']) && $_POST['page'] !='' ) $page  = $_POST['page'];
	else if( isset($_REQUEST['page'])  && $_REQUEST['page'] !='' ) $page  = $_REQUEST['page'];
	else $page =1;

	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	if( isset( $_POST['fld_code_asc']) ) $fld_code_asc= $_POST['fld_code_asc'];
	else $fld_code_asc = '';

	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 15;

	$page_num	= 10;
	$total  = 0;
	$limit = "";
	$no = 0;
	$sdata  = '';
	if( isset($_POST['sdata']) && $_POST['sdata'] !='' ) {
		$sdata  = $_POST['sdata'];
		$sdata = '%' . $sdata . '%';
	}

	if( $sdata !='' ) {
		$query = "SELECT * from {$tkher['sys_menu_bom_table']} ";
		$query = $query . "where sys_subtit like '".$sdata."' and sys_level='mroot' and sys_subtit != 'main' ";
	} else {
		$query = "SELECT * from {$tkher['sys_menu_bom_table']} ";
		$query = $query . "where sys_level='mroot' and sys_subtit != 'main' ";
	}
	$result = sql_query( $query);
	$total  = sql_num_rows( $result );
	
	$total_page = 0;
	$first = 1;
	$last = 1;
if( $total > 0 ) {
	$total_page = intval(($total-1) / $line_cnt)+1;
	if( $page > 1) $first = ($page-1)*$line_cnt;
	else $first = 0;
	$last = $line_cnt;
	if( $total < $last) $last = $total;
	$limit = " limit $first, $last ";
	if( $page == 1)
		$no = $total;
	else {
		$no = $total - ($page - 1) * $line_cnt;
	}
	if( $fld_code!='' ) {
		//if( $fld_code == 'view_cnt') $OrderBy = " order by $fld_code desc ";    
		//else if ( $fld_code == 'up_day') $OrderBy = " order by $fld_code desc ";    
		//else $OrderBy = " order by $fld_code asc ";    
		$OrderBy = " order by $fld_code $fld_code_asc ";
	} else $OrderBy	= "order by tit_gubun desc, up_day desc, sys_subtit ";
	$query = $query . $OrderBy;
	$query = $query . $limit;
	$result = sql_query( $query);
} else $total = 0;

//( $sys_pg, $subtit, $open_mode, $mid, $sys_jong, $num, $job_addr )
?>

<body bgcolor="#000000" text="#FFFFFF" topmargin="0" leftmargin="0" >
<center>
	<FORM method='post' name='sys_form' >
		<input type='hidden' name='Hid' value='<?=$H_ID?>' > 
		<input type='hidden' name='run_mode' value='' > 
		<input type='hidden' name='page' value='<?=$page?>' > 
		<input type='hidden' name='fld_code' value='<?=$fld_code?>' > 
		<input type='hidden' name='fld_code_asc' value='<?=$fld_code_asc?>' > 
		<input type='hidden' name='mode' value='<?=$mode?>' > 
		<input type='hidden' name='sys_pg'	 value='<?=$sys_pg?>' > 
		<input type='hidden' name='subtit'	 value='' > 
		<input type='hidden' name='open_mode' value='' > 
		<input type='hidden' name='mid' value='<?=$mid?>' > 
		<input type='hidden' name='sys_jong' value='' > 
		<input type='hidden' name='num' value='' > 
		<input type='hidden' name='job_addr' value='' > 
		<input type='hidden' name='start_click' value='' > 
<?php
	$runpage='./index.php';
	$cur='C';
	include "../menu_run.php";
	if( $mid) $madeid = $mid;
	else      $madeid ='All';
	echo "<p style='color:cyan;text-align:center;'>id:" . $H_ID .", total: " . $total . ", total-page: " . $total_page . "</p>";
?>
<p style='color:cyan;text-align:center;'>
View Line: 
	<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
		<option value='15'  <?php if( $line_cnt=='15')  echo " selected" ?> >15</option>
		<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
		<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
		<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
	</select>
</p>
	</form>
<table class='floating-thead' width="700">
<thead id='tit_et' width="100%">
<tr style='background-color:#499BDA;color:black;text-align:left;'>
<?php
	//echo " <th title='type Sort click' onclick=title_func('tit_gubun')>type</th> ";
	//echo " <th title='User Sort click' onclick=title_func('sys_userid')>User</th> ";
	//echo " <th title='Title Sort click' onclick=title_func('sys_subtit')>Title</th> ";
	//echo " <th title='View Sort click' onclick=title_func('view_cnt')>View</th> ";
	//echo " <th title='Date Sort click' onclick=title_func('up_day')>Date</th> ";
	echo " <th title='type Sort click or doubleclick' >type</th> ";
	echo " <th title='User Sort click or doubleclick' >User</th> ";
	echo " <th title='Title Sort click or doubleclick' >Title</th> ";
	echo " <th title='View Sort click or doubleclick' style='color:black;text-align:center;'>View</th> ";
	echo " <th title='Date Sort click or doubleclick' style='color:black;text-align:center;'>Date</th> ";
?>
	<th>Pop Run</th>
	<th title='Tree Menu Source Code Download.' style='color:black;'>Down-Load</th>
	<th title='Popup Menu Source Code Download.' style='color:black;'>Down-Load</th>
	<!-- <th title='View count Sort click' style='color:black;text-align:center;' onclick="title_func('view_cnt')">View</th>
	<th title='Date Sort click' style='color:black;text-align:center;' onclick="title_func('up_day')">Date</th> -->
</tr>
</thead>
<tbody>
<?php
$ln = $no;
if( $result ){
	while( $line = sql_fetch_array( $result )) {
		$num		= $line['book_num'];
		$mid	= $line['sys_userid'];
		$sys_pg = $line['sys_pg'];
		$up_day = $line['up_day'];
		$seqno_	= $line['seqno'];
		$tit_gubun_ = $line['tit_gubun'];
		if( $line['tit_gubun']=='G') { // board
			$sys_jong = 'board';
			$run_mode = 'cratree_bbs_remake';
			$bb='green';
			$iconX="<img src='../icon/ship.png' width='20' height='15' title='B tit_gubun: $tit_gubun_'>";
		} else if( $line['tit_gubun']=='B'  ) { // Book note
			$sys_jong = 'note';
			$bb='yellow';
			$run_mode = 'cratree_book_remake';
			$iconX="<img src='../icon/_board_.png' width='20' height='15' title='tit_gubun: $tit_gubun_ '>";
		} else if( $line['tit_gubun']=='T'  ) { // tree
			$sys_jong = 'note'; //$sys_jong = 'link';
			$bb='#99CCFF';
			$run_mode = 'cratree_remake';
			$iconX="<img src='../icon/pizza.png' width='20' height='15' title='tit_gubun: $tit_gubun_ '>";
		} else if( $line['tit_gubun']=='M'  ) { // Main tree
			$sys_jong = 'note';
			$bb='yellow';
			$run_mode = 'cratree_remake';
			$iconX="<img src='../icon/_tree_.png' width='20' height='15' title='M tit_gubun: $tit_gubun_ '>";
		} else {
			$sys_jong = 'note';
			$run_mode = 'cratree_remake';
			$iconX="<img src='../icon/pizzaX.png' width='20' height='15' title='extra : $tit_gubun_ '>";
		}
		$day = substr($line['up_day'], 0 , 10);
		$subtit = $line['sys_subtit'];
		$view = number_format($line['view_cnt']);
		$job_addr='contents_view_menuD.php?num=' . $num;
		$run = './tree_run.php?sys_pg=' . $sys_pg . '&sys_subtitS=' . $line['sys_subtit'] .'&open_mode=on&mid='.$mid. '&sys_jong=' . $sys_jong. '&num=' . $num.'&job_addr='.$job_addr.'&start_click=on';

		if( isset($H_ID) and $mid == $H_ID or $H_LEV > 7 ) {
			echo "
			<tr>
				<td align='center'>$ln $iconX</td>
				&nbsp;<td>".$line['sys_userid']."</td>&nbsp;
				<td>
				<a onclick=\"list_click_run_func('".$sys_pg."', '".$subtit."', 'on', '".$mid."', '".$sys_jong."', '".$num."', '".$job_addr."')\" target='_blank' style='color:$bb' title=' $tit_gubun_ - mid:".$mid.", view:".$line['view_cnt'].", sys_pg: ".$sys_pg."' >".$line['sys_subtit']."</a>
				
				</td>
				<td align='center'>$view</td>
				<td align='center'>$day</td>
				<td align='center'><a onclick=\"list_click_run_func('".$sys_pg."', '".$subtit."', 'on', '".$mid."', '".$sys_jong."', '".$num."', '".$job_addr."')\" target='_blank' style='color:blue' title='gubun:".$line['tit_gubun']."'>Popup</a></td>
				<td><input type='button' value='Tree DN' onclick=\"treeDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'></td>
				<td><input type='button' value='Popup DN' onclick=\"popupDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'></td>
			</tr>";
		} else {
			echo "
			<tr>
				<td align='center'>$ln $iconX</td>
				&nbsp;<td>".$line['sys_userid']."</td>&nbsp;
				<td>
				<a onclick=\"list_click_run_func('".$sys_pg."', '".$subtit."', 'on', '".$mid."', '".$sys_jong."', '".$num."', '".$job_addr."')\" target='_blank' style='color:$bb' title='$tit_gubun_ - mid:".$mid.", view:".$line['view_cnt'].", sys_pg: ".$sys_pg." '>".$line['sys_subtit']."</a>
				</td>
				<td align='center'>$view</td>
				<td align='center'>$day</td>
				<td align='center'><a onclick=\"list_click_run_func('".$sys_pg."', '".$subtit."', 'on', '".$mid."', '".$sys_jong."', '".$num."', '".$job_addr."')\" target='_blank' style='color:cyan' title='run: $run'>Popup</a></td>
				<td><input type='button' value='Tree DN' onclick=\"treeDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'></td>
				<td><input type='button' value='Popup DN' onclick=\"popupDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'></td>
			</tr>";
		}
		$ln--;
	} // while
} //if

	echo "</tbody> </table>";
	echo "<TABLE border='0' align='center' width='100%'>";
	echo "<tr><td align='center' style='font-size:22px;'>";
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if( $last_page > $total_page) $last_page = $total_page;
	$prev = $first_page-1;
	if( $page > $page_num) echo"[<a onclick='page_func($prev)' style='color:cyan;font-size:22px;' title='page:$prev'>Prev</a>] ";
	for($i = $first_page; $i <= $last_page; $i++){
		if( $page == $i) echo" $i ";
		else echo"<a onclick='page_func($i)' style='color:cyan;font-size:22px;' title='page:$i'>[$i]</a>";
	}
	$next = $last_page+1;
	if( $next <= $total_page) echo"[<a onclick='page_func($next)' style='color:cyan;font-size:22px;' title='page:$next'>Next</a>]";
	echo "</td></tr></table>";
?>
</td>
<td align='right'>
</td>
</tr></table>
<?php if( $H_ID !='' ){ ?>
		<form name='form_view' method='post' enctype='multipart/form-data' >
			<input type='hidden' name='mode' value='<?=$mode?>' />						
			<input type='hidden' name='Hid'  value='<?=$H_ID?>' />						
		<input type='button' value='New Create' onclick="javascript:new_create('ailinkapp');" class='HeadTitle01AX' title='New create Menu Tree' onmouseover='big(this);' onmouseout='small(this);'>      
		</form>
<?php } ?>
</body>
</html>
