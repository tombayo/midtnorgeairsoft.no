<?php 
/**
 * The login-screen for Admin
 * @see admin::viewLogin()
 *
 * @package mna
 * @subpackage views
 */
?>
<?php include('view.header.php'); ?>
  <div class="container">
  	<form class="form-signin" method="post" action="<?php echo $url('admin','login'); ?>">
			<?php
			  if($errormsg ?? false) {
			    echo '<div class="alert alert-danger">';
			    echo '<p>'.$errormsg.'</p>';
			    echo '</div>';
			  }
			?>
      <h2 class="form-signin-heading">Vennligst logg inn</h2>
      <label for="loginEmail" class="sr-only">Epost-adresse</label>
      <input type="email" id="loginEmail" name="email" class="form-control" placeholder="Epost-adresse" 
      <?php 
        if ($email ?? false) {
          echo 'value="'.$email.'"';
        } else {
          echo 'autofocus';
        }
      ?>
       required>
      <label for="loginPassword" class="sr-only">Passord</label>
      <input type="password" id="loginPassword" name="password" class="form-control" placeholder="Passord" autocomplete="off"
      <?php 
        if ($email ?? false) {
          echo 'autofocus';
        }
      ?>
       required>
      <div class="checkbox disabled hidden">
        <label>
          <input type="checkbox" value="remember-me" checked disabled> Husk meg
        </label>
      </div>
      <div class="checkbox">
        <label>
          <a href="<?php echo $url('admin','resetpw'); ?>">Glemt passord</a>
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Logg inn</button>
    </form>
  </div><!-- /.container -->
<?php include('view.scripts.php'); ?>
