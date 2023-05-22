$(document).ready(() => {

	Inputmask({mask:"A{5,26}","placeholder":""}).mask('input[name="surname"]');
	Inputmask({mask:"A{2,16}","placeholder":""}).mask('input[name="name"]');
	Inputmask({mask:"A{6,26}","placeholder":""}).mask('input[name="patronymic"]');
	Inputmask({regex:"[a-zA-Z0-9@$\.]{5,20}","placeholder":""}).mask('input[name="login"]');
	Inputmask({regex:"[a-zA-Z0-9@$\.]{6,20}","placeholder":""}).mask('input[name="password"]');
	Inputmask({regex:"[a-zA-Z0-9@$\.]{6,20}","placeholder":""}).mask('input[name="password_repeat"]');

	$("form#registration").validate({
		rules: {
			surname: {required: true, minlength: 6},
			name: {required: true, minlength: 2},
			patronymic: {required: true, minlength: 6},
			login: {required: true, minlength: 5, remote: {type:'GET', url: apip+'/users/check_login.php'}},
			email: {required: true, email: true, remote: {type:'GET', url: apip+'/users/check_email.php'}},
			password: {required: true, minlength: 6},
			password_repeat: {required: true, equalTo: "#password"},
			rules: {required: true},
		},
		messages: {
			surname: {
				required: "Введите Фамилию", minlength: jQuery.validator.format("Фамилия должна содержать не меньше {0} букв")
			},
			name: {
				required: "Введите Имя", minlength: jQuery.validator.format("Имя должно содержать не меньше {0} букв")
			},
			patronymic: {
				required: "Введите Отчество", minlength: jQuery.validator.format("Отчество должно содержать не меньше {0} букв")
			},
			login: {
				required: "Введите Логин", minlength: jQuery.validator.format("Логин должен содержать не меньше {0} символов"),
				remote: "Этот Логин уже занят"
			},
			email: {
				required: "Введите Почту", email: "Введите верную электронную Почту",
				remote: "Эта Почта уже используется"
			},
			password: {
				required: "Введите Пароль",
				minlength: jQuery.validator.format("Пароль должен содержать не меньше {0} символов")
			},
			password_repeat: {
				required: "Введите Пароль повторно",
				equalTo: "Пароли не совпадают"
			},
			rules: {
				required: "Необходимо соглашение"
			},
		},
		submitHandler: function(form, e) {
			e.preventDefault();
			post(new FormData(form), apip + '/users/registration.php', function(data) {
				if (data.res_status) {
					window.location.reload();
				} else {
					$('.form-info').html(`<label class="error" for="${data.res_error_field}"> ${data.res_message} </label>`);
				}
			})
		},
	});
})
