<?php
if (!defined('_KAPP_')) exit;

/*
    환경설정에서 에디터 선택이 없는 경우에 사용하는 라이브러리 입니다.
    에디터 선택시 "선택없음"이 아닌 경우 plugin/editor 하위 디렉토리의 각 에디터이름/editor.lib.php 를 수정하시기 바랍니다.
*/

function editor_html($id, $content)
{
    return "<textarea id=\"$id\" name=\"$id\" style=\"width:100%;\" maxlength=\"65536\">$content</textarea>";
}


// textarea 로 값을 넘긴다. javascript 반드시 필요
function get_editor_js($id)
{
    return "var {$id}_editor = document.getElementById('{$id}');\n";
}


//  textarea 의 값이 비어 있는지 검사
function chk_editor_js($id)
{
    return "if (!{$id}_editor.value) { alert(\"Please enter your details.\"); {$id}_editor.focus(); return false; }\n";//내용을 입력해 주세요.
}
?>