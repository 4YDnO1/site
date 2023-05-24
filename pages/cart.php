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

// Повторное взятие корзины
$query =
"SELECT * FROM `carts` AS cr
WHERE cr.is_ordered = 0 and cr.user_id = ".$_SESSION['user_data']['id'];
$cart_result = mysqli_query($connection, $query);
$cart = mysqli_fetch_assoc($cart_result);

$query =
"SELECT p.*, c.category_name, cp.amount AS cart_amount FROM `carts_products` AS cp
LEFT JOIN `products` AS p ON cp.product_id = p.id
LEFT JOIN `categories` AS c ON p.category_id = c.id
WHERE cp.cart_id = $cart[id]";
$cart_products_result = mysqli_query($connection, $query);
$cart_products = mysqli_fetch_all($cart_products_result, MYSQLI_ASSOC);
?>

<section class="wrapper">

    <div class="container content-container">
        <h2 class="text-lg text-center">Корзина</h2>
    </div>

    <div class="container content-container">
        <? if ($cart_products): ?>
        <div class="max-w-[1000px] mx-auto flex gap-4 flex-wrap justify-center">

			<?php foreach($cart_products as $product): ?>
				<div class="product flex flex-col min-w-[200px] bg-green-100/50 grow items-center rounded border-solid border-2 border-green-800">
					<div class="overflow-hidden rounded m-auto">
						<img src="<?='/uploads/products/'.$product['image_name']?>" alt="Товар" class="grow max-h-[222px]" draggable="false" />
					</div>
					<div class="info py-[5px] px-[10px] flex flex-col gap-1">
						<p><b>Наименование:</b> <?=$product['product_name']?></p>
						<p><b>Цена:</b> <?=$product['price'].' руб.'?></p>
						<p><b>Категория:</b> <?=$product['category_name']?></p>
                        <p><b>Выбрано:</b> <span class="in_cart"><?=$product['cart_amount']?></span> из <?=$product['amount']?></p>
                        
                        <div class="flex gap-2">
                            <form action="" method="post" id="product_add">
                                <input type="hidden" name="product_id" value="<?=$product['id']?>" />
                                <button type="submit" class="grow">Добавить</button>
                            </form>
                            <form action="" method="post" id="product_minus">
                                <input type="hidden" name="product_id" value="<?=$product['id']?>" />
                                <button type="submit" class="grow">Убрать</button>
                            </form>
                        </div>
						<p><a href="/catalog.php?id=<?=$product['id']?>" class="underline">Подробнее</a></p>
                        <div class="form-info"></div>
                    </div>
				</div>
			<?php endforeach; ?>

        </div>
        <? else: ?>
            <p class="text-center">Товаров в корзине не обнаружено, добавте на странице товара из каталога!</p>
        <? endif; ?>

    </div>

</section>
