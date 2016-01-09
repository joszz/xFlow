<?php
/** The template file containing mostly skeleton code
 *  @package    Views
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      04-04-2014
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>XFlow</title>
    <?php foreach($headerFiles['styles'] AS $style) : ?>
    <link rel="stylesheet" type="text/css" href="<?php echo WWWBASE . 'styles/' . $style ?>" />
    <?php endforeach ?>

    <script type="text/javascript">var WWWBASE = "<?php echo WWWBASE ?>";</script>
    <?php foreach($headerFiles['scripts'] AS $script) : ?>
    <script type="text/javascript" src="<?php echo WWWBASE . $script ?>"></script>
    <?php endforeach ?>

    <link rel="apple-touch-icon" sizes="57x57" href="img/icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/icons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/icons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/icons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/icons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="img/icons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="img/icons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="img/icons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="img/icons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="img/icons/manifest.json">
    <link rel="shortcut icon" href="img/icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-TileImage" content="img/icons/mstile-144x144.png">
    <meta name="msapplication-config" content="img/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <div id="wrapper"><?php echo $content ?></div>
</body>
</html>