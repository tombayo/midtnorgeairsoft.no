<?php
  /**
   * A view for resetting a users password by supplying email.
   * @see admin::resetpw()
   * 
   * @package mna
   * @subpackage views 
   */

  include('view.header.php');
?>
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
				<div class="col-md-8">
					<h1></h1>
					<div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <span class="glyphicon glyphicon-lock"></span> <?php echo $lang->dict->adminusercontrols->newpw; ?>
              </h4>
            </div>
            <form class="form-horizontal" id="form-rp" method="post" novalidate>
              <div class="panel-body">
          			<div class="alert alert-info">
                <?php echo $lang->dict->adminusercontrols->changepwexplained; ?>
          			</div>
                <div class="form-group">
                  <label for="form-rp-email" class="col-sm-3 control-label hidden-xs">
                    <?php echo $lang->dict->adminusercontrols->emailaddress; ?>
                  </label>
                  <div class="col-sm-9">
                    <input name="email" type="email" class="form-control" 
                    id="form-rp-email" placeholder="<?php echo $lang->dict->adminusercontrols->emailaddress; ?>" required>
                  </div>
                </div>
              </div><!-- /.panel-body -->
              <div class="modal-footer">
                <a role="button" class="btn btn-default" href="<?php echo BASE_URL; ?>">
                  « <?php echo ucfirst($lang->dict->general->back); ?>
                </a>
                <button type="submit" class="btn btn-primary" name="submit">
                  <?php echo ucfirst($lang->dict->general->confirm); ?> <span class="glyphicon glyphicon-ok"></span>
                </button>
              </div>
            </form>
          </div><!-- /.panel -->
				</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<?php include('view.scripts.php'); ?>