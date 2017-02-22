$(function () {
	$('.nav_fenlei').mousemove(function () {
		$('#Index_fenlei').show();

		$('#Index_fenlei').mouseleave(function () {
		$('#Index_fenlei').hide();
	})
	})
	

	//放大镜
	$('#wrap').mousemove(function () {
		$('.move_div').show();
		$('.move_right').show();
	}).mouseout(function () {
		$('.move_div').hide();
		$('.move_right').hide();
	})
	$('#wrap').mousemove(function(e){
		var m_left = e.pageX;//获得鼠标距离页面左侧的距离
		var m_top = e.pageY;
		var div_left = $('#wrap').offset().left;//获得元素距离页面左侧的距离
		var div_top = $('#wrap').offset().top;
		var left = m_left - div_left-100;//获得滑块的left值
		var top = m_top - div_top -100;
		if(left<0){
			left = 0;
		}
		if(left>200){
			left = 200;
		}
		if(top<0){
			top=0;
		}
		if(top>200){
			top=200;
		}
		$('.move_div').css({'left':left+'px','top':top+'px'});

		//控制右侧大图的位置
		var right_left = -1.8*left;
		var right_top = -1.8*top;
		$('#right_pic').css({'left':right_left+'px','top':right_top+'px'})

	})

	//型号选择
	$('.moreNum_Size a').click(function () {
		$(this).addClass('yangshi').siblings().removeClass('yangshi');
	})

	//导航背景变色
	$('#Index_fenlei .fenlei li').mousemove(function() {
		$(this).addClass('bianse').siblings('li').removeClass('bianse');
	}).mouseout(function () {
		$(this).removeClass('bianse');
	});

	// 列表切换结束
	$('.search_text').focus(function () {
		$(this).val('');
	});
})