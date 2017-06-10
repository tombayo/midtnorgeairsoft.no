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
		<title>Passord midtnorgeairsoft.no</title>
	</head>
	<body>
		<p>Hei, <?php echo ucwords($user['firstname']); ?></p>
		<p>Det har blitt laget et nytt passord til deg på Midtnorgeairsoft.no.<br>Passordet er:</p>
		<blockquote><?php echo $temppw; ?></blockquote>
		<p>Passordet benyttes sammen med din E-post adresse for å logge inn på våre nettsider.</p>
		<p>Når du er logget inn har du mulighet til å endre passord, dette er å anbefale.</p>
	  <p>&nbsp;</p>
	  <p>Hilsen Midt-Norge Airsoft</p>
	</body>
</html>