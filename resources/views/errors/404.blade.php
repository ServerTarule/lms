<!DOCTYPE html>
<html lang="en">
@include('errors.head')
<body class="sidebar-mini  pace-done sidebar-collapse">
    <div class="wrapper">
        @include('errors.header')
        @include('errors.sidebar')
        <div class="content-wrapper">
            @include('errors.401')
            <!-- Content Header (Page header) -->
            {{-- <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-dashboard"></i>
                </div>
                <div class="header-title">
                    <h1>@yield('title')</h1>
                    <small>@yield('subtitle')</small>
                </div>
            </section> --}}
            
        </div>
    </div>
    @include('errors.script')
</body>
</html>
