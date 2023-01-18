<?php

use Core\Session;

$this->layout('auth'); ?>
<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/login.css">
<?php $this->endStyle(); ?>

<?php $this->section('content'); ?>

<form method="POST">
  <div id="wrapForm">
    <div id="titleForm">
      <img src="/resources/images/titleForm.png" alt="" srcset="">
    </div>
    <div class="groupInput">
      <?php if (isset($form['email'])) { ?>

        <span class="message"><?= $form['email'][0] ?></span>
      <?php } ?>
      <?php
      $messageResponse = Session::getFlash('messageResponse');
      if ($messageResponse) {
      ?>

        <span class="message"><?= $messageResponse ?></span>
      <?php } ?>
      <div class="wrapInputIcon">
        <img src="/resources/images/iconEmail.png" alt="" srcset="" class="iconWithInput">
        <input type="email" placeholder="メールアドレス" class="inputText" name="email">
      </div>

    </div>
    <div class="groupInput">
      <?php if (isset($form['password'])) { ?>

        <span class="message"><?= $form['password'][0] ?></span>
      <?php } ?>
      <div class="wrapInputIcon">
        <img src="/resources/images/iconPassword.png" alt="" srcset="" class="iconWithInput">
        <input type="password" placeholder="パスワード" class="inputText" name="password">
      </div>
    </div>
    <div id="mainAction">
      <button type="submit" id="btn-login" class="btn btn-primary">ログイン</button>
    </div>
    <div id="subAction">
      <a href="/user/register" class="btn btn-sub">ユーザー登録</a>
      <a href="/user/forgot-password" class="btn btn-sub">パスワード再発行</a>
    </div>
  </div>

  <!-- <table>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><span class="titleForm">Memory Album System</span></td>
    </tr>


    <tr class="groupInput">
      <td class="fieldInput"><label for="email">E-mail</label></td>
      <td class="colInput">
        <?php if (isset($form['email'])) { ?>

          <span class="message"><?= $form['email'][0] ?></span>
        <?php } ?>
        <?php if (isset($message)) { ?>

          <span class="messageResponse"><?= $message ?></span>
        <?php } ?>
        <input type="email" name="email" placeholder="E-mail" />
      </td>
    </tr>
    <tr class="groupInput">
      <td class="fieldInput"><label for="password">Password</label></td>
      <td class="colInput">
        <?php if (isset($form['password'])) { ?>

          <span class="message"><?= $form['password'][0] ?></span>
        <?php } ?>

        <input type="password" name="password" placeholder="Password" min="8" />
      </td>
    </tr>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><button type="submit">Login</button></td>
    </tr>
    <tr class="groupInput linkRedirect">
      <td class="fieldInput empty"></td>
      <td><a href="/user/register">Sign Up</a></td>
    </tr>
  </table> -->


</form>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
</script>
<?php $this->endScript(); ?>;