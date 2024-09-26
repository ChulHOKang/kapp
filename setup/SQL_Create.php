<?php
include '../modu_shop/coupon/tkher_db_lib.php';		
include '../modu_shop/coupon/tkher_dbcon_Table.php'; 

function Aboard_admin($tab) {
    $SQL = "
        CREATE TABLE kapp_aboard_admin (
        no int(11) auto_increment NOT NULL,
        id varchar(15) DEFAULT NULL,
        password varchar(15) DEFAULT NULL,
        url varchar(70) DEFAULT NULL,
        db_host varchar(50) DEFAULT NULL,
        db_user varchar(40) DEFAULT NULL,
        db_password varchar(20) DEFAULT NULL,
        db_database varchar(30) DEFAULT NULL,
        bbsname varchar(50) DEFAULT '',
        lev smallint(2) DEFAULT 0,
        bbstitle varchar(50) DEFAULT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Aboard_infor($tab) {
    $SQL = "
        CREATE TABLE kapp_aboard_infor (
        no int(11) auto_increment NOT NULL,
        name varchar(50) DEFAULT NULL,
        table_name varchar(50) DEFAULT NULL,
        fileup int(11) DEFAULT NULL,
        in_date int(11) DEFAULT NULL,
        memo_gubun int(11) DEFAULT NULL,
        ip_gubun int(11) DEFAULT NULL,
        html_gubun int(11) DEFAULT NULL,
        imember varchar(15) DEFAULT NULL,
        home_url varchar(150) DEFAULT NULL,
        table_width varchar(5) DEFAULT NULL,
        list_table_set varchar(150) DEFAULT NULL,
        list_title_bgcolor varchar(7) DEFAULT NULL,
        list_title_font varchar(7) DEFAULT NULL,
        list_text_bgcolor varchar(7) DEFAULT NULL,
        list_text_font varchar(7) DEFAULT NULL,
        list_size int(11) DEFAULT NULL,
        detail_table_set varchar(150) DEFAULT NULL,
        detail_title_bgcolor varchar(7) DEFAULT NULL,
        detail_title_font varchar(7) DEFAULT NULL,
        detail_text_bgcolor varchar(7) DEFAULT NULL,
        detail_text_font varchar(7) DEFAULT NULL,
        detail_memo_bgcolor varchar(7) DEFAULT NULL,
        detail_memo_font varchar(7) DEFAULT NULL,
        input_table_set varchar(150) DEFAULT NULL,
        input_title_bgcolor varchar(7) DEFAULT NULL,
        input_title_font varchar(7) DEFAULT NULL,
        icon_home varchar(100) DEFAULT NULL,
        icon_prev varchar(100) DEFAULT NULL,
        icon_next varchar(100) DEFAULT NULL,
        icon_insert varchar(100) DEFAULT NULL,
        icon_update varchar(100) DEFAULT NULL,
        icon_delete varchar(100) DEFAULT NULL,
        icon_reply varchar(100) DEFAULT NULL,
        icon_list varchar(100) DEFAULT NULL,
        icon_search_list varchar(100) DEFAULT NULL,
        icon_search varchar(100) DEFAULT NULL,
        icon_submit varchar(100) DEFAULT NULL,
        icon_new varchar(100) DEFAULT NULL,
        icon_list_reply varchar(100) DEFAULT NULL,
        icon_memo varchar(100) DEFAULT NULL,
        icon_admin varchar(100) DEFAULT NULL,
        list_gubun int(11) DEFAULT NULL,
        connection_gubun int(11) DEFAULT NULL,
        top_html text DEFAULT NULL,
        bottom_html text DEFAULT NULL,
        grant_view int(2) DEFAULT 0,
        grant_write int(2) DEFAULT 0,
        movie char(1) DEFAULT NULL,
        title_color varchar(20) DEFAULT NULL,
        title_text_color varchar(20) DEFAULT NULL,
        security char(1) DEFAULT NULL,
        lev char(1) DEFAULT NULL,
        make_id varchar(20) NOT NULL DEFAULT '',
        make_club varchar(255) DEFAULT NULL,
        sunbun int(4) DEFAULT 0,
        memo text DEFAULT NULL
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Aboard_memo($tab) {
    $SQL = "
        CREATE TABLE kapp_aboard_memo (
        no int(11) auto_increment NOT NULL,
        board_name varchar(30) NOT NULL DEFAULT '',
        list_no int(11) NOT NULL DEFAULT 0,
        name varchar(20) NOT NULL,
        memo text DEFAULT NULL,
        in_date varchar(20) DEFAULT NULL,
        password varchar(15) DEFAULT NULL,
        id varchar(30) DEFAULT NULL
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Aboard_bbs($tab) {
    $SQL = "
        CREATE TABLE kapp_admin_bbs (
        no int(8) auto_increment NOT NULL,
        name varchar(20) DEFAULT NULL,
        comment varchar(100) DEFAULT NULL,
        skin varchar(30) NOT NULL DEFAULT 'modern',
        admin_icon char(1) NOT NULL DEFAULT 'N',
        guest_write char(1) NOT NULL DEFAULT 'N',
        is_notice char(1) NOT NULL DEFAULT 'N',
        is_secret char(1) NOT NULL DEFAULT 'N',
        bbs_level int(1) NOT NULL DEFAULT 9,
        upload_image char(1) NOT NULL DEFAULT 'N',
        up_image_size int(2) NOT NULL DEFAULT 1,
        upload_file char(1) NOT NULL DEFAULT 'N',
        up_file_size int(2) NOT NULL DEFAULT 2,
        width int(4) NOT NULL DEFAULT 600,
        cut int(3) DEFAULT 62,
        list_num int(2) DEFAULT 10,
        page_num int(2) DEFAULT 10,
        font_size int(2) NOT NULL DEFAULT 9,
        font_family varchar(10) NOT NULL DEFAULT '굴림',
        font_color varchar(10) NOT NULL DEFAULT '#000000',
        line_color varchar(10) NOT NULL DEFAULT '#eeeeee',
        top1 varchar(50) DEFAULT 'bbs_top.php',
        top2 text DEFAULT NULL,
        top3 text DEFAULT NULL,
        foot1 text DEFAULT NULL,
        foot2 text DEFAULT NULL,
        foot3 varchar(50) DEFAULT 'bbs_foot.php',
        memo text NOT NULL,
        uptime varchar(20) DEFAULT NULL,
        make_userid varchar(20) NOT NULL DEFAULT 'solpakan'
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Bbs_history($tab) {
    $SQL = "
        CREATE TABLE kapp_bbs_history (
        no int(11) auto_increment NOT NULL,
        id varchar(30) NOT NULL,
        pg_code char(50) NOT NULL,
        pg_name char(150) NOT NULL,
        build_time int(11) DEFAULT NULL,
        comment text DEFAULT NULL,
        cid varchar(30) DEFAULT NULL,
        ctime timestamp NULL DEFAULT ".current_timestamp()."
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Coin_view($tab) {
    $SQL = "
        CREATE TABLE kapp_coin_view (
        seqno int(11) auto_increment NOT NULL,
        id varchar(100) NOT NULL,
        makeid varchar(100) NOT NULL,
        title varchar(255) NOT NULL,
        url varchar(255) NOT NULL DEFAULT '',
        up_day varchar(25) NOT NULL,
        ip varchar(15) NOT NULL,
        host varchar(100) NOT NULL,
        cd varchar(10) NOT NULL,
        cdname varchar(30) NOT NULL,
        view_cnt int(13) NOT NULL DEFAULT 0,
        type varchar(10) NOT NULL
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Ip_info($tab) {
    $SQL = "
        CREATE TABLE kapp_ip_info (
        no int(10) auto_increment NOT NULL,
        ip1 varchar(30) NOT NULL DEFAULT '',
        ip2 varchar(30) NOT NULL DEFAULT '',
        ipno1 bigint(11) NOT NULL DEFAULT 0,
        ipno2 bigint(11) NOT NULL DEFAULT 0,
        country_cd varchar(5) DEFAULT NULL,
        country_name varchar(20) DEFAULT NULL
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Job_link_table($tab) {
    $SQL = "
        CREATE TABLE kapp_job_link_table (
        seqno int(11) auto_increment NOT NULL,
        job_name varchar(200) DEFAULT NULL,
        user_name varchar(200) DEFAULT NULL,
        job_addr text DEFAULT NULL,
        num varchar(50) DEFAULT NULL,
        aboard_no varchar(50) DEFAULT NULL,
        jong char(1) DEFAULT NULL,
        job_level char(1) DEFAULT NULL,
        job_group varchar(200) DEFAULT NULL,
        job_group_code char(30) DEFAULT NULL,
        price int(11) DEFAULT 0,
        user_id varchar(15) DEFAULT NULL,
        club_url varchar(50) DEFAULT NULL,
        up_day timestamp NULL DEFAULT ".current_timestamp().",
        memo varchar(255) DEFAULT NULL,
        view_cnt int(13) DEFAULT 0,
        ip varchar(255) DEFAULT NULL
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Visit_sum($tab) {
    $SQL = "
        CREATE TABLE kapp_visit_sum (
        seqno int(11) auto_increment NOT NULL,
        vs_date date NOT NULL DEFAULT '0000-00-00',
        vs_count int(11) NOT NULL DEFAULT 0,
        visit_all int(11) NOT NULL DEFAULT 0
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Menuskin($tab) {
    $SQL = "
        CREATE TABLE kapp_menuskin (
        seqno int(11) auto_increment NOT NULL,
        user_id varchar(30) DEFAULT NULL,
        sys_pg varchar(30) DEFAULT NULL,
        sys_subtit varchar(50) NOT NULL DEFAULT '',
        sys_link varchar(100) DEFAULT NULL,
        bgcolor varchar(10) DEFAULT NULL,
        fontcolor varchar(10) DEFAULT NULL,
        fontface varchar(10) DEFAULT NULL,
        fontsize varchar(10) DEFAULT NULL,
        imgtype1 varchar(100) DEFAULT NULL,
        imgtype2 varchar(100) DEFAULT NULL,
        imgtype3 varchar(100) DEFAULT NULL,
        Mmemo varchar(100) DEFAULT NULL,
        club_url varchar(15) DEFAULT NULL,
        up_day timestamp NULL DEFAULT ".current_timestamp()."
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Sajin_group($tab) {
    $SQL = "
        CREATE TABLE kapp_sajin_group (
        no int(10) auto_increment NOT NULL,
        g_code varchar(30) DEFAULT NULL,
        g_name varchar(30) NOT NULL DEFAULT '',
        g_class_code varchar(30) DEFAULT NULL,
        g_class_name varchar(30) DEFAULT NULL,
        userid varchar(15) DEFAULT NULL,
        lev char(3) NOT NULL DEFAULT '0',
        up_day datetime DEFAULT ".current_timestamp()."
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Sajin_jpg($tab) {
    $SQL = "
        CREATE TABLE kapp_sajin_jpg (
        no int(11) auto_increment NOT NULL,
        jpg_name varchar(30) NOT NULL,
        jpg_file varchar(100) NOT NULL,
        jpg_memo varchar(200) NOT NULL,
        group_code varchar(30) DEFAULT NULL,
        group_name varchar(30) DEFAULT NULL,
        view_no int(11) DEFAULT 99,
        g_file1 varchar(100) DEFAULT NULL,
        g_file2 varchar(100) DEFAULT NULL,
        g_file3 varchar(100) DEFAULT NULL,
        day datetime DEFAULT current_timestamp(),
        url varchar(200) DEFAULT NULL,
        userid varchar(30) NOT NULL
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Sys_menu_bom($tab) {
    $SQL = "
        CREATE TABLE kapp_sys_menu_bom (
        seqno int(11) auto_increment NOT NULL,
        sys_userid varchar(30) DEFAULT NULL,
        sys_pg varchar(50) NOT NULL,
        sys_rcnt int(11) DEFAULT 0,
        sys_disno int(11) DEFAULT 0,
        sys_subtit varchar(50) NOT NULL,
        sys_link varchar(255) NOT NULL,
        sys_level varchar(50) DEFAULT NULL,
        sys_menu varchar(255) NOT NULL,
        sys_submenu varchar(255) NOT NULL,
        sys_cnt int(11) DEFAULT 0,
        sys_memo text DEFAULT NULL,
        sys_board_num int(12) DEFAULT NULL,
        sys_menutit varchar(100) DEFAULT NULL,
        view_lev char(1) DEFAULT NULL,
        view_cnt int(11) DEFAULT 0,
        tit_gubun char(1) DEFAULT NULL,
        book_num varchar(50) DEFAULT NULL,
        up_day timestamp NULL DEFAULT current_timestamp(),
        sys_comp varchar(200) DEFAULT NULL,
        ip varchar(20) DEFAULT NULL
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Table10($tab) {
    $SQL = "
        CREATE TABLE kapp_table10 (
        seqno int(13) auto_increment NOT NULL,
        group_code char(20) NOT NULL DEFAULT 'xxxx',
        group_name char(20) NOT NULL DEFAULT 'ETC(기타)',
        disno int(5) NOT NULL,
        tab_enm varchar(30) NOT NULL,
        tab_hnm varchar(50) NOT NULL,
        fld_enm varchar(20) NOT NULL,
        fld_hnm varchar(30) NOT NULL,
        fld_type varchar(10) NOT NULL,
        fld_len int(10) NOT NULL,
        if_line tinyint(3) DEFAULT NULL,
        if_type char(255) DEFAULT NULL,
        if_data text DEFAULT NULL,
        relation_data text DEFAULT NULL,
        memo text NOT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(30) NOT NULL,
        grant_write varchar(3) DEFAULT NULL,
        grant_view varchar(3) DEFAULT NULL,
        table_yn varchar(3) DEFAULT NULL,
        sqltable text DEFAULT NULL
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function table10_group($tab) {
    $SQL = "
        CREATE TABLE kapp_table10_group (
        seqno int(13) auto_increment NOT NULL,
        group_code char(20) NOT NULL,
        group_name char(20) NOT NULL,
        memo text NOT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(30) NOT NULL
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Table10_pg($tab) {
    $SQL = "
        CREATE TABLE kapp_table10_pg (
        seqno int(13) auto_increment NOT NULL,
        pg_code char(30) NOT NULL,
        pg_name char(30) NOT NULL,
        tab_enm varchar(30) NOT NULL,
        tab_hnm varchar(50) NOT NULL,
        item_cnt tinyint(3) DEFAULT NULL,
        item_array text NOT NULL,
        if_type varchar(255) DEFAULT NULL,
        if_data text DEFAULT NULL,
        pop_data text DEFAULT NULL,
        relation_data text DEFAULT NULL,
        relation_type varchar(255) DEFAULT NULL,
        memo text DEFAULT NULL,
        group_code char(20) DEFAULT NULL,
        group_name char(20) DEFAULT NULL,
        disno int(5) DEFAULT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(30) NOT NULL,
        del varchar(1) DEFAULT NULL,
        del_date datetime DEFAULT NULL
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Tkher_main_img($tab) {
    $SQL = "
        CREATE TABLE kapp_tkher_main_img (
        no int(11) auto_increment NOT NULL,
        jpg_name varchar(30) NOT NULL,
        jpg_file varchar(200) NOT NULL,
        jpg_memo varchar(200) NOT NULL,
        group_code varchar(20) DEFAULT NULL,
        group_name varchar(20) DEFAULT NULL,
        view_no int(4) DEFAULT 99,
        g_file1 varchar(100) DEFAULT NULL,
        g_file2 varchar(100) DEFAULT NULL,
        g_file3 varchar(100) DEFAULT NULL,
        day timestamp NULL DEFAULT current_timestamp(),
        url varchar(200) DEFAULT NULL,
        userid varchar(30) NOT NULL,
        delay_time int(11) NOT NULL DEFAULT 3000
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Tkher_my_control($tab) {
    $SQL = "
        CREATE TABLE kapp_tkher_my_control (
        seqno int(11) auto_increment NOT NULL,
        userid varchar(30) NOT NULL,
        slide_time int(11) NOT NULL DEFAULT 3000,
        fld1 varchar(50) NOT NULL,
        fld2 varchar(50) NOT NULL,
        fld3 varchar(50) NOT NULL,
        fld4 varchar(50) NOT NULL,
        fld5 decimal(5,0) NOT NULL
        , primary key(seqno) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Url_group($tab) {
    $SQL = "
        CREATE TABLE kapp_url_group (
        no int(10) auto_increment NOT NULL,
        g_name varchar(200) NOT NULL DEFAULT '',
        g_num varchar(50) DEFAULT NULL,
        g_class varchar(20) DEFAULT NULL,
        g_class_num int(11) DEFAULT NULL,
        user_id varchar(15) DEFAULT NULL,
        lev char(3) NOT NULL DEFAULT '7'
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Webeditor($tab) {
    $SQL = "
        CREATE TABLE kapp_webeditor (
        seq int(11) auto_increment NOT NULL,
        num varchar(50) NOT NULL,
        user varchar(30) DEFAULT 'solpakan',
        h_lev char(1) DEFAULT NULL,
        id varchar(39) DEFAULT NULL,
        title varchar(255) NOT NULL DEFAULT '',
        align varchar(255) DEFAULT NULL,
        content text DEFAULT NULL,
        reply text DEFAULT NULL,
        date timestamp NULL DEFAULT current_timestamp(),
        backgroundcolor varchar(7) DEFAULT NULL,
        backgroundimage varchar(100) DEFAULT NULL,
        diff char(1) DEFAULT NULL,
        book_name varchar(50) DEFAULT NULL,
        view_cnt int(13) DEFAULT NULL,
        up_file varchar(255) DEFAULT NULL,
        del char(1) DEFAULT '0'
        , primary key(seq) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Webeditor_comment($tab) {
    $SQL = "
        CREATE TABLE kapp_webeditor_comment (
        seq int(11) auto_increment NOT NULL,
        num varchar(50) NOT NULL,
        user varchar(30) DEFAULT NULL,
        h_lev char(1) DEFAULT NULL,
        doc_userid varchar(30) DEFAULT NULL,
        title varchar(255) DEFAULT NULL,
        align varchar(10) DEFAULT NULL,
        content text DEFAULT NULL,
        reply text DEFAULT NULL,
        date datetime DEFAULT current_timestamp(),
        backgroundcolor varchar(7) DEFAULT NULL,
        backgroundimage varchar(100) DEFAULT NULL,
        diff char(1) DEFAULT NULL,
        book_name varchar(50) DEFAULT NULL,
        view_cnt int(13) DEFAULT NULL,
        del char(1) DEFAULT '0'
        , primary key(seq) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Kapp_member($tab) {
    $SQL = "
        CREATE TABLE kapp_member (
        mb_no int(11) auto_increment NOT NULL,
        mb_id varchar(30) NOT NULL,
        mb_sn varchar(255) DEFAULT NULL,
        mb_password varchar(255) DEFAULT NULL,
        mb_name varchar(255) DEFAULT NULL,
        mb_nick varchar(255) DEFAULT NULL,
        mb_nick_date date DEFAULT '0000-00-00',
        mb_email varchar(255) NOT NULL,
        mb_photo varchar(255) DEFAULT NULL,
        mb_homepage varchar(255) DEFAULT NULL,
        mb_level tinyint(4) DEFAULT 0,
        mb_sex char(1) DEFAULT NULL,
        mb_birth varchar(255) DEFAULT NULL,
        mb_tel varchar(255) DEFAULT NULL,
        mb_hp varchar(255) DEFAULT NULL,
        mb_certify varchar(20) DEFAULT NULL,
        mb_adult tinyint(4) NOT NULL DEFAULT 0,
        mb_dupinfo varchar(255) DEFAULT NULL,
        mb_zip1 char(3) DEFAULT NULL,
        mb_zip2 char(3) DEFAULT NULL,
        mb_addr1 varchar(255) DEFAULT NULL,
        mb_addr2 varchar(255) DEFAULT NULL,
        mb_addr3 varchar(255) DEFAULT NULL,
        mb_addr_jibeon varchar(255) DEFAULT NULL,
        mb_signature text DEFAULT NULL,
        mb_recommend varchar(255) DEFAULT NULL,
        mb_point int(11) DEFAULT 0,
        mb_today_login datetime DEFAULT '0000-00-00 00:00:00',
        mb_login_ip varchar(255) DEFAULT NULL,
        mb_datetime datetime DEFAULT current_timestamp(),
        mb_ip varchar(255) DEFAULT NULL,
        mb_leave_date varchar(8) DEFAULT NULL,
        mb_intercept_date varchar(8) DEFAULT NULL,
        mb_email_certify datetime DEFAULT '0000-00-00 00:00:00',
        mb_email_certify2 varchar(255) DEFAULT NULL,
        mb_memo text DEFAULT NULL,
        mb_lost_certify varchar(255) DEFAULT NULL,
        mb_mailling tinyint(4) DEFAULT 0,
        mb_sms tinyint(4) DEFAULT 0,
        mb_open tinyint(4) DEFAULT 0,
        mb_open_date date DEFAULT '0000-00-00',
        mb_profile text DEFAULT NULL,
        mb_memo_call varchar(255) DEFAULT NULL
        , primary key(mb_no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "<br>Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "<br>Create Success : $tab";
    }
}

function Log_info($tab) {
    $SQL = "
        CREATE TABLE kapp_log_info (
        no int(10) auto_increment NOT NULL,
        url varchar(255) DEFAULT NULL,
        name varchar(100) NOT NULL,
        id varchar(100) NOT NULL,
        uptime datetime NOT NULL DEFAULT current_timestamp(),
        ip varchar(20) DEFAULT NULL,
        msg text DEFAULT NULL,
        country_cd char(5) DEFAULT NULL,
        country_name char(50) DEFAULT NULL,
        type char(10) DEFAULT NULL,
        start_pg char(255) DEFAULT NULL,
        email varchar(255) DEFAULT NULL
        , primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo "$tab Table Create Invalid query: " . $SQL;
        echo "Please check if the $tab table already exists.";//kapp_member table이 이미 존재하는지 확인 바랍니다
    } else {
        echo "Create Success : $tab";
    }
}

?>