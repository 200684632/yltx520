$(function () {
	$('input[name=submit]').click(function () {
		var aa = $('input[name=agreement]').attr('checked');
		$('#email').blur(function() {});
		$('#username').blur(function() {});
		$('#account').blur(function() {});
		$('#password').blur(function() {});
		$('#pwded').blur(function() {});
		if (!aa) {
			return false;
		}
	});
	//邮箱验证
	$('#email').blur(function() {
		var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(!myreg.test($('#email').val())) {
            $('#email').next().find('span').show().siblings().hide();
            $('#email').focus();
            return false;
        } else {
        	$('#email').next().find('img').show().siblings().hide();
        }
	});
	//昵称验证
	$('#username').blur(function() {
		if ($('#username').val() == '') {
			$('#username').next().find('span').show().siblings().hide();
            $('#username').focus();
            return false;
		} else {
			$('#username').next().find('img').show().siblings().hide();
		}
	});
	//账号验证
	$('#account').blur(function() {
		if (!/^[a-zA-Z][a-zA-Z0-9]{6,15}$/.test($('#account').val())) {
			$('#account').next().find('span').show().siblings().hide();
            $('#account').focus();
            return false;
		} else {
			$('#account').next().find('img').show().siblings().hide();
		}
	});
	//密码验证
	$('#password').blur(function() {
		if (!/^[a-zA-Z0-9]{6,20}$/.test($('#password').val())) {
			$('#password').next().find('span').show().siblings().hide();
            $('#password').focus();
            return false;
		} else {
			$('#password').next().find('img').show().siblings().hide();
		}
	});
	//再次输入密码验证
	$('#pwded').blur(function() {
		if ($('#pwded').val() == "" || $('#password').val() != $('#pwded').val()) {
			$('#pwded').next().find('span').show().siblings().hide();
            $('#pwded').focus();
            return false;
		} else {
			$('#pwded').next().find('img').show().siblings().hide();
		}
	});
	// 注册异步验证
	$('#account').blur(function () {
		var account = $('#account').val();
		$.ajax({
			'url' : URL,
			'type' : 'post',
			'dataType' : 'json',
			'data' : {'account' : account},
			'success' : function (data) {
				if (data.num == 1) {
					$('#account').next().find('img').show();
					return ;
				} else {
					$('#account').next().html('该账号已被注册');
					return ;
				}
			}
		});
	});
});