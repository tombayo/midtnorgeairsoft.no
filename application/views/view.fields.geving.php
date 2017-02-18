<?php 
/**
 * The view for the page Fields, Geving
 * @see fields
 *
 * @package mna
 * @subpackage views
 */
?>
<?php include('view.header.php'); ?>
  <div class="container">
  	<?php include('view.nav.php'); ?>
    <div class="container">
      <h1 id="geving">Gevingåsen</h1>
      <?php echo $lang->cont('geving.description'); ?>
      <div class="row">
        <div class="col-md-9">
        <h3><?php echo $lang->dict->headers->images; ?></h3>
          <?php include('view.fields.geving.carusel.php'); ?>
        </div>
        <div class="col-md-3"></div>
      </div>
      <h3><?php echo $lang->dict->headers->map; ?></h3>
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="http://www.norgeskart.no/dynamisk.html#15/294160/7041684/l/drawing/0c40c11b78491c2066e0dab113d2a2957b4593b9/32633/+embed.box" title="Gevingåsen Airsoftfield"></iframe>
      </div>
  	</div>
  </div>
<?php include('view.footer.php'); ?>
