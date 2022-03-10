// create a memo
$("form#createMemo [name='submit']").click(function() {
	createMemo($(this).parent());
});
// update a memo
$("form.updateMemo [name='submit']").click(function() {
	updateMemo($(this).parent());
});
$(".modalClose").click(function() {
	$(this).siblings(".message").empty();
});
// delete a memo
$("button.delete").click(function() {
	deleteMemo(this.dataset.date);
});