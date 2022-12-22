<?php $this->layout('main'); ?>

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
<div class="wrapFlex">
  <div id="wrapCarousel">
    <div id="listImage">
      <div class="cardImage empty">
        <img src="/resources/images/cat1.jpg" alt="">
      </div>
      <div class="wrapVisible">
        <?php foreach ($photos as $key => $value) { ?>
          <div class="cardImage visible">
            <span class="card-message"><?= $value->attendeeComment ?></span>
            <img src="/resources/uploads/<?= $value->attendeeFileName ?>" alt="">
            <span class="nickname">From <?= $value->attendeeName ?></span>
          </div>

        <?php } ?>
      </div>

      <div class="cardImage empty">
        <img src="/resources/images/cat1.jpg" alt="">
      </div>

    </div>
  </div>
</div>

<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
  }
  let countImage = $$(".cardImage.visible").length;


  let current = 1;
  let step = 1;
  ($$(".cardImage.visible"))[0]?.classList?.add('select');
  setInterval(async () => {

    if (current >= 1)($$(".cardImage.visible"))[current - 1]?.classList?.remove('select');

    if (current === 0) $$(".cardImage.visible")[countImage - 1]?.classList?.remove('select');
    ($$(".cardImage.visible"))[current]?.classList?.add('select');
    await timeout(500)
    $("#listImage").scrollTo({
      behavior: 'smooth',
      left: $$(".cardImage.visible")[current - 1]?.offsetLeft - 80
    });
    if (current === countImage - 1) current = 0;
    else current = current + step;


  }, 3000);
  async function poll() {

    let data = new FormData();
    data.append('now', Date.now());
    const result = await fetch("/get-images", {
      method: "POST",
      body: data,
    })
    const response = await result.json();
    if (response.status) {
      const data = response.data;
      const wrapVisible = $(".wrapVisible");
      console.log("new");
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
      poll();
    } else {
      await timeout(1000);
      poll();
    }

  }
  poll();
</script>
<?php $this->endScript(); ?>;