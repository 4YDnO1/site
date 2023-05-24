<header class="header content-wrapper bg-green-100">
    <div class="container content-container flex gap-4 flex-wrap min-h-[80px] justify-between items-center py-4">

        <a href="/" class="flex gap-2 items-center">
            <img src="/assets/images/logotype.png" alt="Логотип" height="100" width="40"/>
            <span class="text-lg"><?=$app_name?></span>
        </a>

        <nav>
            <ul class="flex gap-4">
                <li><a class="page_link" href="/">О нас</a></li>
                <li><a class="page_link" href="/catalog.php">Каталог</a></li>
                <li><a class="page_link" href="/findus.php">Где нас найти?</a></li>
            </ul>
        </nav>

        <div class="flex gap-2">
            <? if (isset($_SESSION['user_data']['id'])): ?>
                <? if ($_SESSION['user_data']['role_id'] == 2): ?>
                    <a class="page_link" href="/admin">Админ панель</a>
                <? endif; ?>
                <a class="page_link" href="/cart.php">Корзина</a>
                <a class="page_link" href="/orders.php">Заказы</a>
                <a class="page_link" href="/logout.php">Выход</a>
            <? else: ?>
                <a class="page_link" href="/registration.php">Регистрация</a>
                <a class="page_link" href="/login.php">Вход</a>
            <? endif; ?>
        </div>

    </div>
</header>