<?php

/********************
    상수 선언
********************/

define('KAPP_VERSION', ' K-APP GENERATOR ');
define('KAPP_Generator_VER', '1.0');

// 이 상수가 정의되지 않으면 각각의 개별 페이지는 별도로 실행될 수 없음
define('_KAPP_', true);

if (PHP_VERSION >= '5.1.0') {
    //if (function_exists("date_default_timezone_set")) date_default_timezone_set("Asia/Seoul");
    date_default_timezone_set("Asia/Seoul");
}

/********************
    경로 상수
********************/

/*
보안서버 도메인
회원가입, 글쓰기에 사용되는 https 로 시작되는 주소를 말합니다.
포트가 있다면 도메인 뒤에 :443 과 같이 입력하세요.
보안서버주소가 없다면 공란으로 두시면 되며 보안서버주소 뒤에 / 는 붙이지 않습니다.
입력예) https://www.domain.com:443/gnuboard5
*/
define('KAPP_DOMAIN', '');
define('KAPP_HTTPS_DOMAIN', '');

/*
www.sir.kr 과 sir.kr 도메인은 서로 다른 도메인으로 인식합니다. 쿠키를 공유하려면 .sir.kr 과 같이 입력하세요.
이곳에 입력이 없다면 www 붙은 도메인과 그렇지 않은 도메인은 쿠키를 공유하지 않으므로 로그인이 풀릴 수 있습니다.
*/
define('KAPP_COOKIE_DOMAIN',  '');

//define('KAPP_DBCONFIG_FILE',  'dbconfig.php');
define('KAPP_DBCONFIG_FILE',  'KAPP_dbconfig.php');

define('KAPP_ADMIN_DIR',      'adm');
define('KAPP_BBS_DIR',        'bbs');
define('KAPP_CSS_DIR',        'css');
define('KAPP_DATA_DIR',       'data');
define('KAPP_EXTEND_DIR',     'extend');
define('KAPP_IMG_DIR',        'img');
define('KAPP_JS_DIR',         'js');
define('KAPP_LIB_DIR',        'lib');
define('KAPP_PLUGIN_DIR',     'plugin');
define('KAPP_SKIN_DIR',       'skin');
define('KAPP_CAPTCHA_DIR',    'kcaptcha');
define('KAPP_EDITOR_DIR',     'editor');
define('KAPP_MOBILE_DIR',     'mobile');
define('KAPP_OKNAME_DIR',     'okname');

define('KAPP_KCPCERT_DIR',    'kcpcert');
define('KAPP_LGXPAY_DIR',     'lgxpay');

define('KAPP_SNS_DIR',        'sns');
define('KAPP_SYNDI_DIR',      'syndi');
define('KAPP_PHPMAILER_DIR',  'PHPMailer');
define('KAPP_SESSION_DIR',    'session');
define('KAPP_THEME_DIR',      'theme');

// URL 은 브라우저상에서의 경로 (도메인으로 부터의)
if (KAPP_DOMAIN) {
    define('KAPP_URL', KAPP_DOMAIN);
} else {
    if (isset($KAPP_path['url']))
        define('KAPP_URL', $KAPP_path['url']);
    else
        define('KAPP_URL', '');
}

if (isset($KAPP_path['path'])) {
    define('KAPP_PATH', $KAPP_path['path']);
} else {
    define('KAPP_PATH', '');
}

define('KAPP_ADMIN_URL',      KAPP_URL.'/'.KAPP_ADMIN_DIR);
define('KAPP_BBS_URL',        KAPP_URL.'/'.KAPP_BBS_DIR);
define('KAPP_CSS_URL',        KAPP_URL.'/'.KAPP_CSS_DIR);
define('KAPP_DATA_URL',       KAPP_URL.'/'.KAPP_DATA_DIR);
define('KAPP_IMG_URL',        KAPP_URL.'/'.KAPP_IMG_DIR);
define('KAPP_JS_URL',         KAPP_URL.'/'.KAPP_JS_DIR);
define('KAPP_SKIN_URL',       KAPP_URL.'/'.KAPP_SKIN_DIR);
define('KAPP_PLUGIN_URL',     KAPP_URL.'/'.KAPP_PLUGIN_DIR);
define('KAPP_CAPTCHA_URL',    KAPP_PLUGIN_URL.'/'.KAPP_CAPTCHA_DIR);
define('KAPP_EDITOR_URL',     KAPP_PLUGIN_URL.'/'.KAPP_EDITOR_DIR);
define('KAPP_OKNAME_URL',     KAPP_PLUGIN_URL.'/'.KAPP_OKNAME_DIR);
define('KAPP_KCPCERT_URL',    KAPP_PLUGIN_URL.'/'.KAPP_KCPCERT_DIR);
define('KAPP_LGXPAY_URL',     KAPP_PLUGIN_URL.'/'.KAPP_LGXPAY_DIR);
define('KAPP_SNS_URL',        KAPP_PLUGIN_URL.'/'.KAPP_SNS_DIR);
define('KAPP_SYNDI_URL',      KAPP_PLUGIN_URL.'/'.KAPP_SYNDI_DIR);
define('KAPP_MOBILE_URL',     KAPP_URL.'/'.KAPP_MOBILE_DIR);

// PATH 는 서버상에서의 절대경로
define('KAPP_ADMIN_PATH',     KAPP_PATH.'/'.KAPP_ADMIN_DIR);
define('KAPP_BBS_PATH',       KAPP_PATH.'/'.KAPP_BBS_DIR);
define('KAPP_DATA_PATH',      KAPP_PATH.'/'.KAPP_DATA_DIR);
define('KAPP_EXTEND_PATH',    KAPP_PATH.'/'.KAPP_EXTEND_DIR);
define('KAPP_LIB_PATH',       KAPP_PATH.'/'.KAPP_LIB_DIR);
define('KAPP_PLUGIN_PATH',    KAPP_PATH.'/'.KAPP_PLUGIN_DIR);
define('KAPP_SKIN_PATH',      KAPP_PATH.'/'.KAPP_SKIN_DIR);
define('KAPP_MOBILE_PATH',    KAPP_PATH.'/'.KAPP_MOBILE_DIR);
define('KAPP_SESSION_PATH',   KAPP_DATA_PATH.'/'.KAPP_SESSION_DIR);
define('KAPP_CAPTCHA_PATH',   KAPP_PLUGIN_PATH.'/'.KAPP_CAPTCHA_DIR);
define('KAPP_EDITOR_PATH',    KAPP_PLUGIN_PATH.'/'.KAPP_EDITOR_DIR);
define('KAPP_OKNAME_PATH',    KAPP_PLUGIN_PATH.'/'.KAPP_OKNAME_DIR);

define('KAPP_KCPCERT_PATH',   KAPP_PLUGIN_PATH.'/'.KAPP_KCPCERT_DIR);
define('KAPP_LGXPAY_PATH',    KAPP_PLUGIN_PATH.'/'.KAPP_LGXPAY_DIR);

define('KAPP_SNS_PATH',       KAPP_PLUGIN_PATH.'/'.KAPP_SNS_DIR);
define('KAPP_SYNDI_PATH',     KAPP_PLUGIN_PATH.'/'.KAPP_SYNDI_DIR);
define('KAPP_PHPMAILER_PATH', KAPP_PLUGIN_PATH.'/'.KAPP_PHPMAILER_DIR);
//==============================================================================


//==============================================================================
// 사용기기 설정
// pc 설정 시 모바일 기기에서도 PC화면 보여짐
// mobile 설정 시 PC에서도 모바일화면 보여짐
// both 설정 시 접속 기기에 따른 화면 보여짐
//------------------------------------------------------------------------------
define('KAPP_SET_DEVICE', 'both');

define('KAPP_USE_MOBILE', true); // 모바일 홈페이지를 사용하지 않을 경우 false 로 설정
define('KAPP_USE_CACHE',  true); // 최신글등에 cache 기능 사용 여부


/********************
    시간 상수
********************/
// 서버의 시간과 실제 사용하는 시간이 틀린 경우 수정하세요.
// 하루는 86400 초입니다. 1시간은 3600초
// 6시간이 빠른 경우 time() + (3600 * 6);
// 6시간이 느린 경우 time() - (3600 * 6);
define('KAPP_SERVER_TIME',    time());
define('KAPP_TIME_YMDHIS',    date('Y-m-d H:i:s', KAPP_SERVER_TIME));
define('KAPP_TIME_YMD',       substr(KAPP_TIME_YMDHIS, 0, 10));
define('KAPP_TIME_HIS',       substr(KAPP_TIME_YMDHIS, 11, 8));

// 입력값 검사 상수 (숫자를 변경하시면 안됩니다.)
define('KAPP_ALPHAUPPER',      1); // 영대문자
define('KAPP_ALPHALOWER',      2); // 영소문자
define('KAPP_ALPHABETIC',      4); // 영대,소문자
define('KAPP_NUMERIC',         8); // 숫자
define('KAPP_HANGUL',         16); // 한글
define('KAPP_SPACE',          32); // 공백
define('KAPP_SPECIAL',        64); // 특수문자

// 퍼미션
define('KAPP_DIR_PERMISSION',  0755); // 디렉토리 생성시 퍼미션
define('KAPP_FILE_PERMISSION', 0644); // 파일 생성시 퍼미션

// 모바일 인지 결정 $_SERVER['HTTP_USER_AGENT']
define('KAPP_MOBILE_AGENT',   'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|android|sony');

// SMTP
// lib/mailer.lib.php 에서 사용
define('KAPP_SMTP',      '127.0.0.1');
define('KAPP_SMTP_PORT', '25');


/********************
    기타 상수
********************/

// 암호화 함수 지정
// 사이트 운영 중 설정을 변경하면 로그인이 안되는 등의 문제가 발생합니다.
define('KAPP_STRING_ENCRYPT_FUNCTION', 'sql_password');

// SQL 에러를 표시할 것인지 지정
// 에러를 표시하려면 TRUE 로 변경
define('KAPP_DISPLAY_SQL_ERROR', FALSE);

// escape string 처리 함수 지정
// addslashes 로 변경 가능
define('KAPP_ESCAPE_FUNCTION', 'sql_escape_string');

// sql_escape_string 함수에서 사용될 패턴
//define('KAPP_ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');
//define('KAPP_ESCAPE_REPLACE',  '');

// 게시판에서 링크의 기본개수를 말합니다.
// 필드를 추가하면 이 숫자를 필드수에 맞게 늘려주십시오.
define('KAPP_LINK_COUNT', 2);

// 썸네일 jpg Quality 설정
define('KAPP_THUMB_JPG_QUALITY', 90);

// 썸네일 png Compress 설정
define('KAPP_THUMB_PNG_COMPRESS', 5);

// 모바일 기기에서 DHTML 에디터 사용여부를 설정합니다.
define('KAPP_IS_MOBILE_DHTML_USE', false);

// MySQLi 사용여부를 설정합니다.
define('KAPP_MYSQLI_USE', true);

// Browscap 사용여부를 설정합니다.
define('KAPP_BROWSCAP_USE', true);

// 접속자 기록 때 Browscap 사용여부를 설정합니다.
define('KAPP_VISIT_BROWSCAP_USE', false);

// ip 숨김방법 설정
/* 123.456.789.012 ip의 숨김 방법을 변경하는 방법은
\\1 은 123, \\2는 456, \\3은 789, \\4는 012에 각각 대응되므로
표시되는 부분은 \\1 과 같이 사용하시면 되고 숨길 부분은 ♡등의
다른 문자를 적어주시면 됩니다.
*/
define('KAPP_IP_DISPLAY', '\\1.♡.\\3.\\4');

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {   //https 통신일때 daum 주소 js
    define('KAPP_POSTCODE_JS', '<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>');
} else {  //http 통신일때 daum 주소 js
    define('KAPP_POSTCODE_JS', '<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>');
}
?>