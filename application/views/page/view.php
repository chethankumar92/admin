<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Page Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                <?= $page->getTitle() ?>
                            </li>
                            <li class="list-group-item">
                                <?= $page->getContent() ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>