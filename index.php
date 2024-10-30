<?php
use App\Storage;
require_once __DIR__ . '/vendor/autoload.php';
$storage = Storage::getInstance();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Pizza</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
  <script src="js/main.js" defer></script>
</head>
<body>
<h1>Заказ пиццы</h1>

<form>
  <label for="pizza">Выберите пиццу:</label>
  <select id="pizzaId">
      <?php foreach ($storage->getPizzas() as $pizza): ?>
        <option value="<?= $pizza['id'] ?>"><?= $pizza['name'] ?></option>
      <?php endforeach; ?>
  </select>

  <label for="size">Выберите размер:</label>
  <select id="sizeId">
      <?php foreach ($storage->getSizes() as $size): ?>
        <option value="<?= $size['id'] ?>"><?= ($size['name']) ?></option>
      <?php endforeach; ?>
  </select>

  <label for="sauce">Выберите соус:</label>
  <select id="sauceId">
      <?php foreach ($storage->getSauses() as $sauce): ?>
        <option value="<?= $sauce['id'] ?>"><?= $sauce['name'] ?></option>
      <?php endforeach; ?>
  </select>

  <button id="order">Заказать</button>
</form>

<div id="receipt"></div>
</body>
</html>
