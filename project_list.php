<?php
	include "../../t/tkher_start_necessary.php";
	$H_ID  = get_session("ss_mb_id");
	$H_LEV = $member['mb_level'];
	if(!$_SESSION['id']) {
		$id = $_REQUEST['H_ID'];
	}	else  {
		$id = $_SESSION['H_ID'];
	}
	$c_sel = $_REQUEST['c_sel'];
	if(!$c_sel) $c_sel = 'a';
	$page = $_REQUEST['page'];
		include "./inc/paging2.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<meta name="format-detection" content="telephone=no" />
<title>모두모아 Customer Center</title>
<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>

<script type="text/javascript" >
	// 사용됨.............
	function Change_Csel(c_sel){
		document.c_sel.c_sel.value=c_sel;
			//alert(' Change_Csel ' + c_sel);
		document.c_sel.submit();
		//location.href="company_list.php";
		//location.href="company_list.php?c_sel="+c_sel;
	}
	function Change_Csel2(c_sel){
		document.c_sel2.c_sel.value=c_sel;
		document.c_sel2.submit();
	}
	function custom_view(c_sel, id, pass_check, no, page){
			//alert(' pass=' + pass_check +', id='+id);  //ok
			if(!id)	location.href="customer_pass.php?c_sel="+ c_sel + "&no="+no+"&page="+page+'#view_page';
			else	location.href="customer_view.php?c_sel="+ c_sel + "&id="+id+"&no="+no+"&page="+page +'#view_page';
			//if(id=='')	location.href="customer_pass.php?no="+no+"#view_page";
			//else		location.href="customer_view.php?id="+id+"&no="+no + "#view_page";
		}
	function custom_write(i,uid, page, c_sel){
			//alert(' custom_write uid=' + uid);  //ok
			if( uid )	location.href="customer_write.php?c_sel="+ c_sel + "&page="+page+ "&id=" + uid + "#write_page";
			else 	    location.href="customer_write.php?c_sel="+ c_sel + "&page="+page+"#write_page";
		}
 </script>

<script>
	$(function() {
		  /*
		  */
		$('.A').on('click', function() {
			var id = document.login.login_id.value;
			var pw = document.login.login_pw.value;
			if( id == ''){
				alert('customer ID 입력하세요. ');
				document.login.login_id.focus();
				return false;
			}
			if( pw ==''){
				alert('비밀번호를 입력하세요.');
				document.login.login_pw.focus();
				return false;
			}
			//alert('A-------Login');
			//alert('ID  = id,' + id + ', pw=' + pw);
			//location.href="company_list.php?mode=login&id="+id +"&pw="+pw;
			document.login.submit();
		});
		$('.B').on('click', function() {
			$('.A').trigger('click');
		});
		$('.C').on('click', function() {
				//alert('Logout ----------------- ');
			location.href="index.php?mode=logout";
		});
		$('.U').on('click', function() {
				//alert('유지보수 ----------------- ');
			//location.href="company_list.php?mode=U";
		});
		$('.G').on('click', function() {
				alert('공지 ----------------- ');
			location.href="company_list.php?mode=G";
		});
		$('.sr').on('click', function() {
				alert('Search ----------------- ');
			location.href="company_list.php?mode=sr";
		});
	});
</script>

</head>
<body>

<div class="wrapper"><!-- start : wrapper -->

	<div class="header"><!-- start : header -->
		<h1>
			<a href="./index.php?id=<?=$id?>" class="logo">
				<img src="../include/img/etc/etc_logo.png" class="logo_web" alt="LEDSignArt" />
				<img src="../include/img/etc/etc_flogo.png" class="logo_mobile" alt="LEDSignArt" />
			</a>
		</h1>
		<a href="javascript:common.lnbOpen()" class="icoTotal"><img src="../include/img/btn/btn_total.png" /></a>
	</div><!-- end : header -->

	<div class="container"><!-- start : container -->

		<div class="visualBox">
			<div class="visualSlide">
				<div class="item bg_c01">
					<div class="txtbox">
						<div class="cellbox">
							<p class="t01">어데가노 앱 가맹점 목록  </p>
							<p class="t02">Company List</p>
							<p class="t03">
								<span>고객과 함께 소통하는 모두모아 가맹점 입니다. </span>
								<span>모두모아의 가맹점을 만나실 수 있으며, 고객과 소통하여 </span>
								<span>매출을  최대한 극대화하여 모두모아와 상생하는 소상공인 들입니다.</span>
								<span>어데가노앱은 보다나은 고객 서비스로 앱의 이용이 편리하고 유익하도록 노력하고 있습니다.</span>
							</p>
						</div>
					</div>
				</div>

			</div>
		</div>
<?php
		//$c_sel = $_gubun[c_sel];
		$maintenance = "";    //$_REQUEST[maintenance];  // 임시test

		//$today = date('Y-m-d');
		$today = date('Y-m');
		$reg_date = date("Y-m-d H:i:s");

		if( !$maintenance ) {

			//$result = mysql_query("SELECT COUNT(*) FROM Students;");
			if( !$c_sel || $c_sel =='a' ) $SQL = "select COUNT(*) as total from project";
			else $SQL = "select COUNT(*) as total from project where gubun='$c_sel'";
			if ( ($result = sql_query( $SQL ) )==false )
			{
			  printf("Invalid query: %s", $SQL);
				m_(" count Select 오류가 발생하였습니다. ");
				//exit();
			} else {
				$data=sql_fetch_array($result); //sql_fetch_assoc($result);
				$total = $data['total'];
			}
			//--------- today -----------------------------------------------------------------like '%[진사미]%'
			if( !$c_sel || $c_sel =='a' ) $SQL = "select COUNT(*) as total from project where day like '%$today%' ";
			else $SQL = "select COUNT(*) as total from project where gubun='$c_sel' and day like '%$today%' ";
			if ( ($result = sql_query( $SQL ) )==false )
			{
			  printf("Invalid query: %s", $SQL);
				m_(" count Select 오류가 발생하였습니다. ");
				//exit();
			} else {
				$data= sql_fetch_array($result); //mysqli_fetch_assoc($result);
				$total_day = $data['total'];
			}
		}

?>
		<div id="write_page" class="mainProject">
			<h2 class="cmnSubj" id="customer">customer</h2>
			<p class="cmnText">Project List</p>
			<div class="listTabs01">
				<a href="./company_list.php?id=<?=$id?>#customer" class="on">가맹점목록</a>
				<a href="./project_list.php#customer">프로젝트신청현황</a>
			</div>

			<div class="boardView">
				<div class="boardNorBox">
					<form name=c_sel action='company_list.php#customer' method=post enctype="multipart/form-data" >
					<input type="hidden" name='page'  value='<?=$page?>' />
					<input type="hidden" name='id'    value='<?=$id?>' />
					<input type="hidden" name='c_sel' value='<?=$c_sel?>' />
					<div class="fl">
						<select name='c_sel' onChange='Change_Csel(this.options[this.selectedIndex].value)' style='height:30px;'>
							<option value='a' <?php if($c_sel=='a' || !$c_sel) echo " selected" ?> >전체</option>
							<option value='1' <?php if($c_sel=='1') echo " selected" ?> >접수</option>
							<option value='2' <?php if($c_sel=='2') echo " selected" ?> >작업중</option>
							<option value='3' <?php if($c_sel=='3') echo " selected" ?> >완료</option>
						</select>
					</div>
					<div class="fr">
						<span>총 프로젝트 <strong><?=$total?></strong>건, 최근 <strong><?=$total_day?></strong>건</span>

						<a href="javascript:custom_write(0,'<?=$id?>','<?=$page?>','<?=$c_sel?>');" class="btn_bo02">가맹점 등록</a>

					</div>
					</form>
				</div>

				<table class="listTable">
					<tr>
						<th class="cell01">번호</th>
						<th class="cell02">분류</th>
						<th class="cell03">프로젝트 제목</th>
						<th class="cell04">작업</th>
						<th class="cell03">예산</th>
						<th class="cell03">작업기간</th>
						<th class="cell03">등록자</th>
						<th class="cell03">연락처</th>
						<th class="cell03">E-Mail</th>
						<th class="cell03">등록일</th>
						<th class="cell03">요구사항</th>
					</tr>

<?php
		$maintenance = $_REQUEST['maitenance'];
		$c_sel = $_REQUEST['c_sel'];
		$page  = $_REQUEST['page'];
		$p_cnt = 15;  // page cnt
		if( !$maintenance ) {

			if( !$c_sel || $c_sel =='a' ) 
				 $SQL1 = "select count(*) as cnt from project ";
			else $SQL1 = "select count(*) as cnt from project where gubun='$c_sel' ";

			if ( ($result = sql_query( $SQL1 ) )==false )
			{
				printf("Invalid query: %s", $SQL1);
				m_(" Select 오류가 발생하였습니다. ");
				$total_count = 0;
				//exit();
			} else {
				$row = sql_fetch_array($result);
				$total_count = $row['cnt'];
				//------------------------------------------------------------
				$rows = $p_cnt; // 15 $config['kapp_page_rows'];
				$total_page  = ceil($total_count / $p_cnt);			// 전체 페이지 계산
				if ($page < 1) {
					$page  = 1;										// 페이지가 없으면 첫 페이지 (1 페이지)
					$start = 0;
				} else {
					$start = ($page - 1) * $p_cnt;					// 시작 열을 구함
				}
				
				$last = $p_cnt;										// 뽑아올 게시물 [끝]
				if( $total_count < $last) $last = $total_count;

				//m_(" total cnt=$total_count, total_page=$total_page, limit=$limit ");
			}

			//if( !$c_sel || $c_sel =='a' ) $SQL = "select * from project order by day desc ";
			//else $SQL = "select * from project where gubun='$c_sel' order by day desc ";
			//if( !$c_sel || $c_sel =='a' ) $SQL = "select * from project order by day desc limit " . $start.", ". $last;
			//else $SQL = "select * from project where gubun='$c_sel' order by day desc limit " . $start.", ". $last;
			if( !$c_sel || $c_sel =='a' ) $SQL = "select * from project order by day desc limit " . $start.", ". $last;
			else $SQL = "select * from project where gubun='$c_sel' order by day  desc limit " . $start.", ". $last;
			if ( ($result = sql_query( $SQL ) )==false )
			{
			  printf("Invalid query: %s", $SQL);
				m_(" Select 오류가 발생하였습니다. ");
				//exit();
			} else {
				while( $row = sql_fetch_array($result)  ) {
					$no++;
					$gu = $row['gubun'];
					$day = $row['day'];
					$datex= explode(' ', $day);
					$dt = $datex[0];
?>
					<tr>
						<td class="cell01"><?=$no?></td>
						<td class="cell02"><!-- <?=$row['gubun']?> -->
						<?php
						if( $gu =='1') { echo " <span class='cate t01'>접수</span> "; }
						else if($gu =='2') { echo " <span class='cate t02'>작업중</span> "; }
						else if($gu =='3') { echo " <span class='cate t03'>완료</span> "; }
						else { echo " <span class='cate t01'>접수</span> "; }
						?>
						</td>
						<td class="cell03"><a href="javascript:custom_view('<?=$c_sel?>','<?=$id?>','<?=$row['pass_check']?>','<?=$row['no']?>', <?=$page?> );" >
						<span class="t01"></span><span><?=$row['wr_subject']?></span></a></td>
						<td class="cell04"><?=$row['reguest']?></td>
						<td class="cell04"><?=$row['wr_yesan']?></td>
						<td class="cell04"><?=$row['wr_iljung']?></td>
						<td class="cell04"><?=$row['wr_name']?></td>
						<td class="cell04"><?=$row['wr_tel']?></td>
						<td class="cell04"><?=$row['wr_email']?></td>
						<td class="cell04"><?=$dt?></td>
						<td class="cell06"><?=$row['wr_content']?></td>
					</tr>
<?php
				}
				//m_(" 프로젝트  list 하였습니다. ");
			}
		} else {
		}
?>
				</table>

				<div class="boardNorBox mt10">
					<div class="fl">
					<form name='c_sel2' action='company_list.php#customer' method=post enctype="multipart/form-data" >
						<input type="hidden" name='page'  value='<?=$page?>' />
						<input type="hidden" name='id'    value='<?=$id?>' />
						<input type="hidden" name='c_sel' value='<?=$c_sel?>' />
					<table>
						<tr>
						<td>
						<!-- <select class="select"><option>전체</option></select> -->
						<select name='c_sel' onChange='Change_Csel2(this.options[this.selectedIndex].value)' style='height:32px;'>
							<option value='a' <?php if($c_sel=='a' || !$c_sel) echo " selected" ?> >전체</option>
							<option value='1' <?php if($c_sel=='1') echo " selected" ?> >접수</option>
							<option value='2' <?php if($c_sel=='2') echo " selected" ?> >작업중</option>
							<option value='3' <?php if($c_sel=='3') echo " selected" ?> >완료</option>
						</select>
						</td>
						<!-- <input type="text" /> -->
						<td align='left'><input type="text" name='search' /></td>
						<td align='left'><div class="sr"><a href="javascript:void(0)" class="btn_bo02">검색</a></div></td>
						<td align='right'><div class="fr">
						<!-- <a href="javascript:void(0)" class="btn_bo02">글쓰기</a> -->
						<a href="javascript:custom_write(1,'<?=$id?>','<?=$page?>','<?=$c_sel?>');" class="btn_bo02">가맹등록</a>
						</div>
						</td>
					</tr></table>
					</form>
				</div>
<?php
	paging("company_list.php?search_choice=$search_choice&search_text=$search_text&id=$id&c_sel=$c_sel",$total_count,$page,$p_cnt); 
?> 
<!--
				<div class="paging">
					<a href="javascript:void(0)" class="prev"><img src="../include/img/btn/btn_prev.png" /></a>
					<a href="javascript:void(0)" class="on">1</a>
					<span>.</span>
					<a href="javascript:void(0)">2</a>
					<span>.</span>
					<a href="javascript:void(0)">3</a>
					<span>.</span>
					<a href="javascript:void(0)">4</a>
					<span>.</span>
					<a href="javascript:void(0)">5</a>
					<span>.</span>
					<a href="javascript:void(0)">6</a>
					<a href="javascript:void(0)" class="next"><img src="../include/img/btn/btn_next.png" /></a>
				</div>
-->
			</div>
		</div>
		<a href="javascript:common.openProj01()" class="btn_req">
			<span>PROJECT REQUEST</span>
			<img src="../include/img/ico/ico_arr01.png" />
		</a>

	</div><!-- end : container -->
	<?php
		include "footer_include.php";
	?>

	<?php
	//include "comp_ifooter.php";
	?>

	</div><!-- end : wrapper-->

	<?php
		include "project_include.php";
	?>

	<!-- Login Logout Display  -->
	<?php
		include "login_include.php";
	?>
</body>
</html>
