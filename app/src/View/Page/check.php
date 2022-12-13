<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/attendee.css">
<link rel="stylesheet" href="/resources/css/check.css">
<?php $this->endStyle(); ?>

<?php $this->section('header'); ?>
<div class="wrapFlex">

  <div class="header">
    <a href="/attendee/toppage" class="btn-back">
      <img src="/resources/images/chevron-left.png">
    </a>
    <div class="headerText">
      <h3>Memory Album System</h3>
      <h3>2000 Top page</h3>
    </div>

  </div>
</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<div class="wrapFlex">
  <div id="content">
    <div class="slideshow">
      <img class="slide" src="/resources/images/cat1.jpg" alt="" srcset="">
      <img class="slide" src="/resources/images/cat2.jpg" alt="" srcset="">
      <img class="slide" src="/resources/images/cat4.jpg" alt="" srcset="">
      <img class="slide" src="/resources/images/cat3.jpg" alt="" srcset="">
      <button class="action-slide previous" onclick="plusDivs(-1)">
        <img src="/resources/images/previous.png" alt="" srcset="">
      </button>
      <button class="action-slide next" onclick="plusDivs(1)">
        <img src="/resources/images/next.png" alt="" srcset=""></button>
    </div>

    <div class="information">
      <span class="author">
        投稿メッセージ
      </span>
      <span class="status">Uploaded message</span>
      <div class="time">
        <span>2022/10/10 10:03</span>
        <span>Nickname</span>
      </div>



    </div>



  </div>
</div>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  console.log("first")
  var slideIndex = 1;
  showDivs(slideIndex);

  function plusDivs(n) {
    showDivs(slideIndex += n);
  }

  function showDivs(n) {
    console.log("seconds")
    var i;
    var x = document.getElementsByClassName("slide");
    if (n > x.length) {
      slideIndex = 1
    }
    if (n < 1) {
      slideIndex = x.length
    }
    for (i = 0; i < x.length; i++) {
      console.log(x[i])
      x[i].style.display = "none";
    }
    x[slideIndex - 1].style.display = "flex";
  }
</script>
<?php $this->endScript(); ?>;