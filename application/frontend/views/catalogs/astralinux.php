<section class="second-page second-template">
    <div class="container">
        <div class="second-side">
            <div class="second-side-left">
                <div class="breadcrumb">
                    <?= $breads; ?>
                </div>
<!--                <div class="second-tags">-->
<!--                    --><?// foreach ($items as $item_one) { ?>
<!--                        <a href="--><?php //= site_url($item_one['url']); ?><!--"><span>#</span> --><?php //= $item_one['name'] ?><!--</a>-->
<!--                    --><?// } ?>
<!--                </div>-->
            </div>
            <div class="second-side-right">
                <h1><?= $item['h1'] ? $item['h1'] : $item['name']; ?></h1>
                <?= $item['text'] ?>
            </div>
        </div>
    </div>
</section>

<section class="po">
    <div class="container">
        <div class="po-block-title">
            <h2>
                <span>#</span>
                Программное обеспечение
            </h2>
        </div>
        <div class="po-block wrap-po-item">
            <? foreach ($items as $item_one) { ?>
                <a href="<?=$item_one['url']?>" class="item_category po-item blob-item">
                    <div class="img_item">
                        <img src="<?= get_image('catalogs_group', 'file', $item_one['id']); ?>"/>
                    </div>
                    <div class="name_item" >
                        <p><?=$item_one['name']?></p>
                    </div>
                </a>
            <? } ?>
        </div>
    </div>
</section>
<section class="about-po">
    <img src="/imgs/po-bg.png" alt="" class="about-po-img">
    <div class="container">
        <?= $item['short_text']; ?>
        <div class="wrap-about-po-item">
            <? foreach ($texts['items'] as $item_one3) { ?>
                <div class="about-po-item">
                    <span><?= $item_one3['name']; ?></span>
                    <?= $item_one3['text']; ?>
                </div>
            <?}?>
        </div>
    </div>
</section>

