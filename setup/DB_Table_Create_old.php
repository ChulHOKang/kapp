<?php
    include_once('../tkher_start_necessary.php');
	/* include '../modu_shop/coupon/tkher_db_lib.php';		
    include '../modu_shop/coupon/tkher_dbcon_Table.php'; */

    $t_head = 'kapp_'; // default

    if($_POST['t_head']) {
        //m_($_POST['t_head']);
        $t_head = $_POST['t_head'];
    }

    function Table_Seatch($t_head, $_tab){
        $tab = $t_head.$_tab;
        $SQL = "show tables like '".$tab."' ";   
        $result = sql_query( $SQL );
        $row = sql_fetch_array($result);

        //print_r($row);
        if($row) {
            //m_("true");
            return true;
        } else {
            //echo "false : ".$SQL;
            return false;
        }
    }

    //Table_Seatch('aboard_admin');
?>

<html>

<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>DB Table Create</TITLE>
    <link rel="shortcut icon" href="<?=TKHER_URL_T_?>/icon/logo25a.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="keywords"
        content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
    <meta name="description"
        content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
    <meta name="robots" content="ALL">
    <style>
    table {
        border-collapse: collapse;
    }

    th {
        background: #cdefff;
        height: 27px;
    }

    th,
    td {
        border: 1px solid silver;
        padding: 5px;
        height: 24px;
    }

    .div-left {
        float: left;
        width: 15%;
    }

    .div-right {
        float: right;
        width: 85%;
        margin-bottom: 20px;
    }

    span {
        font-size: 16px;
        font-weight: bold;
    }

    .a_link {
        /* font-size: 16px; */
        font-weight: bold;
    }

    .div_tab {
        float: left;
        width: 12%;
    }
    </style>

    <link rel="stylesheet" href="<?=TKHER_URL_T_?>/include/css/admin.css" type="text/css" />
    <script src="//code.jquery.com/jquery.min.js"></script>

</head>

<BODY>
    <br />
    <h2 title='pg:program_list3' style="text-align:center">시스템 Table Create</h2>
    <br />
    <div class="div-left"></div>
    <div class="div-right">

        <br>
        <div>
            <form name='t_form' method='post' enctype='multipart/form-data'>
                <div class="div_tab"><span>테이블 접두사 추가</span></div>
                <div class="div_tab" style="width:200px"><input onclick="Edit_t_head('<?=$t_head?>')" id="t_head"
                        name="t_head" type="text" value="<?=$t_head?>" readonly title="input 클릭 후 수정가능"></div>
                <div class="div_tab" style="width:200px"><span>ex. <?=$t_head?>aboard_admin</span></div>
                <div class="div_tab" style="width:200px"></div>
            </form>
        </div>
        <br>
        <br>
        <br>

        <?php
        $table_count = 32;
        $i = 1;
        $table_name = '';
        /* $t_check = '';
        $t_create_btn = '';
        $t_re_create_btn = 'disabled'; */
        
	while ( $i < $table_count ) { 
        $state = '미생성'; // default
        $t_check = ''; // default
        $t_create_btn = ''; // default
        $t_re_create_btn = 'disabled'; // default
        $t_delete_btn = 'disabled'; // default
        $href = ''; // default
        
        switch($i) {
            case 1:
                $table_name = 'aboard_admin';
                $href = 'href= "./ksd39673976_1711519602_kapp_aboard_admin.php"';
                break;
            case 2:
                $table_name = 'aboard_infor';
                break;
            case 3:
                $table_name = 'aboard_memo';
                break;
            case 4:
                $table_name = 'admin_bbs';
                break;
            case 5:
                $table_name = 'bbs_history';
                break;
            case 6:
                $table_name = 'coin_view';
                break;
            case 7:
                $table_name = 'ip_info';
                break;
            case 8:
                $table_name = 'job_link_table';
                break;
            case 9:
                $table_name = 'visit_sum';
                break;
            case 10:
                $table_name = 'menuskin';
                break;  
            case 11:
                $table_name = 'sajin_group';
                break;
            case 12:
                $table_name = 'sajin_jpg';
                break;
            case 13:
                $table_name = 'sys_menu_bom';
                break;
            case 14:
                $table_name = 'table10';
                break;
            case 15:
                $table_name = 'table10_group';
                break;
            case 16:
                $table_name = 'table10_pg';
                break;
            case 17:
                $table_name = 'tkher_main_img';
                break;
            case 18:
                $table_name = 'tkher_my_control';
                $href = 'href= "./ksd39673976_1711520865_kapp_tkher_my_control.php"';
                break;
            case 19:
                $table_name = 'url_group';
                break;
            case 20:
                $table_name = 'webeditor';
                break;
            case 21:
                $table_name = 'webeditor_comment';
                break; 
            case 22:
                $table_name = 'member';
                break;     
            case 23:
                $table_name = 'log_info';
                break;  
            case 24:
                $table_name = 'point';
                break; 
            case 25:
                $table_name = 'config';
                $href = 'href= "./ksd39673976_1711437323_kapp_config.php"';            
                break; 
            case 26:
                $table_name = 'visit';
                break; 
            case 27:
                $table_name = 'ap_bbs';
                break; 
            case 28:
                $table_name = 'e_list';
                break; 
            case 29:
                $table_name = 'pri_contect';
                break; 
            case 30:
                $table_name = 'project';
                break; 
            case 31:
                $table_name = 'tkher_content';
                break; 
            default:
            $table_name = '';
                break;
        }

        $is_table = Table_Seatch($t_head, $table_name);

        if($is_table) {
            $state = '생성완료';
            $t_check = 'checked';
            $t_create_btn = 'disabled';
            $t_re_create_btn = '';
            $t_delete_btn = '';
        }
?>
        <div>
            <div class="div_tab"><span><?=$state?></span></div>
            <div class="div_tab" style="width:280px"><a class="a_link" <?=$href?>><?=$t_head.$table_name?></a></div>
            <div class="div_tab"><input type="checkbox" <?=$t_check?> disabled></div>
            <div class="div_tab"><button onclick="Create_Table(<?=$i?>)" <?=$t_create_btn?>>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(<?=$i?>)" <?=$t_re_create_btn?>>재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(<?=$i?>)" <?=$t_delete_btn?>>삭제</button></div>
        </div>
        <br><br>
        <?php
        $i++;

    }
?>

    </div>
</BODY>
<script>
function Create_Table(_no) {
    $.ajax({
        type: "post",
        dataType: "json",
        data: {
            "mode": 't_create',
            "table_no": _no,
            "t_head": JSON.stringify($("#t_head").val())
        },
        url: "./SQL_Create_r.php",
        success: function(data) {
            //console.log(data);
            alert(data);
            //location.replace(location.href);
            T_form_submit($("#t_head").val());
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- SQL_Create_r.phpe");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            return;
        }
    });
}

function Create_Table_RE(_no) {
    if (confirm("기존 데이터가 전부 삭제됩니다. 테이블을 재생성하시겠습니까?")) {
        $.ajax({
            type: "post",
            dataType: "json",
            data: {
                "mode": 't_delete',
                "table_no": _no,
                "t_head": JSON.stringify($("#t_head").val())
            },
            url: "./SQL_Delete_r.php",
            success: function(data) {
                //console.log(data);
                /* alert(data);
                location.replace(location.href); */
                Create_Table(_no);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- SQL_Delete_r.phpe");
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                return;
            }
        });
    }
}

function Delete_Table(_no) {
    if (confirm("기존 데이터가 전부 삭제됩니다. 테이블을 삭제하시겠습니까?")) {
        $.ajax({
            type: "post",
            dataType: "json",
            data: {
                "mode": 't_delete',
                "table_no": _no,
                "t_head": JSON.stringify($("#t_head").val())
            },
            url: "./SQL_Delete_r.php",
            success: function(data) {
                //console.log(data);
                alert(data);
                //location.replace(location.href);
                T_form_submit($("#t_head").val());
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- SQL_Delete_r.phpe");
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                return;
            }
        });
    }
}

function Edit_t_head(_t_head) {
    let t_head = prompt("Enter table name:", _t_head);
    //console.log("1");
    /* if (t_head != null && t_head != "") {
        document.t_form.t_head.value = t_head;
        document.t_form.action = 'DB_Table_Create.php';
        document.t_form.submit();
    } */

    T_form_submit(t_head);
}

function T_form_submit(_t_head) {
    document.t_form.t_head.value = _t_head;
    document.t_form.action = 'DB_Table_Create.php';
    document.t_form.submit();
}
</script>

</HTML>