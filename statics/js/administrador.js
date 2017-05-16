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

});