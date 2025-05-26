<?php
	include_once('../tkher_start_necessary.php');
		$H_ID			= get_session("ss_mb_id");  
		if( isset($member['mb_level']) ) $H_LEV = $member['mb_level']; 
		else $H_LEV = 0;
		if( isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode'];
		else $mode = '';
		/*
			album_slide_my.php : my page slide image
			- table: tkher_main_img - my slide table
			- view_db_my.php
		*/
?>
<html>

<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
    <link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="keywords"
        content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
    <meta name="description"
        content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
    <meta name="robots" content="ALL">

    <link rel="stylesheet" href="../include/css/common.css" type="text/css" />
    <script type="text/javascript" src="../include/js/ui.js"></script>

    <!--     <link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/default.css" type="text/css" />
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/common.js"></script> -->

    <?php
		if( !$H_ID ) {
			my_msg(" You need to login. ");
			$url = "./";
			echo "<script>window.open('$url', '_self', '');</script>";
		} else {
			$sql = " SELECT * from {$tkher['tkher_my_control_table']} where userid='$H_ID' ";
			$ret= sql_query($sql);
			$rs = sql_fetch_array($ret);
			if( isset($rs['slide_time']) ) $slide_time = $rs['slide_time'];
			else $slide_time=3000;
		}
		if( !$slide_time ) $slide_time=3000;

		//$slide_time=3000;

		$i=0;
		$st_style = "<style type='text/css'> ";
		$slide_msg = "";
		//if( $H_LEV > 4 ) $u_="";
		//else $u_= isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		$u_= isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];//"Tkher.com";

		$sql = " SELECT * from {$tkher['tkher_main_img_table']} where userid='$H_ID' order by view_no ";
		$ret = sql_query($sql);
		while( $rs = sql_fetch_array($ret) ) {
			$i++;
			if( $i < 10 ) $k = "0" . $i;
			else $k = $i;
			//$k = ( $i < 10 ) ? '0'.$i : $i;
			$f_path = KAPP_URL_T_ . "/file/" . $H_ID . "/" . $rs['jpg_file'];
			$inm= $rs['jpg_name'];
			$mg = $rs['jpg_memo'] . "<br>" . $H_ID;
			$st_style = $st_style . " .visualSlide .item.bg_p".$k."{background:url($f_path) no-repeat center top;background-size:cover;} ";
			$slide_msg = $slide_msg .  "	<div class='item bg_p". $k . "'> ";
			$slide_msg = $slide_msg .  "	<div class='txtbox'> ";
			$slide_msg = $slide_msg .  "	<div class='cellbox'> ";
			$slide_msg = $slide_msg .  "	<p class='t01'>$u_</p> ";
			//$slide_msg = $slide_msg .  "	<p class='t02'>$inm</p> ";
			$slide_msg = $slide_msg .  "	<p class='t03'> ";
			//$slide_msg = $slide_msg .  "	<span>$mg</span> ";
			$slide_msg = $slide_msg .  "	</p> ";
			$slide_msg = $slide_msg .  "	</div> ";
			$slide_msg = $slide_msg .  "	</div> ";
			$slide_msg = $slide_msg .  "	</div> ";
		}	
		$st_style = $st_style . "</style>";
		echo $st_style;
		//$slide_time = $rs['delay_time']; //3000;
		//m_("slide_time : ".$slide_time);
		//$slide_time = 3000; // $rs['delay_time'] 값 없음
?>
</head>

<body>
    <div class="header">
        <?php 
		$cur='B';
		//include "../menu_run.php"; 
if( $H_LEV < 2) {
?>
        <h1>
            <a href="./" target='_top' class="logo">
                <!-- <img src="../include/img/etc/etc_logo3.png" class="logo_web" title="Tkher"  /> -->
                <img src="../include/img/dev_man.jpg" class="logo_web" title="Tkher" />
            </a>
        </h1>
        <?php } ?>

    </div>
    <div class="container">
        <div class="visualBox">
            <div class="visualSlide"><?php echo $slide_msg; ?></div>
        </div>
    </div>
    <script type="text/javascript">
    $('.pop').click(function() {
        var index = $('.pop').index();
        var num = $(this).index()
        $('.workView').eq(num).fadeIn();
    })
    $('.whleft').click(function() {
        $('.workView').fadeOut();
    })
    $('.nextwork').click(function() {
        var next = $(this).index()
        $('.workView').fadeOut();
        $(this).parent().parent().parent().next().fadeIn();
    })
    </script>
    <script type="text/javascript">
    var $grid;
    $(function() {
        $(window).on("load resize", function() {
            visualHeight();
            $('#videoBg').vide({
                'mp4': '<?=KAPP_URL_T_?>/include/video/tkherMovie'
            });
        });
        $(".visualSlide ").slick({
            dots: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: <?=$slide_time?>,
            pauseOnHover: false
        });
        if ($(".grid").length) {
            $grid = $('.grid').isotope({
                itemSelector: '.element-item',
                layoutMode: 'fitRows'
            });
        }
        $("body").on("click", ".listTabs a", function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
            $(".listTabs a").removeClass("on");
            $(this).addClass("on");
        });
        $("body").on("click", ".listTabs01 a", function() {
            $(".listTabs01 a").removeClass("on");
            $(this).addClass("on");
        });
        $(window).on("scroll", common.headerFixed);
        $("body").on("click", ".btnService", function() {
            var ck = $(this).hasClass("on");
            if (ck) {
                $(this).removeClass("on");
                $(".serviceLayer").hide();
            } else {
                $(this).addClass("on");
                $(".serviceLayer").show();
            }
        });
        $("body").on("click", ".project_request .close", function() {
            $(".project_area").stop().animate({
                "right": "-1000px"
            }, 200, 'easeOutQuad');
        });
        $("body").on("click", ".lnbFooter a.lnbIcon03", function() {
            $(".project_area").stop().animate({
                "right": "-20px"
            }, 200, 'easeOutQuad');
            $(".loginBox").stop().animate({
                "right": "-1000px"
            }, 200, 'easeOutQuad');
        });
        $("body").on("click", ".loginClose", function() {
            $(".loginBox").stop().animate({
                "right": "-1000px"
            }, 200, 'easeOutQuad');
        });
        $("body").on("click", ".lnbFooter a.lnbIcon01", function() {
            $(".loginBox").stop().animate({
                "right": "0"
            }, 200, 'easeOutQuad');
            $(".project_area").stop().animate({
                "right": "-1000px"
            }, 200, 'easeOutQuad');
        });
    });

    function visualHeight() {
        var h = window.innerHeight;
        $(".visualSlide .item, #videoBg").css("height", h + "px");
    }
    common = {
        etcEvt: function() {
            $("body").on("click", ".btnService", function() {
                var ck = $(this).hasClass("on");
                if (ck) {
                    $(this).removeClass("on");
                    $(".serviceLayer").hide();
                } else {
                    $(this).addClass("on");
                    $(".serviceLayer").show();
                }
            });

        },
        headerFixed: function() {
            var h = window.innerHeight;
            var st = $(window).scrollTop();
            if (st < h) {
                $(".header").removeClass("on");
            } else {
                $(".header").addClass("on");
            }
        },
    }
    </script>
</body>

</html>