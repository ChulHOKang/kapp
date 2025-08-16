<?php
	include_once('../tkher_start_necessary.php');
	$H_ID				= get_session("ss_mb_id");  
	if ( !$H_ID) {
		m_("Please Login! ");
		$run = KAPP_URL_T_;
		echo "<script>window.open( '$run' , '_top', ''); </script>";
	}
	$H_LEV			= $member['mb_level'];
	
	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else $mode= '';
	if( isset($_POST['bmode']) ) $bmode = $_POST['bmode'];
	else $bmode= '';
	if( isset($_POST['mod_key']) ) $mod_key = $_POST['mod_key'];
	else $mod_key= '';

	$incomeinfo = '';
	$incomemoney =0;

	echo "<title>Cashier-Import statement</title>"; // (금전출납부 : 수입내역서);

	$incomedate = date("Y-m-d");
   	if( !$bmode) {  // 입력폼 모드..
   	    $bmode = "insert";
   	    $submit_value = "Insert";
   	}
	if( $bmode =="modify") { // 수정폼 모드..
   	    $sql = "select * from kapp_income where userid='$H_ID' and num = '$mod_key' ";
   	    $result = sql_query($sql);
   	    $row = sql_fetch_array($result);
   	    $incomeinfo  = $row['incomeinfo'];
   	    $incomemoney = $row['money'];
   	    $incomedate  = $row['incomedate'];
   	    $memo  = $row['memo'];
   	    $submit_value = "Change";
   	}
	if( $mode=='change') {
		 $incomedate = $_POST['incomedate'];
	}
	if( $mode =="Insert_func"){
		$income_code		= $H_ID . time();
		//$incomeinfo = htmlspecialchars($incomeinfo);
		$incomeinfo = htmlspecialchars($_POST['incomeinfo']);
		$incomemoney = $_POST['incomemoney'];
		$incomedate = $_POST['incomedate'];
		$memo = $_POST['memo'];
		$cd_		= $_POST['pay_cd'];
		if( !$cd_ ) {
			$income_code		= $H_ID . time();
			$cd_ =	 $income_code;	 //'etc';
			$ret = sql_query("select * from kapp_income_code where userid='$H_ID' and incomeinfo='$incomeinfo' ");
			$tot = sql_num_rows($ret);
			if( !$tot ) sql_query("insert into kapp_income_code set userid='$H_ID', incomeinfo='$incomeinfo', income_code='$cd_' ");
			else {
				$rs = sql_fetch_array($ret);
				$cd_ = $rs['income_code'];
			}
			//sql_query("insert into kapp_income_code set userid='$H_ID', incomeinfo='$incomeinfo', income_code='$cd_' ");
		}
        sql_query("insert into kapp_income set userid='$H_ID', memo='$memo', income_code='$cd_', incomeinfo='$incomeinfo', money='$incomemoney', incomedate='$incomedate' ");
        //$cmode = "close"; 
        $incomeinfo = "";
        $incomemoney = "";
        $memo = "";           
        $submit_value = "Insert";
     }
	else if($mode =="income_code_insert") {
		$income_code		= $H_ID . time();
		$incomeinfo		= $_POST['incomeinfo'];
   		$sql = "insert into kapp_income_code set income_code='$income_code', incomeinfo='$incomeinfo', userid='$H_ID'  ";
   	    $result = sql_query($sql);
		m_("Account name added.");// \\n 계정명을 추가 하였습니다.

	} else if($mode =="income_code_change") {
		$incomeinfo		= $_POST['incomeinfo'];
		$payclass		= $_POST['pay_nm'];
		m_("payclass:$payclass , incomeinfo:$incomeinfo");//payclass:수당 , incomeinfo:수당SK
		$ret = sql_query("select * from kapp_income_code where userid='$H_ID' and incomeinfo='$incomeinfo' ");
		$tot = sql_num_rows($ret);
		if( $tot>0 ) {
			m_("The same account name exists. \\n Please use a different name!");// \\n 같은명의 계정명이 존재합니다. \\n 다른명칭을 사용해주세요!
			echo "<script>exit();</script>";
		} else {

			$sql = "update  kapp_income_code set incomeinfo='$incomeinfo' where incomeinfo='$payclass' and  userid='$H_ID' ";
			$result = sql_query($sql);
			$sql = "update  kapp_income set incomeinfo='$incomeinfo' where incomeinfo='$payclass' and  userid='$H_ID' ";
			$result = sql_query($sql);
			echo "<script>opener.location.reload();</script>";
			m_("Account name changed.");// \\n 계정명을 변경 하였습니다.
		}
	} else if($mode =="Delete_func") {
		sql_query("delete from kapp_income where num = '$mod_key' ");
        $submit_value = "Insert";
	}
	else if( $mode =="Update_func"){
		$incomeinfo = htmlspecialchars($incomeinfo);
		$incomemoney = $_POST['incomemoney'];
		$incomedate = $_POST['incomedate'];
		$memo = $_POST['memo'];
        $sql ="update kapp_income set money= $incomemoney, incomeinfo='$incomeinfo', memo='$memo', incomedate='$incomedate' where userid='$H_ID' and num='$mod_key'"; 
		$result = sql_query($sql);
        $incomeinfo = "";
        $incomemoney = "";           
        $memo = "";           
        $submit_value = "Insert";
		m_("Update OK! ");
	}
       
?>

	  <head>
<!-- 	  <style> 
	table {FONT-SIZE: 9pt; FONT-FAMILY: 굴림,Tahoma,Verdana; } 
    .hand {cursor:hand;}
    input, textarea {cursor:hand;border:1px solid black} 
    .submit {border:solid 1 #000000;font-family:Tahoma,Verdana;font-size:9pt;color:#000000;background-color:#CCCCCC; height=18px}
    .bwhite {border:solid 1 #000000;font-family:Tahoma,Verdana;font-size:9pt;color:#000000;background-color:#ffffff; height=18px; width=105px}
    .radio {color:black;border:1px solid #717171;font-size:9pt;background-color:white;cursor:hand;} 
    .radio2 {color:black;border:0px solid #717171;font-size:9pt;background-color:white;cursor:hand;} 
    .editbox  { border:1 solid black; background-color:white; }
                       
    a:hover {text-decoration: underline;color:#9999ff} 
	a:link { text-decoration: none;} 
    a:visited { text-decoration: none;} 
    a:active { text-decoration: none;} 
    BODY {
		SCROLLBAR-FACE-COLOR: #ffffff; 
	    SCROLLBAR-HIGHLIGHT-COLOR: #aaaaaa; 
	    SCROLLBAR-SHADOW-COLOR: #aaaaaa; 
	    SCROLLBAR-3DLIGHT-COLOR: #ffffff; 
	    SCROLLBAR-ARROW-COLOR: #aaaaaa; 
	    SCROLLBAR-TRACK-COLOR: #ffffff; 
	    SCROLLBAR-DARKSHADOW-COLOR: #ffffff;
	    background-color:transparent;
	}
</style>  -->
<link rel="stylesheet" href="../include/css/style.css" type="text/css">
	</head>
         <body bgcolor='white' topmargin=0 leftmargin=0>
         <center>
         <!-- <script src='inc/pop_util.js'></script> -->

	<script language='javascript'>
	<!--
		function cancel_func(d){
			//alert('-----------------');
            self.close();
            opener.location.reload();
			//	window.close();
			//	document.pay.target = '_self';
			//	document.pay.action = 'index.php';
			//	document.pay.submit();
		}

		function income_code_change(){
				payclass=document.pay.payclass.value;
				paynm = payclass.split(":");
				document.pay.pay_cd.value=paynm[0];
				document.pay.pay_nm.value=paynm[1];
				//alert('in nm: '+paynm);
				document.pay.mode.value='income_code_change';
				document.pay.action = 'pop_income.php';
				document.pay.submit();
		}
		function income_code_insert(){
				document.pay.mode.value='income_code_insert';
				document.pay.action = 'pop_income.php';
				document.pay.submit();
		}
		function pay_insert(d){
			//	document.pay.target = '_self';
				document.pay.action = 'pop_pay.php';
				document.pay.paydate.value=d;
				document.pay.mode.value='change';
				//alert('income d:'+d);
				document.pay.submit();
		}
         function setPayinfo(payinfo, pay_nm){
			 //alert(''+pay_nm);
			 cdnm = pay_nm.split(":");
			 cd = cdnm[0];
             document.pay.incomeinfo.value = payinfo;
             document.pay.pay_cd.value = cd;
			 //alert(''+cd );
         }
            
	function Insert_func(d, bmode){
		  if(document.pay.incomeinfo.value ==''){
			alert('Please enter your earnings. ');//\n 수입내용을 입력하세요.
			document.pay.incomeinfo.focus();
			return false;
		  }
		 if(document.pay.incomemoney.value ==''){
			alert('Please enter an amount. ');//\n 금액을 입력하세요.
			document.pay.incomemoney.focus();
			return false;
		  }
		 if(document.pay.incomedate.value ==''){
			alert('Please enter a date. '); //\n 날짜를 입력하세요.
			document.pay.incomedate.focus();
			return false;
		  }
		  document.pay.incomemoney.value = ClearComma(document.pay.incomemoney.value);
		 for (i = 0; i < document.pay.incomemoney.value.length; i++)
			if ((document.pay.incomemoney.value.charAt(i) < '0') || (document.pay.incomemoney.value.charAt(i) > '9')) {
				alert('Only numbers can be entered.');// \n 숫자만 입력하실 수 있습니다.
				document.pay.incomemoney.focus();
				return false;
			} 
		if(bmode=='insert') document.pay.mode.value = 'Insert_func';
		else if(bmode=='modify') {
			document.pay.bmode.value = 'modify';
			document.pay.mode.value = 'Update_func';
		}

			document.pay.action = 'pop_income.php';
			document.pay.submit();
	}

	function paycheck(){
		if(document.pay.incomeinfo.value ==''){
			alert('Please enter your earnings.');// \n 수입내용을 입력하세요.
			document.pay.incomeinfo.focus();
			return false;
		}
		if(document.pay.incomemoney.value ==''){
			alert('Please enter an amount.');// \n 금액을 입력하세요.
			document.pay.incomemoney.focus();
			return false;
		}
		if(document.pay.incomedate.value ==''){
			alert('Please enter a date.');// \n 날짜를 입력하세요.
			document.pay.incomedate.focus();
			return false;
		}
		document.pay.incomemoney.value = ClearComma(document.pay.incomemoney.value);
		for (i = 0; i < document.pay.incomemoney.value.length; i++)
		if ((document.pay.incomemoney.value.charAt(i) < '0') || (document.pay.incomemoney.value.charAt(i) > '9')) {
			alert('Only numbers can be entered.');// \n 숫자만 입력하실 수 있습니다.
			document.pay.incomemoney.focus();
			return false;
		} 
	}
         /*function paydelete(paykey, incomedate){
            resp = confirm(' Are you sure you want to delete? (삭제하시겠습니까?)');          
           if(resp){
                     location.href='$PHP_SELF?mode=delete&paykey='+paykey+'&incomedate='+incomedate;
                }
            else{
                   return false;         
               }
         }*/
	function paydelete(paykey, paydate){
		resp = confirm('Are you sure you want to delete?'); // \n pay 삭제하시겠습니까?
		if(resp) {
			//location.href='$PHP_SELF?mode=delete&paykey='+paykey+'&paydate='+paydate;
			document.pay.mod_key.value = paykey;
			document.pay.mode.value = 'Delete_func';
			document.pay.action = 'pop_pay.php';
			document.pay.submit();
		} else {
			return false;         
		}
	}
	function incomedelete(paykey, incomeinfo){
		resp = confirm('Do you want to delete ' + incomeinfo + ' ?' );          // \n  income 삭제하시겠습니까?
		if(resp) {
			//location.href='$PHP_SELF?mode=delete&paykey='+paykey+'&paydate='+paydate;
			document.pay.mod_key.value = paykey;
			document.pay.mode.value = 'Delete_func';
			document.pay.action = 'pop_income.php';
			document.pay.submit();
		} else {
			return false;         
		}
	}
	function paymodify(mod_key){
	 //alert('key:'+mod_key);
		document.pay.mod_key.value=mod_key;
		document.pay.bmode.value='modify';
		document.pay.action = 'pop_income.php';
		document.pay.submit();
	}

	function paymodify_func(mod_key){
		document.pay.bmode.value = 'modify';
		document.pay.mod_key.value = mod_key;
		document.pay.action = 'pop_pay.php';
		document.pay.submit();

	}
	function paymodify2(mod_key){
		document.pay.bmode.value = 'modify';
		document.pay.mod_key.value = mod_key;
		document.pay.target= '_self';
		document.pay.action = 'pop_income.php';
		document.pay.submit();
	}
         
	function formclose(){
		self.close();
		opener.location.reload();
	}
	function ClearComma(value1){
		   newValue='';
		   for(i=0;i<value1.length;i++){
			  if(value1.charAt(i)!=',')
				 newValue = newValue + value1.charAt(i);
		   }
		   return newValue;
	}
	function moneyShape(Moneytxt){  
		money = ClearComma(Moneytxt.value);
		Moneytxt.value = money;
		if( chkInteger(Moneytxt)){
		   tmpValue = '';
		   header = '';
		   if( money.charAt(0)=='-' || money.charAt(0)=='+'){
			  header = money.charAt(0);
			  money = money.substring(1,money.length);
		   }
		   if( money.length>3){
			  while( money.length>3){             
				 if( tmpValue!='') tmpValue = money.substring(money.length-3,money.length) + ',' + tmpValue;
				 else 	tmpValue = money.substring(money.length-3,money.length);              
	 			 money = money.substring(0,money.length-3);
			  }
			  if(money.length>0) tmpValue = header + money +','+tmpValue;
			  Moneytxt.value = tmpValue;
		   }   
		}
	 }

	function chkInteger(Form1) {
		for( i=0 ; i < Form1.value.length ; i++ ) {
			if((Form1.value.charAt(i)<'0') || (Form1.value.charAt(i)>'9')) {
				alert('Only numbers can be entered.');  // 숫자만 입력가능합니다.
				Form1.value=''
				Form1.focus();
				return false; 
			} 
		 } // end for 
		return true;
	}
-->
</script>
<?php
		echo "
		 <table border=0 cellspacing=0 cellpadding=0 width=600 height=400>
			<tr>
			<!-- <td width=120><img src=ssamzie_01.gif></td> -->
			<td width=450 background=ssamzie_02.gif align=center valign=top><br>
         <table cellspacing=0 cellpadding=1 bordercolorlight='#cccccc' bordercolordark='#ffffff' border=1 width=590>
         <tr>
		 <form name='pay' method='post' > 
          <input type='hidden' name='mode' value=''>
          <input type='hidden' name='bmode' value='' >
          <input type='hidden' name='paydate' value=''>
          <input type='hidden' name='mod_key' value='$mod_key'>
          <input type='hidden' name='pay_cd' value=''>
          <input type='hidden' name='pay_nm' value=''>
          <td bgcolor='#666fff' colspan=3 align=center  height='20'><font color=yellow>:+: Income Input :+: &nbsp;&nbsp;&nbsp;
		  Date:<input type='text' name='incomedate' size='9' value='$incomedate' readonly></td>
         </tr>
         <tr>
            <td bgcolor='#f0f0f0' align=center title=income content> <font color='#908c90'>Income Title</font>  </td>
            <td bgcolor='#ffffff'>
			<input type='text' size='12' name='incomeinfo' value='$incomeinfo' maxlength='100'> 
			<input type='button' value='Title Add' onclick='income_code_insert()'  title='Register your earnings account.'  >
			<input type='button' value='change' onclick=\"income_code_change()\" title='Change the import account name' >
			</td>
           <td align=center bgcolor='#f0f0f0' align=center> <font color='#908c90'>Select title</font></td>
          </tr>
          <tr>
            <td bgcolor='#f0f0f0' align=center> <font color='#908c90'>Price</font>  </td>
            <td bgcolor='#ffffff'><input type='text' size=12' style='TEXT-ALIGN: right' name='incomemoney' value='$incomemoney' maxlength='11' onkeyUp='moneyShape(this);'></td>
          <td rowspan=3 valign=top>
            <select name='payclass' size='5' onclick='setPayinfo(this.options[this.selectedIndex].text,this.value)' style=\"FONT-SIZE: 9pt; FONT-FAMILY: 굴림,Tahoma,Verdana;\" >
			  <option value='' selected>Select Title</option>
		";
		$sql="select * from kapp_income_code where userid='$H_ID' order by incomeinfo";
		$result = sql_query($sql);
		while( $row = sql_fetch_array($result) ){
?>
				<option value='<?=$row['income_code']?>:<?=$row['incomeinfo']?>'  ><?=$row['incomeinfo']?></option>
<?php       
		} 
		echo "
              </select>
              </td>
			</tr>
          <tr>
            <td bgcolor='#f0f0f0' align=center > <font color='#908c90'>Memo</font>  </td>
            <td bgcolor='#ffffff'><input type='text' size='30' maxlength=250 name='memo' value='$memo' ></td>
          </tr>
          <tr><td colspan=2 bgcolor='#ffffff' align=center>
			  <input type='button' value='$submit_value' onclick=\"Insert_func('$incomedate', '$bmode')\"  class='submit'>
			  <input type='button' value='Close' onclick=\"cancel_func('$paydate')\"  class='submit'>
           </td>
          </tr></form>
          </table>
          <p>
          <table cellspacing=0 cellpadding=1 bordercolorlight='#cccccc' bordercolordark='#ffffff' border=1 width=590>
           <tr>
              <td colspan=6 align=center bgcolor='#cccccc' height='20'>:+: Import history [$incomedate] :+:</td>
           </tr>
           <tr bgcolor='#f0f0f0' >
            <td align=center WIDTH='130' height=20><font color='#908c90'>Income/Expenditure<br> content</font> </td>
            <td align=center WIDTH='130' height=20><font color='#908c90'>memo</font> </td>
            <td align=center width='100'><font color='#908c90'>income<br></font> </td>
            <td align=center width='100'><font color='#908c90'>expenditure</font> </td>
            <td align=center width='50'> <font color='#908c90'>Change</font> </td>
            <td align=center width='50'> <font color='#908c90'>Delete</font> </td>
            </tr>
		";
     // 수입 내역.. 불러오기..
	$sql = "select * from kapp_pay where userid='$H_ID' and paydate ='$incomedate' ";
	$result = sql_query($sql);
	$total = sql_num_rows( $result );
	$sql2 = "select * from kapp_income where userid='$H_ID' and incomedate ='$incomedate'";
	$result2 = sql_query($sql2);
	$total2 = sql_num_rows($result2);
   	 if ( $total > 0 ) {
   	      for( $i=0; $i < $total; $i++){
			   $row = sql_fetch_array($result);
			   $view_money2 = "";
			   $view_money = number_format($row['money'],0);
			   $num = $row['num'];
			   $paydate = $row['paydate'];
			   $payinfo = $row['payinfo'];
			   $memo = $row['memo'];
				echo "
                    <tr  bgcolor='#ffffff'>
                      <td align=center height=21 >$payinfo</td>
                      <td align=center height=21 >$memo</td>
                      <td align=right  height=21 > $view_money2</td>
                      <td align=right  height=21 > $view_money</td>
                      <td align=center height=21 width='50'>
						<input type='button' value='Change' onclick=\"return paymodify_func('$num')\"  class='submit' title='paymodify'>
					</td>
                      <td align=center height=21 width='50'>
						  <input type='button' value='Delete' onclick=\"return paydelete('$num', '$paydate')\"  class='submit'>
					</td>
                    </tr>
				";
          }
   	 }
   	 if ( $total2 > 0 ) {
   	      for( $i=0; $i < $total2; $i++){
                   $row2 = sql_fetch_array($result2);
                   $view_money2 = number_format($row2['money'],0);
                   $view_money = "";
				   $num = $row2['num'];
				   $incomeinfo = $row2['incomeinfo'];
				   $memo=$row2['memo'];
				echo "
                    <tr  bgcolor='#ffffff'>
                      <td align=center height=21 >$incomeinfo</td>
                      <td align=center height=21 >$memo</td>
                      <td align=right  height=21 >$view_money2</td>
                      <td align=right  height=21 >$view_money</td>
                      <td align=center height=21 width='50'>
						<input type='button' value='Change' onclick=\"return paymodify2('$num')\"  class='submit' title='paymodify2'>
					</td>
                      <td align=center height=21 width='50'>
						  <input type='button' value='Delete' onclick=\"return incomedelete('$num', '$incomeinfo')\"  class='submit'>
					</td>
                    </tr>
				";
          }
   	 }
	echo " 
          </table>
          <center><br> <input type='button' value='Close' onclick='formclose()' class='submit'>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type='button' value='Payment Status' onclick=\"pay_insert('$incomedate')\" class='submit' style=\"border-style:;background-color:#666666;color:yellow;width:100px; height:20px;FONT-SIZE: 9pt; FONT-FAMILY: 굴림,Tahoma,Verdana;\" title='Change to the payment registration screen.' >
		  </center>
		</td>
		</tr>
		</table>
         </body>
         </html>
	";
 ?>
