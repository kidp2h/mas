<?php $this->layout('main'); ?>

<?php $this->style(); ?>
   <link rel="stylesheet" href="/resources/css/qrcode.css">
<?php $this->endStyle(); ?>
<?php $this->section('header'); ?>
<a href="/user/logout">
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

<div id="action">
  <a href="">
    <div id="trash" class="itemAction">
      <img src="/resources/images/printer.png" alt="">
    </div>
  </a>
</div>


<div id="qr">

<div id="cardQR">
  <span class="titleQR">招待メッセージ invitation message</span>
  <img src="/resources/images/qr.png" >
  <a href="/">https://mas.com/</a>
</div>

</div>

<?php $this->end(); ?>
