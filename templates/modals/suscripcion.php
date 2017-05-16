	<style>
		#user-subscripction {
			top: 130px;
    		/*transform: translate(0px, -50%);*/
		}
		#user-subscripction .modal-title {
			height: 20px;
		}
		#user-subscripction .modal-title a {}
		#user-subscripction .modal-content {}
		#user-subscripction .modal-content.cols {}
		#user-subscripction .modal-content.cols.cols-2 {}
		#user-subscripction .modal-content.cols.cols-2 modal-col-span1 {}
		#user-subscripction .modal-content.cols.cols-2 modal-col-span1.first-col {}
		#user-subscripction .modal-content.cols.cols-2 modal-col-span1.last-col {}
		#user-subscripction .modal-content .modal-col-inner {
			text-align: center;
		}
		#user-subscripction .modal-content .modal-col-inner img.suscription-banner {
			width: 100%;
		}
		#user-subscripction .modal-content .modal-col-inner h3.black-title {
			background: #000 none repeat scroll 0 0;
		    color: #fff;
		    display: inline-block;
		    font-size: 22px;
		    font-weight: bold;
		    padding: 5px 10px;
		    text-transform: uppercase;
		}
		#user-subscripction .modal-content .modal-col-inner p {}
		#user-subscripction .modal-content .modal-col-inner form {}
		#user-subscripction .modal-content .modal-col-inner form#suscribe-form {
			padding: 0;
		}
		#user-subscripction .modal-content .modal-col-inner form#suscribe-form .form-line {
			text-align: center;
		}
		#user-subscripction .modal-content .modal-col-inner form#suscribe-form .form-line.form-commands {
			position: initial;
		}
		#user-subscripction .modal-content .modal-col-inner form#suscribe-form .form-line input {
			box-sizing: border-box;
		    float: none;
		    height: 44px;
		    text-align: center;
		    width: 100%;
		}
		#user-subscripction .modal-content .modal-col-inner form#suscribe-form .form-line input.error {
			border-color: #c00;
			color: #c00;
			-moz-box-shadow: inset 0 0 5px #dd0000;
			-webkit-box-shadow: inset 0 0 5px #dd0000;
			box-shadow: inset 0 0 5px #dd0000;
		}
		#user-subscripction .modal-content .modal-col-inner form#suscribe-form .form-line button {
			cursor: pointer;
		}
		#user-subscripction .modal-content .modal-col-inner form#suscribe-form .form-line button.btn-rounded {
			background: #000;
		    border-radius: 25px;
		    box-shadow: none;
		    font-size: 18px;
		    height: 50px;
		    padding: 0;
		    width: 50px;
		}
		#user-subscripction .modal-title .modal-close.action-hide-suscription {
			width: auto;
			float: right;
			margin-right: 35px;
			line-height: 35px;
		}
	</style>
	<div class="modal" id="user-subscripction">
		<div class="modal-title">
			<a href="#" class="modal-close action-close action-hide-suscription">Ya estoy suscripto</a>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
		</div>
		<div class="modal-content cols cols-2">
			<div class="modal-col modal-col-span1 first-col">
				<div class="modal-col-inner">
					<img class="suscription-banner" src="/statics/images/suscribe-banner.jpg">
				</div>
			</div>
			<div class="modal-col modal-col-span1 last-col">
				<div class="modal-col-inner">
					<h3 class="black-title">Suscribite!</h3>
					<p>Y recibí en tu email, las mejores novedades, promociones exclusivas, ofertas y más!</p>
					<form action="/suscripcion/" method="POST" id="suscribe-form">
						<div class="form-line">
							<input type="text" class="input <?php echo isset($_GET['subscription']) && $_GET['subscription'] == 'error' ? 'error' : '' ?>" id="email" name="email" placeholder="<?php echo isset($_GET['subscription']) && $_GET['subscription'] == 'error' ? 'Error en el email' : 'Ingresá tu email' ?>">
						</div>
						<div class="form-line form-commands">
							<button type="submit" class="btn bnt-suscribe btn-rounded btn-style black">Ok</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>