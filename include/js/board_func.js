
function getFuncHelp(fid) {
	switch(fid) {
		case "GCOM01" : return "- 공지사항 : 커뮤니티 회원에게 공지할 공지사항을 입력하는 게시판입니다. "
		case "GCOM02" : return "- 일반게시판 : 커뮤니티 내에서 사용 할 게시판입니다. 성격에 맞게 게시판 명을 정하십시오."
		case "GCOM03" : return "- 답변게시판 : 커뮤니티 내에서 사용 할 게시판입니다. 성격에 맞게 게시판 명을 정하십시오."
		case "GCOM04" : return "- 자료실 : 커뮤니티 자료실입니다."
		case "GCOM05" : return "- 방명록 : 커뮤니티 방문객이 이용 할 방명록입니다."
		case "GCOM06" : return "- 한줄메모  : 한줄메모(코멘트 기능강화)및 출석체크를 제공합니다."
		case "GCOM08" : return "- 앨범  : 커뮤니티 앨범입니다."

		case "TCOM01" : return "- 타이틀  : 메뉴의 타이틀을 구성합니다."
		case "TCOM02" : return "- 메뉴구분선 : 메뉴와 메뉴사이의 구분선을 추가합니다."
//		case "TCOM03" : return "- 설문게시판  : 회원등급별 설문및 의견묻기를 제공합니다."
		case "TCOM03" : return "- 음성자료실  : 회원등급별 설문및 의견묻기를 제공합니다."
		case "TCOM04" : return "- 영상자료실  : 회원등급별 를 제공합니다."
		case "TCOM05" : return "- 문서자료실  : 회원등급별 를 제공합니다."
		case "TCOM06" : return "- 그림자료실  : 회원등급별 를 제공합니다."
		default : return ""
	}
}

function getFuncName(fid) {
	switch(fid) {
		case "GCOM01" : return "[공지사항]"
		case "GCOM02" : return "[통합게시판]"
		case "GCOM03" : return "[통합게시판]"
		case "GCOM04" : return "[통합게시판]"
		case "GCOM05" : return "[메모게시판]"
		case "GCOM06" : return "[메모게시판]"
		case "GCOM08" : return "[사진게시판]"

		case "TCOM01" : return "[타이틀]"
		case "TCOM02" : return "[구분선]"
//		case "TCOM03" : return "[설문게시판]"
		case "TCOM03" : return "[음성자료실]"
		case "TCOM04" : return "[영상자료실]"
		case "TCOM05" : return "[문서자료실]"
		case "TCOM06" : return "[그림자료실]"

		default : return "[]"
	}
}

function getFuncMulti(fid) {
	switch(fid) {
		case "GCOM01":

			return false
		default:
			return true
	}
}
