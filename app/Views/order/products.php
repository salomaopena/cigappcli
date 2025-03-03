<div class="container-fluid">
    <div class="row">
        <?php foreach ($products as $product): ?>

            <div class="col-4 text-center">

                <?php
                $linkable = $product['out_of_stock'] ? false : true;
                ?>

                <?php if ($linkable): ?>
                    <a href="<?= site_url('/order/add/' . Encrypt($product['id'])) ?>" class="no-link">
                    <?php endif; ?>

                    <div class="order-product<?= $linkable ? '' : '-not-linkable' ?>">
                        <img class="img-fluid" width="160" src="<?= API_IMAGE_URL . $product['image'] ?>" alt="<?= $product['name'] ?>">
                        <h3 class="order-product-title"><?= $product['name'] ?></h3>

                        <div class="d-flex justify-content-center align-items-center">
                            <?php if ($product['out_of_stock']): ?>
                                <span class="product-out-of-stock">Indisponível</span>
                            <?php else: ?>
                                <?php if ($product['has_promotion']): ?>
                                    <span class="order-product-old-price"><?= format_currency($product['old_price']) ?></span>
                                    <span class="order-product-price mx-1"><?= format_currency($product['price']) ?></span>
                                    <span class="discount-percentage"><?= number_format($product['promotion'], 0) . '%' ?></span>
                                <?php else: ?>

                                    <p class="order-product-price"><?= format_currency($product['price']) ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    </div>

                    <?php if ($linkable): ?>
                    </a>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>
    </div>
</div>