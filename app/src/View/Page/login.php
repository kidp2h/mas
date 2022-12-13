<?php

use Core\Session;

$this->layout('auth'); ?>

<?php $this->section('content'); ?>

<form method="POST">

  <table>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><span class="titleForm">Memory Album System</span></td>
    </tr>

    <!-- <?php if (isset($message)) { ?>
      <tr class="groupMessage">
        <td></td>
        <td class="messageResponse"><?= $message ?></td>

      </tr>
    <?php } ?> -->

    <tr class="groupInput">
      <td class="fieldInput"><label for="email">E-mail</label></td>
      <td class="colInput">
        <?php if (isset($form['email'])) { ?>

          <span class="message"><?= $form['email'][0] ?></span>
        <?php } ?>
        <?php if (isset($message)) { ?>

          <span class="messageResponse"><?= $message ?></span>
        <?php } ?>
        <?php
        $messageResponse = Session::getFlash('messageResponse');
        if ($messageResponse) {
        ?>

          <span class="messageResponse"><?= $messageResponse ?></span>
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
  </table>


</form>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
</script>
<?php $this->endScript(); ?>;