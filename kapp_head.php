<?php
if (!defined('_KAPP_')) exit; // 개별 페이지 접근 불가

// KAPP 관리 no use
if (KAPP_IS_MOBILE) {
    // 모바일의 경우 설정을 따르지 않는다.
    include_once(KAPP_PATH_.'/_head.php');
	if($is_bo_content_head) {
		echo stripslashes($kapp['kapp_mobile_content_head']);
	}
} else {
    if(is_include_path_check($kapp['kapp_include_head'])) {  //파일경로 체크
        @include ($kapp['bo_include_head']);
    } else {    //파일경로가 올바르지 않으면 기본파일을 가져옴
        include_once(KAPP_PATH_.'/_head.php');
    }
	if($is_bo_content_head) {
	    echo stripslashes($board['bo_content_head']);
	}
}
?>