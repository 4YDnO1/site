<section class="wrapper flex flex-col grow items-center justify-center gap-4">

	<div class="container content-container max-w-[600px]">
		<h2 class="text-lg">Вход</h2>
	</div>

	<div class="container content-container max-w-[600px]">
		<form action="" method="post" id="auth">
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