<?php

	if (isset($post["registration"])) {
		$password_hash = password_hash($post["password"], PASSWORD_BCRYPT);
		$query =
		"INSERT INTO `users`
		(`user_surnme`, `user_name`, `user_patronymic`, `login`, `email`, `password`)
		('$post[surname]', '$post[name]', '$post[patronymic]', '$post[login]'), '$post[email]', '$password_hash'
		";
		$result = mysqli_query($connection, $query);

		if ($result) {
			header('Location: /login.php');
			exit(0);
		}
	}

?>


<section class="wrapper flex flex-col grow items-center justify-center gap-4">

	<div class="container content-container">
		<h2 class="text-lg max-w-[600px] mx-auto">Регистрация</h2>
	</div>

	<div class="container content-container">
		<form action="" method="post" id="registration_form" class="max-w-[600px] mx-auto">
			<fieldset class="flex flex-col gap-6">

				<div class="flex flex-col gap-2">
					<label for="surname">Фамилия</label>
					<input type="text" name="surname" id="surname" required />
				</div>
				<div class="flex flex-col gap-2">
					<label for="name">Имя</label>
					<input type="text" name="name" id="name" required />
				</div>
				<div class="flex flex-col gap-2">
					<label for="patronymic">Отчество</label>
					<input type="text" name="patronymic" id="patronymic" required />
				</div>
				<div class="flex flex-col gap-2">
					<label for="login">Логин</label>
					<input type="text" name="login" id="login" required />
				</div>
				<div class="flex flex-col gap-2">
					<label for="email">Почта</label>
					<input type="email" name="email" id="email" required />
				</div>
				<div class="flex flex-col gap-2">
					<label for="password">Пароль</label>
					<input type="password" name="password" id="password" required />
				</div>
				<div class="flex flex-col gap-2">
					<label for="password_repeat">Повторите пароль</label>
					<input type="password" name="password_repeat" id="password_repeat" required />
				</div>
				<div class="flex gap-2">
					<input type="checkbox" name="rules" id="rules" required />
					<label for="rules">Согласие с правилами</label>
				</div>

				<button name="registration_form" type="submit">Регистрация</button>
			</fieldset>
			<div class="form-info"></div>
		</form>
	</div>

</section>