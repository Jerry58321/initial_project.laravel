<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            {{ trans('layout.title') }}
        </title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="robots" content="noindex, nofollow">
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
        @yield('style')
        <script>
         window.Laravel = <?php echo json_encode([
             'csrfToken' => csrf_token(),
         ]); ?>
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            @include('includes.header')
            @include('includes.sidebar')

            <div class="content-wrapper">
                @yield('content')
            </div>

            @include('includes.footer')

            <div class="control-sidebar-bg"></div>
        </div>
        <div id="js-lang-another_login" class="hidden">{{trans('auth.another_login')}}</div>


            <script src="{{ elixir('js/app.js') }}"></script>
            {{--<script src="{{ asset("/js/index.js") }}?v={{time()}}"></script>--}}

            @yield('script')
    </body>
</html>
