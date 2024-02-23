<?php if ($total_news_list) {
    for ($i = 0; $i < $total_news_list; $i++) {
        $news = $news_list[$i];
        $link_news = FSRoute::_("index.php?module=news&view=news&id=" . $news->id . "&code=" . $news->alias . "&ccode=" . $news->category_alias . "&Itemid=$Itemid");
        $images_first = URL_ROOT . str_replace('/original/', '/large/', $news->image);
        $images = URL_ROOT . str_replace('/original/', '/resized/', $news->image);
        ?>
        <?php if ($i == 0) { ?>
            <div class="col-sm-8">
                <a href="<?php echo $link_news ?>">
                    <img data-src="<?php echo $images_first ?>" alt='<?php echo $news->title; ?>'>
                </a>
                <a class="title" href="<?php echo $link_news ?>"><?php echo $news->title; ?></a>
                <p><?php echo getWord(100, $news->summary); ?></p>
            </div>
        <?php } ?>
        <?php if ($i == 1) { ?>
            <div class="col-sm-4">
                <a href="<?php echo $link_news ?>">
                    <img data-src="<?php echo $images ?>" alt='<?php echo $news->title; ?>'>
                </a>
                <a class="titlesub" href="<?php echo $link_news ?>"><?php echo $news->title; ?></a>
            </div>
        <?php } ?>
        <?php if ($i > 1 && $i <= 4) { ?>
            <div class="col-sm-4 item-border">
                <a class="titlesubsub" href="<?php echo $link_news ?>"><?php echo $news->title; ?></a>
            </div>
        <?php } ?>
        <?php if ($i > 4) { ?>
            <div class="col-sm-12">
                <div class="item-news">
                    <div class="row">
                        <a class="item-images col-sm-4" href="<?php echo $link_news ?>">
                            <img data-src="<?php echo $images ?>" alt='<?php echo $news->title; ?>'>
                        </a>
                        <div class="col-sm-8">
                            <a class="title" href="<?php echo $link_news ?>"><?php echo $news->title; ?></a>
                            <span class="datetime"><?php echo date('H:s   d/m/Y', strtotime($news->created_time)); ?></span>
                            <p><?php echo getWord(100, $news->summary); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php }
} ?>