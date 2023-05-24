$(document).ready(() => {

	$("form#cart_add").submit(function(e) {
		e.preventDefault();
		const form = $(this).get(0);
		post(new FormData(form), apip + '/carts/product_add.php', function(data) {
			if (data.status) {
				let num = $('.in_cart').html() == 'Нет' ? 0 : +$('.in_cart').html();
				$('.in_cart').html(num+1);
				$('.form-info').html(`<p class="success"> ${data.message} </p>`);
			} else {
				$('.form-info').html(`<p class="error"> ${data.message} </p>`);
			}
		})
	});

})
