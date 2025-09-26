    <h1>🧙‍♂️ Подготовка хоббитов к путешествию</h1>

<?php
$allHobbits = ["Фродо", "Сэм", "Мери", "Пиппин", "Бильбо", "Тук", "Лобелия", "Рози", "Фатти Болджер", "Одо", "Фредегар"];

// Определяем, сколько хоббитов пойдёт в поход (от 2 до 5)
$partySize = rand(2, 5);

// Перемешиваем массив и берём нужное количество имён
shuffle($allHobbits);
$party = array_slice($allHobbits, 0, $partySize);
$names = implode(', ', $party);
$countParty = count($party);

$transports = ["лошадь", "осёл", "повозка", "нет транспорта"];
$transport = $transports[rand(0, count($transports) - 1)];

$allSupplies = ["лембас", "яблоки", "грибы", "мёд", "сыр", "сало", "копчёная рыба"];
shuffle($allSupplies);
$suppliesCount = rand(2, 6);
$supplies = array_slice($allSupplies, 0, $suppliesCount);

$partyEvents = [
    "{hobbit} решил испечь пирог перед выходом.",
    "{hobbit} не смог найти свой плащ, пришлось искать всем вместе.",
    "{hobbit} потерял карту и пришлось искать её по всему дому.",
    "{hobbit} помог собрать лишний мешок орехов, и это задержало выход.",
    "{hobbit} наоборот всех поторопил, и сборы пошли быстрее!",
];

$delayDays = count($supplies);

shuffle($partyEvents);
$eventsCount = rand(1, 3);
$events = array_slice($partyEvents, 0, $eventsCount);

$delayDays += count($events);

$nazgulDays = 5;
?>

<div class='block'>
    В поход отправятся <?= $countParty?> хоббитов: <?= $names?><br>
</div>

<div class='block'>
    <?if ($transport === 'нет транспорта') {?>
        К сожалению, транспорта нет. Хоббитам придётся идти пешком!
    <?} else {?>
        Хоббиты нашли транспорт: <?=$transport?>
    <?}?>
</div>

<div class='block'>
    Собрали припасы:<br>
    <?foreach ($supplies as $supply) {
        echo("- $supply <br>");
    }?>
</div>

<div class='block'>
    Случившиеся события:<br>
    <?foreach ($events as $event) {
        $event = str_replace('{hobbit}', $party[array_rand($party)], $event);
        echo("$event <br>");
    }?>
</div>

<div class='block'>
    Столько дней собирались хоббиты: <?= $delayDays?><br>
</div>

<div class='block'>
    <?if ($delayDays < $nazgulDays) {?>
        ✨ Хоббиты успели выйти в путь раньше назгулов!
    <?} elseif ($delayDays === $nazgulDays) {?>
        ✨ Хоббиты успели улизнуть от назгулов в самый последний момент
    <?} else {?>
        ⚔️ Назгулы настигли хоббитов! Хоббиты слишком долго собирались и опаздали на опоздали на столько дней: <?=($delayDays - $nazgulDays)?>
    <?}?>
</div>