<?php

use chillerlan\QRCode\QRCode;

$this->layout('main'); ?>

<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/qrcode.css">
<?php $this->endStyle(); ?>
<?php $this->section('header'); ?>
<a href="/">
  <img src="/resources/images/chevron-left.png">
</a>
<span id="titlePage"><?= $titlePage ?></span>



<div id="menuHeader">
  <a href="" onclick="printDiv()">
    <img src="/resources/images/printer.png">
  </a>
</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<?php $id = urlencode($_COOKIE["__masu"]); ?>


<div id="qr">

  <div id="cardQR">
    <span class="titleQR"><?= $eventTitle ?></span>
    <div class="message">
      <span class="txtMessage"><?= $welcomeMessage ?></span>


    </div>
    <span class="nickname"><?= $name ?></span>
    <div id="wrapImage">
      <img src="/resources/uploads/settings/<?= $welcomeMessageFilename ?>" alt="" onerror="this.style.display='none'">
    </div>
    <img id="imgQR" src="<?= (new QRCode())->render($_ENV["BASE_URL"] . "/join/$id"); ?>" width="346" height="346">
    <a class="qrc" href="/join/<?= $id ?>"><?= $_ENV["BASE_URL"] . "/join/$id" ?></a>
  </div>

</div>

<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  function printDiv() {

    var divContents = document.getElementById("imgQR").outerHTML;
    var a = window.open('', '', 'height=346, width=346');
    a.document.write(divContents);
    a.document.close();
    a.print();
  }
</script>
<?php $this->endScript(); ?>;