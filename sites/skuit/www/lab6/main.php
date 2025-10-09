<?php

$product1 = "Молоток";
$product2 = "Отвёртка";
$product3 = "Гвозди";
$product4 = "Саморезы";
$product5 = "Перфоратор";
$product6 = "Уровень";
$product7 = "Рулетка";
$product8 = "Краска";
$product9 = "Кисть малярная";
$product10 = "Шпатель";
$product11 = "Штукатурка";
$product12 = "Дрель";
$product13 = "Клей";
$product14 = "Линейка металлическая";
$product15 = "Пила";

// --- ШАГ 2: создаём 15 переменных со стоимостью товаров ---
$price1 = 250;
$price2 = 180;
$price3 = 99.9;
$price4 = 120.5;
$price5 = 3800;
$price6 = 640;
$price7 = 350.5;
$price8 = 890.99;
$price9 = 150.2;
$price10 = 210;
$price11 = 450;
$price12 = 2700;
$price13 = 199.99;
$price14 = 310.75;
$price15 = 970;

// --- ШАГ 3: создаём два массива ---
$products = [
    $product1, $product2, $product3, $product4, $product5,
    $product6, $product7, $product8, $product9, $product10,
    $product11, $product12, $product13, $product14, $product15
];

$prices = [
    $price1, $price2, $price3, $price4, $price5,
    $price6, $price7, $price8, $price9, $price10,
    $price11, $price12, $price13, $price14, $price15
];
$products2 = $products;
$prices2 = $prices;

$items []= ['Краска белая', 170];
for($i = 0; $i < 10; $i++) {
    $items []= [$products[array_rand($products)], $prices[array_rand($prices)]];
}


?>


<div class="product-list">
    <h2>Товары и цены</h3>

    <?php for ($i = 0; $i < count($products); $i++) { ?>
        <div class="product-card">
            <div class="product-name"><?= $products[$i]?></div>
            <div class="product-price"><?= $prices[$i]?> ₽</div>
        </div>
    <?php } ?>
</div>

<div class="product-list">
    <h2>Товары и цены 2</h3>

    <?php for ($i = 0; $i < count($products); $i++) { ?>
        <div class="product-card">
            <div class="product-name"><?= $products2[$i]?></div>
            <div class="product-price"><?= $prices2[$i]?> ₽</div>
        </div>
    <?php } ?>
</div>

<div class="product-list">
    <h2>Товары и цены 3 </h3>

    <?php foreach ($items as $item) { ?>
        <div class="product-card">
            <div class="product-name"><?= $item[0]?></div>
            <div class="product-price"><?= $item[1]?> ₽</div>
        </div>
    <?php } ?>
</div>