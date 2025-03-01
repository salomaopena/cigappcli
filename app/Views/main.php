<?=$this->extend('layouts/main_layout');?>
<?=$this->section('content')?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 card p-5 text-center">
            <h2 class="mb-5">
                <i class="fa-solid fa-spinner fa-spin"></i>
                Bem-vido ao <span class="cig-burguer-tlte"><strong>Cig burguer</strong></span>
            </h2>
            <h4 class="mb-5 cig-buger-punchline">Hambúrgueres com alma e sabor!</h4>
            <div class="d-flex justify-content-center">
                <a href="<?=site_url('/order')?>" class="cig-primary me-3">
                    <h3 class="p-5"><i class="fa-solid fa-utensils me-3"></i>Iniciar pedido</h3>
                </a>
            </div>
        </div>
</div>
</div>

<?=$this->endSection()?>