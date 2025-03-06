<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col card p-4">

            <!-- Categorias-->
            <div class="mb-5">
                <?= $this->include('order/order_category', ['categories' => $categories]) ?>

            </div>

            <div class="mb-5">
                <?= $this->include('/order/order_info', ['total_items' => $total_items, 'total_price' => $total_price]) ?>
            </div>

            <div class="my-5">
                <?= $this->include('order/products', ['products' => $products]) ?>
            </div>
            <div class="d-flex gap-5 justify-content-center mt-4 mb-5">
               <h4><a href="<?= site_url('order/cancel') ?>" class="cig-primary py-4"><i class="fa-solid fa-ban me-3"></i>Cancelar pedido</a></h4> 
                
               <h4> <a href="<?= site_url('order/checkout') ?>" class="cig-primary py-4"><i class="fa-solid fa-check me-3"></i>Finalizar pedido</a> </h4> 
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('layouts/main_layout') ?>