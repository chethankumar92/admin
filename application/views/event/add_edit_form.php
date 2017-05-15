<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Event</h3>
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
                                <input type="text" value="<?= $event->getName() ?>" class="form-control" name="name" placeholder="Name" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="from-date" class="col-lg-2 control-label">From date</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $event->getFrom_date() ?>" class="form-control datepicker" name="from-date" placeholder="From date" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="to-date" class="col-lg-2 control-label">To date</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $event->getTo_date() ?>" class="form-control datepicker" name="to-date" placeholder="To date"required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="col-lg-2 control-label">Grade</label>
                            <div class="col-lg-10">
                                <select class="form-control selectpicker" name="grade" required="">
                                    <option value="">Select grade</option>
                                    <?php if (isset($grades) && is_array($grades)): ?>
                                        <?php foreach ($grades as $grade): ?>
                                            <option value="<?= $grade->egid ?>" <?= $event->getEgid() == $grade->egid ? "selected" : "" ?>><?= $grade->name ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="trek-distance" class="col-lg-2 control-label">Trek distance</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $event->getTrek_distance() ?>" class="form-control" name="trek-distance" placeholder="Trek distance" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="distance-from-bangalore" class="col-lg-2 control-label">Distance from bangalore</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $event->getDistance_from_bangalore() ?>" class="form-control" name="distance-from-bangalore" placeholder="Distance from bangalore" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cost" class="col-lg-2 control-label">Cost</label>
                            <div class="col-lg-10">
                                <input type="text" value="<?= $event->getCost() ?>" class="form-control" name="cost" placeholder="Cost" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cost-includes" class="col-lg-2 control-label">Cost includes</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="cost-includes" placeholder="Cost includes">
                                    <?= $event->getCost_includes() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cost-excludes" class="col-lg-2 control-label">Cost excludes</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="cost-excludes" placeholder="Cost excludes">
                                    <?= $event->getCost_excludes() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tentative-schedule" class="col-lg-2 control-label">Tentative schedule</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="tentative-schedule" placeholder="Tentative schedule">
                                    <?= $event->getTentative_schedule() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-lg-2 control-label">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="description" placeholder="Description">
                                    <?= $event->getDescription() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="accommodation" class="col-lg-2 control-label">Accommodation</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="accommodation" placeholder="Accommodation">
                                    <?= $event->getAccommodation() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="transportation" class="col-lg-2 control-label">Transportation</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="transportation" placeholder="Transportation">
                                    <?= $event->getTransportation() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="food" class="col-lg-2 control-label">Food</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="food" placeholder="Food">
                                    <?= $event->getFood() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="things-to-carry" class="col-lg-2 control-label">Things to carry</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="things-to-carry" placeholder="Things to carry">
                                    <?= $event->getThings_to_carry() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cancellation-policy" class="col-lg-2 control-label">Cancellation policy</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="cancellation-policy" placeholder="Cancellation policy">
                                    <?= $event->getCancellation_policy() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="refund-policy" class="col-lg-2 control-label">Refund policy</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="refund-policy" placeholder="Refund policy">
                                    <?= $event->getRefund_policy() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="terms-and-conditions" class="col-lg-2 control-label">Terms and conditions</label>
                            <div class="col-lg-10">
                                <textarea class="form-control summernote" rows="3" name="terms-and-conditions" placeholder="Terms and conditions">
                                    <?= $event->getTerms_and_conditions() ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="images" class="col-lg-2 control-label">Images</label>
                            <div class="col-lg-10">
                                <div id="dZUpload" class="dropzone" data-upload="<?= $upload ?>" data-remove="<?= $remove ?>">
                                </div>
                                <input type="hidden" name="images" required="" data-images='<?= json_encode($event->getImages()) ?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="hidden" value="<?= $event->getId() ?>" name="id">
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