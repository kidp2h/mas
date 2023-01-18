<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/attendee.css">
<link rel="stylesheet" href="/resources/css/check.css">
<?php $this->endStyle(); ?>

<?php $this->section('header'); ?>
<div id="header">
  <a href="/attendee/toppage">
    <img src="/resources/images/chevron-left.png">
  </a>
  <div class="wrapTitlePage">
    <img src="/resources/images/person-square.png" alt="" srcset="">
    <span id="titlePage"><?= $titlePage ?></span>
  </div>


</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<div class="wrapFlex">
  <div id="content">
    <div class="slideshow">
      <?php foreach ($data as $value) { ?>
        <div class="slide" draggable="true">
          <div class="groupAction">

            <div class="btn-download-image" data-name="<?= $value->attendeeFileName ?>">
              <img src="/resources/images/black-download.png" alt="" srcset="">
            </div>
            <?php
            if ($attendeeId == $value->userId) {
            ?>
              <div class="btn-delete-image">
                <img src="/resources/images/del.png" alt="" srcset="">
              </div>
            <?php } ?>
          </div>

          <img class="imageSlide" src="/resources/uploads/<?= $value->attendeeFileName ?>" alt="<?= $value->attendeeFileName ?>" srcset="" draggable="false">

        </div>
        <div class="information">
          <div class="author item">
            <span>投稿メッセージ</span>
            <!-- <div class="btn-like" data-id="">いいね</div> -->
          </div>
          <div class="comment item">
            <span><?= $value->attendeeComment ?></span>
            <div class="count-like btn-like" data-id="<?= $value->id ?>">👍 <?= $value->likeCount ?></div>
          </div>
          <div class="time item">
            <span><?= $value->created_at ?></span>

            <span class="nickname"><?= $value->attendeeName  ?></span>
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
  let slideIndex = 1;
  showDivs(slideIndex);

  function plusDivs(n) {
    showDivs(slideIndex += n);
  }

  function showDivs(n) {
    var i;
    let x = $$(".slide");
    let info = $$(".information")
    if (x.length) {
      if (n > x.length) {
        slideIndex = 1
      }
      if (n < 1) {
        slideIndex = x.length
      }
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
        info[i].style.display = 'none';
      }
      x[slideIndex - 1].style.display = "flex";
      info[slideIndex - 1].style.display = 'flex';
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
  $$(".btn-download-image").forEach(btn => {
    btn.addEventListener('click', function() {
      downloadURI(`/resources/uploads/${this.dataset.name}`, this.dataset.name)
    })
  })


  let slides = $$('.slide');
  slides.forEach(slide => {
    slide.addEventListener('touchstart', handleTouchStart, false);
    slide.addEventListener('touchmove', handleTouchMove, false);
  })

  var xDown = null;
  var yDown = null;

  function handleTouchStart(evt) {
    xDown = evt.touches[0].clientX;
    yDown = evt.touches[0].clientY;
  };

  function handleTouchMove(evt) {
    if (!xDown || !yDown) {
      return;
    }

    var xUp = evt.touches[0].clientX;
    var yUp = evt.touches[0].clientY;

    var xDiff = xDown - xUp;
    var yDiff = yDown - yUp;

    if (Math.abs(xDiff) > Math.abs(yDiff)) {
      /*most significant*/
      if (xDiff > 0) {
        /* left swipe */
        // slideRight();
        plusDivs(-1)
      } else {
        /* right swipe */
        // slideLeft();
        plusDivs(1)
      }
    } else {
      if (yDiff > 0) {
        /* up swipe */
      } else {
        /* down swipe */
      }
    }
    /* reset values */
    xDown = null;
    yDown = null;
  };
  $$(".btn-like").forEach(btn => {
    btn.addEventListener('click', async function() {
      let id = this.dataset.id;
      let data = new FormData();
      data.append('id', id)
      const result = await fetch('/attendee/likeImage', {
        method: "POST",
        body: data
      })
      const response = await result.json();
      if (response.status) {
        this.parentElement.parentElement.querySelector(".count-like").innerHTML = `👍 ${response.likeCount}`
      }
    })
  })
</script>
<?php $this->endScript(); ?>;