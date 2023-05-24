<?php

$query =
"SELECT * FROM `products`";
$result = mysqli_query($connection, $query);

?>


<section class="wrapper">

    <?php require_once $server_path. "/require/admin_header.php"?>

    <div class="container content-container">
        <h2 class="text-center">Товары. Админ панель</h2>
    </div>

</section>


<section class="wrapper">
    
    <div class="container content-container">
        <div class="max-w-[700px] mx-auto">
            <table class="table_sort">
                <thead>
                    <tr>
                        <th>Номер товара</th>
                        <th>Название товара</th>
                        <th>Страна производителя</th>
                        <th>Год издания</th>
                    </tr>
                </thead>
                <tbody>
                    <? while ($category = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?=$category['id']?></td>
                            <td><?=$category['product_name']?></td>
                            <td><?=$category['country']?></td>
                            <td><?=$category['year']?></td>
                        </tr>
                    <? endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
