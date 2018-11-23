<body class="hold-transition skin-black layout-top-nav">
    <div class="wrapper">

        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(router.getModuleName()) }}" class="navbar-brand">{{ config.gazlab.logo.lg }}</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="{{ url([router.getModuleName(), 'sessions', 'signIn']|join('/')) }}">Sign In <span class="sr-only">(current)</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {{ router.getActionName()|capitalize }}
                        <small>{{ router.getControllerName()|capitalize }}</small>
                    </h1>
                    <ol class="breadcrumb">
                        {{ breadcrumbs.output() }}
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    {{ content() }}
                </section>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="container text-sm">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.0
                </div>
                <strong>GazlabAdmin.</strong> Copyright &copy; 2018 <a href="https://adminlte.io">Gazlab</a>. All rights reserved.<br/>
                <strong>AdminLTE.</strong> Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>. All rights reserved.
            </div>
            <!-- /.container -->
        </footer>
    </div>