<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="/resources/css/base.css">
  <?php $this->renderStyle(); ?>

<body>
  <?php $this->renderAllSection(); ?>


  <script src="/resources/js/main.js"></script>
  <?php $this->renderScript(); ?>

</body>


</html>