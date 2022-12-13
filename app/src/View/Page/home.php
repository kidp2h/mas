
<?php $this->layout('main'); ?>
<?php $this->style(); ?>
   <link rel="stylesheet" href="/resources/css/home.css">
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
      <a href="/qrcode">
        <div class="imageItem">
          <img src="/resources/images/qrcode.png">
        </div>
        <span>QR Code</span>
      </a>

    </li>
    <li class="itemMenu">
      <a href="/settings">
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

<div id="action">
  <a href="">
    <div id="download" class="itemAction">
      <img src="/resources/images/download.png" alt="">
    </div>
  </a>
  <a href="">
    <div id="trash" class="itemAction">
      <img src="/resources/images/trash.png" alt="">
    </div>
  </a>
</div>
<div id="wrapListPhoto">
  <div id="listPhoto">
    <div class="card photo">
      <img src="/resources/images/cat1.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat2.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat3.jpg" alt="">
    </div>


    <div class="card photo">
      <img src="/resources/images/cat3.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat2.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat1.jpg" alt="">
    </div>


    <div class="card photo">
      <img src="/resources/images/cat3.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat3.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat2.jpg" alt="">
    </div>

    <div class="card photo">
      <img src="/resources/images/cat2.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat1.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat2.jpg" alt="">
    </div>


    <div class="card photo">
      <img src="/resources/images/cat1.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat3.jpg" alt="">
    </div>
    <div class="card photo">
      <img src="/resources/images/cat2.jpg" alt="">
    </div>
  </div>
</div>

<?php $this->end(); ?>

<?php $this->startScript(); ?>
  <script>
    document.getElementById("hamburger").addEventListener("click", function() {
      this.classList.toggle("open");
      document.getElementById("overlay").classList.toggle("active")
    })
  </script>
<?php $this->endScript(); ?>
