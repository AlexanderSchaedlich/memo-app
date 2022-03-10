$("#userDeleteAccount").click(function() {
	let confirmation = confirm("Sind Sie sicher, dass Sie Ihr Konto löschen möchten?");
	
	if (confirmation) {
		deleteMemosByAuthor();
		deleteAccount();
	}
});