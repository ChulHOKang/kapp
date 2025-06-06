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

	  --- 이것을 알아야 하는 이유, 이것을 사용해야 하는 이유 ---
	  1. 이것은 나의 미래를 결정한다.
	  2. 이것은 나의 경쟁력이다.
	  3. 이것은 1시간이면 알수있고, 1주일이면 나도 전문가다
	  4. 이것은 나의 상상력을 펼치기 위한 필수 조건이다.
	  5. 이것을 아는것은 힘이요, 원동력이다.
	  --------------------------------------------------
	*/
	
	date_default_timezone_set("Asia/Seoul");
	$day		= date("Y-m-d H:i:s");
	if( isset($member['mb_id']) ){
		$H_ID = $member['mb_id'];  //get_session("ss_mb_id");  
		$H_LEV = $member['mb_level']; 
	}
	$ip    = $_SERVER['REMOTE_ADDR'];
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
	$sql = " SELECT * from {$tkher['tkher_my_control_table']} where userid='tkher' ";
	$ret = sql_query($sql);
	$rs  = sql_fetch_array($ret);
	$slide_time = $rs['slide_time'];
	if( !$slide_time ) $slide_time = $config['kapp_slide_time'];//$slide_time = 3000;
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
?>
</head>
<!-- <body onload = "re_exec()"> -->
<body>

    <div class="header">
        <?php include "./menu_run.php"; ?>

<?php
	if( get_session("urllink_login_type") == "" ){ 
		echo "<table><tr><td><img height='36' src='".KAPP_URL_T_ . "/icon/kakao.jpg' onclick='javascript:Kakao_Login_func()' title='A Kakao-Login:$day' />&nbsp;&nbsp;&nbsp;</td>";
        echo "<td><div id='buttonDiv' style='text-align: -webkit-center;' title='Google Login A'></div></td>";
        // 네이버 로그인 접근토큰 요청 modumodu.net 사용 $n_client_id = "O8g4b8tFHZem4UBvlfCP"; 
		$n_client_id = $config['kapp_naver_client_id']; // $config['kapp_naver_client_id'], $config['kapp_naver_client_secret'] , 7qW9YxPzy8 
        $redirectURI = urlencode("https://fation.net/kapp/login_checkT.php?mode=N_login");
        $state = "modumoa";
        $apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$n_client_id."&redirect_uri=".$redirectURI."&state=".$state;

        echo "<td><a id='naverIdLogin_loginButton' target='_top' href='".$apiURL."'><img src='./include/img/btnG_naver.png' /></a></td><tr></table>"; // 네이버 로그인

	} else if( get_session("urllink_login_type") == "Google") {
		echo "<table><tr><td><button onclick='GoogleLogout()' class=''>Google_LogOut</button></td><tr></table>";
	} else if( get_session("urllink_login_type") == "Google_Login_K") { // 임시 login_type
        echo "<table><tr><td><button onclick='GoogleLogout()' class=''>Google_LogOut</button></td><tr></table>";
	} else if (get_session("urllink_login_type") == "Kakao_Login_K") {
        echo "<table><tr><td><button onclick='KakaoLogout()' class=''>Kakao_LogOut</button></td><tr></table>";
    } else if (get_session("urllink_login_type") == "Naver_Login_K") {
        echo "<table><tr><td><button onclick='naverLogout()' class=''>Naver_LogOut</button></td><tr></table>";
    }
    if( !$gsajin ) { 
        if( isset($member['mb_photo']) ) $gsajin = $member['mb_photo']; 
		else $gsajin = KAPP_URL_T_ ."/logo/girl5.png";
    }
?>
        <h1>
            <a href="/kapp" target='_top' class="logo" title='development man'>
                <img src="<?=$gsajin?>" class="logo_web" style="opacity:0.3;" title="K-APP Home" />
            </a>
        </h1>
    </div><!-- end : header -->

    <div class="visualSlide"><?php echo $slide_msg; ?></div>

    <!-- <div class="subOrg">
    <h2 class="cmnSubj">ORGANIZATION</h2>
    <p class="cmnText">K-APP Organization</p>
    <div class="orgBox">
        <img src="./include/img/bg/bg_moa01.png" class="imgWeb" />
        <img src="./include/img/bg/bg_moa02.png" class="imgMo" />
    </div>
    <a href="javascript:common.openProj01()" class="btn_req" title="openProj01 --- ">
        <span>PROJECT REQUEST</span><img src="./include/img/ico/ico_arr01.png" />
    </a>
    </div> -->

    <!-- </div> -->
    <!-- end : container -->

    <?php
		include "footer_include.php";	
	?>

    <!-- </div> -->
    <!-- end : wrapper-->

    <?php
	//include_once "project_include.php";
	?>

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

/*
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
*/

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

    // popOpen:function(o){
    // 	$(o).show();
    // },
    // popClose:function(o){
    // 	$(o).hide();
    // }
}

$('.ftr_project').click(function() {
    $(".lnbArea").delay(200).stop().animate({
        "right": "0"
    }, 200, 'easeOutQuad');
})







function handleCredentialResponse(response) { // 로그인 완료
    const responsePayload = parseJwt(response.credential);

    /* console.log(responsePayload);
    return; */

    /* console.log(responsePayload);
    console.log("ID: " + responsePayload.sub);
    console.log('Full Name: ' + responsePayload.name);
    console.log('Given Name: ' + responsePayload.given_name);
    console.log('Family Name: ' + responsePayload.family_name);
    console.log("Image URL: " + responsePayload.picture);
    console.log("Email: " + responsePayload.email); */

    /* document.loginA.g_id.value = responsePayload.sub;
    document.loginA.g_email.value = responsePayload.email;
    document.loginA.g_fullname.value = responsePayload.name;
    document.loginA.g_image.value = responsePayload.picture; */

    /* document.loginA.action = "./loginX/index.php";
    document.loginA.target = "_self";
    document.loginA.mode.value = "G_login";
    document.loginA.submit(); */

    /* let email = responsePayload.email;
    let em = email.split("@");
    let e1 = em[0];
    let e2 = em[1]; */

    document.kakao_form.mode.value = "Google_Login_K";
    document.kakao_form.modeG.value = "Google";
    document.kakao_form.modeA.value = "member_set";
    /* document.kakao_form.gid.value = e1; //solpakan89
    document.kakao_form.gsite.value = e2; //gmail.com */

    //document.kakao_form.g_id.value = responsePayload.sub; // kapp_member 테이블에 사용되지 않음.
    document.kakao_form.g_email.value = responsePayload.email;
    document.kakao_form.g_fullname.value = responsePayload.name;
    document.kakao_form.g_image.value = responsePayload.picture;

    /* document.kakao_form.gemail.value = responsePayload.email;
    document.kakao_form.gname.value = responsePayload.name;
    document.kakao_form.gsajin.value = responsePayload.picture; */
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
        //client_id: "1050435465531-u82qqqcvt15tf7l1g4237ooujt8g2ulc.apps.googleusercontent.com", // kyj 계정
        //client_id: "57167996094-3af0su9i0i9atg53d2pq0kq3ula72p2n.apps.googleusercontent.com", // solpakan89 계정 (OAhth : modumodu.net) // 71자
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
    //alert("Logout");
    let g_email = '<?=$member['mb_id']?>';
    //console.log(g_email);

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
//setTimeout( "history.go(0);", 60000 );
setTimeout("time()", 86400 * 31); // 60x60x24=86400
//setTimeout("time()",  6400000 );
</script>