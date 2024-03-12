<?php
$tmpl->addStylesheet('category', 'modules/products/assets/css');
$tmpl->addScript('category', 'modules/products/assets/js');
?>

<div class="container">
    <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
    <form action="<?php echo $canonical ?>" method="GET" class="page-products-category d-flex flex-wrap">

   

        <div class="section-main">
            <div class="section-item section-padding bg-white">
                <h1 class="cat-h1"><?php echo $cat->name ?></h1>
                <div class="section-banner">
                    <?php echo $tmpl->load_direct_blocks('banners', ['product_category_id' => $cat->id, 'style' => 'category']); ?>
                </div>
            </div>

            <div class="section-item section-padding bg-white section-filter-sort d-flex align-items-center gap-4">
                <?php foreach ($arrSort as $i => $item) {
                    $active = $i == $getSort ? 'active' : '';
                ?>
                    <a class="filter-sort position-relative <?php echo $active ?>" data="<?php echo $i ?>">
                        <?php echo $item ?>
                    </a>
                <?php } ?>
            </div>

            <div class="section-item section-products d-flex flex-wrap">
                <?php foreach ($products as $item) {
                    echo $this->layoutProductItem($item);
                } ?>
            </div>

            <div class="section-item loading-scroll w-100" category="<?php echo $cat->id ?>" limit="<?php echo $this->model->limit ?>" total-current="<?php echo count($products) ?>" total="<?php echo $total ?>" page="1"></div>
        </div>

        <input type="hidden" name="sort" value="<?php echo $getSort ?>">
        <input type="hidden" name="filter" value="<?php echo $getFilter ?>">
        <input type="hidden" name="price" value="<?php echo $getPrice ?>">
    </form>
</div>