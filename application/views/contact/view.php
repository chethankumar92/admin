<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Contact Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group text-right">
                            <li class="list-group-item list-header text-center">
                                Name and contact details
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Name:</b>&nbsp;<?= $contact->getName() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Email:</b>&nbsp;<?= $contact->getEmail() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Mobile:</b>&nbsp;<?= $contact->getMobile() ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group text-right">
                            <li class="list-group-item list-header text-center">
                                Subject and body
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Subject:</b>&nbsp;<?= $contact->getSubject() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Message:</b>&nbsp;<?= $contact->getMessage() ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>