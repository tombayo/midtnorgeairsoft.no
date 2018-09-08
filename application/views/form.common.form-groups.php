<?php 
/**
 * A collection of form-groups commonly used throughout the application 
 *
 * @package mna
 * @subpackage views
 */
?>
					<div class="form-group">
            <label for="<?php echo $formParent; ?>-firstname" class="col-sm-3 control-label hidden-xs">Fornavn</label>
            <div class="col-sm-9">
              <input type="text" maxlength="64" class="form-control" id="<?php echo $formParent; ?>-firstname"
              name="firstname" placeholder="Fornavn" value="<?php echo $formdata['firstname'] ?? $user['firstname'] ?? '';?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="<?php echo $formParent; ?>-lastname" class="col-sm-3 control-label hidden-xs">Etternavn</label>
            <div class="col-sm-9">
              <input type="text" maxlength="64" class="form-control" id="<?php echo $formParent; ?>-lastname"
              name="lastname" placeholder="Etternavn" value="<?php echo $formdata['lastname'] ?? $user['lastname'] ?? '';?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="<?php echo $formParent; ?>-email" class="col-sm-3 control-label hidden-xs">E-post adresse</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="<?php echo $formParent; ?>-email" name="email" placeholder="E-post"
              	data-error="Vennligst fyll inn en gyldig epost-adresse" value="<?php echo $formdata['email'] ?? $user['email'] ?? '';?>" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>