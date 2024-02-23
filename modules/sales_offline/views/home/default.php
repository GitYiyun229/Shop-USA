<?php
global $tmpl, $config;
$tmpl->addStylesheet('sale_home', 'modules/' . $this->module . '/assets/css');
//$tmpl->addStylesheet('hotdeal', 'modules/' . $this->module . '/assets/css');
//$tmpl->addStylesheet('cat', 'modules/' . $this->module . '/assets/css');
//$tmpl->addScript('countdown', 'modules/' . $this->module . '/assets/js');
//$tmpl->addScript('sales', 'modules/' . $this->module . '/assets/js');
// var_dump($cats);
//    echo 1;die;
$time_now = date('Y-m-d H:i:s');
//echo $time_now;
?>
<!-- BREADCRUMBS-->
<script language="javascript" type="text/javascript"
        src="<?php echo URL_ROOT ?>libraries/jquery/jquery-1.11.0.min.js"></script>
<div class="slogan_sale">Khuyến mại hot</div>
<div class="list_sale_parent">
    <div class="row box_row">
        <?php
        foreach ($list_sale_parent as $item) {
            $link = FSRoute::_('index.php?module=sales_offline&view=cat&ccode='.$item->alias.'&Itemid=150');
            ?>
            <div class="col-md-4 col-sm-4 col-xs-6 box_col">
                <a href="<?php echo $link ?>" title="<?php echo $item->name; ?>" class="detail_box">
                    <img src="<?php echo URL_ROOT . $item->image; ?>" alt="<?php echo $item->name; ?>"
                         class="img-responsive">
                    <div class="infor">
                        <h3><?php echo $item->name; ?></h3>
                        <div class="bot_sale">
                            <div class="right_bot">
                                <p class="time_off"><?php echo date('d/m/Y', strtotime($item->fdate)) ?>
                                    <span> - <?php echo date('d/m/Y', strtotime($item->tdate)) ?></span>
                                </p>
                                <?php
                                if ($item->fdate <= $time_now && $time_now <= $item->tdate) {
                                    ?>
                                    <p class="dang">Đang diễn ra</p>
                                <?php }elseif($time_now > $item->tdate){ ?>
                                    <p class="het">Đã hết hạn</p>
                                <?php }elseif ($time_now < $item->fdate){ ?>
                                    <p class="dang">Sắp diễn ra</p>
                                <?php } ?>
                            </div>
                            <div class="left_bot <?php if ($item->fdate <= $time_now && $time_now <= $item->tdate) {echo 'ing';}else{echo 'ed';}?>">Xem chi tiết</div>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>

