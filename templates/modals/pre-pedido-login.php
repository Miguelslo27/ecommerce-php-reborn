	<style>
		.modal#pre-pedido-login {
			width: 400px;
			margin-left: -200px;
			top: 100px;
			padding-bottom: 15px;
		}
		.modal#pre-pedido-login .modal-close {
			right: 17px;
    		top: 10px;
		}
		.modal#pre-pedido-login .modal-title h2 {
			font-size: 20px;
			color: #333;
		}
		.modal#pre-pedido-login .form-line {
			margin-bottom: 15px;
		}
		.modal#pre-pedido-login form {
			display: none;
			padding: 8px;
			margin: 0;
		}
		.modal#pre-pedido-login #pre-pedido-continuar {
			margin-right: 10px;
		}
		.modal#pre-pedido-login #clave-olvidada {
			display: none;
		}
		.modal#pre-pedido-login form .form-line.form-commands {
			position: relative;
		}
		.modal#pre-pedido-login form .form-line.form-commands {
			text-align: left;
		}
	</style>
	<div class="modal" id="pre-pedido-login">
		<div class="modal-title">
			<h2>Ingreso para completar tu pedido</h2>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
			<span class="line-h">&nbsp;</span>
		</div>
		<div class="modal-content cols cols-1">
			<div class="modal-col modal-col-span1 first-col last-col">
				<div class="modal-col-inner">
					<div class="form-line">
						<label class="label">
							<input type="radio" name="pre-pedido-opcion" id="registrar_nuevo_usuario"> Registrarme como nuevo cliente
						</label>
					</div>
					<div class="form-line">
						<label class="label">
							<input type="radio" name="pre-pedido-opcion" id="usuario_registrado"> Soy un cliente registrado
						</label>
					</div>
					<form action="/login/" method="POST" id="pre-orden-login-form">
						<div class="form-line">
							<label for="email">E-Mail</label>
							<input type="text" class="input" id="email" name="email">
						</div>
						<div class="form-line">
							<label for="pass">Contraseña</label>
							<input type="password" class="input" id="pass" name="pass">
						</div>
						<div class="form-line">
							<label class="allsize" for="rememberme">
								<input type="checkbox" id="rememberme" name="rememberme" checked="true">
								Recúerdame en este equipo
							</label>
						</div>
					</form>
					<div class="form-line">
						<a href="#" class="btn btn-style black" id="pre-pedido-continuar">Continuar</a>
						<a href="/recuperar-clave/" id="clave-olvidada">¿Has olvidado tu contraseña?</a>
					</div>
				</div>
			</div>
		</div>
	</div>