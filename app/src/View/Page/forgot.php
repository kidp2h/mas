<?php $this->layout('auth'); ?>
<?php $this->style(); ?>
<style>
  .bg {
    background: var(--bg-gradient);
  }

  .inputText {
    margin-bottom: 10.9rem;
  }

  #mainAction {
    margin-bottom: 9rem;
  }

  #subAction {
    margin-bottom: 8.4rem;
  }
</style>

<?php $this->endStyle(); ?>
<?php $this->section('content'); ?>

<form method="POST">




  <div id="wrapForm">
    <div id="titleForm">
      <img src="/resources/images/titleForm.png" alt="" srcset="">
      <span id="subTitle">パスワード再設定</span>
    </div>
    <div class="groupInput">
      <div class="wrapInputIcon">
        <img src="/resources/images/iconEmail.png" alt="" srcset="" class="iconWithInput">
        <input type="text" placeholder="メールアドレス" class="inputText" name="email">
      </div>
    </div>
    <div id="mainAction">
      <button type="submit" id="btn-login" class="btn btn-primary">送　信</button>
    </div>
    <div id="subAction">
      <a href="/user/register" class="btn btn-sub">ユーザー登録</a>
    </div>
  </div>



</form>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
</script>
<?php $this->endScript(); ?>;