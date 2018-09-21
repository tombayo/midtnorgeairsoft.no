<?php 
/**
 * A collection of form-groups commonly used throughout the application 
 *
 * @package mna
 * @subpackage views
 */
?>
					<div class="form-group">
            <label for="<?php echo $formParent; ?>-firstname" class="col-sm-3 control-label hidden-xs">
              <?php echo ucfirst($lang->dict->general->firstname); ?>
            </label>
            <div class="col-sm-9">
              <input type="text" maxlength="64" class="form-control" id="<?php echo $formParent; ?>-firstname"
              name="firstname" placeholder="<?php echo ucfirst($lang->dict->general->firstname); ?>" 
              value="<?php echo $formdata['firstname'] ?? $user['firstname'] ?? '';?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="<?php echo $formParent; ?>-lastname" class="col-sm-3 control-label hidden-xs">
              <?php echo ucfirst($lang->dict->general->lastname); ?>
            </label>
            <div class="col-sm-9">
              <input type="text" maxlength="64" class="form-control" id="<?php echo $formParent; ?>-lastname"
              name="lastname" placeholder="<?php echo ucfirst($lang->dict->general->lastname); ?>" 
              value="<?php echo $formdata['lastname'] ?? $user['lastname'] ?? '';?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="<?php echo $formParent; ?>-email" class="col-sm-3 control-label hidden-xs">
              <?php echo $lang->dict->adminusercontrols->emailaddress; ?>
            </label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="<?php echo $formParent; ?>-email" 
              name="email" placeholder="<?php echo $lang->dict->adminusercontrols->emailaddress; ?>"
              data-error="Vennligst fyll inn en gyldig epost-adresse" value="<?php echo $formdata['email'] ?? $user['email'] ?? '';?>" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>