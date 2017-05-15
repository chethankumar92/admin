<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Admin Users</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <table id="admin-user-manage-table" data-render-url="<?= $render_url ?>" data-status-action="<?= $status_action ?>" data-status-method="<?= $status_method ?>" data-statuses='<?= json_encode($statuses) ?>' class="table table-condensed table-bordered table-responsive table-hover">
                    <thead>
                        <tr>
                            <th>Admin User Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Date Of Creation</th>
                            <th>Date Of Update</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                &nbsp;
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->