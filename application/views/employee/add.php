<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Title</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label">First name</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputEmail" placeholder="First name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label">Last name</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputEmail" placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPhone" class="col-lg-2 control-label">Phone</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputPhone" placeholder="Phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMobile" class="col-lg-2 control-label">Mobile</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputMobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription" class="col-lg-2 control-label">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows="3" id="inputDescription" placeholder="Description"></textarea>
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="col-lg-2 control-label">Radios</label>
                            <div class="col-lg-10">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                        Option one is this
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                        Option two can be something else
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label">Selects</label>
                            <div class="col-lg-10">
                                <select class="form-control" id="select">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                <br>
                                <select multiple="" class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
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