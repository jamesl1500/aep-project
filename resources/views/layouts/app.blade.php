<?php
use App\Libraries\HeaderFunctions;

// Include the header functions
$headerFunctions = new HeaderFunctions();
?>
<html lang="en">
<head>
    <title><?php echo config('app.name'); ?></title>

    <!-- Meta -->
    <meta charset="UTF-8">

    <meta name="description" content="<?php echo config('app.description'); ?>">
    <meta name="keywords" content="<?php echo config('app.keywords'); ?>">
    <meta name="author" content="<?php echo config('app.author'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/jpg" href="<?php echo url('images'); ?>/main_logo.jpg" />

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}" />
    <?php
    if(isset($stylesheet) && $stylesheet != ""){
    ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/'.$stylesheet.'.css') }}" />
    <?php
    }
    ?>
    <!-- Fontawesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
<div class="mainWebsiteHold animated fadeIn">
    <!-- Main website content -->
    <div class="websiteBody clearfix">
        <!-- Header -->
        @include('templates.header')

        <div class="website">
            @yield('content')
        </div>

        <!-- FadeIn  Overlay -->
        <div class="websiteMainOverlay"></div>

        <!-- Footer -->
        @include('templates.footer')
    </div>

    <!-- Sidebar Hold (Smaller screens E.G Tablets Phones Screens) -->
    @include('templates.sidebar')
</div>

<!-- Javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>

@yield('scripts')

</body>
</html>