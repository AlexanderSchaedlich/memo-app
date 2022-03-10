// update an author
$("button.save").click(function() {
	updateAuthor($(this).parent().parent());
});
// delete an author
$("button.delete").click(function() {
	let authorsName = $(this).parent().siblings().find("[name='first_name']").val() + " " + $(this).parent().siblings().find("[name='last_name']").val();
	let confirmation = confirm("Sind Sie sicher, dass Sie das Konto des Benutzers " + authorsName + " löschen möchten?");
	
	if (confirmation) {
		deleteAuthor(this.dataset.id, authorsName);
		deleteMemosByAuthor(this.dataset.id);
	}
});