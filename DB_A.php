<?php
include_once('./tkher_start_necessary.php');
$prefix = 'kapp_';
?>
<html>

<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>DB Table Create</TITLE>
    <link rel="shortcut icon" href="./icon/logo25a.jpg">
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
            height: 20px;
        }

        .div_tab2 {
            float: left;
            width: 280px;
            height: 20px;
        }
    </style>

    <link rel="stylesheet" href="./include/css/admin.css" type="text/css" />
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
                <div class="div_tab" style="width:200px"><input onclick="Edit_t_head('kapp_')" id="t_head" name="t_head"
                        type="text" value="kapp_" readonly title="input 클릭 후 수정가능"></div>
                <div class="div_tab" style="width:200px"><span>ex. kapp_aboard_admin</span></div>
                <div class="div_tab" style="text-align:center;"><input type="button" onclick="Create_Table_All()"
                        value="일괄생성"></div>
                <div class="div_tab" style="text-align:center;"><input type="button" onclick="Re_Create_Table_All()"
                        value="일괄 재생성"></div>
                <input type="hidden" name="mode" value="">
                <input type="hidden" name="create_table_list" value="">
                <input type="hidden" name="uncreate_table_list" value="">
            </form>
        </div>
        <br>
        <br>
        <br>

        <div>
            <div class="div_tab" style="background-color:lightgray;"><span>미생성</span></div>
            <div class="div_tab2" style="background-color:lightgray;"><a class="a_link" style="font-size: 16px;"
                    href="./ksd39673976_1711519602_kapp_aboard_admin.php"><?=$prefix?>aboard_admin</a></div>
            <div class="div_tab"><input type="checkbox" disabled></div>
            <div class="div_tab"><button onclick="Create_Table('<?=$prefix?>aboard_admin')">생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE('<?=$prefix?>aboard_admin')" disabled>재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table('<?=$prefix?>aboard_admin')" disabled>삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_aboard_infor</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(2)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(2)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(2)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_aboard_memo</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(3)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(3)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(3)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_admin_bbs</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(4)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(4)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(4)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_bbs_history</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(5)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(5)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(5)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_coin_view</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(6)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(6)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(6)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_ip_info</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(7)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(7)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(7)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_job_link_table</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(8)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(8)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(8)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_visit_sum</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(9)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(9)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(9)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_menuskin</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(10)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(10)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(10)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_sajin_group</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(11)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(11)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(11)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_sajin_jpg</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(12)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(12)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(12)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_sys_menu_bom</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(13)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(13)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(13)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_table10</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(14)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(14)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(14)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_table10_group</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(15)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(15)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(15)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_table10_pg</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(16)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(16)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(16)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_tkher_main_img</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(17)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(17)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(17)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;"
                    href="./ksd39673976_1711520865_kapp_tkher_my_control.php">kapp_tkher_my_control</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(18)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(18)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(18)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_url_group</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(19)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(19)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(19)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_webeditor</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(20)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(20)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(20)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_webeditor_comment</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(21)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(21)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(21)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_member</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(22)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(22)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(22)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_log_info</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(23)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(23)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(23)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_point</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(24)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(24)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(24)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;"
                    href="./ksd39673976_1711437323_kapp_config.php">kapp_config</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(25)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(25)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(25)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_visit</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(26)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(26)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(26)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_ap_bbs</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(27)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(27)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(27)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_e_list</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(28)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(28)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(28)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;"
                    href="./ksd39673976_1711673673_kapp_pri_contect.php">kapp_pri_contect</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(29)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(29)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(29)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_project</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(30)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(30)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(30)">삭제</button></div>
        </div>
        <br><br>
        <div>
            <div class="div_tab"><span>생성완료</span></div>
            <div class="div_tab2"><a class="a_link" style="font-size: 16px;">kapp_tkher_content</a></div>
            <div class="div_tab"><input type="checkbox" checked disabled></div>
            <div class="div_tab"><button onclick="Create_Table(31)" disabled>생성</button></div>
            <div class="div_tab"><button onclick="Create_Table_RE(31)">재생성</button></div>
            <div class="div_tab"><button onclick="Delete_Table(31)">삭제</button></div>
        </div>
        <br><br>

    </div>
</BODY>
<script>
    function Create_Table(_table) {
        $.ajax({
            type: "post",
            dataType: "json",
            data: {
                "mode": 't_create',
                "table_name": _table,
                "prefix": '<?=$prefix?>'
            },
            url: "./SQL_Create_r.php",
            success: function (data) {
                //console.log(data);
                alert(data);
                //location.replace(location.href);
                T_form_submit($("#t_head").val());
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- SQL_Create_r.phpe");
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                return;
            }
        });
    }

    function Create_Table_RE(_table) {
        if (confirm("기존 데이터가 전부 삭제됩니다. 테이블을 재생성하시겠습니까?")) {
            $.ajax({
                type: "post",
                dataType: "json",
                data: {
                    "mode": 't_delete',
                    "table_name": _table,
                    "prefix": '<?=$prefix?>'
                },
                url: "./SQL_Delete_r.php",
                success: function (data) {
                    //console.log(data);
                    /* alert(data);
                    location.replace(location.href); */
                    Create_Table(_no);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- SQL_Delete_r.phpe");
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    return;
                }
            });
        }
    }

    function Delete_Table(_table) {
        if (confirm("기존 데이터가 전부 삭제됩니다. 테이블을 삭제하시겠습니까?")) {
            $.ajax({
                type: "post",
                dataType: "json",
                data: {
                    "mode": 't_delete',
                    "table_name": _table,
                    "prefix": '<?=$prefix?>'
                },
                url: "./SQL_Delete_r.php",
                success: function (data) {
                    //console.log(data);
                    alert(data);
                    //location.replace(location.href);
                    T_form_submit($("#t_head").val());
                },
                error: function (jqXHR, textStatus, errorThrown) {
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
        document.t_form.action = 'DB_A.php';
        document.t_form.submit();
    }

    function Create_Table_All() {
        let uncreate_table_list_array = '["aboard_admin"]';

        document.t_form.mode.value = 'create_all';
        document.t_form.uncreate_table_list.value = uncreate_table_list_array;
        /* document.t_form.action = 'DB_Table_Create.php';
        document.t_form.submit(); */
        T_form_submit($("#t_head").val());
    }

    function Re_Create_Table_All() {
        let create_table_list_array = '["aboard_infor","aboard_memo","admin_bbs","bbs_history","coin_view","ip_info","job_link_table","visit_sum","menuskin","sajin_group","sajin_jpg","sys_menu_bom","table10","table10_group","table10_pg","tkher_main_img","tkher_my_control","url_group","webeditor","webeditor_comment","member","log_info","point","config","visit","ap_bbs","e_list","pri_contect","project","tkher_content"]';

        document.t_form.mode.value = 're_create_all';
        document.t_form.create_table_list.value = create_table_list_array;
        /* document.t_form.action = 'DB_Table_Create.php';
        document.t_form.submit(); */
        T_form_submit($("#t_head").val());
    }
</script>

</HTML>