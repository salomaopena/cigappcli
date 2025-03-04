<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 card p-4">
            <h4 class="text-secondary text-center mb-5"> Processo de pagamento simulado </h4>
            <h5 class="text-center mb-5">
                Introduza o seu cartão de crédito na máquina e insera o PIN de 4 dígitos
            </h5>

            <div class="mb-5">
                <?= form_open(site_url('/order/checkout/payment/confirm')) ?>
                <input type="hidden" name="pin_value" value="<?=Encrypt($pin_number)?>">
                <div class="row justify-content-center mb-3">
                    <div class="col-4">
                        <h4 class="text-center mb-3">PIN do seu cartão</h4>
                        <input type="text" class="form-control text-center" name="pin_number" id="pin_number" placeholder="0000" minlength="4" maxlength="4" required>
                    </div>
                </div>

                <?php if (!empty($error)): ?>
                    <h5 class="text-center text-danger"><?= $error ?></h5>
                <?php endif; ?>

                <div class="text-center mb-5">
                    <button type="submit" class="cig-primary">
                        <h6><i class="fas fa-check me-3"></i>Confirmar PIN</h6>
                    </button>
                </div>
                <div class="text-center">
                    <a href="<?= site_url('/order/checkout/payment/') ?>" class="cig-primary"><i class="fas fa-times me-2"></i>Canceler </a>
                </div>
                <?= form_close() ?>
                <div class="text-center mt-4">
                    <h4><?= $pin_number ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#pin_number').focus();
    document.querySelector('#pin_number').addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/[^0-9]/, '');
        if (e.target.value.length === 4) {
            document.querySelector('form').submit();
        }
    })

    document.querySelector('form').addEventListener('submit', (e) => {
        if (document.querySelector('#pin_number').value.length != 4) {
            e.preventDefault();
            //document.querySelector('form').submit();
        }
    })
</script>

<?= $this->endSection() ?>