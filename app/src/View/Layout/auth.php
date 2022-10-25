<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/resources/css/base.css">
    <link rel="stylesheet" href="/resources/css/auth.css">
    <link rel="stylesheet" href="/resources/css/login.css">
</link>
<body>

    <h1>Auth</h1>
    <h3>Header</h3>
    <?php $this->renderSection('content'); ?>
    <h3>Footer</h3>

    <?php $this->renderScript(); ?>
</body>
</html>
