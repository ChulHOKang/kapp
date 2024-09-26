<?php
include "./SQL_Create_json.php";

if($_POST['mode'] === 't_create'){
    $table_name = json_decode($_POST['table_name'], true);
    $prefix = json_decode($_POST['prefix']);
    //$t_head = json_decode($_POST['t_head'], true);

    switch($table_name) {
        case 'aboard_admin':
            Aboard_admin($prefix, $table_name);
            break;
        case 'aboard_infor':
            Aboard_infor($prefix, $table_name);
            break;
        case 'aboard_memo':
            Aboard_memo($prefix, $table_name);
            break;
        case 'admin_bbs':
            Admin_bbs($prefix, $table_name);
            break;
        case 'bbs_history':
            Bbs_history($prefix, $table_name);
            break;
        case 'coin_view':
            Coin_view($prefix, $table_name);
            break;
        case 'ip_info':
            Ip_info($prefix, $table_name);
            break;
        case 'job_link_table':
            Job_link_table($prefix, $table_name);
            break;
        case 'visit_sum':
            Visit_sum($prefix, $table_name);
            break;
        case 'menuskin':
            Menuskin($prefix, $table_name);
            break;  
        case 'sajin_group':
            Sajin_group($prefix, $table_name);
            break;
        case 'sajin_jpg':
            Sajin_jpg($prefix, $table_name);
            break;
        case 'sys_menu_bom':
            Sys_menu_bom($prefix, $table_name);
            break;
        case 'table10':
            Table10($prefix, $table_name);
            break;
        case 'table10_group':
            table10_group($prefix, $table_name);
            break;
        case 'table10_pg':
            Table10_pg($prefix, $table_name);
            break;
        case 'tkher_main_img':
            Tkher_main_img($prefix, $table_name);
            break;
        case 'tkher_my_control':
            Tkher_my_control($prefix, $table_name);
            break;
        case 'url_group':
            Url_group($prefix, $table_name);
            break;
        case 'webeditor':
            Webeditor($prefix, $table_name);
            break;
        case 'webeditor_comment':
            Webeditor_comment($prefix, $table_name);
            break; 
        case 'member':
            Member($prefix, $table_name);
            break;   
        case 'log_info':
            Log_info($prefix, $table_name);
            break;   
        case 'point':
            Point($prefix, $table_name);
            break;   
        case 'config':
            Config($prefix, $table_name);
            break;     
        case 'visit':
            Visit($prefix, $table_name);
            break; 
        case 'ap_bbs':
            Ap_bbs($prefix, $table_name);
            break; 
        case 'e_list':
            E_list($prefix, $table_name);
            break; 
        case 'pri_contect':
            Pri_contect($prefix, $table_name);
            break; 
        case 'project':
            Project($prefix, $table_name);
            break; 
        case 'tkher_content':
            Tkher_content($prefix, $table_name);
            break; 
        case 'pri_maintenance':
            Pri_maintenance($prefix, $table_name);
            break; 
        default:
            break;
    }

    /* if($table_name != '') { // switch 정상 실행
        print_r(json_encode("'".$table_name."' Table Create"));
        exit;
    } else {
        print_r(json_encode("table_no ERROR"));
        exit;
    } */
    
}
?>