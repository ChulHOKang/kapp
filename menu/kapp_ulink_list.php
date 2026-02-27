<?php
	include_once('../tkher_start_necessary.php');
	/*  
		kapp_ulink_list.php, ulink_list.php , ulist.php : table : {$tkher['job_link_table']} 
		cratree_my_list_menu.php - inc menu_run.php - search call
	*/
	$H_ID	= get_session("ss_mb_id"); 
	if( !$H_ID || $H_ID =='' ) {
		m_("my page login please");
		echo("<meta http-equiv='refresh' content='0; URL=../'>"); exit;
	}
	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$H_EMAIL=$member['mb_email'];
	if( $H_LEV < 2) {
		m_("my page login please");
		echo("<meta http-equiv='refresh' content='0; URL=../index.php'>"); exit;
	}
	$up_day = date("Y-m-d H:i:s");
	$pg_		= 'kapp_ulink_list.php';
	if( isset($_POST['target_']) ) $target_	= $_POST['target_'];
	else $target_ = 'iframe_url';
	$type_ = 'U';
	$title_='';
	$secret_key = "";
	$link_	= "";
	$gg_user = "";
?>
<html> 
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="../icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>

<style>
table { border-collapse: collapse; }
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
<script>
$(function () {
	let timer;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			switch(e.target.innerText){
				case 'Project' : title_func('job_group'); break;
				case 'User'    : title_func('user_id'); break;
				case 'Title'   : title_func('user_name'); break;
				case 'Link Url': title_func('job_addr'); break;
				case 'type'    : title_func('jong'); break;
				case 'View'    : title_func('view_cnt'); break;
				case 'date'    : title_func('up_day'); break;
				default        : title_func(''); break;
			}
		}, 250); // 250ms after
	  
	});
	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer);
		switch(e.target.innerText){
			case 'Project' : title_wfunc('job_group'); break;
			case 'User'    : title_wfunc('user_id'); break;
			case 'Title'   : title_wfunc('user_name'); break;
			case 'Link Url': title_wfunc('job_addr'); break;
			case 'type'    : title_wfunc('jong'); break;
			case 'View'    : title_wfunc('view_cnt'); break;
			case 'date'    : title_wfunc('up_day'); break;
			default        : title_wfunc(''); break;
		}
	});

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
<link rel="stylesheet" type="text/css" href="../include/css/dddropdownpanel.css" />
<script type="text/javascript" src="../include/js/dddropdownpanel.js"></script>
<?php
		$g_name = "";
		$project_code = "";
		$project_nmS = ":";
		$g_num = "";

	if( isset($_POST["g_type"]) ) $g_type	= $_POST["g_type"];
	else if( isset($_REQUEST["g_type"]) ) $g_type	= $_REQUEST["g_type"];
	else $g_type	= "";
	if( isset($_REQUEST["title_nm"]) ) $title_nm	= $_REQUEST["title_nm"];
	else $title_nm	= "";

	if( isset($_POST["project_nmS"]) && $_POST["project_nmS"] != '' ) { 
		$project_nmS	= $_POST["project_nmS"];
		$aa = explode(':', $_POST["project_nmS"]); 
		$g_name = $aa[0];
		$g_num = $aa[1];
		$project_code = $g_num;
		$g_name_code = $g_num;
		if( isset($aa[2])) $gg_user = $aa[2];
		else $gg_user = $H_ID;
		if( isset($aa[3])) $g_no = $aa[3];
		else $g_no = "";
	} else {
		if( isset($H_ID) ) $gg_user = $H_ID;
		else $gg_user = "";
		$g_no = "";
	}
	if( isset($_REQUEST["g_name"]) ) $gnm = $_REQUEST["g_name"];
	if( isset($gnm) && $gnm != '' ) {
		$aa = explode(':', $_REQUEST["g_name"]); 
		if( isset($aa[0]) ) $g_name = $aa[0];
		if( isset($aa[1]) ) $g_num = $aa[1];
		if( isset($aa[2]) ) $gg_user = $aa[2];
		if( isset($aa[3]) ) $g_no = $aa[3];
	}
	if( isset($_REQUEST["mode"]) ) 	$mode= $_REQUEST["mode"];
	else if( isset($_POST["mode"]) ) $mode= $_POST["mode"];
	else	$mode			= "";
	if( isset($_REQUEST["memo"]) ) 	$memo= $_REQUEST["memo"];
	else	$memo			= "";
	if( isset($_REQUEST["mode_up"]) ) 	$mode_up= $_REQUEST["mode_up"];
	else if( isset($_POST["mode_up"]) ) $mode_up= $_POST["mode_up"];
	else	$mode_up			= "";
	if( isset($_REQUEST["sdata"]) ) 	$sdata= $_REQUEST["sdata"];
	else	$sdata			= "";
	if( isset($_POST["page"]) )	$page= $_POST["page"];
	else if( isset($_REQUEST["page"]) )	$page= $_REQUEST["page"];
	else $page= 1;
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 15;
	
	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	if( isset( $_POST['fld_code_asc']) ) $fld_code_asc= $_POST['fld_code_asc'];
	else $fld_code_asc = '';

	$page_num = 10; 

	if( $mode == 'update_link') {
		$seq_no = $_REQUEST['seq_no'];	
		$result	= 		$result = sql_query( "select * from {$tkher['job_link_table']} where seqno=$seq_no" );
		$rs		= sql_fetch_array($result);
		if( $rs['job_name'] =='Note' ) {
			$sql= " update {$tkher['job_link_table']} set view_cnt=view_cnt+1 where seqno = $seq_no ";
			sql_query($sql);
			$title_	= $rs['user_name'];
			$link_	= $rs['job_addr'];
			$g_name	= $rs['job_name'];
			$lev	= $rs['job_level'];
			$jong	= $rs['jong'];
			$memo	= $rs['memo'];
		}
	}else if($mode == 'insert_url_func_mode') { 
		if ( !$H_ID ) {
			$url = "kapp_ulink_list.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$job_ = 'Link Note';
		$create_type = 'Note';
		$title_nm		= $_POST['title_nm'];
		$sys_subtit		= $_POST['title_nm'];
		$job_url	= KAPP_URL_T_ . "/my/kapp_ulink_list.php";
		$sys_link	= KAPP_URL_T_ . "/my/kapp_ulink_list.php";
		$url_nm	= $_POST['url_nm'];
		$memo		= $_POST['memo'];
		$jong	= 'U';	                   //  link list note
		$ip = $_SERVER['REMOTE_ADDR'];
		$up_day  = date("Y-m-d-H:i:s");
		$kapp_url = KAPP_URL_T_;
		$g_name=$_POST['g_name']; 
		$project_code=$_POST['project_code']; 

		$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$url_nm', user_name='$title_nm', job_name='$create_type', job_group='$g_name', job_group_code='$project_code', job_addr='$job_url', job_level='0', jong='$jong', memo='$memo', ip='$ip', num='Note', aboard_no='$job_', email='$H_EMAIL', up_day='$up_day' ";
		$ret = sql_query(  $sqlA ); 

		$kapp_theme0 = '';
		$kapp_theme1 = '';
		$kapp_theme = $config['kapp_theme'];
		$kapp_theme = explode('^', $kapp_theme );
		$kapp_theme0 = $kapp_theme[0];
		$kapp_theme1 = $kapp_theme[1];
		if( $ret ) {
			if( $kapp_theme0 !='' ) {
				$kapp_theme0 = $kapp_mainnet;
				if( Link_Table_curl_send( $kapp_theme0, $sys_subtit, $sys_link, $jong, $url_nm, $ip, $memo, $up_day ) ) {
					if( $kapp_theme1 ) Link_Table_curl_send( $kapp_theme1, $sys_subtit, $sys_link, $jong, $url_nm, $ip, $memo, $up_day );
				}
			}
			m_("job_link_table --- insert ok");
		} else {
			m_("my_func - job_link_table_add error ");
		}
	}
	if($mode_up == 'Save_encrypted_run') {
		if ( !$H_ID ) {
			$url = "kapp_ulink_list.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$link_ = $_POST['url_nm'];
		$title_ = $_POST['title_nm'];
		$str = $_POST['memo'];
		$secret_key = $_POST['form_psw'];
		$memo = Encrypt($str, $secret_key, $link_secret_iv);
	}else if($mode_up == 'Decryption_run') {
		$link_ = $_POST['url_nm'];
		$title_ = $_POST['title_nm'];
		$encrypted = $_POST['memo'];
		$secret_key = $_POST['form_psw'];
		$memo = Decrypt($encrypted, $secret_key, $link_secret_iv);
	}else if ( $mode_up == 'update_link_run') {
		if ( !$H_ID ) {
			$url = "kapp_ulink_list.php";
			echo "<script>alert('Please log in'); window.open('$url', '_self', '');</script>";
		}
		$seq		= $_POST['seq_no'];
		$title_		= $_POST['title_nm'];
		$url_		= $_POST['url_nm']; 
		$memo		= $_POST['memo'];
		$memo = special_comma_chk($memo); 
		$sql = "update {$tkher['job_link_table']} set user_name='$title_', job_addr='$url_', memo='$memo' where seqno='$seq' ";
		$result = sql_query(  $sql );
		$memo='';
		$title_='';
		echo "<script>location.href('kapp_ulink_list.php?g_name=$g_name');</script>";
	}
?>
<script language='javascript'>
<!--
	function initA(){
		document.getElementById('upd_save_button').style.visibility = 'hidden'; 
		document.getElementById('upd_cancle').style.visibility = 'hidden'; 
	}
	function check_enter() { 
		if (event.keyCode == 13) { 
			project_code=insert_form.project_code.value;
			if(project_code =='') {
				alert('select project --- '); 
				document.insert_form.project_nmS.focus();
			}
			else document.insert_form.memo.focus();
		} 

	}
	function change_g_name_func(g_nm) {
		g_name = g_nm;
		var gg = g_nm.split(":");
		g_name2 = gg[0];
		g_num = gg[1];
		g_id = gg[2];
		g_no = gg[3];
		document.insert_form.g_name.value = gg[0]; 
		document.insert_form.project_code.value = gg[1]; 
		document.insert_form.g_name_code.value = gg[1];
	}
	function call_pg_select( link_, id, group, title_, jong, num, aboard_no, seqno) {
		document.insert_form.link_.value =link_;
		document.insert_form.mid.value   =id;
		document.insert_form.group.value =group;
		document.insert_form.title_.value=title_;
		document.insert_form.jong.value  =jong;
		document.insert_form.num.value   =num;
		document.insert_form.aboard_no.value =aboard_no;
		document.insert_form.seqno.value =seqno;
        document.insert_form.action='./cratree_coinadd_menu.php';
		document.insert_form.target='_blank';
		document.insert_form.submit();
	}
	function contents_del( num, g_name, webnum ) {
		if( confirm('Are you sure you want to delete? '+num) ) {
			insert_form.mode.value='delete_link';
			insert_form.num.value=num;
			insert_form.webnum.value=webnum;
			insert_form.g_name.value=g_name;
			insert_form.submit();
		}
	}
	function contents_upd( seq_no, g_name, webnum, job_addr, memo, title, mid, H_ID ) {
		form = document.insert_form;
		form.seq_no.value=seq_no;
		form.webnum.value=webnum;
		form.g_name.value=g_name;
		form.url_nm.value=job_addr;
		form.title_nm.value=title;
		form.form_psw.value='';
		form.memo.value=memo;
		form.mode.value="update_link";
		if( mid !== H_ID) {
			document.getElementById('save_button').style.visibility = 'hidden';
			document.getElementById('Save_encrypted').style.visibility = 'hidden';
			document.getElementById('Decryption').style.visibility = 'hidden';
		} else {
			document.getElementById('upd_save_button').style.visibility = 'visible';
			document.getElementById('upd_cancle').style.visibility = 'visible';
			document.getElementById('Save_encrypted').style.visibility = 'visible';
			document.getElementById('Decryption').style.visibility = 'visible';
			document.getElementById('save_button').style.visibility = 'hidden';
		}
		var seq_no= $("#seq_no").val();
		jQuery(document).ready(function ($) {
				$.ajax({
					header:{"Content-Type":"application/json"},
					method: "post",
						url: KAPP_URL_T_ +'/menu/ulink_ajax.php',
						data: {
							"mode_insert": 'view_click',
							"seq_no": seq_no
						},
					success: function(data) {
						//console.log(data);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(" error.-- ulink_list, ajax.php");
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
		document.getElementById('upd_save_button').style.visibility = 'hidden';
		document.getElementById('upd_cancle').style.visibility = 'hidden';
		document.getElementById('save_button').style.visibility = 'visible';
		form = document.insert_form;
		form.seq_no.value='';
		form.url_nm.value='';
		form.title_nm.value='';
		document.getElementById("memo").value = "";
	}
	function insert_url_func() {
		document.insert_form.mode.value = "insert_url_func_mode";
		document.insert_form.action='kapp_ulink_list.php'; 
		document.insert_form.target='_self';
		document.insert_form.submit();
	}
	function Change_line_cnt( $line){
		document.insert_form.page.value = 1;
		document.insert_form.action='kapp_ulink_list.php';
		document.insert_form.submit();
	}
	function title_wfunc(fld_code){       
		document.insert_form.page.value = 1;
		document.insert_form.fld_code.value= fld_code;
		document.insert_form.fld_code_asc.value= 'desc';
		document.insert_form.mode.value='title_wfunc';
		document.insert_form.target='_self';
		document.insert_form.action='kapp_ulink_list.php';
		document.insert_form.submit();                         
	} 
	function title_func(fld_code){       
		document.insert_form.page.value = 1;                
		document.insert_form.fld_code.value= fld_code;           
		document.insert_form.fld_code_asc.value= 'asc';
		document.insert_form.mode.value='title_func';           
		document.insert_form.target='_self';
		document.insert_form.action='kapp_ulink_list.php';
		document.insert_form.submit();                         
	} 
	function g_type_func(gtype){
		document.insert_form.g_type.value = gtype;
		document.insert_form.page.value = 1;                
		document.insert_form.mode.value='type_func';           
		document.insert_form.target='_self';           
		document.insert_form.action='kapp_ulink_list.php';
		document.insert_form.submit();                         
	} 
	function page_func( $page, $search, $sdata, $g_name, $g_type){
		document.insert_form.page.value = $page;
		document.insert_form.action='kapp_ulink_list.php';
		document.insert_form.submit();
	}
//-->
</script>

<script>
jQuery(document).ready(function ($) {
	$('a[href^="#"], .view_click').on('click', function( seq_no, g_name, webnum, job_addr, memo, title, mid, H_ID) {
		//var seq_no = $("#insert_form").seq_no.val();
	});
	$('#Save_encrypted').on('click', function() {
		var memo= $("#memo").val();
		var pws= $("#form_psw").val();
		if(pws==='') {
			alert("key none"); return false;
		}
		var encrypted_check= $("#encrypted_check").val();
		if( encrypted_check == ""){
			alert("Login Please!"); return false;
		}
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_ajax.php',
				data: {
					"mode_insert": 'Encryption_data',
					"memo": memo,
					"pws": pws
				},
			success: function(data) {
				$("#memo").val(data);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("The data type or URL is incorrect. -- ulink_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});
	$('#Decryption').on('click', function() {
		var encrypted_check= $("#encrypted_check").val();
		if( encrypted_check == ""){
			alert("Login Please!"); return false;
		}
		var memo= $("#memo").val();
		var pws= $("#form_psw").val();
		if( pws==='') {
			alert("key none"); return false;
		}
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_ajax.php',
				data: {
					"mode_insert": 'Decryption_data',
					"memo": memo,
					"pws": pws
				},
			success: function(data) {
				$("#memo").val(data);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("data or URL confirm.-- kapp_ulink_list.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

    $("#insert_form").submit(function (event) {
		var g_name= $("#g_name").val();
		var project_code= $("#project_code").val();
		var tit= $("#title_nm").val();
		var url= $("#url_nm").val();
		var memo= $("#memo").val();
		var password= $("#form_psw").val();
		var encrypted_check= $("#encrypted_check").val();
		if( project_code=="" || tit == "" || memo == "" ) {
			alert("project or title or memo confirm");
			return false
		}
		event.preventDefault();
        $("#progress").html('Inserting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>');
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'ulink_ajax.php',
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) 
                {
                    //show return answer
                    alert("OK insert data: " +data);
					location.replace(location.href);
                },
                error: function(){
					//alert("error in ajax form submission");
				}
        });
		//location.reload();
        return;
    });

	$('#insert_group').on('click', function() {	
		var g_code = $("#project_code").val();
		var g_name= $("#g_name").val();		
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_ajax.php',
				data: {
					"mode_insert": 'Group_insert',
					"g_code": g_code,
					"g_name": g_name
				},
			success: function(data) {
				alert(data);
					location.replace(location.href);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("The data type or URL is incorrect. -- ulink_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});
	$('#update_group').on('click', function() {
		var g_code = $("#project_code").val();
		var g_name= $("#g_name").val();		
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'ulink_ajax.php',
				data: {
					"mode_insert": 'Group_update',
					"g_code": g_code,
					"g_name": g_name
				},
			success: function(data) {
					//	$("#g_name").val(data);	//console.log(data);
					alert(data);
					location.replace(location.href);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("The data type or URL is incorrect. -- ulink_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

});
</script>

<body onload="initA()">
<?php
	$cur='B';
	include_once "../menu_run.php"; 
		if( $mode == 'search_rtn') {
			$sdata = $title_nm;
		}
		if( isset($sdata) && $sdata != ''  ) {
				$ls = "SELECT * from {$tkher['job_link_table']} WHERE user_id='$H_ID' and user_name like '%$sdata%' ";
		} else if ( $g_type=='mylist' ) { 
				$ls = "SELECT * from {$tkher['job_link_table']} WHERE user_id='$H_ID' ";
		} else if ( $g_type!='' ) { 
				$ls = "SELECT * from {$tkher['job_link_table']} WHERE user_id='$H_ID' and jong='".$g_type."' ";
		} else{
			$ls = "SELECT * from {$tkher['job_link_table']} WHERE user_id='$H_ID' ";
		}

		$result = sql_query( $ls );
		$total = sql_num_rows($result);
		$total_page = intval(($total-1) / $line_cnt)+1; 
		if( $page > 1) $first = ($page-1)*$line_cnt; 
		else $first = 0;
		$last = $line_cnt; 
		if($total < $last) $last = $total;
		$limit = " limit $first, $last";
		if( $page > 1)
			$no = $total - ($page - 1) * $line_cnt;
		else {
			$no = $total;
		}
		if( $sdata )  $g_nameX = "Search : " . $sdata;
		else if( !$g_name ) $g_nameX = " page:" . $page . ", [count:" .$total. "]";
		else $g_nameX = "Group: " . $g_name;
		$g_nameX = $g_nameX . ", level:" . $H_LEV . "," .$H_EMAIL;
?>
<form id="insert_form" name='insert_form' method='post' enctype='multipart/form-data' >
	<input type='hidden' name='g_name' id='g_name' value='<?=$g_name?>' > 
	<input type='hidden' name='g_user'			value='<?=$gg_user?>' > 
	<input type='hidden' name='mode_up'		value='<?=$mode_up?>' > 
	<input type='hidden' name='seq_no' id='seq_no'	value='' > 
	<input type='hidden' name='page'			value='<?=$page?>' > 
	<input type='hidden' name='mode'			value='<?=$mode?>' > 
	<input type='hidden' name='g_type'			value='<?=$g_type?>' > 
	<input type='hidden' name='num'				value='' > 
	<input type='hidden' name='fld_code' value='<?=$fld_code?>' > 
	<input type='hidden' name='fld_code_asc' value='<?=$fld_code_asc?>' > 
	<input type='hidden' name='type_'			value='<?=$type_?>' > 
	<input type='hidden' name='mode_insert'			value='insert_mode' > 
	<input type='hidden' name='pg_'				value='<?=$pg_?>' > 
	<input type='hidden' name='target_'			value='<?=$target_?>' > 
	<input type='hidden' name='webnum'			value='' > 
	<input type='hidden' name='project_code' id='project_code' value='<?=$project_code?>'>

	<input type='hidden' name='mid'			value='' > 
	<input type='hidden' name='link_'		value='' > 
	<input type='hidden' name='title_'		value='' > 
	<input type='hidden' name='group'		value='' > 
	<input type='hidden' name='aboard_no'	value='' > 
	<input type='hidden' name='gong_num' value='0'><!-- ulink_ajax.php use -->
	<input type='hidden' id='g_name_code' name='g_name_code' value='<?=$g_name_code?>'><!-- ulink_ajax.php use -->
	<input type='hidden' name='jong'	value='' > 
	<input type='hidden' name='seqno'	value='' > <!-- call_pg_select( link_, id, group, title_, jong, num, aboard_no, seqno) -->


<div id="mypanel" class="ddpanel">
<div id="mypanelcontent" class="ddpanelcontent">
<table border='0' bgcolor='#cccccc' width='100%'>
<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Project</td>
		<td bgcolor='#ffffff'>&nbsp; 
			<select name='project_nmS' onchange="change_g_name_func(this.value);" title="select Project">
				<option value=''>Project select</option>
<?php
		$result = sql_query( "select * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name asc" );
		while($rs = sql_fetch_array($result)) {
			$chk = '';
			if( $project_code == $rs['group_code'] ) $chk = ' selected ';
?>
			<option value='<?=$rs['group_name']?>:<?=$rs['group_code']?>:<?=$rs['userid']?>:<?=$rs['seqno']?>' <?php echo $chk; ?>><?=$rs['group_name']?></option>
<?php
		}
?>
			</select>
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
		<td bgcolor='#f4f4f4'><font color='black'>&nbsp; Memo</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp;
		<textarea id="memo" name="memo" rows="4" cols="50"><?=$memo?></textarea>
			<input type='hidden' id='encrypted_check' name='encrypted_check' value='<?=$H_ID?>'>
			<br> &nbsp; Encryption key:<input type='password' id='form_psw' name='form_psw' size='4' value=''> 
				 &nbsp; <input type='button'  id='Save_encrypted' onclick="javascript:Save_encrypted();" value='Encryption' style="background-color:red;color:yellow;height:25;">
				 &nbsp; <input type='button'  id='Decryption' onclick="javascript:Decryption();" value='Decryption' style="background-color:blue;color:yellow;height:25;">
			<br> &nbsp; Encrypt and save notes. 
			<br> &nbsp; The encryption key is not stored and should be remembered. 
			<br> &nbsp; If you forget the key, the memo can not be decrypted.
		</td>
	</tr>
	<tr>
		<td bgcolor='#ffffff' colspan=2><font color='black'>&nbsp; 
			<input type='button' id="upd_save_button" onclick="javascript:contents_upd_run();" value='Save Changes' style="background-color:blue;color:yellow;height:25;display:;">
			<input type='button' id="upd_cancle" onclick="javascript:Cancle_run();" value='Cancel Change' style="background-color:red;color:yellow;height:25;display:;">
<?php if( isset($H_ID) && $H_ID != '') { ?>
<?php 
			if ( $mode == 'update_link') { ?>			
				<input id="upd_save_button" type='button'  onclick="javascript:contents_upd_run();" value='Save Changes' style="background-color:blue;color:yellow;height:25;">
				<input id="upd_cancle" type='button'  onclick="javascript:Cancle_run();" value='Cancel Change' style="background-color:red;color:yellow;height:25;">
<?php		} ?>			
				<input id="save_button" type="submit" value="Note Save" style="background-color:blue;color:yellow;height:25;" />
				<br> User:<?=$H_ID?> - If you want to change the registered link data, you can change the data by clicking the Title.
<?php } ?> 

		</td>
	</tr>
</table>
</div>

<!-- <div id="mypaneltab" class="ddpaneltab" ><a href="#" ><span style="background-color:;color:yellow;">Note Create</span></a></div> -->
<div id="mypaneltab" class="ddpaneltab" ><span style="background-color:;color:yellow;"><a href="#" style='height:25px;color:yellow;'>&nbsp; &#9776; Note Create &nbsp;▼ &nbsp;</a></span></div>

</div>
<!-- <link rel="stylesheet" href="../include/css/kancss.css" type="text/css"> -->

<table border='0' cellpadding='2' cellspacing='1' bgcolor='#cccccc' width='100%'>
	<tr>
		<td align='left' colspan='9'>
			<script type="text/javascript" src="../include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="javascript:void()" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Project List [▼]</b></font>
				</a> 
				<span style='color:black;text-align:center;font-size:21px;'>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View Line: 
					<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='color:black;text-align:center;font-size:18px;height:27;'>
						<option value='15'  <?php if( $line_cnt=='15')  echo " selected" ?> >15</option>
						<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
						<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
						<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
					</select>
				</span>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<span> total: <?=$total?></span>&nbsp;
				<span> , current page: <?=$page?></span>&nbsp;
				<span> , total page: <?=$total_page?></span>
			</p>
			<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">
			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
		$sql = "select * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name ";
		$ttt = "mylist";
		$tM = "mylist";
?>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;
			<img src='../icon/left_icon.gif'>
			<a onclick="g_type_func('mylist')">mylist</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a onclick="g_type_func('P')">Program list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a onclick="g_type_func('U')">Note list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a onclick="g_type_func('A')">Board list</a><!-- G -->
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a onclick="g_type_func('T')">Link list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a onclick="g_type_func('M')">Menu list</a>
		</td>
		</tr>
<?php
	$result = sql_query( $sql );
	$j=0;
	while( $rs = sql_fetch_array( $result )  ) { 
?>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="kapp_ulink_list.php?g_name=<?=$rs['group_name']?>:<?=$rs['userid']?>" target='_self'><?=$rs['group_name']?></a>
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

<table class='floating-thead' width='100%'>
<thead id='tit_et' width='100%'>
		<tr align='center'>
			<TH>icon</TH>
	<?php
		echo " <TH title='Project Sort click or doubleclick'  >Project</th> ";
		echo " <TH title='Project Sort click or doubleclick' >Title</th> ";
		echo " <TH title='url Sort click or doubleclick' >Link Url</th> ";
		echo " <TH title='type Sort click or doubleclick' >type</th> ";
		echo " <TH title='View Sort click or doubleclick' >View</th> ";
		echo " <TH title='date Sort click or doubleclick' >date</th> ";
	?>
		</tr>
</thead>
<tbody width='1500'>
	<?php
	if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
	else $OrderBy	= " ORDER BY up_day desc, user_name ";
	$ls = $ls . $OrderBy;
	$ls = $ls . $limit;
	$result = sql_query( $ls );
	while( $rs = sql_fetch_array( $result ) ) {
		$sys_group= $rs['job_group'];
		$sys_label	= $rs['job_name'];	
		$sys_name	= $rs['user_name']; //title
		$rs_job_addr	= $rs['job_addr'];
		$rs_club_url	= $rs['club_url'];
		$num		= $rs['num'];
		$user_id	= $rs['user_id'];	
		$seqno		= $rs['seqno'];
		$lev		= $rs['job_level'];
		$gubun		= $rs['jong'];
		$aboard_no  = $rs['aboard_no'];
		$memo       = $rs['memo'];
		$lev = $rs['job_level'];
		$vcnt= number_format($rs['view_cnt']);
		$url_ = substr($rs_job_addr, 0, 60);
		$td_bg = '#000000';

		if( $gubun == 'T' )	{
			$icon='../icon/berry.png'; $gubunT='T-Berry';$t_color='white';	$i_tit='T : Link URL';
		} else if( $gubun == 'B' or    $gubun == 'D' or $rs['job_group'] == 'DOC' ){ 
			$icon='../icon/seed.png';  $gubunT='B-Seed';$t_color='cyan';			$i_tit='B, D, DOC';
		} else if( $gubun == 'G' )	{ 
			$icon='../icon/pizza.png'; $gubunT='G-Pizza';$t_color='cyan';			$i_tit='G : Tree Board';
		} else if( $gubun == 'P' )	{// Program List
			$icon='../icon/pcman1.png'; $gubunT='Program';$t_color='cyan';	$i_tit='P : Program';
		}
		else if( $gubun=='F' ){ $icon='../icon/land.png'; $gubunT='Land';$t_color='green';$i_tit='Board';}
		else if( $gubun=='A' ){ $icon='../icon/ship.png'; $gubunT='A-board';$t_color='cyan'; $i_tit='A: T-ABoard';}
		else if( $gubun=='M' ){ $icon='../icon/land.png'; $gubunT='BOM-Main';$t_color='yellow';$i_tit='M: Tree-Main';}
		else if( $gubun=='N' ){ $icon='../icon/leaf.png'; $gubunT='BOM-Note';$t_color='yellow';$i_tit='N: Tree-Note';}
		else if( $gubun=='U' ){ $icon='../icon/seed.png'; $gubunT='U-Leaf';  $t_color='blue'; $i_tit='U: Link Note';}
		else	$t_color='grace';
?>
				<tr valign="middle" align='left' > 
				  <td  bgcolor='black' title='<?=$user_id?>' style="width:1%;"><img src='<?=$icon?>' style="width:25px;"></td>
				  <td  bgcolor='black' style="width:15%;color:<?=$t_color?>;"><?=$sys_group?></td>
<?php
	if( $rs['job_name']=='Note') { 
?>
	  <td style="background-color:<?=$td_bg?>;color:<?=$t_color?>;width:180px;"  title='<?=$user_id?>:<?=$rs_job_addr?>'>
		<a href="javascript:contents_upd( '<?=$seqno?>', '<?=$sys_label?>', '<?=$num?>', '<?=$rs_job_addr?>', '<?=$memo?>', '<?=$sys_name?>', '<?=$user_id?>', '<?=$H_ID?>');" style="background-color:black;color:<?=$t_color?>;" title='url:<?=$rs_job_addr?>'><?=$sys_name?></a></td>
	  <td style="background-color:black;color:<?=$t_color?>;width:30%;" title="type:<?=$i_tit ?>">
	  <?=$rs_club_url?>
	  </td>
<?php } else { ?>
	  <td style="background-color:<?=$td_bg?>;color:<?=$t_color?>;width:180px;" title='<?=$user_id?>:<?=$rs_job_addr?>'>
		<a href="javascript:call_pg_select( '<?=$rs_job_addr?>', '<?=$user_id?>', '<?=$sys_label?>', '<?=$sys_name?>','<?=$gubun?>','<?=$num?>','<?=$aboard_no?>', '<?=$seqno?>' )" style="background-color:black;color:<?=$t_color?>;" title='url:<?=$rs_job_addr?>'><?=$sys_name?></a></td>
	  <td style="background-color:black;color:<?=$t_color?>;width:30%;" title="type:<?=$i_tit ?>">
	  <?=$rs_job_addr?>
	  </td>
<?php } ?>
	  <td style="background-color:black;color:<?=$t_color?>;width:8px;text-align:center;" title="<?=$i_tit ?>"><?=$gubun?></td>
	  <td style="background-color:black;color:<?=$t_color?>;width:8px;text-align:center;" ><?=$vcnt?></td>
	  <td style="background-color:black;color:<?=$t_color?>;width:80px;text-align:center;" ><?=$rs['up_day']?></td>
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

if( $page > $page_num) 
	echo"[<a onclick=\"javascript:page_func($prev, '$search', '$sdata', '$g_name', '$g_type');\" >Prev</a>] ";
for( $i = $first_page; $i <= $last_page; $i++){
	if( $page == $i) echo" <b>$i</b> "; 
	else echo"[<input type='button' value='[$i]' style='font-size:20px;font-weight:bold;' onclick=\"javascript:page_func($i, '$search', '$sdata', '$g_name', '$g_type');\" >";
}
$next = $last_page+1;
if( $next <= $total_page) 
	echo" [<a onclick=\"javascript:page_func($next, '$search', '$sdata', '$g_name', '$g_type');\" title='page next:$next'>Next</a>]";
?>
	</td>
  </tr>
</table>
</form>
</body>
</html>
