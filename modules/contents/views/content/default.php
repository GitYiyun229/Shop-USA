<?php
global $tmpl;
$tmpl->addStylesheet('detail', 'modules/contents/assets/css');
// $id = FSInput::get('id');
// echo $id;
?>
<main>
    

    <div class="container">
        <div class="main-content" id="main_content">
            <div class="menu-left">
                <h2 class="h2_c" id="h2_c"><?php echo $data->category_name ?></h2>
                <ul class="list ul-grid">
                    <?php foreach ($list as $item) { ?>
                        <li class="item <?php echo $item->id == $data->id ? 'active' : '' ?>">
                            <a href="<?php echo FSRoute::_('index.php?module=contents&view=content&code=' . $item->alias . '&id=' . $item->id) ?>">
                                <?php echo $item->title ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="content-right">
                <h2><?php echo $data->title ?></h2>
                <div class="content__">
                    <?php echo $data->content ?>
                </div>

            </div>
        </div>
    </div>
</main>