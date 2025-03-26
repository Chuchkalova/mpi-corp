<form method="post" id="login_form" action="<?= site_url('login/send/'); ?>">
	<h3 class='bold'>Авторизация</h3>
	<input type="text" name="login" id="login_login" required class="change" placeholder="Имя пользователя" maxlength="30">
	<input type="password" name="password" id="pass_login" required placeholder="Пароль">
	<div id="bottom_login">
		<p class="submit">
			<input type="submit" id="enter_form" value="Войти">
		</p>
	</div>
</form>