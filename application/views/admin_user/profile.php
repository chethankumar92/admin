<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">User profile</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?= base_url() ?>/assets/img/user2-160x160.jpg" alt="User profile picture">
                        <h3 class="profile-username text-center">
                            <?= $logged_in_user->getFirst_name() . " " . $logged_in_user->getLast_name() ?>
                        </h3>
                        <p class="text-muted text-center">
                            <?= $logged_in_user->getEmail() . ($logged_in_user->getMobile() ? " | " . $logged_in_user->getMobile() : '') . ($logged_in_user->getPhone() ? " | " . $logged_in_user->getPhone() : '') ?>
                        </p>
                        <a href="#" id="logout" data-action="<?= $logout_action ?>" class="btn btn-primary btn-block"><b>SIGN OUT</b></a>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                        <li><a href="#change-password" data-toggle="tab">Change password</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="profile">
                            <form class="form-horizontal" action="<?= $profile_url ?>" method="<?= $method ?>" autocomplete="off" data-parsley-validate>
                                <fieldset>
                                    <div class="form-group">
                                        <label for="first-name" class="col-lg-2 control-label">First name</label>
                                        <div class="col-lg-10">
                                            <input type="text" value="<?= $logged_in_user->getFirst_name() ?>" class="form-control" name="first-name" placeholder="First name" required="" pattern=".{4,}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last-name" class="col-lg-2 control-label">Last name</label>
                                        <div class="col-lg-10">
                                            <input type="text" value="<?= $logged_in_user->getLast_name() ?>" class="form-control" name="last-name" placeholder="Last name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-lg-2 control-label">Email</label>
                                        <div class="col-lg-10">
                                            <input type="email" value="<?= $logged_in_user->getEmail() ?>" class="form-control" name="email" placeholder="Email"required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-lg-2 control-label">Phone</label>
                                        <div class="col-lg-10">
                                            <input type="text" value="<?= $logged_in_user->getPhone() ?>" class="form-control" name="phone" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="col-lg-2 control-label">Mobile</label>
                                        <div class="col-lg-10">
                                            <input type="text" value="<?= $logged_in_user->getMobile() ?>" class="form-control" name="mobile" placeholder="Mobile">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <button type="reset" class="btn btn-default">Cancel</button>
                                            <button type="submit" class="btn btn-primary ladda-button" data-style="expand-left">Submit</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="change-password">
                            <form class="form-horizontal" action="<?= $password_url ?>" method="<?= $method ?>" autocomplete="off" data-parsley-validate>
                                <fieldset>
                                    <div class="form-group">
                                        <label for="old-password" class="col-lg-2 control-label">Old password</label>
                                        <div class="col-lg-10">
                                            <input type="text" value="" class="form-control" name="old-password" placeholder="Old password" required="" pattern=".{4,}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new-password" class="col-lg-2 control-label">New password</label>
                                        <div class="col-lg-10">
                                            <input type="text" value="" class="form-control" name="new-password" placeholder="New password" required="" pattern=".{4,}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="re-password" class="col-lg-2 control-label">Re-enter password</label>
                                        <div class="col-lg-10">
                                            <input type="text" value="" class="form-control" name="re-password" placeholder="Re-enter password"required="" pattern=".{4,}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <button type="reset" class="btn btn-default">Cancel</button>
                                            <button type="submit" class="btn btn-primary ladda-button" data-style="expand-left">Submit</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>