<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Admin User</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="<?= $action ?>" method="<?= $method ?>" autocomplete="off" data-parsley-validate>
                    <fieldset>
                        <div class="form-group">
                            <label for="first-name" class="col-lg-2 control-label">First name</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $admin_user->getFirst_name() ?>" class="form-control" name="first-name" placeholder="First name" required="" pattern=".{4,}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last-name" class="col-lg-2 control-label">Last name</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $admin_user->getLast_name() ?>" class="form-control" name="last-name" placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="email" value="<?= $admin_user->getEmail() ?>" class="form-control" name="email" placeholder="Email"required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-lg-2 control-label">Phone</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $admin_user->getPhone() ?>" class="form-control" name="phone" placeholder="Phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-lg-2 control-label">Mobile</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $admin_user->getMobile() ?>" class="form-control" name="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="hidden" value="<?= $admin_user->getId() ?>" name="id">
                                <button type="reset" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
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