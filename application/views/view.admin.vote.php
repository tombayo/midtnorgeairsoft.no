<?php
/**
 * Admin-view for voting on candidates
 * @see admin::vote()
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
          if ($voterkey ?? false) {
            echo "
            <div class='callout callout-success'>
              ".$lang->cont('admin.vote.success')."
              <p><b>".$voterkey."</b></p>
            </div>";
          }
          if ($candidates ?? false) {
        ?>
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $lang->dict->adminpagevote->voteleader; ?></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <ul class="users-list">
                <?php
                  foreach($candidates as $candidate) {
                    echo '<li data-vote="'.$candidate['id'].'">';
                    echo '<img src="'.BASE_URL.'static/images/no_image.png" alt="User Image" width="128">';
                    echo '<span class="users-list-name">';
                    echo ucwords($candidate['firstname']).' ';
                    echo ucwords($candidate['lastname']).'</span>';
                    echo '</li>';
                  }
                ?>
              </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
            <div class="box-footer text-center">
              <form method="POST">
                <input id="voteinput" type="hidden" name="vote" value="">
                <input type="submit"
                       class="btn btn-success btn-flat" 
                       name="submit" 
                       value="<?php echo $lang->dict->adminpagevote->givevote; ?>">
              </form>
            </div>
          </div><!-- /.box -->
        </div><!-- /.col- -->  
        <?php
          } // if $candidates
        ?>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php include('view.admin.footer.php'); ?>
  </div><!-- /.wrapper -->
<?php include('view.scripts.php'); ?>
