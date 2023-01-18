<?php

use chillerlan\QRCode\QRCode;

$this->layout('main'); ?>

<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/pattern1.css">
<?php $this->endStyle(); ?>
<?php $this->section('header'); ?>
<a href="/">
  <img src="/resources/images/chevron-left.png">
</a>
<span id="titlePage"><?= $titlePage ?></span>



<div id="menuHeader">
  <a href="/pattern1">
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
  <div id="wrapCarousel">
    <div id="listImage">
      <div class="cardImage empty">
        <img src="/resources/images/cat1.jpg" alt="">
      </div>
      <div class="wrapVisible">
        <?php $index = 0 ?>
        <?php foreach ($photos as $key => $value) { ?>
          <div class="cardImage visible" index="<?= $index ?>">
            <span class="card-message"><?= $value->attendeeComment ?></span>
            <img src="/resources/uploads/<?= $value->attendeeFileName ?>" alt="">
            <span class="nickname">From <?= $value->attendeeName ?></span>
          </div>

        <?php
          $index++;
        } ?>
      </div>

      <div class="cardImage empty">
        <img src="/resources/images/cat1.jpg" alt="">
      </div>

    </div>
  </div>
</div>
<div class="actionPattern">
  <a href="/uploadExhibition">
    <img src="/resources/images/pattern-cam.png">
  </a>
  <div class="circle">
    <img src="<?= (new QRCode())->render($_ENV["BASE_URL"] . "/join/$id"); ?>" alt="">
  </div>
</div>

<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
  }
  let countImage = $$(".cardImage.visible").length;
  let countImageValid = $$(".wrapVisible > .cardImage").length;

  let current = 0;
  let step = 1;
  let idInterval = null;
  let queueAction = []
  //($$(".cardImage.visible"))[0]?.classList?.add('select');
  const loopSlideFunction = async () => {
    // console.log(current);
    // if (current >= 1)($$(".cardImage.visible"))[current - 1]?.classList?.remove('select');


    console.log(queueAction);
    // if (queueAction.length !== 0) {
    //   queueAction.forEach(action => {
    //     switch (action) {
    //       case 'left':

    //         // prevSlide();
    //         //console.log(current);
    //         gotoSlide(current - 1);

    //         --current;
    //         //console.log(current);
    //         break;
    //       case 'right':
    //         gotoSlide(current + 1);
    //         ++current;
    //         break;
    //     }
    //     queueAction.shift();
    //   })
    //   await timeout(3000)
    // } else {

    if (countImage == 1) {
      $(".cardImage.visible").classList.add('select');
    } else {
      nextSlide()
    }
    // }

    // ($$(".cardImage.visible"))[current]?.classList?.add('select');
    // await timeout(500)
    // $("#listImage").scrollTo({
    //   behavior: 'smooth',
    //   left: $$(".cardImage.visible")[current - 1]?.offsetLeft - 80
    // });



  }

  function startSlide() {
    return setInterval(loopSlideFunction, 3000);;
  }

  function resetSlide() {
    clearInterval(idInterval);
    ($$(".cardImage.visible")).forEach((card, index) => {
      card.classList?.remove('select');

    })
    current = 1;
    $("#listImage").scrollTo({
      behavior: 'smooth',
      left: 0
    });

    idInterval = startSlide();
  }

  // function continueSlide() {
  //   clearInterval(idInterval)
  //   set
  // }
  async function nextSlide(type = 1) {
    ($$(".cardImage.visible")).forEach((card, index) => {
      card.classList?.remove('select');

    })
    // current = current + step;
    await timeout(500);
    //console.log(current);

    if (current === countImage) {
      current = 0;
      gotoSlide(0);
      current++;
    } else {
      $("#listImage").scrollTo({
        behavior: 'smooth',
        left: $$(".cardImage.visible")[current - 1]?.offsetLeft - 80
      });
      ($$(".cardImage.visible"))[current]?.classList?.add('select');
      current = current + step;
    }
    //current = number + 1;

  }

  async function prevSlide() {
    // ($$(".cardImage.visible")).forEach((card, index) => {
    //   card.classList?.remove('select');

    // })
    // await timeout(500);
    // //console.log(current);
    // $("#listImage").scrollTo({
    //   behavior: 'smooth',
    //   left: $$(".cardImage.visible")[current - 2]?.offsetLeft - 80
    // });
    // ($$(".cardImage.visible"))[current]?.classList?.add('select');
    // if (current === countImage - 1) current = 0;
    // else current = current + step;
    // //current = number + 1;
    // gotoSlide(current - 2);
    if (current !== 0) {
      ($$(".cardImage.visible")).forEach((card, index) => {
        card.classList?.remove('select');

      })
      await timeout(500);

      //current = number;
      //console.log(current);
      $("#listImage").scrollTo({
        behavior: 'smooth',
        left: $$(".cardImage.visible")[current - 3]?.offsetLeft - 80
      });
      ($$(".cardImage.visible"))[current - 2]?.classList?.add('select');
      current = current - 1;
    }

  }
  async function gotoSlide(number) {
    //clearInterval(idInterval);
    ($$(".cardImage.visible")).forEach((card, index) => {
      card.classList?.remove('select');

    })
    // await timeout(0);

    //current = number;
    //console.log(current);
    $("#listImage").scrollTo({
      behavior: 'smooth',
      left: $$(".cardImage.visible")[number - 1]?.offsetLeft - 80
    });
    ($$(".cardImage.visible"))[number]?.classList?.add('select');
    //current = number + 1;

  }
  idInterval = startSlide();
  async function pollImage() {
    const result = await fetch("/get-new-images", {
      method: "POST",
    })
    const response = await result.json();
    if (response.status) {
      const data = response.data;
      const wrapVisible = $(".wrapVisible");
      data.forEach(photo => {
        const cardImage = document.createElement('div');
        cardImage.classList.add('cardImage', "visible");
        const img = document.createElement('img');
        const message = document.createElement('span');
        const nickname = document.createElement('span');
        nickname.classList.add('nickname')
        message.classList.add('card-message')
        nickname.innerText = `From ${photo.attendeeName}`;
        message.innerText = photo.attendeeComment;
        img.src = `/resources/uploads/${photo.attendeeFileName}`
        cardImage.append(message);
        cardImage.append(img)
        cardImage.append(nickname)
        console.log(cardImage);

        wrapVisible.append(cardImage);
        ++countImage;
      });
      await timeout(3000);
      pollImage();
    } else {
      await timeout(1000);
      pollImage();
    }

  }
  pollImage();

  async function pollRemote() {
    if (countImage > 1) {
      const result = await fetch("/poll-remote", {
        method: "POST",
      })
      const response = await result.json();
      console.log(response);
      if (response.status) {
        clearInterval(idInterval)
        await timeout(500)
        pollRemote();
        const data = response.data
        let numberSlide = null;
        data.forEach((event) => {
          console.log("for");
          switch (event.message) {
            case 'left':
              //numberSlide = current - 1;
              // prevSlide();
              // console.log(current);
              // gotoSlide(current - 1);
              prevSlide()
              // --current;
              // console.log(current);

              break;
            case 'left-start':
              gotoSlide(0);
              current = 1;
              break;
            case 'right':
              // numberSlide = current + 1;
              // console.log(numberSlide);
              nextSlide()
              // console.log(current);
              // gotoSlide(current + 1);
              // ++current;
              //queueAction.push("left");
              break;
            case 'right-end':
              gotoSlide(countImage - 1);
              current = countImage
              break;

            default:
              //queueAction.push(event.message);
              break;
          }
        })
        // idInterval = startSlide();
      } else {
        await timeout(500);
        pollRemote();
      }
    }

  }
  pollRemote();
</script>
<?php $this->endScript(); ?>;