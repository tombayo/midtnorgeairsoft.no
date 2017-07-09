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
    <?php 
      foreach ($album as $i => $img) {
       ?>
       <li data-target="#carousel-saetnan" data-slide-to="<?php echo $i; ?>"<?php if($i == 0) echo ' class="active"';?>></li>
       <?php 
      }
    ?>
  </ol>
  
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php 
      foreach ($album as $i => $img) {
        ?>
        <div class="item<?php if($i == 0) echo ' active'; ?>">
          <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['name']; ?>">
          <div class="carousel-caption">
            <p></p>
          </div>
        </div>
        <?php
      }
    ?>
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