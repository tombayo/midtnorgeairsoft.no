<?php 
/**
 * The header shared by most of this application's views.
 *
 * @package mna
 * @subpackage views
 */
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="icon" type="image/png" href="static/images/favicon.png" />
    
    <meta name="description" content="Nettsiden til Midt-Norge Airsoftklubb">
    <meta name="keywords" content="midt-norge, midt, norge, airsoft, klubb, airsoftklubb, MNA, trøndelag, softgun, soft, gun, milsim">
    
    <!-- To please our overlords at Facebook -->
    <meta property="og:url" content="https://midtnorgeairsoft.no">
    <meta property="og:site_name" content="Midt-Norge Airsoft">
    <meta property="og:locale" content="<?php echo $lang; ?>">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/theme.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Allerta+Stencil|Open+Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.7.0/css/flag-icon.min.css" integrity="sha256-EQjZwW4ljrt9dsonbyX+si6kbxgkVde47Ty9FQehnUg=" crossorigin="anonymous" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/style.css">
    
    <title>Midt-Norge Airsoft</title>
  </head>
  <body>
