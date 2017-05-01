<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Contact</h3>
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
                            <label for="name" class="col-lg-2 control-label">Name</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $contact->getName() ?>" class="form-control" name="name" placeholder="Name" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="email" value="<?= $contact->getEmail() ?>" class="form-control" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-lg-2 control-label">Mobile</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $contact->getMobile() ?>" class="form-control" name="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-lg-2 control-label">Subject</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $contact->getSubject() ?>" class="form-control" name="subject" placeholder="Subject" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-lg-2 control-label">Message</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows="3" name="message" placeholder="Message" required="">
                                    <?= $contact->getMessage() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="hidden" value="<?= $contact->getId() ?>" name="id">
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