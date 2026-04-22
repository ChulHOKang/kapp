var $grid;
$(function(){
	$(window).on("load resize",function(){
		visualHeight();
		$('#videoBg').vide({'mp4': '../include/videoMeta/asdM'});
//		$('#videoBg').vide({'mp4': '../include/video/asd'});
	});

	$(".visualSlide ").slick({
		dots: true, slidesToShow: 1,slidesToScroll: 1, autoplay:true ,autoplaySpeed: 6000,pauseOnHover : false
	});

	$("body").on("click",".radioLabel",function(){
		$(".radioLabel").removeClass("on");
		$(this).addClass("on");
	});

	$("body").on("click",".btn_projectMore",function(){
		var gridItem = '<div class="element-item maketing" data-category="maketing">';
		gridItem += '<a href="javascript:void(0)">';
		gridItem += '<span class="img"><img src="../include/img/etc/etc_project01.png" /></span>';
		gridItem += '<span class="subj">(주)모두모아 marketing</span>';
		gridItem += '<span class="txt">소상공인 앱인앱, AI 라이브커머스, 지문 인식 승선 시스템 </span>';
		gridItem += '</a>';
		gridItem += '</div>';
		for(var i = 0; i<3;i++){
			$(".grid").append(gridItem);
		}
		$('.grid').isotope('destroy');
		$('.grid').isotope({
			itemSelector: '.element-item',
			layoutMode: 'fitRows'
		});
	});

	if($(".grid").length){
		$grid = $('.grid').isotope({
			itemSelector: '.element-item',
			layoutMode: 'fitRows'
		});
	}

	$("body").on("click",".listTabs a",function(){
		var filterValue = $( this ).attr('data-filter');
	    $grid.isotope({ filter: filterValue });
		$(".listTabs a").removeClass("on");
		$(this).addClass("on");
	});

	$("body").on("click",".listTabs01 a",function(){
		$(".listTabs01 a").removeClass("on");
		$(this).addClass("on");
	});

	$(window).on("scroll", common.headerFixed);

	$("body").on("click",".btnService",function(){
		var ck = $(this).hasClass("on");
		if(ck){
			$(this).removeClass("on");
			$(".serviceLayer").hide();
		}else{
			$(this).addClass("on");
			$(".serviceLayer").show();
		}
	});

	$("body").on("click",".project_request .close",function(){ // $(".project_area").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad');
		$(".project_area").stop().animate({"right":"-1100px"}, 200, 'easeOutQuad');
	});
	$("body").on("click",".lnbFooter a.lnbIcon03",function(){
		$(".project_area").stop().animate({"right":"-20px"}, 200, 'easeOutQuad');
		$(".loginBox").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad');
	});

	$("body").on("click",".loginClose",function(){
		$(".loginBox").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad');
	});
	$("body").on("click",".lnbFooter a.lnbIcon01",function(){ //$(".project_area").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad');
		$(".loginBox").stop().animate({"right":"0"}, 200, 'easeOutQuad');
		$(".project_area").stop().animate({"right":"-1100px"}, 200, 'easeOutQuad');
	});

});
function visualHeight(){
	var h = window.innerHeight;
	var w = window.innerWidth;
	$(".visualSlide .item, #videoBg").css("height", h+"px");
	$(".visualSlide .item, #videoBg").css("width", w+"px");
}





common = {
	etcEvt:function(){
		$("body").on("click",".btnService",function(){
			var ck = $(this).hasClass("on");
			if(ck){
				$(this).removeClass("on");
				$(".serviceLayer").hide();
			}else{
				$(this).addClass("on");
				$(".serviceLayer").show();
			}
		});

	},
	openProj01:function(){
		$(".dialog").stop().fadeIn(200, 'easeOutQuad');
		$(".lnbArea").delay(200).stop().animate({"right":"0"}, 200, 'easeOutQuad');
		$(".project_area").delay(200).stop().animate({"right":"-20px"}, 200, 'easeOutQuad');
	},
	lnbOpen:function(){
		$(".dialog").stop().fadeIn(200, 'easeOutQuad');
		$(".lnbArea").delay(200).stop().animate({"right":"0"}, 200, 'easeOutQuad');
	},
	lnbClose:function(){ // $(".project_area").stop().animate({"right":"-1000px"}, 200, 'easeOutQuad', function(){
		$(".project_area").stop().animate({"right":"-1100px"}, 200, 'easeOutQuad', function(){
			$(".lnbArea").stop().animate({"right":"-300px"}, 200, 'easeOutQuad');
		});
		$(".dialog").delay(200).stop().fadeOut(200, 'easeOutQuad');
	},
	headerFixed:function(){
		var h = window.innerHeight;
		var st = $(window).scrollTop();
		if (st < h){
			$(".header").removeClass("on");
		}else{
			$(".header").addClass("on");
		}
	},


	// popOpen:function(o){
	// 	$(o).show();
	// },
	// popClose:function(o){
	// 	$(o).hide();
	// }



}

$('.ftr_project').click(function(){
	$(".lnbArea").delay(200).stop().animate({"right":"0"}, 200, 'easeOutQuad');
})
