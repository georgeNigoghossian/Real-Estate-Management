<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.layouts.partials.head')
<body class="g-sidenav-show  bg-gray-100">

    @include('admin.layouts.partials.menus.aside')

<main class="main-content border-radius-lg ">

    @include('admin.layouts.partials.menus.topbar')


    <div class="container-fluid py-4">
    @yield('content')

    @include('admin.layouts.partials.footer')
    </div>

</main>
</body>
</html>
