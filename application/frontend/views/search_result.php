<style>
    /* 🌟 Общие стили */
    body {
        font-family: 'Inter', 'Segoe UI', Roboto, Arial, sans-serif;
        background: #f9f9fb;
        color: #222;
        margin: 0;
        padding: 40px;
    }
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

    /* 🔍 Поисковая форма */
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

    /* 💡 Подсказки */
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

    /* 📋 Списки */
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

    /* 🛍️ Для товаров */
    .product-name {
        font-weight: 500;
    }
    .product-price {
        color: #4a90e2;
        font-weight: 700;
    }

    /* 😔 Нет результатов */
    .no-results {
        font-size: 18px;
        color: #888;
        margin-top: 30px;
    }
</style>
<div class="search-wrapper">
    <h1>🔍 Результаты поиска: <span class="highlight">"<?= htmlspecialchars($query) ?>"</span></h1>

    <form id="search-form" action="/search" method="get" autocomplete="off">
        <div class="search-box">
            <input type="text" name="q" id="search-input" placeholder="Введите название товара или категории..." value="<?= htmlspecialchars($query) ?>" />
            <button type="submit">Поиск</button>
            <div id="search-suggestions" class="suggestions-box"></div>
        </div>
    </form>

    <?php if (!empty($categories)): ?>
        <div class="result-block">
            <h2>📂 Категории</h2>
            <ul class="result-list">
                <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="/<?= $cat['url'] ?>">
                            <?= $cat['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($products)): ?>
        <div class="result-block">
            <h2>🛍️ Товары</h2>
            <ul class="result-list">
                <?php foreach ($products as $prod): ?>
                    <li>
                        <a href="/<?= $prod['category_url'] ?>?product_id=<?= $prod['id'] ?>">
                            <div class="product-name"><?= $prod['name'] ?></div>
                            <div class="product-price"><?= number_format($prod['price'], 0, '.', ' ') ?> ₽</div>
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
</script>