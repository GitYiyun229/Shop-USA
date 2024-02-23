<?php
$tmpl->addStylesheet('home', 'modules/tiktok/assets/css');
?>
 
<div class="container">
	<?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?> 
	<h2 class="title_lovu">Lỗ Vũ trên Tiktok</h2> 
	<div class="list_tiktok">
		<?php foreach ($list as $item) { ?>
			<div class="item-tiktok item-tiktok-<?php echo $item->id ?>">
				<?php echo html_entity_decode($item->tiktok) ?>
			</div>
		<?php } ?>
	</div> 
</div>
<?php if ($pagination) echo $pagination->showPagination(2); ?>