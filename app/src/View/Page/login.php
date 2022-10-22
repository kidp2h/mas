<?php $this->layout('auth'); ?>

<?php $this->section('content'); ?>
<h5>Login</h5>
<form method="POST">
  <input type="text" name="username" >
  <input type="password" name="password" >
  <button type="submit">Login</button>
</form>
<?php $this->end(); ?>
