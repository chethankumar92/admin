<div class="dropdown">
    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
        Action<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?php if ($row["tsid"] != 4): ?>
            <li role="presentation">
                <a role="menuitem" tabindex="-1" href="<?= site_url(Testimonials::class . "/edit/" . $id) ?>">
                    <i class="fa fa-fw fa-edit"></i>Edit
                </a>
            </li>
        <?php endif; ?>
        <?php if (!$row["tstid"]): ?>
            <li role="presentation">
                <a role="menuitem" tabindex="-1" href="javascript:void(0);" class="change-status" data-id="<?= $id ?>" data-status='<?= $row["tsid"] ?>'>
                    <i class="fa fa-fw fa-toggle-on"></i>Change status
                </a>
            </li>
        <?php endif; ?>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="<?= site_url(Testimonials::class . "/view/" . $id) ?>">
                <i class="fa fa-fw fa-film"></i>View
            </a>
        </li>
    </ul>
</div>