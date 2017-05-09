<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url() ?>/assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $logged_in_user->getFirst_name() . " " . $logged_in_user->getLast_name() ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview <?= ($query->segments[1] === Home::class) ? "active" : "" ?>">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= ($query->uri_string === Home::class) ? "active" : "" ?>"><a href="<?= site_url(Home::class) ?>"><i class="fa fa-angle-right"></i> Dashboard</a></li>
                </ul>
            </li>
            <li class="treeview <?= ($query->segments[1] === AdminUsers::class) ? "active" : "" ?>">
                <a href="#">
                    <i class="fa fa-user-circle"></i> <span>Admin User</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= ($query->uri_string === AdminUsers::class . "/add") ? "active" : "" ?>"><a href="<?= site_url(AdminUsers::class . "/add") ?>"><i class="fa fa-angle-right"></i> Add</a></li>
                    <li class="<?= ($query->uri_string === AdminUsers::class) ? "active" : "" ?>"><a href="<?= site_url(AdminUsers::class) ?>"><i class="fa fa-angle-right"></i> Manage</a></li>
                </ul>
            </li>
            <li class="treeview <?= ($query->segments[1] === Events::class) ? "active" : "" ?>">
                <a href="#">
                    <i class="fa fa-calendar"></i> <span>Event</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= ($query->uri_string === Events::class . "/add") ? "active" : "" ?>"><a href="<?= site_url(Events::class . "/add") ?>"><i class="fa fa-angle-right"></i> Add</a></li>
                    <li class="<?= ($query->uri_string === Events::class) ? "active" : "" ?>"><a href="<?= site_url(Events::class) ?>"><i class="fa fa-angle-right"></i> Manage</a></li>
                </ul>
            </li>
            <li class="treeview <?= ($query->segments[1] === Contacts::class) ? "active" : "" ?>">
                <a href="#">
                    <i class="fa fa-volume-control-phone"></i> <span>Contact</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= ($query->uri_string === Contacts::class . "/add") ? "active" : "" ?>"><a href="<?= site_url(Contacts::class . "/add") ?>"><i class="fa fa-angle-right"></i> Add</a></li>
                    <li class="<?= ($query->uri_string === Contacts::class) ? "active" : "" ?>"><a href="<?= site_url(Contacts::class) ?>"><i class="fa fa-angle-right"></i> Manage</a></li>
                </ul>
            </li>
            <li class="treeview <?= ($query->segments[1] === Pages::class) ? "active" : "" ?>">
                <a href="#">
                    <i class="fa fa-file-text"></i> <span>Page</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= ($query->uri_string === Pages::class . "/add") ? "active" : "" ?>"><a href="<?= site_url(Pages::class . "/add") ?>"><i class="fa fa-angle-right"></i> Add</a></li>
                    <li class="<?= ($query->uri_string === Pages::class) ? "active" : "" ?>"><a href="<?= site_url(Pages::class) ?>"><i class="fa fa-angle-right"></i> Manage</a></li>
                </ul>
            </li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-angle-right text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-angle-right text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-angle-right text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>