<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center p-5">
        <div class="col-6 border border-2 p-5">

            <div class="text-center">
                <img src="<?= base_url('assets/images/logo_bw.png') ?>" alt="Logo">
            </div>

            <br>
            <p class="display-1 text-center my-0 py-0"><strong>
                    <?= str_pad($order_number,3,0,STR_PAD_LEFT) ?>
                </strong></p>
            <p class="order-resume-final-font text-center">
                Por favor, dirija-se ao balcão, assim que os nossos colaboradores o informarem que o seu pedido está pronto.
            </p>

            <hr>

            <div class="order-resume-final-font text-center">
                <?php foreach ($order_products as $product) : ?>
                    <div class="mb-1">
                        <small>
                            <?= str_pad($product['quantity'] . ' x ' . $product['name'], 35, '.', STR_PAD_RIGHT) . str_pad(format_currency($product['total_price']), 10, '.', STR_PAD_LEFT) ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mb-5 order-resume-final-font text-center">
                <hr>
                <small>
                    <?= str_pad('TOTAL', 35, '.', STR_PAD_RIGHT) . str_pad(format_currency($total_price), 10, '.', STR_PAD_LEFT) ?>
                </small>
            </div>

            <div class="order-resume-final-font mb-3 text-center">
                <p class="mb-0 p-0"><?= $restaurant_details['name'] . ' | ' . $restaurant_details['address'] ?></p>
                <p class="mb-0 p-0"><?= $restaurant_details['phone'] . ' | ' . $restaurant_details['email'] ?></p>
            </div>

            <h6 class="text-center">Muito obrigado pela sua preferência</h6>

            <div class="order-resume-final-font text-center mb-3">
                <small>
                    <?= date('d-m-Y H:i:s') ?> | #<?= $order_series ?> | #<?= $order_number ?> | #<?= $order_code ?>
                </small>
            </div>

        </div>
    </div>

    <div class="text-center my-5">
        <a href="<?= site_url('/order') ?>" class="cig-primary"><i class="fa-regular fa-thumbs-up me-3"></i>Voltar</a>
    </div>

</div>

<?= $this->endSection('layouts/main_layout') ?>