<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/attendee.css">
<link rel="stylesheet" href="/resources/css/toppage.css">
<?php $this->endStyle(); ?>

<?php $this->section('header'); ?>
<div class="wrapFlex">
  <div class="header">
    <h3>Memory Album System</h3>
    <h3>2000 Top page</h3>
  </div>
</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<div class="wrapFlex">
  <div id="content">
    <div class="message org">
      <span>主催者からメッセージ</span>
      <span>Organizer message</span>
    </div>
    <div class="message image">
      <span>メッセージ画像</span>
      <span>Message image</span>

    </div>
    <div class="group-btn">
      <div class="btn">
        <a href="">写真投稿 Photo upload</a>
      </div>
      <div class="btn">
        <a href="">写真確認 Photo check</a>
      </div>
      <div class="btn">
        <a href="">展示パネルリモコン Panle Remo-con</a>
      </div>
    </div>
  </div>
</div>
<?php $this->end(); ?>