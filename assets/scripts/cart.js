/// !!!!!!!!!!!!!!!!!!!
$(document).ready(() => {

	$("form#product_add").submit(function(e) {
		e.preventDefault();
		const form = $(this).get(0);
		post(new FormData(form), apip + '/carts/product_add.php', function(data) {
			const info = $(form).closest('.info').find('.form-info');
			if (data.status) {
				const value =  $(form).closest('.info').find('.in_cart').html()
				let num = value == 'Нет' ? 0 : +value;
				$(form).closest('.info').find('.in_cart').html(num+1)
				info.html(`<p class="success"> ${data.message} </p>`);
			} else {
				info.html(`<p class="error"> ${data.message} </p>`);
			}
		})
	});

	$("form#product_minus").submit(function(e) {
		e.preventDefault();
		const form = $(this).get(0);
		post(new FormData(form), apip + '/carts/product_minus.php', function(data) {
			const info = $(form).closest('.info').find('.form-info');
			if (data.status) {
				const value =  +$(form).closest('.info').find('.in_cart').html()
				if (value - 1 <= 0) {
					$(form).closest('.product').remove();
				} else {
					$(form).closest('.info').find('.in_cart').html(value-1)
					info.html(`<p class="success"> ${data.message} </p>`);
				}
				
			} else {
				info.html(`<p class="error"> ${data.message} </p>`);
			}
		})
	});

})
