<?php
	include_once('../tkher_start_necessary.php');
	/*
		index.php : Tree List
		- index_create.php - cratreebook_make_create_menu.php : tree menu Create
		DB: {$tkher['sys_menu_bom_table']}, webeditor, webeditor_comment,
		     job_link_table, aboard_info, aboard_memo, aboard_admin, menuskin
	*/
	$H_ID  = get_session("ss_mb_id");
	if( isset($H_ID) && strlen($H_ID) > 2) {
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
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
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

	function new_create(Anum) {
		if( confirm('Are you sure you want to create? ') ) {
			location.href='index_create.php';
		}
	}
	function tree_func(mid, sys_pg, run_mode ){
		document.sys_form.mid.value     = mid;
		document.sys_form.sys_pg.value  = sys_pg;
		document.sys_form.run_mode.value= "cratree_book_remake";//run_mode;
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
</script>

<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<link rel='stylesheet' href='../include/css/kancss.css' type='text/css'>

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
	if( isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode'];
	else $mode="";
	if( isset($_REQUEST['mid']) ) $mid  = $_REQUEST['mid'];
	else $mid = $H_ID;
	if( isset($_REQUEST['page']) ) $page  = $_REQUEST['page'];
	else $page =1;
	$limite		= 15;	// page line
	$page_num	= 10;	// page 
	$total  = 0;
	$limit = "";
	$no = 0;
	$sdata  = '';
	if( isset($_POST['sdata']) && $_POST['sdata'] !=='' ) {
		$sdata  = $_POST['sdata'];
		$sdata = '%' . $sdata . '%';
		$query = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_subtit like '".$sdata."' and sys_level='mroot' and sys_subtit != 'main'  ";
	} else {
		$query = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_level='mroot' and sys_subtit != 'main' ";
	}
	$result = sql_query( $query);
	$total  = sql_num_rows( $result );
	
	$total_page = 0;
	$first = 1;
	$last = 1;
if( $total > 0 ) {
	$total_page = intval(($total-1) / $limite)+1;
	$first = ($page-1)*$limite;
	$last = $limite;
	if( $total < $last) $last = $total;
	$limit = "limit $first,$last";
	if( $page == 1)
		$no = $total;
	else {
		$no = $total - ($page - 1) * $limite;
	}
	if( strlen($sdata) > 0 ){
		$query = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_subtit like '".$sdata."' and sys_level='mroot' and sys_subtit != 'main' order by tit_gubun desc, up_day desc, sys_subtit $limit";
	} else {
		$query = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_level='mroot' and sys_menu = sys_submenu order by tit_gubun desc, up_day desc, sys_subtit $limit";
	}
	$result = sql_query( $query);
} else $total = 0;
	if( isset($_POST['Search_Mode']) ) $Search_Mode = $_POST['Search_Mode'];
	else $Search_Mode = "";
?>

<body bgcolor="#000000" text="#FFFFFF" topmargin="0" leftmargin="0" >
<center>
	<FORM method='post' name='sys_form' >
		<input type='hidden' name='Hid' value='<?=$H_ID?>' > 
		<input type='hidden' name='mid' value='<?=$mid?>' > 
		<input type='hidden' name='sys_pg'	 value='<?=$sys_pg?>' > 
		<input type='hidden' name='run_mode' value='' > 
	</form>
	<div class="header"><!-- start : header -->
<?php
	$runpage='./index.php';
	$cur='C';
	include "../menu_run.php";
	if( $mid) $madeid = $mid;
	else      $madeid ='All';
	echo "id:" . $H_ID .", total: " . $total . ", total-page: " . $total_page;
?>
<table class='floating-thead' >
<thead>
<tr style='background-color:#499BDA;color:black;'>
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
$ln = $no;
if( $result ){
	while( $line = sql_fetch_array( $result )) {
		$number = $number + 1;
		$num		= $line['book_num'];
		$mid	= $line['sys_userid'];
		$sys_pg = $line['sys_pg'];
		$runM = './' . $mid . '/' . $sys_pg . '_menu.html';
		$tit_gubun_ = $line['tit_gubun'];
		if( $line['tit_gubun']=='G') { // board
			$sys_jong = 'board';
			$run_mode = 'cratree_bbs_remake';
			$bb='green';
			$iconX="<img src='../icon/ship.png' width='20' height='15' title='B tit_gubun: $tit_gubun_'>";
		} else if( $line['tit_gubun']=='B'  ) { // note
			$sys_jong = 'note';
			$bb='yellow';
			$run_mode = 'cratree_book_remake';
			$iconX="<img src='../icon/pizza.png' width='20' height='15' title='tit_gubun: $tit_gubun_ '>";
		} else if( $line['tit_gubun']=='T'  ) { // tree
			$sys_jong = 'link';
			$bb='#99CCFF';
			$run_mode = 'cratree_remake';
			$iconX="<img src='../icon/berry.png' width='20' height='15' title='tit_gubun: $tit_gubun_ '>";
		} else if( $line['tit_gubun']=='M'  ) { // Note, tree
			$sys_jong = 'note';
			$bb='yellow';
			$run_mode = 'cratree_remake';
			$iconX="<img src='../icon/pizza.png' width='20' height='15' title='M tit_gubun: $tit_gubun_ '>";
		} else {
			$sys_jong = 'link';
			$run_mode = 'cratree_remake';
			$iconX="";
		}
		$day = substr($line['up_day'], 0 , 10);
		$subtit = $line['sys_subtit'];
		$job_addr='contents_view_menuD.php?num=' . $num;
		$run = './tree_run.php?sys_pg=' . $sys_pg . '&sys_subtitS=' . $line['sys_subtit'] .'&open_mode=on&mid='.$mid. '&sys_jong=' . $sys_jong. '&num=' . $num.'&job_addr='.$job_addr;
		if( isset($H_ID) and $mid == $H_ID or $H_LEV > 7 ) {
			echo "
			<tr>
				<td align='center'>$ln $iconX</td>
				<td><a href='$run' target='_blank' style='color:$bb' title=' $tit_gubun_ - mid:".$mid.", view:".$line['view_cnt'].", sys_pg: ".$sys_pg."'>".$line['sys_subtit']."</a></td>
				<td align='center'><a href='$run' target='_blank' style='color:blue' title='gubun:".$line['tit_gubun']."'>Popup</a></td>
				<td><input type='button' value='Tree DN' onclick=\"treeDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'></td>
				<td><input type='button' value='Popup DN' onclick=\"popupDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'></td>
				<!-- 2021-10-09 : <td>
				<input type='button' value='Tree Create' onclick=\"tree_func('$mid', '$sys_pg', '$run_mode');\" style='background-color:black;color:yellow;' title='Recreate the tree menu of $subtit'>	</td>
				<td><input type='button' value='Popup Create' onclick=\"popup_func('$mid', '$sys_pg', '$run_mode');\" style='background-color:black;color:yellow;' title='Recreate the popup menu of $subtit'></td> -->
			</tr>";
		} else {
			echo "
			<tr>
				<td align='center'>$ln $iconX</td>
				<td><a href='$run' target='_blank' style='color:$bb' title='$tit_gubun_ - mid:".$mid.", view:".$line['view_cnt'].", sys_pg: ".$sys_pg." '>".$line['sys_subtit']."</a></td>
				<td align='center'><a href='$run' target='_blank' style='color:cyan' title='run: $run'>Popup</a></td>
				<td><input type='button' value='Tree DN' onclick=\"treeDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'></td>
				<td><input type='button' value='Popup DN' onclick=\"popupDN_func('$mid', '$sys_pg', '$run_mode', '$H_POINT');\" style='background-color:black;color:white;' title='Download source code of $subtit'></td>
				<td align='center'> --- </td>
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
	if($last_page > $total_page) $last_page = $total_page;
	$prev = $first_page-1;
	if($page > $page_num) echo"[<a href=$PHP_SELF?page=$prev>Prev</a>] ";
	for($i = $first_page; $i <= $last_page; $i++)
	{
		if($page == $i) echo" $i ";
		else echo"<a href=$PHP_SELF?page=$i style='font-size:22px;'>[$i]</a>";
	}
	$next = $last_page+1;
	if($next <= $total_page) echo"[<a href=$PHP_SELF?page=$next>Next</a>]";
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
		<input type='button' value='New Create' onclick="javascript:new_create('ailinkapp');" class='HeadTitle01AX' title='New create Menu Tree' onmouseover='big(this);' onmouseout='small(this);'>      
		</form>
<?php } ?>
</div><!-- end : header -->
</body></html>
