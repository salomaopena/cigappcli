<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 card p-5">
            <?php if ($total_products == 0): ?>
                <h4 class="p-5 text-secondary text-center">Nenhum produto encontrado.</h4>
                <div class="text-center mb-5">
                    <a href="<?= site_url('/order') ?>" class="btn cig-primary"><i class="fa-solid fa-chevron-left me-2"></i>Voltar</a>
                </div>
            <?php else: ?>
                <h4 class="text-secondary">Itens do pedido</h4>
                <hr>
                <?php foreach ($order_products as $product): ?>
                    <div class="row">
                        <div class="col-7 d-flex align-items-center">


                        <a href="<?= site_url('/order/remove/' . Encrypt($product['id']))?>" class="cig-primary px-3 me-2"><i class="fa-regular fa-trash-can"></i></a>
                        <a href="<?= site_url('/order/add/' . Encrypt($product['id'])) ?>" class="cig-primary px-3 me-2"><i class="fa-solid fa-gear"></i></a>
                    

                            <img src="<?= API_IMAGE_URL . $product['image'] ?>" alt="<?= $product['name'] ?>" class="img-fluid rounded-5" width="100">
                            <p class="order-product-title me-3"><?= $product['name'] ?></p>
                        </div>

                        <div class="col d-flex align-items-center justify-content-end">

                            <h3>
                                <?= $product['has_promotion'] ? '<span class="discount-percentage">' . number_format($product['promotion'], 0) . '%</span>' : '' ?>

                                <?= $product['quantity'] ?> <span class="text-secondary">x</span> <?= format_currency($product['price']) ?>

                            </h3>
                        </div>

                        <div class="col d-flex align-items-center justify-content-end">
                            <h3 class="order-product-total-price">
                                <?= format_currency($product['total_price']) ?>
                            </h3>
                        </div>

                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="row">
                    <div class="col-8 text-end">
                        <h5>Total</h5>
                    </div>
                    <div class="col-4 text-end">
                        <h5 class="text-secondary">
                            <?= format_currency($total_price) ?>
                        </h5>
                    </div>
                </div>


                <div class="d-flex justify-content-between my-5">
                    <h5><a href="<?= site_url('/order/cancel') ?>" class="cig-primary p-3">
                            <i class="fa-solid fa-ban me-3"></i>Cancelar pedido
                        </a></h5>
                    <h5><a href="<?= site_url('/order') ?>" class="cig-primary p-3">
                            <i class="fa-solid fa-check me-3"></i>Voltar
                        </a></h5>
                    <h5><a href="<?= site_url('/order/checkout/payment') ?>" class="cig-primary p-3">
                            <i class="fa-regular fa-credit-card me-3"></i>Finalizar pedido
                        </a></h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endsection() ?>