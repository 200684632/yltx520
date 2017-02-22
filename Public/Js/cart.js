$(function () {
	$('.del').click(function () {
		confirm('您确实要把该商品移出购物车吗？')
	});
	$('input[name=goods_number]').blur(function () {
		var a = $(this).val();
		var num = $(this).next().val();
		var obj = $(this);
		$.ajax({
			'url' : URL,
			'type' : 'post',
			'dataType' : 'json',
			'data' : {'number' : num , 'num' : a},
			'success' : function (data) {
				obj.parent().next().html('￥'+ data.price);
				$('#totalAmount').html(data.gross);
			}
			
		});

	});
});