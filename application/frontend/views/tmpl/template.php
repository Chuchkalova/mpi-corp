<!DOCTYPE html>

<html lang="ru">

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> -->

  <link rel="stylesheet" href="/fonts/fonts.css">

  <link rel="stylesheet" href="/css/liMarquee.css">

  <?= $css; ?>

  <link rel="stylesheet" href="/css/main.css?v=1">

    <?php
    // Получаем текущий URL
    $current_url = $_SERVER['REQUEST_URI'];

    if ($current_url !== '/') {
        // Убираем конечный слеш, если он есть
        if (substr($current_url, -1) === '/') {
            $current_url = rtrim($current_url, '/');
            header("Location: $current_url", true, 301);
            exit();
        }

        // Проверяем, если это первая страница пагинации
        // Предполагаем, что первая страница всегда имеет формат /имя_раздела/1
        if (preg_match('#^/(.+)/1$#', $current_url, $matches)) {
            // Перенаправляем на основную страницу без номера
            $base_url = 'https://mpi-corp.ru/' . $matches[1]; // Формируем базовый URL
            header("Location: $base_url", true, 301);
            exit();
        }

        // Проверяем, содержит ли URL номер страницы
        if (preg_match('/\/\d+$/', $current_url)) {
            ?>
            <style>
                .developer-tab-list {
                    display: none;
                }
            </style>
            <?
        }
        // Проверяем, если это страница пагинации
        if (preg_match('#^/(.+)/(\d+)$#', $current_url, $matches)) {
            // Получаем номер страницы
            $page_number = (int)$matches[2];

            // Проверяем, если номер страницы 2 или выше
            if ($page_number >= 2) {
                // Добавляем номер страницы к заголовку
                $meta_title .= " - страница " . $page_number;
                $meta_description .= " - страница " . $page_number;
            }
        }
    }
    ?>

  <title><?= htmlspecialchars($meta_title); ?></title>

  <meta name="description" content="<?= htmlspecialchars($meta_description); ?>" />
  

  <? if($this->settings[3]){ ?>

	<link rel="shortcut icon" href="<?= $this->settings[3]; ?>" type="image/x-icon"> 

  <? } ?>	

  <?= $verification; ?>
  
  <? if($this->uri->segment(2)&&is_numeric($this->uri->segment(2))){ ?>
	<? $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'?'https':'http'; ?>
	<link rel="canonical" href="<?= $protocol; ?>://<?= $_SERVER['SERVER_NAME'].site_url($this->uri->segment(1)) ?>">
  <? } ?>
<? if (isset($schema))echo $schema; ?>
  <!-- Top.Mail.Ru counter -->
<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "3653306", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = "https://top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "tmr-code");
</script>
<noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3653306;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
<!-- /Top.Mail.Ru counter -->

</head>



<body class="<?= $top10?$top10:"third-page-template"; ?>">

  <header class="<?= $top9?$top9:"developer"; ?>">

    <div class="wrap-header">

      <div class="container">

        <div class="wrap-header-content">

          <div class="gamb"></div>

          <div class="logo">

            <a href="<?= site_url('/'); ?>">

              <span class="header-desc-logo"></span>

            </a>

          </div>

          <div class="wrap-nav">

			<?= $menu1; ?>

          </div>

          <div class="contact-header">

            <div class="contact-header-block desc-hid">
              <a href="mailto:sales@mpi-corp.ru" class="mail">sales@mpi-corp.ru</a>

              <? if($this->settings[5]){ ?><a href="<?= $this->settings[5]; ?>" class="telegram">Техподдержка (общая)</a><? } ?>

              <? if($this->settings[6]){ ?><a href="<?= $this->settings[6]; ?>" class="telegram">Техподдержка (GIPRO)</a><? } ?>

            </div>

            <div class="contact-header-block">

              <a href="tel:<?= str_replace(array('-',' ','(',')',),'',$top1); ?>" class="tel"><?= $top1; ?></a>
              <a href="mailto:sales@mpi-corp.ru" class="mail">sales@mpi-corp.ru</a>
              <p class="btn-tel" data-popup="call">Заказать звонок</p>

            </div>
                          
          </div>
    <div class="wrap-header-form-search">
        
      <div class="btn-search" data-popup="seacrh-pop">
        <span>
<svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
  <g clip-path="url(#clip0_1865_4316)">
    <path d="M11.7818 3.61938C11.2541 3.08193 10.6252 2.65435 9.93138 2.36133C9.23753 2.06831 8.49251 1.91566 7.73934 1.9122C6.98617 1.90874 6.23977 2.05453 5.54327 2.34116C4.84676 2.62779 4.21394 3.04958 3.68136 3.58216C3.14878 4.11474 2.727 4.74755 2.44037 5.44406C2.15374 6.14057 2.00794 6.88696 2.0114 7.64013C2.01487 8.39331 2.16751 9.13833 2.46053 9.83217C2.75355 10.526 3.18113 11.1549 3.71858 11.6826C4.79118 12.7357 6.23622 13.3226 7.73934 13.3157C9.24246 13.3088 10.682 12.7086 11.7449 11.6457C12.8078 10.5828 13.408 9.14325 13.4149 7.64013C13.4218 6.13702 12.8349 4.69198 11.7818 3.61938ZM2.47822 2.37902C3.82281 1.03476 5.63014 0.254945 7.53061 0.199029C9.43109 0.143113 11.2811 0.815324 12.7024 2.0782C14.1237 3.34108 15.0089 5.09921 15.1769 6.99307C15.3449 8.88692 14.7831 10.7734 13.6064 12.2668L18.295 16.9554L17.0546 18.1958L12.366 13.5072C10.8721 14.6796 8.98726 15.2379 7.09585 15.0682C5.20445 14.8986 3.44902 14.0137 2.18767 12.5941C0.926324 11.1745 0.25408 9.3272 0.308071 7.42897C0.362063 5.53073 1.13822 3.72461 2.47822 2.37902Z" fill="white"/>
  </g>
  <defs>
    <clipPath id="clip0_1865_4316">
      <rect width="18" height="18" fill="white" transform="translate(0.0999756)"/>
    </clipPath>
  </defs>
</svg>
                        </span>
                        Найти
      </div>

            </div>
          <div class="header-cart">

            <a href="<?= site_url("orders/cart") ?>">

              <div class="cart-icon">

                <span class='cart-count'><?= $this->cart->total_items_qty(); ?></span>

              </div>

              <p><span class='cart-summa'><?= $this->cart->total(); ?></span> ₽</p>

            </a>

          </div>

        </div>

      </div>

    </div>

  </header>

  <div class="gamb-menu">

    <div class="container">

      <div class="close-gamb">

        <span></span>

      </div>

      <div class="wrap-gamb-nav-menu">

        <div class="gamb-logo">

          <a href="<?= site_url('/'); ?>">

            <img src="/imgs/short-header-logo.svg" alt="" class="desc-logo">

            <img src="/imgs/logo-header.svg" alt="" class="mob-logo">

          </a>

        </div>

        <nav class="gamb-nav">

			<?= $menu2; ?>

        </nav>

        <div class="contact-header-block">

          <a href="tel:<?= str_replace(array('-',' ','(',')',),'',$top1); ?>" class="tel"><?= $top1; ?></a>

          <p class="btn-tel" data-popup="call">Заказать звонок</p>

          <a href="mailto:<?= $top2; ?>" class="mail"><?= $top2; ?></a>

        </div>

        <div class="header-cart">

          <a href="<?= site_url("orders/cart") ?>">

            <div class="cart-icon">

              <span class='cart-count'><?= $this->cart->total_items_qty(); ?></span>

            </div>

            <p><span class='cart-summa'><?= number_format($this->cart->total(),0,'.', ''); ?></span> ₽</p>

          </a>

        </div>

      </div>

    </div>

    <div class="wrap-gamb-content">
                <form id="search-form" class="search-header" action="/search" method="get" autocomplete="off">
                  <div class="search-box">
                      <input type="text" name="q" id="search-input" placeholder="Поиск" value="<?= isset($query) ? htmlspecialchars($query) : '' ?>" />
                      <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <path d="M11.5801 3.91999C11.0788 3.40942 10.4813 3.00322 9.82219 2.72485C9.16304 2.44649 8.45527 2.30147 7.73977 2.29819C7.02426 2.2949 6.31519 2.4334 5.65351 2.7057C4.99183 2.97799 4.39066 3.37869 3.88472 3.88463C3.37877 4.39058 2.97808 4.99175 2.70578 5.65343C2.43348 6.31511 2.29498 7.02418 2.29827 7.73968C2.30156 8.45519 2.44657 9.16296 2.72494 9.82211C3.0033 10.4813 3.4095 11.0787 3.92007 11.58C4.93904 12.5804 6.31181 13.138 7.73977 13.1314C9.16772 13.1248 10.5353 12.5547 11.545 11.545C12.5548 10.5352 13.1249 9.16763 13.1315 7.73968C13.138 6.31173 12.5805 4.93895 11.5801 3.91999ZM2.74174 2.74166C4.01909 1.46463 5.73604 0.723805 7.54147 0.670685C9.34691 0.617565 11.1044 1.25616 12.4547 2.45588C13.8049 3.65561 14.6458 5.32582 14.8054 7.12497C14.965 8.92412 14.4313 10.7163 13.3134 12.135L17.7676 16.5892L16.5892 17.7675L12.1351 13.3133C10.7159 14.4271 8.92528 14.9575 7.12846 14.7963C5.33163 14.6351 3.664 13.7945 2.46572 12.4459C1.26745 11.0973 0.628821 9.34238 0.680113 7.53907C0.731404 5.73576 1.46875 4.01996 2.74174 2.74166Z" fill="white"/>
</svg></button>
                      <div id="search-suggestions" class="suggestions-box"></div>
                  </div>
              </form>
      <div class="container">

        <div class="wrap-hidden-design-tablet">

          <nav class="gamb-nav">

            <?= $menu2; ?>


          </nav>

        </div>

        <div class="gamb-col">

          <?= $menu3; ?>

          <div class="gamb-col-item">

            <h5><a href="/kontakty">техподдержка</a></h5>

            <div class="wrap-support-col-link wrap-gamb-col-link">

              <a href="mailto:<?= $top3; ?>" class="mail"><?= $top3; ?></a>

              <? if($this->settings[5]){ ?><a href="<?= $this->settings[5]; ?>" class="telegram">Техподдержка (общая)</a><? } ?>

              <? if($this->settings[6]){ ?><a href="<?= $this->settings[6]; ?>" class="telegram">Техподдержка (GIPRO)</a><? } ?>

            </div>

          </div>

          <div class="wrap-hidden-design">

            <nav class="gamb-nav">

				<?= $menu2; ?>

            </nav>

          </div>

          <div class="gamb-col-item gamb-col-item-mob">

            <h6>офис в екатеринбурге</h6>

            <div class="wrap-contact-gamb">

              <p><?= $top6; ?></p>

              <a href="tel:+73432920082" class="tel">+7 (343) 292-00-82</a>

            </div>

            <h6>офис в перми</h6>

            <div class="wrap-contact-gamb">

              <p><?= $top7; ?></p>

              <a href="tel:<?= str_replace(array('-',' ','(',')',),'',$top5); ?>"><?= $top5; ?></a>

            </div>

            <h6>офис в омске</h6>

            <div class="wrap-contact-gamb">

              <p>ул. Гагарина 14, 4 вход, офис 8.1</p>

              <a href="tel:+79828438228">+7 (982) 843-82-28</a>

            </div>
          </div>
          <div class="gamb-col-item gamb-col-item-mob">

            <h6><a href="tel:88002341714">8 (800) 234-17-14</a></h6>

            <a href="mailto:<?= $top2; ?>" class="mail"><?= $top2; ?></a>
            <a href="mailto:sales@mpi-corp.ru" class="mail">sales@mpi-corp.ru</a>

            <a href="#" class="tab-btn" data-popup="application">Оставить заявку</a>

          </div>


        </div>

      </div>

    </div>

  </div>

  

  <?= $content_main; ?>

  <section class="footer-form-block">

    <div class="footer-form-left">

      <div class="footer-form-info">

        <h4>обратная связь</h4>

        <?= $bottom3; ?>

      </div>

      <div class="footer-form-particle" id="particles-js"></div>

    </div>

    <div class="footer-form-right">

        <script data-b24-form="inline/21/z6rel0" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://cdn-ru.bitrix24.ru/b26270930/crm/form/loader_21.js');</script>

    </div>

  </section>

  <footer>

    <div class="container">

      <div class="wrap-footer-col">

        <div class="logo-col">

          <div class="footer-logo">

            <a href="<?= site_url('/'); ?>">

              <img src="/imgs/footer-logo.svg" alt="">

            </a>

          </div>

		  <?= $menu4; ?>         

        </div>

        <div class="wrap-footer-cols">

			<?= $menu5; ?>          

        </div>

        <div class="wrap-footer-cols-2">

          <div class="contact-col">

            <h3>контакты</h3>

            <h5>екатеринбург</h5>

            <p><?= $top6; ?></p>

             <a href="tel:+73432920082" class="tel">+7 (343) 292-00-82</a>
            

            <h5>пермь</h5>

            <p><?= $top7; ?></p>

            <a href="tel:<?= str_replace(array('-',' ','(',')',),'',$top5); ?>"><?= $top5; ?></a>

            <!-- <a href="mailto:<?= $top1; ?>"><?= $top1; ?></a> -->

            <h5>Омск</h5>

            <p>ул. Гагарина 14, 4 вход, офис 8.1</p>

            <a href="tel:+7(982)8438228">+7 (982) 843-82-28</a>

          </div>

          <div class="support-col">

            <h3>техподдержка</h3>

            <div class="contact-header-block ">

              <a href="mailto:<?= $top3; ?>" class="mail"><?= $top3; ?></a>

              <? if($this->settings[5]){ ?><a href="<?= $this->settings[5]; ?>" class="telegram">Техподдержка (общая)</a><? } ?>

              <? if($this->settings[6]){ ?><a href="<?= $this->settings[6]; ?>" class="telegram">Техподдержка (GIPRO)</a><? } ?>

            </div>

            <h3><a href="tel:88002341714">8-800-234-17-14</a></h3>
            <div class="contact-header-block ">

              <a href="mailto:sales@mpi-corp.ru" class="mail">sales@mpi-corp.ru</a>

            </div>
            <div class="mob-design">

              <p>связаться <br>с нами</p>

              <div class="application-btn" data-popup="application">Оставить <br>заявку</div>

            </div>

          </div>

        </div>
        

      </div>

      <div class="footer-bottom">

        <?= $bottom1; ?>

		<?= $bottom2; ?>

        <div class="company">

          <a href="https://ipos.digital/" target='_blank'>

            <img src="/imgs/ipos.svg" alt="">

          </a>

		  <?= $counters; ?>

        </div>

      </div>

    </div>

  </footer>

  <div id="call_vacancy" class="popup">

      <div class="popup-body">

          <div class="popup-content">

              <div class="popup-close">

                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">

                      <path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />

                  </svg>

              </div>

              <h3>Откликнуться</h3>

              <form action="#" method="POST" id="form-call" class='ajax-form'>

                  <div class="wrap-input">

                      <label>

                          <input type="text" name="name" required>

                          <span>Ваше имя</span>

                      </label>

                  </div>

                  <div class="wrap-input">

                      <input type="tel" name="phone" placeholder="+7 (9__) ___-__-__" required>

                  </div>

                  <div class="wrap-input">

                      <label>

                          <input type="text" name='text'>

                          <span>Напишите, что Вас интересует</span>

                      </label>

                  </div>

                  <input type='hidden' name='type' value='Заказать звонок'>

                  <div class="wrap-check">

                      <button>Откликнуться</button>

                      <p>Нажимая на кнопку «Откликнуться» Вы даете согласие на <a href="<?= site_url('politic'); ?>" target='_blank'>обработку персональных данных</a></p>

                  </div>

              </form>

          </div>

      </div>

  </div>

  <div id="call" class="popup">

    <div class="popup-body">

      <div class="popup-content">

        <div class="popup-close">

          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">

            <path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />

          </svg>

        </div>

        <script data-b24-form="inline/19/k7bbhg" data-skip-moving="true">
        (function(w,d,u){
        var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
        var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn-ru.bitrix24.ru/b26270930/crm/form/loader_19.js');
        </script>

      </div>

    </div>

  </div>

  <div id="application" class="popup">

    <div class="popup-body">

      <div class="popup-content">

        <div class="popup-close">

          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">

            <path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />

          </svg>

        </div>

    <script data-b24-form="inline/15/ztmjaq" data-skip-moving="true">
    (function(w,d,u){
    var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
    var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
    })(window,document,'https://cdn-ru.bitrix24.ru/b26270930/crm/form/loader_15.js');
    </script>

      </div>

    </div>

  </div>

  <div id="thx" class="popup">

    <div class="popup-body">

      <div class="popup-content">

        <div class="popup-close">

          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">

            <path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />

          </svg>

        </div>

        <h3>Спасибо!</h3>

        <p><span>Ваша заявка успешно отправлена!</span></p>

        <p>Мы свяжемся с Вами в ближайшее время и ответим на все интересующие Вас вопросы</p>

        <a href="<?= site_url('/') ?>" class="popup-back-close-btn">Перейти на главную</a>

      </div>

    </div>

  </div>
    <div id="seacrh-pop" class="popup">

    <div class="popup-body">

      <div class="popup-content">

        <div class="container">
                <form id="search-form" class="search-header" action="/search" method="get" autocomplete="off">
                  <div class="search-box">
                      <input type="text" name="q" id="search-input" placeholder="Поиск" value="<?= isset($query) ? htmlspecialchars($query) : '' ?>" />
                      <button type="submit">Найти</button>
                      <div id="search-suggestions" class="suggestions-box"></div>
                  </div>
              </form>
                      <div class="popup-close">

          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
  <path d="M7.46671 26.6668L5.33337 24.5335L13.8667 16.0002L5.33337 7.46683L7.46671 5.3335L16 13.8668L24.5334 5.3335L26.6667 7.46683L18.1334 16.0002L26.6667 24.5335L24.5334 26.6668L16 18.1335L7.46671 26.6668Z" fill="#666666"/>
</svg>
        </div>
</div>
      </div>

    </div>

  </div>
  <div class="wrap-bottom-menu">
    <a href="/programmnoe_obespechenie"><img src="./../../../imgs/b-i-1.svg" alt=""><span>ПО</span></a>
    <a href="/oborudovanie"><img src="./../../../imgs/b-i-2.svg" alt=""><span>Оборудование</span></a>
    <a href="/orders/cart"><img src="./../../../imgs/b-i-3.svg" alt=""><span>Корзина</span></a>
    <a href="/kontakty"><img src="./../../../imgs/b-i-4.svg" alt=""><span>Техподдержка</span></a>
    <a href="/kontakty"><img src="./../../../imgs/b-i-5.svg" alt=""><span>Контакты</span></a>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script src="/js/jquery.liMarquee.js"></script>

  <script src="/js/jquery.event.move.js"></script>

  <script src="/js/particles.min.js"></script>

  <script src="https://unpkg.com/imask"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.22/vue.min.js"></script>

  <script src="/js/clamp.js"></script>

  <script src="/js/round.js?v=<?= filemtime($_SERVER['DOCUMENT_ROOT']."/js/round.js"); ?>"></script>

  <?= $js; ?>
  <a href="https://t.me/+79581333695" target="_blank" title="Написать в Telegram" rel="noopener noreferrer">
	<div class="telegram-button">
		<!--<img class=" lazyloaded" src="/images/telegram.png" data-src="/images/telegram.png">-->
    	<svg viewBox="0 0 1000 1000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <!-- Generator: Sketch 53.2 (72643) - https://sketchapp.com -->
            <title>Artboard</title>
            <desc>Created with Sketch.</desc>
            <defs>
                <linearGradient x1="50%" y1="0%" x2="50%" y2="99.2583404%" id="linearGradient-1">
                    <stop stop-color="#2AABEE" offset="0%"></stop>
                    <stop stop-color="#229ED9" offset="100%"></stop>
                </linearGradient>
            </defs>
            <g id="Artboard" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <circle id="Oval" fill="url(#linearGradient-1)" cx="500" cy="500" r="500"></circle>
                <path d="M226.328419,494.722069 C372.088573,431.216685 469.284839,389.350049 517.917216,369.122161 C656.772535,311.36743 685.625481,301.334815 704.431427,301.003532 C708.567621,300.93067 717.815839,301.955743 723.806446,306.816707 C728.864797,310.92121 730.256552,316.46581 730.922551,320.357329 C731.588551,324.248848 732.417879,333.113828 731.758626,340.040666 C724.234007,419.102486 691.675104,610.964674 675.110982,699.515267 C668.10208,736.984342 654.301336,749.547532 640.940618,750.777006 C611.904684,753.448938 589.856115,731.588035 561.733393,713.153237 C517.726886,684.306416 492.866009,666.349181 450.150074,638.200013 C400.78442,605.66878 432.786119,587.789048 460.919462,558.568563 C468.282091,550.921423 596.21508,434.556479 598.691227,424.000355 C599.00091,422.680135 599.288312,417.758981 596.36474,415.160431 C593.441168,412.561881 589.126229,413.450484 586.012448,414.157198 C581.598758,415.158943 511.297793,461.625274 375.109553,553.556189 C355.154858,567.258623 337.080515,573.934908 320.886524,573.585046 C303.033948,573.199351 268.692754,563.490928 243.163606,555.192408 C211.851067,545.013936 186.964484,539.632504 189.131547,522.346309 C190.260287,513.342589 202.659244,504.134509 226.328419,494.722069 Z" id="Path-3" fill="#FFFFFF"></path>
            </g>
        </svg>
	</div>
  </a>
  <style>
    .telegram-button {
    	display: block;
        position: fixed;
        right: 45px;
        bottom: 130px;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }
    .telegram-button::before, .telegram-button::after {
        content: " ";
        display: block;
        position: absolute;
        border: 50%;
        border: 1px solid #28a5e5;
        left: -20px;
        right: -20px;
        top: -20px;
        bottom: -20px;
        border-radius: 50%;
        animation: animate 1.5s linear infinite;
        opacity: 0;
        backface-visibility: hidden;
    }
    
    .telegram-button::after {
        animation-delay: .5s;
    }
    .telegram-button svg {
        width: 60px;
        height: 60px;
        
    }
    @keyframes animate {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
    
        50% {
            opacity: 1;
        }
    
        100% {
            transform: scale(1.2);
            opacity: 0;
        }
    }
    @media (max-width: 991px) {
        .telegram-button {
            right: 0px;
            bottom: 80px;
        }
        .telegram-button svg {
            width: 50px;
            height: 50px;
        }
    }
  </style>
  <script>
      // Функция для определения, находимся ли мы на странице пагинации
      function isPaginationPage() {
          const pathParts = window.location.pathname.split('/'); // Разбиваем путь URL
          const page = pathParts[pathParts.length - 1]; // Предполагаем, что номер страницы находится в конце пути
          console.log('Номер страницы из URL:', page); // Отладка: выводим номер страницы
          return page && !isNaN(page) && parseInt(page) >= 2; // Проверяем, что страница 2 или выше
      }

      // Функция для добавления текста к заголовку h1
      function updateH1WithPageNumber() {
          if (isPaginationPage()) {
              const pathParts = window.location.pathname.split('/');
              const page = pathParts[pathParts.length - 1]; // Получаем номер страницы
              console.log('Мы на странице пагинации:', page); // Отладка: подтверждаем, что мы на странице пагинации
              const secondSideRightBlock = document.querySelector('.second-side-right');

              if (secondSideRightBlock) {
                  const h1 = secondSideRightBlock.querySelector('h1');
                  if (h1) {
                      console.log('Найден заголовок h1:', h1.textContent); // Отладка: выводим текущий текст h1
                      h1.textContent += ` - страница ${page}`; // Добавляем текст
                      console.log('Обновленный текст h1:', h1.textContent); // Отладка: выводим обновленный текст h1
                  } else {
                      console.error('Заголовок h1 не найден внутри блока second-side-right.'); // Сообщение об ошибке
                  }
              } else {
                  console.error('Блок second-side-right не найден.'); // Сообщение об ошибке
              }
          } else {
              console.log('Мы не на странице пагинации или на первой странице.'); // Отладка: если не на пагинации
          }
      }

      // Запускаем функцию при загрузке страницы
      document.addEventListener('DOMContentLoaded', updateH1WithPageNumber);

  </script>
  
<div class="cookie-win" id="cookieWin">
    <div class="cookie-win-content">
    <p>Мы используем файлы cookie, чтобы делать сайт удобнее. Оставаясь на сайте, вы соглашаетесь на <a href="/soglasie" target="_blank">обработку данных</a> и с <a href="/politic" target="_blank">политикой</a> их использования</a></p>
    <div class="coockie-btn" id="cookieBtn">Ок</div>
    </div>
</div>

<script>
const cookieWin = $("#cookieWin");
    const cookieBtn = $("#cookieBtn");
    if (!localStorage.getItem("cookieAccepted")) {
        cookieWin.show();
    }
    cookieBtn.on("click", function () {
        localStorage.setItem("cookieAccepted", "true");
        cookieWin.hide();
    });
</script>
  <script>
      $(document).ready(function(){
          $("#search-input").on("keyup", function(){
              let q = $(this).val();

              if(q.length < 2){
                  $("#search-suggestions").hide();
                  return;
              }

              $.getJSON("/search/ajax", {q: q}, function(data){
                  let html = "";

                  if(data.categories.length > 0){
                      html += "<strong>Категории</strong><ul>";
                      $.each(data.categories, function(i, cat){
                          html += `<li>
                    <a href="/${cat.url}">
                        ${cat.name}
                    </a>
                </li>`;
                      });
                      html += "</ul>";
                  }

                  if(data.products.length > 0){
                      html += "<strong>Товары</strong><ul>";
                      $.each(data.products, function(i, prod){
                          html += `<li>
                    <a href="/${prod.category_url}?product_id=${prod.id}">
                        <div class="product-name">${prod.name}</div>
                        <div class="product-price">${prod.price} ₽</div>
                    </a>
                </li>`;
                      });
                      html += "</ul>";
                  }

                  if(html === ""){
                      html = "<div style='padding:8px;'>Ничего не найдено</div>";
                  }

                  $("#search-suggestions").html(html).show();
              });
          });

          // Скрываем подсказки при клике вне формы
          $(document).click(function(e){
              if(!$(e.target).closest("#search-form").length){
                  $("#search-suggestions").hide();
              }
          });
      });
  </script>


</body>

</html>