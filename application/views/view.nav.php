<?php 
/**
 * The view for the main navigation used in this webapplication
 *
 * @package mna
 * @subpackage views
 */
?>
<img src="<?php echo BASE_URL; ?>static/images/MNA.nasf.jpg" class="main-img">
<nav class="navbar navbar-inverse navbar-main">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand navbar-highlight" href="<?php echo BASE_URL; ?>">Midt-Norge Airsoft</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
        <?php include('generator.menu.php'); ?>
      </ul>
      <hr class="visible-xs">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="<?php echo $url('admin'); ?>" title="Login">
            <span class="glyphicon glyphicon-lock"></span>
          </a>
        </li>
        <li>&nbsp;&nbsp;&nbsp;</li>
        <li>
          <a href="https://www.facebook.com/groups/198079110278140/" title="Vår Facebookgruppe" target="_blank">
            <span class="fa fa-facebook-official"></span>
          </a>
        </li>
        <li>
          <a data-email="ZNhz_AugONWdzi_5gzZdkNYWd">
            <span class="fa fa-envelope"></span>
          </a>
        </li>
        <li><span style="width:2em;display:block-inline;"></span></li>
        <li>
          <a href="<?php echo $url('settings','setlang',['lang'=>'no']); ?>" title="Norsk">
            <span class="flag-icon flag-icon-no"></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $url('settings','setlang',['lang'=>'en']); ?>" title="English">
            <span class="flag-icon flag-icon-gb"></span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>