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
        <iframe class="embed-responsive-item" src="https://www.norgeskart.no/#!?project=norgeskart&layers=1002&zoom=15&lat=7041635.01&lon=294033.53&type=1&marker_lat=7041619.8046875&marker_lon=293919.1533203125" title="Gevingåsen Airsoftfield"></iframe>
      </div>
  	</div>
  </div>
<?php include('view.footer.php'); ?>
