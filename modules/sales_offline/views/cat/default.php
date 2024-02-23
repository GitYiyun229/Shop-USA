<?php
global $tmpl, $config;
$tmpl->addStylesheet('cat', 'modules/' . $this->module . '/assets/css');
//$tmpl->addStylesheet('hotdeal', 'modules/' . $this->module . '/assets/css');
//$tmpl->addStylesheet('cat', 'modules/' . $this->module . '/assets/css');
$tmpl->addScript('countdown', 'modules/' . $this->module . '/assets/js');
$tmpl->addScript('sales', 'modules/' . $this->module . '/assets/js');
$time_now1 = date('Y-m-d H:i:s');
$time_now = date('M d Y H:i:s');

//var_dump($time_now);
//$time_end = $cat->tdate;
$time_end =  date('M d Y H:i:s', strtotime($cat->tdate));
$time_start =   date('M d Y H:i:s', strtotime($cat->fdate));
//var_dump($cat);
//var_dump($time_start);
//var_dump($time_end);
//    echo 1;die;
?>
<style>

</style>
<!-- BREADCRUMBS-->
<script language="javascript" type="text/javascript"
        src="<?php echo URL_ROOT ?>libraries/jquery/jquery-1.11.0.min.js"></script>
<span id="demo"></span>

<div class="banner_sale_off">
    <a href="<?php echo $cat->link ?>">
        <img src="<?php echo $cat->icon ?>" alt="<?php echo $cat->name ?>" class="img-responsive" style="width: 100%;">
    </a>
</div>
<div class="clearfix"></div>
<div class="container">
    <div class="body_sale">
        <div class="cout_down">
            <span class="dem"><?php echo $cat->name_display ?>:</span>
            <?php if ($time_now < $time_start) { ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        start('<?php echo $time_start ?>', '<?php echo $cat->id ?>');
                    });
                </script>
            <?php }else{ ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        // alert(1);
                        start('<?php echo $time_end ?>', '<?php echo $cat->id ?>');
                    });
                </script>
            <?php } ?>
            <p class="time_coundown" id="demo<?php echo $cat->id ?>"></p>
        </div>
        <div class="content_sale">
            <?php echo html_entity_decode($cat->content) ?>
        </div>
        <div class="box_products">
            <?php
            //            var_dump($cats);
            foreach ($cats

            as $item) {
            $phone = $model->get_records('published = 1 AND is_sale_special != 1  AND sale_off_id = ' . $item->id . ' ORDER BY sale_odering ASC limit 4', 'fs_products', 'id, name,sale_off_id,list_sale_off_id,image,price,h_price,h_price_old,discount, category_id,category_alias,alias,color_code,keyword,alt_images,price_off, 
                price_special, quant_off, quan_special, stdate, fndate, is_sale_special,condition_sale');
            //                var_dump($phone);
            $phone_special = $model->get_record('published = 1 AND is_sale_special = 1  AND sale_off_id = ' . $item->id . ' ORDER BY sale_odering DESC Limit 1', 'fs_products', '*');
            //                $price_spc ='';
            //                if (isset($phone_special) && !empty($phone_special)) {
            //                    $product_active_special = $model->get_record('published = 1 and product_id=' . $phone_special->id . ' and price_h = ' . $phone_special->h_price . ' order by price asc limit 1', 'fs_products_sub', '*');
            //                    $cat_special = $model->get_record('published = 1 and id = ' . $phone_special->sale_id, 'fs_sales_categories', 'id, name, fdate, tdate');
            //                    if ($cat_special) {
            //                        $time_start_spc = $cat_special->fdate;
            //                        $time_end_spc = $cat_special->tdate;
            //                        if ($time_start_spc <= $time_now && $time_end_spc >= $time_now) {
            //                            $price_spc = $phone_special->h_price;
            //                        } else {
            //                            $price_spc = $phone_special->price;
            //                        }
            //                    } else {
            //                        $price_spc = $phone_special->price;
            //                    }
            //                }
            //                                var_dump($phone_special);
            ?>
            <?php if ($phone || $phone_special) { ?>
            <div class="list_prd_<?php echo $item->id ?> list_prd">
                <h3 class="name_cat_sale">
                    <img src="<?php echo URL_ROOT . $item->icon1 ?>" alt="<?php echo $item->name ?>"
                         class="img-responsive">
                </h3>
                <?php if (isset($phone_special) && !empty($phone_special)) {
//var_dump($phone_special);
                    ?>
                    <div class="prd_special"
                         style="background: url('<?php echo URL_ROOT . $phone_special->background_special ?>') center repeat;">
                        <div class="row row_1">
                            <div class="col-md-5 l_prd"
                                 <?php if ($phone_special->background_special1) { ?>style="background: url('<?php echo URL_ROOT . $phone_special->background_special1 ?>')"<?php } ?>>
                                <p class="discount_prd">
                                    <img src="<?php echo URL_ROOT . str_replace('/original', 'resized', $cat->sticky) ?>"
                                         alt="khuyến mại" class="img-responsive">
                                    <span style="color: <?= $cat->color_sticky ?>"><?php echo format_money($phone_special->price - $phone_special->price_special, 'đ') ?></span>
                                </p>
                                <div class="clearfix"></div>
                                <a href="<?php echo FSRoute::_('index.php?module=products&view=product&code=' . $phone_special->alias . '&id=' . $phone_special->id . '&ccode=' . $phone_special->category_alias . '&Itemid=5') ?>">
                                    <img src="<?php echo URL_ROOT . str_replace('original', 'original', $phone_special->image_special) ?>"
                                         alt="<?php echo $item->name ?>" class="img-responsive img_prd">
                                </a>
                                <?php if ($cat->icon_hot) { ?>
                                    <img src="<?php echo URL_ROOT . str_replace('/original', 'resized', $cat->icon_hot) ?>"
                                         alt="hot" class="img-responsive img_hot">
                                <?php } ?>
                            </div>
                            <div class="col-md-7 r_prd text-center">
                                <p class="time_dead"
                                   style="color: <?php echo $phone_special->color_time ?>;background-color: <?php echo $phone_special->bgrcolor_time ?>;">
                                    Thời gian:
                                    <span><?php echo date('d-m-Y', strtotime($phone_special->fndate)) ?></span>
                                </p>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        // alert(1);
                                        start2('<?php echo date('M d Y H:i:s', strtotime($phone_special->fndate)) ?>', '<?php echo $phone_special->id ?>', '<?php echo $phone_special->numcolor_countdown ?>', '<?php echo $phone_special->bgrcolor_countdown ?>', '<?php echo $phone_special->wordcolor_countdown ?>');
                                    });
                                </script>

                                <p class="time_coundown" id="demo<?php echo $phone_special->id ?>"></p>

                                <h3 class="name_prd_spc"
                                    style="color: <?php echo $phone_special->color_sale ?>"><?php echo $phone_special->name ?></h3>
                                <p class="price_display">
                                    <img src="<?php echo URL_ROOT . $phone_special->img_price_special ?>"
                                         alt="giá khuyến mãi">
                                    <?php
                                    if ($phone_special->stdate <= $time_now1 && $time_now1 <= $phone_special->fndate) { ?>
                                        <span style="color: <?= $phone_special->color_font ?>"><?php echo format_money($phone_special->price_special, 'đ') ?></span>
                                    <?php } else { ?>
                                        <span style="color: <?= $phone_special->color_font ?>"><?php echo format_money($phone_special->price, 'đ') ?></span>
                                    <?php } ?>
                                </p>
                                <?php if ($phone_special->stdate <= $time_now1 && $time_now1 <= $phone_special->fndate) { ?>
                                    <p class="price_old_spc" style="color: <?= $phone_special->color_font_ ?>">Giá gốc:
                                        <span><?php echo format_money($phone_special->price, 'đ') ?></span></p>
                                <?php } ?>
                                <span class="quan_special"><?php if ($phone_special->quan_special && $phone_special->quan_special > 0) {
                                        echo $phone_special->quan_special . ' Suất';
                                    } else {
                                        echo 'Hết suất';
                                    } ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>
                <div class="sale_normal row"
                ">
                <div class="box_normal" id="list_prd<?php echo $item->id ?>">
                    <?php
                    foreach ($phone as $key) {
                        $link = FSRoute::_('index.php?module=products&view=product&code=' . $key->alias . '&id=' . $key->id . '&ccode=' . $key->category_alias . '&Itemid=5');
                        ?>
                        <div class="col-md-3 col-sm-3 col-xs-6 prd_normal">
                            <div class="prd_normal_detail">
                                <a href="<?php echo $link ?>" class="link_prd">
                                    <p class="discount_prd">
                                        <img src="<?php echo URL_ROOT . str_replace('/original', 'resized', $cat->sticky) ?>"
                                             alt="khuyến mại" class="img-responsive">
                                        <span style="color: <?= $cat->color_sticky ?>"><?php echo format_money($key->price - $key->price_off, 'đ') ?></span>
                                    </p>
                                    <img src="<?php echo URL_ROOT . str_replace('original', 'resized', $key->image) ?>"
                                         alt="<?php echo $key->name ?>" class="img-responsive img_normal">
                                    <h3 class="name_prd_normal"><?php echo $key->name ?></h3>
                                    <p style="background-color: <?= $cat->bgr_color_price ?>"
                                       class="price_normal text-center">
                                        <span style="color: <?= $cat->color_price ?>"
                                              class="price_sale_normal"><?php echo format_money($key->price_off, 'đ') ?></span>
                                        <span style="color: <?= $cat->color_price ?>"
                                              class="price_no_sale"><?php echo format_money($key->price, 'đ') ?></span>
                                    </p>
                                </a>
                                <div style="background: <?= $cat->bgr_content_saleup ?>" class="condition_sale">
                                    <span style="color: <?= $cat->color_saleup ?>;background: <?= $cat->bgr_color_saleup ?>">Khuyến mãi</span>
                                    <p style="color: <?= $cat->color_content_saleup ?>"><?php echo $key->condition_sale ?></p>
                                </div>
                                <div class="time_normal">
                                    <?php if ($key->quant_off && $key->quant_off > 0) { ?>
                                        <span style="color: <?= $cat->color_stock ?>;background: <?= $cat->bgr_color_stock ?>"
                                              class="quan_normal still">Còn suất</span>
                                    <?php } else { ?>
                                        <span style="color: <?= $cat->color_stock ?>;background: <?= $cat->bgr_color_ofstock ?>"
                                              class="quan_normal over">Hết suất</span>
                                    <?php } ?>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            // alert(1);
                                            start1('<?php echo date('M d Y H:i:s', strtotime($item->tdate)) ?>', '<?php echo $key->id ?>');
                                        });
                                    </script>
                                    <span class="time_coundown" id="demo<?php echo $key->id ?>"></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="pagination">
                <a id="load_more_sales" class="load_more" data-cat_id="<?php echo $cat->id ?>"
                   data-id="<?php echo $item->id ?>" data-pagecurrent="1" title="Next page"
                   data-class="list_prd"
                   data-nextpage="2" limit="4" href="javascript: void(0);"
                   data-list="list-product-hot"> Xem
                    thêm <i class="fa fa-sort-down"></i></a>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <div class="note_sale">
        <div class="content_sale1">
            <?php echo html_entity_decode($cat->note_sale) ?>
        </div>
    </div>
    <div class="banner_sale_off1">
        <?php foreach ($banner as $item) { ?>
            <div class="banner_detail">
                <a href="<?php echo $item->link ?>">
                    <img src="<?php echo URL_ROOT . $item->image ?>" alt="<?php echo $item->name ?>"
                         class="img-responsive">
                </a>
            </div>
        <?php } ?>
    </div>
</div>
<div class="clearfix"></div>