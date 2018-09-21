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
      <h2 class="form-signin-heading"><?php echo $lang->dict->adminusercontrols->pleaselogin; ?></h2>
      <label for="loginEmail" class="sr-only"><?php echo $lang->dict->adminusercontrols->emailaddress; ?></label>
      <input type="email"
             id="loginEmail"
             name="email" 
             class="form-control" 
             placeholder="<?php echo $lang->dict->adminusercontrols->emailaddress; ?>" 
      <?php 
        if ($email ?? false) {
          echo 'value="'.$email.'"';
        } else {
          echo 'autofocus';
        }
      ?>
       required>
      <label for="loginPassword" class="sr-only"><?php echo $lang->dict->adminusercontrols->password; ?></label>
      <input type="password" 
             id="loginPassword" 
             name="password" 
             class="form-control" 
             placeholder="<?php echo $lang->dict->adminusercontrols->password; ?>" 
             autocomplete="off"
      <?php 
        if ($email ?? false) {
          echo 'autofocus';
        }
      ?>
       required>
      <div class="checkbox disabled hidden">
        <label>
          <input type="checkbox" value="remember-me" checked disabled> <?php echo $lang->dict->adminusercontrols->rememberme; ?>
        </label>
      </div>
      <div class="checkbox">
        <label>
          <a href="<?php echo $url('admin','resetpw'); ?>">
            <?php echo $lang->dict->adminusercontrols->forgotpw; ?>
          </a>
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">
        <?php echo $lang->dict->adminusercontrols->login; ?>
      </button>
    </form>
  </div><!-- /.container -->
<?php include('view.scripts.php'); ?>
