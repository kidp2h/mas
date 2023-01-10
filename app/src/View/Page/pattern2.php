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





<?php $this->end(); ?>

<?php $this->startScript(); ?>
<!-- <script>
  const offsetImage = 200
  const leftWidth = $("#wrapImageLeft").offsetWidth - offsetImage;
  const leftHeight = $("#wrapImageLeft").offsetHeight - offsetImage;
  const rightWidth = $("#wrapImageRight").offsetWidth - offsetImage;
  const rightHeight = $("#wrapImageRight").offsetHeight - offsetImage;
  let countImage = $$(".photoAttendee").length;


  function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
  }
  $$("#wrapImageLeft img").forEach((ele) => {
    let randomTop = getRandomNumber(0, leftHeight);
    let randomLeft = getRandomNumber(0, leftWidth);
    ele.style.top = `${randomTop}px`
    ele.style.left = `${randomLeft}px`
  })

  $$("#wrapImageRight img").forEach((ele) => {



    let randomTop = getRandomNumber(0, rightHeight);
    let randomLeft = getRandomNumber(0, rightWidth);

    ele.style.top = `${randomTop}px`
    ele.style.left = `${randomLeft}px`
  })




  async function poll() {

    let data = new FormData();
    data.append('now', Date.now());
    const result = await fetch("/get-new-images", {
      method: "POST",
      body: data,
    })
    const response = await result.json();
    if (response.status) {
      const data = response.data;
      const pos = [$('#wrapImageLeft'), $('#wrapImageRight')];
      const leftOrRight = pos[getRandomNumber(0, 2)]
      data.forEach(photo => {
        const img = document.createElement('img');
        img.classList.add("photoAttendee")
        img.setAttribute("message", photo.attendeeComment)
        img.setAttribute("nickname", photo.attendeeName)
        img.setAttribute("index", countImage)
        img.src = `/resources/uploads/${photo.attendeeFileName}`

        leftOrRight.append(img);
        ++countImage;

      });
      await timeout(3000);
      poll();
    } else {
      await timeout(1000);
      poll();
    }

  }

  function getRandomNumber(min, max) {

    return Math.floor(Math.random() * (max - min) + min);

  }
  poll();
</script> -->
<script>
  const wrapImageWidth = $("#wrapImage").offsetWidth;
  const widthCenter = $(".cardCenter").offsetWidth;
  const heightCenter = $(".cardCenter").offsetHeight - 200;
  const side = ['left', 'right']
  let POS_SAVED = [];
  let current = 0;

  console.log(widthCenter, heightCenter);
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
  // setInterval(() => {


  // }, 1000)

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