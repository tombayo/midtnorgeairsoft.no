<?php 
/**
 * A collection of form-groups commonly used throughout the application 
 *
 * @package tennisklubben.net
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
          <div class="form-group"></div>
          <div class="form-group">
            <label for="<?php echo $formParent; ?>-address" class="col-sm-3 control-label hidden-xs">Adresse</label>
            <div class="col-sm-9">
              <input type="text" maxlength="64" class="form-control" id="<?php echo $formParent; ?>-address"
              name="address" placeholder="Adresse" value="<?php echo $formdata['address'] ?? $user['address'] ?? '';?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="<?php echo $formParent; ?>-postalcode" class="col-sm-3 control-label hidden-xs">Postnummer</label>
             <div class="col-sm-2">
               <input type="text" class="form-control" id="<?php echo $formParent; ?>-postalcode" name="postcode" placeholder="Postnr"
               	 maxlength="4" data-minlength="4" pattern="[0-9]{4}" title="Postnummer med 4-siffer"
               	 data-error="Vennligst skriv inn et gyldig postnummer" value="<?php echo $formdata['postcode'] ?? $user['postcode'] ?? '';?>" required>
               <div class="help-block with-errors"></div>
             </div>
            <label for="<?php echo $formParent; ?>-postalplace" class="col-sm-2 control-label hidden-xs">Poststed</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="<?php echo $formParent; ?>-postalplace" disabled="disabled">
            </div>
          </div>
          <div class="form-group">
            <label for="<?php echo $formParent; ?>-phonenumber" class="col-sm-3 control-label hidden-xs">Telefonnummer</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="<?php echo $formParent; ?>-phonenumber" name="phonenumber" placeholder="Telefonnummer"
              	maxlength="8" data-minlength="8" pattern="[0-9]{8}" title="Telefon-nummer med 8 siffer"
              	data-error="Vennligst skriv inn et gyldig telefonnummer" value="<?php echo $formdata['phonenumber'] ?? $user['phonenumber'] ?? '';?>" required>
             	<div class="help-block with-errors"></div>
            </div>
          </div>