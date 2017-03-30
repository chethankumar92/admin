<?php if (isset($segments) && !empty($segments)): ?>
        <ol class="breadcrumb">
            <?php $url = ''; ?>
            <?php $page = array_pop($segments); ?>
            <?php foreach ($segments as $segment): ?>
                <?php $url .= "/" . $segment; ?>
                <li>
                    <a href="<?= base_url("index.php" . $url) ?>"><i class="fa fa-dashboard"></i> <?= $segment ?></a>
                </li>
            <?php endforeach; ?>
            <li class="active"> <?= ucwords($page === "index" ? "manage" : $page) ?></li>
        </ol>
    <?php endif; ?>