<?= $this->extend('layouts/main_layout')?>
<?= $this->section('content')?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 card p-5">
            <div class="text-center">
                <h4 class="mb-5">Deseja cancelar o seu pedido?</h4>
                <a href="<?= site_url('/order')?>" class="cig-primary me-3">Não</a>
                <a href="<?= site_url('/')?>" class="cig-primary me-3">Sim</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection()?>
