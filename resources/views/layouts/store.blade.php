<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>@yield('cpn') | @yield('wn')</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Style -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
        @if ($ss ?? '' != "")
            <link href="{{ asset('css/' . $ss ?? '') }}" rel="stylesheet" />
        @endif

        <script src='https://cdn.tiny.cloud/1/ervzym3h4q9y5ncnd8868gsf43lhgnoggvcfrq4q65tl9mj8/tinymce/5/tinymce.min.js' referrerpolicy="origin">
        </script>
        <script>
          tinymce.init({
            selector: '#product_key_features'
          });
        </script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>

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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>        <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>