<div class="d-flex justify-content-center flex-col-flex-wrap gap-1">
    <?php foreach ($categories as $category): ?>
        <a href="<?= site_url('order/set_filter/'.Encrypt($category['category']))?>" class="category-link">
            <div class="category">
                <img src="<?= base_url('assets/images/categories/' . strtolower($category['category']) . '.png') ?>" alt="<?= $category['category'] ?>">
                <p class="p-0 m-0 ms-2"><?= $category['category'] ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>