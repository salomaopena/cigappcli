<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 card p-5">
            <div class="text-center">

                <h4 class="my-5 text-center">Deseja cancelar o seu pedido?</h4>

                <div class="d-flex justify-content-center gap-3 mb-5">
                    <h5><a href="<?= site_url('/order') ?>" class="cig-primary me-3"><i class="fa-solid fa-times me-3"></i>Não</a></h5>
                    <h5><a href="<?= site_url('/') ?>" class="cig-primary me-3"><i class="fa-solid fa-check me-3"></i>Sim</a></h5>
                </div>

                <div class="text-center">
                    Produtos no pedido: <strong><?= $total_items ?></strong>
                    <p class="mb-0">Todos os itens do seu pedido serão excluídos.</p>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endsection() ?>