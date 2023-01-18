<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/attendee.css">
<link rel="stylesheet" href="/resources/css/toppage.css">
<?php $this->endStyle(); ?>

<?php $this->section('header'); ?>
<div id="header">
  <!-- <a href="/attendee/logout">
    <img src="/resources/images/chevron-left.png">
  </a> -->
  <span id="titlePage"><?= $titlePage ?></span>

</div>

<?php $this->end(); ?>

<?php $this->section('content'); ?>
<div class="wrapFlex">
  <div id="content">
    <div class="eventTitle"><?= $data["eventTitle"] ?></div>
    <div class="message org">
      <span><?= $data["welcomeMessage"] ?></span>
    </div>
    <div class="message image">
      <div class="wrapImage">
        <img src="/resources/uploads/settings/<?= $data["welcomeImageFilename"] ?>" onerror="this.style.display = 'none'">
      </div>



    </div>
    <span class="nickname"><?= $data["name"] ?></span>
    <div class="group-btn">
      <div class="btn">
        <a href="/attendee/upload">
          <img src="/resources/images/white-cam.png" alt="">
        </a>
      </div>
      <div class="btn">
        <a href="/attendee/check">
          <img src="/resources/images/person-square.png" alt="">
        </a>

      </div>
      <div class="btn">
        <a href="/remote">
          <img src="/resources/images/play.png" alt="">
        </a>
      </div>
    </div>
  </div>
</div>
<?php $this->end(); ?>