<?php
	include_once('./tkher_start_necessary.php');
	 $H_ID	= get_session("ss_mb_id"); 
	if( isset($H_ID) && $H_ID && $H_ID !=='' ){
		$H_ID	= get_session("ss_mb_id");    //"ss_mb_id";	//connect_count('ulist', $H_ID, 0);	// log count
		$_LEVEL	= get_session("ss_mb_level"); //m_($H_ID . ", _LEVEL: " . $_LEVEL);
	} else {
		m_("login please! - $H_ID");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}

	/*  
		2025-05-03
		kapp_project.php : table : kapp_url_group {$tkher['url_group_table']} 
		kapp_project_ajax.php - insert, update,   {$tkher['table10_group_table']} 

	*/
	$day = date("Y-m-d H:i:s");
	$pg_		= 'kapp_project.php';
	if( isset($_POST['target_']) ) $target_	= $_POST['target_'];
	else $target_ = 'iframe_url';	//table_main
	$type_ = 'U';
	$title_='';
	$secret_key = "";
	$link_	= "";
	$gg_user = "";
	$url = "kapp_project.php";

	//$uid = explode('@', $H_ID);
	//$p_code = $uid[0] . "_" . time();
	$p_code = $H_ID . "_" . time();

?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./icon/project_.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<style>
table { border-collapse: collapse; }
/*th { background: #cdefff; height: 32px; } */
th { background: #666fff; color: white; height: 32px; }
th, td { border: 1px solid silver; padding:5px; }

	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
		/*flex-direction: row;*/							/* row, row-reverse, column, column-reverse */
		/*flex-wrap: nowrap;*/							/* nowrap, wrap, wrap-reverse */
		justify-content: space-between;		/* flex-start, flex-end, center, space-between, space-around */
		align-content: center;				/* flex-start, flex-end, center, space-between, space-around 줄넘김 처리시 사용. */
		align-items: center;							/* flex-start, flex-end, center, baseline, stretch */
		height:25px;

	}
	.item {
		background-color: gold;
		boarder: 1px solid gray;
	}
</style>
<script src="//code.jquery.com/jquery.min.js"></script>
<script>
$(function () {
  $('table.floating-thead').each(function() {
    if( $(this).css('border-collapse') == 'collapse') {
      $(this).css('border-collapse','separate').css('border-spacing',0);
    }
    $(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
  });
  $(window).scroll(function() {
    var scrollTop = $(window).scrollTop(),
      scrollLeft = $(window).scrollLeft();
    $('table.floating-thead').each(function(i) {
      var thead = $(this).find('thead:last'),
        clone = $(this).find('thead:first'),
        top = $(this).offset().top,
        bottom = top + $(this).height() - thead.height();

      if( scrollTop < top || scrollTop > bottom ) {
        clone.hide();
        return true;
      }
      if( clone.is('visible') ) return true;
      clone.find('th').each(function(i) {
        $(this).width( thead.find('th').eq(i).width() );
      });
      clone.css("margin-left", -scrollLeft ).width( thead.width() ).show();
    });
  });
});
</script>
<link rel="stylesheet" href="./include/css/common.css" type="text/css" />
<script type="text/javascript" src="./include/js/ui.js"></script>
<script type="text/javascript" src="./include/js/common.js"></script>

<link rel="stylesheet" type="text/css" href="./include/css/dddropdownpanel.css" />
<script type="text/javascript" src="./include/js/dddropdownpanelA.js"></script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script> -->

</head> 

<?php
	$ss_mb_id		= get_session("ss_mb_id");
	if( isset($member['mb_id']) && $member['mb_id'] !== "") {
		$ss_mb_level	= $member['mb_level']; 
		$H_EMAIL	    = $member['mb_email'];
		$H_ID				= $ss_mb_id;
		$H_LEV			= $ss_mb_level; 
	} else {
		$ss_mb_level	= ""; 
		$H_EMAIL	    = ""; 
		$H_ID				= ""; 
		$H_LEV			= ""; 
	}
	if( isset($_REQUEST["g_type"]) ) $g_type	= $_REQUEST["g_type"];
	else $g_type	= "";
	if( isset($_REQUEST["g_name_old"]) ) $g_name_old	= $_REQUEST["g_name_old"];
	else $g_name_old	= "";

	if( isset($_REQUEST["project_nm"]) ) $project_nm	= $_REQUEST["project_nm"];
	else $project_nm	= "";

			//$sel_g_name = $_POST["sel_g_name"];

	if( isset($_POST["sel_g_name"]) && $_POST["sel_g_name"] !=="" ) {
		$sel_g_name	= $_POST["sel_g_name"];
		$aa = explode(':', $_POST["sel_g_name"]); 
		$g_name = $aa[0];
		$g_num = $aa[1];
		$g_name_code = $g_num;
		if( isset($aa[2])) $gg_user = $aa[2];
		else $gg_user = $H_ID;
		if( isset($aa[3])) $g_no = $aa[3];
		else $g_no = "";
	} else {
		$sel_g_name	= "ETC:ETC"; // 초기화 ETC
		$g_name = "ETC";
		$g_name_code = "ETC";
		if( isset($H_ID) ) $gg_user = $H_ID;
		else $gg_user = "";
		$g_no = "";
	}
	/*
	$gnm = $_REQUEST["g_name"];	//2018-07-13
	if( !$gnm ) {
	} else {
		$aa = explode(':', $_REQUEST["g_name"]); 
		$g_name = $aa[0];
		$g_num = $aa[1];
		$gg_user = $aa[2];
		$g_no = $aa[3];
	}*/

	if( isset($_REQUEST["mode"]) )   $mode = $_REQUEST["mode"];
	else if( isset($_POST["mode"]) ) $mode = $_POST["mode"];
	else	$mode			= "";

	if( isset($_REQUEST["memo"]) ) 	$memo= $_REQUEST["memo"];
	else	$memo			= "";
	if( isset($_REQUEST["mode_up"]) ) 	$mode_up= $_REQUEST["mode_up"];
	else	$mode_up			= "";
	if( isset($_REQUEST["mode_in"]) ) 	$mode_in= $_REQUEST["mode_in"];
	else	$mode_in			= "";
	if( isset($_REQUEST["sdata"]) ) 	$sdata= $_REQUEST["sdata"];
	else	$sdata			= "";

	if( isset($_REQUEST["page"]) ) 	$page = $_REQUEST["page"];
	else	$page = 1;

	if( $mode == 'insert_project1') {
		$g_num = $H_ID . time();
		if ( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$ls = "select * from {$tkher['table10_group_table']} where group_name='$g_name' and userid='$H_ID' ";
		$result = sql_query( $ls);
		$rs = sql_num_rows($result);
		if($rs) {
			echo "<script>alert('\'$g_name\' Already exists. 이미 존재합니다');history.back();</script>";
		} else {
			$ls = "insert into {$tkher['table10_group_table']} set group_name='$g_name', group_code='$g_num', userid='$H_ID' ";
			$result = sql_query(  $ls );
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	}
	else if($mode == 'update_project1') {
		if ( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		} else {
			$g_name = $_REQUEST['g_name'];
			$g_name_update = $_REQUEST['g_name_update'];
			$sql = "update {$tkher['table10_group_table']} set group_name='$g_name_update' where group_name='$g_name' and userid='$H_ID' ";
			$rs = sql_query(  $sql );
			$url = "kapp_project.php?g_name=".$g_name_update;
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	}
	else if($mode == 'delete_g_name') {
		if ( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$result = sql_query( "delete from {$tkher['table10_group_table']} where group_name='$g_name' and userid='$H_ID'" );
	}
	else if($mode == 'insert_num') {
		if ( !$H_ID ) {
			echo "<script>alert('Member Login! Please!'); window.open('$url', '_self', '');</script>";
		}
		$result = sql_query( "select * from {$tkher['table10_group_table']} where group_name='$g_name' and group_code='$num'" );
		$rs = sql_num_rows($result);
		if($rs) {
			echo "<script>alert('\'$g_name\' \'$num\' Item already exists');history.back();</script>";
		} else {
			$result = sql_query(  "insert into {$tkher['table10_group_table']} set group_name='$g_name', group_code='$num'" );
			echo "<script>location.href('kapp_project.php?g_name=$g_name');</script>";
		}
		exit;
	}
	else if($mode == 'delete_link') {
		if ( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		} else {
			$num=$_POST['num'];
			$webnum=$_POST['webnum'];
			$g_name=$_POST['name'];
			$result = sql_query( "delete from {$tkher['job_link_table']} where user_id='$H_ID' and seqno='$num'" );
			if($H_LEV > 7 ) $chkpass = " ";
			else $chkpass = " and user='$H_ID' ";
			$query="select * from webeditor where num='$webnum' $chkpass ";
			$mq=sql_query($query);
			$mn=sql_num_rows($mq);
			if($mn){
				$rs=sql_fetch_array($mq);
				$dir = substr($rs['date'],0,7);
				$result = sql_query( "delete from webeditor where num=$webnum" );
			}
			echo "<script>location.href('kapp_project.php?g_name=$g_name');</script>";
		}
	}

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
<script language='javascript'>
<!--
	function initA(){
		document.getElementById('Change_btn').style.visibility = 'hidden'; 
	}
	
	function check_enter(p_code) {
		if (event.keyCode == 13) {
			pg_dup_check(p_code);
		} 
	}
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, kapp_project.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
	function change_g_name_func(g_nm) {
		g_name = g_nm;
		var gg = g_nm.split(":");
		g_name2 = gg[0];
		g_num = gg[1];
		g_id = gg[2];
		g_no = gg[3];
		document.insert_form.g_name.value = gg[0]; 
		document.insert_form.g_name_code.value = gg[1]; 
		document.insert_form.g_name_update.value = gg[0]; 
	}
	function call_pg_select( no, project_code, mid, project_name, lev, hid) {

		document.insert_form.mid.value = mid;
		document.insert_form.project_cd.value = project_code;
		document.insert_form.project_nm.value   =project_name;
		document.insert_form.seq_no.value =no;
		document.insert_form.memo.value =lev;
		if( hid == mid ) {
			document.getElementById('save_button').style.visibility = 'hidden';
			document.getElementById('Change_btn').style.visibility = 'visible';
		} else {
			document.getElementById('save_button').style.visibility = 'hidden';
			document.getElementById('Change_btn').style.visibility = 'hidden';
		}
	}
	//---------------------------
	function pg_dup_check(p_code)
	{
		p_name = document.insert_form.project_nm.value;
		var item_cnt = insert_form.sel_g_name.options.length; 
		dup_ok = false;
		for (i = 0; i < item_cnt; i++) { 
				var str_val = insert_form.sel_g_name.options[i].value; 
				var pgnm = insert_form.sel_g_name.options[i].text;
					pnm = pgnm.split(':');
				if( p_name == pnm[0]){
					alert("Program name is duplicate. Please use a different name!"); // \n 프로그램명이 중복입니다. 다른 명칭을 사용해주세요! pgnm:
					document.insert_form.project_nm.focus();
					dup_ok = true;
					return false;
				}
		}
		if( dup_ok === false ) {
			alert("No Dup! OK!");
			document.insert_form.dup_confirm.checked =true;
			document.insert_form.project_cd.value = p_code;
		}
		document.insert_form.memo.focus();
		return true;
	}

	//------------------------
	function contents_del( num, g_name, webnum ) {
		if( confirm('Are you sure you want to delete? '+num) ) {
			insert_form.mode.value='delete_link';
			insert_form.num.value=num;
			insert_form.webnum.value=webnum;
			insert_form.g_name.value=g_name;
			insert_form.submit();
		}
	}
	function contents_upd(hid) { // title click run
		form = document.insert_form;
		var seq_no = form.seq_no.value;
		var project_nm = form.project_nm.value;
		var memo = form.memo.value;
		var mid = form.mid.value;
		if( mid !== hid) {
			document.getElementById('save_button').style.visibility = 'hidden';
			document.getElementById('Save_encrypted').style.visibility = 'hidden';
			document.getElementById('Decryption').style.visibility = 'hidden';
			document.getElementById('Change_btn').style.visibility = 'hidden';
		} else {
			document.getElementById('save_button').style.visibility = 'hidden';
			document.getElementById('Change_btn').style.visibility = 'visible';
			document.getElementById('Save_encrypted').style.visibility = 'visible';
			document.getElementById('Decryption').style.visibility = 'visible';
		}
		//-------------------------------------------
		//var seq_no= $("#seq_no").val();alert( seq_no + ", project_nm: " + project_nm + ", memo: " + memo);
jQuery(document).ready(function ($) {
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'kapp_project_ajax.php',
				data: {
					"mode_insert": 'project_change',
					"project_nm": project_nm,
					"memo": memo,
					"seq_no": seq_no
				},
			success: function(data) {
				//console.log(data);
				alert("OK --- " + seq_no);
				location.replace(location.href);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(" 올바르지 않습니다.-- kapp_project_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
});


		//form.mode.value = "update_link";
		//form.submit();
	}
	function contents_upd_run() {
		form = document.insert_form;
		seq_no=form.seq_no.value;
		if( confirm('Do you want to change '+seq_no ) ) {
			form.mode_up.value = "update_link_run";
			form.mode.value = "";
			form.submit();
		}
	}
	function Cancle_run() {
		window.open('/','_top','');
	}

//-->
</script>

 <script>
jQuery(document).ready(function ($) {


	$('a[href^="#"], .view_click').on('click', function( seq_no, g_name, webnum, job_addr, memo, title, mid, H_ID) {
		//var seq_no = $("#insert_form").seq_no.val();
		//alert("view_click --- " ); // Project Create 클리시 --- here
	});


	$('#Save_encrypted').on('click', function() {		//alert('버튼 클릭됨');		//$('#element').text('새 텍스트 내용');
		var encrypted_check= $("#encrypted_check").val();
		if( encrypted_check == ""){
			alert("Login Please!"); return false;
		}
		var memo= $("#memo").val();
		var pws= $("#form_psw").val();		//alert(" memo:" + memo + ", pw:" + pws); // return;

		//$("#encrypted_check").val(pws);

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'kapp_project_ajax.php',
				data: {
					"mode_insert": 'Encryption_data',
					"memo": memo,
					"pws": pws
				},
			success: function(data) {
					$("#memo").val(data);
				//console.log(data);
				//alert(data);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- kapp_project_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

	$('#Decryption').on('click', function() {		//alert('버튼 클릭됨');
		var memo= $("#memo").val();
		var pws= $("#form_psw").val();		//alert(" memo:" + memo + ", pw:" + pws); // return;

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'kapp_project_ajax.php',
				data: {
					"mode_insert": 'Decryption_data',
					"memo": memo,
					"pws": pws
				},
			success: function(data) {
					$("#memo").val(data);
				//console.log(data);
				//alert(data);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("data or URL confirm.-- kapp_project.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

    $("#insert_form").submit(function (event) {
		var g_name= $("#g_name").val();
		var g_name_code= $("#g_name_code").val();

		var nm= $("#project_nm").val();
		if( nm === "" ) {
			alert(" project name confirm");
			document.insert_form.project_nm.focus();
			return false;
		}
				var cd= $("#project_cd").val();
		if( cd === "" ) {
			alert(" project name - duplicate confirm");
			document.insert_form.project_nm.focus();
			return false;
		}
				var memo= $("#memo").val();
		if( memo === "" ) {
			alert(" project memo - Confirm");
			document.insert_form.memo.focus();
			return false;
		}
				var password= $("#form_psw").val();
				var encrypted_check= $("#encrypted_check").val();
				//alert("nm:  ----------" + nm + ", cd:" + cd +", memo" + memo + ", pw:" + password + ", enc: " +encrypted_check);  return;
		if( insert_form.dup_confirm.checked === false ) {
			alert(" project name - duplicate confirm");
			return false;
		}
		//document.insert_form.mode_insert.value='project_insert';

		event.preventDefault();
		//validation for login form
        $("#progress").html('Inserting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>');

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'kapp_project_ajax.php',
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata) 
                {
                    //show return answer
                    alert(returndata);
					location.replace(location.href);
                },
                error: function(){
                alert("error in ajax form submission");
                                    }
        });
		//location.reload();
        return false;
    });

	$('#insert_project').on('click', function() {		//alert('버튼 클릭됨');
		var g_code = $("#g_name_code").val();
		var g_name= $("#g_name").val();		
		//alert(" g_code:" + g_code + ", g_name:" + g_name); //return;

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'kapp_project_ajax.php',
				data: {
					"mode_insert": 'Group_insert',
					"g_code": g_code,
					"g_name": g_name
				},
			success: function(data) {
					alert(data);
					location.replace(location.href);
					//	$("#g_name").val(data);
					//console.log(data);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- kapp_project_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

	$('#update_project').on('click', function() {		//alert('버튼 클릭됨');
		var g_code = $("#g_name_code").val();
		var g_name= $("#g_name").val();		
		//alert(" g_code:" + g_code + ", g_name:" + g_name); //return;

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'kapp_project_ajax.php',
				data: {
					"mode_insert": 'Group_update',
					"g_code": g_code,
					"g_name": g_name
				},
			success: function(data) {
					//	$("#g_name").val(data);
					//console.log(data);
					alert(data);
					location.replace(location.href);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- kapp_project_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

});
</script>


<body onLoad="initA()" oncontextmenu='return false' ondragstart='return false' onselectstart='return false' topmargin='0'>
<?php
		$cur='B';
		include_once "./menu_run.php"; 
?>

<form id="insert_form" name='insert_form' method='post' enctype='multipart/form-data' >
	<input type='hidden' name='g_type'			value='<?=$g_type?>' > 
	<input type='hidden' name='g_name_old'	value='<?=$g_name?>' > 
	<input type='hidden' name='g_user'			value='<?=$g_user?>' > 
	<input type='hidden' name='mode_in'		value='' > 
	<input type='hidden' name='mode_up'		value='' > 
	<input type='hidden' name='seq_no' id='seq_no'	value='<?=$_REQUEST['seq_no']?>' > 
	<input type='hidden' name='page'			value='<?=$page?>' > 
	<input type='hidden' name='mode'			value='<?=$mode?>' > 
	<input type='hidden' name='mode_insert'		value='project_insert' > 
	<input type='hidden' name='pg_'				value='<?=$pg_?>' > 
	<input type='hidden' name='target_'			value='<?=$target_?>' > 
	<input type='hidden' name='type_'			value='<?=$type_?>' > 
	<input type='hidden' name='data'			value='<?=$sdata?>' > 
	<input type='hidden' name='num'				value='' > 
	<input type='hidden' name='webnum'			value='' > 
	<input type='hidden' name='mid'    value=''>
	<input type='hidden' id='g_name_code' name='g_name_code' value='<?=$g_name_code?>'>

<div id="mypanel" class="ddpanel">
<div id="mypanelcontent" class="ddpanelcontent">
<table border='0' bgcolor='#cccccc' width='100%'>

	<!-- <tr>
		<td bgcolor='#ffffff' colspan='2' align='center' style=""><font color='black'>&nbsp; Project Management
	</tr> -->
	<p align="center" style="margin-top:5px; color:yellow;height:25px;">Project Management</p>
	<tr>
		<td bgcolor='#f4f4f4' height='30' style="display:none;"><font color='black'>&nbsp;Projetc</td>
		<td bgcolor='#ffffff' style="display:none;" >&nbsp; 
			<select style="display:none;" name='sel_g_name' onchange="change_g_name_func(this.value);" title="select group">
				<option value=''>Project Select</option>
<?php
				$result = sql_query( "select * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name asc" );
				while($rs = sql_fetch_array($result)) {
					if($temp_g_name != $rs['group_name']) {
						$temp_g_name = $rs['group_name'];
?>
						<option value='<?=$rs['group_name']?>:<?=$rs['group_code']?>:<?=$rs['userid']?>:<?=$rs['seqno']?>' <?php if($rs['group_name']==$g_name) echo "selected"; ?>><?=$rs['group_name']?></option>
<?php
					}
				}
?>
			</select>

				<input style="display:none;" type='text' id='g_name' name='g_name' size='10' value='<?=$g_name?>'> 
<?php 
		if ( isset($H_ID) && $H_LEV > 1) { 
?>
				&nbsp; &nbsp; 
				<input style="display:none;" type='button' id="insert_project" onclick="javascript:insert_project();" value='Group-Insert' title="group add">
				&nbsp; &nbsp; 
				<input style="display:none;" type='hidden' name='g_name_update' value='' > 
<?php
				if( $H_LEV > 7 or $H_ID == $gg_user) {
?>
				<input style="display:none;" type='button' value='Group-Update' id="update_project" onclick="javascript:update_project();" title="group name Change!">
<?php
				}	
		} else { 
?>
				You can register after login.
<?php
		}
?>
		</td>
	</tr>

	<tr>
		<td bgcolor='#f4f4f4' height='30' ><font color='black'>&nbsp; Project Name</td>
		<td bgcolor='#ffffff'><font color='black'>
		&nbsp;<input type='text' id='project_nm' name='project_nm' size='50' value='<?=$title_?>' onKeyDown="check_enter('<?=$p_code?>')" >
		&nbsp;<input type='checkbox' id='dup_confirm' name='dup_confirm' value='Confirm' onClick="return false">&nbsp;
		&nbsp;<input type='button' onclick="pg_dup_check('<?=$p_code?>')" value='Duplicate check' >
		
		</td>
	</tr>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Project Code </td>
		<td bgcolor='#ffffff'>&nbsp;<input type='text' id='project_cd' name='project_cd' size='50' maxlength='300'  value='' readonly></td>
	</tr>
	
	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Memo</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp; <textarea id="memo" name="memo" rows="4" cols="60"></textarea>

			<input type='hidden' id='encrypted_check' name='encrypted_check' value='<?=$H_ID?>'>
			<br> &nbsp; Encryption key:<input type='password' id='form_psw' name='form_psw' size='4' value=''> 
				 &nbsp; <input type='button'  id='Save_encrypted' onclick="javascript:Save_encrypted();" value='Encryption' style="background-color:red;color:yellow;height:25;">
				 &nbsp; <input type='button'  id='Decryption' onclick="javascript:Decryption();" value='Decryption' style="background-color:blue;color:yellow;height:25;">
			<br> &nbsp; Encrypt and save notes. 
			<br> &nbsp; The encryption key is not stored and should be remembered. 
			<br> &nbsp; If you forget the key, the memo can not be decrypted.
			<!--<br> &nbsp; 메모를 암호화하여저장합니다. <br> &nbsp; 암호키는 저장되지않으며 잘기억해두어야합니다. 
			<br> &nbsp; 키를 잊어버리면 메모는 복호화가 불가능합니다.-->
		</td>
	</tr>
	<tr>
		<td bgcolor='#ffffff' colspan=2><font color='black'>&nbsp; 
<?php if( isset($H_ID) && $H_ID !== "") { ?>

			<a id='Change_btn' href="javascript:contents_upd('<?=$H_ID?>');" style="background-color:blue;color:yellow;height:25;">Save Change</a>
			<!-- <input type='button'  onclick="javascript:Cancle_run();" value='Cancel Change' style="background-color:red;color:yellow;height:25;"> -->

			<!-- <a id="save_button" href="javascript:void(0)" type="submit" style="background-color:blue;color:yellow;height:25;" />Project Save</a> -->
			<input id="save_button" type="submit" value="Project Save" style="background-color:blue;color:yellow;height:25;" />
			<!-- curl run button -->
<?php } ?> 

		</td>
	</tr>
	</form>
</table>
</div>

<div id="mypaneltab" class="ddpaneltab" >
<a href="#" ><span style="background-color:;color:yellow;">Project Create</span> </a>
</div>
</div>

<!-- <link rel="stylesheet" href="./include/css/kancss.css" type="text/css"> -->
 <!-- 
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, kapp_project.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
 -->
<form name='coinview_form' method='post' >
	<input type='hidden' name='table_name'	value='' > 
	<input type='hidden' name='mid'			value='' > 
	<input type='hidden' name='seqno'		value='' > 
	<input type='hidden' name='link_'		value='' > 
	<input type='hidden' name='title_'		value='' > 
	<input type='hidden' name='group'		value='' > 
	<input type='hidden' name='jong'		value='' > 
	<input type='hidden' name='num'			value='' > 
	<input type='hidden' name='aboard_no'	value='' > 
<table border='0' cellpadding='2' cellspacing='1' bgcolor='#cccccc' width='100%'>
	<tr>
		<td align='left' colspan='9'>
			<script type="text/javascript" src="./include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="./" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Group View [▼]</b></font>
				</a> 
			</p>
			<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">
			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
				if( $g_user or $H_ID ) {
					$sql = "select * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name ";
					$ttt = "my-list";
				}	else {
					$sql = "select * from {$tkher['table10_group_table']} order by group_name ";
					$ttt = "all-list";
				}
?>
				<tr>
				<td width='130' height='24' background='./icon/admin_submenu.gif'>&nbsp;
					<img src='./icon/project_.png'>
					<a href="./kapp_project.php?g_type=mylist" target='iframe_url'>&nbsp;
					<font color='blue'>URL <?=$ttt?></a>
				</td>
				</tr>
		<tr>
		<td width='130' height='24' background='./icon/admin_submenu.gif'>&nbsp;<img src='./icon/project_.png'>
		<a href="kapp_project.php?g_type=P" target='iframe_url'>Program list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='./icon/admin_submenu.gif'>&nbsp;<img src='./icon/project_.png'>
		<a href="kapp_project.php?g_type=U" target='iframe_url'>Note list</a><!-- <a href="kapp_project.php?g_type=D" target='iframe_url'>Note list</a> -->
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='./icon/admin_submenu.gif'>&nbsp;<img src='./icon/project_.png'>
		<a href="kapp_project.php?g_type=G" target='iframe_url'>Board list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='./icon/admin_submenu.gif'>&nbsp;<img src='./icon/project_.png'>
		<a href="kapp_project.php?g_type=T" target='iframe_url'>Link list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='./icon/admin_submenu.gif'>&nbsp;<img src='./icon/project_.png'>
		<a href="kapp_project.php?g_type=M" target='iframe_url'>Menu list</a>
		</td>
		</tr>
<?php
	$result = sql_query(  $sql );
	$j=0;
	while ( $rs = sql_fetch_array( $result )  ) {
?>
		<tr>
		<td width='130' height='24' background='./icon/admin_submenu.gif'>&nbsp;<img src='./icon/project_.png'>
		<a href="kapp_project.php?g_name=<?=$rs['group_name']?>:<?=$rs['userid']?>" target='iframe_url'><?=$rs['group_name']?></a>
		</td>
		</tr>
<?php
	}
?>
			</TABLE>
		<div align="right"><a href="javascript:dropdowncontent.hidediv('subcontent2')">Hide </a></div>
		</DIV>
		<script type="text/javascript">
			dropdowncontent.init("searchlink", "left-bottom", 800, "mouseover")
			dropdowncontent.init("contentlink", "right-bottom", 800, "click")
		</script>
		</td>
	</tr>
<?php
		$limite = 10; 
		$page_num = 10; 
		if($mode == 'search_rtn') {
			$sdata = $project_nm;
		}

		$ls = "SELECT group_name from {$tkher['table10_group_table']} ";
		$result = sql_query( $ls );
		$total = sql_num_rows($result);
		if( !$page ) $page =1; 
		$total_page = intval(($total-1) / $limite)+1; 
		$first = ($page-1)*$limite; 
		$last = $limite; 
		if( $total < $last) $last = $total;
		$limit = " limit $first, $last ";
		if( $sdata )  $g_nameX = "Search : " . $sdata;
		else if( !$g_name ) $g_nameX = " page:" . $page . ", [count:" .$total. "]";
		else $g_nameX = "Group: " . $g_name;
		if( $H_ID ) $g_nameX = $g_nameX . ", level:" . $member['mb_level'] . "," .$member['mb_email'];
?>

<table class='floating-thead' width='100%'>
<thead  width='100%'>
		<tr align='center'>
			<TH>icon</TH>
			<TH>Project</TH>
			<TH>Code</TH>
			<TH>Manager</TH>
			<TH>memo</TH>
			<TH>management</TH>
		</tr>
</thead>
<tbody width='100%'>
		<?php
			$ls = " SELECT * from {$tkher['table10_group_table']} ";
			$ls = $ls . "  ";
//			$ls = $ls . " WHERE userid='$H_ID' and g_name like '%$sdata%'    ";
			$ls = $ls . " $limit ";

		$result = sql_query(  $ls );
		while ( $rs = sql_fetch_array( $result ) ) {
			$project_code	= $rs['group_code'];		//  분류
			$project_name	= $rs['group_name'];		//  타이틀명 
			$seqno			= $rs['seqno'];
			$memo		= $rs['memo']; // memo
			$userid    = $rs['userid'];

			$td_bg = '#000000';

			$icon='./icon/project_.png';
			$t_color='cyan';;
			$i_tit='Project - ';
?>
				<tr valign="middle" width='100%' height='20'> 
				  <td bgcolor='black' width='30' title='<?=$i_tit?>'><img src='<?=$icon?>' width='30' ></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:30%;" align='left' >
				      <a href="javascript:call_pg_select( '<?=$seqno?>', '<?=$project_code?>', '<?=$userid?>', '<?=$project_name?>', '<?=$memo?>', '<?=$H_ID?>')" style="background-color:black;color:<?=$t_color?>;" title='<?=$project_code?>'><?=$project_name?></a></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:10%;" ><?=$project_code?></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:10%;" ><?=$userid?></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:30%;" ><?=$memo?></td>
<?php
			if ( isset($H_ID) && $H_LEV > 1 ) {
?>
				  <td style="background-color:black;color:<?=$t_color?>;width:15%;" >
<?php 
				if ( $H_ID==$userid ) {
?>
					  <input type='button' onclick="javascript:contents_del( '<?=$seqno?>', '<?=$project_name?>', '<?=$project_code?>' );" value='delete' style="background-color:red;color:yellow;height:25;">
					  <a href="javascript:call_pg_select( '<?=$seqno?>', '<?=$project_code?>', '<?=$userid?>', '<?=$project_name?>', '<?=$memo?>', '<?=$H_ID?>')" style="background-color:blue;color:yellow;height:25;">Change</a>
					  <!-- <input type='button' onclick="javascript:call_pg_select( '<?=$seqno?>', '<?=$project_code?>', '<?=$userid?>', '<?=$project_name?>', '<?=$memo?>')" value='Change' style="background-color:blue;color:yellow;height:25;"> -->
<?php
				} else {
?>
						---
<?php
				}
?>
			  </td>
<?php
			}
?> 
				</tr>
<?php
		}//-------- Loop
?>
		  </td>
		</tr>
		<tr align="center"></tr>
</tbody>
</table>
<table width="100%"   bgcolor="#CCCCCC" >
  <tr>
    <td align="center" bgcolor="f4f4f4" >
<?php
if( isset($search) ) $search = $_REQUEST['search'];
else  $search = "";

$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
$last_page = $first_page+($page_num-1);
if($last_page > $total_page) $last_page = $total_page;
$prev = $first_page-1;

if($page > $page_num) echo"[<a href=".$PHP_SELF."?page=".$prev."&search=".$search."&sdata=".$sdata."&g_name=".$g_name."&g_type=".$g_type." >Prev</a>] ";
for($i = $first_page; $i <= $last_page; $i++)
{
	if($page == $i) echo" <b>$i</b> "; 
	else echo"[<a style='font-size:20px;font-weight:bold;' href=".$PHP_SELF."?page=".$i."&search=".$search."&sdata=".$sdata."&g_name=".$g_name."&g_type=".$g_type." >".$i."</a>]";
}
$next = $last_page+1;
if($next <= $total_page) echo" [<a href=".$PHP_SELF."?page=".$next."&search=".$search."&sdata=".$sdata."&g_name=".$g_name."&g_type=".$g_type." >Next</a>]";
?>
	</td>
  </tr>
</table>
</form>
</body>
</html>
