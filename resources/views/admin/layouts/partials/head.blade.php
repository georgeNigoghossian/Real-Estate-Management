<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">--}}
        <link rel="icon" type="image/png" href="{{asset('assets/img/logos/favicon.ico')}}">

    <title>
        Real Estate Management
    </title>

    @include('admin.layouts.partials.head_scripts')
    @stack('head_scripts')

    <style>
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

</head>
