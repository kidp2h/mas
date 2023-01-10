<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/attendee.css">
<link rel="stylesheet" href="/resources/css/toppage.css">
<link rel="stylesheet" href="/resources/css/remote.css">
<?php $this->endStyle(); ?>

<?php $this->section('header'); ?>
<div class="wrapFlex wrapHeader">
  <div class="header">
    <h3>Memory Album System</h3>
    <h3>2300 Panel</h3>
  </div>
</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<div id="content">
  <div class="text-desc">
    <p>
      この画面を開くと同時に、展示パネルはスライドショーモードに変わります。
      下記の操作は、展示パネルを見ながら行ってください。
    </p>
  </div>
  <div class="group-btn-remote">
    <div class="btn-remote" data-action="left-start">
      <img src="/resources/images/left-start.png" alt="">
    </div>
    <div class="btn-remote" data-action="left">
      <img src="/resources/images/left.png" alt="">
    </div>
    <div class="btn-remote" data-action="right">
      <img src="/resources/images/right.png" alt="">
    </div>
    <div class="btn-remote" data-action="right-end">
      <img src="/resources/images/right-end.png" alt="">
    </div>
  </div>
</div>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  $$(".btn-remote").forEach(btn => {
    btn.addEventListener("click", async function() {
      let action = this.dataset.action;
      console.log(action);
      let data = new FormData();
      data.append('action', action)
      console.log(data.get('action'));
      const result = await fetch("/remote", {
        method: "POST",
        body: data
      })
      const response = await result.json()
    })
  })
</script>
<?php $this->endScript(); ?>;