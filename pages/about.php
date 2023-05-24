<?php

$query =
"SELECT * FROM `products` as p
LEFT JOIN `categories` as c ON p.category_id = c.id
ORDER BY p.id
LIMIT 0,5" ;
$products_result = mysqli_query($connection, $query);

?>

<section class="wrapper">

    <div class="container content-container">
        <div class="max-w-[700px] mx-auto">
            <h2 class="text-xl text-center">О нас</h2>
        </div>
    </div>
    
    <div class="container content-container">
        <div class="max-w-[700px] mx-auto text-center">
            <p>- Продаём любые типы принтеров</p>
            <p>- Работаем уже 5 лет</p>
            <p>- Только качественное оборудование</p>
        </div>
    </div>

</section>

<section class="wrapper">

    <div class="container content-container">
        <div class="max-w-[700px] mx-auto">
            <h2 class="text-xl text-center">Наш девиз</h2>
        </div>
    </div>
    
    <div class="container content-container">
        <div class="max-w-[700px] mx-auto text-center">
            <p>Сделаем вашу жизнь ярче! <br /> - Цветная печать</p>
        </div>
    </div>

</section>

<section class="wrapper">

    <div class="container content-container">
        <div class="max-w-[700px] mx-auto">
            <h2 class="text-xl text-center">Последние товары</h2>
        </div>
    </div>

    <div class="container content-container">
        <div class="swiper max-h-full bg-white/50 rounded min-w-full overflow-hidden relative">

            <div class="swiper-wrapper">
                <? while($product = mysqli_fetch_assoc($products_result)): ?>
                    <div class="swiper-slide min-h-[40vh] min-w-full flex justify-center p-4 items-center border-solid border-2 border-green-800">
                        <div class="flex flex-wrap w-full max-w-[700px] justify-center">
                            <img src="/uploads/products/<?=$product['image_name']?>" alt="Товар" class="max-h-[400px]" draggable="false" />
                            <div class="flex flex-col p-4 justify-center">
                                <p><b>Наименование: </b><?=$product['product_name']?></p>
                                <p><b>Цена: </b><?=$product['price'].' руб.'?></p>
                                <p><b>Категория: </b><?=$product['category_name']?></p>
                                <p><span class="text-lg">Количество (осталось):</span> <?=$product['amount']?></p>
                                <p><a href="/catalog.php?id=<?=$product['id']?>" class="underline">Подробнее</a></p>
                            </div>
                        </div>
                    </div>
                <? endwhile; ?>
            </div>


            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <!-- <div class="swiper-scrollbar"></div> -->

        </div>
    </div>

</section>