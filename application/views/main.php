<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $title ?></title>
        <?php foreach ($meta as $tag): ?>
            <meta <?php foreach ($tag as $key => $value): ?>
                <?= $key . '="' . $value . '"' ?>
                <?php endforeach; ?>>
            <?php endforeach; ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <?php foreach ($plugins["css"] as $plugin): ?>
            <?= plugin($plugin, "css"); ?>
        <?php endforeach; ?>
        <?php foreach ($plugins["scss"] as $plugin): ?>
            <?= plugin($plugin, "scss"); ?>
        <?php endforeach; ?>
        <?php foreach ($styles as $style): ?>
            <?= css($style); ?>
        <?php endforeach; ?>
    </head>

    <?php if (isset($is_login) && $is_login): ?>
        <body class="hold-transition login-page">
            <?= $body ?>
        </body>
    <?php else: ?>
        <body class="hold-transition skin-blue sidebar-mini">
            <!-- Site wrapper -->
            <div class="wrapper">
                <?= $header ?>
                <?= $sidebar ?>
                <?= $body ?>
                <?php // $settings ?>
                <?= $footer ?>
            </div>
            <!-- ./wrapper -->
        </body>
    <?php endif; ?>

    <div data-notify="container" class="hidden alert alert-{0}" role="alert">
        <button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>
        <span data-notify="icon"></span>
        <span data-notify="title">{1}</span>
        <span data-notify="message">{2}</span>
        <div class="progress" data-notify="progressbar">
            <div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
        </div>
        <a href="{3}" target="{4}" data-notify="url"></a>
    </div>

    <?php foreach ($plugins["js"] as $plugin): ?>
        <?= plugin($plugin, "js"); ?>
    <?php endforeach; ?>
    <?php foreach ($scripts as $script): ?>
        <?= js($script); ?>
    <?php endforeach; ?>
</html>