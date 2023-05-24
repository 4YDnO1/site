<?php require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php"; ?>

<!DOCTYPE html>
<html lang="ru"><head>

	<?php
		$title = "О нас | Главная | ".$app_name;
		require_once $server_path."/require/head.php";
	?>
	<link rel="stylesheet" href="/assets/styles/base.css">
	<link rel="stylesheet" href="/assets/librarys/tailwind/tailwind-index.min.css">
	<link rel="stylesheet" href="/assets/librarys/swiper/swiper.css">
	<script src="/assets/librarys/tailwind/tailwind-index.min.js"></script>

</head><body><div class="page-wrapper">

	<?php require_once $server_path."/require/header.php"; ?>
	<main class="main">
		<?php require_once $server_path."/pages/about.php"; ?>
	</main>
	<?php require_once $server_path."/require/footer.php"; ?>

</div><div class="scripts-wrapper">

	<script src="/assets/librarys/jquery/jquery-3.6.3.min.js"></script>
	<script src="/assets/librarys/maskedinput/jquery.inputmask.bundle.min.js"></script>
	<script src="/assets/librarys/swiper/swiper.min.js"></script>
	<script src="/assets/scripts/common.js"></script>
	<script src="/assets/scripts/about.js"></script>

</div></body></html>