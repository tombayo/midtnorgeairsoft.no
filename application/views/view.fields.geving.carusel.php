<?php 
/**
 * The view for the carousel used in view.fields.geving
 * @see view.fields.geving.php
 *
 * @package mna
 * @subpackage views
 */
?>
<div id="carousel-geving" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-geving" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-geving" data-slide-to="1"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="<?php echo BASE_URL; ?>static/images/geving1.jpg" alt="geving1">
      <div class="carousel-caption">
        <p></p>
      </div>
    </div>
    <div class="item">
      <img src="<?php echo BASE_URL; ?>static/images/geving2.jpg" alt="geving2">
      <div class="carousel-caption">
        <p></p>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-geving" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-geving" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>