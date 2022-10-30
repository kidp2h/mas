<?php $this->layout('main'); ?>

<?php $this->style(); ?>
   <link rel="stylesheet" href="/resources/css/qrcode.css">
<?php $this->endStyle(); ?>
<?php $this->section('header'); ?>
<a href="/user/logout">
  <img src="/resources/images/chevron-left.png">
</a>
<span id="titlePage"><?= $titlePage ?></span>
<div id="hamburger">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
</div>

<div class="wrapMenu">
  <ul id="menuHamburger">
    <li class="itemMenu">
      <a href="">
        <div class="imageItem">
          <img src="/resources/images/display.png">
        </div>

        <span>Display</span>
      </a>

    </li>
    <li class="itemMenu">
      <a href="">
        <div class="imageItem">
          <img src="/resources/images/qrcode.png">
        </div>
        <span>QR Code</span>
      </a>

    </li>
    <li class="itemMenu">
      <a href="">
        <div class="imageItem">
          <img src="/resources/images/gear.png">
        </div>
        <span>Settings</span>
      </a>

    </li>
  </ul>
</div>


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

<?php $this->end(); ?>
