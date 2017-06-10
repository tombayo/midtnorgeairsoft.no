<?php
/**
 * Admin-view for listing the current members
 * @see admin::members()
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
        <h1>Medlemmer</h1>
      </section>
    	<section class="content">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Medlemmer i Midt-Norge Airsoft</h3>
          </div><!-- /.box-header -->
          <div class="box-body no-padding">
            <table class="table">
              <tbody>
                <tr>
                  <th>Navn</th>
                  <th>Email</th>
                  <th>Telefon</th>
                </tr>
                <?php 
                  if ($dbdata ?? false) {
                    foreach ($dbdata as $row) {
                      echo '<tr>';
                      echo '<td>'.ucfirst($row['firstname']).' '.ucfirst($row['lastname']).'</td>';
                      echo '<td>'.$row['email'].'</td>';
                      echo '<td>'.$row['phonenumber'].'</td>';
                      echo '</tr>';
                    }
                  } else {
                    echo '<tr><td colspan="3">Ingen her :(</td></tr>';
                  }
                ?>
              </tbody>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php include('view.admin.footer.php'); ?>
  </div><!-- /.wrapper -->
<?php include('view.scripts.php'); ?>
