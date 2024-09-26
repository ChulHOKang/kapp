<?php
if( !defined('_KAPP_')) exit;

/*************************************************************************
**  GNU														참조.
*************************************************************************/

// 마이크로 타임을 얻어 계산 형식으로 만듦
function get_microtime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

// 변수 또는 배열의 이름과 값을 얻어냄. print_r() 함수의 변형
function print_r2($var)
{
    ob_start();
    print_r($var);
    $str = ob_get_contents();
    ob_end_clean();
    $str = str_replace(" ", "&nbsp;", $str);
    echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
}


// 메타태그를 이용한 URL 이동
// header("location:URL") 을 대체
function goto_url($url)
{
        //echo "<script>alert('111111 url:$url');</script>";
    $url = str_replace("&amp;", "&", $url);
    //echo "<script>window.open('$url', '_blank', '');</script>";
	echo "<script> top.location.replace('$url'); </script>";//

    if (!headers_sent()){
        //echo "<script>alert('Have Good Time!');</script>";exit;  여기온다.
        header('Location: '.$url);
	}
    else {
        //echo "<script>alert('-------------333333333333 url:');</script>";exit;

		echo '<script>';
        echo 'location.replace("'.$url.'");';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }
    exit;
}


// 세션변수 생성 
function set_session($session_name, $value)
{
    if (PHP_VERSION < '5.3.0')
        session_register($session_name);
    // PHP 버전별 차이를 없애기 위한 방법
    $$session_name = $_SESSION[$session_name] = $value;
    //$session_name = $_SESSION[$session_name] = $value;
}

// 세션변수값 얻음
function get_session($session_name)
{
    return isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : '';
}


// 쿠키변수 생성
function set_cookie($cookie_name, $value, $expire)
{
    global $tkher;

    setcookie(md5($cookie_name), base64_encode($value), KAPP_SERVER_TIME + $expire, '/', KAPP_COOKIE_DOMAIN);
}

function get_cookie($cookie_name)
{
    $cookie = md5($cookie_name);
    if (array_key_exists($cookie, $_COOKIE))
        return base64_decode($_COOKIE[$cookie]);
    else
        return "";
}

function alert($msg='', $url='', $error=true, $post=false)
{
    global $tkher, $config, $member;
    global $is_admin;

    if (!$msg) $msg = 'Please use it in the correct way. alert';//올바른 방법으로 이용해 주십시오.

    $header = '';
    if (isset($tkher['title'])) {
        $header = $tkher['title'];
    }
	m_(" alert : $msg");
}


function alert_close($msg, $error=true)
{
    global $tkher;

    $header = '';
    if (isset($tkher['title'])) {
        $header = $tkher['title'];
    }
}

// confirm 창
function confirm($msg, $url1='', $url2='', $url3='')
{
    global $tkher;

    if (!$msg) {
        $msg = 'Please use it in the correct way. confirm';//올바른 방법으로 이용해 주십시오.
        alert($msg);
    }

    if(!trim($url1) || !trim($url2)) {
        $msg = '$url1 과 $url2 를 지정해 주세요.';
        alert($msg);
    }

    if (!$url3) $url3 = clean_xss_tags($_SERVER['HTTP_REFERER']);

    $msg = str_replace("\\n", "<br>", $msg);

    $header = '';
    if (isset($tkher['title'])) {
        $header = $tkher['title'];
    }
    include_once(KAPP_PATH_T_.'/confirm.php');
    exit;
}

function url_auto_link($str)
{
    global $tkher;
    global $config;

    $str = str_replace(array("&lt;", "&gt;", "&amp;", "&quot;", "&nbsp;", "&#039;"), array("\t_lt_\t", "\t_gt_\t", "&", "\"", "\t_nbsp_\t", "'"), $str);
    $str = preg_replace("/([^(href=\"?'?)|(src=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#!=_\?\/~\+%@;\-\|\,\(\)]+)/i", "\\1<A HREF=\"\\2\" TARGET=\"{$config['kapp_link_target']}\">\\2</A>", $str);
    $str = preg_replace("/(^|[\"'\s(])(www\.[^\"'\s()]+)/i", "\\1<A HREF=\"http://\\2\" TARGET=\"{$config['kapp_link_target']}\">\\2</A>", $str);
    $str = preg_replace("/[0-9a-z_-]+@[a-z0-9._-]{4,}/i", "<a href=\"mailto:\\0\">\\0</a>", $str);
    $str = str_replace(array("\t_nbsp_\t", "\t_lt_\t", "\t_gt_\t", "'"), array("&nbsp;", "&lt;", "&gt;", "&#039;"), $str);
    return $str;
}


function get_filesize($size)
{
    //$size = @filesize(addslashes($file));
    if ($size >= 1048576) {
        $size = number_format($size/1048576, 1) . "M";
    } else if ($size >= 1024) {
        $size = number_format($size/1024, 1) . "K";
    } else {
        $size = number_format($size, 0) . "byte";
    }
    return $size;
}


function get_dirsize($dir)
{
    $size = 0;
    $d = dir($dir);
    while ($entry = $d->read()) {
        if ($entry != '.' && $entry != '..') {
            $size += filesize($dir.'/'.$entry);
        }
    }
    $d->close();
    return $size;
}

// 제목을 변환
function conv_subject($subject, $len, $suffix='')
{
    return get_text(cut_str($subject, $len, $suffix));
}

// 내용을 변환
function conv_content($content, $html, $filter=true)
{
    global $config, $board;

    if ($html)
    {
        $source = array();
        $target = array();

        $source[] = "//";
        $target[] = "";

        if ($html == 2) { // 자동 줄바꿈
            $source[] = "/\n/";
            $target[] = "<br/>";
        }

        // 테이블 태그의 개수를 세어 테이블이 깨지지 않도록 한다.
        $table_begin_count = substr_count(strtolower($content), "<table");
        $table_end_count = substr_count(strtolower($content), "</table");
        for ($i=$table_end_count; $i<$table_begin_count; $i++)
        {
            $content .= "</table>";
        }

        $content = preg_replace($source, $target, $content);

        if($filter)
            $content = html_purifier($content);
    }
    else // text 이면
    {
        // & 처리 : &amp; &nbsp; 등의 코드를 정상 출력함
        $content = html_symbol($content);

        // 공백 처리
		//$content = preg_replace("/  /", "&nbsp; ", $content);
		$content = str_replace("  ", "&nbsp; ", $content);
		$content = str_replace("\n ", "\n&nbsp;", $content);

        $content = get_text($content, 1);
        $content = url_auto_link($content);
    }

    return $content;
}
function html_purifier($html)
{
    $f = file(KAPP_PLUGIN_PATH.'/htmlpurifier/safeiframe.txt');
    $domains = array();
    foreach($f as $domain){
        // 첫행이 # 이면 주석 처리
        if (!preg_match("/^#/", $domain)) {
            $domain = trim($domain);
            if ($domain)
                array_push($domains, $domain);
        }
    }
    // 내 도메인도 추가
    array_push($domains, $_SERVER['HTTP_HOST'].'/');
    $safeiframe = implode('|', $domains);

    include_once(KAPP_PLUGIN_PATH.'/htmlpurifier/HTMLPurifier.standalone.php');
    $config = HTMLPurifier_Config::createDefault();
    // data/cache 디렉토리에 CSS, HTML, URI 디렉토리 등을 만든다.
    $config->set('Cache.SerializerPath', KAPP_DATA_PATH.'/cache');
    $config->set('HTML.SafeEmbed', false);
    $config->set('HTML.SafeObject', false);
    $config->set('Output.FlashCompat', false);
    $config->set('HTML.SafeIframe', true);
    $config->set('URI.SafeIframeRegexp','%^(https?:)?//('.$safeiframe.')%');
    $config->set('Attr.AllowedFrameTargets', array('_blank'));
    $purifier = new HTMLPurifier($config);
    return $purifier->purify($html);
}

// 회원 정보를 얻는다. login_checkT.php -------
function get_member_login($mb_id, $table)
{
    global $tkher;

    return sql_fetch(" SELECT * from {$table} where mb_id = TRIM('$mb_id') ");
}
function get_member($mb_id, $fields='*')
{
    global $tkher;
    return sql_fetch(" select $fields from {$tkher['tkher_member_table']} where mb_id = TRIM('$mb_id') ");
}
// 날짜, 조회수의 경우 높은 순서대로 보여져야 하므로 $flag 를 추가
// $flag : asc 낮은 순서 , desc 높은 순서
// 제목별로 컬럼 정렬하는 QUERY STRING
function subject_sort_link($col, $query_string='', $flag='asc')
{
    global $sst, $sod, $sfl, $stx, $page, $sca;

    $q1 = "sst=$col";
    if ($flag == 'asc')
    {
        $q2 = 'sod=asc';
        if ($sst == $col)
        {
            if ($sod == 'asc')
            {
                $q2 = 'sod=desc';
            }
        }
    }
    else
    {
        $q2 = 'sod=desc';
        if ($sst == $col)
        {
            if ($sod == 'desc')
            {
                $q2 = 'sod=asc';
            }
        }
    }

    $arr_query = array();
    $arr_query[] = $query_string;
    $arr_query[] = $q1;
    $arr_query[] = $q2;
    $arr_query[] = 'sfl='.$sfl;
    $arr_query[] = 'stx='.$stx;
    $arr_query[] = 'sca='.$sca;
    $arr_query[] = 'page='.$page;
    $qstr = implode("&amp;", $arr_query);

    return "<a href=\"{$_SERVER['SCRIPT_NAME']}?{$qstr}\">";
}


// 관리자 정보를 얻음
function get_admin($admin='super', $fields='*')
{
    global $config, $group, $board;
    global $tkher;

    $is = false;
    if ($admin == 'board') {
        $mb = sql_fetch("select {$fields} from {$tkher['tkher_member_table']} where mb_id in ('{$board['bo_admin']}') limit 1 ");
        $is = true;
    }

    if (($is && !$mb['mb_id']) || $admin == 'group') {
        $mb = sql_fetch("select {$fields} from {$tkher['tkher_member_table']} where mb_id in ('{$group['gr_admin']}') limit 1 ");
        $is = true;
    }

    if (($is && !$mb['mb_id']) || $admin == 'super') {
        $mb = sql_fetch("select {$fields} from {$tkher['tkher_member_table']} where mb_id in ('{$config['kapp_admin']}') limit 1 ");
    }

    return $mb;
}


// 관리자인가?
function is_admin($mb_id)
{
    global $config, $group, $board;

    if (!$mb_id) return;

    if ($config['kapp_admin'] == $mb_id) return 'super';
    if (isset($group['gr_admin']) && ($group['gr_admin'] == $mb_id)) return 'group';
    if (isset($board['bo_admin']) && ($board['bo_admin'] == $mb_id)) return 'board';
    return '';
}

function option_selected($value, $selected, $text='')
{
    if (!$text) $text = $value;
    if ($value == $selected)
        return "<option value=\"$value\" selected=\"selected\">$text</option>\n";
    else
        return "<option value=\"$value\">$text</option>\n";
}
// appgenerator 포인트 부여
function insert_point_appX($mb_id, $point, $content='', $rel_table='', $rel_id='', $rel_action='', $expire=0)
{
    global $config;
    global $tkher;
    global $is_admin;
    global $member;

    if (!$config['kapp_use_point']) { return 0; }
    if ($point == 0) { return 0; }
    if ($mb_id == '') { return 0; }
    $mb = sql_fetch(" select mb_id, mb_point from {$tkher['tkher_member_table']} where mb_id = '$mb_id' ");
    if (!$mb['mb_id']) { return 0; }

    $mb_point = $mb['mb_point'];//$member['mb_point'];
    $po_mb_point = $mb_point + $point;

	// 포인트 UPDATE
    $sql = " update {$tkher['tkher_member_table']} set mb_point = mb_point + $point where mb_id = '$mb_id' ";
    sql_queryG($sql);


    // 포인트 건별 생성
    $po_expire_date = '9999-12-31';
    $po_expired = 0;

    $sql = " insert into {$tkher['point_table']}
                set mb_id         = '$mb_id',
                    po_datetime   = '".KAPP_TIME_YMDHIS."',
                    po_content    = '" . $content . "',     
                    po_point      = '$point',
                    po_use_point  = '0',
                    po_mb_point   = '$po_mb_point',
                    po_expired    = '$po_expired',
                    po_expire_date= '$po_expire_date',
                    po_rel_table  = '$rel_table',
                    po_rel_id     = '$rel_id',
                    po_rel_action = '$rel_action' ";
    sql_queryG($sql);

    // 포인트를 사용한 경우 포인트 내역에 사용금액 기록
    //if($point < 0) {
     //   insert_use_point($mb_id, $point);
    //}


    return 1;
}
// 포인트 부여
function insert_point($mb_id, $point, $content='', $rel_table='', $rel_id='', $rel_action='', $expire=0)
{
    global $config;
    global $tkher;
    global $is_admin;

    // 포인트 사용을 하지 않는다면 return
    if (!$config['kapp_use_point']) { return 0; }

    // 포인트가 없다면 업데이트 할 필요 없음
    if ($point == 0) { return 0; }

    // 회원아이디가 없다면 업데이트 할 필요 없음
    if ($mb_id == '') { return 0; }
    $mb = sql_fetch(" select mb_id from {$tkher['tkher_member_table']} where mb_id = '$mb_id' ");
    if (!$mb['mb_id']) { return 0; }

    // 회원포인트
    $mb_point = get_point_sum($mb_id);

    // 이미 등록된 내역이라면 건너뜀
    if ($rel_table || $rel_id || $rel_action)
    {
        $sql = " select count(*) as cnt from {$tkher['point_table']}
                  where mb_id = '$mb_id'
                    and po_rel_table = '$rel_table'
                    and po_rel_id = '$rel_id'
                    and po_rel_action = '$rel_action' ";
        $row = sql_fetch($sql);
        if ($row['cnt'])
            return -1;
    }

    // 포인트 건별 생성
    $po_expire_date = '9999-12-31';
    if($config['kapp_point_term'] > 0) {
        if($expire > 0)
            $po_expire_date = date('Y-m-d', strtotime('+'.($expire - 1).' days', KAPP_SERVER_TIME));
        else
            $po_expire_date = date('Y-m-d', strtotime('+'.($config['kapp_point_term'] - 1).' days', KAPP_SERVER_TIME));
    }

    $po_expired = 0;
    if($point < 0) {
        $po_expired = 1;
        $po_expire_date = KAPP_TIME_YMD;
    }
    $po_mb_point = $mb_point + $point;

    $sql = " insert into {$tkher['point_table']}
                set mb_id = '$mb_id',
                    po_datetime = '".KAPP_TIME_YMDHIS."',
                    po_content = '".addslashes($content)."',
                    po_point = '$point',
                    po_use_point = '0',
                    po_mb_point = '$po_mb_point',
                    po_expired = '$po_expired',
                    po_expire_date = '$po_expire_date',
                    po_rel_table = '$rel_table',
                    po_rel_id = '$rel_id',
                    po_rel_action = '$rel_action' ";
    sql_queryG($sql);

    // 포인트를 사용한 경우 포인트 내역에 사용금액 기록
    if($point < 0) {
        insert_use_point($mb_id, $point);
    }

    // 포인트 UPDATE
    $sql = " update {$tkher['tkher_member_table']} set mb_point = '$po_mb_point' where mb_id = '$mb_id' ";
    sql_queryG($sql);

    return 1;
}

// 사용포인트 입력
function insert_use_point($mb_id, $point, $po_id='')
{
    global $tkher, $config;

    if($config['kapp_point_term'])
        $sql_order = " order by po_expire_date asc, po_id asc ";
    else
        $sql_order = " order by po_id asc ";

    $point1 = abs($point);
    $sql = " select po_id, po_point, po_use_point
                from {$tkher['point_table']}
                where mb_id = '$mb_id'
                  and po_id <> '$po_id'
                  and po_expired = '0'
                  and po_point > po_use_point
                $sql_order ";
    $result = sql_queryG($sql);
    for($i=0; $row=sql_fetch_arrayG($result); $i++) {
        $point2 = $row['po_point'];
        $point3 = $row['po_use_point'];

        if(($point2 - $point3) > $point1) {
            $sql = " update {$tkher['point_table']}
                        set po_use_point = po_use_point + '$point1'
                        where po_id = '{$row['po_id']}' ";
            sql_queryG($sql);
            break;
        } else {
            $point4 = $point2 - $point3;
            $sql = " update {$tkher['point_table']}
                        set po_use_point = po_use_point + '$point4',
                            po_expired = '100'
                        where po_id = '{$row['po_id']}' ";
            sql_queryG($sql);
            $point1 -= $point4;
        }
    }
}

// 사용포인트 삭제
function delete_use_point($mb_id, $point)
{
    global $tkher, $config;

    if($config['kapp_point_term'])
        $sql_order = " order by po_expire_date desc, po_id desc ";
    else
        $sql_order = " order by po_id desc ";

    $point1 = abs($point);
    $sql = " select po_id, po_use_point, po_expired, po_expire_date
                from {$tkher['point_table']}
                where mb_id = '$mb_id'
                  and po_expired <> '1'
                  and po_use_point > 0
                $sql_order ";
    $result = sql_queryG($sql);
    for($i=0; $row=sql_fetch_arrayG($result); $i++) {
        $point2 = $row['po_use_point'];

        $po_expired = $row['po_expired'];
        if($row['po_expired'] == 100 && ($row['po_expire_date'] == '9999-12-31' || $row['po_expire_date'] >= KAPP_TIME_YMD))
            $po_expired = 0;

        if($point2 > $point1) {
            $sql = " update {$tkher['point_table']}
                        set po_use_point = po_use_point - '$point1',
                            po_expired = '$po_expired'
                        where po_id = '{$row['po_id']}' ";
            sql_queryG($sql);
            break;
        } else {
            $sql = " update {$tkher['point_table']}
                        set po_use_point = '0',
                            po_expired = '$po_expired'
                        where po_id = '{$row['po_id']}' ";
            sql_queryG($sql);

            $point1 -= $point2;
        }
    }
}

// 소멸포인트 삭제
function delete_expire_point($mb_id, $point)
{
    global $tkher, $config;

    $point1 = abs($point);
    $sql = " select po_id, po_use_point, po_expired, po_expire_date
                from {$tkher['point_table']}
                where mb_id = '$mb_id'
                  and po_expired = '1'
                  and po_point >= 0
                  and po_use_point > 0
                order by po_expire_date desc, po_id desc ";
    $result = sql_queryG($sql);
    for($i=0; $row=sql_fetch_arrayG($result); $i++) {
        $point2 = $row['po_use_point'];
        $po_expired = '0';
        $po_expire_date = '9999-12-31';
        if($config['kapp_point_term'] > 0)
            $po_expire_date = date('Y-m-d', strtotime('+'.($config['kapp_point_term'] - 1).' days', KAPP_SERVER_TIME));

        if($point2 > $point1) {
            $sql = " update {$tkher['point_table']}
                        set po_use_point = po_use_point - '$point1',
                            po_expired = '$po_expired',
                            po_expire_date = '$po_expire_date'
                        where po_id = '{$row['po_id']}' ";
            sql_queryG($sql);
            break;
        } else {
            $sql = " update {$tkher['point_table']}
                        set po_use_point = '0',
                            po_expired = '$po_expired',
                            po_expire_date = '$po_expire_date'
                        where po_id = '{$row['po_id']}' ";
            sql_queryG($sql);

            $point1 -= $point2;
        }
    }
}

// 포인트 내역 합계
function get_point_sum($mb_id)
{
    global $tkher, $config;

    if($config['kapp_point_term'] > 0) {
        // 소멸포인트가 있으면 내역 추가
        $expire_point = get_expire_point($mb_id);
        if($expire_point > 0) {
            $mb = get_member($mb_id, 'mb_point');
            $content = '포인트 소멸';
            $rel_table = '@expire';
            $rel_id = $mb_id;
            $rel_action = 'expire'.'-'.uniqid('');
            $point = $expire_point * (-1);
            $po_mb_point = $mb['mb_point'] + $point;
            $po_expire_date = KAPP_TIME_YMD;
            $po_expired = 1;

            $sql = " insert into {$tkher['point_table']}
                        set mb_id = '$mb_id',
                            po_datetime = '".KAPP_TIME_YMDHIS."',
                            po_content = '".addslashes($content)."',
                            po_point = '$point',
                            po_use_point = '0',
                            po_mb_point = '$po_mb_point',
                            po_expired = '$po_expired',
                            po_expire_date = '$po_expire_date',
                            po_rel_table = '$rel_table',
                            po_rel_id = '$rel_id',
                            po_rel_action = '$rel_action' ";
            sql_queryG($sql);

            // 포인트를 사용한 경우 포인트 내역에 사용금액 기록
            if($point < 0) {
                insert_use_point($mb_id, $point);
            }
        }

        // 유효기간이 있을 때 기간이 지난 포인트 expired 체크
        $sql = " update {$tkher['point_table']}
                    set po_expired = '1'
                    where mb_id = '$mb_id'
                      and po_expired <> '1'
                      and po_expire_date <> '9999-12-31'
                      and po_expire_date < '".KAPP_TIME_YMD."' ";
        sql_queryG($sql);
    }

    // 포인트합
    $sql = " select sum(po_point) as sum_po_point
                from {$tkher['point_table']}
                where mb_id = '$mb_id' ";
    $row = sql_fetch($sql);

    return $row['sum_po_point'];
}

// 소멸 포인트
function get_expire_point($mb_id)
{
    global $tkher, $config;

    if($config['kapp_point_term'] == 0)
        return 0;

    $sql = " select sum(po_point - po_use_point) as sum_point
                from {$tkher['point_table']}
                where mb_id = '$mb_id'
                  and po_expired = '0'
                  and po_expire_date <> '9999-12-31'
                  and po_expire_date < '".KAPP_TIME_YMD."' ";
    $row = sql_fetch($sql);

    return $row['sum_point'];
}

// 포인트 삭제
function delete_point($mb_id, $rel_table, $rel_id, $rel_action)
{
    global $tkher;

    $result = false;
    if ($rel_table || $rel_id || $rel_action)
    {
        // 포인트 내역정보
        $sql = " SELECT * from {$tkher['point_table']}
                    where mb_id = '$mb_id'
                      and po_rel_table = '$rel_table'
                      and po_rel_id = '$rel_id'
                      and po_rel_action = '$rel_action' ";
        $row = sql_fetch($sql);

        if($row['po_point'] < 0) {
            $mb_id = $row['mb_id'];
            $po_point = abs($row['po_point']);

            delete_use_point($mb_id, $po_point);
        } else {
            if($row['po_use_point'] > 0) {
                insert_use_point($row['mb_id'], $row['po_use_point'], $row['po_id']);
            }
        }

        $result = sql_queryG(" delete from {$tkher['point_table']}
                     where mb_id = '$mb_id'
                       and po_rel_table = '$rel_table'
                       and po_rel_id = '$rel_id'
                       and po_rel_action = '$rel_action' ", false);

        // po_mb_point에 반영
        $sql = " update {$tkher['point_table']}
                    set po_mb_point = po_mb_point - '{$row['po_point']}'
                    where mb_id = '$mb_id'
                      and po_id > '{$row['po_id']}' ";
        sql_queryG($sql);

        // 포인트 내역의 합을 구하고
        $sum_point = get_point_sum($mb_id);

        // 포인트 UPDATE
        $sql = " update {$tkher['tkher_member_table']} set mb_point = '$sum_point' where mb_id = '$mb_id' ";
        $result = sql_queryG($sql);
    }

    return $result;
}


// 파일을 보이게 하는 링크 (이미지, 플래쉬, 동영상)
function view_file_link($file, $width, $height, $content='')
{
    global $config, $board;
    global $tkher;
    static $ids;

    if (!$file) return;

    $ids++;

    // 파일의 폭이 게시판설정의 이미지폭 보다 크다면 게시판설정 폭으로 맞추고 비율에 따라 높이를 계산
    if ($width > $board['bo_image_width'] && $board['bo_image_width'])
    {
        $rate = $board['bo_image_width'] / $width;
        $width = $board['bo_image_width'];
        $height = (int)($height * $rate);
    }

    // 폭이 있는 경우 폭과 높이의 속성을 주고, 없으면 자동 계산되도록 코드를 만들지 않는다.
    if ($width)
        $attr = ' width="'.$width.'" height="'.$height.'" ';
    else
        $attr = '';

    if (preg_match("/\.({$config['kapp_image_extension']})$/i", $file)) {
        $img = '<a href="'.KAPP_BBS_URL.'/view_image.php?bo_table='.$board['bo_table'].'&amp;fn='.urlencode($file).'" target="_blank" class="view_image">';
        $img .= '<img src="'.KAPP_DATA_URL.'/file/'.$board['bo_table'].'/'.urlencode($file).'" alt="'.$content.'" '.$attr.'>';
        $img .= '</a>';

        return $img;
    }
}

// view_file_link() 함수에서 넘겨진 이미지를 보이게 합니다.
// {img:0} ... {img:n} 과 같은 형식
function view_image($view, $number, $attribute)
{
    if ($view['file'][$number]['view'])
        return preg_replace("/>$/", " $attribute>", $view['file'][$number]['view']);
    else
        return "";
}

function cut_str($str, $len, $suffix="…")
{
    $arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    $str_len = count($arr_str);

    if ($str_len >= $len) {
        $slice_str = array_slice($arr_str, 0, $len);
        $str = join("", $slice_str);

        return $str . ($str_len > $len ? $suffix : '');
    } else {
        $str = join("", $arr_str);
        return $str;
    }
}
// TEXT 형식으로 변환
function get_text($str, $html=0, $restore=false)
{
    $source[] = "<";
    $target[] = "&lt;";
    $source[] = ">";
    $target[] = "&gt;";
    $source[] = "\"";
    $target[] = "&#034;";
    $source[] = "\'";
    $target[] = "&#039;";

    if($restore)  $str = str_replace($target, $source, $str);

    // TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
    if ($html == 0) {
        $str = html_symbol($str);
    }

    if ($html) {
        $source[] = "\n";
        $target[] = "<br/>";
    }

    return str_replace($source, $target, $str);
}

// &nbsp; &amp; &middot; 등을 정상으로 출력
function html_symbol($str)
{
    return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
}


/*************************************************************************
**
**  SQL 관련 함수 모음
**
*************************************************************************/

// DB 연결
function sql_connectG($host, $user, $pass, $db=KAPP_MYSQL_DB)
{
    global $tkher;

    if(function_exists('mysqli_connect') && KAPP_MYSQLI_USE) {
        $link = mysqli_connect($host, $user, $pass, $db);

        // 연결 오류 발생 시 스크립트 종료
        if (mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {
        $link = mysql_connectG($host, $user, $pass);
    }

    return $link;
}


// DB 선택
function sql_select_dbG($db, $connect)
{
    global $tkher;

    if(function_exists('mysqli_select_db') && KAPP_MYSQLI_USE)
        return @mysqli_select_db($connect, $db);
    else
        return @mysql_select_dbG($db, $connect);
}


function sql_set_charset($charset, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    if(function_exists('mysqli_set_charset') && KAPP_MYSQLI_USE)
        mysqli_set_charset($link, $charset);
    else
        mysql_query(" set names {$charset} ", $link);
}


// mysqli_query 와 mysqli_error 를 한꺼번에 처리
// mysql connect resource 지정 - 명랑폐인님 제안
function sql_queryG($sql, $error=KAPP_DISPLAY_SQL_ERROR, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query') && KAPP_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }

    return $result;
}

// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=null, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    $result = sql_queryG($sql, $error, $link);
    //$row = @sql_fetch_arrayG($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
    $row = sql_fetch_arrayG($result);
    return $row;
}


// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_arrayG($result)
{
    if(function_exists('mysqli_fetch_assoc') && KAPP_MYSQLI_USE)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}

// $result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
// sql_free_result()는 결과로부터 얻은 질의 값이 커서 많은 메모리를 사용할 염려가 있을 때 사용된다.
// 단, 결과 값은 스크립트(script) 실행부가 종료되면서 메모리에서 자동적으로 지워진다.
function sql_free_result($result)
{
    if(function_exists('mysqli_free_result') && KAPP_MYSQLI_USE)
        return mysqli_free_result($result);
    else
        return mysql_free_result($result);
}

function sql_password($value)
{
    $row = sql_fetch(" select password('$value') as pass ");
    return $row['pass'];
}

function sql_insert_id($link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    if(function_exists('mysqli_insert_id') && KAPP_MYSQLI_USE)
        return mysqli_insert_id($link);
    else
        return mysql_insert_id($link);
}

function sql_num_rowsX($result)
{
    if(function_exists('mysqli_num_rows') && KAPP_MYSQLI_USE)
    //if( function_exists('mysqli_num_rows' ) )
        return mysqli_num_rows($result);
    else
        return mysql_num_rows($result);
}

function sql_num_rowsG($result)
{
    if(function_exists('mysqli_num_rows') && KAPP_MYSQLI_USE)
        return mysqli_num_rows($result);
    else
        return mysql_num_rows($result);
}


function sql_field_names($table, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    $columns = array();

    $sql = " SELECT * from `$table` limit 1 ";
    $result = sql_queryG($sql, $link);

    if(function_exists('mysqli_fetch_field') && KAPP_MYSQLI_USE) {
        while($field = mysqli_fetch_field($result)) {
            $columns[] = $field->name;
        }
    } else {
        $i = 0;
        $cnt = mysql_num_fields($result);
        while($i < $cnt) {
            $field = mysql_fetch_field($result, $i);
            $columns[] = $field->name;
            $i++;
        }
    }

    return $columns;
}


function sql_error_info($link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    if(function_exists('mysqli_error') && KAPP_MYSQLI_USE) {
        return mysqli_errno($link) . ' : ' . mysqli_error($link);
    } else {
        return mysql_errno($link) . ' : ' . mysql_error($link);
    }
}


// PHPMyAdmin 참고
function get_table_define($table, $crlf="\n")
{
    global $tkher;

    // For MySQL < 3.23.20
    $schema_create .= 'CREATE TABLE ' . $table . ' (' . $crlf;

    $sql = 'SHOW FIELDS FROM ' . $table;
    $result = sql_queryG($sql);
    while ($row = sql_fetch_arrayG($result))
    {
        $schema_create .= '    ' . $row['Field'] . ' ' . $row['Type'];
        if (isset($row['Default']) && $row['Default'] != '')
        {
            $schema_create .= ' DEFAULT \'' . $row['Default'] . '\'';
        }
        if ($row['Null'] != 'YES')
        {
            $schema_create .= ' NOT NULL';
        }
        if ($row['Extra'] != '')
        {
            $schema_create .= ' ' . $row['Extra'];
        }
        $schema_create     .= ',' . $crlf;
    } // end while
    sql_free_result($result);

    $schema_create = preg_replace('/,' . $crlf . '$/', '', $schema_create);

    $sql = 'SHOW KEYS FROM ' . $table;
    $result = sql_queryG($sql);
    while ($row = sql_fetch_arrayG($result))
    {
        $kname    = $row['Key_name'];
        $comment  = (isset($row['Comment'])) ? $row['Comment'] : '';
        $sub_part = (isset($row['Sub_part'])) ? $row['Sub_part'] : '';

        if ($kname != 'PRIMARY' && $row['Non_unique'] == 0) {
            $kname = "UNIQUE|$kname";
        }
        if ($comment == 'FULLTEXT') {
            $kname = 'FULLTEXT|$kname';
        }
        if (!isset($index[$kname])) {
            $index[$kname] = array();
        }
        if ($sub_part > 1) {
            $index[$kname][] = $row['Column_name'] . '(' . $sub_part . ')';
        } else {
            $index[$kname][] = $row['Column_name'];
        }
    } // end while
    sql_free_result($result);

    while (list($x, $columns) = @each($index)) {
        $schema_create     .= ',' . $crlf;
        if ($x == 'PRIMARY') {
            $schema_create .= '    PRIMARY KEY (';
        } else if (substr($x, 0, 6) == 'UNIQUE') {
            $schema_create .= '    UNIQUE ' . substr($x, 7) . ' (';
        } else if (substr($x, 0, 8) == 'FULLTEXT') {
            $schema_create .= '    FULLTEXT ' . substr($x, 9) . ' (';
        } else {
            $schema_create .= '    KEY ' . $x . ' (';
        }
        $schema_create     .= implode($columns, ', ') . ')';
    } // end while

    $schema_create .= $crlf . ') ENGINE=MyISAM DEFAULT CHARSET=utf8';

    return $schema_create;
} // end of the 'PMA_getTableDef()' function


// 리퍼러 체크
function referer_check($url='')
{
	//alert('referer_check --------');
    /**/
    // 제대로 체크를 하지 못하여 주석 처리함
    global $tkher;

    if (!$url)
        $url = KAPP_URL_T_;

    if (!preg_match("/^http['s']?:\/\/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
        alert("Please follow the normal procedure. ", $url);
		echo "<script>window.open( '$url/tkher_register_.php' , '_self', ''); </script>";
	}
    /*  alert : 제대로 된 접근이 아닌것 같습니다. url:http://urllinkcoin.com/t */
}


// 한글 요일
function get_yoil($date, $full=0)
{
    $arr_yoil = array ('일', '월', '화', '수', '목', '금', '토');

    $yoil = date("w", strtotime($date));
    $str = $arr_yoil[$yoil];
    if ($full) {
        $str .= '요일';
    }
    return $str;
}


// 날짜를 select 박스 형식으로 얻는다
function date_select($date, $name='')
{
    global $tkher;

    $s = '';
    if (substr($date, 0, 4) == "0000") {
        $date = KAPP_TIME_YMDHIS;
    }
    preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $date, $m);

    // 년
    $s .= "<select name='{$name}_y'>";
    for ($i=$m['0']-3; $i<=$m['0']+3; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['0']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>년 \n";

    // 월
    $s .= "<select name='{$name}_m'>";
    for ($i=1; $i<=12; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['2']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>월 \n";

    // 일
    $s .= "<select name='{$name}_d'>";
    for ($i=1; $i<=31; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['3']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>일 \n";

    return $s;
}


// 시간을 select 박스 형식으로 얻는다
// 1.04.00
// 경매에 시간 설정이 가능하게 되면서 추가함
function time_select($time, $name="")
{
    preg_match("/([0-9]{2}):([0-9]{2}):([0-9]{2})/", $time, $m);

    // 시
    $s .= "<select name='{$name}_h'>";
    for ($i=0; $i<=23; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['0']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>시 \n";

    // 분
    $s .= "<select name='{$name}_i'>";
    for ($i=0; $i<=59; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['2']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>분 \n";

    // 초
    $s .= "<select name='{$name}_s'>";
    for ($i=0; $i<=59; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['3']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>초 \n";

    return $s;
}

// 문자열이 한글, 영문, 숫자, 특수문자로 구성되어 있는지 검사
function check_string($str, $options)
{
    global $tkher;

    $s = '';
    for($i=0;$i<strlen($str);$i++) {
        $c = $str[$i];
        $oc = ord($c);

        // 한글
        if ($oc >= 0xA0 && $oc <= 0xFF) {
            if ($options & KAPP_HANGUL) {
                $s .= $c . $str[$i+1] . $str[$i+2];
            }
            $i+=2;
        }
        // 숫자
        else if ($oc >= 0x30 && $oc <= 0x39) {
            if ($options & KAPP_NUMERIC) {
                $s .= $c;
            }
        }
        // 영대문자
        else if ($oc >= 0x41 && $oc <= 0x5A) {
            if (($options & KAPP_ALPHABETIC) || ($options & KAPP_ALPHAUPPER)) {
                $s .= $c;
            }
        }
        // 영소문자
        else if ($oc >= 0x61 && $oc <= 0x7A) {
            if (($options & KAPP_ALPHABETIC) || ($options & KAPP_ALPHALOWER)) {
                $s .= $c;
            }
        }
        // 공백
        else if ($oc == 0x20) {
            if ($options & KAPP_SPACE) {
                $s .= $c;
            }
        }
        else {
            if ($options & KAPP_SPECIAL) {
                $s .= $c;
            }
        }
    }
    return ($str == $s);
}
// 한글(2bytes)에서 마지막 글자가 1byte로 끝나는 경우 출력시 깨지는 현상이 발생하므로 마지막 완전하지 않은 글자(1byte)를 하나 없앰
function cut_hangul_last($hangul)
{
    global $tkher;
    $cnt = 0;
    for($i=0;$i<strlen($hangul);$i++) {
        if (ord($hangul[$i]) >= 0xA0) {
            $cnt++;
        }
    }
    return $hangul;
}


// Check whether INDEX (key) is used in a table
function explain($sql)
{
    if (preg_match("/^(select)/i", trim($sql))) {
        $q = "explain $sql";
        echo $q;
        $row = sql_fetch($q);
        if (!$row['key']) $row['key'] = "NULL";
        echo " <font color=blue>(type={$row['type']} , key={$row['key']})</font>";
    }
}

// Malicious tag conversion
function bad_tag_convert($code)
{
    global $view;
    global $member, $is_admin;

    if ($is_admin && $member['mb_id'] != $view['mb_id']) {
        $code = preg_replace_callback("#(\<(embed|object)[^\>]*)\>?(\<\/(embed|object)\>)?#i",
                    create_function('$matches', 'return "<div class=\"embedx\">Due to security issues, the embed or object tag cannot be viewed with the administrator ID. To check, log in with a different ID without administrative rights.</div>";'),
                    $code);
    }

    return preg_replace("/\<([\/]?)(script|iframe|form)([^\>]*)\>?/i", "&lt;$1$2$3&gt;", $code);
}


// 토큰 생성
function _token()
{
    return md5(uniqid(rand(), true));
}


// 불법접근을 막도록 토큰을 생성하면서 토큰값을 리턴
function get_token()
{
    $token = md5(uniqid(rand(), true));
    set_session('ss_token', $token);

    return $token;
}


// POST로 넘어온 토큰과 세션에 저장된 토큰 비교
function check_token()
{
    set_session('ss_token', '');
    return true;
}


// 문자열에 utf8 문자가 들어 있는지 검사하는 함수
// 코드 : http://in2.php.net/manual/en/function.mb-check-encoding.php#95289
function is_utf8($str)
{
    $len = strlen($str);
    for($i = 0; $i < $len; $i++) {
        $c = ord($str[$i]);
        if ($c > 128) {
            if (($c > 247)) return false;
            elseif ($c > 239) $bytes = 4;
            elseif ($c > 223) $bytes = 3;
            elseif ($c > 191) $bytes = 2;
            else return false;
            if (($i + $bytes) > $len) return false;
            while ($bytes > 1) {
                $i++;
                $b = ord($str[$i]);
                if ($b < 128 || $b > 191) return false;
                $bytes--;
            }
        }
    }
    return true;
}


// UTF-8 문자열 자르기
// 출처 : https://www.google.co.kr/search?q=utf8_strcut&aq=f&oq=utf8_strcut&aqs=chrome.0.57j0l3.826j0&sourceid=chrome&ie=UTF-8
function utf8_strcut( $str, $size, $suffix='...' )
{
        $substr = substr( $str, 0, $size * 2 );
        $multi_size = preg_match_all( '/[\x80-\xff]/', $substr, $multi_chars );

        if ( $multi_size > 0 )
            $size = $size + intval( $multi_size / 3 ) - 1;

        if ( strlen( $str ) > $size ) {
            $str = substr( $str, 0, $size );
            $str = preg_replace( '/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str );
            $str .= $suffix;
        }

        return $str;
}


/*
-----------------------------------------------------------
    Charset 을 변환하는 함수
-----------------------------------------------------------
iconv 함수가 있으면 iconv 로 변환하고
없으면 mb_convert_encoding 함수를 사용한다.
둘다 없으면 사용할 수 없다.
*/
function convert_charset($from_charset, $to_charset, $str)
{

    if( function_exists('iconv') )
        return iconv($from_charset, $to_charset, $str);
    elseif( function_exists('mb_convert_encoding') )
        return mb_convert_encoding($str, $to_charset, $from_charset);
    else
        die("Not found 'iconv' or 'mbstring' library in server.");
}


// mysqli_real_escape_string 의 alias 기능을 한다.
function sql_real_escape_string($str, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    return mysqli_real_escape_string($link, $str);
}

function escape_trim($field)
{
    $str = call_user_func(KAPP_ESCAPE_FUNCTION, $field);
    return $str;
}

// $_POST 형식에서 checkbox 엘리먼트의 checked 속성에서 checked 가 되어 넘어 왔는지를 검사
function is_checked($field)
{
    return !empty($_POST[$field]);
}


function abs_ip2long($ip='')
{
    $ip = $ip ? $ip : $_SERVER['REMOTE_ADDR'];
    return abs(ip2long($ip));
}


function get_selected($field, $value)
{
    return ($field==$value) ? ' selected="selected"' : '';
}


function get_checked($field, $value)
{
    return ($field==$value) ? ' checked="checked"' : '';
}


function is_mobile()
{
    return preg_match('/'.KAPP_MOBILE_AGENT.'/i', $_SERVER['HTTP_USER_AGENT']);
}
// key make
function get_uniqid()
{
    global $tkher;

    sql_queryG(" LOCK TABLE {$tkher['uniqid_table']} WRITE ");
    while (1) {
        // 년월일시분초에 100분의 1초 두자리를 추가함 (1/100 초 앞에 자리가 모자르면 0으로 채움)
        $key = date('ymdHis', time()) . str_pad((int)(microtime()*100), 2, "0", STR_PAD_LEFT);

        $result = sql_queryG(" insert into {$tkher['uniqid_table']} set uq_id = '$key', uq_ip = '{$_SERVER['REMOTE_ADDR']}' ", false);
        if ($result) break;
        usleep(10000); // 100분의 1초를 쉰다
    }
    sql_queryG(" UNLOCK TABLES ");

    return $key;
}

function iconv_utf8($str)
{
    return iconv('euc-kr', 'utf-8', $str);
}

function iconv_euckr($str)
{
    return iconv('utf-8', 'euc-kr', $str);
}

function check_device($device)
{
    global $is_admin;

    if ($is_admin) return;

    if ($device=='pc' && KAPP_IS_MOBILE) {
        alert('PC 전용 게시판입니다.', KAPP_URL_T_);
    } else if ($device=='mobile' && !KAPP_IS_MOBILE) {
        alert('모바일 전용 게시판입니다.', KAPP_URL_T_);
    }
}


// Get skin style sheet file
function get_skin_stylesheet($skin_path, $dir='')
{
    if(!$skin_path)
        return "";

    $str = "";
    $files = array();

    if($dir)
        $skin_path .= '/'.$dir;

    $skin_url = KAPP_URL_T_.str_replace("\\", "/", str_replace(KAPP_PATH_T_, "", $skin_path));

    if(is_dir($skin_path)) {
        if($dh = opendir($skin_path)) {
            while(($file = readdir($dh)) !== false) {
                if($file == "." || $file == "..")
                    continue;

                if(is_dir($skin_path.'/'.$file))
                    continue;

                if(preg_match("/\.(css)$/i", $file))
                    $files[] = $file;
            }
            closedir($dh);
        }
    }

    if(!empty($files)) {
        sort($files);

        foreach($files as $file) {
            $str .= '<link rel="stylesheet" href="'.$skin_url.'/'.$file.'?='.date("md").'">'."\n";
        }
    }
    return $str;
}

// Get skin javascript file
function get_skin_javascript($skin_path, $dir='')
{
    if(!$skin_path)
        return "";

    $str = "";
    $files = array();

    if($dir)
        $skin_path .= '/'.$dir;

    $skin_url = KAPP_URL_T_.str_replace("\\", "/", str_replace(KAPP_PATH_T_, "", $skin_path));

    if(is_dir($skin_path)) {
        if($dh = opendir($skin_path)) {
            while(($file = readdir($dh)) !== false) {
                if($file == "." || $file == "..")
                    continue;

                if(is_dir($skin_path.'/'.$file))
                    continue;

                if(preg_match("/\.(js)$/i", $file))
                    $files[] = $file;
            }
            closedir($dh);
        }
    }

    if(!empty($files)) {
        sort($files);

        foreach($files as $file) {
            $str .= '<script src="'.$skin_url.'/'.$file.'"></script>'."\n";
        }
    }

    return $str;
}

// file_put_contents is a PHP5-only function, so it is intended to be used in lower versions of PHP4.
// http://www.phpied.com/file_get_contents-for-php4/
if (!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data) {
        $f = @fopen($filename, 'w');
        if (!$f) {
            return false;
        } else {
            $bytes = fwrite($f, $data);
            fclose($f);
            return $bytes;
        }
    }
}


// HTML 마지막 처리 
function html_end()
{
    global $html_process;

    return $html_process->run();
}

function add_stylesheet($stylesheet, $order=0)
{
    global $html_process;

    if(trim($stylesheet))
        $html_process->merge_stylesheet($stylesheet, $order);
}

function add_javascript($javascript, $order=0)
{
    global $html_process;

    if(trim($javascript))
        $html_process->merge_javascript($javascript, $order);
}

class html_process {
    protected $css = array();
    protected $js  = array();

    function merge_stylesheet($stylesheet, $order)
    {
        $links = $this->css;
        $is_merge = true;

        foreach($links as $link) {
            if($link[1] == $stylesheet) {
                $is_merge = false;
                break;
            }
        }

        if($is_merge)
            $this->css[] = array($order, $stylesheet);
    }

    function merge_javascript($javascript, $order)
    {
        $scripts = $this->js;
        $is_merge = true;

        foreach($scripts as $script) {
            if($script[1] == $javascript) {
                $is_merge = false;
                break;
            }
        }

        if($is_merge)
            $this->js[] = array($order, $javascript);
    }

    function run()
    {
        global $config, $tkher, $member;

        // 현재접속자 처리
        $tmp_sql = " select count(*) as cnt from {$tkher['login_table']} where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
        $tmp_row = sql_fetch($tmp_sql);

        if ($tmp_row['cnt']) {
            $tmp_sql = " update {$tkher['login_table']} set mb_id = '{$member['mb_id']}', lo_datetime = '".KAPP_TIME_YMDHIS."', lo_location = '{$tkher['lo_location']}', lo_url = '{$tkher['lo_url']}' where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
            sql_queryG($tmp_sql, FALSE);
        } else {
            $tmp_sql = " insert into {$tkher['login_table']} ( lo_ip, mb_id, lo_datetime, lo_location, lo_url ) values ( '{$_SERVER['REMOTE_ADDR']}', '{$member['mb_id']}', '".KAPP_TIME_YMDHIS."', '{$tkher['lo_location']}',  '{$tkher['lo_url']}' ) ";
            sql_queryG($tmp_sql, FALSE);

            // 시간이 지난 접속은 삭제한다
            sql_queryG(" delete from {$tkher['login_table']} where lo_datetime < '".date("Y-m-d H:i:s", KAPP_SERVER_TIME - (60 * $config['kapp_login_minutes']))."' ");

            // 부담(overhead)이 있다면 테이블 최적화
            //$row = sql_fetch(" SHOW TABLE STATUS FROM `$mysql_db` LIKE '$tkher['login_table']' ");
            //if ($row['Data_free'] > 0) sql_queryG(" OPTIMIZE TABLE $tkher['login_table'] ");
        }

        $buffer = ob_get_contents();
        ob_end_clean();

        $stylesheet = '';
        $links = $this->css;

        if(!empty($links)) {
            foreach ($links as $key => $row) {
                $order[$key] = $row[0];
                $index[$key] = $key;
                $style[$key] = $row[1];
            }

            array_multisort($order, SORT_ASC, $index, SORT_ASC, $links);

            foreach($links as $link) {
                if(!trim($link[1]))
                    continue;

                $link[1] = preg_replace('#\.css([\'\"]?>)$#i', '.css?ver='.KAPP_CSS_VER.'$1', $link[1]);

                $stylesheet .= PHP_EOL.$link[1];
            }
        }

        $javascript = '';
        $scripts = $this->js;
        $php_eol = '';

        unset($order);
        unset($index);

        if( !empty($scripts)) {
            foreach ($scripts as $key => $row) {
                $order[$key] = $row[0];
                $index[$key] = $key;
                $script[$key] = $row[1];
            }

            array_multisort($order, SORT_ASC, $index, SORT_ASC, $scripts);

            foreach($scripts as $js) {
                if(!trim($js[1]))
                    continue;

                $js[1] = preg_replace('#\.js([\'\"]?>)$#i', '.js?ver='.KAPP_JS_VER.'$1', $js[1]);

                $javascript .= $php_eol.$js[1];
                $php_eol = PHP_EOL;
            }
        }
        $buffer = preg_replace('#(</title>[^<]*<link[^>]+>)#', "$1$stylesheet", $buffer);
        $nl = '';
        if($javascript)
            $nl = "\n";
        $buffer = preg_replace('#(</head>[^<]*<body[^>]*>)#', "$javascript{$nl}$1", $buffer);

        return $buffer;
    }
}

function hyphen_hp_number($hp)
{
    $hp = preg_replace("/[^0-9]/", "", $hp);
    return preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $hp);
}

function login_url($url='')
{
    if (!$url) $url = KAPP_URL_T_;
    return urlencode(clean_xss_tags(urldecode($url)));
}

function https_url($dir, $https=true)
{
    if ($https) {
        if (KAPP_HTTPS_DOMAIN) {
            $url = KAPP_HTTPS_DOMAIN.'/'.$dir;
        } else {
            $url = KAPP_URL_T_.'/'.$dir;
        }
    } else {
        if (KAPP_DOMAIN) {
            $url = KAPP_DOMAIN.'/'.$dir;
        } else {
            $url = KAPP_URL_T_.'/'.$dir;
        }
    }

    return $url;
}


// Update notices on the bulletin board by separating them with and .
function board_notice($bo_notice, $wr_id, $insert=false)
{
    $notice_array = explode(",", trim($bo_notice));

    if($insert && in_array($wr_id, $notice_array))
        return $bo_notice;

    $notice_array = array_merge(array($wr_id), $notice_array);
    $notice_array = array_unique($notice_array);
    foreach ($notice_array as $key=>$value) {
        if (!trim($value))
            unset($notice_array[$key]);
    }
    if (!$insert) {
        foreach ($notice_array as $key=>$value) {
            if ((int)$value == (int)$wr_id)
                unset($notice_array[$key]);
        }
    }
    return implode(",", $notice_array);
}


// Create a short address
function googl_short_url($longUrl)
{
    global $config;

    // Get API key from : http://code.google.com/apis/console/
    // URL Shortener API ON
    $apiKey = $config['kapp_googl_shorturl_apikey'];

    $postData = array('longUrl' => $longUrl);
    $jsonData = json_encode($postData);

    $curlObj = curl_init();

    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($curlObj);

    //change the response json string to object
    $json = json_decode($response);

    curl_close($curlObj);

    return $json->id;
}

function autosave_count($mb_id)
{
    global $tkher;

    if ($mb_id) {
        $row = sql_fetch(" select count(*) as cnt from {$tkher['autosave_table']} where mb_id = '$mb_id' ");
        return (int)$row['cnt'];
    } else {
        return 0;
    }
}

// Record of identity verification details
function insert_cert_history($mb_id, $company, $method)
{
    global $tkher;

    $sql = " insert into {$tkher['cert_history_table']}
                set mb_id = '$mb_id',
                    cr_company = '$company',
                    cr_method = '$method',
                    cr_ip = '{$_SERVER['REMOTE_ADDR']}',
                    cr_date = '".KAPP_TIME_YMD."',
                    cr_time = '".KAPP_TIME_HIS."' ";
    sql_queryG($sql);
}

// Check the number of authentication attempts 
function certify_count_check($mb_id, $type)
{
    global $tkher, $config;

    if($config['kapp_cert_use'] != 2)
        return;

    if($config['kapp_cert_limit'] == 0)
        return;

    $sql = " select count(*) as cnt from {$tkher['cert_history_table']} ";

    if($mb_id) {
        $sql .= " where mb_id = '$mb_id' ";
    } else {
        $sql .= " where cr_ip = '{$_SERVER['REMOTE_ADDR']}' ";
    }

    $sql .= " and cr_method = '".$type."' and cr_date = '".KAPP_TIME_YMD."' ";

    $row = sql_fetch($sql);

    switch($type) {
        case 'hp':
            $cert = '휴대폰';
            break;
        case 'ipin':
            $cert = '아이핀';
            break;
        default:
            break;
    }

    if((int)$row['cnt'] >= (int)$config['kapp_cert_limit'])
        alert_close('Today '.$cert.' You can no longer use your identity because you have used it '.$row['cnt'].' times.');
	//오늘 '.$cert.' 본인확인을 '.$row['cnt'].'회 이용하셔서 더 이상 이용할 수 없습니다.
}

// 1:1문의 설정로드
function get_qa_config($fld='*')
{
    global $tkher;

    $sql = " select $fld from {$tkher['qa_config_table']} ";
    $row = sql_fetch($sql);

    return $row;
}

// get_sock 함수 대체
if (!function_exists("get_sock")) {
    function get_sock($url)
    {
        // host , uri separation
        //if (ereg("http://([a-zA-Z0-9_\-\.]+)([^<]*)", $url, $res))
        if (preg_match("/http:\/\/([a-zA-Z0-9_\-\.]+)([^<]*)/", $url, $res))
        {
            $host = $res[1];
            $get  = $res[2];
        }

        $fp = fsockopen ($host, 80, $errno, $errstr, 30);
        if (!$fp)
        {
            //die("$errstr ($errno)\n");

            echo "$errstr ($errno)\n";
            return null;
        }
        else
        {
            fputs($fp, "GET $get HTTP/1.0\r\n");
            fputs($fp, "Host: $host\r\n");
            fputs($fp, "\r\n");

            // header , content
            while (trim($buffer = fgets($fp,1024)) != "")
            {
                $header .= $buffer;
            }
            while (!feof($fp))
            {
                $buffer .= fgets($fp,1024);
            }
        }
        fclose($fp);

        // content  return .
        return $buffer;
    }
}

// 
function module_exec_check($exe, $type)
{
    $error = '';
    $is_linux = false;
    if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') $is_linux = true;

    if(!is_file($exe)) {
        $error = $exe.' file no found';
    } else {
        if(!is_executable($exe)) {
            if($is_linux) $error = $exe.'\nYou do not have permission to execute the file.\n\nchmod 755 '.basename($exe).' Please grant execution permission.';
            else          $error = $exe.'\nYou do not have permission to execute the file.\n\n'.basename($exe).' Please grant execution permission to the file.';
        } else {
            if($is_linux) {
                $search = false;
                $isbinary = true;
                $executable = true;

                switch($type) {
                    case 'ct_cli':
                        exec($exe.' -h 2>&1', $out, $return_var);

                        if($return_var == 139) {
                            $isbinary = false;
                            break;
                        }

                        for($i=0; $i<count($out); $i++) {
                            if(strpos($out[$i], 'KCP ENC') !== false) {
                                $search = true;
                                break;
                            }
                        }
                        break;
                    case 'okname':
                        exec($exe.' D 2>&1', $out, $return_var);

                        if($return_var == 139) {
                            $isbinary = false;
                            break;
                        }

                        for($i=0; $i<count($out); $i++) {
                            if(strpos(strtolower($out[$i]), 'ret code') !== false) {
                                $search = true;
                                break;
                            }
                        }
                        break;
                }

                if(!$isbinary || !$search) {
                    $error = $exe.'\nPlease re-upload the file in binary format.';//파일을 바이너리 타입으로 다시 업로드하여 주십시오.
                }
            }
        }
    }

    if($error) {
        $error = '<script>alert("'.$error.'");</script>';
    }

    return $error;
}

// 주소출력
function print_address($addr1, $addr2, $addr3, $addr4)
{
    $address = get_text(trim($addr1));
    $addr2   = get_text(trim($addr2));
    $addr3   = get_text(trim($addr3));

    if($addr4 == 'N') {
        if($addr2)
            $address .= ' '.$addr2;
    } else {
        if($addr2)
            $address .= ', '.$addr2;
    }

    if($addr3)
        $address .= ' '.$addr3;

    return $address;
}

// input vars check
function check_input_vars()
{
    $max_input_vars = ini_get('max_input_vars');

    if($max_input_vars) {
        $post_vars = count($_POST, COUNT_RECURSIVE);
        $get_vars = count($_GET, COUNT_RECURSIVE);
        $cookie_vars = count($_COOKIE, COUNT_RECURSIVE);

        $input_vars = $post_vars + $get_vars + $cookie_vars;

        if($input_vars > $max_input_vars) {
            alert('The number of variables transmitted from the form is greater than the max_input_vars value.\\nSome of the transmitted values may be lost and recorded in the DB.\\n\\nTo solve the problem, change the max_input_vars value in server php.ini. do it.');
			//폼에서 전송된 변수의 개수가 max_input_vars 값보다 큽니다.\\n전송된 값중 일부는 유실되어 DB에 기록될 수 있습니다.\\n\\n문제를 해결하기 위해서는 서버 php.ini의 max_input_vars 값을 변경하십시오.
        }
    }
}

// HTML htmlspecialchars change
function htmlspecialchars2($str)
{
    $trans = array("\"" => "&#034;", "'" => "&#039;", "<"=>"&#060;", ">"=>"&#062;");
    $str = strtr($str, $trans);
    return $str;
}

// date type change
function conv_date_format($format, $date, $add='')
{
    if($add)
        $timestamp = strtotime($add, strtotime($date));
    else
        $timestamp = strtotime($date);

    return date($format, $timestamp);
}

// Remove special characters from search words
function get_search_string($stx)
{
    $stx_pattern = array();
    $stx_pattern[] = '#\.*/+#';
    $stx_pattern[] = '#\\\*#';
    $stx_pattern[] = '#\.{2,}#';
    $stx_pattern[] = '#[/\'\"%=*\#\(\)\|\+\&\!\$~\{\}\[\]`;:\?\^\,]+#';

    $stx_replace = array();
    $stx_replace[] = '';
    $stx_replace[] = '';
    $stx_replace[] = '.';
    $stx_replace[] = '';

    $stx = preg_replace($stx_pattern, $stx_replace, $stx);

    return $stx;
}

// XSS tag clear
function clean_xss_tags($str)
{
    $str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);

    return $str;
}

// unescape nl 얻기
function conv_unescape_nl($str)
{
    $search = array('\\r', '\r', '\\n', '\n');
    $replace = array('', '', "\n", "\n");

    return str_replace($search, $replace, $str);
}

// member delete
function member_delete($mb_id)
{
    global $config;
    global $tkher;

    $sql = " select mb_name, mb_nick, mb_ip, mb_recommend, mb_memo, mb_level from {$tkher['tkher_member_table']} where mb_id= '".$mb_id."' ";
    $mb = sql_fetch($sql);

    // delete member
    if(preg_match('#^[0-9]{8}.*deleted#', $mb['mb_memo']))
        return;

    if ($mb['mb_recommend']) {
        $row = sql_fetch(" select count(*) as cnt from {$tkher['tkher_member_table']} where mb_id = '".addslashes($mb['mb_recommend'])."' ");
        if ($row['cnt'])
            insert_point($mb['mb_recommend'], $config['kapp_recommend_point'] * (-1), $mb_id.' point clear', "@member", $mb['mb_recommend'], $mb_id.' id delete');
    }

    // id memo no use :
    $sql = " update {$tkher['tkher_member_table']} set mb_password = '', mb_level = 1, mb_email = '', mb_homepage = '', mb_tel = '', mb_hp = '', mb_zip1 = '', mb_zip2 = '', mb_addr1 = '', mb_addr2 = '', mb_birth = '', mb_sex = '', mb_signature = '', mb_memo = '".date('Ymd', KAPP_SERVER_TIME)."  deleted \n{$mb['mb_memo']}' where mb_id = '{$mb_id}' ";
    sql_queryG($sql);

    // point delete
    sql_queryG(" delete from {$tkher['point_table']} where mb_id = '$mb_id' ");
    // group delete
    sql_queryG(" delete from {$tkher['group_member_table']} where mb_id = '$mb_id' ");
    // memo delete
    sql_queryG(" delete from {$tkher['memo_table']} where me_recv_mb_id = '$mb_id' or me_send_mb_id = '$mb_id' ");
    sql_queryG(" delete from {$tkher['scrap_table']} where mb_id = '$mb_id' ");
    sql_queryG(" delete from {$tkher['auth_table']} where mb_id = '$mb_id' ");
    sql_queryG(" update {$tkher['group_table']} set gr_admin = '' where gr_admin = '$mb_id' ");
    sql_queryG(" update {$tkher['board_table']} set bo_admin = '' where bo_admin = '$mb_id' ");

    // icon delet
    @unlink(KAPP_DATA_PATH.'/member/'.substr($mb_id,0,2).'/'.$mb_id.'.gif');
}

// email clear
function get_email_address($email)
{
    preg_match("/[0-9a-z._-]+@[a-z0-9._-]{4,}/i", $email, $matches);

    return $matches[0];
}

// file name clear
function get_safe_filename($name)
{
    $pattern = '/["\'<>=#&!%\\\\(\)\*\+\?]/';
    $name = preg_replace($pattern, '', $name);

    return $name;
}

// 
function replace_filename($name)
{
    @session_start();
    $ss_id = session_id();
    $usec = get_microtime();
    $ext = array_pop(explode('.', $name));

    return sha1($ss_id.$_SERVER['REMOTE_ADDR'].$usec).'.'.$ext;
}

// icode user
function get_icode_userinfo($id, $pass)
{
    $res = get_sock('http://www.icodekorea.com/res/userinfo.php?userid='.$id.'&userpw='.$pass);
    $res = explode(';', $res);
    $userinfo = array(
        'code'      => $res[0], // 결과코드
        'coin'      => $res[1], // 고객 잔액 (충전제만 해당)
        'gpay'      => $res[2], // 고객의 건수 별 차감액 표시 (충전제만 해당)
        'payment'   => $res[3]  // 요금제 표시, A:충전제, C:정액제
    );

    return $userinfo;
}

// 인기검색어 입력
function insert_popular($field, $str)
{
    global $tkher;

    if(!in_array('mb_id', $field)) {
        $sql = " insert into {$tkher['popular_table']} set pp_word = '{$str}', pp_date = '".KAPP_TIME_YMD."', pp_ip = '{$_SERVER['REMOTE_ADDR']}' ";
        sql_queryG($sql, FALSE);
    }
}

// 문자열 암호화
function get_encrypt_string($str)
{
    if(defined('KAPP_STRING_ENCRYPT_FUNCTION') && KAPP_STRING_ENCRYPT_FUNCTION) {
        $encrypt = call_user_func(KAPP_STRING_ENCRYPT_FUNCTION, $str);
    } else {
        $encrypt = sql_password($str);
    }

    return $encrypt;
}

// 비밀번호 비교
function check_password($pass, $hash)
{
    $password = get_encrypt_string($pass);

    return ($password === $hash);
}

// 동일한 host url 인지
function check_url_host($url, $msg='', $return_url=KAPP_URL_T_)
{
    if(!$msg)
        $msg = 'url is no another url .';

    $p = @parse_url($url);
    $host = preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']);
    $is_host_check = false;

    if(stripos($url, 'http:') !== false) {
        if(!isset($p['scheme']) || !$p['scheme'] || !isset($p['host']) || !$p['host'])
            alert('url 정보가 올바르지 않습니다.', $return_url);
    }

    //php 5.6.29 이하 버전에서는 parse_url 버그가 존재함
    if ( (isset($p['host']) && $p['host']) && version_compare(PHP_VERSION, '5.6.29') < 0) {
        $bool_ch = false;
        foreach( array('user','host') as $key) {
            if ( isset( $p[ $key ] ) && strpbrk( $p[ $key ], ':/?#@' ) ) {
                $bool_ch = true;
            }
        }
        if( $bool_ch ){
            $regex = '/https?\:\/\/'.$host.'/i';
            if( ! preg_match($regex, $url) ){
                $is_host_check = true;
            }
        }
    }

    if ((isset($p['scheme']) && $p['scheme']) || (isset($p['host']) && $p['host']) || $is_host_check) {
        //if ($p['host'].(isset($p['port']) ? ':'.$p['port'] : '') != $_SERVER['HTTP_HOST']) {
        if ( ($p['host'] != $host) || $is_host_check ) {
            echo '<script>'.PHP_EOL;
            echo 'alert("url에 타 도메인을 지정할 수 없습니다.");'.PHP_EOL;
            echo 'document.location.href = "'.$return_url.'";'.PHP_EOL;
            echo '</script>'.PHP_EOL;
            echo '<noscript>'.PHP_EOL;
            echo '<p>'.$msg.'</p>'.PHP_EOL;
            echo '<p><a href="'.$return_url.'">돌아가기</a></p>'.PHP_EOL;
            echo '</noscript>'.PHP_EOL;
            exit;
        }
    }
}

// QUERY STRING 에 포함된 XSS 태그 제거
function clean_query_string($query, $amp=true)
{
    $qstr = trim($query);

    parse_str($qstr, $out);

    if(is_array($out)) {
        $q = array();

        foreach($out as $key=>$val) {
            $key = strip_tags(trim($key));
            $val = trim($val);

            switch($key) {
                case 'wr_id':
                    $val = (int)preg_replace('/[^0-9]/', '', $val);
                    $q[$key] = $val;
                    break;
                case 'sca':
                    $val = clean_xss_tags($val);
                    $q[$key] = $val;
                    break;
                case 'sfl':
                    $val = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $val);
                    $q[$key] = $val;
                    break;
                case 'stx':
                    $val = get_search_string($val);
                    $q[$key] = $val;
                    break;
                case 'sst':
                    $val = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $val);
                    $q[$key] = $val;
                    break;
                case 'sod':
                    $val = preg_match("/^(asc|desc)$/i", $val) ? $val : '';
                    $q[$key] = $val;
                    break;
                case 'sop':
                    $val = preg_match("/^(or|and)$/i", $val) ? $val : '';
                    $q[$key] = $val;
                    break;
                case 'spt':
                    $val = (int)preg_replace('/[^0-9]/', '', $val);
                    $q[$key] = $val;
                    break;
                case 'page':
                    $val = (int)preg_replace('/[^0-9]/', '', $val);
                    $q[$key] = $val;
                    break;
                case 'w':
                    $val = substr($val, 0, 2);
                    $q[$key] = $val;
                    break;
                case 'bo_table':
                    $val = preg_replace('/[^a-z0-9_]/i', '', $val);
                    $val = substr($val, 0, 20);
                    $q[$key] = $val;
                    break;
                case 'gr_id':
                    $val = preg_replace('/[^a-z0-9_]/i', '', $val);
                    $q[$key] = $val;
                    break;
                default:
                    $val = clean_xss_tags($val);
                    $q[$key] = $val;
                    break;
            }
        }

        if($amp)
            $sep = '&amp;';
        else
            $sep ='&';

        $str = http_build_query($q, '', $sep);
    } else {
        $str = clean_xss_tags($qstr);
    }

    return $str;
}

function get_device_change_url()
{
    $p = @parse_url(KAPP_URL_T_);
    $href = $p['scheme'].'://'.$p['host'];
    if(isset($p['port']) && $p['port'])
        $href .= ':'.$p['port'];
    $href .= $_SERVER['SCRIPT_NAME'];

    $q = array();
    $device = 'device='.(KAPP_IS_MOBILE ? 'pc' : 'mobile');

    if($_SERVER['QUERY_STRING']) {
        foreach($_GET as $key=>$val) {
            if($key == 'device')
                continue;

            $key = strip_tags($key);
            $val = strip_tags($val);

            if($key && $val)
                $q[$key] = $val;
        }
    }

    if(!empty($q)) {
        $query = http_build_query($q, '', '&amp;');
        $href .= '?'.$query.'&amp;'.$device;
    } else {
        $href .= '?'.$device;
    }

    return $href;
}

// 발신번호 유효성 체크
function check_vaild_callback($callback){
   $_callback = preg_replace('/[^0-9]/','', $callback);

   /**
   * 1588 로시작하면 총8자리인데 7자리라 차단
   * 02 로시작하면 총9자리 또는 10자리인데 11자리라차단
   * 1366은 그자체가 원번호이기에 다른게 붙으면 차단
   * 030으로 시작하면 총10자리 또는 11자리인데 9자리라차단
   */

   if( substr($_callback,0,4) == '1588') if( strlen($_callback) != 8) return false;
   if( substr($_callback,0,2) == '02')   if( strlen($_callback) != 9  && strlen($_callback) != 10 ) return false;
   if( substr($_callback,0,3) == '030')  if( strlen($_callback) != 10 && strlen($_callback) != 11 ) return false;

   if( !preg_match("/^(02|0[3-6]\d|01(0|1|3|5|6|7|8|9)|070|080|007)\-?\d{3,4}\-?\d{4,5}$/",$_callback) &&
       !preg_match("/^(15|16|18)\d{2}\-?\d{4,5}$/",$_callback) ){
             return false;
   } else if( preg_match("/^(02|0[3-6]\d|01(0|1|3|5|6|7|8|9)|070|080)\-?0{3,4}\-?\d{4}$/",$_callback )) {
             return false;
   } else {
             return true;
   }
}

// 문자열 암복호화
class str_encrypt
{
    var $salt;
    var $lenght;

    function __construct($salt='')
    {
        if(!$salt)
            $this->salt = md5(preg_replace('/[^0-9A-Za-z]/', substr(KAPP_MYSQL_USER, -1), KAPP_MYSQL_PASSWORD));
        else
            $this->salt = $salt;

        $this->length = strlen($this->salt);
    }

    function encrypt($str)
    {
        $length = strlen($str);
        $result = '';

        for($i=0; $i<$length; $i++) {
            $char    = substr($str, $i, 1);
            $keychar = substr($this->salt, ($i % $this->length) - 1, 1);
            $char    = chr(ord($char) + ord($keychar));
            $result .= $char;
        }

        return base64_encode($result);
    }

    function decrypt($str) {
        $result = '';
        $str    = base64_decode($str);
        $length = strlen($str);

        for($i=0; $i<$length; $i++) {
            $char    = substr($str, $i, 1);
            $keychar = substr($this->salt, ($i % $this->length) - 1, 1);
            $char    = chr(ord($char) - ord($keychar));
            $result .= $char;
        }

        return $result;
    }
}

// 불법접근을 막도록 토큰을 생성하면서 토큰값을 리턴
function get_write_token($bo_table)
{
    $token = md5(uniqid(rand(), true));
    set_session('ss_write_'.$bo_table.'_token', $token);

    return $token;
}


// POST로 넘어온 토큰과 세션에 저장된 토큰 비교
function check_write_token($bo_table)
{
    if(!$bo_table)
        alert('Please use it in the correct way. check_write_token', KAPP_URL_T_);//올바른 방법으로 이용해 주십시오.

    $token = get_session('ss_write_'.$bo_table.'_token');
    set_session('ss_write_'.$bo_table.'_token', '');

    if(!$token || !$_REQUEST['token'] || $token != $_REQUEST['token'])
        alert('Please use it in the correct way.', KAPP_URL_T_);

    return true;
}

function get_call_func_cache($func, $args=array()){
    
    static $cache = array();

    $key = md5(serialize($args));

    if( isset($cache[$func]) && isset($cache[$func][$key]) ){
        return $cache[$func][$key];
    }

    $result = null;

    try{
        $cache[$func][$key] = $result = call_user_func_array($func, $args);
    } catch (Exception $e) {
        return null;
    }
    
    return $result;
}

// include 하는 경로에 data file 경로가 포함되어 있는지 체크합니다.
function is_include_path_check($path='')
{
    if( $path ){
        try {
            // whether $path is unix or not
            $unipath = strlen($path)==0 || $path{0}!='/';
            $unc = substr($path,0,2)=='\\\\'?true:false;
            // attempts to detect if path is relative in which case, add cwd
            if(strpos($path,':') === false && $unipath && !$unc){
                $path=getcwd().DIRECTORY_SEPARATOR.$path;
                if($path{0}=='/'){
                    $unipath = false;
                }
            }

            // resolve path parts (single dot, double dot and double delimiters)
            $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
            $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
            $absolutes = array();
            foreach ($parts as $part) {
                if ('.'  == $part){
                    continue;
                }
                if ('..' == $part) {
                    array_pop($absolutes);
                } else {
                    $absolutes[] = $part;
                }
            }
            $path = implode(DIRECTORY_SEPARATOR, $absolutes);
            // resolve any symlinks
            // put initial separator that could have been lost
            $path = !$unipath ? '/'.$path : $path;
            $path = $unc ? '\\\\'.$path : $path;
        } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            return false;
        }

        if( preg_match('/\/data\/(file|editor)\/[A-Za-z0-9_]{1,20}\//', $path) ){
            return false;
        }
    }

    return true;
}
?>