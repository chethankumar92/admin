<div class="login-box">
    <div class="login-logo">
        <b>Mountain Trekkers</b>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="<?= $action ?>" method="<?= $method ?>" autocomplete="off" data-parsley-validate>
            <div class="form-group has-feedback">
                <input name="email" type="email" class="form-control" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control" placeholder="Password" required pattern=".{4,}">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button name="submit" type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>
        <div class="row hide">
            <div class="col-xs-12 text-center">
                <a href="#">I forgot my password</a><br>
            </div>
        </div>
    </div>
</div>