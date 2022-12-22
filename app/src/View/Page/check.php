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
      <h3>2200 Photo check</h3>
    </div>

  </div>
</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<div class="wrapFlex">
  <div id="content">
    <div class="slideshow">
      <?php foreach ($data as $value) { ?>
        <div class="slide">
          <div class="btn-delete-image">
            <img src="/resources/images/del.png" alt="" srcset="">
          </div>
          <img class="imageSlide" src="/resources/uploads/<?= $value->attendeeFileName ?>" alt="<?= $value->attendeeFileName ?>" srcset="">
          <div class="information">
            <span class="author">
              投稿メッセージ
            </span>
            <span class="status">Uploaded message</span>
            <div class="time">
              <span><?= $value->created_at ?></span>
              <span><?= $value->attendeeName  ?></span>
            </div>
          </div>
        </div>

      <?php } ?>

      <button class="action-slide previous" onclick="plusDivs(-1)">
        <img src="/resources/images/previous.png" alt="" srcset="">
      </button>
      <button class="action-slide next" onclick="plusDivs(1)">
        <img src="/resources/images/next.png" alt="" srcset="">
      </button>
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
    var i;
    var x = document.getElementsByClassName("slide");
    if (x.length) {
      if (n > x.length) {
        slideIndex = 1
      }
      if (n < 1) {
        slideIndex = x.length
      }
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      x[slideIndex - 1].style.display = "flex";
    }

  }

  $$(".btn-delete-image").forEach(btn => {
    btn.addEventListener('click', async function(e) {
      this.parentElement.remove();
      let attendeeFileName = this.parentElement?.querySelector('.imageSlide').getAttribute('alt')



      if (attendeeFileName) {
        plusDivs(2);
        let form = new FormData();
        form.append("attendeeFileName", attendeeFileName);
        const result = await fetch("/attendee/delete-image", {
          method: "POST",
          body: form,
        })
        const response = await result.json();
        if (response.status) {

        } else {

        }
      }
    })
  });
</script>
<?php $this->endScript(); ?>;