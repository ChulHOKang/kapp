<?php
	include_once('./kapp_start_necessary.php');
	/*
	  indexTT_kapp.php <- indexTT.php : test 
	  call: index_kapp.php

	  --- 이것을 알아야 하는 이유, 이것을 사용해야 하는 이유 ---
	  1. 이것은 나의 미래를 결정한다.
	  2. 이것은 나의 경쟁력이다.
	  3. 이것은 1시간이면 알수있고, 1주일이면 나도 전문가다
	  4. 이것은 나의 상상력을 펼치기 위한 필수 조건이다.
	  5. 이것을 아는것은 힘이요, 원동력이다.
	  --------------------------------------------------
	  tkher_my_control, tkher_main_img
	  $sql = " SELECT * from {$tkher['tkher_my_control_table']} where userid='tkher' ";
	  $sql = " SELECT * from {$tkher['tkher_main_img_table']} where userid='tkher' and group_name='main' order by view_no ";
	*/

	date_default_timezone_set("Asia/Seoul");
	$day		= date("Y-m-d H:i:s");
	$H_ID		= get_session("ss_mb_id");  
	$H_LEV = $member['mb_level']; 
	$ip    = $_SERVER['REMOTE_ADDR'];
?>

<html>
<head>
<TITLE>K-App Generator System. Made in Korea - Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg"><!-- /logo/logo25a.jpg -->
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<link rel="stylesheet" href="./include/css/common.css" type="text/css" />
<script type="text/javascript" src="./include/js/ui.js"></script>
<script>
	function re_exec(){
		setTimeout( "history.go(0);", 6000000 );
	 	}
	function time() {
		//alert(<%=System.currentTimeMillis%>);
		//alert(new Date().getTime());//1620176755434

		dt=getTimeStamp();
		//alert(dt); 
		//document.write( dt + '<br />'); // 전체화면지우고 출력한다.

		//setTimeout("time()",3000);

		//_url='./';
		//document.kakao_form.action=_url;
		//document.kakao_form.target='_top';
		//document.kakao_form.submit();
		//setTimeout("time()",  86400*31 );
		setTimeout( "history.go(0);", 600000 );
		//2021-05-05 10:37:09
		//2021-05-05 10:49:35
	}
	function getTimeStamp() {
	  var d = new Date();

	  var s =
		leadingZeros(d.getFullYear(), 4) + '-' +
		leadingZeros(d.getMonth() + 1, 2) + '-' +
		leadingZeros(d.getDate(), 2) + ' ' +

		leadingZeros(d.getHours(), 2) + ':' +
		leadingZeros(d.getMinutes(), 2) + ':' +
		leadingZeros(d.getSeconds(), 2);

	  return s;
	}

	function leadingZeros(n, digits) {
	  var zero = '';
	  n = n.toString();

	  if (n.length < digits) {
		for (i = 0; i < digits - n.length; i++)
		  zero += '0';
	  }
	  return zero + n;
	}
</script>

<?php
		$sql = " SELECT * from {$tkher['tkher_my_control_table']} where userid='tkher' ";
		$ret = sql_query($sql);
		$rs  = sql_fetch_array($ret);
		$slide_time = $rs['slide_time'];
		if( !$slide_time ) $slide_time = 3000;
		$sql = " SELECT * from {$tkher['tkher_main_img_table']} where userid='tkher' and group_name='main' order by view_no ";
		$ret       = sql_query($sql);
		$st_style  = "<style type='text/css'> ";
		$slide_msg = "";
		$i=0;
		while ( $rs = sql_fetch_array($ret) ) {
			$i++;
			if( $i < 10 ) $k = "0" . $i;
			else			$k = $i;
			$ifile =$rs['jpg_file'];
			$inm   =$rs['jpg_name'];
			$mg    =$rs['jpg_memo'];
			$st_style = $st_style . " .visualSlide .item.bg_p".$k."{background:url(./data/main_scroll_image/$ifile) no-repeat center top;background-size:cover;} ";
			$slide_msg = $slide_msg .  "	<div class='item bg_p". $k . "'> ";
			$slide_msg = $slide_msg .  "	<div class='txtbox'> ";
			$slide_msg = $slide_msg .  "	<div class='cellbox'> ";
			$slide_msg = $slide_msg .  "	<p class='t01'>App Maker : $k</p> ";
			$slide_msg = $slide_msg .  "	<p class='t02'>$inm</p> ";
			$slide_msg = $slide_msg .  "	<p class='t03'> ";
			$slide_msg = $slide_msg .  "	<span>$mg</span> ";
			$slide_msg = $slide_msg .  "	</p> ";
			$slide_msg = $slide_msg .  "	</div> ";
			$slide_msg = $slide_msg .  "	</div> ";
			$slide_msg = $slide_msg .  "	</div> ";
		}	
		$st_style = $st_style . "</style>";
		echo $st_style;

date_default_timezone_set("Asia/Seoul");
$t = date("Y-m-d H:i:s");
//echo $t;
?>
</head>
<!-- <body onload = "re_exec()"> -->
<body>
	<div class="header"><!-- start : header -->

		<?php include "./menu_run.php"; ?>

<?php
 if(!$H_ID) echo $ip;
?>

<?php
	if( get_session("urllink_login_type") == "" ){ 
		echo "<table><tr><td><img height='36' src='./icon/kakao.jpg' onclick='javascript:Kakao_Login_func()' title='A Kakao-Login:$day' />&nbsp;&nbsp;&nbsp;</td>";
		echo "<td><div class='g-signin2' data-onsuccess='onSignIn' data-theme='dark' title='Google Login A'></div></td><tr></table>";
	}
	if( !$G_SAJIN ) {
?>
		<h1>
			<a href="/" target='_top' class="logo" title='development man'>
				<img src="./icon/dev_man.jpg" class="logo_web" title="Development Manager" />
			</a>
		</h1>
<?php
	} else {
?>
		<h1>
			<a href="/cratree/r1_my.php" target='_top' class="logo">
				<img src="<?=$G_SAJIN?>" class="logo_web" title="My Page go!" />
			</a>
		</h1>
<?php
	}
?>
	</div><!-- end : header -->
	<div class="visualSlide"><?php echo $slide_msg; ?></div> 
<?php	include "footer_include.php";	?>
</body>

 <script type="text/javascript">
	$('.pop').click(function(){
		alert('pop 1111');
		var index = $('.pop').index();
		var num = $(this).index()
		$('.workView').eq(num).fadeIn();
	})
	$('.whleft').click(function(){
		$('.workView').fadeOut();
	})
	$('.nextwork').click(function(){
		var next = $(this).index()
		$('.workView').fadeOut();
		$(this).parent().parent().parent().next().fadeIn();
	})
</script>
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
</body>
</html>
<script>
	//setTimeout( "history.go(0);", 60000 );
	setTimeout("time()",  86400*31 );
	//setTimeout("time()",  6400000 );
</script>
