<section class="wrapper flex flex-col grow items-center justify-center gap-4">

	<div class="container content-container">
		<h2 class="text-lg max-w-[600px] mx-auto">Вход</h2>
	</div>

	<div class="container content-container">
		<form action="" method="post" id="auth" class="max-w-[600px] mx-auto">
			<fieldset class="flex flex-col gap-6">

				<div class="flex flex-col gap-2">
					<label for="login">Логин</label>
					<input type="text" name="login" id="login" required />
				</div>
				<div class="flex flex-col gap-2">
					<label for="password">Пароль</label>
					<input type="password" name="password" id="password" required/>
				</div>
				<button name="auth" type="submit">Войти</button>
			</fieldset>
			<div class="form-info"></div>
		</form>
	</div>

</section>