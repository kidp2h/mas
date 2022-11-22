<?php $this->layout('main'); ?>

<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/settings.css">
<?php $this->endStyle(); ?>
<?php $this->section('header'); ?>
<span id="titlePage">
  <span class="textPC"><?= $titlePage ?></span>
  <span class="textMobile">Settings</span>
</span>
<div class="groupAction">
  <div class="btn-action">
    <a href="/registerEvent">登録</a>
  </div>
  <div class="btn-action">
    <a href="/"> 戻る</a>

  </div>

</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<div id="formSettings">

  <form method="post">
    <div class="groupInput">
      <label class="titleGroup">登録日</label>
      <div class="textValue">
        <span>2022 年 10 月 22 日</span>
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup">ご利用状態</label>
      <div class="textValue">
        <span>継続して、ご利用いただけます</span>
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup textPC">お名前（主催者名）</label>
      <label class="titleGroup textMobile">お名前</label>
      <div class="inputValue">
        <input type="text" value="グエン　ティ　バオ　ヴィー">
      </div>
    </div>

    <div class="groupInput">
      <label class="titleGroup">メールアドレス</label>
      <div class="inputValue">
        <input type="email" value="vi@nguyen.vn">
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup">イベント名称</label>
      <div class="inputValue">
        <input type="text" value="〇〇さんの結婚式">
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup textPC">出席者へのメッセージ</label>
      <label class="titleGroup textMobile">メッセージ</label>
      <div class="inputValue">
        <textarea>今日は来てくれてありがとう！！
写真をたくさん投稿してくださいねー
      </textarea>
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup">メッセージ画像</label>
      <div class="inputFile">
        <input type="text" class="centerInput" value="写真を選択して下さい">
        <div class="selectedImage">
          <div class="wrapText">
            <div>選択画像</div>
            <div>Selected image</div>
          </div>

        </div>
      </div>
    </div>

    <div class="groupInput">
      <label class="titleGroup">スライドショーパターン</label>
      <div class="groupRadioWithPattern">
        <div class="radioPattern">
          <input type="radio" id="pattern2">
          <div class="pattern pattern1">
            <span>Pattern 1</span>
          </div>
        </div>
        <div class="radioPattern">
          <input type="radio" id="pattern2">
          <div class="pattern pattern2">
            <span>Pattern 2</span>
          </div>
        </div>

      </div>
    </div>

    <div class="groupInput groupInput1Line">
      <label class="titleGroup textPC">展示パネルQRコード表示</label>
      <label class="titleGroup textMobile"> QRコード表示</label>


      <div class="groupRadioWithText">
        <div class="radioText">
          <input type="radio" id="option1">
          <span>する</span>
        </div>
        <div class="radioText">
          <input type="radio" id="option2">
          <span class="textPC">しない（展示パネルにQRコードを表示しません）</span>
          <span class="textMobile">しない</span>
        </div>

  </form>
</div>





<?php $this->end(); ?>
