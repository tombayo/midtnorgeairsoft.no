<?php 
/**
 * The view for the carousel used in view.fields.saetnan
 * @see view.fields.saetnan.php
 *
 * @package mna
 * @subpackage views
 */
?>
<div id="carousel-saetnan" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-saetnan" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-saetnan" data-slide-to="1"></li>
    <li data-target="#carousel-saetnan" data-slide-to="2"></li>
  </ol>
  
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="http://lorempixel.com/854/480/sports/1" alt="saetnan1">
      <div class="carousel-caption">
        <p></p>
      </div>
    </div>
    <div class="item">
      <img src="http://lorempixel.com/854/480/sports/2" alt="saetnan2">
      <div class="carousel-caption">
        <p></p>
      </div>
    </div>
    <div class="item">
      <img src="<?php echo BASE_URL;?>static/images/giefpics.jpg" alt="saetnan3">
    </div>
  </div>
  
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-saetnan" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-saetnan" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>