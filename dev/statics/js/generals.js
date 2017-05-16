function showModal ($modal, showVelo = false) {

	closeModal();
	if ($modal.length) {

		if(showVelo) {
			$(".modal-bg").addClass('velo-bg');
		} else {
			$(".modal-bg").removeClass('velo-bg');
		}

		$(".modal-bg").fadeIn("fast");
		$(".modal-cont").fadeIn("fast");

		$modal.fadeIn("fast");

	}

}

function closeModal () {

	$(".modal-bg").fadeOut("fast");
	$(".modal-cont").fadeOut("fast");
	$(".modal").fadeOut("fast");

}

$(document).on("ready", function () {

	if(userStats['status'] == "ERROR_EMAIL_OR_PASS") {
		$("#first-time-user").find(".form-line.form-error").show();
		showModal($("#first-time-user, #super-user-register"));
	}

	$("#user-cmd")
		.find(".user-menu.user-login").on("click", function (e) {

			e.preventDefault();
			showModal($("#first-time-user, #super-user-register"));
			
		});

	$("#user-cmd")
		.find(".user-menu.user-logged").on("click", function (e) {

			e.preventDefault();
			e.stopPropagation();

			$(".user-cmd-dropdown:visible").fadeOut();
			$(".user-cmd-dropdown.user-info").fadeIn();

		});

	$(".modal .action-close, .mensaje-modal .action-close").on("click", function (e) {

		e.preventDefault();
		closeModal();

	});

	if(document.location.href.indexOf('?subscription=error') != -1) {
		sessionStorage.suscribeMessageViewed = 'false';
	}

	if((!sessionStorage.suscribeMessageViewed || sessionStorage.suscribeMessageViewed != 'true') && !userStats['user']) {
		sessionStorage.suscribeMessageViewed = 'true';
		showModal($('#user-subscripction'), true);
	}

})
.on("click", function () {

	$(".user-cmd-dropdown").fadeOut();

});


