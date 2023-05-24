$(document).ready(() => {

	Inputmask({regex:"[a-zA-Z0-9@$\.]{5,20}","placeholder":""}).mask('input[name="login"]');
	Inputmask({regex:"[a-zA-Z0-9@$\.]{6,20}","placeholder":""}).mask('input[name="password"]');

	$("form#auth").validate({
		rules: {
			login: {required: true, minlength: 5, remote: {type:'GET', url: apip+'/users/user_check_login_exist.php'}},
			password: {required: true, minlength: 6},
		},
		messages: {
			login: {
				required: "Введите Логин", minlength: jQuery.validator.format("Логин должен содержать не меньше {0} символов"),
				remote: "Такого Логина не существет"
			},
			password: {
				required: "Введите Пароль",
				minlength: jQuery.validator.format("Пароль должен содержать не меньше {0} символов")
			},
		},
		submitHandler: function(form, e) {
			e.preventDefault();
			post(new FormData(form), apip + '/users/user_login.php', function(data) {
				if (data.status) {
					window.location.reload();
				} else {
					$('.form-info').html(`<label class="error" for="${data.error_field}"> ${data.message} </label>`);
				}
			})
		},
	});
})
