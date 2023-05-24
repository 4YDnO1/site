<?php

$query =
"SELECT * FROM `categories`";
$result = mysqli_query($connection, $query);

?>


<section class="wrapper">

    <?php require_once $server_path. "/require/admin_header.php"?>

    <div class="container content-container">
        <h2 class="text-center">Категории. Админ панель</h2>
    </div>

</section>

<section class="wrapper">
    
    <div class="container content-container">
        <div class="max-w-[700px] mx-auto">
            <table class="table_sort">
                <thead>
                    <tr>
                        <th>Номер категории</th>
                        <th>Название категории</th>
                    </tr>
                </thead>
                <tbody>
                    <? while ($category = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?=$category['id']?></td>
                            <td><?=$category['category_name']?></td>
                        </tr>
                    <? endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</section>


<section class="wrapper">

    <div class="container content-container">
        <h2 class="text-center">Добавить категорию</h2>
    </div>

    <div class="container content-container">
        <div class="max-w-[700px] mx-auto flex">
            <input type="text">
        </div>
    </div>

</section>