<?php
	include "./tkher_start_necessary.php";
	$H_ID  = get_session("ss_mb_id");
	$H_LEV = $member['mb_level'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<meta name="format-detection" content="telephone=no" />
<title>회사소개</title>
<link rel="stylesheet" href="./include/css/common.css" type="text/css" />
<script type="text/javascript" src="./include/js/ui.js"></script>
<script type="text/javascript" src="./include/js/commonO.js"></script>

</head>
<body> <!-- about.php를 index.php로 사용. index.php 는 indexA.php 로 -->

<div class="wrapper"><!-- start : wrapper -->

	<?php
		include "header.php";
	?>

	<div class="container"><!-- start : container -->

		<div class="item" id="videoBg"><div class="videoPattern"></div></div>

		<div class="subCompany">
			<h2 class="cmnSubj">COMPANY</h2>
			<p class="cmnText">MODUMOA Information</p>
			<div class="companyBox">
				<img src="./include/img/etc/etc_logo01.png" />
				<table>
					<tr>
						<th>Company</th>
						<td>(주)모두모아</td>
					</tr>
					<tr>
						<th>Our Bussiness</th>
						<td>메타버스 기반 디지털 휴먼 방송 시스템(전통시장 소상공인 전용), 의료관광, AI휴먼 Live Commerce, AI Solution, Viral marketing, 3D 실감형 메타버스 </td>
					</tr>
					<tr>
						<th>Number of Staff</th>
						<td>6</td>
					</tr>
					<tr>
						<th>Office Address</th>
						<td>부산광역시 서구 구덕로 186번길 13(2층) </td>
					</tr>
				</table>
			</div>
		</div>

		<div class="subCeo">
			<h2 class="cmnSubj">CEO MESSAGE</h2>
			<p class="cmnText"><span>Connecting people with technology,</span> this is priority value of us.</p>
			<div class="ceoBox">
				<ul>
					<li>주식회사 모두모아는 2020년 오픈하였습니다. </li>
					<li>저희 모두모아는 온오프라인을 넘나드는 오랜 경험과 끈질긴 생명력으로 살아 남았으며, 앞으로의 길은 과거보다 더 험난하리라 생각되지만 이전에도 그랬듯이 더욱 더 발전하리라 생각합니다.</li>
					<li>비전은 <span>"주식회사 모두모아는 소상공인을 돕는 기업이 되는 것을 기업의 가치로 삼으며 소상공인들의 온라인 경기 활성화에 대한 해결방안을 수립하고 실행하기 위해 앱인앱 '어데가노'를 이용한다."</span> 입니다.</li>
					<li>AI 라이브커머스, 지문인식 승선 시스템, 어데가노 앱등으로 온오프라인을 아우르는 기업으로서 소상공인에게 최상의 비즈니스 파트너가 되겠습니다.</li>
					<li>감사합니다.</li>
				</ul>
				<img src="./include/img/etc/etc_ceo.png" />

			</div>
		</div>

		<div class="subHistory">
			<h2 class="cmnSubj">HISTORY</h2>
			<p class="cmnText">The path we have followed </p>
			<div class="historyBox">
			<div class="item t01">
					<div class="year">2020</div>
					<ul>
						<li class="c01">
							<span class="t01"> 월 일</span>
							<span class="t02">창업</span>
						</li>
					</ul>
				</div>

				<div class="item t02">
					<div class="year">2023</div>
					<ul>
						<li class="c02">
							<span class="t01">04월~현재</span>
							<span class="t02">VR지도 제작 - 괴정골목시장 <a href="https://moado.net/_mat/indexA.html#">괴정골목시장 이동!</a> </span>
						</li>
						<li class="c02">
							<span class="t01">04월~현재</span>
							<span class="t02">VR지도 제작 - 샘터상가 <a href="https://moado.net/_mat/indexB.html#">샘터상가 이동!</a> </span>
						</li>
						<li class="c02">
							<span class="t01">03월~현재</span>
							<span class="t02">피트모스 - 러시아 - 사할린 </span>
						</li>
						<li class="c02">
							<span class="t01">03월~현재</span>
							<span class="t02">스마트 팜 </span>
						</li>
						<li>
							<span class="t01">02월~현재</span>
							<span class="t02">거름 제조 장비 </span>
						</li>
						<li>
							<span class="t01">01월~현재</span>
							<span class="t02">스마트 협동 조합 </span>
						</li>
					</ul>
				</div>

				<div class="item t03">
					<div class="year">2022</div>
					<ul>
						<li>
							<span class="t01">07월~현재</span>
							<span class="t02">3D 디지털 트윈 메타버스 - 전통시장</span>
						</li>
						<li>
							<span class="t01">09월~현재</span>
							<span class="t02">전통시장 디지털 휴먼 TTS 라이브 방송 시스템 </span>
						</li>
						<li class="c02">
							<span class="t01">11월~현재</span>
							<span class="t02">AI휴먼 라이브 쇼핑 상담 시스템 </span>
						</li>
						<li>
							<span class="t01">12월~현재</span>
							<span class="t02">AI휴먼 의료 상담 </span>
						</li>
					</ul>
				</div>

				<div class="item t04">
					<div class="year">2021</div>
					<ul>
						<li>
							<span class="t01">11월~현재</span>
							<span class="t02">전통시장 소상공인 모두모아 앱 인 앱 </span>
						</li>
						<li class="c02">
							<span class="t01">9월~현재</span>
							<span class="t02">전통시장 앱 설계 </span>
						</li>
						<li class="c02">
							<span class="t01">05월~현재</span>
							<span class="t02">전통시장 소상공인 쇼핑 앱 디자인 </span>
						</li>
					</ul>
				</div>
			</div> 
		</div>

		<div class="subOrg">
			<h2 class="cmnSubj">ORGANIZATION</h2>
			<p class="cmnText">MODUMOA Organization</p>
			<div class="orgBox">
				<img src="./include/img/bg/bg_org01.png" class="imgWeb" />
				<img src="./include/img/bg/bg_org02.png" class="imgMo" />
			</div>
			<a href="javascript:common.openProj01()" class="btn_req">
				<span>PROJECT REQUEST</span>
				<img src="./include/img/ico/ico_arr01.png" />
			</a>
		</div>

		<div style='margin: 0px 0px 0px 0px' width="100%" height="800" frameborder="0" allowfullscreen="">
		<iframe src="https://my.matterport.com/show/?m=Bh78mdB5rvV" style='margin: 0px 0px 0px 0px' width="100%" height="800" frameborder="0" allowfullscreen=""></iframe>
		</div>

		<div class="subMap">
			<h2 class="cmnSubj">MAP INFO</h2>
			<p class="cmnText">Way to come MODUMOA</p>
			
			<div class="mapBox">
			
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1154.0738119915397!2d129.01936677153583!3d35.10137501464648!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3568e9a310d9e7f5%3A0xe1a2d42db35a5297!2z67aA7IKw6rSR7Jet7IucIOyEnOq1rCDqtazrjZXroZwxODbrsojquLggMTM!5e0!3m2!1sko!2skr!4v1656991932673!5m2!1sko!2skr" width="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			<iframe src="https://my.matterport.com/show/?m=Bh78mdB5rvV" style='margin: 0px 0px 0px 0px' width="100%" height="100%" frameborder="0" allowfullscreen=""></iframe>
			</div> 
		</div>


	</div><!-- end : container -->
<?php
include "footer_include.php";
?>

</div><!-- end : wrapper-->

<?php
include_once "project_include.php";
?>

<?php
include "login_include.php";
?>



</body>
</html>
