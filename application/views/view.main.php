<?php 
/**
 * The view for the Main page, the index or home.
 * @see main
 *
 * @package mna
 * @subpackage views
 */
?>
<?php include('view.header.php'); ?>
  <div class="container">
  	<?php include('view.nav.php'); ?>
    <div class="page-header">
  		<h1><?php echo $lang->dict->headers->welcome; ?></h1>
  	</div>
  	<div class="jumbotron">
      <?php echo $lang->cont('main.jumbotron'); ?>
    </div>
  </div>
<?php include('view.footer.php'); ?>
