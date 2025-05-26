<?php 
	include_once('../tkher_start_necessary.php');
	if($_SESSION['mb_level'] < 8) {
		m_("approach error. ---mb_level:".$member['mb_level']);
		echo "<script>window.open( './index.php' , '_self');</script>";
	}
                                
	/* $upfile	 = '';  
	$upfileX	= '';  
	$mode = $_POST["mode"];  
	$seqno = $_REQUEST["seqno"];  
	if( $mode == 'record_update' ) {  
 			$query			= " UPDATE ksd39673976_1711520865 SET  "; 
			$ff_nm = time() . '_';  
			$f_path = './' . $ff_nm;   // $f_path='./file/';  // dir add     
 			$query = $query . "userid= '" . $_POST['userid'] . "' ";   
 			$query = $query . ",slide_time= '" . $_POST['slide_time'] . "' ";   
 			$query = $query . ",fld1= '" . $_POST['fld1'] . "' ";   
 			$query = $query . ",fld2= '" . $_POST['fld2'] . "' ";   
 			$query = $query . ",fld3= '" . $_POST['fld3'] . "' ";   
 			$query = $query . ",fld4= '" . $_POST['fld4'] . "' ";   
 			$query = $query . ",fld5= '" . $_POST['fld5'] . "' ";   
			$query = $query . " where seqno=$seqno ";   
 			$ret = sql_query( $query );   
 			if( $ret ) {   
 				m_(" Change completed!  ");   
 				if ($upfileX && $upfile) exec ("rm $upfile");	// upfileX: If there is a file, the existing file is preserved if the existing file is not deleted.
 			} else {   
 				printf("sql:%s", $query);   
 				m_(" Change Error!  seqno:$seqno ");   
 			}   
			echo "<script>window.open( './ksd39673976_1711520865_run.php' , '_self', ''); </script>";      
	}    */        
	$menu1TWPer=15;  
	$menu1AWPer=100 - $menu1TWPer;  
	$menu2TWPer=10;  
	$menu2AWPer=50 - $menu2TWPer;  
	$menu3TWPer=10;  
	$menu3AWPer=33.3 - $menu3TWPer;  
	$menu4TWPer=10;  
	$menu4AWPer=25 - $menu4TWPer;  
	$Xwidth='90%';  
	$Xheight='100%';  
	$Text_height='60px';  
?>
<style>
* {
    box-sizing: border-box;
}

.header2A {
    width: 100%;
    height: 50px;
    float: left;
    border: 0px solid red;
    padding: 0px;
}

.menu1Area {
    width: 100%;
    height: auto;
    float: left;
    padding: 0px;
    border: 0px solid #DEDEDE;
    background-color: #FAFAFA;
}

.menu2T {
    padding-top: 3px;
    width: 25%;
    height: 30px;
    float: left;
    padding: 4px;
    border: 1px solid #DEDEDE;
    background-color: #FAFAFA;
}

.menu2A {
    width: 25%;
    height: 30px;
    float: left;
    padding: 0px;
    border: 0px solid #DEDEDE;
    background-color: #FAFAFA;
}

.data2A {
    width: 25%;
    height: 30px;
    float: left;
    padding: 4px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.input1A {
    padding: 0px;
}

.mainA {
    width: 100%;
    float: left;
    padding: 15px;
    border: 1px solid red;
}

.menu1T {
    padding-top: 0px;
    width: <?=$menu1TWPer?>%;
    height: 30px;
    float: left;
    padding: 6px;
    border: 1px solid #DEDEDE;
    background-color: #FAFAFA;
}

.menu1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 0px;
    text-align: left;
}

.data1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 6px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

radio1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 6px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.ListBox1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 2px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.File1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 2px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.menu4T {
    padding-top: 3px;
    width: 10%;
    height: 30px;
    float: left;
    padding: 4px;
    border: 1px solid #DEDEDE;
    background-color: #FAFAFA;
}

.input4A {
    width: 15%;
    height: 30px;
    float: left;
    padding: 0px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.menu4B {
    width: 15%;
    height: 30px;
    float: left;
    padding: 0px;
    border: 0px solid #DEDEDE;
    background-color: #FAFAFA;
}

.data4A {
    width: 15%;
    height: 30px;
    float: left;
    padding: 4px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.main4A {
    width: 100%;
    float: left;
    padding: 15px;
    border: 1px solid #DEDEDE;
}

.blankA {
    border-top: 0px;
    width: 100%;
    float: left;
    height: 1px;
    padding: 0px;
    border: 1px solid #FFFFFF;
    background-color: #FFFFFF;
}

.blankB {
    width: 100%;
    height: 1px;
    padding: 1px;
    float: left;
    border: 1px solid #FFFFFF;
    background-color: #FFFFFF;
}

.viewSubjX {
    margin-top: 1px;
    width: 100%;
    height: 35px;
    line-height: 32px;
    border-top: 3px solid #d01c27;
    text-align: center;
    background: #fafafa;
    border-bottom: 1px solid #dedede;
    overflow: hidden;
    font-size: 18px;
    color: #69604f;
}

.viewSubjX span {
    font-size: 22px;
    color: #171512;
    vertical-align: baseline;
}

.HeadTitle02AX {
    display: inline-block;
    margin: 0 1px;
    height: 35px;
    line-height: 35px;
    padding: 0 20px;
    font-size: 25px;
    background: #d01c27;
    color: #ffffff;
    border-radius: 5px;
}

.HeadTitle01AX {
    display: inline-block;
    margin: 0 1px;
    height: 40px;
    line-height: 0px;
    padding: 0 20px;
    font-size: 22px;
    background: #d01c27;
    color: #fff;
    border-radius: 5px;
}

.HeadTitle01AX a.on {
    background: #d01c27;
    color: #fff;
}

.HeadTitle01A {
    display: inline-block;
    margin: 0 1px;
    height: 35px;
    line-height: 35px;
    padding: 0 20px;
    font-size: 22px;
    background: #dedcdf;
    color: #000;
    border-radius: 5px;
}

.HeadTitle02A a {
    display: inline-block;
    margin: 0 1px;
    height: 35px;
    line-height: 35px;
    padding: 0 20px;
    font-size: 22px;
    background: #dedcdf;
    color: #000;
    border-radius: 5px;
}

.HeadTitle01A a {
    display: inline-block;
    margin: 0 1px;
    height: 35px;
    line-height: 35px;
    padding: 0 20px;
    font-size: 22px;
    background: #dedcdf;
    color: #000;
    border-radius: 5px;
}

.HeadTitle01A a.on {
    background: #d01c27;
    color: #fff;
}

.Btn_List01A {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 64px;
    height: 33px;
    display: inline-block;
    line-height: 33px;
    text-align: center;
    color: #fff;
    font-size: 14px;
    background: #d01d27;
    margin-right: 10px;
}

.Btn_List02A {
    width: 64px;
    height: 33px;
    display: inline-block;
    line-height: 33px;
    text-align: center;
    color: #fff;
    font-size: 14px;
    background: #d01d27;
    margin-right: 10px;
}

.viewHeader {
    width: 100%;
    height: auto;
    overflow: hidden;
    position: relative;
    text-align: left;
}

.viewHeader span {
    left: 0;
    top: 12px;
    font-size: 14px;
    color: #686868;
}

.boardView {
    width: 1168px;
    height: auto;
    overflow: hidden;
    margin: 0 auto 50px auto;
}

.boardViewX {
    width: 99%;
    height: auto;
    overflow: hidden;
    margin: 0 auto 50px auto;
}

.a_btn {
    position: absolute;
    width: 9%;
    height: 3%;
}
</style>
<script type="text/javascript">
function popup_callDN(if_dataPG, pop_dataPG, if_typePG, host_url, i) {
    substring = 'appgenerator.net';
    if (host_url.includes(substring)) Trun = '../../popup_callDN.php?fld_session=' + i;
    else Trun = './popup_callDN.php?fld_session=' + i;
    window.open(Trun, '', 'alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes');
    return true;
}

function table_data_list($pg_code) {
    document.tkher_form.action = "ksd39673976_1711520865_run.php?pg_code=" + $pg_code;
    document.tkher_form.target = '_self';
    document.tkher_form.submit();
}

function popimage(imagesrc, winwidth, winheight) {
    var look = 'width=' + winwidth + ',height=' + winheight + ','
    popwin = window.open("", "", look)
    popwin.document.open()
    popwin.document.write(
        '<title>appgenerator.net</title><body bgcolor="white" topmargin=0 leftmargin=0 marginheight=0 marginwidth=0><a href="javascript:window.close()"><img src="' +
        imagesrc + '" border=0></a></body>')
    popwin.document.close()
}

function record_modify($pg_code, seqno) {
    if (confirm("Do you want to change it?")) {
        document.makeform.mode.value = "record_update";
        document.makeform.seqno.value = seqno;
        document.makeform.action = 'ksd39673976_1711520865_update.php?pg_code=' + $pg_code;
        document.makeform.submit();
    }
}

function tab_pg_list($pg_code) {
    document.tkher_form.action = 'ksd39673976_1711520865_run.php?pg_code=' + $pg_code;
    document.tkher_form.submit();
}

function Back($pg_code) {
    document.tkher_form.action = 'DB_Table_CreateA.php';
    document.tkher_form.submit();
}
</script>
<script src="//code.jquery.com/jquery.min.js"></script>
</head>

<body width=100%>
    <center>

        <?php   
	$SQLX = " SELECT * from {$tkher['tkher_my_control_table']} ";   //tkher_my_control_table
	if ( ($result = sql_query( $SQLX ) )==false )   
	{   
        m_("테이블 또는 레코드가 생성되지 않았습니다.");
		//echo "<script>window.open('./DB_Table_CreateA.php' ,'_self')</script>";
	  printf("SQLX Invalid query: %s", $SQLX);   	  exit();   
	} else {   
				$row	= sql_fetch_array($result);   
?>
        <div class="HeadTitle01AX">
            <P href='#' class='on' title='table code:kapp_tkher_my_control , program name:kapp_tkher_my_control'>
                kapp_tkher_my_control</P>
        </div>
        <form name='tkher_form' method='post' enctype='multipart/form-data'>
            <input type=hidden name='mode' value='' />
            <input type=hidden name='seqno' value='' />
            <input type=hidden name='pg_name' value='kapp_tkher_my_control' />
            <input type=hidden name='pg_code' value='ksd39673976_1711520865' />
            <input type=hidden name='page' value='<?=$page?>' />
            <input type=hidden name='grant_write' value='<?=$grant_write?>' />
        </form>
        <div class='boardViewX'>
            <div class='viewHeader'>
                <span title='tab_update_pg70'>Date:<?=date("Y-m-d H:i:s" ); ?></span>
                <input type=button value='Back' onclick="javascript:Back();" class='Btn_List01A'>
            </div>
            <div class='viewSubjX'><span>kapp_tkher_my_control</span> </div>
            <div class='blankA'> </div>
            <form name='makeform' action='' method='post' enctype='multipart/form-data' onsubmit='return check(this)'>
                <input type=hidden name='mode' value='' />
                <input type=hidden name='seqno' value='' />
                <input type=hidden name='page' value='<?=$page?>' />
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>userid</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='userid' value='<?=$row['userid']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a userid.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>slide_time</span></div>
                <div class='menu1A'><input type='INT' name='slide_time' value='<?=$row['slide_time']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a slide_time.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>fld1</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='fld1' value='<?=$row['fld1']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a fld1.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>fld2</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='fld2' value='<?=$row['fld2']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a fld2.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>fld3</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='fld3' value='<?=$row['fld3']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a fld3.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>fld4</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='fld4' value='<?=$row['fld4']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a fld4.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>fld5</span>
                </div>
                <div class='menu1A'><input type='DECIMAL' name='fld5' value='<?=$row['fld5']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a fld5.'></div>
                <div class='blankA'> </div>
                <input type='hidden' name='upfile' value='<?=$upfile?>' />
                <div class='viewHeader'>
                    <!-- <input type=button value='Save'
                        onclick="javascript:record_modify('ksd39673976_1711520865','<?=$seqno?>');" class='Btn_List02A'>
                    <input type=button value='List' onclick="javascript:tab_pg_list('ksd39673976_1711520865');"
                        class='Btn_List02A'> -->
                </div>
            </form>
        </div>
        <?php   
	}  //query false   
?>
</body>
<script>
Add_Btn('.menu1A');

function Add_Btn(_class) {

    let itemList = document.querySelectorAll(_class);
    //console.log(itemList.length);

    itemList.forEach(function(item) {
        let add_input = document.createElement("input");
        add_input.setAttribute("class", "a_btn");
        add_input.type = 'button';
        add_input.value = "update";
        add_input.setAttribute("onclick", "update_ajax(this)");
        item.append(add_input);
    });


}

function update_ajax(_this) {
    $.ajax({
        type: "post",
        dataType: "json",
        data: {
            "mode": 'tkher_my_control_update',
            "column": JSON.stringify(_this.previousElementSibling.name),
            "data": JSON.stringify(_this.previousElementSibling.value)
        },
        url: "./tkher_my_control_update_ajax.php",
        success: function(data) {
            //console.log(data);
            alert(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- tkher_my_control_update_ajax.php");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            return;
        }
    });
}
</script>

</html>