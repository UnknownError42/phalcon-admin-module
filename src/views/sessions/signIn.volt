<div class="login-box">
    {{ content() }}
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{ url([router.getModuleName(), 'sessions', 'signIn']|join('/')) }}" method="post">
            <div class="form-group has-feedback">
                <input class="form-control" placeholder="Username" name="sign_in[username]" autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="sign_in[password]">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-8">
                    <button type="submit" class="btn btn-primary btn-flat pull-right">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>