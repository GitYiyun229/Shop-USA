<?php  	global $tmpl;
$tmpl -> addStylesheet('detail','modules/news/assets/css');
$tmpl -> addStylesheet('detail','modules/news/assets/css');
$tmpl -> addScript('form');
$tmpl -> addScript('main');
$tmpl -> addScript('detail','modules/news/assets/js');
//$tmpl -> addScript('product24h','modules/products/assets/js');
FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);
?>
<div class="news_detail wapper-page wapper-page-detail">
<div class="wapper-content-page mt20">
	<!-- NEWS NAME-->	
	<h1 class='content_title'>
		<span><?php	echo $data -> title; ?></span>
	</h1>
	
	<!-- end NEWS NAME-->
			
	<!-- DATETIME -->
    <div class="clock clearfix">
			<span class='datetime'><i class="fa fa-calendar" aria-hidden="true"></i>	<?php echo date('d/m/Y',strtotime($data -> created_time)); ?></span>
			<span class="view"><i class="fa fa-eye" aria-hidden="true"></i> <?php	echo $data->hits; ?></span>
			<?php if ($data ->action_username) {?>
				<span class="view"><i class="fa fa-user" aria-hidden="true"></i> <?php	echo $data->action_username; ?></span>
			<?php } ?>	
			<span class="">
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58c7c502fd1f8e9b"></script>
            	<div class="addthis_inline_share_toolbox"></div>
			</span>				
    </div>
	<!-- end DATETIME-->
		

	<?php if(count($relate_news_list_by_tags)){?>
	<div class='relate_t'>
		<?php $i = 0;?>
		<?php foreach($relate_news_list_by_tags as $item){?>
			<?php $link_news = FSRoute::_("index.php?module=news&view=news&code=".$item->alias."&id=".$item -> id."&ccode=".$item -> category_alias."&Itemid=$Itemid"); ?>
			<h2 class="relate_item flever_12">
				<a href="<?php echo $link_news; ?>" title="<?php echo $item -> title; ?>"><?php echo $item -> title; ?></a>
			</h2>
			<?php $i++;?>
			<?php if($i > 2) break;?>
		<?php }?>
			
	</div>
	<?php }?>
	<div class='description clearfix' style="margin-top: 10px">
		<?php   echo $description; ?>
	</div>
	<?php if (@$products_related){ ?>
		<div class="buy-bottom">
            <div class="media-img " >
                <img class="img-responsive " src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $products_related -> image); ?>" alt="<?php echo $products_related->name;?>">
                <div class="lef-b">
                    <p><?php echo $products_related->name ?></p>
                    <span  class='_price '>
                        <?php echo format_money($products_related->price,' đ') ?>
                    </span>
                </div>
            </div>

            <div class="btn-add">
                <a  id="buy-now"  href="<?php echo FSRoute::_('index.php?module=products&view=product&code='.$products_related->alias.'&id='.$products_related->id.'&ccode='.$products_related->category_alias.'')?>" class="btn-buy btn mt10" data-toggle="modal">
                    Mua hàng ngay
                </a>
                <?php if ($products_related->is_service == 0 && $products_related->is_accessories == 0) { ?>
                <a  id="buy-pig" href="<?php echo FSRoute::_('index.php?module=products&view=product&code='.$products_related->alias.'&id='.$products_related->id.'&ccode='.$products_related->category_alias.'')?>" class="btn-buy btn mt10" data-toggle="modal">
                    Mua trả góp
                </a>
                <?php } ?>
            </div>

        </div>
	<?php } ?>

	<!--	RELATED	-->
	<?php include_once 'default_related.php'; ?>

	<div class="frame-content  hidden-md hidden-sm hidden-xs">
		<? include_once("comment_facebook.php");?>
	</div>
	
	
	<input type="hidden" value="<?php echo $data->id; ?>" name='news_id' id='news_id'  />
	</div>
</div>

<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": "<?php echo $link_news; ?>",
      "headline": "<?php	echo str_replace('"','',$data -> title) ?>",
      "author": {
          "@type": "Person",
          "name": "<?php echo $data ->action_username ? $data ->action_username:'24hstore' ?>"
        },
      "publisher": {
          "@type": "Organization",
          "name": "24hstore",
          "logo": {
            "@type": "ImageObject",
            "url": "https://24hstore.vn/images/config/logo_03_1506932598.png",
            "width": 80,
            "height": 36
            }
      },
      "image": {
        "@type": "ImageObject",
        "url": "<?php echo URL_ROOT.str_replace('/original/','/original/', $data->image) ?>",
        "height": 280,
        "width": 160
      },
      "datePublished": "<?php echo $data->created_time ?>",
      "dateModified": "<?php echo $data->updated_time ?>"
    }
</script>
