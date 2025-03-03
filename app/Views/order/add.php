<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 card p-5">

            <div class="row align-items-center">
                <div class="col-sm-6 text-center p-5">
                    <img src="<?= API_IMAGE_URL . $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <p class="order-product-title-large"><?= $product['name'] ?></p>
                    <p class="order-product-description"><?= $product['description'] ?></p>
                </div>


                <div class="col-sm-6 text-center">

                    <div class="d-flex justify-content-center align-items-center border rounded-5 bg-light p-4 gap-3">
                        <?php if ($product['has_promotion']): ?>
                            <span class="order-product-old-price"><?= format_currency($product['old_price']) ?></span>
                            <span class="order-product-price mx-1"><?= format_currency($product['price']) ?></span>
                            <span class="discount-percentage"><?= number_format($product['promotion'], 0) . '%' ?></span>
                        <?php else: ?>
                            <span class="order-product-price mx-1"><?= format_currency($product['price']) ?></span>
                        <?php endif; ?>

                    </div>


                    <div class="row my-5">
                        <div class="col text-end">
                            <button id="decrease-quantity" class="cig-primary px-5">
                                <h3><i class="fa-solid fa-minus"></i></h3>
                            </button>
                        </div>

                        <div class="col text-center align-items-center">
                            <p class="order-product-quantity">
                                <?= $quantity ?>
                            </p>
                        </div>

                        <div class="col text-start">
                            <button id="increase-quantity" class="cig-primary px-5">
                                <h3><i class="fa-solid fa-plus"></i></h3>
                            </button>
                        </div>

                    </div>


                    <div class="d-flex justify-content-between gap-5 align-items-center">
                        <a href="<?= site_url('/order') ?>" class="cig-primary">
                            <h5><i class="fa-solid fa-ban me-3"></i>Cancelar</h5>
                        </a>
                        <button id="accept" class="cig-primary">
                            <h5><i class="fa-solid fa-check me-3"></i>Aceitar</h5>
                        </button>

                    </div>
                </div>
            </div>



        </div>
    </div>

    <script>
        const btn_decrease_quantity = document.querySelector("#decrease-quantity");
        const btn_increase_quantity = document.querySelector("#increase-quantity");
        const btn_accept = document.querySelector("#accept");
        const product_order_quantity = document.querySelector(".order-product-quantity");
        const max_quantity = <?= MAX_QUANTITY_PER_PRODUCT ?>;
        let current_quantity = <?= $quantity ?>;
        let product_id ="<?= Encrypt($product['id'])?>";

        btn_decrease_quantity.addEventListener('click',()=>{
            if(current_quantity > 0){
                current_quantity--;
                product_order_quantity.textContent = current_quantity;
            }
        });

        btn_increase_quantity.addEventListener('click',()=>{
            if(current_quantity < max_quantity){
                current_quantity++;
                product_order_quantity.textContent = current_quantity;
            }
        });

        btn_accept.addEventListener('click',()=>{
            window.location.href = `<?= site_url("/order/add/confirm/")?>${product_id}/${current_quantity}`;
        });

    </script>
    <?= $this->endsection() ?>