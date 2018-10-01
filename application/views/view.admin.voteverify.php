<?php
/**
 * Admin-view for verifying a previously cast vote in the votingsystem.
 * @see admin::voteverify()
 *
 * @package mna
 * @subpackage views
 */
?>
<?php include('view.header.php'); ?>
  <div class="wrapper">
    <?php include('view.admin.nav.php'); ?>	
    <div class="content-wrapper">
      <section class="content-header">
        <h1><?php echo $lang->dict->adminvoteverify->verifyvote; ?></h1>
      </section>
    	<section class="content">
        <?php
          if ($error ?? false) {
            echo "
            <div class='callout callout-danger'>
              <h4>Error:</h4>
              <p>".$error."</p>
            </div>";
          }
          if ($info ?? false) {
            echo "
            <div class='callout callout-info'>
              <h4>Info:</h4>
              <p>".$info."</p>
              <p>".ucwords($candidate[0]['name'])."</p>
            </div>";
          }
        ?>
        <form method="POST">
          <div class="form-group">
            <label for="inputKey"><?php echo $lang->dict->adminvoteverify->textfield; ?></label>
            <input type="text" class="form-control"
              minlength="64" maxlength="64"
              id="inputKey" name="key"
              placeholder="<?php echo $lang->dict->adminvoteverify->textfield; ?>"
              required>
          </div>
          <input type="submit"
            class="btn btn-success btn-flat" 
            name="submit" 
            value="<?php echo $lang->dict->adminvoteverify->verify; ?>">
        </form>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php include('view.admin.footer.php'); ?>
  </div><!-- /.wrapper -->
<?php include('view.scripts.php'); ?>
