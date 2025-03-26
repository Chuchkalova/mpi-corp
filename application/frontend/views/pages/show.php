<section class="developer-page third-template">
    <div class="container">
      <div class="second-side">
        <div class="second-side-left">
          <div class="breadcrumb">
            <?= $breads; ?>
          </div>
        </div>
        <div class="second-side-right">
          <h1><?= $item['h1']?$item['h1']:$item['name']; ?></h1>
        </div>
      </div>
    </div>
  </section>
  <?
    if($item['id'] == 5){
        ?>
                <?= $item['text'] ?>
        <?
    }
    else{
        ?>
        <section class="contact-page">
            <div class="container">
                <?= $item['text'] ?>
            </div>

        </section>
        <?
    }
  ?>

