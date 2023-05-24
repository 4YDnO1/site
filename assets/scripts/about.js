window.addEventListener('load', function() {
	const swiper = new Swiper('.swiper', {
		// Опциональный настройки
		direction: 'horizontal',
		loop: true,

		// Авто свайп
		autoplay: {
			delay: 3000,
		},
		// Если нужна пагинация
		pagination: {
			el: '.swiper-pagination',
		},
		
		// Стрелочки навигации
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	
		// Если нужен скроллбар
		scrollbar: {
			el: '.swiper-scrollbar',
		},
	});
})

