<?php
	// Фильтры
	$filter = "WHERE 1=1 and p.amount > 0";
	// Фильтр по категориям
	if(!empty($get['category_filter']))
		$filter .= " and p.category_id = ".$get['category_filter'];

	// Сортировки
	$type = isset($get['sorter_direction']) && $get['sorter_direction'] == 1 ? "DESC" : "ASC";
	$sorter = "ORDER BY `id` ".$type;
	// Сортировка по цене
	if (isset($get['sorter_type']))  {
		if ($get['sorter_type'] == 1) {
			$sorter = "ORDER BY `year` ".$type;
		} else if ($get['sorter_type'] == 2)  {
			$sorter = "ORDER BY `product_name` ".$type;
		} else if ($get['sorter_type'] == 3) {
			$sorter = "ORDER BY `price` ".$type;
		}
	}


	// Пагинатор, расчёт страниц с соблюдением фильтра
	$limit_num = !empty($get['limit']) && $get['limit'] >= 1 ? $get['limit'] : 10; 
	$total = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM `products` AS p $filter"))[0];
	$pages = ceil($total/$limit_num);
	$page = !empty($get['page']) ? $get['page'] : 1;
	$page = is_numeric($page) && $page >= 1 ? min([$page, $pages]) : 1;  
	$_GET['page'] = $page;
	$amount = $limit_num * ($total==0 ? 1 : $page-1);
	$limit = "LIMIT $amount, $limit_num";

	// Запрос на товары
	$query =
	"SELECT p.*, c.category_name FROM `products` as p
	LEFT JOIN `categories` AS c ON p.category_id = c.id
	$filter $sorter $limit";
	$products_result = mysqli_query($connection, $query);

	// Запрос на категории
	$query =
	"SELECT c.* FROM `categories` AS c";
	$categories_result = mysqli_query($connection, $query);
?>

<section class="content-wrapper">
	
	<?php if (!isset($get['id'])): ?>

	<form action="" method="GET" class="content-wrapper">

		<div class="container content-container">
			<h2 class="text-xl">Фильтры</h2>
		</div>

		<div class="container content-container">
			<div class="flex gap-6 flex-wrap">
				<div class="flex gap-2 flex-wrap">
					<label for="category_filter">Категория</label>
					<select name="category_filter" id="category_filter">
						<option value="">Выберите категорию ...</option>
						<?php while($category = mysqli_fetch_assoc($categories_result)): ?>
							<option value="<?=$category['id'] ?>" <?=isset($get["category_filter"]) && $get["category_filter"] ==$category['id']?"selected":""?>>
								<?= $category['category_name'] ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
				<button type="submit">Отфильтровать</button>
			</div>
		</div>

		<div class="container content-container">
			<h2 class="text-xl">Сортировка</h2>
		</div>

		<div class="container content-container">
			<div class="flex gap-6 flex-wrap">
				<div class="flex gap-2 flex-wrap">
					<label for="sorter_type">Сортировать по</label>
					<select name="sorter_type" id="sorter_type">
						<option value="0" <?=empty($get['sorter_type']) || $get['sorter_type']==0?'selected':''?>>Новизне</option>
						<option value="1" <?=!empty($get['sorter_type']) && $get['sorter_type']==1?'selected':''?>>Году</option>
						<option value="2" <?=!empty($get['sorter_type']) && $get['sorter_type']==2?'selected':''?>>Наименованию</option>
						<option value="3" <?=!empty($get['sorter_type']) && $get['sorter_type']==3?'selected':''?>>Цене</option>
					</select>
					<select name="sorter_direction" id="sorter_direction">
						<option value="1" <?=!empty($get['sorter_direction']) && $get['sorter_direction']==1?'selected':''?>>По убыванию</option>
						<option value="" <?=empty($get['sorter_direction']) || $get['sorter_direction']!=1?'selected':''?>>По возврастанию</option>
					</select>
				</div>
				<button type="submit">Сортировать</button>
			</div>
		</div>

	</form>

	<?php endif; ?>

</section>


<section class="content-wrapper">

	<?php if (!isset($get['id'])): ?>

	<div class="container content-container">
		<h2 class="text-xl">Каталог</h2>
	</div>

	<div class="container content-container">
		<div class="flex gap-4 flex-wrap justify-center">
			<?php while($product = mysqli_fetch_assoc($products_result)): ?>
				<div class="flex flex-col min-w-[200px] bg-green-100/50 grow items-center rounded border-solid border-2 border-green-800">
					<div class="overflow-hidden rounded m-auto">
						<img src="<?='/uploads/products/'.$product['image_name']?>" alt="Товар" class="grow max-h-[222px]" draggable="false" />
					</div>
					<div class="py-[5px] px-[10px]">
						<p><b>Наименование: </b><?=$product['product_name']?></p>
						<p><b>Цена: </b><?=$product['price'].' руб.'?></p>
						<p><b>Категория: </b><?=$product['category_name']?></p>
						<p><a href="/catalog.php?id=<?=$product['id']?>" class="underline">Подробнее</a></p>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</div>

	<?php else: ?>

	<?php
		// Просмотр товара в корзине пользователя
		$query =
		"SELECT * FROM `products` AS p
		WHERE p.id =" .$get['id'];
		$categories_result = mysqli_query($connection, $query);
	?>
	<div class="container content-container">
		<?php
			// Запрос на выбраный товар
			$query =
			"SELECT p.*, c.category_name FROM `products` as p
			LEFT JOIN `categories` AS c ON p.category_id = c.id
			WHERE p.id = '$get[id]'";
			$result = mysqli_query($connection, $query);
			$product = mysqli_fetch_assoc($result)
		?>
		<div class="flex gap-4 flex-col items-center">
			<a href="/catalog.php" class="underline">Вернутся ко всем товарам</a>
			<div class="flex w-full gap-4 justify-center flex-wrap">
				<div class="max-w-[400px] rounded overflow-hidden">
					<img src="<?='/uploads/products/'.$product['image_name']?>" alt="Товар" draggable="false">
				</div>
				<form class="py-[5px] px-[10px]" method="POST" action="" id="cart_add">

					<p><b>Наименование: </b><?=$product['product_name']?></p>
					<p><b>Цена: </b><?=$product['price']." руб."?></p>
					<p><b>Категория: </b><?=$product['category_name']?></p>
					<p><b>Страна производителя: </b><?=$product['country']?></p>
					<p><b>Год произвдства: </b><?=$product['year']?></p>
					<p><b>Количество: </b><?=$product['amount']?></p>
					<input type="hidden" name="product_id" value="<?= $product['id'] ?>" />
					<?php if (isset($_SESSION['user_data'])): ?>
						<?php
							// Проверка есть ли текущая корзина у пользователя
							$query =
							"SELECT * FROM `carts` AS cr
							WHERE cr.is_ordered = 0 and cr.user_id = ".$_SESSION['user_data']['id'];
							$cart_result = mysqli_query($connection, $query);
							$cart = mysqli_fetch_assoc($cart_result);
							if (!$cart) {
								// Создание если нет
								$query =
								"INSERT INTO `carts` (`user_id`)
								VALUES (".$_SESSION['user_data']['id'].")";
								$insert_result = mysqli_query($connection, $query);
							}

							$query =
							"SELECT * FROM `carts` AS cr
							WHERE cr.is_ordered = 0 and cr.user_id = ".$_SESSION['user_data']['id'];
							$cart_result = mysqli_query($connection, $query);
							$cart = mysqli_fetch_assoc($cart_result);

							$query =
							"SELECT * FROM `carts_products` AS cp
							WHERE cp.cart_id = ".$cart['id'];
							$cart_products_result = mysqli_query($connection, $query);
							$cart_products = mysqli_fetch_all($cart_products_result, 1);

							$query =
							"SELECT * FROM `carts_products` AS cp
							WHERE cp.cart_id = ".$cart['id']." and cp.product_id = ".$get['id'];
							$cart_product_result = mysqli_query($connection, $query);
							$cart_product = mysqli_fetch_assoc($cart_product_result);
						?>
					<? endif;?>

					<? if(isset($_SESSION['user_data']['id'])): ?>
						<button type="submit">Добавить в корзину</button>
						<? if($cart): ?>
							<p>В корзине: <span class="in_cart"><?= !empty($cart_product) ? $cart_product['amount']:'Нет'?></span></p>
						<? endif; ?>
					<? else: ?>
						<p><a href="/login.php" class="underline">Войдите</a> в аккаунт, чтобы добавить в корзину</p>
					<? endif; ?>
					<p class="form-info"></p>
				</form>
			</div>
		</div>
	</div>

	<?php endif; ?>

</section>
