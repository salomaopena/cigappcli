<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-center mt-3">

    <div class="alert alert-warning p-3 shadow border border-danger">

        <h3 class="mb-3">
            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
        </h3>
        <h4><?= $error ?></h4>
    </div>
</div>
<?= $this->endSection() ?>