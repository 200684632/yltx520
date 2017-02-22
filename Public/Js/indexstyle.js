$(function(){

	$(".main_visual").hover(function(){
		$("#btn_prev,#btn_next").fadeIn()
	},function(){
		$("#btn_prev,#btn_next").fadeOut()
	});
	
	$dragBln = false;
	
	$(".main_image").touchSlider({
		flexible : true,
		speed : 200,
		btn_prev : $("#btn_prev"),
		btn_next : $("#btn_next"),
		paging : $(".flicking_con a"),
		counter : function (e){
			$(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
		}
	});
	
	$(".main_image").bind("mousedown", function() {
		$dragBln = false;
	});
	
	$(".main_image").bind("dragstart", function() {
		$dragBln = true;
	});
	
	$(".main_image a").click(function(){
		if($dragBln) {
			return false;
		}
	});
	
	timer = setInterval(function(){
		$("#btn_next").click();
	}, 5000);
	
	$(".main_visual").hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			$("#btn_next").click();
		},5000);
	});
	
	$(".main_image").bind("touchstart",function(){
		clearInterval(timer);
	}).bind("touchend", function(){
		timer = setInterval(function(){
			$("#btn_next").click();
		}, 5000);
	});


	// 左边的小轮播

	$(".meet_image1").touchSlider({
		flexible : true,
		speed : 200,
		btn_prev : $("#btn_prev1"),
		btn_next : $("#btn_next1"),
		paging : $(".flicking_con1 a"),
		counter : function (e){
			$(".flicking_con1 a").removeClass("on").eq(e.current-1).addClass("on");
		}
	});
	$(".meet_image1").bind("mousedown", function() {
		$dragBln = false;
	});
	
	$(".meet_image1").bind("dragstart", function() {
		$dragBln = true;
	});
	
	$(".meet_image1 a").click(function(){
		if($dragBln) {
			return false;
		}
	});
	timer = setInterval(function(){
		$("#btn_next1").click();
	}, 5000);
	
	$(".meet_image1").hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			$("#btn_next1").click();
		},5000);
	});
	
	$(".meet_image1").bind("touchstart",function(){
		clearInterval(timer);
	}).bind("touchend", function(){
		timer = setInterval(function(){
			$("#btn_next1").click();
		}, 5000);
	});


	// 下边

$(".meet_image2").touchSlider({
		flexible : true,
		speed : 200,
		btn_prev : $("#btn_prev2"),
		btn_next : $("#btn_next2"),
		paging : $(".flicking_con2 a"),
		counter : function (e){
			$(".flicking_con2 a").removeClass("on").eq(e.current-1).addClass("on");
		}
	});
	$(".meet_image2").bind("mousedown", function() {
		$dragBln = false;
	});
	
	$(".meet_image2").bind("dragstart", function() {
		$dragBln = true;
	});
	
	$(".meet_image2 a").click(function(){
		if($dragBln) {
			return false;
		}
	});
	timer = setInterval(function(){
		$("#btn_next2").click();
	}, 5000);
	
	$(".meet_image2").hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			$("#btn_next2").click();
		},5000);
	});
	
	$(".meet_image2").bind("touchstart",function(){
		clearInterval(timer);
	}).bind("touchend", function(){
		timer = setInterval(function(){
			$("#btn_next2").click();
		}, 5000);
	});



});