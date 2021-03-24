<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="OneUIUX HTML website template by Maxartkiller. Bootstrap UI UX, Bootstrap theme, Bootstrap HTML, Bootstrap template, Bootstrap website, multipurpose website template. get bootstrap template, website">
    <meta name="author" content="Maxartkiller">

    <title>Point Of Sales</title>

    <!-- Favicons -->
    <!-- <link rel="apple-touch-icon" href="<?= base_url() . 'assets/img/favicons/apple-touch-icon.png' ?>" sizes="180x180">
    <link rel="icon" href="<?= base_url() . 'assets/img/favicons/favicon-32x32.png' ?>" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url() . 'assets/img/favicons/favicon-16x16.png' ?>" sizes="16x16" type="image/png">
    <link rel="mask-icon" href="<?= base_url() . 'assets/img/favicons/safari-pinned-tab.svg' ?>" color="#ffffff">
    <link rel="icon" href="<?= base_url() . 'assets/img/favicons/favicon.ico' ?>"> -->

    <!-- Elegant font icons -->
    <link href="<?= base_url() . 'assets/css/style.css' ?>" rel="stylesheet">
    <!-- Material font icons -->
    <link href="<?= base_url() . 'assets/css/material-icons.css' ?>" rel="stylesheet">
    <!-- Swiper Slider -->
    <link href="<?= base_url() . 'assets/css/swiper.min.css' ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?= base_url() . 'assets/css/style-blue.css' ?>" rel="stylesheet" id="style">
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
    <!-- Begin page content -->
    <main class="flex-shrink-0 main-container py-0">
        <?php echo $content ?>
    </main>
    <!-- End of page content -->
    <!-- scroll to top button -->
    <button type="button" class="btn btn-default default-shadow scrollup bottom-right position-fixed btn-44"><span class="arrow_carrot-up"></span></button>
    <!-- scroll to top button ends-->

    <!-- Required jquery and libraries -->
    <script src="<?= base_url() . 'assets/js/jquery-3.3.1.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/js/popper.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/js/bootstrap.min.js' ?>"></script>

    <!-- cookie css -->
    <script src="<?= base_url() . 'assets/js/jquery.cookie.js' ?>"></script>

    <!-- Swiper slider  -->
    <script src="<?= base_url() . 'assets/js/swiper.min.js' ?>"></script>

    <!-- Customized jquery file  -->
    <script src="<?= base_url() . 'assets/js/main.js' ?>"></script>
    <script src="<?= base_url() . 'assets/js/color-scheme-demo.js' ?>"></script>

    <script>
        "use strict"
        $(document).ready(function() {
            /* Swiper slider */
            var swiper = new Swiper('.introslider', {
                autoplay: true,
                pagination: {
                    el: '.swiper-pagination',
                },
            });
        });
    </script>
</body>

</html>