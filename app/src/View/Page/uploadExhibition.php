<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/uploadExhibition.css">
<?php $this->endStyle(); ?>

<?php $this->section('header'); ?>
<div id="header">
  <div class="btn-back">
    <a href="">戻る</a>
  </div>
  <div class="headerText">
    <h3>Memory Album System</h3>
    <h3>1500 Exhihibiton</h3>
  </div>


</div>

<?php $this->end(); ?>

<?php $this->section('content'); ?>

<div class="wrapFlex">
  <canvas id="canvas"></canvas>
  <div id="content">
    <video autoplay id="camera"></video>
    <div id="action">
      <div class="group_btn-action">
        <div class="btn-action take">撮影</div>
        <span class="note">３秒後に撮影します</span>
      </div>
      <div class="btn-action edit">やり直し</div>
      <div class="btn-action upload">投稿</div>
    </div>
  </div>

</div>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
    (async function() {
      const camera = $("#camera");
      const constraints = {
        video: {
          width: {
            min: 350,
            ideal: 350,
            max: 350,
          },
          height: {
            min: 350,
            ideal: 350,
            max: 350,
          },
        },
      }

      const videoStream = await navigator.mediaDevices.getUserMedia(constraints)
      camera.srcObject = videoStream
      $(".take").addEventListener("click", function() {
        $('.take').classList.add('disabled')
        const canvas = document.querySelector('#canvas')
        canvas.width = camera.videoWidth
        canvas.height = camera.videoHeight
        setTimeout(async () => {
          camera.pause();
          canvas.getContext('2d').drawImage(camera, 0, 0)


          let anchor = document.createElement("a");
          anchor.href = canvas.toDataURL("image/png");

          const uploadFn = async function() {
            $('.upload').classList.add('disabled')
            const form = new FormData();
            form.append("image", anchor.href);
            const result = await fetch("/uploadExhibition", {
              method: "POST",
              body: form,
            })

            if (result.status === 200) {
              const response = await result.json();
              console.log(response);
            } else {
              console.log("error");
            }
          }
          // upload
          $(".upload").addEventListener('click', uploadFn)


        }, 2500);
      })
      $(".edit").addEventListener("click", function() {
        camera.play();
        $('.take').classList.remove('disabled')
        $('.upload').classList.remove('disabled')
      })
    })();
  }
</script>
<?php $this->endScript(); ?>;