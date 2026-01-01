<?php
	include_once('./tkher_start_necessary.php');
	/*
		kapp_table_index_Create.php : Table index create
		kapp_save_session.php - project_nmS set
	*/
	$H_ID	= get_session("ss_mb_id");
	if( !$H_ID || $H_ID =='' )	{
		m_("You need to login. ");
		$url="./";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_LEV =$member['mb_level'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator,web app,web,homepage,php,no coding system,php source generator">
<meta name="description" content="app generator,web app,web,homepage,php,no coding system,php source generator">
<!-- <meta name="robots" content="ALL"> -->
<style>
table {}
th, td { padding: 8px; text-align: center; border-bottom: 1px solid #DDD; }
tr:hover {background-color: #D6EEEE;}
</style>

<script src="//code.jquery.com/jquery.min.js"></script>
</head>

<?php
	$key_msg='';

	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode = '';	
	
	/*if( isset($_SESSION['project_nmS']) ) $project_nmS = $_SESSION['project_nmS'];
	if( isset($project_nmS) && $project_nmS !=='' ){
		$pcd_nm = explode(":", $project_nmS );
		if( isset($pcd_nm[0]) && $pcd_nm[0] !=='' ) $project_code	= $pcd_nm[0];
		else $project_code = '';	
		if( isset($pcd_nm[1]) && $pcd_nm[1] !=='' ) $project_name	= $pcd_nm[1]; 
		else $project_name= "";
	} else {
		$project_nmS = '';
		$project_name= "";
		$project_code= "";
	}*/
	if( $mode=='Project_Search' || isset( $_SESSION['project_nmS']) ) { //|| isset( $_SESSION['project_nmS'])
		$project_nmS = $_SESSION['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	} else {
		$project_nmS = '';
		$project_name= "";
		$project_code= "";
	}
	if( isset($_POST['seqno']) ) $seqno= $_POST['seqno'];
	else  $seqno = "";
	if( isset($_POST['idx_name']) ) $idx_name= $_POST['idx_name'];
	else  $idx_name = "";
/*
	if( isset($_POST['tab_enm']) ) $tab_enm= $_POST['tab_enm'];
	else  $tab_enm = "";
	if( isset($_POST['tab_hnm']) ) $tab_hnm= $_POST['tab_hnm'];
	else  $tab_hnm = "";
	if( isset($_POST['tab_hnmS']) ) $tab_hnmS= $_POST['tab_hnmS'];
	else if( isset($_REQUEST['tab_hnmS']) ) $tab_hnmS= $_REQUEST['tab_hnmS'];
	else  $tab_hnmS = "";
*/
	if( $mode=='SearchTAB' || isset($_SESSION['tab_hnmS']) ) {
		$tab_hnmS =$_SESSION['tab_hnmS'];
		$tab_R = explode(":", $tab_hnmS);
		$tab_enm = $tab_R[0];
		$tab_hnm = $tab_R[1];
	} else {
		$tab_hnmS = '';
		$tab_enm = '';
		$tab_hnm = '';
	}

	if( isset($_POST['item_cnt']) ) $item_cnt= $_POST['item_cnt'];
	else  $item_cnt = 0;
?>
<body leftmargin="0" topmargin="0">
 
<script language="JavaScript"> 
<!--
 	var frealname	= ''
	var isEdited    = false
	var delList		= ''
	var smode		= false
	var start, end, grpStr
	function indexlist_onclick(keyval) {
		if( keyval == 'seqno') {
			alert("Primary key is not delete : " + keyval);
			document.kapp_makeform.index_name.value='';
		} else {//alert("key is delete : " + keyval);
			document.kapp_makeform.index_name.value=keyval;
		}
	}
	function getfname(str) {
		if (str.indexOf("]") > 0) {
			frealname = str.substring(0, str.indexOf("]")+1)
			str = str.substr(str.indexOf("]")+2)
		}
		return str
	}
	function k_func_ok( r, j ){
		//alert("k_func_ok - r: " + r + ", j: " + j);
		return;
	}
	function r_func(r,qna){
		qna1 = qna.split('^');
		len = qna1.length;
		ss="";
		for(i=0;i<len;i++){
			rr = qna1[i].split('|');
			lenj = rr.length-2;
			ok = rr.length-1;
			ss+=" &#160; <p><form><div>"+(i+1)+". "+rr[0]+"</div> ";
			//ss+=" &#160; <p><div>"+(i+1)+". "+rr[0]+"</div> ";
			for(k=0,j=1; k < lenj; k++, j++){
				//ss+=" &#160; <label><span><input type='radio' name='qna' onclick=\"k_func_ok('"+ rr[j] +"', "+j+", "+rr[ok]+")\" value='"+ rr[j] +"' >" +j+'. ' + rr[j]+" &#160; </span></label><br>";
				ss+=" &#160; <label><span><input type='radio' name='qna' onclick=\"k_func_ok('"+ rr[j] +"', "+j+")\" value='"+ rr[j] +"' >" +j+'. ' + rr[j]+" &#160; </span></label><br>";
			}
		}
		//ss+="</p>";
		ss+="</form></p>";
		here.innerHTML=ss;
	}
	function Print_item_func( ss, qna ){
		if(!ss) r_func('A', qna);
		else here.innerHTML = ss;
	}
	let A_click=0;
	function column_list_onclickAA( j ){
		if( A_click == 1){
			A_click=0;
		} else if( A_click == 0){
			if( document.getElementById('column_list'+j).checked === false ){
				document.getElementById('column_list'+j).checked = true;
			}else{
				document.getElementById('column_list'+j).checked = false;
			}
		}
	}
	function column_list_onclickA( ss, j ){
		A_click = 1;//alert("A, j: "+j +", ss: " + ss);//A, j: 7, ss: |tran_reportdate|tran_reportdate|DATETIME|
	}

	function sendDataToPHP( projectnmS, pnmdataS ) {
		fetch('<?=KAPP_URL_T_?>/kapp_save_session.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ projectnmS: projectnmS, pnmdataS: pnmdataS }),
		})
		.then(response => response.json())
		.then(data => {
			console.log('Success:', data);
		})
		.catch((error) => {
			console.error('Error:', error);
		});
	}
	function change_project_funcX(pnmS){
		var p_selind = document.kapp_makeform.project_nmS.selectedIndex; 
		var p_val    = document.kapp_makeform.project_nmS.options[p_selind].value;
		var p_nm     = document.kapp_makeform.project_nmS.options[p_selind].text;
		sendDataToPHP('project_nmS', pnmS);  //my_func
	}
	function change_project_func(pnmS){
		if( pnmS == '') {
			alert('Select Project!');
			return false;
		}
		sendDataToPHP('project_nmS', pnmS); //my_func
		document.getElementById('mode').value = 'Project_Search';
		document.kapp_makeform.action="kapp_table_index_Create.php";
		document.kapp_makeform.submit();
	}

	function change_table_funcX(tab) {
		tab = document.kapp_makeform.tab_hnmS.value;
		document.kapp_makeform.mode.value='SearchTAB';
		document.kapp_makeform.action="kapp_table_index_Create.php";
		document.kapp_makeform.submit();
	}
	function change_table_func(pnmS){
		sendDataToPHP('tab_hnmS', pnmS);
		document.kapp_makeform.mode.value='SearchTAB';
		document.kapp_makeform.action="kapp_table_index_Create.php";
		document.kapp_makeform.submit();
	}

	function index_Create_button( pg) {
		var idx_name = document.getElementById('idx_name').value;		//alert( "idx_name: " + idx_name);
		if( idx_name == '' ){
			document.kapp_makeform.idx_name.focus();
			alert("enter index name"); return false;
		}
		if( !confirm('Do you want to Create! '+idx_name + ', tab: <?=$tab_hnmS?>' ) ) return;
		var key_array = document.getElementById('key_array').value;
		//key_array: |em_tran_1|tran_date@|em_tran_6|tran_status|tran_rslt@|em_tran_7|tran_net@

		var p_selind = kapp_makeform.project_nmS.selectedIndex; 
		var p_val    = kapp_makeform.project_nmS.options[p_selind].value;
		var p_nm      = kapp_makeform.project_nmS.options[p_selind].text;
		if( p_nm =='1.Select Project' || p_nm =='' ){
			alert( " Please select a project! p_selind: " + p_selind);
			document.kapp_makeform.project_nmS.focus();
			return false;
		}
		var tab_selind = kapp_makeform.tab_hnmS.selectedIndex; 
		var tab_val    = kapp_makeform.tab_hnmS.options[tab_selind].value;
		var tabnm      = kapp_makeform.tab_hnmS.options[tab_selind].text;
		if( !tab_selind || !tabnm) {
			alert( tab_selind+" :  Please select a table! ");
			document.kapp_makeform.tab_hnmS.focus();
			return false;
		}
		const checkbox = document.getElementById('idxdup_confirm');
		if( checkbox.checked === false){
			alert("Please check for duplicate index names.");
			return false;
		} else{
			Index_name_Dup_Check(); // Check if the index name has been changed after checking for duplication. 중복 체크후 인덱스명을 변경한 경우를 확인 한다.
		}
		var colnm = document.getElementsByName('column_list'); // name은 첨자가없다.
		var item_cnt = colnm.length;
		str_array = '';
		icnt= 0;
		var index_data = '|' + idx_name + '|';
		for( i = 0; i < item_cnt; i++) {
			if( document.getElementById('column_list'+i).checked === true ){
				colnm_value = colnm[i].value; //colnm_value: |tran_status|tran_status|CHAR|1
				fldA = colnm_value.split('|');
				icnt++;
				if(icnt == 1) index_data = index_data + fldA[1];
				else if(icnt > 1) index_data = index_data  + '|' + fldA[1];
			}
		} 
		if( icnt == 0){
			alert("Select one or more columns"); return false;
		}
		key_array = key_array + index_data+ '@' ;

		if( pg == "kapp_index_Create") {
jQuery(document).ready(function ($) {
		var tab_enm= $("#tab_enm").val();
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
				data: {
					"mode": 'kapp_table_index_add',
					"tab_enm": JSON.stringify(tab_enm),
					"key_array": JSON.stringify(key_array),
					"index_data": JSON.stringify(index_data),
					"index_name": JSON.stringify(idx_name)
				},
			url: "./kapp_table_index_ajax.php",
			success: function(data) {
				alert(data); //console.log(data);
				location.href='kapp_table_index_Create.php?mode=SearchTAB&tab_hnmS=<?=$tab_hnmS?>';
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("data: ");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});

});
		}
	}
	function Index_name_Dup_Check(){
		const checkbox = document.getElementById('idxdup_confirm');
		var idx_name = document.getElementById('idx_name').value;
		if( idx_name == '' ){
			document.kapp_makeform.idx_name.focus();
			alert("enter index name"); return false;
		}
		var key_array = document.getElementById('key_array').value;
		if( key_array == '') {
			checkbox.checked = true;
			return true;
		} else{
			keyA = key_array.split('@');
			for( i=0; i<keyA.length; i++){
				ikey = keyA[i].split('|');
				if( ikey[1] == idx_name ) {
					alert("Please check for duplicate index names.");
					checkbox.checked = false;
					return false;
				}
			}
		}
		checkbox.checked = true;
		return true;
	}
//-->
</script>

<script>
/*
SQLKapp_em_tran, index_name: em_tran_4, |em_tran_1|tran_date@|em_tran_2|tran_id|tran_rslt@|em_tran_4|tran_refkey@|em_tran_5|tran_status|tran_date@|em_tran_6|tran_status|tran_rslt@|em_tran_7|tran_net@@@
alert( "keyB: " + keyB);//keyB: |em_tran_1|tran_date@|em_tran_2|tran_id|tran_rslt@|em_tran_5|tran_status|tran_date@|em_tran_6|tran_status|tran_rslt@|em_tran_7|tran_net@
*/

jQuery(document).ready(function ($) {

	$('#Delete_idx').on('click', function() {		//alert('버튼 클릭됨');
		var tab_enm= $("#tab_enm").val();
		var index_name= $("#index_name").val();
		var key_array= $("#key_array").val();
		if( !confirm('Do you want to delete! '+index_name ) ) return;
		keyA = key_array.split('@');
		keyB = '';
		for(i=0;i<keyA.length && keyA[i] !==''; i++){
			keyfld = keyA[i].split('|');
			if( keyfld[1] !== index_name) {
				keyB = keyB + keyA[i] + '@';
			}
		}
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
				data: {
					"mode": 'kapp_table_index_delete',
					"tab_enm": JSON.stringify(tab_enm),
					"key_array": JSON.stringify(keyB),
					"index_name": JSON.stringify(index_name)
				},
			url: "./kapp_table_index_ajax.php",
			success: function(data) {
				alert(data); //console.log(data);
				location.href='kapp_table_index_Create.php?mode=SearchTAB&tab_hnmS=<?=$tab_hnmS?>';
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("data: ");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});

	});

});
</script>

<?php
//m_("--- tab_hnmS: $tab_hnmS");
	if( $mode == 'SearchTAB' || isset($_SESSION['tab_nmS']) ){
		$aa				= explode(':', $tab_hnmS);
		$tab_enm		= $aa[0];
		$tab_hnm		= $aa[1];
		$sqlTAB		= "SELECT * from {$tkher['table10_table']} where userid='$H_ID' && tab_enm='$tab_enm' && fld_enm='seqno' ";
		$rsTAB			= sql_fetch($sqlTAB);
		$key_msg		= $rsTAB['key_msg'];
		$item_array		= $rsTAB['memo'];
		$key_array		= $rsTAB['relation_data'];
		//$project_code	    = $rsTAB['group_code'];  
		//$project_name	    = $rsTAB['group_name'];  
		//$project_nmS	= $project_code.":".$project_name;
		$itX = explode("@",$item_array);
		$item_cnt		= count($itX) -1;
		//m_("$item_cnt");
	}
?>
<center>
		<form name="kapp_makeform" method="post" >
			<input type="hidden" name="sellist"	        value="" >
			<input type="hidden" id='mode' name="mode" value="<?=$mode?>" >
			<input type="hidden" id="key_array" name="key_array" value="<?=$key_array?>" > 

<div id='menu_normal'>
   <table height='100%' cellspacing='0' cellpadding='4' border='1' > 




<tr><td colspan='2' align="center" <?php echo" title='Create index of Table \n 1:Select Project and Table \n 2:Enter program name \n 3:Click Create button.'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;">
		Creation Index of Table (<?=$H_ID?>)<br>
			Project:<SELECT id='project_nmS' name='project_nmS' onchange="change_project_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:50%; height:30px;" >

			<option value=''>1.Select Project</option>
<?php 
		if( $mode=='Project_Search' || isset( $_SESSION['project_nmS']) ) echo "<option value='$project_nmS' selected >$project_name</option>";
		$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by upday desc " ); 
		while( $rs = sql_fetch_array($result)) {
			if( $project_code == $rs['group_code']) $chk = " selected ";
			else $chk = "";
?>
			<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' <?php echo $chk; ?> title='Project code: <?php echo $project_code;?>' ><?=$rs['group_name']?></option>
<?php	} ?>
			</SELECT>
</td></tr>

<tr><td colspan='2' <?php echo" title='New Index creation order \n 1:Enter index name \n 2:Select columns \n 3:Click Create button.'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;text-align:center;">
			Table:&nbsp;

			<SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:50%; height:30px;">
					<option value=''>2.Select table</option>
<?php 
				if( $mode=='SearchTAB' || isset($_SESSION['tab_nmS'])) echo "<option value='$tab_hnmS' selected >$tab_hnm</option>";
				$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and group_code='$project_code' and fld_enm='seqno'" );
				while( $rs = sql_fetch_array($result)) {
					if( $tab_enm == $rs['tab_enm'] ) $sel = ' selected ';
					else $sel='';
?>
					<option value='<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>' title='Table code: <?=$rs['tab_enm']?>' <?=$sel?> ><?=$rs['tab_hnm']?></option>
<?php
				}
?>
			</SELECT>
</td></tr>

<tr><td colspan='2' style="text-align:left;background-color:#666666;color:cyan;" >
Index name:<input type='text' id='idx_name' name='idx_name' value='<?=$idx_name?>' style="border-style:;background-color:black;color:yellow;height:25px;width:180;">
&nbsp;<input type='checkbox' id='idxdup_confirm' name='idxdup_confirm' value='Confirm' onClick="return false">&nbsp;
&nbsp;<input type='button' onclick="Index_name_Dup_Check()" value='Duplicate check' >
&nbsp;<input type='button' value='Index Create' onClick="index_Create_button('kapp_index_Create')" style="border-style:;background-color:#666fff;color:yellow; height:30px;">
</td></tr>
<tr>
	<td valign="top" style='text-align:left;width:50%;'>
	<div id="here">
	<table border="1" style='text-align:left;table-layout:fixed;'>
<?php
	$qna = "sequence of the work|Select Project and Table.|Enter index name.|Click Column button.|Click Create button.|"; // 4:item cnt, ^:item add.
	$column_ = "";
	if( $mode == 'SearchTAB' || isset($_SESSION['tab_nmS'])){
		$itX = explode("@",$item_array);
		for( $i=0, $j=0; $i<$item_cnt; $i++, $j++){
			$it = explode("|",$itX[$i]);
			$column_ = $column_ . "<label id='columnRX".$j."' onclick='column_list_onclickAA(" .$j. " )'><input type='checkbox' id='column_list".$j."' name='column_list' onclick='column_list_onclickA(this.value, " .$j. ")' value='".$itX[$i]."'><label id='columnR".$j."'>".$it[2]."</label></label><br>";
		}
		echo "<script> Print_item_func(\"".$column_."\", \"".$qna."\");</script> "; // 
	} else {
		$column_ = "";
	}
?>
	</table>
	</div>
	</td>


	<td valign="top" style='text-align:center;'>
	<div id="here">
	<table border="1">
				<tr>
				  <td style='background-color:#000000;color:yellow;height:30px;text-align:center;'>index list of <?=$tab_hnm?></td>
				</tr>
				<tr>
				  <td valign="top" style='background-color:#f5f5f5;color:black;height:30px;text-align:center;'>
					 <SELECT id="fnclist" style="width:100%" onChange="indexlist_onclick(this.value)" multiple size="8" name="fnclist">
<?php
	if( $mode=='SearchTAB' || isset($_SESSION['tab_nmS'])){
		$keyA = explode("@",$key_array);
		echo "<option value='seqno' title='Cannot be deleted'>PRIMARY KEY (seqno)</option>";
		$key_flds = ''; 
		for( $i=0; $i < count($keyA) && $keyA[$i]!=''; $i++){
				$key_i = explode("|", $keyA[$i]);
				$key_cnt = count($key_i);
				$key_flds = ''; 
				$key_flds = $key_i[2];//|em_tran_1|tran_date@|em_tran_6|tran_status|tran_rslt@|em_tran_7|tran_net@em_tran_2|tran_id|tran_rslt|@
				for( $k=3; $k < $key_cnt; $k++) $key_flds = $key_flds . " + " . $key_i[$k];
				$k_m = $key_i[1] . ":" . $keyA[$i];
				echo "<option value='".$key_i[1]."' title='".$k_m."'>".$key_i[1]." KEY (".$key_flds.") </option>";
		}
	} else {
				echo "<option value='' ></option>";
	}
?>
					  </SELECT>
				   </td>
				 </tr>
				 <tr>
					<td height="24">Selection index:<input id='index_name' name='index_name' readonly title='readonly'>
					<input type='button' id='Delete_idx' value="Delete" style="border:1px solid black;background-color:red;color:white;height:27px;border-radius:20px;" title='Delete index key. caution!'>
					<textarea id='mns' onKeyUp='ption()' name='ents' rows='3' cols='60' onChange='chkDescription()' style="display:none;"></textarea>
					</td>
				 </tr>
	</table>
	</div>
	</td>
</tr>

<tr><td colspan='2' bgcolor="#666666" height="27">
	<?php
	//$key_msg = str_replace('KEY', '<br>KEY', $key_msg);
	//$mkey="PRIMARY KEY (`seqno`), ";
	//echo "index list: ". $mkey . $key_msg; 
	?>
</td></tr>

<tr><td colspan='2' height="24" title='Enter the column name and click the button! ' >
</td></tr>
		<input type='hidden' id='column_index' name='column_index' >
		<input type='hidden' name='multy_menu_sel' >
		<input type='hidden' id='tab_enm' name='tab_enm' value='<?=$tab_enm?>' >
		<input type='hidden' id='tab_hnm' name='tab_hnm' value='<?=$tab_hnm?>' >
		<input type='hidden' id='seqno' name='seqno' value='<?=$seqno?>' >
		<input type='hidden' name='item_cnt' value='<?=$item_cnt?>' >
		<input type='hidden' name='item_array' value='<?=$item_array?>' >
</form>



</table>
</div>
</body>
</html>
