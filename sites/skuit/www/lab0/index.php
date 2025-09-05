<?php
$fullname = "******";
$group = "*****";
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>lab0</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
<div class="card shadow-lg p-4 text-center" style="max-width: 400px;">
<h1 class="h4 text-primary mb-3">HELLO WORLD</h1>
<div class="alert alert-info mb-3">
<strong>ФИО:</strong> <?= $fullname?><br>
<strong>Группа:</strong> <?= $group?>
</div>
<button class="btn btn-success w-100">👍</button>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>