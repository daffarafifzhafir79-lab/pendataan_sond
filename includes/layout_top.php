<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($page_title)) $page_title = " Sound Event Organizer";
if (!isset($extra_head)) $extra_head = "";
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title) ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

  
  <link rel="stylesheet" href="../assets/css/css_style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <?= $extra_head ?>
</head>
<body>
    <div class="bg-blur"></div>
<div class="bg-overlay"></div>


<div class="app">
  <?php include __DIR__ . '/sidebar.php'; ?>

  <main class="content">
