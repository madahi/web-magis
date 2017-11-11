<form method="post" action="">
	<input name="nonce_custom_form" value="magis_user_signin" type="hidden"/>

	<div class="input-group">
		<input name="user-name" type="text" placeholder="Usuario" required/>
		<label class="input-label" for="user-name">Nombre de usuario o dirección de correo electrónico</label>
		<span class="input-description">Nombre de usuario o dirección de correo electrónico</span>
	</div>

	<div class="input-group">
		<input name="user-pwd" type="password" placeholder="Contraseña" required/>
		<label class="input-label" for="user-pwd">Contraseña</label>
		<span class="input-description">Introduzca su contraseña</span>
	</div>

	<?php if(!empty($user_error)) { ?>
			<div><?php echo $user_error; ?></div>
	<?php } ?>

	<div>
		<input type='submit' value='Iniciar'/>
	</div>
</form>