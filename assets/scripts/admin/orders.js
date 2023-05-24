/// !!!!!!!!!!!!!!!!!!!
$(document).ready(() => {

	$("form#cart_add").submit(function(e) {
		e.preventDefault();
		const form = $(this).get(0);
		post(new FormData(form), apip + '/carts/product_add.php', function(data) {
			if (data.status) {
				window.location.reload();
			} else {
				$('.form-info').html(`<label class="error" for="${data.error_field}"> ${data.message} </label>`);
			}
		})
	});

})
