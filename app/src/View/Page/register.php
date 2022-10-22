<?php $this->layout('auth'); ?>

<?php $this->section('content'); ?>
<h5>Register</h5>

<?php if (isset($form)) {
  echo '<pre>';
  var_dump($form);
  echo '</pre>';
} ?>
<form method="POST">
  <input type="text" name="name" placeholder="name" value="kidp2h2604" >
  <input type="text" name="email" placeholder="email" value="thjnhsoajca@gmail.com" >
  <input type="password" name="password" value="kidp2h2604" >
  <input type="password" name="confirmPassword" value="kidp2h2604" >
  <button type="submit">Register</button>
</form>
<?php $this->end(); ?>
