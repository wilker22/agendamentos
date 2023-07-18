<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Meus agendamentos | <?php echo $this->renderSection('title'); ?></title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sticky-footer-navbar/">



    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('front/'); ?>bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <?php echo $this->renderSection('css'); ?>
</head>

<body class="d-flex flex-column h-100">

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo route_to('home'); ?>">Meus agendamentos</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo route_to('home'); ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo route_to('schedules.new'); ?>">Criar agendamentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo route_to('schedules.my'); ?>">Meus agendamentos</a>
                        </li>
                    </ul>
                    <div class="d-flex">

                        <ul class="navbar-nav me-auto mb-2 mb-md-0">

                            <?php if (auth()->loggedIn()) : ?>

                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="<?php echo route_to('logout'); ?>">Sair</a>
                                </li>

                            <?php else : ?>

                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo route_to('login'); ?>">Entrar | Registrar-se</a>
                                </li>

                            <?php endif; ?>

                        </ul>

                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Begin page content -->
    <main class="flex-shrink-0">


        <?php echo $this->renderSection('content'); ?>


    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">Place sticky footer content here.</span>
        </div>
    </footer>


    <script src="<?php echo base_url('front/'); ?>bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <?php echo $this->renderSection('js'); ?>


    <script>
        const setParameters = (object) => {

            return (new URLSearchParams(object)).toString();
        }

        const setHeadersRequest = () => {

            return {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }

        const showErrorMessage = (message) => {

            boxErrors.innerHTML = '';

            return `<div class="alert alert-danger">${message}</div>`;
        }
    </script>

</body>

</html>