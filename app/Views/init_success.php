<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-10">

            <div class="card bg-light p-4">

                <div class="row">
                    <div class="col">
                        <h4>System initiated</h4>
                    </div>
                    <div class="col">
                        <p>Date: <strong><?= $initiated_at ?></strong></p>
                    </div>
                    <div class="col text-end">
                        <a href="<?= base_url('/') ?>" class="cig-primary"><i class="fas fa-chevron-right me-2"></i>Avançar</a>
                    </div>
                </div>
                <hr>
                <p>Restaurant ID: <strong><?= $restaurant_id ?></strong></p>
                <p>Restaurant Name: <strong><?= $restaurant_name ?></strong></p>
                <hr>
                <p>Categories: <strong><?= count($categories) ?></strong></p>
                <table class="table">
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?= $category ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <hr>
                <p>Products: <strong><?= count($products) ?></strong></p>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Image</th>
                            <th>Product</th>
                            <th class="text-center">Stock</th>
                        </tr>
                    </thead>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td class="text-center"><img src="<?= API_IMAGE_URL. $product['image'] ?>" alt="<?= $product['name'] ?>" class="img-fluid" style="max-width: 50px;"></td>
                            <td class="align-middle"><?= $product['name'] ?></td>
                            <td class="text-center align-middle"><?= $product['stock'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>