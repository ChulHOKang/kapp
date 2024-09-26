<?php
	include_once('../tkher_start_necessary.php');

	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = 
	$H_POINT=$member['mb_point']; $_SERVER['REMOTE_ADDR'];
	/*
		/t/menu/ktree_list_my.php - /t/tree_menu_list_guest.php copy
		/t/tree_menu_list_guest.php : /t/menu/tree_menu_list.php copy Guest용 tree list
		/t/menu/tree_menu_list.php : /t/menu/ktree_list_my.php copy 모바일용 통합 tree list
		2021-05-30 : 모바일용 생성
	*/
	if( $member['mb_level'] < 2) {
		m_("my page login please"); 
		echo("<meta http-equiv='refresh' content='0; URL=index.php'>");
		exit;
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator Tree Menu. Made in Kang, Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> 
<meta name='keywords' content='app, tree, tree menu, app make, appgenerator, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> 
<meta name='description' content='app, tree, tree menu, app make, appgenerator, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> 
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

	function contents_del(num, page) {
	}
	function new_create(Anum) {
		location.href='../menu/index.php';
	}
	function tree_func(mid, sys_pg, run_mode ){
		//alert("tree mid:"+mid + ", sys_pg:" + sys_pg + ", run_mode:" + run_mode);
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= "cratree_book_remake";//run_mode;
		document.sys_form.action='../treebom_remake_all_menu.php';
		document.sys_form.target  = "_blank";
		document.sys_form.submit();
	}
	function popup_func(mid, sys_pg, run_mode ){
		//alert("popup mid:"+mid + ", sys_pg:" + sys_pg + ", run_mode:" + run_mode);
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= run_mode;
		document.sys_form.action='../treebom_dropdown_menu_create.php';
		document.sys_form.submit();
	}
	function treeDN_func(mid, sys_pg, run_mode, point ){
		if( !document.sys_form.Hid.value ) {
			alert('Login please!'); return false;
		}
		if( point < 1000){
			alert("There are not enough points. point:" + point);
			return  false;
		}
		//alert("treeDN_func mid:"+mid + ", sys_pg:" + sys_pg + ", run_mode:" + run_mode+ ", point:" + point);
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= 'tree_menu_createDN';
		document.sys_form.action='../treebom_tree_menu_createDN.php';
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
		//alert("popup mid:"+mid + ", sys_pg:" + sys_pg + ", run_mode:" + run_mode+ ", point:" + point);
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= 'dropdown_menu_createDN';
		document.sys_form.action='../treebom_dropdown_menu_createDN.php';
		document.sys_form.target  = "_blank";
		document.sys_form.submit();
	}
</script>
<!-- <script src="//code.jquery.com/jquery.min.js"></script> -->

<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<link rel='stylesheet' href='../include/css/kancss.css' type='text/css'><!-- 중요! -->

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
<!-- --- login -->
<script type="text/javascript">
var $grid;
$(function(){
	$(window).on("load resize",function(){
		visualHeight();
		$('#videoBg').vide({'mp4': '../video/tkherMovie'});
	});
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

	$h_lev		= $H_LEV;	//	HTTP_SESSION_VARS['H_LEV'];
	$from_session_id  = $H_ID;	//HTTP_SESSION_VARS['from_session_id'];
	$mode = $_REQUEST['mode'];

	$mid  = $_REQUEST['mid'];

	$param = $_REQUEST['param'];
	$sel   = $_REQUEST['sel'];
	$data  = $_REQUEST['data'];
	$page  = $_REQUEST['page'];

	$limite		= 15;	// 한페이지에 나타낼 글자 갯수
	$page_num	= 10;	// [1] [2] [3] 갯수
	//----------------------------------------------------------------------------------------------------

		if( $mode=='MySearch' ){
			if($sel=='like') $data = '%' . $data . '%';
			$query = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$H_ID' and $param $sel '$data' and sys_level='mroot' and sys_subtit != 'main'  ";
		} else {
			$query = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$H_ID' and sys_level='mroot' and sys_subtit != 'main' ";
		}
	//----------------------------------------------------------------------------------------------------
	$result = sql_query( $query);
	$total  = sql_num_rows( $result );

	if(!$page) $page=1;
	$total_page = intval(($total-1) / $limite)+1;
	$first = ($page-1)*$limite;
	$last = $limite;


	if($total < $last) $last = $total;
	$limit = "limit $first,$last";
	if ($page == 1)
		$no = $total;
	else {
		$no = $total - ($page - 1) * $limite;
	}

		if( $mode=='MySearch' ){
			if($sel=='like') $data = '%' . $data . '%';
			$query = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$H_ID' and $param $sel '$data' and sys_level='mroot' and sys_subtit != 'main' order by tit_gubun desc, up_day desc, sys_subtit $limit";
		} else {
			$query = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$H_ID' and sys_level='mroot' and sys_subtit != 'main' order by tit_gubun desc, up_day desc, sys_subtit $limit";
		}

	$result = sql_query( $query);
?>

<body bgcolor="#000000" text="#FFFFFF" topmargin="0" leftmargin="0" >
<center>

	<form method='post' name='sys_form' >
		<input type='hidden' name='Hid' value='<?=$H_ID?>' > 
		<input type='hidden' name='mid' value='<?=$mid?>' > 
		<input type='hidden' name='sys_pg'	value='<?=$sys_pg?>' > 
		<input type='hidden' name='run_mode' value='' > 
	</form>

	<div class="header"><!-- start : header -->
	
	<?php
		$runpage='./ktree_list_my.php';
		$cur='C';
		//include "../menu_run.php";

	if($mid) $madeid = $mid;
	else $madeid ='All';

echo "id:" . $H_ID .", total: " . $total . ", total-page: " . $total_page;
	?>

<table class='floating-thead' >

<thead>
<tr style='background-color:#499BDA;color:black;'>
	<!-- <th>NO</th> -->
	<th>type</th>
	<th>Title</th>
	<th>Pop Run</th>
	<th title='Tree Menu Source Code Download.' style='color:black;'>Down-Load</th>
	<th title='Popup Menu Source Code Download.' style='color:black;'>Down-Load</th>
</tr>

 </thead>
<tbody>

<?php
$number = ($page - 1) * $limite;
$ln=$no;
while( $line = sql_fetch_array( $result )) {

	$number = $number + 1;
	$make_id = $line['user'];
	if ( !$make_id ) $make_id ='-';
	$nm		=$line['book_num'];
	$day_ymd= substr( $line['date'], 0, 10);
	$lnum	=$line['seqno'];
	$mid	=$line['sys_userid'];

	$sys_pg = $line['sys_pg'];

	$runM = './' . $mid . '/' . $sys_pg . '_menu.html';

	if( $line['tit_gubun']=='G') { // board
		$run_mode = 'cratree_bbs_remake';
		$bb='green';
		$iconX="<img src='".KAPP_URL_T_."/logo/ship.png' width='20' height='15' title='Tree G Board:'>";
		$typeT = 'board';
	} else if( $line['tit_gubun']=='M'  ) { // Tree Create 'note'
		$bb='yellow';
		$run_mode = 'cratree_book_remake';
		$iconX="<img src='".KAPP_URL_T_."/logo/pizza.png' width='20' height='15' title='Tree M Note:'>";
		$typeT = 'note';
	} else if( $line['tit_gubun']=='B'  ) { // note
		$bb='yellow';
		$run_mode = 'cratree_book_remake';
		$iconX="<img src='".KAPP_URL_T_."/logo/pizza.png' width='20' height='15' title='Tree B Note:'>";
		$typeT = 'note';
	} else if( $line['tit_gubun']=='T'  ) { // tree
		$bb='#99CCFF';
		$run_mode = 'cratree_remake';
		$iconX="<img src='".KAPP_URL_T_."/logo/berry.png' width='20' height='15' title='Tree T Url:'>";
		$typeT = 'link';
	} else {
		$run_mode = 'cratree_remake';
		$iconX='';
		$typeT = 'note';
	}

		$day = substr($line['up_day'], 0 , 10);
        $subtit = $line['sys_subtit'];

		//$run = '../tree_menu_guest.php?sys_pg=' . $sys_pg . '&sys_subtitS=' . $line['sys_subtit'] .'&open_mode=on&mid='.$mid;
		$run = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg . '&num=' . $sys_pg . '&sys_subtitS=' . $line['sys_subtit'] .'&open_mode=on&mid='.$mid. '&sys_jong=' . $typeT;
	if ( $H_ID and $mid == $from_session_id ) {
		echo "
		<tr>
			<td align='center'>$ln $iconX</td>
			<td><a href='$run' target='_blank' style='color:$bb' title='maker:".$mid.", view:".$line['view_cnt'].", $typeT' style='color:white;'>".$line['sys_subtit']."</a></td>
			<td align='center'><a href='$runM' target='_blank' style='color:blue' title='Launch the popup menu:$runM'>Popup</a></td>
			<td><input type='button' value='Tree DN' onclick=\"treeDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='color:black;' title='Download source code of $subtit'></td>
			<td><input type='button' value='Popup DN' onclick=\"popupDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='color:black;' title='Download source code of $subtit'>
			</td>
		</tr>
		";

	} else {
		/*echo "
		<tr>
			<td align='center'>$ln $iconX</td>
			<td>
				<a href='$run' target='_blank' style='color:$bb' title='maker:".$mid.", view:".$line['view_cnt'].", Run the tree menu.'>".$line['sys_subtit']."</a></td>
			<td align='center'><a href='$runM' target='_blank' style='color:cyan' title='-Launch the popup menu:$runM'>Popup</a>
			</td>
			<td>
			<input type='button' value='Tree DN' onclick=\"treeDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'>
			</td>
			<td>
			<input type='button' value='Popup DN' onclick=\"popupDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'>
			</td>
			<td align='center'> --- </td>
			<td align='center'> --- </td>
		</tr>
		";*/
	}
	$ln--;
} // while

	echo "</tbody> </table>";
	echo "<TABLE border='0' align='center' width='100%'>";
	echo "<tr><td align='center' style='font-size:18;color:yellow;'>";

	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;

	$prev = $first_page-1;

	if($page > $page_num) echo "&nbsp;[<a href=$PHP_SELF?page=$prev>Prev</a>]&nbsp;";
	for($i = $first_page; $i <= $last_page; $i++)
	{
		if($page == $i) echo " $i ";
		else echo "&nbsp;[<a style='font-size:18;color:cyan;' href=$PHP_SELF?page=$i>$i</a>]&nbsp;";
	}

	$next = $last_page+1;
	if($next <= $total_page) echo "&nbsp;[<a href=$PHP_SELF?page=$next>Next</a>]&nbsp;";
	echo "</td></tr></table>";
?>
</td>
<td align='right'>
</td>
</tr></table>

<?php if($H_ID){ ?>
		<form name='form_view' method='post' enctype='multipart/form-data' >
			<input type='hidden' name='mode' value='' />						
			<input type='hidden' name='Hid'  value='<?=$H_ID?>' />						
		<input type='button' value='New Create' onclick="javascript:new_create('urllinksystem');" class='HeadTitle01AX' title='New create Menu Tree' onmouseover='big(this);' onmouseout='small(this);'>      
		</form>
<?php } ?>

	</div><!-- end : header -->

</body></html>
