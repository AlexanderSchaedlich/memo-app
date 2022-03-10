function generatePassword() {
	let data = new FormData();
	data.append("action", "generate_password");
	const request = new XMLHttpRequest();
	// execute when the request transaction completes successfully
	request.onload = function() {
		$("[name='password']").val(this.responseText);
	};

	request.open("POST", "ajax");
	request.send(data);
}

function createMemo(form) {
	// get the values
	let title = form.find("[name='title']").val();
	let text = form.find("[name='text']").val();
	let visibility = form.find("[name='visibility']").val();

	if (title == "" || text == "") {
		alert("Bitte füllen Sie alle Felder aus.");
		return;
	}

	let data = new FormData();
	data.append("action", "create_memo");
	data.append("title", title);
	data.append("text", text);
	data.append("visibility", visibility);
	const request = new XMLHttpRequest();

	// execute when the request transaction completes successfully
	request.onload = function() {
		let lastMemo = JSON.parse(this.responseText);
		// if the memo couldn't be created
		if (lastMemo.length == 0) {
			// show a message
			$("#newMemoMessage").addClass("text-danger").append("Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.");
		} else {
			// show a message
			$("#newMemoMessage").empty().addClass("text-success").append("Die Notiz wurde erstellt.");
			$("#noPrivateMemos").empty();
			// add a card
			let date = lastMemo["date"];
			let selectedPrivate = "selected";
			let selectedPublic = "";
			let visibility = "Privat";

			if (lastMemo["visibilty"] == "public") {
				selectedPrivate = "";
				selectedPublic = "selected";
				visibility = "Öffentlich";
			}

			$("#cards").append(`
				<div>
					<!--card-->
					<div id="newCard-${lastMemo['id']}" class="card my-4 shadow">
				        <div class="card-header d-flex justify-content-between">
				          <div>
				            <p class="card-date mt-0 mb-2">Gerade eben erstellt</p>
				            <p class="card-visibility mb-0">${visibility}</p>
				          </div>
				          <div class="buttonsParent">
				            <button class="btn btn-primary mr-1" type="button" data-toggle="modal" data-target=".bd-example-modal-lg${lastMemo['id']}">Ändern</button>
				            <button class="btn btn-primary" type="button" onclick="deleteNewMemo('${date}', this)">Löschen</button>
				          </div>
				        </div>
				        <div class="card-body">
				          <h5 class="card-title">${lastMemo['title']}</h5>
				          <p class="card-text">${lastMemo['text']}</p>
				        </div>
				      </div>
				      <!-- large modal -->
		              <div class="modal fade bd-example-modal-lg${lastMemo['id']}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		                <div class="modal-dialog modal-lg">
		                  <div class="modal-content">
            				<p class="message mb-0 p-2 text-center"></p>
		                    <form id="updateMemo-${lastMemo['id']}" class="mt-1 p-4 shadow d-flex justify-content-center flex-column align-items-center" action="javascript:void(0);">
		                      <input class="d-block inputWidth pl-4" type="text" value="${lastMemo['title']}" name="title">
		                      <textarea class="inputWidth mt-4" rows="4" cols="50" name="text">${lastMemo['text']}</textarea>
		                      <select class="m-4" name="visibility">
		                        <option ${selectedPrivate} value="private">Private Notiz</option>
		                        <option ${selectedPublic} value="public">Öffentliche Notiz</option>
		                      </select>
		                      <button class="btn btn-primary my-3 inputWidth" type="submit" name="submit" onclick="updateNewMemo('${date}', ${lastMemo['id']}, this)">Speichern</button>
		                    </form>
		                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="closeModal(${lastMemo['id']})">Schließen</button>
		                  </div>
		                </div>
		            </div>
	            </div>
			`);
		}
	};

	request.open("POST", "ajax");
	request.send(data);
};

function updateMemo(form) {
	// get the values
	let id = form.find("[name='id']").val();
	let date = form.find("[name='date']").val();
	let title = form.find("[name='title']").val();
	let text = form.find("[name='text']").val();
	let visibility = form.find("[name='visibility']").val();

	if (title == "" || text == "") {
		alert("Bitte füllen Sie alle Felder aus.");
		return;
	}

	let data = new FormData();
	data.append("action", "update_memo");
	data.append("date", date);
	data.append("title", title);
	data.append("text", text);
	data.append("visibility", visibility);
	const request = new XMLHttpRequest();

	// execute when the request transaction completes successfully
	request.onload = function() {
		if (this.responseText === "") {
			console.log("something went wrong");
			return;
		}

		let updatedMemo = JSON.parse(this.responseText);
		let modal = $(".bd-example-modal-lg" + id);
		$("#newMemoMessage").empty().removeClass("text-success").removeClass("text-danger");
		// if the memo couldn't be created
		if (updatedMemo.length == 0) {
			// show a message
			modal.find(".message").removeClass("text-success").addClass("text-danger").append("Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.");
		} else {
			// show a message
			modal.find(".message").empty().removeClass("text-danger").addClass("text-success").append("Die Notiz wurde aktualisiert.");
			// update the card and the modal
			let visibility;

			modal.siblings().find("option").removeAttr("selected");

			if (updatedMemo["visibility"] == "private") {
				visibility = "Privat";
				modal.siblings().find("option[value='private']").attr("selected", "");
			} else {
				visibility = "Öffentlich";
				modal.siblings().find("option[value='public']").attr("selected", "");
			}

			modal.siblings().find(".card-date").html(updatedMemo["styled_date"]);
			modal.siblings().find(".card-visibility").text(visibility);
			modal.siblings().find(".card-title").html(updatedMemo["title"]);
			modal.siblings().find(".card-text").html(updatedMemo["text"]);
		}
	};

	request.open("POST", "ajax");
	request.send(data);
};

function updateNewMemo(date, id, button) {
	// get the values
	let title = document.querySelector("form#updateMemo-" + id + " [name='title']").value;
	let text = document.querySelector("form#updateMemo-" + id + " [name='text']").value;
	let visibility = document.querySelector("form#updateMemo-" + id + " [name='visibility']").value;

	if (title == "" || text == "") {
		alert("Bitte füllen Sie alle Felder aus.");
		return;
	}

	let data = new FormData();
	data.append("action", "update_memo");
	data.append("date", date);
	data.append("title", title);
	data.append("text", text);
	data.append("visibility", visibility);
	const request = new XMLHttpRequest();

	// execute when the request transaction completes successfully
	request.onload = function() {
		let updatedMemo = JSON.parse(this.responseText);
		$("#newMemoMessage").empty().removeClass("text-success").removeClass("text-danger");
		// if the memo couldn't be created
		if (updatedMemo.length == 0) {
			// show a message
			document.querySelector(".bd-example-modal-lg" + id + " .message").classList.remove("text-success");
			document.querySelector(".bd-example-modal-lg" + id + " .message").classList.add("text-danger");
			document.querySelector(".bd-example-modal-lg" + id + " .message").innerHTML = "Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.";
		} else {
			// show a message
			document.querySelector(".bd-example-modal-lg" + id + " .message").classList.remove("text-danger");
			document.querySelector(".bd-example-modal-lg" + id + " .message").classList.add("text-success");
			document.querySelector(".bd-example-modal-lg" + id + " .message").innerHTML = "Die Notiz wurde aktualisiert.";
			
			// update the card and the modal
			let visibility;

			document.querySelectorAll(".bd-example-modal-lg" + id + " option").forEach(function(currentValue) {
				currentValue.removeAttribute("selected", "");
			});

			if (updatedMemo["visibility"] == "private") {
				visibility = "Privat";
				document.querySelector(".bd-example-modal-lg" + id + " option[value='private']").setAttribute("selected", "");
			} else {
				visibility = "Öffentlich";
				document.querySelector(".bd-example-modal-lg" + id + " option[value='public']").setAttribute("selected", "");
			}

			document.querySelector("#newCard-" + id + " .card-date").innerHTML = updatedMemo["date"];
			document.querySelector("#newCard-" + id + " .card-visibility").innerHTML = visibility;
			document.querySelector("#newCard-" + id + " .card-title").innerHTML = updatedMemo["title"];
			document.querySelector("#newCard-" + id + " .card-text").innerHTML = updatedMemo["text"];
		}
	};

	request.open("POST", "ajax");
	request.send(data);
};

function closeModal(id) {
	document.querySelector(".bd-example-modal-lg" + id + " .message").innerHTML = "";
}

function deleteMemo(date) {
	let data = new FormData();
	data.append("action", "delete_memo");
	data.append("date", date);
	const request = new XMLHttpRequest();
	// execute when the request transaction completes successfully
	request.onload = function() {
		$("#newMemoMessage").empty().removeClass("text-success").removeClass("text-danger");
		if (this.responseText == "1") {
			// remove the card
			$(".card[data-date='" + date + "']").parent().empty().removeClass("card").removeClass("my-4");
			// write a message
			$("#newMemoMessage").addClass("text-success").html("Die Notiz wurde entfernt.");
			
		} else {
			// write a message
			$("#newMemoMessage").addClass("text-danger").html("Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.");
		}
	};

	request.open("POST", "ajax");
	request.send(data);
}

function deleteNewMemo(date, button) {
	let data = new FormData();
	data.append("action", "delete_memo");
	data.append("date", date);
	const request = new XMLHttpRequest();
	// execute when the request transaction completes successfully
	request.onload = function() {
		let card = button.parentElement.parentElement.parentElement;
		$("#newMemoMessage").empty().removeClass("text-success").removeClass("text-danger");
		
		if (this.responseText == "1") {
			// remove the card
			card.innerHTML = "";
			card.classList.remove("card");
			card.classList.remove("my-4");
			// write a message
			$("#newMemoMessage").addClass("text-success").html("Die Notiz wurde entfernt.");
			
		} else {
			// write a message
			$("#newMemoMessage").addClass("text-danger").html("Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.");
		}
	};

	request.open("POST", "ajax");
	request.send(data);
}

function deleteAccount() {
	let data = new FormData();
	data.append("action", "delete_author");

	const request = new XMLHttpRequest();
	// execute when the request transaction completes successfully
	request.onload = function() {
		if (this.responseText == "1") {
			alert("Das Konto wurde gelöscht.");
			window.location.href = "../index.php/logout";
		} else {
			alert("Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.");
		}
	};

	request.open("POST", "ajax");
	request.send(data);
}

function deleteMemosByAuthor() {
	let data = new FormData();
	data.append("action", "delete_memos_by_author");
	const request = new XMLHttpRequest();
	// execute when the request transaction completes successfully
	request.onload = function() {
		if (this.responseText == "1") {
			// console.log("deleted memos")
		} else {
			// console.log("something went wrong")
		}
	};

	request.open("POST", "ajax");
	request.send(data);
}

function updateAuthor(form) {
	// get the values
	let id = form.find("[name='id']").val();
	let firstName = form.find("[name='first_name']").val();
	let lastName = form.find("[name='last_name']").val();
	let role = form.find("[name='role']").val();

	if (firstName == "" || lastName == "") {
		alert("Bitte füllen Sie alle Felder aus.");
		return;
	}

	let data = new FormData();
	data.append("action", "update_author");
	data.append("id", id);
	data.append("first_name", firstName);
	data.append("last_name", lastName);
	data.append("role", role);
	const request = new XMLHttpRequest();

	// execute when the request transaction completes successfully
	request.onload = function() {
		let updatedAuthor = JSON.parse(this.responseText);
		// if the author couldn't be updated
		if (updatedAuthor.length == 0) {
			// show a message
			alert("Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.");
		} else {
			// show a message
			alert("Die Daten des Benutzers " + firstName + " " + lastName + " wurden aktualisiert.");
		}
	};

	request.open("POST", "ajax");
	request.send(data);
};

function deleteAuthor(id, authorsName) {
	let data = new FormData();
	data.append("action", "delete_author");
	data.append("id", id);
	const request = new XMLHttpRequest();
	// execute when the request transaction completes successfully
	request.onload = function() {
		if (this.responseText == "1") {
			alert("Das Konto des Benutzers " + authorsName + " wurde gelöscht.");
			$("tr[data-id='" + id + "']").empty();
		} else {
			alert("Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.");
		}
	};

	request.open("POST", "ajax");
	request.send(data);
}