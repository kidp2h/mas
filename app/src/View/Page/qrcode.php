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
  <a href="/display">
    <img src="/resources/images/display.png">
  </a>
  <a href="/qrcode">
    <img src="/resources/images/qrcode.png">
  </a>

  <a href="/settings">
    <img src="/resources/images/gear.png">
  </a>
</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<?php $id = urlencode($_COOKIE["__masu"]); ?>
<div id="action">
  <a href="">
    <div id="print" class="itemAction" onclick="printDiv()">
      <img src="/resources/images/printer.png" alt="">
    </div>
  </a>
</div>


<div id="qr">

  <div id="cardQR">
    <span class="titleQR">招待メッセージ invitation message</span>
    <img id="imgQR" src="<?= (new QRCode())->render($_ENV["BASE_URL"] . "/join/$id"); ?>" width="346" height="346">
    <a href="/">https://mas.com/</a>
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