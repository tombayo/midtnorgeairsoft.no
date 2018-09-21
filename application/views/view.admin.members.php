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
        <h1><?php echo $lang->dict->adminpagemembers->members; ?></h1>
      </section>
    	<section class="content">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><?php echo $lang->dict->adminpagemembers->membersmna; ?></h3>
          </div><!-- /.box-header -->
          <div class="box-body no-padding">
            <table class="table">
              <tbody>
                <tr>
                  <th><?php echo ucfirst($lang->dict->general->name); ?></th>
                  <th><?php echo ucfirst($lang->dict->general->email); ?></th>
                  <th><?php echo ucfirst($lang->dict->general->role); ?></th>
                </tr>
                <?php 
                  if ($dbdata ?? false) {
                    foreach ($dbdata as $row) {
                      echo '<tr>';
                      echo '<td>'.ucwords($row['firstname']).' '.ucwords($row['lastname']).'</td>';
                      echo '<td>'.$row['email'].'</td>';
                      echo '<td>'.$row['groupname'].'</td>';
                      echo '</tr>';
                    }
                  } else {
                    echo '<tr><td colspan="3">';
                    echo $lang->dict->adminpagemembers->noone;
                    echo '</td></tr>';
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
