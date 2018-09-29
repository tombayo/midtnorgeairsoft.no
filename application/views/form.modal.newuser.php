<?php 
/**
 * Basic form for creating a new user
 * @see view.admin.editpersons.php
 *
 * @package mna
 * @subpackage views
 */
?>
<div class="modal fade" id="newuserModal" tabindex="-1" role="dialog" aria-labelledby="newuserModal-title">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="newuserModal-title"><span class="glyphicon glyphicon-user"></span> Ny Bruker</h4>
      </div>
      <form class="form-horizontal" id="form-nu" method="post">
        <div class="modal-body">
          <?php
            $formParent = 'form-nu';
            unset($user); // Prevents form to be filled with current user's data
            include('form.common.form-groups.php');
          ?>
	      </div><!-- /.modal-body -->
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Lukk</button>
	        <button type="submit" class="btn btn-primary" name="submit">Bekreft <span class="glyphicon glyphicon-ok"></span></button>
	      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->