listenForAllModalsToHide();
checkForQueryParamsAndOpenModal();

function checkForQueryParamsAndOpenModal() {
	const queryParams = window.location.search;

	if (queryParams) {
		const id = queryParams.replace('?field=', '');
		const windowHeight = window.innerHeight;
		window.scrollTo(
			0, windowHeight
		);
		setTimeout(
			() => {
				openModal(id);

			}, 100
		);
	}
}

function listenForAllModalsToHide() {
	const modals = document.querySelectorAll('.modal');
	console.log(modals.length);
	modals.forEach(
		modal => {
			modal.addEventListener('hidden.bs.modal', function(event) {
				clearParams();
			});
		}
	)

}


function openModal(id) {

	var myModal = new bootstrap.Modal(document.getElementById(id), {
		keyboard: false
	});
	myModal.show();
}

function clearParams(params) {
	window.history.replaceState(null, null, '?');

}

function closeModal(id) {
	var button = document.getElementById(id);

	button.click();
	clearParams();

}



function changeParams(params) {
	window.history.replaceState(null, null, `?field=${params}`);

}