<style>
    /* Общие стили */
    h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
    }
    .highlight {
        color: #4a90e2;
    }
    h2 {
        font-size: 22px;
        margin: 30px 0 15px;
        color: #444;
        border-bottom: 2px solid #eee;
        padding-bottom: 8px;
    }

    .search-wrapper {
        padding-top: 160px;
        width: 90%;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Поисковая форма */
    .search-box {
        position: relative;
        display: flex;
        width: 100%;
        max-width: 600px;
        margin-bottom: 30px;
    }
    #search-input {
        width: 100%;
        padding: 14px 18px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 12px 0 0 12px;
        outline: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    #search-input:focus {
        border-color: #4a90e2;
        box-shadow: 0 4px 12px rgba(74,144,226,0.2);
    }
    button {
        padding: 14px 20px;
        font-size: 16px;
        background: #4a90e2;
        color: #fff;
        border: none;
        border-radius: 0 12px 12px 0;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    button:hover {
        background: #357ABD;
    }

    /* Подсказки */
    .suggestions-box {
        position: absolute;
        top: 52px;
        left: 0;
        background: #fff;
        border: 1px solid #ddd;
        width: calc(100% - 2px);
        max-height: 300px;
        overflow-y: auto;
        display: none;
        z-index: 999;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .suggestions-box strong {
        margin-left: 15px;
        height: 30px;
        display: flex;
        align-items: center;
        margin-top: 10px;
    }
    .suggestions-box ul { margin: 0; padding: 0; list-style: none; }
    .suggestions-box li {
        padding: 10px 14px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        font-size: 15px;
    }
    .suggestions-box li:hover {
        background: #f5f8ff;
    }
    .suggestions-box li a {
        text-decoration: none;
        color: black;
    }

    /* Списки */
    .result-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .result-list li {
        margin-bottom: 10px;
    }
    .result-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 18px;
        background: #fff;
        border-radius: 10px;
        border: 1px solid #eee;
        text-decoration: none;
        color: #333;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .result-list a:hover {
        background: #f5f8ff;
        border-color: #4a90e2;
        box-shadow: 0 4px 12px rgba(74,144,226,0.15);
        transform: translateY(-2px);
    }

    /* Для товаров */
    .product-name {
        font-weight: 500;
    }
    .product-price {
        color: #4a90e2;
        font-weight: 700;
    }

    /* Нет результатов */
    .no-results {
        font-size: 18px;
        color: #888;
        margin-top: 30px;
    }
    .result-list li a {
        display: flex;
        gap: 20px;
        align-items: stretch;
        text-align: left;
        padding: 20px;
        justify-content: start;
    }

    .category-item a, .product-item a {
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .category-item a p, .product-item a p {
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
        margin-bottom: 15px;
    }

    .category-image img,
    .product-image img {
        width: 130px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .category-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .category-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }

    .category-desc {
        font-size: 14px;
        color: #666;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
        line-height: 24px;
    }

    .product-desc {
        font-size: 14px;
        color: #666;
    }

    .product-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
    }

    .product-price {
        font-size: 16px;
        font-weight: bold;
        color: #4a90e2;
        margin-bottom: 8px;
    }

    .btn-more {
        background: #4a90e2;
        color: #fff;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s ease;
    }

    .btn-more:hover {
        background: #357ABD;
    }

    .wrap-header.fix {
        position: fixed;
        top: 0;
        width: 100%;
        left: 0;
        bottom: auto;
        background: #FFF;
        margin-top: 0;
        background: rgba(255, 255, 255, 0.90);
        box-shadow: 0px 5px 15px 0px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(5px);
        transition: top 0.3s;
    }
</style>
<div class="search-wrapper">
    <h1>Результаты поиска: <span class="highlight">"<?= htmlspecialchars($query) ?>"</span></h1>

    <form id="search-form" action="/search" method="get" autocomplete="off">
        <div class="search-box">
            <input type="text" name="q" id="search-input" placeholder="Введите название товара или категории..." value="<?= htmlspecialchars($query) ?>" />
            <button type="submit">Поиск</button>
            <div id="search-suggestions" class="suggestions-box"></div>
        </div>
    </form>

    <?php if (!empty($categories)): ?>
        <div class="result-block">
            <h2>Категории</h2>
            <ul class="result-list">
                <?php foreach ($categories as $cat): ?>
                    <li class="category-item">
                        <a href="/<?= $cat['url'] ?>">
                            <div class="category-image">
                                <img src="<?= get_image('catalogs_group','file',$cat['id']) ?>" alt="<?= $cat['name'] ?>">
                            </div>
                            <div class="category-info">
                                <div class="category-name"><?= $cat['name'] ?></div>
                                <div class="category-desc"><?= $cat['short_text'] ?></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($products)): ?>
        <div class="result-block">
            <h2>Товары</h2>
            <ul class="result-list">
                <?php foreach ($products as $prod): ?>
                    <li class="product-item">
                        <a href="/<?= $prod['category_url'] ?>?product_id=<?= $prod['id'] ?>">
                            <div class="product-image">
                                <img src="<?= get_image('catalogs','file1',$prod['id']) ?>" alt="<?= $prod['name'] ?>">
                            </div>
                            <div class="product-info">
                                <div class="product-name"><?= $prod['name'] ?></div>
                                <div class="product-desc"><?= $prod['short_text'] ?></div>
                            </div>
                            <div class="product-meta">
                                <div class="product-price">
                                    <?= ($prod['price'] > 0) ? number_format($prod['price'], 0, '.', ' ') . ' ₽' : 'Цена по запросу' ?>
                                </div>
                                <div><button class="btn-more">Подробнее</button></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (empty($categories) && empty($products)): ?>
        <p class="no-results">😔 Ничего не найдено. Попробуйте другой запрос.</p>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        // 👇 Формируем правильную ссылку с product_id
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

        // Скрываем подсказки, если клик вне
        $(document).click(function(e){
            if(!$(e.target).closest("#search-form").length){
                $("#search-suggestions").hide();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const wrapHeader = document.querySelector('.wrap-header');

        if (!wrapHeader) return;

        window.addEventListener('scroll', function() {
            if (window.scrollY > 80) {
                if (!wrapHeader.classList.contains('fix')) {
                    wrapHeader.classList.add('fix');
                }
            } else {
                if (wrapHeader.classList.contains('fix')) {
                    wrapHeader.classList.remove('fix');
                }
            }
        });
    });
</script>