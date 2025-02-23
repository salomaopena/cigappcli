<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>

    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/bootstrap.min.css') ?>">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>

    <!-- logo -->

    <div class="d-flex justify-content-center p-3">
        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="logo" width="120">
    </div>

    <!--Content -->
    <?= $this->renderSection('content') ?>


    <!-- Footer -->
    <footer class="my-5 text-center text-muted">

        <p><i class="fa-solid fa-burger me-2"></i>
      &copy; 2022 - <?= date('Y') ?> <?= APP_NAME ?>. Todos os direitos reservados </p>
    </footer>


    <script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/fontawesome/js/all.min.js') ?>"></script>
</body>

</html>