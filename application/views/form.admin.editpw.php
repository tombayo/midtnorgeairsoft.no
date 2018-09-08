<?php 
/**
 * The form for changing a user's password 
 * @see view.admin.editpw.php, admin::editpw()
 *
 * @package mna
 * @subpackage views
 */
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Endre Passord</h4>
  </div>
  <form class="form-horizontal" id="form-editpw" method="post">
    <div class="panel-body">
      <?php
        if($success ?? false) {
          echo '<div class="alert alert-success" role="alert">';
          echo '<p>'.$success.'</p>';
          echo '</div>';
        }
        if($errors ?? false) {
          echo '<div class="alert alert-danger" role="alert">';
          foreach($errors as $value) {
            echo "<p>".$value."</p>";
          }
          echo '</div>';
        }
        $formParent = 'form-editpw';
      ?>
      <div class="form-group">
        <label for="<?php echo $formParent; ?>-oldpw" class="col-sm-3 control-label hidden-xs">Nåværende Passord</label>
        <div class="col-sm-9">
          <input type="password" maxlength="99" class="form-control" id="<?php echo $formParent; ?>-oldpw"
          name="oldpw" placeholder="Nåværende Passord" required autofocus>
        </div>
      </div>
      <div class="form-group"></div>
      <div class="form-group">
        <label for="<?php echo $formParent; ?>-newpw" class="col-sm-3 control-label hidden-xs">Nytt Passord</label>
        <div class="col-sm-9">
          <input type="password" maxlength="99" class="form-control" id="<?php echo $formParent; ?>-newpw"
          name="newpw" placeholder="Nytt Passord" required>
        </div>
      </div>
      <div class="form-group">
        <label for="<?php echo $formParent; ?>-newpw2" class="col-sm-3 control-label hidden-xs">Gjenta Nytt Passord</label>
        <div class="col-sm-9">
          <input type="password" maxlength="99" class="form-control" id="<?php echo $formParent; ?>-newpw2"
          name="newpw2" placeholder="Gjenta Nytt Passord" required>
        </div>
      </div>
    </div><!-- /.panel-body -->
    <div class="modal-footer">
      <a role="button" class="btn btn-default" href="<?php echo $url('admin'); ?>">« Tilbake</a>
      <button type="submit" class="btn btn-primary" name="submit">Lagre <span class="glyphicon glyphicon-ok"></span></button>
    </div>
  </form>
</div><!-- /.panel -->