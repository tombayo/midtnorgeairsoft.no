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
        <iframe class="embed-responsive-item" src="https://www.norgeskart.no/dynamisk.html#14/300637/7035430/l/drawing/c23be830ae0c30e1041c6b30f9e3eacc72aa3b89/32633/+embed.box" title="Sætnan Airsoftfield"></iframe>
      </div>
    </div>
  </div>
<?php include('view.footer.php'); ?>
      