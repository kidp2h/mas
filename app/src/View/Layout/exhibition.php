<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="/resources/css/base.css">
  <link rel="stylesheet" href="/resources/css/pattern1.css">
  <?php $this->renderStyle(); ?>
</head>
<div id="header">
  <?php $this->renderSection('header'); ?>
</div>
<?php $this->renderSection('content'); ?>

<body>
  <?php $this->renderScript(); ?>
</body>

</html>