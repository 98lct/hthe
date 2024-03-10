<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H.The App</title>
        <!-- icons
          ================================================== -->
        <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
        <!-- CSS
          ================================================== -->
        <link rel="stylesheet" href="{{ asset('assets/css/uikit.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        @vite(['resources/js/app.js'])

      </head>

      <body>
        <div id="app">
        </div>
        <!-- For Night mode -->

        <!-- Javascript
            ================================================== -->
        <script "https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/tippy.all.min.js') }}"></script>
        <script src="{{ asset('assets/js/uikit.js') }}"></script>
        <script src="{{ asset('assets/js/simplebar.js') }}"></script>
        {{--  <script src="{{ asset('assets/js/custom.js') }}"></script>  --}}
        {{--  <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>  --}}
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
      </body>
</html>
