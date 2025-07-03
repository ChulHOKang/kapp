2025-05-08<?php
	include_once('../tkher_start_necessary.php');
	 $_ID	= get_session("ss_mb_id"); 
	if( isset( $_ID) ){
		$H_ID	= get_session("ss_mb_id");    //"ss_mb_id";	//connect_count('ulist', $H_ID, 0);	// log count
		$_LEVEL	= get_session("ss_mb_level"); //m_($H_ID . ", _LEVEL: " . $_LEVEL);
	} else {
		$H_ID = "";
		$_LEVEL	= 0; 
		m_("login please!");
	}

	/*  
		2021-04-08
		ulink_list.php, = /memu/ulink_list.php : table : {$tkher['job_link_table']} 
		cratree_my_list_menu.php - inc menu_run.php - search call

	*/
	$up_day = date("Y-m-d H:i:s");
	$pg_		= 'ulink_list.php';
	if( isset($_POST['target_']) ) $target_	= $_POST['target_'];
	else $target_ = 'iframe_url';	//table_main
	$type_ = 'U';
	$title_='';
	$secret_key = "";
	$link_	= "";
	$gg_user = "";
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
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
<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>

<link rel="stylesheet" type="text/css" href="../include/css/dddropdownpanel.css" />
<script type="text/javascript" src="../include/js/dddropdownpanel.js"></script>

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
		$g_name = "";
		$g_name_code = "";
		$sel_g_name = ":";

	if( isset($_REQUEST["g_type"]) ) $g_type	= $_REQUEST["g_type"];
	else $g_type	= "";
	if( isset($_REQUEST["g_name_old"]) ) $g_name_old	= $_REQUEST["g_name_old"];
	else $g_name_old	= "";
	if( isset($_REQUEST["title_nm"]) ) $title_nm	= $_REQUEST["title_nm"];
	else $title_nm	= "";

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
		//$sel_g_name	= "ETC:ETC"; // 초기화 ETC
		//$g_name = "ETC";
		//$g_name_code = "ETC";
		if( isset($H_ID) ) $gg_user = $H_ID;
		else $gg_user = "";
		$g_no = "";
	}
	
	if( isset($_REQUEST["g_name"]) ) $gnm = $_REQUEST["g_name"];//m_("gnm: " . $gnm); //gnm: ETCA:solpakan@naver.com
	if( isset($gnm) && $gnm !=="" ) {
		$aa = explode(':', $_REQUEST["g_name"]); 
		$g_name = $aa[0];
		$g_num = $aa[1];
		if( isset($aa[2]) ) $gg_user = $aa[2];
		if( isset($aa[3]) ) $g_no = $aa[3];
	}

	if( isset($_REQUEST["mode"]) ) 	$mode			= $_REQUEST["mode"];
	else if( isset($_POST["mode"]) )	$mode			= $_POST["mode"];
	else	$mode			= "";
	if( isset($_REQUEST["memo"]) ) 	$memo			= $_REQUEST["memo"];
	else	$memo			= "";
	if( isset($_REQUEST["mode_up"]) ) 	$mode_up			= $_REQUEST["mode_up"];
	else	$mode_up			= "";
	if( isset($_REQUEST["mode_in"]) ) 	$mode_in			= $_REQUEST["mode_in"];
	else	$mode_in			= "";
	if( isset($_REQUEST["sdata"]) ) 	$sdata			= $_REQUEST["sdata"];
	else	$sdata			= "";

	if( isset($_REQUEST["page"]) ) 	$page			= $_REQUEST["page"];
	else	$page			= "";

	if( $mode == 'update_link') {
		$seq_no = $_REQUEST['seq_no'];	
		$result	= 		$result = sql_query( "select * from {$tkher['job_link_table']} where seqno=$seq_no" );
		$rs		= sql_fetch_array($result);
		if( $rs['job_name'] =='Note' ) { // add 2025-03-30
			$sql= " update {$tkher['job_link_table']} set view_cnt=view_cnt+1 where seqno = $seq_no ";
			sql_query($sql);
			$title_	= $rs['user_name'];
			$link_	= $rs['job_addr'];
			$g_name	= $rs['job_name'];	// =job_group
			$lev	= $rs['job_level'];
			$jong	= $rs['jong'];
			$memo	= $rs['memo'];
		}
	}
	else if($mode == 'insert_url_func_mode') { // 'Save' 버턴 클릭시 - 2025-05-01 no use
		if ( !$H_ID ) {
			$url = "ulist_admin.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$board_num = 'Note';
		$table_name = 'Note';
		$create_type = 'Note';

		$title_nm		= $_REQUEST['title_nm'];
		$g_class	= $_REQUEST['url_nm'];  // url
		$gong_num = $_REQUEST['gong_num'];
		$memo		= $_REQUEST['memo'];
		$job_label	= $gong_num;	              
		$jong	= 'U';	                   //  tree가아닌 개별등록...
		$ip = $_SERVER['REMOTE_ADDR'];
		$result = sql_query("select * from {$tkher['job_link_table']} where user_id='$H_ID' and user_name='$title_nm' and job_addr='$g_class' ");
		$tot = sql_num_rows($result);
		if( $tot < 1 ) {
			$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$from_session_url', user_name='$title_nm', job_name='$create_type', job_group='$g_name', job_group_code='$g_name_code', job_addr='$g_class', job_level='$job_label', jong='$jong', memo='$memo', ip='$ip', num='$create_type', aboard_no='$create_type', email='$H_EMAIL', up_day='$up_day' ";
			sql_query(  $sqlA ); 
		}
		$sql= " update {$tkher['tkher_member_table']} set mb_point=mb_point+1 where mb_id = '$ss_mb_id' ";
		sql_query($sql);

		Link_Table_curl_send( $title_nm, $g_class, $jong, $from_session_url, $ip, $memo, $up_day );

		$memo='';
	}
	if($mode_up == 'Save_encrypted_run') {
		if ( !$H_ID ) {
			$url = "ulist_admin.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$link_ = $_REQUEST['url_nm'];
		$title_ = $_REQUEST['title_nm'];
		$str = $_REQUEST['memo'];
		$secret_key = $_REQUEST['form_psw'];
		$memo = Encrypt($str, $secret_key, $link_secret_iv);
	}
	else if($mode_up == 'Decryption_run') {
		$link_ = $_REQUEST['url_nm'];
		$title_ = $_REQUEST['title_nm'];
		$encrypted = $_REQUEST['memo'];
		$secret_key = $_REQUEST['form_psw'];
		$memo = Decrypt($encrypted, $secret_key, $link_secret_iv);
	}
	else if ( $mode_up == 'update_link_run') {
		if ( !$H_ID ) {
			$url = "ulist_admin.php";
			echo "<script>alert('Please log in'); window.open('$url', '_self', '');</script>";
		}
		$title_		= $_REQUEST['title_nm'];		// title
		$seq		= $_REQUEST['seq_no'];
		$url_		= $_REQUEST['url_nm'];  // url
		$job_label	= $_REQUEST['job_label'];
		$gong_num	= $_REQUEST['gong_num'];
		$memo		= $_REQUEST['memo'];			// memo
		$sql = "update {$tkher['job_link_table']} set user_name='$title_', job_name='$g_name', job_addr='$url_', job_group='$g_name', job_group_code='$g_name_code', memo='$memo' where seqno='$seq' ";
		$result = sql_query(  $sql );
		$memo='';
		$title_='';
		echo "<script>location.href('ulist_admin.php?g_name=$g_name');</script>";
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
	function check_enter() { if (event.keyCode == 13) { search_func(); } }
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, ulist_admin.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
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
	function call_pg_select( link_, id, group, title_, jong, num, aboard_no, seqno) {
        //if(jong=='M') link_='/t/menu/' + id + '/' + num + '_r1.htm'; // add M=menu
		document.coinview_form.link_.value =link_;
		document.coinview_form.mid.value   =id;
		document.coinview_form.group.value =group;
		document.coinview_form.title_.value=title_;
		document.coinview_form.jong.value  =jong;
		document.coinview_form.num.value   =num;
		document.coinview_form.aboard_no.value =aboard_no;
		document.coinview_form.seqno.value =seqno;
        document.coinview_form.action='<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
		document.coinview_form.target='_blank';
		document.coinview_form.submit();
	}
	//------------ tree -------------
	function contents_del( num, g_name, webnum ) {
		if( confirm('Are you sure you want to delete? '+num) ) {
			insert_form.mode.value='delete_link';
			insert_form.num.value=num;
			insert_form.webnum.value=webnum;
			insert_form.g_name.value=g_name;
			insert_form.submit();
		}
	}
	function contents_upd( seq_no, g_name, webnum, job_addr, memo, title, mid, H_ID ) { // title click run
		form = document.insert_form;
		form.seq_no.value=seq_no;
		form.webnum.value=webnum;
		form.g_name.value=g_name;
		form.url_nm.value=job_addr; // url
		form.title_nm.value=title;
		form.form_psw.value='';
		form.memo.value=memo;

		if( mid !== H_ID) {
			document.getElementById('save_button').style.visibility = 'hidden';
			document.getElementById('Save_encrypted').style.visibility = 'hidden';
			document.getElementById('Decryption').style.visibility = 'hidden';
		} else {
			document.getElementById('save_button').style.visibility = 'visible';
			document.getElementById('Save_encrypted').style.visibility = 'visible';
			document.getElementById('Decryption').style.visibility = 'visible';
		}
		//-------------------------------------------
		var seq_no= $("#seq_no").val();		//alert( seq_no + ", memo: " + memo);
jQuery(document).ready(function ($) {
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_admin_ajax.php',
				data: {
					"mode_insert": 'view_click',
					"seq_no": seq_no
				},
			success: function(data) {
				//console.log(data);
				//alert("OK ---" + seq_no);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(" confirm. -- ulink_admin_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
});


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
		//alert("view_click --- " );

	});


	$('#Save_encrypted').on('click', function() {		//alert('버튼 클릭됨');		//$('#element').text('새 텍스트 내용');
		var encrypted_check= $("#encrypted_check").val();
		if( encrypted_check == ""){
			alert("Login Please!"); return false;
		}
		var memo= $("#memo").val();
		var pws= $("#form_psw").val();

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_admin_ajax.php',
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
				alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- ulink_admin_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

	$('#Decryption').on('click', function() {
		var memo= $("#memo").val();
		var pws= $("#form_psw").val();

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_admin_ajax.php',
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
				alert("data or URL confirm.-- ulist_admin.php");
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

		var tit= $("#title_nm").val();
		var url= $("#url_nm").val();
		var memo= $("#memo").val();
		var password= $("#form_psw").val();
		var encrypted_check= $("#encrypted_check").val();
		//alert("tit:  --" + tit + ", url:" + url +", memo" + memo + ", pw:" + password + ", enc: " +encrypted_check);  return;

		event.preventDefault();
		//validation for login form
        $("#progress").html('Inserting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>');

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'ulink_admin_ajax.php',
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

	$('#insert_group').on('click', function() {		//alert('버튼 클릭됨');
		var g_code = $("#g_name_code").val();
		var g_name= $("#g_name").val();		
		alert(" g_code:" + g_code + ", g_name:" + g_name); //return;

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_admin_ajax.php',
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
				alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- ulink_admin_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

	$('#update_group').on('click', function() {		//alert('버튼 클릭됨');
		var g_code = $("#g_name_code").val();
		var g_name= $("#g_name").val();		
		alert(" g_code:" + g_code + ", g_name:" + g_name); //return;

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_admin_ajax.php',
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
				alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- ulink_admin_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

});
</script>


<body>
<?php
		$cur='B';
		include_once "../menu_run.php"; 
?>

<form id="insert_form" name='insert_form' method='post' enctype='multipart/form-data' >
	<input type='hidden' name='g_type'			value='<?=$g_type?>' > 
	<input type='hidden' name='g_name_old'	value='<?=$g_name?>' > 
	<input type='hidden' name='g_user'			value='<?=$gg_user?>' > 
	<input type='hidden' name='mode_in'		value='' > 
	<input type='hidden' name='mode_up'		value='' > 
	<input type='hidden' name='seq_no' id='seq_no'	value='<?=$_REQUEST['seq_no']?>' > 
	<input type='hidden' name='page'			value='<?=$page?>' > 
	<input type='hidden' name='mode'			value='<?=$mode?>' > 
	<input type='hidden' name='mode_insert'			value='insert_mode' > 
	<input type='hidden' name='pg_'				value='<?=$pg_?>' > 
	<input type='hidden' name='target_'			value='<?=$target_?>' > 
	<input type='hidden' name='type_'			value='<?=$type_?>' > 
	<input type='hidden' name='data'			value='<?=$sdata?>' > 
	<input type='hidden' name='num'				value='' > 
	<input type='hidden' name='webnum'			value='' > 
	<input type='hidden' name='gong_num' value='0'>
	<input type='hidden' id='g_name_code' name='g_name_code' value='<?=$g_name_code?>'>

<div id="mypanel" class="ddpanel">
<div id="mypanelcontent" class="ddpanelcontent">
<table border='0' bgcolor='#cccccc' width='100%'>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Project</td>
		<td bgcolor='#ffffff'>&nbsp; 
			<select name='sel_g_name' onchange="change_g_name_func(this.value);" title="select Project">
				<option value=''>Project select</option>
				<!-- <option value='ETC:ETC:<?=$H_ID?>:' <?php if($g_name_code=='ETC' || $g_name_code=='') echo "selected"; ?>>ETC</option> -->
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
			<input type='hidden' id='g_name' name='g_name' size='10' value='<?=$g_name?>' readonly> 
		</td>
	</tr>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Title</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp; <input type='text' id='title_nm' name='title_nm' size='20' value='<?=$title_?>' onKeyDown="check_enter()" >
		</td>
	</tr>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; URL </td>
		<td bgcolor='#ffffff'>&nbsp; <input type='text' id='url_nm' name='url_nm' size='70' maxlength='550'  value='<?=$link_?>'>
		</td>
	</tr>
	
	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Memo</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp; <textarea id="memo" name="memo" rows="4" cols="50"><?=$memo?></textarea>

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
		<!-- <td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Title</td> -->
		<td bgcolor='#ffffff' colspan=2><font color='black'>&nbsp; 
			<!-- <input type='text' name='title_nm' size='20' value='<?=$title_?>' onKeyDown="check_enter()" > -->
<?php if( isset($H_ID) && $H_ID !== "") { ?>
<?php 
				if ( $mode == 'update_link') { ?>			
					<input type='button'  onclick="javascript:contents_upd_run();" value='Save Changes' style="background-color:blue;color:yellow;height:25;">
					<input type='button'  onclick="javascript:Cancle_run();" value='Cancel Change' style="background-color:red;color:yellow;height:25;">
<?php		} else { ?>			
					<!-- <input type='button'  onclick="javascript:insert_url_func();" value='Save' style="background-color:green;color:yellow;height:25;" title='Save the link.'> --> User:<?=$H_ID?>
<?php		} ?>			
					<input id="save_button" type="submit" value="Note Save" style="background-color:blue;color:yellow;height:25;" /><!-- curl run button -->
<?php } ?> 
					<!-- <input type='button'  onclick="javascript:Note_Save_ajax(this);" value='Note Save' style="background-color:green;color:yellow;height:25;" title='Save the link.'> --> 

		</td>
	</tr>
	</form>
</table>
</div>
<div id="mypaneltab" class="ddpaneltab" >
<a href="#" ><span style="background-color:;color:yellow;">Note Create</span> </a>
</div>
</div>



<link rel="stylesheet" href="../include/css/kancss.css" type="text/css">
 <!-- 
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, ulist_admin.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
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
			<script type="text/javascript" src="../include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="javascript:void()" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Project List [▼]</b></font>
				</a> 
			</p>
			<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">
			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
	if( isset($H_ID) && $H_LEV > 1 ) {
		$sql = "select * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name ";
		$ttt = "mylist";
		$tM = "mylist";
	} else {
		$sql = "select * from {$tkher['table10_group_table']} order by group_name ";
		$ttt = "ALL-List";
		$tM = "";
	}
?>
				<tr>
				<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;
					<img src='../icon/left_icon.gif'>
					<a href="./ulist_admin.php?g_type=<?=$tM?>" target='iframe_url'>&nbsp;
					<font color='blue'><?=$ttt?></a>
				</td>
				</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulist_admin.php?g_type=P" target='iframe_url'>Program list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulist_admin.php?g_type=U" target='iframe_url'>Note list</a><!-- <a href="ulist_admin.php?g_type=D" target='iframe_url'>Note list</a> -->
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulist_admin.php?g_type=G" target='iframe_url'>Board list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulist_admin.php?g_type=T" target='iframe_url'>Link list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulist_admin.php?g_type=M" target='iframe_url'>Menu list</a>
		</td>
		</tr>
<?php
	$result = sql_query( $sql );
	$j=0;
	while ( $rs = sql_fetch_array( $result )  ) { //m_("nm: " .$rs['group_name']);
?>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulist_admin.php?g_name=<?=$rs['group_name']?>:<?=$rs['userid']?>" target='_top'><?=$rs['group_name']?></a>
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
			$sdata = $title_nm;
		}
		//m_("1 mylist ---: " . $g_name . ", g_type: " . $g_type);//1 mylist ---: , g_type: my-list
		if ( $g_type=='mylist' && isset($sdata) && $sdata !== ""  ) { //m_("1 - my g_type: " . $g_type);
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE user_id='$H_ID' and user_name like '%$sdata%' ";
		} else if ( $g_type=='mylist' ) {  //m_("OK 1 - mylist ---");
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE user_id='$H_ID'   ";
		} else if ( $g_type=='M' ) { // menu
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE job_group='menu' ";
		} else if ( $g_type=='T' ) { // link T, U
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='T' "; // sysbom menu url link
		} else if ( $g_type=='G' ) { // 게시판 A, [G, F]:tkher_bbs/bbs_listTT.php
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='G' or jong='A' or jong='F' ";
		} else if ( $g_type=='U' ) { // Note - U
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='U' ";
		} else if ( $g_type=='D' ) { // Note D, B:webeditor content
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='D' or jong='B' ";
		} else if ( $g_type=='P' ) {
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='p' ";
		} else if ( isset($g_name) && $g_name !== "" && isset($sdata) && $sdata !== "" ){ //m_(" 2 g_name :" . $g_name);
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE (job_name='$g_name' or job_group='$g_name') and user_name like '%$sdata%'   ";
		} else if ( isset($g_name) && $g_name !== "" ) { //m_(" g_name :" . $g_name);
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE (job_name='$g_name' or job_group='$g_name') ";
		} else if ( isset($sdata) && $sdata !== "" ) { //m_(" 3 g_name :" . $g_name);
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE user_name like '%$sdata%' ";
		} else{ //m_(" 4 g_name :" . $g_name . ", g_type: " . $g_type); // 4 g_name :, g_type: 
			$ls = "SELECT job_addr from {$tkher['job_link_table']} ";
		}
		$result = sql_query( $ls );
		$total = sql_num_rows($result);
		if(!$page) $page=1; 
		$total_page = intval(($total-1) / $limite)+1; 
		$first = ($page-1)*$limite; 
		$last = $limite; 
		if($total < $last) $last = $total;
		$limit = " limit $first,$last";
		if ($page == "1")
			$no = $total;
		else {
			$no = $total - ($page - 1) * $limite;
		}
		if( $sdata )  $g_nameX = "Search : " . $sdata;
		else if( !$g_name ) $g_nameX = " page:" . $page . ", [count:" .$total. "]";
		else $g_nameX = "Group: " . $g_name;
		if( $H_ID ) $g_nameX = $g_nameX . ", level:" . $member['mb_level'] . "," .$member['mb_email'];
?>
		<!-- <tr>
			<td bgcolor='#f4f4f4'  align='center' colspan=7><font color='black'>&nbsp;<?=$g_nameX?> [count:<?=$total?>]
			</td> 
		</tr> -->
<table class='floating-thead' width='100%'>
<thead  width='100%'>
		<tr align='center'>
			<TH>icon</TH>
			<TH>Project</TH>
			<!-- <TH>User</TH> -->
			<TH>Title</TH>
			<!-- <TH>URL-Link </TH> -->
			<TH>Link Url</TH>
			<TH>type</TH>
			<TH>View</TH>
			<TH>date</TH>
			<!-- <TH>lev</TH>-->
			<!-- <TH>management</TH> -->
		</tr>
</thead>
<tbody width='100%'>
		<?php
			if ( $g_type=='mylist' && isset($sdata) && $sdata !=="" ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID' and user_name like '%$sdata%'    ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='mylist' ) {  //m_("OK 2 g_type: " . $g_type);
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID'  ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='P' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='P' ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='D' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='D' or jong='B' ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='G' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='G' or jong='A' ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='T' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='T' ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='M' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='M' ";
				//$ls = $ls . " WHERE job_group='menu' ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='U' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='U' ";
				//$ls = $ls . " WHERE job_group='menu' ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( isset($g_name) && $g_name !== "" && isset($sdata) && $sdata !== "" ) { //m_("--- 0 g_name : " . $g_name );
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE (job_name='$g_name' or job_group='$g_name') and user_name like '%$sdata%'   ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( isset($g_name) && $g_name !== "" ) { //m_("--- 1 g_name : " . $g_name );
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE (job_name='$g_name' or job_group='$g_name') $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( isset($sdata) && $sdata !== "" ) { //m_("--- sdata : " . $sdata );
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_name like '%$sdata%'    ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else{ //m_("--- 2 g_name : " . $g_name );
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			}
		$result = sql_query(  $ls );
		while ( $rs = sql_fetch_array( $result ) ) {
			$sys_label	= $rs['job_name'];		//  분류
			$sys_name	= $rs['user_name'];		//  타이틀명 
			$rs_job_addr	= $rs['job_addr'];		//	프로그램명. or  Url 
			$sys_group	= $rs['job_group'];   // project
			$num		= $rs['num'];				//  생성번호.
			$user_id	= $rs['user_id'];			//  작성자id
			$seqno		= $rs['seqno'];
			$lev		= $rs['job_level'];
			$gubun		= $rs['jong'];
			$aboard_no  = $rs['aboard_no'];
			$memo       = $rs['memo'];
			$lev = $rs['job_level'];
			$url_ = substr($rs_job_addr, 0, 60);
			$td_bg = '#000000';

			if( $gubun == 'T' )	{
				$icon='../icon/berry.png'; $gubunT='T-Berry';$t_color='white';	$i_tit='T : Link URL';
			} else if( $gubun == 'B' or    $gubun == 'D' or $rs['job_group'] == 'DOC' ){ 
				$icon='../icon/seed.png';  $gubunT='B-Seed';$t_color='cyan';			$i_tit='D or DOC : Document';
			} else if( $gubun == 'G' )	{ 
				$icon='../icon/pizza.png'; $gubunT='D-Pizza';$t_color='cyan';			$i_tit='B : Tree Document : Ebook';
			} else if( $gubun == 'P' )	{// Program List
				$icon='../icon/pcman1.png'; $gubunT='Program';$t_color='cyan';	$i_tit='P : Program';
			}
			else if( $gubun=='F' ){ $icon='../icon/land.png'; $gubunT='Land';$t_color='green';$i_tit='Board';}
			else if( $gubun=='G' ){ $icon='../icon/ship.png'; $gubunT='Ship';$t_color='green';$i_tit='Tree Board';}
			else if( $gubun=='A' ){ $icon='../icon/ship.png'; $gubunT='A-board';$t_color='yellow'; $i_tit='A: T-ABoard';}
			else if( $gubun=='M' ){ $icon='../icon/land.png'; $gubunT='BOM-Main';$t_color='yellow';$i_tit='M: Tree-Main';}
			else if( $gubun=='N' ){ $icon='../icon/leaf.png'; $gubunT='BOM-Note';$t_color='yellow';$i_tit='N: Tree-Note';}
			else if( $gubun=='U' ){ $icon='../icon/seed.png'; $gubunT='U-Leaf';  $t_color='white'; $i_tit='U: Link Note';}
			else	$t_color='grace';
?>
				<tr valign="middle" align='left' width='30' height='20'> 
				  <td  bgcolor='black' width='30' title='<?=$user_id?>'><img src='<?=$icon?>' width='30' ></td>
				  <td  bgcolor='black' width='30' width='5%' style="color:<?=$t_color?>;"><?=$sys_group?></td>
				  <!-- <td  bgcolor='black' width='30'  width='5%' style="color:<?=$t_color?>;"><?=$user_id?></td> -->
				  <!-- <td bgcolor='<?=$td_bg?>' align='left'  width='150' title='type:<?=$gubun?>'>
					<a href="javascript:call_pg_selectT( '<?=$rs_job_addr?>', '<?=$user_id?>', '<?=$sys_label?>', '<?=$sys_name?>','<?=$gubun?>','<?=$num?>','<?=$aboard_no?>', '<?=$seqno?>' )" style="background-color:black;color:<?=$t_color?>;"  title='type:<?=$gubun?>'><?=$sys_label?></a>
				  </td> -->
<?php if( $rs['job_name']=='Note') { ?>
				  <!-- <td bgcolor='<?=$td_bg?>' align='left' title='<?=$memo?>'>
					<a href="javascript:void(0);" onclick="contents_upd( '<?=$seqno?>', '<?=$sys_label?>', '<?=$num?>', '<?=$rs_job_addr?>', '<?=$memo?>', '<?=$sys_name?>', '<?=$user_id?>', '<?=$H_ID?>');" class="view_click" style="background-color:black;color:<?=$t_color?>;" ><?=$sys_name?></a>
				  </td> -->
				  <td bgcolor='<?=$td_bg?>' align='left' title='<?=$user_id?>'>
					<a href="javascript:contents_upd( '<?=$seqno?>', '<?=$sys_label?>', '<?=$num?>', '<?=$rs_job_addr?>', '<?=$memo?>', '<?=$sys_name?>', '<?=$user_id?>', '<?=$H_ID?>');" style="background-color:black;color:<?=$t_color?>;" ><?=$sys_name?></a>
				  </td>
<?php } else {?>
				  <td bgcolor='<?=$td_bg?>' align='left' title='<?=$user_id?>'>
					<a href="javascript:call_pg_select( '<?=$rs_job_addr?>', '<?=$user_id?>', '<?=$sys_label?>', '<?=$sys_name?>','<?=$gubun?>','<?=$num?>','<?=$aboard_no?>', '<?=$seqno?>' )" style="background-color:black;color:<?=$t_color?>;" title='<?=$user_id?>'><?=$sys_name?></a>
				  </td>
<?php }?>
				  <td style="background-color:black;color:<?=$t_color?>;" ><?=$rs_job_addr?></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:80px;" ><?=$i_tit ?></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:30px;" ><?=$rs['view_cnt'] ?></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:120px;" ><?=$rs['up_day'] ?></td>
			  <?php 
			  if ( $H_ID ) {
			  ?>
				  <!-- <td style="background-color:black;color:<?=$t_color?>;width:100px;" >
				  <?php 
				  if ( $gubun=='U' && ($H_ID==$rs['user_id']) ) {
				  ?>
					  <input type='button' onclick="javascript:contents_del( '<?=$seqno?>', '<?=$g_name?>', '<?=$num?>' );" value='delete' style="background-color:red;color:yellow;height:25;">
					  <input type='button' onclick="javascript:contents_upd( '<?=$seqno?>', '<?=$sys_label?>', '<?=$num?>', '<?=$rs_job_addr?>', '<?=$memo?>', '<?=$sys_name?>');" value='Change' style="background-color:blue;color:yellow;height:25;">
				<?php } else { ?>
						---
			<?php }  ?>
			  </td>
			<?php } ?> 
				</tr> -->
		<?php
			}	//-------- Loop
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
