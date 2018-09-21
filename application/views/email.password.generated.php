<?php 
/**
 * Generates an email for informing a user about a newly generated password
 * @see admin::makeUserRandomPassword()
 *
 * @package mna
 * @subpackage views
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$lang->dict->adminpwmail->subject</title>
	</head>
	<body>
		<p><?php echo $lang->dict->adminpwmail->greeting; ?>, <?php echo ucwords($user['firstname']); ?></p>
		<p><?php echo $lang->dict->adminpwmail->newpw; ?><br><?php echo $lang->dict->adminpwmail->pwis; ?></p>
		<blockquote><?php echo $temppw; ?></blockquote>
		<p><?php echo $lang->dict->adminpwmail->pwinfo; ?></p>
		<p><?php echo $lang->dict->adminpwmail->pwchange; ?></p>
	  <p>&nbsp;</p>
	  <p><?php echo $lang->dict->adminpwmail->signature; ?></p>
	</body>
</html>