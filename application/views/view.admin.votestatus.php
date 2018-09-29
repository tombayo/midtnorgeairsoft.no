<?php
/**
 * Admin-view for getting a status on the votingsystem.
 * @see admin::votestatus()
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
        <h1><?php echo $lang->dict->adminpagevote->clubvote; ?></h1>
      </section>
    	<section class="content">
        <?php
          if ($errors ?? false) {
            echo "
            <div class='callout callout-danger'>
              <h4>Error:</h4>
              <p>".$errors->getMessage()."</p>
            </div>";
          }
        ?>
        <p>
          <?php
            echo $lang->dict->adminpagevote->numvoters.': '.$numvoters.'<br>';
            echo $lang->dict->adminpagevote->numvotes.': '.$numvotes.'<br>';
          ?>
        </p>
      <p><?php print_r($votespercandidate); ?></p>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php include('view.admin.footer.php'); ?>
  </div><!-- /.wrapper -->
<?php include('view.scripts.php'); ?>
