$(function () {
	$('#imgscroll ul li:eq(0)').find('img').addClass('hover');
	$('.mini_img').click(function () {
	$(this).addClass('hover').parent().parent('li').siblings().find('img').removeClass('hover');
	$('#medium').attr('src', $(this).attr('medium'));
	$('#right_pic').attr('src', $(this).attr('max'));
	});
	$('li .moreNum_Size a:first-child').addClass('cur yangshi');
	$(document).ready(function() {
		$(this).addClass('cur').siblings().removeClass('cur');
		var obj = $('.moreNum_Size');
		var specLen = obj.length;
		var spec = [];
		for (var i = 0; i < specLen; i++) {
			if (obj.eq(i).find('.cur').length > 0) {
				spec[i] = obj.eq(i).find('.cur').attr('aid');
			}
		}
		if (spec.length == specLen) {
			var gid = $('input[name=gid]').val();
			$.ajax({
				'url' : getPrice,
				'type' : 'post',
				'dataType' : 'json',
				'data' : {'gid' : gid, 'spec' : spec},
				'success' : function (data) {
					$('.moreMoney_NR').html(data.number);
					$('.price').html('￥' + data.price);
					$('#shows_number').html('(库存'+data.inventory+'件)');
				}

			});
		}
	})
	// 选择购买规格
	$('.moreNum_Size a').click(function () {
		$(this).addClass('cur').siblings().removeClass('cur');
		var obj = $('.moreNum_Size');
		var specLen = obj.length;
		var spec = [];
		for (var i = 0; i < specLen; i++) {
			if (obj.eq(i).find('.cur').length > 0) {
				spec[i] = obj.eq(i).find('.cur').attr('aid');
			}
		}
		if (spec.length == specLen) {
			var gid = $('input[name=gid]').val();
			$.ajax({
				'url' : getPrice,
				'type' : 'post',
				'dataType' : 'json',
				'data' : {'gid' : gid, 'spec' : spec},
				'success' : function (data) {
					$('.moreMoney_NR').html(data.number);
					$('.price').html('￥' + data.price);
					$('#shows_number').html('(库存'+data.inventory+'件)');
				}

			});
		}
	});
	//加入购物车
	$('#cart').click(function () {
		var obj = $('.moreNum_Size');
		var specLen = obj.length;
		var spec = [];
		for (var i = 0; i < specLen; i++) {
			if (obj.eq(i).find('.cur').length > 0) {
				spec[i] = obj.eq(i).find('.cur').attr('aid');
			}
		}
		if (spec.length != specLen) {
			alert('请选择购买规格');
			return false;
		}

		var gid = $('input[name=gid]').val();
		var number = $('input[name=number]').val();
		// 异步加入购物车
		$.ajax({
			'url' : URL,
			'type' : 'post',
			'data' : {'gid' : gid, 'spec' : spec,'num' : number},
			'dataType' : 'json',
			'success' : function (data)
			{
				
			}
		});
		return false;
	});

	$('#cart').click(function () {
		$('#good_Car').show();
	});
	$('.good_Car_topCOlose').click(function () {
		$('#good_Car').hide();
	});
})