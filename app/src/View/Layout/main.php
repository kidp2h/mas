<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="/resources/css/base.css">
  <link rel="stylesheet" href="/resources/css/main.css">
  <?php $this->renderStyle(); ?>



</head>
<div id="overlay">
  <div id="wrapDetail">
    <img src="" alt="">
  </div>
</div>
<div id="overlay2">
</div>
<div id="header">
  <?php $this->renderSection('header'); ?>
</div>
<?php $this->renderSection('content'); ?>

<body>
  <script src="/resources/js/main.js"></script>
  <?php $this->renderScript(); ?>
</body>

</html>