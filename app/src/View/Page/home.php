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

    <?php foreach ($photos as $key => $value) { ?>
      <div class="card photo">
        <img class="cardImage" src="/resources/uploads/<?= $value->attendeeFileName ?>" alt="">
        <div class="imageAction">
          <div class="downloadImage btn-img-action">
            <img src="/resources/images/download2.png" alt="">
          </div>
          <div class="deleteImage btn-img-action">
            <img src="/resources/images/del.png" alt="">
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  document.getElementById("hamburger").addEventListener("click", function() {
    this.classList.toggle("open");
    document.getElementById("overlay").classList.toggle("active")
  })

  $$('.deleteImage').forEach(btnDelete => {
    btnDelete.addEventListener('click', function() {
      const cardPhoto = this.parentElement.parentElement.remove();
    })
  })

  $$('.downloadImage').forEach(btnDownload => {
    btnDownload.addEventListener('click', function() {
      const link = document.createElement('a')
      link.href = this.parentElement.parentElement.querySelector('.cardImage').src;
      link.download = Date.now();
      link.click();
    })
  });
  $$('.cardImage').forEach(cardImage => {
    cardImage.addEventListener('click', function() {
      const urlImage = this.src;
      $("#overlay").classList.add('active');
      $("#wrapDetail > img").src = urlImage;
    })
  });
  $("#overlay").addEventListener('click', function(e) {
    if (e?.srcElement?.classList?.contains('active')) $("#overlay").classList.remove('active');
  })
</script>
<?php $this->endScript(); ?>