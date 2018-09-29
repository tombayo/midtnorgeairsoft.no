<?php 
/**
 * Admin-view for the administrating the persons in the database
 * @see admin::editpersons(), admin::jsonpersons()
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
    		<?php
    		if($success ?? false) {
    		  echo '<div class="alert alert-success" role="alert" data-fixurl="'.$url('admin','editpersons').'">';
    		  echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    		  echo '<p>'.$success.'</p>';
    		  echo '</div>';
    		}
    		if($error ?? false) {
    		  echo '<div class="alert alert-danger" role="alert" data-fixurl="'.$url('admin','editpersons').'">';
    		  echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    		  echo '<p>'.$error.'</p>';
    		  echo '</div>';
    		}
    		?>
    		<div class="row">
    			<div class="col-md-6">
        		<form id="p-search" method="post">
              <label for="p-searchbar">Søk etter personer i databasen</label>
              <div class="input-group">
              	<div class="input-group-btn" data-toggle="buttons">
                  <label class="btn btn-default">
                    <input type="radio" name="searchtype" id="stype-firstname" value="firstname" autocomplete="off"> Fornavn
                  </label>
                  <label class="btn btn-default active">
                    <input type="radio" name="searchtype" id="stype-lastname" value="lastname" autocomplete="off" checked> Etternavn
                  </label>
                  <label class="btn btn-default">
                    <input type="radio" name="searchtype" id="stype-firstname" value="accessgroup" autocomplete="off"> Tilgang
                  </label>
                </div>
                <input type="text" class="form-control" id="p-searchbar" aria-describedby="p-searchbar-name" placeholder="Søketekst...">
                <div class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Søk</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-6 text-right">
          	<label>Manuelt legg til en ny person i databasen:</label>
          	<div class="form-group">
          		<select class="form-control hidden" id="accessgroups">
          			<?php 
          			 foreach ($accessgroups as $accessgroup) {
          			   echo '<option value="'.$accessgroup['id'].'">'.$accessgroup['groupname'].'</option>';
          			 }
          			?>
          		</select>
          		<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#newuserModal">
          			<span class="glyphicon glyphicon-plus"></span> Ny Bruker
          		</button>
          	</div>
          </div>
        </div><!-- /.row -->
        <p>&nbsp;</p>
        <div class="panel panel-default">
        	<div class="panel-heading">
        		<h4 class="panel-title">Søkeresultater</h4>
        	</div>
        	<ul class="list-group" id="p-results">
        		<li class="list-group-item">Ingen treff :(</li>
        	</ul>
        </div><!-- /.panel -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php include('view.admin.footer.php'); ?>
  </div><!-- /.wrapper -->
  <?php include('form.modal.newuser.php'); ?>
<?php include('view.scripts.php'); ?>