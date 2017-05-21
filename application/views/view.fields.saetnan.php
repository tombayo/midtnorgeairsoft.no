<?php 
/**
 * The view for the page Fields, Saetnan
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
      <h1 id="saetnan">Sætnan</h1>
      <?php echo $lang->cont('saetnan.description'); ?>
      <div class="row">
        <div class="col-md-9">
        <h3><?php echo $lang->dict->headers->images; ?></h3>
          <?php include('view.fields.saetnan.carusel.php'); ?>
        </div>
        <div class="col-md-3"></div>
      </div>
      <h3><?php echo $lang->dict->headers->map; ?></h3>
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://www.norgeskart.no/#!?project=norgeskart&layers=1002&zoom=16&lat=7035467.96&lon=300546.35&type=1&marker_lat=7035428.2958984375&marker_lon=300586.67773437506" title="Sætnan Airsoftfield"></iframe>
      </div>
    </div>
  </div>
<?php include('view.footer.php'); ?>
      