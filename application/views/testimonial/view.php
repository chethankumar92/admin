<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Testimonial Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                <?= $testimonial->getName() ?>, <?= $testimonial->getDesignation() ?>
                            </li>
                            <li class="list-group-item">
                                <?= $testimonial->getContent() ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                Image
                            </li>
                            <li class="list-group-item">
                                <img src="<?= asset_url() . "files/testimonial/small/" . $testimonial->getImage() ?>" class="img-responsive"/>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>