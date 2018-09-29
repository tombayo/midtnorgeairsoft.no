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

    <!-- Some metadata for JS to parse -->
    <meta name="urlrewrite" content="<?php global $config; echo $config['url_rewrite'] ? 'true':'false'; ?>"/>
    
    <link rel="apple-touch-icon" sizes="180x180" href="/static/icons/apple-touch-icon.png?v=gAENnqlzOx">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/icons/favicon-32x32.png?v=gAENnqlzOx">
    <link rel="icon" type="image/png" sizes="16x16" href="/static/icons/favicon-16x16.png?v=gAENnqlzOx">
    <link rel="manifest" href="/static/icons/manifest.json?v=gAENnqlzOx">
    <link rel="mask-icon" href="/static/icons/safari-pinned-tab.svg?v=gAENnqlzOx" color="#5bbad5">
    <link rel="shortcut icon" href="/static/icons/favicon.ico?v=gAENnqlzOx">
    <meta name="msapplication-config" content="/static/icons/browserconfig.xml?v=gAENnqlzOx">
    <meta name="theme-color" content="#ffffff">
    
    <meta name="description" content="Nettsiden til Midt-Norge Airsoftklubb">
    <meta name="keywords" content="midt-norge, midt, norge, airsoft, klubb, airsoftklubb, MNA, trøndelag, softgun, soft, gun, milsim">
    
    <!-- To please our overlords at Facebook -->
    <meta property="og:url" content="https://midtnorgeairsoft.no">
    <meta property="og:site_name" content="Midt-Norge Airsoft">
    <meta property="og:locale" content="<?php echo $lang; ?>">
    
    <title>Midt-Norge Airsoft</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/theme.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Allerta+Stencil|Open+Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.7.0/css/flag-icon.min.css" integrity="sha256-EQjZwW4ljrt9dsonbyX+si6kbxgkVde47Ty9FQehnUg=" crossorigin="anonymous" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php $a = 'static/css/style.css'; echo BASE_URL.$a.'?'.filemtime(ROOT_DIR.$a); ?>">
    <?php 
    if ($controller == 'admin') {
    ?>
      <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/login.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" integrity="sha256-3iu9jgsy9TpTwXKb7bNQzqWekRX7pPK+2OLj3R922fo=" crossorigin="anonymous" />
      <!-- AdminLTE -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css" integrity="sha256-lrbt+EtA5LBekt2urIreC9u+QqzGsLKb0wEa+KgfVKA=" crossorigin="anonymous" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/skin-blue.min.css" integrity="sha256-rTttv3Qz9fBq76ZDyUQ9P7YRpL4JafXNzB2CCoyGoOM=" crossorigin="anonymous" />
      <?php
        if ($page == 'vote') echo '<link rel="stylesheet" href="'.BASE_URL.'static/css/vote.css">';
      ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php 
    } else {
    ?>
  </head>
  <body>
<?php }?>