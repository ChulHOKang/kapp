<script>
function check(x){

	if(x.name.value==''){
		alert('Please enter your name.');
		x.name.focus();
		return false;
	}
	if(x.password.value==''){
		alert('Please enter a password');
		x.password.focus();
		return false;
	}
	else{return true;}
	

}
function memo_insert(id){
	if( !id ) {
		alert("Login please"); return false;
	}
	x = document.memo_form;
	if(x.name.value==''){
		alert('Please enter your name!');
		x.name.focus();
		return false;
	}
	if(x.context.value==''){
		alert('Please enter your comment!');
		x.context.focus();
		return false;
	}
	if(x.password.value==''){
		alert('Please enter a password!');
		x.password.focus();
		return false;
	}
	document.memo_form.mode.value='memo_insertTT';
	document.memo_form.action='detailD_memoD_write.php'; // query_ok_new.php
	document.memo_form.submit();
}
function memo_delete(memo_no){
		document.memo_form.memo_no.value=memo_no;
		document.memo_form.mode.value='memo_deleteTT';
		board_name 	= document.memo_form.board_name.value;
		infor 		= document.memo_form.infor.value;
		list_no		= document.memo_form.list_no.value;
		page		= document.memo_form.page.value;
		search_choice= document.memo_form.search_choice.value;
		search_text	= document.memo_form.search_text.value;
		url = "memo_password.php?infor=" + infor + "&mode=memo_deleteTT" + "&board_name=" +board_name+ "&memo_no=" +memo_no + "&list_no=" + list_no + "&page=" +page+ "&call_pg=detailD.php";
		window.open(url,"newB","width=600,height=300,scrollbars=no");
		return true;
}
</script>
<?php
	$query_memo="select no,name,memo,in_date from {$tkher['aboard_memo_table']} where board_name='aboard_".$mf_infor[2]."' and list_no=" .$list_no. " order by in_date desc ";
	$mq_memo=sql_query($query_memo);
?>
<!-- <form name='memo_form' action='query_ok_new.php' method='post'> -->
<form name='memo_form' action='detailD_memoD_write.php' method='post'>
		<input type='hidden' name='list_no'		value='<?=$list_no?>' >
		<input type='hidden' name='board_name'	value='aboard_<?=$mf_infor[2]?>' >
		<input type='hidden' name='infor'			value='<?=$infor?>' >
		<input type='hidden' name='page'			value='<?=$page?>' >
		<input type='hidden' name='search_choice'	value='<?=$search_choice?>' >
		<input type='hidden' name='search_text'	value='<?=$search_text?>' >
		<input type='hidden' name='memo'			value=''>
		<input type='hidden' name='mode'			value=''>
		<input type='hidden' name='xname'			value=<?=$name?>>
		<input type='hidden' name='memo_no'		value=''>
		<input type='hidden' name='memo_delTT'	value=''>

	<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0'>
<?php
		while($memo=sql_fetch_row($mq_memo)) {
			$dateT = intval($memo[3]);
			$tit_memo=date("Y-m-d H:i",$dateT); 
			$memoD=date("m-d H:i",$dateT); 
			//$memoD=date("Y-m-d H:i",$dateT); 
			//$memoD= $dateT; 
?>
		<tr>
			<td valign='top' style="width:20px; background-color:<?=$mf_infor[22]?>; color:<?=$mf_infor[23]?>">&#9786;</td>
			<td style="text-align:left;width:80%; background-color:<?=$mf_infor[22]?>; color:<?=$mf_infor[23]?>" ><?=$memo[2]?></td>
			<td style="text-align:right;width:170px; background-color:<?=$mf_infor[22]?>; color:<?=$mf_infor[23]?>">
				<a href="javascript:memo_delete('<?=$memo[0]?>')" title='<?=$tit_memo?> - Delete memo'><font color='red'><?=$memo[1]?>:<?=$memoD?> &nbsp;√Del</a>
				</td>
		</tr>
<?php } ?>
	    <tr><td height="1" colspan='3' bgcolor="#ffffff" background="../include/img/dot.gif"></td></tr><!-- 점선...... -->
		<tr><td colspan='3' align='center'><font size='1' color=<?=$mf_infor[23]?>>
			name&nbsp;<input type=text name='name' value='<?=$H_NAME?>' size='15' style='border:1 black solid;'>
			password <input type='password' name='password' size='10' style='border:1 black solid;'>
					<input type='button' value='Reply' onclick="memo_insert('<?=$H_ID?>')" title='Register your comment.'>
		</td></tr>
		<tr><td colspan='3' align='center'>
			<textarea wrap="hard" name="context" rows="3" cols="65" ></textarea>
		</td></tr>
	</table>
</form>
