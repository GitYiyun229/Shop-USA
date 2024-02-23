<?php
$tmpl->addStylesheet('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('owl.theme.default.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('default', 'modules/home/assets/css');
$tmpl->addScript('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist');
$tmpl->addScript('default', 'modules/home/assets/js');

?>

<div class="page-home">
    <div class="d-flex gap-3 section-top mb-3">


        <div class="section-top-center">
            <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '1', 'style' => 'slide']); ?>


        </div>


    </div>
    <div class="container">
        <div class="section-top mb-3 mt-3">
            <h3 class="title-categories mb-3 mt-3"><?= FSText::_('Shop by categories') ?></h3>
            <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'view_menu_categories_home']); ?>
        </div>
        <div class="section-product bg-white mb-3">
            <div class="mb-2 section-title"><?php echo FSText::_('Gợi ý hôm nay') ?></div>
            <div class="categories d-flex align-items-center flex-wrap justify-content-between gap-3" role="tablist">
                <a class="text-title active" data-bs-toggle="tab" data-bs-target="#nav-0" type="button" role="tab" aria-controls="nav-0" aria-selected="true">
                    <?php echo FSText::_('Gợi ý phổ biến') ?>
                </a>
                <?php foreach ($categories as $item) {
                    $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id");
                ?>
                    <a title="<?php echo $item->name ?>" data-bs-toggle="tab" data-bs-target="#nav-<?php echo $item->id ?>" type="button" role="tab" aria-controls="nav-<?php echo $item->id ?>" aria-selected="false">
                        <?php echo $item->name ?>
                    </a>
                <?php } ?>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="nav-0" role="tabpanel" aria-labelledby="nav-0-tab" tabindex="0">
                    <div class="products d-flex flex-wrap product-gap">
                        <?php foreach ($products as $item) { ?>
                            <?php echo $this->layoutProductItem($item) ?>
                        <?php } ?>
                    </div>
                    <div class="loading-scroll w-100" limit="20" total-current="<?php echo count($products) ?>" total="<?php echo $total ?>" page="1"></div>
                </div>

                <?php foreach ($categories as $item) { ?>
                    <div class="tab-pane fade" id="nav-<?php echo $item->id ?>" role="tabpanel" aria-labelledby="nav-<?php echo $item->id ?>-tab" tabindex="0">
                        <div class="d-flex flex-wrap product-gap">
                            <?php foreach ($item->products as $prd) { ?>
                                <?php echo $this->layoutProductItem($prd) ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

       
    </div>
</div>