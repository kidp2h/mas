<?php $this->layout('auth'); ?>
<?php $this->style(); ?>
<style>
  .bg {
    background: var(--bg-gradient);
  }
</style>

<?php $this->endStyle(); ?>
<?php $this->section('content'); ?>

<form method="POST">

  <!-- <table>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><span class="titleForm">Memory Album System</span></td>
    </tr>

    <tr class="groupInput">
      <td class="fieldInput"><label for="name">Name</label></td>
      <td class="colInput">

        <?php if (isset($form['name'])) { ?>
          <span class="message"><?= $form['name'][0] ?></span>
        <?php } ?>
        <input type="text" name="name" placeholder="name" />
      </td>
    </tr>
    <tr class="groupInput">
      <td class="fieldInput"><label for="email">E-mail</label></td>
      <td class="colInput">

        <?php if (isset($form['email'])) { ?>
          <span class="message"><?= $form['email'][0] ?></span>
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
        <input type="password" name="password" placeholder="Password" />
      </td>
    </tr>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><button type="submit">Sign Up</button></td>
    </tr>
    <tr class="groupInput linkRedirect">
      <td class="fieldInput empty"></td>
      <td><a href="/user/login">Login</a></td>
    </tr>
  </table> -->
  <div id="wrapForm">
    <div id="titleForm">
      <img src="/resources/images/titleForm.png" alt="" srcset="">
      <span id="subTitle">ユーザー登録</span>
    </div>
    <div class="groupInput">

      <?php if (isset($form['name'])) { ?>
        <span class="message"><?= $form['name'][0] ?></span>
      <?php } ?>
      <div class="wrapInputIcon">
        <img src="/resources/images/iconUsername.png" alt="" srcset="" class="iconWithInput">
        <input type="text" placeholder="お名前" class="inputText" name="name">
      </div>
    </div>
    <div class="groupInput">

      <?php if (isset($form['email'])) { ?>
        <span class="message"><?= $form['email'][0] ?></span>
      <?php } ?>
      <div class="wrapInputIcon">
        <img src="/resources/images/iconEmail.png" alt="" srcset="" class="iconWithInput">
        <input type="text" placeholder="メールアドレス" class="inputText" name="email">
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
      <button type="submit" id="btn-login" class="btn btn-primary">登　録</button>
    </div>
    <div id="subAction">
      <a href="/user/login" class="btn btn-sub">ログイン</a>
    </div>
  </div>


</form>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
</script>
<?php $this->endScript(); ?>;