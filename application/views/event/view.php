<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= isset($page_header) ? $page_header : "" ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Event Details</h3>
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
                                Basic details
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Name:</b>&nbsp;<?= $event->getName() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">From date:</b>&nbsp;<?= $event->getFrom_date() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">To date:</b>&nbsp;<?= $event->getTo_date() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Trek distance:</b>&nbsp;<?= $event->getTrek_distance() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">From bangalore:</b>&nbsp;<?= $event->getDistance_from_bangalore() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Cost:</b>&nbsp;<?= $event->getCost() ?>
                            </li>
                            <li class="list-group-item">
                                <b class="pull-left">Grade:</b>&nbsp;<?= $event->getEgid() ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                Description
                            </li>
                            <li class="list-group-item">
                                <?= $event->getDescription() ?>&nbsp;
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                Accommodation
                            </li>
                            <li class="list-group-item">
                                <?= $event->getAccommodation() ?>&nbsp;
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                Transportation
                            </li>
                            <li class="list-group-item">
                                <?= $event->getTransportation() ?>&nbsp;
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                Food
                            </li>
                            <li class="list-group-item">
                                <?= $event->getFood() ?>&nbsp;
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                Things to carry
                            </li>
                            <li class="list-group-item">
                                <?= $event->getThings_to_carry() ?>&nbsp;
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item list-header text-center">
                                Terms and conditions
                            </li>
                            <li class="list-group-item">
                                <?= $event->getTerms_and_conditions() ?>&nbsp;
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>