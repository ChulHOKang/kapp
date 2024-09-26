 // 액션관련
function kong()
{
	this.selection = null;
	this.selection2 = null;
	this.RestoreSelection = Kong_RestoreSelection;
	this.SaveSelection = Kong_SaveSelection;
	this.GetSelection = Kong_GetSelection;
}

function Kong_RestoreSelection()
{
	if (this.selection)
	{
//	  	this.selection.collapse(true);
		this.selection.select();
	}
}

function Kong_GetSelection()
{
	var oSel = this.selection;
	if (!oSel)
	{
		oSel = EditCtrl.document.selection.createRange();
		oSel.type = EditCtrl.document.selection.type;
	}
	return oSel;
}

function Kong_SaveSelection()
{
	nowkong.selection = EditCtrl.document.selection.createRange();
	nowkong.selection.type = EditCtrl.document.selection.type;
}

function editctrlsize(mode)
{
	if(mode == 1)
	{
		editctrl.style.pixelWidth += 60;
	}
	else if(mode == 2)
	{
		editctrl.style.pixelWidth -= 60;
	}
	else if(mode == 3)
	{
		editctrl.style.pixelHeight += 60;
	}
	else if(mode == 4)
	{
		editctrl.style.pixelHeight -= 60;
	}
}

function showmenu(framename)
{
    var rightedge = document.body.clientWidth - event.clientX;
	var bottomedge = document.body.clientHeight - event.clientY;
	var leftpoint;
	var toppoint;

	if (rightedge < document.all.item(framename).style.width)
	{
		leftpoint = document.body.scrollLeft + event.clientX - document.all.item(framename).style.width + 40;
    }
	else
	{
		leftpoint = document.body.scrollLeft + event.clientX - 40;
    }
	if (bottomedge < framename.offsetHeight)
	{
		toppoint = document.body.scrollTop + event.clientY - framename.offsetHeight;
    }
    else
	{
		toppoint = document.body.scrollTop + event.clientY;
	}
	toppoint = toppoint + 10;
	/* emoticon이 여러개 일 때 각각의 크기 잡음 */
	if(framename=="i_emoticon0")
	{
		document.all.i_emoticon0.style.left = leftpoint;
		document.all.i_emoticon1.style.left = leftpoint;
		document.all.i_emoticon2.style.left = leftpoint;
		document.all.i_emoticon3.style.left = leftpoint;
		document.all.i_emoticon4.style.left = leftpoint;
		document.all.i_emoticon5.style.left = leftpoint;
		document.all.i_emoticon6.style.left = leftpoint;
		document.all.i_emoticon7.style.left = leftpoint;
		document.all.i_emoticon0.style.top = toppoint;
		document.all.i_emoticon1.style.top = toppoint;
		document.all.i_emoticon2.style.top = toppoint;
		document.all.i_emoticon3.style.top = toppoint;
		document.all.i_emoticon4.style.top = toppoint;
		document.all.i_emoticon5.style.top = toppoint;
		document.all.i_emoticon6.style.top = toppoint;
		document.all.i_emoticon7.style.top = toppoint;
	}
	else
	{
		document.all.item(framename).style.left = leftpoint;
		document.all.item(framename).style.top = toppoint;
	}
	if (document.all.item(framename).style.visibility=="visible")
		document.all.item(framename).style.visibility = "hidden";
	else
		document.all.item(framename).style.visibility = "visible";
	if(framename=="i_image")
	{
		i_image.document.imageform.imageurl.focus();
		i_image.document.imageform.imageurl.select();
	}
	else if(framename=="i_link")
	{
		i_link.document.linkform.linkurl.focus();
		i_link.document.linkform.linkurl.select();
	}
	else if(framename=="i_table")
	{
		i_table.document.tableform.cols.focus();
		i_table.document.tableform.cols.select();
	}
}

function format(what, opt)
{
	if (opt == null)
	{
		EditCtrl.document.execCommand(what);
	}
	else
	{
		EditCtrl.document.execCommand(what,"", opt);
	}
	EditCtrl.focus();
	var du = nowkong.selection.duplicate()
	nowkong.selection.setEndPoint("StartToStart", du);
	nowkong.selection = null;
}

function init()
{
	var tag = "";
	nowkong = new kong();
	var str = "<HEAD><STYLE>P {margin-top:2pxmargin-bottom:2px}</STYLE></HEAD><BODY oncontextmenu='return false' style='background-color:  background-image: url() font-size:10pt font-family:굴림' topmargin=11 leftmargin=11></BODY>";
	EditCtrl.document.designMode = 'on';
	EditCtrl.document.open();
	if (document.boardForm.mode.value=="insert") { EditCtrl.document.write(str); }
	else
	{
		EditCtrl.document.write(str);
		EditCtrl.document.write(document.boardForm.BODY0.value);
		EditCtrl.document.body.style.backgroundColor = document.boardForm.BODYBGC.value;
		EditCtrl.document.body.style.backgroundImage = document.boardForm.BODYBG.value;
	}
	EditCtrl.document.close();

	i_image.document.open();
	tag = tagLink("image");
	i_image.document.write(tag);
	i_image.document.close();

	i_link.document.open();
	tag = tagLink("link");
	i_link.document.write(tag);
	i_link.document.close();

	i_table.document.open();
	tag = tagTable("table");
	i_table.document.write(tag);
	i_table.document.close();

	i_backcolor.document.open();
	tag = tagColor("backcolor");
	i_backcolor.document.write(tag);
	i_backcolor.document.close();

	i_fontcolor.document.open();
	tag = tagColor("forecolor");
	i_fontcolor.document.write(tag);
	i_fontcolor.document.close();

	i_emoticon.document.open();
	tag = tagEmo(0);
	i_emoticon.document.write(tag);
	i_emoticon.document.close();

	EditCtrl.focus();
}

function layeroff()
{
	document.all.i_backcolor.style.visibility='hidden';
	document.all.i_fontcolor.style.visibility='hidden';
	document.all.i_link.style.visibility='hidden';
	document.all.i_image.style.visibility='hidden';
	document.all.i_table.style.visibility='hidden';
	document.all.i_emoticon.style.visibility='hidden';
}

function clickdo(clk, opt, opt1, opt2, opt3, opt4, opt5)
{
	var nowopened=0;

	if(clk=="showmenu")
	{
		if(document.all.item(opt).style.visibility!="hidden") { nowopened = 1; }
	}
	layeroff();
	if(document.boardForm.sourceview.checked)
	{
		alert('소스보기 체크를 해제하고 사용하세요');
		return;
	}
	if(clk=="showmenu")
	{
		if(nowopened==0)
		{
			nowkong.SaveSelection();
			showmenu(opt);
		}
		return;
	}
	else if (clk=="bgimg")
	{
		f_backimage(opt);
		return;
	}
	nowkong.RestoreSelection();
	if(nowkong.selection)
	{
		var aa = nowkong.selection.parentElement();
		if(aa.style.topmargin!="12px") { EditCtrl.focus(); }
	}
	if(clk=="insertimage")
	{
		if(opt!="" && opt!="http://")
		{
			i_image.document.imageform.imageurl.value='http://';
			var iCtrl = EditCtrl.document.selection.createRange();
			iCtrl.pasteHTML("<IMG src='"+opt+"'>");
		}
	}
	else if(clk=="createlink")
	{
		if(opt!="" && opt!="http://")
		{
			i_link.document.linkform.linkurl.value="http://";
			var lCtrl = EditCtrl.document.selection.createRange();
			if(lCtrl.htmlText=="")
			{
				lCtrl.pasteHTML("<A HREF='"+opt+"' target='_blank'>"+opt+"</A>");
			}
			else
			{
				lCtrl.pasteHTML("<A HREF='"+opt+"' target='_blank'>"+lCtrl.htmlText+"</A>");
			}
		}
	}
	else if(clk=="inserttable")
	{
		if(opt!="" && opt1!="")
		{
			var str = "<table border=1 bordercolordark=white bordercolorlight=black width='"+opt2+"' height='"+opt3+"' cellSpacing='"+opt4+"' cellPadding='"+opt5+"' >";
			var lCtrl = EditCtrl.document.selection.createRange();

			for (var i=0; i<opt; i++)
			{
				str = str + "<tr>";
				for(var j=0; j<opt1; j++)
				{
					str = str + "<td></td>";
				}
				str = str + "</tr>";
			}
			lCtrl.pasteHTML(str);
		}
	}
	else if(clk=="backcolor")
	{
		f_backcolor(opt);
		return;
	}
	else if(clk=="htmlinside")
	{
		htmlinside();
		return;
	}
	else if(clk=="hr")
	{
		insert_hr();
		return;
	}
	else
	{
		//원래 10,11번도 그냥 format 불렀었다
		format(clk, opt);
	}
	return true;
}

function htmlinside()
{
	var eA = EditCtrl.document.selection.createRange();
	var aa = eA.parentElement();
	if(aa.tagName!="BODY"){ return; }
	eA.pasteHTML(eA.text);
	EditCtrl.focus();
}

function f_backcolor(color)
{
	EditCtrl.document.body.style.backgroundImage = '';
	EditCtrl.document.body.style.backgroundColor = '' + color + '';
}

function f_backimage(img)
{
	EditCtrl.document.body.style.backgroundColor = '';
	EditCtrl.document.body.style.backgroundImage = "url(\"" + img + "\")";
}

function viewact(flag)
{
	layeroff();
	if(flag)
	{
		//소스쓰기
		document.boardForm.BODYBG.value = EditCtrl.document.body.style.backgroundImage;
		document.boardForm.BODYBGC.value = EditCtrl.document.body.style.backgroundColor;
		var tmp = EditCtrl.document.body.innerHTML;
		EditCtrl.document.body.innerText = tmp;
		EditCtrl.document.body.style.backgroundImage = '';
		EditCtrl.document.body.style.backgroundColor = '';
		EditCtrl.focus();
	}
	else
	{
		//html쓰기
		var tmp = EditCtrl.document.body.innerText;
		EditCtrl.document.body.innerHTML = tmp;
		EditCtrl.document.body.style.backgroundImage = document.boardForm.BODYBG.value;
		EditCtrl.document.body.style.backgroundColor = document.boardForm.BODYBGC.value;
		EditCtrl.focus();
	}
}

/* 색깔관련 */
var colortone = new Array(10);
colortone[0] = new Array('#ffffff','#e5e4e4','#d9d8d8','#c0bdbd','#a7a4a4','#8e8a8b','#827e7f','#767173','#5c585a','#000000');
colortone[1] = new Array('#fefcdf','#fef4c4','#feed9b','#fee573','#ffed43','#f6cc0b','#e0b800','#c9a601','#ad8e00','#8c7301');
colortone[2] = new Array('#ffded3','#ffc4b0','#ff9d7d','#ff7a4e','#ff6600','#e95d00','#d15502','#ba4b01','#a44201','#8d3901');
colortone[3] = new Array('#ffd2d0','#ffbab7','#fe9a95','#ff7a73','#ff483f','#fe2419','#f10b00','#d40a00','#940000','#6d201b');
colortone[4] = new Array('#ffdaed','#ffb7dc','#ffa1d1','#ff84c3','#ff57ac','#fd1289','#ec0078','#d6006d','#bb005f','#9b014f');
colortone[5] = new Array('#fcd6fe','#fbbcff','#f9a1fe','#f784fe','#f564fe','#f546ff','#f328ff','#d801e5','#c001cb','#8f0197');
colortone[6] = new Array('#e2f0fe','#c7e2fe','#add5fe','#92c7fe','#6eb5ff','#48a2ff','#2690fe','#0162f4','#013add','#0021b0');
colortone[7] = new Array('#d3fdff','#acfafd','#7cfaff','#4af7fe','#1de6fe','#01deff','#00cdec','#01b6de','#00a0c2','#0084a0');
colortone[8] = new Array('#edffcf','#dffeaa','#d1fd88','#befa5a','#a8f32a','#8fd80a','#79c101','#3fa701','#307f00','#156200');
colortone[9] = new Array('#d4c89f','#daad88','#c49578','#c2877e','#ac8295','#c0a5c4','#969ac2','#92b7d7','#80adaf','#9ca53b');

/* 이모티콘관련 */
var emotigroupnum=8;
var emotigroupname = new Array(8);
var emotiname = new Array(8);
var emotiurl = new Array(8);

emotigroupname[0] = '표정';
emotiname[0] = new Array('스마일', '반짝반짝', '메롱', '쿨쿨', '조용', '열받음2', '하하', '윙크', '엉엉', '주루룩', '땀삐질', '멋적음', '열받음', '웃음', '취함', '황당', '띵함1', '띵함2', '반함', '실망');
emotiurl[0] = new Array(
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s16.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s17.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s18.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s19.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s21.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s20.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s11.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s12.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s13.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s14.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s15.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s6.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s7.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s8.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s9.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s10.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s1.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s2.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s3.gif',
	'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s4.gif');


emotigroupname[1] = '기념일';
emotiname[1] = new Array(
		'생일','크리스마스트리','발렌타인데이','산타마을','선물',
		'루돌프','산타','과자','러브포크','화이트데이',
		'커플링','','','','',
		'','','','','');
emotiurl[1] = new Array(
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s1.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s2.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s3.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s4.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s5.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s6.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s7.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s8.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s9.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s10.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/day_s11.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif');


emotigroupname[2] = '도구';
emotiname[2] = new Array(
		'똥','똥꼬치','폭탄','키스','사랑의막대기',
		'젖병','칼','도끼','뽕망치','우산',
		'핸드폰','돈','날개','','',
		'','','','','');
emotiurl[2] = new Array(
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s1.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s2.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s3.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s4.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s5.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s6.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s7.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s8.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s9.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s10.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s11.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s12.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/jim_s13.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif');


emotigroupname[3] = '캐릭터';
emotiname[3] = new Array(
		'왕','광대','펭괸','alian','여자날나리',
		'남자날나리','여자악마','악마','girl','꽃순이',
		'소년','','','','',
		'','','','','');
emotiurl[3] = new Array(
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s1.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s2.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s3.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s4.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s5.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s6.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s7.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s8.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s9.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s10.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/char_s11.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif');


emotigroupname[4] = '꽃';
emotiname[4] = new Array(
		'튤립','해바라기','카네이션','은방울','장미꽃다발',
		'꽃다발','꽃다발2','꽃','단풍잎','화분',
		'화분2','','','','',
		'','','','','');
emotiurl[4] = new Array(
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s1.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s2.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s3.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s4.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s5.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s6.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s7.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s8.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s9.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s10.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/flower_s11.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif');


emotigroupname[5] = '음식';
emotiname[5] = new Array(
		'쥬스','커피','피자','햄버거','김밥',
		'맥주','사탕','우유','짜장면','아이스크림',
		'','','','','',
		'','','','','');
emotiurl[5] = new Array(
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s1.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s2.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s3.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s4.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s5.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s6.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s7.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s8.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s9.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/food_s10.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif');


emotigroupname[6] = '행동';
emotiname[6] = new Array(
		'방구','설명중','아양','잠','잠수중',
		'잠수중2','잠수중3','퍽','화장실1','화장실2',
		'당근','우웩','','','',
		'','','','','');
emotiurl[6] = new Array(
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s1.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s2.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s3.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s4.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s5.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s6.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s7.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s8.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s9.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/action_s10.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/carrot_s.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/face_s5.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif');


emotigroupname[7] = '문장';
emotiname[7] = new Array(
		'방가','안녕','안녕2','hi','hi2',
		'bye','bye2','love','사랑해','깨물어주고싶어',
		'','','','','',
		'','','','','');
emotiurl[7] = new Array(
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s1.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s2.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s3.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s4.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s5.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s6.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s7.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s8.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s9.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/emot/say_s10.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',

		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
		'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif',
'http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif');


function emotishow(i)
{
	i_emoticon.document.open();
	tag = tagEmo(i);
	i_emoticon.document.write(tag);
	i_emoticon.document.close();
}

function tagEmo(n)
{
	var str = "";
	str = str + "<html><body marginwidth=0 marginheight=0 topmargin=0 leftmargin=0 bgcolor='#efefef'><table>";
	if(n <=0)
	{
		str = str + " <tr> <td colspan=5> <table border=0 cellpadding=2 cellspacing=0 width=100% bgcolor=#e6e6e6> <tr> <td align=center width=15 nowrap><a href=\"javascript:parent.emotishow(" + (emotigroupnum-1) + ");\"><img src='http://image.hanmail.net/hanmail/s_img/messenger2/web/bs_back.gif' width=13 height=13 border=0></a></td> <td width=100% style=\"font-size:9pt\" align=center>" + emotigroupname[n] + "</td> <td align=center width=15 nowrap><a href=\"javascript:parent.emotishow(" + (n+1) + ");\"><img src='http://image.hanmail.net/hanmail/s_img/messenger2/web/bs_next.gif' width=13 height=13 border=0'></a></td> </tr> </table> </td> </tr>";
	}
	else if(n >= emotigroupnum-1)
	{
		str = str + " <tr> <td colspan=5> <table border=0 cellpadding=2 cellspacing=0 width=100% bgcolor=#e6e6e6> <tr> <td align=center width=15 nowrap><a href=\"javascript:parent.emotishow(" + (n-1) + ");\"><img src='http://image.hanmail.net/hanmail/s_img/messenger2/web/bs_back.gif' width=13 height=13 border=0 alt='" + emotigroupname[n-1] + "'></a></td> <td width=100% style=\"font-size:9pt\" align=center>" + emotigroupname[n] + "</td> <td align=center width=15 nowrap><a href=\"javascript:parent.emotishow(0);\"><img src='http://image.hanmail.net/hanmail/s_img/messenger2/web/bs_next.gif' width=13 height=13 border=0'></a></td> </tr> </table> </td> </tr>";
	}
	else
	{
		str = str + " <tr> <td colspan=5> <table border=0 cellpadding=2 cellspacing=0 width=100% bgcolor=#e6e6e6> <tr> <td align=center width=15 nowrap><a href=\"javascript:parent.emotishow(" + (n-1) + ");\"><img src='http://image.hanmail.net/hanmail/s_img/messenger2/web/bs_back.gif' width=13 height=13 border=0 alt='" + emotigroupname[n-1] + "'></a></td> <td width=100% style=\"font-size:9pt\" align=center>" + emotigroupname[n] + "</td> <td align=center width=15 nowrap><a href=\"javascript:parent.emotishow(" + (n+1) + ");\"><img src='http://image.hanmail.net/hanmail/s_img/messenger2/web/bs_next.gif' width=13 height=13 border=0 alt='" + emotigroupname[n+1] + "'></a></td> </tr> </table> </td> </tr>";
	}
	for (var i=0; i<4; i++)
	{
		str = str + "<tr>";
		for (var j=0; j<5; j++)
		{
			if (emotiurl[n][i*5+j]=="http://image.hanmail.net/hanmail/s_img/messenger2/web/shaded.gif")
			{
				str = str + "<td width=24 height=24 align=center bgcolor=#ffffff><img src=\"" + emotiurl[n][i*5+j] + "\" width=20 height=20 border=0><br></td>";
			}
			else
			{
				str = str + "<td onMouseOver=\"this.style.backgroundColor='#00107b';\" onMouseOut=\"this.style.backgroundColor='#ffffff';\" width=24 height=24 align=center bgcolor=#ffffff><a onclick=\"parent.clickdo('insertimage', '" + emotiurl[n][i*5+j] + "');\" onfocus='this.blur()'><img src=\"" + emotiurl[n][i*5+j] + "\" width=20 height=20 alt=\"" + emotiname[n][i*5+j] + "\" border=0></a><br></td>";
			}
		}
		str = str + "</tr>";
	}
	str = str + "</table></body></html>";
	return str;
}

function tagColor(flag)
{
//	flag == "forecolor" -> 폰트 색
//	flag == "backcolor" -> 배경 색

	var str = "";
	str = str + "<html><body marginwidth=0 marginheight=0 topmargin=0 leftmargin=0>";
	str = str + "<table cellpadding=0 cellspacing=0 border=0>";

	for (var i=0; i<10; i++)
	{
		str = str + "<tr>";
		for(var j=0; j<10; j++)
		{
			str = str + "<td onmouseover=this.style.backgroundColor='blue' onmouseout=this.style.backgroundColor=''><table cellpadding=0 cellspacing=1 border=0><tr><td bgcolor='" + colortone[i][j] + "' style='cursor:hand' onclick='parent.clickdo(\"" + flag + "\", \"" + colortone[i][j] + "\");' width=10 height=10></td></tr></table></td>";
		}
		str = str + "</tr>";
	}
	return str;
}

function tagLink(flag)
{
	var str = "";
	str = str + "<html><head><style> td { font-size:10pt; color:#000000; font-family:굴림; } .base { font-size:9pt; color:#000000; font-family:굴림; } </style></head><body marginwidth=0 marginheight=0 topmargin=10 leftmargin=5 bgcolor='#efefef'>";
	if(flag=="link")
	{
		str = str + "<font class=base>&nbsp;선택된 부분에 걸릴 링크 주소(url)을 넣어주세요<br>&nbsp;&nbsp;(예: http://www.ictedu.net) - \"http://\" 꼭 써야함</font><br> <table><tr><form name=linkform onsubmit='parent.clickdo(\"createlink\", document.linkform.linkurl.value); return false;'><td> <input type='text' name='linkurl' value='http://' size=29> <img src='http://image.hanmail.net/function/button01.gif' onclick='parent.clickdo(\"createlink\", document.linkform.linkurl.value);' border=0 align=absmiddle><img src='http://image.hanmail.net/hanmail/general/b_cancel.gif' onclick='parent.clickdo(\"unlink\"); parent.layeroff();' border=0 align=absmiddle></td></form></tr></table></body></html>";
	}
	else if (flag=="image")
	{
		str = str + "<font class=base>&nbsp;인터넷에 올려진 이미지만 삽입이 가능합니다.<br>&nbsp;삽입할 이미지 주소(url)을 넣어주세요<br>&nbsp;&nbsp;(예: http://daum.net/a.jpg) - \"http://\" 꼭 써야함</font><br> <table><tr><form name=imageform onsubmit='parent.clickdo(\"insertimage\", document.imageform.imageurl.value); return false;'><td> <input type='text' name='imageurl' value='http://' size=29'> <img src='http://image.hanmail.net/function/button01.gif' onclick='parent.clickdo(\"insertimage\", document.imageform.imageurl.value);' border=0 align=absmiddle><img src='http://image.hanmail.net/hanmail/general/b_cancel.gif' onclick='parent.layeroff();' border=0 align=absmiddle></td></form></tr></table></body></html>";
	}
	return str;
}

function tagTable(flag)
{
	var str = "";
	str = str + "<html><head><style> td { font-size:10pt; color:#000000; font-family:굴림; } .base { font-size:9pt; color:#000000; font-family:굴림; } </style></head><body marginwidth=0 marginheight=0 topmargin=10 leftmargin=5 bgcolor='#efefef'>";
//	if(flag=="link")
//	{
		str = str + "<font class=base>&nbsp;테이블을 생성합니다<br></font><table><tr><form name=tableform onsubmit='parent.clickdo(\"createlink\", document.linkform.linkurl.value); return false;'><td>행 : <input type='text' name='cols' value='2' size=2> 열: <input type='text' name='rows' value='2' size=2><br>길이 : <input type='text' name='width' value='100%' size=2> 높이 : <input type='text' name='height' value='' size=2><br>	셀간격: <input type='text' name='cellspacing' value='0' size=1> 글간격: <input type='text' name='cellpadding' value='1' size=1><br><img src='http://image.hanmail.net/function/button01.gif' onclick='parent.clickdo(\"inserttable\", document.tableform.cols.value,  document.tableform.rows.value, document.tableform.width.value, document.tableform.height.value, document.tableform.cellspacing.value, document.tableform.cellpadding.value);' border=0 align=absmiddle> <img src='http://image.hanmail.net/hanmail/general/b_cancel.gif' onclick='parent.clickdo(\"unlink\"); parent.layeroff();' border=0 align=absmiddle></td></form></tr></table></body></html>";
//	}
	return str;
}

function gotext()
{
	if (EditCtrl.document.body.innerHTML != EditCtrl.document.body.innerText)
	{
		var conf = confirm("html효과들은 사라집니다. 계속하겠습니까?");
		if(!conf) { return; }
	}
	var str = EditCtrl.document.body.innerText;
	document.gocomp0.BODY.value= str.replace(/&lt;?/g, '<').replace(/&gt;?/g, '>').replace(/&quot;?/g, '"').replace(/&amp;?/g, '&');
	document.gocomp0.TO.value=document.boardForm.TO.value;
	document.gocomp0.CC.value=document.boardForm.CC.value;
	document.gocomp0.BCC.value=document.boardForm.BCC.value;
	document.gocomp0.SUBJECT.value=document.boardForm.SUBJECT.value;
	document.gocomp0.submit();
}

function checksourceview()
{
	document.boardForm.sourceview.checked = !document.boardForm.sourceview.checked;
}

function enterchk(flag, keycode, val)
{
	if (keycode==13)
	{
		if(flag == "L")
		{
			clickdo('createlink', val);
		}
		else if(flag == "I")
		{
			clickdo('insertimage', val);
		}
	}
}

function insert_hr()
{
	var str = "";
	str = "<hr>";
	var iCtrl = EditCtrl.document.selection.createRange();
	iCtrl.pasteHTML(str);
}
