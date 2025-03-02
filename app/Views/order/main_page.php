<?= $this->extend('layouts/main_layout')?>
<?= $this->section('content')?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col card p-4">

            <!-- Categorias-->
             <?= $this->include('order/order_category',['categories'=>$categories])?>

             <div class="text-center mt-3">
                <h3><?= $selected_category?></h3>
             </div>

            <div class="my-5">
                <?= $this->include('order/products',['products'=>$products])?>
            </div>
            <div class="text-center my-3">
                <a href="<?= site_url('order/cancel')?>">Cancelar pedido</a>
                <span class="mx-5">|</span>
                <a href="<?= site_url('order/checkout')?>">Finalizar pedido</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('layouts/main_layout')?>
