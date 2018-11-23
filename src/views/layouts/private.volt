<body class="hold-transition skin-black sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="{{ url(router.getModuleName()) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{{ config.gazlab.logo.mini }}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{{ config.gazlab.logo.lg }}</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ gravatar.getAvatar(identity.username) }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ identity.username }}</span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url([router.getModuleName(), 'administrators', 'profile']|join('/')) }}">Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ url([router.getModuleName(), 'sessions', 'signOut']|join('/')) }}">Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    {% for group, resources in mainNavigation %}
                        {% if group is not 'main_navigation' %}
                            <li class="header">{{ group|upper }}</li>
                        {% endif %}
                        {% for resource in resources %}
                            <li>
                                <a href="{{ url([router.getModuleName(), resource.menu[0]]|join('/')) }}">
                                    <i class="{{ resource.menu['icon'] }}"></i> <span>{{ resource.menu['name'] }}</span>
                                </a>
                            </li>
                        {% endfor %}    
                    {% endfor %}
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    {{ router.getControllerName()|capitalize }}
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
        <!-- /.content-wrapper -->

        <footer class="main-footer text-sm">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>GazlabAdmin.</strong> Copyright &copy; 2018 <a href="https://adminlte.io">Gazlab</a>. All rights reserved.<br/>
            <strong>AdminLTE.</strong> Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>. All rights reserved.
        </footer>
    </div>

    {% do assets.addCss('gazlab_assets/datatables.net-bs/css/dataTables.bootstrap.min.css') %}
    {% do assets.addJs('gazlab_assets/datatables.net/js/jquery.dataTables.min.js') %}
    {% do assets.addJs('gazlab_assets/datatables.net-bs/js/dataTables.bootstrap.min.js') %}
    {% do assets.addInlineJs(view.getPartial('layouts/private.js')) %}