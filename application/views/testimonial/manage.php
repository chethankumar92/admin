<!-- Content Wrapper. Contains testimonial content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= isset($testimonial_header) ? $testimonial_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Pages</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <table id="testimonial-manage-table" data-render-url="<?= $render_url ?>" data-status-action="<?= $status_action ?>" data-status-method="<?= $status_method ?>" data-statuses='<?= json_encode($statuses) ?>' class="table table-condensed table-bordered table-responsive table-hover">
                    <thead>
                        <tr>
                            <th>Page Id</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Content</th>
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