<?php
	$filter = 'WHERE 1=1';
	if(!empty($_GET['category_filter']))
		$filter .= " and p.category_id = ".$_GET['category_filter'];

	$sorter = 'ORDER BY `created` ASC';
	if(isset($_GET['price_sorter'])) {
		$type = $_GET['price_sorter'] == 1 ? 'DESC' : 'ASC';
		$sorter = "ORDER BY `price` ".$type;
	}

	$limit_num = !empty($_GET['limit']) && $_GET['limit'] >= 1 ? $_GET['limit'] : 10; 
	$total = mysqli_fetch_row(mysqli_query($c, "SELECT COUNT(*) FROM `products` AS p $filter"))[0];
	$pages = ceil($total/$limit_num);
	$page = !empty($_GET['page']) ? $_GET['page'] : 1;
	$page = is_numeric($page) && $page >= 1 ? min([$page, $pages]) : 1;  
	$_GET['page'] = $page;
	$kolvo = $limit_num * ($total==0 ? 1 : $page-1);
	$limit = "LIMIT $kolvo, $limit_num";

	$q =
	"SELECT p.*, c.category_name FROM `products` as p
	LEFT JOIN `categories` AS c ON p.category_id = c.id
	$filter $sorter $limit";
	$products_result = mysqli_query($c, $q);

	$q =
	"SELECT c.* FROM `categories` AS c";
	$categories_result = mysqli_query($c, $q);
?>

<section class="content-wrapper">
	<form action="" method="GET" class="content-wrapper">

		<div class="container content-container">
			<h2 class="text-xl">Фильтры</h2>
		</div>

		<div class="container content-container">
			<div class="flex gap-6">
				<div class="flex gap-2">
					<label for="category_filter">Категория</label>
					<select name="category_filter" id="category_filter">
						<option value="">Выберите категорию ...</option>
						<?php while($category = mysqli_fetch_assoc($categories_result)): ?>
							<option value="<?= $category['id'] ?>" <?=$_GET['category_filter']==$category['id']?'selected':''?>>
								<?= $category['category_name'] ?>
							</option>
						<? endwhile; ?>
					</select>
				</div>
				<button type="submit">Отфильтровать</button>
			</div>
		</div>

		<div class="container content-container">
			<h2 class="text-xl">Сортировка</h2>
		</div>

		<div class="container content-container">
			<div class="flex gap-6">
				<div class="flex gap-2">
					<label for="price_sorter">Цена</label>
					<select name="price_sorter" id="price_sorter">
						<option value="">Выберите направление ...</option>
						<option value="1" <?=!empty($_GET['price_sorter']) && $_GET['price_sorter']==1?'selected':''?>>По убыванию</option>
						<option value="2" <?=!empty($_GET['price_sorter']) && $_GET['price_sorter']==2?'selected':''?>>По возврастанию</option>
					</select>
				</div>
				<button type="submit">Сортировать</button>
			</div>
		</div>

	</form>

</section>

<section class="content-wrapper">

	<?php if (!isset($_GET['id'])): ?>

	<div class="container content-container">
		<h2 class="text-xl">Каталог</h2>
	</div>

	<div class="container content-container">
		<div class="flex gap-4 flex-wrap">
			<?php while($product = mysqli_fetch_assoc($products_result)): ?>
				<div class="flex flex-col min-w-[200px] max-w-[220px] w-full grow bg-yellow-100/25">
					<div class="overflow-hidden rounded mb-auto">
						<img src="<?='/products_uploads/'.$product['image_name']?>" alt="Товар" class="grow max-h-[222px]" draggable="false"/>
					</div>
					<div class="w-full py-[5px] px-[10px]">
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

	<div class="container content-container">
		<?php
			$q =
			"SELECT p.*, c.category_name FROM `products` as p
			LEFT JOIN `categories` AS c ON p.category_id = c.id
			WHERE p.id = '$_GET[id]'";
			$result = mysqli_query($c, $q);
			$product = mysqli_fetch_assoc($result)
		?>
		<div class="flex gap-4 flex-col">
			<a href="/catalog.php?>" class="underline">Вернутся ко всем товарам</a>
			<div class="flexw-full flex gap-4">
				<div class="max-w-[400px] rounded overflow-hidden">
					<img src="<?='/products_uploads/'.$product['image_name']?>" alt="Товар">
				</div>
				<div class="w-full py-[5px] px-[10px]">
					<p><b>Наименование: </b><?=$product['product_name']?></p>
					<p><b>Цена: </b><?=$product['price'].' руб.'?></p>
					<p><b>Категория: </b><?=$product['category_name']?></p>
					<p><b>Цвет: </b><?=$product['color']?></p>
					<p><b>Страна производителя: </b><?=$product['country']?></p>
					<p><b>Количество: </b><?=$product['amount']?></p>
					
				</div>
			</div>
		</div>
	</div>

	<?php endif; ?>

</section>