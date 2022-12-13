<?php $this->layout('auth'); ?>

<?php $this->section('content'); ?>

<form method="POST">

  <table>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><span class="titleForm">Memory Album System</span></td>
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
      <td class="fieldInput"><label for="password">Confirm</label></td>
      <td class="colInput">
        <?php if (isset($form['confirm'])) { ?>
          <span class="message"><?= $form['confirm'][0] ?></span>
        <?php } ?>
        <input type="password" name="confirm" placeholder="Confirm password" min="8" />
      </td>
    </tr>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><button type="submit">reset password</button></td>
    </tr>
  </table>


</form>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
</script>
<?php $this->endScript(); ?>;