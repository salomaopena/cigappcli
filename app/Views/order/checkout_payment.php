<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col card p-4">
            <h4 class="text-center text-secondary">
                Os dados do seu pedido
            </h4>
            <hr>

            <div class="order-resume text-center">

                <?php foreach ($order_products as $product): ?>

                    <?php

                    $quantity = $product['quantity'];
                    $product_name = $product['name'];
                    $total_product_price = format_currency($product['price'] * $quantity);

                    ?>

                    <p><?= str_pad($quantity . ' x ' . $product_name, 60, '.', STR_PAD_RIGHT) . str_pad($total_product_price, 15, '.', STR_PAD_LEFT) ?></p>

                <?php endforeach; ?>
                <hr>
                <p><?= str_pad('Total', 60, '.', STR_PAD_RIGHT) . str_pad(format_currency($total_price), 15, '.', STR_PAD_LEFT) ?></p>
            </div>


            <div class="d-flex justify-content-center gap-3 my-3">
                <h4><a href="<?= site_url('/order/checkout')?>" class="cig-primary  mx-3 px-3 "><i class="fas fa-chevron-left me-2"></i>Voltar</a></h4>
                <h4><a href="<?= site_url('/order/payment/process')?>" class="cig-primary  mx-3 px-3"><i class="fa-regular fa-credit-card me-2"></i>Efetura pagamento</a></h4>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>