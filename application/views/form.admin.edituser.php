<?php 
/**
 * The form for changing a user's personal information 
 * @see view.admin.edituser.php, admin::edituser()
 *
 * @package mna
 * @subpackage views
 */
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title"><span class="glyphicon glyphicon-user"></span> Endre Brukerinfo</h4>
  </div>
  <form class="form-horizontal" id="form-edituser" method="post">
    <div class="panel-body">
				<?php
				if($success ?? false) {
				  echo '<div class="alert alert-success" role="alert">';
				  echo '<p>'.$success.'</p>';
				  echo '</div>';
				}
        if($errors ?? false){
          echo '<div class="alert alert-danger" role="alert">';
          foreach($errors as $value) {
            echo "<p>".$value."</p>";
          }
          echo '</div>';
        }
        $formParent = 'form-edituser';
        include('form.common.form-groups.php');
      ?>
    </div><!-- /.panel-body -->
    <div class="modal-footer">
      <a role="button" class="btn btn-default" href="<?php echo $url('admin'); ?>">« Tilbake</a>
      <button type="submit" class="btn btn-primary" name="submit">Lagre <span class="glyphicon glyphicon-ok"></span></button>
    </div>
  </form>
</div><!-- /.panel -->