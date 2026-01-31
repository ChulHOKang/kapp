<?php
	include_once('../tkher_start_necessary.php');
	$H_ID				= get_session("ss_mb_id");  
	if( !$H_ID) {
		m_("Please Login!");
		$run = KAPP_URL_T_;
		echo "<script>window.open( '$run' , '_top', ''); </script>";
	}
	$H_LEV			= $member['mb_level'];
	//	include "./inc/header.html";
	echo "<title>Cashier-Expense statement</title>";// (금전출납부-지출내역서)&nbsp;

	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode'];
	else $mode= '';
	if( isset($_POST['bmode']) ) $bmode = $_POST['bmode'];
	else if( isset($_REQUEST['bmode']) ) $bmode = $_REQUEST['bmode'];
	else $bmode= '';
	if( isset($_POST['mod_key']) ) $mod_key = $_POST['mod_key'];
	else if( isset($_REQUEST['mod_key']) ) $mod_key = $_REQUEST['mod_key'];
	else $mod_key= '';

	$payinfo  = '';
	$paymoney = 0;
	$memo = '';
	//$paydate = date("Y-m-d");
	if( isset($_REQUEST['paydate']) ) $paydate = $_REQUEST['paydate'];
	else if( isset($_POST['paydate']) ) $paydate = $_POST['paydate'];
	else $paydate = date("Y-m-d");
	if( !$bmode){  // 입력폼 모드..
   		$bmode = "insert";
   	    $submit_value = "Insert";
   	 }
	if( $bmode =="modify"){
   		$sql = "select * from kapp_pay where userid='$H_ID' and num = '$mod_key' ";
   	    $result = sql_query($sql);
   	    $row = sql_fetch_array($result);
   	    $payinfo  = $row['payinfo'];
   	    $paymoney = $row['money'];
   	    $memo = $row['memo'];
   	    $paydate = $row['paydate'];
   	    $submit_value = "Change";
   	 }
	if( $bmode =="modify2"){
   	    $sql = "select * from kapp_income where userid='$H_ID' and num = '$mod_key' ";
   	    $result = sql_query($sql);
   	    $row = sql_fetch_array($result);
   	    //$incomeinfo  = $row['incomeinfo'];
   	    $payinfo  = $row['incomeinfo'];
   	    $paymoney = $row['money'];
   	    //$incomemoney = $row['money'];
   	    //$incomedate  = $row[incomedate'];
   	    $paydate  = $row['incomedate'];
   	    $memo  = $row['memo'];
   	    $submit_value = " Change ";
   	 }
   	if( $mode=='change') {
		 $paydate = $_POST['paydate'];		 //m_("------------------------ incomedate:$incomedate:$mode");
	}
	if( $mode =="pay_code_insert"){
		$pay_code = $H_ID . time();
		$payinfo = $_POST['payinfo'];
   		$sql = "insert into kapp_pay_code set pay_code='$pay_code', payinfo='$payinfo' , userid='$H_ID' ";
   	    $result = sql_query($sql);
        //$payinfo = "";
        //$paymoney ="";
		m_("Account name added.");// \\n 계정명을 추가 하였습니다.
	} else if( $mode =="pay_code_change") {
		$payinfo		= $_POST['payinfo'];
		$payclass		= $_POST['pay_nm'];
		m_("payclass:$payclass , payinfo:$payinfo");//payclass:수당 , incomeinfo:수당SK
		$ret = sql_query("select * from kapp_pay_code where userid='$H_ID' and payinfo='$payinfo' ");
		$tot = sql_num_rows($ret);
		if( $tot>0 ) {
			m_("The same account name exists. \\n Please use a different name! ");//\\n 같은명의 계정명이 존재합니다. \\n 다른명칭을 사용해주세요!
			//echo "<script>exit();</script>";
			exit;
		} else {
			$sql = "update  kapp_pay_code set payinfo='$payinfo' where payinfo='$payclass' and  userid='$H_ID' ";
			$result = sql_query($sql);
			$sql = "update  kapp_pay set payinfo='$payinfo' where payinfo='$payclass' and  userid='$H_ID' ";
			$result = sql_query($sql);
			m_("Account name changed.");// \\n 계정명을 변경 하였습니다.
		}
	} else if( $mode =="Insert_func") {
		$pay_code		= $H_ID . time();
		$payinfo = htmlspecialchars($_POST['payinfo']);
		$paymoney = $_POST['paymoney'];
		$paydate = $_POST['paydate'];
		$cd_		= $_POST['pay_cd'];
		$memo = $_POST['memo'];
		if( !$cd_ ) {
			$pay_code		= $H_ID . time();
			$cd_ = $pay_code;	//'etc';
			$ret = sql_query("select * from kapp_pay_code where userid='$H_ID' and payinfo='$payinfo' ");
			$tot = sql_num_rows($ret);
			if( !$tot ) sql_query("insert into kapp_pay_code set userid='$H_ID', payinfo='$payinfo', pay_code='$cd_' ");
			else {
				$rs = sql_fetch_array($ret);
				$cd_ = $rs['pay_code'];
			}
		}
        sql_query("insert into kapp_pay set userid='$H_ID', payinfo='$payinfo', memo='$memo', pay_code='$cd_', money='$paymoney', paydate='$paydate' ");
        $payinfo = "";
        $paymoney ="";
        $memo = "";           
        $submit_value = "Insert";
	}

/*------ 삭제 모드 ---------------------*/        
	else if($mode =="Delete_func") {
		sql_query("delete from kapp_pay where userid ='$H_ID' and num ='$mod_key'");   
        //$cmode = "close"; 
        $submit_value = "Insert";
	}
	else if($mode =="delete2") {
		sql_query("delete from kapp_income where num = '$paykey' ");
        //$cmode = "close";
        $submit_value = "Insert";
	}
    else if( $mode =="Update_func") {
		$payinfo = htmlspecialchars($payinfo);
		$paymoney = $_POST['paymoney'];
		$paydate = $_POST['paydate'];
		$memo = $_POST['memo'];
        $sql ="update kapp_pay set money = $paymoney, payinfo = '$payinfo', memo = '$memo', paydate = '$paydate' where num = '$mod_key'"; 
        $result = sql_query($sql);
        //$cmode = "close"; 
        $payinfo = "";
        $paymoney ="";
        $memo = "";           
        $submit_value = "Insert";
	}
    else if( $mode =="modify2") {
		$incomeinfo = htmlspecialchars($incomeinfo);
        $sql ="update kapp_income set money= $paymoney, incomeinfo='$payinfo', incomedate='$paydate' where num='$mod_key'"; 
        //$sql ="update kapp_income set money= $incomemoney, incomeinfo='$incomeinfo', incomedate='$incomedate' where num='$mod_key'"; 
		$result = sql_query($sql);
		//$cmode = "close";
        $incomeinfo = "";
        $incomemoney = "";           
        $submit_value = "Insert";
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
	<script language='javascript'>
	<!--
		function cancel_func(d){
            self.close();
            opener.location.reload();
		}
		function income_insert(d){
			//	document.pay.target = '_self';
				document.pay.incomedate.value=d;
				document.pay.mode.value='change';
				//alert('pay:d:'+d);
				document.pay.action = 'pop_income.php';
				document.pay.submit();
		}
		function pay_code_insert(){
				document.pay.mode.value='pay_code_insert';
				document.pay.action = 'pop_pay.php';
				document.pay.submit();
		}
		function pay_code_change(){
			
				payclass=document.pay.payclass.value;
				paynm = payclass.split(":");
				document.pay.pay_cd.value=paynm[0];
				document.pay.pay_nm.value=paynm[1];
				//alert(' pnm: '+paynm);
				document.pay.mode.value='pay_code_change';
				document.pay.action = 'pop_pay.php';
				document.pay.submit();
		}
		//-------------------------------------------------------
		function Insert_func(d, bmode){
              if(document.pay.payinfo.value ==''){
                alert('Please enter your spend.');// \n 지출내용을 입력하세요.
                document.pay.payinfo.focus();
                return false;
              }
             if(document.pay.paymoney.value ==''){
                alert('Please enter an amount.');// \n 금액을 입력하세요.
                document.pay.paymoney.focus();
                return false;
              }
             if(document.pay.paydate.value ==''){
                alert('Please enter a date.');// \n 날짜를 입력하세요.
                document.pay.paydate.focus();
                return false;
              }
             document.pay.paymoney.value = ClearComma(document.pay.paymoney.value);
             for (i = 0; i < document.pay.paymoney.value.length; i++) {
				if ((document.pay.paymoney.value.charAt(i) < '0') || (document.pay.paymoney.value.charAt(i) > '9')) {
					alert('Only numbers can be entered.');// \n 숫자만 입력하실 수 있습니다.
					document.pay.paymoney.focus();
					return false;
				} 
			 }
			
			if(bmode=='insert') document.pay.mode.value = 'Insert_func';
			else if(bmode=='modify') {
				//mod_key = document.pay.mod_key.value;
				//alert('key num:'+mod_key);
				document.pay.mode.value = 'Update_func';
			}
			//else if(bmode=='delete') document.pay.mode.value = 'Delete_func';
			//document.pay.paydate.value = d;
			document.pay.action = 'pop_pay.php';
			document.pay.submit();
		}
	function paychecks(){
              if(document.pay.payinfo.value ==''){
                alert('Please enter your spend.');// \n 지출내용을 입력하세요.
                document.pay.payinfo.focus();
                return false;
              }
             if(document.pay.paymoney.value ==''){
                alert('Please enter an amount.');// \n 금액을 입력하세요.
                document.pay.paymoney.focus();
                return false;
              }
             if(document.pay.paydate.value ==''){
                alert('Please enter a date.');// \n 날짜를 입력하세요.
                document.pay.paydate.focus();
                return false;
              }
             document.pay.paymoney.value = ClearComma(document.pay.paymoney.value);
			 for (i = 0; i < document.pay.paymoney.value.length; i++) {
				if ((document.pay.paymoney.value.charAt(i) < '0') || (document.pay.paymoney.value.charAt(i) > '9')) {
					alert('Only numbers can be entered.');// \n 숫자만 입력하실 수 있습니다.
					document.pay.paymoney.focus();
					return false;
				} 
			 }
	}
    function paydelete(paykey, paydate){
            resp = confirm('Are you sure you want to delete? \n 삭제하시겠습니까?');          
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
	function paymodify_func(mod_key){
				//location.href ='$PHP_SELF?bmode=modify&mod_key='+mod_key ;
				document.pay.bmode.value = 'modify';
			 //alert('paymodify_func');
				//document.pay.paydate.value = d;
				document.pay.mod_key.value = mod_key;
			 //alert('paymodify_func');
				document.pay.action = 'pop_pay.php';
				document.pay.submit();

    }
 function paymodify2(mod_key){
		//location.href ='$PHP_SELF?bmode=modify2&mod_key='+mod_key ;
		document.pay.bmode.value = 'modify';
		document.pay.mod_key.value = mod_key;
		document.pay.target= '_self';
		document.pay.action = 'pop_income.php';
		document.pay.submit();
 }

 function formclose(){
	//if(document.pay.cmode.value!=''){
	//   opener.location.reload();
	//}
	window.close();
	opener.location.reload();
 }
 
 function accept_number(){
	   if (event.keyCode < 45 || event.keyCode > 57 || ((event.keyCode > 32 && event.keyCode < 48) || (event.keyCode > 57 && event.keyCode < 65) || (event.keyCode > 90 && event.keyCode < 97))) {
		   event.returnValue = false;
	   }
 }
 
 function setPayinfo(payinfo, pay_cd){
	 //alert(''+cd_nm);
	 cdnm = pay_cd.split(":");
	 cd = cdnm[0];
	 document.pay.payinfo.value = payinfo;
	 document.pay.pay_cd.value = cd;
	 //alert(''+cd );
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
		if (chkInteger(Moneytxt)){
		   tmpValue = '';
		   header = '';
		   if (money.charAt(0)=='-' || money.charAt(0)=='+'){
			  header = money.charAt(0);
			  money = money.substring(1,money.length);
		   }
		   if(money.length>3){
			  while(money.length>3){             
				 if (tmpValue!='')
					tmpValue = money.substring(money.length-3,money.length) + ',' + tmpValue;
				 else
					tmpValue = money.substring(money.length-3,money.length);              
	 
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
					alert('Only numbers can be entered. '); //\n 숫자만 입력가능합니다.
					Form1.value=''
					Form1.focus();
					return false; 
				} 
			 } 
			return true;
    }
-->
</script>

		 <table border=0 cellspacing=0 cellpadding=0 width=600 height=400>
			<tr>
			<!-- <td width=173><img src=ssamzie_01.gif></td> -->
			<td width='351' background='ssamzie_02.gif' align='center' valign='_self'><br>
         <table cellspacing=0 cellpadding=1 bordercolorlight='#cccccc' bordercolordark='#ffffff' border=1 width=590>
         <tr>
         <!-- <form name='pay' onSubmit='return paychecks()' method='post' >  -->
         <form name='pay' method='post' > 
          <input type='hidden' name='mode' value=''>
          <input type='hidden' name='bmode' value='' >
          <input type='hidden' name='incomedate' value=''>
          <input type='hidden' name='mod_key' value='<?=$mod_key?>'>
          <input type='hidden' name='pay_cd' value=''>
          <input type='hidden' name='pay_nm' value=''>
          <td bgcolor='#666666' colspan=3 align=center  height='20'><font color=yellow>:+: Spend input :+: Date:<input type='text' size='9' name='paydate' value='<?=$paydate?>' readonly></td>
         </tr>
         <tr>
            <td bgcolor='#f0f0f0' width=80 align=center> <font color='#908c90'>Pay Title</font> </td>
            <td bgcolor='#ffffff'><input type='text' size=12' name='payinfo' value='<?=$payinfo?>' maxlength='100'> 
				<input type='button' value='Title Add' onclick="pay_code_insert()" title='Register your spending account.'>
				<input type='button' value='change' onclick="pay_code_change()" title='Change spending account name.'>
			</td>
           <td align=center bgcolor='#f0f0f0' align=center> <font color='#908c90'>Select Pay Title</font></td>
           </tr>
          <tr>
            <td bgcolor='#f0f0f0' align=center> <font color='#908c90'>price</font>  </td>
            <td bgcolor='#ffffff'><input type='text' size='12' style='TEXT-ALIGN: right' name='paymoney' value='<?=$paymoney?>' maxlength='11' onkeyUp='moneyShape(this);'></td></td>
          <td rowspan=3 valign=top>
         <select name='payclass' size='5' onclick='setPayinfo(this.options[this.selectedIndex].text,this.value)' style="FONT-SIZE: 9pt; FONT-FAMILY: 굴림,Tahoma,Verdana;" >
			  <option value='' selected>Select Pay Title</option>
<?php
				$sql="select * from kapp_pay_code where userid='$H_ID' order by payinfo";
				$result = sql_query($sql);
				while( $row = sql_fetch_array($result) ){
?>
					<option value='<?=$row['pay_code']?>:<?=$row['payinfo']?>'  ><?=$row['payinfo']?></option>
<?php } ?>
          </select>
              </td>
          </tr>
          <tr>
            <td bgcolor='#f0f0f0' align=center > <font color='#908c90'>Memo</font>  </td>
            <td bgcolor='#ffffff'><input type='text' size='30' maxlength='250' name='memo' value='<?=$memo?>' ></td>
          </tr>
          
          <tr><td colspan=2 bgcolor='#ffffff' align=center>
			  <input type='button' value='<?=$submit_value?>' onclick="Insert_func('<?=$paydate?>', '<?=$bmode?>')"  class='submit'>
			  <input type='button' value=' Close ' onclick="cancel_func('<?=$paydate?>')"  class='submit'>
           </td>
          </tr></form>
          
          </table>
          <p>
          
          <!-- <table cellspacing=0 cellpadding=1 bordercolorlight='#cccccc' bordercolordark='#ffffff' border=1 width=430> -->
          <table cellspacing=0 cellpadding=1 bordercolorlight='#cccccc' bordercolordark='#ffffff' border=1 width=590>
           <tr>
              <td colspan=6 align=center bgcolor='#cccccc' height='20'>:+: Income, Expenditure[<?=$paydate?>] :+:</td><!--  [수입,지출 내역]  -->
           </tr>
           
           <tr bgcolor='#f0f0f0' >
            <!-- <td align=center WIDTH='130' height=20><font color='#908c90'>Title</font> </td> -->
            <td align=center WIDTH='130' height=20><font color='#908c90'>Income/Expenditure<br> content</font> </td>
            <td align=center WIDTH='130' height=20><font color='#908c90'>memo</font> </td>
            <td align=center width='100'><font color='#908c90'>income</font> </td><!-- <br>[수입] -->
            <td align=center width='100'><font color='#908c90'>expenditure</font> </td><!-- <br>[지출] -->
            <td align=center width='50'> <font color='#908c90'>Change</font> </td>
            <td align=center width='50'> <font color='#908c90'>Delete</font> </td>
            </tr>
<?php
	  // 사용내역.. 불러오기..
   	 $sql = "select * from kapp_pay where userid='$H_ID' and paydate ='$paydate' ";
   	 $result = sql_query($sql);
   	 $total = sql_num_rows($result);
	 $sql2 = "select * from kapp_income where userid='$H_ID' and incomedate ='$paydate'";
   	 $result2 = sql_query($sql2);
   	 $total2 = sql_num_rows($result2);
   	 if( $total ==0 && $total2 ==0){
   		//echo(" <tr bgcolor='#ffffff'><td colspan=5 align=center height=30>※지출내역이 없습니다.</td></tr>");
   	 }
   	 if ( $total > 0 ) {
   	      for( $i=0;$i<$total;$i++){
                   $row = sql_fetch_array($result);
                   $view_money2 = "";
                   $view_money = number_format($row['money'],0);
				   $payinfo = $row['payinfo'];
				   $memo = $row['memo'];
				   $num = $row['num'];
				   $paydate = $row['paydate'];
              echo "
                    <tr  bgcolor='#ffffff'>
                      <td align=center height=21 >$payinfo</td>
                      <td align=center height=21 >$memo</td>
                      <td align=right  height=21 >$view_money2</td>
                      <td align=right  height=21 >$view_money</td>
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
   	      for($i=0;$i<$total2;$i++){
                   $row2 = sql_fetch_array($result2);
                   $view_money2 = number_format($row2['money'],0);
				   $num=$row2['num'];
				   $incomedate=$row2['incomedate'];
				   $incomeinfo=$row2['incomeinfo'];
				   $memo=$row2['memo'];
                   $view_money = "";
              echo "
                    <tr  bgcolor='#ffffff'>
                      <td align=center height=21 >$incomeinfo </td>
                      <td align=center height=21 >$memo </td>
                      <td align=right  height=21 >$view_money2</td>
                      <td align=right  height=21 >$view_money</td>
                      <td align=center height=21 width='50'>
						<input type='button' value='Change' onclick=\"return paymodify2('$num')\"  class='submit' title='paymodify2'>
					</td>
                      <td align=center height=21 width='50'>
						  <input type='button' value='Delete' onclick=\"return paydelete2('$num', '$incomedate')\"  class='submit'>
					</td>
                    </tr>
                  ";
          }
   	 }
?>
          </table>
          <center><br> 
		  <input type='button' value='Close' onclick='formclose()' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type='button' value='Import Status' onclick="income_insert('<?=$paydate?>')" class='submit' style="border-style:;background-color:#666fff;color:black;width:100px; height:20px;FONT-SIZE: 9pt; FONT-FAMILY: 굴림,Tahoma,Verdana;" title='Change to the payment registration screen.' >
			</td>
				</tr>
				</table>
         </body>
         </html>
