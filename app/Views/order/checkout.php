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

                            <span id="btn-remove-<?= Encrypt($product['id']) ?>" class="cig-primary px-3 me-2" style="cursor:pointer">
                                <i class="fa-regular fa-trash-can"></i>
                            </span>

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



<!--Modal Dialog-->

<div class="modal fade" id="modal-remove-item" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-remove-item-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-remove-item-label">Remover item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1 class="text-danger text-center"><i class="fa-solid fa-exclamation-circle me-2"></i></h1>
                <h5 class="text-center">Deseja remover o item do pedido?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="cig-primary" data-bs-dismiss="modal"><i class="fa-solid fa-xmark me-3"></i>Não</button>
                <button type="button" class="cig-primary" id="btn-confirm"><i class="fa-solid fa-check me-3"></i>Sim</button>
            </div>
        </div>
    </div>
</div>

<!--End modal dialog-->

<script>
    let id = null;
    let btn_remove = document.querySelectorAll('[id^="btn-remove-"]');
    btn_remove.forEach(btn => {
        btn.addEventListener('click', () => {
            id = btn.id.split('-')[2];
            let modal = new bootstrap.Modal(document.querySelector('#modal-remove-item'));
            modal.show();
        });
    });


    let btn_confirm = document.querySelector('#btn-confirm');
    btn_confirm.addEventListener('click', () => {
        window.location.href = '<?= site_url('/order/remove/') ?>' + id;
    });
</script>

<?= $this->endsection() ?>