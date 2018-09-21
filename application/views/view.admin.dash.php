<?php 
/**
 * Admin-view for the dashboard
 * @see admin::viewDashboard()
 *
 * @package mna
 * @subpackage views
 */
?>
<?php include('view.header.php'); ?>
  <div class="wrapper">
    <?php include('view.admin.nav.php'); ?>	
    <div class="content-wrapper">
      <section class="content-header">
        <h1>Midt-Norge Airsoft Adminsystem</h1>
      </section>
    	<section class="content">
        <p>Velkommen til den Interne Administrasjonssiden!</p>
        <p>Benytt menyen til venstre for å navigere dit du ønsker.</p>
        <hr>
        <p>Welcome to the Internal administration-page!</p>
        <p>Please use the menu on the left to navigate.</p>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php include('view.admin.footer.php'); ?>
  </div><!-- /.wrapper -->
<?php include('view.scripts.php'); ?>
