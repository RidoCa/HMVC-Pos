<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="OneUIUX HTML website template by Maxartkiller. Bootstrap UI UX, Bootstrap theme, Bootstrap HTML, Bootstrap template, Bootstrap website, multipurpose website template. get bootstrap template, website">
	<meta name="author" content="Maxartkiller">

	<title>Point Of Sales</title>

	<!-- Favicons -->
	<!-- <link rel="apple-touch-icon" href="../assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="../assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="../assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="mask-icon" href="../assets/img/favicons/safari-pinned-tab.svg" color="#ffffff">
    <link rel="icon" href="../assets/img/favicons/favicon.ico"> -->

	<!-- Elegant font icons -->
	<link href="<?= base_url() . 'assets/css/style.css' ?>" rel="stylesheet">
	<!-- Material font icons -->
	<link href="<?= base_url() . 'assets/css/material-icons.css' ?>" rel="stylesheet">
	<!-- Font Awesome icons -->
	<link href="<?php echo base_url('assets/vendor/font-awesome/css/fontawesome-all.min.css'); ?>" rel="stylesheet">
	<!-- daterange picker -->
	<link href="<?= base_url() . 'assets/css/daterangepicker.css' ?>" rel="stylesheet">
	<!-- Swiper Slider -->
	<link href="<?= base_url() . 'assets/css/swiper.min.css' ?>" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="<?= base_url() . 'assets/css/style-blue.css' ?>" rel="stylesheet" id="style">
	<!-- SweetAlert 2 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.min.css'); ?>">
	<!-- Datatables -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
	<!-- 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->
</head>

<body class="ui-rounded">
	<!-- Page laoder -->
	<div class="container-fluid pageloader">
		<div class="row h-100">
			<div class="col-12 align-self-start text-center">
			</div>
			<div class="col-12 align-self-center text-center">
				<img class="img-fluid h-75 w-75 rotate" src="<?= base_url() . 'assets/img/splashcoin.png' ?>"> <br>
				<h4 class="logo-text"><span>SPLASH MARKET</span></h4>
			</div>
			<div class="col-12 align-self-end text-center">
				<p class="my-5">Please wait<br><small class="text-mute">S M A R T is loading...</small></p>
			</div>
		</div>
	</div>
	<!-- Page laoder ends -->

	<!-- Fixed navbar -->
	<header class="header fixed-top">
		<nav class="navbar">
			<div>
				<button class="menu-btn btn btn-link btn-44">
					<span class="icon material-icons">menu</span>
				</button>
			</div>
			<div>
				<a class="navbar-brand" href="<?= base_url() . 'dashboard' ?>">
					<div class="logo">1<span>UX</span><span>UI</span></div>
					<h4 class="logo-text"><span>SMART</span><small>Splash Market</small></h4>
				</a>
			</div>
			<div>
				<!-- <form class="form-inline search">
                    <input class="form-control w-100" type="text" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-link btn-44" type="submit"><span class="icon_search"></span></button>
                </form>
                <button class="btn btn-link search-btn" type="button"><span class="icon_search"></span></button> -->
				<a href="<?= base_url() . 'profile' ?>" class=""><span class="avatar avatar-30"><img src="<?= site_url() . 'assets/img/default_image.png' ?>"></span></a>
			</div>
		</nav>
	</header>
	<!-- Fixed navbar ends -->

	<!-- sidebar -->
	<div class="sidebar text-left">
		<div class="row no-gutters">
			<div class="col pl-3 align-self-center">
				<a class="navbar-brand" href="<?= base_url() . 'dashboard' ?>">
					<div class="logo">1<span>UX</span><span>UI</span></div>
					<h4 class="logo-text"><span>SMART</span><small>Splash Market</small></h4>
				</a>
			</div>
			<div class="col-auto align-self-center">
				<a href="<?= base_url() . 'login/logout' ?>" class="btn btn-link text-white p-2"><i class="material-icons">power_settings_new</i></a>
			</div>
		</div>
		<div class="list-group main-menu my-4">
			<?php
			if (count($menu) > 0) :
				for ($i = 0; $i < count($menu); $i++) :
					for ($y = 0; $y < count($menu[$i]['data']); $y++) : ?>
						<a href="<?= base_url() . $menu[$i]['data'][$y]['url'] ?>" class="list-group-item list-group-item-action <?= ($this->uri->segment(1) == $menu[$i]['data'][$y]['url'] ? 'active' : '') ?>">
							<i class="<?php echo $menu[$i]['data'][$y]['icon'] ?>"></i><?php echo $menu[$i]['data'][$y]['title'] ?>
						</a>
			<?php endfor;
				endfor;
			endif;
			?>
		</div>
	</div>
	<!-- sidebar ends -->

	<!-- Begin page content -->
	<main class="flex-shrink-0 main-container pb-0">
		<?= $content ?>
	</main>
	<!-- End of page content -->

	<!-- Footer -->
	<footer class="footer footer-dark mt-auto pt-3">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-12 col-md-auto  text-center">
					<a href="https://www.facebook.com/maxartkiller/" target="_blank" class="btn btn-link px-2"><span class="social_facebook"></span></a>
					<a href="https://twitter.com/maxartkiller" class="btn btn-link px-2" target="_blank"><span class="social_twitter"></span></a>
					<a href="https://www.linkedin.com/company/maxartkiller" class="btn btn-link px-2" target="_blank"><span class="social_linkedin"></span></a>
					<a href="https://www.instagram.com/maxartkiller/" class="btn btn-link px-2" target="_blank"><span class="social_instagram"></span></a>
					<a href="https://dribbble.com/maxartkiller" class="btn btn-link px-2" target="_blank"><span class="social_dribbble"></span></a>
				</div>
			</div>
			<hr>
			<p class="text-center">Copyright &copy; <?php echo date('Y') ?> MabaKoding. All rights reserved. Develop with </span><span class="text-danger">❤</span></p>
		</div>
	</footer>
	<!-- Footer ends -->

	<!-- scroll to top button -->
	<button type="button" class="btn btn-default default-shadow scrollup bottom-right position-fixed btn-44"><span class="arrow_carrot-up"></span></button>
	<!-- scroll to top button ends-->

	<!-- Required jquery and libraries -->
	<script src="<?= base_url() . 'assets/js/jquery-3.3.1.min.js' ?>"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->
	<script src="<?= base_url() . 'assets/js/popper.min.js' ?>"></script>
	<script src="<?= base_url() . 'assets/js/bootstrap.min.js' ?>"></script>
	<script src="<?= base_url('assets/js/sweetalert2.min.js'); ?>"></script>

	<!-- Datatables -->
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

	<!-- cookie css -->
	<script src="<?= base_url() . 'assets/js/jquery.cookie.js' ?>"></script>

	<!-- Swiper slider  -->
	<script src="<?= base_url() . 'assets/js/swiper.min.js' ?>"></script>

	<!-- date range picker -->
	<script src="<?= base_url() . 'assets/js/moment.min.js' ?>"></script>
	<script src="<?= base_url() . 'assets/js/daterangepicker.js' ?>"></script>

	<!-- Swiper slider  -->
	<script src="<?= base_url() . 'assets/js/jquery.sparkline.min.js' ?>"></script>

	<!-- Customized jquery file  -->
	<script src="<?= base_url() . 'assets/js/main.js' ?>"></script>
	<script src="<?= base_url() . 'assets/js/color-scheme-demo.js' ?>"></script>

	<script>
		"use strict"
		$(document).ready(function() {
			/* Swiper slider */
			var swiper = new Swiper('.swiper-categories', {
				slidesPerView: 'auto',
				spaceBetween: 0,
				pagination: false,
			});

			var swiper = new Swiper('.swiper-offers', {
				slidesPerView: 'auto',
				spaceBetween: 10,
				pagination: false,
			});

			/* swiper tavs  js */
			$('#recurring-tab[data-toggle="tab"]').on('shown.bs.tab', function(e) {
				var swiper = new Swiper('.swiper-container', {
					effect: 'coverflow',
					grabCursor: true,
					centeredSlides: true,
					slidesPerView: 'auto',
					spaceBetween: 10,
					coverflowEffect: {
						rotate: 30,
						stretch: 0,
						depth: 80,
						modifier: 1,
						slideShadows: true,
					}

				});

			});

			/* swiper tavs  js */
			$('#addexpense').on('shown.bs.modal', function(e) {
				$('.amount').focusin();

				/* calander picker */
				var start = moment().subtract(29, 'days');
				var end = moment();

				/* calander single  picker ends */
				$('.datepicker').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					drops: 'up',
					minYear: 1901
				}, function(start, end, label) {});

			});

			/* toast message */
			// setTimeout(function() {
			//     $('.toast').toast('show')
			// }, 2000);

			/* sparklines */
			$("#sparklines1").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7], {
				type: 'bar',
				height: '20px',
				barWidth: 2,
				barColor: '#e0eaff'
			});

		});
	</script>
</body>

</html>
