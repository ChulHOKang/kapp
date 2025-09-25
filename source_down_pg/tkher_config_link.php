<?php

/* -------------------------------------------------------
   tkher_config_link.php : tkher_config.php TKHER  상수 선언
   call : tkher_db_lib.php
------------------------------------------------------- */
define('TKHER_VERSION_', 'TKHER_V1');
define('TKHER_TREE_VER_', '3.1');
define('TKHER_NOTE_VER_', '3.1');
define('TKHER_BOARD_VER_', '3.1');
define('TKHER_PROGRAM_VER_', '3.5');
define('TKHER_URLLINKCOIN_VER_', '3.5');
define('TKHER_BATCOIN_VER_', '3.1');
define('_TKHER_', true);

if (PHP_VERSION >= '5.1.0') {
    if (function_exists("date_default_timezone_set")) date_default_timezone_set("Asia/Seoul");
}

/* ------------------------
    경로 상수
------------------------ */

/* -------------------------------------------------------------
보안서버 도메인
포트가 있다면 도메인 뒤에 :88 입력.
보안서버주소가 없다면 공란으로 두시면 되며 보안서버주소 뒤에 / 는 붙이지 않습니다.
입력예) https://domain.com:88/tkher
------------------------------------------------------------- */
define('TKHER_DOMAIN', '');
define('TKHER_HTTPS_DOMAIN', '');

/*
www.tkher.com and tkher.com  쿠키를 공유하려면 tkher.comr 과 같이 입력하세요.
*/
define('TKHER_COOKIE_DOMAIN',  '');
define('TKHER_DATA_DIR',       '');

define('TKHER_CSS_DIR',        'include/css');
define('TKHER_IMG_DIR',        'include/img');
define('TKHER_TJS_DIR',         'include/tjs');
define('TKHER_JS_DIR',         'include/js');
define('TKHER_LIB_DIR',        'include/lib');

define('TKHER_PLUGIN_DIR',     '');
define('TKHER_SKIN_DIR',        '');
define('TKHER_CAPTCHA_DIR',    'kcaptcha');
define('TKHER_MOBILE_DIR',     'mobile');
define('TKHER_SESSION_DIR',    '');

// URL 은 브라우저상에서의 경로 (도메인으로 부터의)
if (TKHER_DOMAIN) {
    define('TKHER_URL', TKHER_DOMAIN);
} else {
    if (isset($tkher_path['url']))
        define('TKHER_URL', $tkher_path['url']);
    else
        define('TKHER_URL', '');
}

if (isset($tkher_path['path'])) {
    define('TKHER_PATH', $tkher_path['path']);
} else {
    define('TKHER_PATH', '');
}
//define('TKHER_ADMIN_URL',      TKHER_URL.'/'.TKHER_ADMIN_DIR);
define('TKHER_CSS_URL',        TKHER_URL.'/'.TKHER_CSS_DIR);
define('TKHER_DATA_URL',       './' );
define('TKHER_IMG_URL',        TKHER_URL.'/'.TKHER_IMG_DIR);
define('TKHER_JS_URL',         TKHER_URL.'/'.TKHER_JS_DIR);
define('TKHER_PLUGIN_URL',     './' );

define('TKHER_CAPTCHA_URL',    TKHER_PLUGIN_URL.'/'.TKHER_CAPTCHA_DIR);
define('TKHER_MOBILE_URL',     TKHER_URL.'/'.TKHER_MOBILE_DIR);

// PATH 는 서버상에서의 절대경로
define('TKHER_DATA_PATH',      './' );
define('TKHER_LIB_PATH',       TKHER_PATH.'/'.TKHER_LIB_DIR);
define('TKHER_PLUGIN_PATH',    './'  );
define('TKHER_MOBILE_PATH',    TKHER_PATH.'/'.TKHER_MOBILE_DIR);
define('TKHER_SESSION_PATH',   './' );
define('TKHER_CAPTCHA_PATH',   TKHER_PLUGIN_PATH.'/'.TKHER_CAPTCHA_DIR);
//define('TKHER_PHPMAILER_PATH', TKHER_PLUGIN_PATH.'/'.TKHER_PHPMAILER_DIR);
//==============================================================================


//==============================================================================
// 사용기기 설정
// pc 설정 시 모바일 기기에서도 PC화면 보여짐
// mobile 설정 시 PC에서도 모바일화면 보여짐
// both 설정 시 접속 기기에 따른 화면 보여짐
//------------------------------------------------------------------------------
define('TKHER_SET_DEVICE', 'both');
define('TKHER_USE_MOBILE', true); // 모바일 홈페이지를 사용하지 않을 경우 false 로 설정
define('TKHER_USE_CACHE',  true); // 최신글등에 cache 기능 사용 여부


/********************
    시간 상수
********************/
define('TKHER_SERVER_TIME',    time());
define('TKHER_TIME_YMDHIS',    date('Y-m-d H:i:s', TKHER_SERVER_TIME));
define('TKHER_TIME_YMD',       substr(TKHER_TIME_YMDHIS, 0, 10));
define('TKHER_TIME_HIS',       substr(TKHER_TIME_YMDHIS, 11, 8));

// 입력값 검사 상수 (숫자를 변경하시면 안됩니다.)
define('TKHER_ALPHAUPPER',      1); // 영대문자
define('TKHER_ALPHALOWER',      2); // 영소문자
define('TKHER_ALPHABETIC',      4); // 영대,소문자
define('TKHER_NUMERIC',         8); // 숫자
define('TKHER_HANGUL',         16); // 한글
define('TKHER_SPACE',          32); // 공백
define('TKHER_SPECIAL',        64); // 특수문자

// 퍼미션
define('TKHER_DIR_PERMISSION',  0755); // 디렉토리 생성시 퍼미션
define('TKHER_FILE_PERMISSION', 0644); // 파일 생성시 퍼미션

// 모바일 인지 결정 $_SERVER['HTTP_USER_AGENT']
define('TKHER_MOBILE_AGENT',   'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|android|sony');

/********************
    기타 상수
********************/

// 암호화 함수 지정
// 사이트 운영 중 설정을 변경하면 로그인이 안되는 등의 문제가 발생합니다.
define('TKHER_STRING_ENCRYPT_FUNCTION', 'sql_password');

// SQL 에러를 표시할 것인지 지정
// 에러를 표시하려면 TRUE 로 변경, FALSE
define('TKHER_DISPLAY_SQL_ERROR', TRUE);

// escape string 처리 함수 지정
// addslashes 로 변경 가능
define('TKHER_ESCAPE_FUNCTION', 'sql_escape_string');

// sql_escape_string 함수에서 사용될 패턴
//define('TKHER_ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');
//define('TKHER_ESCAPE_REPLACE',  '');

// 썸네일 jpg Quality 설정
define('TKHER_THUMB_JPG_QUALITY', 90);

// 썸네일 png Compress 설정
define('TKHER_THUMB_PNG_COMPRESS', 5);

// 모바일 기기에서 DHTML 에디터 사용여부를 설정합니다.
define('TKHER_IS_MOBILE_DHTML_USE', false);

// MySQLi 사용여부를 설정합니다.
define('TKHER_MYSQLI_USE', true);

// Browscap 사용여부를 설정합니다.
define('TKHER_BROWSCAP_USE', true);

// 접속자 기록 때 Browscap 사용여부를 설정합니다.
define('TKHER_VISIT_BROWSCAP_USE', false);

// ip 숨김방법 설정
/* 123.456.789.099 ip의 숨김 방법을 변경하는 방법은
\\1 은 123, \\2는 456, \\3은 789, \\4는 099에 각각 대응되므로
표시되는 부분은 \\1 과 같이 사용하시면 되고 숨길 부분은 ♡등의
다른 문자를 적어주시면 됩니다.
*/
define('TKHER_IP_DISPLAY', '\\1.\\2.♡.\\4');
/*
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {   //https 통신일때 daum 주소 js
    define('TKHER_POSTCODE_JS', '<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>');
} else {  //http 통신일때 daum 주소 js
    define('TKHER_POSTCODE_JS', '<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>');
}*/
?>