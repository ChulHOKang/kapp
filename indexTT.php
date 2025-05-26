<?php
	include_once('./tkher_start_necessary.php');	 //KAPP_URL , kapp_start_necessary_TT.php, tkher_start_necessary.php
?>
<html>

<head>
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="keywords"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
    <meta name="description"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
    <meta name="robots" content="ALL">

    <?php
	/*
	indexTT.php - call : index.php - include : 
	- include : tkher_start_necessary.php
	: login $config['kapp_googl_shorturl_apikey']

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
	if( isset($member['mb_id']) ){
		$H_ID = $member['mb_id'];  //get_session("ss_mb_id");  
		$H_LEV = $member['mb_level']; 
	}
	$ip    = $_SERVER['REMOTE_ADDR'];
	$ss_mb_id = get_session("ss_mb_id");
	$ss_mb_lev = get_session("ss_mb_lev");
?>
    <link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg"><!-- /logo/logo25a.jpg -->
    <link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/common.css" type="text/css" />
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>

    <script>
    function re_exec() {
        setTimeout("history.go(0);", 6000000);
    }

    function time() {
        dt = getTimeStamp();
        setTimeout("history.go(0);", 600000);
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

    // 구글 로그아웃
    /* function GoogleLogout() {
        let g_email = '<?=$H_ID?>';
        let g_type = '<?=get_session("urllink_login_type")?>';
        //console.log(g_email);

        if (g_email == '') {
            alert("g_email:" + g_email);
            return;
        }
        if (g_type !== 'Google') {
            alert("g_type:" + g_type);
            return;
        }
        //console.log("logout");
        //google.accounts.id.disableAutoSelect();
        google.accounts.id.revoke(g_email, done => {
            console.log('consent revoked');
            google.accounts.id.disableAutoSelect();
            logout_();
        });
    } */
    </script>

    <?php
	// Syatem Table : {$tkher['tkher_my_control_table']}, tkher_main_img
	$sql = " SELECT * from {$tkher['tkher_my_control_table']} where userid='tkher' ";
	$ret = sql_query($sql);
	$rs  = sql_fetch_array($ret);
	$slide_time = $rs['slide_time'];
	if( !$slide_time ) $slide_time = $config['kapp_slide_time'];//$slide_time = 3000;

    //m_($slide_time);

	$sql = " SELECT * from {$tkher['tkher_main_img_table']} where userid='tkher' and group_name='main' order by view_no ";
	//$sql = " SELECT * from {$tkher['tkher_main_img_table']} where userid='tkher' and group_name='main' order by view_no ";
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
		$st_style = $st_style . " .visualSlide .item.bg_p".$k."{background:url(".KAPP_URL_T_."/data/main_scroll_image/$ifile) no-repeat center top;background-size:cover;} ";
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
    <!-- <div class="wrapper"> -->
    <!-- start : wrapper -->
    <!-- <div class="container"> -->
    <!-- start : container -->

    <div class="header">
        <!-- start : header -->

        <?php include "./menu_run.php"; ?>

        <?php
	//m_("indexTT - login_type : " . get_session("urllink_login_type")); // indexTT - login_type : Naver_Login_K
	//m_("H_ID : " . $H_ID);
	echo '<script src="https://accounts.google.com/gsi/client" async defer></script>
    <div id="g_id_onload"
         data-client_id="'.$config['kapp_googl_shorturl_apikey'].'"
         data-callback="handleCredentialResponse">
    </div>';

	if( get_session("urllink_login_type") == "" ){ 

		echo "<table><tr><td><img height='36' src='".KAPP_URL_T_ . "/icon/kakao.jpg' onclick='javascript:Kakao_Login_func()' title='A Kakao-Login:$day' />&nbsp;&nbsp;&nbsp;</td>";

        /* if($config['kapp_login_minutes'] == 10) {
            echo "<td><div class='g-signin2' data-onsuccess='onSignIn' data-theme='dark' title='Google Login A'></div></td><tr></table>"; // 구글 자동로그인
        } else {
            echo "<td><div id='buttonDiv' style='text-align: -webkit-center;' title='Google Login A'></div></td><tr></table>"; // 구글 수동로그인
        } */

		echo '<td><div class="g_id_signin" data-type="standard"></div></td>';
		//echo "<td><div class='g-signin2' data-onsuccess='onSignIn' data-theme='dark' title='Google Login A'></div></td>"; // 구글 자동로그인
		//echo "<td><div id='buttonDiv' style='text-align: -webkit-center;' title='Google Login A'></div></td><tr></table>"; // 구글 수동로그인

		$n_client_id = $config['kapp_naver_client_id'];
		$N_reurl = KAPP_URL_T . "/login_checkT.php?mode=N_login";
        $redirectURI = urlencode( $N_reurl );
        $state = "modumoa";
        $apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$n_client_id."&redirect_uri=".$redirectURI."&state=".$state;
        echo "<td><a id='naverIdLogin_loginButton' target='_top' href='".$apiURL."'><img src='./include/img/btnG_naver.png' /></a></td><tr></table>"; // 네이버 로그인

	} else if( get_session("urllink_login_type") == "Google_Login_K") { // 임시 login_type
		
		//echo "<table><tr><td><a href='javascript:GoogleLogout()' class=''>Google_LogOut</a></td><tr></table>"; // 함수 실행
        echo "<table><tr><td><button onclick='GoogleLogout()' class=''>Google_LogOut</button></td><tr></table>"; // 로그아웃 버튼

	} else if (get_session("urllink_login_type") == "Kakao_Login_K") {
        echo "<table><tr><td><button onclick='KakaoLogout()' class=''>Kakao_LogOut</button></td><tr></table>";

    } else if (get_session("urllink_login_type") == "Naver_Login_K") {
        echo "<table><tr><td><button onclick='naverLogout()' class=''>Naver_LogOut</button></td><tr></table>";
    }

	//if( !$gsajin ) { $gsajin = KAPP_URL_T_ ."/icon/dev_man.jpg"; }
    if( !$gsajin ) { 
        if( isset($member['mb_photo']) ) $gsajin = $member['mb_photo']; 
		else $gsajin = KAPP_URL_T_ ."/icon/dev_man.jpg";
    }
    
    //m("mb_photo : ".$member['mb_photo']);
	// photo 1 : https://lh3.googleusercontent.com/a/ACg8ocItDyMm1Cvc11Vh1iYxflCBoLFYWYkvbXJItKQ8GhYyHxg=s96-c
?>
        <h1>
            <a href="/kapp" target='_top' class="logo" title='development man'>
                <img src="<?=$gsajin?>" class="logo_web" title="K-APP Home" />
            </a>
        </h1>
    </div><!-- end : header -->

    <div class="visualSlide"><?php echo $slide_msg; ?></div>

    <!-- </div> -->
    <!-- end : container -->

    <?php
		include "footer_include.php";	
	?>

    <!-- </div> -->
    <!-- end : wrapper-->

</body>

<script type="text/javascript">
$('.pop').click(function() {
    alert('pop 1111');
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
    /*$(window).on("load resize", function() {
        visualHeight();
        $('#videoBg').vide({
            'mp4': './file/video/tkherMovie'
        });
    });*/
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
    var w = window.innerWidth;
    $(".visualSlide .item, #videoBg").css("height", h + "px");
    $(".visualSlide .item, #videoBg").css("width", w + "px");
}

common = {
    openProj01: function() {
        alert(" Proj01------------");
        $(".dialog").stop().fadeIn(200, 'easeOutQuad');
        $(".lnbArea").delay(200).stop().animate({
            "right": "0"
        }, 200, 'easeOutQuad');
        $(".project_area").delay(200).stop().animate({
            "right": "-20px"
        }, 200, 'easeOutQuad');
    },
    lnbOpen: function() {
        $(".dialog").stop().fadeIn(200, 'easeOutQuad');
        $(".lnbArea").delay(200).stop().animate({
            "right": "0"
        }, 200, 'easeOutQuad');
    },
    lnbClose: function() { // $(".project_area").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad', function(){
        $(".project_area").stop().animate({
            "right": "-1100px"
        }, 200, 'easeOutQuad', function() {
            $(".lnbArea").stop().animate({
                "right": "-300px"
            }, 200, 'easeOutQuad');
        });
        $(".dialog").delay(200).stop().fadeOut(200, 'easeOutQuad');
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

$('.ftr_project').click(function() {
    $(".lnbArea").delay(200).stop().animate({
        "right": "0"
    }, 200, 'easeOutQuad');
})

function handleCredentialResponse(response) { // 로그인 완료
    const responsePayload = parseJwt(response.credential);

    document.kakao_form.mode.value = "Google_Login_K";
    document.kakao_form.modeG.value = "Google";
    document.kakao_form.modeA.value = "member_set";

    document.kakao_form.g_email.value = responsePayload.email;
    document.kakao_form.g_fullname.value = responsePayload.name;
    document.kakao_form.g_image.value = responsePayload.picture;
    document.kakao_form.action = "login_checkT.php";
    document.kakao_form.submit();
}

function parseJwt(token) { // 파싱
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
};

// 구글 로그인, 자동 로그인
window.onload = function() {
    google.accounts.id.initialize({
        client_id: "<?=Decrypt($config['kapp_googl_shorturl_apikey'], 'modumoa', '~!@#$%^&*()_+')?>",
        callback: handleCredentialResponse // 로그인 완료
    });
    google.accounts.id.renderButton(
        document.getElementById("buttonDiv"), {
            shape: "rectangular",
            theme: "filled_blue",
            size: "large",
            text: "signin",
            width: 72, // 변경 전 : 183
            locale: "en_US"
        } // customization attributes
    );
    google.accounts.id.prompt(); // also display the One Tap dialog

}

// 구글 로그아웃
function GoogleLogout() {
    let g_email = "<?=$member['mb_email']?>";
    google.accounts.id.revoke(g_email, done => {
        console.log('consent revoked');
        google.accounts.id.disableAutoSelect();
        //logout_();
        document.kakao_form.action = "./logoutT.php";
        document.kakao_form.submit();
    });
}

// 카카오 로그아웃
function KakaoLogout() {

    document.kakao_form.action = "./logoutT.php";
    document.kakao_form.submit();
}

// 네이버 팝업
var naverPopup;

function openPopUp() {
    naverPopup = window.open("https://nid.naver.com/nidlogin.logout", "_blank",
        "toolbar=yes,scrollbars=yes,resizable=yes,width=1,height=1");
}

function closePopUp() {
    naverPopup.close();
}

// 네이버 로그아웃 (팝업 방식)
function naverLogout() {
    openPopUp();
    setTimeout(function() {
        closePopUp();
        document.kakao_form.action = "./logoutT.php";
        document.kakao_form.submit();
    }, 1000);

    //logout_();
}
</script>
</body>

</html>
<script>
	setTimeout("time()", 86400 * 31); // 60x60x24=86400
	//setTimeout("time()",  6400000 );
</script>
