<a href="<?= site_url('/order/checkout')?>" class="no-link">
    <div class="mx-3 p-3 text-center order-info-link">
        <i class="fa-solid fa-list-check display-6 me-3"></i>
        <span class="display-6"><strong><?= $total_items?> </strong></span>
        <span class="mx-5 align-items-center"><strong>|</strong></span>
        <i class="fa-solid fa-cart-shopping display-6 me-3"></i>
        <span class="display-6"><strong><?= format_currency($total_price)?> </strong></strong></span>
    </div>
</a>
