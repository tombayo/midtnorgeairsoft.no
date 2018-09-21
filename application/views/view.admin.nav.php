<?php 
/**
 * The navigation-view for Admin.
 * 
 * Contains the navbar and sidebar.
 * 
 * @see admin
 *
 * @package mna
 * @subpackage views
 */
?>
    <!-- Main Header -->
    <header class="main-header">
      <!-- Logo -->
      <a href="<?php echo BASE_URL; ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">MNA</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Midt-Norge Airsoft</span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo BASE_URL; ?>static/images/no_image.png" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo ucwords($user['firstname'])." ".ucwords($user['lastname']); ?></span>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="<?php echo BASE_URL; ?>static/images/no_image.png" class="img-circle" alt="User Image">
                  <p><?php echo ucwords($user['firstname'])." ".ucwords($user['lastname']); ?></p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                    <div class="col-xs-6 text-center">
                      <a class="btn btn-default btn-flat" href="<?php echo $url('admin','edituser'); ?>">
                        <?php echo $lang->dict->adminusercontrols->changeinfo; ?>
                      </a>
                    </div>
                    <div class="col-xs-6 text-center">
                      <a class="btn btn-default btn-flat" href="<?php echo $url('admin','editpw'); ?>">
                        <?php echo $lang->dict->adminusercontrols->changepw; ?>
                      </a>
                    </div>
                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-right">
                    <a class="btn btn-default btn-flat" href="<?php echo $url('admin','logout'); ?>">
                      <?php echo $lang->dict->adminusercontrols->logout; ?>
                    </a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
          <?php
            // List below is built from admin::$menu
            $icons = [
              'index'=>'fa-home',
              'members'=>'fa-users',
              'vote'=>'fa-check-square-o',
              'benchpw'=>'fa-tachometer',
              'genpw'=>'fa-key',
              'php'=>'fa-info'
            ];
          
            foreach ($menu as $key => $value) {
              if (is_array($value)) {
                echo '<li class="header">'.$key.'</li>';
                /*
                echo '<li class="treeview';
                if (array_key_exists(str_replace('admin.','',$page), $value)) echo ' active';
                echo '">';
                echo '<a href="#"> <span>'.$key.'</span>';
                echo '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
                echo '<ul class="treeview-menu';
                if (array_key_exists(str_replace('admin.','',$page), $value)) echo ' menu-open';
                echo '">';*/
                foreach ($value as $subkey => $subvalue) {
                  echo '<li';
                  if ($subkey == str_replace('admin.','',$page)) echo ' class="active"';
                  echo '><a href="'.$url('admin',$subkey).'"><i class="fa '.$icons[$subkey].'"></i> <span>'.$subvalue.'</span></a></li>';
                }
                //echo '</ul></li>';
              } else {
                echo '<li';
                if ($key == str_replace('admin.','',$page)) echo ' class="active"';
                echo '><a href="'.$url('admin',$key).'"><i class="fa '.$icons[$key].'"></i> <span>'.$value.'</span></a></li>';
              }
            }
          ?>
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>