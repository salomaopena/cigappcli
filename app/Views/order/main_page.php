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

            <div class="text-center my-3">
                Produtos
            </div>
            <div class="text-center my-3">
                Cancelar | Finalizar
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('layouts/main_layout')?>
