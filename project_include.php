<?php
	$str  = "abcdefghijklmnopqrstuvwxyz";
    $str .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str .= "0123456789";

    $shuffled_str = str_shuffle($str);
	$auto_char    = substr($shuffled_str, 0, 6);
    //echo $shuffled_str;
	$f_path = "./pro_file";
	$day = date("Y-m-d h:i:s");
	if( $_POST['mode'] == "insert_prj") {
		$hb = $_POST['request_0']; 
		$cnt= sizeof($hb);
		$data = '';
		for($i=0; $i < $cnt; $i++) {
			$data .= $hb[$i] . ', ';
		}
		$wr_subject=$_REQUEST['wr_subject']; 
		//$reguest=$_REQUEST[reguest]; 
		$bf_file=$_REQUEST['bf_file']; 
		$wr_yesan=$_REQUEST['wr_yesan']; $wr_iljung=$_REQUEST['wr_iljung'];     $wr_content=$_REQUEST['wr_content']; 
		$wr_name=$_REQUEST['wr_name'];   $wr_tel=$_REQUEST['wr_tel'];           $wr_comp=$_REQUEST['wr_comp']; $wr_bu=$_REQUEST['wr_bu']; 
		$wr_email=$_REQUEST['wr_email']; $wr_homepage=$_REQUEST['wr_homepage']; $pass_check=$_REQUEST['pass_check'];

		if ($file and $file_size){
			$file_ext =explode(".",$file_name);
			$extsize  =sizeof($file_ext);
			$extsize  =$extsize-1;
			//$file_nick=$in_date . "." . $file_type;
			$file_nm   = strtolower( $file_ext[0]);
			$file_type = strtolower( $file_ext[$extsize]);

			$file_nick = "pro_". $file_nm . "." . $file_type;

			if(!copy($file,"$f_path/$file_nick")) {
				echo("파일업로드에 실패 하였습니다.");
				exit;
			} else {
				unlink($file);
			}
		}

		$SQL = "insert into {$tkher['project_table']} (wr_subject, reguest, wr_yesan, wr_iljung, wr_content, bf_file, wr_name, wr_tel, wr_comp, wr_bu, wr_email, wr_homepage,day, pass_check) values ('$wr_subject', '$data', '$wr_yesan', '$wr_iljung', '$wr_content', '$file_nick', '$wr_name', '$wr_tel', '$wr_comp', '$wr_bu', '$wr_email', '$wr_homepage','$day','$pass_check' ) ";
		if( ( $result = sql_query( $SQL ) )==false ) {
			printf("Invalid query: %s", $SQL);
			m_("project 등록 오류가 발생하였습니다. ");
			exit();
		} else {
			m_("OK Insert");
			$content	.= ' 프로젝트 의뢰 작성자 성함 : ' . $wr_name . ', <br>';
			$content	.= ' 연락처 : ' . $wr_tel . ', <br>';
			$content	.= ' 프로젝트 의뢰 제목 : ' . $wr_subject . ', <br>';
			$content    .= ' 원하는 서비스 : ' . $data . ', <br>';
			$content	.= ' 의뢰내용 : ' . $wr_content . ', <br>';
			$content	.= ' 예산 : ' . $wr_yesan . ', <br>';
			$content	.= ' 일정 : ' . $wr_iljung . ', <br>';

			$EMAIL		= $wr_email;				//"solpakan@naver.com";
			$NAME		= "연구소 소장 강철호";
			$SUBJECT	= $wr_subject;				//$title;
			$CONTENT	= $content;
			$mailto		= $send_mail;
			sendMail($EMAIL, $wr_name, $SUBJECT, $CONTENT, $mailto);
			m_(" 프로젝트 의뢰 등록 하였습니다.  guest_mail: $EMAIL , $content");
		}
	}
?>

<div class="dialog">
	<div class="etcArea" onclick="common.lnbClose()"></div>
	<!-- <div class="etcArea" onclick="prj_check()"></div> -->
	
	<div class="project_area" id="project">
		<div class="project_request">
			<div class="close"></div>
			<div class="project_header">
				<h1>:프로젝트 의뢰:</h1>
				<h2>작은 일도 최선의 노력을 다하고 있습니다.</h2>
				<p>KAPP는 의뢰인을 위하여 작은 프로젝트도 최고의 퀄리티를 내기 위해 최선의 노력을 다하고 있습니다.<br>
				아래 양식을 작성해 주시면 빠르게 연락드리겠습니다.</p>
			</div>

			<div class="project_part">
				
				<FORM name='prj' action='index.php' method='post' enctype="multipart/form-data" >

					<input type="hidden" name='cracan' value='insert_prj' />
					<input type="hidden" name='mode'   value='insert_prj' />
					<input type="hidden" name='auto_char' value='<?=$auto_char?>' />
				<h3>프로젝트 정보</h3>
				<p><input name="wr_subject" itemname="제목" required="required" type="text" placeholder="프로젝트 제목 (필수)"></p>

				<div>
					<h4>어떤 서비스를 원하십니까?</h4>
					<ul class="select_choice">
						<li>
							<input type="checkbox" name="request_0[]" id="request_01" value="Web Program"> 
							<label for="request_01"><span>Web Program</span></label>
						</li>
						<li> 
							<input type="checkbox" name="request_0[]" id="request_02" value="Android App"> 
							<label for="request_02"><span>Android App</span></label>
						</li>
						<li> 
							<input type="checkbox" name="request_0[]" id="request_03" value="iPhone App"> 
							<label for="request_03"><span>iPhone App</span></label>
						</li>
						<li>
							<input type="checkbox" name="request_0[]" id="request_04" value="AI"> 
							<label for="request_04"><span>AI</span></label>
						</li>
						<li>
							<input type="checkbox" name="request_0[]" id="request_04" value="MetaVerse"> 
							<label for="request_04"><span>MetaVerse</span></label>
						</li>
						<li>
							<input type="checkbox" name="request_0[]" id="request_04" value="PC App"> 
							<label for="request_04"><span>PC App</span></label>
						</li>
						<li>
							<input type="checkbox" name="request_0[]" id="request_04" value="ETC App"> 
							<label for="request_04"><span>ETC App</span></label>
						</li>
						
					</ul>

					<ul class="select_choice02">
					<li>
						<div>
							<select name="wr_yesan" value="" required="required">
								<option value="예산을 선택해 주세요.">예산을 선택해 주세요.</option>
								<option value="100만원 미만">100백만원</option>
								<option value="100~500만원">100~500백만원</option>
								<option value="500~1000만원">500만원 이상 ~ 1000만원</option>
								<option value="1,000만원~3,000만원"> 1,000만원~3,000만원</option>
								<option value="3,000만원~5,000만원">3,000만원~5,000만원</option>
								<option value="5,000만원~1억원">5,000만원~1억원</option>
								<option value="1억원 이상">1억원 이상 </option>
								<option value="미정">미정</option>
							</select>
						</div>
					</li>
					<li>
						<div>
							<select name="wr_iljung" value="" required="required">
								<option value="일정을 선택해 주세요.">일정을 선택해 주세요.</option>
								<option value="바로 해야 합니다.">바로 해야 합니다.</option>
								<option value="1개월 이내">1개월 이내</option>
								<option value="1~2개월">1~2개월</option>
								<option value="3~5개월">3~5개월</option>
								<option value="6~9개월">6~9개월</option>
								<option value="9개월 이상">9개월 이상 </option>
							</select>
						</div>
					</li>
				</ul>

				<p>
					<span></span>      
					<textarea name="wr_content" placeholder="의뢰하실 프로젝트 내용을 입력해 주세요. (필수)" required="required"></textarea> 		
				</p> 
				<p class="filebox">
					<input type="file" class="ed" name="file" title="파일 용량  이하만 업로드 가능">
					<br>
					압축하여 올려주시고, 최대 20mb까지 가능합니다.
				 </p> 
			 
				</div>
			</div><!--//project_part--> 

			<div class="project_part">
				<h3>신청자 정보</h3>

				<ul class="select_choice02">
					<li>
						<div><input name="wr_name" value="" itemname="name" required="required" type="text" placeholder="name (필수)"></div>
					</li>
					<li>
						<div><input name="wr_tel" type="text" required="required" itemname="mobile" placeholder="mobile (필수)"></div>
					</li>
					<li>
						<div><input name="wr_email" type="text" required="required" itemname="E-mail" placeholder="E-mail (필수)"></div>
					</li>
					<li>
						<div><input name="wr_homepage" type="text" itemname="HomePage" placeholder="HpmePage"></div>
					</li>
				</ul>

				<ul class="select_choice02">
					<li>
						<div><input name="wr_comp" type="text" placeholder="company name" itemname="company"></div>
					</li>
					<li>
						<div><input name="wr_bu" type="text" placeholder="Department/Title"></div>
					</li>
				</ul>

				<p><input name="pass_check" itemname="Password(Required when making changes!)" type="password" placeholder="Password - Required when making changes! (필수)" required="required"></p>

<!-- 
				<p><input name="auto_check" itemname="자동방지 문자" type="text" placeholder="아래 자동방지 문자를 정확히 입력하세요! (필수)" required='required' oncontextmenu='return false' ondragstart='return false' onselectstart='return false'>자동방지 문자 : <?=$auto_char?> </p>
				<p><span class="t02"><?=$auto_char?> = <input type="text" name="auto_check2" value='' oncontextmenu='return false' ondragstart='return false' onselectstart='return false'></p> -->
					<!-- <span class="t01">자동방지 문자 :</span> 
					<span class="t02"><?=$auto_char?> = <input type="text" name="auto_check" value='' oncontextmenu='return false' ondragstart='return false' onselectstart='return false'>
					&nbsp;&nbsp;&nbsp;(자동 방지 코드를 정확히 입력 바랍니다.)</span> -->
					<!-- <br><br>
					<span class="t01">비밀번호 :</span> 
					<span class="t02"><input type="text" name="pass_check" value='' > (변경시에 필요합니다.!)</span> -->
			</div><!--//project_part-->


			<div class="privacypolicy">
				<p><input name="agree" id="agree" type="checkbox" value="0" required="required"> 
					<label for="agree"><a class="etcBtn">Privacy Policy</a> I agree*</label> 
				</p>
			</div>

			<div class="Btn"><input id="btn_submit" type="submit" accesskey="s" value="Request" ></div>
			</form><!-- prj end  -->
		</div>
	</div>
