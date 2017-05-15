<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Testimonial</h3>
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
                                <input type="text" value="<?= $testimonial->getName() ?>" class="form-control" name="name" placeholder="Name" required="" pattern=".{4,}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="designation" class="col-lg-2 control-label">Designation</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $testimonial->getDesignation() ?>" class="form-control" name="designation" placeholder="Designation" required="" pattern=".{4,}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-lg-2 control-label">Content</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows="3" name="content" placeholder="Content"><?= $testimonial->getContent() ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="images" class="col-lg-2 control-label">Images</label>
                            <div class="col-lg-10">
                                <div id="dZUpload" class="dropzone" data-upload="<?= $upload ?>" data-remove="<?= $remove ?>">
                                </div>
                                <input type="hidden" name="images" required="" data-images='<?= json_encode($testimonial->getId() ? array(array("name" => $testimonial->getImage(), "url" => asset_url() . "files/testimonial/small/" . $testimonial->getImage())) : array()) ?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="hidden" value="<?= $testimonial->getId() ?>" name="id">
                                <button type="reset" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary ladda-button" data-style="expand-left">Submit</button>
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