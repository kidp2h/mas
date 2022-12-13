<?php $this->layout('auth'); ?>

<?php $this->section('content'); ?>

<form method="POST">

  <table>
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
  </table>


</form>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
</script>
<?php $this->endScript(); ?>;