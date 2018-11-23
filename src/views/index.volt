<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{ getTitle() }}
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{ stylesheet_link('gazlab_assets/bootstrap/dist/css/bootstrap.min.css') }}
    {{ stylesheet_link('gazlab_assets/font-awesome/css/font-awesome.min.css') }}
    {{ stylesheet_link('gazlab_assets/Ionicons/css/ionicons.min.css') }}

    {{ assets.outputCss() }}

    {{ stylesheet_link('gazlab_assets/select2/dist/css/select2.min.css') }}
    {{ stylesheet_link('gazlab_assets/adminlte/css/AdminLTE.min.css') }}
    {{ stylesheet_link('gazlab_assets/adminlte/css/skins/_all-skins.min.css') }}
    {{ stylesheet_link('gazlab_assets/PACE/themes/black/pace-theme-minimal.css') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

{{ content() }}

    {{ javascript_include('gazlab_assets/jquery/dist/jquery.min.js') }}
    {{ javascript_include('gazlab_assets/bootstrap/dist/js/bootstrap.min.js') }}

    {{ assets.outputJs() }}
    
    {{ javascript_include('gazlab_assets/select2/dist/js/select2.full.min.js') }}
    {{ javascript_include('gazlab_assets/PACE/pace.min.js') }}
    {{ javascript_include('gazlab_assets/jquery-slimscroll/jquery.slimscroll.min.js') }}
    {{ javascript_include('gazlab_assets/fastclick/lib/fastclick.js') }}
    {{ javascript_include('gazlab_assets/adminlte/js/adminlte.min.js') }}
    {{ assets.outputInlineJs() }}
</body>

</html>