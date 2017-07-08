$(document).on("ready", function () {
	$(".orden-acciones .aprobar")
		.on("click", function (e) {

			$this = $(this);

			if ($this.hasClass("grey")) {
				return;
			}

			$this.removeClass("purple").addClass("grey").text("...");
			$.getJSON("/app/pedido/aprobar/index.php?id=" + $this.data("id"), function (e) {

				$this.text("Aprobado");
				document.location.href = document.location.href;

			});

		});

	$(".orden-acciones .cerrar")
		.on("click", function (e) {
			console.log('Cerrar....');

			$this = $(this);

			if ($this.hasClass("grey")) {
				return;
			}

			$this.removeClass("purple").addClass("grey").text("...");
			$.getJSON("/app/pedido/cerrar/index.php?id=" + $this.data("id"), function (e) {

				$this.text("Aprobado");
				document.location.href = document.location.href;

			});

		});

	$(".orden-acciones .cancelar")
		.on("click", function (e) {

			$this = $(this);

			if ($this.text() == "...") {
				return;
			}

			$this.text("...");
			$.getJSON("/app/pedido/cancelar/index.php?id=" + $this.data("id"), function (e) {

				$this.text("Cancelado");
				document.location.href = document.location.href;

			});

		});

	$(".orden-acciones .pendiente")
		.on("click", function (e) {

			$this = $(this);

			if ($this.text() == "...") {
				return;
			}

			$this.text("...");
			$.getJSON("/app/pedido/posponer/index.php?id=" + $this.data("id"), function (e) {

				$this.text("Pendiente");
				document.location.href = document.location.href;

			});

		});

	function checkNotification() {
		// Chequeo por las notificaciones
		if (!("Notification" in window)) {
			// Si no se puede enviar, le aviso al usuario
			alert("Este navegador no soporta las notificaciones.\n\nPor favor usa uno compatible, como Firefox o Chrome.");
			return false;
		} else if (Notification.permission === "granted") {
		  // If it's okay let's create a notification
			return true;
		} else if (Notification.permission !== 'denied') {
			return Notification.requestPermission(function (permission) {
				// If the user accepts, let's create a notification
				if (permission === "granted") {
					var notification = new Notification("Las notificaciones han sido activadas!");
					return true;
				} else {
					return false;
				}
			});
		}
	}

	if (typeof(Worker) !== "undefined") {
	  if (typeof(w) == "undefined") {
	    w = new Worker("../statics/js/check-new-orders-ww.js");
		}

		w.onmessage = function(event){
			if (checkNotification()) {
				var orden = JSON.parse(event.data);

				if (orden) {
			  	var options = {
			      body: 'El usuario ' + orden.nombre + ' ' + orden.apellido + ' ingresó un nuevo pedido.',
			      icon: '../images/logo.png',
			      data: orden
				  };
				  var n = new Notification('Nuevo pedido: Nº ' + orden.id, options);

				  n.onclick = function(e) {
				  	document.location.href = '/detalle/?id=' + e.explicitOriginalTarget.data.id;
				  };

				  setTimeout(n.close.bind(n), 10000);
				}
			}
		};

	} else {
	  // Sorry! No Web Worker support..
	  alert('Worker is not supported :\'(');
	}
});