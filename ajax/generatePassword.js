$(".generatePassword").click(function() {
	generatePassword();
});

// hide the open eye icon
$(".fa-eye").hide();
$(".toggleEye").click(function() {
	// toggle the visibility of the eye icons
	$(".fa-eye").toggle();
	$(".fa-eye-slash").toggle();
	// toggle between the password and text input types
	if ($("[name='password']").attr("type") == "password") {
		$("[name='password']").attr("type", "text");
	} else {
		$("[name='password']").attr("type", "password");
	}
});