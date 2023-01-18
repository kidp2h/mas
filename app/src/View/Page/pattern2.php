<?php

use chillerlan\QRCode\QRCode;

$this->layout('main'); ?>

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
<?php $id = urlencode($_COOKIE["__masu"]); ?>

<div class="wrapFlex">
  <div id="wrapImage">

    <?php for ($i = 1; !empty($photos) && $i < (count($photos)); $i++) { ?>
      <div class="imageWithMessage outside" index="<?= $i ?>" message="<?= $photos[$i]->attendeeComment ?>" nickname="<?= $photos[$i]->attendeeName ?>">
        <span class="card-message"><?= $photos[$i]->attendeeComment ?></span>
        <img class="imageCenter" src="/resources/uploads/<?= $photos[$i]->attendeeFileName ?>" alt="">
        <div class="nickname"> From <?= $photos[$i]->attendeeName ?></div>
      </div>

    <?php } ?>


    <!-- <div id="wrapImageCenter_ cardImage cardCenter "> -->
    <div class="imageWithMessage cardCenter" index="0">
      <?php
      $first = $photos[0] ?? null;
      ?>
      <span class="card-message"><?= $first ? $first->attendeeComment : "" ?></span>
      <img class="imageCenter" src="<?= $first ? "/resources/uploads/$first->attendeeFileName" : "" ?>" alt="">
      <div class="nickname"> <?= $first ? "From $first->attendeeName"  : "" ?></div>
    </div>

    <!-- </div> -->
    <!-- <div id="wrapImageRight">

      <?php for ($i = ceil((count($photos) - 1) / 2); !empty($photos) && $i < count($photos); $i++) { ?>

        <img class="photoAttendee" src="/resources/uploads/<?= $photos[$i]->attendeeFileName ?>" message="<?= $photos[$i]->attendeeComment ?>" nickname="<?= $photos[$i]->attendeeName ?>" alt="" index="<?= $i ?>">
      <?php } ?>

    </div> -->
  </div>
</div>
<div class="actionPattern">
  <a>
    <img src="/resources/images/pattern-cam.png">
  </a>
  <div class="circle">
    <img src="<?= (new QRCode())->render($_ENV["BASE_URL"] . "/join/$id"); ?>" alt="">
  </div>
</div>






<?php $this->end(); ?>

<?php $this->startScript(); ?>

<script>
  const wrapImageWidth = $("#wrapImage").offsetWidth;
  const widthCenter = $(".cardCenter").offsetWidth;
  const heightCenter = $(".cardCenter").offsetHeight - 200;
  const countImage = $$(".imageWithMessage").length;
  const side = ['left', 'right']
  let POS_SAVED = [];
  let current = 0;

  $$(".outside").forEach(ele => {
    let pos = side[getRandomNumber(0, 2)]
    let randomTop = getRandomNumber(0, heightCenter);
    let randomLeft = null;
    if (pos == 'right') {
      randomLeft = getRandomNumber(($("#wrapImage").offsetWidth - $(".cardCenter").offsetWidth) + 100, wrapImageWidth - 150);
      ele.setAttribute("pos", 'right')
    } else {
      randomLeft = getRandomNumber(100, (($("#wrapImage").offsetWidth - $(".cardCenter").offsetWidth) / 2) - 200);
      ele.setAttribute("pos", 'left')

    }
    ele.style.top = `${randomTop}px`
    ele.style.left = `${randomLeft}px`

  })

  if (countImage >= 2) {
    setInterval(() => {
      let currentElem = $(`.imageWithMessage[index="${current}"]`);
      ++current;
      let next = $(`.imageWithMessage[index="${current}"]`);
      if (currentElem) {
        if (next) {
          swapElement(currentElem, next)
        } else {
          current = 0;
          next = $(`.imageWithMessage[index="${current}"]`);
          swapElement(currentElem, next)
        }
      }

    }, 3000)
  }


  function swapElement(current, next) {
    const {
      top,
      left
    } = next.style;
    next.classList.add("cardCenter")
    next.classList.remove("outside")
    next.style.left = "50%";
    next.style.top = "50%";
    next.style.height = "100%"
    next.style.width = "30%"

    current.style.width = "20rem";
    current.style.height = "20rem";
    current.style.top = top;
    current.style.left = left
    current.style.transform = null;
    current.classList.remove("cardCenter")
    current.classList.add("outside");
  }

  function getRandomNumber(min, max) {

    return Math.floor(Math.random() * (max - min) + min);

  }


  function getValidPos() {

  }
</script>
<?php $this->endScript(); ?>;