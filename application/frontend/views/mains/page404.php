<section class="developer-page third-template">
    <div class="container">
      <div class="second-side">
        <div class="second-side-left">
          <div class="breadcrumb">
            <ul>
              <li><a href="<?= current_url('/'); ?>">Главная</a></li>
              <li><a href="#"><?= $item['name']; ?></a></li>
            </ul>
          </div>
        </div>
        <div class="second-side-right">
          <h1><?= $item['name']; ?></h1>
        </div>
      </div>
    </div>
  </section>
  <section class="error">
    <div class="container">
      <div class="error-side">
        <div class="error-left">
          <h2><?= $item['h1']; ?></h2>
          <?= $item['text']; ?>
          <div class="wrap-error-btn">
            <a href="#" onclick="javascript:history.back(); return false;" class="error-back-btn">Вернуться назад</a>
            <a href="<?= site_url('/'); ?>" class="error-main-btn">Перейти на главную</a>
          </div>
        </div>
        <div class="error-right">
          <img src="/imgs/404.png" alt="">
        </div>
      </div>
    </div>
</section>