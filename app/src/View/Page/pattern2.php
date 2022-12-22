<?php $this->layout('main'); ?>

<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/pattern2.css">
<?php $this->endStyle(); ?>
<?php $this->section('header'); ?>
<a href="/">
  <img src="/resources/images/chevron-left.png">
</a>
<span id="titlePage"><?= $titlePage ?></span>



<div id="menuHeader">
  <a href="/pattern2">
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
<div id="wrapImage">
  <div id="wrapImageLeft">
    <!-- <img src="/resources/images/cat1.jpg" alt=""> -->
  </div>
  <div id="wrapImageCenter">
    <img src="/resources/images/cat1.jpg" alt="">
  </div>
  <div id="wrapImageRight">

    <!-- <img src="/resources/images/cat1.jpg" alt=""> -->
  </div>
</div>




<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  const winWidth = $(".wrapOutside").offsetWidth - 200;
  const winHeight = $(".wrapOutside").offsetHeight - 200;

  function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
  }
  $$(".wrapImageOutside").forEach((ele) => {
    let randomTop = getRandomNumber(0, winHeight);
    let randomLeft = getRandomNumber(0, winWidth);
    ele.style.top = `${randomTop}px`
    ele.style.left = `${randomLeft}px`
  })

  function getRandomNumber(min, max) {

    return Math.random() * (max - min) + min;

  }
</script>
<?php $this->endScript(); ?>;