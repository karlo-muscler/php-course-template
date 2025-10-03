<?php
// --- 1) Жители деревни ---
$names = [
    "Альдар","Берен","Келеборн","Теодред","Эомер","Фарамир","Денетор","Халдир","Глорфиндел","Трандуил",
    "Эльдан","Маблон","Брандор","Аранель","Лотарион","Мелькор","Ангмар","Саэрон","Эарендил","Эльрос",
    "Аделина","Мириэль","Идунн","Лиана","Элениэль","Лютиэн","Галадриэль","Арвен","Нимродэль","Видария",
    "Сильмариэн","Элендис","Альвина","Рианна","Финдуилас","Эстелла","Морвен","Эрисель","Йованна","Мирандиль",
    "Боромир","Турин","Финрод","Маэглин","Ородрет","Телион","Ангрон","Дориан","Феанор","Эндар",
    "Ангвин","Себальд","Эмильдор","Варгельд","Тарвин","Эларион","Ругвир","Дагор","Мельда","Эофрид",
    "Годфри","Гильом","Ричард","Генри","Эдмунд","Родерик","Конрад","Альфред","Эрнст","Гуго",
    "Вильгельм","Томас","Оуэн","Филипп","Стефан","Леонард","Роберт","Джон","Артур","Мэтью",
    "Агата","Флоренс","Маргарет","Эдит","Сибилла","Катарина","Эльфрида","Изольда","Беатриса","Розалинда",
    "Сесиль","Джулиана","Матильда","Элеонора","Клементина","Фелиция","Валентина","Амелия","Гертруда","Хелена"
];

$genders = ["мужчина", "женщина"];
$villagers = [];
$villagerCount = 100;
for ($i = 0; $i < $villagerCount; $i++) {
    $villagers[] = [
        "name" => $names[array_rand($names)] . " " . ($i + 1),
        "age" => rand(12, 60),
        "gender" => $genders[array_rand($genders)],
        "hp" => rand(10, 15),
        "strength" => rand(3, 5),
        "intelligence" => rand(3, 8),
    ];
}

// --- 1) Выбор всех мужчин старше 18 (опризыв) ---
$conscripts = [];
foreach ($villagers as $villager) {
    if ($villager["gender"] === "мужчина" && $villager["age"] > 18) {
        $conscripts[] = $villager;
    }
}

// --- 2) Список вооружения ---
$weapons = [
    ["name" => "Лук", "bonus" => ["strength" => 2, "intelligence" => 1, "hp" => 0], "class" => "ranged"],
    ["name" => "Праща", "bonus" => ["strength" => 1, "intelligence" => 0, "hp" => 0], "class" => "ranged"],
    ["name" => "Меч", "bonus" => ["strength" => 3, "intelligence" => 0, "hp" => 0], "class" => "melee"],
    ["name" => "Копье", "bonus" => ["strength" => 2, "intelligence" => 0, "hp" => 1], "class" => "melee"],
    ["name" => "Щит", "bonus" => ["strength" => 0, "intelligence" => 0, "hp" => 3], "class" => "melee"],
    ["name" => "Силки и ловушки", "bonus" => ["strength" => 0, "intelligence" => 5, "hp" => 0], "class" => "scout"],
];

// --- 2) Раздача оружия случайно призванным и обновление характеристик ---
$militia = []; // ополчение с оружием
for ($i = 0; $i < count($conscripts); $i++) {
    $soldier = $conscripts[$i];
    $weapon = $weapons[array_rand($weapons)];
    // применяем бонусы
    $soldier["weaponName"] = $weapon["name"];
    $soldier["weaponClass"] = $weapon["class"];
    $soldier["hp"] += $weapon["bonus"]["hp"];
    $soldier["strength"] += $weapon["bonus"]["strength"];
    $soldier["intelligence"] += $weapon["bonus"]["intelligence"];
    $militia[] = $soldier;
}

// --- 3) Разбивка ополчения на отряды по типу оружия и выбор командиров (max intelligence) ---
$ourUnits = [
    "ranged" => [], // лучники/пращники
    "melee" => [],  // мечники/копейщики/щитоносцы
    "scout" => []   // следопыты/ловушки
];

for ($i = 0; $i < count($militia); $i++) {
    $m = $militia[$i];
    if ($m["weaponClass"] === "ranged") {
        $ourUnits["ranged"][] = $m;
    } elseif ($m["weaponClass"] === "melee") {
        $ourUnits["melee"][] = $m;
    } else {
        $ourUnits["scout"][] = $m;
    }
}

// определяем командиров (по максимальному intelligence)
$ourCommanders = ["ranged" => null, "melee" => null, "scout" => null];
foreach ($ourUnits as $type => $unitList) {
    $maxInt = -1;
    $commanderName = null;
    for ($i = 0; $i < count($unitList); $i++) {
        if ($unitList[$i]["intelligence"] > $maxInt) {
            $maxInt = $unitList[$i]["intelligence"];
            $commanderName = $unitList[$i]["name"];
        }
    }
    $ourCommanders[$type] = $commanderName;
}

// --- 4) Карта леса 10x10 с эмодзи (чаща, кустарник, полянка, дичь, варг) ---
$tileTypes = ["Чаща" => "🌲", "Кустарник" => "🌿", "Поляна" => "🌾", "Дичь" => "🦌", "варг" => "🐺"];
$mapSize = 10;
$forestMap = [];
for ($y = 0; $y < $mapSize; $y++) {
    $row = [];
    for ($x = 0; $x < $mapSize; $x++) {
        // делаем варгов реже
        $r = rand(1, 100);
        if ($r <= 8) $cell = "варг";
        elseif ($r <= 40) $cell = "Чаща";
        elseif ($r <= 70) $cell = "Кустарник";
        elseif ($r <= 85) $cell = "Поляна";
        else $cell = "Дичь";
        $row[] = $cell;
    }
    $forestMap[] = $row;
}
// карта с эмодзи для вывода (только подготовка данных)
$forestEmojiMap = [];
for ($y = 0; $y < $mapSize; $y++) {
    $row = [];
    for ($x = 0; $x < $mapSize; $x++) {
        $cell = $forestMap[$y][$x];
        $row[] = ["type" => $cell, "emoji" => $tileTypes[$cell]];
    }
    $forestEmojiMap[] = $row;
}

// очищаем лес: заменяем все "варг" на "Чаща"
$cleanedForestMap = $forestMap;
for ($y = 0; $y < $mapSize; $y++) {
    for ($x = 0; $x < $mapSize; $x++) {
        if ($cleanedForestMap[$y][$x] === "варг") $cleanedForestMap[$y][$x] = "Чаща";
    }
}
$cleanedEmojiMap = [];
for ($y = 0; $y < $mapSize; $y++) {
    $row = [];
    for ($x = 0; $x < $mapSize; $x++) {
        $cell = $cleanedForestMap[$y][$x];
        $row[] = ["type" => $cell, "emoji" => $tileTypes[$cell]];
    }
    $cleanedEmojiMap[] = $row;
}

// --- 5) Подсчёт характеристик отрядов (сумма hp, strength, intelligence) ---
$ourStats = [];
foreach ($ourUnits as $type => $unitList) {
    $sumHp = 0; $sumStr = 0; $sumInt = 0;
    for ($i = 0; $i < count($unitList); $i++) {
        $sumHp += $unitList[$i]["hp"];
        $sumStr += $unitList[$i]["strength"];
        $sumInt += $unitList[$i]["intelligence"];
    }
    $ourStats[$type] = ["hp" => $sumHp, "strength" => $sumStr, "intelligence" => $sumInt, "count" => count($unitList)];
}

// --- 6) Генерация врагов и разбиение на 3 отряда ---
// враги: гоблины (30..50), орки (2..10)
$enemyPool = [];
$goblinCount = rand(30, 50);
$orcCount = rand(2, 10);
// гоблины
for ($i = 0; $i < $goblinCount; $i++) {
    $enemyPool[] = ["type" => "гоблин", "hp" => rand(6, 12), "strength" => rand(2, 4), "intelligence" => rand(1, 3)];
}
// орки
for ($i = 0; $i < $orcCount; $i++) {
    $enemyPool[] = ["type" => "орк", "hp" => rand(12, 20), "strength" => rand(4, 7), "intelligence" => rand(1, 3)];
}

// оружие врагов: топор(+4), праща(+1), лук(+2)
$enemyWeapons = [
    ["name" => "Топор", "bonus" => ["strength" => 4], "class" => "melee"],
    ["name" => "Праща", "bonus" => ["strength" => 1], "class" => "ranged"],
    ["name" => "Лук", "bonus" => ["strength" => 2], "class" => "ranged"]
];
// раздача оружия врагам
for ($i = 0; $i < count($enemyPool); $i++) {
    $w = $enemyWeapons[array_rand($enemyWeapons)];
    $enemyPool[$i]["weaponName"] = $w["name"];
    $enemyPool[$i]["weaponClass"] = $w["class"];
    $enemyPool[$i]["strength"] += $w["bonus"]["strength"];
}

// разбиение на 3 отряда (приблизительно равномерно)
$enemyUnits = [[], [], []];
for ($i = 0; $i < count($enemyPool); $i++) {
    $enemyUnits[$i % 3][] = $enemyPool[$i];
}

// подсчёт характеристик вражеских отрядов
$enemyStats = [];
for ($k = 0; $k < 3; $k++) {
    $sumHp = 0; $sumStr = 0; $sumInt = 0;
    for ($i = 0; $i < count($enemyUnits[$k]); $i++) {
        $sumHp += $enemyUnits[$k][$i]["hp"];
        $sumStr += $enemyUnits[$k][$i]["strength"];
        $sumInt += $enemyUnits[$k][$i]["intelligence"];
    }
    $enemyStats[$k] = ["hp" => $sumHp, "strength" => $sumStr, "intelligence" => $sumInt, "count" => count($enemyUnits[$k])];
}
?>

<h2>1) Все жители деревни (<?= count($villagers) ?>)</h2>
<table class="table">
    <tr><th>Имя</th><th>Пол</th><th>Возраст</th><th>HP</th><th>Сила</th><th>Интеллект</th></tr>
    <?php foreach ($villagers as $hobbit) { ?>
        <tr>
            <td><?= $hobbit["name"] ?></td>
            <td><?= $hobbit["gender"] ?></td>
            <td><?= $hobbit["age"] ?></td>
            <td><?= $hobbit["hp"] ?></td>
            <td><?= $hobbit["strength"] ?></td>
            <td><?= $hobbit["intelligence"] ?></td>
        </tr>
    <?php } ?>
</table>

<h2>2) Призванные мужчины (>18) — ополчение (<?= count($militia) ?>)</h2>
<table class="table">
    <tr><th>Имя</th><th>Возраст</th><th>HP</th><th>Сила</th><th>Интеллект</th><th>Оружие</th></tr>
    <?php foreach ($militia as $m) { ?>
        <tr>
            <td><?= $m["name"] ?></td>
            <td><?= $m["age"] ?></td>
            <td><?= $m["hp"] ?></td>
            <td><?= $m["strength"] ?></td>
            <td><?= $m["intelligence"] ?></td>
            <td><?= $m["weaponName"] ?></td>
        </tr>
    <?php } ?>
</table>

<h2>3) Отряды и командиры</h2>
<div class="grid">

    <div class="unit">
        <h3>🏹 Стрелки (<?= $ourStats["ranged"]["count"] ?? 0 ?>)</h3>
        <p><b>Командир:</b> <?= $ourCommanders["ranged"] ?? "нет" ?></p>
        <p>❤️ Здоровье: <?= $ourStats["ranged"]["hp"] ?? 0 ?> | ⚔️ Сила: <?= $ourStats["ranged"]["strength"] ?? 0 ?> | 🧠 Интеллект: <?= $ourStats["ranged"]["intelligence"] ?? 0 ?></p>
        <?php if (!empty($ourUnits["ranged"])) { ?>
            <div class="vlist">
                <?php foreach ($ourUnits["ranged"] as $u) { ?>
                    <div class="smallcard">
                        <div class="avatar">🏹</div>
                        <div class="info">
                            <b><?= $u["name"] ?></b><br>
                            🪓 Оружие: <?= $u["weaponName"] ?><br>
                            ❤️ <?= $u["hp"] ?> | ⚔️ <?= $u["strength"] ?> | 🧠 <?= $u["intelligence"] ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p><i>Нет бойцов</i></p>
        <?php } ?>
    </div>

    <div class="unit">
        <h3>⚔️ Ближний бой (<?= $ourStats["melee"]["count"] ?? 0 ?>)</h3>
        <p><b>Командир:</b> <?= $ourCommanders["melee"] ?? "нет" ?></p>
        <p>❤️ Здоровье: <?= $ourStats["melee"]["hp"] ?? 0 ?> | ⚔️ Сила: <?= $ourStats["melee"]["strength"] ?? 0 ?> | 🧠 Интеллект: <?= $ourStats["melee"]["intelligence"] ?? 0 ?></p>
        <?php if (!empty($ourUnits["melee"])) { ?>
            <div class="vlist">
                <?php foreach ($ourUnits["melee"] as $u) { ?>
                    <div class="smallcard">
                        <div class="avatar">🛡️</div>
                        <div class="info">
                            <b><?= htmlspecialchars($u["name"]) ?></b><br>
                            🪓 Оружие: <?= $u["weaponName"] ?><br>
                            ❤️ <?= $u["hp"] ?> | ⚔️ <?= $u["strength"] ?> | 🧠 <?= $u["intelligence"] ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p><i>Нет бойцов</i></p>
        <?php } ?>
    </div>
    <div class="unit">
    <h3>🕵️ Диверсанты / Следопыты (<?= $ourStats["scout"]["count"] ?? 0 ?>)</h3>
    <p><b>Командир:</b> <?= $ourCommanders["scout"] ?? "нет" ?></p>
    <p>❤️ Здоровье: <?= $ourStats["scout"]["hp"] ?? 0 ?> | ⚔️ Сила: <?= $ourStats["scout"]["strength"] ?? 0 ?> | 🧠 Интеллект: <?= $ourStats["scout"]["intelligence"] ?? 0 ?></p>
    <?php if (!empty($ourUnits["scout"])) { ?>
        <div class="vlist">
            <?php foreach ($ourUnits["scout"] as $u) { ?>
                <div class="smallcard">
                    <div class="avatar">🕸️</div>
                    <div class="info">
                        <b><?= htmlspecialchars($u["name"]) ?></b><br>
                        🪓 Оружие: <?= $u["weaponName"] ?><br>
                        ❤️ <?= $u["hp"] ?> | ⚔️ <?= $u["strength"] ?> | 🧠 <?= $u["intelligence"] ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p><i>Нет бойцов</i></p>
    <?php } ?>
</div>
</div>

<h2>4) Карта леса (исходная)</h2>
<div class="map">
    <?php foreach ($forestEmojiMap as $row) { ?>
        <div class="map-row">
            <?php foreach ($row as $cell) { ?>
                <div class="cell" title="<?= $cell['type'] ?>"><?= $cell['emoji'] ?></div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<h2>После прочёсывания (все варги заменены на чащу)</h2>
<div class="map">
    <?php foreach ($cleanedEmojiMap as $row) { ?>
        <div class="map-row">
            <?php foreach ($row as $cell) { ?>
                <div class="cell" title="<?= $cell['type'] ?>"><?= $cell['emoji'] ?></div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<h2>5) Вражеские отряды (3)</h2>
<div class="grid">

    <!-- Вражеские стрелки -->
    <div class="unit">
        <h3>🏹 Вражеские стрелки (<?= $enemyStats["ranged"]["count"] ?? 0 ?>)</h3>
        <p><b>Командир:</b> <?= $enemyCommanders["ranged"] ?? "нет" ?></p>
        <p>❤️ Здоровье: <?= $enemyStats["ranged"]["hp"] ?? 0 ?> | ⚔️ Сила: <?= $enemyStats["ranged"]["strength"] ?? 0 ?> | 🧠 Интеллект: <?= $enemyStats["ranged"]["intelligence"] ?? 0 ?></p>
        <?php if (!empty($enemyUnits["ranged"])) { ?>
            <div class="vlist">
                <?php foreach ($enemyUnits["ranged"] as $u) { ?>
                    <div class="smallcard">
                        <div class="avatar">🏹</div>
                        <div class="info">
                            <b><?= htmlspecialchars($u["name"]) ?></b><br>
                            🪓 Оружие: <?= $u["weaponName"] ?><br>
                            ❤️ <?= $u["hp"] ?> | ⚔️ <?= $u["strength"] ?> | 🧠 <?= $u["intelligence"] ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="empty"><i>Нет бойцов</i></p>
        <?php } ?>
    </div>

    <!-- Вражеский ближний бой -->
    <div class="unit">
        <h3>⚔️ Вражеский ближний бой (<?= $enemyStats["melee"]["count"] ?? 0 ?>)</h3>
        <p><b>Командир:</b> <?= $enemyCommanders["melee"] ?? "нет" ?></p>
        <p>❤️ Здоровье: <?= $enemyStats["melee"]["hp"] ?? 0 ?> | ⚔️ Сила: <?= $enemyStats["melee"]["strength"] ?? 0 ?> | 🧠 Интеллект: <?= $enemyStats["melee"]["intelligence"] ?? 0 ?></p>
        <?php if (!empty($enemyUnits["melee"])) { ?>
            <div class="vlist">
                <?php foreach ($enemyUnits["melee"] as $u) { ?>
                    <div class="smallcard">
                        <div class="avatar">🛡️</div>
                        <div class="info">
                            <b><?= htmlspecialchars($u["name"]) ?></b><br>
                            🪓 Оружие: <?= $u["weaponName"] ?><br>
                            ❤️ <?= $u["hp"] ?> | ⚔️ <?= $u["strength"] ?> | 🧠 <?= $u["intelligence"] ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="empty"><i>Нет бойцов</i></p>
        <?php } ?>
    </div>

</div>