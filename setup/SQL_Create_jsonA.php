<?php

/* 
   DB_Table_CreateA.php : 테이블 생성 후 'Table List' 버턴을 클릭 하면 테이블 목록을 출력 한다. - SQL_Create_jsonA.php을 호출.
   처음 셋업시에 -> kapp_dbcon_create.php 에서 테이블을 생성한다.  중요
   SQL_Create_jsonA.php - DB_Table_CreateA.php 에서 호출한다.
   ajax echo 출력을 위한 json_encode 추가한 프로그램 
*/

/* $table_array = array();
$table_array = ['aboard_admin', 'aboard_infor', 'aboard_memo', 'admin_bbs', 'bbs_history', 'coin_view', 'ip_info', 'job_link_table', 'visit_sum', 'menuskin', 'sajin_group', 'sajin_jpg', 'sys_menu_bom', 'table10', 'table10_group', 'table10_pg', 'tkher_main_img', 'tkher_my_control', 'url_group', 'webeditor', 'webeditor_comment', 'member', 'log_info', 'point', 'config', 'visit', 'ap_bbs', 'e_list', 'pri_contect', 'project', 'tkher_content']; */

	if( $_SESSION['mb_level'] < 8) {
		m_("Approche error---mb_level:".$member['mb_level']);
		exit;
		//echo "<script>window.open( './index.php' , '_self');</script>";
	}
	$admin_id = 'admin'; //$member['mb_id'];

function Delete_tableX($_prefix, $tab) {
    $kapp_tab = $_prefix.$tab;
    $SQL = " drop table ".$kapp_tab." ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");
    } else {
        m_("Delete Success : $tab");
    }
}

function Aboard_admin($t_head, $tab) {
    /* m_("Create Success : $tab");
    exit; */
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."aboard_admin (
        no int(11) auto_increment NOT NULL,
        id varchar(50) DEFAULT NULL,
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
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");

        $query = "
        INSERT INTO `".$t_head."aboard_admin` (`no`, `id`, `password`, `url`, `db_host`, `db_user`, `db_password`, `db_database`, `bbsname`, `lev`, `bbstitle`) VALUES (1, 'admin', '1004', 'menu', '', '', '', '', 'kapp', 8, 'Manager')
        ";

        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");//table이 이미 존재하는지 확인 바랍니다
        } else {
            m_("Create Success and Record Create Success : $tab");
        }
    }
}

function Aboard_infor($t_head, $tab) {
	global $admin_id;
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."aboard_infor (
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
        make_id varchar(50) NOT NULL DEFAULT '',
        make_club varchar(255) DEFAULT NULL,
        sunbun int(4) DEFAULT 0,
        memo text DEFAULT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {

		//$admin_id
        m_("Create Success : $tab");
    }
}

function Aboard_memo($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."aboard_memo (
        no int(11) auto_increment NOT NULL,
        board_name varchar(50) NOT NULL DEFAULT '',
        list_no int(11) NOT NULL DEFAULT 0,
        name varchar(50) NOT NULL,
        memo text DEFAULT NULL,
        in_date varchar(20) DEFAULT NULL,
        password varchar(15) DEFAULT NULL,
        id varchar(50) DEFAULT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Admin_bbs($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."admin_bbs (
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
        make_userid varchar(50) NOT NULL DEFAULT 'solpakan'
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Bbs_history($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."bbs_history (
        no int(11) auto_increment NOT NULL,
        id varchar(50) NOT NULL,
        pg_code char(50) NOT NULL,
        pg_name char(150) NOT NULL,
        build_time int(11) DEFAULT NULL,
        comment text DEFAULT NULL,
        cid varchar(50) DEFAULT NULL,
        ctime timestamp NULL DEFAULT current_timestamp()
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Coin_view($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."coin_view (
        seqno int(11) auto_increment NOT NULL,
        id varchar(50) NOT NULL,
        makeid varchar(50) NOT NULL,
        title varchar(255) NOT NULL,
        url varchar(255) NOT NULL DEFAULT '',
        up_day varchar(25) NOT NULL,
        ip varchar(15) NOT NULL,
        host varchar(100) NOT NULL,
        cd varchar(10) NOT NULL,
        cdname varchar(30) NOT NULL,
        view_cnt int(13) NOT NULL DEFAULT 0,
        type varchar(10) NOT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Ip_info($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."ip_info (
        no int(10) auto_increment NOT NULL,
        ip1 varchar(30) NOT NULL DEFAULT '',
        ip2 varchar(30) NOT NULL DEFAULT '',
        ipno1 bigint(11) NOT NULL DEFAULT 0,
        ipno2 bigint(11) NOT NULL DEFAULT 0,
        country_cd varchar(5) DEFAULT NULL,
        country_name varchar(20) DEFAULT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Visit_sum($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."visit_sum (
        seqno int(11) auto_increment NOT NULL,
        vs_date date NOT NULL DEFAULT '0000-00-00',
        vs_count int(11) NOT NULL DEFAULT 0,
        visit_all int(11) NOT NULL DEFAULT 0,
        PRIMARY KEY (seqno),
        UNIQUE KEY vs_date (vs_date) USING BTREE,
        KEY index1 (vs_count)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Menuskin($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."menuskin (
        seqno int(11) auto_increment NOT NULL,
        user_id varchar(50) DEFAULT NULL,
        sys_pg varchar(50) DEFAULT NULL,
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
        club_url varchar(100) DEFAULT NULL,
        up_day timestamp NULL DEFAULT current_timestamp()
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Sajin_group($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."sajin_group (
        no int(10) auto_increment NOT NULL,
        g_code varchar(50) DEFAULT NULL,
        g_name varchar(50) NOT NULL DEFAULT '',
        g_class_code varchar(50) DEFAULT NULL,
        g_class_name varchar(50) DEFAULT NULL,
        userid varchar(50) DEFAULT NULL,
        lev char(3) NOT NULL DEFAULT '0',
        up_day datetime DEFAULT current_timestamp()
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Sajin_jpg($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."sajin_jpg (
        no int(11) auto_increment NOT NULL,
        jpg_name varchar(50) NOT NULL,
        jpg_file varchar(100) NOT NULL,
        jpg_memo varchar(200) NOT NULL,
        group_code varchar(50) DEFAULT NULL,
        group_name varchar(50) DEFAULT NULL,
        view_no int(11) DEFAULT 99,
        g_file1 varchar(100) DEFAULT NULL,
        g_file2 varchar(100) DEFAULT NULL,
        g_file3 varchar(100) DEFAULT NULL,
        day datetime DEFAULT current_timestamp(),
        url varchar(200) DEFAULT NULL,
        userid varchar(50) NOT NULL
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

//-----------------------------------------------------------------------
function Table10($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10 (
		seqno int(13) auto_increment NOT NULL,
        group_code varchar(50)  DEFAULT NULL,
        group_name varchar(50)  DEFAULT NULL,
        disno int(5) NOT NULL,
        tab_enm varchar(50) NOT NULL,
        tab_hnm varchar(50) NOT NULL,
        fld_enm varchar(50) NOT NULL,
        fld_hnm varchar(50) NOT NULL,
        fld_type varchar(20) NOT NULL,
        fld_len int(10) NOT NULL,
        if_line tinyint(3) DEFAULT NULL,
        if_type text DEFAULT NULL,
        if_data text DEFAULT NULL,
        relation_data text DEFAULT NULL,
        memo text NOT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(50) NOT NULL,
        grant_write int(3) DEFAULT 0,
        grant_view int(3) DEFAULT 0,
        table_yn varchar(3) DEFAULT NULL,
        sqltable text DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Table10_pg($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10_pg (
        seqno int(13) auto_increment NOT NULL,
        pg_code char(50) NOT NULL,
        pg_name char(50) NOT NULL,
        tab_enm varchar(50) NOT NULL,
        tab_hnm varchar(50) NOT NULL,
        item_cnt tinyint(3) DEFAULT NULL,
        item_array text NOT NULL,
        if_type text DEFAULT NULL,
        if_data text DEFAULT NULL,
        pop_data text DEFAULT NULL,
        relation_data text DEFAULT NULL,
        relation_type varchar(255) DEFAULT NULL,
        memo text DEFAULT NULL,
        group_code varchar(50) DEFAULT NULL,
        group_name varchar(50) DEFAULT NULL,
        disno int(5) DEFAULT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(50) NOT NULL,
        tab_mid varchar(50) NOT NULL,
        del varchar(1) DEFAULT NULL,
        grant_write int(3) DEFAULT 0,
        grant_view int(3) DEFAULT 0,
        del_date datetime DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}
function Job_link_table($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."job_link_table (
        seqno int(11) auto_increment NOT NULL,
        job_name varchar(200) DEFAULT NULL,
        user_name varchar(200) DEFAULT NULL,
        job_addr text DEFAULT NULL,
        num varchar(50) DEFAULT NULL,
        aboard_no varchar(50) DEFAULT NULL,
        jong char(1) DEFAULT NULL,
        job_level char(1) DEFAULT NULL,
        job_group varchar(200) DEFAULT NULL,
        job_group_code varchar(50) DEFAULT NULL,
        price int(11) DEFAULT 0,
        user_id varchar(50) DEFAULT NULL,
        club_url varchar(50) DEFAULT NULL,
        up_day timestamp NULL DEFAULT current_timestamp(),
        memo text DEFAULT NULL,
        view_cnt int(13) DEFAULT 0,
        ip varchar(255) DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Sys_menu_bom($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."sys_menu_bom (
        seqno int(11) auto_increment NOT NULL,
        sys_userid varchar(50) DEFAULT NULL,
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
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

//------- add 2025-03-17 테이블 컬럼 확인 필요 . 중요 -  보완완료2025-03-20
function Table10_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10_curl (
        `seqno` int(13) auto_increment NOT NULL,
  `host` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `group_code` varchar(50)  DEFAULT NULL,
  `group_name` varchar(50)  DEFAULT NULL,
  `disno` int(5) NOT NULL,
  `tab_enm` varchar(50) NOT NULL,
  `tab_hnm` varchar(50) NOT NULL,
  `fld_enm` varchar(50) NOT NULL,
  `fld_hnm` varchar(50) NOT NULL,
  `fld_type` varchar(20) NOT NULL,
  `fld_len` int(10) NOT NULL,
  `if_line` tinyint(3) DEFAULT NULL,
  `if_type` text DEFAULT NULL,
  `if_data` text DEFAULT NULL,
  `relation_data` text DEFAULT NULL,
  `memo` text DEFAULT NULL,
  `upday` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `userid` varchar(50) NOT NULL,
  `grant_write` varchar(3) DEFAULT NULL,
  `grant_view` varchar(3) DEFAULT NULL,
  `table_yn` varchar(3) DEFAULT NULL,
  `sqltable` text DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Table10_pg_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10_pg_curl (
        `seqno` int(13) auto_increment NOT NULL,
  `host` varchar(100) NOT NULL,
  `pg_code` char(50) NOT NULL,
  `pg_name` char(50) NOT NULL,
  `tab_enm` varchar(50) NOT NULL,
  `tab_hnm` varchar(50) NOT NULL,
  `item_cnt` tinyint(3) DEFAULT NULL,
  `item_array` text NOT NULL,
  `if_type` text DEFAULT NULL,
  `if_data` text DEFAULT NULL,
  `pop_data` text DEFAULT NULL,
  `relation_data` text DEFAULT NULL,
  `relation_type` varchar(255) DEFAULT NULL,
  `memo` text DEFAULT NULL,
  `group_code` varchar(50) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `disno` int(5) DEFAULT NULL,
  `upday` timestamp NOT NULL DEFAULT current_timestamp(),
  `userid` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `del` varchar(1) DEFAULT NULL,
  `del_date` datetime DEFAULT NULL,
  `sys_link` varchar(255) NOT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Job_link_table_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."job_link_table_curl (
        `seqno` int(11) auto_increment NOT NULL,
		`host` varchar(100) NOT NULL,
  `kapp_server` varchar(100) DEFAULT NULL,
  `link_title` varchar(200) DEFAULT NULL,
  `link_url` text DEFAULT NULL,
  `link_type` char(1) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `up_day` timestamp NULL DEFAULT current_timestamp(),
  `memo` text DEFAULT NULL,
  `user_ip` varchar(255) DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function Sys_menu_bom_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."sys_menu_bom_curl (
        `seqno` int(11) auto_increment NOT NULL,
  `host` varchar(100) DEFAULT NULL,
  `sys_userid` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sys_pg` varchar(50) NOT NULL,
  `sys_rcnt` int(11) DEFAULT 0,
  `sys_disno` int(11) DEFAULT 0,
  `sys_subtit` varchar(50) DEFAULT NULL,
  `sys_link` varchar(250) NOT NULL,
  `sys_level` varchar(50) DEFAULT NULL,
  `sys_menu` varchar(100) NOT NULL,
  `sys_submenu` varchar(100) NOT NULL,
  `sys_cnt` int(11) DEFAULT 0,
  `sys_memo` text DEFAULT NULL,
  `sys_file` varchar(50) DEFAULT NULL,
  `sys_menutit` varchar(100) DEFAULT NULL,
  `view_lev` char(1) DEFAULT NULL,
  `view_cnt` int(11) DEFAULT 0,
  `tit_gubun` char(1) DEFAULT NULL,
  `book_num` varchar(50) DEFAULT NULL,
  `up_day` timestamp NULL DEFAULT current_timestamp(),
  `ip` varchar(20) DEFAULT NULL,
  `bgcolor` varchar(10) DEFAULT NULL,
  `fontcolor` varchar(10) DEFAULT NULL,
  `fontface` varchar(10) DEFAULT NULL,
  `fontsize` varchar(10) DEFAULT NULL,
  `imgtype1` varchar(100) DEFAULT NULL,
  `imgtype2` varchar(100) DEFAULT NULL,
  `imgtype3` varchar(100) DEFAULT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        echo " - Create  Success : $tab";
    }
}

function table10_group($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."table10_group (
        seqno int(13) auto_increment NOT NULL,
        group_code varchar(50) NOT NULL,
        group_name varchar(50) NOT NULL,
        memo text NOT NULL,
        upday timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        userid varchar(50) NOT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Tkher_main_img($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."tkher_main_img (
        no int(11) auto_increment NOT NULL,
        jpg_name varchar(50) NOT NULL,
        jpg_file varchar(200) NOT NULL,
        jpg_memo varchar(200) NOT NULL,
        group_code varchar(50) DEFAULT NULL,
        group_name varchar(50) DEFAULT NULL,
        view_no int(4) DEFAULT 99,
        g_file1 varchar(100) DEFAULT NULL,
        g_file2 varchar(100) DEFAULT NULL,
        g_file3 varchar(100) DEFAULT NULL,
        day timestamp NULL DEFAULT current_timestamp(),
        url varchar(200) DEFAULT NULL,
        userid varchar(50) NOT NULL,
        delay_time int(11) NOT NULL DEFAULT 3000
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");

        $query = "
        INSERT INTO `".$t_head."tkher_main_img` (`no`, `jpg_name`, `jpg_file`, `jpg_memo`, `group_code`, `group_name`, `view_no`, `g_file1`, `g_file2`, `g_file3`, `day`, `url`, `userid`, `delay_time`) VALUES
        (81, 'Developer Level', 'ma1.jpg', 'Beginner<br>\r\nIntermediate<br>\r\nAdvanced<br>\r\nExp', 'main', 'main', 5, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (82, 'App Generator My Page', 'ma2.jpg', 'My Album<br>\r\nSchedule<br>\r\nAccount Book<br>\r\nMy Menu Design', 'main', 'main', 6, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (98, 'Menu Make', 'ma4.jpg', 'My Menu Design<br>\r\nTree Menu Create<br>\r\nProgram Make and Source Code DownLoad<br>\r\nProgram Link<br>\r\nPopUp Menu Create<br>\r\nSource Code DownLoad', 'main', 'main', 1, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (86, 'App Generator My Page', '20171022_175759m.jpg', '이것 알아야하는이유?<br>\r\n나의 미래를 설계한다면 이것은 필수다.<br>\r\n나의 상상력을 발휘할려면 최소한 이것은 기본으로 알아야한다.<br>\r\n이것은 미래의시스템이다.<br>\r\n이것을 모르면 반드시 경쟁에서 밀린다.<br>\r\n이것에 투자할 시간은 하루면 충분하다.<br>\r\n이것은 시작이다. 창의력를 발휘하기 위해.', 'main', 'main', 12, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (87, 'Program Generation', 'bg_proj01.jpg', 'Beginner<br>\r\nMiddle<br>\r\nMaster<br>\r\nSource Code DownLoad', 'main', 'main', 99, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (88, 'Relationship', 'bg_proj02.jpg', 'Table Design<br>\r\nRelationship<br>\r\nColumn Move<br>\r\nSource Code DownLoad', 'main', 'main', 99, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (89, 'Table Design', 'bg_proj03.jpg', 'Column Name<br>\r\nType<br>\r\nLength<br>\r\nColumn Attribute<br>\r\nSource Code DownLoad', 'main', 'main', 4, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (91, 'Column Attribute', 'bg_proj05.jpg', 'Column Attribute<br>\r\nradio button<br>\r\ncheck box<br>\r\nList box<br>\r\nPopup Window<br>\r\nFormula<br>\r\nTable Relationship<br>\r\nSource Code DownLoad', 'main', 'main', 5, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (92, 'Column Formula', 'bg_proj06.jpg', 'Column Formula<br>\r\nA-column=B-Column+C-column<br>\r\nA=B*C<br>\r\nPrice=unit price * count<br>\r\nSource Code DownLoad', 'main', 'main', 99, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (93, 'App Generator PopUp Window', 'bg_proj07.jpg', 'App Generator PopUp Window<br>\r\nColumn Attribute<br>\r\nColumn Move<br>\r\nSource Code DownLoad\r\n', 'main', 'main', 8, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (94, 'Table Permission', 'bg_proj04.jpg', 'Table Permission<br>\r\nRead<br>\r\nWrite<br>\r\nSource Code DownLoad\r\n', 'main', 'main', 3, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (95, 'App Generator Tree Menu Make', 'bg_proj09.jpg', 'App Generator Tree Menu Make<br>\r\nTree Menu<br>\r\nPopUp Menu <br>\r\nSource Code DownLoad', 'main', 'main', 3, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (96, 'App Generator Note', 'bg_proj10.jpg', 'App Generator Note Tree<br>\r\nNote create<br>\r\nEncryption,\r\nDecryption', 'main', 'main', 2, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (97, 'App Generator Board', 'bg_proj11.jpg', 'App Generator Board<br>\r\nTree Board Make<br>\r\nGeneral<br>\r\nStandard<br>\r\nOne line board', 'main', 'main', 99, NULL, NULL, NULL, NULL, NULL, 'tkher', 5000),
        (100, 'App Generator', '2_78281.jpg', 'App Generator<br>\r\nProgram Generator<br>\r\nSource Code DownLoad\r\n', 'main', 'main', 0, NULL, NULL, NULL, '2018-11-19 02:20:24', NULL, 'tkher', 3000)
        ";

        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
        } else {
            m_("Create Success and Record Create Success : $tab");
        }
    }
}

function Tkher_my_control($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."tkher_my_control (
        seqno int(11) auto_increment NOT NULL,
        userid varchar(50) NOT NULL,
        slide_time int(11) NOT NULL DEFAULT 3000,
        fld1 varchar(50) NOT NULL,
        fld2 varchar(50) NOT NULL,
        fld3 varchar(50) NOT NULL,
        fld4 varchar(50) NOT NULL,
        fld5 decimal(5,0) NOT NULL
        , primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");

        $query = "
        INSERT INTO `".$t_head."tkher_my_control` (`seqno`, `userid`, `slide_time`, `fld1`, `fld2`, `fld3`, `fld4`, `fld5`) VALUES
        (1, 'tkher', 6000, '', '', '', '', 0)
        ";
        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
        } else {
            m_("Create Success and Record Create Success : $tab");
        }
    }
}

function Url_group($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."url_group (
        no int(10) auto_increment NOT NULL,
        g_name varchar(200) NOT NULL DEFAULT '',
        g_num varchar(50) DEFAULT NULL,
        g_class varchar(20) DEFAULT NULL,
        g_class_num int(11) DEFAULT NULL,
        user_id varchar(50) DEFAULT NULL,
        lev char(3) NOT NULL DEFAULT '7'
        , primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Webeditor($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."webeditor (
        seq int(11) auto_increment NOT NULL,
        num varchar(50) NOT NULL,
        user varchar(30) DEFAULT 'solpakan',
        h_lev char(1) DEFAULT NULL,
        id varchar(50) DEFAULT NULL,
        title varchar(255) NOT NULL DEFAULT '',
        align varchar(255) DEFAULT NULL,
        content longblob  DEFAULT NULL,
        reply longblob  DEFAULT NULL,
        date timestamp NULL DEFAULT current_timestamp(),
        backgroundcolor varchar(7) DEFAULT NULL,
        backgroundimage varchar(100) DEFAULT NULL,
        diff char(1) DEFAULT NULL,
        book_name varchar(50) DEFAULT NULL,
        view_cnt int(13) DEFAULT NULL,
        up_file varchar(255) DEFAULT NULL,
        del char(1) DEFAULT '0'
        , primary key(seq) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Webeditor_comment($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."webeditor_comment (
        seq int(11) auto_increment NOT NULL,
        num varchar(50) NOT NULL,
        user varchar(50) DEFAULT NULL,
        h_lev char(1) DEFAULT NULL,
        doc_userid varchar(50) DEFAULT NULL,
        title varchar(255) DEFAULT NULL,
        align varchar(10) DEFAULT NULL,
        content longblob  DEFAULT NULL,
        reply longblob  DEFAULT NULL,
        date datetime DEFAULT current_timestamp(),
        backgroundcolor varchar(7) DEFAULT NULL,
        backgroundimage varchar(100) DEFAULT NULL,
        diff char(1) DEFAULT NULL,
        book_name varchar(50) DEFAULT NULL,
        view_cnt int(13) DEFAULT NULL,
        del char(1) DEFAULT '0'
        , primary key(seq) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Member($t_head, $tab) {
    $tab = $t_head.$tab;
    // 2024-03-26 mb_zip1 char(3) => char(10) 변경
    $SQL = "
			CREATE TABLE ".$table_prefix."member (
			  mb_no int(11) auto_increment NOT NULL,
			  mb_id varchar(50) NOT NULL,
			  mb_sn varchar(255) ,
			  mb_password varchar(255) NOT NULL,
			  mb_name varchar(255) NOT NULL,
			  mb_nick varchar(255) ,
			  mb_nick_date date,
			  mb_email varchar(255) NOT NULL,
			  mb_photo varchar(255) ,
			  mb_homepage varchar(255) ,
			  mb_level tinyint(4),
			  mb_sex char(1) ,
			  mb_birth varchar(255) ,
			  mb_tel varchar(255) ,
			  mb_hp varchar(255) ,
			  mb_certify varchar(20) ,
			  mb_adult tinyint(4) ,
			  mb_dupinfo varchar(255) ,
			  mb_zip1 char(4) ,
			  mb_zip2 char(4) ,
			  mb_addr1 varchar(255) ,
			  mb_addr2 varchar(255) ,
			  mb_addr3 varchar(255) ,
			  mb_addr_jibeon varchar(255) ,
			  mb_signature text,
			  mb_recommend varchar(255) ,
			  mb_point int(11) DEFAULT 0,
			  mb_today_login datetime,
			  mb_login_ip varchar(255) ,
			  mb_datetime datetime ,
			  mb_ip varchar(255) ,
			  mb_leave_date varchar(8) ,
			  mb_intercept_date varchar(8) ,
			  mb_email_certify datetime,
			  mb_email_certify2 varchar(255) ,
			  mb_memo text NOT NULL,
			  mb_lost_certify varchar(255),
			  mb_mailling tinyint(4),
			  mb_sms tinyint(4),
			  mb_open tinyint(4),
			  mb_open_date date,
			  mb_profile text,
			  mb_memo_call varchar(255),
			  mb_penalty int(11) DEFAULT 0,
			  mb_gpt_key varchar(255),
			  mb_gpt_model varchar(255)
			  , PRIMARY KEY (mb_no)
			  , UNIQUE KEY mb_id (mb_id)
			  , KEY mb_today_login (mb_today_login)
			  , KEY mb_datetime (mb_datetime)
			  , KEY mb_email (mb_email)
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Log_info($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."log_info (
        no int(10) auto_increment NOT NULL,
        url varchar(255) DEFAULT NULL,
        name varchar(100) NOT NULL,
        id varchar(50) NOT NULL,
        uptime datetime NOT NULL DEFAULT current_timestamp(),
        ip varchar(20) DEFAULT NULL,
        msg text DEFAULT NULL,
        country_cd char(5) DEFAULT NULL,
        country_name char(50) DEFAULT NULL,
        type char(10) DEFAULT NULL,
        start_pg char(255) DEFAULT NULL,
        email varchar(255) DEFAULT NULL,
        PRIMARY KEY (no),
        KEY no (no)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Point($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."point (
        po_id int(11) auto_increment NOT NULL,
        mb_id varchar(50) NOT NULL,
        po_datetime datetime DEFAULT current_timestamp(),
        po_title varchar(100) NOT NULL,
        po_content varchar(255) NOT NULL DEFAULT '',
        po_point int(11) NOT NULL DEFAULT 0,
        po_use_point int(11) NOT NULL DEFAULT 0,
        po_expired tinyint(4) NOT NULL DEFAULT 0,
        po_expire_date datetime DEFAULT current_timestamp(),
        po_mb_point int(11) NOT NULL DEFAULT 0,
        po_rel_table varchar(100) NOT NULL,
        po_rel_id varchar(50) NOT NULL,
        po_rel_action varchar(255) NOT NULL DEFAULT '',
        PRIMARY KEY (po_id),
        KEY index2 (po_expire_date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Config($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."config (
        kapp_title varchar(255) NOT NULL DEFAULT '',
        kapp_admin varchar(255) NOT NULL DEFAULT '',
        kapp_admin_email varchar(255) DEFAULT NULL,
        kapp_admin_email_name varchar(255) DEFAULT NULL,
        kapp_admin_level int(3) DEFAULT 8,
        kapp_use_point tinyint(4) DEFAULT 0,
        kapp_point_term int(11) DEFAULT 0,
        kapp_use_copy_log tinyint(4) DEFAULT 0,
        kapp_use_email_certify tinyint(4) DEFAULT 0,
        kapp_login_point int(11) DEFAULT 0,
        kapp_cut_name tinyint(4) DEFAULT 0,
        kapp_nick_modify int(11) DEFAULT 0,
        kapp_new_rows int(11) DEFAULT 0,
        kapp_read_point int(11) DEFAULT 0,
        kapp_write_point int(11) DEFAULT 0,
        kapp_comment_point int(11) DEFAULT 0,
        kapp_download_point int(11) DEFAULT 0,
        kapp_write_pages int(11) DEFAULT 0,
        kapp_mobile_pages int(11) DEFAULT 0,
        kapp_delay_sec int(11) DEFAULT 0,
        kapp_filter text DEFAULT NULL,
        kapp_possible_ip text DEFAULT NULL,
        kapp_intercept_ip text DEFAULT NULL,
        kapp_analytics text DEFAULT NULL,
        kapp_syndi_token varchar(255) DEFAULT NULL,
        kapp_syndi_except text DEFAULT NULL,
        kapp_register_level tinyint(4) DEFAULT 0,
        kapp_register_point int(11) DEFAULT 0,
        kapp_use_recommend tinyint(4) DEFAULT 0,
        kapp_recommend_point int(11) DEFAULT 0,
        kapp_leave_day int(11) DEFAULT 0,
        kapp_search_part int(11) DEFAULT 0,
        kapp_prohibit_id text DEFAULT NULL,
        kapp_prohibit_email text DEFAULT NULL,
        kapp_new_del int(11) DEFAULT 0,
        kapp_memo_del int(11) DEFAULT 0,
        kapp_visit_del int(11) DEFAULT 0,
        kapp_popular_del int(11) DEFAULT 0,
        kapp_optimize_date date DEFAULT '0000-00-00',
        kapp_login_minutes int(11) DEFAULT 0,
        kapp_image_extension varchar(255) DEFAULT NULL,
        kapp_movie_extension varchar(255) DEFAULT NULL,
        kapp_formmail_is_member tinyint(4) DEFAULT 0,
        kapp_page_rows int(11) DEFAULT 0,
        kapp_mobile_page_rows int(11) DEFAULT 0,
        kapp_visit varchar(255) DEFAULT NULL,
        kapp_max_po_id int(11) DEFAULT 0,
        kapp_stipulation text DEFAULT NULL,
        kapp_privacy text DEFAULT NULL,
        kapp_open_modify int(11) DEFAULT 0,
        kapp_memo_send_point int(11) DEFAULT 0,
        kapp_editor varchar(255) DEFAULT NULL,
        kapp_googl_shorturl_apikey varchar(255) DEFAULT NULL,
        kapp_facebook_appid varchar(255) DEFAULT NULL,
        kapp_facebook_secret varchar(255) DEFAULT NULL,
        kapp_twitter_key varchar(255) DEFAULT NULL,
        kapp_twitter_secret varchar(255) DEFAULT NULL,
        kapp_kakao_js_apikey varchar(255) DEFAULT NULL,
        kapp_naver_client_id varchar(255) DEFAULT NULL,
        kapp_naver_client_secret varchar(255) DEFAULT NULL,
        kapp_pay_point int(11) DEFAULT 1,
        kapp_slide_time int(11) DEFAULT 6000,
		PRIMARY KEY (kapp_title)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");

        $query = "
        INSERT INTO ".$t_head."config set
			kapp_title='K-APP',
			kapp_admin='".$admin_id."',
			kapp_admin_email='".$admin_email."',
			kapp_admin_email_name='".$admin_id."',
			kapp_admin_level=8,
			kapp_use_point=1,
			kapp_point_term=0,
			kapp_use_copy_log=1,
			kapp_use_email_certify=1,
			kapp_login_point=100,
			kapp_cut_name=10,
			kapp_nick_modify=60,
			kapp_new_rows=15,
			kapp_read_point=100,
			kapp_write_point=3000,
			kapp_comment_point=1000,
			kapp_download_point=-1000,
			kapp_write_pages=10,
			kapp_mobile_pages=5,
			kapp_delay_sec=30,
			kapp_filter='',
			kapp_possible_ip='',
			kapp_intercept_ip='',
			kapp_analytics='',
			kapp_syndi_token='',
			kapp_syndi_except='',
			kapp_register_level=2,
			kapp_register_point=30000,
			kapp_use_recommend=1,
			kapp_recommend_point=1000,
			kapp_leave_day=30,
			kapp_search_part=1000,
			kapp_prohibit_id='admin,administrator,webmaster,sysop,manager,root,su,guest',
			kapp_prohibit_email='',
			kapp_new_del=30,
			kapp_memo_del=180,
			kapp_visit_del=365,
			kapp_popular_del=180,
			kapp_optimize_date='',
			kapp_login_minutes=10,
			kapp_image_extension='gif|jpg|png',
			kapp_movie_extension='asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3',
			kapp_formmail_is_member=1,
			kapp_page_rows=15,
			kapp_mobile_page_rows=10,
			kapp_visit='today:2, yestday:, max:2, Total:2',
			kapp_max_po_id=0,
			kapp_stipulation='',
			kapp_privacy='',
			kapp_open_modify=0,
			kapp_memo_send_point=100,
			kapp_editor='editor',
			kapp_googl_shorturl_apikey='',
			kapp_facebook_appid='',
			kapp_facebook_secret='',
			kapp_twitter_key='',
			kapp_twitter_secret='',
			kapp_kakao_js_apikey='',
			kapp_naver_client_id='',
			kapp_naver_client_secret='',
			kapp_pay_point=1,
			kapp_slide_time=6000 
        ";

        $result = sql_query( $query );

        if( !$result ){
            m_("SQL_Create_jsonA $tab Table Insert Invalid query: ");
            //m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
        } else {
            m_("Create Success and Record Create Success : $tab");
        }
    }
}

function Visit($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE ".$t_head."visit (
        vi_id int(11) auto_increment NOT NULL,
        vi_ip varchar(255) NOT NULL DEFAULT '',
        vi_date date NOT NULL DEFAULT '0000-00-00',
        vi_time time NOT NULL DEFAULT '00:00:00',
        vi_referer text DEFAULT NULL,
        vi_agent varchar(255) DEFAULT NULL,
        vi_browser varchar(255) DEFAULT NULL,
        vi_os varchar(255) DEFAULT NULL,
        vi_device varchar(255) NOT NULL,
        PRIMARY KEY (vi_id),
        UNIQUE KEY index1 (vi_device,vi_date),
        KEY index2 (vi_date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Ap_bbs($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE `".$t_head."ap_bbs` (
        `seqno` bigint(20) NOT NULL AUTO_INCREMENT,
        `infor` bigint(20) NOT NULL,
        `email` varchar(100) DEFAULT NULL,
        `subject` varchar(100) NOT NULL,
        `content` longblob NOT NULL,
        `up_day` datetime DEFAULT current_timestamp(),
        `reg_date` int(11) DEFAULT NULL,
		`host` varchar(100) DEFAULT NULL,
		`aboard_tab_enm` varchar(50) DEFAULT NULL,
		`aboard_tab_hnm` varchar(50) DEFAULT NULL,
		`kapp_server` varchar(100) DEFAULT NULL,
        PRIMARY KEY (`seqno`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}
function Ap_bbs_curl($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE `".$t_head."ap_bbs_curl` (
        `seqno` bigint(20) NOT NULL AUTO_INCREMENT,
        `infor` bigint(20) NOT NULL,
        `email` varchar(100) DEFAULT NULL,
        `subject` varchar(100) NOT NULL,
        `content` longblob NOT NULL,
        `up_day` datetime DEFAULT current_timestamp(),
        `reg_date` int(11) DEFAULT NULL,
		`host` varchar(100) DEFAULT NULL,
		`aboard_tab_enm` varchar(50) DEFAULT NULL,
		`aboard_tab_hnm` varchar(50) DEFAULT NULL,
		`kapp_server` varchar(100) DEFAULT NULL,
        PRIMARY KEY (`seqno`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");
    } else {
        echo " - Create  Success : $tab";
    }
}

function E_list($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
        CREATE TABLE `".$t_head."e_list` (
        `no` int(11) auto_increment NOT NULL,
        `e_yy` varchar(100) NOT NULL,
        `yy` varchar(100) NOT NULL,
        `mm` varchar(100) NOT NULL,
        `e_memo` varchar(255) NOT NULL,
        `indate` varchar(20) NOT NULL,
        primary key(no) 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Pri_contect($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
    CREATE TABLE `".$t_head."pri_contect` (
    `seqno` int(11) auto_increment NOT NULL,
    `custom` varchar(50) NOT NULL,
    `compno` varchar(15) NOT NULL,
    `up_name` varchar(30) NOT NULL,
    `postno` varchar(5) NOT NULL,
    `address1` varchar(255) NOT NULL,
    `address2` varchar(255) NOT NULL,
    `address3` varchar(255) NOT NULL,
    `tel` varchar(15) NOT NULL,
    `tel1` varchar(5) NOT NULL,
    `tel2` varchar(5) NOT NULL,
    `tel3` varchar(5) NOT NULL,
    `email` varchar(50) NOT NULL,
    `homep` varchar(100) NOT NULL,
    `gubun` varchar(200) NOT NULL,
    `jobgubun1` varchar(30) NOT NULL,
    `jobgubun2` varchar(30) NOT NULL,
    `jobgubun3` varchar(30) NOT NULL,
    `jobgubun4` varchar(30) NOT NULL,
    `memo` text NOT NULL,
    `day` datetime NOT NULL,
    `pass_check` varchar(10) NOT NULL,
    `cnt` int(12) NOT NULL,
    primary key(seqno) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        //m_("Create Success : $tab");
        $query = "
        INSERT INTO `".$t_head."pri_contect` (`seqno`, `custom`, `compno`, `up_name`, `postno`, `address1`, `address2`, `address3`, `tel`, `tel1`, `tel2`, `tel3`, `email`, `homep`, `gubun`, `jobgubun1`, `jobgubun2`, `jobgubun3`, `jobgubun4`, `memo`, `day`, `pass_check`, `cnt`) VALUES
        (1, '(주)modumoa', '736-81-01709', 'sw개발', '49224', '부산 서구 구덕로186번길 13', '2층', ' (토성동3가)', '010-7542-8567', '010', '7542', '8567', 'solpakan@naver.com', 'https://modumodu.net', '', '', '', '', '', '어데가노', '2022-07-11 13:15:00', '1111', 0)
        ";

        $result = sql_query( $query );

        if( !$result ){
            m_("$tab Table Insert Invalid query: " . $query);
            //m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
        } else {
            m_("Create Success and Record Create Success : $tab");
        }
    }
}

function Project($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
    CREATE TABLE `".$t_head."project` (
    `no` int(11) auto_increment NOT NULL,
    `wr_subject` varchar(200) DEFAULT NULL,
    `reguest` varchar(50) DEFAULT NULL,
    `wr_yesan` varchar(255) DEFAULT NULL,
    `wr_iljung` varchar(50) DEFAULT NULL,
    `wr_content` text DEFAULT NULL,
    `bf_file` varchar(255) DEFAULT NULL,
    `wr_name` varchar(30) DEFAULT NULL,
    `wr_tel` varchar(15) DEFAULT NULL,
    `wr_comp` varchar(30) DEFAULT NULL,
    `wr_bu` varchar(20) DEFAULT NULL,
    `wr_email` varchar(20) DEFAULT NULL,
    `wr_homepage` varchar(255) DEFAULT NULL,
    `day` varchar(20) DEFAULT NULL,
    `pass_check` varchar(10) NOT NULL,
    `gubun` varchar(10) NOT NULL,
    primary key(no) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Tkher_content($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
    CREATE TABLE `".$t_head."tkher_content` (
    `co_id` varchar(50) NOT NULL DEFAULT '',
    `co_html` tinyint(4) NOT NULL DEFAULT 0,
    `co_subject` varchar(255) NOT NULL DEFAULT '',
    `co_content` longtext NOT NULL,
    `co_mobile_content` longtext NOT NULL,
    `co_skin` varchar(255) NOT NULL DEFAULT '',
    `co_mobile_skin` varchar(255) NOT NULL DEFAULT '',
    `co_tag_filter_use` tinyint(4) NOT NULL DEFAULT 0,
    `co_hit` int(11) NOT NULL DEFAULT 0,
    `co_include_head` varchar(255) NOT NULL,
    `co_include_tail` varchar(255) NOT NULL,
    primary key(co_id) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

function Pri_maintenance($t_head, $tab) {
    $tab = $t_head.$tab;
    $SQL = "
    CREATE TABLE `".$t_head."pri_maintenance` (
    `no` int(11) auto_increment NOT NULL,
    `num` int(11) DEFAULT NULL,
    `reply` varchar(10) DEFAULT NULL,
    `parent` int(11) DEFAULT NULL,
    `gubun` varchar(10) DEFAULT NULL,
    `jemok` varchar(50) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    `tel` varchar(15) DEFAULT NULL,
    `email` varchar(200) DEFAULT NULL,
    `homep` varchar(200) DEFAULT NULL,
    `day` varchar(50) DEFAULT NULL,
    `cnt` varchar(255) DEFAULT NULL,
    `jobgubun` int(1) DEFAULT NULL,
    `memo` text DEFAULT NULL,
    `customer_file` varchar(200) DEFAULT NULL,
    `pass_check` varchar(10) DEFAULT NULL,
    primary key(no) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";
    $result = sql_query( $SQL );
    if( !$result ){
        m_("$tab Table Create Invalid query: " . $SQL);
        m_("Please check if the $tab table already exists.");// table이 이미 존재하는지 확인 바랍니다
    } else {
        m_("Create Success : $tab");
    }
}

?>