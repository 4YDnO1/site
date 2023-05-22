<header class="header content-wrapper bg-cyan-100">
    <div class="container content-container flex gap-4 flex-wrap min-h-[80px] justify-between items-center">

        <a href="index.php" class="flex gap-2">
            <img src="/assets/images/logotype" alt="Логотип" />
            <span><?=$appn?></span>
        </a>

        <nav>
            <ul class="flex gap-2">
                <li><a href="/index.php">О нас</a></li>
                <li><a href="/catalog.php">Каталог</a></li>
                <li><a href="/findus.php">Где нас найти?</a></li>
            </ul>
        </nav>

        <div class="flex gap-2">
            <? if (isset($_SESSION['user_data']['id'])): ?>
                <? if ($_SESSION['user_data']['role_id'] == 2): ?>
                    <a href="/admin">Админ панель</a>
                <? endif; ?>
                <a href="/cart.php">Корзина</a>
                <a href="/logout.php">Выход</a>
            <? else: ?>
                <a href="/registration.php">Регистрация</a>
                <a href="/login.php">Вход</a>
            <? endif; ?>
        </div>

    </div>
</header>