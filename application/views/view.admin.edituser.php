<?php 
/**
 * Admin-view for editing a user's personal information
 * @see admin::edituser()
 *
 * @package mna
 * @subpackage views
 */
?>
<?php $user = $formdata; ?>
<?php include('view.header.php'); ?>
  <div class="container">
  	<?php include('form.admin.edituser.php'); ?>
  </div><!-- /.container -->
<?php include('view.scripts.php'); ?>