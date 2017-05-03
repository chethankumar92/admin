<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Admin User Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group text-right">
                            <li class="list-group-item list-header text-center">
                                Basic details
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">First name:</b>&nbsp;<?= $admin_user->getFirst_name() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Last name:</b>&nbsp;<?= $admin_user->getLast_name() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Email:</b>&nbsp;<?= $admin_user->getEmail() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Phone:</b>&nbsp;<?= $admin_user->getPhone() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Mobile:</b>&nbsp;<?= $admin_user->getMobile() ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>