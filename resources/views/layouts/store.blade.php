<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>@yield('cpn') | @yield('wn')</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Style -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
        @if ($ss != "")
            <link href="{{ asset('css/' . $ss) }}" rel="stylesheet" />
        @endif
    </head>
    <body>
        <div class="websiteWhole">
            <!-- Website Header -->
            <div class="websiteHeader">
                @include('templates.headers.primary')
            </div>

            <!-- Website Content -->
            <div class="websiteContent">
                @yield('website_content')
            </div>

            <!-- Website Footer -->
            <div class="websiteFooter">
                @include('templates.footers.primary')
            </div>
        </div>

        <!-- Website Sidebar -->
        <div class="websiteSidebar">

        </div>
        
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>