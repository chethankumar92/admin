<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Events</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <table id="event-manage-table" data-render-url="<?= $render_url ?>" class="table table-condensed table-bordered table-responsive table-hover">
                    <thead>
                        <tr>
                            <th>Event Id</th>
                            <th>Name</th>
                            <th>From date</th>
                            <th>To date</th>
                            <th>Trek Distance</th>
                            <th>Fee</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Date Of Creation</th>
                            <th>Date Of Update</th>
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