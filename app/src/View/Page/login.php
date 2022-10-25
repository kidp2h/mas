<?php $this->layout('auth'); ?>

<?php $this->section('content'); ?>
<h5>Login</h5>
<form method="POST">
  <input type="email" name="email" >
  <input type="password" name="password" min="8" >
  <button type="submit">Login</button>
</form>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
</script>


<?php $this->endScript(); ?>;
