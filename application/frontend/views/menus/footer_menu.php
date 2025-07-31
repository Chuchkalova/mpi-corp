<?php
$i = 0;
foreach ($items[0]['children'] as $item_one) {
    ++$i;
?>
    <div class="<?= $i == 1 ? "resolution" : "education"; ?>-col fade-block">
        <h5><?= $item_one['name']; ?></h5>

        <?php if (!empty($item_one['children'])): ?>
            <div class="wrap-fade-block">
                <?php foreach ($item_one['children'] as $item_one2): ?>
                    <?php if (!empty($item_one2['children'])): ?>
                        <p><a href="<?= $item_one2['url']; ?>"><?= $item_one2['name']; ?></a></p>
                        <?php foreach ($item_one2['children'] as $item_one3): ?>
                            <a href="<?= $item_one3['url']; ?>"><?= $item_one3['name']; ?></a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <a href="<?= $item_one2['url']; ?>"><?= $item_one2['name']; ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($i == 2): ?>
            <div class="off-canal">Официальный канал</div>
            <a class="icon-r" href="https://rutube.ru/channel/42051824/videos/"><img class="icon-r-effect" src="/dir_images/rutube-icon.svg"></a>
            <a class="icon-r" href="https://vk.com/mpi_corp" style="margin-left: 20px;"><img class="icon-r-effect" src="/dir_images/vk.svg"></a>
        <?php endif; ?>
    </div>
<?php
}
?>