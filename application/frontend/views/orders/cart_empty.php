 <section class="developer-page third-template">
    <div class="container">
      <div class="second-side">
        <div class="second-side-left">
          <div class="breadcrumb">
            <ul>
              <li><a href="<?= site_url('/') ?>">Главная</a></li>
              <li><a href="#">Корзина</a></li>
            </ul>
          </div>
        </div>
        <div class="second-side-right">
          <h1><?= $item['h1']?$item['h1']:$item['name']; ?></h1>
        </div>
      </div>
    </div>
  </section>
  <section class="cart">
    <div class="container">
      <div class="cart-empty">
        <?= $item['text'] ?>
      </div>
    </div>
  </section>
  