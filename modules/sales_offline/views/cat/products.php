<!--<div class="list_prd_--><?php //echo $item->id ?><!-- list_prd">-->

<!--        <div class="sale_normal row">-->
            <?php
            foreach ($phone as $key) {
                $link = FSRoute::_('index.php?module=products&view=product&code=' . $key->alias . '&id=' . $key->id . '&ccode=' . $key->category_alias . '&Itemid=5');
                ?>
                <div class="col-md-3 col-sm-3 col-xs-6 prd_normal">
                    <div class="prd_normal_detail">
                        <a href="<?php echo $link ?>" class="link_prd">
                            <p class="discount_prd">
                                <img src="<?php echo URL_ROOT . str_replace('/original', 'resized', $cat_parent->sticky) ?>"
                                     alt="khuyến mại" class="img-responsive">
                                <span style="color: <?= $cat_parent->color_sticky ?>"><?php echo format_money($key->price - $key->price_off, 'đ') ?></span>
                            </p>
                            <img src="<?php echo URL_ROOT . str_replace('original', 'resized', $key->image) ?>"
                                 alt="<?php echo $key->name ?>" class="img-responsive img_normal">
                            <h3 class="name_prd_normal"><?php echo $key->name ?></h3>
                            <p style="background-color: <?= $cat_parent->bgr_color_price ?>"
                               class="price_normal text-center">
                                        <span style="color: <?= $cat_parent->color_price ?>"
                                              class="price_sale_normal"><?php echo format_money($key->price_off, 'đ') ?></span>
                                <span style="color: <?= $cat_parent->color_price ?>"
                                      class="price_no_sale"><?php echo format_money($key->price, 'đ') ?></span>
                            </p>
                        </a>
                        <div style="background: <?= $cat_parent->bgr_content_saleup ?>" class="condition_sale">
                            <span style="color: <?= $cat_parent->color_saleup ?>;background: <?= $cat_parent->bgr_color_saleup ?>">Khuyến mãi</span>
                            <p style="color: <?= $cat_parent->color_content_saleup ?>"><?php echo $key->condition_sale ?></p>
                        </div>
                        <div class="time_normal">
                            <?php if ($key->quant_off && $key->quant_off > 0) { ?>
                                <span class="quan_normal still">Còn suất</span>
                            <?php } else { ?>
                                <span class="quan_normal over">Hết suất</span>
                            <?php } ?>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    // alert(1);
                                    start1('<?php echo date('M d Y H:i:s', strtotime($cat_detail->tdate)) ?>', '<?php echo $key->id ?>');
                                });
                            </script>
                            <span class="time_coundown" id="demo<?php echo $key->id ?>"></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="clearfix"></div>
<!--        </div>-->

<script src="<?php echo URL_ROOT ?>modules/sales_offline/assets/js/countdown.js?v=5.1"></script>
<!--</div>-->