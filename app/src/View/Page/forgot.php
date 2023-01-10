<?php $this->layout('auth'); ?>

<?php $this->section('content'); ?>
<form method="POST">

  <table>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><span class="titleForm">Memory Album System</span></td>
    </tr>

    <tr class="groupInput">
      <td class="fieldInput"><label for="email">E-mail</label></td>
      <td class="colInput">
        <?php if (isset($errorEmail)) { ?>
          <span class="message"><?= $errorEmail ?></span>
        <?php } ?>
        <input type="email" name="email" placeholder="E-mail" />
      </td>
    </tr>
    <tr class="groupInput">
      <td class="fieldInput empty"></td>
      <td><button type="submit">Send</button></td>
    </tr>
  </table>
</form>

<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
</script>
<?php $this->endScript(); ?>;